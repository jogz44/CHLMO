<?php

namespace App\Livewire;

use App\Models\Blacklist;
use Livewire\Component;
use Livewire\WithPagination;

class Blacklists extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $blacklisted = Blacklist::with([
            'awardee.taggedAndValidatedApplicant.applicant.person',
            'user'
        ])
            ->orderBy('created_at', 'desc')
            ->paginate(5); // You can adjust the number of items per page;

        return view('livewire.blacklists',[
            'blacklisted' => $blacklisted
        ]);
    }
}
