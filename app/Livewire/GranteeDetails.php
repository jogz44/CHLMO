<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Shelter\ShelterApplicant;
use App\Models\Shelter\ProfiledTaggedApplicant;
use App\Models\Shelter\Grantee;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class GranteeDetails extends Component
{
    public $shelterApplicant;
    public $firstName;
    public $middleName;
    public $lastName;
    public $originOfRequest;
    public $requestDate;

    public $profiledTagged;
    public $age;
    public $sex;
    public $occupation;
    public $contact_number;
    public $year_of_residency;

    public function mount($profileNo)
    {
        Log::info('ProfileNo: ' . $profileNo);
        DB::enableQueryLog();  // Start logging queries
        $this->shelterApplicant = ShelterApplicant::where('profile_no', $profileNo)
            ->with(['profiledTagged', 'originOfRequest'])
            ->first();
        
        Log::info(DB::getQueryLog());

        if ($this->shelterApplicant) {
            $this->firstName = $this->shelterApplicant->first_name;
            $this->middleName = $this->shelterApplicant->middle_name;
            $this->lastName = $this->shelterApplicant->last_name;
            $this->originOfRequest = $this->shelterApplicant->originOfRequest->name ?? null;
            $this->requestDate = $this->shelterApplicant->created_at ? $this->shelterApplicant->created_at->format('Y-m-d') : '';

            $this->profiledTagged = $this->grantee->profiledTaggedApplicant;
            $profiledTaggedApplicant = $this->shelterApplicant->profiledTaggedApplicant;
        
            $this->age = $profiledTaggedApplicant ? $profiledTaggedApplicant->age : null;
            $this->sex = $this->shelterApplicant->sex;
            $this->occupation = $this->shelterApplicant->occupation;
            $this->contact_number = $this->shelterApplicant->contact_number;
            $this->year_of_residency = $this->shelterApplicant->year_of_residency;
        }
    }

    public function render()
    {
        return view('livewire.grantee-details')
            ->layout('layouts.adminshelter');
    }
}
