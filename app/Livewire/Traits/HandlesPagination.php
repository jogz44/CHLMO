<?php

namespace App\Livewire\Traits;

use Livewire\WithPagination;

trait HandlesPagination
{
    use WithPagination;

    public $perPage = 10;
    public $perPageOptions = [5, 10, 25, 50, 100];

    public function updatedPerPage(): void
    {
        $this->perPage = in_array((int) $this->perPage, $this->perPageOptions, true)
            ? (int) $this->perPage
            : 10;

        $this->resetPage();
    }
}
