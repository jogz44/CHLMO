<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Livewire\Logs\ActivityLogs;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserManagement extends Component
{
    use WithPagination;
    public $selectedRolePermissions = [];
    public $isModalOpen = false, $isEditing = false;

    // User Management Properties
    public $userId, $username, $firstName, $middleName, $lastName, $password, $password_confirmation,
        $roles = [], $selectedRole;

    // For search and filter
    public $search = '', $roleFilter = '';

    // Permissions Management Properties
    public $selectedPermissions = [], $showPermissionsModal = false, $managingPermissionsFor = null,
        $selectedRoleId, $selectedUserId;


    protected $listeners = [
        'permissionUpdated' => 'handlePermissionUpdate',
        'roleUpdated' => 'handleRoleUpdate',
        'refreshComponent' => '$refresh'
    ];

    public $showDisableModal = false, $userToDisable = null, $confirmationPassword = '';
    public function handlePermissionUpdate(): void
    {
        // Refresh permissions data
        $this->dispatch('$refresh');

        // If permissions modal is open, refresh the permissions list
        if ($this->showPermissionsModal) {
            if ($this->managingPermissionsFor === 'role' && $this->selectedRoleId) {
                $role = Role::findById($this->selectedRoleId);
                $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
            } elseif ($this->managingPermissionsFor === 'user' && $this->selectedUserId) {
                $user = User::findOrFail($this->selectedUserId);
                $this->selectedPermissions = $user->permissions->pluck('name')->toArray();
            }
        }
    }
    public function handleRoleUpdate(): void
    {
        // Refresh the entire component to get updated role data
        $this->dispatch('$refresh');

        // If editing a user, refresh the role data
        if ($this->isModalOpen && $this->isEditing && $this->userId) {
            $user = User::findOrFail($this->userId);
//            $this->roleId = $user->role_id;
        }
    }
    public function mount()
    {
        $this->resetInputFields();
        // Fetch roles from the database
        $this->roles = Role::all();
    }
    protected $rules = [
        'username' => 'required|string|max:255|unique:users,username',
        'firstName' => 'required|string|max:255',
        'middleName' => 'nullable|string|max:255',
        'lastName' => 'required|string|max:255',
//        'email' => 'required|email|unique:users,email',
//        'password' => 'required|string|min:8',
        'password' => 'required|min:8|confirmed',
        'selectedRole' => 'required|exists:roles,id',
    ];
    public function openPermissionsModal($type, $id): void
    {
        $this->managingPermissionsFor = $type;
        if ($type === 'role') {
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
            if ($this->managingPermissionsFor === 'role') {
                $role = Role::findById($this->selectedRoleId);
                $role->syncPermissions($this->selectedPermissions);
                //                session()->flash('message', 'Role permissions updated successfully.');
                $this->dispatch('alert', [
                    'title' => 'Role permissions updated successfully!',
                    'message' => '<br><small>' . now()->calendar() . '</small>',
                    'type' => 'success'
                ]);
            } else {
                $user = User::findOrFail($this->selectedUserId);
                $user->syncPermissions($this->selectedPermissions);
                //                session()->flash('message', 'User permissions updated successfully.');
                $this->dispatch('alert', [
                    'title' => 'User permissions updated successfully!',
                    'message' => '<br><small>' . now()->calendar() . '</small>',
                    'type' => 'success'
                ]);
            }
            $this->closePermissionsModal();
            $this->dispatch('role-management', 'roleUpdated');
        } catch (\Exception $e) {
            //            session()->flash('error', 'Error: ' . $e->getMessage());
            $this->dispatch('alert', [
                'title' => 'Something went wrong!',
                'message' => $e->getMessage() . '<br><small>' . now()->calendar() . '</small>',
                'type' => 'danger'
            ]);
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
//        $this->email = '';
        $this->password = '';
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
//        $this->email = $user->email;

        $this->isModalOpen = true;
    }
    public function getPasswordStrengthProperty()
    {
        $length = strlen($this->password);

        if ($length === 0) {
            return null; // No feedback if password is empty
        }

        if ($length < 6) {
            return 'Weak';
        } elseif ($length < 10) {
            return 'Medium';
        } else {
            return 'Strong';
        }
    }


    public function save(): void
    {
        Log::info('Starting save process', ['isEditing' => $this->isEditing]);

        try {
            // Log data before validation to verify values
            Log::info('Data before validation', [
                'username' => $this->username,
//                'email' => $this->email,
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'password' => $this->password,
                'selectedRole' => $this->selectedRole
            ]);

            $validatedData = $this->validate(
                $this->isEditing
                    ? $this->getUpdateRules()
                    : $this->rules
            );

            Log::info('Validation passed', ['validatedData' => $validatedData]);

            if ($this->isEditing) {
                Log::info('Editing user', ['userId' => $this->userId]);

                $user = User::findOrFail($this->userId);
                $user->update([
                    'username' => $this->username,
                    'first_name' => $this->firstName,
                    'middle_name' => $this->middleName,
                    'last_name' => $this->lastName,
//                    'email' => $this->email,
                    'is_disabled' => false,
                ]);

                if ($this->password) {
                    Log::info('Updating password for user', ['userId' => $this->userId]);
                    $user->update(['password' => Hash::make($this->password)]);
                }

                $role = Role::findById($this->roleId);
                $user->syncRoles([$role->name]);

                  // Log the activity using ActivityLogs
                  $logger = new ActivityLogs();
                  $logger->logActivity('Update User', $user);

                Log::info('Role updated for user', ['userId' => $this->userId, 'role' => $role->name]);

                $this->dispatch('alert', [
                    'title' => 'User updated successfully!',
                    'message' => '<br><small>' . now()->calendar() . '</small>',
                    'type' => 'success'
                ]);
            } else {
                Log::info('Creating new user', [
                    'username' => $this->username,
//                    'email' => $this->email,
                ]);

                $user = User::create([
                    'username' => $this->username,
                    'first_name' => $this->firstName,
                    'middle_name' => $this->middleName,
                    'last_name' => $this->lastName,
//                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'is_disabled' => false,
//                    'email_verified_at' => now(),
                ]);
              
                $roleName = Role::findOrFail($this->selectedRole)->name;
                $user->assignRole($roleName);
              
                // Log the activity using ActivityLogs
                $logger = new ActivityLogs();
                $logger->logActivity('Create User', $user);


                Log::info('User created successfully', ['userId' => $user->id]);

//                $role = Role::findById($this->roleId);
//                $user->assignRole($role->name);
//                Log::info('Role assigned to new user', ['userId' => $user->id, 'role' => $role->name]);

                $this->dispatch('alert', [
                    'title' => 'User created successfully!',
                    'message' => '<br><small>' . now()->calendar() . '</small>',
                    'type' => 'success'
                ]);
            }

            $this->closeModal();
//            $this->dispatch('role-management', 'roleUpdated');
        } catch (\Illuminate\Validation\ValidationException $ve) {
            Log::error('Validation failed', [
                'errors' => $ve->errors(),
                'message' => $ve->getMessage()
            ]);
            $this->dispatch('alert', [
                'title' => 'Validation Error!',
                'message' => 'Please check your inputs.',
                'type' => 'warning'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in save process', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->dispatch('alert', [
                'title' => 'Something went wrong!',
                'message' => $e->getMessage() . '<br><small>' . now()->calendar() . '</small>',
                'type' => 'danger'
            ]);
        }
    }

    protected function getUpdateRules(): array
    {
        return [
            'username' => 'required|string|max:255|unique:users,username,' . $this->userId,
            'firstName' => 'required|string|max:255',
            'middleName' => 'nullable|string|max:255',
            'lastName' => 'required|string|max:255',
//            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => 'nullable|string|min:8',
        ];
    }
    public function delete($userId): void
    {
        try {
            $user = User::findOrFail($userId);
            $user->delete();
            //            session()->flash('message', 'User deleted successfully.');
            $this->dispatch('alert', [
                'title' => 'User deleted successfully!',
                'message' => '<br><small>' . now()->calendar() . '</small>',
                'type' => 'danger'
            ]);
            $this->dispatch('role-management', 'roleUpdated');
        } catch (\Exception $e) {
            //            session()->flash('error', 'Error deleting user: ' . $e->getMessage());
            $this->dispatch('alert', [
                'title' => 'Something went wrong!',
                'message' => $e->getMessage() . '<br><small>' . now()->calendar() . '</small>',
                'type' => 'danger'
            ]);
        }
    }

    public function updateRoleOptions(): void
    {
        $this->dispatch('refreshRoleOptions');
    }

    public function confirmDisable($userId): void
    {
        $this->userToDisable = $userId;
        $this->showDisableModal = true;
    }

    public function closeDisableModal(): void
    {
        $this->showDisableModal = false;
        $this->userToDisable = null;
        $this->confirmationPassword = '';
        $this->resetValidation('confirmationPassword');
    }

    public function disableUser(): void
    {
        $this->validate([
            'confirmationPassword' => 'required|string'
        ]);

        try {
            // Verify the password matches the authenticated user's password
            if (!Hash::check($this->confirmationPassword, auth()->user()->password)) {
                //                session()->flash('error', 'Invalid password.');
                $this->dispatch('alert', [
                    'title' => 'Invalid password!',
                    'message' => '<br><small>' . now()->calendar() . '</small>',
                    'type' => 'danger'
                ]);
                return;
            }

            $user = User::findOrFail($this->userToDisable);

            // Prevent disabling your own account
            if ($user->id === auth()->id()) {
                //                session()->flash('error', 'You cannot disable your own account.');
                $this->dispatch('alert', [
                    'title' => 'You cannot disable your own account!',
                    'message' => '<br><small>' . now()->calendar() . '</small>',
                    'type' => 'danger'
                ]);
                return;
            }

            // Prevent disabling admin accounts (role_id = 1)

//            if ($user->role_id === 1) {
////                session()->flash('error', 'Administrator accounts cannot be disabled.');
//                $this->dispatch('alert', [
//                    'title' => 'Administrator accounts cannot be disabled!',
//                    'message' => '<br><small>' . now()->calendar() . '</small>',
//                    'type' => 'danger'
//                ]);
//                return;
//            }

            $user->update(['is_disabled' => true]);

              // Log the activity using ActivityLogs
              $logger = new ActivityLogs();
              $logger->logActivity('Disabled User', $user);

            // Log the action for audit purposes
            // activity()
            //     ->performedOn($user)
            //     ->causedBy(auth()->user())
            //     ->log('disabled user account');

            //            session()->flash('message', 'User disabled successfully.');
            $this->dispatch('alert', [
                'title' => 'User disabled successfully!',
                'message' => '<br><small>' . now()->calendar() . '</small>',
                'type' => 'succes'
            ]);
            $this->closeDisableModal();
            $this->dispatch('role-management', 'roleUpdated');
        } catch (\Exception $e) {
            //            session()->flash('error', 'Error disabling user: ' . $e->getMessage());
            $this->dispatch('alert', [
                'title' => 'Error disabling user!',
                'message' => $e->getMessage() . '<br><small>' . now()->calendar() . '</small>',
                'type' => 'danger'
            ]);
        }
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('username', 'like', '%' . $this->search . '%')
//                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            })
//            ->when($this->roleFilter, function ($query) {
//                $query->where('role_id', $this->roleFilter);
//            })
//            ->with(['role' => function ($query) {
//                $query->with('permissions')->withoutGlobalScopes();
//            }])
            ->paginate(5);

        return view('livewire.user-management', [
            'users' => $users,
            'roles' => Role::all(),
//            'roles' => Role::with('permissions')->withoutGlobalScopes()->get(),
//            'permissions' => Permission::withoutGlobalScopes()->get(),
//            'selectedRolePermissions' => $this->selectedRolePermissions
        ])->layout('layouts.app');
    }
}
