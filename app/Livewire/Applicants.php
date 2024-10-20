<?php

namespace App\Livewire;

use AllowDynamicProperties;
use App\Models\Address;
use App\Models\Applicant;
use App\Models\Barangay;
use App\Models\Purok;
use App\Models\TaggedAndValidatedApplicant;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;
use Ramsey\Collection\Collection;

class Applicants extends Component
{
    use WithPagination;
    public $search = '';

    public $isModalOpen = false;
    public $isLoading = false;
    public $date_applied;
    public $transaction_type_id;
    public $transaction_type_name;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $suffix_name;
    public $contact_number;
    public $barangay_id; // Update this property name
    public $purok_id; // Update this property name
    public $puroks = [];
    public $interviewer;

    public $barangays = []; // Initialize as an empty array

    // Filter properties:
    public $applicantId;
    public $startDate, $endDate, $selectedTaggingStatus;
    public $selectedPurok_id;
    public $puroksFilter = []; // Initialize as an empty array
    public $selectedBarangay_id;
    public $barangaysFilter = []; // Initialize as an empty array
    public $taggingStatuses;
    protected $paginationTheme = 'tailwind';

    public $selectedApplicantId;
    public $edit_first_name;
    public $edit_middle_name;
    public $edit_last_name;
    public $edit_suffix_name;
    public $edit_date_applied;
    public $edit_contact_number;
    public $edit_barangay_id; // Update this property name
    public $edit_purok_id; // Update this property name

    // For export
    public Collection $applicantsForExport;
    public Collection $selectedApplicantsForExport;
    public $designTemplate = 'tailwind';

    public function updatingSearch(): void
    {
        // This ensures that the search query is updated dynamically as the user types
        $this->resetPage();
    }
    public function clearSearch()
    {
        $this->search = ''; // Clear the search input
    }

    public function resetFilters(): void
    {
        $this->startDate = null;
        $this->endDate = null;
        $this->selectedPurok_id = null;
        $this->selectedBarangay_id = null;
        $this->selectedTaggingStatus = null;

        // Reset pagination and any search terms
        $this->resetPage();
        $this->search = '';
    }


    public function mount()
    {
//        dd('Component mounted');

        // Set today's date as the default value for date_applied
        $this->date_applied = now()->toDateString(); // YYYY-MM-DD format

        // Initialize dropdowns
        $this->barangays = Barangay::all();
        $this->puroks = Purok::all();
//        $this->transactionTypes = TransactionType::all();

        // Set the default transaction type to 'Walk-in'
        $walkIn = TransactionType::where('type_name', 'Walk-in')->first();
        if ($walkIn) {
            $this->transaction_type_id = $walkIn->id; // This can still be used internally for further logic if needed
            $this->transaction_type_name = $walkIn->type_name; // Set the name to display
        }

        // Set interviewer
        $this->interviewer = Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name;

        // Initialize filter options
        $this->puroksFilter = Cache::remember('puroks', 60*60, function() {
            return Purok::all();
        });
        $this->barangaysFilter = Cache::remember('barangays', 60*60, function() {
            return Barangay::all();
        });
        $this->taggingStatuses = ['Tagged', 'Not Tagged']; // Add your statuses here
    }

    public function updatingBarangay()
    {
        $this->resetPage();
    }
    public function updatingPurok()
    {
        $this->resetPage();
    }
    public function updatedBarangayId($barangayId)
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
    protected function rules()
    {
        return [
            'date_applied' => 'required|date',
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'suffix_name' => 'nullable|string|max:50',
            'contact_number' => 'nullable|string|max:15',
            'barangay_id' => 'required|exists:barangays,id',
            'purok_id' => 'required|exists:puroks,id',
        ];
    }

    public function store()
    {
        // Validate the input data
        $this->validate();

        // Create the address entry first
        $address = Address::create([
            'barangay_id' => $this->barangay_id,
            'purok_id' => $this->purok_id,
        ]);

        // Generate the unique applicant ID
        $applicantId = Applicant::generateApplicantId();

        // Create the new applicant record and get the ID of the newly created applicant
        $applicant = Applicant::create([
            'user_id' => Auth::id(),
            'date_applied' => $this->date_applied,
            'transaction_type_id' => $this->transaction_type_id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'suffix_name' => $this->suffix_name,
            'contact_number' => $this->contact_number,
            'initially_interviewed_by' => $this->interviewer,
            'address_id' => $address->id,
            'applicant_id' => $applicantId,
        ]);

        $this->resetForm();
        $this->isModalOpen = false; // Close the modal

        // Trigger the alert message
        $this->dispatch('alert', [
            'title' => 'Applicant Added!',
            'message' => 'Applicant successfully added at <br><small>'. now()->calendar() .'</small>',
            'type' => 'success'
        ]);

        $this->redirect('applicants');
    }

