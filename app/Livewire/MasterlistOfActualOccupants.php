<?php

namespace App\Livewire;

use App\Models\TaggedAndValidatedApplicant;
use Livewire\Component;

class MasterlistOfActualOccupants extends Component
{
    public function render()
    {
        // fetch data with necessary relationships eagerly loaded
        $applicants = TaggedAndValidatedApplicant::with([
           'applicant.person',
           'civilStatus',
           'address',
           'spouse',
           'liveInPartner',
           'dependents',
           'livingSituation'
        ])->get();

        // Pass data to the Blade view
        return view('livewire.masterlist-of-actual-occupants', [
            'applicants' => $applicants,
        ]);
    }
}
