<div x-data="{ openFilters: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <!-- Main Content -->
        <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">

            <!-- Container for the Title -->
            <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-0 relative p-3">
                <div class="flex items-center">
                    <h2 class="text-[13px] ml-5 text-gray-700">BLACKLIST</h2>
                </div>
                <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
            </div>

            <!-- Search and Filters -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex justify-between items-center">
                    <div class="flex space-x-2">
                        <!-- Search -->
                        <div class="relative hidden md:block border-gray-300">
                            <svg class="absolute top-[9px] left-4" width="19" height="19" viewBox="0 0 21 21"
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
                </div>

                <div class="flex space-x-2 mb-1 mt-5">
                    <label class="text-center mt-2 mr-1">Date Awarded From:</label>
                    <input wire:model.live="grantDateStart"
                           type="date"
                           class="border text-[13px] border-gray-300 rounded px-2 py-1"
                           max="{{ now()->toDateString() }}">
                    <label class="text-center mt-2 mr-1">To:</label>
                    <input wire:model.live="grantDateEnd"
                           type="date"
                           class="border text-[13px] border-gray-300 rounded px-2 py-1"
                           max="{{ now()->toDateString() }}">
                    <label class="text-center mt-2 mr-1">Date Blacklisted From:</label>
                    <input wire:model.live="blacklistDateStart"
                           type="date"
                           class="border text-[13px] border-gray-300 rounded px-2 py-1"
                           max="{{ now()->toDateString() }}">
                    <label class="text-center mt-2 mr-1">To:</label>
                    <input wire:model.live="blacklistDateEnd"
                           type="date"
                           class="border text-[13px] border-gray-300 rounded px-2 py-1"
                           max="{{ now()->toDateString() }}">
                    <button wire:click="resetFilters"
                            class="px-4 py-2 text-sm text-white bg-gray-500 rounded hover:bg-gray-600">
                        Reset Filters
                    </button>
                </div>
            </div>

            <!-- Table with transaction requests -->
            <div x-data="{openModalTransfer: false, openPreviewModal: false}" class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-2  text-center font-medium">Name</th>
                            <th class="py-2 px-2 border-b text-center font-medium">Date Awarded</th>
                            <th class="py-2 px-2 border-b text-center font-medium">Date Blacklisted</th>
                            <th class="py-2 px-2 border-b text-center font-medium">Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($blacklisted as $blacklistedApplicant)
                        <tr>
                            <td class="py-4 px-2 text-center border-b">
                                {{ $blacklistedApplicant->awardee->taggedAndValidatedApplicant->applicant->person->full_name ?? '--' }}
                            </td>
                            <td class="py-4 px-2 text-center border-b">{{ $blacklistedApplicant->awardee->grant_date ? date('M d, Y', strtotime($blacklistedApplicant->awardee->grant_date)) : 'N/A' }}</td>
                            <td class="py-4 px-2 text-center border-b">{{ $blacklistedApplicant->date_blacklisted ? date('M d, Y', strtotime($blacklistedApplicant->date_blacklisted)) : 'N/A' }}</td>
                            <td class="py-2 px-2 text-center border-b">{{ $blacklistedApplicant->blacklist_reason_description ?? '--' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="14" class="py-4 px-2 text-center border-b">No applicants found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $blacklisted->links() }}
            </div>
        </div>
    </div>
</div>