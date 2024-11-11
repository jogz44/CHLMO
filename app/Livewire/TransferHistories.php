<?php

namespace App\Livewire;

use App\Models\AwardeeTransferHistory;
use Livewire\Component;

class TransferHistories extends Component
{
    public function render()
    {
        $transfers = AwardeeTransferHistory::with([
            'previousAwardee.taggedAndValidatedApplicant',
            'previousAwardee.relocationLot',
            'processor'
        ])->latest()->paginate(5);

        return view('livewire.transfer-histories', [
            'transfers' => $transfers
        ])->layout('layouts.app');
    }
}
