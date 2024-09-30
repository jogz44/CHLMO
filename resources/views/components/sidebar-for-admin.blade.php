<div class="bg-none shadow-md font-poppins text-black 0 p-0 " x-data="{ open: false, activeLink: localStorage.getItem('activeLink') || '', activeChildLink: localStorage.getItem('activeChildLink') || '' }">

    <div class="flex h-[100vh]">
        <!-- Sidebar -->
        <aside :class="open ? 'block' : 'hidden md:block'" class="fixed w-[17%] bg-[#ffffff] max-h-screen  py-3 pl-4 pr-2 md:block mr-2 pb-[8px] shadow-lg ">
            <div class="text-20 font-bold mb-4 ml-1 flex items-center ">
                <div class="w-[85%] h-auto inline-block">
                    <a href="{{ route('dashboard') }}" class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline"><x-application-sidebar-logo/></a>
                </div>
            </div>
            <!-- SIDEBAR MENU -->
            <nav class="space-y-2 mt-15 flex-1 text-[13px] h-[calc(100vh-4rem)] overflow-auto scrollbar-hidden" x-data="{
                    activeLink: localStorage.getItem('activeLink') || '',
                    activeChildLink: localStorage.getItem('activeChildLink') || ''}">

                <x-admin-link
                        :href="route('admin.roles.index')"
                        :active="request()->routeIs('admin.roles.index')"
                        :class="request()->routeIs('admin.roles.index') ? 'bg-gray-200' : 'bg-gray-200'">
                    Roles
                </x-admin-link>
                <x-admin-link
                        :href="route('admin.permissions.index')"
                        :active="request()->routeIs('admin.permissions.index')">
                    Permissions
                </x-admin-link>
                <x-admin-link
                        :href="route('admin.users.index')"
                        :active="request()->routeIs('admin.users.index')">
                    Users
                </x-admin-link>
            </nav>
        </aside>
    </div>
</div>