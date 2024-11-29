@php use App\Models\User; @endphp
<div>
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">User Management</h2>
        <button
                wire:click="openModal"
                class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white px-4 py-2 rounded">
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
                    Role
                </th>
                <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Status
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
                            {{ $user->roles->first()->name ?? 'No Role' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_disabled ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $user->is_disabled ? 'Disabled' : 'Active' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                            @if(!$user->is_disabled)
                                <button
                                        wire:click="edit({{ $user->id }})"
                                        class="text-custom-green mr-2 underline">
                                    Edit
                                </button>
                                <button
                                        wire:click="confirmDisable({{ $user->id }})"
                                        class="bg-custom-dark-green text-white px-2 py-1 rounded-md">
                                    Disable
                                </button>
                            @else
                                <button
                                        wire:click="confirmEnable({{ $user->id }})"
                                        class="bg-blue-600 text-white px-2 py-1 rounded-md hover:bg-blue-700">
                                    Enable User
                                </button>
                            @endif
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
                                <input type="text"
                                       wire:model="username"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- First Name -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                                <input type="text"
                                       wire:model="firstName"
                                       class="capitalize shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       oninput="capitalizeInput(this)">
                                @error('firstName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Middle Name -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Middle Name</label>
                                <input type="text"
                                       wire:model="middleName"
                                       class="capitalize shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       oninput="capitalizeInput(this)">
                                @error('middleName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Last Name -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                                <input type="text"
                                       wire:model="lastName"
                                       class="capitalize shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       oninput="capitalizeInput(this)">
                                @error('lastName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-4 relative">
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    Password {{ $isEditing ? '(Leave blank to keep current)' : '' }}
                                </label>
                                <div class="relative">
                                    <input type="password" wire:model.debounce.500ms="password" id="password"
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline pr-10">
                                    <button type="button"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500"
                                            onclick="togglePasswordVisibility('password')">
                                        👁️
                                    </button>
                                </div>
                                @if($password)
                                    <p class="text-xs text-gray-500 mt-1">Password strength: {{ $this->passwordStrength }}</p>
                                @endif
                                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>


                            <!-- Confirm Password -->
                            <div class="mb-4 relative">
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    Confirm Password
                                </label>
                                <div class="relative">
                                    <input type="password" wire:model="password_confirmation" id="confirm_password"
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline pr-10">
                                    <button type="button"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500"
                                            onclick="togglePasswordVisibility('confirm_password')">
                                        👁️
                                    </button>
                                </div>
                                @if($password_confirmation && $password !== $password_confirmation)
                                    <p class="text-xs text-red-500 mt-1">Passwords do not match.</p>
                                @endif
                                @error('password_confirmation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Roles -->
                            <div>
                                <label for="role">Role</label>
                                <select wire:model="selectedRole" id="role" class="bg-white shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                                    <option value="">Select a role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name}}</option>
                                    @endforeach
                                </select>
                                @error('selectedRole') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <div>
                                    <div class="alert"
                                         :class="{primary:'alert-primary', success:'alert-success', danger:'alert-danger', warning:'alert-warning'}[(alert.type ?? 'primary')]"
                                         x-data="{ open:false, alert:{} }"
                                         x-show="open" x-cloak
                                         x-transition:enter="animate-alert-show"
                                         x-transition:leave="animate-alert-hide"
                                         @alert.window="open = true; setTimeout( () => open=false, 3000 ); alert=$event.detail[0]">
                                        <div class="alert-wrapper">
                                            <strong x-html="alert.title">Title</strong>
                                            <p x-html="alert.message">Description</p>
                                        </div>
                                        <i class="alert-close fa-solid fa-xmark" @click="open=false"></i>
                                    </div>
                                        <!-- SUBMIT Button -->
                                    <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-500 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue sm:text-sm sm:leading-5">
                                        {{ $isEditing ? 'Update' : 'Save' }}
                                        <div wire:loading>
                                            <svg aria-hidden="true"
                                                 class="w-3.5 h-3.5 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                                 viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                        fill="currentColor" />
                                                <path
                                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                        fill="currentFill" />
                                            </svg>
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </button>
                                </div>
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

    <!-- Confirm Disable modal -->
    <div x-show="$wire.showDisableModal"
         class="fixed inset-0 z-50 overflow-y-auto"
         x-cloak>
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

            <!-- Modal panel -->
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Confirm User Disable
                            </h3>
                            <div class="mt-4">
                                @if($userToDisable)
                                    @if($userToDisable === auth()->id())
                                        <p class="text-sm text-red-500 font-medium">
                                            You cannot disable your own account.
                                        </p>
                                    @elseif(User::find($userToDisable)?->hasRole('Super Admin'))
                                        <p class="text-sm text-red-500 font-medium">
                                            Super Admin accounts cannot be disabled.
                                        </p>
                                    @elseif(User::find($userToDisable)?->hasRole('Housing System Admin') && !auth()->user()->hasRole('Super Admin'))
                                        <p class="text-sm text-red-500 font-medium">
                                            Only Super Admins can disable Administrator accounts.
                                        </p>
                                    @elseif(User::find($userToDisable)?->hasRole('Shelter System Admin') && !auth()->user()->hasRole('Super Admin'))
                                        <p class="text-sm text-red-500 font-medium">
                                            Only Super Admins can disable Administrator accounts.
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-500">
                                            Please enter your password to confirm disabling this user.
                                        </p>
                                        <div class="mt-4">
                                            <input type="password"
                                                   wire:model="confirmationPassword"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                                   placeholder="Enter your password">
                                            @error('confirmationPassword')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                    <!-- Alert Component -->
                    <div class="alert"
                         :class="{primary:'alert-primary', success:'alert-success', danger:'alert-danger', warning:'alert-warning'}[(alert.type ?? 'primary')]"
                         x-data="{ open:false, alert:{} }"
                         x-show="open" x-cloak
                         x-transition:enter="animate-alert-show"
                         x-transition:leave="animate-alert-hide"
                         @alert.window="open = true; setTimeout(() => open=false, 3000); alert=$event.detail[0]">
                        <div class="alert-wrapper">
                            <strong x-html="alert.title">Title</strong>
                            <p x-html="alert.message">Description</p>
                        </div>
                        <i class="alert-close fa-solid fa-xmark" @click="open=false"></i>
                    </div>

                    <!-- Action Buttons -->
                    <div class="sm:flex sm:flex-row-reverse">
                        @if($userToDisable)
                            @php
                                $userToDisableModel = User::find($userToDisable);
                            @endphp

                            @if(!($userToDisable === auth()->id() ||
                                $userToDisableModel?->hasRole('Super Admin') ||
                                ($userToDisableModel?->hasRole('Housing System Admin') && !auth()->user()->hasRole('Super Admin')) ||
                                ($userToDisableModel?->hasRole('Shelter System Admin') && !auth()->user()->hasRole('Super Admin'))))
                                <button wire:click="disableUser"
                                        class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Disable User
                                    <div wire:loading wire:target="disableUser">
                                        <svg aria-hidden="true"
                                             class="w-3.5 h-3.5 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                             viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                        </svg>
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </button>
                            @endif

                            <button wire:click="closeDisableModal"
                                    class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                                {{ $userToDisable === auth()->id() ||
                                   $userToDisableModel?->hasRole('Super Admin') ||
                                   ($userToDisableModel?->hasRole('Housing System Admin') && !auth()->user()->hasRole('Super Admin')) ||
                                   ($userToDisableModel?->hasRole('Shelter System Admin') && !auth()->user()->hasRole('Super Admin'))
                                   ? 'Close' : 'Cancel' }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            let obj = @json(session('alert') ?? []);
            if (Object.keys(obj).length) {
                Livewire.dispatch('alert', [obj])
            }
        });
    </script>
</div>
<script>
    function capitalizeInput(input) {
        input.value = input.value.toLowerCase().replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }
</script>
<script>
    function togglePasswordVisibility(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
