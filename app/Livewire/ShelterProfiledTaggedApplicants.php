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
use Livewire\WithFileUploads;
use Livewire\WithPagination;


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
    public $quantity, $date_of_delivery, $date_of_ris;
    public $grantee_quantity = [];
    public $photo = [];

    // For uploading of files
    public $isFilePondUploadComplete = false, $isFilePonduploading = false, $requestLetterAddressToCityMayor, $certificateOfIndigency, $consentLetterIfTheLandIsNotTheirs,
        $photocopyOfIdFromTheLandOwnerIfTheLandIsNotTheirs, $profilingForm, $selectedGrantee, $files,
        $granteeToPreview, $isUploading = false;

    public $attachment_id, $attachmentLists = [];
    public $description, $granteeId, $documents = [], $newFileImages = [];
    public $show = false;

    public $materialLists = [];
    public $materials = [
        ['material_id' => '', 'grantee_quantity' => '', 'material_unit_id' => '', 'purchase_order_id' => '', 'quantity' => '']
    ];


    public $shelterLivingStatusesFilter = [];

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
        $material = Material::with(['purchaseOrder', 'materialUnit', 'quantity'])->find($material_id);
        if ($material) {
            return [
                'material_unit_id' => $material->materialUnit?->unit ?? 'N/A',
                'purchase_order_id' => $material->purchaseOrder?->po_number ?? 'N/A',
                'quantity' => $material->quantity // Assuming 'quantity' holds the available stock
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
            $this->materials[$index]['quantity'] = $material->quantity;
        } else {
            // Set defaults if material not found
            $this->materials[$index]['material_unit_id'] = null;
            $this->materials[$index]['purchase_order_id'] = null;
            $this->materials[$index]['materialUnitDisplay'] = 'N/A';
            $this->materials[$index]['purchaseOrderDisplay'] = 'N/A';
            $this->materials[$index]['quantity'] = 'N/A';
        }
    }



    public function addMaterial()
    {
        $this->materials[] = ['material_id' => '', 'grantee_quantity' => '', 'material_unit_id' => '', 'purchase_order_id' => '', 'quantity' => ''];
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
            'materials.*.material_id' => 'required|exists:materials,id',
            'grantee_quantity.*' => 'required|numeric|min:1',
            'materials.*.material_unit_id' => 'required|exists:material_units,id',
            'materials.*.purchase_order_id' => 'required|exists:purchase_orders,id'
            // 'photo.*' => 'required|image|max:2048'
        ];
    }

    public function updatedPhoto()
    {
        Log::info('Photo uploaded:', $this->photo);
        // Validate the uploaded photo immediately after selection
        $this->validateOnly('photo');
    }



    // public function grantApplicant()
    // {
    //     $this->validate();
    //     DB::beginTransaction();

    //     try {
    //         // Loop over each material to create a grantee entry
    //         foreach ($this->materials as $material) {
    //             // Check if there's enough stock available for the material
    //             $currentMaterial = Material::find($material['material_id']);
    //             if ($currentMaterial->quantity < $material['grantee_quantity']) {
    //                 throw new \Exception("Insufficient stock for material ID: {$material['material_id']}");
    //             }

    //             // Create the grantee entry
    //             $grantee = Grantee::create([
    //                 'profiled_tagged_applicant_id' => $this->profiledTaggedApplicantId,
    //                 'material_id' => $material['material_id'],
    //                 'grantee_quantity' => $material['grantee_quantity'],
    //                 'material_unit_id' => $material['material_unit_id'],
    //                 'purchase_order_id' => $material['purchase_order_id'],
    //                 'date_of_delivery' => $this->date_of_delivery,
    //                 'date_of_ris' => $this->date_of_ris,
    //                 'is_granted' => false,
    //             ]);

    //             // Upload photos if any
    //             foreach ($this->photo as $image) {
    //                 $path = $image->storeAs('photo', $image->getClientOriginalName(), 'public');
    //                 ShelterUploadedFiles::create([
    //                     'grantee_id' => $grantee->id,
    //                     'image_path' => $path,
    //                     'display_name' => $image->getClientOriginalName(),
    //                 ]);
    //             }

    //             // Subtract the granted quantity from the available stock
    //             $currentMaterial->decrement('quantity', $material['grantee_quantity']);

    //             Log::info('Grantee created successfully', ['granteeId' => $grantee->id]);
    //         }

    //         // Update the applicant's status
    //         ProfiledTaggedApplicant::where('id', $this->profiledTaggedApplicantId)->update([
    //             'is_awarding_on_going' => true
    //         ]);

    //         DB::commit();
    //         $this->resetForm();
    //         $this->dispatch('alert', [
    //             'title' => 'Granting Pending!',
    //             'message' => 'Applicant needs to submit necessary requirements.',
    //             'type' => 'warning',
    //         ]);

    //         return redirect()->route('shelter-profiled-tagged-applicants');
    //     } catch (QueryException $e) {
    //         DB::rollBack();
    //         $this->handleGrantingError($e);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Error processing grant: ' . $e->getMessage());
    //         $this->dispatch('alert', [
    //             'title' => 'Insufficient Stock!',
    //             'message' => 'There was not enough stock to fulfill this request.',
    //             'type' => 'danger',
    //         ]);
    //     }
    // }

    public function grantApplicant()
    {
        $this->validate();
        DB::beginTransaction();

        try {
            // Create the grantee entry first
            $grantee = Grantee::create([
                'profiled_tagged_applicant_id' => $this->profiledTaggedApplicantId,
                'date_of_delivery' => $this->date_of_delivery,
                'date_of_ris' => $this->date_of_ris,
                'is_granted' => false,
            ]);

            // Now loop over the materials to create DeliveredMaterial entries for this grantee
            foreach ($this->materials as $material) {
                // Check if there's enough stock available for the material
                $currentMaterial = Material::find($material['material_id']);
                if ($currentMaterial->quantity < $material['grantee_quantity']) {
                    throw new \Exception("Insufficient stock for material ID: {$material['material_id']}");
                }

                // Create the DeliveredMaterial record for each material
                DeliveredMaterial::create([
                    'grantee_id' => $grantee->id,
                    'material_id' => $material['material_id'],
                    'grantee_quantity' => $material['grantee_quantity'],
                ]);

                // Subtract the granted quantity from the available stock
                $currentMaterial->decrement('quantity', $material['grantee_quantity']);
            }

            // Retrieve the delivered materials for logging or debugging purposes
            $deliveredMaterials = $grantee->deliveredMaterials; // Will automatically load related delivered materials
            Log::info('Materials delivered to grantee', ['granteeId' => $grantee->id, 'deliveredMaterials' => $deliveredMaterials]);

           
            foreach ($this->photo as $image) {
                $path = $image->storeAs('photo', $image->getClientOriginalName(), 'public');
                ShelterUploadedFiles::create([
                    'grantee_id' => $grantee->id,
                    'image_path' => $path,
                    'display_name' => $image->getClientOriginalName(),
                ]);
            }

            Log::info('Grantee created successfully', ['granteeId' => $grantee->id]);

            // Update the applicant's status
            ProfiledTaggedApplicant::where('id', $this->profiledTaggedApplicantId)->update([
                'is_awarding_on_going' => true
            ]);

            DB::commit();
            $this->resetForm();
            $this->dispatch('alert', [
                'title' => 'Granting Pending!',
                'message' => 'Applicant needs to submit necessary requirements.',
                'type' => 'warning',
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

        Log::error('Error creating applicant or dependents: ' . $e->getMessage());
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
            'grantee_quantity',
            'photo',
        ]);
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
            'requestLetterAddressToCityMayor' => 'required|file|max:10240',
            'certificateOfIndigency' => 'required|file|max:10240',
            'consentLetterIfTheLandIsNotTheirs' => 'required|file|max:10240',
            'photocopyOfIdFromTheLandOwnerIfTheLandIsNotTheirs' => 'required|file|max:10240',
            'profilingForm' => 'required|file|max:10240',
        ]);
    }

    public function submit(): void
    {
        DB::beginTransaction();
        try {
            // Check if granteeId is set
            if (is_null($this->granteeId)) {
                $this->handleError('Grantee ID is missing. Please make sure the grantee is created first.');
                return;
            }

            // Log the current IDs we're working with
            logger()->info('Starting submission with IDs', [
                'grantee_id' => $this->granteeId,
                // 'attachment_id' => $this->attachment_id,
            ]);

            $this->isFilePonduploading = false;

            // Validate inputs
            $validatedData = $this->validate([
                'requestLetterAddressToCityMayor' => 'required|file|max:10240',
                'certificateOfIndigency' => 'required|file|max:10240',
                'consentLetterIfTheLandIsNotTheirs' => 'required|file|max:10240',
                'photocopyOfIdFromTheLandOwnerIfTheLandIsNotTheirs' => 'required|file|max:10240',
                'profilingForm' => 'required|file|max:10240',
            ]);

            logger()->info('Validation passed', $validatedData);

            $this->storeAttachment('requestLetterAddressToCityMayor', 1);
            $this->storeAttachment('certificateOfIndigency', 2);
            $this->storeAttachment('consentLetterIfTheLandIsNotTheirs', 3);
            $this->storeAttachment('photocopyOfIdFromTheLandOwnerIfTheLandIsNotTheirs', 4);
            $this->storeAttachment('profilingForm', 5);

            DB::commit();

            $this->dispatch('alert', [
                'title' => 'Requirements Submitted Successfully!',
                'message' => 'Applicant is now an official grantee! <br><small>' . now()->calendar() . '</small>',
                'type' => 'success'
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
                'grantee_id' => $this->granteeId,
                'attachment_id' => $attachmentId,
                'file_path' => $filePath,
                'file_name' => $fileName,
                'file_type' => $file->extension(),
                'file_size' => $file->getSize(),
            ]);

            logger()->info('Searching for grantee with ID', ['id' => $this->granteeId]);

            $grantee = Grantee::findOrFail($this->granteeId);

            logger()->info('Found grantee', [
                'grantee_id' => $grantee->id,
                'profiled_tagged_applicant_id' => $grantee->profiled_tagged_applicant_id
            ]);

            // $grantee->update(['is_granted' => true]);
            Grantee::where('id', $this->granteeId)->update([
                'is_granted' => true
            ]);
            logger()->info('The grantee is now granted', ['id' => $this->granteeId]);
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
        $this->reset([
            'requestLetterAddressToCityMayor',
            'certificateOfIndigency',
            'consentLetterIfTheLandIsNotTheirs',
            'photocopyOfIdFromTheLandOwnerIfTheLandIsNotTheirs',
            'profilingForm',
            'attachment_id',
        ]);

        $this->isFilePondUploadComplete = false;  // Reset FilePond upload status if applicable
        $this->show = false;  // Close the modal or hide any UI related to uploads if needed
    }
    public function viewApplicantDetails($profileNo): RedirectResponse
    {
        return redirect()->route('profiled-tagged-applicant-details', ['profileNo' => $profileNo]);
    }

    public function render()
    {
        $query = ProfiledTaggedApplicant::query();

        // Apply search conditions if there is a search term
        $query->when($this->search, function ($query) {
            return $query->where(function ($query) {
                $query->where('profile_no', 'like', '%' . $this->search . '%')
                    ->orWhereHas('shelterApplicant', function ($query) { // Access shelterApplicant relationship
                        $query->where('first_name', 'like', '%' . $this->search . '%')
                            ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                            ->orWhere('last_name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('shelterApplicant.originOfRequest', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        });

        // Apply date range filter (if both dates are present)
        if ($this->startTaggingDate && $this->endTaggingDate) {
            $query->whereBetween('date_tagged', [$this->startTaggingDate, $this->endTaggingDate]);
        }

        if ($this->selectedOriginOfRequest) {
            $query->whereHas('shelterApplicant.originOfRequest', function ($query) {
                $query->where('id', $this->selectedOriginOfRequest);
            });
        }

        $OriginOfRequests = OriginOfRequest::all();

        $query = $query->with(['originOfRequest', 'shelterApplicant']);
        $profiledTaggedApplicants = $query->paginate(5);

        return view('livewire.shelter-profiled-tagged-applicants', [
            'profiledTaggedApplicants' => $profiledTaggedApplicants,
            'OriginOfRequests' => $OriginOfRequests,
        ]);
    }
}
