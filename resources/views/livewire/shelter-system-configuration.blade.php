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
            </div>
        </div>
    </div>    
</x-app-layout>