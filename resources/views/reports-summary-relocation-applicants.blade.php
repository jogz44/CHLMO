<x-app-layout>
    <div x-data="{ openFilters: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
        <div class="flex bg-gray-100 text-[12px]">
            <!-- Main Content -->
            <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">
                <div class="bg-white rounded shadow mb-6 flex items-center justify-between relative p-3">
                    <div class="flex items-center">
                        <h2 class="text-[13px] ml-2 items-center text-gray-700">REPORTS</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design"
                        class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                    <div x-data="{ selectedReport: '' }" class="flex space-x-2 z-0">
                        <select @change="window.location.href = selectedReport" x-model="selectedReport"
                            class="w-full px-3 py-3 bg-transparent border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                            style="padding: 4px 4px;">
                            <option value="" default>Reports</option>
                            <option value="/reports-summary-informal-settlers" >Summary of
                                Identified Informal Settlers
                            </option>
                            <option value="/reports-summary-relocation-applicants" selected>Relocation
                                Applicant Summary
                            </option>
                        </select>
                        <button class="bg-custom-green text-white px-4 py-2 rounded">Export</button>
                    </div>
                </div>

                <div class="flex items-center mb-2 ml-2">
                    <h2 class="text-[14px] font-semibold items-center text-gray-700">Relocation
                    Applicant Summary</h2>
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
                        <button class="bg-custom-yellow text-white px-4 py-2 rounded">Apply Filters</button>
                    </div>
                </div>

                    <!-- Table with transaction requests -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-10 font-semibold  text-center">Relocation Lot Applicants</th>
                                <th class="py-2 px-10 border-b text-center  font-medium">No. of Applicants</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="py-2 px-2 text-center  border-b font-semibold">Walkin Applicants</td>
                                <td class="py-2 px-2 border-b text-center font-medium"> 21008</td>

                            </tr>
                            <tr>
                                <td class="py-2 px-2 text-center  border-b font-semibold">Tagged and Validated</td>
                                <td class="py-2 px-2 border-b text-center font-medium"> 12567</td>

                            </tr>
                            <tr>
                                <td class="py-2 px-2 text-center  border-b font-semibold">Identified Informal Settlers</td>
                                <td class="py-2 px-2 border-b text-center font-medium">8767</td>

                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b font-semibold"></td>
                                <td class="py-4 px-2 b text-center border-b font-medium"></td>

                            </tr>
                            <tr>
                                <td class="py-2 px-2 text-center  border-b font-semibold">Total Number Relocation Lot
                                    Applicants
                                </td>
                                <td class="py-2 px-2 border-b text-center font-medium"> 10873</td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>