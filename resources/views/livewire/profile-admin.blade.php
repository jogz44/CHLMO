<div class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex flex-col lg:flex-row p-6 h-screen bg-transparent">
        
        <livewire:profile-photo-upload />

        <!-- Right Section (Form) -->
        <div x-data="{ isEditing: @entangle('isEditing') }" class="w-full lg:w-2/3 mt-6 lg:mt-0">
            <div class="bg-white shadow-lg p-6 rounded-md">
                <h3 class="text-[13px] font-semibold mb-4">Personal Information</h3>

                <!-- Livewire Form -->
                <form wire:submit.prevent="save">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <label class="block text-[13px] font-medium text-gray-700">First Name</label>
                            <input type="text" wire:model="first_name" :disabled="!isEditing"
                                class="mt-1 text-[13px] block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>

                        <div class="col-span-1">
                            <label class="block text-[13px] font-medium text-gray-700">Middle Name</label>
                            <input type="text" wire:model="middle_name" :disabled="!isEditing"
                                class="mt-1 text-[13px] block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>

                        <div class="col-span-1">
                            <label class="block text-[13px] font-medium text-gray-700">Last Name</label>
                            <input type="text" wire:model="last_name" :disabled="!isEditing"
                                class="mt-1 text-[13px] block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>

                        <div class="col-span-1">
                            <label class="block text-[13px] font-medium text-gray-700">Email</label>
                            <input type="email" wire:model="email" :disabled="!isEditing"
                                class="mt-1 text-[13px] block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>

                        <div class="col-span-1">
                            <label class="block text-[13px] font-medium text-gray-700">Designation</label>
                            <input type="role" wire:model=" " :disabled="!isEditing" value="{{ Auth::user()->getRoleNames()->first() }}"
                                class="mt-1 text-[13px] block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>

                        <div class="col-span-1">
                            <label class="block text-[13px] font-medium text-gray-700">Username</label>
                            <input type="text" wire:model="username" :disabled="!isEditing"
                                class="mt-1 text-[13px] block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>

                    </div>

                    <div class="mt-4 flex justify-end">
                        <button type="button" wire:click="toggleEditMode"
                            class="mr-4 text-[13px] px-4 py-2 bg-custom-yellow text-white hover:bg-orange-500 rounded-full">
                            {{ $isEditing ? 'Cancel' : 'Edit Profile' }}
                        </button>
                        <button type="submit" wire:click="save"
                            x-show="isEditing"
                            class="px-4 text-[13px] py-2 bg-green-500 text-white rounded-full hover:bg-green-600">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
