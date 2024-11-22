<div class="flex-1 flex flex-col ml-[17%] mt-[-50%]">
    <!-- Header for large screens -->
    <header class="fixed top-0 left-0 bg-[#ffffff] p-4 hidden md:flex w-full justify-between items-center z-10"
        style="width: calc(100% - 17%); left: 17%; max-width: calc(100% - 17%);">
        <!-- Navigation Links -->

         <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
             <div class="flex items-center space-x-2">
                 <h3 class="text-[#328d56] font-semibold">City Housing and Land Management System</h3>
             </div>
         </div>

        <!-- Right-aligned container for and Profile -->
        <div class="flex items-center ml-auto space-x-2">
            <!-- Profile Section -->
            <div x-data="{ showProfile: false }" class="relative rounded-full py-[-4px] px-2">
                <!-- Toggle Button for Profile Menu -->
                <button x-data="{ profilePhoto: '{{ Auth::user() && Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : asset('/storage/images/default-avatar.png') }}' }"
                    @click="showProfile = !showProfile"
                    class="flex items-center w-30">

                    <!-- User profile photo -->
                    <template x-if="profilePhoto === '{{ asset('/storage/images/default-avatar.png') }}'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400 bg-gray-200 rounded-full" viewBox="0 0 24 24" fill="gray">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                        </svg>
                    </template>
                    <template x-if="profilePhoto !== '{{ asset('/storage/images/default-avatar.png') }}'">
                        <img :src="profilePhoto" class="w-8 h-8 rounded-full bg-gray-200 object-cover" alt="User Photo">
                    </template>

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
                                <p class="text-sm font-sm">{{ Auth::user()->first_name }} {{ Auth::user()->middle_name }} {{ Auth::user()->last_name }}</p>
                            </a>
                        </li>
                        <li>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
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

<script>
    // Listen for the profile photo update event globally
    document.addEventListener('profile-updated', function(event) {
        // Ensure profile photo is updated dynamically
        const profileButtons = document.querySelectorAll('[x-data]');
        profileButtons.forEach(button => {
            button.__x.$data.profilePhoto = event.detail.newPhoto;
        });
    });
</script>