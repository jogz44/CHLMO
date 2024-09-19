<x-app-layout>
    <div class="p-10 h-screen ml-[17%] mt-[60px]">
        <div class="flex bg-gray-100 text-[12px]">
            <!-- Main Content -->
            <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">
                <div class="bg-white rounded shadow mb-4 flex items-center justify-between">
                    <h2 class="text-[13px] ml-5 text-gray-700">ACTIVITY LOGS</h2>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="h-full object-cover">
                </div>

                <div x-data="fileUpload()" class="bg-white p-6 rounded shadow">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex space-x-2">
                            <!-- Search -->
                            <div class="relative hidden md:block">
                                <svg class="absolute top-[13px] left-4" width="19" height="19" viewBox="0 0 21 21"
                                     fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.625 16.625C13.491 16.625 16.625 13.491 16.625 9.625C16.625 5.75901 13.491 2.625 9.625 2.625C5.75901 2.625 2.625 5.75901 2.625 9.625C2.625 13.491 5.75901 16.625 9.625 16.625Z"
                                          stroke="#787C7F" stroke-width="1.75" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                    <path d="M18.3746 18.375L14.5684 14.5688" stroke="#787C7F" stroke-width="1.75"
                                          stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <input type="search" name="search" id="search"
                                       class="rounded-md px-12 py-2 placeholder:text-[13px] outline-none border-none z-10 bg-[#f7f7f9] hover:ring-custom-yellow focus:ring-custom-yellow"
                                       placeholder="Search">
                            </div>
                        </div>

                        <!-- filters and button -->
                        <div x-data="{ openModal: false}" class="flex space-x-2">
                            <label for="start-date" class="text-[13px] py-2 font-medium">Date Range:</label>
                            <input type="date" id="start-date" class="border text-[13px] border-gray-300 rounded px-2 py-1">
                            <input type="date" id="end-date" class="border text-[13px] border-gray-300 rounded px-2 py-1">
                            <button class="bg-custom-yellow text-white px-4 py-2 rounded">Filter</button>
                            <button class="bg-custom-green text-white px-4 py-2 rounded">Export</button>
                        </div>
                    </div>

                    <!-- Table with transaction requests -->
                    <div x-data="{openModalTransfer: false, openPreviewModal: false}" class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-2  text-center font-medium">Date & Time</th>
                                <th class="py-2 px-2 border-b text-center  font-medium">User</th>
                                <th class="py-2 px-2 border-b text-center font-medium">Activity Description</th>
                                <th class="py-2 px-2 border-b text-center font-medium">Activity Type</th>
                                <th class="py-2 px-2 border-b text-center font-medium">Additional Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="px-6 py-4 text-center">
                                    <div>5 mins ago</div>
                                    <div>8/27/2024 4:00 pm</div>
                                </td>
                                <td class="px-6 py-4 text-center">Jane Doe</td>
                                <td class="px-6 py-4 text-center">Add Awardee</td>
                                <td class="px-6 py-4 text-center">Approval</td>
                                <td class="px-6 py-4 text-center">Transferred</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-center">
                                    <div>30 mins ago</div>
                                    <div>8/27/2024 4:00 pm</div>
                                </td>
                                <td class="px-6 py-4 text-center">Jane Doe</td>
                                <td class="px-6 py-4 text-center">Data for Lot 0001 updated</td>
                                <td class="px-6 py-4 text-center">Modification</td>
                                <td class="px-6 py-4 text-center">Validated</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-center">
                                    <div>1 hour ago</div>
                                    <div>8/27/2024 4:00 pm</div>
                                </td>
                                <td class="px-6 py-4 text-center">Jane Doe</td>
                                <td class="px-6 py-4 text-center">Update Awardee Profile</td>
                                <td class="px-6 py-4 text-center">Modification</td>
                                <td class="px-6 py-4 text-center">Validated</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-center">
                                    <div>5 mins ago</div>
                                    <div>8/27/2024 4:00 pm</div>
                                </td>
                                <td class="px-6 py-4 text-center">Jane Doe</td>
                                <td class="px-6 py-4 text-center">Add Awardee</td>
                                <td class="px-6 py-4 text-center">Approval</td>
                                <td class="px-6 py-4 text-center">Transferred</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 text-center">
                                    <div>5 mins ago</div>
                                    <div>8/27/2024 4:00 pm</div>
                                </td>
                                <td class="px-6 py-4 text-center">Jane Doe</td>
                                <td class="px-6 py-4 text-center">Add Awardee</td>
                                <td class="px-6 py-4 text-center">Approval</td>
                                <td class="px-6 py-4 text-center">Transferred</td>
                            </tr>
                            </tbody>
                        </table>


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
</x-app-layout>