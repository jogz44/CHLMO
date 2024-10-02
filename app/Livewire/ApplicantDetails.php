<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\Barangay;
use App\Models\CivilStatus;
use App\Models\Religion;
use App\Models\TaggedAndValidatedApplicant;
use App\Models\Tribe;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ApplicantDetails extends Component
{
    public $applicantId;
    public $applicant;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $contact_number;
    public $name_suffix;
    public $barangay;
    public $purok;

    // New fields
    public $full_address;
    public $civil_status_id; // Store selected Civil Status ID
    public $civil_statuses; // For populating the civil statuses dropdown

    public $religion_id; // Store selected Religion ID
    public $religions; // For populating the religions dropdown
    public $tribe_id; // Store selected Tribe ID
    public $tribes; // For populating the tribes dropdown

    public $sex;

    public $occupation;
    public $monthly_income;
    public $family_income;

    public $tagged = false; // Track whether the applicant has been tagged

    public function mount($applicantId)
    {
        $this->applicantId = $applicantId;
        $this->applicant = Applicant::find($applicantId);

        // Fetch the applicant with their related address, barangay, and purok
        $applicant = Applicant::with('address.barangay', 'address.purok')->find($this->applicantId);
        // Fetch civil statuses for the dropdown
        $this->civil_statuses = CivilStatus::all();
        // Fetch religions for the dropdown
        $this->religions = Religion::all();
        // Fetch tribes for the dropdown
        $this->tribes = Tribe::all();

        if ($applicant) {
            $this->applicantId = $applicantId;
            $this->first_name = $applicant->first_name;
            $this->middle_name = $applicant->middle_name;
            $this->last_name = $applicant->last_name;
            $this->name_suffix = $applicant->name_suffix;
            $this->contact_number = $applicant->contact_number;

            // Access the barangay and purok through the address relation
            $this->barangay = $applicant->address->barangay->name ?? '';
            $this->purok = $applicant->address->purok->name ?? '';

            // Populate the specific address field
            $this->full_address = $this->applicant->address->full_address ?? '';

            // Populate the civil status based on applicant's existing data
            $this->civil_status_id = $this->applicant->civil_status_id ?? '';

            // Populate the religions based on applicant's existing data
            $this->religion_id = $this->applicant->religion_id ?? '';

            // Populate the tribes based on applicant's existing data
            $this->tribe_id = $this->applicant->tribe_id ?? '';
        }
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
            'sex' => 'required|in:Male,Female', // Updated to check for full words
            'occupation' => 'nullable|string|max:255',
            'monthly_income' => 'nullable|integer',
            'family_income' => 'nullable|integer',
        ];
    }

    public function store()
    {
        // Validate the input data
        $this->validate();

        // Create the new tagged and validated applicant record and get the ID of the newly created applicant
        $taggedAndValidatedApplicant = TaggedAndValidatedApplicant::create([
            // Other fields...
            'occupation' => $this->occupation,
            'monthly_income' => $this->monthly_income,
            'family_income' => $this->family_income,
        ]);
    }

    public function render()
    {
        return view('livewire.applicant-details')
            ->layout('layouts.app');  // Ensure this matches your Blade layout path
    }
}
