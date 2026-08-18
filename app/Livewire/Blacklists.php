<?php

namespace App\Livewire;

use App\Livewire\Traits\HandlesPagination;
use App\Models\Blacklist;
use Carbon\Carbon;
use Livewire\Component;

class Blacklists extends Component
{
    use HandlesPagination;
    protected $paginationTheme = 'tailwind';

    // Search and filter properties
    public $search = '';
    public $grantDateStart = '';
    public $grantDateEnd = '';
    public $blacklistDateStart = '';
    public $blacklistDateEnd = '';

    // Reset pagination when filters change
    protected $queryString = [
        'search' => ['except' => ''],
        'grantDateStart' => ['except' => ''],
        'grantDateEnd' => ['except' => ''],
        'blacklistDateStart' => ['except' => ''],
        'blacklistDateEnd' => ['except' => '']
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingGrantDateStart(): void
    {
        $this->resetPage();
    }

    public function updatingGrantDateEnd(): void
    {
        $this->resetPage();
    }

    public function updatingBlacklistDateStart(): void
    {
        $this->resetPage();
    }

    public function updatingBlacklistDateEnd(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Blacklist::with([
            'awardee.taggedAndValidatedApplicant.applicant.person',
            'awardee.assignedRelocationSite',
            'awardee.actualRelocationSite',
            'user'
        ]);

        // Enhanced search filter
        if ($this->search) {
            $query->whereHas('awardee.taggedAndValidatedApplicant.applicant.person', function ($q) {
                $q->where(DB::raw("CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name)"), 'like', '%' . $this->search . '%');
            })->orWhere('blacklist_reason_description', 'like', '%' . $this->search . '%');
        }

        // Apply grant date range filter
        if ($this->grantDateStart && $this->grantDateEnd) {
            $query->whereHas('awardee', function ($q) {
                $q->whereBetween('grant_date', [
                    Carbon::parse($this->grantDateStart)->startOfDay(),
                    Carbon::parse($this->grantDateEnd)->endOfDay()
                ]);
            });
        }

        // Apply blacklist date range filter
        if ($this->blacklistDateStart && $this->blacklistDateEnd) {
            $query->whereBetween('date_blacklisted', [
                Carbon::parse($this->blacklistDateStart)->startOfDay(),
                Carbon::parse($this->blacklistDateEnd)->endOfDay()
            ]);
        }

        $blacklisted = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.blacklists', [
            'blacklisted' => $blacklisted
        ]);
    }
    public function resetFilters(): void
    {
        $this->reset(['search', 'grantDateStart', 'grantDateEnd', 'blacklistDateStart', 'blacklistDateEnd']);
        $this->resetPage();
    }
}
