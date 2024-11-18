<!-- Header -->
<div>
    <div class="grid grid-cols-2 gap-4">
        <!-- Role Table -->
        <div class="p-4 rounded-md shadow-md">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold">Roles</h2>
                <button
                        wire:click="openRoleModal"
                        class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white text-xs font-semibold px-6 py-2 rounded">
                    Add New Role
                </button>
            </div>

            <div class="overflow-x-auto overflow-y-auto">
                <table class="min-w-full bg-white border-collapse">
                    <thead>
                    <tr>
                        <th class="px-4 py-3 border-b bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Role
                        </th>
                        <th class="px-4 py-3 border-b bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Permissions
                        </th>
                        <th class="px-4 py-3 border-b bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td class="px-4 py-3 border-b border-gray-200 whitespace-nowrap">
                                    {{ $role->name ?? 'No Role' }}
                                </td>
                                <td class="px-4 py-3 border-b border-gray-200">
                                    <ul class="list-disc pl-5">
                                        @foreach($role->permissions as $permission)
                                            <li>{{ $permission->name }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-4 py-3 border-b border-gray-200">
                                    <button
                                            wire:click="editRole({{ $role->id }})"
                                            class="text-custom-green mr-3">
                                        Edit
                                    </button>
                                    <button
                                            wire:click="deleteRole({{ $role->id }})"
                                            class="text-custom-dark-green"
                                            onclick="return confirm('Are you sure you want to delete this role?')">
                                        Disable
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Role management modal -->
        @if($isRoleModalOpen)
            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form wire:submit.prevent="save">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <!-- Role name -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Add Role</label>
                                    <input type="text"
                                           wire:model="roleName"
                                           class="capitalize shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           oninput="capitalizeInput(this)">
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Permissions -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Select Permissions</label>
                                    <div class="mt-4 space-y-4">
                                        @foreach($permissions as $permission)
                                            <div class="flex items-center">
                                                <input type="checkbox" value="{{ $permission->id }}"
                                                       wire:model="selectedPermissions"
                                                       id="permission_{{ $permission->id }}"
                                                       class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                                <label for="permission_{{ $permission->id }}"
                                                       class="ml-2">{{ $permission->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('selectedPermissions') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-500 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue sm:text-sm sm:leading-5">
                                    {{ $isRoleEditing ? 'Update' : 'Save' }}
                                </button>
                            </span>
                                <span class="flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                <button type="button" wire:click="closeRoleModal" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue sm:text-sm sm:leading-5">
                                    Cancel
                                </button>
                            </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <!-- Permissions Table -->
        <div class="p-4 rounded-md shadow-md">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold">Permissions</h2>
                <button
                        wire:click="openPermissionModal"
                        class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white text-xs font-semibold px-6 py-2 rounded">
                    Add New Permission
                </button>
            </div>

            <div class="overflow-x-auto overflow-y-auto">
                <table class="min-w-full bg-white border-collapse">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 border-b bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Permissions
                            </th>
                            <th class="px-4 py-3 border-b bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                            <tr>
                                <td class="px-4 py-3 border-b border-gray-200 whitespace-nowrap">
                                    {{ $permission->name ?? 'No Permission' }}
                                </td>
                                <td class="px-4 py-3 border-b border-gray-200">
                                    <button
                                            wire:click="edit({{ $role->id }})"
                                            class="text-custom-green mr-4">
                                        Edit
                                    </button>
                                    <button
                                            wire:click="deleteRole({{ $role->id }})"
                                            class="text-custom-dark-green"
                                            onclick="return confirm('Are you sure you want to delete this role?')">
                                        Disable
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Permission management modal -->
        @if($isPermissionModalOpen)
            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form wire:submit.prevent="savePermission">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <!-- Role name -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Permission</label>
                                    <input type="text"
                                           wire:model="permissionName"
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           oninput="capitalizeInput(this)">
                                    @error('permissionName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Assigned Roles</label>
                                    <div class="mt-4 space-y-4">
                                        @foreach($roles as $role)
                                            <div class="flex items-center">
                                                <input type="checkbox" value="{{ $role->id }}" wire:model="selectedRoles" id="role_{{ $role->id }}" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                                <label for="role_{{ $role->id }}" class="ml-2">{{ $role->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('selectedRoles') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-500 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue sm:text-sm sm:leading-5">
                                    {{ $isPermissionEditing ? 'Update' : 'Save' }}
                                </button>
                            </span>
                                <span class="flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                <button type="button" wire:click="closePermissionModal" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue sm:text-sm sm:leading-5">
                                    Cancel
                                </button>
                            </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<script>
    function capitalizeInput(input) {
        input.value = input.value.toLowerCase().replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }
</script>

