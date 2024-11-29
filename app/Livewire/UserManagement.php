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
    public $isModalOpen = false, $isEditing = false;

    // User Management Properties
    public $userId, $username, $firstName, $middleName, $lastName, $password, $password_confirmation, $selectedRole;

    // For search and filter
    public $search = '', $roleFilter = '';

    // Disable user modal properties
    public $showDisableModal = false;
    public $userToDisable = null;
    public $confirmationPassword = '';

    protected $rules = [
        'username' => 'required|string|max:255|unique:users,username',
        'firstName' => 'required|string|max:255',
        'middleName' => 'nullable|string|max:255',
        'lastName' => 'required|string|max:255',
        'password' => 'required|min:8|confirmed',
        'selectedRole' => 'required|exists:roles,id',
    ];

    public function mount(): void
    {
        $this->resetInputFields();
    }

    public function resetInputFields(): void
    {
        $this->userId = null;
        $this->username = '';
        $this->firstName = '';
        $this->middleName = '';
        $this->lastName = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->selectedRole = '';
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
        $this->selectedRole = $user->roles->first()->id ?? null;

        $this->isModalOpen = true;
    }
    public function save(): void
    {
        try {
            $validatedData = $this->validate(
                $this->isEditing ? $this->getUpdateRules() : $this->rules
            );

            if ($this->isEditing) {
                $user = User::findOrFail($this->userId);
                $user->update([
                    'username' => $this->username,
                    'first_name' => $this->firstName,
                    'middle_name' => $this->middleName,
                    'last_name' => $this->lastName,
                    'is_disabled' => false,
                ]);

                if ($this->password) {
                    $user->update(['password' => Hash::make($this->password)]);
                }

                // Update role using Spatie
                $role = Role::findById($this->selectedRole);
                $user->syncRoles([$role->name]);

                // Log the activity
                $logger = new ActivityLogs();
                $logger->logActivity('Update User', $user);

                $this->dispatch('alert', [
                    'title' => 'User updated successfully!',
                    'message' => '<br><small>' . now()->calendar() . '</small>',
                    'type' => 'success'
                ]);
            } else {
                $user = User::create([
                    'username' => $this->username,
                    'first_name' => $this->firstName,
                    'middle_name' => $this->middleName,
                    'last_name' => $this->lastName,
                    'password' => Hash::make($this->password),
                    'is_disabled' => false,
                ]);

                // Assign role using Spatie
                $role = Role::findById($this->selectedRole);
                $user->assignRole($role);

                // Log the activity
                $logger = new ActivityLogs();
                $logger->logActivity('Create User', $user);

                $this->dispatch('alert', [
                    'title' => 'User created successfully!',
                    'message' => '<br><small>' . now()->calendar() . '</small>',
                    'type' => 'success'
                ]);
            }

            $this->closeModal();
        } catch (\Exception $e) {
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
            'password' => 'nullable|min:8|confirmed',
            'selectedRole' => 'required|exists:roles,id',
        ];
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
            'confirmationPassword' => 'required|current_password'
        ]);

        try {
            $user = User::findOrFail($this->userToDisable);

            // Check if trying to disable own account
            if ($user->id === auth()->id()) {
                throw new \Exception('You cannot disable your own account.');
            }

            // Check if trying to disable a super_admin
            if ($user->hasRole('super_admin')) {
                throw new \Exception('Super Admin accounts cannot be disabled.');
            }

            // Check if current user is not super_admin but trying to disable an admin
            if ($user->hasRole('admin') && !auth()->user()->hasRole('super_admin')) {
                throw new \Exception('Only Super Admins can disable Administrator accounts.');
            }

            $user->update(['is_disabled' => true]);

            // Log the activity
            $logger = new ActivityLogs();
            $logger->logActivity('Disabled User', $user);

            $this->dispatch('alert', [
                'title' => 'User disabled successfully!',
                'message' => '<br><small>' . now()->calendar() . '</small>',
                'type' => 'success'
            ]);

            $this->closeDisableModal();
        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'title' => 'Error disabling user!',
                'message' => $e->getMessage() . '<br><small>' . now()->calendar() . '</small>',
                'type' => 'danger'
            ]);
        }
    }

    public function confirmEnable($userId): void
    {
        try {
            $user = User::findOrFail($userId);
            $user->update(['is_disabled' => false]);

            // Log the activity
            $logger = new ActivityLogs();
            $logger->logActivity('Enabled User', $user);

            $this->dispatch('alert', [
                'title' => 'User enabled successfully!',
                'message' => '<br><small>' . now()->calendar() . '</small>',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'title' => 'Error enabling user!',
                'message' => $e->getMessage() . '<br><small>' . now()->calendar() . '</small>',
                'type' => 'danger'
            ]);
        }
    }

    public function render()
    {
        $query = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('username', 'like', '%' . $this->search . '%')
                        ->orWhere('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('id', $this->roleFilter);
                });
            })
            ->with('roles');

        return view('livewire.user-management', [
            'users' => $query->paginate(5),
            'roles' => Role::all(),
        ])->layout('layouts.app');
    }
}