    public function resetForm()
    {
        $this->reset([
            'date_applied', 'transaction_type_id', 'first_name', 'middle_name', 'last_name',
            'suffix_name', 'barangay_id', 'purok_id', 'contact_number',
        ]);
    }
    public function edit($id)
    {
        $applicant = Applicant::findOrFail($id);

        $this->selectedApplicantId = $applicant->id;
        $this->edit_first_name = $applicant->first_name;
        $this->edit_middle_name = $applicant->middle_name;
        $this->edit_last_name = $applicant->last_name;
        $this->edit_suffix_name = $applicant->suffix_name;
        $this->edit_contact_number = $applicant->contact_number;
        $this->edit_barangay_id = $applicant->address->barangay_id ?? null;
        $this->edit_purok_id = $applicant->address->purok_id ?? null;
        $this->edit_date_applied = $applicant->date_applied->format('Y-m-d');
    }
    public function update()
    {
        $this->validate([
            'edit_first_name' => 'required|string|max:255',
            'edit_middle_name' => 'nullable|string|max:255',
            'edit_last_name' => 'required|string|max:255',
            'edit_suffix_name' => 'nullable|string|max:255',
            'edit_contact_number' => 'nullable|string|max:15',
            'edit_barangay_id' => 'required|integer',
            'edit_purok_id' => 'required|integer',
            'edit_date_applied' => 'required|date',
        ]);

        $applicant = Applicant::findOrFail($this->selectedApplicantId);
        $applicant->first_name = $this->edit_first_name;
        $applicant->middle_name = $this->edit_middle_name;
        $applicant->last_name = $this->edit_last_name;
        $applicant->suffix_name = $this->edit_suffix_name;
        $applicant->contact_number = $this->edit_contact_number;
        $applicant->date_applied = $this->edit_date_applied;
        $applicant->address->barangay_id = $this->edit_barangay_id;
        $applicant->address->purok_id = $this->edit_purok_id;

        $applicant->save();

        $this->dispatch('alert', [
            'title' => 'Details Updated!',
            'message' => 'Applicant successfully updated at <br><small>'. now()->calendar() .'</small>',
            'type' => 'success'
        ]);
    }
    public function tagApplicant($applicantId)
    {
        // Logic to tag the applicant
        $applicant = Applicant::find($applicantId);
        $applicant->is_tagged = true;
        $applicant->save();
    }
    public function render()
    {
        $query = Applicant::with(['address.purok', 'address.barangay', 'taggedAndValidated'])
            ->where(function($query) {
                $query->where('applicant_id', 'like', '%'.$this->search.'%')
                    ->orWhere('first_name', 'like', '%'.$this->search.'%')
                    ->orWhere('middle_name', 'like', '%'.$this->search.'%')
                    ->orWhere('last_name', 'like', '%'.$this->search.'%')
                    ->orWhere('suffix_name', 'like', '%'.$this->search.'%')
                    ->orWhere('contact_number', 'like', '%'.$this->search.'%')
                    ->orWhereHas('address.purok', function ($query) {
                        $query->where('name', 'like', '%'.$this->search.'%');
                    })
                    ->orWhereHas('address.barangay', function ($query) {
                        $query->where('name', 'like', '%'.$this->search.'%');
                    });
            });

        // Apply filters
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('date_applied', [$this->startDate, $this->endDate]);
        }

        if ($this->selectedPurok_id) {
            $query->whereHas('address', function ($q) {
                $q->where('purok_id', $this->selectedPurok_id);
            });
        }

        if ($this->selectedBarangay_id) {
            $query->whereHas('address', function ($q) {
                $q->where('barangay_id', $this->selectedBarangay_id);
            });
        }

        if ($this->selectedTaggingStatus !== null) {
            $query->where('is_tagged', $this->selectedTaggingStatus === 'Tagged');
        }

        $applicants = $query->paginate(5); // Apply pagination after filtering
//        $applicants = $query->orderBy('date_applied', 'desc')->paginate(5);

        // Pass data to the view
        return view('livewire.applicants', [
            'puroks' => $this->puroks,
            'puroksFilter' => $this->puroksFilter,
            'applicants' => $applicants
        ]);
    }
}