<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Address;
use App\Models\Shelter\ShelterLivingSituation;
use App\Models\Shelter\Grantee;
use App\Models\Shelter\Material;
use App\Models\Shelter\GranteeDocumentsSubmission;
use App\Models\Shelter\OriginOfRequest;
use App\Models\Shelter\MaterialUnit;
use App\Models\Shelter\ProfiledTaggedApplicant;
use App\Models\Shelter\ShelterUploadedFiles;
use App\Models\Shelter\DeliveredMaterial;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Logs\ActivityLogs;


class ShelterProfiledTaggedApplicants extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $isLoading = false;
    public $selectedOriginOfRequest = null;
    public $startTaggingDate, $endTaggingDate, $selectedTaggingStatus;
    public $taggingStatuses;

    public $first_name, $middle_name, $last_name, $request_origin_id;
    public $origin_name, $date_tagged, $profileNo, $date_request;
    public $profiledTaggedApplicantId;
    public $materialUnits = [];
    public $purchaseOrders = [];
    public $materialUnitId, $material_id, $purchaseOrderId;
    public $quantity, $available_quantity, $date_of_delivery, $date_of_ris, $ar_no;
    public $grantee_quantity = [];
    public $images = [];

    public $description, $granteeId, $newFileImages = [];
    public $show = false;

    public $materialLists = [];
    public $materials = [
        ['material_id' => '', 'grantee_quantity' => '', 'material_unit_id' => '', 'purchase_order_id' => '', 'available_quantity' => '']
    ];

    public $shelterLivingStatusesFilter = [];
    public $profiledTaggedApplicants;
    public $documents = [];
    public $selectedDocument = null;
    public $showEditDocumentsModal = false;
    public $existingDocuments = [];
    public $existingDocumentNames = [];
    public $newDocuments = [];
    public $newDocumentNames = [];

        public function mount()
        {
            $this->profiledTaggedApplicants = ProfiledTaggedApplicant::with(['shelterApplicant.person', 'shelterApplicant.originOfRequest', 'grantees'])
                ->get();
            // Debugging: Log the data
            logger($this->profiledTaggedApplicants);

            $this->shelterLivingStatusesFilter = Cache::remember('shelter_living_situations', 60 * 60, function () {
                return ShelterLivingSituation::all();
            });
            $this->taggingStatuses = ['Tagged', 'Not Tagged']; // Add your statuses here        
            $this->date_request = now()->toDateString(); // YYYY-MM-DD format

            // For Granting Modal
            $this->date_of_delivery = now()->toDateString(); // YYYY-MM-DD format
            $this->date_of_ris = now()->toDateString(); // YYYY-MM-DD format

            $this->materialLists = Material::all();
            $this->materialUnits = MaterialUnit::all();
            $this->purchaseOrders = Material::with('purchaseOrder')->get();
        }


    public function viewDocument($documentId)
    {
        $this->selectedDocument = GranteeDocumentsSubmission::find($documentId);
    }


    // Method to close document viewer
    public function closeDocumentViewer()
    {
        $this->selectedDocument = null;
    }
    // Method to open edit documents modal
    public function openEditDocumentsModal()
    {
        // Prepare existing documents for editing
        $this->existingDocuments = GranteeDocumentsSubmission::where('profiled_tagged_applicant_id', $this->profiledTaggedApplicantId)->get()->toArray();

        // Populate existing document names
        $this->existingDocumentNames = collect($this->existingDocuments)
            ->mapWithKeys(function ($document) {
                return [$document['id'] => $document['document_name']];
            })
            ->toArray();

        $this->showEditDocumentsModal = true;
    }

    // Method to remove an existing document
    public function removeDocument($documentId)
    {
        $document = GranteeDocumentsSubmission::find($documentId);

        if ($document) {
            // Delete the file from storage
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            // Delete the database record
            $document->delete();

            // Remove from existingDocuments array
            $this->existingDocuments = array_filter($this->existingDocuments, function ($doc) use ($documentId) {
                return $doc['id'] != $documentId;
            });

            // Remove from existingDocumentNames
            unset($this->existingDocumentNames[$documentId]);
        }
    }

    // Method to remove a newly uploaded document before saving
    public function removeNewDocument($index)
    {
        unset($this->newDocuments[$index]);
        unset($this->newDocumentNames[$index]);

        // Reindex arrays
        $this->newDocuments = array_values($this->newDocuments);
        $this->newDocumentNames = array_values($this->newDocumentNames);
    }

    // Method to update documents
    public function updateDocuments()
    {
        $this->validate([
            'existingDocumentNames.*' => 'required|string|max:255',
            'newDocuments.*' => 'file|max:2048', // 2MB max, supports all file types
            'newDocumentNames.*' => 'required|string|max:255'
        ]);

        // Update existing document names
        foreach ($this->existingDocumentNames as $documentId => $name) {
            $document = GranteeDocumentsSubmission::find($documentId);
            if ($document) {
                $document->update(['document_name' => $name]);
            }
        }

        // Handle new document uploads
        if ($this->newDocuments) {
            foreach ($this->newDocuments as $index => $document) {
                $path = $document->storeAs(
                    'documents',
                    Str::slug($this->newDocumentNames[$index]) . '_' . uniqid() . '.' . $document->extension(),
                    'public'
                );

                GranteeDocumentsSubmission::create([
                    'profiled_tagged_applicant_id' => $this->profiledTaggedApplicantId,
                    'file_path' => $path,
                    'document_name' => $this->newDocumentNames[$index],
                    'file_name' => $document->getClientOriginalName(),
                    'file_type' => $document->getMimeType(),
                    'file_size' => $document->getSize()
                ]);
            }
        }

        // Reset form and close modal
        $this->reset(['newDocuments', 'newDocumentNames']);
        $this->showEditDocumentsModal = false;

        // Optional: Dispatch a success message
        $this->dispatch('alert', [
            'title' => 'Documents Updated',
            'message' => 'Your documents have been successfully updated.',
            'type' => 'success'
        ]);
    }

    // Reset pagination when search changes
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    // Clear search input
    public function clearSearch()
    {
        $this->search = '';
    }

    // Triggered when search or other filters are updated
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Reset filters
    public function resetFilters()
    {
        $this->startTaggingDate = null;
        $this->endTaggingDate = null;
        $this->selectedOriginOfRequest = null;
        $this->selectedTaggingStatus = null;

        $this->resetPage();
        $this->search = '';
    }


    public function findMaterialInfo($material_id)
    {
        $material = Material::with(['purchaseOrder', 'materialUnit', 'available_quantity'])->find($material_id);
        if ($material) {
            return [
                'material_unit_id' => $material->materialUnit?->unit ?? 'N/A',
                'purchase_order_id' => $material->purchaseOrder?->po_number ?? 'N/A',
                'available_quantity' => $material->available_quantity // 'available quantity' holds the available stock
            ];
        }
        return [];
    }

    public function updateMaterialInfo($index)
    {
        $material = Material::with(['purchaseOrder', 'materialUnit'])->find($this->materials[$index]['material_id']);

        if ($material) {
            // Store IDs for internal logic
            $this->materials[$index]['material_unit_id'] = $material->materialUnit?->id ?? null;
            $this->materials[$index]['purchase_order_id'] = $material->purchaseOrder?->id ?? null;

            // Store readable values for display
            $this->materials[$index]['materialUnitDisplay'] = $material->materialUnit?->unit ?? 'N/A';
            $this->materials[$index]['purchaseOrderDisplay'] = $material->purchaseOrder?->po_number ?? 'N/A';

            // Quantity is a straightforward value
            $this->materials[$index]['available_quantity'] = $material->available_quantity;
        } else {
            // Set defaults if material not found
            $this->materials[$index]['material_unit_id'] = null;
            $this->materials[$index]['purchase_order_id'] = null;
            $this->materials[$index]['materialUnitDisplay'] = 'N/A';
            $this->materials[$index]['purchaseOrderDisplay'] = 'N/A';
            $this->materials[$index]['available_quantity'] = 'N/A';
        }
    }



    public function addMaterial()
    {
        $this->materials[] = ['material_id' => '', 'grantee_quantity' => '', 'material_unit_id' => '', 'purchase_order_id' => '', 'available_quantity' => ''];
    }

    public function removeMaterial($index)
    {
        unset($this->materials[$index]);
        $this->materials = array_values($this->materials); // reindex array
    }

    public function findpurchaseOrderId($material_id)
    {
        $material = Material::with('purchaseOrder')->find($material_id);
        return $material?->purchaseOrder?->po_number ?? 'N/A';
    }


    protected function rules(): array
    { // For Granting Modal
        return [
            'date_of_delivery' => 'required|date',
            'date_of_ris' => 'required|date',
            'ar_no' => 'required|numeric',
            'materials.*.material_id' => 'required|exists:materials,id',
            'grantee_quantity.*' => 'required|numeric|min:1',
            'materials.*.material_unit_id' => 'required|exists:material_units,id',
            'materials.*.purchase_order_id' => 'required|exists:purchase_orders,id'
            // 'photo.*' => 'required|image|max:2048'
        ];
    }

    public function updatedPhoto()
    {
        Log::info('Photo uploaded:', $this->images);
        // Validate the uploaded images immediately after selection
        $this->validateOnly('images');
    }

    public function grantApplicant()
    {
        $this->validate();
        DB::beginTransaction();

        try {
            // Create the grantee entry first
            $grantee = Grantee::updateOrCreate([
                'profiled_tagged_applicant_id' => $this->profiledTaggedApplicantId,
                'date_of_delivery' => $this->date_of_delivery,
                'date_of_ris' => $this->date_of_ris,
                'ar_no' => $this->ar_no,
                'is_granted' => true,
            ]);

            // Now loop over the materials to create DeliveredMaterial entries for this grantee
            foreach ($this->materials as $material) {
                // Check if there's enough stock available for the material
                $currentMaterial = Material::find($material['material_id']);
                if ($currentMaterial->available_quantity < $material['grantee_quantity']) {
                    throw new \Exception("Insufficient stock for material ID: {$material['material_id']}");
                }

                // Create the DeliveredMaterial record for each material
                DeliveredMaterial::create([
                    'grantee_id' => $grantee->id,
                    'material_id' => $material['material_id'],
                    'grantee_quantity' => $material['grantee_quantity'],
                ]);

                // Subtract the granted quantity from the available stock
                $currentMaterial->decrement('available_quantity', $material['grantee_quantity']);
            }

            // Retrieve the delivered materials for logging or debugging purposes
            $deliveredMaterials = $grantee->deliveredMaterials; // Will automatically load related delivered materials
            Log::info('Materials delivered to grantee', ['granteeId' => $grantee->id, 'deliveredMaterials' => $deliveredMaterials]);


            foreach ($this->images as $image) {
                $path = $image->storeAs('images', $image->getClientOriginalName(), 'public');
                ShelterUploadedFiles::create([
                    'grantee_id' => $grantee->id,
                    'image_path' => $path,
                    'display_name' => $image->getClientOriginalName(),
                ]);
            }

            Log::info('Grantee created successfully', ['granteeId' => $grantee->id]);

            Grantee::where('id', $this->granteeId)->update([
                'is_granted' => true
            ]);
            // $grantee->update(['is_granted' => true]);

            // Log the activity
            $logger = new ActivityLogs();
            $user = Auth::user();
            $logger->logActivity('Granted Shelter Applicant', $user);

            DB::commit();
            $this->resetForm();
            $this->dispatch('alert', [
                'title' => 'Granted!',
                'message' => 'The Applicant Successfuly Granted.',
                'type' => 'success',
            ]);

            return redirect()->route('shelter-profiled-tagged-applicants');
        } catch (QueryException $e) {
            DB::rollBack();
            $this->handleGrantingError($e);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing grant: ' . $e->getMessage());
            $this->dispatch('alert', [
                'title' => 'Insufficient Stock!',
                'message' => 'There was not enough stock to fulfill this request.',
                'type' => 'danger',
            ]);
        }
    }

    protected function handleGrantingError(QueryException $e)
    {
        $errorMessage = 'An error occurred while processing your request. Please try again later.';
        if ($e->getCode() === 23000) {
            $errorMessage = 'The information you provided conflicts with existing records. Please check your input and try again.';
        } elseif ($e->getCode() === 42000) {
            $errorMessage = 'There was a problem with the data you provided. Please check your input and try again.';
        }

        Log::error('Error creating grantee: ' . $e->getMessage());
        $this->dispatch('alert', [
            'title' => 'Something went wrong!',
            'message' => $errorMessage . ' <br><small>' . now()->calendar() . '</small>',
            'type' => 'danger',
        ]);
    }

    public function resetForm(): void
    {
        $this->reset([
            'material_id',
            'materialUnitId',
            'purchaseOrderId',
            'date_of_delivery',
            'date_of_ris',
            'ar_no',
            'grantee_quantity',
            'images',
        ]);
    }

    public function viewApplicantDetails($profileNo): RedirectResponse
    {
        return redirect()->route('profiled-tagged-applicant-details', ['profileNo' => $profileNo]);
    }

    public function searchMaterials($query)
    {
        if (empty($query)) {
            return [];
        }

        return Material::where('item_description', 'like', '%' . $query . '%')
            ->take(10) // Limit results for performance
            ->get(['id', 'item_description'])
            ->toArray();
    }

    public function markRequirementsComplete()
    {
        // Find the applicant and update the `documents_submitted` column
        $shelterApplicant = ProfiledTaggedApplicant::find($this->profiledTaggedApplicantId);
        if ($shelterApplicant) {
            $shelterApplicant->update(['documents_submitted' => true]);
            $this->dispatch('requirements-completed'); // Notify Alpine.js
        }
    }


    public function render()
    {
        // Fetch applicants with their related data
        $query = ProfiledTaggedApplicant::with(['originOfRequest', 'shelterApplicant.person'])
            ->where(function ($query) {
                // Search within shelterApplicant's person relationship
                $query->whereHas('shelterApplicant.person', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%');
                })
                    // Search within shelterApplicant's own fields
                    ->orWhereHas('shelterApplicant', function ($q) {
                        $q->where('request_origin_id', 'like', '%' . $this->search . '%')
                            ->orWhere('profile_no', 'like', '%' . $this->search . '%');
                    });
            });

        // Apply date range filter (if both dates are present)
        if ($this->startTaggingDate && $this->endTaggingDate) {
            $query->whereBetween('date_tagged', [$this->startTaggingDate, $this->endTaggingDate]);
        }

        // Filter by selected origin of request
        if ($this->selectedOriginOfRequest) {
            $query->whereHas('shelterApplicant.originOfRequest', function ($q) {
                $q->where('id', $this->selectedOriginOfRequest);
            });
        }

        $profiledTaggedApplicants = $query->orderBy('date_tagged', 'desc')->paginate(10);

        // Load documents for the current profiled tagged applicant if applicable
        if ($this->profiledTaggedApplicantId) {
            $this->documents = GranteeDocumentsSubmission::where('profiled_tagged_applicant_id', $this->profiledTaggedApplicantId)->get();
        }

        // Fetch all origin of requests for filter dropdown
        $OriginOfRequests = OriginOfRequest::all();

        return view('livewire.shelter-profiled-tagged-applicants', [
            'profiledTaggedApplicants' => $profiledTaggedApplicants,
            'OriginOfRequests' => $OriginOfRequests,
        ]);
    }
}
