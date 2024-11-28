<div x-data="{ openFilters: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <!-- Main Content -->
        <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">
            <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-5 relative p-3">
                <div class="flex items-center">
                    <h2 class="text-[13px] ml-5 text-gray-700 font-semibold">DISTRIBUTION LIST</h2>
                </div>
                <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                <div class="relative">
                    <button wire:click="export" wire:ignore wire:loading.attr="disabled"
                        class="bg-gradient-to-r from-custom-yellow to-custom-orange hover:bg-gradient-to-r hover:from-custom-yellow hover:to-custom-dark-orange text-white px-4 py-2 rounded">
                        <span wire:loading wire:target="export">Exporting Excel...</span>
                        <span wire:loading.remove>Export to Excel</span>
                    </button>
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
                            <input type="search" name="search" id="search"
                                class="rounded-md px-12 py-2 placeholder:text-[13px] z-10 border border-gray-300 bg-[#f7f7f9] hover:ring-custom-yellow focus:ring-custom-yellow"
                                placeholder="Search">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <!-- PR Number Filter -->
                        <label class="text-center mt-2">PR No:</label>
                        <select wire:model="selectedPrNumber" wire:change="applyFilters" class="border text-[12px] border-gray-300 text-gray-600 rounded px-1 py-1 shadow-sm ml-2 mr-2">
                            <option value="">PR NUMBER</option>
                            <option value="">All</option>
                            @foreach ($prNumbers as $id => $prNumber)
                            <option value="{{ $id }}">PR No. {{ $prNumber }}</option>
                            @endforeach
                        </select>

                        <!-- PO Number Filter -->
                        <label class="text-center mt-2">PO No:</label>
                        <select wire:model="selectedPoNumber" wire:change="applyFilters" class="border text-[12px] border-gray-300 text-gray-600 rounded ml-2 px-1 py-1 shadow-sm">
                            <option value="">PO NUMBER</option>
                            <option value="">All</option>
                            @foreach ($poNumbers as $id => $poNumber)
                            <option value="{{ $id }}">PO No. {{ $poNumber }}</option>
                            @endforeach
                        </select>

                        <!-- Reset Button -->
                        <div class="relative group ml-2">
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
                    <label class="text-center mt-2">Date From:</label>
                    <input type="date" id="start-date" class="border text-[12px] border-gray-300 rounded px-2 py-1"
                        max="{{ now()->toDateString() }}" wire:model.live="startRisDate">
                    <label class="text-center mt-2">To:</label>
                    <input type="date" id="end-date" class="border text-[12px] border-gray-300 rounded px-2 py-1"
                        max="{{ now()->toDateString() }}" wire:model.live="endRisDate">
                    <button wire:click="resetFilters" class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-4 py-1.5 rounded-full">Clear Filter</button>
                </div>
            </div>


            <!-- Table with transaction requests -->
            <div x-data="{openModalGrant: false, openPreviewModal: false, selectedFile: null, fileName: ''}"
                class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-[20px]  text-center font-medium whitespace-nowrap">No.</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">DATE OF RIS</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">NAME OF RECIPIENT</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">CONTACT NO.</th>
                            @foreach ($allMaterials as $material)
                            <th class="py-2 px-2 text-center font-medium whitespace-nowrap">
                                {{ strtoupper($material->item_description) }}
                                ({{ $material->materialUnit->unit_name ?? 'N/A' }})
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grantees as $grantee)
                        <tr>
                            <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $grantee->profiledTaggedApplicant->shelterApplicant->profile_no }}</td>
                            <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $grantee->date_of_ris ? $grantee->date_of_ris->format('Y-m-d') : '' }}</td>
                            <td class="py-4 px-2 text-center capitalize border-b whitespace-nowrap">
                                {{ $grantee->profiledTaggedApplicant->shelterApplicant->person->last_name ?? 'N/A' }},
                                {{ $grantee->profiledTaggedApplicant->shelterApplicant->person->first_name ?? 'N/A' }}
                                {{ $grantee->profiledTaggedApplicant->shelterApplicant->person->middle_name ?? 'N/A' }}
                            </td>
                            <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $grantee->profiledTaggedApplicant->contact_number ?? 'N/A' }}</td>

                            @foreach ($allMaterials as $material)
                            @php
                            $deliveredMaterial = $grantee->deliveredMaterials->firstWhere('material_id', $material->id);
                            @endphp
                            <td class="py-4 px-2 text-center border-b whitespace-nowrap">
                                {{ $deliveredMaterial->grantee_quantity ?? '0' }}
                            </td>
                            @endforeach
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ 4 + $allMaterials->count() }}" class="text-center py-4">No Grantees found.</td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <!-- Pagination Links -->
            <div class="py-4 px-3">
                {{ $grantees->links() }}
            </div>
        </div>
    </div>
</div>