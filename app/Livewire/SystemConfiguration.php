<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CivilStatus;
use App\Models\Tribe;
use App\Models\Religion; // Assuming you have a Religion model for storing religions


class SystemConfiguration extends Component
{
    public $civilStatuses = [];
    public $newStatus = ''; // For the input field
    public $tribes = [];
    public $applicant_tribes = []; // Array to hold new tribe entries from Alpine.js
    public $showModal = true;
   
    // Properties for religion management
    public $religions = [''];
    public $message = '';

    public function mount()
    {
        $this->civilStatuses = CivilStatus::pluck('civil_status')->toArray();
        $this->tribes = Tribe::pluck('tribe_name')->toArray();
        $this->religions = Religion::pluck('religion_name')->toArray();
    }

    public function addCivilStatus()
    {
        // Validation (ensure the status isn't empty and is unique)
        $this->validate([
            'newStatus' => 'required|string|unique:civil_statuses,civil_status',
        ]);

        // Add the status to the database
        CivilStatus::create(['civil_status' => $this->newStatus]);

        // Update the local array and reset input
        $this->civilStatuses[] = $this->newStatus;
        $this->newStatus = '';
        session()->flash('message', 'Civil Status added successfully!');
    }

    public function addTribe()
    {
        // Validate each tribe entry to ensure uniqueness
        foreach ($this->applicant_tribes as $tribe) {
            if (!empty($tribe)) {
                $this->validate([
                    'applicant_tribes.*' => 'string|unique:tribes,tribe_name',
                ]);

                // Add the tribe to the database
                Tribe::create(['tribe_name' => $tribe]);
            
            }
        }

        // Update the tribes list and clear the input array
        $this->applicant_tribes = [];
        $this->tribes = []; // Resetting the fields to an empty array
        session()->flash('message', 'Tribes added successfully!');
    }

    // Methods for religion management
    public function addReligion()
    {
        // Validate each religion entry to ensure uniqueness
        $this->validate([
            'religions.*' => 'required|string|unique:religions,religion_name',
        ]);

        foreach ($this->religions as $religion) {
            if (!empty($religion)) {
                Religion::create(['religion_name' => $religion]);
            }
        }

        // Clear the input array and show a success message
        $this->religions = [''];
        $this->message = 'Religions added successfully!';
    }

    public function removeTribe($index)
    {
        unset($this->tribes[$index]);
        $this->applicant_tribes = array_values($this->tribes); // Re-index the array
    }

    public function removeReligion($index)
    {
        unset($this->religions[$index]);
        $this->religions = array_values($this->religions); // Re-index the array
    }

    public function render()
    {
        return view('livewire.system-configuration');
    }
}
