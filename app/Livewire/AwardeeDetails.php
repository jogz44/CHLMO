<?php

namespace App\Livewire;

use App\Models\Awardee;
use App\Models\Barangay;
use App\Models\Blacklist;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
use App\Models\DependentsRelationship;
use App\Models\GovernmentProgram;
use App\Models\LivingSituation;
use App\Models\LivingStatus;
use App\Models\Purok;
use App\Models\Religion;
use App\Models\RoofType;
use App\Models\TransactionType;
use App\Models\Tribe;
use App\Models\WallType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use App\Livewire\Logs\ActivityLogs;
use Livewire\WithFileUploads;

class AwardeeDetails extends Component
{
    use WithFileUploads;

    public Awardee $awardee;
    public $selectedDocument = null;
    public $showEditDocumentsModal = false;
    public $newDocuments = [];
    public $newDocumentNames = [];
    public $existingDocuments = [];
    public $existingDocumentNames = [];
    public $isBlacklistModalOpen = false;
    public $blacklistForm = [
        'date_blacklisted' => '',
        'reason' => '',
        'confirmation_password' => ''
    ];

    protected $rules = [
        'newDocuments.*' => 'required|file|max:20048',
        'newDocumentNames.*' => 'required|string|max:255',
        'existingDocumentNames.*' => 'required|string|max:255'
    ];

    protected $messages = [
        'newDocumentNames.*.required' => 'Document name is required.',
        'existingDocumentNames.*.required' => 'Document name is required.'
    ];

    public function mount($applicantId): void
    {
        $this->awardee = Awardee::with([
            'taggedAndValidatedApplicant.applicant.person',
            'documents',
            'blacklist',
        ])->findOrFail($applicantId);

        $this->blacklistForm['date_blacklisted'] = now()->format('Y-m-d');

        $this->loadExistingDocuments();
    }

    public function loadExistingDocuments(): void
    {
        $documents = $this->awardee->documents()
            ->orderBy('created_at', 'desc')
            ->get();

        $this->existingDocuments = $documents->toArray();
        $this->existingDocumentNames = $documents->pluck('document_name', 'id')->toArray();
    }

    public function updatedNewDocuments(): void
    {
        foreach ($this->newDocuments as $index => $document) {
            if (!isset($this->newDocumentNames[$index])) {
                // Set default name from file name but allow editing
                $this->newDocumentNames[$index] = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
            }
        }
    }

    public function removeNewDocument($index): void
    {
        array_splice($this->newDocuments, $index, 1);
        array_splice($this->newDocumentNames, $index, 1);
        // Re-index arrays to maintain consistency
        $this->newDocuments = array_values($this->newDocuments);
        $this->newDocumentNames = array_values($this->newDocumentNames);
    }

    public function updateDocuments(): void
    {
        $this->validate();

        try {
            // Update existing document names
            foreach ($this->existingDocumentNames as $id => $newName) {
                $this->awardee->documents()
                    ->where('id', $id)
                    ->update(['document_name' => $newName]);
            }

            // Add new documents
            foreach ($this->newDocuments as $index => $document) {
                $path = $document->store('awardee-documents', 'public');

                $this->awardee->documents()->create([
                    'document_name' => $this->newDocumentNames[$index],
                    'file_path' => $path,
                    'file_name' => $document->getClientOriginalName(),
                    'file_type' => $document->getMimeType(),
                    'file_size' => $document->getSize()
                ]);
            }

            $this->showEditDocumentsModal = false;
            $this->reset(['newDocuments', 'newDocumentNames']);
            $this->loadExistingDocuments();

            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Documents updated successfully'
            ]);

        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Error updating documents: ' . $e->getMessage()
            ]);
        }
    }

    public function removeDocument($documentId): void
    {
        try {
            $document = $this->awardee->documents()->findOrFail($documentId);

            // Delete the file from storage
            Storage::delete($document->file_path);

            // Delete the database record
            $document->delete();

            // Remove from local arrays
            unset($this->existingDocuments[$documentId]);
            unset($this->existingDocumentNames[$documentId]);

            // Refresh the documents list
            $this->loadExistingDocuments();

            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Document removed successfully'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Error removing document: ' . $e->getMessage()
            ]);
        }
    }

    public function viewDocument($documentId): void
    {
        $this->selectedDocument = $this->awardee->documents()->findOrFail($documentId);
    }

    public function closeDocumentViewer(): void
    {
        $this->selectedDocument = null;
    }

    public function confirmBlacklist(): void
    {
        $this->validate([
            'blacklistForm.date_blacklisted' => 'required|date',
            'blacklistForm.reason' => 'required|string|max:255',
            'blacklistForm.confirmation_password' => 'required'
        ]);

        if (!Hash::check($this->blacklistForm['confirmation_password'], Auth::user()->password)) {
            $this->addError('blacklistForm.confirmation_password', 'Incorrect password');
            return;
        }

        $this->awardee->blacklist()->create([
            'user_id' => Auth::id(),
            'date_blacklisted' => $this->blacklistForm['date_blacklisted'],
            'blacklist_reason_description' => $this->blacklistForm['reason'],
            'updated_by' => Auth::user()->full_name
        ]);

        $this->awardee->update(['is_blacklisted' => true]);

        $logger = new ActivityLogs();
        $logger->logActivity('Blacklisted an Awardee', Auth::user());

        $this->isBlacklistModalOpen = false;
        $this->dispatch('alert', [
            'type' => 'success',
            'title' => 'Awardee Blacklisted',
            'message' => 'The awardee has been successfully blacklisted.'
        ]);

        $this->redirect(route('awardee-details', ['applicantId' => $this->awardee->id]));
    }

    public function render()
    {
        return view('livewire.awardee-details', [
            'documents' => $this->awardee->documents()
                ->orderBy('created_at', 'desc')
                ->get(),
            'applicant' => $this->awardee->taggedAndValidatedApplicant->applicant
        ])->layout('layouts.app');
    }
}
