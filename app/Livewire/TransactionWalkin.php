<?php

namespace App\Livewire;

use AllowDynamicProperties;
use App\Models\Address;
use App\Models\Applicant;
use App\Models\Barangay;
use App\Models\Purok;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TransactionWalkin extends Component
{
    // Define public properties for the form fields
    public $isModalOpen = false; // Manage modal visibility
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


    public function mount()
    {
        // Set today's date as the default value for date_applied
        $this->date_applied = now()->toDateString(); // YYYY-MM-DD format

        // Initialize dropdowns
        $this->barangays = Barangay::all();
        $this->transactionTypes = TransactionType::all();
        $this->interviewer = Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name;
    }

    public function updatedBarangayId($barangayId)
    {
        // Fetch the puroks based on the selected barangay
        $this->puroks = Purok::where('barangay_id', $barangayId)->get();
        $this->purok_id = null; // Reset selected purok when barangay changes
        // Log the retrieved puroks with descriptive information
        logger()->info('Retrieved Puroks', [
            'barangay_id' => $barangayId,
            'puroks' => $this->puroks
        ]);

        $this->isLoading = false; // Reset loading state
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
            'contact_number' => 'nullable|string|max:20',
            'barangay_id' => 'required|exists:barangays,id',
            'purok_id' => 'required|exists:puroks,id', // Ensure this validation works for purok
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

        // Create the new applicant record and get the ID of the newly created applicant
        $applicant = Applicant::create([
            'user_id' => Auth::id(),
            'date_applied' => $this->date_applied,
            'transaction_type_id' => $this->transaction_type_id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'suffix_name' => $this->suffix_name,
            'phone' => $this->contact_number,
            'initially_interviewed_by' => $this->interviewer,
            'address_id' => $address->id,
        ]);

        $this->resetForm();
        $this->isModalOpen = false; // Close the modal

        // Flash a success message
        session()->flash('message', 'Applicant successfully added.');
    }

    public function resetForm()
    {
        $this->reset([
            'date_applied',
            'transaction_type_id',
            'first_name',
            'middle_name',
            'last_name',
            'suffix_name',
            'barangay_id',
            'purok_id',
            'contact_number',
            'interviewer',
        ]);
    }

    public function render()
    {
        return view('livewire.transaction-walkin', [
            'transactionTypes' => $this->transactionTypes,
            'barangays' => $this->barangays,
            'puroks' => $this->puroks,
        ]);
    }
}
