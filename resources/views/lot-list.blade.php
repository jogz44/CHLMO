<x-app-layout>
    <div x-data="{ openFilters: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
        <div class="flex bg-gray-100 text-[12px]">
            <!-- Main Content -->
            <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">
                <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-50 relative p-3">
                    <div class="flex items-center">
                        <h2 class="text-[13px] ml-5 text-gray-700">LOT LIST</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                    <div x-data="{ openModalLot: false}" class="relative z-0">
                        <button @click="openModalLot = true" class="bg-custom-yellow text-white px-4 py-2 rounded">Add Lot
                        </button>
                        <button class="bg-custom-green text-white px-4 py-2 rounded">Export</button>

                        <div x-show="openModalLot"
                            class="fixed z-50 inset-0 flex items-center justify-center bg-black bg-opacity-50" x-cloak
                            style="font-family: 'Poppins', sans-serif;">
                            <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-md font-semibold text-black">ADD LOT</h3>
                                    <button @click="openModalLot = false" class="text-gray-400 hover:text-gray-200">
                                        &times;
                                    </button>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="barangay">LOT/RELOCATION
                                        NAME</label>
                                    <input type="text" id="lotname"
                                        class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                                        placeholder="Barangay">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black"
                                        for="barangay">BARANGAY</label>
                                    <input type="text" id="barangay"
                                        class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                                        placeholder="Barangay">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black"
                                        for="purok">PUROK</label>
                                    <input type="text" id="purok"
                                        class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                                        placeholder="Purok">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="total-lotsize">TOTAL
                                        LOT SIZE</label>
                                    <input type="text" id="total-lotsize"
                                        class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                                        placeholder="Total Lot Size">
                                </div>
                                <br>
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <button type="submit"
                                        class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                        <span class="text-[12px]">ADD</span>
                                    </button>
                                    <!-- Cancel Button -->
                                    <button type="submit"
                                        class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                        <span @click="openModalLot = false" class="text-[12px]">CANCEL</span>
                                    </button>
                                </div>
                            </div>
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
                                <input type="search" name="search" id="search"
                                    class="rounded-md px-12 py-2 placeholder:text-[13px] z-10 border border-gray-300 bg-[#f7f7f9] hover:ring-custom-yellow focus:ring-custom-yellow"
                                    placeholder="Search">
                            </div>
                        </div>
                    </div>

                    <div x-show="openFilters" class="flex space-x-2 mb-1 mt-5">
                        <label class="text-center mt-2">Date From:</label>
                        <input type="date" id="start-date" class="border text-[13px] border-gray-300 rounded px-2 py-1">
                        <label class="text-center mt-2">To:</label>
                        <input type="date" id="end-date" class="border text-[13px] border-gray-300 rounded px-2 py-1">
                        <select class="border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">Purok</option>
                            <option value="purok1">Purok 1</option>
                            <option value="purok2">Purok 2</option>
                            <option value="purok3">Purok 3</option>
                        </select>
                        <select class="border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">Barangay</option>
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

                        <button class="bg-custom-yellow text-white px-4 py-2 rounded">Apply Filters</button>
                    </div>
                </div>

                <!-- Table -->
                <div x-data="{openModalEditLot: false}" class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-2  text-center font-medium">Name</th>
                                <th class="py-2 px-2 border-b text-center  font-medium">Purok</th>
                                <th class="py-2 px-2 border-b text-center font-medium">Barangay</th>
                                <th class="py-2 px-2 border-b text-center font-medium">Status</th>
                                <th class="py-2 px-2 border-b text-center font-medium">No. of Awardees</th>
                                <th class="py-2 px-2 border-b text-center font-medium">Total Lot Size</th>
                                <th class="py-2 px-2 border-b text-center font-medium"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-2 text-center  border-b"></td>
                                <td class="py-2 px-2 text-center border-b"></td>
                                <td class="py-2 px-2 text-center border-b"></td>
                                <td class="py-2 px-2 text-center border-b"></td>
                                <td class="py-2 px-2 text-center border-b space-x-2">
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">Canocotan Relocation Site</td>
                                <td class="py-4 px-2 text-center border-b">Suaybaguio</td>
                                <td class="py-4 px-2 text-center border-b">Magugpo North</td>
                                <td class="py-4 px-2 text-center border-b">Full</td>
                                <td class="py-4 px-2 text-center border-b">60</td>
                                <td class="py-2 px-2 text-center border-b">80ha</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button
                                        @click="window.location.href = '{{ route('lot-list-details') }}'"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Details
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">Canocotan Relocation Site</td>
                                <td class="py-4 px-2 text-center border-b">Suaybaguio</td>
                                <td class="py-4 px-2 text-center border-b">Magugpo North</td>
                                <td class="py-4 px-2 text-center border-b">Available</td>
                                <td class="py-4 px-2 text-center border-b">60</td>
                                <td class="py-2 px-2 text-center border-b">100ha</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button
                                        @click="window.location.href = '{{ route('lot-list-details') }}'"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Details
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">Canocotan Relocation Site</td>
                                <td class="py-4 px-2 text-center border-b">Suaybaguio</td>
                                <td class="py-4 px-2 text-center border-b">Magugpo North</td>
                                <td class="py-4 px-2 text-center border-b">Full</td>
                                <td class="py-4 px-2 text-center border-b">60</td>
                                <td class="py-2 px-2 text-center border-b">80ha</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button
                                        @click="window.location.href = '{{ route('lot-list-details') }}'"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Details
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">Canocotan Relocation Site</td>
                                <td class="py-4 px-2 text-center border-b">Suaybaguio</td>
                                <td class="py-4 px-2 text-center border-b">Magugpo North</td>
                                <td class="py-4 px-2 text-center border-b">Full</td>
                                <td class="py-4 px-2 text-center border-b">60</td>
                                <td class="py-2 px-2 text-center border-b">80ha</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button
                                        @click="window.location.href = '{{ route('lot-list-details') }}'"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Details
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">Canocotan Relocation Site</td>
                                <td class="py-4 px-2 text-center border-b">Suaybaguio</td>
                                <td class="py-4 px-2 text-center border-b">Magugpo North</td>
                                <td class="py-4 px-2 text-center border-b">Full</td>
                                <td class="py-4 px-2 text-center border-b">60</td>
                                <td class="py-2 px-2 text-center border-b">80ha</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button
                                        @click="window.location.href = '{{ route('lot-list-details') }}'"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Details
                                    </button>
                                </td>
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
            </div>
        </div>
    </div>
    </div>
</x-app-layout>