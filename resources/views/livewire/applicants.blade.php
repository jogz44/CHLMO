<div x-data="{ openFilters: false, isModalOpen: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <!-- Main Content -->
        <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">
            <!-- Container for the Title -->
            <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-0 relative p-3">
                <div class="flex items-center">
                    <h2 class="text-[13px] ml-5 text-gray-700">APPLICANTS</h2>
                </div>
                <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                <div class="relative z-0">
                    <button @click="isModalOpen = true" class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white px-4 py-2 rounded">
                        Add Applicant
                    </button>
                    <button class="bg-custom-green text-white px-4 py-2 rounded">Export</button>
                </div>
            </div>
            <!-- Search and Filters -->
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
                        <div class="relative hidden md:block border-gray-300 z-60">
                            <svg class="absolute top-[8px] left-4" width="19" height="19" viewBox="0 0 21 21"
                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.625 16.625C13.491 16.625 16.625 13.491 16.625 9.625C16.625 5.75901 13.491 2.625 9.625 2.625C5.75901 2.625 2.625 5.75901 2.625 9.625C2.625 13.491 5.75901 16.625 9.625 16.625Z"
                                      stroke="#787C7F" stroke-width="1.75" stroke-linecap="round"
                                      stroke-linejoin="round" />
                                <path d="M18.3746 18.375L14.5684 14.5688" stroke="#787C7F" stroke-width="1.75"
                                      stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <input wire:model.live.debounce.300ms="search" type="search" name="search"
                                   class="rounded-md px-12 py-2 placeholder:text-[13px] z-60 border border-gray-300 bg-[#f7f7f9] hover:ring-custom-yellow focus:ring-custom-yellow"
                                   placeholder="Search">
                            <!-- Clear Button -->
                            <button wire:click="clearSearch" class="absolute bottom-1 right-4 text-2xl text-gray-500">
                                &times; <!-- This is the "x" symbol -->
                            </button>
                        </div>
                        <!-- Button to toggle dropdown -->
                        <div x-data="{ showDropdown: false }" class="relative">
                            <button @click="showDropdown = !showDropdown" class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-4 py-2 rounded-md items-center">
                                Toggle Columns
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="showDropdown" @click.away="showDropdown = false" class="absolute bg-white border border-gray-300 shadow-lg w-56 mt-2 py-2 rounded-lg z-10">
                                <!-- Select All Option -->
                                <label class="block px-4 py-2">
                                    <input type="checkbox" id="toggle-all" checked> Select All
                                </label>
                                <hr class="my-2">
                                <!-- Individual Column Toggles -->
                                <label class="block px-4 py-2">
                                    <input type="checkbox" class="toggle-column" id="toggle-name" checked> NAME
                                </label>
                                <label class="block px-4 py-2">
                                    <input type="checkbox" class="toggle-column" id="toggle-suffix" checked> SUFFIX NAME
                                </label>
                                <label class="block px-4 py-2">
                                    <input type="checkbox" class="toggle-column" id="toggle-contact" checked> CONTACT
                                </label>
                                <label class="block px-4 py-2">
                                    <input type="checkbox" class="toggle-column" id="toggle-purok" checked> PUROK
                                </label>
                                <label class="block px-4 py-2">
                                    <input type="checkbox" class="toggle-column" id="toggle-barangay" checked> BARANGAY
                                </label>
                                <label class="block px-4 py-2">
                                    <input type="checkbox" class="toggle-column" id="toggle-date-applied" checked> DATE APPLIED
                                </label>
                                <label class="block px-4 py-2">
                                    <input type="checkbox" class="toggle-column" id="toggle-actions" checked> ACTIONS
                                </label>
                            </div>
                        </div>

                        <!-- JavaScript for toggling columns and "Select All" -->
                        <script>
                            // Function to toggle visibility of columns
                            function toggleColumn(columnClass, isVisible) {
                                document.querySelectorAll('.' + columnClass).forEach(function(col) {
                                    col.style.display = isVisible ? '' : 'none';
                                });
                            }

                            // Select All functionality
                            document.getElementById('toggle-all').addEventListener('change', function() {
                                const isChecked = this.checked;
                                document.querySelectorAll('.toggle-column').forEach(function(checkbox) {
                                    checkbox.checked = isChecked;
                                    const columnClass = checkbox.id.replace('toggle-', '') + '-col';
                                    toggleColumn(columnClass, isChecked);
                                });
                            });

                            // Individual column checkboxes
                            document.querySelectorAll('.toggle-column').forEach(function(checkbox) {
                                checkbox.addEventListener('change', function() {
                                    const columnClass = this.id.replace('toggle-', '') + '-col';
                                    toggleColumn(columnClass, this.checked);

                                    // If any checkbox is unchecked, uncheck "Select All"
                                    if (!this.checked) {
                                        document.getElementById('toggle-all').checked = false;
                                    }

                                    // If all checkboxes are checked, check "Select All"
                                    document.getElementById('toggle-all').checked = Array.from(document.querySelectorAll('.toggle-column')).every(cb => cb.checked);
                                });
                            });
                        </script>
                    </div>

                    <div class="flex justify-end">
                        <label class="text-center mt-2 mr-1" for="start_date">Date Applied From:</label>
                        <input type="date" id="start_date" wire:model.live="startDate" class="border text-[13px] border-gray-300 rounded px-2 py-1"
                               max="{{ now()->toDateString() }}">
                        <label class="text-center mt-2 ml-2 mr-1" for="end_date">To:</label>
                        <input type="date" id="end_date" wire:model.live="endDate" class="border text-[13px] border-gray-300 rounded px-2 py-1 mr-1"
                               max="{{ now()->toDateString() }}">

                        <div class="relative group">
                            <button wire:click="resetFilters" class="flex items-center justify-center border border-gray-300 bg-gray-100 rounded w-8 h-8">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 256 256" class="w-4 h-4" xml:space="preserve">
                                    <g transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                        <path d="M 81.521 31.109 c -0.86 -1.73 -2.959 -2.438 -4.692 -1.575 c -1.73 0.86 -2.436 2.961 -1.575 4.692 c 2.329 4.685 3.51 9.734 3.51 15.01 C 78.764 67.854 63.617 83 45 83 S 11.236 67.854 11.236 49.236 c 0 -16.222 11.501 -29.805 26.776 -33.033 l -3.129 4.739 c -1.065 1.613 -0.62 3.784 0.992 4.85 c 0.594 0.392 1.264 0.579 1.926 0.579 c 1.136 0 2.251 -0.553 2.924 -1.571 l 7.176 -10.87 c 0.001 -0.001 0.001 -0.002 0.002 -0.003 l 0.018 -0.027 c 0.063 -0.096 0.106 -0.199 0.159 -0.299 c 0.049 -0.093 0.108 -0.181 0.149 -0.279 c 0.087 -0.207 0.152 -0.419 0.197 -0.634 c 0.009 -0.041 0.008 -0.085 0.015 -0.126 c 0.031 -0.182 0.053 -0.364 0.055 -0.547 c 0 -0.014 0.004 -0.028 0.004 -0.042 c 0 -0.066 -0.016 -0.128 -0.019 -0.193 c -0.008 -0.145 -0.018 -0.288 -0.043 -0.431 c -0.018 -0.097 -0.045 -0.189 -0.071 -0.283 c -0.032 -0.118 -0.065 -0.236 -0.109 -0.35 c -0.037 -0.095 -0.081 -0.185 -0.125 -0.276 c -0.052 -0.107 -0.107 -0.211 -0.17 -0.313 c -0.054 -0.087 -0.114 -0.168 -0.175 -0.25 c -0.07 -0.093 -0.143 -0.183 -0.223 -0.27 c -0.074 -0.08 -0.153 -0.155 -0.234 -0.228 c -0.047 -0.042 -0.085 -0.092 -0.135 -0.132 L 36.679 0.775 c -1.503 -1.213 -3.708 -0.977 -4.921 0.53 c -1.213 1.505 -0.976 3.709 0.53 4.921 l 3.972 3.2 C 17.97 13.438 4.236 29.759 4.236 49.236 C 4.236 71.714 22.522 90 45 90 s 40.764 -18.286 40.764 -40.764 C 85.764 42.87 84.337 36.772 81.521 31.109 z"
                                              style="fill: rgb(0,0,0);"></path>
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
                    <select wire:model.live="selectedBarangay_id" class="bg-gray-50 border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                        <option value="">Barangay</option>
                        @foreach($barangaysFilter as $barangayFilter)
                            <option value="{{ $barangayFilter->id }}">{{ $barangayFilter->name }}</option>
                        @endforeach
                    </select>
                    <select wire:model.live="selectedPurok_id" class="bg-gray-50 border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                        <option value="">Purok</option>
                        @foreach($puroksFilter as $purokFilter)
                            <option value="{{ $purokFilter->id }}">{{ $purokFilter->name }}</option>
                        @endforeach
                    </select>
                    <select wire:model.live="selectedTaggingStatus" class="bg-gray-50 border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                        <option value="">Status</option>
                        @foreach($taggingStatuses as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                    <button wire:click="resetFilters" class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-4 py-1.5 rounded-full">Reset Filters</button>
                </div>
            </div>

            <!-- Applicants table -->
            <div x-data="{openEditModal: false}"
                 class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
{{--                            <th class="py-2 px-2 border-b text-center font-semibold">--}}
{{--                                <input type="checkbox">--}}
{{--                            </th>--}}
                            <th class="py-2 px-2 border-b text-center font-medium">ID</th>
                            <th class="py-2 px-2 border-b text-center font-medium toggle-column name-col">NAME</th>
                            <th class="py-2 px-2 border-b text-center font-medium toggle-column suffix-col">SUFFIX NAME</th>
                            <th class="py-2 px-2 border-b text-center font-medium toggle-column contact-col">CONTACT NUMBER</th>
                            <th class="py-2 px-2 border-b text-center font-medium toggle-column purok-col">PUROK</th>
                            <th class="py-2 px-2 border-b text-center font-medium toggle-column barangay-col">BARANGAY</th>
                            <th class="py-2 px-2 border-b text-center font-medium toggle-column date-applied-col">DATE APPLIED</th>
                            <th class="py-2 px-2 border-b text-center font-medium toggle-column actions-col">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Display the latest applicant first only if it's on the first page -->
                        @if($latestApplicant && $otherApplicants->currentPage() == 1)
                            <tr>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap">{{ $latestApplicant->applicant_id }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap name-col">{{ $latestApplicant->last_name }}, {{ $latestApplicant->first_name }} {{ $latestApplicant->middle_name }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap suffix-col">{{ $latestApplicant->suffix_name }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap contact-col">{{ $latestApplicant->contact_number }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap purok-col">{{ $latestApplicant->address->purok->name ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap barangay-col">{{ $latestApplicant->address->barangay->name ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b whitespace-nowrap date-applied-col">{{ \Carbon\Carbon::parse($latestApplicant->date_applied)->format('m/d/Y') }}</td>
                                <td class="py-4 px-2 text-center border-b whitespace-nowrap space-x-2 actions-col">
                                    <button wire:click="edit({{ $latestApplicant->id }})" @click="openEditModal = true" class="text-custom-red text-bold underline px-4 py-1.5">Edit</button>
                                    @if ($latestApplicant->taggedAndValidated)
                                        <button class="bg-gray-400 text-white px-5 py-1.5 rounded-full cursor-not-allowed">
                                            Tagged
                                        </button>
                                    @else
                                        <button onclick="window.location.href='{{ route('applicant-details', ['applicantId' => $latestApplicant->id]) }}'"
                                                class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-8 py-1.5 rounded-full">
                                            Tag
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @forelse($otherApplicants as $applicant)
                            <tr>
{{--                                <td class="py-4 px-2 text-center border-b uppercase font-semibold">--}}
{{--                                    <input type="checkbox" wire:model="selectedApplicantsForExport.{{ $applicant->applicant_id }}">--}}
{{--                                </td>--}}
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap">{{ $applicant->applicant_id }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap name-col">{{ $applicant->last_name }}, {{ $applicant->first_name }} {{ $applicant->middle_name }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap suffix-col">{{ $applicant->suffix_name }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap contact-col">{{ $applicant->contact_number }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap purok-col">{{ $applicant->address->purok->name ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap barangay-col">{{ $applicant->address->barangay->name ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b whitespace-nowrap date-applied-col">{{ \Carbon\Carbon::parse($applicant->date_applied)->format('m/d/Y') }}</td>
                                <td class="py-4 px-2 text-center border-b whitespace-nowrap space-x-2 actions-col">
                                    <button wire:click="edit({{ $applicant->id }})" @click="openEditModal = true" class="text-custom-red text-bold underline px-4 py-1.5">Edit</button>
                                    @if ($applicant->taggedAndValidated)
                                        <button class="bg-gray-400 text-white px-5 py-1.5 rounded-full cursor-not-allowed">
                                            Tagged
                                        </button>
                                    @else
                                        <button onclick="window.location.href='{{ route('applicant-details', ['applicantId' => $applicant->id]) }}'"
                                                class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-8 py-1.5 rounded-full">
                                            Tag
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-4 px-2 text-center border-b">
                                    @if (!$latestApplicant)
                                        No applicants found.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="py-4 px-3">
                {{-- {{ $applicants->links() }}--}}
                    {{ $otherApplicants->links() }}
                </div>

                <!-- ADD APPLICANT MODAL -->
                <div x-show="isModalOpen" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                    <div class="bg-white text-white w-[450px] rounded-lg shadow-lg p-6 relative z-50">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-black">ADD APPLICANT</h3>
                            <!-- Close Button: Closes the Modal -->
                            <button @click="isModalOpen = false" class="text-gray-400 hover:text-gray-200 text-3xl">
                                &times;
                            </button>
                        </div>

                        <!-- Livewire Form -->
                        <form wire:submit.prevent="store">
                            <x-validation-errors class="mb-4" />
                            <!-- Date Applied Field -->
                            <div class="grid grid-cols-1 mb-4">
                                <div>
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="date_applied">APPLICATION DATE <span class="text-red-500">*</span></label>
                                    <input type="date" id="date_applied" wire:model="date_applied" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none"
                                           max="{{ now()->toDateString() }}">
                                    @error('date_applied') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <!-- Main Fields -->
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <!-- First Name Field -->
                                <div>
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="first_name">FIRST NAME <span class="text-red-500">*</span> </label>
                                    <input type="text" wire:model="first_name" id="first_name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" required>
                                    @error('first_name') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <!-- Middle Name Field -->
                                <div>
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="middle_name">MIDDLE NAME <span class="text-red-500">*</span> </label>
                                    <input type="text" wire:model="middle_name" id="middle_name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase">
                                    @error('middle_name') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <!-- Last Name Field -->
                                <div>
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="last_name">LAST NAME <span class="text-red-500">*</span> </label>
                                    <input type="text" wire:model="last_name" id="last_name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" required>
                                    @error('last_name') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <!-- Suffix Name Field -->
                                <div>
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="suffix_name">SUFFIX NAME</label>
                                    <input type="text" wire:model="suffix_name" id="suffix_name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase">
                                    @error('suffix_name') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Barangay Field -->
                            <div class="mb-3">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="barangay">BARANGAY <span class="text-red-500">*</span> </label>
                                <select id="barangay" wire:model.live="barangay_id" class="w-full px-3 py-1 text-[12px] select2-barangay bg-white-700 border border-gray-600 rounded-lg text-gray-800 uppercase" required>
                                    <option value="">Select Barangay</option>
                                    @foreach($barangays as $barangay)
                                        <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                    @endforeach
                                </select>
                                @error('barangay_id') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Purok Field -->
                            <div class="mb-3">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="purok">PUROK <span class="text-red-500">*</span> </label>
                                <select id="purok" wire:model.live="purok_id" class="w-full px-3 py-1 text-[12px] select2-purok bg-white-700 border border-gray-600 rounded-lg focus:outline-none text-gray-800 uppercase" required>
                                    <option value="">Select Purok</option>
                                    @foreach($puroks as $purok)
                                        <option value="{{ $purok->id }}">{{ $purok->name }}</option>
                                    @endforeach
                                </select>
                                @error('purok_id') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Contact Number Field -->
                            <div class="mb-3">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="contact_number">CONTACT NUMBER</label>
                                <input type="text" wire:model="contact_number" id="contact_number" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" placeholder="Contact Number">
                                @error('contact_number') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Interviewer Field -->
                            <div class="mb-6">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="interviewer">INITIALLY INTERVIEWED BY <small class="text-red-500">(read only)</small></label>
                                <input type="text" id="interviewer" wire:model="interviewer" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-red-600 focus:outline-none text-[12px] uppercase cursor-default" readonly>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <!-- Submit button and alert message -->
                                <div>
                                    <div class="alert"
                                         :class="{primary:'alter-primary', success:'alert-success', danger:'alert-danger', warning:'alter-warning'}[(alert.type ?? 'primary')]"
                                         x-data="{ open:false, alert:{} }"
                                         x-show="open" x-cloak
                                         x-transition:enter="animate-alert-show"
                                         x-transition:leave="animate-alert-hide"
                                         @alert.window="open = true; setTimeout( () => open=false, 3000 ); alert=$event.detail[0]"
                                    >
                                        <div class="alert-wrapper">
                                            <strong x-html="alert.title">Title</strong>
                                            <p x-html="alert.message">Description</p>
                                        </div>
                                        <i class="alert-close fa-solid fa-xmark" @click="open=false"></i>
                                    </div>
                                    <!-- Add Applicant Button -->
                                    <button type="submit" wire:click.prevent="store"
                                            class="w-full py-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                        <span class="text-[12px]"> + ADD APPLICANT</span>
                                        <div wire:loading>
                                            <svg aria-hidden="true"
                                                 class="w-5 h-5 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
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
                                <script>
                                    document.addEventListener('livewire.initialized', () => {
                                        let obj = @json(session('alert') ?? []);
                                        if (Object.keys(obj).length){
                                            Livewire.dispatch('alert', [obj])
                                        }
                                    })
                                </script>
                                <!-- Cancel Button -->
                                <button type="button" @click="isModalOpen = false"
                                        class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                    <span class="text-[12px]">CANCEL</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- EDIT APPLICANT MODAL -->
                <div x-show="openEditModal" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                    <div class="bg-white text-white w-[450px] rounded-lg shadow-lg p-6 relative z-50">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-black">EDIT APPLICANT</h3>
                            <!-- Close Button: Closes the Modal -->
                            <button @click="openEditModal = false" class="text-gray-400 hover:text-gray-200 text-3xl">
                                &times;
                            </button>
                        </div>

                        <form wire:submit.prevent="update">
                            <!-- Main Fields -->
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <!-- First Name Field -->
                                <div>
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="first_name">FIRST NAME </label>
                                    <input type="text" wire:model="edit_first_name" id="first_name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" required>
                                </div>

                                <!-- Middle Name Field -->
                                <div>
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="middle_name">MIDDLE NAME </label>
                                    <input type="text" wire:model="edit_middle_name" id="middle_name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase">
                                </div>

                                <!-- Last Name Field -->
                                <div>
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="last_name">LAST NAME </label>
                                    <input type="text" wire:model="edit_last_name" id="last_name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" required>
                                </div>

                                <!-- Suffix Name Field -->
                                <div>
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="suffix_name">SUFFIX NAME</label>
                                    <input type="text" wire:model="edit_suffix_name" id="suffix_name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase">
                                </div>
                            </div>

                            <!-- Barangay Field -->
                            <div class="mb-3">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="barangay">BARANGAY </label>
                                <select id="barangay" wire:model.live="edit_barangay_id" class="w-full px-3 py-1 text-[12px] select2-barangay bg-white-700 border border-gray-600 rounded-lg text-gray-800 uppercase" required>
                                    <option value="">Select Barangay</option>
                                    @foreach($barangays as $barangay)
                                        <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Purok Field -->
                            <div class="mb-3">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="purok">PUROK </label>
                                <select id="purok" wire:model.live="edit_purok_id" class="w-full px-3 py-1 text-[12px] select2-purok bg-white-700 border border-gray-600 rounded-lg focus:outline-none text-gray-800 uppercase" required>
                                    <option value="">Select Purok</option>
                                    @foreach($puroks as $purok)
                                        <option value="{{ $purok->id }}">{{ $purok->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Contact Number Field -->
                            <div class="mb-6">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="contact_number">CONTACT NUMBER</label>
                                <input type="text" wire:model="edit_contact_number" id="contact_number" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" placeholder="Contact Number">
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <!-- Submit button and alert message -->
                                <div>
                                    <div class="alert"
                                         :class="{primary:'alter-primary', success:'alert-success', danger:'alert-danger', warning:'alter-warning'}[(alert.type ?? 'primary')]"
                                         x-data="{ open:false, alert:{} }"
                                         x-show="open" x-cloak
                                         x-transition:enter="animate-alert-show"
                                         x-transition:leave="animate-alert-hide"
                                         @alert.window="open = true; setTimeout( () => open=false, 3000 ); alert=$event.detail[0]"
                                    >
                                        <div class="alert-wrapper">
                                            <strong x-html="alert.title">Title</strong>
                                            <p x-html="alert.message">Description</p>
                                        </div>
                                        <i class="alert-close fa-solid fa-xmark" @click="open=false"></i>
                                    </div>
                                    <!-- SAVE Button -->
                                    <button type="submit" wire:click.prevent="update"
                                            class="w-full py-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                        <span class="text-[12px]"> SAVE </span>
                                        <div wire:loading>
                                            <svg aria-hidden="true"
                                                 class="w-5 h-5 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
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
                                <script>
                                    document.addEventListener('livewire.initialized', () => {
                                        let obj = @json(session('alert') ?? []);
                                        if (Object.keys(obj).length){
                                            Livewire.dispatch('alert', [obj])
                                        }
                                    })
                                </script>
                                <!-- Cancel Button -->
                                <button type="button" @click="openEditModal = false"
                                        class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                    <span class="text-[12px]">CANCEL</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function capitalizeInput(input) {
        input.value = input.value.toLowerCase().replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }
</script>