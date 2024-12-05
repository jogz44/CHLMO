<div class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <div x-data="{ isEditable: false, openPreviewModal: false }" class="flex-1 p-6 overflow-auto">
            <form wire:submit.prevent="grantApplicant">
                <div class="bg-white rounded shadow mb-4 flex items-center justify-between p-3 fixed top-[80px] left-[20%] right-[3%] z-10">
                    <div class="flex items-center">
                        <a href="{{ route('shelter-profiled-tagged-applicants') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-custom-yellow mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <h2 class="text-[13px] font-semibold ml-2 items-center text-gray-700">GRANT APPLICANT</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design"
                        class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                    <!-- Buttons -->
                    <div class="flex space-x-2  z-[60]">
                        <div>
                            <div class="alert mt-14"
                                :class="{primary:'alert-primary', success:'alert-success', danger:'alert-danger', warning:'alert-warning'}[(alert.type ?? 'primary')]"
                                x-data="{ open:false, alert:{} }"
                                x-show="open" x-cloak
                                x-transition:enter="animate-alert-show"
                                x-transition:leave="animate-alert-hide"
                                @alert.window="open = true; setTimeout( () => open=false, 3000 ); alert=$event.detail[0]">
                                <div class="alert-wrapper">
                                    <strong x-html="alert.title">Title</strong>
                                    <p x-html="alert.message">Description</p>
                                </div>
                                <i class="alert-close fa-solid fa-xmark" @click="open=false"></i>
                            </div>
                            <button type="submit"
                                class="w-full px-4 py-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                <span class="text-[12px]">GRANT</span>
                                <div wire:loading>
                                    <svg aria-hidden="true"
                                        class="w-5 h-5 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="currentColor" />
                                        <path
                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentFill" />
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </button>
                        </div>
                        <script>
                            document.addEventListener('livewire.initialized', () => {
                                let obj = @json(session('alert') ?? []);
                                if (Object.keys(obj).length) {
                                    Livewire.dispatch('alert', [obj])
                                }
                            })
                        </script>
                    </div>
                </div>
                <!-- GRANT Modal -->



                <div class="bg-white rounded shadow p-6 mb-4 mt-6">
                    <div class="relative flex justify-between">
                        <div class="flex flex-wrap -mx-2 w-[50%] justify-items-start">
                            <!-- Tagging and Validation Date Field -->
                            <div class="w-full md:w-1/2 px-2 mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                    for="irs-date">DATE OF RIS</label>
                                <input type="date" id="irs-date" wire:model="date_of_ris" max="{{ now()->toDateString() }}" required
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]">
                                @error('date_of_ris') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-1/2 px-2 mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                    for="delivery-date">DATE OF DELIVERY</label>
                                <input type="date" id="delivery-date" wire:model="date_of_delivery" required
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                    max="{{ now()->toDateString() }}">
                                @error('date_of_delivery') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-2 w-[50%] justify-items-end">
                            <div class="w-full md:w-1/2 px-2 mb-4 ml-auto">
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                    for="ar_no">AR N0.</label>
                                <input type="number" id="ar_no" wire:model="ar_no"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]">
                                @error('ar_no') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <label class="block text-[13px] font-bold text-gray-700 mb-4 mt-4">MATERIALS DELIVERED</label>
                    <div class="flex flex-wrap -mx-2 text-start">
                        <div class="w-full md:w-4/12 px-2 mb-2">
                            <label
                                class="block text-[12px] font-medium text-gray-700">ITEM</label>
                        </div>
                        <div class="w-full md:w-2/12 px-2 mb-2">
                            <label class="block text-[12px] font-medium text-black">STOCK</label>
                        </div>
                        <div class="w-full md:w-2/12 px-2 mb-2">
                            <label class="block text-[12px] font-medium text-black">QTY</label>
                        </div>
                        <div class="w-full md:w-2/12 px-2 mb-2">
                            <label class="block text-[12px] font-medium text-black">UNIT</label>
                        </div>
                        <div class="w-full md:w-2/12 px-2 mb-2">
                            <label class="block text-[12px] font-medium text-black">PO NO.</label>
                        </div>
                    </div>
                    <div>
                        @foreach ($materials as $index => $material)
                        <div class="flex flex-wrap -mx-2">
                            <!-- Material Select -->
                            <div class="w-full md:w-4/12 px-2 mb-2" x-data="{ query: '', suggestions: [], showSuggestions: false }" @click.away="showSuggestions = false">
                                <input
                                    type="text"
                                    x-model="query"
                                    @input.debounce.300ms="$wire.searchMaterials(query).then(data => { suggestions = data; showSuggestions = true; })"
                                    placeholder="Type to search materials..."
                                    class="uppercase w-full px-1 py-1.5 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none text-[12px]" />

                                <ul x-show="showSuggestions && suggestions.length" class="bg-white border text-black border-gray-300 rounded-lg shadow-lg mt-1 max-h-40 overflow-y-auto uppercase">
                                    <template x-for="(item, index) in suggestions" :key="index">
                                        <li
                                            @click="$wire.selectMaterial({{ $index }}, item.id); query = item.item_description; showSuggestions = false;"
                                            class="px-3 py-2 cursor-pointer hover:bg-gray-100">
                                            <span x-text="item.item_description"></span>
                                            <span class="ml-2 text-gray-600" x-text="item.purchaseOrderDisplay ? `${item.purchaseOrderDisplay}` : 'PO: Not available'"></span>
                                        </li>
                                    </template>
                                </ul>

                                @error('materials.' . $index . '.material_id')
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Available quantity -->
                            <div class="w-full md:w-2/12 px-2 mb-2">
                                <input type="text" wire:model="materials.{{ $index }}.available_quantity" readonly class="uppercase w-full p-1 border text-[12px] border-gray-600 rounded-lg text-gray-800 focus:outline-none" placeholder="available">
                            </div>

                            <!-- Quantity Input -->
                            <div class="w-full md:w-2/12 px-2 mb-2">
                                <input type="number" wire:model="materials.{{ $index }}.grantee_quantity" required class="uppercase w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px]" placeholder="Quantity">
                                @error('materials.' . $index . '.grantee_quantity') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Material Unit -->
                            <div class="w-full md:w-2/12 px-2 mb-2">
                                <input type="text" wire:model="materials.{{ $index }}.materialUnitDisplay" readonly class="uppercase w-full p-1 border text-[12px] border-gray-600 rounded-lg text-gray-800 focus:outline-none" placeholder="Material Unit">
                            </div>

                            <!-- PO Number -->
                            <div class="w-full md:w-2/12 px-2 mb-2">
                                <input type="text" wire:model="materials.{{ $index }}.purchaseOrderDisplay" readonly class="uppercase w-full p-1 border text-[12px] border-gray-600 rounded-lg text-gray-800 focus:outline-none" placeholder="PO Number">
                            </div>
                        </div>
                        @endforeach

                        <!-- Add Material Button -->
                        <div class="flex justify-center mt-4 mb-4">
                            <button type="button" wire:click="addMaterial" class="px-3 py-1 bg-custom-yellow text-white rounded-md text-xs hover:bg-custom-yellow">Add Materials Delivered</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded shadow py-4 px-6 mb-4 mt-4">
                    <!-- House Situation Upload -->
                    <div class="p-3 rounded">
                        <h2 class="block text-[12px] font-medium text-black">UPLOAD PHOTO</h2>
                        <p class="text-gray-500 text-xs">Upload here the photo after delivery.</p>
                    </div>

                    <!-- Drag and Drop Area -->
                    <div x-data="fileUpload()" class="w-[60%]  mx-auto ">
                        <div class="border-2 border-dashed border-green-500 bg-[#e9fff1] rounded-lg p-4 flex flex-col items-center space-y-1">
                            <svg class="w-10 h-10 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 011-7.874V7a5 5 0 018.874-2.485A5.5 5.5 0 1118.5 15H5z" />
                            </svg>
                            <button type="button" class="px-3 py-1 bg-green-600 text-white rounded-md text-xs hover:bg-green-700"
                                @click="$refs.fileInput.click()">BROWSE FILES
                            </button>

                            <!-- Hidden File Input -->
                            <input type="file" x-ref="fileInput" wire:model="images" class="hidden"
                                @change="addFiles($refs.fileInput.files)" multiple />
                            @error('images')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Show selected file and progress bar when a file is selected -->
                        <template x-for="(fileWrapper, index) in files" :key="index">
                            <div @click="openPreviewModal = true; selectedFile = fileWrapper" class="mt-4 bg-white p-2 rounded-lg shadow">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 3v6h4l1 1h4V3H7z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8v10h14V8H5z" />
                                        </svg>
                                        <span class="text-xs font-medium text-gray-700" x-text="fileWrapper.displayName"></span>
                                    </div>
                                    <!-- Status -->
                                    <span class="text-xs text-green-500 font-medium" x-text="fileWrapper.progress + '%'"></span>
                                </div>
                                <!-- Progress Bar -->
                                <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden cursor-pointer">
                                    <div class="h-full bg-green-500" x-bind:style="'width: ' + fileWrapper.progress + '%'"></div>
                                </div>
                            </div>
                        </template>

                        <!-- Preview Modal (Triggered by Clicking the Progress Bar) -->
                        <div x-show="openPreviewModal"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 shadow-lg"
                            x-cloak>
                            <div class="bg-white w-[600px] rounded-lg shadow-lg p-6 relative">
                                <!-- Modal Header with File Name -->
                                <div class="flex justify-between items-center mb-4">
                                    <!-- Only show input if selectedFile is not null -->
                                    <template x-if="selectedFile">
                                        <input type="text" x-model="selectedFile.displayName"
                                            class="text-[13px] w-[60%] font-regular text-black border-none focus:outline-none focus:ring-0"
                                            placeholder="Rename file">
                                        @error('images') <span class="error text-red-600">{{ $message }}</span> @enderror
                                    </template>
                                    <button @click="openPreviewModal = false" class="text-gray-400 hover:text-gray-200">
                                        &times;
                                    </button>
                                </div>

                                <!-- Display Image -->
                                <div class="flex justify-center mb-4">
                                    <img :src="selectedFile && selectedFile.file ? URL.createObjectURL(selectedFile.file) :  '/storage/images/default.jpg'"
                                        alt="Preview Image" class="w-full h-auto max-h-[60vh] object-contain">
                                </div>
                                <!-- Modal Buttons -->
                                <div class="flex justify-between mt-4 ">
                                    <button type="button" class="px-4 py-2 bg-green-600 text-white rounded-lg"
                                        @click="confirmFile(); $wire.grantApplicant(selectedFile.file)">CONFIRM
                                    </button>
                                    <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg"
                                        @click="removeFile(selectedFile); openPreviewModal = false">REMOVE
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function fileUpload() {
        return {
            files: [],
            selectedFile: null,

            addFiles(fileList) {
                for (let i = 0; i < fileList.length; i++) {
                    const file = fileList[i];
                    this.files.push({
                        file,
                        displayName: file.name,
                        progress: 0 // Initialize progress to 0
                    });
                    // Start the upload process for the file
                    this.uploadFile(file, this.files.length - 1);
                }
            },
            removeFile(fileWrapper) {
                this.files = this.files.filter(f => f !== fileWrapper);
            },
            uploadFile(file, index) {
                const uploadSimulation = setInterval(() => {
                    if (this.files[index].progress >= 100) {
                        clearInterval(uploadSimulation);
                    } else {
                        this.files[index].progress += 10; // Simulate progress increase
                    }
                }, 100); // Adjust the speed of progress simulation
            },

            confirmFile() {
                // Logic to handle file confirmation (just close modal)
                this.openPreviewModal = false;
            }
        };
    }
</script>