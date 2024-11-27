<div>
    <div x-data="{ openModal1: false }" class="p-10 h-screen ml-[17%] mt-[60px] ">
        <div class="flex bg-gray-100 text-[12px] mt-5 mb-5"></div>
        <div x-data="{civilStatuses: [''],openModal1: false,confirmRemoveIndex: null,showConfirmModal: false,confirmRemove(index) {this.confirmRemoveIndex = index;this.showConfirmModal = true;},
    }">
            <!-- Main Content -->
            <div class="grid grid-cols-4 gap-10 mb-12 mt-10">
                <button @click="openModal1 = true" class="relative cursor-pointer bg-white shadow rounded-lg flex items-center">
                    <div class="flex-shrink-0 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-6 h-6 ml-5 text-custom-yellow" stroke-width="0.5">
                            <path d="M 21 4 C 15.494917 4 11 8.494921 11 14 C 11 19.505079 15.494917 24 21 24 C 26.505083 24 31 19.505079 31 14 C 31 8.494921 26.505083 4 21 4 z M 21 7 C 24.883764 7 28 10.116238 28 14 C 28 17.883762 24.883764 21 21 21 C 17.116236 21 14 17.883762 14 14 C 14 10.116238 17.116236 7 21 7 z M 35 24 C 28.925 24 24 28.925 24 35 C 24 41.075 28.925 46 35 46 C 41.075 46 46 41.075 46 35 C 46 28.925 41.075 24 35 24 z M 9.5 28 C 7.02 28 5 30.02 5 32.5 L 5 33.699219 C 5 39.479219 12.03 44 21 44 C 22.49 44 23.929062 43.870859 25.289062 43.630859 C 24.549063 42.800859 23.910391 41.880859 23.400391 40.880859 C 22.630391 40.960859 21.83 41 21 41 C 12.97 41 8 37.209219 8 33.699219 L 8 32.5 C 8 31.67 8.67 31 9.5 31 L 22.630859 31 C 22.970859 29.93 23.450781 28.93 24.050781 28 L 9.5 28 z M 35 28 C 35.48 28 35.908453 28.305766 36.064453 28.759766 L 37.177734 32 L 40.875 32 C 41.358 32 41.787406 32.308625 41.941406 32.765625 C 42.095406 33.223625 41.939687 33.729484 41.554688 34.021484 L 38.560547 36.292969 L 39.574219 39.539062 C 39.720219 40.005063 39.548391 40.510969 39.150391 40.792969 C 38.955391 40.930969 38.727 41 38.5 41 C 38.263 41 38.025172 40.925391 37.826172 40.775391 L 35 38.660156 L 32.173828 40.775391 C 31.783828 41.068391 31.248609 41.076922 30.849609 40.794922 C 30.451609 40.512922 30.279781 40.005063 30.425781 39.539062 L 31.439453 36.294922 L 28.445312 34.021484 C 28.060312 33.729484 27.904594 33.225578 28.058594 32.767578 C 28.213594 32.309578 28.642 32 29.125 32 L 32.822266 32 L 33.935547 28.759766 C 34.091547 28.305766 34.52 28 35 28 z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 flex flex-col items-center justify-centert">
                        <p class="text-[13px] text-gray-500 ">Civil Status</p>
                    </div>
                    <div class="flex-shrink-0">
                        <img src="/storage/images/designDasboard.png" alt="dashboard design" class="w-24 h-20 object-contain rounded-lg">
                    </div>
                </button>
           
                <!-- Modal -->
                <div x-show="openModal1" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white rounded-lg p-6 w-[400px] max-h-[80vh] overflow-y-auto">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center  mb-4">
                            <h3 class="text-md font-semibold text-black">ADD CIVIL STATUS</h3>
                            <button @click="openModal1 = false" class="text-gray-600 hover:text-gray-800">&times;</button>
                        </div>
                     
                        <!-- Modal Body -->
                        @foreach($civilStatuses as $status)
                        <div class="flex items-center mb-1">
                            <input type="text" value="{{ $status }}" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" disabled />
                        </div>
                        @endforeach
                        <div class="mt-5">
                            <label class="block text-[12px] font-medium mb-2 text-black" for="civil-status">CIVIL STATUS</label>
                            <template x-for="(status, index) in civilStatuses" :key="index">
                                <div class="flex items-center mb-1">
                                    <!-- Input for new civil status -->
                                    <input type="text" wire:model="newStatus" placeholder="Civil Status" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" />
                                </div>
                            </template>
                        </div>

                        <!-- Modal Footer -->
                        <div class="grid grid-cols-2 gap-4 mb-5 mt-5">
                            <button @click="$wire.addCivilStatus()" class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                <span class="text-[12px]">ADD</span>
                            </button>
                            <button @click="openModal1 = false" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                <span class="text-[12px]">CANCEL</span>
                            </button>
                        </div>
                        <!-- Success Message Inside Modal -->
                        @if (session()->has('message'))
                        <div class="mb-4 text-green-500 text-center">
                            {{ session('message') }}
                        </div>
                        @endif
                        <!-- Error Message -->
                        @if (session()->has('error'))
                        <div class="mt-2 text-red-500 text-center">
                            {{ session('error') }}
                        </div>
                        @endif
                    </div>
                </div>
                <!-- Card 4 -->

                <div x-data="{ livingSituations: [''], openModal4: false, confirmRemoveIndex: null, showConfirmModal: false, confirmRemove(index) { this.confirmRemoveIndex = index; this.showConfirmModal = true;},
        removeLivingSituation(index) { if (index !== null) { this.livingSituations.splice(index, 1); this.confirmRemoveIndex = null;this.showConfirmModal = false;
            }
        }
    }">
                    <!-- Main Content -->
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
                        <div class="bg-white rounded-lg p-6 w-[400px] max-h-[80vh] overflow-y-auto">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-md font-semibold text-black">ADD LIVING SITUATION</h3>
                                <button @click="openModal4 = false" class="text-gray-600 hover:text-gray-800">
                                    &times;
                                </button>
                            </div>
                           
                            <!-- Modal Body -->
                            @foreach($living_situations as $situation)
                            <div class="mb-1">
                                <input type="text" value="{{$situation}}" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" disabled />
                            </div>
                            @endforeach
                            <div>
                                <label class="block text-[12px] font-medium mb-2 mt-5 text-black">LIVING SITUATION</label>
                                <template x-for="(situation, index) in livingSituations" :key="index">
                                    <div class="flex items-center mb-3 mt-1">
                                        <!-- Input for new Living Situation -->
                                        <input type="text" wire:model="newSituation" placeholder="Living Situation" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" />
                                        
                                    </div>
                                </template>
                            </div>

                            <!-- Modal Footer -->
                            <div class="grid grid-cols-2 gap-4 mb-5 mt-8">
                                <button wire:click="addLivingSituation" class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">ADD</span>
                                </button>
                                <button @click="openModal4 = false" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">CANCEL</span>
                                </button>
                            </div>
                            <!-- Success Message Inside Modal -->
                            @if (session()->has('message'))
                            <div class="mb-4 text-green-500 text-center">
                                {{ session('message') }}
                            </div>
                            @endif
                            <!-- Error Message -->
                            @if (session()->has('error'))
                            <div class="mt-2 text-red-500 text-center">
                                {{ session('error') }}
                            </div>
                            @endif
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
                <div x-data="{caseSpecifications: [''],openModal5: false,confirmRemoveIndex: null,showConfirmModal: false,confirmRemove(index) {this.confirmRemoveIndex = index;this.showConfirmModal = true;},
        removeCaseSpecification(index) {if (index !== null) { this.caseSpecifications.splice(index, 1); this.confirmRemoveIndex = null;this.showConfirmModal = false;
            }
        }">
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
                            <div class="bg-white rounded-lg p-6 w-[400px] max-h-[100vh] overflow-y-auto]">
                                <!-- Modal Header -->
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-md font-semibold text-black">ADD CASE SPECIFICATION</h3>
                                    <button @click="openModal5 = false" class="text-gray-600 hover:text-gray-800">
                                        &times;
                                    </button>
                                </div>
                              
                                <!-- Modal Body -->
                                @foreach($case_specifications as $specification)
                                <div class="flex items-center mb-1">
                                    <input type="text" value="{{ $specification }}" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" disabled />
                                </div>
                                @endforeach
                                <div class="mt-5 ">
                                    <label class="block text-[12px] font-medium mb-2 text-black">CASE SPECIFICATION</label>
                                    <template x-for="(specification, index) in case_specifications" :key="index">
                                        <div class="flex items-center mb-1">
                                            <!-- Input for new case specification -->
                                            <input type="text" wire:model="newSpecification" placeholder="Case Specification" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" />
                                        </div>
                                    </template>
                                </div>

                                <!-- Modal Footer -->
                                <div class="grid grid-cols-2 gap-4 mb-4 mt-8">
                                    <button wire:click="addCaseSpecification" class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                        <span class="text-[12px]">ADD</span>
                                    </button>
                                    <button @click="openModal5 = false" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                        <span class="text-[12px]">CANCEL</span>
                                    </button>
                                </div>
                                <!-- Success Message Inside Modal -->
                                @if (session()->has('message'))
                                <div class="mb-4 text-green-500 text-center">
                                    {{ session('message') }}
                                </div>
                                @endif
                                <!-- Error Message -->
                                @if (session()->has('error'))
                                <div class="mt-2 text-red-500 text-center">
                                    {{ session('error') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 6 -->
                <div x-data="{livingStatuses: [''],openModal1: false,confirmRemoveIndex: null,showConfirmModal: false,confirmRemove(index) {this.confirmRemoveIndex = index;this.showConfirmModal = true;},
                removeLivingStatus(index) {if (index !== null) {this.livingStatuses.splice(index, 1);this.confirmRemoveIndex = null; this.showConfirmModal = false;
            }
        }
    }">
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
                            <div class="bg-white rounded-lg p-6 w-[400px] max-h-[80vh] overflow-y-auto">
                                <!-- Modal Header -->
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-md font-semibold text-black">ADD LIVING STATUS</h3>
                                    <button @click="openModal6 = false" class="text-gray-600 hover:text-gray-800">
                                        &times;
                                    </button>
                                </div>
                             
                                <!-- Modal Body -->
                                @foreach($living_statuses as $LivingStatus)
                                <div class="flex items-center mb-1">
                                    <input type="text" value="{{ $LivingStatus }}" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" disabled />
                                </div>
                                @endforeach
                                <div>
                                    <label class="block text-[12px] font-medium mt-5 mb-2 text-black">LIVING STATUS</label>
                                    <template x-for="(LivingStatus, index) in living_statuses" :key="index">
                                        <div class="flex items-center mb-1">
                                            <!-- Input for new living status -->
                                            <input type="text" wire:model="newLivingStatus" placeholder="Living Status" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" />
                                        </div>
                                    </template>
                                </div>

                                <!-- Modal Footer -->
                                <div class="grid grid-cols-2 gap-4 mb-4 mt-8">
                                    <button wire:click="addLivingStatus" class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                        <span class="text-[12px]">ADD</span>
                                    </button>
                                    <button @click="openModal6 = false" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                        <span class="text-[12px]">CANCEL</span>
                                    </button>
                                </div>
                                <!-- Success Message Inside Modal -->
                                @if (session()->has('message'))
                                <div class="mb-4 text-green-500 text-center">
                                    {{ session('message') }}
                                </div>
                                @endif
                                <!-- Error Message -->
                                @if (session()->has('error'))
                                <div class="mt-2 text-red-500 text-center">
                                    {{ session('error') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 7 -->
                <div x-data="{barangays: [''],openModal7: false,confirmRemoveIndex: null,showConfirmModal: false,confirmRemove(index) {this.confirmRemoveIndex = index;this.showConfirmModal = true;}, 
                removeBarangay(index) {if (index !== null) {this.barangays.splice(index, 1);this.confirmRemoveIndex = null;this.showConfirmModal = false;
            }
        }
    }">
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
                        <div class="bg-white rounded-lg p-6 w-[400px] max-h-[80vh] overflow-y-auto">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-md font-semibold text-black">ADD BARANGAY</h3>
                                <button @click="openModal7 = false" class="text-gray-600 hover:text-gray-800">
                                    &times;
                                </button>
                            </div>
                        
                            <!-- Modal Body -->
                            @foreach($barangays as $barangay)
                            <div class="flex items-center mb-1">
                                <input type="text" value="{{ $barangay}}" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" disabled />
                            </div>
                            @endforeach
                            <div>
                                <label class="block text-[12px] font-medium mb-2 mt-5 text-black">BARANGAY</label>
                                <template x-for="(barangay, index) in barangays" :key="index">
                                    <div class="flex items-center mb-3">
                                        <!-- Input for new barangay -->
                                        <input type="text" wire:model="newBarangay" placeholder="Barangay" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" />
                                    </div>
                                </template>
                            </div>
                            <!-- Modal Footer -->
                            <div class="grid grid-cols-2 gap-4 mb-4 mt-8">
                                <button wire:click="addBarangay" class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">ADD</span>
                                </button>
                                <button @click="openModal7 = false" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                    <span class="text-[12px]">CANCEL</span>
                                </button>
                            </div>
                            <!-- Success Message Inside Modal -->
                            @if (session()->has('message'))
                            <div class="mb-4 text-green-500 text-center">
                                {{ session('message') }}
                            </div>
                            @endif
                            <!-- Error Message -->
                            @if (session()->has('error'))
                            <div class="mt-2 text-red-500 text-center">
                                {{ session('error') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Card 8 -->
                <div x-data="{puroks: [''],openModal8: false,confirmRemoveIndex: null,showConfirmModal: false,confirmRemove(index) {this.confirmRemoveIndex = index;this.showConfirmModal = true;},
            removePurok(index) {if (index !== null) {this.puroks.splice(index, 1);this.confirmRemoveIndex = null;this.showConfirmModal = false;
            }
        }
    }">
                    <div x-data="{ openModal8: false, confirmDelete: false, deleteIndex: null, puroks: [''] }">
                        <button @click="openModal8 = true" class="relative cursor-pointer gap-[50px] bg-white shadow rounded-lg flex items-center">
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
                            <div class="bg-white rounded-lg p-6 w-[400px] max-h-[80vh] overflow-y-auto">
                                <!-- Modal Header -->
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-md font-semibold text-black">ADD PUROK</h3>
                                    <button @click="openModal8 = false" class="text-gray-600 hover:text-gray-800">
                                        &times;
                                    </button>
                                </div>
                                
                                <!-- Modal Body -->
                                @foreach($puroks as $purok)
                                <div class="flex items-center mb-1">
                                    <input type="text" value="{{ $purok }}" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" disabled />
                                </div>
                                @endforeach
                                <div>
                                    <label class="block text-[12px] font-medium mb-2 mt-5 text-black">PUROK</label>
                                    <template x-for="(purok, index) in puroks" :key="index">
                                        <div class="flex items-center mb-3">
                                            <input type="text" wire:model="newPurok" placeholder="Purok" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" />
                                        </div>
                                    </template>
                                </div>

                                <!-- Modal Footer -->
                                <div class="grid grid-cols-2 gap-4 mb-4 mt-8">
                                    <button wire:click="addPurok" class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                        <span class="text-[12px]">ADD</span>
                                    </button>
                                    <button @click="openModal8 = false" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                        <span class="text-[12px]">CANCEL</span>
                                    </button>
                                </div>
                                <!-- Success Message Inside Modal -->
                                @if (session()->has('message'))
                                <div class="mb-4 text-green-500 text-center">
                                    {{ session('message') }}
                                </div>
                                @endif
                                <!-- Error Message -->
                                @if (session()->has('error'))
                                <div class="mt-2 text-red-500 text-center">
                                    {{ session('error') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 5 -->
                <div 
    x-data="{
        openModal9: false, confirmDelete: false, deleteIndex: null, structure_status_types: @entangle('structure_status_types'), newStructure: '', confirmRemove(index) { this.deleteIndex = index; this.confirmDelete = true; },
        removeStructure(index) { if (index !== null) { $wire.confirmRemoveStructure(index);this.deleteIndex = null; this.confirmDelete = false; 
            }
        }
    }"
>

                    
                        <button @click="openModal9 = true" class="relative cursor-pointer gap-5 bg-white shadow rounded-lg flex items-center">
                            <div class="flex-shrink-0 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" fill="currentColor" stroke="currentColor" viewBox="0 0 48 48" class="w-6 h-6 ml-5 text-custom-yellow" stroke-width="0.5">
                                    <path d="M 21 4 C 15.494917 4 11 8.494921 11 14 C 11 19.505079 15.494917 24 21 24 C 26.505083 24 31 19.505079 31 14 C 31 8.494921 26.505083 4 21 4 z M 21 7 C 24.883764 7 28 10.116238 28 14 C 28 17.883762 24.883764 21 21 21 C 17.116236 21 14 17.883762 14 14 C 14 10.116238 17.116236 7 21 7 z M 35 24 C 28.925 24 24 28.925 24 35 C 24 41.075 28.925 46 35 46 C 41.075 46 46 41.075 46 35 C 46 28.925 41.075 24 35 24 z M 9.5 28 C 7.02 28 5 30.02 5 32.5 L 5 33.699219 C 5 39.479219 12.03 44 21 44 C 22.49 44 23.929062 43.870859 25.289062 43.630859 C 24.549063 42.800859 23.910391 41.880859 23.400391 40.880859 C 22.630391 40.960859 21.83 41 21 41 C 12.97 41 8 37.209219 8 33.699219 L 8 32.5 C 8 31.67 8.67 31 9.5 31 L 22.630859 31 C 22.970859 29.93 23.450781 28.93 24.050781 28 L 9.5 28 z M 35 28 C 35.48 28 35.908453 28.305766 36.064453 28.759766 L 37.177734 32 L 40.875 32 C 41.358 32 41.787406 32.308625 41.941406 32.765625 C 42.095406 33.223625 41.939687 33.729484 41.554688 34.021484 L 38.560547 36.292969 L 39.574219 39.539062 C 39.720219 40.005063 39.548391 40.510969 39.150391 40.792969 C 38.955391 40.930969 38.727 41 38.5 41 C 38.263 41 38.025172 40.925391 37.826172 40.775391 L 35 38.660156 L 32.173828 40.775391 C 31.783828 41.068391 31.248609 41.076922 30.849609 40.794922 C 30.451609 40.512922 30.279781 40.005063 30.425781 39.539062 L 31.439453 36.294922 L 28.445312 34.021484 C 28.060312 33.729484 27.904594 33.225578 28.058594 32.767578 C 28.213594 32.309578 28.642 32 29.125 32 L 32.822266 32 L 33.935547 28.759766 C 34.091547 28.305766 34.52 28 35 28 z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 flex flex-col items-center justify-center">
                                <p class="text-[13px] text-gray-500">Structure Status</p>
                            </div>
                            <div class="flex-shrink-0">
                                <img src="/storage/images/designDasboard.png" alt="dashboard design" class="w-24 h-20 object-contain rounded-lg">
                            </div>
                        </button>
                        
                        <!-- Modal -->
                        <div x-show="openModal9" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                            <div class="bg-white rounded-lg p-6 w-[400px] max-h-[100vh] overflow-y-auto]">
                                <!-- Modal Header -->
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-md font-semibold text-black">ADD STRUCTURE STATUS</h3>
                                    <button @click="openModal9 = false" class="text-gray-600 hover:text-gray-800">
                                        &times;
                                    </button>
                                </div>
                               
                                <!-- Modal Body -->
                                @foreach($structure_status_types as $structure)
                                <div class="flex items-center mb-1">
                                    <input type="text" value="{{ $structure }}" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" disabled />
                                </div>
                                @endforeach
                                <div class="mt-3 ">
                                    <label class="block text-[12px] font-medium mb-2 text-black">STRUCTURE STATUS</label>
                                        <div class="flex items-center mb-1">
                                            <!-- Input for new case structure -->
                                            <input type="text" wire:model="newStructure" placeholder="Structure Status" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 text-[12px]" />
                                        </div>
                                

                                <!-- Modal Footer -->
                                <div class="grid grid-cols-2 gap-4 mb-4 mt-8">
                                    <button  wire:click="addStructure"  class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                        <span class="text-[12px]">ADD</span>
                                    </button>
                                    <button @click="openModal9 = false" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center">
                                        <span class="text-[12px]">CANCEL</span>
                                    </button>
                                </div>
                                <!-- Success Message Inside Modal -->
                                @if (session()->has('message'))
                                <div class="mb-4 text-green-500 text-center">
                                    {{ session('message') }}
                                </div>
                                @endif
                                <!-- Error Message -->
                                @if (session()->has('error'))
                                <div class="mt-2 text-red-500 text-center">
                                    {{ session('error') }}
                                </div>
                                @endif
                            </div>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>