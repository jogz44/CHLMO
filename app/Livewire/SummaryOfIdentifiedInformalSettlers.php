<?php

namespace App\Livewire;

use App\Exports\ApplicantsDataExport;
use App\Exports\SummaryOfIdentifiedInformalSettlersDataExport;
use App\Models\Address;
use App\Models\Barangay;
use App\Models\CaseSpecification;
use App\Models\LivingSituation;
use App\Models\Purok;
use App\Models\RelocationSite;
use App\Models\TaggedAndValidatedApplicant;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class SummaryOfIdentifiedInformalSettlers extends Component
{
    use WithPagination;

    // Constants
    const DANGER_ZONE_ID = 8;

    // Search and filters properties
    public $search = '', $filterBarangay = '', $filterPurok = '', $filterLivingSituation = '', $filterCaseSpecification = '',
        $filterAssignedRelocationSite, $filterActualRelocationSite, $startDate, $endDate;

    // Add property to store available puroks for selected barangay
    public $availablePuroks = [];

    // Sorting properties
    public $sortField = 'tagging_date', $sortDirection = 'desc';

    // Cache for filter options
    protected $filterOptions = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'filterBarangay' => ['except' => ''],
        'filterPurok' => ['except' => ''],
        'filterLivingSituation' => ['except' => ''],
        'filterCaseSpecification' => ['except' => ''],
        'sortField' => ['except' => 'tagging_date'],
        'sortDirection' => ['except' => 'desc'],
        'page' => ['except' => 1],
    ];

    public function mount(): void
    {
        if ($this->filterBarangay) {
            $this->updateAvailablePuroks();
        }
    }

    // Add method to update available puroks based on selected barangay
    public function updateAvailablePuroks()
    {
        if ($this->filterBarangay) {
            $this->availablePuroks = Purok::join('addresses', 'puroks.id', '=', 'addresses.purok_id')
                ->join('barangays', 'addresses.barangay_id', '=', 'barangays.id')
                ->where('barangays.name', $this->filterBarangay)
                ->pluck('puroks.name')
                ->unique()
                ->sort()
                ->values()
                ->toArray();

            // Reset purok filter if selected purok is not in the available puroks
            if (!in_array($this->filterPurok, $this->availablePuroks)) {
                $this->filterPurok = '';
            }
        } else {
            $this->availablePuroks = [];
            $this->filterPurok = '';
        }

    }

    // Reset pagination when search changes
    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    // Modify updatingFilterBarangay to update available puroks
    public function updatingFilterBarangay($value): void
    {
        $this->resetPage();
        $this->filterPurok = ''; // Reset purok when barangay changes
    }

    public function updatedFilterBarangay(): void
    {
        if ($this->filterBarangay) {
            $barangay = Barangay::where('name', $this->filterBarangay)->first();

            if ($barangay) {
                // Get puroks directly through the barangay relationship
                $this->availablePuroks = Purok::where('barangay_id', $barangay->id)
                    ->pluck('name')
                    ->toArray();

                // Debug logging
                logger('Query Results:', [
                    'barangay' => $this->filterBarangay,
                    'barangay_id' => $barangay->id,
                    'found_puroks' => $this->availablePuroks
                ]);
            }
        } else {
            $this->availablePuroks = [];
        }

        $this->filterPurok = '';
    }

    public function updatingFilterPurok(): void
    {
        $this->resetPage();
    }
    public function updatingFilterLivingSituation(): void
    {
        $this->resetPage();
    }
    public function updatingFilterCaseSpecification(): void
    {
        $this->resetPage();
    }
    // Sort method
    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? ($this->sortDirection === 'asc' ? 'desc' : 'asc')
            : 'asc';
        $this->sortField = $field;
    }
    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'filterBarangay',
            'filterPurok',
            'filterLivingSituation',
            'filterCaseSpecification',
            'filterAssignedRelocationSite',
            'filterActualRelocationSite',
            'startDate',
            'endDate',
            'sortField',
            'sortDirection'
        ]);
        $this->resetPage();
    }
    public function export()
    {
        try {
            $filters = array_filter([
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'filterBarangay' => $this->filterBarangay,
                'filterPurok' => $this->filterPurok,
                'filterLivingSituation' => $this->filterLivingSituation,
                'filterCaseSpecification' => $this->filterCaseSpecification,
                'filterAssignedRelocationSite' => $this->filterAssignedRelocationSite,
                'filterActualRelocationSite' => $this->filterActualRelocationSite // Add this new filter
            ]);

            return Excel::download(
                new SummaryOfIdentifiedInformalSettlersDataExport($filters),
                'summary-of-identified-informal-settlers-' . now()->format('Y-m-d') . '.xlsx'
            );
        } catch (\Exception $e) {
            \Log::error('Export error: ' . $e->getMessage());
            $this->dispatch('alert', [
                'title' => 'Export failed: ',
                'message' => $e->getMessage() . '<br><small>'. now()->calendar() .'</small>',
                'type' => 'danger'
            ]);
            return null;
        }
    }

    public function render()
    {
        $query = TaggedAndValidatedApplicant::query()
            ->select([
                'tagged_and_validated_applicants.tagging_date',
                'barangays.name as barangay',
                'puroks.name as purok',
                'living_situations.living_situation_description as living_situation',
                DB::raw('CASE
                    WHEN tagged_and_validated_applicants.living_situation_id = ' . self::DANGER_ZONE_ID . '
                    THEN case_specifications.case_specification_name
                    ELSE tagged_and_validated_applicants.living_situation_case_specification
                END as case_specification'),
                'assigned_relocation_sites.relocation_site_name as assigned_relocation_site',
                DB::raw('COUNT(DISTINCT tagged_and_validated_applicants.id) as occupants_count'),
                DB::raw('COUNT(DISTINCT awardees.id) as awarded_count'),
                DB::raw('GROUP_CONCAT(DISTINCT actual_relocation_sites.relocation_site_name SEPARATOR ", ") as actual_relocation_sites')
            ])
            ->join('applicants', 'tagged_and_validated_applicants.applicant_id', '=', 'applicants.id')
            ->join('addresses', 'applicants.address_id', '=', 'addresses.id')
            ->join('barangays', 'addresses.barangay_id', '=', 'barangays.id')
            ->join('puroks', 'addresses.purok_id', '=', 'puroks.id')
            ->join('living_situations', 'tagged_and_validated_applicants.living_situation_id', '=', 'living_situations.id')
            ->leftJoin('case_specifications', function ($join) {
                $join->on('tagged_and_validated_applicants.case_specification_id', '=', 'case_specifications.id')
                    ->where('tagged_and_validated_applicants.living_situation_id', '=', self::DANGER_ZONE_ID);
            })
            ->leftJoin('awardees', 'tagged_and_validated_applicants.id', '=', 'awardees.tagged_and_validated_applicant_id')
            ->leftJoin('relocation_sites as assigned_relocation_sites', 'awardees.assigned_relocation_site_id', '=', 'assigned_relocation_sites.id')
            ->leftJoin('relocation_sites as actual_relocation_sites', 'awardees.actual_relocation_site_id', '=', 'actual_relocation_sites.id');

        // 🔍 Flexible Search Filter
        if (!empty($this->search)) {
            $words = preg_split('/\s+/', trim($this->search));

            $query->where(function ($q) use ($words) {
                foreach ($words as $word) {
                    $like = '%' . $word . '%';
                    $q->where(function ($subQ) use ($like) {
                        $subQ->orWhere('barangays.name', 'like', $like)
                            ->orWhere('puroks.name', 'like', $like)
                            ->orWhere('living_situations.living_situation_description', 'like', $like)
                            ->orWhere('tagged_and_validated_applicants.living_situation_case_specification', 'like', $like)
                            ->orWhere('case_specifications.case_specification_name', 'like', $like)
                            ->orWhere('assigned_relocation_sites.relocation_site_name', 'like', $like)
                            ->orWhere(DB::raw("DATE_FORMAT(tagged_and_validated_applicants.tagging_date, '%M %d, %Y')"), 'like', $like);
                    });
                }
            });
        }

        // Apply filters
        if ($this->filterBarangay) {
            $query->where('barangays.name', $this->filterBarangay);
        }

        if ($this->filterPurok) {
            $query->where('puroks.name', $this->filterPurok);
        }

        if ($this->filterLivingSituation) {
            $query->where('living_situations.living_situation_description', $this->filterLivingSituation);
        }

        if ($this->filterCaseSpecification) {
            $query->where(function ($q) {
                $q->where(function ($subQ) {
                    $subQ->where('tagged_and_validated_applicants.living_situation_id', self::DANGER_ZONE_ID)
                        ->where('case_specifications.case_specification_name', $this->filterCaseSpecification);
                })->orWhere(function ($subQ) {
                    $subQ->where('tagged_and_validated_applicants.living_situation_id', '!=', self::DANGER_ZONE_ID)
                        ->where('tagged_and_validated_applicants.living_situation_case_specification', $this->filterCaseSpecification);
                });
            });
        }

        // Date Range Filter
        if ($this->startDate) {
            $query->where('tagged_and_validated_applicants.tagging_date', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->where('tagged_and_validated_applicants.tagging_date', '<=', $this->endDate);
        }

        $relocationSites = RelocationSite::all();

        $actualRelocationSites = RelocationSite::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('awardees')
                ->whereColumn('awardees.actual_relocation_site_id', 'relocation_sites.id')
                ->whereNotNull('actual_relocation_site_id');
        })->get();

        if ($this->filterAssignedRelocationSite) {
            $query->where('assigned_relocation_sites.relocation_site_name', $this->filterAssignedRelocationSite);
        }

        if ($this->filterActualRelocationSite) {
            $query->whereExists(function ($subquery) {
                $subquery->select(DB::raw(1))
                    ->from('awardees as a')
                    ->join('relocation_sites as rs', 'a.actual_relocation_site_id', '=', 'rs.id')
                    ->whereColumn('a.tagged_and_validated_applicant_id', 'tagged_and_validated_applicants.id')
                    ->where('rs.relocation_site_name', $this->filterActualRelocationSite);
            });
        }

        if (empty($this->filterOptions)) {
            $this->filterOptions = [
                'barangays' => Barangay::pluck('name')->unique()->sort()->values(),
                'puroks' => Purok::pluck('name')->unique()->sort()->values(),
                'livingSituations' => LivingSituation::pluck('living_situation_description')->unique()->sort()->values(),
                'caseSpecifications' => collect([
                    CaseSpecification::pluck('case_specification_name'),
                    TaggedAndValidatedApplicant::where('living_situation_id', '!=', self::DANGER_ZONE_ID)
                        ->whereNotNull('living_situation_case_specification')
                        ->pluck('living_situation_case_specification')
                ])->flatten()->unique()->sort()->values(),
                'relocationSites' => RelocationSite::all(),
            ];
        }

        $totalsQuery = (clone $query);
        $totals = $totalsQuery->select([
            DB::raw('COUNT(DISTINCT tagged_and_validated_applicants.id) as total_occupants'),
            DB::raw('COUNT(DISTINCT awardees.id) as total_awarded')
        ])->first();

        $grandTotals = (clone $query)->select([
            DB::raw('COUNT(DISTINCT tagged_and_validated_applicants.id) as total_occupants'),
            DB::raw('COUNT(DISTINCT awardees.id) as total_awarded'),
            DB::raw('COUNT(DISTINCT CASE WHEN awardees.id IS NULL THEN tagged_and_validated_applicants.id END) as total_pending')
        ])->first();

        $query->groupBy([
            'tagged_and_validated_applicants.tagging_date',
            'barangays.name',
            'puroks.name',
            'living_situations.living_situation_description',
            DB::raw('CASE
                WHEN tagged_and_validated_applicants.living_situation_id = ' . self::DANGER_ZONE_ID . '
                THEN case_specifications.case_specification_name
                ELSE tagged_and_validated_applicants.living_situation_case_specification
            END'),
            'assigned_relocation_sites.relocation_site_name'
        ]);

        if ($this->sortField === 'occupants_count' || $this->sortField === 'awarded_count') {
            $query->orderBy(DB::raw($this->sortField), $this->sortDirection);
        } else {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        $groupedApplicants = $query->paginate(5);

        return view('livewire.summary-of-identified-informal-settlers', [
            'groupedApplicants' => $groupedApplicants,
            'totals' => $totals,
            'grandTotals' => $grandTotals,
            'barangays' => $this->filterOptions['barangays'],
            'puroks' => $this->availablePuroks,
            'livingSituations' => $this->filterOptions['livingSituations'],
            'caseSpecifications' => $this->filterOptions['caseSpecifications'],
            'relocationSites' => $relocationSites,
            'actualRelocationSites' => $actualRelocationSites,
        ]);
    }
}
