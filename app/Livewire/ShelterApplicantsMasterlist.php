<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Shelter\ShelterApplicant;  
use App\Models\Shelter\OriginOfRequest;   
use Carbon\Carbon;

class ShelterApplicantsMasterlist extends Component
{
    use WithPagination;

    public $search = '';
    public $openModal = false;
    public $isEditModalOpen = false;
    public $isLoading = false;
    public $startDate, $endDate;
    public $selectedOriginOfRequest = null;
    public $profileNo;
    public $date_request;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $suffix_name;
    public $request_origin_id;
    public $editingApplicantId = null;
    public $origin_name;
    public $selectedTaggingStatus;
    public $taggingStatuses;

    public function openModal()
    {
        $this->resetForm();  // Reset form before opening the modal
        $this->openModal = true;
    }

    public function closeModal()
    {
        $this->openModal = false;
    }

    public function resetForm()
    {
        if (!$this->editingApplicantId) {
            $this->profileNo = '';
        }
        $this->date_request = '';
        $this->first_name = '';
        $this->middle_name = '';
        $this->last_name = '';
        $this->suffix_name = '';
        $this->request_origin_id = null;
    }

    public function mount()
    {
        $this->date_request = now()->toDateString();
        $this->startDate = null;
        $this->endDate = null;
        $this->search = ''; // Ensure search is empty initially
        $this->taggingStatuses = ['Tagged', 'Not Tagged'];
    }

    public function updated($field)
    {
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->startDate = null;
        $this->endDate = null;
        $this->selectedOriginOfRequest = null;
        $this->selectedTaggingStatus = null;
        $this->resetPage();
    }

    public function render()
    {
        // Use the correct model name
        $query = ShelterApplicant::query();

        // Apply search conditions if there is a search term
        $query->when($this->search, function ($query) {
            return $query->where(function ($query) {
                $query->where('request_origin_id', 'like', '%' . $this->search . '%')
                    ->orWhere('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('profile_no', 'like', '%' . $this->search . '%');
            });
        });

        if ($this->startDate && $this->endDate) {
            $query->whereDate('created_at', '>=', $this->startDate)
                ->whereDate('created_at', '<=', $this->endDate);
        }

        if ($this->selectedOriginOfRequest) {
            $query->where('request_origin_id', $this->selectedOriginOfRequest);
        }

        if ($this->selectedTaggingStatus !== null) {
            $query->where('is_tagged', $this->selectedTaggingStatus === 'Tagged');
        }

        $applicants = $query->paginate(5);
        $originOfRequests = OriginOfRequest::all();

        // Return the view with the filtered applicants and originOfRequests
        return view('livewire.shelter-applicants-masterlist', [
            'applicants' => $applicants,
            'originOfRequests' => $originOfRequests,
        ]);
    }
}