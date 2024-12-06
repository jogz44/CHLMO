<div x-data="{ openFilters: false, isModalOpen: false }"
     class="@role('Housing System Tagger') p-4 lg:p-10 md:p-2 mt-16 min-h-screen w-full @else p-10 h-screen ml-[17%] mt-[80px] @endrole">
    <div class="@role('Housing System Tagger') flex flex-col bg-gray-100 text-[12px] @else flex bg-gray-100 text-[12px] @endrole">
        <!-- Main Content -->
        <div class="@role('Housing System Tagger') flex-1 h-screen p-6 overflow-auto @else flex-1 h-screen p-3 lg:p-6 overflow-auto @endrole">
            <!-- Add this to your Blade template -->
            <div x-data="{
                    showHousingDuplicateWarning: @entangle('showHousingDuplicateWarning'),
                    housingDuplicateData: @entangle('housingDuplicateData')
                }">
                <!-- Container for the Title -->
                <div class="@role('Housing System Tagger') bg-white rounded shadow mb-4 flex flex-col sm:flex-row items-center justify-between z-0 relative p-3 @else bg-white rounded shadow mb-4 flex items-center justify-between z-0 relative p-3 @endrole">
                    <div class="@role('Housing System Tagger') flex items-center mb-3 sm:mb-0 @else flex items-center @endrole">
                        <h2 class="@role('Housing System Tagger') text-[13px] ml-2 sm:ml-5 text-gray-700 @else text-[13px] ml-5 text-gray-700 @endrole">APPLICANTS</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design"
                         class="@role('Housing System Tagger') hidden sm:block absolute right-0 top-0 h-full object-cover opacity-100 z-0 @else absolute right-0 top-0 h-full object-cover opacity-100 z-0 @endrole">
                    @hasanyrole('Super Admin|Housing System Admin')
                        <div class="@role('Housing System Tagger') relative z-0 flex flex-col sm:flex-row gap-2 @else relative z-0 @endrole">
                            <button @click="isModalOpen = true"
                                    class="@role('Housing System Tagger') w-full sm:w-auto bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white px-4 py-2 rounded text-sm @else bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white px-4 py-2 rounded @endrole">
                                Add Applicant
                            </button>
                            <button wire:click="exportPDF" wire:loading.attr="disabled"
                                    class="@role('Housing System Tagger') w-full sm:w-auto bg-gradient-to-r from-custom-blue to-custom-purple hover:bg-gradient-to-r hover:from-custom-blue hover:to-custom-dark-purple text-white px-4 py-2 rounded text-sm @else bg-gradient-to-r from-custom-blue to-custom-purple hover:bg-gradient-to-r hover:from-custom-blue hover:to-custom-dark-purple text-white px-4 py-2 rounded @endrole">
                                <span wire:loading wire:target="exportPDF">Exporting PDF...</span>
                                <span wire:loading.remove>Export to PDF</span>
                            </button>

                            <button wire:click="export" wire:ignore wire:loading.attr="disabled"
                                    class="@role('Housing System Tagger') w-full sm:w-auto bg-gradient-to-r from-custom-yellow to-custom-orange hover:bg-gradient-to-r hover:from-custom-yellow hover:to-custom-dark-orange text-white px-4 py-2 rounded text-sm @else bg-gradient-to-r from-custom-yellow to-custom-orange hover:bg-gradient-to-r hover:from-custom-yellow hover:to-custom-dark-orange text-white px-4 py-2 rounded @endrole">
                                <span wire:loading wire:target="export">Exporting Excel...</span>
                                <span wire:loading.remove>Export to Excel</span>
                            </button>
                        </div>
                    @endhasanyrole
                </div>

                <!-- Search and Filters -->
                <div class="@role('Housing System Tagger') bg-white p-4 lg:p-6 rounded shadow @else bg-white p-6 rounded shadow @endrole">
                    <div class="@role('Housing System Tagger') flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 @else flex justify-between items-center @endrole">
                        <div class="@role('Housing System Tagger') flex flex-col sm:flex-row gap-2 w-full sm:w-auto @else flex space-x-2 @endrole">
                            <button @click="openFilters = !openFilters"
                                    class="@role('Housing System Tagger') flex space-x-2 items-center justify-center hover:bg-yellow-500 py-2 px-4 rounded bg-iroad-orange w-full sm:w-auto @else flex space-x-2 items-center hover:bg-yellow-500 py-2 px-4 rounded bg-iroad-orange @endrole">
                                <div class="text-white">
                                    <!-- Filter Icon (You can use an icon from any library) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.447.894l-4 2.5A1 1 0 017 21V13.414L3.293 6.707A1 1 0 013 6V4z" />
                                    </svg>
                                </div>
                                <div class="@role('Housing System Tagger') text-[13px] text-white font-medium @else text-[13px] text-white font-medium @endrole">
                                    Filter
                                </div>
                            </button>
                            <!-- Search -->
                            <div class="@role('Housing System Tagger') relative w-full sm:w-auto border-gray-300 z-60 @else relative hidden md:block border-gray-300 z-60 @endrole">
                                <svg class="absolute top-[8px] left-4" width="19" height="19" viewBox="0 0 21 21"
                                     fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.625 16.625C13.491 16.625 16.625 13.491 16.625 9.625C16.625 5.75901 13.491 2.625 9.625 2.625C5.75901 2.625 2.625 5.75901 2.625 9.625C2.625 13.491 5.75901 16.625 9.625 16.625Z"
                                          stroke="#787C7F" stroke-width="1.75" stroke-linecap="round"
                                          stroke-linejoin="round" />
                                    <path d="M18.3746 18.375L14.5684 14.5688" stroke="#787C7F" stroke-width="1.75"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <input wire:model.live.debounce.300ms="search" type="search" name="search"
                                       class="@role('Housing System Tagger') w-full rounded-md px-12 py-2 placeholder:text-[13px] z-60 border border-gray-300 bg-[#f7f7f9] hover:ring-custom-yellow focus:ring-custom-yellow @else rounded-md px-12 py-2 placeholder:text-[13px] z-60 border border-gray-300 bg-[#f7f7f9] hover:ring-custom-yellow focus:ring-custom-yellow @endrole" placeholder="Search">
                                <!-- Clear Button -->
                                <button wire:click="clearSearch" class="@role('Housing System Tagger') absolute bottom-1 right-4 text-2xl text-gray-500 @else absolute bottom-1 right-4 text-2xl text-gray-500 @endrole">
                                    &times; <!-- This is the "x" symbol -->
                                </button>
                            </div>
                        </div>

                        <div class="@role('Housing System Tagger') flex flex-col sm:flex-row gap-2 w-full sm:w-auto @endrole">
                            <div class="flex justify-end">
                                @hasanyrole('Super Admin|Housing System Admin|Housing System Staff')
                                    <div class="@role('Housing System Tagger') flex items-center gap-1 w-full sm:w-auto @endrole">
                                        <label class="@role('Housing System Tagger') text-center whitespace-nowrap text-sm @else text-center mt-2 mr-1 @endrole" for="start_date">
                                            Date Applied From:
                                        </label>
                                        <input type="date" id="start_date" wire:model.live="startDate"
                                               class="@role('Housing System Tagger') border text-[13px] border-gray-300 rounded px-2 py-1 w-6 @else border text-[13px] border-gray-300 rounded px-2 py-1 @endrole"
                                               max="{{ now()->toDateString() }}">
                                    </div>

                                    <div class="@role('Housing System Tagger') flex items-center gap-1 w-full sm:w-auto @endrole">
                                        <label class="@role('Housing System Tagger') text-center whitespace-nowrap text-sm @else text-center mt-2 ml-2 mr-1 @endrole" for="end_date">
                                            To:
                                        </label>
                                        <input type="date" id="end_date" wire:model.live="endDate"
                                               class="@role('Housing System Tagger') border text-[13px] border-gray-300 rounded px-2 py-1 w-full @else border text-[13px] border-gray-300 rounded px-2 py-1 mr-1 @endrole"
                                               max="{{ now()->toDateString() }}"
                                               placeholder="{{ now()->toDateString() }}">
                                    </div>

                                    <div class="relative group">
                                        <button wire:click="resetFilters" class="@role('Housing System Tagger') flex items-center justify-center border border-gray-300 bg-gray-100 rounded w-8 h-8 @else flex items-center justify-center border border-gray-300 bg-gray-100 rounded w-8 h-8 @endrole">
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 256 256" class="w-4 h-4" xml:space="preserve">
                                                <g transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                                    <path d="M 81.521 31.109 c -0.86 -1.73 -2.959 -2.438 -4.692 -1.575 c -1.73 0.86 -2.436 2.961 -1.575 4.692 c 2.329 4.685 3.51 9.734 3.51 15.01 C 78.764 67.854 63.617 83 45 83 S 11.236 67.854 11.236 49.236 c 0 -16.222 11.501 -29.805 26.776 -33.033 l -3.129 4.739 c -1.065 1.613 -0.62 3.784 0.992 4.85 c 0.594 0.392 1.264 0.579 1.926 0.579 c 1.136 0 2.251 -0.553 2.924 -1.571 l 7.176 -10.87 c 0.001 -0.001 0.001 -0.002 0.002 -0.003 l 0.018 -0.027 c 0.063 -0.096 0.106 -0.199 0.159 -0.299 c 0.049 -0.093 0.108 -0.181 0.149 -0.279 c 0.087 -0.207 0.152 -0.419 0.197 -0.634 c 0.009 -0.041 0.008 -0.085 0.015 -0.126 c 0.031 -0.182 0.053 -0.364 0.055 -0.547 c 0 -0.014 0.004 -0.028 0.004 -0.042 c 0 -0.066 -0.016 -0.128 -0.019 -0.193 c -0.008 -0.145 -0.018 -0.288 -0.043 -0.431 c -0.018 -0.097 -0.045 -0.189 -0.071 -0.283 c -0.032 -0.118 -0.065 -0.236 -0.109 -0.35 c -0.037 -0.095 -0.081 -0.185 -0.125 -0.276 c -0.052 -0.107 -0.107 -0.211 -0.17 -0.313 c -0.054 -0.087 -0.114 -0.168 -0.175 -0.25 c -0.07 -0.093 -0.143 -0.183 -0.223 -0.27 c -0.074 -0.08 -0.153 -0.155 -0.234 -0.228 c -0.047 -0.042 -0.085 -0.092 -0.135 -0.132 L 36.679 0.775 c -1.503 -1.213 -3.708 -0.977 -4.921 0.53 c -1.213 1.505 -0.976 3.709 0.53 4.921 l 3.972 3.2 C 17.97 13.438 4.236 29.759 4.236 49.236 C 4.236 71.714 22.522 90 45 90 s 40.764 -18.286 40.764 -40.764 C 85.764 42.87 84.337 36.772 81.521 31.109 z"
                                                          style="fill: rgb(0,0,0);"></path>
                                                </g>
                                            </svg>
                                        </button>
                                    </div>
                                @endhasanyrole
                            </div>
                        </div>
                    </div>

                    <div x-show="openFilters" class="@role('Housing System Tagger') flex flex-col sm:flex-row gap-2 mb-1 mt-5 @else flex space-x-2 mb-1 mt-5 @endrole">
                        <select wire:model.live="selectedBarangay_id" class="@role('Housing System Tagger') w-full sm:w-auto bg-gray-50 border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm @else bg-gray-50 border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm @endrole">
                            <option value="">Barangay</option>
                            @foreach($barangaysFilter as $barangayFilter)
                                <option value="{{ $barangayFilter->id }}">{{ $barangayFilter->name }}</option>
                            @endforeach
                        </select>
                        <select wire:model.live="selectedPurok_id" class="@role('Housing System Tagger') w-full sm:w-auto bg-gray-50 border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm @else bg-gray-50 border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm @endrole">
                            <option value="">Purok</option>
                            @foreach($puroksFilter as $purokFilter)
                                <option value="{{ $purokFilter->id }}">{{ $purokFilter->name }}</option>
                            @endforeach
                        </select>
                        <select wire:model.live="selectedTaggingStatus" class="@role('Housing System Tagger') w-full sm:w-auto bg-gray-50 border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm @else bg-gray-50 border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm @endrole">
                            <option value="">Status</option>
                            @foreach($taggingStatuses as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                        <button wire:click="resetFilters" class="@role('Housing System Tagger') w-full sm:w-auto bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-4 py-1.5 rounded-full @else bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-4 py-1.5 rounded-full @endrole">Reset Filters</button>
                    </div>
                </div>

                <!-- Applicants table -->
                <div x-data="{openEditModal: false}" class="@role('Housing System Tagger') overflow-x-auto mt-4 @else overflow-x-auto @endrole">
                    <div class="@role('Housing System Tagger') inline-block min-w-full align-middle @endrole">
                        <div class="@role('Housing System Tagger') overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg @endrole">
                            <table class="@role('Housing System Tagger') min-w-full divide-y divide-gray-300 @else min-w-full bg-white border border-gray-200 @endrole">
                                <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-2 border-b text-center font-medium">ID</th>
                                    <th class="py-2 px-2 border-b text-center font-medium">Name</th>
                                    <th class="@role('Housing System Tagger') hidden sm:table-cell py-2 px-2 border-b text-center font-medium @else py-2 px-2 border-b text-center font-medium @endrole">Suffix Name</th>
                                    <th class="@role('Housing System Tagger') hidden sm:table-cell py-2 px-2 border-b text-center font-medium @else py-2 px-2 border-b text-center font-medium @endrole">Contact Number</th>
                                    <th class="@role('Housing System Tagger') hidden sm:table-cell py-2 px-2 border-b text-center font-medium @else py-2 px-2 border-b text-center font-medium @endrole">Purok</th>
                                    <th class="@role('Housing System Tagger') hidden sm:table-cell py-2 px-2 border-b text-center font-medium @else py-2 px-2 border-b text-center font-medium @endrole">Barangay</th>
                                    <th class="@role('Housing System Tagger') hidden sm:table-cell py-2 px-2 border-b text-center font-medium @else py-2 px-2 border-b text-center font-medium @endrole">Transaction Type</th>
                                    <th class="py-2 px-2 border-b text-center font-medium">Date Applied</th>
                                    <th class="py-2 px-2 border-b text-center font-medium">Actions</th>
                                </tr>
                                </thead>
                                <tbody class="@role('Housing System Tagger') divide-y divide-gray-200 bg-white @endrole">
                                    @forelse($applicants->where('transaction_type', 'Walk-in') as $applicant)
                                        <tr>
                                            <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap">{{ optional($applicant)->applicant_id }}</td>
                                            <td class="py-4 px-2 text-center border-b capitalize whitespace-normal break-words">{{ optional($applicant->person)->full_name }}</td>
                                            <td class="@role('Housing System Tagger') hidden sm:table-cell py-4 px-2 text-center border-b capitalize @else py-4 px-2 text-center border-b capitalize whitespace-normal break-words @endrole">{{ optional($applicant->person)->suffix_name }}</td>
                                            <td class="@role('Housing System Tagger') hidden sm:table-cell py-4 px-2 text-center border-b capitalize @else py-4 px-2 text-center border-b capitalize whitespace-normal break-words @endrole">{{ optional($applicant->person)->contact_number }}</td>
                                            <td class="@role('Housing System Tagger') hidden sm:table-cell py-4 px-2 text-center border-b capitalize @else py-4 px-2 text-center border-b capitalize whitespace-normal break-words @endrole">{{ optional($applicant->address->purok)->name ?? 'N/A' }}</td>
                                            <td class="@role('Housing System Tagger') hidden sm:table-cell py-4 px-2 text-center border-b capitalize @else py-4 px-2 text-center border-b capitalize whitespace-normal break-words @endrole">{{ optional($applicant->address->barangay)->name ?? 'N/A' }}</td>
                                            <td class="@role('Housing System Tagger') hidden sm:table-cell py-4 px-2 text-center border-b capitalize @else py-4 px-2 text-center border-b capitalize whitespace-normal break-words @endrole">{{ $applicant->transaction_type ?? 'N/A' }}</td>
                                            <td class="py-4 px-2 text-center border-b whitespace-normal break-words">{{ \Carbon\Carbon::parse($applicant->date_applied)->format('m/d/Y') }}</td>
                                            <td class="py-4 px-2 text-center border-b whitespace-nowrap space-x-2">
                                                <div class="@role('Housing System Tagger') flex flex-col sm:flex-row gap-2 justify-center @endrole">
                                                    @if ($applicant->taggedAndValidated)
                                                        <button class="@role('Housing System Tagger') bg-gray-400 text-white px-4 sm:px-14 py-1.5 rounded-full cursor-not-allowed @else bg-gray-400 text-white px-14 py-1.5 rounded-full cursor-not-allowed @endrole">
                                                            Tagged
                                                        </button>
                                                    @else
                                                        @hasanyrole('Super Admin|Housing System Admin')
                                                        <!-- Edit Button -->
                                                        <button wire:click="edit({{ $applicant->id }})"
                                                                @click="openEditModal = true"
                                                                class="@role('Housing System Tagger') text-custom-red text-bold underline px-4 py-1.5 @else text-custom-red text-bold underline px-4 py-1.5 @endrole">
                                                            Edit
                                                        </button>
                                                        @endhasanyrole
                                                        <!-- Tag Button -->
                                                        <button onclick="window.location.href='{{ route('applicant-details', ['applicantId' => $applicant->id]) }}'"
                                                                class="@role('Housing System Tagger') bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-4 sm:px-8 py-1.5 rounded-full @else bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-8 py-1.5 rounded-full @endrole">
                                                            Tag
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="py-4 px-2 text-center border-b">No applicants found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <!-- Pagination Links -->
                    <div class="py-4 px-3">
                        {{ $applicants->links() }}
                    </div>

                    <!-- applicants.blade.php -->
                    <div x-show="$wire.showHousingDuplicateWarning"
                         class="fixed inset-0 z-[99999] bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full"
                         x-cloak>
                        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                            <div class="mt-3 text-center">
                                <h3 class="text-lg leading-6 font-medium text-gray-900"
                                    x-text="$wire.housingDuplicateData?.applications?.housing ? 'Cannot Proceed - Duplicate Found' : 'Possible Duplicate Found'">
                                </h3>
                                <div class="mt-2 px-7 py-3">
                                    <p class="text-sm text-gray-500" x-text="$wire.housingDuplicateData?.message"></p>
                                    <div class="mt-4">
                                        <template x-if="$wire.housingDuplicateData?.applications?.housing">
                                            <p class="text-sm text-red-600">Has Housing Application</p>
                                        </template>
                                        <template x-if="$wire.housingDuplicateData?.applications?.shelter">
                                            <p class="text-sm text-red-600">Has Shelter Application</p>
                                        </template>
                                    </div>
                                </div>
                                <div class="items-center px-4 py-3 space-y-3">
                                    <template x-if="!$wire.housingDuplicateData?.applications?.housing">
                                        <button type="button"
                                                wire:click="proceedWithApplication"
                                                class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                            Proceed
                                        </button>
                                    </template>
                                    <button type="button"
                                            wire:click="closeDuplicateWarning"
                                            class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ADD APPLICANT MODAL -->
                    <div x-show="isModalOpen" x-cloak
                         class="fixed inset-0 flex items-center justify-center z-[9999] bg-black bg-opacity-50">
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
                                <div>
                                    <label class="block text-[12px] font-medium mb-2 w-full text-black">
                                        APPLICATION DATE <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="date_applied" wire:model="date_applied"
                                           class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none mb-4"
                                           max="{{ now()->toDateString() }}">
                                    @error('date_applied') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <!-- Main Fields -->
                                <div class="grid grid-cols-2 gap-3 mb-3">
                                    <!-- First Name Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-2 text-black">
                                            FIRST NAME <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               wire:model="first_name"
                                               id="first_name"
                                               maxlength="256"
                                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px]"
                                               required>
                                        @error('first_name') <span class="error">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Middle Name Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-2 text-black">
                                            MIDDLE NAME <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               wire:model="middle_name"
                                               id="middle_name"
                                               maxlength="256"
                                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px]">
                                        @error('middle_name') <span class="error">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Last Name Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-2 text-black" for="last_name">
                                            LAST NAME <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               wire:model="last_name"
                                               id="last_name"
                                               maxlength="256"
                                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px]"
                                               required>
                                        @error('last_name') <span class="error">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Suffix Name Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-2 text-black">
                                            SUFFIX NAME
                                        </label>
                                        <input type="text"
                                               wire:model="suffix_name"
                                               id="suffix_name"
                                               maxlength="256"
                                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px]">
                                        @error('suffix_name') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- Barangay Field -->
                                <div class="mb-3">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="barangay">
                                        BARANGAY <span class="text-red-500">*</span>
                                    </label>
                                    <select id="barangay" wire:model.live="barangay_id"
                                            class="w-full px-3 py-1 text-[12px] select2-barangay bg-white border border-gray-600 rounded-lg text-gray-800"
                                            required>
                                        <option value="">Select Barangay</option>
                                        @foreach($barangays as $barangay)
                                            <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('barangay_id') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <!-- Purok Field -->
                                <div class="mb-3">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="purok">
                                        PUROK <span class="text-red-500">*</span>
                                    </label>
                                    <select id="purok" wire:model.live="purok_id"
                                            class="w-full px-3 py-1 text-[12px] select2-purok bg-white border border-gray-600 rounded-lg focus:outline-none text-gray-800"
                                            required>
                                        <option value="">Select Purok</option>
                                        @foreach($puroks as $purok)
                                            <option value="{{ $purok->id }}">{{ $purok->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('purok_id') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <!-- Contact Number Field -->
                                <div class="mb-3">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="contact_number">
                                        CONTACT NUMBER
                                    </label>
                                    <input type="text"
                                           wire:model="contact_number"
                                           id="contact_number"
                                           pattern="^09\d{9}$"
                                           title="Enter a valid phone number (e.g., 09123456789)"
                                           maxlength="11"
                                           class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase"
                                           placeholder="09xxxxxxxxx"
                                           oninput="validateNumberInput(this)">
                                    @error('contact_number') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <script>
                                    function validatePhoneNumber(input) {
                                        // Remove any characters that are not digits, parentheses, or spaces
                                        input.value = input.value.replace(/[^0-9() ]/g, '');

                                        // Optional: Automatically limit the length based on the type of number
                                        if (input.value.startsWith('09')) {
                                            input.maxLength = 11; // Mobile numbers
                                        }
                                    }
                                </script>

                                <!-- Interviewer Field -->
                                <div class="mb-6">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="interviewer">
                                        INITIALLY INTERVIEWED BY <small class="text-red-500">(read only)</small>
                                    </label>
                                    <input type="text" id="interviewer" wire:model="interviewer" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-red-600 focus:outline-none text-[12px] uppercase cursor-default" readonly>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <!-- Cancel Button -->
                                    <button type="button" @click="isModalOpen = false"
                                            class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                        <span class="text-[12px]">
                                            CANCEL
                                        </span>
                                    </button>
                                    <!-- Submit button and alert message -->
                                    <div>
                                        <div class="alert"
                                             :class="{primary:'alert-primary', success:'alert-success', danger:'alert-danger', warning:'alert-warning'}[(alert.type ?? 'primary')]"
                                             x-data="{ open:false, alert:{} }"
                                             x-show="open" x-cloak
                                             x-transition:enter="animate-alert-show"
                                             x-transition:leave="animate-alert-hide"
                                             @alert.window="open = true; setTimeout( () => open=false, 3000 ); alert=$event.detail[0]">
                                            <div class="alert-wrapper">
                                                <strong x-html="alert.title">Title</strong>
                                                <p x-html="alert.message">Description</p>
                                            </div>
                                            <i class="alert-close fa-solid fa-xmark" @click="open=false"></i>
                                        </div>
                                        <!-- Add Applicant Button -->
                                        <button type="submit"
                                                wire:click.prevent="store"
                                                wire:loading.attr="disabled"
                                                wire:target="store"
                                                class="w-full py-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white font-semibold rounded-lg flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                                <span class="text-[12px]">
                                                    + ADD APPLICANT
                                                </span>
                                            <!-- Show spinner only when loading -->
                                            <div wire:loading wire:target="store">
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
                                        <input type="text" wire:model="edit_first_name" id="first_name"
                                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" required>
                                    </div>

                                    <!-- Middle Name Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-2 text-black" for="middle_name">MIDDLE NAME </label>
                                        <input type="text" wire:model="edit_middle_name" id="middle_name"
                                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase">
                                    </div>

                                    <!-- Last Name Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-2 text-black" for="last_name">LAST NAME </label>
                                        <input type="text" wire:model="edit_last_name" id="last_name"
                                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" required>
                                    </div>

                                    <!-- Suffix Name Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-2 text-black" for="suffix_name">SUFFIX NAME</label>
                                        <input type="text" wire:model="edit_suffix_name" id="suffix_name"
                                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase">
                                    </div>
                                </div>

                                <!-- Barangay Field -->
                                <div class="mb-3">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="barangay">BARANGAY </label>
                                    <select id="barangay" wire:model.live="edit_barangay_id"
                                            class="w-full px-3 py-1 text-[12px] select2-barangay bg-white border border-gray-600 rounded-lg text-gray-800 uppercase" required>
                                        <option value="">Select Barangay</option>
                                        @foreach($barangays as $barangay)
                                            <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Purok Field -->
                                <div class="mb-3">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="purok">PUROK </label>
                                    <select id="purok" wire:model.live="edit_purok_id"
                                            class="w-full px-3 py-1 text-[12px] select2-purok bg-white border border-gray-600 rounded-lg focus:outline-none text-gray-800 uppercase" required>
                                        <option value="">Select Purok</option>
                                        @foreach($puroks as $purok)
                                            <option value="{{ $purok->id }}">{{ $purok->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Contact Number Field -->
                                <div class="mb-6">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="contact_number">
                                        CONTACT NUMBER
                                    </label>
                                    <input type="text"
                                           wire:model="edit_contact_number"
                                           id="contact_number"
                                           class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase"
                                           placeholder="Contact Number">
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <!-- Cancel Button -->
                                    <button type="button" @click="openEditModal = false"
                                            class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                        <span class="text-[12px]">
                                            CANCEL
                                        </span>
                                    </button>
                                    <div>
                                        <!-- Submit button and alert message -->
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
                                        <!-- SAVE Button -->
                                        <button type="submit"
                                                wire:click.prevent="update"
                                                wire:loading.attr="disabled"
                                                wire:target="store"
                                                class="w-full py-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white font-semibold rounded-lg flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                            <span class="text-[12px]">
                                                SAVE
                                            </span>
                                            <div wire:loading wire:target="store">
                                                <svg aria-hidden="true"
                                                     class="w-5 h-5 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                                     viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                            fill="currentColor"/>
                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                            fill="currentFill"/>
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
                                </div>
                            </form>
                        </div>
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
<script>
    // Function to allow only numeric input
    function validateNumberInput(input) {
        // Remove any characters that are not digits
        input.value = input.value.replace(/[^0-9]/g, '');
    }
</script>