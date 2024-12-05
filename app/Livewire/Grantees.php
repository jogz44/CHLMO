<?php

namespace App\Livewire;

use App\Models\GovernmentProgram;
use App\Models\Shelter\Grantee;
use App\Models\Barangay;
use App\Models\Purok;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Shelter\OriginOfRequest;
use App\Exports\GranteesDataExport;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Collection\Collection;
use Illuminate\Support\Carbon;

class Grantees extends Component
{
    use WithPagination;
    public $search = '';
    public $startGrantingDate, $endGrantingDate;
    public $profileNo;
    public $date_request;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $suffix_name;
    public $request_origin_id;
    public $origin_name;
    public $date_of_delivery;
    public $date_tagged;
    public $selectedOriginOfRequest;
    public $grantee_quantity;

    public $address;
    public $contact_number;
    public $government_program_id;
    public $governmentPrograms;
    public $remarks;
    public $spouse_first_name, $spouse_middle_name, $spouse_last_name;
    public $selectedGovernmentProgram;
    public $applicantForSpouse;
    public $house_no_street;

    public $selectedPurok_id, $puroksFilter = [], $selectedBarangay_id, $barangaysFilter = [], $barangay_id, $barangays = [], $purok_id, $puroks = [];
    public $governmentProgramsFilter = [];
    public $isLoading = false;

    public function mount()
    {
        $this->date_request = now()->toDateString(); 
        $this->date_of_delivery = now()->toDateString();
        $this->date_tagged = now()->toDateString();
        $this->startGrantingDate = null;
        $this->endGrantingDate = null;
        $this->search = ''; // Ensure search is empty initially


        $this->barangays = Barangay::all();
        $this->puroks = Purok::all();
        $this->governmentPrograms = GovernmentProgram::all();

        // Initialize filter options
        $this->puroksFilter = Cache::remember('puroks', 60*60, function() {
            return Purok::all();
        });
        $this->barangaysFilter = Cache::remember('barangays', 60*60, function() {
            return Barangay::all();
        });
        $this->governmentProgramsFilter = Cache::remember('governmentPrograms', 60*60, function() {
            return GovernmentProgram::all();
        });
    }
    public function updatedBarangayId($barangayId): void
    {
        // Fetch the puroks based on the selected barangay
        $this->puroks = Purok::where('barangay_id', $barangayId)->get();
        $this->purok_id = null; // Reset selected purok when barangay changes
        $this->isLoading = false; // Reset loading state
        logger()->info('Retrieved Puroks', [
            'barangay_id' => $barangayId,
            'puroks' => $this->puroks
        ]);
    }
    public function updatedSelectedBarangayId($barangayId)
    {
        // Fetch the puroks based on the selected barangay
        $this->puroksFilter = Purok::where('barangay_id', $barangayId)->get();
        $this->selectedPurok_id = null; // Reset selected purok when barangay changes
        $this->isLoading = false; // Reset loading state
        logger()->info('Retrieved Puroks', [
            'selectedBarangay_id' => $barangayId,
            'puroksFilter' => $this->puroksFilter
        ]);
    }
    // Reset pagination when search changes
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    // Clear search input
    public function clearSearch()
    {
        $this->search = '';
    }

 // Reset filters
 public function resetFilters()
 {
     $this->startGrantingDate = null;
     $this->selectedPurok_id = null;
     $this->selectedBarangay_id = null;
     $this->endGrantingDate = null;
     $this->search = '';
     $this->selectedOriginOfRequest = null;
     $this->resetPage();
 }

 // Triggered when search or other filters are updated
 public function updatedSearch()
 {
     $this->resetPage();
 }

 //  export method
    public function export()
    {
        try {
            $filters = array_filter([
                'start_date' => $this->startGrantingDate,
                'end_date' => $this->endGrantingDate,
                'barangay_id' => $this->selectedBarangay_id,
                'purok_id' => $this->selectedPurok_id,
                'request_origin_id' => $this->selectedOriginOfRequest,
            ]);

            // Debug logging
        Log::info('Export Filters', $filters);

            return Excel::download(
                new GranteesDataExport($filters),
                'grantees-' . now()->format('Y-m-d') . '.xlsx'
            );
        } catch (\Exception $e) {
            Log::error('Export error: ' . $e->getMessage());
            $this->dispatch('alert', [
                'title' => 'Export failed: ',
                'message' => $e->getMessage(),
                'type' => 'danger',
            ]);
        }
    }

