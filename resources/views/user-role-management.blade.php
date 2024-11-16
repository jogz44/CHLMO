<x-app-layout>
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
                                Roles & Permissions
                            </button>
{{--                            <button--}}
{{--                                    @click="activeTab = 'permissions'"--}}
{{--                                    :class="{'text-green-500': activeTab === 'permissions', 'text-gray-500': activeTab !== 'permissions'}"--}}
{{--                                    class="font-semibold focus:outline-none text-[14px]">--}}
{{--                                Permissions--}}
{{--                            </button>--}}
                        </div>

                        <div x-show="activeTab === 'users'">
                            <livewire:user-management />
                        </div>

                        <div x-show="activeTab === 'roles'">
                            <livewire:role-management />
                        </div>

{{--                        <div x-show="activeTab === 'permissions'">--}}
{{--                            <livewire:permissions-management />--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>