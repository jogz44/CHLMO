<?php

namespace App\Livewire;

use App\Models\AwardeeTransferHistory;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class TransferHistories extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $transfers = AwardeeTransferHistory::with([
            'previousAwardee.taggedAndValidatedApplicant.applicant.person',
            'previousAwardee.assignedRelocationSite',
            'previousAwardee.actualRelocationSite',
            'processor'
        ])
        ->when($this->search, function ($query) {
            $words = preg_split('/\s+/', trim($this->search));

            $query->where(function ($q) use ($words) {
                foreach ($words as $word) {
                    $like = '%' . $word . '%';

                    $q->where(function ($subQ) use ($like) {
                        $subQ
                            ->orWhere('relationship', 'like', $like)
                            ->orWhere('remarks', 'like', $like)
                            ->orWhere('transfer_reason', 'like', $like)

                            // Match against person name combinations
                            ->orWhereHas('previousAwardee.taggedAndValidatedApplicant.applicant.person', function ($p) use ($like) {
                                $p->where(DB::raw("CONCAT_WS(' ', first_name, middle_name, last_name)"), 'like', $like)
                                ->orWhere(DB::raw("CONCAT_WS(' ', last_name, first_name)"), 'like', $like)
                                ->orWhere(DB::raw("CONCAT_WS(' ', middle_name, last_name)"), 'like', $like)
                                ->orWhere('first_name', 'like', $like)
                                ->orWhere('middle_name', 'like', $like)
                                ->orWhere('last_name', 'like', $like);
                            })

                            // Match processor name combinations
                            ->orWhereHas('processor', function ($proc) use ($like) {
                                $proc->where(DB::raw("CONCAT_WS(' ', first_name, middle_name, last_name)"), 'like', $like)
                                    ->orWhere(DB::raw("CONCAT_WS(' ', last_name, first_name)"), 'like', $like)
                                    ->orWhere(DB::raw("CONCAT_WS(' ', middle_name, last_name)"), 'like', $like)
                                    ->orWhere('first_name', 'like', $like)
                                    ->orWhere('middle_name', 'like', $like)
                                    ->orWhere('last_name', 'like', $like);
                            });
                    });
                }
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(5);

        return view('livewire.transfer-histories', compact('transfers'))->layout('layouts.app');
    }

}
