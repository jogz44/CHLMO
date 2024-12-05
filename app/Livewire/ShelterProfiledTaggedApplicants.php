<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Address;
use App\Models\LivingStatus;
use App\Models\Shelter\Grantee;
use App\Models\Shelter\Material;
use App\Models\Shelter\GranteeAttachmentList;
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
use App\Models\ShelterUploadedFile;
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

    // For uploading of files
    public $isFilePondUploadComplete = false, $isFilePonduploading = false, $requestLetterAddressToCityMayor, $certificateOfIndigency, $consentLetterIfTheLandIsNotTheirs,
        $photocopyOfIdFromTheLandOwnerIfTheLandIsNotTheirs, $profilingForm, $selectedGrantee, $files,
        $granteeToPreview, $isUploading = false;

    public $attachment_id, $attachmentLists = [];
    public $description, $granteeId, $documents = [], $newFileImages = [];
    public $show = false;

    public $materialLists = [];
    public $materials = [
        ['material_id' => '', 'grantee_quantity' => '', 'material_unit_id' => '', 'purchase_order_id' => '', 'available_quantity' => '']
    ];


    public $shelterLivingStatusesFilter = [];
    public $showDocumentModal = false;
    public $currentDocuments = [];
    public $editingDocumentId = null;
    public $newDocument = null;


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

    public function mount()
    {

        $this->shelterLivingStatusesFilter = Cache::remember('living_situations', 60 * 60, function () {
            return LivingStatus::all();
        });
        $this->taggingStatuses = ['Tagged', 'Not Tagged']; // Add your statuses here        
        $this->date_request = now()->toDateString(); // YYYY-MM-DD format

        // For Granting Modal
        $this->date_of_delivery = now()->toDateString(); // YYYY-MM-DD format
        $this->date_of_ris = now()->toDateString(); // YYYY-MM-DD format

        $this->materialLists = Material::all();
        $this->materialUnits = MaterialUnit::all();
        $this->purchaseOrders = Material::with('purchaseOrder')->get();

        // Fetch attachment types for the dropdown
        $this->attachmentLists = GranteeAttachmentList::all(); // Fetch all attachment lists

        $this->isFilePondUploadComplete = false;
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

    public  function removeUpload($property, $fileName, $load): void
    {
        $filePath = storage_path('livewire-tmp/' . $fileName);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $load('');
    }
    public function updatedGranteeUpload(): void
    {
        $this->isFilePondUploadComplete = true;
        $this->validate([
            'requestLetterAddressToCityMayor' => 'nullable|file|max:10240',
            'certificateOfIndigency' => 'nullable|file|max:10240',
            'consentLetterIfTheLandIsNotTheirs' => 'nullable|file|max:10240',
            'photocopyOfIdFromTheLandOwnerIfTheLandIsNotTheirs' => 'nullable|file|max:10240',
            'profilingForm' => 'nullable|file|max:10240',
        ]);
    }

    public function submit(): void
    {
        $submittedAttachments = GranteeDocumentsSubmission::where('profiled_tagged_applicant_id', $this->profiledTaggedApplicantId)->count();

        if ($submittedAttachments === 0) {
            $this->handleError('No documents have been submitted.');
            return;
        }

        DB::beginTransaction();
        try {
            // Check if granteeId is set
            if (is_null($this->profiledTaggedApplicantId)) {
                $this->handleError('Grantee ID is missing. Please make sure the grantee is created first.');
                return;
            }

            // Log the current IDs we're working with
            logger()->info('Starting submission with IDs', [
                'profiled_tagged_applicant_id' => $this->profiledTaggedApplicantId,
                // 'attachment_id' => $this->attachment_id,
            ]);

            $this->isFilePonduploading = false;

            // Validate inputs
            $validatedData = $this->validate([
                'requestLetterAddressToCityMayor' => 'nullable|file|max:10240',
                'certificateOfIndigency' => 'nullable|file|max:10240',
                'consentLetterIfTheLandIsNotTheirs' => 'nullable|file|max:10240',
                'photocopyOfIdFromTheLandOwnerIfTheLandIsNotTheirs' => 'nullable|file|max:10240',
                'profilingForm' => 'nullable|file|max:10240',
            ]);

            logger()->info('Validation passed', $validatedData);

            $this->storeAttachment('requestLetterAddressToCityMayor', 1);
            $this->storeAttachment('certificateOfIndigency', 2);
            $this->storeAttachment('consentLetterIfTheLandIsNotTheirs', 3);
            $this->storeAttachment('photocopyOfIdFromTheLandOwnerIfTheLandIsNotTheirs', 4);
            $this->storeAttachment('profilingForm', 5);

            DB::commit();

            // Log the activity
            $logger = new ActivityLogs();
            $user = Auth::user();
            $logger->logActivity('Submitted Applicants Requirements', $user);

            $this->dispatch('alert', [
                'title' => 'Requirements Submitted Successfully!',
                'message' => 'Applicant is now ready for granting! <br><small>' . now()->calendar() . '</small>',
                'type' => 'warning'
            ]);

            $this->redirect('shelter-profiled-tagged-applicants');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->dispatch('alert', [
                'title' => 'Failed!',
                'message' => 'Submission of requirements failed. Please try again. <br><small>' . now()->calendar() . '</small>',
                'type' => 'danger'
            ]);
        }
    }

    /**
     * Store individual attachment
     */
    private function storeAttachment($fileInput, $attachmentId): void
    {
        $file = $this->$fileInput;
        if ($file) {
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'grantee-photo-requirements');

            GranteeDocumentsSubmission::create([
                'profiled_tagged_applicant_id' => $this->profiledTaggedApplicantId,
                'attachment_id' => $attachmentId,
                'file_path' => $filePath,
                'file_name' => $fileName,
                'file_type' => $file->extension(),
                'file_size' => $file->getSize(),
            ]);

            // Update the applicant's status
            ProfiledTaggedApplicant::where('id', $this->profiledTaggedApplicantId)->update([
                'is_awarding_on_going' => true
            ]);
            logger()->info('The applicant submitted its requirements', ['id' => $this->profiledTaggedApplicantId]);
        }
    }
    private function handleError(string $message, \Exception $e = null): void
    {
        if ($e) {
            logger()->error('Document submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        } else {
            logger()->error('Document submission failed', ['error' => $message]);
        }
        $this->dispatch('alert', [
            'title' => 'Error',
            'message' => $message,
            'type' => 'error'
        ]);
    }

    private function resetUpload(): void
    {
        $this->isFilePondUploadComplete = false;  // Reset FilePond upload status if applicable
        $this->show = false;  // Close the modal or hide any UI related to uploads if needed
    }

    public function isRequirementsComplete($profiledTaggedApplicantId): bool
    {
        $submittedAttachments = GranteeDocumentsSubmission::where('profiled_tagged_applicant_id', $profiledTaggedApplicantId)->count();

        // Check for at least one document if all are optional
        return $submittedAttachments > 0;
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

    // Update the viewSubmittedDocuments method to include the attachment name
    public function viewSubmittedDocuments($applicantId): void
    {
        $this->profiledTaggedApplicantId = $applicantId;
        $attachmentsList = GranteeAttachmentList::all()->pluck('attachment_name', 'id');

        $this->currentDocuments = GranteeDocumentsSubmission::where('profiled_tagged_applicant_id', $applicantId)
            ->with('attachmentType')
            ->get()
            ->map(function ($doc) use ($attachmentsList) {
                return [
                    'id' => $doc->id,
                    'attachment_name' => $attachmentsList[$doc->attachment_id] ?? 'Unknown Attachment',
                    'file_name' => $doc->file_name,
                    'file_path' => $doc->file_path,
                    'attachment_id' => $doc->attachment_id,
                    // Updated to use the correct path structure based on your filesystem config
                    'file_url' => asset('grantee-photo-requirements/' . $doc->file_path)
                ];
            });
        $this->showDocumentModal = true;
    }

    public function startEditingDocument($documentId): void
    {
        $this->editingDocumentId = $documentId;
    }

    public function updateDocument()
    {
        $this->validate([
            'newDocument' => 'required|file|max:10240|mimes:jpeg,png,jpg,gif'
        ]);

        DB::beginTransaction();
        try {
            $document = GranteeDocumentsSubmission::find($this->editingDocumentId); // Updated property name

            // Store the new file
            $file = $this->newDocument;
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'grantee-photo-requirements');

            // Delete old file if it exists
            if ($document->file_path) {
                Storage::disk('grantee-photo-requirements')->delete($document->file_path);
            }

            // Update document record
            $document->update([
                'file_path' => $filePath,
                'file_name' => $fileName,
                'file_type' => $file->extension(),
                'file_size' => $file->getSize(),
            ]);

            DB::commit();

            $this->editingDocumentId = null; // Updated property name
            $this->newDocument = null;
            $this->viewSubmittedDocuments($this->profiledTaggedApplicantId); // Refresh documents

            $this->dispatch('alert', [
                'title' => 'Document Updated',
                'message' => 'Document has been successfully updated!',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->handleError('Failed to update document', $e);
        }
    }

    public function cancelEdit(): void
    {
        $this->editingDocumentId = null; // Updated property name
        $this->newDocument = null;
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

        // Fetch all origin of requests for filter dropdown
        $OriginOfRequests = OriginOfRequest::all();

        // Fetch and paginate the results
        $profiledTaggedApplicants = $query->orderBy('date_tagged', 'desc')->paginate(5);

        return view('livewire.shelter-profiled-tagged-applicants', [
            'profiledTaggedApplicants' => $profiledTaggedApplicants,
            'OriginOfRequests' => $OriginOfRequests,
        ]);
    }
}
