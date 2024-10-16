<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\TaggedAndValidatedApplicant;
use Livewire\Component;

class ApplicantsMasterlist extends Component
{
    public $applicants;

    // applicant details
    public $first_name, $middle_name, $last_name, $suffix_name, $barangay, $purok, $living_situation, $contact_number, $occupation, $monthly_income, $transaction_type;

    public function mount()
    {
        // Fetch all tagged and validated applicants with related data
        $this->applicants = Applicant::with([
            'address.purok',      // Load applicant's address with purok
            'address.barangay',   // Load applicant's address with barangay
            'transactionType',    // Load applicant's transaction type
            'taggedAndValidated.livingSituation',    // Load related living situation details
        ])->get();
    }
    public function render()
    {
        return view('livewire.applicants-masterlist', [
            'applicants' => $this->applicants
        ]);
    }
}
