<x-adminshelter-layout>
    <div x-data="{ openFilters: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
        <div class="flex bg-gray-100 text-[12px]">
            <!-- Main Content -->
            <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">
                <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-5 relative p-3">
                    <div class="flex items-center">
                        <h2 class="text-[13px] ml-5 text-gray-700">SHELTER ASSISTANCE APPLICANTS — PROFILED/TAGGED</h2>
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
                        <input type="date" id="start-date" class="border text-[13px] border-gray-300 rounded px-2 py-1">
                        <label class="text-center mt-2">To:</label>
                        <input type="date" id="end-date" class="border text-[13px] border-gray-300 rounded px-2 py-1">
                        <select class="border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">Select</option>
                            <option value="purok1">Date Request</option>
                            <option value="purok2">Date Profiled/tagged</option>
                            <option value="purok3">Delivery Date</option>
                        </select>
                        <select class="border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">Origin of Request</option>
                            <option value="barangay1">All</option>
                            <option value="barangay1">CMO</option>
                            <option value="barangay2">SPMO</option>
                            <option value="barangay3">Walk-in</option>
                            <option value="barangay3">Barangay</option>
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
                                <th class="py-2 px-2  text-center font-medium">Profile No.</th>
                                <th class="py-2 px-2 border-b text-center  font-medium">Last Name</th>
                                <th class="py-2 px-2 border-b text-center font-medium">First Name</th>
                                <th class="py-2 px-2 border-b text-center font-medium">Middle Name</th>
                                <th class="py-2 px-2 border-b text-center font-medium">Origin of Request</th>
                                <th class="py-2 px-2 border-b text-center font-medium">Date Request</th>
                                <th class="py-2 px-2 border-b text-center font-medium">Date Profiled/Tagged</th>
                                <th class="py-2 px-2 border-b text-center font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody x-data>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">2022-00002</td>
                                <td class="py-4 px-2 text-center border-b">Doe</td>
                                <td class="py-4 px-2 text-center border-b">Jane</td>
                                <td class="py-4 px-2 text-center border-b">Dove</td>
                                <td class="py-4 px-2 text-center border-b">Barangay</td>
                                <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                                <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button
                                        @click="window.location.href = '{{ route('shelter-applicant-details') }}'"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Details
                                    </button>
                                    <button @click="openModalGrant = true"
                                        class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-8 py-1.5 rounded-full">Grant
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">2024-00002</td>
                                <td class="py-4 px-2 text-center border-b">Cruz</td>
                                <td class="py-4 px-2 text-center border-b">Anastacia</td>
                                <td class="py-4 px-2 text-center border-b">De Guzman</td>
                                <td class="py-4 px-2 text-center border-b">CMO</td>
                                <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                                <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button
                                        @click="window.location.href = '{{ route('shelter-applicant-details') }}'"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Details
                                    </button>
                                    <button @click="openModalGrant = true"
                                        class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-8 py-1.5 rounded-full">Grant
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">2023-00003</td>
                                <td class="py-4 px-2 text-center border-b">Dagan</td>
                                <td class="py-4 px-2 text-center border-b">John Lloyd</td>
                                <td class="py-4 px-2 text-center border-b">Aborin</td>
                                <td class="py-4 px-2 text-center border-b">SPMO</td>
                                <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                                <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button
                                        @click="window.location.href = '{{ route('shelter-applicant-details') }}'"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Details
                                    </button>
                                    <button @click="openModalGrant = true"
                                        class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-8 py-1.5 rounded-full">Grant
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">2024-00005</td>
                                <td class="py-4 px-2 text-center border-b">Sison</td>
                                <td class="py-4 px-2 text-center border-b">Dave John</td>
                                <td class="py-4 px-2 text-center border-b">Yael</td>
                                <td class="py-4 px-2 text-center border-b">Walk=in</td>
                                <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                                <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button
                                        @click="window.location.href = '{{ route('shelter-applicant-details') }}'"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Details
                                    </button>
                                    <button @click="openModalGrant = true"
                                        class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-8 py-1.5 rounded-full">Grant
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">2021-00001</td>
                                <td class="py-4 px-2 text-center border-b">Duno</td>
                                <td class="py-4 px-2 text-center border-b">Harold</td>
                                <td class="py-4 px-2 text-center border-b">Alison</td>
                                <td class="py-4 px-2 text-center border-b">SPMO</td>
                                <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                                <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button
                                        @click="window.location.href = '{{ route('shelter-applicant-details') }}'"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Details
                                    </button>
                                    <button @click="openModalGrant = true"
                                        class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-8 py-1.5 rounded-full">Grant
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- GRANT Modal -->
                    <div x-show="openModalGrant"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 shadow-lg"
                        x-cloak style="font-family: 'Poppins', sans-serif;">
                        <div class="bg-white text-white w-[500px] rounded-lg shadow-lg p-6 relative">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-black">GRANT APPLICANT</h3>
                                <button @click="openModalGrant = false" class="text-gray-400 hover:text-gray-200">
                                    &times;
                                </button>
                            </div>

                            <!-- Form -->
                            <form @submit.prevent>
                                <div class="flex flex-wrap -mx-2">
                                    <!-- Tagging and Validation Date Field -->
                                    <div class="w-full md:w-1/2 px-2 mb-4">
                                        <label class="block text-[12px] font-medium mb-2 text-black"
                                            for="delivery-date">DATE OF DELIVERY</label>
                                        <input type="date" id="delivery-date"
                                            class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]">
                                    </div>
                                    <div class="w-full md:w-1/2 px-2 mb-4">
                                        <label class="block text-[12px] font-medium mb-2 text-black"
                                            for="irs-date">DATE OF IRS</label>
                                        <input type="date" id="irs-date"
                                            class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]">
                                    </div>

                                </div>
                                <label class="block text-[13px] font-medium text-gray-700 mb-4">MATERIALS DELIVERED</label>
                                <div x-data="{ materials: [{ material: '', qty: '', poNum: '' }], addMaterial() {this.materials.push({ material: '', qty: '', poNum: '' });}}">
                                    <template x-for="(material, index) in materials" :key="index">
                                        <div class="flex flex-wrap -mx-2 mb-1">
                                            <!-- Material Select -->
                                            <div class="w-full md:w-2/4 px-2 mb-2">
                                                <label for="material"
                                                    class="block text-[13px] font-medium text-gray-700 mb-1">MATERIAL</label>
                                                <select x-model="material.material"
                                                    class="uppercase w-full p-1 border text-[13px] border-gray-600 rounded-lg focus:outline-none focus:ring-custom-yellow">
                                                    <option value="">Select Material</option>
                                                    <option value="barangay1">Barangay 1</option>
                                                </select>
                                            </div>

                                            <!-- Quantity Input -->
                                            <div class="w-full md:w-1/4 px-2 mb-2">
                                                <label class="block text-[12px] font-medium mb-2 text-black" for="qty">QUANTITY</label>
                                                <input type="number" x-model="material.qty"
                                                    class="uppercase w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px]"
                                                    placeholder="Quantity">
                                            </div>

                                            <!-- PO Number Select -->
                                            <div class="w-full md:w-1/4 px-2 mb-2">
                                                <label class="block text-[12px] font-medium mb-2 text-black" for="PoNum">PO NUMBER</label>
                                                <select x-model="material.poNum"
                                                    class="uppercase w-full p-1 border text-[13px] border-gray-600 rounded-lg focus:outline-none focus:ring-custom-yellow">
                                                    <option value="">Select</option>
                                                    <option value="barangay1">Barangay 1</option>
                                                </select>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Add Button -->
                                    <div class="flex justify-center mt-4">
                                        <button type="button" @click="addMaterial"
                                            class="px-3 py-1 bg-custom-yellow text-white rounded-md text-xs hover:bg-custom-yellow">
                                            ADD
                                        </button>
                                    </div>
                                </div>


                                <!-- House Situation Upload -->
                                <h2 class="block text-[12px] font-medium mb-2 text-black">UPLOAD HOUSE SITUATION</h2>

                                <!-- Drag and Drop Area -->
                                <div class="border-2 border-dashed border-green-500 rounded-lg p-4 flex flex-col items-center space-y-1">
                                    <svg class="w-10 h-10 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 15a4 4 0 011-7.874V7a5 5 0 018.874-2.485A5.5 5.5 0 1118.5 15H5z" />
                                    </svg>
                                    <p class="text-gray-500 text-xs">DRAG AND DROP FILES</p>
                                    <p class="text-gray-500 text-xs">or</p>
                                    <button type="button"
                                        class="px-3 py-1 bg-green-600 text-white rounded-md text-xs hover:bg-green-700"
                                        @click="$refs.fileInput.click()">BROWSE FILES
                                    </button>

                                    <!-- Hidden File Input -->
                                    <input type="file" x-ref="fileInput"
                                        @change="selectedFile = $refs.fileInput.files[0]; fileName = selectedFile.name"
                                        class="hidden" />
                                </div>

                                <!-- Show selected file and progress bar when a file is selected -->
                                <template x-if="selectedFile">
                                    <div @click="openPreviewModal = true" class="mt-4 bg-white p-2 rounded-lg shadow">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-orange-500" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M7 3v6h4l1 1h4V3H7z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 8v10h14V8H5z" />
                                                </svg>
                                                <span class="text-xs font-medium text-gray-700"
                                                    x-text="fileName"></span>

                                            </div>
                                            <!-- Status -->
                                            <span class="text-xs text-green-500 font-medium">100%</span>
                                        </div>
                                        <!-- Progress Bar -->
                                        <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden cursor-pointer">
                                            <div class="w-full h-full bg-green-500"></div>
                                        </div>
                                    </div>
                                </template>

                                <!-- Buttons -->
                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <button type="submit"
                                        class="w-full py-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white font-semibold rounded-lg">
                                        GRANT APPLICANT
                                    </button>
                                    <button type="button" @click="openModalGrant = false"
                                        class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg">
                                        CANCEL
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Preview Modal (Triggered by Clicking the Progress Bar) -->
                    <div x-show="openPreviewModal"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 shadow-lg"
                        x-cloak>
                        <div class="bg-white w-[600px] rounded-lg shadow-lg p-6 relative">
                            <!-- Modal Header with File Name -->
                            <div class="flex justify-between items-center mb-4">
                                <input type="text" x-model="fileName"
                                    class="text-[13px] w-[60%] font-regular text-black border-none focus:outline-none focus:ring-0">
                                <button class="text-orange-500 underline text-sm"
                                    @click="fileName = prompt('Rename File', fileName) || fileName">Rename File
                                </button>
                                <button @click="openPreviewModal = false" class="text-gray-400 hover:text-gray-200">
                                    &times;
                                </button>
                            </div>

                            <!-- Display Image -->
                            <div class="flex justify-center mb-4">
                                <img :src="selectedFile ? URL.createObjectURL(selectedFile) : '/path/to/default/image.jpg'"
                                    alt="Preview Image" class="w-full h-auto max-h-[60vh] object-contain">
                            </div>
                            <!-- Modal Buttons -->
                            <div class="flex justify-between mt-4">
                                <button class="px-4 py-2 bg-green-600 text-white rounded-lg"
                                    @click="openPreviewModal = false">CONFIRM
                                </button>
                                <button class="px-4 py-2 bg-red-600 text-white rounded-lg"
                                    @click="selectedFile = null; openPreviewModal = false">REMOVE
                                </button>
                            </div>
                        </div>
                    </div>
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