<div x-data="{ openFilters: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
    <div x-data="{ openModalLot: false}" class="flex bg-gray-100 text-[12px]">
        <!-- Main Content -->
        <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">
            <div class="bg-white rounded shadow mb-4 flex items-center justify-between relative p-3 z-0">
                <div class="flex items-center">
                    <h2 class="text-[13px] ml-5 text-gray-700">LOT LIST</h2>
                </div>
                <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                <div class="relative z-0">
                    <button wire:click="openModal"
                            class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white px-4 py-2 rounded">
                        Add Relocation Site
                    </button>
                    <button class="bg-custom-green text-white px-4 py-2 rounded">
                        Export
                    </button>
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
                </div>
            </div>

            <!-- Table -->
            <div x-data="{openModalEditLot: false}" class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-2  text-center font-medium">Relocation Site Name</th>
                        <th class="py-2 px-2 border-b text-center  font-medium">Purok</th>
                        <th class="py-2 px-2 border-b text-center font-medium">Barangay</th>
                        <th class="py-2 px-2 border-b text-center font-medium">Total Lot Size (m&sup2;)</th>
                        <th class="py-2 px-2 border-b text-center font-medium">No. of Awardees</th>
                        <th class="py-2 px-2 border-b text-center font-medium">Lot Size Left (m&sup2;)</th>
                        <th class="py-2 px-2 border-b text-center font-medium">Status</th>
                        <th class="py-2 px-2 border-b text-center font-medium">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($relocationSites as $relocationSite)
                            <tr>
                                <td class="py-2 px-2 text-center border-b">{{ $relocationSite->relocation_site_name }}</td>
                                <td class="py-2 px-2 text-center border-b">{{ $relocationSite->address->purok->name ?? 'N/A' }}</td>
                                <td class="py-2 px-2 text-center border-b">{{ $relocationSite->address->barangay->name ?? 'N/A' }}</td>
                                <td class="py-2 px-2 text-center border-b">
                                    {{ $relocationSite->total_lot_size ?? 'N/A' }} m&sup2;
                                </td>
                                <td class="py-2 px-2 text-center border-b">{{ $relocationSite->awardees->count() }}</td>
                                <td class="py-2 px-2 text-center text-red-500 border-b">
                                    {{ $this->getRemainingLotSize($relocationSite->id) }} m&sup2;
                                </td>
                                <td class="py-2 px-2 text-center border-b">
                                    @php
                                        $remainingSize = $this->getRemainingLotSize($relocationSite->id);
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $this->getStatusBadgeClass($remainingSize, $relocationSite->total_lot_size) }}">
                                        {{ $this->getStatusText($remainingSize, $relocationSite->total_lot_size) }}
                                    </span>
                                </td>
                                <td class="py-2 px-2 text-center border-b">
                                    <button wire:click="openEditModal({{ $relocationSite->id }})"
                                            class="px-2 py-1 text-xs font-medium text-blue-600 hover:text-blue-800 focus:outline-none">
                                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 px-2 text-center border-b">No relocation sites found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($isModalOpen)
            <div class="fixed z-50 inset-0 flex items-center justify-center bg-black bg-opacity-50" x-cloak
                 style="font-family: 'Poppins', sans-serif;">
                <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-md font-semibold text-black">ADD RELOCATION SITE</h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-200">
                            &times;
                        </button>
                    </div>
                    <form wire:submit.prevent="createRelocationSite">
                        <div class="mb-4">
                            <label class="block text-[12px] font-medium mb-2 text-black">
                                LOT/RELOCATION NAME <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="relocation_site_name"
                                   type="text"
                                   id="relocation_name"
                                   class="capitalize w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                                   placeholder="Canocotan Relocation Lot"
                                   required
                                   oninput="capitalizeInput(this)">
                            @error('relocation_site_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Lot Number -->
                        <div class="mb-4">
                            <label class="block text-[12px] font-medium mb-2 text-black">
                                LOT NAME/NUMBER
                            </label>
                            <input wire:model="lot_number"
                                   type="text"
                                   class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none text-[12px]"
                                   placeholder="Lot name or number..."
                                   oninput="capitalizeInput(this)">
                            @error('lot_number') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Block Identifier -->
                        <div class="mb-4">
                            <label class="block text-[12px] font-medium mb-2 text-black">
                                BLOCK IDENTIFIER
                            </label>
                            <input wire:model="block_identifier"
                                   type="text"
                                   class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none text-[12px]"
                                   placeholder="Block identifier..."
                                   oninput="capitalizeInput(this)">
                            @error('block_identifier') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Barangay Field -->
                        <div class="mb-3">
                            <label class="block text-[12px] font-medium mb-2 text-black">
                                BARANGAY <span class="text-red-500">*</span>
                            </label>
                            <select id="barangay" wire:model.live="barangay_id"
                                    class="w-full px-3 py-1 text-[12px] select2-barangay bg-white border border-gray-600 rounded-lg text-gray-800 uppercase"
                                    required>
                                <option value="">Select Barangay</option>
                                @foreach($barangays as $barangay)
                                    <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                @endforeach
                            </select>
                            @error('barangay_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Purok Field -->
                        <div class="mb-3">
                            <label class="block text-[12px] font-medium mb-2 text-black">
                                PUROK <span class="text-red-500">*</span>
                            </label>
                            <select id="purok" wire:model.live="purok_id"
                                    class="w-full px-3 py-1 text-[12px] select2-purok bg-white border border-gray-600 rounded-lg focus:outline-none text-gray-800 uppercase"
                                    required>
                                <option value="">Select Purok</option>
                                @foreach($puroks as $purok)
                                    <option value="{{ $purok->id }}">{{ $purok->name }}</option>
                                @endforeach
                            </select>
                            @error('purok_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-[12px] font-medium mb-2 text-black">
                                TOTAL LOT SIZE (m&sup2;) <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="total_lot_size"
                                   type="number"
                                   id="total_lot_size"
                                   class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]"
                                   placeholder="1000"
                                   required
                                   oninput="validateNumberInput(this)">
                            @error('total_lot_size') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Modal Footer --}}
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-6">
                            <button type="submit"
                                    class="w-full py-2 bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                <span class="text-[12px]">
                                    CREATE
                                </span>
                            </button>
                            <!-- Cancel Button -->
                            <button type="button" wire:click="closeModal"
                                    class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                CANCEL
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- resources/views/livewire/edit-relocation-site.blade.php -->
        <x-modal wire:model="showEditModal">
            <div class="p-4">
                <div class="text-lg font-medium mb-4">Update Total Lot Size</div>

                @if($editingRelocationSite)
                    <form wire:submit="updateTotalSize">
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">
                                Relocation Site
                            </label>
                            <div class="text-gray-700">
                                {{ $editingRelocationSite->relocation_site_name }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">
                                Current Total Size
                            </label>
                            <div class="text-gray-700">
                                {{ $editingRelocationSite->total_lot_size }} m²
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">
                                Currently Allocated
                            </label>
                            <div class="text-gray-700">
                                {{ $editingRelocationSite->awardees()->sum('lot_size') }} m²
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="newTotalLotSize" class="block text-sm font-medium mb-2">
                                New Total Size (m²) <span class="text-red-500">*</span>
                            </label>
                            <input
                                    type="number"
                                    id="newTotalLotSize"
                                    wire:model="newTotalLotSize"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                                    step="0.01"
                                    min="0"
                            >
                            @error('newTotalLotSize')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button
                                    type="button"
                                    wire:click="closeEditModal"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                            >
                                Cancel
                            </button>
                            <button
                                    type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                Update Size
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </x-modal>
    </div>
</div>
<script>
    function capitalizeInput(input) {
        input.value = input.value.toLowerCase().replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }
</script>
<script>
    // Function to allow only numeric input
    function validateNumberInput(input) {
        // Remove any characters that are not digits
        input.value = input.value.replace(/[^0-9]/g, '');
    }
</script>