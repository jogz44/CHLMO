<?php

namespace App\Livewire;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RoleManagement extends Component
{
    public $search = '', $filter = '';
    // Role properties
    public $isRoleModalOpen = false, $isRoleEditing = false;
    public $roleId, $roleName, $selectedPermissions = [];  // Changed from permissionId to selectedPermissions array

    // Permission properties
    public $permissions;
    public $isPermissionModalOpen = false, $permissionName, $selectedRoles = [], $isPermissionEditing = false, $editingPermissionId;

    protected $rules = [
        'roleName' => 'required|string|max:255|unique:roles,name',
        'selectedPermissions' => 'required|array|min:1',
        'selectedPermissions.*' => 'exists:permissions,id',
    ];
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function resetInputFields(): void
    {
        $this->roleName = '';
        $this->selectedPermissions = [];
    }
    public function openRoleModal(): void
    {
        $this->isRoleModalOpen = true;
        $this->isRoleEditing = false;
        $this->resetInputFields();
    }

    public function closeRoleModal(): void
    {
        $this->isRoleModalOpen = false;
        $this->resetInputFields();
    }
    public function editRole($roleId): void
    {
        $this->isRoleEditing = true;
        $this->roleId = $roleId;
        $role = Role::findOrFail($roleId);
        $this->roleName = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();  // Load existing permissions

        $this->isRoleModalOpen = true;
    }

    public function save(): void
    {
        $validatedData = $this->validate($this->isRoleEditing
            ? $this->getUpdateRules()
            : $this->rules
        );

        $validPermissionIds = Permission::whereIn('id', $validatedData['selectedPermissions'])->pluck('id')->toArray();

        try {
            DB::beginTransaction();

            if ($this->isRoleEditing) {
                $role = Role::findOrFail($this->roleId);
                $role->name = $this->roleName;
                $role->syncPermissions($validPermissionIds);
                $role->save();
                session()->flash('message', 'Role updated successfully.');
            } else {
                $role = Role::create(['name' => $this->roleName]);
                $role->givePermissionTo($validPermissionIds);
                session()->flash('message', 'Role created successfully.');
            }

            DB::commit();
            // Dispatch event to notify other components
            $this->dispatch('roleUpdated')->to('user-management');
            $this->closeRoleModal();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to save role: ' . $e->getMessage());
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }
    protected function getUpdateRules(): array
    {
        return [
            'roleName' => 'required|string|max:255|unique:roles,name,' . $this->roleId,
            'selectedPermissions' => 'required|array|min:1|exists:permissions,id',
        ];
    }

    // Permission properties
    public function mount()
    {
        $this->permissions = Permission::all();
//        dd($this->permissions->pluck('id'));
    }
    public function openPermissionModal(): void
    {
        $this->isPermissionModalOpen = true;
        $this->permissionName = '';
        $this->selectedRoles = [];
        $this->isPermissionEditing = false;
    }
    public function closePermissionModal(): void
    {
        $this->isPermissionModalOpen = false;
    }
    public function editPermission($id): void
    {
        $this->isPermissionModalOpen = true;
        $this->isPermissionEditing = true;
        $this->editingPermissionId = $id;
        $permission = \Spatie\Permission\Models\Permission::findOrFail($id);
        $this->permissionName = $permission->name;
        $this->selectedRoles = $permission->roles->pluck('id')->toArray();
    }
    public function deletePermission($id): void
    {
        \Spatie\Permission\Models\Permission::findOrFail($id)->delete();
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Permission deleted successfully.']);
    }
//    public function savePermission(): void
//    {
//        $validatedData = $this->validate([
//            'permissionName' => 'required|string|max:255',
//            'selectedRoles' => 'required|array|min:1',
//        ]);
//
//        if ($this->isPermissionEditing) {
//            $permission = \Spatie\Permission\Models\Permission::findOrFail($this->editingPermissionId);
//            $permission->name = $validatedData['permissionName'];
//            $permission->syncRoles(array_map('intval', $validatedData['selectedRoles']));
//            $permission->save();
//
//            $this->dispatch('alert', ['type' => 'success', 'message' => 'Permission updated successfully.']);
//        } else {
//            $permission = Permission::create(['name' => $validatedData['permissionName']]);
//
//            // Attach permission to each selected role
//            foreach ($validatedData['selectedRoles'] as $roleName) {
//                $role = Role::where('name', $roleName)->first();
//                if ($role) {
//                    $role->givePermissionTo($permission); // This should populate role_has_permissions
//                }
//            }
//
//            $this->dispatch('alert', ['type' => 'success', 'message' => 'Permission created successfully.']);
//        }
//
//        $this->closePermissionModal();
//    }

    public function savePermission(): void
    {
        $validatedData = $this->validate([
            'permissionName' => 'required|string|max:255',
            'selectedRoles' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            if ($this->isPermissionEditing) {
                $permission = \Spatie\Permission\Models\Permission::findOrFail($this->editingPermissionId);
                $permission->name = $validatedData['permissionName'];
                $permission->syncRoles(array_map('intval', $validatedData['selectedRoles']));
                $permission->save();

                $this->dispatch('alert', ['type' => 'success', 'message' => 'Permission updated successfully.']);
            } else {
                $permission = Permission::create(['name' => $validatedData['permissionName']]);

                foreach ($validatedData['selectedRoles'] as $roleName) {
                    $role = Role::where('name', $roleName)->first();
                    if ($role) {
                        $role->givePermissionTo($permission);
                    }
                }

                $this->dispatch('alert', ['type' => 'success', 'message' => 'Permission created successfully.']);
            }

            DB::commit();
            // Dispatch event to notify other components
            $this->dispatch('permissionUpdated')->to('user-management');
            $this->closePermissionModal();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $roles = Role::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->filter, function ($query) {
                $query->where('id', $this->filter);
            })
            ->paginate(5);

        return view('livewire.role-management', [
            'roles' => $roles,
            'permissions' => Permission::all(),
        ]);
    }

    // From the PermissionManagement livewire component:
//    public function render()
//    {
//        $permissions = \Spatie\Permission\Models\Permission::when($this->search, function ($query) {
//            $query->where('name', 'like', '%' . $this->search . '%');
//        })
//            ->when($this->filter, function ($query) {
//                $query->whereHas('roles', function ($query) {
//                    $query->where('id', $this->filter);
//                });
//            })
//            ->paginate(5);
//
//        $roles = Role::all();
//
//        return view('livewire.permissions-management', [
//            'permissions' => $permissions,
//            'roles' => $roles,
//        ])->layout('layouts.app');
//    }
}
