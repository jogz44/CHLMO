<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Address;
use App\Models\LivingStatus;
use App\Models\Shelter\Grantee;
use App\Models\Shelter\Material;
use Livewire\WithPagination;
use App\Models\Shelter\OriginOfRequest;
use App\Models\Shelter\ProfiledTaggedApplicant;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class ShelterProfiledTaggedApplicants extends Component
{
    use WithPagination;
    public $search = '';
    public $isLoading = false;
    public $selectedOriginOfRequest = null;
    public $startTaggingDate, $endTaggingDate, $selectedTaggingStatus;
    public $taggingStatuses;

    public $first_name;
    public $middle_name;
    public $last_name;
    public $request_origin_id;
    public $origin_name;
    public $date_tagged;
    public $profileNo;
    public $date_request;
    public $granteeId;

    public $profiledTaggedApplicantId;
    public $materialId;
    public $materials;
    public $date_of_delivery;
    public $date_of_ris;
    public $photo;
    public $is_granted;

    public $shelterLivingStatusesFilter = []; // Initialize as an empty array

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

    // Triggered when search or other filters are updated
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Reset filters
    public function resetFilters()
    {
        $this->startTaggingDate = null;
        $this->endTaggingDate = null;
        $this->selectedOriginOfRequest = null;
        $this->selectedTaggingStatus = null;

        $this->resetPage();
        $this->search = '';
    }

    public function mount()
    {

        $this->granteeId = null; // Initialize
        // \Log::info('Mounted with granteeId', ['granteeId' => $this->granteeId]);

        $this->shelterLivingStatusesFilter = Cache::remember('living_situations', 60*60, function() {
            return LivingStatus::all();
        });
        $this->taggingStatuses = ['Tagged', 'Not Tagged']; // Add your statuses here        
        $this->date_request = now()->toDateString(); // YYYY-MM-DD format

        // For Awarding Modal
        // Set today's date as the default value for date_applied
        $this->date_of_delivery = now()->toDateString(); // YYYY-MM-DD format

        $this->materials = Material::all();
    }

    protected function rules(): array
    {
        return [
            // For Awarding Modal
            'date_of_delivery' => 'required|date',
            'material_id' => 'required|exists:barangays,id',
        ];
    }

    public function grantApplicant(): void
    {
        // Validate the input data
        $this->validate([]);

        // Create the new grantee record and get the ID of the newly created grantee
        $grantee = Grantee::create([
            'profiled_tagged_applicant_id' => $this->profiledTaggedApplicantId,
            'material_id' => $this->materialId,
            'lot_id' => $this->lot_id,
            'lot_size' => $this->lot_size,
            'lot_size_unit_id' => $this->lot_size_unit_id,
            'grant_date' => $this->grant_date,
            'is_awarded' => false, // Update grantee table for status tracking
        ]);

        // Check if the grantee was created successfully
        if ($grantee) {
            $this->granteeId = $grantee->id; // Set granteeId here
            Log::info('Awardee created successfully', ['granteeId' => $this->granteeId]);
        } else {
            Log::error('Failed to create grantee');
        }

        // Update the 'tagged_and_validated_applicants' table to mark the applicant as being processed for awarding
        ProfiledTaggedApplicant::where('id', $this->profiledTaggedApplicantId)->update([
            'is_awarding_on_going' => true, // Update to reflect awarding is in process
        ]);

        $this->resetForm();
        // Trigger the alert message
        $this->dispatch('alert', [
            'title' => 'Awarding Successful!',
            'message' => 'Applicant awarded successfully! <br><small>'. now()->calendar() .'</small>',
            'type' => 'success'
        ]);

        $this->redirect('shelter-profiled-tagged-applicants');
    }

    public function resetForm()
    {
        if (!$this->editingApplicantId) {
            $this->profileNo = '';
        }
        $this->date_request = '';
        $this->date_tagged = '';
        $this->first_name = '';
        $this->middle_name = '';
        $this->last_name = '';
        $this->request_origin_id = null;
    }

    public function render()
    {
        $query = ProfiledTaggedApplicant::query();
    
        // Apply search conditions if there is a search term
        $query->when($this->search, function ($query) {
            return $query->where(function ($query) {
                $query->where('profile_no', 'like', '%' . $this->search . '%')
                    ->orWhereHas('shelterApplicant', function ($query) { // Access shelterApplicant relationship
                        $query->where('first_name', 'like', '%' . $this->search . '%')
                              ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                              ->orWhere('last_name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('shelterApplicant.originOfRequest', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        });
    
        // Apply date range filter (if both dates are present)
        if ($this->startTaggingDate && $this->endTaggingDate) {
            $query->whereBetween('date_tagged', [$this->startTaggingDate, $this->endTaggingDate]);
        }
    
        if ($this->selectedOriginOfRequest) {
            $query->whereHas('shelterApplicant.originOfRequest', function ($query) {
                $query->where('id', $this->selectedOriginOfRequest);
            });
        }
    
        $OriginOfRequests = OriginOfRequest::all();
    
        $query = $query->with(['originOfRequest', 'shelterApplicant']);
        $profiledTaggedApplicants = $query->paginate(5);
    
        return view('livewire.shelter-profiled-tagged-applicants', [
            'profiledTaggedApplicants' => $profiledTaggedApplicants, 
            'OriginOfRequests' => $OriginOfRequests,
        ]);
    }
    
}
