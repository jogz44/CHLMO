<?php

namespace App\Livewire;

use App\Livewire\Traits\HandlesPagination;
use App\Models\Applicant;
use App\Models\People;
use App\Models\TaggedAndValidatedApplicant;
use Livewire\Component;

class ApplicantsMasterlist extends Component
{
    use HandlesPagination;
    protected $paginationTheme = 'tailwind';
    // Search and filter properties
    public $search = '';
    public $statusFilter = '';
    public $filterApplicationType = ''; // 'housing', 'shelter', or empty for all
    // applicant details
    public $first_name, $middle_name, $last_name, $suffix_name, $barangay, $purok, $living_situation, $contact_number,
        $occupation, $monthly_income, $transaction_type;

    public $sortField = 'application_date';
    public $sortDirection = 'desc';
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            // Toggle direction if clicking the same column
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function render()
    {
        // Initialize the query builder at the start
        $query = People::query()
            ->with([
                'applicants' => function ($query) {
                    $query->with([
                        'address.purok',
                        'address.barangay',
                        'taggedAndValidated.awardees',
                        'taggedAndValidated.livingSituation',
                    ]);
                },
                'shelterApplicants' => function ($query) {
                    $query->with([
                        'originOfRequest',
                    ]);
                }
            ]);

        // Apply filters
        if ($this->statusFilter) {
            $query->whereHas('applicants', function ($query) {
                switch ($this->statusFilter) {
                    case 'pending_tagging':
                        $query->where('is_tagged', false);
                        break;
                    case 'tagged':
                        $query->where('is_tagged', true)
                            ->whereDoesntHave('taggedAndValidated.awardees');
                        break;
                    case 'pending_awarding':
                        $query->whereHas('taggedAndValidated.awardees', function ($q) {
                            $q->where('has_assigned_relocation_site', true)
                                ->where('is_awarded', false);
                        });
                        break;
                    case 'awarded':
                        $query->whereHas('taggedAndValidated.awardees', function ($q) {
                            $q->where('is_awarded', true);
                        });
                        break;
                    case 'blacklisted':
                        $query->whereHas('taggedAndValidated.awardees', function ($q) {
                            $q->where('is_blacklisted', true);
                        });
                        break;
                }
            });
        }

        // Apply search if provided
        if ($this->search) {
            $searchWords = explode(' ', strtolower($this->search));

            $query->where(function ($query) use ($searchWords) {
                foreach ($searchWords as $word) {
                    $query->where(function ($subQuery) use ($word) {
                        $subQuery->whereRaw('LOWER(first_name) LIKE ?', ["%{$word}%"])
                            ->orWhereRaw('LOWER(middle_name) LIKE ?', ["%{$word}%"])
                            ->orWhereRaw('LOWER(last_name) LIKE ?', ["%{$word}%"])
                            ->orWhereHas('applicants', function ($q) use ($word) {
                                $q->whereRaw('LOWER(applicant_id) LIKE ?', ["%{$word}%"]);
                            })
                            ->orWhereHas('shelterApplicants', function ($q) use ($word) {
                                $q->whereRaw('LOWER(profile_no) LIKE ?', ["%{$word}%"]);
                            });
                    });
                }
            });
        }

        // Apply application type filter if selected
        if ($this->filterApplicationType) {
            $query->where('application_type', $this->filterApplicationType);
        }

        // Get paginated results
        // $people = $query->orderBy('last_name', 'asc')->paginate($this->perPage);
        if (in_array($this->sortField, ['application_date', 'date_request', 'date_applied'])) {
            $direction = $this->sortDirection === 'asc' ? 'asc' : 'desc';

            $query->orderByRaw(
                "CASE
                    WHEN people.application_type = ? THEN (
                        SELECT applicants.date_applied
                        FROM applicants
                        WHERE applicants.person_id = people.id
                        ORDER BY applicants.id DESC
                        LIMIT 1
                    )
                    WHEN people.application_type = ? THEN (
                        SELECT shelter_applicants.date_request
                        FROM shelter_applicants
                        WHERE shelter_applicants.person_id = people.id
                        ORDER BY shelter_applicants.id DESC
                        LIMIT 1
                    )
                    ELSE NULL
                END {$direction}",
                ['Housing Applicant', 'Shelter Applicant']
            );
        } elseif ($this->sortField === 'name') {
            $query->orderBy('last_name', $this->sortDirection);
        } else {
            $query->orderBy('last_name', 'asc');
        }

        $people = $query->paginate($this->perPage);

        return view('livewire.applicants-masterlist', [
            'people' => $people
        ]);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterApplicationType']);
    }
}
