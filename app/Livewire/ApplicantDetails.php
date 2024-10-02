<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\Barangay;
use App\Models\CivilStatus;
use App\Models\Religion;
use App\Models\Tribe;
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

    public function render()
    {
        return view('livewire.applicant-details')
            ->layout('layouts.app');  // Ensure this matches your Blade layout path
    }
}
