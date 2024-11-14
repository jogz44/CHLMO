<div x-data="{ openFilters: false, openModal: false }" class="p-10 h-screen ml-[17%] mt-[100px]">
    <div class="flex bg-gray-100 text-[12px]">
        <!-- Main Content -->
        <div class="flex-1 h-screen p-6 overflow-auto">
            <!-- Header -->
            <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-0 relative p-3">
                <h2 class="text-[13px] ml-5 text-gray-700">SHELTER ASSISTANCE PROGRAM MASTERLIST OF APPLICANTS </h2>
                <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                <div class="relative">
                    <!-- <button @click="openModal = true" class="bg-gradient-to-r from-custom-red to-custom-green text-white px-4 py-2 rounded">Add Applicant</button> -->
                    <button class="bg-custom-green text-white px-4 py-2 rounded">Export</button>
                </div>
            </div>
            <div class="bg-white p-6 rounded shadow">
                <div class="flex justify-between items-center">
                    <div class="flex space-x-2">
                        <button @click="openFilters = !openFilters" class="flex space-x-2 items-center hover:bg-yellow-500 py-2 px-4 rounded bg-iroad-orange">
                            <div class="text-white">
                                <!-- Filter Icon (You can use an icon from any library) -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.447.894l-4 2.5A1 1 0 017 21V13.414L3.293 6.707A1 1 0 013 6V4z" />
                                </svg>
                            </div>
                            <div class="text-[13px] text-white font-medium">
                                Filter
                            </div>
                        </button>
                        <!-- Search -->
                        <div class="flex relative z-10 md:block border-gray-300">
                            <svg class="absolute top-[8px] left-4" width="19" height="19" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.625 16.625C13.491 16.625 16.625 13.491 16.625 9.625C16.625 5.75901 13.491 2.625 9.625 2.625C5.75901 2.625 2.625 5.75901 2.625 9.625C2.625 13.491 5.75901 16.625 9.625 16.625Z" stroke="#787C7F" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M18.3746 18.375L14.5684 14.5688" stroke="#787C7F" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <input type="search" name="search" wire:model.live.debounce.300ms="search" class="capitalize rounded-md px-12 py-2 placeholder:text-[13px] border border-gray-300 focus:outline-none focus:ring-1 focus:ring-[#828181] focus:border-[#828181] bg-[#f7f7f9] " placeholder="Search">
                            <button wire:click="clearSearch" class="absolute bottom-1 right-4 text-2xl text-gray-500">
                                &times; <!-- This is the "x" symbol -->
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <label class="text-center mt-2 mr-1" for="start_date">Date Applied From:</label>
                        <input type="date" id="start_date" wire:model.live="startDate" class="border text-[13px] border-gray-300 rounded px-2 py-1" max="{{ now()->toDateString() }}">
                        <label class="text-center mt-2 ml-2 mr-1" for="end_date">To:</label>
                        <input type="date" id="end_date" wire:model.live="endDate" class="border text-[13px] border-gray-300 rounded px-2 py-1 mr-1" max="{{ now()->toDateString() }}">

                        <div class="relative group">
                            <button wire:click="resetFilters" class="flex items-center justify-center border border-gray-300 bg-gray-100 rounded w-8 h-8">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 256 256" class="w-4 h-4" xml:space="preserve">
                                    <g transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                        <path d="M 81.521 31.109 c -0.86 -1.73 -2.959 -2.438 -4.692 -1.575 c -1.73 0.86 -2.436 2.961 -1.575 4.692 c 2.329 4.685 3.51 9.734 3.51 15.01 C 78.764 67.854 63.617 83 45 83 S 11.236 67.854 11.236 49.236 c 0 -16.222 11.501 -29.805 26.776 -33.033 l -3.129 4.739 c -1.065 1.613 -0.62 3.784 0.992 4.85 c 0.594 0.392 1.264 0.579 1.926 0.579 c 1.136 0 2.251 -0.553 2.924 -1.571 l 7.176 -10.87 c 0.001 -0.001 0.001 -0.002 0.002 -0.003 l 0.018 -0.027 c 0.063 -0.096 0.106 -0.199 0.159 -0.299 c 0.049 -0.093 0.108 -0.181 0.149 -0.279 c 0.087 -0.207 0.152 -0.419 0.197 -0.634 c 0.009 -0.041 0.008 -0.085 0.015 -0.126 c 0.031 -0.182 0.053 -0.364 0.055 -0.547 c 0 -0.014 0.004 -0.028 0.004 -0.042 c 0 -0.066 -0.016 -0.128 -0.019 -0.193 c -0.008 -0.145 -0.018 -0.288 -0.043 -0.431 c -0.018 -0.097 -0.045 -0.189 -0.071 -0.283 c -0.032 -0.118 -0.065 -0.236 -0.109 -0.35 c -0.037 -0.095 -0.081 -0.185 -0.125 -0.276 c -0.052 -0.107 -0.107 -0.211 -0.17 -0.313 c -0.054 -0.087 -0.114 -0.168 -0.175 -0.25 c -0.07 -0.093 -0.143 -0.183 -0.223 -0.27 c -0.074 -0.08 -0.153 -0.155 -0.234 -0.228 c -0.047 -0.042 -0.085 -0.092 -0.135 -0.132 L 36.679 0.775 c -1.503 -1.213 -3.708 -0.977 -4.921 0.53 c -1.213 1.505 -0.976 3.709 0.53 4.921 l 3.972 3.2 C 17.97 13.438 4.236 29.759 4.236 49.236 C 4.236 71.714 22.522 90 45 90 s 40.764 -18.286 40.764 -40.764 C 85.764 42.87 84.337 36.772 81.521 31.109 z" style="fill: rgb(0,0,0);"></path>
                                    </g>
                                </svg>
                            </button>
                            <p class="absolute opacity-0 w-12/12 group-hover:opacity-50 transition-opacity duration-300 rounded-md bg-gray-700 text-[11px] text-white mt-1 p-1">
                                Reset
                            </p>
                        </div>
                    </div>
                </div>

                <div x-show="openFilters" class="flex space-x-2 mb-1 mt-5">
                    <select wire:model.live="selectedOriginOfRequest" class="border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                        <option value="">Select Request Origin</option>
                        @foreach ($originOfRequests as $origin) <!-- Corrected variable name here -->
                        <option value="{{ $origin->id }}">{{ $origin->name }}</option>
                        @endforeach
                    </select>
                    <select wire:model.live="selectedTaggingStatus" class="bg-gray-50 border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                        <option value="">Status</option>
                        @foreach($taggingStatuses as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                    <button wire:click="resetFilters" class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-4 py-1.5 rounded-full">
                        Reset Filter
                    </button>
                </div>

                <!-- Table -->
                <div x-data="{isEditModalOpen: false}" class="overflow-x-auto mt-5">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-2 border-b text-center font-medium">PROFILE NO.</th>
                                <th class="py-2 px-2 border-b text-center font-medium">NAME</th>
                                <th class="py-2 px-2 border-b text-center font-medium">DATE REQUEST</th>
                                <th class="py-2 px-2 border-b text-center font-medium">ORIGIN OF REQUEST</th>
                                <th class="py-2 px-2 border-b text-center font-medium">STATUS</th>
                                <th class="py-2 px-2 border-b text-center font-medium">AGING</th>
                                <th class="py-2 px-2 border-b text-center font-medium">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($shelterApplicants)
                            @forelse($shelterApplicants as $shelterApplicant)
                            <tr>
                                <td class="py-4 px-2 text-center border-b">{{ $shelterApplicant->profile_no }}</td>
                                <td class="py-4 px-2 text-center capitalize border-b">{{ $shelterApplicant->last_name }}, {{ $shelterApplicant->first_name }} {{ $shelterApplicant->middle_name }} {{ $applicant->suffix_name }}</td>
                                <td class="py-4 px-2 text-center capitalize border-b">{{ $shelterApplicant->created_at->format('m-d-Y') }}</td>
                                <td class="py-4 px-2 text-center capitalize border-b">{{ $shelterApplicant->OriginOfRequest->name ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center capitalize border-b">
                                    <!-- Animated Confetti -->
                                    <div class="flex items-center">
                                        @if($grantee->is_granted)
                                        Granted
                                        <span class="ml-1">
                                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                            <lord-icon src="https://cdn.lordicon.com/fkmafinl.json" trigger="loop" delay="2000" style="width: 30px; height: 30px">
                                            </lord-icon>
                                        </span>
                                        @else
                                        <span class="text-red-500">Pending...</span>
                                        @endif
                                    </div>
                                    {{ $shelterApplicant->Status ?? 'N/A' }}
                                </td>
                                <td class="py-4 px-2 text-center capitalize border-b">{{ $shelterApplicant->created_at->format('m-d-Y'), updated_at->format('m-d-Y') }}</td>
                                <td class="py-4 px-2 text-center capitalize border-b"></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No Applicants Found.</td>
                            </tr>
                            @endforelse
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>