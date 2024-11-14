<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleManagement extends Component
{
    public function render()
    {
        return view('livewire.role-management', [
            'roles' => Role::all(),
        ]);
    }
}
