<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\TaggedAndValidatedApplicant;
use Livewire\Component;
use Livewire\WithPagination;

class ApplicantsMasterlist extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';
    // applicant details
    public $first_name, $middle_name, $last_name, $suffix_name, $barangay, $purok, $living_situation, $contact_number, $occupation, $monthly_income, $transaction_type;

    public function render()
    {
        $applicants = Applicant::with([
            'address.purok',      // Load applicant's address with purok
            'address.barangay',   // Load applicant's address with barangay
            'transactionType',    // Load applicant's transaction type
            'taggedAndValidated.livingSituation',    // Load related living situation details
            'taggedAndValidated',
        ])
            ->orderBy('created_at', 'desc')
            ->paginate(10); // You can adjust the number of items per page

        return view('livewire.applicants-masterlist', [
            'applicants' => $applicants
        ]);
    }
}
