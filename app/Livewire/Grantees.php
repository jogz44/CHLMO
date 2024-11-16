<?php

namespace App\Livewire;

use App\Models\GovernmentProgram;
use App\Models\Shelter\Grantee;
use App\Models\Barangay;
use App\Models\Purok;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Shelter\OriginOfRequest;
use Illuminate\Support\Facades\Cache;

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
            return Barangay::all();
        });
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

    public function render()
    {
        $query = Grantee::query();

        // Apply search conditions if there is a search term
        $query->when($this->search, function ($query) {
            return $query->where(function ($query) {
                $query->where('profile_no', 'like', '%' . $this->search . '%')
                    ->orWhereHas('profiledTaggedApplicant.shelterApplicant', function ($query) {
                        $query->where('first_name', 'like', '%' . $this->search . '%')
                            ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                            ->orWhere('last_name', 'like', '%' . $this->search . '%')
                            ->orWhere('contact_number', 'like', '%' . $this->search . '%')
                            ->orWhere('address.full_address', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('shelterApplicant.originOfRequest', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas(' shelterApplicant.governmentProgram', function ($query) {
                        $query->where('program_name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('shelterApplicant.address.purok', function ($query) {
                        $query->where('name', 'like', '%'.$this->search.'%');
                    })
                    ->orWhereHas('shelterApplicant.address.barangay', function ($query) {
                        $query->where('name', 'like', '%'.$this->search.'%');
                    });
            });
        });        
        $query = $query->with(['shelterApplicant', 'originOfRequest', 'material', 'governmentProgram']);
        $query = $query->with(['profiledTaggedApplicant']);
        $query = $query->with(['profiledTaggedApplicant.barangay', 'profiledTaggedApplicant.purok']);
        
       // Apply date range filter (if both dates are present)
       if ($this->startGrantingDate && $this->endGrantingDate) {
        $query->whereBetween('date_of_delivery', [$this->startGrantingDate, $this->endGrantingDate]);
    }
    if ($this->selectedOriginOfRequest) {
        $query->whereHas('profiledTaggedApplicant.shelterApplicant.originOfRequest', function ($query) {
            $query->where('id', $this->selectedOriginOfRequest);
        });
    }
    if ($this->selectedGovernmentProgram) {
        $query->whereHas('profiledTaggedApplicant.shelterApplicant.governmentProgram', function ($query) {
            $query->where('id', $this->selectedGovernmentProgram);
        });
    }
    if ($this->selectedPurok_id) {
        $query->whereHas('profiledTaggedApplicant.shelterApplicant.address.purok', function ($query) {
            $query->where('id', $this->selectedPurok_id);
        });
    }

    if ($this->selectedBarangay_id) {
        $query->whereHas('profiledTaggedApplicant.shelterApplicant.address.barangay', function ($query) {
            $query->where('id', $this->selectedBarangay_id);
        });
    }

    $OriginOfRequests = OriginOfRequest::all();
    $GovernmentPrograms = GovernmentProgram::all();

    // $grantees = $query->paginate(5);
    $grantees = $query->orderBy('date_of_delivery', 'desc')->paginate(5);

        return view('livewire.grantees', [
            'grantees' => $grantees,
            'OriginOfRequests' => $OriginOfRequests,
            'GovernmentPrograms' => $GovernmentPrograms,
            'puroks' => $this->puroks,
            'barangays' => $this->barangays,
            'puroksFilter' => $this->puroksFilter]);
    }
}
