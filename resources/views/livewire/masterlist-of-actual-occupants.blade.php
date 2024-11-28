<div>
    <div class="p-10 h-screen ml-[17%] mt-[60px]">
        <div x-data="{ openModal: false, openFilters: false}" class="flex bg-gray-100 text-[12px]">

            <!-- Main Content -->
            <div class="flex-1 h-screen p-6 overflow-auto">

                <!-- Container for the Title -->
                <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-0 relative p-3">
                    <div class="flex items-center">
                        <h2 class="text-[13px] ml-5 text-gray-700">MASTERLIST OF ACTUAL OCCUPANTS</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}"
                         alt="Design"
                         class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                    @hasanyrole('Super Admin|Housing System Admin')
                    <div class="@role('Housing System Tagger') relative z-0 flex flex-col sm:flex-row gap-2 @else relative z-0 @endrole">
                        <button wire:click="export" wire:ignore wire:loading.attr="disabled"
                                class="@role('Housing System Tagger') w-full sm:w-auto bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white px-4 py-2 rounded text-sm @else bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white px-4 py-2 rounded @endrole">
                            <span wire:loading wire:target="export">Exporting Excel...</span>
                            <span wire:loading.remove>Export to Excel</span>
                        </button>
                    </div>
                    @endhasanyrole
                </div>

                <!-- Search and Filters -->
                <div class="bg-white p-6 rounded shadow">
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2">
                            <button @click="openFilters = !openFilters" class="flex space-x-2 items-center hover:bg-[#FF8100] py-2 px-4 rounded bg-[#FF9100]">
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
                                <input wire:model.live="search"
                                       type="search"
                                       name="search"
                                       class="rounded-md px-12 py-2 placeholder:text-[13px] z-60 border border-gray-300 bg-[#f7f7f9] hover:ring-custom-yellow focus:ring-custom-yellow"
                                       placeholder="Search by name...">
                            </div>
                        </div>
                    </div>

                    <div x-show="openFilters" class="grid grid-cols-4 gap-2 mb-1 mt-5">
                        <select wire:model.live="filters.barangay"
                                class="border text-[13px] bg-white border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">All Barangays</option>
                            @foreach($barangays as $barangay)
                                <option value="{{ $barangay->name }}">{{ $barangay->name }}</option>
                            @endforeach
                        </select>
                        <select wire:model.live="filters.purok"
                                class="border text-[13px] bg-white border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">All Puroks</option>
                            @foreach ($availablePuroks as $purok)
                                <option value="{{ $purok }}">{{ $purok }}</option>
                            @endforeach
                        </select>
                        <select wire:model.live="filters.civil_status"
                                class="border text-[13px] bg-white border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">All Civil Status</option>
                            @foreach($civilStatuses as $status)
                                <option value="{{ $status->id }}">{{ $status->civil_status }}</option>
                            @endforeach
                        </select>
                        <select wire:model.live="filters.income_range"
                                class="border text-[13px] bg-white border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            @foreach($incomeRanges as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <select wire:model.live="filters.age_range"
                                class="border text-[13px] bg-white border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            @foreach($ageRanges as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <select wire:model.live="filters.living_status"
                                class="border text-[13px] bg-white border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">All Living Status</option>
                            @foreach($livingStatuses as $status)
                                <option value="{{ $status->id }}">{{ $status->living_status_name }}</option>
                            @endforeach
                        </select>
                        <select wire:model.live="filters.living_situation"
                                class="border text-[13px] bg-white border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">All Living Situations</option>
                            @foreach($livingSituations as $livingSituation)
                                <option value="{{ $livingSituation->id }}">{{ $livingSituation->living_situation_description }}</option>
                            @endforeach
                        </select>
                        <select wire:model.live="filters.living_situation_case_specification"
                                class="border text-[13px] bg-white border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">Living Situation (Case)</option>
                            @foreach($this->getLivingSituationSpecifications() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <select wire:model.live="filters.case_specification"
                                class="border text-[13px] bg-white border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">All Case Specifications</option>
                            @foreach($caseSpecifications as $caseSpecification)
                                <option value="{{ $caseSpecification->id }}">{{ $caseSpecification->case_specification_name }}</option>
                            @endforeach
                        </select>
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

                <!-- Table for Applicants Master   list -->
                <div x-data="{ openModalAward: false, openModalTag: false, openPreviewModal: false, selectedFile: null, fileName: '' }" class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap toggle-column name-col">ID</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap toggle-column name-col">PRINCIPAL NAME</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words toggle-column name-col">AGE</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words toggle-column contact-col">OCCUPATION</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words toggle-column contact-col">MONTHLY INCOME</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words toggle-column barangay-col">MARITAL STATUS</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words toggle-column purok-col">BARANGAY</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words toggle-column purok-col">PUROK</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words toggle-column status-col">DATE TAGGED</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words toggle-column status-col">LIVING SITUATION</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words toggle-column status-col">LIVING SITUATION (CASE SPECIFICATION)</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words toggle-column status-col">LIVING STATUS</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words toggle-column status-col">SPOUSE</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words toggle-column status-col">OCCUPATION</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words toggle-column status-col">MONTHLY INCOME</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words toggle-column status-col">NO. OF DEPENDENTS</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words toggle-column status-col">FAMILY INCOME</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words toggle-column status-col">LENGTH OF RESIDENCY (YEARS)</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words toggle-column status-col">CONTACT NUMBER</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words toggle-column status-col">REMARKS</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($applicants as $applicant)
                                <tr>
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-nowrap">
                                        {{ $applicant->applicant->applicant_id ?? 'N/A' }}
                                    </td>
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words name-col">
                                        {{ $applicant->applicant->person->last_name ?? 'N/A' }}, {{ $applicant->applicant->person->first_name ?? 'N/A' }} {{ $applicant->applicant->person->middle_name ?? 'N/A' }}
                                    </td>
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words contact-col">
                                        {{ $applicant->date_of_birth ? $applicant->date_of_birth->age : 'N/A' }}
                                    </td>
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words contact-col">
                                        {{ $applicant->occupation ?? 'N/A' }}
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words barangay-col">
                                        {{ number_format($applicant->monthly_income, 2) }}
                                    </td>
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words purok-col">
                                        {{ $applicant->civilStatus->civil_status ?? 'N/A' }}
                                    </td>
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words purok-col">{{ $applicant->applicant->address->barangay->name ?? 'N/A' }}</td>
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words purok-col">{{ $applicant->applicant->address->purok->name ?? 'N/A' }}</td>
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words purok-col">{{ $applicant->tagging_date->format('m/d/Y') }}</td>
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words purok-col">{{ $applicant->livingSituation->living_situation_description ?? 'N/A' }}</td> <!-- to be modified -->
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words purok-col">
                                        @if($applicant->livingSituation->id == 8)
                                            {{ $applicant->caseSpecification->case_specification_name ?? 'N/A' }}
                                        @else
                                            {{ $applicant->living_situation_case_specification ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words purok-col">{{ $applicant->livingStatus->living_status_name ?? 'N/A' }}</td> <!-- to be modified -->
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words purok-col">
                                        @if ($applicant->civil_status_id == 3) <!-- Married -->
                                            {{ $applicant->spouse->spouse_first_name ?? '' }}
                                            {{ $applicant->spouse->spouse_middle_name ?? '' }}
                                            {{ $applicant->spouse->spouse_last_name ?? '' }}
                                        @elseif ($applicant->civil_status_id == 2) <!-- Live-in -->
                                            {{ $applicant->liveInPartner->partner_first_name ?? '' }}
                                            {{ $applicant->liveInPartner->partner_middle_name ?? '' }}
                                            {{ $applicant->liveInPartner->partner_last_name ?? '' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words purok-col">
                                        @if ($applicant->civil_status_id == 3) <!-- Married -->
                                            {{ $applicant->spouse->spouse_occupation ?? '' }}
                                        @elseif ($applicant->civil_status_id == 2) <!-- Live-in -->
                                            {{ $applicant->liveInPartner->partner_occupation ?? '' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words purok-col">
                                        @if ($applicant->civil_status_id == 3) <!-- Married -->
                                            {{ $applicant->spouse->spouse_monthly_income ? number_format($applicant->spouse->spouse_monthly_income, 2) : 'N/A' }}
                                        @elseif ($applicant->civil_status_id == 2) <!-- Live-in -->
                                            {{ $applicant->liveInPartner->partner_monthly_income ? number_format($applicant->liveInPartner->partner_monthly_income, 2) : 'N/A' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words purok-col">
                                        {{ $applicant->dependents->count() }}
                                    </td>
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words purok-col">
                                        @if ($applicant->civil_status_id == 3) <!-- Married -->
                                            {{ number_format(($applicant->monthly_income ?? 0) + ($applicant->spouse->spouse_monthly_income ?? 0), 2) }}
                                        @elseif ($applicant->civil_status_id == 2) <!-- Live-in -->
                                            {{ number_format(($applicant->monthly_income ?? 0) + ($applicant->liveInPartner->partner_monthly_income ?? 0), 2) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words purok-col">
                                        {{ $applicant->years_of_residency }}
                                    </td>
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words purok-col">
                                        {{ $applicant->applicant->person->contact_number ?? 'N/A' }}
                                    </td>
                                    <td class="py-4 px-2 text-center border-b uppercase whitespace-normal break-words purok-col">
                                        {{ $applicant->remarks ?? 'N/A' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="18" class="py-4 px-2 text-center border-b">No records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
