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
    // Search and filter properties
    public $search = '';
    public $filterApplicationType = ''; // 'housing', 'shelter', or empty for all
    // applicant details
    public $first_name, $middle_name, $last_name, $suffix_name, $barangay, $purok, $living_situation, $contact_number,
        $occupation, $monthly_income, $transaction_type;

    public function render()
    {
        $peopleQuery = People::query()
            ->with([
                'applicants' => function ($query) {
                    $query->with([
                        'address.purok',
                        'address.barangay',
                        'transactionType',
                        'taggedAndValidated.livingSituation',
                    ]);
                },
                'shelterApplicants' => function ($query) {
                    $query->with([
                        'originOfRequest',
                    ]);
                }
            ]);

        // Apply search if provided
        if ($this->search) {
            $peopleQuery->where(function ($query) {
                $query->where('first_name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $this->search . '%')
                    ->orWhereHas('applicants', function ($subQuery) {
                        $subQuery->where('applicant_id', $this->search)  // Exact match
                        ->orWhere('applicant_id', 'LIKE', '%' . $this->search . '%');  // Partial match
                    })
                    ->orWhereHas('shelterApplicants', function ($subQuery) {
                        $subQuery->where('profile_no', $this->search)  // Exact match
                        ->orWhere('profile_no', 'LIKE', '%' . $this->search . '%');  // Partial match
                    });
            });
        }

        // Apply application type filter if selected
        if ($this->filterApplicationType) {
            $peopleQuery->where('application_type', $this->filterApplicationType);
        }

        $people = $peopleQuery
            ->orderBy('last_name', 'asc')
            ->paginate(5);

        return view('livewire.applicants-masterlist', [
            'people' => $people
        ]);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterApplicationType']);
    }
}
