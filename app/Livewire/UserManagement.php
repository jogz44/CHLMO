<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserManagement extends Component
{
    use WithPagination;
    public $isModalOpen = false, $isEditing = false;

    // User Management Properties
    public $userId, $username, $firstName, $middleName, $lastName, $email, $password, $roleId;

    // New properties for permissions management
    public $selectedPermissions = [], $showPermissionsModal = false, $managingPermissionsFor = null,
        $selectedRoleId, $selectedUserId;

    protected $listeners = ['permissionsUpdated' => '$refresh'];

    // For search and filter
    public $search = '', $roleFilter = '';
    public function mount()
    {
        $this->resetInputFields();
    }
    protected $rules = [
        'username' => 'required|string|max:255|unique:users,username',
        'firstName' => 'required|string|max:255',
        'middleName' => 'nullable|string|max:255',
        'lastName' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        'roleId' => 'required|exists:roles,id'
    ];
    public function openPermissionsModal($type, $id): void
    {
        $this->managingPermissionsFor = $type;
        if ($type === 'role'){
            $this->selectedRoleId = $id;
            $role = Role::findById($id);
            $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        } else {
            $this->selectedUserId = $id;
            $user = User::findOrFail($id);
            $this->selectedPermissions = $user->permissions->pluck('name')->toArray();
        }
        $this->showPermissionsModal = true;
    }
    public function savePermissions(): void
    {
        try {
            if ($this->managingPermissionsFor === 'role'){
                $role = Role::findById($this->selectedRoleId);
                $role->syncPermissions($this->selectedPermissions);
                session()->flash('message', 'Role permissions updated successfully.');
            } else {
                $user = User::findOrFail($this->selectedUserId);
                $user->syncPermissions($this->selectedPermissions);
                session()->flash('message', 'User permissions updated successfully.');
            }
            $this->closePermissionsModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }
    public function closePermissionsModal(): void
    {
        $this->showPermissionsModal = false;
        $this->managingPermissionsFor = null;
        $this->selectedPermissions = [];
        $this->selectedRoleId = null;
        $this->selectedUserId = null;
    }
    public function resetInputFields(): void
    {
        $this->userId = null;
        $this->username = '';
        $this->firstName = '';
        $this->middleName = '';
        $this->lastName = '';
        $this->email = '';
        $this->password = '';
        $this->roleId = '';
        $this->isEditing = false;
    }
    public function openModal(): void
    {
        $this->isModalOpen = true;
        $this->resetInputFields();
    }
    public function closeModal(): void
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }
    public function edit($userId): void
    {
        $this->isEditing = true;
        $this->userId = $userId;
        $user = User::findOrFail($userId);

        $this->username = $user->username;
        $this->firstName = $user->first_name;
        $this->middleName = $user->middle_name;
        $this->lastName = $user->last_name;
        $this->email = $user->email;
        $this->roleId = $user->role_id;

        $this->isModalOpen = true;
    }
    public function save(): void
    {
        $validatedData = $this->validate($this->isEditing
            ? $this->getUpdateRules()
            : $this->rules
        );

        try {
            if ($this->isEditing) {
                $user = User::findOrFail($this->userId);
                $user->update([
                    'username' => $this->username,
                    'first_name' => $this->firstName,
                    'middle_name' => $this->middleName,
                    'last_name' => $this->lastName,
                    'email' => $this->email,
                    'role_id' => $this->roleId,
                ]);

                if ($this->password) {
                    $user->update(['password' => Hash::make($this->password)]);
                }

                // Update role
                $role = Role::findById($this->roleId);
                $user->syncRoles([$role->name]);

                session()->flash('message', 'User updated successfully.');
            } else {

                \Log::info('Creating new user with data:', [
                    'username' => $this->username,
                    'email' => $this->email,
                    'role_id' => $this->roleId
                ]);

                $user = User::create([
                    'username' => $this->username,
                    'first_name' => $this->firstName,
                    'middle_name' => $this->middleName,
                    'last_name' => $this->lastName,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'role_id' => $this->roleId,
                    'email_verified_at' => now(),
                ]);

                \Log::info('User created with ID: ' . $user->id);

                // Assign role
                $role = Role::findById($this->roleId);
                $user->assignRole($role->name);

                session()->flash('message', 'User created successfully.');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            \Log::error('Failed to create user: ' . $e->getMessage());
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }
    protected function getUpdateRules(): array
    {
        return [
            'username' => 'required|string|max:255|unique:users,username,'.$this->userId,
            'firstName' => 'required|string|max:255',
            'middleName' => 'nullable|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$this->userId,
            'password' => 'nullable|string|min:8',
            'roleId' => 'required|exists:roles,id',
        ];
    }
    public function delete($userId): void
    {
        try {
            $user = User::findOrFail($userId);
            $user->delete();
            session()->flash('message', 'User deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting user: ' . $e->getMessage());
        }
    }
    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('username', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%')
                        ->orWhere('first_name', 'like', '%'.$this->search.'%')
                        ->orWhere('last_name', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role_id', $this->roleFilter);
            })
            ->paginate(5);

        return view('livewire.user-management', [
            'users' => $users,
            'roles' => Role::all(),
            'permissions' => Permission::all(),
        ])->layout('layouts.app');
    }
}
