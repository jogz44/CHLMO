<x-app-layout>
    <div x-data="{ openModal1: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
        <div class="flex bg-gray-100 text-[12px] mt-5 mb-5">
        </div>
        <div x-data="{
        civilStatuses: [''],
        openModal1: false,
        confirmRemoveIndex: null,
        showConfirmModal: false,
        confirmRemove(index) {
            this.confirmRemoveIndex = index;
            this.showConfirmModal = true;
        },
        removeCivilStatus(index) {
            if (index !== null) {
                this.civilStatuses.splice(index, 1);
                this.confirmRemoveIndex = null;
                this.showConfirmModal = false;
            }
        }
    }">

            <!-- Main Content -->
            <div class="grid grid-cols-4 gap-10 mb-12 mt-10">
                <button @click="openModal1 = true" class="relative cursor-pointer bg-white shadow rounded-lg flex items-center">
                    <div class="flex-shrink-0 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-6 h-6 ml-5 text-custom-yellow" stroke-width="0.5">
                            <path d="M 21 4 C 15.494917 4 11 8.494921 11 14 C 11 19.505079 15.494917 24 21 24 C 26.505083 24 31 19.505079 31 14 C 31 8.494921 26.505083 4 21 4 z M 21 7 C 24.883764 7 28 10.116238 28 14 C 28 17.883762 24.883764 21 21 21 C 17.116236 21 14 17.883762 14 14 C 14 10.116238 17.116236 7 21 7 z M 35 24 C 28.925 24 24 28.925 24 35 C 24 41.075 28.925 46 35 46 C 41.075 46 46 41.075 46 35 C 46 28.925 41.075 24 35 24 z M 9.5 28 C 7.02 28 5 30.02 5 32.5 L 5 33.699219 C 5 39.479219 12.03 44 21 44 C 22.49 44 23.929062 43.870859 25.289062 43.630859 C 24.549063 42.800859 23.910391 41.880859 23.400391 40.880859 C 22.630391 40.960859 21.83 41 21 41 C 12.97 41 8 37.209219 8 33.699219 L 8 32.5 C 8 31.67 8.67 31 9.5 31 L 22.630859 31 C 22.970859 29.93 23.450781 28.93 24.050781 28 L 9.5 28 z M 35 28 C 35.48 28 35.908453 28.305766 36.064453 28.759766 L 37.177734 32 L 40.875 32 C 41.358 32 41.787406 32.308625 41.941406 32.765625 C 42.095406 33.223625 41.939687 33.729484 41.554688 34.021484 L 38.560547 36.292969 L 39.574219 39.539062 C 39.720219 40.005063 39.548391 40.510969 39.150391 40.792969 C 38.955391 40.930969 38.727 41 38.5 41 C 38.263 41 38.025172 40.925391 37.826172 40.775391 L 35 38.660156 L 32.173828 40.775391 C 31.783828 41.068391 31.248609 41.076922 30.849609 40.794922 C 30.451609 40.512922 30.279781 40.005063 30.425781 39.539062 L 31.439453 36.294922 L 28.445312 34.021484 C 28.060312 33.729484 27.904594 33.225578 28.058594 32.767578 C 28.213594 32.309578 28.642 32 29.125 32 L 32.822266 32 L 33.935547 28.759766 C 34.091547 28.305766 34.52 28 35 28 z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 flex flex-col items-start">
                        <p class="text-[13px] text-gray-500">Civil Status</p>
                    </div>
                    <div class="flex-shrink-0">
                        <img src="/storage/images/designDasboard.png" alt="dashboard design" class="w-24 h-20 object-contain rounded-lg">
                    </div>
                </button>

                <!-- Modal -->
                <div x-show="openModal1" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white rounded-lg p-6 w-[400px]">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-md font-semibold text-black">ADD CIVIL STATUS</h3>
                            <button @click="openModal1 = false" class="text-gray-600 hover:text-gray-800">&times;</button>
                        </div>

                        <!-- Modal Body -->
                        <div>
                            <label class="block text-[12px] font-medium mb-2 text-black" for="civil-status">CIVIL STATUS</label>
                            <template x-for="(status, index) in civilStatuses" :key="index">
                                <div class="flex items-center mb-3">
                                    <input type="text" x-model="civilStatuses[index]" placeholder="Civil Status" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" />
                                    <button @click="confirmRemove(index)" class="ml-2 text-red-600 hover:text-red-700">&#x2715;</button>
                                </div>
                            </template>

                            <!-- Add new input button -->
                            <button @click="civilStatuses.push('')" class="w-full py-1 bg-gray-100 shadow-md border-collapse hover:bg-green-300 text-gray-700 rounded-md flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <p class="text-m font-small text-black">Add Another Civil Status</p>
                            </button>
                        </div>

                        <!-- Modal Footer -->
                        <div class="grid grid-cols-2 gap-4 mb-4 mt-8">
                            <button type="submit" class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                <span class="text-[12px]">ADD</span>
                            </button>
                            <button @click="openModal1 = false" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                <span class="text-[12px]">CANCEL</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Confirmation Modal -->
                <div x-show="showConfirmModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white rounded-lg p-6 w-[300px]">
                        <h3 class="text-md font-semibold text-black mb-4">Are you sure you want to remove this?</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <button @click="removeCivilStatus(confirmRemoveIndex)" class="w-full py-1 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg">Remove</button>
                            <button @click="showConfirmModal = false" class="w-full py-1 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg">Cancel</button>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div x-data="{ openModal2: false, confirmDelete: false, deleteIndex: null, applicant_tribes: [''] }">
                    <button @click="openModal2 = true" class="relative cursor-pointer gap-10 bg-white shadow rounded-lg flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-6 h-6 ml-5 text-custom-yellow" stroke-width="0.5">
                                <path d="M 23.984375 5.9863281 A 1.0001 1.0001 0 0 0 23 7 L 23 13 A 1.0001 1.0001 0 1 0 25 13 L 25 7 A 1.0001 1.0001 0 0 0 23.984375 5.9863281 z M 13.869141 9.8691406 A 1.0001 1.0001 0 0 0 13.171875 11.585938 L 17.414062 15.828125 A 1.0001 1.0001 0 1 0 18.828125 14.414062 L 14.585938 10.171875 A 1.0001 1.0001 0 0 0 13.869141 9.8691406 z M 34.101562 9.8691406 A 1.0001 1.0001 0 0 0 33.414062 10.171875 L 29.171875 14.414062 A 1.0001 1.0001 0 1 0 30.585938 15.828125 L 34.828125 11.585938 A 1.0001 1.0001 0 0 0 34.101562 9.8691406 z M 24 16 C 22.458334 16 21.112148 16.632133 20.253906 17.597656 C 19.395664 18.563179 19 19.791667 19 21 C 19 22.208333 19.395664 23.436821 20.253906 24.402344 C 21.112148 25.367867 22.458334 26 24 26 C 25.541666 26 26.887852 25.367867 27.746094 24.402344 C 28.604336 23.436821 29 22.208333 29 21 C 29 19.791667 28.604336 18.563179 27.746094 17.597656 C 26.887852 16.632133 25.541666 16 24 16 z M 24 19 C 24.791666 19 25.195482 19.242867 25.503906 19.589844 C 25.81233 19.936821 26 20.458333 26 21 C 26 21.541667 25.81233 22.063179 25.503906 22.410156 C 25.195482 22.757133 24.791666 23 24 23 C 23.208334 23 22.804518 22.757133 22.496094 22.410156 C 22.18767 22.063179 22 21.541667 22 21 C 22 20.458333 22.18767 19.936821 22.496094 19.589844 C 22.804518 19.242867 23.208334 19 24 19 z M 9 22 C 7.4583337 22 6.1121484 22.632133 5.2539062 23.597656 C 4.3956641 24.563179 4 25.791667 4 27 C 4 28.208333 4.3956641 29.436821 5.2539062 30.402344 C 6.1121484 31.367867 7.4583337 32 9 32 C 10.541666 32 11.887852 31.367867 12.746094 30.402344 C 13.604336 29.436821 14 28.208333 14 27 C 14 25.791667 13.604336 24.563179 12.746094 23.597656 C 11.887852 22.632133 10.541666 22 9 22 z M 39 22 C 37.458334 22 36.112148 22.632133 35.253906 23.597656 C 34.395664 24.563179 34 25.791667 34 27 C 34 28.208333 34.395664 29.436821 35.253906 30.402344 C 36.112148 31.367867 37.458334 32 39 32 C 40.541666 32 41.887852 31.367867 42.746094 30.402344 C 43.604336 29.436821 44 28.208333 44 27 C 44 25.791667 43.604336 24.563179 42.746094 23.597656 C 41.887852 22.632133 40.541666 22 39 22 z M 9 25 C 9.791666 25 10.195482 25.242867 10.503906 25.589844 C 10.81233 25.936821 11 26.458333 11 27 C 11 27.541667 10.81233 28.063179 10.503906 28.410156 C 10.195482 28.757133 9.791666 29 9 29 C 8.208334 29 7.8045177 28.757133 7.4960938 28.410156 C 7.1876698 28.063179 7 27.541667 7 27 C 7 26.458333 7.1876698 25.936821 7.4960938 25.589844 C 7.8045177 25.242867 8.208334 25 9 25 z M 39 25 C 39.791666 25 40.195482 25.242867 40.503906 25.589844 C 40.81233 25.936821 41 26.458333 41 27 C 41 27.541667 40.81233 28.063179 40.503906 28.410156 C 40.195482 28.757133 39.791666 29 39 29 C 38.208334 29 37.804518 28.757133 37.496094 28.410156 C 37.18767 28.063179 37 27.541667 37 27 C 37 26.458333 37.18767 25.936821 37.496094 25.589844 C 37.804518 25.242867 38.208334 25 39 25 z M 18.052734 28 C 16.384766 28 15 29.384766 15 31.052734 L 15 34.021484 C 14.979733 34.021074 14.96762 34 14.947266 34 L 3.0527344 34 C 1.3847659 34 -2.9605947e-16 35.384766 0 37.052734 L 0 38.949219 C 0 40.778128 1.1549049 42.35297 2.7695312 43.382812 C 4.3841576 44.412656 6.526281 45.001953 9 45.001953 C 11.473607 45.001953 13.613818 44.412548 15.228516 43.382812 C 15.743751 43.054234 16.100843 42.590377 16.5 42.160156 C 16.898941 42.589937 17.25472 43.054455 17.769531 43.382812 C 19.384158 44.412656 21.526281 45.001953 24 45.001953 C 26.473607 45.001953 28.613818 44.412548 30.228516 43.382812 C 30.743751 43.054234 31.100843 42.590377 31.5 42.160156 C 31.898941 42.589937 32.25472 43.054455 32.769531 43.382812 C 34.384158 44.412656 36.526281 45.001953 39 45.001953 C 41.473607 45.001953 43.613818 44.412548 45.228516 43.382812 C 46.843213 42.353077 48 40.77836 48 38.949219 L 48 37.052734 C 48 35.384766 46.615234 34 44.947266 34 L 33.052734 34 C 33.032384 34 33.02026 34.021074 33 34.021484 L 33 31.052734 C 32.999996 29.38477 31.615234 28 29.947266 28 L 18.052734 28 z M 18.052734 31 L 29.947266 31 C 29.993297 31 30 31.006703 30 31.052734 L 30 37.052734 L 30 38.949219 C 30 39.503077 29.637239 40.203001 28.617188 40.853516 C 27.597135 41.50403 25.987393 42.001953 24 42.001953 C 22.012719 42.001953 20.402936 41.504172 19.382812 40.853516 C 18.362689 40.202859 18 39.502309 18 38.949219 L 18 37.052734 L 18 31.052734 C 18 31.006703 18.006703 31 18.052734 31 z M 3.0527344 37 L 14.947266 37 C 14.993297 37 15 37.006703 15 37.052734 L 15 38.949219 C 15 39.503077 14.637239 40.203001 13.617188 40.853516 C 12.597134 41.50403 10.987393 42.001953 9 42.001953 C 7.012719 42.001953 5.4029362 41.504172 4.3828125 40.853516 C 3.3626888 40.202859 3 39.502309 3 38.949219 L 3 37.052734 C 3 37.006703 3.0067029 37 3.0527344 37 z M 33.052734 37 L 44.947266 37 C 44.993297 37 45 37.006703 45 37.052734 L 45 38.949219 C 45 39.503077 44.637239 40.203001 43.617188 40.853516 C 42.597135 41.50403 40.987393 42.001953 39 42.001953 C 37.012719 42.001953 35.402936 41.504172 34.382812 40.853516 C 33.36269 40.202859 33 39.502309 33 38.949219 L 33 37.052734 C 33 37.006703 33.006703 37 33.052734 37 z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 flex flex-col items-start">
                            <p class="text-[13px] text-gray-500">Tribe/Ethnicity</p>
                        </div>
                        <div class="flex-shrink-0">
                            <img src="/storage/images/designDasboard.png" alt="dashboard design" class="w-24 h-20 object-contain rounded-lg">
                        </div>
                    </button>

                    <!-- Modal -->
                    <div x-show="openModal2" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg p-6 w-[400px]">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-md font-semibold text-black">ADD TRIBE/ETHNICITY</h3>
                                <button @click="openModal2 = false" class="text-gray-600 hover:text-gray-800">
                                    &times;
                                </button>
                            </div>

                            <!-- Modal Body -->
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black">TRIBE/ETHNICITY</label>
                                <template x-for="(tribe, index) in applicant_tribes" :key="index">
                                    <div class="flex items-center mb-3">
                                        <input type="text" x-model="applicant_tribes[index]" placeholder="Tribe/Ethnicity" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" />
                                        <button @click="confirmDelete = true; deleteIndex = index;" class="ml-2 text-red-600 hover:text-red-700">
                                            &#x2715;
                                        </button>
                                    </div>
                                </template>

                                <!-- Add new input button -->
                                <button @click="applicant_tribes.push('')" class="w-full py-1 bg-gray-100 shadow-md border-collapse hover:bg-green-300 text-gray-700 rounded-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <p class="text-m font-small text-black">Add Another Tribe/Ethnicity</p>
                                </button>
                            </div>

                            <!-- Modal Footer -->
                            <div class="grid grid-cols-2 gap-4 mb-4 mt-8">
                                <button type="submit" class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">ADD</span>
                                </button>
                                <button @click="openModal2 = false" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">CANCEL</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation Modal for Deletion -->
                    <div x-show="confirmDelete" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-20">
                        <div class="bg-white rounded-lg p-6 w-[300px]">
                            <div class="mb-4">
                                <p class="text-md font-semibold text-black mb-4">Are you sure you want to remove this?</p>
                            </div>
                            <!-- Confirmation Buttons -->
                            <div class="grid grid-cols-2 gap-4">
                                <button @click="applicant_tribes.splice(deleteIndex, 1); confirmDelete = false;" class="w-full py-1 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg">
                                    <span class="text-[12px]">REMOVE</span>
                                </button>
                                <button @click="confirmDelete = false" class="w-full py-1 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg">
                                    <span class="text-[12px]">CANCEL</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    // Initialize Alpine.js
                    document.addEventListener('alpine:init', () => {
                        Alpine.data('tribeModal', () => ({
                            openModal2: false,
                            confirmDelete: false,
                            deleteIndex: null,
                            applicant_tribes: ['']
                        }));
                    });
                </script>

                <!-- Card 3 -->
                <div x-data="{ openModal3: false, confirmDelete: false, deleteIndex: null, religions: [''] }">
                    <button @click="openModal3 = true" class="relative cursor-pointer gap-10 bg-white shadow rounded-lg flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-6 h-6 ml-5 text-custom-yellow" stroke-width="0.5">
                                <path d="M 9.5 6 A 1.50015 1.50015 0 1 0 9.5 9 L 10 9 L 10 11 C 10 16.929898 13.772437 21.88495 19 23.917969 L 19 24.082031 C 13.772437 26.11505 10 31.070102 10 37 L 10 39 L 9.5 39 A 1.50015 1.50015 0 1 0 9.5 42 L 11.5 42 L 36.5 42 L 38.5 42 A 1.50015 1.50015 0 1 0 38.5 39 L 38 39 L 38 37 C 38 31.070102 34.227563 26.11505 29 24.082031 L 29 23.917969 C 34.227563 21.88495 38 16.929898 38 11 L 38 9 L 38.5 9 A 1.50015 1.50015 0 1 0 38.5 6 L 36.5 6 L 11.5 6 L 9.5 6 z M 13 9 L 35 9 L 35 11 C 35 16.018458 31.650951 20.222469 27.080078 21.554688 A 1.50015 1.50015 0 0 0 26 22.994141 L 26 25.005859 A 1.50015 1.50015 0 0 0 27.080078 26.445312 C 31.650951 27.777531 35 31.981542 35 37 L 35 39 L 31.349609 39 C 30.654699 35.57668 27.628336 33 24 33 C 20.371664 33 17.345301 35.57668 16.650391 39 L 13 39 L 13 37 C 13 31.981542 16.349049 27.777531 20.919922 26.445312 A 1.50015 1.50015 0 0 0 22 25.005859 L 22 22.994141 A 1.50015 1.50015 0 0 0 20.919922 21.554688 C 16.349049 20.222469 13 16.018458 13 11 L 13 9 z M 20 16 C 20 18.209 21.791 20 24 20 C 26.209 20 28 18.209 28 16 L 20 16 z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 flex flex-col items-start">
                            <p class="text-[13px] text-gray-500">Religion</p>
                        </div>
                        <div class="flex-shrink-0">
                            <img src="/storage/images/designDasboard.png" alt="dashboard design" class="w-24 h-20 object-contain rounded-lg">
                        </div>
                    </button>

                    <!-- Modal -->
                    <div x-show="openModal3" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg p-6 w-[400px]">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-md font-semibold text-black">ADD RELIGION</h3>
                                <button @click="openModal3 = false" class="text-gray-600 hover:text-gray-800">&times;</button>
                            </div>

                            <!-- Modal Body -->
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black">RELIGION</label>
                                <template x-for="(religion, index) in religions" :key="index">
                                    <div class="flex items-center mb-3">
                                        <input type="text" x-model="religions[index]" placeholder="Religion" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" />
                                        <button @click="deleteIndex = index; confirmDelete = true" class="ml-2 text-red-600 hover:text-red-700">
                                            &#x2715;
                                        </button>
                                    </div>
                                </template>

                                <!-- Add new input button -->
                                <button @click="religions.push('')" class="w-full py-1 bg-gray-100 shadow-md border-collapse hover:bg-green-300 text-gray-700 rounded-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <p class="text-m font-small text-black">Add Another Religion</p>
                                </button>
                            </div>

                            <!-- Modal Footer -->
                            <div class="grid grid-cols-2 gap-4 mb-4 mt-8">
                                <button type="submit" class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">ADD</span>
                                </button>
                                <button @click="openModal3 = false" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">CANCEL</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation Modal for Deletion -->
                    <div x-show="confirmDelete" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg p-6 w-[300px]">
                            <h3 class="text-md font-semibold text-black mb-4">Are you sure you want to remove this?</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <button @click="religions.splice(deleteIndex, 1); confirmDelete = false;" class="w-full py-1 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg">Remove</button>
                                <button @click="confirmDelete = false" class="w-full py-1 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    // Initialize Alpine.js
                    document.addEventListener('alpine:init', () => {
                        Alpine.data('religionModal', () => ({
                            openModal3: false,
                            confirmDelete: false,
                            deleteIndex: null,
                            religions: ['']
                        }));
                    });
                </script>

                <!-- Card 4 -->
                <div x-data="{ openModal4: false, confirmDelete: false, deleteIndex: null, living_situations: [''] }">
                    <button @click="openModal4 = true" class="relative cursor-pointer gap-5 bg-white shadow rounded-lg flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-6 h-6 ml-5 text-custom-yellow" stroke-width="0.5">
                                <path d="M 24 5.015625 C 22.851301 5.015625 21.70304 5.3892757 20.753906 6.1367188 A 1.50015 1.50015 0 0 0 20.751953 6.1367188 L 8.859375 15.509766 C 7.0558128 16.931133 6 19.102989 6 21.400391 L 6 39.488281 C 6 41.403236 7.5850452 42.988281 9.5 42.988281 L 38.5 42.988281 C 40.414955 42.988281 42 41.403236 42 39.488281 L 42 21.400391 C 42 19.102989 40.944187 16.931133 39.140625 15.509766 A 1.50015 1.50015 0 0 0 39.140625 15.507812 L 27.246094 6.1367188 C 26.29696 5.3892758 25.148699 5.015625 24 5.015625 z M 24 8.0078125 C 24.489801 8.0078125 24.979759 8.1705836 25.390625 8.4941406 L 37.285156 17.865234 C 38.369594 18.719867 39 20.019792 39 21.400391 L 39 39.488281 C 39 39.783326 38.795045 39.988281 38.5 39.988281 L 9.5 39.988281 C 9.2049548 39.988281 9 39.783326 9 39.488281 L 9 21.400391 C 9 20.019792 9.6304058 18.719867 10.714844 17.865234 L 22.609375 8.4941406 C 23.020241 8.1705836 23.510199 8.0078125 24 8.0078125 z M 24 14 A 3 3 0 0 0 24 20 A 3 3 0 0 0 24 14 z M 23.611328 22 C 21.065328 22 19 24.065328 19 26.611328 L 19 31 C 19 31.738946 19.404366 32.376387 20 32.722656 L 20 36.5 A 1.50015 1.50015 0 1 0 23 36.5 L 23 33 L 25 33 L 25 36.5 A 1.50015 1.50015 0 1 0 28 36.5 L 28 32.722656 C 28.595634 32.376387 29 31.738946 29 31 L 29 26.611328 C 29 24.065328 26.935672 22 24.388672 22 L 23.611328 22 z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 flex flex-col items-start">
                            <p class="text-[13px] text-gray-500">Living Situation(Case)</p>
                        </div>
                        <div class="flex-shrink-0">
                            <img src="/storage/images/designDasboard.png" alt="dashboard design" class="w-24 h-20 object-contain rounded-lg">
                        </div>
                    </button>
                    <!-- Modal -->
                    <div x-show="openModal4" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg p-6 w-[400px]">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-md font-semibold text-black">ADD LIVING SITUATION</h3>
                                <button @click="openModal4 = false" class="text-gray-600 hover:text-gray-800">
                                    &times;
                                </button>
                            </div>

                            <!-- Modal Body -->
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black">LIVING SITUATION</label>
                                <template x-for="(situation, index) in living_situations" :key="index">
                                    <div class="flex items-center mb-3">
                                        <input type="text" x-model="living_situations[index]" placeholder="Living Situation" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" />
                                        <button @click="deleteIndex = index; confirmDelete = true" class="ml-2 text-red-600 hover:text-red-700">
                                            &#x2715;
                                        </button>
                                    </div>
                                </template>

                                <!-- Add new input button -->
                                <button @click="living_situations.push('')" class="w-full py-1 bg-gray-100 shadow-md border-collapse hover:bg-green-300 text-gray-700 rounded-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <p class="text-m font-small text-black">Add Another Living Situation</p>
                                </button>
                            </div>

                            <!-- Modal Footer -->
                            <div class="grid grid-cols-2 gap-4 mb-4 mt-8">
                                <button type="submit" class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">ADD</span>
                                </button>
                                <button @click="openModal4 = false" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">CANCEL</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Confirmation Modal for Deletion -->
                    <div x-show="confirmDelete" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg p-6 w-[300px]">
                            <h3 class="text-md font-semibold text-black mb-4">Are you sure you want to remove this?</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <button @click="living_situations.splice(deleteIndex, 1); confirmDelete = false;" class="w-full py-1 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg">Remove</button>
                                <button @click="confirmDelete = false" class="w-full py-1 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    // Initialize Alpine.js
                    document.addEventListener('alpine:init', () => {
                        Alpine.data('living_situationsModal', () => ({
                            openModal4: false,
                            confirmDelete: false,
                            deleteIndex: null,
                            living_situations: ['']
                        }));
                    });
                </script>

                <!-- Card 5 -->
                <div x-data="{ openModal5: false, confirmDelete: false, deleteIndex: null, case_specifications: [''] }">
                    <button @click="openModal5 = true" class="relative cursor-pointer gap-5 bg-white shadow rounded-lg flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-6 h-6 ml-5 text-custom-yellow" stroke-width="0.5">
                                <path d="M 21 4 C 15.494917 4 11 8.494921 11 14 C 11 19.505079 15.494917 24 21 24 C 26.505083 24 31 19.505079 31 14 C 31 8.494921 26.505083 4 21 4 z M 21 7 C 24.883764 7 28 10.116238 28 14 C 28 17.883762 24.883764 21 21 21 C 17.116236 21 14 17.883762 14 14 C 14 10.116238 17.116236 7 21 7 z M 35 24 C 28.925 24 24 28.925 24 35 C 24 41.075 28.925 46 35 46 C 41.075 46 46 41.075 46 35 C 46 28.925 41.075 24 35 24 z M 9.5 28 C 7.02 28 5 30.02 5 32.5 L 5 33.699219 C 5 39.479219 12.03 44 21 44 C 22.49 44 23.929062 43.870859 25.289062 43.630859 C 24.549063 42.800859 23.910391 41.880859 23.400391 40.880859 C 22.630391 40.960859 21.83 41 21 41 C 12.97 41 8 37.209219 8 33.699219 L 8 32.5 C 8 31.67 8.67 31 9.5 31 L 22.630859 31 C 22.970859 29.93 23.450781 28.93 24.050781 28 L 9.5 28 z M 35 28 C 35.48 28 35.908453 28.305766 36.064453 28.759766 L 37.177734 32 L 40.875 32 C 41.358 32 41.787406 32.308625 41.941406 32.765625 C 42.095406 33.223625 41.939687 33.729484 41.554688 34.021484 L 38.560547 36.292969 L 39.574219 39.539062 C 39.720219 40.005063 39.548391 40.510969 39.150391 40.792969 C 38.955391 40.930969 38.727 41 38.5 41 C 38.263 41 38.025172 40.925391 37.826172 40.775391 L 35 38.660156 L 32.173828 40.775391 C 31.783828 41.068391 31.248609 41.076922 30.849609 40.794922 C 30.451609 40.512922 30.279781 40.005063 30.425781 39.539062 L 31.439453 36.294922 L 28.445312 34.021484 C 28.060312 33.729484 27.904594 33.225578 28.058594 32.767578 C 28.213594 32.309578 28.642 32 29.125 32 L 32.822266 32 L 33.935547 28.759766 C 34.091547 28.305766 34.52 28 35 28 z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 flex flex-col items-start">
                            <p class="text-[13px] text-gray-500">Case Specification</p>
                        </div>
                        <div class="flex-shrink-0">
                            <img src="/storage/images/designDasboard.png" alt="dashboard design" class="w-24 h-20 object-contain rounded-lg">
                        </div>
                    </button>
                    <!-- Modal -->
                    <div x-show="openModal5" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg p-6 w-[400px]">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-md font-semibold text-black">ADD CASE SPECIFICATION</h3>
                                <button @click="openModal5 = false" class="text-gray-600 hover:text-gray-800">
                                    &times;
                                </button>
                            </div>

                            <!-- Modal Body -->
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black">CASE SPECIFICATION</label>
                                <template x-for="(specification, index) in case_specifications" :key="index">
                                    <div class="flex items-center mb-3">
                                        <input type="text" x-model="case_specifications[index]" placeholder="Case Specification" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" />
                                        <button @click="deleteIndex = index; confirmDelete = true" class="ml-2 text-red-600 hover:text-red-700">
                                            &#x2715;
                                        </button>
                                    </div>
                                </template>

                                <!-- Add new input button -->
                                <button @click="case_specifications.push('')" class="w-full py-1 bg-gray-100 shadow-md border-collapse hover:bg-green-300 text-gray-700 rounded-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <p class="text-m font-small text-black">Add Another Case Specification</p>
                                </button>
                            </div>

                            <!-- Modal Footer -->
                            <div class="grid grid-cols-2 gap-4 mb-4 mt-8">
                                <button type="submit" class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">ADD</span>
                                </button>
                                <button @click="openModal5 = false" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">CANCEL</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation Modal for Deletion -->
                    <div x-show="confirmDelete" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg p-6 w-[300px]">
                            <h3 class="text-md font-semibold text-black mb-4">Are you sure you want to remove this?</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <button @click="case_specifications.splice(deleteIndex, 1); confirmDelete = false;" class="w-full py-1 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg">Remove</button>
                                <button @click="confirmDelete = false" class="w-full py-1 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 6 -->
                <div x-data="{ openModal6: false, confirmDelete: false, deleteIndex: null, living_statuses: [''] }">
                    <button @click="openModal6 = true" class="relative cursor-pointer gap-11 bg-white shadow rounded-lg flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-6 h-6 ml-5 text-custom-yellow" stroke-width="0.5">
                                <path d="M 21 4 C 15.494917 4 11 8.494921 11 14 C 11 19.505079 15.494917 24 21 24 C 26.505083 24 31 19.505079 31 14 C 31 8.494921 26.505083 4 21 4 z M 21 7 C 24.883764 7 28 10.116238 28 14 C 28 17.883762 24.883764 21 21 21 C 17.116236 21 14 17.883762 14 14 C 14 10.116238 17.116236 7 21 7 z M 35 24 C 28.925 24 24 28.925 24 35 C 24 41.075 28.925 46 35 46 C 41.075 46 46 41.075 46 35 C 46 28.925 41.075 24 35 24 z M 9.5 28 C 7.02 28 5 30.02 5 32.5 L 5 33.699219 C 5 39.479219 12.03 44 21 44 C 22.49 44 23.929062 43.870859 25.289062 43.630859 C 24.549063 42.800859 23.910391 41.880859 23.400391 40.880859 C 22.630391 40.960859 21.83 41 21 41 C 12.97 41 8 37.209219 8 33.699219 L 8 32.5 C 8 31.67 8.67 31 9.5 31 L 22.630859 31 C 22.970859 29.93 23.450781 28.93 24.050781 28 L 9.5 28 z M 35 28 C 35.48 28 35.908453 28.305766 36.064453 28.759766 L 37.177734 32 L 40.875 32 C 41.358 32 41.787406 32.308625 41.941406 32.765625 C 42.095406 33.223625 41.939687 33.729484 41.554688 34.021484 L 38.560547 36.292969 L 39.574219 39.539062 C 39.720219 40.005063 39.548391 40.510969 39.150391 40.792969 C 38.955391 40.930969 38.727 41 38.5 41 C 38.263 41 38.025172 40.925391 37.826172 40.775391 L 35 38.660156 L 32.173828 40.775391 C 31.783828 41.068391 31.248609 41.076922 30.849609 40.794922 C 30.451609 40.512922 30.279781 40.005063 30.425781 39.539062 L 31.439453 36.294922 L 28.445312 34.021484 C 28.060312 33.729484 27.904594 33.225578 28.058594 32.767578 C 28.213594 32.309578 28.642 32 29.125 32 L 32.822266 32 L 33.935547 28.759766 C 34.091547 28.305766 34.52 28 35 28 z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 flex flex-col items-start">
                            <p class="text-[13px] text-gray-500">Living Status</p>
                        </div>
                        <div class="flex-shrink-0">
                            <img src="/storage/images/designDasboard.png" alt="dashboard design" class="w-24 h-20 object-contain rounded-lg">
                        </div>
                    </button>
                    <!-- Modal -->
                    <div x-show="openModal6" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg p-6 w-[400px]">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-md font-semibold text-black">ADD LIVING STATUS</h3>
                                <button @click="openModal6 = false" class="text-gray-600 hover:text-gray-800">
                                    &times;
                                </button>
                            </div>

                            <!-- Modal Body -->
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black">LIVING STATUS</label>
                                <template x-for="(living_status, index) in living_statuses" :key="index">
                                    <div class="flex items-center mb-3">
                                        <input type="text" x-model="living_statuses[index]" placeholder="Living Status" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" />
                                        <button @click="deleteIndex = index; confirmDelete = true" class="ml-2 text-red-600 hover:text-red-700">
                                            &#x2715;
                                        </button>
                                    </div>
                                </template>

                                <!-- Add new input button -->
                                <button @click="living_statuses.push('')" class="w-full py-1 bg-gray-100 shadow-md border-collapse hover:bg-green-300 text-gray-700 rounded-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <p class="text-m font-small text-black">Add Another Living Status</p>
                                </button>
                            </div>

                            <!-- Modal Footer -->
                            <div class="grid grid-cols-2 gap-4 mb-4 mt-8">
                                <button type="submit" class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">ADD</span>
                                </button>
                                <button @click="openModal6 = false" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">CANCEL</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Confirmation Modal for Deletion -->
                    <div x-show="confirmDelete" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg p-6 w-[300px]">
                            <h3 class="text-md font-semibold text-black mb-4">Are you sure you want to remove this?</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <button @click="case_specifications.splice(deleteIndex, 1); confirmDelete = false;" class="w-full py-1 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg">Remove</button>
                                <button @click="confirmDelete = false" class="w-full py-1 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 7 -->
                <div x-data="{ openModal7: false, confirmDelete: false, deleteIndex: null, barangays: [''] }">
                    <button @click="openModal7 = true" class="relative cursor-pointer gap-10 bg-white shadow rounded-lg flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-6 h-6 ml-5 text-custom-yellow" stroke-width="0.5">
                                <path d="M 24 5.015625 C 22.851301 5.015625 21.70304 5.3892757 20.753906 6.1367188 A 1.50015 1.50015 0 0 0 20.751953 6.1367188 L 8.859375 15.509766 C 7.0558128 16.931133 6 19.102989 6 21.400391 L 6 39.488281 C 6 41.403236 7.5850452 42.988281 9.5 42.988281 L 38.5 42.988281 C 40.414955 42.988281 42 41.403236 42 39.488281 L 42 21.400391 C 42 19.102989 40.944187 16.931133 39.140625 15.509766 A 1.50015 1.50015 0 0 0 39.140625 15.507812 L 27.246094 6.1367188 C 26.29696 5.3892758 25.148699 5.015625 24 5.015625 z M 24 8.0078125 C 24.489801 8.0078125 24.979759 8.1705836 25.390625 8.4941406 L 37.285156 17.865234 C 38.369594 18.719867 39 20.019792 39 21.400391 L 39 39.488281 C 39 39.783326 38.795045 39.988281 38.5 39.988281 L 9.5 39.988281 C 9.2049548 39.988281 9 39.783326 9 39.488281 L 9 21.400391 C 9 20.019792 9.6304058 18.719867 10.714844 17.865234 L 22.609375 8.4941406 C 23.020241 8.1705836 23.510199 8.0078125 24 8.0078125 z M 24 14 A 3 3 0 0 0 24 20 A 3 3 0 0 0 24 14 z M 23.611328 22 C 21.065328 22 19 24.065328 19 26.611328 L 19 31 C 19 31.738946 19.404366 32.376387 20 32.722656 L 20 36.5 A 1.50015 1.50015 0 1 0 23 36.5 L 23 33 L 25 33 L 25 36.5 A 1.50015 1.50015 0 1 0 28 36.5 L 28 32.722656 C 28.595634 32.376387 29 31.738946 29 31 L 29 26.611328 C 29 24.065328 26.935672 22 24.388672 22 L 23.611328 22 z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 flex flex-col items-start">
                            <p class="text-[13px] text-gray-500">Barangay</p>
                        </div>
                        <div class="flex-shrink-0">
                            <img src="/storage/images/designDasboard.png" alt="dashboard design" class="w-24 h-20 object-contain rounded-lg">
                        </div>
                    </button>

                    <!-- Modal -->
                    <div x-show="openModal7" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg p-6 w-[400px]">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-md font-semibold text-black">ADD BARANGAY</h3>
                                <button @click="openModal7 = false" class="text-gray-600 hover:text-gray-800">
                                    &times;
                                </button>
                            </div>

                            <!-- Modal Body -->
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black">BARANGAY</label>
                                <template x-for="(barangay, index) in barangays" :key="index">
                                    <div class="flex items-center mb-3">
                                        <input type="text" x-model="barangays[index]" placeholder="Barangay" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" />
                                        <button @click="deleteIndex = index; confirmDelete = true" class="ml-2 text-red-600 hover:text-red-700">
                                            &#x2715;
                                        </button>
                                    </div>
                                </template>

                                <!-- Add new input button -->
                                <button @click="barangays.push('')" class="w-full py-1 bg-gray-100 shadow-md border-collapse hover:bg-green-300 text-gray-700 rounded-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <p class="text-m font-small text-black">Add Another Barangay</p>
                                </button>
                            </div>

                            <!-- Modal Footer -->
                            <div class="grid grid-cols-2 gap-4 mb-4 mt-8">
                                <button type="submit" class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">ADD</span>
                                </button>
                                <button @click="openModal7 = false" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">CANCEL</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation Modal for Deletion -->
                    <div x-show="confirmDelete" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg p-6 w-[300px]">
                            <h3 class="text-md font-semibold text-black mb-4">Are you sure you want to remove this?</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <button @click="barangays.splice(deleteIndex, 1); confirmDelete = false;" class="w-full py-1 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg">Remove</button>
                                <button @click="confirmDelete = false" class="w-full py-1 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 8 -->
                <div x-data="{ openModal8: false, confirmDelete: false, deleteIndex: null, puroks: [''] }">
                    <button @click="openModal8 = true" class="relative cursor-pointer gap-11 bg-white shadow rounded-lg flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-6 h-6 ml-5 text-custom-yellow" stroke-width="0.5">
                                <path d="M 24 5.015625 C 22.851301 5.015625 21.70304 5.3892757 20.753906 6.1367188 A 1.50015 1.50015 0 0 0 20.751953 6.1367188 L 8.859375 15.509766 C 7.0558128 16.931133 6 19.102989 6 21.400391 L 6 39.488281 C 6 41.403236 7.5850452 42.988281 9.5 42.988281 L 38.5 42.988281 C 40.414955 42.988281 42 41.403236 42 39.488281 L 42 21.400391 C 42 19.102989 40.944187 16.931133 39.140625 15.509766 A 1.50015 1.50015 0 0 0 39.140625 15.507812 L 27.246094 6.1367188 C 26.29696 5.3892758 25.148699 5.015625 24 5.015625 z M 24 8.0078125 C 24.489801 8.0078125 24.979759 8.1705836 25.390625 8.4941406 L 37.285156 17.865234 C 38.369594 18.719867 39 20.019792 39 21.400391 L 39 39.488281 C 39 39.783326 38.795045 39.988281 38.5 39.988281 L 9.5 39.988281 C 9.2049548 39.988281 9 39.783326 9 39.488281 L 9 21.400391 C 9 20.019792 9.6304058 18.719867 10.714844 17.865234 L 22.609375 8.4941406 C 23.020241 8.1705836 23.510199 8.0078125 24 8.0078125 z M 24 14 A 3 3 0 0 0 24 20 A 3 3 0 0 0 24 14 z M 23.611328 22 C 21.065328 22 19 24.065328 19 26.611328 L 19 31 C 19 31.738946 19.404366 32.376387 20 32.722656 L 20 36.5 A 1.50015 1.50015 0 1 0 23 36.5 L 23 33 L 25 33 L 25 36.5 A 1.50015 1.50015 0 1 0 28 36.5 L 28 32.722656 C 28.595634 32.376387 29 31.738946 29 31 L 29 26.611328 C 29 24.065328 26.935672 22 24.388672 22 L 23.611328 22 z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 flex flex-col items-start">
                            <p class="text-[13px] text-gray-500">Purok</p>
                        </div>
                        <div class="flex-shrink-0">
                            <img src="/storage/images/designDasboard.png" alt="dashboard design" class="w-24 h-20 object-contain rounded-lg">
                        </div>
                    </button>

                    <!-- Modal -->
                    <div x-show="openModal8" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg p-6 w-[400px]">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-md font-semibold text-black">ADD PUROK</h3>
                                <button @click="openModal8 = false" class="text-gray-600 hover:text-gray-800">
                                    &times;
                                </button>
                            </div>

                            <!-- Modal Body -->
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black">PUROK</label>
                                <template x-for="(purok, index) in puroks" :key="index">
                                    <div class="flex items-center mb-3">
                                        <input type="text" x-model="puroks[index]" placeholder="Purok" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" />
                                        <button @click="deleteIndex = index; confirmDelete = true" class="ml-2 text-red-600 hover:text-red-700">
                                            &#x2715;
                                        </button>
                                    </div>
                                </template>

                                <!-- Add new input button -->
                                <button @click="puroks.push('')" class="w-full py-1 bg-gray-100 shadow-md border-collapse hover:bg-green-300 text-gray-700 rounded-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <p class="text-m font-small text-black">Add Another Purok</p>
                                </button>
                            </div>

                            <!-- Modal Footer -->
                            <div class="grid grid-cols-2 gap-4 mb-4 mt-8">
                                <button type="submit" class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">ADD</span>
                                </button>
                                <button @click="openModal8 = false" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">CANCEL</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation Modal for Deletion -->
                    <div x-show="confirmDelete" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg p-6 w-[300px]">
                            <h3 class="text-md font-semibold text-black mb-4">Are you sure you want to remove this?</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <button @click="puroks.splice(deleteIndex, 1); confirmDelete = false; deleteIndex = null;" class="w-full py-1 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg">Remove</button>
                                <button @click="confirmDelete = false; deleteIndex = null;" class="w-full py-1 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 9 -->
                <div x-data="{ openModal9: false, confirmDelete: false, sectorIndex: null, social_welfare_sector: [''] }">
                    <button @click="openModal9 = true" class="relative cursor-pointer gap-10 bg-white shadow rounded-lg flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-6 h-6 ml-5 text-custom-yellow" stroke-width="0.5">
                                <path d="M 23.984375 5.9863281 A 1.0001 1.0001 0 0 0 23 7 L 23 13 A 1.0001 1.0001 0 1 0 25 13 L 25 7 A 1.0001 1.0001 0 0 0 23.984375 5.9863281 z M 13.869141 9.8691406 A 1.0001 1.0001 0 0 0 13.171875 11.585938 L 17.414062 15.828125 A 1.0001 1.0001 0 1 0 18.828125 14.414062 L 14.585938 10.171875 A 1.0001 1.0001 0 0 0 13.869141 9.8691406 z M 34.101562 9.8691406 A 1.0001 1.0001 0 0 0 33.414062 10.171875 L 29.171875 14.414062 A 1.0001 1.0001 0 1 0 30.585938 15.828125 L 34.828125 11.585938 A 1.0001 1.0001 0 0 0 34.101562 9.8691406 z M 24 16 C 22.458334 16 21.112148 16.632133 20.253906 17.597656 C 19.395664 18.563179 19 19.791667 19 21 C 19 22.208333 19.395664 23.436821 20.253906 24.402344 C 21.112148 25.367867 22.458334 26 24 26 C 25.541666 26 26.887852 25.367867 27.746094 24.402344 C 28.604336 23.436821 29 22.208333 29 21 C 29 19.791667 28.604336 18.563179 27.746094 17.597656 C 26.887852 16.632133 25.541666 16 24 16 z M 24 19 C 24.791666 19 25.195482 19.242867 25.503906 19.589844 C 25.81233 19.936821 26 20.458333 26 21 C 26 21.541667 25.81233 22.063179 25.503906 22.410156 C 25.195482 22.757133 24.791666 23 24 23 C 23.208334 23 22.804518 22.757133 22.496094 22.410156 C 22.18767 22.063179 22 21.541667 22 21 C 22 20.458333 22.18767 19.936821 22.496094 19.589844 C 22.804518 19.242867 23.208334 19 24 19 z M 9 22 C 7.4583337 22 6.1121484 22.632133 5.2539062 23.597656 C 4.3956641 24.563179 4 25.791667 4 27 C 4 28.208333 4.3956641 29.436821 5.2539062 30.402344 C 6.1121484 31.367867 7.4583337 32 9 32 C 10.541666 32 11.887852 31.367867 12.746094 30.402344 C 13.604336 29.436821 14 28.208333 14 27 C 14 25.791667 13.604336 24.563179 12.746094 23.597656 C 11.887852 22.632133 10.541666 22 9 22 z M 39 22 C 37.458334 22 36.112148 22.632133 35.253906 23.597656 C 34.395664 24.563179 34 25.791667 34 27 C 34 28.208333 34.395664 29.436821 35.253906 30.402344 C 36.112148 31.367867 37.458334 32 39 32 C 40.541666 32 41.887852 31.367867 42.746094 30.402344 C 43.604336 29.436821 44 28.208333 44 27 C 44 25.791667 43.604336 24.563179 42.746094 23.597656 C 41.887852 22.632133 40.541666 22 39 22 z M 9 25 C 9.791666 25 10.195482 25.242867 10.503906 25.589844 C 10.81233 25.936821 11 26.458333 11 27 C 11 27.541667 10.81233 28.063179 10.503906 28.410156 C 10.195482 28.757133 9.791666 29 9 29 C 8.208334 29 7.8045177 28.757133 7.4960938 28.410156 C 7.1876698 28.063179 7 27.541667 7 27 C 7 26.458333 7.1876698 25.936821 7.4960938 25.589844 C 7.8045177 25.242867 8.208334 25 9 25 z M 39 25 C 39.791666 25 40.195482 25.242867 40.503906 25.589844 C 40.81233 25.936821 41 26.458333 41 27 C 41 27.541667 40.81233 28.063179 40.503906 28.410156 C 40.195482 28.757133 39.791666 29 39 29 C 38.208334 29 37.804518 28.757133 37.496094 28.410156 C 37.18767 28.063179 37 27.541667 37 27 C 37 26.458333 37.18767 25.936821 37.496094 25.589844 C 37.804518 25.242867 38.208334 25 39 25 z M 18.052734 28 C 16.384766 28 15 29.384766 15 31.052734 L 15 34.021484 C 14.979733 34.021074 14.96762 34 14.947266 34 L 3.0527344 34 C 1.3847659 34 -2.9605947e-16 35.384766 0 37.052734 L 0 38.949219 C 0 40.778128 1.1549049 42.35297 2.7695312 43.382812 C 4.3841576 44.412656 6.526281 45.001953 9 45.001953 C 11.473607 45.001953 13.613818 44.412548 15.228516 43.382812 C 15.743751 43.054234 16.100843 42.590377 16.5 42.160156 C 16.898941 42.589937 17.25472 43.054455 17.769531 43.382812 C 19.384158 44.412656 21.526281 45.001953 24 45.001953 C 26.473607 45.001953 28.613818 44.412548 30.228516 43.382812 C 30.743751 43.054234 31.100843 42.590377 31.5 42.160156 C 31.898941 42.589937 32.25472 43.054455 32.769531 43.382812 C 34.384158 44.412656 36.526281 45.001953 39 45.001953 C 41.473607 45.001953 43.613818 44.412548 45.228516 43.382812 C 46.843213 42.353077 48 40.77836 48 38.949219 L 48 37.052734 C 48 35.384766 46.615234 34 44.947266 34 L 33.052734 34 C 33.032384 34 33.02026 34.021074 33 34.021484 L 33 31.052734 C 32.999996 29.38477 31.615234 28 29.947266 28 L 18.052734 28 z M 18.052734 31 L 29.947266 31 C 29.993297 31 30 31.006703 30 31.052734 L 30 37.052734 L 30 38.949219 C 30 39.503077 29.637239 40.203001 28.617188 40.853516 C 27.597135 41.50403 25.987393 42.001953 24 42.001953 C 22.012719 42.001953 20.402936 41.504172 19.382812 40.853516 C 18.362689 40.202859 18 39.502309 18 38.949219 L 18 37.052734 L 18 31.052734 C 18 31.006703 18.006703 31 18.052734 31 z M 3.0527344 37 L 14.947266 37 C 14.993297 37 15 37.006703 15 37.052734 L 15 38.949219 C 15 39.503077 14.637239 40.203001 13.617188 40.853516 C 12.597134 41.50403 10.987393 42.001953 9 42.001953 C 7.012719 42.001953 5.4029362 41.504172 4.3828125 40.853516 C 3.3626888 40.202859 3 39.502309 3 38.949219 L 3 37.052734 C 3 37.006703 3.0067029 37 3.0527344 37 z M 33.052734 37 L 44.947266 37 C 44.993297 37 45 37.006703 45 37.052734 L 45 38.949219 C 45 39.503077 44.637239 40.203001 43.617188 40.853516 C 42.597135 41.50403 40.987393 42.001953 39 42.001953 C 37.012719 42.001953 35.402936 41.504172 34.382812 40.853516 C 33.36269 40.202859 33 39.502309 33 38.949219 L 33 37.052734 C 33 37.006703 33.006703 37 33.052734 37 z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 flex flex-col items-start">
                            <p class="text-[13px] text-gray-500">Social Welfare Sector</p>
                        </div>
                        <div class="flex-shrink-0">
                            <img src="/storage/images/designDasboard.png" alt="dashboard design" class="w-24 h-20 object-contain rounded-lg">
                        </div>
                    </button>

                    <!-- Modal -->
                    <div x-show="openModal9" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg p-6 w-[400px]">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-md font-semibold text-black">ADD SOCIAL WELFARE SECTOR</h3>
                                <button @click="openModal9 = false" class="text-gray-600 hover:text-gray-800">
                                    &times;
                                </button>
                            </div>

                            <!-- Modal Body -->
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black">SOCIAL WELFARE SECTOR</label>
                                <template x-for="(sector, index) in social_welfare_sector" :key="index">
                                    <div class="flex items-center mb-3">
                                        <input type="text" x-model="social_welfare_sector[index]" placeholder="Social Welfare Sector" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" />
                                        <button @click="sectorIndex = index; confirmDelete = true" class="ml-2 text-red-600 hover:text-red-700">
                                            &#x2715;
                                        </button>
                                    </div>
                                </template>

                                <!-- Add new input button -->
                                <button @click="social_welfare_sector.push('')" class="w-full py-1 bg-gray-100 shadow-md border-collapse hover:bg-green-300 text-gray-700 rounded-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <p class="text-m font-small text-black">Add Another Social Welfare Sector</p>
                                </button>
                            </div>

                            <!-- Modal Footer -->
                            <div class="grid grid-cols-2 gap-4 mb-4 mt-8">
                                <button type="submit" class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">ADD</span>
                                </button>
                                <button @click="openModal9 = false" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">CANCEL</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation Modal for Deletion -->
                    <div x-show="confirmDelete" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg p-6 w-[300px]">
                            <h3 class="text-md font-semibold text-black mb-4">Are you sure you want to remove this?</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <button @click="social_welfare_sector.splice(sectorIndex, 1); confirmDelete = false; sectorIndex = null;" class="w-full py-1 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg">Remove</button>
                                <button @click="confirmDelete = false; sectorIndex = null;" class="w-full py-1 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
