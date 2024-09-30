<x-adminshelter-layout>
    <div x-data="{ openFilters: false, openModal: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
        <div class="flex bg-gray-100 text-[12px]">
            <!-- Main Content -->
            <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">


                <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-0 relative p-3">
                    <div class="flex items-center">
                        <h2 class="text-[13px] ml-5 text-gray-700">SHELTER ASSISTANCE PROGRAM APPLICANTS</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                    <div class="relative">
                        <button @click="openModal = true" class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white px-4 py-2 rounded">Add
                            Applicant
                        </button>
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
                            <div class="flex relative z-10 md:block border-gray-300">
                                <svg class="absolute top-[13px] left-4" width="19" height="19" viewBox="0 0 21 21"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.625 16.625C13.491 16.625 16.625 13.491 16.625 9.625C16.625 5.75901 13.491 2.625 9.625 2.625C5.75901 2.625 2.625 5.75901 2.625 9.625C2.625 13.491 5.75901 16.625 9.625 16.625Z"
                                        stroke="#787C7F" stroke-width="1.75" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M18.3746 18.375L14.5684 14.5688" stroke="#787C7F" stroke-width="1.75"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <input type="search" name="search" id="search"
                                    class="uppercase rounded-md px-12 py-2 placeholder:text-[13px] border border-gray-300 bg-[#f7f7f9] hover:ring-custom-yellow focus:ring-custom-yellow"
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
                <div x-data="{openModalEdit: false}"
                    class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-2  text-center font-medium">Profile No.</th>
                                <th class="py-2 px-2 border-b text-center  font-medium">Last Name</th>
                                <th class="py-2 px-2 border-b text-center font-medium">First Name</th>
                                <th class="py-2 px-2 border-b text-center font-medium">Middle Name</th>
                                <th class="py-2 px-2 border-b text-center font-medium">Date Request</th>
                                <th class="py-2 px-2 border-b text-center font-medium">Origin of Request</th>
                                <th class="py-2 px-2 border-b text-center font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody x-data>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">2022-00002</td>
                                <td class="py-4 px-2 text-center border-b">Doe</td>
                                <td class="py-4 px-2 text-center border-b">Jane</td>
                                <td class="py-4 px-2 text-center border-b">Dove</td>
                                <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                                <td class="py-4 px-2 text-center border-b">CMO</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button @click="openModalEdit = true"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Edit
                                    </button>
                                    <button
                                        @click="window.location.href = '{{ route('shelter-tag-applicant') }}'"
                                        class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-8 py-1.5 rounded-full">Tag
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">2024-00002</td>
                                <td class="py-4 px-2 text-center border-b">Cruz</td>
                                <td class="py-4 px-2 text-center border-b">Anastacia</td>
                                <td class="py-4 px-2 text-center border-b">De Guzman</td>
                                <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                                <td class="py-4 px-2 text-center border-b">Barangay</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button @click="openModalEdit = true"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Edit
                                    </button>
                                    <button
                                        @click="window.location.href = '{{ route('shelter-tag-applicant') }}'"
                                        class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-8 py-1.5 rounded-full">Tag
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">2023-00003</td>
                                <td class="py-4 px-2 text-center border-b">Dagan</td>
                                <td class="py-4 px-2 text-center border-b">John Lloyd</td>
                                <td class="py-4 px-2 text-center border-b">Aborin</td>
                                <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                                <td class="py-4 px-2 text-center border-b">SPMO</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button @click="openModalEdit = true"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Edit
                                    </button>
                                    <button
                                        @click="window.location.href = '{{ route('shelter-tag-applicant') }}'"
                                        class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-8 py-1.5 rounded-full">Tag
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">2024-00005</td>
                                <td class="py-4 px-2 text-center border-b">Sison</td>
                                <td class="py-4 px-2 text-center border-b">Dave John</td>
                                <td class="py-4 px-2 text-center border-b">Yael</td>
                                <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                                <td class="py-4 px-2 text-center border-b">Walk=in</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button @click="openModalEdit = true"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Edit
                                    </button>
                                    <button
                                        @click="window.location.href = '{{ route('shelter-tag-applicant') }}'"
                                        class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-8 py-1.5 rounded-full">Tag
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-2 text-center  border-b">2021-00001</td>
                                <td class="py-4 px-2 text-center border-b">Duno</td>
                                <td class="py-4 px-2 text-center border-b">Harold</td>
                                <td class="py-4 px-2 text-center border-b">Alison</td>
                                <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                                <td class="py-4 px-2 text-center border-b">SPMO</td>
                                <td class="py-4 px-2 text-center border-b space-x-2">
                                    <button @click="openModalEdit = true"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Edit
                                    </button>
                                    <button
                                        @click="window.location.href = '{{ route('shelter-tag-applicant') }}'"
                                        class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-8 py-1.5 rounded-full">Tag
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- EDIT APPLICANT MODAL -->
                    <div x-show="openModalEdit"
                        class="fixed inset-0 flex z-50 items-center justify-center w-full bg-black bg-opacity-50 shadow-lg"
                        x-cloak>
                        <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-black">EDIT APPLICANT</h3>
                                <button @click="openModalEdit = false" class="text-gray-400 hover:text-gray-200">
                                    &times;
                                </button>
                            </div>

                            <!-- Form -->
                            <form>
                                <div>
                                    <label class="block  text-[12px] font-medium mb-2 text-black"
                                        for="profile-no">PROFILE FORM NO.</label>
                                    <input type="text" id="profile-no"
                                        class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-custom-red text-[12px]"
                                        placeholder="Profile Form No" value="2022-00002	">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="date-applied">DATE OF REQUEST</label>
                                    <input type="date" id="date-applied"
                                        class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-1 focus:ring-custom-red text-[12px]"
                                        placeholder="Date Applied" value="2023-11-23">
                                </div>
                                <!-- Main Fields -->
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <!-- First Name Field -->
                                    <div>
                                        <label class="block  text-[12px] font-medium mb-2 text-black"
                                            for="first-name">FIRST NAME</label>
                                        <input type="text" id="first-name"
                                            class="uppercase w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-custom-red text-[12px]"
                                            placeholder="First Name" value="Jane">
                                    </div>

                                    <!-- Middle Name Field -->
                                    <div>
                                        <label class="block  text-[12px] font-medium mb-2 text-black"
                                            for="middle-name">MIDDLE NAME</label>
                                        <input type="text" id="middle-name"
                                            class="uppercase w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-custom-red text-[12px]"
                                            placeholder="Middle Name" value="Dove">
                                    </div>

                                    <!-- Last Name Field -->
                                    <div>
                                        <label class="block  text-[12px] font-medium mb-2 text-black"
                                            for="last-name">LAST NAME</label>
                                        <input type="text" id="last-name"
                                            class="uppercase w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-custom-red text-[12px]"
                                            placeholder="Last Name" value="Doe">
                                    </div>

                                    <!-- Suffix Name Field -->
                                    <div>
                                        <label class="block  text-[12px] font-medium mb-2 text-black"
                                            for="suffix-name">SUFFIX NAME</label>
                                        <input type="text" id="suffix-name"
                                            class="uppercase w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-custom-red text-[12px] "
                                            placeholder="Suffix Name">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="interviewer">ORIGIN OF REQUEST</label>
                                    <input type="text" id="origin-of-request"
                                        class="uppercase w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-custom-red text-[12px]"
                                        placeholder="Select Origin of Request" value="CMO">
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <button type="submit"
                                        class="w-full py-2 bg-custom-green hover:bg-custom-red text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                        <span class="text-sm"> SAVE </span>
                                    </button>

                                    <button type="submit"
                                        @click="openModalEdit = false"
                                        class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                        <span class="text-[12px]">CANCEL</span>
                                    </button>
                                </div>
                            </form>
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

        <!-- ADD APPLICANT MODAL -->
        <div x-show="openModal"
            class="fixed inset-0 flex z-50 items-center justify-center w-full bg-black bg-opacity-50 shadow-lg"
            x-cloak>
            <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-black">ADD APPLICANT</h3>
                    <button @click="openModal = false" class="text-gray-400 hover:text-gray-200">
                        &times;
                    </button>
                </div>

                <!-- Form -->
                <form>
                    <div>
                        <label class="block  text-[12px] font-medium mb-2 text-black"
                            for="profile-no">PROFILE FORM NO.</label>
                        <input type="text" id="profile-no"
                            class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-custom-red text-[12px]"
                            placeholder="Profile Form No">
                    </div>
                    <div class="mb-4">
                        <label class="block text-[12px] font-medium mb-2 text-black" for="date-applied">DATE OF REQUEST</label>
                        <input type="date" id="date-applied"
                            class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-1 focus:ring-custom-red text-[12px]"
                            placeholder="Date Applied">
                    </div>
                    <!-- Main Fields -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <!-- First Name Field -->
                        <div>
                            <label class="block  text-[12px] font-medium mb-2 text-black"
                                for="first-name">FIRST NAME</label>
                            <input type="text" id="first-name"
                                class="uppercase w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-custom-red text-[12px] "
                                placeholder="First Name">
                        </div>

                        <!-- Middle Name Field -->
                        <div>
                            <label class="block  text-[12px] font-medium mb-2 text-black"
                                for="middle-name">MIDDLE NAME</label>
                            <input type="text" id="middle-name"
                                class="uppercase w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-custom-red text-[12px] "
                                placeholder="Middle Name">
                        </div>

                        <!-- Last Name Field -->
                        <div>
                            <label class="block  text-[12px] font-medium mb-2 text-black"
                                for="last-name">LAST NAME</label>
                            <input type="text" id="last-name"
                                class="uppercase w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-custom-red text-[12px] "
                                placeholder="Last Name">
                        </div>

                        <!-- Suffix Name Field -->
                        <div>
                            <label class="block  text-[12px] font-medium mb-2 text-black"
                                for="suffix-name">SUFFIX NAME</label>
                            <input type="text" id="suffix-name"
                                class="uppercase w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-custom-red text-[12px] "
                                placeholder="Suffix Name">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-[12px] font-medium mb-2 text-black" for="interviewer">ORIGIN OF REQUEST</label>
                            <select  class="uppercase w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-custom-red text-[12px]"
                            placeholder="Select Origin of Request">
                                <option value="">Select Origin of Request</option>
                                <option value="">CMO</option>
                                <option value="">SPMO</option>
                                <option value="">Walk-in</option>
                                <option value="">Barangay</option>
                            </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <!-- Award Button -->
                        <button type="submit"
                            class="w-full py-2 bg-custom-green hover:bg-custom-red text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                            <span class="text-sm"> + ADD APPLICANT</span>
                        </button>

                        <!-- Cancel Button -->
                        <button type="submit"
                            class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                            <span class="text-[12px]">CANCEL</span>
                        </button>
                    </div>
                </form>
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