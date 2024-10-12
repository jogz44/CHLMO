<div>
    <div class="p-10 h-screen ml-[17%] mt-[60px]">
        <div x-data="{ openModal: false, openFilters: false}" class="flex bg-gray-100 text-[12px]">

            <!-- Main Content -->
            <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">

                <!-- Container for the Title -->
                <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-0 relative p-3">
                    <div class="flex items-center">
                        <h2 class="text-[13px] ml-5 text-gray-700">MASTERLIST OF APPLICANTS</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                    <div x-data class="relative z-0">
                        <button class="bg-[#2B7A0B] text-white px-4 py-2 rounded">Export</button>
                    </div>
                </div>

                <!-- Search and Filters -->
                <div class="bg-white p-6 rounded shadow">
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2 justify-start">
                            <button @click="openFilters = !openFilters" class="flex space-x-2 items-center hover:bg-[#FF8100] py-2 px-4 rounded bg-[#FF9100]">
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
                        <div class="flex justify-end">
                            <label class="text-center mt-2 mr-1" for="start_date">Date Applied From:</label>
                            <input type="date" id="start_date" wire:model.live="startDate" class="border text-[13px] border-gray-300 rounded px-2 py-1"
                                max="{{ now()->toDateString() }}">
                            <label class="text-center mt-2 ml-2 mr-1" for="end_date">To:</label>
                            <input type="date" id="end_date" wire:model.live="endDate" class="border text-[13px] border-gray-300 rounded px-2 py-1 mr-1"
                                max="{{ now()->toDateString() }}">

                            <div class="relative group">
                                <button wire:click="resetFilters" class="flex items-center justify-center border border-gray-300 bg-gray-100 rounded w-8 h-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 256 256" class="w-4 h-4" xml:space="preserve">
                                        <g transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                            <path d="M 81.521 31.109 c -0.86 -1.73 -2.959 -2.438 -4.692 -1.575 c -1.73 0.86 -2.436 2.961 -1.575 4.692 c 2.329 4.685 3.51 9.734 3.51 15.01 C 78.764 67.854 63.617 83 45 83 S 11.236 67.854 11.236 49.236 c 0 -16.222 11.501 -29.805 26.776 -33.033 l -3.129 4.739 c -1.065 1.613 -0.62 3.784 0.992 4.85 c 0.594 0.392 1.264 0.579 1.926 0.579 c 1.136 0 2.251 -0.553 2.924 -1.571 l 7.176 -10.87 c 0.001 -0.001 0.001 -0.002 0.002 -0.003 l 0.018 -0.027 c 0.063 -0.096 0.106 -0.199 0.159 -0.299 c 0.049 -0.093 0.108 -0.181 0.149 -0.279 c 0.087 -0.207 0.152 -0.419 0.197 -0.634 c 0.009 -0.041 0.008 -0.085 0.015 -0.126 c 0.031 -0.182 0.053 -0.364 0.055 -0.547 c 0 -0.014 0.004 -0.028 0.004 -0.042 c 0 -0.066 -0.016 -0.128 -0.019 -0.193 c -0.008 -0.145 -0.018 -0.288 -0.043 -0.431 c -0.018 -0.097 -0.045 -0.189 -0.071 -0.283 c -0.032 -0.118 -0.065 -0.236 -0.109 -0.35 c -0.037 -0.095 -0.081 -0.185 -0.125 -0.276 c -0.052 -0.107 -0.107 -0.211 -0.17 -0.313 c -0.054 -0.087 -0.114 -0.168 -0.175 -0.25 c -0.07 -0.093 -0.143 -0.183 -0.223 -0.27 c -0.074 -0.08 -0.153 -0.155 -0.234 -0.228 c -0.047 -0.042 -0.085 -0.092 -0.135 -0.132 L 36.679 0.775 c -1.503 -1.213 -3.708 -0.977 -4.921 0.53 c -1.213 1.505 -0.976 3.709 0.53 4.921 l 3.972 3.2 C 17.97 13.438 4.236 29.759 4.236 49.236 C 4.236 71.714 22.522 90 45 90 s 40.764 -18.286 40.764 -40.764 C 85.764 42.87 84.337 36.772 81.521 31.109 z"
                                                style="fill: rgb(0,0,0);"></path>
                                        </g>
                                    </svg>
                                </button>
                                <p class="absolute opacity-0 w-12/12 group-hover:opacity-50 transition-opacity duration-300 rounded-md bg-gray-700 text-[11px] text-white mt-1 p-1">
                                    Reset
                                </p>
                            </div>

                            <!-- Button to toggle dropdown -->
                            <div x-data="{ showDropdown: false }" class="relative">
                                <button @click="showDropdown = !showDropdown" class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-4 py-2 rounded-md items-center">
                                    Toggle Columns
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="showDropdown" @click.away="showDropdown = false" class="absolute bg-white border border-gray-300 shadow-lg w-56 mt-2 py-2 rounded-lg z-10">
                                    <!-- Select All Option -->
                                    <label class="block px-4 py-2">
                                        <input type="checkbox" id="toggle-all" checked> Select All
                                    </label>
                                    <hr class="my-2">
                                    <!-- Individual Column Toggles -->
                                    <label class="block px-4 py-2">
                                        <input type="checkbox" class="toggle-column" id="toggle-name" checked> NAME
                                    </label>
                                    <label class="block px-4 py-2">
                                        <input type="checkbox" class="toggle-column" id="toggle-purok" checked> PUROK
                                    </label>
                                    <label class="block px-4 py-2">
                                        <input type="checkbox" class="toggle-column" id="toggle-barangay" checked> BARANGAY
                                    </label>
                                    <label class="block px-4 py-2">
                                        <input type="checkbox" class="toggle-column" id="toggle-contact" checked> CONTACT
                                    </label>
                                    <label class="block px-4 py-2">
                                        <input type="checkbox" class="toggle-column" id="toggle-occupation" checked> OCCUPATION
                                    </label>
                                    <label class="block px-4 py-2">
                                        <input type="checkbox" class="toggle-column" id="toggle-monthly-income" checked> MONTHLY INCOME
                                    </label>
                                    <label class="block px-4 py-2">
                                        <input type="checkbox" class="toggle-column" id="toggle-transaction-type" checked> TRANSACTION TYPE
                                    </label>
                                    <label class="block px-4 py-2">
                                        <input type="checkbox" class="toggle-column" id="toggle-date-applied" checked> DATE APPLIED
                                    </label>
                                    <label class="block px-4 py-2">
                                        <input type="checkbox" class="toggle-column" id="toggle-status" checked> STATUS
                                    </label>
                                    <label class="block px-4 py-2">
                                        <input type="checkbox" class="toggle-column" id="toggle-actions" checked> ACTIONS
                                    </label>
                                </div>
                            </div>

                            <!-- JavaScript for toggling columns and "Select All" -->
                            <script>
                                // Function to toggle visibility of columns
                                function toggleColumn(columnClass, isVisible) {
                                    document.querySelectorAll('.' + columnClass).forEach(function(col) {
                                        col.style.display = isVisible ? '' : 'none';
                                    });
                                }

                                // Select All functionality
                                document.getElementById('toggle-all').addEventListener('change', function() {
                                    const isChecked = this.checked;
                                    document.querySelectorAll('.toggle-column').forEach(function(checkbox) {
                                        checkbox.checked = isChecked;
                                        const columnClass = checkbox.id.replace('toggle-', '') + '-col';
                                        toggleColumn(columnClass, isChecked);
                                    });
                                });

                                // Individual column checkboxes
                                document.querySelectorAll('.toggle-column').forEach(function(checkbox) {
                                    checkbox.addEventListener('change', function() {
                                        const columnClass = this.id.replace('toggle-', '') + '-col';
                                        toggleColumn(columnClass, this.checked);

                                        // If any checkbox is unchecked, uncheck "Select All"
                                        if (!this.checked) {
                                            document.getElementById('toggle-all').checked = false;
                                        }

                                        // If all checkboxes are checked, check "Select All"
                                        document.getElementById('toggle-all').checked = Array.from(document.querySelectorAll('.toggle-column')).every(cb => cb.checked);
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div x-show="openFilters" class="flex space-x-2 mb-1 mt-5">
                    <select class="border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">Barangay</option>
                            <option value="barangay1">Barangay 1</option>
                            <option value="barangay2">Barangay 2</option>
                            <option value="barangay3">Barangay 3</option>
                        </select>
                        <select class="border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">Purok</option>
                            <option value="purok1">Purok 1</option>
                            <option value="purok2">Purok 2</option>
                            <option value="purok3">Purok 3</option>
                        </select> 
                        <select class="border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">Applicant Type</option>
                            <option value="applicantType1">Applicant Type</option>
                            <option value="applicantType2">Applicant Type</option>
                            <option value="applicantType3">Applicant Type</option>
                        </select>
                        <select class="border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">Applicant age</option>
                            <option value="applicantAge1">1 day ago</option>
                            <option value="applicantAge1">2 days ago</option>
                            <option value="applicantAge1">Last week</option>
                        </select>
                        <select class="border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">Status</option>
                            <option value="status1">Status 1</option>
                            <option value="status2">Status 2</option>
                            <option value="status3">Status 3</option>
                        </select>

                        <button class="bg-[#FFBF00] hover:bg-[#FFAF00] text-white px-4 py-2 rounded">Apply Filters</button>
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
                            <!-- Date Applied Field -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="date-applied">DATE
                                    APPLIED</label>
                                <input type="date" id="date-applied"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                    placeholder="Date Applied">
                            </div>
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="barangay">TYPE
                                    OF APPLICANT <span class="text-red-500">*</span></label>
                                <select class="block text-[12px] w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600"
                                    style="padding: 2px 4px;">
                                    <option value="">TYPE OF APPLICANT</option>
                                    <option value="barangay1">Walkin Housing Applicant</option>
                                    <option value="barangay2">Request for Relocation Applicant</option>
                                    <option value="barangay3">Shelter Assistance Applicant</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block  text-[12px] font-medium mb-2 text-black"
                                        for="first-name">FIRST NAME <span class="text-red-500">*</span></label>
                                    <input type="text" id="first-name"
                                        class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                                        placeholder="First Name">
                                </div>
                                <div>
                                    <label class="block  text-[12px] font-medium mb-2 text-black"
                                        for="middle-name">MIDDLE NAME <span class="text-red-500">*</span></label>
                                    <input type="text" id="middle-name"
                                        class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                                        placeholder="Middle Name">
                                </div>
                                <div>
                                    <label class="block  text-[12px] font-medium mb-2 text-black"
                                        for="last-name">LAST NAME <span class="text-red-500">*</span></label>
                                    <input type="text" id="last-name"
                                        class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                                        placeholder="Last Name">
                                </div>
                                <div>
                                    <label class="block  text-[12px] font-medium mb-2 text-black"
                                        for="suffix-name">SUFFIX NAME</label>
                                    <input type="text" id="suffix-name"
                                        class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                                        placeholder="Suffix Name">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="barangay">BARANGAY <span class="text-red-500">*</span></label>
                                <input type="text" id="barangay"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                                    placeholder="Barangay">
                            </div>
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                    for="purok">PUROK <span class="text-red-500">*</span></label>
                                <input type="text" id="purok"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                                    placeholder="Purok">
                            </div>
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                    for="contact number">CONTACT NUMBER <span class="text-red-500">*</span></label>
                                <input type="text" id="contact-number"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                                    placeholder="Contact Number">
                            </div>
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="interviewer">INITIALLY
                                    INTERVIEWED BY</label>
                                <input type="text" id="initially-interviewed-by"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:ring-1 focus:ring-gray-600 text-[12px]"
                                    placeholder="Initially Interviewed By">
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <!-- Award Button -->
                                <button type="submit"
                                    class="w-full py-2 bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
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

                <!-- Table with transaction requests -->
                <div x-data="{openModalAward: false, openModalTag: false, openPreviewModal: false, selectedFile: null, fileName: ''}"
                    class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-2 border-b text-center font-semibold">ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applicants as $applicant)
                            <tr>
                                <td class="py-4 px-2 text-center  border-b capitalize font-semibold  whitespace-nowrap">{{ $applicant->applicant_id}}</td>
                                <td class="py-4 px-2 text-center  border-b capitalize name-col  whitespace-nowrap">{{ $applicant->last_name }}, {{ $applicant->first_name }} {{ $applicant->middle_name }} {{ $applicant->suffix_name }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize purok-col  whitespace-nowrap">{{ $applicant->address->purok->name ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize barangay-col  whitespace-nowrap">{{ $applicant->address->barangay->name ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize contact-col  whitespace-nowrap">{{ $applicant->contact_number}}</td>
                                <td class="py-4 px-2 text-center border-b capitalize  whitespace-nowrap">{{ optional($applicant->taggedAndValidated)->occupation ?? 'N/A' }}</td>
                                {{-- <td class="py-4 px-2 text-center border-b capitalize">{{ $applicant->livingSituation->living_situation_description ?? 'N/A' }}</td>--}}
                                <td class="py-4 px-2 text-center border-b capitalize  whitespace-nowrap">{{ optional($applicant->taggedAndValidated)->monthly_income ?? 'N/A' }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize  whitespace-nowrap">{{ $applicant->transactionType->type_name }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize  whitespace-nowrap">{{ \Carbon\Carbon::parse($applicant->date_applied)->format('m/d/Y') }}</td>
                                <td class="py-4 px-2 text-center border-b capitalize  whitespace-nowrap">1 day ago</td>
                                <td class="py-4 px-2 text-center border-b capitalize  whitespace-nowrap">Pending</td>
                                <td class="py-4 px-2 text-center border-b space-x-2  whitespace-nowrap">
                                    <button
                                        @click="window.location.href = '{{ route('masterlist-applicant-details') }}'"
                                        class="text-custom-red text-bold underline px-4 py-1.5">Details
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-4 px-2 text-center border-b">No applicants found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

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
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="date-applied">AWARD
                                        DATE</label>
                                    <input type="date" id="award-date"
                                        class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                        placeholder="Award Date">
                                </div>


                                <!-- Main Fields -->

                                <!-- Barangay Field -->
                                <div class="mb-4">
                                    <br>
                                    <label class="block text-sm font-medium mb-2 text-black" for="barangay">LOT
                                        ALLOCATED</label>
                                    <label class="block text-[12px] font-medium mb-2 text-black"
                                        for="barangay">BARANGAY</label>
                                    <input type="text" id="barangay"
                                        class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                        placeholder="Barangay">
                                </div>

                                <!-- Purok Field -->
                                <div class="mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black"
                                        for="purok">PUROK</label>
                                    <input type="text" id="purok"
                                        class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                        placeholder="Purok">
                                </div>

                                <!-- Contact Number Field -->
                                <div class="mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="contact number">CONTACT
                                        NUMBER</label>
                                    <input type="text" id="contact-number"
                                        class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                        placeholder="Contact Number">
                                </div>

                                <!-- Interviewer Field -->
                                <div class="mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="interviewer">LOT
                                        SIZE ALLOCATED</label>
                                    <input type="text" id="lot-size-allocated"
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
</div>