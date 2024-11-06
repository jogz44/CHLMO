<?php

namespace App\Livewire;

use App\Models\Awardee;
use Livewire\Component;
use Livewire\WithPagination;

class AwardeeList extends Component
{
    use WithPagination;

    public function render()
    {
        $awardees = Awardee::with([
            'taggedAndValidatedApplicant', 'address', 'lot', 'lotSizeUnit'
        ])->orderBy('created_at', 'desc')->paginate( 10);

        return view('livewire.awardee-list', [
            'awardees' => $awardees
        ]);
    }
}
