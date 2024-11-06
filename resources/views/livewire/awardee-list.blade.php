<div>
    <div x-data="{ openFilters: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
        <div class="flex bg-gray-100 text-[12px]">
            <!-- Main Content -->
            <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">
                <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-0 relative p-3">
                    <div class="flex items-center">
                        <h2 class="text-[13px] ml-5 text-gray-700">AWARDEE LIST</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                    <div x-data class="relative z-0">
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

                <!-- Table with transaction requests -->
                <div x-data="{openModalTransfer: false, openPreviewModal: false}" class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-2  text-center font-medium whitespace-nowrap">ID</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">Applicant</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">Purok</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">Barangay</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">Lot</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">Lot Size</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">Grant Date</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">Status</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($awardees as $awardee)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $awardee->taggedAndValidatedApplicant->applicant->applicant_id }}</td>
                                <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $awardee->taggedAndValidatedApplicant->applicant->last_name ?? 'N/A' }}, {{ $awardee->taggedAndValidatedApplicant->applicant->first_name ?? 'N/A' }} {{ $awardee->taggedAndValidatedApplicant->applicant->middle_name ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $awardee->address->purok->name ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $awardee->address->barangay->name ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $awardee->lot->lot_name ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $awardee->lot_size }} {{ $awardee->lotSizeUnit->lot_size_unit_short_name ?? '' }}</td>
                                <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $awardee->grant_date ? date('M d, Y', strtotime($awardee->grant_date)) : 'N/A' }}</td>
                                <td class="py-4 px-2 text-center text-custom-green border-b whitespace-nowrap">
                                    <!-- Animated Confetti -->
                                    <div class="flex items-center">
                                        @if($awardee->is_awarded)
                                            Awarded
                                            <span class="ml-1">
                                                <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                <lord-icon
                                                        src="https://cdn.lordicon.com/fkmafinl.json"
                                                        trigger="loop"
                                                        delay="2000"
                                                        style="width: 30px; height: 30px">
                                                </lord-icon>
                                            </span>
                                        @else
                                            <span class="text-red-500">Pending...</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-2 text-center border-b space-x-2 whitespace-nowrap">
                                    @if(!$awardee->is_awarded)
                                        <button disabled class="text-gray-400 text-bold underline px-4 py-1.5 cursor-not-allowed">
                                            Details
                                        </button>
                                        <button disabled class="bg-gray-400 text-white px-8 py-1.5 rounded-full cursor-not-allowed">
                                            Transfer
                                        </button>
                                    @else
                                        <button @click="window.location.href = '{{ route('awardee-details', ['applicantId' => $awardee->id]) }}'"
                                                class="text-custom-red text-bold underline px-4 py-1.5">
                                            Details
                                        </button>
                                        @if ($awardee->is_blacklisted)
                                            <button disabled class="bg-gray-300 text-white px-8 py-1.5 rounded-full cursor-not-allowed">
                                                Transfer
                                            </button>
                                        @else
                                            <button @click="window.location.href = '{{ route('transfer-awardee') }}'" class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white px-8 py-1.5 rounded-full">
                                                Transfer
                                            </button>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $awardees->links() }}
                    </div>

                    <!-- Modal Background -->
                    <div x-show="openModalTransfer"
                         class="fixed inset-0 flex z-50 items-center justify-center w-full bg-black bg-opacity-50 shadow-lg"
                         x-cloak>
                        <!-- Modal -->
                        <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative max-h-[90vh] overflow-y-auto scrollbar-hide">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="text-m font-semibold text-black">TRANSFER OF AWARD</h3>
                                <button @click="openModalTransfer = false" class="text-gray-400 hover:text-gray-200">
                                    &times;
                                </button>
                            </div>

                            <!-- Form -->
                            <form @submit.prevent>
                                <!-- Date Applied Field -->
                                <div class="mb-1">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="date-applied">DATE
                                        UPDATED</label>
                                    <input type="date" id="date-updated"
                                           class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                           placeholder="Date Applied">
                                </div>

                                <!-- Main Fields -->
                                <div class="grid grid-cols-2 gap-2 mb-2">
                                    <!-- First Name Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-2 text-black" for="first-name">FIRST
                                            NAME</label>
                                        <input type="text" id="first-name"
                                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                               placeholder="First Name">
                                    </div>

                                    <!-- Middle Name Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-2 text-black" for="middle-name">MIDDLE
                                            NAME</label>
                                        <input type="text" id="middle-name"
                                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                               placeholder="Middle Name">
                                    </div>

                                    <!-- Last Name Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-2 text-black" for="last-name">LAST
                                            NAME</label>
                                        <input type="text" id="last-name"
                                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                               placeholder="Last Name">
                                    </div>

                                    <!-- Suffix Name Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-2 text-black" for="suffix-name">SUFFIX
                                            NAME</label>
                                        <input type="text" id="suffix-name"
                                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                               placeholder="Suffix Name">
                                    </div>
                                </div>

                                <!-- Barangay Field -->
                                <div class="mb-1">
                                    <label class="block text-[12px] font-medium mb-2 text-black"
                                           for="barangay">BARANGAY</label>
                                    <input type="text" id="barangay"
                                           class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                           placeholder="Barangay">
                                </div>

                                <!-- Additional Fields -->
                                <div class="grid grid-cols-2 gap-2 mb-1">
                                    <!-- Purok Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-1 text-black"
                                               for="purok">PUROK</label>
                                        <input type="text" id="purok"
                                               class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                               placeholder="Purok">
                                    </div>

                                    <!-- Age Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-1 text-black"
                                               for="age">AGE</label>
                                        <input type="text" id="age"
                                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                               placeholder="Age">
                                    </div>

                                    <!-- Contact Number Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-2 text-black"
                                               for="contact-number">CONTACT NUMBER</label>
                                        <input type="text" id="contact-number"
                                               class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                               placeholder="Contact Number">
                                    </div>

                                    <!-- Gender Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-2 text-black"
                                               for="gender">GENDER</label>
                                        <input type="text" id="gender"
                                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                               placeholder="Gender">
                                    </div>

                                    <!-- Religion Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-2 text-black" for="religion">RELIGION</label>
                                        <input type="text" id="religion"
                                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                               placeholder="Religion">
                                    </div>

                                    <!-- Status Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-2 text-black"
                                               for="status">STATUS</label>
                                        <input type="text" id="status"
                                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                               placeholder="Status">
                                    </div>

                                    <!-- Occupation Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-2 text-black" for="occupation">OCCUPATION</label>
                                        <input type="text" id="occupation"
                                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                               placeholder="Occupation">
                                    </div>

                                    <!-- Monthly Income Field -->
                                    <div>
                                        <label class="block text-[12px] font-medium mb-2 text-black"
                                               for="monthly-income">MONTHLY INCOME</label>
                                        <input type="text" id="monthly-income"
                                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                               placeholder="Monthly Income">
                                    </div>
                                </div>

                                <h2 class="block text-[12px] font-medium mb-2 text-black">UPLOAD REQUIREMENT
                                    DOCUMENTS</h2>

                                <!-- Drag and Drop Area -->
                                <div class="border-2 border-dashed border-green-500 rounded-lg p-4 flex flex-col items-center space-y-1 mb-2">
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

                                    <!-- Hidden File Input for Multiple Files -->
                                    <input type="file" x-ref="fileInput" @change="addFiles($refs.fileInput.files)"
                                           multiple class="hidden" />
                                </div>

                                <!-- Show selected file and progress bar when a file is selected -->
                                <template x-for="(fileWrapper, index) in files" :key="index">
                                    <div @click="openPreviewModal = true; selectedFile = fileWrapper"
                                         class="bg-white p-2 shadow border-2 border-green-500 rounded-lg">
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
                                                      x-text="fileWrapper.displayName, selectedFile.displayName"></span>
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
                                            class="w-full py-2 bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white font-semibold rounded-lg">
                                        TAGGED & VALIDATED
                                    </button>
                                    <button type="button" @click="openModalTag = false"
                                            class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg">
                                        CANCEL
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Preview Modal (Triggered by Clicking a Progress Bar) -->
                        <div x-show="openPreviewModal"
                             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 shadow-lg"
                             x-cloak>
                            <div class="bg-white w-[600px] rounded-lg shadow-lg p-6 relative">
                                <!-- Modal Header with File Name -->
                                <div class="flex justify-between items-center mb-4">
                                    <input type="text" x-model="selectedFile.displayName"
                                           class="text-[13px] w-[60%] font-regular text-black border-none focus:outline-none focus:ring-0">
                                    <button class="text-orange-500 underline text-sm" @click="renameFile()">Rename
                                        File
                                    </button>
                                    <button @click="openPreviewModal = false" class="text-gray-400 hover:text-gray-200">
                                        &times;
                                    </button>
                                </div>

                                <!-- Display Image -->
                                <div class="flex justify-center mb-4">
                                    <img :src="selectedFile ? URL.createObjectURL(selectedFile.file) : '/path/to/default/image.jpg'"
                                         alt="Preview Image" class="w-full h-auto max-h-[60vh] object-contain">
                                </div>
                                <!-- Modal Buttons -->
                                <div class="flex justify-between mt-4">
                                    <button class="px-4 py-2 bg-green-600 text-white rounded-lg"
                                            @click="openPreviewModal = false">CONFIRM
                                    </button>
                                    <button class="px-4 py-2 bg-red-600 text-white rounded-lg"
                                            @click="removeFile(selectedFile); openPreviewModal = false">REMOVE
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination controls -->
{{--                <div class="flex justify-end text-[12px] mt-4">--}}
{{--                    <button--}}
{{--                            @click="prevPage"--}}
{{--                            :disabled="currentPage === 1"--}}
{{--                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-l disabled:opacity-50">--}}
{{--                        Prev--}}
{{--                    </button>--}}
{{--                    <template x-for="page in totalPages" :key="page">--}}
{{--                        <button--}}
{{--                                @click="goToPage(page)"--}}
{{--                                :class="{'bg-custom-green text-white': page === currentPage, 'bg-gray-200': page !== currentPage}"--}}
{{--                                class="px-4 py-2 mx-1 rounded">--}}
{{--                            <span x-text="page"></span>--}}
{{--                        </button>--}}
{{--                    </template>--}}
{{--                    <button--}}
{{--                            @click="nextPage"--}}
{{--                            :disabled="currentPage === totalPages"--}}
{{--                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-r disabled:opacity-50">--}}
{{--                        Next--}}
{{--                    </button>--}}
{{--                </div>--}}
                <script>
                    function fileUpload() {
                        return {
                            files: [],
                            selectedFile: null,
                            openPreviewModal: false,
                            addFiles(fileList) {
                                for (let i = 0; i < fileList.length; i++) {
                                    const file = fileList[i];
                                    this.files.push({
                                        file,
                                        displayName: file.name
                                    });
                                }
                            },
                            removeFile(fileWrapper) {
                                this.files = this.files.filter(f => f !== fileWrapper);
                            },
                            renameFile() {
                                if (this.selectedFile) {
                                    const newName = prompt('Rename File', this.selectedFile.displayName);
                                    if (newName) {
                                        this.selectedFile.displayName = newName;
                                        const fileIndex = this.files.findIndex(f => f === this.selectedFile);
                                        if (fileIndex > -1) {
                                            this.files[fileIndex].displayName = newName;
                                        }

                                    }
                                }
                            }
                        }
                    }
                </script>
{{--                <script>--}}
{{--                    function pagination() {--}}
{{--                        return {--}}
{{--                            currentPage: 1,--}}
{{--                            totalPages: 3, // Set this to the total number of pages you have--}}

{{--                            prevPage() {--}}
{{--                                if (this.currentPage > 1) this.currentPage--;--}}
{{--                            },--}}
{{--                            nextPage() {--}}
{{--                                if (this.currentPage < this.totalPages) this.currentPage++;--}}
{{--                            },--}}
{{--                            goToPage(page) {--}}
{{--                                this.currentPage = page;--}}
{{--                            }--}}
{{--                        }--}}
{{--                    }--}}
{{--                </script>--}}
            </div>
        </div>
    </div>
</div>