 public function render()
{
    $query = Grantee::with([
        'originOfRequest', 
        'profiledTaggedApplicant.shelterApplicant.person',
        'profiledTaggedApplicant.shelterApplicant.originOfRequest',
        'profiledTaggedApplicant.governmentProgram', // Make sure the governmentProgram relationship is defined here
        'profiledTaggedApplicant.shelterApplicant.address.purok', // Correct path for address.purok
        'profiledTaggedApplicant.shelterApplicant.address.barangay', // Correct path for address.barangay
        'profiledTaggedApplicant.shelterSpouse' // Correct path for shelterSpouse
    ])
    ->where(function($query) {
        // Search within shelterApplicant's person relationship
        $query->whereHas('profiledTaggedApplicant.shelterApplicant.person', function($q) {
            $q->where('first_name', 'like', '%'.$this->search.'%')
                ->orWhere('middle_name', 'like', '%'.$this->search.'%')
                ->orWhere('last_name', 'like', '%'.$this->search.'%');
        })
        // Search within shelterApplicant's own fields
        ->orWhereHas('profiledTaggedApplicant.shelterApplicant', function($q) {
            $q->where('request_origin_id', 'like', '%'.$this->search.'%')
                ->orWhere('profile_no', 'like', '%'.$this->search.'%')
                ->orWhere('contact_number', 'like', '%'.$this->search.'%')
                ->orWhere('full_address', 'like', '%'.$this->search.'%');
        })
        ->orWhereHas('profiledTaggedApplicant.shelterApplicant.originOfRequest', function ($q) {
            $q->where('name', 'like', '%'.$this->search.'%');
        })
        ->orWhereHas('profiledTaggedApplicant.governmentProgram', function ($q) {
            $q->where('program_name', 'like', '%'.$this->search.'%');
        })
        ->orWhereHas('profiledTaggedApplicant.shelterApplicant.address.purok', function ($q) {
            $q->where('name', 'like', '%'.$this->search.'%');
        })
        ->orWhereHas('profiledTaggedApplicant.shelterApplicant.address.barangay', function ($q) {
            $q->where('name', 'like', '%'.$this->search.'%');
        });
    });

    // Apply date range filter
    if ($this->startGrantingDate && $this->endGrantingDate) {
        $query->whereBetween('date_of_delivery', [$this->startGrantingDate, $this->endGrantingDate]);
    }

    // Apply filters for related fields
    if ($this->selectedOriginOfRequest) {
        $query->whereHas('profiledTaggedApplicant.shelterApplicant.originOfRequest', function ($q) {
            $q->where('id', $this->selectedOriginOfRequest);
        });
    }

    if ($this->selectedGovernmentProgram) {
        $query->whereHas('profiledTaggedApplicant.governmentProgram', function ($q) {
            $q->where('id', $this->selectedGovernmentProgram);
        });
    }

    if ($this->selectedPurok_id) {
        $query->whereHas('profiledTaggedApplicant.shelterApplicant.address.purok', function ($q) {
            $q->where('id', $this->selectedPurok_id);
        });
    }

    if ($this->selectedBarangay_id) {
        $query->whereHas('profiledTaggedApplicant.shelterApplicant.address.barangay', function ($q) {
            $q->where('id', $this->selectedBarangay_id);
        });
    }

    $OriginOfRequests = OriginOfRequest::all();
    $GovernmentPrograms = GovernmentProgram::all();

    $grantees = $query->orderBy('date_of_delivery', 'desc')->paginate(5);

    return view('livewire.grantees', [
        'grantees' => $grantees,
        'OriginOfRequests' => $OriginOfRequests,
        'GovernmentPrograms' => $GovernmentPrograms,
        'puroks' => $this->puroks,
        'barangays' => $this->barangays,
        'puroksFilter' => $this->puroksFilter
    ]);
}

 
}
