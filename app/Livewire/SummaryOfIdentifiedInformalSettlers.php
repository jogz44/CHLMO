<?php

namespace App\Livewire;

use App\Models\TaggedAndValidatedApplicant;
use Livewire\Component;
use Livewire\WithPagination;

class SummaryOfIdentifiedInformalSettlers extends Component
{
    use WithPagination;

    // Search and filters properties
    public $search = '', $filterBarangay = '', $filterPurok = '', $filterLivingSituation = '', $filterCaseSpecification = '';
    // Sorting properties
    public $sortField = 'tagging_date', $sortDirection = 'desc';

    // Reset pagination when search changes
    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    // Sort method
    public function sortBy($field): void
    {
        $this->sortDirection = $this->sortField === $field
            ? ($this->sortDirection === 'asc' ? 'desc' : 'asc')
            : 'asc';
        $this->sortField = $field;
    }
    public function render()
    {
        // Get unique barangays for filter dropdown
        $barangays = TaggedAndValidatedApplicant::whereHas('applicant.address.barangay')
            ->with('applicant.address.barangay')
            ->get()
            ->pluck('applicant.address.barangay.name')
            ->unique()
            ->sort();

        // Get unique puroks for filter dropdown
        $puroks = TaggedAndValidatedApplicant::whereHas('applicant.address.purok')
            ->with('applicant.address.purok')
            ->get()
            ->pluck('applicant.address.purok.name')
            ->unique()
            ->sort();

        // Get unique living situations for filter dropdown
        $livingSituations = TaggedAndValidatedApplicant::whereHas('livingSituation')
            ->with('livingSituation')
            ->get()
            ->pluck('livingSituation.living_situation_description')
            ->unique()
            ->sort();

        // Get unique case specifications for filter dropdown
        $caseSpecifications = TaggedAndValidatedApplicant::whereHas('caseSpecification')
            ->with('caseSpecification')
            ->get()
            ->pluck('caseSpecification.case_specification_name')
            ->unique()
            ->sort();

        // Query with eager loading and filters
        $taggedApplicants = TaggedAndValidatedApplicant::with([
            'applicant.address.barangay',
            'applicant.address.purok',
            'livingSituation',
            'caseSpecification',
            'awardees',
            'dependents',
            'governmentProgram'
        ])
            // Search across multiple fields
            ->where(function($query) {
                $search = '%' . $this->search . '%';
                $query->whereHas('applicant.address.barangay', function($q) use ($search) {
                    $q->where('name', 'LIKE', $search);
                })
                    ->orWhereHas('applicant.address.purok', function($q) use ($search) {
                        $q->where('name', 'LIKE', $search);
                    })
                    ->orWhereHas('livingSituation', function($q) use ($search) {
                        $q->where('living_situation_description', 'LIKE', $search);
                    })
                    ->orWhereHas('caseSpecification', function($q) use ($search) {
                        $q->where('case_specification_name', 'LIKE', $search);
                    })
                    ->orWhere('remarks', 'LIKE', $search)
                    ->orWhere('tagger_name', 'LIKE', $search);
            })
            // Barangay filter
            ->when($this->filterBarangay, function($query) {
                return $query->whereHas('address.barangay', function($q) {
                    $q->where('name', $this->filterBarangay);
                });
            })

            // Purok filter
            ->when($this->filterPurok, function($query) {
                return $query->whereHas('address.purok', function($q) {
                    $q->where('name', $this->filterPurok);
                });
            })

            // Living Situation filter
            ->when($this->filterLivingSituation, function($query) {
                return $query->whereHas('livingSituation', function($q) {
                    $q->where('living_situation_description', $this->filterLivingSituation);
                });
            })

            // Case Specification filter
            ->when($this->filterCaseSpecification, function($query) {
                return $query->whereHas('caseSpecification', function($q) {
                    $q->where('case_specification_name', $this->filterCaseSpecification);
                });
            })

            // Sorting
            ->orderBy($this->sortField, $this->sortDirection)

            // Pagination
            ->paginate(5);

        return view('livewire.summary-of-identified-informal-settlers', [
            'taggedApplicants' => $taggedApplicants,
            'barangays' => $barangays,
            'puroks' => $puroks,
            'livingSituations' => $livingSituations,
            'caseSpecifications' => $caseSpecifications
        ]);
    }
    // Reset all filters
    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'filterBarangay',
            'filterPurok',
            'filterLivingSituation',
            'filterCaseSpecification',
            'sortField',
            'sortDirection'
        ]);
    }
}
