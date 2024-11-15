<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsManagement extends Component
{
    public $isPermissionModalOpen = false, $name, $selectedRoles = [], $isEditing = false, $editingPermissionId;
    public $search = '', $filter = '';

    public function openModal(): void
    {
        $this->isModalOpen = true;
        $this->name = '';
        $this->selectedRoles = [];
        $this->isEditing = false;
    }
    public function closeModal(): void
    {
        $this->isModalOpen = false;
    }
    public function edit($id): void
    {
        $this->isModalOpen = true;
        $this->isEditing = true;
        $this->editingPermissionId = $id;
        $permission = Permission::findOrFail($id);
        $this->name = $permission->name;
        $this->selectedRoles = $permission->roles->pluck('id')->toArray();
    }
    public function deletePermission($id): void
    {
        Permission::findOrFail($id)->delete();
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Permission deleted successfully.']);
    }
    public function save(): void
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'selectedRoles' => 'required|array|min:1',
        ]);

        if ($this->isEditing) {
            $permission = Permission::findOrFail($this->editingPermissionId);
            $permission->update(['name' => $validatedData['name']]);
            $permission->syncRoles($validatedData['selectedRoles']);
            $this->dispatch('alert', ['type' => 'success', 'message' => 'Permission updated successfully.']);
        } else {
            $permission = Permission::create(['name' => $validatedData['name']]);
            $permission->syncRoles($validatedData['selectedRoles']);
            $this->dispatch('alert', ['type' => 'success', 'message' => 'Permission created successfully.']);
        }
        $this->closeModal();
    }

    public function render()
    {
        $permissions = Permission::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
            ->when($this->filter, function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->where('id', $this->filter);
                });
            })
            ->paginate(5);

        $roles = Role::all();

        return view('livewire.permissions-management', [
            'permissions' => $permissions,
            'roles' => $roles,
        ])->layout('layouts.app');
    }
}
