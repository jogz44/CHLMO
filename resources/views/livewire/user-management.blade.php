<div class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <!-- Main Content -->
        <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">
            <div class="p-6">
                <!-- Top Navigation Bar -->
                <div x-data="{ activeTab: 'users' }" class="space-y-4 mb-6">
                    <div class="flex space-x-4">
                        <button
                                @click="activeTab = 'users'"
                                :class="{'text-green-500': activeTab === 'users', 'text-gray-500': activeTab !== 'users'}"
                                class="font-semibold focus:outline-none text-[14px]">
                            Users
                        </button>
                        <button
                                @click="activeTab = 'roles'"
                                :class="{'text-green-500': activeTab === 'roles', 'text-gray-500': activeTab !== 'roles'}"
                                class="font-semibold focus:outline-none text-[14px]">
                            Roles
                        </button>
                        <button
                                @click="activeTab = 'permissions'"
                                :class="{'text-green-500': activeTab === 'permissions', 'text-gray-500': activeTab !== 'permissions'}"
                                class="font-semibold focus:outline-none text-[14px]">
                            Permissions
                        </button>
                    </div>

                    <div x-show="activeTab === 'users'">
                        <!-- Header -->
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-semibold">User Management</h2>
                            <button
                                    wire:click="openModal"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add New User
                            </button>
                        </div>

                        <!-- Search and Filter -->
                        <div class="mb-4 flex gap-4">
                            <div class="flex-1">
                                <input
                                        wire:model.live.debounce.300ms="search"
                                        type="text"
                                        placeholder="Search users..."
                                        class="w-full px-4 py-2 border rounded">
                            </div>
                            <div class="w-64">
                                <select
                                        wire:model.live="roleFilter"
                                        class="w-full px-4 py-2 border rounded">
                                    <option value="">All Roles</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Users Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Username
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Role
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                            {{ $user->username }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                            {{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                            {{ $user->roles->first()->name ?? 'No Role' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                            <button
                                                    wire:click="edit({{ $user->id }})"
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded mr-2">
                                                Edit
                                            </button>
                                            <button
                                                    wire:click="openPermissionsModal('user', {{ $user->id }})">
                                                Manage Permissions
                                            </button>
                                            <button
                                                    wire:click="delete({{ $user->id }})"
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>

                        <!-- User management modal -->
                        @if($isModalOpen)
                            <div class="fixed z-10 inset-0 overflow-y-auto">
                                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div class="fixed inset-0 transition-opacity">
                                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                    </div>
                                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                        <form wire:submit.prevent="save">
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <!-- Username -->
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                                                    <input type="text" wire:model="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    @error('username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>

                                                <!-- First Name -->
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                                                    <input type="text" wire:model="firstName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    @error('firstName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>

                                                <!-- Middle Name -->
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2">Middle Name</label>
                                                    <input type="text" wire:model="middleName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    @error('middleName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>

                                                <!-- Last Name -->
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                                                    <input type="text" wire:model="lastName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    @error('lastName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>

                                                <!-- Email -->
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                                                    <input type="email" wire:model="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>

                                                <!-- Password -->
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                                        Password {{ $isEditing ? '(Leave blank to keep current)' : '' }}
                                                    </label>
                                                    <input type="password" wire:model="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>

                                                <!-- Role -->
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                                                    <select wire:model="roleId" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                        <option value="">Select Role</option>
                                                        @foreach($roles as $role)
                                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('roleId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                            </div>

                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-500 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue sm:text-sm sm:leading-5">
                                    {{ $isEditing ? 'Update' : 'Save' }}
                                </button>
                            </span>
                                                <span class="flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                <button type="button" wire:click="closeModal" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue sm:text-sm sm:leading-5">
                                    Cancel
                                </button>
                            </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Permissions Modal -->
                        @if($showPermissionsModal)
                            <div class="fixed z-10 inset-0 overflow-y-auto">
                                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div class="fixed inset-0 transition-opacity">
                                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                    </div>

                                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <h3 class="text-lg font-medium text-gray-900">
                                                Manage Permissions for {{ $managingPermissionsFor === 'role' ? 'Role' : 'User' }}
                                            </h3>

                                            <div class="mt-4 space-y-4">
                                                @foreach($permissions as $permission)
                                                    <div class="flex items-center">
                                                        <input
                                                                type="checkbox"
                                                                value="{{ $permission->name }}"
                                                                wire:model="selectedPermissions"
                                                                id="permission_{{ $permission->id }}"
                                                                class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                                        <label for="permission_{{ $permission->id }}" class="ml-2">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button wire:click="savePermissions" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                                Save Permissions
                                            </button>
                                            <button wire:click="closePermissionsModal" class="mt-3 inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <livewire:role-management/>

                    <div x-show="activeTab === 'permissions'">
                        <h1>Permissions Management</h1>
                    </div>
                    <!-- end of Permissions contents -->
                </div>
            </div>
        </div>
    </div>
</div>
