<div class="font-poppins text-black" x-data="{ open: false, activeLink: localStorage.getItem('activeLink') || '', activeChildLink: localStorage.getItem('activeChildLink') || '' }">

    <div>
        <!-- Sidebar -->
        <aside :class="open ? 'block' : 'hidden md:block'" class="app-sidebar">
            <div class="text-20 font-bold mb-4 ml-1 flex items-center">
                <div class="w-[85%] h-auto inline-block">
                    <a href="{{ route('dashboard') }}" class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline"><x-application-sidebar-logo/></a>
                </div>
            </div>
            <!-- SIDEBAR MENU -->
            <nav class="space-y-2 mt-15 text-[13px]" x-data="{
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