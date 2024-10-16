<?php

namespace App\Livewire;

use App\Models\TaggedAndValidatedApplicant;
use Livewire\Component;
use Livewire\WithFileUploads;


class ApplicantsViaRequest extends Component
{
    public $taggedAndValidatedApplicants;

    // Tagged and validated applicant details
    public $first_name, $middle_name, $last_name, $suffix_name, $barangay, $purok, $living_situation, $contact_number, $occupation, $monthly_income, $transaction_type;

    public function mount()
    {
        // Fetch all tagged and validated applicants with related data
        $this->taggedAndValidatedApplicants = TaggedAndValidatedApplicant::with([
            'applicant.address.purok',      // Load applicant's address with purok
            'applicant.address.barangay',   // Load applicant's address with barangay
            'applicant.transactionType',    // Load applicant's transaction type
            'livingSituation',             // Load related living situation details
        ])->get();
    }

    public function render()
    {
        return view('livewire.applicants-via-request', [
            'taggedAndValidatedApplicants' => $this->taggedAndValidatedApplicants
        ]);
    }
}
