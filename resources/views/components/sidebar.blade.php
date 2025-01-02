@hasanyrole('Super Admin|Housing System Admin|Housing System Staff|Housing System Relocation Site Manager')
<div class="bg-none shadow-md font-poppins text-black 0 p-0 " x-data="{ open: false, activeLink: localStorage.getItem('activeLink') || '', activeChildLink: localStorage.getItem('activeChildLink') || '' }">
    <div class="flex h-[100vh]">
        <!-- Sidebar -->
        <aside :class="open ? 'block' : 'hidden md:block'" class="fixed w-[17%] bg-[#ffffff] max-h-screen  py-3 pl-4 pr-2 md:block mr-2 pb-[8px] shadow-lg ">
            <div class="text-20 font-bold mb-4 ml-1 flex items-center ">
                <div class="w-[85%] h-auto inline-block">
                    <x-application-sidebar-logo />
                </div>
            </div>
            <!-- SIDEBAR MENU -->
            <nav class="space-y-2 mt-15 flex-1 text-[13px] h-[calc(100vh-4rem)] overflow-auto scrollbar-hidden" x-data="{
                    activeLink: localStorage.getItem('activeLink') || '',
                    activeChildLink: localStorage.getItem('activeChildLink') || ''}">

                @role('Super Admin')
                    <div x-data="{ isDashboardOpen: false }">
                        <!-- Main Dashboard Menu -->
                        <a href="#" @click="isDashboardOpen = !isDashboardOpen; activeLink = 'dashboard'; localStorage.setItem('activeLink', 'dashboard')"
                           :class="{ 'bg-[#D9D9D9] bg-opacity-40 text-[#FF9100] border-l-[#FF9100] border-l-[5px] font-bold': activeLink === 'dashboard' }"
                           class="mx-2 flex items-center justify-between py-2.5 px-4 rounded hover:bg-[#D9D9D9] hover:bg-opacity-40 hover:border-l-[#D9D9D9] hover:border-l-[5px] hover:text-[#FF9100]">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 24 4 C 12.972066 4 4 12.972074 4 24 C 4 35.027926 12.972066 44 24 44 C 35.027934 44 44 35.027926 44 24 C 44 12.972074 35.027934 4 24 4 z M 24 7 C 33.406615 7 41 14.593391 41 24 C 41 33.406609 33.406615 41 24 41 C 14.593385 41 7 33.406609 7 24 C 7 14.593391 14.593385 7 24 7 z M 24 8.5 A 1.5 1.5 0 0 0 24 11.5 A 1.5 1.5 0 0 0 24 8.5 z M 14.101562 12.601562 A 1.5 1.5 0 0 0 14.101562 15.601562 A 1.5 1.5 0 0 0 14.101562 12.601562 z M 33.898438 12.601562 A 1.5 1.5 0 0 0 33.898438 15.601562 A 1.5 1.5 0 0 0 33.898438 12.601562 z M 34.498047 19.216797 C 32.208377 19.17827 24.126875 21.782219 23.234375 22.152344 C 22.214375 22.575344 21.729344 23.745625 22.152344 24.765625 C 22.575344 25.785625 23.745625 26.270656 24.765625 25.847656 C 25.786625 25.424656 35.508938 20.427203 35.085938 19.408203 C 35.033062 19.280578 34.825143 19.222301 34.498047 19.216797 z M 10 22.5 A 1.5 1.5 0 0 0 10 25.5 A 1.5 1.5 0 0 0 10 22.5 z M 38 22.5 A 1.5 1.5 0 0 0 38 25.5 A 1.5 1.5 0 0 0 38 22.5 z M 14.101562 32.398438 A 1.5 1.5 0 0 0 14.101562 35.398438 A 1.5 1.5 0 0 0 14.101562 32.398438 z M 33.898438 32.398438 A 1.5 1.5 0 0 0 33.898438 35.398438 A 1.5 1.5 0 0 0 33.898438 32.398438 z"></path>
                                </svg>
                                <p class="ml-2">Dashboard</p>
                            </div>
                            <svg :class="{ 'transform rotate-180': isDashboardOpen }"
                                 class="w-4 h-4 transition-transform duration-200"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>

                        <!-- Dashboard Submenus -->
                        <div x-show="isDashboardOpen" x-transition class="ml-6">
                            <!-- User Management Submenu -->
                            <a href="{{ route('dashboard') }}" @click="activeChildLink = 'dashboard'; localStorage.setItem('activeChildLink', 'dashboard')"
                               :class="{ 'text-[#FF9100] font-bold': activeChildLink === 'dashboard' }"
                               class="flex items-center py-2 px-4 hover:text-[#FF9100]">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2"
                                     class="w-5 h-5">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                <span class="ml-2">Housing</span>
                            </a>
                            <a href="{{ route('shelter-dashboard') }}"
                               @click="activeChildLink = 'shelter-dashboard';
                                            localStorage.setItem('activeChildLink', 'shelter-dashboard')"
                               :class="{ 'text-[#FF9100] font-bold': activeChildLink === 'shelter-dashboard' }"
                               class="flex items-center py-2 px-4 hover:text-[#FF9100]">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2"
                                     class="w-5 h-5">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819" />
                                </svg>
                                <span class="ml-2">Shelter</span>
                            </a>
                        </div>
                    </div>
                    <a href="{{ route('masterlist-applicants') }}" @click="activeLink = 'masterlist-applicants'; activeChildLink = ''; localStorage.setItem('activeLink', 'masterlist-applicants'); localStorage.setItem('activeChildLink', '')" :class="{ 'bg-[#D9D9D9] text-[12px] bg-opacity-40 text-[#FF9100] border-l-[#FF9100] border-l-[5px] font-bold': activeLink === 'applicants' }" class="mx-2 flex items-center  py-2.5 px-4 rounded hover:bg-[#D9D9D9] hover:bg-opacity-40 hover:border-l-[#D9D9D9] hover:border-l-[5px] hover:text-[12px] hover:text-[#FF9100]">

                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                            <path d="M 23.984375 5.9863281 A 1.0001 1.0001 0 0 0 23 7 L 23 13 A 1.0001 1.0001 0 1 0 25 13 L 25 7 A 1.0001 1.0001 0 0 0 23.984375 5.9863281 z M 13.869141 9.8691406 A 1.0001 1.0001 0 0 0 13.171875 11.585938 L 17.414062 15.828125 A 1.0001 1.0001 0 1 0 18.828125 14.414062 L 14.585938 10.171875 A 1.0001 1.0001 0 0 0 13.869141 9.8691406 z M 34.101562 9.8691406 A 1.0001 1.0001 0 0 0 33.414062 10.171875 L 29.171875 14.414062 A 1.0001 1.0001 0 1 0 30.585938 15.828125 L 34.828125 11.585938 A 1.0001 1.0001 0 0 0 34.101562 9.8691406 z M 24 16 C 22.458334 16 21.112148 16.632133 20.253906 17.597656 C 19.395664 18.563179 19 19.791667 19 21 C 19 22.208333 19.395664 23.436821 20.253906 24.402344 C 21.112148 25.367867 22.458334 26 24 26 C 25.541666 26 26.887852 25.367867 27.746094 24.402344 C 28.604336 23.436821 29 22.208333 29 21 C 29 19.791667 28.604336 18.563179 27.746094 17.597656 C 26.887852 16.632133 25.541666 16 24 16 z M 24 19 C 24.791666 19 25.195482 19.242867 25.503906 19.589844 C 25.81233 19.936821 26 20.458333 26 21 C 26 21.541667 25.81233 22.063179 25.503906 22.410156 C 25.195482 22.757133 24.791666 23 24 23 C 23.208334 23 22.804518 22.757133 22.496094 22.410156 C 22.18767 22.063179 22 21.541667 22 21 C 22 20.458333 22.18767 19.936821 22.496094 19.589844 C 22.804518 19.242867 23.208334 19 24 19 z M 9 22 C 7.4583337 22 6.1121484 22.632133 5.2539062 23.597656 C 4.3956641 24.563179 4 25.791667 4 27 C 4 28.208333 4.3956641 29.436821 5.2539062 30.402344 C 6.1121484 31.367867 7.4583337 32 9 32 C 10.541666 32 11.887852 31.367867 12.746094 30.402344 C 13.604336 29.436821 14 28.208333 14 27 C 14 25.791667 13.604336 24.563179 12.746094 23.597656 C 11.887852 22.632133 10.541666 22 9 22 z M 39 22 C 37.458334 22 36.112148 22.632133 35.253906 23.597656 C 34.395664 24.563179 34 25.791667 34 27 C 34 28.208333 34.395664 29.436821 35.253906 30.402344 C 36.112148 31.367867 37.458334 32 39 32 C 40.541666 32 41.887852 31.367867 42.746094 30.402344 C 43.604336 29.436821 44 28.208333 44 27 C 44 25.791667 43.604336 24.563179 42.746094 23.597656 C 41.887852 22.632133 40.541666 22 39 22 z M 9 25 C 9.791666 25 10.195482 25.242867 10.503906 25.589844 C 10.81233 25.936821 11 26.458333 11 27 C 11 27.541667 10.81233 28.063179 10.503906 28.410156 C 10.195482 28.757133 9.791666 29 9 29 C 8.208334 29 7.8045177 28.757133 7.4960938 28.410156 C 7.1876698 28.063179 7 27.541667 7 27 C 7 26.458333 7.1876698 25.936821 7.4960938 25.589844 C 7.8045177 25.242867 8.208334 25 9 25 z M 39 25 C 39.791666 25 40.195482 25.242867 40.503906 25.589844 C 40.81233 25.936821 41 26.458333 41 27 C 41 27.541667 40.81233 28.063179 40.503906 28.410156 C 40.195482 28.757133 39.791666 29 39 29 C 38.208334 29 37.804518 28.757133 37.496094 28.410156 C 37.18767 28.063179 37 27.541667 37 27 C 37 26.458333 37.18767 25.936821 37.496094 25.589844 C 37.804518 25.242867 38.208334 25 39 25 z M 18.052734 28 C 16.384766 28 15 29.384766 15 31.052734 L 15 34.021484 C 14.979733 34.021074 14.96762 34 14.947266 34 L 3.0527344 34 C 1.3847659 34 -2.9605947e-16 35.384766 0 37.052734 L 0 38.949219 C 0 40.778128 1.1549049 42.35297 2.7695312 43.382812 C 4.3841576 44.412656 6.526281 45.001953 9 45.001953 C 11.473607 45.001953 13.613818 44.412548 15.228516 43.382812 C 15.743751 43.054234 16.100843 42.590377 16.5 42.160156 C 16.898941 42.589937 17.25472 43.054455 17.769531 43.382812 C 19.384158 44.412656 21.526281 45.001953 24 45.001953 C 26.473607 45.001953 28.613818 44.412548 30.228516 43.382812 C 30.743751 43.054234 31.100843 42.590377 31.5 42.160156 C 31.898941 42.589937 32.25472 43.054455 32.769531 43.382812 C 34.384158 44.412656 36.526281 45.001953 39 45.001953 C 41.473607 45.001953 43.613818 44.412548 45.228516 43.382812 C 46.843213 42.353077 48 40.77836 48 38.949219 L 48 37.052734 C 48 35.384766 46.615234 34 44.947266 34 L 33.052734 34 C 33.032384 34 33.02026 34.021074 33 34.021484 L 33 31.052734 C 32.999996 29.38477 31.615234 28 29.947266 28 L 18.052734 28 z M 18.052734 31 L 29.947266 31 C 29.993297 31 30 31.006703 30 31.052734 L 30 37.052734 L 30 38.949219 C 30 39.503077 29.637239 40.203001 28.617188 40.853516 C 27.597135 41.50403 25.987393 42.001953 24 42.001953 C 22.012719 42.001953 20.402936 41.504172 19.382812 40.853516 C 18.362689 40.202859 18 39.502309 18 38.949219 L 18 37.052734 L 18 31.052734 C 18 31.006703 18.006703 31 18.052734 31 z M 3.0527344 37 L 14.947266 37 C 14.993297 37 15 37.006703 15 37.052734 L 15 38.949219 C 15 39.503077 14.637239 40.203001 13.617188 40.853516 C 12.597134 41.50403 10.987393 42.001953 9 42.001953 C 7.012719 42.001953 5.4029362 41.504172 4.3828125 40.853516 C 3.3626888 40.202859 3 39.502309 3 38.949219 L 3 37.052734 C 3 37.006703 3.0067029 37 3.0527344 37 z M 33.052734 37 L 44.947266 37 C 44.993297 37 45 37.006703 45 37.052734 L 45 38.949219 C 45 39.503077 44.637239 40.203001 43.617188 40.853516 C 42.597135 41.50403 40.987393 42.001953 39 42.001953 C 37.012719 42.001953 35.402936 41.504172 34.382812 40.853516 C 33.36269 40.202859 33 39.502309 33 38.949219 L 33 37.052734 C 33 37.006703 33.006703 37 33.052734 37 z"></path>
                        </svg>
                        <p class="ml-2">Applicants Inquiry</p>
                    </a>

                    <div x-data="{ isApplicationsOpen: false }">
                        <!-- Applications Menu -->
                        <a href="#" @click="isApplicationsOpen = !isApplicationsOpen; activeLink = 'applications'; localStorage.setItem('activeLink', 'applications')"
                           :class="{ 'bg-[#D9D9D9] bg-opacity-40 text-[#FF9100] border-l-[#FF9100] border-l-[5px] font-bold': activeLink === 'applications' }"
                           class="mx-2 flex items-center justify-between py-2.5 px-4 rounded hover:bg-[#D9D9D9] hover:bg-opacity-40 hover:border-l-[#D9D9D9] hover:border-l-[5px] hover:text-[#FF9100]">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 13 7 C 11.125 7 9.5288151 7.7571335 8.5039062 8.9101562 C 7.4789976 10.063179 7 11.541667 7 13 C 7 14.458333 7.4789975 15.936821 8.5039062 17.089844 C 9.5288151 18.242867 11.125 19 13 19 C 14.875 19 16.471185 18.242867 17.496094 17.089844 C 18.521003 15.936821 19 14.458333 19 13 C 19 11.541667 18.521003 10.063179 17.496094 8.9101562 C 16.471185 7.7571335 14.875 7 13 7 z M 35 7 C 33.125 7 31.528815 7.7571335 30.503906 8.9101562 C 29.478997 10.063179 29 11.541667 29 13 C 29 14.458333 29.478997 15.936821 30.503906 17.089844 C 31.528815 18.242867 33.125 19 35 19 C 36.875 19 38.471185 18.242867 39.496094 17.089844 C 40.521003 15.936821 41 14.458333 41 13 C 41 11.541667 40.521003 10.063179 39.496094 8.9101562 C 38.471185 7.7571335 36.875 7 35 7 z M 13 10 C 14.124999 10 14.778816 10.367867 15.253906 10.902344 C 15.728997 11.436821 16 12.208333 16 13 C 16 13.791667 15.728997 14.563179 15.253906 15.097656 C 14.778816 15.632133 14.124999 16 13 16 C 11.875001 16 11.221184 15.632133 10.746094 15.097656 C 10.271003 14.563179 10 13.791667 10 13 C 10 12.208333 10.271003 11.436821 10.746094 10.902344 C 11.221184 10.367867 11.875001 10 13 10 z M 35 10 C 36.124999 10 36.778816 10.367867 37.253906 10.902344 C 37.728997 11.436821 38 12.208333 38 13 C 38 13.791667 37.728997 14.563179 37.253906 15.097656 C 36.778816 15.632133 36.124999 16 35 16 C 33.875001 16 33.221184 15.632133 32.746094 15.097656 C 32.271003 14.563179 32 13.791667 32 13 C 32 12.208333 32.271003 11.436821 32.746094 10.902344 C 33.221184 10.367867 33.875001 10 35 10 z M 24 17 C 22.125 17 20.528815 17.757133 19.503906 18.910156 C 18.478997 20.063179 18 21.541667 18 23 C 18 24.458333 18.478997 25.936821 19.503906 27.089844 C 20.528815 28.242867 22.125 29 24 29 C 25.875 29 27.471185 28.242867 28.496094 27.089844 C 29.521003 25.936821 30 24.458333 30 23 C 30 21.541667 29.521003 20.063179 28.496094 18.910156 C 27.471185 17.757133 25.875 17 24 17 z M 24 20 C 25.124999 20 25.778816 20.367867 26.253906 20.902344 C 26.728997 21.436821 27 22.208333 27 23 C 27 23.791667 26.728997 24.563179 26.253906 25.097656 C 25.778816 25.632133 25.124999 26 24 26 C 22.875001 26 22.221184 25.632133 21.746094 25.097656 C 21.271003 24.563179 21 23.791667 21 23 C 21 22.208333 21.271003 21.436821 21.746094 20.902344 C 22.221184 20.367867 22.875001 20 24 20 z M 7.5 21 C 5.57 21 4 22.57 4 24.5 L 4 27 C 4 30.36 7.95 33 13 33 L 13.210938 33 C 13.660937 31.39 14.839375 30.079688 16.359375 29.429688 C 15.409375 29.779688 14.26 30 13 30 C 9.57 30 7 28.42 7 27 L 7 24.5 C 7 24.22 7.22 24 7.5 24 L 16.060547 24 C 16.020547 23.67 16 23.34 16 23 C 16 22.31 16.09 21.64 16.25 21 L 7.5 21 z M 31.75 21 C 31.91 21.64 32 22.31 32 23 C 32 23.34 31.979453 23.67 31.939453 24 L 40.5 24 C 40.78 24 41 24.22 41 24.5 L 41 27 C 41 28.42 38.43 30 35 30 C 33.74 30 32.590625 29.779688 31.640625 29.429688 C 33.160625 30.079687 34.339063 31.39 34.789062 33 L 35 33 C 40.05 33 44 30.36 44 27 L 44 24.5 C 44 22.57 42.43 21 40.5 21 L 31.75 21 z M 18.5 31 C 16.585045 31 15 32.585045 15 34.5 L 15 37 C 15 38.918154 16.279921 40.481204 17.925781 41.46875 C 19.571641 42.456296 21.68576 43 24 43 C 26.31424 43 28.428359 42.456296 30.074219 41.46875 C 31.720079 40.481204 33 38.918154 33 37 L 33 34.5 C 33 32.585045 31.414955 31 29.5 31 L 18.5 31 z M 18.5 34 L 29.5 34 C 29.795045 34 30 34.204955 30 34.5 L 30 37 C 30 37.566846 29.59989 38.255281 28.53125 38.896484 C 27.46261 39.537688 25.82776 40 24 40 C 22.17224 40 20.53739 39.537688 19.46875 38.896484 C 18.40011 38.255281 18 37.566846 18 37 L 18 34.5 C 18 34.204955 18.204955 34 18.5 34 z"></path>
                                </svg>
                                <p class="ml-2">Applications</p>
                            </div>
                            <svg :class="{ 'transform rotate-180': isApplicationsOpen }"
                                 class="w-4 h-4 transition-transform duration-200"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>

                        <!-- Applications Submenus -->
                        <div x-show="isApplicationsOpen" x-transition class="ml-6">
                            <!-- Applicants -->
                            <a href="{{ route('applicants') }}"
                               @click="activeChildLink = 'admin-applicants'; localStorage.setItem('activeChildLink', 'admin-applicants')"
                               :class="{ 'text-[#FF9100] font-bold': activeChildLink === 'admin-applicants' }"
                               class="flex items-center py-2 px-4 hover:text-[#FF9100]">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 12.5 4 C 10.02 4 8 6.02 8 8.5 L 8 39.5 C 8 41.98 10.02 44 12.5 44 L 26.539062 44 C 26.189063 43.4 26 42.73 26 42 L 26 41 L 12.5 41 C 11.67 41 11 40.33 11 39.5 L 11 8.5 C 11 7.67 11.67 7 12.5 7 L 35.5 7 C 36.33 7 37 7.67 37 8.5 L 37 24 C 38.01 24 39.02 24.070938 40 24.210938 L 40 8.5 C 40 6.02 37.98 4 35.5 4 L 12.5 4 z M 24 10 A 3.5 3.5 0 1 0 24 17 A 3.5 3.5 0 1 0 24 10 z M 19.5 19 C 18.672 19 18 19.672 18 20.5 L 18 21.5 C 18 23.433 20.686 25 24 25 C 27.314 25 30 23.433 30 21.5 L 30 20.5 C 30 19.672 29.328 19 28.5 19 L 19.5 19 z M 37 26 C 32.029 26 28 27.791 28 30 C 28 32.209 32.029 34 37 34 C 41.971 34 46 32.209 46 30 C 46 27.791 41.971 26 37 26 z M 16.5 28 C 15.67 28 15 28.67 15 29.5 C 15 30.33 15.67 31 16.5 31 L 26 31 L 26 30 C 26 29.27 26.189063 28.6 26.539062 28 L 16.5 28 z M 28 33 L 28 36 C 28 38.21 32.03 40 37 40 C 41.97 40 46 38.21 46 36 L 46 33 C 46 35.21 41.97 37 37 37 C 32.03 37 28 35.21 28 33 z M 16.5 34 C 15.67 34 15 34.67 15 35.5 C 15 36.33 15.67 37 16.5 37 L 26 37 L 26 34 L 16.5 34 z M 28 39 L 28 42 C 28 44.21 32.03 46 37 46 C 41.97 46 46 44.21 46 42 L 46 39 C 46 41.21 41.97 43 37 43 C 32.03 43 28 41.21 28 39 z"></path>
                                </svg>
                                <span class="ml-2">Applicants</span>
                            </a>

                            <!-- Tagged/Validated -->
                            <a href="{{ route('transaction-request') }}"
                               @click="activeChildLink = 'admin-transactions-request'; localStorage.setItem('activeChildLink', 'admin-transactions-request')"
                               :class="{ 'text-[#FF9100] font-bold': activeChildLink === 'admin-transactions-request' }"
                               class="flex items-center py-2 px-4 hover:text-[#FF9100]">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 24 5.0273438 C 22.851301 5.0273438 21.70304 5.4009945 20.753906 6.1484375 A 1.50015 1.50015 0 0 0 20.658203 6.2304688 L 4.5546875 21.255859 C 2.8485365 22.847233 2.8013499 25.586506 4.4511719 27.236328 C 6.036957 28.822113 8.6399476 28.853448 10.261719 27.304688 A 1.50015 1.50015 0 0 0 10.265625 27.300781 L 24.003906 14.085938 L 37.734375 27.298828 A 1.50015 1.50015 0 0 0 37.738281 27.302734 C 39.359795 28.852802 41.963043 28.824063 43.548828 27.238281 C 45.19865 25.588459 45.151465 22.849186 43.445312 21.257812 L 27.341797 6.2304688 A 1.50015 1.50015 0 0 0 27.246094 6.1484375 C 26.296957 5.4009942 25.148699 5.0273438 24 5.0273438 z M 24 8.0195312 C 24.485694 8.0195312 24.970178 8.1837987 25.378906 8.5019531 L 41.400391 23.451172 C 41.89424 23.911798 41.905915 24.63901 41.427734 25.117188 C 40.971519 25.573401 40.277033 25.580696 39.810547 25.134766 L 25.044922 10.923828 A 1.50015 1.50015 0 0 0 22.964844 10.923828 L 8.1894531 25.134766 C 7.723224 25.580006 7.0284805 25.571449 6.5722656 25.115234 C 6.0940876 24.637056 6.1057604 23.909845 6.5996094 23.449219 L 22.621094 8.5019531 C 23.029822 8.1837987 23.514306 8.0195312 24 8.0195312 z"></path>
                                </svg>
                                <span class="ml-2">Tagged/Validated</span>
                            </a>

                            <!-- Awardee List -->
                            <a href="{{ route('awardee-list') }}"
                               @click="activeChildLink = 'awardee'; localStorage.setItem('activeChildLink', 'awardee')"
                               :class="{ 'text-[#FF9100] font-bold': activeChildLink === 'awardee' }"
                               class="flex items-center py-2 px-4 hover:text-[#FF9100]">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 21 4 C 15.494917 4 11 8.494921 11 14 C 11 19.505079 15.494917 24 21 24 C 26.505083 24 31 19.505079 31 14 C 31 8.494921 26.505083 4 21 4 z M 21 7 C 24.883764 7 28 10.116238 28 14 C 28 17.883762 24.883764 21 21 21 C 17.116236 21 14 17.883762 14 14 C 14 10.116238 17.116236 7 21 7 z M 35 24 C 28.925 24 24 28.925 24 35 C 24 41.075 28.925 46 35 46 C 41.075 46 46 41.075 46 35 C 46 28.925 41.075 24 35 24 z M 9.5 28 C 7.02 28 5 30.02 5 32.5 L 5 33.699219 C 5 39.479219 12.03 44 21 44 C 22.49 44 23.929062 43.870859 25.289062 43.630859 C 24.549063 42.800859 23.910391 41.880859 23.400391 40.880859 C 22.630391 40.960859 21.83 41 21 41 C 12.97 41 8 37.209219 8 33.699219 L 8 32.5 C 8 31.67 8.67 31 9.5 31 L 22.630859 31 C 22.970859 29.93 23.450781 28.93 24.050781 28 L 9.5 28 z"></path>
                                </svg>
                                <span class="ml-2">Awardee List</span>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('relocation-sites') }}" @click="activeLink = 'relocation'; activeChildLink = ''; localStorage.setItem('activeLink', 'relocation'); localStorage.setItem('activeChildLink', '')" :class="{ 'bg-[#D9D9D9] text-[12px] bg-opacity-40 text-[#FF9100] border-l-[#FF9100] border-l-[5px] font-bold': activeLink === 'relocation' }" class="mx-2 flex items-center py-2.5 px-4 rounded hover:bg-[#D9D9D9] hover:bg-opacity-40 hover:border-l-[#D9D9D9] hover:border-l-[5px] hover:text-[#FF9100]">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                            <path d="M 24 4 C 14.629252 4 7 11.629252 7 21 C 7 25.20679 8.5433056 29.064832 11.078125 32.03125 L 11.085938 32.039062 L 11.091797 32.046875 C 11.091797 32.046875 18.323729 40.299027 20.898438 42.755859 C 22.622568 44.39966 25.375478 44.39966 27.099609 42.755859 C 30.034388 39.956663 36.910156 32.042969 36.910156 32.042969 L 36.914062 32.037109 L 36.919922 32.03125 C 39.456988 29.064801 41 25.20679 41 21 C 41 11.629252 33.370748 4 24 4 z M 24 7 C 31.749252 7 38 13.250748 38 21 C 38 24.47521 36.733544 27.632586 34.638672 30.082031 C 34.625032 30.097631 27.590036 38.143501 25.029297 40.585938 C 24.435428 41.152136 23.562619 41.152136 22.96875 40.585938 C 20.828579 38.543748 13.381099 30.106639 13.359375 30.082031 L 13.357422 30.080078 C 11.265326 27.630829 10 24.474248 10 21 C 10 13.250748 16.250748 7 24 7 z M 24 15 C 22.125 15 20.528815 15.757133 19.503906 16.910156 C 18.478997 18.063179 18 19.541667 18 21 C 18 22.458333 18.478997 23.936821 19.503906 25.089844 C 20.528815 26.242867 22.125 27 24 27 C 25.875 27 27.471185 26.242867 28.496094 25.089844 C 29.521003 23.936821 30 22.458333 30 21 C 30 19.541667 29.521003 18.063179 28.496094 16.910156 C 27.471185 15.757133 25.875 15 24 15 z M 24 18 C 25.124999 18 25.778816 18.367867 26.253906 18.902344 C 26.728997 19.436821 27 20.208333 27 21 C 27 21.791667 26.728997 22.563179 26.253906 23.097656 C 25.778816 23.632133 25.124999 24 24 24 C 22.875001 24 22.221184 23.632133 21.746094 23.097656 C 21.271003 22.563179 21 21.791667 21 21 C 21 20.208333 21.271003 19.436821 21.746094 18.902344 C 22.221184 18.367867 22.875001 18 24 18 z"></path>
                        </svg>
                        <p class="ml-2">Relocation Sites</p>
                    </a>

                    <div x-data="{ isReportsOpen: false }">
                        <!-- Reports Menu -->
                        <a href="#" @click="isReportsOpen = !isReportsOpen; activeLink = 'reports'; localStorage.setItem('activeLink', 'reports')"
                           :class="{ 'bg-[#D9D9D9] bg-opacity-40 text-[#FF9100] border-l-[#FF9100] border-l-[5px] font-bold': activeLink === 'reports' }"
                           class="mx-2 flex items-center justify-between py-2.5 px-4 rounded hover:bg-[#D9D9D9] hover:bg-opacity-40 hover:border-l-[#D9D9D9] hover:border-l-[5px] hover:text-[#FF9100]">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-5 h-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="ml-2">Reports</p>
                            </div>
                            <svg :class="{ 'transform rotate-180': isReportsOpen }"
                                 class="w-4 h-4 transition-transform duration-200"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>

                        <!-- Reports Submenus -->
                        <div x-show="isReportsOpen" x-transition class="ml-6">
                            <!-- Transfer Histories -->
                            <a href="{{ route('transfer-histories') }}"
                               @click="activeChildLink = 'transfer-histories'; localStorage.setItem('activeChildLink', 'transfer-histories')"
                               :class="{ 'text-[#FF9100] font-bold': activeChildLink === 'transfer-histories' }"
                               class="flex items-center py-2 px-4 hover:text-[#FF9100]">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 24 4 C 12.972066 4 4 12.972074 4 24 C 4 35.027926 12.972066 44 24 44 C 35.027934 44 44 35.027926 44 24 C 44 12.972074 35.027934 4 24 4 z M 24 7 C 33.406615 7 41 14.593391 41 24 C 41 33.406609 33.406615 41 24 41 C 14.593385 41 7 33.406609 7 24 C 7 14.593391 14.593385 7 24 7 z M 23.976562 12.978516 A 1.50015 1.50015 0 0 0 22.5 14.5 L 22.5 24 C 22.5 24.397 22.658 24.774781 22.933594 25.050781 L 28.933594 31.050781 A 1.50015 1.50015 0 1 0 31.066406 28.917969 L 25.5 23.351562 L 25.5 14.5 A 1.50015 1.50015 0 0 0 23.976562 12.978516 z"></path>
                                </svg>
                                <span class="ml-2">Transfer Histories</span>
                            </a>

                            <!-- Blacklist -->
                            <a href="{{ route('blacklist') }}"
                               @click="activeChildLink = 'blacklist'; localStorage.setItem('activeChildLink', 'blacklist')"
                               :class="{ 'text-[#FF9100] font-bold': activeChildLink === 'blacklist' }"
                               class="flex items-center py-2 px-4 hover:text-[#FF9100]">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 24 4 C 12.972066 4 4 12.972074 4 24 C 4 35.027926 12.972066 44 24 44 C 35.027934 44 44 35.027926 44 24 C 44 12.972074 35.027934 4 24 4 z M 24 7 C 33.406615 7 41 14.593391 41 24 C 41 33.406609 33.406615 41 24 41 C 14.593385 41 7 33.406609 7 24 C 7 14.593391 14.593385 7 24 7 z M 31.976562 15.978516 A 1.50015 1.50015 0 0 0 30.939453 16.439453 L 24 23.378906 L 17.060547 16.439453 A 1.50015 1.50015 0 0 0 15.939453 16.439453 A 1.50015 1.50015 0 0 0 15.939453 17.560547 L 22.878906 24.5 L 15.939453 31.439453 A 1.50015 1.50015 0 1 0 17.060547 32.560547 L 24 25.621094 L 30.939453 32.560547 A 1.50015 1.50015 0 1 0 32.060547 31.439453 L 25.121094 24.5 L 32.060547 17.560547 A 1.50015 1.50015 0 0 0 31.976562 15.978516 z"></path>
                                </svg>
                                <span class="ml-2">Blacklist</span>
                            </a>

                            <!-- Summary of Identified Informal Settlers -->
                            <a href="{{ route('summary-of-identified-informal-settlers') }}"
                               @click="activeChildLink = 'summary-of-identified-informal-settlers'; localStorage.setItem('activeChildLink', 'summary-of-identified-informal-settlers')"
                               :class="{ 'text-[#FF9100] font-bold': activeChildLink === 'summary-of-identified-informal-settlers' }"
                               class="flex items-center py-2 px-4 hover:text-[#FF9100]">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 7 4 C 6.448 4 6 4.448 6 5 L 6 43 C 6 43.552 6.448 44 7 44 L 41 44 C 41.552 44 42 43.552 42 43 L 42 5 C 42 4.448 41.552 4 41 4 L 7 4 z M 9 7 L 39 7 L 39 41 L 9 41 L 9 7 z M 14 12 L 14 15 L 34 15 L 34 12 L 14 12 z M 14 20 L 14 23 L 34 23 L 34 20 L 14 20 z M 14 28 L 14 31 L 34 31 L 34 28 L 14 28 z M 14 36 L 14 39 L 34 39 L 34 36 L 14 36 z"></path>
                                </svg>
                                <span class="ml-2">Summary of Identified Informal Settlers</span>
                            </a>

                            <!-- Summary of Relocation Lot Applicants -->
                            <a href="{{ route('summary-of-relocation-lot-applicants') }}"
                               @click="activeChildLink = 'summary-of-relocation-lot-applicants'; localStorage.setItem('activeChildLink', 'summary-of-relocation-lot-applicants')"
                               :class="{ 'text-[#FF9100] font-bold': activeChildLink === 'summary-of-relocation-lot-applicants' }"
                               class="flex items-center py-2 px-4 hover:text-[#FF9100]">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 6 5 C 5.448 5 5 5.448 5 6 L 5 42 C 5 42.552 5.448 43 6 43 L 42 43 C 42.552 43 43 42.552 43 42 L 43 6 C 43 5.448 42.552 5 42 5 L 6 5 z M 8 8 L 40 8 L 40 40 L 8 40 L 8 8 z M 14.5 13 C 13.67 13 13 13.67 13 14.5 L 13 15.5 C 13 16.33 13.67 17 14.5 17 L 33.5 17 C 34.33 17 35 16.33 35 15.5 L 35 14.5 C 35 13.67 34.33 13 33.5 13 L 14.5 13 z M 14.5 23 C 13.67 23 13 23.67 13 24.5 L 13 25.5 C 13 26.33 13.67 27 14.5 27 L 33.5 27 C 34.33 27 35 26.33 35 25.5 L 35 24.5 C 35 23.67 34.33 23 33.5 23 L 14.5 23 z M 14.5 33 C 13.67 33 13 33.67 13 34.5 L 13 35.5 C 13 36.33 13.67 37 14.5 37 L 33.5 37 C 34.33 37 35 36.33 35 35.5 L 35 34.5 C 35 33.67 34.33 33 33.5 33 L 14.5 33 z"></path>
                                </svg>
                                <span class="ml-2">Summary of Relocation Lot Applicants</span>
                            </a>

                            <!-- Masterlist of Actual Occupants -->
                            <a href="{{ route('masterlist-of-actual-occupants') }}"
                               @click="activeChildLink = 'masterlist-of-actual-occupants'; localStorage.setItem('activeChildLink', 'masterlist-of-actual-occupants')"
                               :class="{ 'text-[#FF9100] font-bold': activeChildLink === 'masterlist-of-actual-occupants' }"
                               class="flex items-center py-2 px-4 hover:text-[#FF9100]">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 12.5 4 C 10.032499 4 8 6.0324991 8 8.5 L 8 39.5 C 8 41.967501 10.032499 44 12.5 44 L 35.5 44 C 37.967501 44 40 41.967501 40 39.5 L 40 18.5 A 1.50015 1.50015 0 0 0 39.560547 17.439453 L 26.560547 4.4394531 A 1.50015 1.50015 0 0 0 25.5 4 L 12.5 4 z M 12.5 7 L 24 7 L 24 16.5 C 24 18.967501 26.032499 21 28.5 21 L 37 21 L 37 39.5 C 37 40.346499 36.346499 41 35.5 41 L 12.5 41 C 11.653501 41 11 40.346499 11 39.5 L 11 8.5 C 11 7.6535009 11.653501 7 12.5 7 z M 27 9.1210938 L 34.878906 17 L 28.5 17 C 27.653501 17 27 16.346499 27 15.5 L 27 9.1210938 z"></path>
                                </svg>
                                <span class="ml-2">Masterlist of Actual Occupants</span>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('activity-logs') }}" @click="activeLink = 'activity'; activeChildLink = ''; localStorage.setItem('activeLink', 'activity'); localStorage.setItem('activeChildLink', '')" :class="{ 'bg-[#D9D9D9] text-[12px] bg-opacity-40 text-[#FF9100] border-l-[#FF9100] border-l-[5px] font-bold': activeLink === 'activity' }" class="mx-2 flex items-center py-2.5 px-4 rounded hover:bg-[#D9D9D9] hover:bg-opacity-40 hover:border-l-[#D9D9D9] hover:border-l-[5px] hover:text-[#FF9100]">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                            <path d="M 12.5 5 C 10.019 5 8 7.019 8 9.5 L 8 33 L 6.5 33 C 5.672 33 5 33.671 5 34.5 L 5 36.5 C 5 40.084 7.916 43 11.5 43 L 25.474609 43 C 24.985609 42.062 24.611328 41.055 24.361328 40 L 11.5 40 C 9.57 40 8 38.43 8 36.5 L 8 36 L 24.050781 36 C 24.129781 34.961 24.325766 33.956 24.634766 33 L 11 33 L 11 9.5 C 11 8.673 11.673 8 12.5 8 L 35.5 8 C 36.327 8 37 8.673 37 9.5 L 37 24 C 38.034 24 39.035 24.133328 40 24.361328 L 40 9.5 C 40 7.019 37.981 5 35.5 5 L 12.5 5 z M 16.5 13 A 1.5 1.5 0 0 0 16.5 16 A 1.5 1.5 0 0 0 16.5 13 z M 21.5 13 A 1.50015 1.50015 0 1 0 21.5 16 L 31.5 16 A 1.50015 1.50015 0 1 0 31.5 13 L 21.5 13 z M 16.5 19 A 1.5 1.5 0 0 0 16.5 22 A 1.5 1.5 0 0 0 16.5 19 z M 21.5 19 A 1.50015 1.50015 0 1 0 21.5 22 L 31.5 22 A 1.50015 1.50015 0 1 0 31.5 19 L 21.5 19 z M 16.5 25 A 1.5 1.5 0 0 0 16.5 28 A 1.5 1.5 0 0 0 16.5 25 z M 21.5 25 C 20.672 25 20 25.671 20 26.5 C 20 27.329 20.672 28 21.5 28 L 27.632812 28 C 28.828813 26.755 30.266 25.743734 31.875 25.052734 C 31.754 25.021734 31.63 25 31.5 25 L 21.5 25 z M 37 26 C 30.925 26 26 30.925 26 37 C 26 43.075 30.925 48 37 48 C 43.075 48 48 43.075 48 37 C 48 30.925 43.075 26 37 26 z M 33 30 L 41 30 C 41.553 30 42 30.448 42 31 C 42 31.552 41.553 32 41 32 L 41 34 C 41 35.2 40.457187 36.266 39.617188 37 C 40.457188 37.734 41 38.8 41 40 L 41 42 C 41.553 42 42 42.448 42 43 C 42 43.552 41.553 44 41 44 L 40 44 L 34 44 L 33 44 C 32.447 44 32 43.552 32 43 C 32 42.448 32.447 42 33 42 L 33 40 C 33 38.8 33.542813 37.734 34.382812 37 C 33.542812 36.266 33 35.2 33 34 L 33 32 C 32.447 32 32 31.552 32 31 C 32 30.448 32.447 30 33 30 z M 35 32 L 35 34 L 39 34 L 39 32 L 35 32 z M 37 38 C 35.897 38 35 38.897 35 40 L 35 41.611328 L 36.683594 41.050781 C 36.888594 40.982781 37.111406 40.982781 37.316406 41.050781 L 39 41.611328 L 39 40 C 39 38.897 38.103 38 37 38 z"></path>
                        </svg>
                        <p class="ml-2">Activity Logs</p>
                    </a>
                    <a href="{{ route('system-configuration') }}" @click="activeLink = 'settings'; activeChildLink = ''; localStorage.setItem('activeLink', 'settings'); localStorage.setItem('activeChildLink', '')" :class="{ 'bg-[#D9D9D9] text-[12px] bg-opacity-40 text-[#FF9100] border-l-[#FF9100] border-l-[5px] font-bold': activeLink === 'settings' }" class="ml-2 flex items-center py-2.5 px-4 rounded hover:bg-[#D9D9D9] hover:bg-opacity-40 hover:border-l-[#D9D9D9] hover:border-l-[5px] hover:text-[#FF9100]">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                            <path d="M 10 6 A 4 4 0 0 0 6 10 L 6 38 A 4 4 0 0 0 10 42 L 38 42 A 4 4 0 0 0 42 38 L 42 10 A 4 4 0 0 0 38 6 L 10 6 z M 10 9 L 38 9 A 1 1 0 0 1 39 10 L 39 38 A 1 1 0 0 1 38 39 L 10 39 A 1 1 0 0 1 9 38 L 9 10 A 1 1 0 0 1 10 9 z M 23 13 A 2 2 0 0 0 21 15 L 21 15.410156 A 1.87 1.87 0 0 1 20 17.050781 L 20 17.099609 A 1.92 1.92 0 0 1 18.089844 17.099609 L 17.740234 16.890625 A 2 2 0 0 0 15 17.619141 L 14 19.359375 A 2 2 0 0 0 14.740234 22.089844 L 15.119141 22.310547 A 1.91 1.91 0 0 1 16.119141 23.980469 A 1.91 1.91 0 0 1 15.119141 25.650391 L 14.740234 25.869141 A 2 2 0 0 0 14 28.630859 L 15 30.369141 A 2 2 0 0 0 17.740234 31.099609 L 18.089844 30.890625 A 1.92 1.92 0 0 1 20 30.890625 L 20 31 A 1.87 1.87 0 0 1 21 32.640625 L 21 33 A 2 2 0 0 0 23 35 L 25 35 A 2 2 0 0 0 27 33 L 27 32.589844 A 1.87 1.87 0 0 1 28 31 L 28 30.900391 A 1.92 1.92 0 0 1 29.910156 30.900391 L 30.259766 31.109375 A 2 2 0 0 0 33 30.369141 L 34 28.630859 A 2 2 0 0 0 33.289062 25.900391 L 32.910156 25.679688 A 1.91 1.91 0 0 1 32 24 A 1.91 1.91 0 0 1 33 22.330078 L 33.380859 22.109375 A 2 2 0 0 0 34 19.369141 L 33 17.630859 A 2 2 0 0 0 30.259766 16.900391 L 29.910156 17.109375 A 1.92 1.92 0 0 1 28 17.109375 L 28 17.050781 A 1.87 1.87 0 0 1 27 15.410156 L 27 15 A 2 2 0 0 0 25 13 L 23 13 z M 23.875 21.001953 A 3 3 0 0 1 27 24 A 3 3 0 0 1 24 27 A 3 3 0 0 1 23.875 21.001953 z"></path>
                        </svg>
                        <p class="ml-2">Settings</p>
                    </a>
                    <a href="{{ route('user-role-management') }}" @click="activeLink = 'user-role-management'; activeChildLink = ''; localStorage.setItem('activeLink', 'user-role-management'); localStorage.setItem('activeChildLink', '')" :class="{ 'bg-[#D9D9D9] text-[12px] bg-opacity-40 text-[#FF9100] border-l-[#FF9100] border-l-[5px] font-bold': activeLink === 'user-role-management' }" class="ml-2 flex items-center py-2.5 px-4 rounded hover:bg-[#D9D9D9] hover:bg-opacity-40 hover:border-l-[#D9D9D9] hover:border-l-[5px] hover:text-[#FF9100]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        <p class="ml-2">User Management</p>
                    </a>
                @endrole

                @role('Housing System Admin|Housing System Staff')
                    <!-- Housing menu will be shown for Housing System Admin only -->
                    <a href="{{ route('dashboard') }}" @click="activeLink = 'dashboard'; activeChildLink = ''; localStorage.setItem('activeLink', 'dashboard'); localStorage.setItem('activeChildLink', '')" :class="{ 'bg-[#D9D9D9] text-[12px] bg-opacity-40 text-[#FF9100] border-l-[#FF9100] border-l-[5px] font-bold': activeLink === 'dashboard' }"
                       class="mx-2 flex items-center  py-2.5 px-4 rounded hover:bg-[#D9D9D9] hover:bg-opacity-40 hover:border-l-[#D9D9D9] hover:border-l-[5px] hover:text-[12px] hover:text-[#FF9100]">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-5 h-5 mx-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span class="ml-2">Dashboard</span>
                    </a>

                    <div x-data="{ isApplicationsOpen: false }">
                        <!-- Applications Menu -->
                        <a href="#" @click="isApplicationsOpen = !isApplicationsOpen; activeLink = 'applications'; localStorage.setItem('activeLink', 'applications')"
                           :class="{ 'bg-[#D9D9D9] bg-opacity-40 text-[#FF9100] border-l-[#FF9100] border-l-[5px] font-bold': activeLink === 'applications' }"
                           class="mx-2 flex items-center justify-between py-2.5 px-4 rounded hover:bg-[#D9D9D9] hover:bg-opacity-40 hover:border-l-[#D9D9D9] hover:border-l-[5px] hover:text-[#FF9100]">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 13 7 C 11.125 7 9.5288151 7.7571335 8.5039062 8.9101562 C 7.4789976 10.063179 7 11.541667 7 13 C 7 14.458333 7.4789975 15.936821 8.5039062 17.089844 C 9.5288151 18.242867 11.125 19 13 19 C 14.875 19 16.471185 18.242867 17.496094 17.089844 C 18.521003 15.936821 19 14.458333 19 13 C 19 11.541667 18.521003 10.063179 17.496094 8.9101562 C 16.471185 7.7571335 14.875 7 13 7 z M 35 7 C 33.125 7 31.528815 7.7571335 30.503906 8.9101562 C 29.478997 10.063179 29 11.541667 29 13 C 29 14.458333 29.478997 15.936821 30.503906 17.089844 C 31.528815 18.242867 33.125 19 35 19 C 36.875 19 38.471185 18.242867 39.496094 17.089844 C 40.521003 15.936821 41 14.458333 41 13 C 41 11.541667 40.521003 10.063179 39.496094 8.9101562 C 38.471185 7.7571335 36.875 7 35 7 z M 13 10 C 14.124999 10 14.778816 10.367867 15.253906 10.902344 C 15.728997 11.436821 16 12.208333 16 13 C 16 13.791667 15.728997 14.563179 15.253906 15.097656 C 14.778816 15.632133 14.124999 16 13 16 C 11.875001 16 11.221184 15.632133 10.746094 15.097656 C 10.271003 14.563179 10 13.791667 10 13 C 10 12.208333 10.271003 11.436821 10.746094 10.902344 C 11.221184 10.367867 11.875001 10 13 10 z M 35 10 C 36.124999 10 36.778816 10.367867 37.253906 10.902344 C 37.728997 11.436821 38 12.208333 38 13 C 38 13.791667 37.728997 14.563179 37.253906 15.097656 C 36.778816 15.632133 36.124999 16 35 16 C 33.875001 16 33.221184 15.632133 32.746094 15.097656 C 32.271003 14.563179 32 13.791667 32 13 C 32 12.208333 32.271003 11.436821 32.746094 10.902344 C 33.221184 10.367867 33.875001 10 35 10 z M 24 17 C 22.125 17 20.528815 17.757133 19.503906 18.910156 C 18.478997 20.063179 18 21.541667 18 23 C 18 24.458333 18.478997 25.936821 19.503906 27.089844 C 20.528815 28.242867 22.125 29 24 29 C 25.875 29 27.471185 28.242867 28.496094 27.089844 C 29.521003 25.936821 30 24.458333 30 23 C 30 21.541667 29.521003 20.063179 28.496094 18.910156 C 27.471185 17.757133 25.875 17 24 17 z M 24 20 C 25.124999 20 25.778816 20.367867 26.253906 20.902344 C 26.728997 21.436821 27 22.208333 27 23 C 27 23.791667 26.728997 24.563179 26.253906 25.097656 C 25.778816 25.632133 25.124999 26 24 26 C 22.875001 26 22.221184 25.632133 21.746094 25.097656 C 21.271003 24.563179 21 23.791667 21 23 C 21 22.208333 21.271003 21.436821 21.746094 20.902344 C 22.221184 20.367867 22.875001 20 24 20 z M 7.5 21 C 5.57 21 4 22.57 4 24.5 L 4 27 C 4 30.36 7.95 33 13 33 L 13.210938 33 C 13.660937 31.39 14.839375 30.079688 16.359375 29.429688 C 15.409375 29.779688 14.26 30 13 30 C 9.57 30 7 28.42 7 27 L 7 24.5 C 7 24.22 7.22 24 7.5 24 L 16.060547 24 C 16.020547 23.67 16 23.34 16 23 C 16 22.31 16.09 21.64 16.25 21 L 7.5 21 z M 31.75 21 C 31.91 21.64 32 22.31 32 23 C 32 23.34 31.979453 23.67 31.939453 24 L 40.5 24 C 40.78 24 41 24.22 41 24.5 L 41 27 C 41 28.42 38.43 30 35 30 C 33.74 30 32.590625 29.779688 31.640625 29.429688 C 33.160625 30.079687 34.339063 31.39 34.789062 33 L 35 33 C 40.05 33 44 30.36 44 27 L 44 24.5 C 44 22.57 42.43 21 40.5 21 L 31.75 21 z M 18.5 31 C 16.585045 31 15 32.585045 15 34.5 L 15 37 C 15 38.918154 16.279921 40.481204 17.925781 41.46875 C 19.571641 42.456296 21.68576 43 24 43 C 26.31424 43 28.428359 42.456296 30.074219 41.46875 C 31.720079 40.481204 33 38.918154 33 37 L 33 34.5 C 33 32.585045 31.414955 31 29.5 31 L 18.5 31 z M 18.5 34 L 29.5 34 C 29.795045 34 30 34.204955 30 34.5 L 30 37 C 30 37.566846 29.59989 38.255281 28.53125 38.896484 C 27.46261 39.537688 25.82776 40 24 40 C 22.17224 40 20.53739 39.537688 19.46875 38.896484 C 18.40011 38.255281 18 37.566846 18 37 L 18 34.5 C 18 34.204955 18.204955 34 18.5 34 z"></path>
                                </svg>
                                <p class="ml-2">Applications</p>
                            </div>
                            <svg :class="{ 'transform rotate-180': isApplicationsOpen }"
                                 class="w-4 h-4 transition-transform duration-200"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>

                        <!-- Applications Submenus -->
                        <div x-show="isApplicationsOpen" x-transition class="ml-6">
                            <!-- Applicants -->
                            <a href="{{ route('applicants') }}"
                               @click="activeChildLink = 'admin-applicants'; localStorage.setItem('activeChildLink', 'admin-applicants')"
                               :class="{ 'text-[#FF9100] font-bold': activeChildLink === 'admin-applicants' }"
                               class="flex items-center py-2 px-4 hover:text-[#FF9100]">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 12.5 4 C 10.02 4 8 6.02 8 8.5 L 8 39.5 C 8 41.98 10.02 44 12.5 44 L 26.539062 44 C 26.189063 43.4 26 42.73 26 42 L 26 41 L 12.5 41 C 11.67 41 11 40.33 11 39.5 L 11 8.5 C 11 7.67 11.67 7 12.5 7 L 35.5 7 C 36.33 7 37 7.67 37 8.5 L 37 24 C 38.01 24 39.02 24.070938 40 24.210938 L 40 8.5 C 40 6.02 37.98 4 35.5 4 L 12.5 4 z M 24 10 A 3.5 3.5 0 1 0 24 17 A 3.5 3.5 0 1 0 24 10 z M 19.5 19 C 18.672 19 18 19.672 18 20.5 L 18 21.5 C 18 23.433 20.686 25 24 25 C 27.314 25 30 23.433 30 21.5 L 30 20.5 C 30 19.672 29.328 19 28.5 19 L 19.5 19 z M 37 26 C 32.029 26 28 27.791 28 30 C 28 32.209 32.029 34 37 34 C 41.971 34 46 32.209 46 30 C 46 27.791 41.971 26 37 26 z M 16.5 28 C 15.67 28 15 28.67 15 29.5 C 15 30.33 15.67 31 16.5 31 L 26 31 L 26 30 C 26 29.27 26.189063 28.6 26.539062 28 L 16.5 28 z M 28 33 L 28 36 C 28 38.21 32.03 40 37 40 C 41.97 40 46 38.21 46 36 L 46 33 C 46 35.21 41.97 37 37 37 C 32.03 37 28 35.21 28 33 z M 16.5 34 C 15.67 34 15 34.67 15 35.5 C 15 36.33 15.67 37 16.5 37 L 26 37 L 26 34 L 16.5 34 z M 28 39 L 28 42 C 28 44.21 32.03 46 37 46 C 41.97 46 46 44.21 46 42 L 46 39 C 46 41.21 41.97 43 37 43 C 32.03 43 28 41.21 28 39 z"></path>
                                </svg>
                                <span class="ml-2">Applicants</span>
                            </a>

                            <!-- Tagged/Validated -->
                            <a href="{{ route('transaction-request') }}"
                               @click="activeChildLink = 'admin-transactions-request'; localStorage.setItem('activeChildLink', 'admin-transactions-request')"
                               :class="{ 'text-[#FF9100] font-bold': activeChildLink === 'admin-transactions-request' }"
                               class="flex items-center py-2 px-4 hover:text-[#FF9100]">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 24 5.0273438 C 22.851301 5.0273438 21.70304 5.4009945 20.753906 6.1484375 A 1.50015 1.50015 0 0 0 20.658203 6.2304688 L 4.5546875 21.255859 C 2.8485365 22.847233 2.8013499 25.586506 4.4511719 27.236328 C 6.036957 28.822113 8.6399476 28.853448 10.261719 27.304688 A 1.50015 1.50015 0 0 0 10.265625 27.300781 L 24.003906 14.085938 L 37.734375 27.298828 A 1.50015 1.50015 0 0 0 37.738281 27.302734 C 39.359795 28.852802 41.963043 28.824063 43.548828 27.238281 C 45.19865 25.588459 45.151465 22.849186 43.445312 21.257812 L 27.341797 6.2304688 A 1.50015 1.50015 0 0 0 27.246094 6.1484375 C 26.296957 5.4009942 25.148699 5.0273438 24 5.0273438 z M 24 8.0195312 C 24.485694 8.0195312 24.970178 8.1837987 25.378906 8.5019531 L 41.400391 23.451172 C 41.89424 23.911798 41.905915 24.63901 41.427734 25.117188 C 40.971519 25.573401 40.277033 25.580696 39.810547 25.134766 L 25.044922 10.923828 A 1.50015 1.50015 0 0 0 22.964844 10.923828 L 8.1894531 25.134766 C 7.723224 25.580006 7.0284805 25.571449 6.5722656 25.115234 C 6.0940876 24.637056 6.1057604 23.909845 6.5996094 23.449219 L 22.621094 8.5019531 C 23.029822 8.1837987 23.514306 8.0195312 24 8.0195312 z"></path>
                                </svg>
                                <span class="ml-2">Tagged/Validated</span>
                            </a>

                            <!-- Awardee List -->
                            <a href="{{ route('awardee-list') }}"
                               @click="activeChildLink = 'awardee'; localStorage.setItem('activeChildLink', 'awardee')"
                               :class="{ 'text-[#FF9100] font-bold': activeChildLink === 'awardee' }"
                               class="flex items-center py-2 px-4 hover:text-[#FF9100]">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 21 4 C 15.494917 4 11 8.494921 11 14 C 11 19.505079 15.494917 24 21 24 C 26.505083 24 31 19.505079 31 14 C 31 8.494921 26.505083 4 21 4 z M 21 7 C 24.883764 7 28 10.116238 28 14 C 28 17.883762 24.883764 21 21 21 C 17.116236 21 14 17.883762 14 14 C 14 10.116238 17.116236 7 21 7 z M 35 24 C 28.925 24 24 28.925 24 35 C 24 41.075 28.925 46 35 46 C 41.075 46 46 41.075 46 35 C 46 28.925 41.075 24 35 24 z M 9.5 28 C 7.02 28 5 30.02 5 32.5 L 5 33.699219 C 5 39.479219 12.03 44 21 44 C 22.49 44 23.929062 43.870859 25.289062 43.630859 C 24.549063 42.800859 23.910391 41.880859 23.400391 40.880859 C 22.630391 40.960859 21.83 41 21 41 C 12.97 41 8 37.209219 8 33.699219 L 8 32.5 C 8 31.67 8.67 31 9.5 31 L 22.630859 31 C 22.970859 29.93 23.450781 28.93 24.050781 28 L 9.5 28 z"></path>
                                </svg>
                                <span class="ml-2">Awardee List</span>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('relocation-sites') }}" @click="activeLink = 'relocation'; activeChildLink = ''; localStorage.setItem('activeLink', 'relocation'); localStorage.setItem('activeChildLink', '')" :class="{ 'bg-[#D9D9D9] text-[12px] bg-opacity-40 text-[#FF9100] border-l-[#FF9100] border-l-[5px] font-bold': activeLink === 'relocation' }" class="mx-2 flex items-center py-2.5 px-4 rounded hover:bg-[#D9D9D9] hover:bg-opacity-40 hover:border-l-[#D9D9D9] hover:border-l-[5px] hover:text-[#FF9100]">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                            <path d="M 24 4 C 14.629252 4 7 11.629252 7 21 C 7 25.20679 8.5433056 29.064832 11.078125 32.03125 L 11.085938 32.039062 L 11.091797 32.046875 C 11.091797 32.046875 18.323729 40.299027 20.898438 42.755859 C 22.622568 44.39966 25.375478 44.39966 27.099609 42.755859 C 30.034388 39.956663 36.910156 32.042969 36.910156 32.042969 L 36.914062 32.037109 L 36.919922 32.03125 C 39.456988 29.064801 41 25.20679 41 21 C 41 11.629252 33.370748 4 24 4 z M 24 7 C 31.749252 7 38 13.250748 38 21 C 38 24.47521 36.733544 27.632586 34.638672 30.082031 C 34.625032 30.097631 27.590036 38.143501 25.029297 40.585938 C 24.435428 41.152136 23.562619 41.152136 22.96875 40.585938 C 20.828579 38.543748 13.381099 30.106639 13.359375 30.082031 L 13.357422 30.080078 C 11.265326 27.630829 10 24.474248 10 21 C 10 13.250748 16.250748 7 24 7 z M 24 15 C 22.125 15 20.528815 15.757133 19.503906 16.910156 C 18.478997 18.063179 18 19.541667 18 21 C 18 22.458333 18.478997 23.936821 19.503906 25.089844 C 20.528815 26.242867 22.125 27 24 27 C 25.875 27 27.471185 26.242867 28.496094 25.089844 C 29.521003 23.936821 30 22.458333 30 21 C 30 19.541667 29.521003 18.063179 28.496094 16.910156 C 27.471185 15.757133 25.875 15 24 15 z M 24 18 C 25.124999 18 25.778816 18.367867 26.253906 18.902344 C 26.728997 19.436821 27 20.208333 27 21 C 27 21.791667 26.728997 22.563179 26.253906 23.097656 C 25.778816 23.632133 25.124999 24 24 24 C 22.875001 24 22.221184 23.632133 21.746094 23.097656 C 21.271003 22.563179 21 21.791667 21 21 C 21 20.208333 21.271003 19.436821 21.746094 18.902344 C 22.221184 18.367867 22.875001 18 24 18 z"></path>
                        </svg>
                        <p class="ml-2">Relocation Sites</p>
                    </a>

                    <div x-data="{ isReportsOpen: false }">
                        <!-- Reports Menu -->
                        <a href="#" @click="isReportsOpen = !isReportsOpen; activeLink = 'reports'; localStorage.setItem('activeLink', 'reports')"
                           :class="{ 'bg-[#D9D9D9] bg-opacity-40 text-[#FF9100] border-l-[#FF9100] border-l-[5px] font-bold': activeLink === 'reports' }"
                           class="mx-2 flex items-center justify-between py-2.5 px-4 rounded hover:bg-[#D9D9D9] hover:bg-opacity-40 hover:border-l-[#D9D9D9] hover:border-l-[5px] hover:text-[#FF9100]">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-5 h-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="ml-2">Reports</p>
                            </div>
                            <svg :class="{ 'transform rotate-180': isReportsOpen }"
                                 class="w-4 h-4 transition-transform duration-200"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>

                        <!-- Reports Submenus -->
                        <div x-show="isReportsOpen" x-transition class="ml-6">
                            <!-- Transfer Histories -->
                            <a href="{{ route('transfer-histories') }}"
                               @click="activeChildLink = 'transfer-histories'; localStorage.setItem('activeChildLink', 'transfer-histories')"
                               :class="{ 'text-[#FF9100] font-bold': activeChildLink === 'transfer-histories' }"
                               class="flex items-center py-2 px-4 hover:text-[#FF9100]">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 24 4 C 12.972066 4 4 12.972074 4 24 C 4 35.027926 12.972066 44 24 44 C 35.027934 44 44 35.027926 44 24 C 44 12.972074 35.027934 4 24 4 z M 24 7 C 33.406615 7 41 14.593391 41 24 C 41 33.406609 33.406615 41 24 41 C 14.593385 41 7 33.406609 7 24 C 7 14.593391 14.593385 7 24 7 z M 23.976562 12.978516 A 1.50015 1.50015 0 0 0 22.5 14.5 L 22.5 24 C 22.5 24.397 22.658 24.774781 22.933594 25.050781 L 28.933594 31.050781 A 1.50015 1.50015 0 1 0 31.066406 28.917969 L 25.5 23.351562 L 25.5 14.5 A 1.50015 1.50015 0 0 0 23.976562 12.978516 z"></path>
                                </svg>
                                <span class="ml-2">Transfer Histories</span>
                            </a>

                            <!-- Blacklist -->
                            <a href="{{ route('blacklist') }}"
                               @click="activeChildLink = 'blacklist'; localStorage.setItem('activeChildLink', 'blacklist')"
                               :class="{ 'text-[#FF9100] font-bold': activeChildLink === 'blacklist' }"
                               class="flex items-center py-2 px-4 hover:text-[#FF9100]">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 24 4 C 12.972066 4 4 12.972074 4 24 C 4 35.027926 12.972066 44 24 44 C 35.027934 44 44 35.027926 44 24 C 44 12.972074 35.027934 4 24 4 z M 24 7 C 33.406615 7 41 14.593391 41 24 C 41 33.406609 33.406615 41 24 41 C 14.593385 41 7 33.406609 7 24 C 7 14.593391 14.593385 7 24 7 z M 31.976562 15.978516 A 1.50015 1.50015 0 0 0 30.939453 16.439453 L 24 23.378906 L 17.060547 16.439453 A 1.50015 1.50015 0 0 0 15.939453 16.439453 A 1.50015 1.50015 0 0 0 15.939453 17.560547 L 22.878906 24.5 L 15.939453 31.439453 A 1.50015 1.50015 0 1 0 17.060547 32.560547 L 24 25.621094 L 30.939453 32.560547 A 1.50015 1.50015 0 1 0 32.060547 31.439453 L 25.121094 24.5 L 32.060547 17.560547 A 1.50015 1.50015 0 0 0 31.976562 15.978516 z"></path>
                                </svg>
                                <span class="ml-2">Blacklist</span>
                            </a>

                            <!-- Summary of Identified Informal Settlers -->
                            <a href="{{ route('summary-of-identified-informal-settlers') }}"
                               @click="activeChildLink = 'summary-of-identified-informal-settlers'; localStorage.setItem('activeChildLink', 'summary-of-identified-informal-settlers')"
                               :class="{ 'text-[#FF9100] font-bold': activeChildLink === 'summary-of-identified-informal-settlers' }"
                               class="flex items-center py-2 px-4 hover:text-[#FF9100]">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 7 4 C 6.448 4 6 4.448 6 5 L 6 43 C 6 43.552 6.448 44 7 44 L 41 44 C 41.552 44 42 43.552 42 43 L 42 5 C 42 4.448 41.552 4 41 4 L 7 4 z M 9 7 L 39 7 L 39 41 L 9 41 L 9 7 z M 14 12 L 14 15 L 34 15 L 34 12 L 14 12 z M 14 20 L 14 23 L 34 23 L 34 20 L 14 20 z M 14 28 L 14 31 L 34 31 L 34 28 L 14 28 z M 14 36 L 14 39 L 34 39 L 34 36 L 14 36 z"></path>
                                </svg>
                                <span class="ml-2">Summary of Identified Informal Settlers</span>
                            </a>

                            <!-- Summary of Relocation Lot Applicants -->
                            <a href="{{ route('summary-of-relocation-lot-applicants') }}"
                               @click="activeChildLink = 'summary-of-relocation-lot-applicants'; localStorage.setItem('activeChildLink', 'summary-of-relocation-lot-applicants')"
                               :class="{ 'text-[#FF9100] font-bold': activeChildLink === 'summary-of-relocation-lot-applicants' }"
                               class="flex items-center py-2 px-4 hover:text-[#FF9100]">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 6 5 C 5.448 5 5 5.448 5 6 L 5 42 C 5 42.552 5.448 43 6 43 L 42 43 C 42.552 43 43 42.552 43 42 L 43 6 C 43 5.448 42.552 5 42 5 L 6 5 z M 8 8 L 40 8 L 40 40 L 8 40 L 8 8 z M 14.5 13 C 13.67 13 13 13.67 13 14.5 L 13 15.5 C 13 16.33 13.67 17 14.5 17 L 33.5 17 C 34.33 17 35 16.33 35 15.5 L 35 14.5 C 35 13.67 34.33 13 33.5 13 L 14.5 13 z M 14.5 23 C 13.67 23 13 23.67 13 24.5 L 13 25.5 C 13 26.33 13.67 27 14.5 27 L 33.5 27 C 34.33 27 35 26.33 35 25.5 L 35 24.5 C 35 23.67 34.33 23 33.5 23 L 14.5 23 z M 14.5 33 C 13.67 33 13 33.67 13 34.5 L 13 35.5 C 13 36.33 13.67 37 14.5 37 L 33.5 37 C 34.33 37 35 36.33 35 35.5 L 35 34.5 C 35 33.67 34.33 33 33.5 33 L 14.5 33 z"></path>
                                </svg>
                                <span class="ml-2">Summary of Relocation Lot Applicants</span>
                            </a>

                            <!-- Masterlist of Actual Occupants -->
                            <a href="{{ route('masterlist-of-actual-occupants') }}"
                               @click="activeChildLink = 'masterlist-of-actual-occupants'; localStorage.setItem('activeChildLink', 'masterlist-of-actual-occupants')"
                               :class="{ 'text-[#FF9100] font-bold': activeChildLink === 'masterlist-of-actual-occupants' }"
                               class="flex items-center py-2 px-4 hover:text-[#FF9100]">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                                    <path d="M 12.5 4 C 10.032499 4 8 6.0324991 8 8.5 L 8 39.5 C 8 41.967501 10.032499 44 12.5 44 L 35.5 44 C 37.967501 44 40 41.967501 40 39.5 L 40 18.5 A 1.50015 1.50015 0 0 0 39.560547 17.439453 L 26.560547 4.4394531 A 1.50015 1.50015 0 0 0 25.5 4 L 12.5 4 z M 12.5 7 L 24 7 L 24 16.5 C 24 18.967501 26.032499 21 28.5 21 L 37 21 L 37 39.5 C 37 40.346499 36.346499 41 35.5 41 L 12.5 41 C 11.653501 41 11 40.346499 11 39.5 L 11 8.5 C 11 7.6535009 11.653501 7 12.5 7 z M 27 9.1210938 L 34.878906 17 L 28.5 17 C 27.653501 17 27 16.346499 27 15.5 L 27 9.1210938 z"></path>
                                </svg>
                                <span class="ml-2">Masterlist of Actual Occupants</span>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('activity-logs') }}" @click="activeLink = 'activity'; activeChildLink = ''; localStorage.setItem('activeLink', 'activity'); localStorage.setItem('activeChildLink', '')" :class="{ 'bg-[#D9D9D9] text-[12px] bg-opacity-40 text-[#FF9100] border-l-[#FF9100] border-l-[5px] font-bold': activeLink === 'activity' }" class="mx-2 flex items-center py-2.5 px-4 rounded hover:bg-[#D9D9D9] hover:bg-opacity-40 hover:border-l-[#D9D9D9] hover:border-l-[5px] hover:text-[#FF9100]">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                            <path d="M 12.5 5 C 10.019 5 8 7.019 8 9.5 L 8 33 L 6.5 33 C 5.672 33 5 33.671 5 34.5 L 5 36.5 C 5 40.084 7.916 43 11.5 43 L 25.474609 43 C 24.985609 42.062 24.611328 41.055 24.361328 40 L 11.5 40 C 9.57 40 8 38.43 8 36.5 L 8 36 L 24.050781 36 C 24.129781 34.961 24.325766 33.956 24.634766 33 L 11 33 L 11 9.5 C 11 8.673 11.673 8 12.5 8 L 35.5 8 C 36.327 8 37 8.673 37 9.5 L 37 24 C 38.034 24 39.035 24.133328 40 24.361328 L 40 9.5 C 40 7.019 37.981 5 35.5 5 L 12.5 5 z M 16.5 13 A 1.5 1.5 0 0 0 16.5 16 A 1.5 1.5 0 0 0 16.5 13 z M 21.5 13 A 1.50015 1.50015 0 1 0 21.5 16 L 31.5 16 A 1.50015 1.50015 0 1 0 31.5 13 L 21.5 13 z M 16.5 19 A 1.5 1.5 0 0 0 16.5 22 A 1.5 1.5 0 0 0 16.5 19 z M 21.5 19 A 1.50015 1.50015 0 1 0 21.5 22 L 31.5 22 A 1.50015 1.50015 0 1 0 31.5 19 L 21.5 19 z M 16.5 25 A 1.5 1.5 0 0 0 16.5 28 A 1.5 1.5 0 0 0 16.5 25 z M 21.5 25 C 20.672 25 20 25.671 20 26.5 C 20 27.329 20.672 28 21.5 28 L 27.632812 28 C 28.828813 26.755 30.266 25.743734 31.875 25.052734 C 31.754 25.021734 31.63 25 31.5 25 L 21.5 25 z M 37 26 C 30.925 26 26 30.925 26 37 C 26 43.075 30.925 48 37 48 C 43.075 48 48 43.075 48 37 C 48 30.925 43.075 26 37 26 z M 33 30 L 41 30 C 41.553 30 42 30.448 42 31 C 42 31.552 41.553 32 41 32 L 41 34 C 41 35.2 40.457187 36.266 39.617188 37 C 40.457188 37.734 41 38.8 41 40 L 41 42 C 41.553 42 42 42.448 42 43 C 42 43.552 41.553 44 41 44 L 40 44 L 34 44 L 33 44 C 32.447 44 32 43.552 32 43 C 32 42.448 32.447 42 33 42 L 33 40 C 33 38.8 33.542813 37.734 34.382812 37 C 33.542812 36.266 33 35.2 33 34 L 33 32 C 32.447 32 32 31.552 32 31 C 32 30.448 32.447 30 33 30 z M 35 32 L 35 34 L 39 34 L 39 32 L 35 32 z M 37 38 C 35.897 38 35 38.897 35 40 L 35 41.611328 L 36.683594 41.050781 C 36.888594 40.982781 37.111406 40.982781 37.316406 41.050781 L 39 41.611328 L 39 40 C 39 38.897 38.103 38 37 38 z"></path>
                        </svg>
                        <p class="ml-2">Activity Logs</p>
                    </a>
                    <a href="{{ route('system-configuration') }}" @click="activeLink = 'settings'; activeChildLink = ''; localStorage.setItem('activeLink', 'settings'); localStorage.setItem('activeChildLink', '')" :class="{ 'bg-[#D9D9D9] text-[12px] bg-opacity-40 text-[#FF9100] border-l-[#FF9100] border-l-[5px] font-bold': activeLink === 'settings' }" class="ml-2 flex items-center py-2.5 px-4 rounded hover:bg-[#D9D9D9] hover:bg-opacity-40 hover:border-l-[#D9D9D9] hover:border-l-[5px] hover:text-[#FF9100]">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                            <path d="M 10 6 A 4 4 0 0 0 6 10 L 6 38 A 4 4 0 0 0 10 42 L 38 42 A 4 4 0 0 0 42 38 L 42 10 A 4 4 0 0 0 38 6 L 10 6 z M 10 9 L 38 9 A 1 1 0 0 1 39 10 L 39 38 A 1 1 0 0 1 38 39 L 10 39 A 1 1 0 0 1 9 38 L 9 10 A 1 1 0 0 1 10 9 z M 23 13 A 2 2 0 0 0 21 15 L 21 15.410156 A 1.87 1.87 0 0 1 20 17.050781 L 20 17.099609 A 1.92 1.92 0 0 1 18.089844 17.099609 L 17.740234 16.890625 A 2 2 0 0 0 15 17.619141 L 14 19.359375 A 2 2 0 0 0 14.740234 22.089844 L 15.119141 22.310547 A 1.91 1.91 0 0 1 16.119141 23.980469 A 1.91 1.91 0 0 1 15.119141 25.650391 L 14.740234 25.869141 A 2 2 0 0 0 14 28.630859 L 15 30.369141 A 2 2 0 0 0 17.740234 31.099609 L 18.089844 30.890625 A 1.92 1.92 0 0 1 20 30.890625 L 20 31 A 1.87 1.87 0 0 1 21 32.640625 L 21 33 A 2 2 0 0 0 23 35 L 25 35 A 2 2 0 0 0 27 33 L 27 32.589844 A 1.87 1.87 0 0 1 28 31 L 28 30.900391 A 1.92 1.92 0 0 1 29.910156 30.900391 L 30.259766 31.109375 A 2 2 0 0 0 33 30.369141 L 34 28.630859 A 2 2 0 0 0 33.289062 25.900391 L 32.910156 25.679688 A 1.91 1.91 0 0 1 32 24 A 1.91 1.91 0 0 1 33 22.330078 L 33.380859 22.109375 A 2 2 0 0 0 34 19.369141 L 33 17.630859 A 2 2 0 0 0 30.259766 16.900391 L 29.910156 17.109375 A 1.92 1.92 0 0 1 28 17.109375 L 28 17.050781 A 1.87 1.87 0 0 1 27 15.410156 L 27 15 A 2 2 0 0 0 25 13 L 23 13 z M 23.875 21.001953 A 3 3 0 0 1 27 24 A 3 3 0 0 1 24 27 A 3 3 0 0 1 23.875 21.001953 z"></path>
                        </svg>
                        <p class="ml-2">Settings</p>
                    </a>
                @endrole

                @role('Housing System Tagger')
                    <!-- Applicants -->
                    <a href="{{ route('applicants') }}" @click="activeLink = 'applicants'; activeChildLink = ''; localStorage.setItem('activeLink', 'applicants'); localStorage.setItem('activeChildLink', '')" :class="{ 'bg-[#D9D9D9] text-[12px] bg-opacity-40 text-[#FF9100] border-l-[#FF9100] border-l-[5px] font-bold': activeLink === 'applicants' }" class="mx-2 flex items-center py-2.5 px-4 rounded hover:bg-[#D9D9D9] hover:bg-opacity-40 hover:border-l-[#D9D9D9] hover:border-l-[5px] hover:text-[#FF9100]">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                            <path d="M 12.5 4 C 10.02 4 8 6.02 8 8.5 L 8 39.5 C 8 41.98 10.02 44 12.5 44 L 26.539062 44 C 26.189063 43.4 26 42.73 26 42 L 26 41 L 12.5 41 C 11.67 41 11 40.33 11 39.5 L 11 8.5 C 11 7.67 11.67 7 12.5 7 L 35.5 7 C 36.33 7 37 7.67 37 8.5 L 37 24 C 38.01 24 39.02 24.070938 40 24.210938 L 40 8.5 C 40 6.02 37.98 4 35.5 4 L 12.5 4 z M 24 10 A 3.5 3.5 0 1 0 24 17 A 3.5 3.5 0 1 0 24 10 z M 19.5 19 C 18.672 19 18 19.672 18 20.5 L 18 21.5 C 18 23.433 20.686 25 24 25 C 27.314 25 30 23.433 30 21.5 L 30 20.5 C 30 19.672 29.328 19 28.5 19 L 19.5 19 z M 37 26 C 32.029 26 28 27.791 28 30 C 28 32.209 32.029 34 37 34 C 41.971 34 46 32.209 46 30 C 46 27.791 41.971 26 37 26 z M 16.5 28 C 15.67 28 15 28.67 15 29.5 C 15 30.33 15.67 31 16.5 31 L 26 31 L 26 30 C 26 29.27 26.189063 28.6 26.539062 28 L 16.5 28 z M 28 33 L 28 36 C 28 38.21 32.03 40 37 40 C 41.97 40 46 38.21 46 36 L 46 33 C 46 35.21 41.97 37 37 37 C 32.03 37 28 35.21 28 33 z M 16.5 34 C 15.67 34 15 34.67 15 35.5 C 15 36.33 15.67 37 16.5 37 L 26 37 L 26 34 L 16.5 34 z M 28 39 L 28 42 C 28 44.21 32.03 46 37 46 C 41.97 46 46 44.21 46 42 L 46 39 C 46 41.21 41.97 43 37 43 C 32.03 43 28 41.21 28 39 z"></path>
                        </svg>
                        <p class="ml-2">Applicants for Tagging</p>
                    </a>
                @endrole

                @role('Housing System Relocation Site Manager')
                    <a href="{{ route('relocation-sites') }}" @click="activeLink = 'relocation'; activeChildLink = ''; localStorage.setItem('activeLink', 'relocation'); localStorage.setItem('activeChildLink', '')" :class="{ 'bg-[#D9D9D9] text-[12px] bg-opacity-40 text-[#FF9100] border-l-[#FF9100] border-l-[5px] font-bold': activeLink === 'relocation' }" class="mx-2 flex items-center py-2.5 px-4 rounded hover:bg-[#D9D9D9] hover:bg-opacity-40 hover:border-l-[#D9D9D9] hover:border-l-[5px] hover:text-[#FF9100]">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-5 h-5" stroke-width="0.5">
                            <path d="M 24 4 C 14.629252 4 7 11.629252 7 21 C 7 25.20679 8.5433056 29.064832 11.078125 32.03125 L 11.085938 32.039062 L 11.091797 32.046875 C 11.091797 32.046875 18.323729 40.299027 20.898438 42.755859 C 22.622568 44.39966 25.375478 44.39966 27.099609 42.755859 C 30.034388 39.956663 36.910156 32.042969 36.910156 32.042969 L 36.914062 32.037109 L 36.919922 32.03125 C 39.456988 29.064801 41 25.20679 41 21 C 41 11.629252 33.370748 4 24 4 z M 24 7 C 31.749252 7 38 13.250748 38 21 C 38 24.47521 36.733544 27.632586 34.638672 30.082031 C 34.625032 30.097631 27.590036 38.143501 25.029297 40.585938 C 24.435428 41.152136 23.562619 41.152136 22.96875 40.585938 C 20.828579 38.543748 13.381099 30.106639 13.359375 30.082031 L 13.357422 30.080078 C 11.265326 27.630829 10 24.474248 10 21 C 10 13.250748 16.250748 7 24 7 z M 24 15 C 22.125 15 20.528815 15.757133 19.503906 16.910156 C 18.478997 18.063179 18 19.541667 18 21 C 18 22.458333 18.478997 23.936821 19.503906 25.089844 C 20.528815 26.242867 22.125 27 24 27 C 25.875 27 27.471185 26.242867 28.496094 25.089844 C 29.521003 23.936821 30 22.458333 30 21 C 30 19.541667 29.521003 18.063179 28.496094 16.910156 C 27.471185 15.757133 25.875 15 24 15 z M 24 18 C 25.124999 18 25.778816 18.367867 26.253906 18.902344 C 26.728997 19.436821 27 20.208333 27 21 C 27 21.791667 26.728997 22.563179 26.253906 23.097656 C 25.778816 23.632133 25.124999 24 24 24 C 22.875001 24 22.221184 23.632133 21.746094 23.097656 C 21.271003 22.563179 21 21.791667 21 21 C 21 20.208333 21.271003 19.436821 21.746094 18.902344 C 22.221184 18.367867 22.875001 18 24 18 z"></path>
                        </svg>
                        <p class="ml-2">Relocation Sites</p>
                    </a>
                @endrole
            </nav>
        </aside>
    </div>
</div>
@endhasanyrole

@role('Housing System Tagger')
    <div class="flex h-[100vh]">

    </div>
@endrole
