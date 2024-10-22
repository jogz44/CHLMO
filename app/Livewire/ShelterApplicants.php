<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Shelter\ShelterApplicant;
use Livewire\WithPagination;
use App\Models\Shelter\OriginOfRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ShelterApplicants extends Component
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

    public function openModalEdit($applicantId)
    {
        $applicant = ShelterApplicant::findOrFail($applicantId);
        $this->editingApplicantId = $applicantId;
        $this->profileNo = $applicant->profileNo;
        $this->date_request = $applicant->date_request;
        $this->first_name = $applicant->first_name;
        $this->middle_name = $applicant->middle_name;
        $this->last_name = $applicant->last_name;
        $this->suffix_name = $applicant->suffix_name;
        $this->request_origin_id = $applicant->request_origin_id;

        $this->origin_name = $applicant->originOfRequest->name ?? 'Unknown'; 

        $this->isEditModalOpen = true; // Open the modal
    }

    public function closeEditApplicantModal()
    {
        $this->isEditModalOpen = false;
    }

    public function submitForm()
{
    $this->validate([
        'date_request' => 'required|date',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'request_origin_id' => 'required|exists:origin_of_requests,id', // Ensure the request origin is valid
    ]);

    if ($this->editingApplicantId) {
        // Update existing applicant
        $applicant = ShelterApplicant::findOrFail($this->editingApplicantId);
        $applicant->update([
            'date_request' => $this->date_request,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'suffix_name' => $this->suffix_name,
            'request_origin_id' => $this->request_origin_id,
        ]);

        session()->flash('message', 'Applicant updated successfully!');
        $this->closeEditApplicantModal(); // Close the EDIT modal
    } else {
        // Generate profile number and assign it
        $this->profileNo = ShelterApplicant::generateProfileNo();

        // Create new applicant
        ShelterApplicant::create([
            'user_id' => Auth::id(),
            'profile_no' => $this->profileNo, // Use the generated profile number
            'date_request' => $this->date_request,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'suffix_name' => $this->suffix_name,
            'request_origin_id' => $this->request_origin_id,
        ]);

        session()->flash('message', 'Applicant added successfully!');
       
    }

    // Reset form and close the modal
    $this->resetForm();
    $this->closeModal(); //CLOSING THE ADD APPLICANT MODAL
    $this->redirect('shelter-transaction-applicants');
}


    public function mount()
    {
        $this->date_request = now()->toDateString(); 

        $this->startDate = null;
        $this->endDate = null;
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
        $this->startDate = null;
        $this->endDate = null;
        $this->search = '';
        $this->selectedOriginOfRequest = null;
        $this->resetPage();
    }

    // Triggered when search or other filters are updated
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function tagApplicant($profileNo)
    {
        // Logic to tag the applicant
        $applicant = ShelterApplicant::find($profileNo);
        $applicant->is_tagged = true;
        $applicant->save();

        $this->dispatch('alert', [
            'title' => 'Tagging Successful!',
            'message' => 'Applicant tagged and validated successfully at <br><small>'. now()->calendar() .'</small>',
            'type' => 'success'
        ]);
    }
    public function untagged($profileNo)
    {
        $applicant = ShelterApplicant::find($profileNo);
        $applicant->is_tagged = false;
        $applicant->save();

        $this->dispatch('alert', [
            'title' => 'Untagging Successful!',
            'message' => 'Applicant untagged successfully at <br><small>'. now()->calendar() .'</small>',
            'type' => 'success'
        ]);
    }

    public function render()
    {

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

        $applicants = $query->paginate(5);
        $OriginOfRequests = OriginOfRequest::all();

        // Return the view with the filtered applicants
        return view('livewire.shelter-applicants', [
            'applicants' => $applicants,
            'OriginOfRequests' => $OriginOfRequests,
        ]);
    }
}
