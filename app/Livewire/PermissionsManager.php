<?php

namespace App\Livewire;

use App\Models\Permission;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class PermissionsManager extends Component
{
    public $roleId;
    public $permissions = [];

    public function mount()
    {
        $permissions = Permission::all()->pluck('name')->toArray();
    }

    public function assignPermissions()
    {
        $role = Role::findById($this->roleId);
        $role->syncPermissions($this->permissions);
        $this->dispatch('permissionsUpdated');
    }

    public function render()
    {
        $roles = Role::all();
        $selectedRole = Role::findById($this->roleId);
        $selectedPermissions = $selectedRole ? $selectedRole->permissions->pluck('name')->toArray() : [];

        return view('livewire.permissions-manager', [
            'roles' => $roles,
            'selectedPermissions' => $selectedPermissions
        ]);
    }
    /**
            This Livewire component provides a way to manage permissions for roles in a Laravel application that uses the Spatie Permissions package.

            Here's how it works:

            1. The `mount()` method retrieves all available permissions and stores them in the `$permissions` property.
            2. The `assignPermissions()` method takes the selected role ID from the view, finds the corresponding role, and synchronizes the selected permissions with that role.
            3. The `render()` method retrieves all roles and the selected permissions for the currently selected role, and passes them to the view.

            To use this component, you'll need to create a Livewire view file (e.g., `permissions-manager.blade.php`).
     * */
}
