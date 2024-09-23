<?php

namespace App\Livewire;

use App\Models\Applicant;
use Livewire\Component;

class WalkinTransaction extends Component
{

    public function createNewApplicant()
    {
        Applicant::create([

        ]);
    }

    public function render()
    {
        return view('livewire.walkin-transaction');
    }
}
