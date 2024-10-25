<?php

namespace App\Livewire;

use Livewire\Component;

class AddNewOccupant extends Component
{
    // Required fields in adding an occupant
    public
        $first_name, $middle_name, $last_name, $suffix_name,
        $barangay_id, $purok_id, $barangays = [], $puroks = [], $full_address,
        $civil_status_id, $civilStatuses,
        $contact_number,
        $tribe_id, $tribes = [],
        $sex, $age,
        $religion_id, $religions = [],
        $occupation, $monthly_income, $family_income;

    // TODO continue setting the wire:models in the blade file for this. You stopped at 'wire:model="first_name".
    // TODO Good night, sleep well.

    public function render()
    {
        return view('livewire.add-new-occupant');
    }
}
