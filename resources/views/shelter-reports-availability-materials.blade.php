<x-adminshelter-layout>
    <div x-data="{ openFilters: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
        <div class="flex bg-gray-100 text-[12px]">
            <!-- Main Content -->
            <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">
                <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-5 relative p-3">
                    <div class="flex items-center">
                        <h2 class="text-[13px] ml-5 text-gray-700 font-semibold">REPORT ON AVAILABILITY OF MATERIALS UNDER THE SHELTER ASSISTANCE PROGRAM</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                    <div class="relative z-0">
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
                    </div>

                    <div x-show="openFilters" class="flex space-x-2 mb-1 mt-5">
                        <label class="text-center mt-2">Date From:</label>
                        <input type="date" id="start-date" class="border text-[12px] border-gray-300 rounded px-2 py-1">
                        <label class="text-center mt-2">To:</label>
                        <input type="date" id="end-date" class="border text-[12px] border-gray-300 rounded px-2 py-1">
                        <select class="border text-[12px] border-gray-300 text-gray-600 rounded px-1 py-1 shadow-sm">
                            <option value="">BARANGAY</option>
                            <option value="barangay1">All</option>
                            <option value="purok1">BARANGAY 1</option>
                            <option value="purok2">BARANGAY 1</option>
                            <option value="purok3">BARANGAY 1</option>
                        </select>
                        <select class="border text-[12px] border-gray-300 text-gray-600 rounded px-1 py-1 shadow-sm">
                            <option value="">SOCIAL WELFARE SECTOR</option>
                            <option class="text-[11px]" value="barangay1">All</option>
                            <option class="text-[11px]" value="purok1">4P'S</option>
                            <option class="text-[11px]" value="purok2">SENIOR CITIZEN</option>
                            <option class="text-[11px]" value="purok3">SOLO PARENT</option>
                        </select>
                        <select class="border text-[12px] border-gray-300 text-gray-600 rounded px-1 py-1 shadow-sm">
                            <option value="">PO NUMBER</option>
                            <option class="text-[11px]" value="barangay1">All</option>
                            <option class="text-[11px]" value="purok1">PO No. 22-10-0052</option>
                            <option class="text-[11px]" value="purok2">PO No. 23-11-0123</option>
                            <option class="text-[11px]" value="purok3">PO No. 23-11-0252</option>
                        </select>
                        <select class="border text-[12px] border-gray-300 text-gray-600 rounded px-1 py-1 shadow-sm">
                            <option value="">PR NUMBER</option>
                            <option class="text-[11px]" value="barangay1">All</option>
                            <option class="text-[11px]" value="purok1">PR No. 22-10-0052</option>
                            <option class="text-[11px]" value="purok2">PR No. 23-11-0123</option>
                            <option class="text-[11px]" value="purok3">PR No. 23-11-0252</option>
                        </select>
                        <button class="bg-custom-yellow text-white px-4 py-2 rounded">Apply Filters</button>
                    </div>
                </div>


                <!-- Table with transaction requests -->
                <div x-data="{openModalGrant: false, openPreviewModal: false, selectedFile: null, fileName: ''}"
                    class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-[20px]  text-center font-medium whitespace-nowrap">No.</th>
                                <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">DESCRIPTION</th>
                                <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">UNIT</th>
                                <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">TOTAL QUANTITY</th>
                                <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">WITHDRAWAL</th>
                                <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">AVAILABLE MATERIALS</th>
                            </tr>
                        </thead>
                        <tbody x-data>
                            <tr>
                                <td class="py-4 px-2 text-center border-b">1</td>
                                <td class="py-4 px-2 text-center border-b whitespace-nowrap">AMAKAN</td>
                                <td class="py-4 px-2 text-center border-b">SHEETS</td>
                                <td class="py-4 px-2 text-center border-b">100</td>
                                <td class="py-4 px-2 text-center border-b">50</td>
                                <td class="py-4 px-2 text-center border-b">50</td>
                            </tr>
                            <tr>
                            <td class="py-4 px-2 text-center border-b">2</td>
                            <td class="py-4 px-2 text-center border-b whitespace-nowrap">PORTLAND CEMENT</td>
                                <td class="py-4 px-2 text-center border-b">BAGS</td>
                                <td class="py-4 px-2 text-center border-b">50</td>
                                <td class="py-4 px-2 text-center border-b">25</td>
                                <td class="py-4 px-2 text-center border-b">25</td>
                            </tr>
                            <tr>
                            <td class="py-4 px-2 text-center border-b">3</td>
                            <td class="py-4 px-2 text-center border-b whitespace-nowrap">COCO LUMBER 4X4X10</td>
                                <td class="py-4 px-2 text-center border-b">PCS</td>
                                <td class="py-4 px-2 text-center border-b">150</td>
                                <td class="py-4 px-2 text-center border-b">15</td>
                                <td class="py-4 px-2 text-center border-b">135</td>
                            </tr>
                            <tr>
                            <td class="py-4 px-2 text-center border-b">4</td>
                            <td class="py-4 px-2 text-center border-b whitespace-nowrap">COCO LUMBER 2X3X10</td>
                                <td class="py-4 px-2 text-center border-b">PCS</td>
                                <td class="py-4 px-2 text-center border-b">150</td>
                                <td class="py-4 px-2 text-center border-b">130</td>
                                <td class="py-4 px-2 text-center border-b">20</td>
                            </tr>
                            <tr>
                            <td class="py-4 px-2 text-center border-b">5</td>
                            <td class="py-4 px-2 text-center border-b whitespace-nowrap">NAILS - CWN 2 1/2</td>
                                <td class="py-4 px-2 text-center border-b">KLS</td>
                                <td class="py-4 px-2 text-center border-b">250</td>
                                <td class="py-4 px-2 text-center border-b">50</td>
                                <td class="py-4 px-2 text-center border-b">200</td>
                            </tr>
                        </tbody>
                    </table>
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
</x-adminshelter-layout>