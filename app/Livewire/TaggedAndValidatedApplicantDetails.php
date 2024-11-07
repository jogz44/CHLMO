<?php

namespace App\Livewire;

use App\Models\TaggedAndValidatedApplicant;
use Livewire\Component;

class TaggedAndValidatedApplicantDetails extends Component
{
    public $isEditing = false, $isLoading = false;

    public function mount($taggedAndValidatedApplicantId): void
    {
        $this->taggedAndValidatedApplicant = TaggedAndValidatedApplicant::with([
            'applicant.transactionType',
            'civilStatus',
            'tribe',
            'religion',
            'livingSituation',
            'caseSpecification',
            'governmentProgram',
            'livingStatus',
            'roofType',
            'wallType',
            'spouse',
            'liveInPartner',
            'dependents',
            'address.purok',
            'address.barangay',
        ])->findOrFail($taggedAndValidatedApplicantId);
    }
    public function toggleEdit(): void
    {
        $this->isEditing = !$this->isEditing;
        if (!$this->isEditing) {
            $this->loadFormData(); // Reset form data if canceling edit
        }
    }
    public function render()
    {
        return view('livewire.tagged-and-validated-applicant-details');
    }
}
