<div x-data="{ openFilters: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <!-- Main Content -->
        <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">
            <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-5 relative p-3">
                <div class="flex items-center">
                    <h2 class="text-[13px] ml-5 text-gray-700 font-semibold">REPORT ON REQUEST AND DELIVERED MATERIALS UNDER THE SHELTER ASSISTANCE PROGRAM</h2>
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
                        <!-- Government Program Filter -->
                        <select wire:model.live.debounce.500ms="governmentProgram" class="border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">Select Social Welfare Sector</option>
                            @foreach ($GovernmentPrograms as $governmentProgram)
                            <option value="{{ $governmentProgram->id }}">{{ $governmentProgram->program_name }}</option>
                            @endforeach
                        </select>


                        <!-- Clear Filter Button -->
                        <button wire:click="clearFilter" class="ml-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-4 py-1.5 rounded-full">
                            Clear Filter
                        </button>
                    </div>

                </div>
            </div>

            <div x-data="{openModalGrant: false, openPreviewModal: false, selectedFile: null, fileName: ''}" class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-[20px] text-center font-medium whitespace-nowrap">NO.</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">BARANGAY</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">NO. OF REQUEST</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">NO. OF REQUEST TAGGED AND VALIDATED</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">NO. OF REQUEST DELIVERED</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($statistics as $index => $stat)
                        <tr>
                            <td class="py-4 px-2 text-center border-b">{{ $index + 1 }}</td>
                            <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $stat->barangay_name }}</td>
                            <td class="py-4 px-2 text-center border-b">{{ $stat->total_requests }}</td>
                            <td class="py-4 px-2 text-center border-b">{{ $stat->tagged_requests }}</td>
                            <td class="py-4 px-2 text-center border-b">{{ $stat->delivered_requests }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-4 px-2 text-center border-b">No records found</td>
                        </tr>
                        @endforelse
                        <!-- Totals Row -->
                        <tr class="bg-yellow-100 font-bold">
                            <td class="py-4 px-2 text-center border-t"></td>
                            <td class="py-4 px-2 text-center border-t" >TOTAL</td>
                            <td class="py-4 px-2 text-center border-t">{{ $totals['total_requests'] }}</td>
                            <td class="py-4 px-2 text-center border-t">{{ $totals['tagged_requests'] }}</td>
                            <td class="py-4 px-2 text-center border-t">{{ $totals['delivered_requests'] }}</td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>