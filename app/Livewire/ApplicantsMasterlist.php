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
    public $statusFilter = '';
    public $filterApplicationType = ''; // 'housing', 'shelter', or empty for all
    // applicant details
    public $first_name, $middle_name, $last_name, $suffix_name, $barangay, $purok, $living_situation, $contact_number,
        $occupation, $monthly_income, $transaction_type;

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
            $query->whereHas('applicants', function($query) {
                switch($this->statusFilter) {
                    case 'pending_tagging':
                        $query->where('is_tagged', false);
                        break;
                    case 'tagged':
                        $query->where('is_tagged', true)
                            ->whereDoesntHave('taggedAndValidated.awardees');
                        break;
                    case 'pending_awarding':
                        $query->whereHas('taggedAndValidated.awardees', function($q) {
                            $q->where('has_assigned_relocation_site', true)
                                ->where('is_awarded', false);
                        });
                        break;
                    case 'awarded':
                        $query->whereHas('taggedAndValidated.awardees', function($q) {
                            $q->where('is_awarded', true);
                        });
                        break;
                    case 'blacklisted':
                        $query->whereHas('taggedAndValidated.awardees', function($q) {
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
        $people = $query->orderBy('last_name', 'asc')->paginate(5);

        return view('livewire.applicants-masterlist', [
            'people' => $people
        ]);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterApplicationType']);
    }
}
