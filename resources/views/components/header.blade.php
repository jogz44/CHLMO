<div class="flex-1 flex flex-col ml-[17%] mt-[-50%]">
    <!-- Header for large screens -->
    <header class="fixed top-0 left-0 bg-[#ffffff] p-3 hidden md:flex w-full justify-between items-center z-10" style="width: calc(100% - 17%); left: 17%; max-width: calc(100% - 17%);">
        <!-- Navigation Links -->
         
        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('HOUSING') }}
            </x-nav-link>
            @role('ShelterAdmin')
            <x-nav-link href="{{ route('shelter-dashboard') }}" :active="request()->routeIs('shelter-dashboard')">
                {{ __('SHELTER ASSISTANCE') }}
            </x-nav-link>
            @endrole
            @role('Admin')
            <x-nav-link href="{{ route('shelter-dashboard') }}" :active="request()->routeIs('shelter-dashboard')">
                {{ __('SHELTER ASSISTANCE') }}
            </x-nav-link>
            <x-nav-link href="{{ route('admin.index') }}" :active="request()->routeIs('admin.index')">
                {{ __('ADMIN') }}
            </x-nav-link>
            @endrole
        </div>

        <!-- Right-aligned container for         and Profile -->
        <div class="flex items-center ml-auto space-x-2">
            <!-- Search -->
            <div class="relative hidden md:block mr-2">
                <svg class="absolute top-[13px] left-4" width="19" height="19" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.625 16.625C13.491 16.625 16.625 13.491 16.625 9.625C16.625 5.75901 13.491 2.625 9.625 2.625C5.75901 2.625 2.625 5.75901 2.625 9.625C2.625 13.491 5.75901 16.625 9.625 16.625Z" stroke="#787C7F" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M18.3746 18.375L14.5684 14.5688" stroke="#787C7F" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <input type="search" name="search" id="search" class="rounded-full px-12 py-2 placeholder:text-[13px] outline-none border-none bg-[#f7f7f9] hover:ring-[#BA2C2C] focus:ring-[#BA2C2C]" placeholder="Search Anything">
            </div>

            <!-- Profile Section -->
            <div x-data="{ showProfile: false }" class="relative rounded-full py-[-4px] px-2">
                <!-- Toggle Button for Profile Menu -->
                <button @click="showProfile = !showProfile" class="flex items-center w-30">
                    <!-- User Image (SVG) -->
                    <svg class="w-8 h-8 rounded-full bg-gray-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-3.33 0-10 1.67-10 5v1h20v-1c0-3.33-6.67-5-10-5z" />
                    </svg>
                    <!-- User Name -->
                    <div class="flex flex-col">
                        <p class="text-[13px] ml-2 font-medium">{{ Auth::user()->first_name }}</p>
                        <p class="text-[12px] ml-2 font-light text-gray-500">{{ Auth::user()->getRoleNames()->first() }}</p>
                    </div>

                </button>

                <!-- Dropdown Menu -->
                <div x-cloak x-show="showProfile" class="absolute bg-white rounded-lg shadfow-md right-0 top-12 w-56 z-50 transition duration-300 ease-in-out transform origin-top" :class="{ 'scale-y-100': showProfile, 'scale-y-0': !showProfile }">
                    <ul class="block text-sm divide-y py-1 text-[#4F6065]">
                        <!-- User Profile -->
                        <li>
                            <a href="{{ route('profile') }}" @click="showProfile = false; subTmsActiveItem = ''; subActiveItem = ''; show = false; showManage = false; setActiveTab('profile')" class="flex items-center gap-3 px-4 py-2 hover:text-[#19323C] hover:bg-gray-200">
                                <!-- User Image (SVG) -->
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-9 h-9"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM15 9C15 10.6569 13.6569 12 12 12C10.3431 12 9 10.6569 9 9C9 7.34315 10.3431 6 12 6C13.6569 6 15 7.34315 15 9ZM12 20.5C13.784 20.5 15.4397 19.9504 16.8069 19.0112C17.4108 18.5964 17.6688 17.8062 17.3178 17.1632C16.59 15.8303 15.0902 15 11.9999 15C8.90969 15 7.40997 15.8302 6.68214 17.1632C6.33105 17.8062 6.5891 18.5963 7.19296 19.0111C8.56018 19.9503 10.2159 20.5 12 20.5Z" fill="#000000"></path> </g></svg>
                                <!-- User Name -->
                                <p class="text-sm font-sm">{{ Auth::user()->first_name }} {{ Auth::user()->middle_name }} {{ Auth::user()->last_name }}</p>
                            </a>
                        </li>
                        <li>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
{{--                                <button type="submit" @click="showProfile = false; subTmsActiveItem = ''; subActiveItem = ''; show = false; showManage = false; setActiveTab('dashboard')" class="w-full flex gap-3 items-center px-4 py-2 hover:text-[#19323C] hover:bg-gray-200">--}}
{{--                                    <p class="group relative">Sign Out</p>--}}
{{--                                </button>--}}
                                    <x-responsive-nav-link href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-responsive-nav-link>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
