<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\Awardee;
use App\Models\AwardeeAttachmentsList;
use App\Models\AwardeeTransferHistory;
use App\Models\Barangay;
use App\Models\Blacklist;
use App\Models\Dependent;
use App\Models\Purok;
use App\Models\RelocationSite;
use App\Models\Spouse;
use App\Models\TransferAttachmentsList;
use App\Models\TransferDocumentsSubmissions;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Livewire\Logs\ActivityLogs;
use Illuminate\Support\Facades\Auth;

class AwardeeList extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $spouse = null, $isSpouseTransfer = false, $awardee;
    public $showTransferModal = false, $showConfirmationModal = false, $selectedAwardeeId, $eligibleDependents = [],
        $selectedDependentId, $selectedDependent;

    // Filter properties
    public $relocation_site = '', $barangay = '', $purok = '', $status = '', $search = '', $startDate = '', $endDate = '';
    public $lot_number = '', $block_identifier = '';

    // For uploading of files
    public $showRequirementsModal = false, $selectedAwardeeIdForTransfer;
    public $isFilePondUploadComplete = false, $isFilePonduploading = false, $originalCopyOfNoticeOfAward, $deathCert, $marriageCert,
        $validId1, $validId2, $votersCert, $birthCert, $extraJudicialSettlement, $certOfNoLandHolding, $files,
        $transferToPreview, $isUploading = false, $attachment_id, $attachmentLists = [], $transferId, $documents = [],
        $newFileImages = [];
    public $hasSubmittedDocuments = false;
    public $transferredAwardees = [];  // To track which awardees have been transferred

    // For viewing the submitted requirements/images
    public $showDocumentViewModal = false;
    public $currentDocuments = [];
    public $editingDocumentId = null;
    public $newDocument = null;
    public $selectedDependentDetails = null;

    public function openTransferModal($awardeeId): void
    {
        $this->selectedAwardeeId = $awardeeId; // Add this line
        $this->awardee = Awardee::with([
            'taggedAndValidatedApplicant.spouse',
            'taggedAndValidatedApplicant.dependents.dependentRelationship'
        ])->findOrFail($awardeeId);

        // Get spouse if exists
        $this->spouse = $this->awardee->taggedAndValidatedApplicant->spouse;

        // Get eligible dependents
        $this->eligibleDependents = $this->awardee->taggedAndValidatedApplicant->dependents()
            ->whereHas('dependentRelationship', function($query) {
                $query->whereIn('relationship', [
                    'Child (Biological)',
                    'Mother',
                    'Father'
                ]);
            })
            ->get();

        $this->showTransferModal = true;
    }
    public function loadEligibleDependents(): void
    {
        // Get the awardee with dependents and spouse relationships
        $awardee = Awardee::with([
            'taggedAndValidatedApplicant' => function ($query) {
                $query->with([
                    'dependents' => function ($dependentQuery) {
                        $dependentQuery->whereHas('dependentRelationship', function ($relationshipQuery) {
                            $relationshipQuery->whereIn('relationship', [
                                'Child (Biological)',
                                'Mother',
                                'Father'
                            ]);
                        });
                    },
                    'spouse', // Include the spouse if the applicant is married
                ]);
            },
            'taggedAndValidatedApplicant.dependents.dependentRelationship'
        ])->findOrFail($this->selectedAwardeeId);

        // Separate dependents and spouse
        $this->eligibleDependents = $awardee->taggedAndValidatedApplicant->dependents;

        // Check for spouse eligibility based on civil status
        if ($awardee->taggedAndValidatedApplicant->civil_status_id === 3) {
            $spouse = $awardee->taggedAndValidatedApplicant->spouse;
            if ($spouse) {
                $this->spouse = $spouse; // Handle spouse separately
            }
        }
    }

    // Requirements upload:
    public function mount()
    {
        // Fetch attachment types for the dropdown
        $this->attachmentLists = TransferAttachmentsList::all(); // Fetch all attachment lists
        $this->isFilePondUploadComplete = false;
        // Check if the selected awardee has submitted documents
        $this->hasSubmittedDocuments = Awardee::where('id', $this->selectedAwardeeId)
            ->value('documents_submitted') ?? false;
    }
    protected $rules = [
        'selectedAwardeeIdForTransfer' => 'required|exists:awardees,id',
        'originalCopyOfNoticeOfAward' => 'nullable|file|max:10240',
        'deathCert' => 'nullable|file|max:10240',
        'marriageCert' => 'nullable|file|max:10240',
        'validId1' => 'nullable|file|max:10240',
        'validId2' => 'nullable|file|max:10240',
        'votersCert' => 'nullable|file|max:10240',
        'birthCert' => 'nullable|file|max:10240',
        'extraJudicialSettlement' => 'nullable|file|max:10240',
        'certOfNoLandHolding' => 'nullable|file|max:10240',
    ];
    public function openRequirementsModal($awardeeIdForTransfer): void
    {
        $this->selectedAwardeeIdForTransfer = $awardeeIdForTransfer;
        $this->showRequirementsModal = true;
    }
    public function submit()
    {
        DB::beginTransaction();
        try {
            logger()->info('Starting document submission for transfer', [
                'awardee' => $this->selectedAwardeeIdForTransfer,
            ]);

            $this->isFilePonduploading = false;

            // Validate and store documents
            $this->validate([
                'originalCopyOfNoticeOfAward' => 'nullable|file|max:10240',
                'deathCert' => 'nullable|file|max:10240',
                'marriageCert' => 'nullable|file|max:10240',
                'validId1' => 'nullable|file|max:10240',
                'validId2' => 'nullable|file|max:10240',
                'votersCert' => 'nullable|file|max:10240',
                'birthCert' => 'nullable|file|max:10240',
                'extraJudicialSettlement' => 'nullable|file|max:10240',
                'certOfNoLandHolding' => 'nullable|file|max:10240',
            ]);

            // Store each document
            $this->storeAttachment('originalCopyOfNoticeOfAward', 1);
            $this->storeAttachment('deathCert', 2);
            $this->storeAttachment('marriageCert', 3);
            $this->storeAttachment('validId1', 4);
            $this->storeAttachment('validId2', 5);
            $this->storeAttachment('votersCert', 6);
            $this->storeAttachment('birthCert', 7);
            $this->storeAttachment('extraJudicialSettlement', 8);
            $this->storeAttachment('certOfNoLandHolding', 9);

            // Update the `documents_submitted` field for the awardee
            Awardee::where('id', $this->selectedAwardeeIdForTransfer)
                ->update([
                    'documents_submitted' => true,
                    'is_blacklisted' => false,
                    ]);

            $this->hasSubmittedDocuments = true;

            DB::commit();

            $this->showRequirementsModal = false;

            $this->dispatch('alert', [
                'title' => 'Requirements Submitted Successfully!',
                'message' => 'Documents have been submitted successfully!.' . '<br>' . 'You mmay now proceed to Transfer.',
                'type' => 'success'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->handleError('Document submission failed', $e);
        }
    }
    private function handleError(string $message, \Exception $e = null): void
    {
        if ($e) {
            logger()->error($message, [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        $this->dispatch('alert', [
            'title' => 'Error',
            'message' => $message,
            'type' => 'error'
        ]);
    }
    /**
     * Store individual attachment
     */
    private function storeAttachment($fileInput, $attachmentId): void
    {
        $file = $this->$fileInput;
        if ($file) {
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'transfer-photo-requirements');

            TransferDocumentsSubmissions::create([
                'awardee_id' => $this->selectedAwardeeIdForTransfer,
                'attachment_id' => $attachmentId,
                'file_path' => $filePath,
                'file_name' => $fileName,
                'file_type' => $file->extension(),
                'file_size' => $file->getSize(),
            ]);
        }
    }
    public function removeUpload($property, $fileName, $load): void
    {
        $filePath = storage_path('livewire-tmp/'.$fileName);
        if (file_exists($filePath)){
            unlink($filePath);
        }
        $load('');
    }
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $tmpPath = storage_path('livewire-tmp');
            // Delete files older than 24 hours
            foreach (glob("$tmpPath/*") as $file) {
                if (time() - filemtime($file) > 24 * 3600) {
                    unlink($file);
                }
            }
        })->daily();
    }
    private function resetUpload(): void
    {
        $this->reset([
            'originalCopyOfNoticeOfAward',
            'deathCert',
            'marriageCert',
            'validId1',
            'validId2',
            'votersCert',
            'birthCert',
            'extraJudicialSettlement',
            'certOfNoLandHolding',
            'attachment_id',
        ]);

        $this->isFilePondUploadComplete = false;  // Reset FilePond upload status if applicable
        $this->show = false;  // Close the modal or hide any UI related to uploads if needed
    }
    public function closeRequirementsModal(): void
    {
        $this->showRequirementsModal = false;
    }
    public function openConfirmModal(): void
    {
        $this->showConfirmationModal = true;
    }

    // Method to view submitted documents
    public function viewSubmittedDocuments($awardeeId): void
    {
        $this->selectedAwardeeIdForTransfer = $awardeeId;
        $attachmentList = TransferAttachmentsList::all()->pluck('attachment_name', 'id');

        // Get the awardee with the selected dependent
        $awardee = Awardee::with([
            'taggedAndValidatedApplicant.applicant.person',
            'taggedAndValidatedApplicant.spouse',
            'taggedAndValidatedApplicant.dependents.dependentRelationship'
        ])->find($awardeeId);

        if ($awardee) {
            // Get the selected dependent based on your previous selection
            if ($this->selectedDependentId) {
                if ($this->isSpouseTransfer) {
                    $spouse = $awardee->taggedAndValidatedApplicant->spouse;
                    $this->selectedDependentDetails = [
                        'name' => "{$spouse->spouse_last_name}, {$spouse->spouse_first_name} {$spouse->spouse_middle_name}",
                        'relationship' => 'Spouse'
                    ];
                } else {
                    $dependent = $awardee->taggedAndValidatedApplicant->dependents
                        ->where('id', $this->selectedDependentId)
                        ->first();

                    if ($dependent) {
                        $this->selectedDependentDetails = [
                            'name' => "{$dependent->dependent_last_name}, {$dependent->dependent_first_name} {$dependent->dependent_middle_name}",
                            'relationship' => $dependent->dependentRelationship->relationship
                        ];
                    }
                }
            }
        }

        // Get all documents, even if they don't exist yet
        $this->currentDocuments = collect($attachmentList)->map(function ($name, $id) {
            $document = TransferDocumentsSubmissions::where([
                'awardee_id' => $this->selectedAwardeeIdForTransfer,
                'attachment_id' => $id
            ])->first();

            return[
                'id' => $document ? $document->id : null,
                'attachment_id' => $id,
                'attachment_name' => $name,
                'file_name' => $document ? $document->file_name : null,
                'file_path' => $document ? $document->file_path : null,
                'file_url' => $document ? asset('transfer-photo-requirements/' . $document->file_path) : null,
                'exists' => (bool) $document
            ];
        })->values();

        $this->showDocumentViewModal = true;
    }

    public function startEditingDocument($documentId, $attachmentId): void
    {
        $this->editingDocumentId = $documentId;
        $this->attachment_id = $attachmentId;
        $this->newDocument = null; // Reset any previous file selection
    }

    public function updateDocument(): void
    {
        $this->validate([
            'newDocument' => 'required|file|max:10240|mimes:jpeg,png,jpg,gif'
        ]);

        DB::beginTransaction();
        try {
            $file = $this->newDocument;
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'transfer-photo-requirements');

            // For new uploads where there's no existing document
            if (!$this->editingDocumentId) {
                // Create new document
                TransferDocumentsSubmissions::create([
                    'awardee_id' => $this->selectedAwardeeIdForTransfer,
                    'attachment_id' => $this->attachment_id,
                    'file_path' => $filePath,
                    'file_name' => $fileName,
                    'file_type' => $file->extension(),
                    'file_size' => $file->getSize(),
                ]);
            } else {
                // Update existing document
                $document = TransferDocumentsSubmissions::find($this->editingDocumentId);

                // Delete old file if it exists
                if ($document && $document->file_path) {
                    Storage::disk('transfer-photo-requirements')->delete($document->file_path);
                }

                $document->update([
                    'file_path' => $filePath,
                    'file_name' => $fileName,
                    'file_type' => $file->extension(),
                    'file_size' => $file->getSize(),
                ]);
            }

            DB::commit();

            // Reset states
            $this->editingDocumentId = null;
            $this->newDocument = null;
            $this->attachment_id = null;

            // Refresh the documents list
            $this->viewSubmittedDocuments($this->selectedAwardeeIdForTransfer);

            $this->dispatch('alert', [
                'title' => 'Success',
                'message' => 'Document has been successfully ' . ($this->editingDocumentId ? 'updated' : 'uploaded') . '!',
                'type' => 'success'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Document upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->dispatch('alert', [
                'title' => 'Error',
                'message' => 'Failed to upload document: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function cancelEdit(): void
    {
        $this->editingDocumentId = null;
        $this->newDocument = null;
        $this->attachment_id = null;
    }

    public function confirmTransfer($id): void
    {
        $this->selectedDependentId = $id;

        // Get the awardee
        $awardee = Awardee::with([
            'taggedAndValidatedApplicant.dependents.dependentRelationship',
            'taggedAndValidatedApplicant.spouse'
        ])->find($this->selectedAwardeeId);

        // Check if this is a spouse transfer
        if ($this->spouse && $this->spouse->id == $id) {
            $this->selectedDependent = $this->spouse;
            $this->isSpouseTransfer = true;
        } else {
            // Regular dependent transfer
            $this->selectedDependent = $awardee->taggedAndValidatedApplicant->dependents
                ->where('id', $id)
                ->first();
            $this->isSpouseTransfer = false;
        }

        // Check if requirements are already submitted
        $hasSubmittedRequirements = TransferDocumentsSubmissions::where('awardee_id', $this->selectedAwardeeId)->exists();

        if (!$hasSubmittedRequirements) {
            // Close transfer modal and open requirements modal
            $this->showTransferModal = false;
            $this->openRequirementsModal($this->selectedAwardeeId);
        } else {
            // If requirements already submitted, show confirmation modal
            $this->showConfirmationModal = true;
        }
    }
    public function hasSubmittedRequirements($awardeeId)
    {
        return TransferDocumentsSubmissions::where('awardee_id', $awardeeId)->exists();
    }
    public function proceedWithTransfer(): void
    {
        try {
            $this->transferAward($this->selectedDependentId);

            // Mark awardee as transferred
            Awardee::where('id', $this->selectedAwardeeId)
                ->update(['is_awarded' => true]);

            $this->transferredAwardees[] = $this->selectedAwardeeId;

            $this->showConfirmationModal = false;

            // Reset states
            $this->hasSubmittedDocuments = false;
            $this->reset(['selectedAwardeeId', 'eligibleDependents', 'selectedDependentId', 'selectedDependent']);

            $this->dispatch('transfer-completed')->self();

        } catch (\Exception $e) {
            logger()->error('Transfer process failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            session()->flash('error', 'Failed to transfer award: ' . $e->getMessage());
        }
    }
    public function transferAward($transfereeId): void
    {
        try {
            DB::beginTransaction();

            // Get the current awardee
            $currentAwardee = Awardee::with([
                'taggedAndValidatedApplicant.dependents.dependentRelationship',
                'taggedAndValidatedApplicant.spouse'
            ])->findOrFail($this->selectedAwardeeId);

            if ($this->isSpouseTransfer) {
                // Handle spouse transfer
                $transferee = $currentAwardee->taggedAndValidatedApplicant->spouse()
                    ->where('id', $transfereeId)
                    ->firstOrFail();
                $relationship = 'Spouse';
            } else {
                // Handle dependent transfer
                $transferee = $currentAwardee->taggedAndValidatedApplicant->dependents()
                    ->with('dependentRelationship')
                    ->where('id', $transfereeId)
                    ->firstOrFail();
                $relationship = $transferee->dependentRelationship->relationship;
            }

            // Create blacklist record
            $blacklist = new Blacklist([
                'awardee_id' => $currentAwardee->id,
                'user_id' => auth()->id(),
                'blacklist_reason_description' => 'Deceased - Award transferred to ' .
                    ($this->isSpouseTransfer
                        ? "{$transferee->spouse_first_name} {$transferee->spouse_last_name}"
                        : "{$transferee->dependent_first_name} {$transferee->dependent_last_name}"),
                'date_blacklisted' => now(),
                'updated_by' => auth()->id()
            ]);
            $blacklist->save();

            // Update current awardee
            $currentAwardee->update([
                'is_blacklisted' => true
            ]);

            // Create transfer history
            $transferHistory = AwardeeTransferHistory::create([
                'previous_awardee_id' => $currentAwardee->id,
                'transfer_date' => now(),
                'transfer_reason' => 'Death of previous awardee',
                'relationship' => $relationship,
                'processed_by' => auth()->id(),
                'remarks' => $this->isSpouseTransfer
                    ? "{$transferee->spouse_first_name} {$transferee->spouse_last_name}"
                    : "{$transferee->dependent_first_name} {$transferee->dependent_last_name}"
            ]);

            DB::commit();
            logger()->info('Transfer completed successfully', [
                'transfer_to' => $this->isSpouseTransfer
                    ? "{$transferee->spouse_first_name} {$transferee->spouse_last_name}"
                    : "{$transferee->dependent_first_name} {$transferee->dependent_last_name}",
                'is_spouse' => $this->isSpouseTransfer
            ]);

            $logger = new ActivityLogs();
            $user = Auth::user();
            $logger->logActivity('Transfer an Awardee', $user);

            session()->flash('message', 'Award successfully transferred to ' .
                ($this->isSpouseTransfer
                    ? "{$transferee->spouse_first_name} {$transferee->spouse_last_name}"
                    : "{$transferee->dependent_first_name} {$transferee->dependent_last_name}"));

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Transfer failed', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'is_spouse' => $this->isSpouseTransfer ?? false
            ]);

            throw $e;
        }
    }
    public function cancelTransfer(): void
    {
        $this->showConfirmationModal = false;
        $this->selectedDependentId = null;
        $this->selectedDependent = null;
    }
    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingRelocationSite(): void
    {
        $this->resetPage();
    }
    public function updatingBarangay(): void
    {
        $this->resetPage();
    }
    public function updatingPurok(): void
    {
        $this->resetPage();
    }
    public function updatingStatus(): void
    {
        $this->resetPage();
    }
    public function resetFilters(): void
    {
        $this->reset([
            'relocation_site',
            'barangay',
            'purok',
            'status',
            'search',
            'startDate',
            'endDate'
        ]);
    }

    public function render()
    {
        $query = Awardee::with([
            'taggedAndValidatedApplicant.applicant.person',
            'relocationLot.address.barangay',
            'relocationLot.address.purok',
            'lotSizeUnit'
        ]);

        // Apply filters
        if ($this->relocation_site) {
            $query->whereHas('relocationLot', function ($q) {
                $q->where('relocation_site_name', 'like', '%' . $this->relocation_site . '%');
            });
        }

        if ($this->lot_number) {
            $query->whereHas('relocationLot', function ($q) {
                $q->where('lot_number', $this->lot_number);
            });
        }

        if ($this->block_identifier) {
            $query->whereHas('relocationLot', function ($q) {
                $q->where('block_identifier', $this->block_identifier);
            });
        }

        if ($this->barangay) {
            $query->whereHas('relocationLot.address.barangay', function ($q) {
                $q->where('name', 'like', '%' . $this->barangay . '%');
            });
        }

        if ($this->purok) {
            $query->whereHas('relocationLot.address.purok', function ($q) {
                $q->where('name', 'like', '%' . $this->purok . '%');
            });
        }

        // Date range filter
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('grant_date', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ]);
        }

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('taggedAndValidatedApplicant.applicant.person', function ($subQuery) {
                    $subQuery->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('relocationLot', function ($subQuery) {
                        $subQuery->where('relocation_site_name', 'like', '%' . $this->search . '%')
                            ->orWhere('lot_number', 'like', '%' . $this->search . '%')
                            ->orWhere('block_identifier', 'like', '%' . $this->search . '%');
                    });
            });
        }

        $awardees = $query->orderBy('created_at', 'desc')->paginate(5);
        $relocationSites = RelocationSite::distinct()->pluck('relocation_site_name');
        $barangays = Barangay::distinct()->pluck('name');

        // Get unique lot numbers and block identifiers
        $lotNumbers = RelocationSite::distinct()->orderBy('lot_number')->pluck('lot_number');
        $blockIdentifiers = RelocationSite::distinct()->orderBy('block_identifier')->pluck('block_identifier');

        // Get puroks based on selected barangay
        $puroks = !empty($this->barangay)
            ? Purok::whereHas('barangay', function ($query) {
                $query->where('name', $this->barangay);
            })->pluck('name')
            : Purok::distinct()->pluck('name');

        return view('livewire.awardee-list', [
            'awardees' => $awardees,
            'relocationSites' => $relocationSites,
            'barangays' => $barangays,
            'puroks' => $puroks,
            'lotNumbers' => $lotNumbers,
            'blockIdentifiers' => $blockIdentifiers,
        ]);
    }
}
