<div class="flex-1 flex flex-col ml-[17%] mt-[-50%]">
    <!-- Header for large screens -->
    <header class="fixed top-0 left-0 bg-[#ffffff] p-3 hidden md:flex w-full justify-between items-center z-10" style="width: calc(100% - 17%); left: 17%; max-width: calc(100% - 17%);">
        <!-- Right-aligned container for Search and Profile -->
        <div class="flex items-center ml-auto space-x-4">
            <!-- Search -->
            <div class="relative hidden md:block">
                <svg class="absolute top-[13px] left-4" width="19" height="19" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.625 16.625C13.491 16.625 16.625 13.491 16.625 9.625C16.625 5.75901 13.491 2.625 9.625 2.625C5.75901 2.625 2.625 5.75901 2.625 9.625C2.625 13.491 5.75901 16.625 9.625 16.625Z" stroke="#787C7F" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M18.3746 18.375L14.5684 14.5688" stroke="#787C7F" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <input type="search" name="search" id="search" class="rounded-full px-12 py-2 placeholder:text-[13px] outline-none border-none z-10 bg-[#f7f7f9] hover:ring-[#BA2C2C] focus:ring-[#BA2C2C]" placeholder="Search Anything">
            </div>

           <!-- Profile Section -->
            <div x-data="{ showProfile: false }" class="relative">
                <!-- Toggle Button for Profile Menu -->
                <button @click="showProfile = !showProfile" class="flex items-center gap-3">
                    <!-- User Image (SVG) -->
                    <svg class="w-8 h-8 rounded-full bg-gray-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-3.33 0-10 1.67-10 5v1h20v-1c0-3.33-6.67-5-10-5z" />
                    </svg>
                    <!-- User Name -->
                    <div class="flex flex-col">
                        <p class="text-[13px] font-medium">Katie Pena</p>
                        <p class="text-[12px] -ml-7 font-light text-gray-500">Admin</p>
                    </div>

                </button>

                <!-- Dropdown Menu -->
                <div x-cloak x-show="showProfile" class="absolute bg-white rounded-lg shadow-md right-0 top-12 w-56 z-10 transition duration-300 ease-in-out transform origin-top" :class="{ 'scale-y-100': showProfile, 'scale-y-0': !showProfile }">
                    <ul class="block text-sm divide-y py-1 text-[#4F6065]">
                        <!-- User Profile -->
                        <li>
                            <a href="{ route('profile') }" @click="showProfile = false; subTmsActiveItem = ''; subActiveItem = ''; show = false; showManage = false; setActiveTab('profile')" class="flex items-center gap-3 px-4 py-2 hover:text-[#19323C] hover:bg-gray-200">
                                <!-- User Image (SVG) -->
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-9 h-9"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM15 9C15 10.6569 13.6569 12 12 12C10.3431 12 9 10.6569 9 9C9 7.34315 10.3431 6 12 6C13.6569 6 15 7.34315 15 9ZM12 20.5C13.784 20.5 15.4397 19.9504 16.8069 19.0112C17.4108 18.5964 17.6688 17.8062 17.3178 17.1632C16.59 15.8303 15.0902 15 11.9999 15C8.90969 15 7.40997 15.8302 6.68214 17.1632C6.33105 17.8062 6.5891 18.5963 7.19296 19.0111C8.56018 19.9503 10.2159 20.5 12 20.5Z" fill="#000000"></path> </g></svg>
                                <!-- User Name -->
                                <p class="text-sm font-sm">John Doe</p>
                            </a>
                        </li>
                        <li>
                            <form method="GET" action="">
                                <button type="submit" @click="showProfile = false; subTmsActiveItem = ''; subActiveItem = ''; show = false; showManage = false; setActiveTab('dashboard')" class="w-full flex gap-3 items-center px-4 py-2 hover:text-[#19323C] hover:bg-gray-200">
                                    <p class="group relative">Settings</p>
                                </button>
                                <button type="submit" @click="showProfile = false; subTmsActiveItem = ''; subActiveItem = ''; show = false; showManage = false; setActiveTab('dashboard')" class="w-full flex gap-3 items-center px-4 py-2 hover:text-[#19323C] hover:bg-gray-200">
                                    <p class="group relative">Sign Out</p>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
</div>