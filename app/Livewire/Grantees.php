<?php

namespace App\Livewire;

use App\Models\Shelter\Grantee;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Shelter\OriginOfRequest;

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

    public function mount()
    {
        $this->date_request = now()->toDateString(); 
        $this->date_of_delivery = now()->toDateString();
        $this->date_tagged = now()->toDateString();
        $this->startGrantingDate = null;
        $this->endGrantingDate = null;
        $this->search = ''; // Ensure search is empty initially
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
                            ->orWhere('last_name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('shelterApplicant.originOfRequest', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        });        
        $query = $query->with(['shelterApplicant', 'originOfRequest', 'material']);
        $query = $query->with(['profiledTaggedApplicant']);

       // Apply date range filter (if both dates are present)
       if ($this->startGrantingDate && $this->endGrantingDate) {
        $query->whereBetween('date_of_delivery', [$this->startGrantingDate, $this->endGrantingDate]);
    }
    if ($this->selectedOriginOfRequest) {
        $query->whereHas('profiledTaggedApplicant.shelterApplicant.originOfRequest', function ($query) {
            $query->where('id', $this->selectedOriginOfRequest);
        });
    }
    $OriginOfRequests = OriginOfRequest::all();
    $query = $query->with(['originOfRequest', 'shelterApplicant']);
    $grantees = $query->paginate(5);

        return view('livewire.grantees', [
            'grantees' => $grantees,
            'OriginOfRequests' => $OriginOfRequests,]);
    }
}
