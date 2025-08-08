<div x-data="{ openFilters: false, isModalOpen: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <!-- Main Content -->
        <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">
            <!-- Container for the Title -->
            <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-0 relative p-3">
                <div class="flex items-center">
                    <h2 class="text-[13px] ml-5 text-gray-700">TRANSFER HISTORIES</h2>
                </div>
                <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
            </div>
            <!-- Search and Filters -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex justify-between items-center">
                    <div class="flex space-x-2">
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
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transfer History table -->
            <div x-data="{openEditModal: false}"
                 class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-2 border-b text-center font-medium">Transfer Date</th>
                            <th class="py-2 px-2 border-b text-center font-medium toggle-column name-col">Previous Awardee</th>
                            <th class="py-2 px-2 border-b text-center font-medium toggle-column suffix-col">New Awardee</th>
                            <th class="py-2 px-2 border-b text-center font-medium toggle-column contact-col">Relationship</th>
                            <th class="py-2 px-2 border-b text-center font-medium toggle-column contact-col">Property Details</th>
                            <th class="py-2 px-2 border-b text-center font-medium toggle-column purok-col">Reason</th>
                            <th class="py-2 px-2 border-b text-center font-medium toggle-column barangay-col">Processed By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transfers as $transfer)
                            <tr>
                                <td class="py-4 px-2 text-center border-b whitespace-nowrap">
                                    {{ $transfer->transfer_date->format('M d, Y') }}
                                </td>
                                <td class="py-4 px-2 text-center border-b whitespace-normal">
                                    @php
                                        $parts = explode(" from ", $transfer->remarks);
                                        $previousParts = explode(" to ", $parts[1] ?? '');
                                        $previousAwardee = $previousParts[0] ?? 'N/A';
                                    @endphp
                                    {{ $previousAwardee }}
                                </td>
                                <td class="py-4 px-2 text-center border-b whitespace-normal">
                                    @php
                                        $newAwardee = $previousParts[1] ?? 'N/A';
                                    @endphp
                                    {{ $newAwardee }}
                                </td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-normal">
                                    {{ $transfer->relationship ?? 'N/A' }}
                                </td>
                                <td class="py-4 px-2 text-center border-b whitespace-normal">
                                    @php
                                        $awardee = $transfer->previousAwardee;
                                        $site = $awardee->actualRelocationSite ?? $awardee->assignedRelocationSite;
                                        $block = $awardee->actual_block ?? $awardee->assigned_block;
                                        $lot = $awardee->actual_lot ?? $awardee->assigned_lot;
                                    @endphp
                                    @if($site)
                                        {{ $site->relocation_site_name }}<br>
                                        <span class="text-sm text-gray-600">
                                            Block {{ $block }}, Lot {{ $lot }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-normal">
                                    {{ $transfer->transfer_reason }}
                                </td>
                                <td class="py-4 px-2 text-center border-b whitespace-normal">
                                    {{ optional($transfer->processor)->first_name }} {{ optional($transfer->processor)->last_name }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 px-2 text-center border-b">No transfer history found.</td>
                            </tr>
                        @endforelse

{{--                        @forelse($transfers as $transfer)--}}
{{--                            <tr>--}}
{{--                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap">--}}
{{--                                    {{ $transfer->transfer_date->format('M d, Y') }}--}}
{{--                                </td>--}}
{{--                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap name-col">--}}
{{--                                    {{ optional(optional(optional(optional($transfer->previousAwardee)->taggedAndValidatedApplicant)->applicant)->person)->full_name ?? 'N/A' }}--}}
{{--                                </td>--}}
{{--                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap suffix-col">--}}
{{--                                    @php--}}
{{--                                        $parts = explode(" to ", $transfer->remarks);--}}
{{--                                        $newOccupant = count($parts) > 1 ? trim($parts[1]) : 'N/A';--}}
{{--                                    @endphp--}}
{{--                                    {{ $newOccupant }}--}}
{{--                                </td>--}}
{{--                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap suffix-col">--}}
{{--                                    {{ $transfer->relationship ?? 'N/A' }}--}}
{{--                                </td>--}}
{{--                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap contact-col">--}}
{{--                                    @php--}}
{{--                                        $awardee = $transfer->previousAwardee;--}}
{{--                                        $site = $awardee->actualRelocationSite ?? $awardee->assignedRelocationSite;--}}
{{--                                        $block = $awardee->actual_block ?? $awardee->assigned_block;--}}
{{--                                        $lot = $awardee->actual_lot ?? $awardee->assigned_lot;--}}
{{--                                    @endphp--}}
{{--                                    @if($site)--}}
{{--                                        {{ $site->relocation_site_name }}<br>--}}
{{--                                        <span class="text-sm text-gray-600">--}}
{{--                                            Block {{ $block }}, Lot {{ $lot }}--}}
{{--                                        </span>--}}
{{--                                    @else--}}
{{--                                        N/A--}}
{{--                                    @endif--}}
{{--                                </td>--}}
{{--                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap purok-col">--}}
{{--                                    {{ $transfer->transfer_reason }}--}}
{{--                                </td>--}}
{{--                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap barangay-col">--}}
{{--                                    {{ optional($transfer->processor)->first_name }} {{ optional($transfer->processor)->last_name }}--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @empty--}}
{{--                            <tr>--}}
{{--                                <td colspan="7" class="py-4 px-2 text-center border-b">No transfer history found.</td>--}}
{{--                            </tr>--}}
{{--                        @endforelse--}}
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="py-4 px-3">
                    {{ $transfers->links() }}
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
