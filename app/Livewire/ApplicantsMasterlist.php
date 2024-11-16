<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\People;
use App\Models\TaggedAndValidatedApplicant;
use Livewire\Component;
use Livewire\WithPagination;

class ApplicantsMasterlist extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';
    // applicant details
    public $first_name, $middle_name, $last_name, $suffix_name, $barangay, $purok, $living_situation, $contact_number,
        $occupation, $monthly_income, $transaction_type;

    public function render()
    {
        $people = People::with([
            'applicants.address.purok',
            'applicants.address.barangay',
            'applicants.transactionType',
            'applicants.taggedAndValidated.livingSituation',
            'applicants.taggedAndValidated',
        ])
            ->orderBy('created_at', 'desc')
            ->paginate(5); // Pagination applies to $people

        return view('livewire.applicants-masterlist', [
            'people' => $people // Pass the paginated $people variable
        ]);
    }
}