</x-app-layout>


// public function addCivilStatus()
    // {
    //     // Validate each civil status entry to ensure uniqueness
    //     foreach ($this->civilStatuses as $status) {
    //         if (!empty($status)) {
    //             $this->validate([
    //                 'civilStatuses.*' => 'string|unique:civil_statuses,civil_status',
    //             ]);

    //             // Add the civil status to the database
    //             CivilStatus::create(['civil_status' => $status]);
    //         }
    //     }

    //     // Clear the input array and show success message
    //     $this->civilStatuses = [];
    //     session()->flash('message', 'Civil statuses added successfully!');
    // }



    // public function addCivilStatus()
    // {
    //     // Validation (ensure the status isn't empty and is unique)
    //     $this->validate([
    //         'newStatus' => 'required|string|unique:civil_statuses,civil_status',
    //     ]);

    //     // Add the status to the database
    //     CivilStatus::create(['civil_status' => $this->newStatus]);

    //     // Update the local array and reset input
    //     $this->civilStatuses[] = $this->newStatus;
    //     $this->newStatus = '';
    //     session()->flash('message', 'Civil Status added successfully!');
    // }
    // public function saveCivilStatuses()
    // {
    //     // Validate each status to ensure it's not empty and unique
    //     foreach ($this->civilStatuses as $status) {
    //         if (!empty($status)) {
    //             $this->validate([
    //                 'civilStatuses.*' => 'required|string|unique:civil_statuses,civil_status',
    //             ]);

    //             // Add the status to the database if it doesn't exist
    //             CivilStatus::create(['civil_status' => $status]);
    //         }
    //     }
    //     // Reset the input fields and show a success message
    //     $this->civilStatuses = [''];
    //     session()->flash('message', 'Civil Statuses added successfully!');
    // }
    // public function removeCivilStatusField($index)
    // {
    //     unset($this->civilStatuses[$index]);
    //     $this->civilStatuses = array_values($this->civilStatuses); // Re-index the array
    // }
