<div x-data="{ openFilters: false }" class="p-10 h-screen  ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <!-- Main Content -->
        <div class="flex-1 h-screen p-6 overflow-auto">
            <div class="relative z-0 mb-2">
                @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
                @endif
            </div>
            {{-- <div x-data="{ show: true }"--}}
            {{-- x-init="setTimeout(() => show = false, 3000)"--}}
            {{-- x-show="show"--}}
            {{-- x-transition:leave="transition ease-in duration-1000"--}}
            {{-- class="relative z-0 mb-2">--}}
            {{-- @if (session()->has('message'))--}}
            {{-- <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">--}}
            {{-- <strong class="font-bold">Success!</strong>--}}
            {{-- <span class="block sm:inline">{{ session('message') }}</span>--}}

            {{-- <!-- Progress Bar -->--}}
            {{-- <div class="h-1 bg-green-500 absolute bottom-0 left-0 right-0">--}}
            {{-- <div x-bind:style="'width: ' + (show ? '100%' : '0%')"--}}
            {{-- class="h-full bg-green-700 transition-all duration-3000"></div>--}}
            {{-- </div>--}}
            {{-- </div>--}}
            {{-- @endif--}}
            {{-- </div>--}}

            <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-5 relative p-3">
                <div class="flex items-center">
                    <h2 class="text-[13px] ml-5 text-gray-700">WALK IN APPLICANTS</h2>
                </div>
                <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                <div class="relative z-0">
                    <button wire:click="$set('isModalOpen', true)" class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-4 py-2 rounded">Add
                        Applicant
                    </button>
                </div>
            </div>

            <!-- Table with transaction requests -->
            <div x-data="{openModalAward: false, openModalTag: false, openPreviewModal: false, selectedFile: null, fileName: ''}"
                class="px-3 py-6 z-5 bg-white"> 
                <livewire:walkin-applicants-table />
                {{-- <livewire:applicants-table tableName="ApplicantsTable" />--}}

                <!-- Award Applicant Modal -->
                <div x-show="openModalAward"
                    class="fixed inset-0 flex z-50 items-center justify-center bg-black bg-opacity-50 shadow-lg"
                    x-cloak style="font-family: 'Poppins', sans-serif;">
                    <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-black">AWARD APPLICANT</h3>
                            <button @click="openModalAward = false" class="text-gray-400 hover:text-gray-200">
                                &times;
                            </button>
                        </div>

                        <!-- Form -->
                        <form>
                            <!-- Award Date Field -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="award_date">AWARD
                                    DATE</label>
                                <input type="date" id="award_date"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                    placeholder="Award Date">
                            </div>

                            <div class="mb-4">
                                <br>
                                <label class="block text-sm font-medium mb-2 text-black" for="lot">LOT
                                    ALLOCATED</label>
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                    for="lot">BARANGAY</label>
                                <input type="text" id="lot"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                    placeholder="Barangay">
                            </div>

                            <!-- Purok Field -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                    for="awardee-purok">PUROK</label>
                                <input type="text" id="awardee-purok"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                    placeholder="Purok">
                            </div>

                            <!-- Contact Number Field -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="awardee-contact-number">CONTACT
                                    NUMBER</label>
                                <input type="text" id="awardee-contact-number"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                    placeholder="Contact Number">
                            </div>

                            <!-- Interviewer Field -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="rawr">LOT
                                    SIZE ALLOCATED</label>
                                <input type="text" id="rawr"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                    placeholder="Lot Size Allocated">
                            </div>
                            <br>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <button type="submit"
                                    class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg">
                                    AWARD
                                </button>
                                <button type="button" @click="openModalAward = false"
                                    class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg">
                                    CANCEL
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tagging/Validation Modal -->
                <div x-show="openModalTag"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 shadow-lg"
                    x-cloak style="font-family: 'Poppins', sans-serif;">
                    <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-black">TAGGED/VALIDATED</h3>
                            <button @click="openModalTag = false" class="text-gray-400 hover:text-gray-200">
                                &times;
                            </button>
                        </div>

                        <!-- Form -->
                        <form @submit.prevent>
                            <!-- Tagging and Validation Date Field -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                    for="tagging-validation-date">TAGGING AND VALIDATION DATE</label>
                                <input type="date" id="tagging-validation-date"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]">
                            </div>

                            <!-- Validator's Name Field -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="validator-name">VALIDATOR'S
                                    NAME</label>
                                <input type="text" id="validator-name"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                    placeholder="Validator's Name">
                            </div>

                            <h2 class="block text-[12px] font-medium mb-2 text-black">UPLOAD HOUSE SITUATION</h2>

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

                                <input type="file" x-ref="fileInput"
                                    @change="selectedFile = $refs.fileInput.files[0]; fileName = selectedFile.name"
                                    class="hidden" />
                            </div>

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
                                        <span class="text-xs text-green-500 font-medium">100%</span>
                                    </div>
                                    <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden cursor-pointer">
                                        <div class="w-full h-full bg-green-500"></div>
                                    </div>
                                </div>
                            </template>

                            <!-- Buttons -->
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <button type="submit"
                                    class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg">
                                    TAGGED & VALIDATED
                                </button>
                                <button type="button" @click="openModalTag = false"
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

            <!-- ADD APPLICANT MODAL -->
            @if($isModalOpen)
            <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                <div class="bg-white text-white w-[450px] rounded-lg shadow-lg p-6 relative z-50">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-black">ADD APPLICANT</h3>
                        <button wire:click="$set('isModalOpen', false)" class="text-gray-400 hover:text-gray-200">
                            &times;
                        </button>
                    </div>

                    <!-- Livewire Form -->
                    <form wire:submit.prevent="store">
                        <!-- Date Applied Field -->
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black" for="date_applied">APPLICATION DATE <span class="text-red-500">*</span></label>
                                <input type="date" id="date_applied" wire:model="date_applied" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none ">
                                @error('date_applied') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Transaction Type Field -->
{{--                            <div>--}}
{{--                                <label class="block text-[12px] font-medium mb-2 text-black" for="transaction_type">TRANSACTION TYPE</label>--}}
{{--                                <input type="text" wire:model="transaction-type-id" id="transaction-type-id" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" required>--}}
{{--                            </div>--}}
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black" for="transaction_type">TRANSACTION TYPE</label>
                                <select wire:model="transaction_type_id" id="transaction_type_id" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg text-gray-800 focus:outline-none text-[12px] uppercase" required>
                                    @foreach ($transactionTypes as $type)
                                        <option value="{{ $type->id }}" {{ $type->type_name == 'Walk-in' ? 'selected' : '' }}>{{ $type->type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Main Fields -->
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <!-- First Name Field -->
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black" for="first_name">FIRST NAME <span class="text-red-500">*</span> </label>
                                <input type="text" wire:model="first_name" id="first_name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" required>
                                @error('first_name') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Middle Name Field -->
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black" for="middle_name">MIDDLE NAME <span class="text-red-500">*</span> </label>
                                <input type="text" wire:model="middle_name" id="middle_name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase">
                                @error('middle_name') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Last Name Field -->
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black" for="last_name">LAST NAME <span class="text-red-500">*</span> </label>
                                <input type="text" wire:model="last_name" id="last_name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" required>
                                @error('last_name') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Suffix Name Field -->
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black" for="suffix_name">SUFFIX NAME</label>
                                <input type="text" wire:model="suffix_name" id="suffix_name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase">
                                @error('suffix_name') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>


                        <!-- Barangay Field -->
                        <div class="mb-3">
                            <label class="block text-[12px] font-medium mb-2 text-black" for="barangay">BARANGAY <span class="text-red-500">*</span> </label>
                            <select id="barangay" wire:model.live="barangay_id" class="w-full px-3 py-1 text-[12px] select2-barangay bg-white-700 border border-gray-600 rounded-lg text-gray-800 uppercase" required>
                                <option value="">Select Barangay</option>
                                @foreach($barangays as $barangay)
                                <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                @endforeach
                            </select>
                            @error('barangay_id') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Purok Field -->
                        <div class="mb-3">
                            <label class="block text-[12px] font-medium mb-2 text-black" for="purok">PUROK <span class="text-red-500">*</span> </label>
                            <select id="purok" wire:model.live="purok_id" class="w-full px-3 py-1 text-[12px] select2-purok bg-white-700 border border-gray-600 rounded-lg focus:outline-none text-gray-800 uppercase" required>
                                <option value="">Select Purok</option>
                                @foreach($puroks as $purok)
                                <option value="{{ $purok->id }}">{{ $purok->name }}</option>
                                @endforeach
                            </select>
                            @error('purok_id') <span class="error">{{ $message }}</span> @enderror
                        </div>


                        <!-- Contact Number Field -->
                        <div class="mb-3">
                            <label class="block text-[12px] font-medium mb-2 text-black" for="contact_number">CONTACT NUMBER</label>
                            <input type="text" wire:model="contact_number" id="contact_number" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 focus:outline-none text-gray-800 focus:outline-none text-[12px] uppercase" placeholder="Contact Number">
                            @error('contact_number') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Interviewer Field -->
                        <div class="mb-6">
                            <label class="block text-[12px] font-medium mb-2 text-black" for="interviewer">INITIALLY INTERVIEWED BY</label>
                            <input type="text" id="interviewer" wire:model="interviewer" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" readonly>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <!-- Award Button -->
                            <button type="submit"
                                class="w-full py-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                <span class="text-[12px]"> + ADD APPLICANT</span>
                            </button>

                            <!-- Cancel Button -->
                            <button type="button" wire:click="$set('isModalOpen', false)"
                                class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                <span class="text-[12px]">CANCEL</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    Livewire.on('applicant-added', () => {
                        alert('Applicant added successfully!');
                    });
                });
            </script>
        </div>
    </div>
    {{-- <script>--}}
    {{-- $(document).ready(function () {--}}
    {{-- // Function to initialize Select2 for searchable dropdowns--}}
    {{-- function initializeSelect2() {--}}
    {{-- $('#barangay').select2({--}}
    {{-- placeholder: 'Select Barangay',--}}
    {{-- allowClear: true,--}}
    {{-- width: '100%'--}}
    {{-- });--}}

    {{-- $('#purok').select2({--}}
    {{-- placeholder: 'Select Purok',--}}
    {{-- allowClear: true,--}}
    {{-- width: '100%'--}}
    {{-- });--}}
    {{-- }--}}

    {{-- // Initialize Select2 on page load--}}
    {{-- initializeSelect2();--}}

    {{-- // Call this function on modal open    --}}
    {{-- $(document).on('shown.bs.modal', function () {--}}
    {{-- initializeSelect2();--}}
    {{-- });--}}

    {{-- // When Barangay dropdown changes--}}
    {{-- $('#barangay').on('change', function () {--}}
    {{-- var barangayId = $(this).val();--}}

    {{-- if (barangayId) {--}}
    {{-- $.ajax({--}}
    {{-- url: '/get-puroks/' + barangayId,--}}
    {{-- type: 'GET',--}}
    {{-- success: function (response) {--}}
    {{-- // Clear and repopulate the Purok dropdown--}}
    {{-- $('#purok').empty();--}}
    {{-- $('#purok').append('<option value="">Select Purok</option>');--}}

    {{-- $.each(response.puroks, function (key, purok) {--}}
    {{-- $('#purok').append('<option value="' + purok.id + '">' + purok.name + '</option>');--}}
    {{-- });--}}

    {{-- // Reinitialize Select2 for the new Purok dropdown options--}}
    {{-- $('#purok').select2({--}}
    {{-- placeholder: 'Select Purok',--}}
    {{-- allowClear: true,--}}
    {{-- width: '100%'--}}
    {{-- });--}}
    {{-- }--}}
    {{-- });--}}
    {{-- } else {--}}
    {{-- // If no barangay selected, reset Purok dropdown--}}
    {{-- $('#purok').empty();--}}
    {{-- $('#purok').append('<option value="">Select Purok</option>');--}}
    {{-- $('#purok').trigger('change');--}}
    {{-- }--}}
    {{-- });--}}
    {{-- });--}}
    {{-- </script>--}}
</div>