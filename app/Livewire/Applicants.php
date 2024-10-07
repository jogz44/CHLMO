<?php

namespace App\Livewire;

use AllowDynamicProperties;
use App\Models\Address;
use App\Models\Applicant;
use App\Models\Barangay;
use App\Models\Purok;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class Applicants extends Component
{
    use WithPagination;
    public $search = '';

    public $isModalOpen = false;
    public $isLoading = false;
    public $date_applied;
    public $transaction_type_id;
    public $transactionTypes = []; // Initialize as an empty array
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
    public $startDate, $endDate, $selectedPurok, $selectedBarangay, $selectedTaggingStatus;
    // Properties to hold filter options
    public $purokFilter = null, $barangayFilter = null, $taggingStatuses;
    protected $paginationTheme = 'tailwind';
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
        $this->selectedPurok = null;
        $this->selectedBarangay = null;
        $this->purokFilter = null;
        $this->barangayFilter = null;
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
        $this->transactionTypes = TransactionType::all();

        // Set default transaction type to 'Walk-in'
        $walkIn = TransactionType::where('type_name', 'Walk-in')->first();
        if ($walkIn) {
            $this->transaction_type_id = $walkIn->id;
        }

        // Set interviewer
        $this->interviewer = Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name;

        // Initialize filter options
        $this->puroks = Cache::remember('puroks', 60*60, function() {
            return Purok::all();
        });
        $this->barangays = Cache::remember('barangays', 60*60, function() {
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


    protected function rules()
    {
        return [
            'date_applied' => 'required|date',
            'transaction_type_id' => 'required|exists:transaction_types,id',
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

        // Load applicants directly in the WalkinApplicantsTable component
//        $this->emitTo('walkin-applicants-table-v2', 'loadApplicants');

        // Flash a success message
        session()->flash('message', 'Applicant successfully added.');
    }

    public function resetForm()
    {
        $this->reset([
            'date_applied', 'transaction_type_id', 'first_name', 'middle_name', 'last_name',
            'suffix_name', 'barangay_id', 'purok_id', 'contact_number',
        ]);
    }
    public function tagApplicant($applicantId)
    {
        // Logic to tag the applicant
        $applicant = Applicant::find($applicantId);
        $applicant->is_tagged = true;
        $applicant->save();

        // Optionally, show a success message
        session()->flash('message', 'Applicant tagged successfully.');
    }

    public function render()
    {
        $query = Applicant::with(['address.purok', 'address.barangay', 'taggedAndValidated'])
            ->where(function($query) {
                $query->where('applicant_id', 'like', '%'.$this->search.'%')
                    ->orWhere('first_name', 'like', '%'.$this->search.'%')
                    ->orWhere('middle_name', 'like', '%'.$this->search.'%')
                    ->orWhere('last_name', 'like', '%'.$this->search.'%')
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

        if ($this->selectedPurok) {
            $query->whereHas('address', function ($q) {
                $q->where('purok_id', $this->selectedPurok);
            });
        }

        if ($this->selectedBarangay) {
            $query->whereHas('address', function ($q) {
                $q->where('barangay_id', $this->selectedBarangay);
            });
        }

        if ($this->selectedTaggingStatus !== null) {
            $query->where('is_tagged', $this->selectedTaggingStatus === 'Tagged');
        }

        $applicants = $query->paginate(5); // Apply pagination after filtering

        return view('livewire.applicants', [
            'puroks' => $this->puroks,
            'applicants' => $applicants
        ]);
    }
}