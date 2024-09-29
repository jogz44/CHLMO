<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\Barangay;
use Livewire\Component;

class ApplicantDetails extends Component
{
    public $applicantId;
    public $applicant;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $name_suffix;
    public $barangay;
    public $purok;

    public function mount($applicantId)
    {
        $this->applicantId = $applicantId;
        $this->applicant = Applicant::find($applicantId);

        // Fetch the applicant with their related address, barangay, and purok
        $applicant = Applicant::with('address.barangay', 'address.purok')->find($applicantId);

        if ($applicant) {
            $this->first_name = $applicant->first_name;
            $this->middle_name = $applicant->middle_name;
            $this->last_name = $applicant->last_name;
            $this->name_suffix = $applicant->name_suffix;

            // Access the barangay and purok through the address relation
            $this->barangay = $applicant->address->barangay->name ?? '';
            $this->purok = $applicant->address->purok->name ?? '';
        }
    }

    public function render()
    {
        return view('livewire.applicant-details')
            ->layout('layouts.app');  // Ensure this matches your Blade layout path
    }
}
