<!-- Role Management -->
<div x-show="activeTab === 'roles'">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Role Management</h2>
        <button
                wire:click="openModal"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Role
        </button>
    </div>

    <!-- Search and Filter -->
    <div class="mb-4 flex gap-4">
        <div class="flex-1">
            <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="Search roles..."
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

    <!-- Role Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
            <tr>
                <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Role
                </th>
                <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($roles as $role)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                        {{ $role->name ?? 'No Role' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                        <button
                                wire:click="editRole({{ $role->id }})"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded mr-2">
                            Edit
                        </button>
                        <button wire:click="openPermissionsModal('role', {{ $role->id }})">
                            Manage Permissions
                        </button>
                        <button
                                wire:click="deleteRole({{ $role->id }})"
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
    {{--                        <div class="mt-4">--}}
    {{--                            {{ $roles->links() }}--}}
    {{--                        </div>--}}
</div>
