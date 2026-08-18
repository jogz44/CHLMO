<?php

namespace App\Livewire;

use App\Livewire\Traits\HandlesPagination;
use App\Models\AwardeeTransferHistory;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class TransferHistories extends Component
{
    use HandlesPagination;
    
    public function render()
    {
        $transfers = AwardeeTransferHistory::with([
            'previousAwardee.taggedAndValidatedApplicant.applicant.person',
            'previousAwardee.assignedRelocationSite',
            'previousAwardee.actualRelocationSite',
            'processor'
        ])
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        // Add debug logging
        foreach ($transfers as $transfer) {
            Log::info('Transfer details', [
                'id' => $transfer->id,
                'previous_awardee_id' => $transfer->previous_awardee_id,
                'remarks' => $transfer->remarks,
                'relationship' => $transfer->relationship
            ]);
        }

        return view('livewire.transfer-histories', [
            'transfers' => $transfers
        ])->layout('layouts.app');
    }
}
