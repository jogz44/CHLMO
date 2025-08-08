<?php

namespace App\Livewire;

use App\Exports\ApplicantsDataExport;
use App\Exports\MasterlistOfActualOccupantsDataExport;
use App\Models\Barangay;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
use App\Models\LivingSituation;
use App\Models\LivingStatus;
use App\Models\Purok;
use App\Models\TaggedAndValidatedApplicant;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class MasterlistOfActualOccupants extends Component
{
    use WithPagination;

    public $barangays, $puroks, $civilStatuses, $livingSituations, $livingStatuses, $caseSpecifications, $livingSituationCaseSpecifications;
    public $sortField = 'last_name';  // default sort field
    public $sortDirection = 'asc';    // default sort direction
    public $availablePuroks = [];
    // Search and filter properties
    public $search = '';
    public $filters = [
        'barangay' => '',
        'purok' => '',
        'civil_status' => '',
        'living_situation' => '',
        'case_specification' => '',
        'living_situation_case_specification' => '',
        'living_status' => '',
        'income_range' => '',
        'age_range' => '',
    ];
    // For income range filter
    public $incomeRanges = [
        '' => 'All Income Ranges',
        '0-10000' => '₱0 - ₱10,000',
        '10001-20000' => '₱10,001 - ₱20,000',
        '20001-30000' => '₱20,001 - ₱30,000',
        '30001-up' => '₱30,001 and above'
    ];

    // For age range filter
    public $ageRanges = [
        '' => 'All Ages',
        '18-30' => '18-30 years',
        '31-45' => '31-45 years',
        '46-60' => '46-60 years',
        '60-up' => '60+ years'
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'filters' => ['except' => [
            'barangay' => '',
            'purok' => '',
            'civil_status' => '',
            'living_situation' => '',
            'case_specification' => '',
            'living_situation_case_specification' => '',
            'living_status' => '',
            'income_range' => '',
            'age_range' => '',
        ]],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingFilters(): void
    {
        $this->resetPage();
    }
    public function resetFilters(): void
    {
        $this->reset('filters', 'search');
        $this->resetPage();
    }

    public function mount()
    {
        $this->barangays = Barangay::orderBy('name')->get();
        // Remove the puroks initialization since we'll load them dynamically
        $this->civilStatuses = CivilStatus::all();
        $this->livingSituations = LivingSituation::all();
        $this->livingStatuses = LivingStatus::all();
        $this->caseSpecifications = CaseSpecification::all();

        // Initialize puroks if barangay is already selected
        if ($this->filters['barangay']) {
            $this->updateAvailablePuroks();
        }
    }

    // Add method to update available puroks
    public function updatedFiltersBarangay(): void
    {
        $this->updateAvailablePuroks();
        // Reset purok filter when barangay changes
        $this->filters['purok'] = '';
    }

    protected function updateAvailablePuroks(): void
    {
        if ($this->filters['barangay']) {
            $barangay = Barangay::where('name', $this->filters['barangay'])->first();
            if ($barangay) {
                $this->availablePuroks = Purok::where('barangay_id', $barangay->id)
                    ->orderBy('name')
                    ->pluck('name')
                    ->toArray();
            }
        } else {
            $this->availablePuroks = [];
        }
    }
    // In your Livewire component
    public function getLivingSituationSpecifications(): array
    {
        $specifications = TaggedAndValidatedApplicant::whereNotNull('living_situation_case_specification')
            ->distinct()
            ->pluck('living_situation_case_specification')
            ->toArray();

        // Start with "No Specification" option
        $options = ['no_specification' => 'No Specification'];

        // Add existing specifications from database
        foreach ($specifications as $spec) {
            $options[$spec] = $spec;
        }

        return $options;
    }

    protected function getFilteredQuery()
    {
        $query = TaggedAndValidatedApplicant::query()
            ->with([
                'applicant.person',
                'applicant.address.barangay',
                'applicant.address.purok',
                'civilStatus',
                'spouse',
                'liveInPartner',
                'dependents',
                'livingSituation',
                'caseSpecification',
                'livingStatus'
            ])
            ->join('applicants', 'tagged_and_validated_applicants.applicant_id', '=', 'applicants.id')
            ->join('people', 'applicants.person_id', '=', 'people.id')
            ->select('tagged_and_validated_applicants.*')
            ->orderBy('people.last_name', $this->sortDirection);

        // Apply existing search logic
        if ($this->search) {
            $keywords = preg_split('/\s+/', trim($this->search)); // Split search into words

            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $like = '%' . $word . '%';
                    $q->where(function ($subQ) use ($like) {
                        $subQ->orWhere('people.first_name', 'like', $like)
                            ->orWhere('people.middle_name', 'like', $like)
                            ->orWhere('people.last_name', 'like', $like)
                            ->orWhere(DB::raw("CONCAT(people.first_name, ' ', people.last_name)"), 'like', $like)
                            ->orWhere(DB::raw("CONCAT(people.last_name, ' ', people.first_name)"), 'like', $like)
                            ->orWhere(DB::raw("CONCAT(people.first_name, ' ', people.middle_name, ' ', people.last_name)"), 'like', $like);
                    });
                }
            });
        }


        // Apply existing filters...
        if ($this->filters['barangay']) {
            $query->whereHas('applicant.address.barangay', function ($q) {
                $q->where('name', $this->filters['barangay']);
            });
        }

        if ($this->filters['purok']) {
            $query->whereHas('applicant.address.purok', function ($q) {
                $q->where('name', $this->filters['purok']);
            });
        }

        if ($this->filters['civil_status']) {
            $query->where('civil_status_id', $this->filters['civil_status']);
        }

        if ($this->filters['living_situation']) {
            $query->where('living_situation_id', $this->filters['living_situation']);
        }

        if ($this->filters['living_situation_case_specification']) {
            if ($this->filters['living_situation_case_specification'] === 'no_specification') {
                $query->whereNull('living_situation_case_specification');
            } else {
                $query->where('living_situation_case_specification', $this->filters['living_situation_case_specification']);
            }
        }

        if ($this->filters['living_status']) {
            $query->where('living_status_id', $this->filters['living_status']);
        }

        if ($this->filters['case_specification']) {
            $query->where('case_specification_id', $this->filters['case_specification']);
        }

        // Income range filter
        if ($this->filters['income_range']) {
            [$min, $max] = explode('-', $this->filters['income_range']);
            if ($max === 'up') {
                $query->where('monthly_income', '>', (int)$min);
            } else {
                $query->whereBetween('monthly_income', [(int)$min, (int)$max]);
            }
        }

        // Age range filter
        if ($this->filters['age_range']) {
            [$minAge, $maxAge] = explode('-', $this->filters['age_range']);
            $query->whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) >= ?', [(int)$minAge])
                ->when($maxAge !== 'up', function($q) use ($maxAge) {
                    $q->whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) <= ?', [(int)$maxAge]);
                });
        }

        return $query;
    }

    public function sortBy($field)
    {
        // If clicking the same field, toggle direction
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    // Add this export method
    public function export()
    {
        try {
            // Prepare the filters from the component's state
            $filters = array_filter([
                'barangay' => $this->filters['barangay'],
                'purok' => $this->filters['purok'],
                'civil_status' => $this->filters['civil_status'],
                'living_situation' => $this->filters['living_situation'],
                'case_specification' => $this->filters['case_specification'],
                'living_situation_case_specification' => $this->filters['living_situation_case_specification'],
                'living_status' => $this->filters['living_status'],
                'income_range' => $this->filters['income_range'],
                'age_range' => $this->filters['age_range'],
                'search' => $this->search,
            ]);

            // Generate a dynamic filename
            $fileName = 'masterlist_of_actual_occupants_' . now()->format('Y_m_d_His') . '.xlsx';

            // Use the filters to create an export instance and download
            return Excel::download(
                new MasterlistOfActualOccupantsDataExport($filters),
                $fileName
            );
        } catch (\Exception $e) {
            \Log::error('Export error: ' . $e->getMessage());

            // Dispatch a browser alert with Livewire for user feedback
            $this->dispatch('alert', [
                'title' => 'Export Failed',
                'message' => 'An error occurred while exporting the data. Please try again later.',
                'type' => 'error',
            ]);

            return null;
        }
    }

    public function render()
    {
        $query = $this->getFilteredQuery();
        $applicants = $query->paginate(5);

        return view('livewire.masterlist-of-actual-occupants', [
            'applicants' => $applicants,
        ]);
    }
}
