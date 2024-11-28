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
                            <svg class="absolute top-[9px] left-4" width="19" height="19" viewBox="0 0 21 21"
                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.625 16.625C13.491 16.625 16.625 13.491 16.625 9.625C16.625 5.75901 13.491 2.625 9.625 2.625C5.75901 2.625 2.625 5.75901 2.625 9.625C2.625 13.491 5.75901 16.625 9.625 16.625Z"
                                      stroke="#787C7F" stroke-width="1.75" stroke-linecap="round"
                                      stroke-linejoin="round" />
                                <path d="M18.3746 18.375L14.5684 14.5688" stroke="#787C7F" stroke-width="1.75"
                                      stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <input wire:model.live="search"
                                   type="search"
                                   class="rounded-md px-12 py-2 placeholder:text-[13px] z-10 border border-gray-300 bg-[#f7f7f9] hover:ring-custom-yellow focus:ring-custom-yellow"
                                   placeholder="Search">
                        </div>
                    </div>
                </div>

                <div x-show="openFilters" class="flex space-x-2 mb-1 mt-5">
                    <select wire:model.live="filterBarangay"
                            class="border text-[13px] bg-white border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm w-full">
                        <option value="">All Barangays</option>
                        @foreach($barangays as $barangay)
                            <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                        @endforeach
                    </select>
                    <select wire:model.live="filterPurok"
                            class="border text-[13px] bg-white border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm w-full">
                        <option value="">All Puroks</option>
                        @foreach($filterPuroks as $purok)
                            <option value="{{ $purok->id }}">{{ $purok->name }}</option>
                        @endforeach
                    </select>
                    <button wire:click="resetFilters"
                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 w-full">
                        Reset Filters
                    </button>
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

                                    <button wire:click="openAwardeesModal({{ $relocationSite->id }})"
                                            class="px-2 py-1 text-xs font-medium text-green-600 hover:text-green-800 focus:outline-none">
                                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
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
                            <!-- Submit button and alert message -->
                            <div>
                                <div class="alert"
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
                                <!-- Add Relocation Site Button -->
                                <button type="submit"
                                        class="w-full py-2 px-12 bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                            <span class="text-[12px]">
                                                CREATE
                                            </span>
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
                                    if (Object.keys(obj).length){
                                        Livewire.dispatch('alert', [obj])
                                    }
                                })
                            </script>
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
                            <button type="button"
                                    wire:click="closeEditModal"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </button>
                            <div>
                                <div class="alert"
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
                                <!-- Update Relocation Site -->
                                <button type="submit"
                                        class="px-4 py-2 text-sm font-medium bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Update Size
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
                                    if (Object.keys(obj).length){
                                        Livewire.dispatch('alert', [obj])
                                    }
                                })
                            </script>
                        </div>
                    </form>
                @endif
            </div>
        </x-modal>

        <!-- Awardees Modal -->
        @if($isAwardeesModalVisible)
            <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeAwardeesModal"></div>

                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                Awardees for {{ $selectedRelocationSite->relocation_site_name }}
                            </h3>

                            @if($selectedRelocationSite->awardees->count() > 0)
                                <div class="max-h-96 overflow-y-auto">
                                    <table class="min-w-full bg-white border border-gray-200">
                                        <thead class="bg-gray-100 sticky top-0">
                                        <tr>
                                            <th class="py-2 px-2 text-center font-medium">Name</th>
                                            <th class="py-2 px-2 text-center font-medium">Lot Size (m²)</th>
                                            <th class="py-2 px-2 text-center font-medium">Date Granted</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($selectedRelocationSite->awardees as $awardee)
                                            <tr>
                                                <td class="py-2 px-2 text-center border-b">
                                                    {{ $awardee->taggedAndValidatedApplicant->applicant->person->full_name ?? 'N/A' }}
                                                </td>
                                                <td class="py-2 px-2 text-center border-b">
                                                    {{ $awardee->lot_size }} m²
                                                </td>
                                                <td class="py-2 px-2 text-center border-b">
                                                    {{ \Carbon\Carbon::parse($awardee->grant_date)->format('m/d/Y') }}

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-center text-gray-500">No awardees found for this relocation site.</p>
                            @endif
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse">
                            <button type="button"
                                    wire:click="closeAwardeesModal"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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