</div>

{{--<!-- Primary Navigation Menu -->--}}
{{--<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">--}}
{{--    <div class="flex justify-between h-16">--}}
{{--        <div class="flex">--}}
{{--            <!-- Logo -->--}}
{{--<!--            <div class="shrink-0 flex items-center">-->--}}
{{--<!--                <a href="{{ route('dashboard') }}">-->--}}
{{--<!--                        <x-application-mark class="block h-9 w-auto" />-->--}}
{{--<!--                    </a>-->--}}
{{--<!--            </div>-->--}}

{{--            <!-- Navigation Links -->--}}
{{--            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">--}}
{{--                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">--}}
{{--                    {{ __('Dashboard') }}--}}
{{--                </x-nav-link>--}}
{{--                @role('admin')--}}
{{--                <x-nav-link href="{{ route('admin.index') }}" :active="request()->routeIs('admin.index')">--}}
{{--                    {{ __('Admin') }}--}}
{{--                </x-nav-link>--}}
{{--                @endrole--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="hidden sm:flex sm:items-center sm:ml-6">--}}
{{--            <!-- Settings Dropdown -->--}}
{{--            <div class="ml-3 relative">--}}
{{--                <x-dropdown align="right" width="48">--}}
{{--                    <x-slot name="trigger">--}}
{{--                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">--}}
{{--                            <div>{{ Auth::user()->name }}</div>--}}
{{--                            <div class="ml-1">--}}
{{--                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">--}}
{{--                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />--}}
{{--                                </svg>--}}
{{--                            </div>--}}
{{--                        </button>--}}
{{--                    </x-slot>--}}

{{--                    <x-slot name="content">--}}
{{--                        <x-dropdown-link href="{{ route('profile.show') }}">--}}
{{--                            {{ __('Profile') }}--}}
{{--                        </x-dropdown-link>--}}

{{--                        <!-- Authentication -->--}}
{{--                        <form method="POST" action="{{ route('logout') }}">--}}
{{--                            @csrf--}}
{{--                            <x-dropdown-link href="{{ route('logout') }}"--}}
{{--                                             onclick="event.preventDefault(); --}}
{{--                                                        this.closest('form').submit();">--}}
{{--                                {{ __('Log Out') }}--}}
{{--                            </x-dropdown-link>--}}
{{--                        </form>--}}
{{--                    </x-slot>--}}
{{--                </x-dropdown>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <!-- Hamburger -->--}}
{{--        <div class="-mr-2 flex items-center sm:hidden">--}}
{{--            <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">--}}
{{--                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">--}}
{{--                    <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>--}}
{{--                    <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>--}}
{{--                </svg>--}}
{{--            </button>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<!-- Responsive Navigation Menu -->--}}
{{--<div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">--}}
{{--    <div class="pt-2 pb-3 space-y-1">--}}
{{--        <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">--}}
{{--            {{ __('Dashboard') }}--}}
{{--        </x-responsive-nav-link>--}}
{{--        @role('admin')--}}
{{--        <x-responsive-nav-link href="{{ route('admin.roles.index') }}" :active="request()->routeIs('admin.roles.index')">--}}
{{--            {{ __('Admin') }}--}}
{{--        </x-responsive-nav-link>--}}
{{--        @endrole--}}
{{--    </div>--}}

{{--    <!-- Responsive Settings Options -->--}}
{{--    <div class="pt-4 pb-1 border-t border-gray-200">--}}
{{--        <div class="px-4">--}}
{{--            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>--}}
{{--            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>--}}
{{--        </div>--}}

{{--        <div class="mt-3 space-y-1">--}}

{{--            <x-responsive-nav-link href="{{ route('profile.show') }}">--}}
{{--                {{ __('Profile') }}--}}
{{--            </x-responsive-nav-link>--}}

{{--            <!-- Authentication -->--}}
{{--            <form method="POST" action="{{ route('logout') }}">--}}
{{--                @csrf--}}
{{--                <x-responsive-nav-link href="{{ route('logout') }}"--}}
{{--                                       onclick="event.preventDefault();--}}
{{--                                                        this.closest('form').submit();">--}}
{{--                    {{ __('Log Out') }}--}}
{{--                </x-responsive-nav-link>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}