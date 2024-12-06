<div x-data="{ openFilters: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <!-- Main Content -->
        <div class="flex-1 h-screen p-6 overflow-auto">
            <div class="bg-white rounded shadow mb-2 flex items-center justify-between relative p-3">
                <div class="flex items-center">
                    <h2 class="text-[13px] ml-2 items-center text-gray-700">Summary of Identified Informal Settlers</h2>
                </div>
                <img src="{{ asset('storage/images/design.png') }}" alt="Design"
                     class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                <div class="relative z-0">
                    <button wire:click="export" wire:ignore wire:loading.attr="disabled"
                            class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white px-4 py-2 rounded">
                        <span wire:loading wire:target="export">Exporting Excel...</span>
                        <span wire:loading.remove>Export to Excel</span>
                    </button>
                </div>
            </div>
            <!-- Summary Stats -->
            <div class="flex items-center mb-2 ml-2">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-sm font-semibold">Total Occupants :
                            <span class="text-lg font-bold text-red-600">{{ number_format($totals->total_occupants) }}</span>
                        </h3>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold">Total Awardees:
                            <span class="text-lg font-bold text-red-600">{{ number_format($totals->total_awarded) }}</span>
                        </h3>
                    </div>
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
                            <svg class="absolute top-[13px] left-4" width="19" height="19" viewBox="0 0 21 21"
                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.625 16.625C13.491 16.625 16.625 13.491 16.625 9.625C16.625 5.75901 13.491 2.625 9.625 2.625C5.75901 2.625 2.625 5.75901 2.625 9.625C2.625 13.491 5.75901 16.625 9.625 16.625Z"
                                      stroke="#787C7F" stroke-width="1.75" stroke-linecap="round"
                                      stroke-linejoin="round" />
                                <path d="M18.3746 18.375L14.5684 14.5688" stroke="#787C7F" stroke-width="1.75"
                                      stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <input wire:model.live="search"
                                   type="search"
                                   class="rounded-md px-12 py-2 placeholder:text-[13px] z-10 border border-gray-300 bg-[#f7f7f9] hover:ring-custom-yellow focus:ring-custom-yellow"
                                   placeholder="Search">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <label class="text-center mt-2 mr-1" for="start_date">
                            Date Applied From:
                        </label>
                        <input type="date"
                               wire:model.live="startDate"
                               class="border text-[13px] border-gray-300 rounded px-2 py-1"
                               max="{{ now()->toDateString() }}"
                               value="{{ now()->toDateString() }}">

                        <label class="text-center mt-2 ml-2 mr-1" for="end_date">
                            To:
                        </label>
                        <input type="date"
                               wire:model.live="endDate"
                               class="border text-[13px] border-gray-300 rounded px-2 py-1 mr-1"
                               max="{{ now()->toDateString() }}"
                               value="{{ now()->toDateString() }}">

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

                <div x-show="openFilters" class="grid grid-cols-3 gap-2 mb-1 mt-5">
                    <!-- Barangay Filter -->
                    <select wire:model.live="filterBarangay"
                            class="bg-gray-50 border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                        <option value="">All Barangays</option>
                        @foreach ($barangays as $barangay)
                            <option value="{{ $barangay }}">{{ $barangay }}</option>
                        @endforeach
                    </select>

                    <!-- Purok Filter -->
                    <select wire:model.live="filterPurok"
                            class="bg-gray-50 border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                        <option value="">All Puroks</option>
                        @foreach ($availablePuroks as $purok)
                            <option value="{{ $purok }}">{{ $purok }}</option>
                        @endforeach
                    </select>

                    <!-- Living Situation Filter -->
                    <select wire:model.live="filterLivingSituation"
                            class="bg-gray-50 border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                        <option value="">All Living Situations</option>
                        @foreach ($livingSituations as $livingSituation)
                            <option value="{{ $livingSituation }}">{{ $livingSituation }}</option>
                        @endforeach
                    </select>

                    <!-- Case Specification Filter -->
                    <select wire:model.live="filterCaseSpecification"
                            class="bg-gray-50 border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                        <option value="">All Case Specifications</option>
                        @foreach ($caseSpecifications as $caseSpecification)
                            <option value="{{ $caseSpecification }}">{{ $caseSpecification }}</option>
                        @endforeach
                    </select>

                    <!-- Assigned Relocation Site Filter -->
                    <select wire:model.live="filterAssignedRelocationSite"
                            class="bg-gray-50 border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                        <option value="">Select Assigned Relocation Site</option>
                        @foreach($relocationSites as $site)
                            <option value="{{ $site->relocation_site_name }}">{{ $site->relocation_site_name }}</option>
                        @endforeach
                    </select>

                    <!-- Actual Relocation Site Filter -->
                    <select wire:model.live="filterActualRelocationSite"
                            class="bg-gray-50 border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                        <option value="">Select Actual Relocation Site</option>
                        @foreach($actualRelocationSites as $site)
                            <option value="{{ $site->relocation_site_name }}">{{ $site->relocation_site_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Table for Summary of Identified Informal Settlers -->
            <div class="overflow-x-auto">
                <table id="dataTable" class="min-w-full bg-white border border-gray-200 mb-1">
                    <thead class="bg-gray-100">
                        <tr>
                            <th wire:click="sortBy('tagging_date')"
                                class="py-2 px-10  text-center font-medium">
                                <div class="flex items-center">
                                    DATE TAGGED
                                    @if($sortField === 'tagging_date')
                                        <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </div>
                            </th>
                            <th class="py-2 px-10 border-b text-center font-medium">BARANGAY</th>
                            <th class="py-2 px-10 border-b text-center font-medium">PUROK</th>
                            <th class="py-2 px-10 border-b text-center font-medium">CASE</th>
                            <th class="py-2 px-10 border-b text-center font-medium">CASE SPECIFICATION</th>
                            <th class="py-2 px-10 border-b text-center font-medium">NO. OF ACTUAL OCCUPANTS</th>
                            <th class="py-2 px-10 border-b text-center font-medium">ASSIGNED RELOCATION SITE</th>
                            <th class="py-2 px-10 border-b text-center font-medium">AWARDED</th>
                            <th class="py-2 px-10 border-b text-center font-medium">ACTUAL RELOCATION SITE</th>
                            <th class="py-2 px-10 border-b text-center font-medium">REMARKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($groupedApplicants as $group)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-2 text-center border-b capitalize">
                                    {{ \Carbon\Carbon::parse($group->tagging_date)->format('M d, Y') }}
                                </td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-normal break-words">
                                    {{ $group->barangay }}
                                </td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-normal break-words">
                                    {{ $group->purok }}
                                </td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-normal break-words">
                                    {{ $group->living_situation }}
                                </td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-normal break-words">
                                    {{ $group->case_specification ?? 'N/A' }}
                                </td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-normal break-words">
                                    {{ number_format($group->occupants_count) }}
                                </td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-normal break-words">
                                    {{ $group->assigned_relocation_site ?? 'N/A' }}
                                </td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-normal break-words">
                                    {{ number_format($group->awarded_count) }}
                                </td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-normal break-words">
                                    {{ $group->actual_relocation_sites ?? 'N/A' }}
                                </td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-normal break-words">
                                    Remarks
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="py-4 px-2 text-center border-b capitalize">
                                    No records found.
                                </td>
                            </tr>
                        @endforelse

                        <!-- Grand Totals Row -->
                        <tr class="bg-gray-100 font-semibold">
                            <td colspan="5" class="py-3 px-2 text-left border-b capitalize">
                                GRAND TOTAL:
                            </td>
                            <td class="py-3 px-2 text-center border-b capitalize">
                                {{ number_format($grandTotals->total_occupants) }}
                            </td>
                            <td class="py-3 px-2 text-center border-b capitalize">
                                <!-- Empty cell for Assigned Relocation Site -->
                            </td>
                            <td class="py-3 px-2 text-center border-b capitalize">
                                {{ number_format($grandTotals->total_awarded) }}
                            </td>
                            <td colspan="2" class="py-3 px-2 text-right border-b capitalize">
                                Pending: {{ number_format($grandTotals->total_pending) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="mt-4">
                {{ $groupedApplicants->links() }}
            </div>

{{--            <script>--}}
{{--                // Function to number rows--}}
{{--                function numberRows(){--}}
{{--                    // Get the table body--}}
{{--                    const tbody = document.querySelector('#dataTable tbody');--}}

{{--                    // Get all rows in the body--}}
{{--                    const rows = tbody.querySelectorAll('tr');--}}

{{--                    // Loop through rows and add numbering--}}
{{--                    rows.forEach((row, index) => {--}}
{{--                        // Select the first cell (No. column)--}}
{{--                        const numberCell = row.querySelector('td:first-child');--}}

{{--                        // Set the row number (adding 1 to make it 1-indexed)--}}
{{--                        numberCell.textContent = index + 1;--}}
{{--                    });--}}
{{--                }--}}

{{--                // Call the function when the page loads--}}
{{--                window.onload = numberRows();--}}
{{--            </script>--}}
        </div>
    </div>
</div>
