<div x-data="{ openFilters: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <!-- Main Content -->
        <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">
            <!-- Container for the Title -->
            <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-0 relative p-3">
                <div class="flex items-center">
                    <h2 class="text-[13px] ml-5 text-gray-700">TAGGED AND VALIDATED</h2>
                </div>
                <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                <div x-data class="relative z-0">
                    <button
                            @click="window.location.href = '{{ route('add-new-request') }}'"
                            class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white px-4 py-2 rounded">
                        Add Occupant
                    </button>
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
                        <div class="relative hidden md:block border-gray-300">
                            <svg class="absolute top-[8px] left-4" width="19" height="19" viewBox="0 0 21 21"
                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.625 16.625C13.491 16.625 16.625 13.491 16.625 9.625C16.625 5.75901 13.491 2.625 9.625 2.625C5.75901 2.625 2.625 5.75901 2.625 9.625C2.625 13.491 5.75901 16.625 9.625 16.625Z"
                                      stroke="#787C7F" stroke-width="1.75" stroke-linecap="round"
                                      stroke-linejoin="round" />
                                <path d="M18.3746 18.375L14.5684 14.5688" stroke="#787C7F" stroke-width="1.75"
                                      stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <input wire:model.live.debounce.300ms="search" type="search" name="search" id="search"
                                   class="rounded-md px-12 py-2 placeholder:text-[13px] z-10 border border-gray-300 bg-[#f7f7f9] hover:ring-custom-yellow focus:ring-custom-yellow"
                                   placeholder="Search">
                            <!-- Clear Button -->
                            <button wire:click="clearSearch" class="absolute top-1 right-4 text-2xl text-gray-500">
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
                                    <input type="checkbox" class="toggle-column" id="toggle-name" checked> Name
                                </label>
                                <label class="block px-4 py-2">
                                    <input type="checkbox" class="toggle-column" id="toggle-purok" checked> Purok
                                </label>
                                <label class="block px-4 py-2">
                                    <input type="checkbox" class="toggle-column" id="toggle-barangay" checked> Barangay
                                </label>
                                <label class="block px-4 py-2">
                                    <input type="checkbox" class="toggle-column" id="toggle-living-situation" checked> Case
                                </label>
                                <label class="block px-4 py-2">
                                    <input type="checkbox" class="toggle-column" id="toggle-case-specification" checked> Case Specification
                                </label>
                                <label class="block px-4 py-2">
                                    <input type="checkbox" class="toggle-column" id="toggle-case-specification-description" checked> Case Specification Description
                                </label>
                                <label class="block px-4 py-2">
                                    <input type="checkbox" class="toggle-column" id="toggle-contact" checked> Contact Number
                                </label>
                                <label class="block px-4 py-2">
                                    <input type="checkbox" class="toggle-column" id="toggle-monthly" checked> Monthly Income
                                </label>
                                <label class="block px-4 py-2">
                                    <input type="checkbox" class="toggle-column" id="toggle-transaction-type" checked> Transaction Type
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
                        <label class="text-center mt-2 mr-1" for="start_date">Tagging Date From:</label>
                        <input type="date" id="start_date" wire:model.live="startTaggingDate" class="border text-[13px] border-gray-300 rounded px-2 py-1"
                               max="{{ now()->toDateString() }}">
                        <label class="text-center mt-2 ml-2 mr-1" for="end_date">To:</label>
                        <input type="date" id="end_date" wire:model.live="endTaggingDate" class="border text-[13px] border-gray-300 rounded px-2 py-1 mr-1"
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
                    <select wire:model.live="selectedLivingSituation_id" class="bg-gray-50 border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                        <option value="">CASE</option>
                        @foreach($livingSituationsFilter as $livingSituationFilter)
                            <option value="{{ $livingSituationFilter->id }}">{{ $livingSituationFilter->living_situation_description }}</option>
                        @endforeach
                    </select>
                    <select class="border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                        <option value="">Occupation</option>
                        <option value="barangay1">Barangay 1</option>
                        <option value="barangay2">Barangay 2</option>
                        <option value="barangay3">Barangay 3</option>
                    </select>
                    <select class="border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                        <option value="">Status</option>
                        <option value="barangay1">Barangay 1</option>
                        <option value="barangay2">Barangay 2</option>
                        <option value="barangay3">Barangay 3</option>
                    </select>
                    <button wire:click="resetFilters" class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-4 py-1.5 rounded-full">Reset Filters</button>
{{--                    <button class="bg-custom-yellow text-white px-4 py-2 rounded">Apply Filters</button>--}}
                </div>
            </div>

            <!-- Table with transaction requests -->
            <div x-data="{openModalRelocate: false, openModalDocumentsChecklist: false, openModalTag: false, openPreviewModal: false, selectedFile: null, fileName: ''}"
                 class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-2 border-b text-center font-medium">ID</th>
                            <th class="py-2 px-2 border-b text-center font-medium toggle-column name-col">NAME</th>
                            <th class="py-2 px-2 border-b text-center font-medium toggle-column purok-col">PUROK</th>
                            <th class="py-2 px-2 border-b text-center font-medium toggle-column barangay-col">BARANGAY</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap toggle-column living-situation-col">LIVING SITUATION (CASE)</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap toggle-column case-specification-col">CASE SPECIFICATION</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap toggle-column case-specification-description-col">CASE SPECIFICATION DESCRIPTION</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap toggle-column contact-col">CONTACT NUMBER</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap toggle-column monthly-col">MONTHLY INCOME</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap toggle-column transaction-type-col">TRANSACTION TYPE</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap toggle-column transaction-type-col">TAGGING DATE</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap toggle-column actions-col">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($taggedAndValidatedApplicants as $applicant)
                            <tr>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap">{{ $applicant->applicant->applicant_id}}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap name-col">{{ $applicant->applicant->last_name }}, {{ $applicant->applicant->first_name }} {{ $applicant->applicant->middle_name }} {{ $applicant->applicant->suffix_name }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap purok-col">{{ $applicant->applicant->address->purok->name ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap barangay-col">{{ $applicant->applicant->address->barangay->name ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap living-situation-col">{{ $applicant->livingSituation->living_situation_description ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap case-specification-col">{{ $applicant->caseSpecification->case_specification_name ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap case-specification-description-col">{{ $applicant->living_situation_case_specification ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap contact-col">{{ $applicant->applicant->contact_number ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap monthly-col">{{ $applicant->monthly_income ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap transaction-type-col">{{ $applicant->applicant->transactionType->type_name ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap transaction-type-col">{{ \Carbon\Carbon::parse($applicant->tagging_date)->format('m/d/Y') }}</td>
                                <td class="py-4 px-2 text-center border-b space-x-2 whitespace-nowrap actions-col">
{{--                                    <button--}}
{{--                                            @click="window.location.href = '{{ route('request-applicant-details', ['applicantId' => $applicant->id]) }}'"--}}
{{--                                            class="text-custom-red text-bold underline px-4 py-1.5">--}}
{{--                                        Details--}}
{{--                                    </button>--}}
                                    @if(!$applicant->is_awarding_on_going)
                                        <!-- Award Button -->
                                        <button @click="openModalRelocate = true; $wire.set('taggedAndValidatedApplicantId', {{ $applicant->id }})"
                                                class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-14 py-1.5 rounded-full">
                                            Award
                                        </button>
                                    @elseif($applicant->awardees->isNotEmpty() && $applicant->awardees->first()->is_awarded)
                                        <!-- Awarded Button -->
                                        <button class="bg-gray-400 text-white px-12 py-1.5 rounded-full cursor-not-allowed">
                                            Awarded
                                        </button>
                                    @else
                                        <!-- Award Pending Button (disabled) -->
                                        <div class="relative flex items-center space-x-2">
                                            <!-- Award Pending Button -->
                                            <button disabled
                                                    class="bg-amber-500 text-white px-4 py-1.5 rounded-full cursor-not-allowed">
                                                Award Pending
                                            </button>

                                            <!-- Info Icon with Hover Tooltip -->
                                            <div class="group relative z-50">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                                                        <path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/>
                                                    </svg>
                                                </span>

                                                <!-- Tooltip content -->
                                                <div class="absolute right-6 top-0 mb-2 w-max bg-custom-dark-green text-white text-xs rounded-lg py-2 px-3 opacity-0 group-hover:opacity-100 group-hover:visible group-hover:transition-opacity duration-200 z-50">
                                                    Award is pending for this applicant. <br> Requirements are needed to be uploaded.
                                                    <br>
                                                    <small>Documents are ready.
                                                        @if($applicant->is_awarding_on_going && $applicant->awardees->isNotEmpty())
                                                            <button type="button" class="underline"
                                                                    @click="
                                                                openModalDocumentsChecklist = true;
                                                                $wire.set('awardeeId', {{ $applicant->awardees->first()->id }});
                                                            ">
                                                                Upload now.
                                                            </button>
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 px-2 text-center border-b">No applicants found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Modal Relocate -->
                <div x-show="openModalRelocate"
                     class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak
                     style="font-family: 'Poppins', sans-serif;">
                    <!-- Modal -->
                    <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-md font-semibold text-black">RELOCATE AFFECTED APPLICANT</h3>
                            <button @click="openModalRelocate = false" class="text-gray-400 hover:text-gray-200">
                                &times;
                            </button>
                        </div>

                        <!-- Form -->
                        <form wire:submit.prevent="awardApplicant">
                            <!-- Grant Date Field -->
                            <div class="mb-3">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="grant_date">GRANT DATE <span class="text-red-500">*</span></label>
                                <input wire:model="grant_date" type="date" id="grant_date" required
                                       class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none text-[12px]"
                                       max="{{ now()->toDateString() }}">
                                @error('grant_date') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Main Fields -->
                            <!-- Barangay Field -->
                            <div class="mb-4">
                                <br>
                                <label class="block text-sm font-medium mb-2 text-black" for="barangay">LOT
                                    ALLOCATED</label>
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                       for="barangay">BARANGAY <span class="text-red-500">*</span></label>
                                <select wire:model.live="barangay_id" id="barangay" name="barangay" :disabled="!isEditable" required
                                        class="uppercase w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none text-[12px]">
                                    <option value="">Select Barangay</option>
                                    @foreach($barangays as $barangay)
                                        <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                    @endforeach
                                </select>
                                @error('barangay_id') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Purok Field -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                       for="purok">PUROK <span class="text-red-500">*</span></label>
                                <select wire:model.live="purok_id" id="purok" name="purok" :disabled="!isEditable" required
                                        class="uppercase w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none text-[12px]">
                                    <option value="">Select Purok </option>
                                    @foreach($puroks as $purok)
                                        <option value="{{ $purok->id }}">{{ $purok->name }}</option>
                                    @endforeach
                                </select>
                                @error('purok_id') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                       for="lot_name">LOT NAME/NUMBER <span class="text-red-500">*</span></label>
                                <select wire:model.live="lot_id" id="lot_name" name="lot_name" :disabled="!isEditable" required
                                        class="uppercase w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none text-[12px]">
                                    <option value="">Select Lot </option>
                                    @foreach($lots as $lot)
                                        <option value="{{ $lot->id }}">{{ $lot->lot_name }}</option>
                                    @endforeach
                                </select>
                                @error('lot_id') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!-- LotList Size Allocated Field -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="lot_size_allocated">
                                    LOT SIZE ALLOCATED <span class="text-red-500">*</span></label>
                                <input wire:model="lot_size" type="number" id="lot_size_allocated"
                                       class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none text-[12px]"
                                       placeholder="1000.50"
                                       oninput="validateNumberInput(this)">
                                @error('lot_size') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Lot Size Unit -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                       for="lot_size_unit">LOT SIZE UNIT <span class="text-red-500">*</span></label>
                                <select wire:model.live="lot_size_unit_id" id="lot_size_unit" name="lot_size_unit" :disabled="!isEditable" required
                                        class="uppercase w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none text-[12px]">
                                    <option value="">Lot Size Unit </option>
                                    @foreach($lotSizeUnits as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->lot_size_unit_name }}</option>
                                    @endforeach
                                </select>
                                @error('lot_size_unit_id') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <br>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <div class="alert"
                                         :class="{primary:'alert-primary', success:'alert-success', danger:'alert-danger', warning:'alert-warning'}[(alert.type ?? 'primary')]"
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
                                    <!-- Relocate Button -->
                                    <button type="submit"
                                            class="w-full py-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                        <span class="text-[12px]">RELOCATE</span>
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
                                <button type="button" @click="openModalRelocate = false"
                                        class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2 cursor-pointer">
                                    <span class="text-[12px]">CANCEL</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Relocate - Checklist for uploading documents -->
                <div x-show="openModalDocumentsChecklist"
                     class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak
                     style="font-family: 'Poppins', sans-serif;">
                    <!-- Modal -->
                    <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-md font-semibold text-black">DOCUMENTS/REQUIREMENTS CHECKLIST</h3>
                            <button @click="openModalDocumentsChecklist = false" class="text-gray-400 hover:text-gray-200">
                                &times;
                            </button>
                        </div>

                        <div class="max-w-md mx-auto rounded-lg p-4 text-gray-900">
                            <form wire:submit.prevent="submit">
                                <!-- Attachment Type -->
                                <div class="mb-6">
                                    <label class="block text-[12px] font-medium mb-2 text-black"
                                           for="attachment">ATTACHMENT TYPE <span class="text-red-500">*</span></label>
                                    <select wire:model="attachment_id" id="attachment_id" name="attachment_id" :disabled="!isEditable" required
                                            class="uppercase w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none text-[12px]">
                                        <option value="">Attachment Type</option>
                                        @foreach($attachmentLists as $attachmentList)
                                            <option value="{{ $attachmentList->id }}">{{ $attachmentList->attachment_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('attachment_id')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
                                </div>

                                <!-- Description -->
                                <div class="mb-6">
                                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description:</label>
                                    <textarea id="description" rows="4" name="description" wire:model="description"
                                              class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg"
                                              placeholder="Please leave a comment..."></textarea>
                                    @error('description')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
                                </div>
                                <!-- File upload -->
                                <div wire:ignore x-data="{ isUploading: false }" x-init="
                                        FilePond.registerPlugin(FilePondPluginImagePreview);
                                        const pond = FilePond.create($refs.input, {
                                            allowFileEncode: true,
                                            onprocessfilestart: () => { isUploading = true; },
                                            onprocessfile: (error, file) => { isUploading = false; },
                                            server: {
                                                process: (fileName, file, metadata, load, error, progress, abort, transfer, options) => {
                                                    @this.upload('letterOfIntent', file, load, error, progress);
                                                },
                                                revert: (fileName, load) => {
                                                    @this.removeUpload('letterOfIntent', fileName, load);
                                                },
                                            },
                                        });
                                    ">
                                    <input x-ref="input" type="file" accept="image/*,application/pdf" wire:model="letterOfIntent" required>
                                    @error('letterOfIntent')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
                                </div>
                                <div>
                                    <div class="alert"
                                         :class="{primary:'alert-primary', success:'alert-success', danger:'alert-danger', warning:'alert-warning'}[(alert.type ?? 'primary')]"
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
                                    <!-- SUBMIT REQUIREMENTS Button -->
                                    <button type="submit"
                                            class="w-full py-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                        <span class="text-[12px]">SUBMIT</span>
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
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tagging/Validation Modal -->
                <div x-show="openModalTag"
                     class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 shadow-lg"
                     x-cloak style="font-family: 'Poppins', sans-serif;">
                    <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-black">TAGGED/VALIDATED</h3>
                            <button @click="openModalTag = false" class="text-gray-400 hover:text-gray-200">
                                &times;
                            </button>
                        </div>

                        <!-- Form -->
                        <form @submit.prevent>
                            <!-- Tagging and Validation Date Field -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                       for="tagging-validation-date">TAGGING AND VALIDATION DATE</label>
                                <input type="date" id="tagging-validation-date"
                                       class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px]">
                            </div>

                            <!-- Validator's Name Field -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="validator-name">VALIDATOR'S
                                    NAME</label>
                                <input type="text" id="validator-name"
                                       class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px]"
                                       placeholder="Validator's Name">
                            </div>

                            <!-- House Situation Upload -->
                            <h2 class="block text-[12px] font-medium mb-2 text-black">UPLOAD HOUSE SITUATION</h2>

                            <!-- Drag and Drop Area -->
                            <div class="border-2 border-dashed border-green-500 rounded-lg p-4 flex flex-col items-center space-y-1">
                                <svg class="w-10 h-10 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 15a4 4 0 011-7.874V7a5 5 0 018.874-2.485A5.5 5.5 0 1118.5 15H5z" />
                                </svg>
                                <p class="text-gray-500 text-xs">DRAG AND DROP FILES</p>
                                <p class="text-gray-500 text-xs">or</p>
                                <button type="button"
                                        class="px-3 py-1 bg-green-600 text-white rounded-md text-xs hover:bg-green-700"
                                        @click="$refs.fileInput.click()">BROWSE FILES
                                </button>

                                <!-- Hidden File Input -->
                                <input type="file" x-ref="fileInput"
                                       @change="selectedFile = $refs.fileInput.files[0]; fileName = selectedFile.name"
                                       class="hidden" />
                            </div>

                            <!-- Show selected file and progress bar when a file is selected -->
                            <template x-if="selectedFile">
                                <div @click="openPreviewModal = true" class="mt-4 bg-white p-2 rounded-lg shadow">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-orange-500" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2" d="M7 3v6h4l1 1h4V3H7z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2" d="M5 8v10h14V8H5z" />
                                            </svg>
                                            <span class="text-xs font-medium text-gray-700"
                                                  x-text="fileName"></span>

                                        </div>
                                        <!-- Status -->
                                        <span class="text-xs text-green-500 font-medium">100%</span>
                                    </div>
                                    <!-- Progress Bar -->
                                    <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden cursor-pointer">
                                        <div class="w-full h-full bg-green-500"></div>
                                    </div>
                                </div>
                            </template>

                            <!-- Buttons -->
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <button type="submit"
                                        class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg">
                                    TAGGED & VALIDATED
                                </button>
                                <button type="button" @click="openModalTag = false"
                                        class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg">
                                    CANCEL
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Preview Modal (Triggered by Clicking the Progress Bar) -->
                <div x-show="openPreviewModal"
                     class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 shadow-lg"
                     x-cloak>
                    <div class="bg-white w-[600px] rounded-lg shadow-lg p-6 relative">
                        <!-- Modal Header with File Name -->
                        <div class="flex justify-between items-center mb-4">
                            <input type="text" x-model="fileName"
                                   class="text-[13px] w-[60%] font-regular text-black border-none focus:outline-none focus:ring-0">
                            <button class="text-orange-500 underline text-sm"
                                    @click="fileName = prompt('Rename File', fileName) || fileName">Rename File
                            </button>
                            <button @click="openPreviewModal = false" class="text-gray-400 hover:text-gray-200">
                                &times;
                            </button>
                        </div>

                        <!-- Display Image -->
                        <div class="flex justify-center mb-4">
                            <img :src="selectedFile ? URL.createObjectURL(selectedFile) : '/path/to/default/image.jpg'"
                                 alt="Preview Image" class="w-full h-auto max-h-[60vh] object-contain">
                        </div>
                        <!-- Modal Buttons -->
                        <div class="flex justify-between mt-4">
                            <button class="px-4 py-2 bg-green-600 text-white rounded-lg"
                                    @click="openPreviewModal = false">CONFIRM
                            </button>
                            <button class="px-4 py-2 bg-red-600 text-white rounded-lg"
                                    @click="selectedFile = null; openPreviewModal = false">REMOVE
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination controls -->
            <div class="flex justify-end text-[12px] mt-4">
                <button
                        @click="prevPage"
                        :disabled="currentPage === 1"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-l disabled:opacity-50">
                    Prev
                </button>
                <template x-for="page in totalPages" :key="page">
                    <button
                            @click="goToPage(page)"
                            :class="{'bg-custom-green text-white': page === currentPage, 'bg-gray-200': page !== currentPage}"
                            class="px-4 py-2 mx-1 rounded">
                        <span x-text="page"></span>
                    </button>
                </template>
                <button
                        @click="nextPage"
                        :disabled="currentPage === totalPages"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-r disabled:opacity-50">
                    Next
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function pagination() {
        return {
            currentPage: 1,
            totalPages: 3, // Set this to the total number of pages you have

            prevPage() {
                if (this.currentPage > 1) this.currentPage--;
            },
            nextPage() {
                if (this.currentPage < this.totalPages) this.currentPage++;
            },
            goToPage(page) {
                this.currentPage = page;
            }
        }
    }
</script>
<script>
    // Function to allow only numeric input
    function validateNumberInput(input) {
        // Remove any characters that are not digits
        input.value = input.value.replace(/[^0-9]/g, '');
    }
</script>