<div>
    <div class="p-10 h-screen ml-[17%] mt-[60px]">
        <div x-data="{ openModal: false, openFilters: false}" class="flex bg-gray-100 text-[12px]">

            <!-- Main Content -->
            <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">

                <!-- Container for the Title -->
                <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-0 relative p-3">
                    <div class="flex items-center">
                        <h2 class="text-[13px] ml-5 text-gray-700">LIST OF MATERIALS</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                    <div class="relative">
                    <button @click="openModal = true" class="bg-gradient-to-r from-custom-red to-custom-green text-white px-4 py-2 rounded">Add Applicant</button>
                    <button wire:click="exportPDF" wire:loading.attr="disabled"
                        class="bg-gradient-to-r from-custom-blue to-custom-purple hover:bg-gradient-to-r hover:from-custom-blue hover:to-custom-dark-purple text-white px-4 py-2 rounded">
                        <span wire:loading wire:target="exportPDF">Exporting PDF...</span>
                        <span wire:loading.remove>Export to PDF</span>
                    </button>

                    <button wire:click="export" wire:ignore wire:loading.attr="disabled"
                        class="bg-gradient-to-r from-custom-yellow to-custom-orange hover:bg-gradient-to-r hover:from-custom-yellow hover:to-custom-dark-orange text-white px-4 py-2 rounded">
                        <span wire:loading wire:target="export">Exporting Excel...</span>
                        <span wire:loading.remove>Export to Excel</span>
                    </button>
                </div>
                </div>

                <!-- Search and Filters -->
                <div class="bg-white p-6 rounded shadow">
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2">
                            <button @click="openFilters = !openFilters" class="flex space-x-1 items-center hover:bg-[#FF8100] p-[5px] px-3 rounded bg-[#FF9100]">
                                <div class="text-white">
                                    <!-- Filter Icon (You can use an icon from any library) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.447.894l-4 2.5A1 1 0 017 21V13.414L3.293 6.707A1 1 0 013 6V4z" />
                                    </svg>
                                </div>
                                <div class="text-[12px] text-white font-medium">
                                    Filter
                                </div>
                            </button>
                            <!-- Search -->
                            <div class="relative hidden md:block border-gray-300 ">
                                <svg class="absolute top-[10px] left-3" width="16" height="16" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.625 16.625C13.491 16.625 16.625 13.491 16.625 9.625C16.625 5.75901 13.491 2.625 9.625 2.625C5.75901 2.625 2.625 5.75901 2.625 9.625C2.625 13.491 5.75901 16.625 9.625 16.625Z" stroke="#787C7F" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M18.3746 18.375L14.5684 14.5688" stroke="#787C7F" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <input type="search" name="search" id="search" class="rounded-md px-10 py-2 placeholder:text-[13px] z-10 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-[#828181] focus:border-[#828181] bg-[#f7f7f9] " placeholder="Search">
                            </div>


                            <!-- Button to toggle dropdown -->
                            <div x-data="{ showDropdown: false }" class="relative">
                                <button @click="showDropdown = !showDropdown" class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white text-[12px] px-4 py-2 rounded-md items-center">
                                    Toggle Columns
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="showDropdown" @click.away="showDropdown = false" class="absolute bg-white border border-gray-300 shadow-lg w-56 mt-2 py-2 rounded-lg z-10">
                                    <!-- Select All Option -->
                                    <label class="block px-4 py-1">
                                        <input type="checkbox" id="toggle-all" checked> Select All
                                    </label>
                                    <hr class="my-2">
                                    <!-- Individual Column Toggles -->
                                    <label class="block px-4 py-2">
                                        <input type="checkbox" class="toggle-column" id="toggle-items-description" checked> ITEMS DESCRIPTION
                                    </label>
                                    <label class="block px-4 py-2">
                                        <input type="checkbox" class="toggle-column" id="toggle-quantity" checked> QUANTITY
                                    </label>
                                    <label class="block px-4 py-2">
                                        <input type="checkbox" class="toggle-column" id="toggle-unit" checked> UNIT
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
                        <div class="flex justify-end">
                            <div class="flex justify-end space-x-2">
                                <!-- Smaller Purchase Order No Field -->
                                <label class="text-center mt-2 text-[12px]" for="purchase_order_no">P0 No:</label>
                                <input type="text" id="purchase_order_no" wire:model.live="purchaseOrderNo" class="border text-[12px] border-gray-300 focus:outline-none focus:ring-1 focus:ring-[#828181] focus:border-[#828181] rounded px-1 py-[0.5rem]" placeholder="Enter Purchase Order No">
                                <!-- Smaller Purchase Requisition No Field -->
                                <label class="text-center mt-2 text-[12px]" for="purchase_requisition_no">PR No:</label>
                                <input type="text" id="purchase_requisition_no" wire:model.live="purchaseRequisitionNo" class="border text-[12px] border-gray-300 focus:outline-none focus:ring-1 focus:ring-[#828181] focus:border-[#828181] rounded px-1 py-[0.5rem]" placeholder="Enter Purchase Requisition No">
                            </div>

                            <div class="relative group">
                                <button wire:click="resetFilters" class="flex items-center justify-center border border-gray-300 bg-gray-100 focus:outline-none focus:ring-1 focus:ring-[#828181] focus:border-[#828181] rounded w-8 h-8 ml-1 ">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 256 256" class="w-4 h-4" xml:space="preserve">
                                        <g transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                            <path d="M 81.521 31.109 c -0.86 -1.73 -2.959 -2.438 -4.692 -1.575 c -1.73 0.86 -2.436 2.961 -1.575 4.692 c 2.329 4.685 3.51 9.734 3.51 15.01 C 78.764 67.854 63.617 83 45 83 S 11.236 67.854 11.236 49.236 c 0 -16.222 11.501 -29.805 26.776 -33.033 l -3.129 4.739 c -1.065 1.613 -0.62 3.784 0.992 4.85 c 0.594 0.392 1.264 0.579 1.926 0.579 c 1.136 0 2.251 -0.553 2.924 -1.571 l 7.176 -10.87 c 0.001 -0.001 0.001 -0.002 0.002 -0.003 l 0.018 -0.027 c 0.063 -0.096 0.106 -0.199 0.159 -0.299 c 0.049 -0.093 0.108 -0.181 0.149 -0.279 c 0.087 -0.207 0.152 -0.419 0.197 -0.634 c 0.009 -0.041 0.008 -0.085 0.015 -0.126 c 0.031 -0.182 0.053 -0.364 0.055 -0.547 c 0 -0.014 0.004 -0.028 0.004 -0.042 c 0 -0.066 -0.016 -0.128 -0.019 -0.193 c -0.008 -0.145 -0.018 -0.288 -0.043 -0.431 c -0.018 -0.097 -0.045 -0.189 -0.071 -0.283 c -0.032 -0.118 -0.065 -0.236 -0.109 -0.35 c -0.037 -0.095 -0.081 -0.185 -0.125 -0.276 c -0.052 -0.107 -0.107 -0.211 -0.17 -0.313 c -0.054 -0.087 -0.114 -0.168 -0.175 -0.25 c -0.07 -0.093 -0.143 -0.183 -0.223 -0.27 c -0.074 -0.08 -0.153 -0.155 -0.234 -0.228 c -0.047 -0.042 -0.085 -0.092 -0.135 -0.132 L 36.679 0.775 c -1.503 -1.213 -3.708 -0.977 -4.921 0.53 c -1.213 1.505 -0.976 3.709 0.53 4.921 l 3.972 3.2 C 17.97 13.438 4.236 29.759 4.236 49.236 C 4.236 71.714 22.522 90 45 90 s 40.764 -18.286 40.764 -40.764 C 85.764 42.87 84.337 36.772 81.521 31.109 z" style="fill: rgb(0,0,0);"></path>
                                        </g>
                                    </svg>
                                </button>
                                <p class="absolute opacity-0 w-12/12 group-hover:opacity-50 transition-opacity duration-300 rounded-md bg-gray-700 text-[11px] text-white p-1">
                                    Reset
                                </p>
                            </div>
                        </div>
                    </div>

                    <div x-show="openFilters" class="flex space-x-2 mb-1 mt-5">
                        <select wire:model.live="itemsDescription" class="border text-[13px] bg-white border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">Items Description</option>
                            <option value="Amakan">Amakan</option>
                            <option value="Cement">CEMENT</option>
                            <option value="Kahoy">KAHOY</option>
                            <option value="Plywood">PLYWOOD</option>
                        </select>
                        <select wire:model.live="quantity" class="border text-[13px] bg-white border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">Quantity</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <select wire:model.live="unit" class="border text-[13px] bg-white border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">Unit</option>
                            <option value="1">SHEETS</option>
                            <option value="2">BAGS</option>
                            <option value="3">PCS</option>
                            <option value="4">KLS</option>
                           
                        </select>

                        <button class="bg-[#FFBF00] hover:bg-[#FFAF00] text-white px-4 py-2 rounded">Apply Filters</button>
                    </div>
                </div>

                <!-- Table with transaction requests -->
                <div wire:poll.5000ms x-data="{openModalAward: false, openModalTag: false, openPreviewModal: false, selectedFile: null, fileName: ''}" class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-2 border-b text-center font-medium">ID</th>
                                <th class="py-3 px-2 border-b text-center font-medium whitespace-nowrap toggle-column name-col">PUCHASE ORDER </th>
                                <th class="py-3 px-2 border-b text-center font-medium whitespace-nowrap toggle-column purok-col">MATERIAL UNIT </th>
                                <th class="py-3 px-2 border-b text-center font-medium whitespace-nowrap toggle-column barangay-col">ITEM DESCRIPTION</th>
                                <th class="py-3 px-2 border-b text-center font-medium whitespace-nowrap toggle-column contact-col">QUANTITY</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($materials as $material)
                            <tr>
                                <!-- ID -->
                                <td class="py-2 px-2 text-center border-b capitalize whitespace-nowrap">{{ $material->id }}</td>

                                <!-- Purchase Order -->
                                <td class="py-2 px-2 text-center border-b capitalize whitespace-nowrap">{{ $material->PurchaseOrder->po_number }}</td>

                                <!-- Material Unit -->
                                <td class="py-2 px-2 text-center border-b capitalize whitespace-nowrap">{{ $material->MaterialUnit->unit }}</td>
                                
                                <!-- Item Description -->
                                <td class="py-2 px-2 text-center border-b capitalize whitespace-nowrap">{{ $material->item_description }}</td>

                                <!-- Quantity -->
                                <td class="py-2 px-2 text-center border-b capitalize whitespace-nowrap">{{ $material->quantity }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-4 px-2 text-center border-b">No materials found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination controls -->
                    <div class="flex justify-end text-[12px] mt-4">
                        <button @click="prevPage" :disabled="currentPage === 1" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-l disabled:opacity-50">
                            Prev
                        </button>
                        <template x-for="page in totalPages" :key="page">
                            <button @click="goToPage(page)" :class="{'bg-custom-green text-white': page === currentPage, 'bg-gray-200': page !== currentPage}" class="px-4 py-2 mx-1 rounded">
                                <span x-text="page"></span>
                            </button>
                        </template>
                        <button @click="nextPage" :disabled="currentPage === totalPages" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-r disabled:opacity-50">
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