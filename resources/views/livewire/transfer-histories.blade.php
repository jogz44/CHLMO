{{--<div>--}}
{{--    <div class="bg-white shadow rounded-lg">--}}
{{--        <div class="px-4 py-5 sm:px-6">--}}
{{--            <h3 class="text-lg font-medium leading-6 text-gray-900">Award Transfer History</h3>--}}
{{--        </div>--}}
{{--        <div class="overflow-x-auto">--}}
{{--            <table class="min-w-full divide-y divide-gray-200">--}}
{{--                <thead class="bg-gray-50">--}}
{{--                <tr>--}}
{{--                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">--}}
{{--                        Transfer Date--}}
{{--                    </th>--}}
{{--                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">--}}
{{--                        Previous Awardee--}}
{{--                    </th>--}}
{{--                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">--}}
{{--                        Transferred To--}}
{{--                    </th>--}}
{{--                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">--}}
{{--                        Lot Details--}}
{{--                    </th>--}}
{{--                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">--}}
{{--                        Reason--}}
{{--                    </th>--}}
{{--                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">--}}
{{--                        Processed By--}}
{{--                    </th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody class="bg-white divide-y divide-gray-200">--}}
{{--                @foreach($transfers as $transfer)--}}
{{--                    <tr>--}}
{{--                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">--}}
{{--                            {{ $transfer->transfer_date->format('M d, Y') }}--}}
{{--                        </td>--}}
{{--                        <td class="px-6 py-4 whitespace-nowrap">--}}
{{--                            {{ $transfer->previousAwardee->taggedAndValidatedApplicant->applicant->full_name }}--}}
{{--                        </td>--}}
{{--                        <td class="px-6 py-4 whitespace-nowrap">--}}
{{--                            {{ $transfer->remarks }}--}}
{{--                        </td>--}}
{{--                        <td class="px-6 py-4 whitespace-nowrap">--}}
{{--                            {{ $transfer->previousAwardee->lot->name }}--}}
{{--                        </td>--}}
{{--                        <td class="px-6 py-4 whitespace-nowrap">--}}
{{--                            {{ $transfer->transfer_reason }}--}}
{{--                        </td>--}}
{{--                        <td class="px-6 py-4 whitespace-nowrap">--}}
{{--                            {{ $transfer->processor->first_name }}--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}
{{--        <div class="px-4 py-3">--}}
{{--            {{ $transfers->links() }}--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

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
                <div class="relative z-0">
{{--                    <button @click="isModalOpen = true" class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white px-4 py-2 rounded">--}}
{{--                        Add Applicant--}}
{{--                    </button>--}}
                    <button class="bg-custom-green text-white px-4 py-2 rounded">Export</button>
                </div>
            </div>
            <!-- Search and Filters -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex justify-between items-center">
                    <div class="flex space-x-2">
{{--                        <button @click="openFilters = !openFilters" class="flex space-x-2 items-center hover:bg-yellow-500 py-2 px-4 rounded bg-iroad-orange">--}}
{{--                            <div class="text-white">--}}
{{--                                <!-- Filter Icon (You can use an icon from any library) -->--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">--}}
{{--                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.447.894l-4 2.5A1 1 0 017 21V13.414L3.293 6.707A1 1 0 013 6V4z" />--}}
{{--                                </svg>--}}
{{--                            </div>--}}
{{--                            <div class="text-[13px] text-white font-medium">--}}
{{--                                Filter--}}
{{--                            </div>--}}
{{--                        </button>--}}
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
                                    <input type="checkbox" class="toggle-column" id="toggle-transaction-type" checked> TRANSACTION TYPE
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
                        <th class="py-2 px-2 border-b text-center font-medium toggle-column suffix-col">Transferred To</th>
                        <th class="py-2 px-2 border-b text-center font-medium toggle-column contact-col">Relationship</th>
                        <th class="py-2 px-2 border-b text-center font-medium toggle-column contact-col">Lot Details</th>
                        <th class="py-2 px-2 border-b text-center font-medium toggle-column purok-col">Reason</th>
                        <th class="py-2 px-2 border-b text-center font-medium toggle-column barangay-col">Processed By</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($transfers as $transfer)
                            <tr>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap">
                                    {{ $transfer->transfer_date->format('M d, Y') }}
                                </td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap name-col">
                                    {{ $transfer->previousAwardee->taggedAndValidatedApplicant->applicant->person->full_name }}
                                </td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap suffix-col">
                                    {{ $transfer->remarks }}
                                </td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap suffix-col">
                                    {{ $transfer->relationship }}
                                </td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap contact-col">
                                    {{ $transfer->previousAwardee->relocationLot->relocation_site_name }}
                                </td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap purok-col">
                                    {{ $transfer->transfer_reason }}
                                </td>
                                <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap barangay-col">
                                    {{ $transfer->processor->first_name }} {{ $transfer->processor->last_name }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-4 px-2 text-center border-b">No transfer history found.</td>
                            </tr>
                        @endforelse
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