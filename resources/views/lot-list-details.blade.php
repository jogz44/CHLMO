<x-app-layout>
    <div x-data="{ openFilters: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
        <div class="flex bg-gray-100 text-[12px]">
            <div x-data="{ isEditable: false }" class="flex-1 p-6 overflow-auto">
                <div class="bg-white rounded shadow mb-4 flex items-center justify-between p-3 fixed top-[80px] left-[20%] right-[3%] z-50">
                    <div class="flex items-center">
                        <a href="{{ route('transaction-walkin') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-custom-yellow mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <h2 class="text-[13px] ml-2 items-center text-gray-700">Lot Details</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design"
                        class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                    <div x-data="{ openModalLot: false}" class="flex space-x-2 z-0">
                        <button @click="openModalLot = true" class="bg-custom-yellow text-white px-4 py-2 rounded">Add Lot</button>
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
                                    <label class="block text-[12px] font-medium mb-2 text-black"
                                        for="barangay">LOT NUMBER</label>
                                    <input type="text" id="barangay"
                                        class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                                        placeholder="Lot Number">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="total-lotsize">LOT SIZE</label>
                                    <input type="text" id="total-lotsize"
                                        class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                                        placeholder="Lot Size">
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

                <div class="flex flex-col p-3 rounded mt-5">
                    <h2 class="text-[13px] ml-2 items-center font-bold text-gray-700">CANOCOTAN RELOCATION SITE</h2>
                    <p class="text-[12px] ml-2 items-center text-gray-700">Purok 2-A Tandang Sora, Canocotan, Tagum City</p>
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
                                <th class="py-2 px-2  text-center font-medium">Lot Number</th>
                                <th class="py-2 px-2 border-b text-center  font-medium">Occupant</th>
                                <th class="py-2 px-2 border-b text-center font-medium">Lot Size</th>
                                <th class="py-2 px-2 border-b text-center font-medium">Status</th>
                                <th class="py-2 px-2 border-b text-center font-medium"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">Lot 1</td>
                                <td class="py-4 px-2 text-center border-b">April Boy Regino</td>
                                <td class="py-4 px-2 text-center border-b">60 sqm.</td>
                                <td class="py-4 px-2 text-center border-b">Occupied</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button
                                        @click="openModalEditLot = true"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Edit
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">Lot 2</td>
                                <td class="py-4 px-2 text-center border-b">n/a</td>
                                <td class="py-4 px-2 text-center border-b">60 sqm.</td>
                                <td class="py-4 px-2 text-center border-b">Available</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button
                                        @click="openModalEditLot = true"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Edit
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">Lot 3</td>
                                <td class="py-4 px-2 text-center border-b">n/a</td>
                                <td class="py-4 px-2 text-center border-b">60 sqm.</td>
                                <td class="py-4 px-2 text-center border-b">Available</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button
                                        @click="openModalEditLot = true"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Edit
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">Lot 4</td>
                                <td class="py-4 px-2 text-center border-b">Hannagene Daluro</td>
                                <td class="py-4 px-2 text-center border-b">60 sqm.</td>
                                <td class="py-4 px-2 text-center border-b">Occupied</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button
                                        @click="openModalEditLot = true"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Edit
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">Lot 5</td>
                                <td class="py-4 px-2 text-center border-b">Nova Grace Palmes</td>
                                <td class="py-4 px-2 text-center border-b">60 sqm.</td>
                                <td class="py-4 px-2 text-center border-b">Occupied</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button
                                        @click="openModalEditLot = true"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Edit
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div x-show="openModalEditLot"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak
                        style="font-family: 'Poppins', sans-serif;">
                        <!-- Modal -->
                        <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-md font-semibold text-black">EDIT LOT</h3>
                                <button @click="openModalEditLot = false" class="text-gray-400 hover:text-gray-200">
                                    &times;
                                </button>
                            </div>

                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                    for="barangay">LOT NUMBER</label>
                                <input type="text" id="barangay"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-white focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                                    placeholder="Barangay">
                            </div>

                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="purok">OCCUPANT</label>
                                <input type="text" id="purok"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-white focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                                    placeholder="Purok">
                            </div>

                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="total-lotsize">LOT SIZE</label>
                                <input type="text" id="total-lotsize"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-white focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                                    placeholder="Total Lot Size">
                            </div>

                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="status">STATUS</label>
                                <select class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-white focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" placeholder="Status">
                                    <option value="occupied">OCCUPIED</option>
                                    <option value="vacant">VACANT</option>
                                </select>       
                            </div>

                            <br>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <button type="submit"
                                    class="w-full py-2 bg-yellow-500 hover:bg-yellow-400 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                    <span class="text-[12px]">SAVE</span>
                                </button>
                                <!-- Cancel Button -->
                                <button type="submit"
                                    class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                    <span class="text-[12px]">CANCEL</span>
                                </button>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

</x-app-layout>