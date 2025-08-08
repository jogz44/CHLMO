<div x-data="{ openFilters: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
    <div x-data="{ openModalLot: false}" class="flex bg-gray-100 text-[12px]">
        <!-- Main Content -->
        <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">
            <div class="bg-white rounded shadow mb-4 flex items-center justify-between relative p-3 z-0">
                <div class="flex items-center">
                    <h2 class="text-[13px] ml-5 text-gray-700">RELOCATION SITES</h2>
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
                        <th class="py-2 px-2 border-b text-center font-medium">Barangay</th>
                        <th class="py-2 px-2 border-b text-center font-medium">Total Land Area (hectares)</th>
                        <th class="py-2 px-2 border-b text-center font-medium">Total No. Of Lots (m&sup2;)</th>
                        <th class="py-2 px-2 border-b text-center font-medium">Total Lot No. for Community Facilities/Road Lots/Open Space (m&sup2;)</th>
                        <th class="py-2 px-2 border-b text-center font-medium">Residential Lots</th>
                        <th class="py-2 px-2 border-b text-center font-medium">No. of Awardees</th>
                        <th class="py-2 px-2 border-b text-center font-medium">Status</th>
                        <th class="py-2 px-2 border-b text-center font-medium">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($relocationSites as $relocationSite)
                            <tr>
                                <td class="py-2 px-2 text-center border-b whitespace-normal break-words">{{ $relocationSite->relocation_site_name }}</td>
                                <td class="py-2 px-2 text-center border-b">{{ $relocationSite->barangay->name ?? 'N/A' }}</td>
                                <td class="py-2 px-2 text-center border-b">
                                    {{ isset($relocationSite->total_land_area) ? rtrim(rtrim(number_format($relocationSite->total_land_area, 2, '.', ''), '0'), '.') : 'N/A' }} hectares
                                </td>

                                <td class="py-2 px-2 text-center border-b">
                                    {{ isset($relocationSite->total_no_of_lots) ? rtrim(rtrim(number_format($relocationSite->total_no_of_lots, 2, '.', ''), '0'), '.') : 'N/A' }} m&sup2;
                                </td>

                                <td class="py-2 px-2 text-center border-b">
                                    {{ isset($relocationSite->community_facilities_road_lots_open_space) ? rtrim(rtrim(number_format($relocationSite->community_facilities_road_lots_open_space, 2, '.', ''), '0'), '.') : 'N/A' }} m&sup2;
                                </td>

                                <td class="py-2 px-2 text-center border-b">
                                    @php
                                        $residentialSize = $relocationSite->total_no_of_lots - $relocationSite->community_facilities_road_lots_open_space;
                                    @endphp
                                    {{ rtrim(rtrim(number_format($residentialSize, 2, '.', ''), '0'), '.') }}
                                    <span class="text-sm text-gray-500">
                                        ({{ $relocationSite->awardees->count() }} awarded)
                                    </span>
                                </td>
                                <td class="py-2 px-2 text-center border-b">
                                    @php
                                        $awardeesCounts = $this->getAwardeesCount($relocationSite->id);
                                    @endphp
                                    <div class="flex flex-col space-y-1">
                                        <span class="text-sm">
                                            Assigned: {{ $awardeesCounts['assigned'] }}
                                        </span>
                                                            <span class="text-sm">
                                            Actual: {{ $awardeesCounts['actual'] }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-2 px-2 text-center border-b">
                                    @php
                                        $remainingSize = $this->getRemainingLotSize($relocationSite->id);
                                        $totalResidentialSize = $relocationSite->total_no_of_lots - $relocationSite->community_facilities_road_lots_open_space;
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $this->getStatusBadgeClass($remainingSize, $totalResidentialSize) }}">
                                        {{ $this->getStatusText($remainingSize, $totalResidentialSize) }}
                                    </span>
                                </td>
                                <td class="py-2 px-2 text-center border-b whitespace-nowrap">
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

                        <!-- TOTAL LAND AREA (hectares) -->
                        <div class="mb-4">
                            <label class="block text-[12px] font-medium mb-2 text-black">
                                TOTAL LAND AREA (hectares)<span class="text-red-500">*</span>
                            </label>
                            <input wire:model="total_land_area"
                                type="number"
                                step="0.01"
                                class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none text-[12px]"
                                placeholder="5.5">
                            @error('total_land_area') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <!-- TOTAL NUMBER OF LOTS (m²) -->
                        <div class="mb-4">
                            <label class="block text-[12px] font-medium mb-2 text-black">
                                TOTAL NUMBER OF LOTS (m&sup2;)<span class="text-red-500">*</span>
                            </label>
                            <input wire:model="total_no_of_lots"
                                type="number"
                                step="0.01"
                                class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none text-[12px]"
                                placeholder="200.25">
                            @error('total_number_of_lots') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <!-- TOTAL LOT NUMBER OF COMMUNITY FACILITIES/ ROAD LOTS/ OPEN SPACE (m²) -->
                        <div class="mb-4">
                            <label class="block text-[12px] font-medium mb-2 text-black">
                                TOTAL LOT NUMBER OF COMMUNITY FACILITIES/ ROAD LOTS/ OPEN SPACE (m&sup2;)<span class="text-red-500">*</span>
                            </label>
                            <input wire:model="total_lot_number_of_community_facilities"
                                type="number"
                                step="0.01"
                                class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none text-[12px]"
                                placeholder="30.75">
                            @error('total_lot_number_of_community_facilities') <span class="error">{{ $message }}</span> @enderror
                        </div>


                        <!-- Residential Lots -->
                        {{--                        <div class="mb-4">--}}
                        {{--                            <label class="block text-[12px] font-medium mb-2 text-black">--}}
                        {{--                                RESIDENTIAL LOTS (m&sup2;)--}}
                        {{--                            </label>--}}
                        {{--                            <input wire:model="residential_lots"--}}
                        {{--                                    type="number"--}}
                        {{--                                   disabled--}}
                        {{--                                   class="w-full px-3 py-1 bg-gray-200 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none text-[12px]"--}}
                        {{--                                   placeholder="200">--}}
                        {{--                        </div>--}}

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
                <div class="text-lg font-medium mb-4">Update Relocation Site Details</div>

                @if($editingRelocationSite)
                    <form wire:submit="updateRelocationSite">
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">
                                Relocation Site
                            </label>
                            <div class="text-gray-700">
                                {{ $editingRelocationSite->relocation_site_name }}
                            </div>
                        </div>

                        <!-- Assigned Lots Section -->
                        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-medium mb-3">Assigned Lots Information</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">
                                        Total Assigned Awardees
                                    </label>
                                    <div class="text-gray-700 font-medium">
                                        {{ $editingRelocationSite->awardees()->count() }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">
                                        Total Assigned Space
                                    </label>
                                    <div class="text-gray-700 font-medium">
                                        {{ $editingRelocationSite->awardees()->sum('assigned_relocation_lot_size') }} m²
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actual Lots Section -->
                        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-medium mb-3">Actual Lots Information</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">
                                        Total Actual Awardees
                                    </label>
                                    <div class="text-gray-700 font-medium">
                                        {{ $editingRelocationSite->actualAwardees()->count() }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">
                                        Total Actual Space
                                    </label>
                                    <div class="text-gray-700 font-medium">
                                        {{ $editingRelocationSite->actualAwardees()->sum('actual_relocation_lot_size') }} m²
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Site Configuration -->
                        <div class="space-y-4">
                            <!-- Total Land Area -->
                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Total Land Area (hectares) <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    wire:model="new_total_land_area"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                                    step="0.01"
                                    min="0"
                                >
                                @if(is_numeric($new_total_land_area))
                                    <div class="text-sm text-gray-500 mt-1">
                                        Formatted: {{ number_format($new_total_land_area, 2) }} ha
                                    </div>
                                @endif
                                @error('new_total_land_area')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Total Number of Lots -->
                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Total Number of Lots (m²)<span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    wire:model="new_total_no_of_lots"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                                    step="0.01" {{-- changed from 1 to 0.01 --}}
                                    min="0"
                                >
                                @if(is_numeric($new_total_no_of_lots))
                                    <div class="text-sm text-gray-500 mt-1">
                                        Formatted: {{ number_format($new_total_no_of_lots, 2) }} m²
                                    </div>
                                @endif
                                @error('new_total_no_of_lots')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Community Facilities -->
                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Community Facilities/Road Lots/Open Space (m²)<span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    wire:model="new_total_lot_number_of_community_facilities"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                                    step="0.01" {{-- changed from 1 to 0.01 --}}
                                    min="0"
                                >
                                @if(is_numeric($new_total_lot_number_of_community_facilities))
                                    <div class="text-sm text-gray-500 mt-1">
                                        Formatted: {{ number_format($new_total_lot_number_of_community_facilities, 2) }} m²
                                    </div>
                                @endif
                                @error('new_total_lot_number_of_community_facilities')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Available Residential Lots -->
                            <div class="bg-blue-50 p-3 rounded-md">
                                <label class="block text-sm font-medium mb-2">
                                    Available Residential Lots
                                </label>
                                <div class="text-gray-700 font-medium">
                                    {{ number_format($new_residential_lots ?? ($new_total_no_of_lots - $new_total_lot_number_of_community_facilities), 2) }} lots
                                </div>
                            </div>

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
                                    Update Site
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

                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-6xl sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                Awardees for {{ $selectedRelocationSite->relocation_site_name }}
                            </h3>

                            <!-- Summary Statistics -->
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-medium text-gray-700 mb-2">Assigned Lots Summary</h4>
                                    <div class="grid grid-cols-2 gap-2 text-sm">
                                        <div>
                                            <span class="text-gray-600">Total Awardees:</span>
                                            <span class="font-medium">{{ $selectedRelocationSite->awardees->count() }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Total Space:</span>
                                            <span class="font-medium">{{ $selectedRelocationSite->awardees->sum('assigned_relocation_lot_size') }} m²</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-medium text-gray-700 mb-2">Actual Lots Summary</h4>
                                    <div class="grid grid-cols-2 gap-2 text-sm">
                                        <div>
                                            <span class="text-gray-600">Total Actual:</span>
                                            <span class="font-medium">{{ $selectedRelocationSite->actualAwardees->count() }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Total Space:</span>
                                            <span class="font-medium">{{ $selectedRelocationSite->actualAwardees->sum('actual_relocation_lot_size') }} m²</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($selectedRelocationSite->awardees->count() > 0)
                                <div class="max-h-96 overflow-y-auto">
                                    <table class="min-w-full bg-white border border-gray-200">
                                        <thead class="bg-gray-100 sticky top-0">
                                        <tr>
                                            <th class="py-2 px-2 text-left font-medium">Name</th>
                                            <th class="py-2 px-2 text-center font-medium">Assigned Block</th>
                                            <th class="py-2 px-2 text-center font-medium">Assigned Lot</th>
                                            <th class="py-2 px-2 text-center font-medium">Assigned Size</th>
                                            <th class="py-2 px-2 text-center font-medium">Actual Block</th>
                                            <th class="py-2 px-2 text-center font-medium">Actual Lot</th>
                                            <th class="py-2 px-2 text-center font-medium">Actual Size</th>
                                            <th class="py-2 px-2 text-center font-medium">Status</th>
                                            <th class="py-2 px-2 text-center font-medium">Date Granted</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($selectedRelocationSite->awardees as $awardee)
                                            <tr class="hover:bg-gray-50">
                                                <td class="py-2 px-2 text-left border-b">
                                                    {{ $awardee->taggedAndValidatedApplicant->applicant->person->full_name ?? 'N/A' }}
                                                </td>
                                                <td class="py-2 px-2 text-center border-b">
                                                    {{ $awardee->assigned_block }}
                                                </td>
                                                <td class="py-2 px-2 text-center border-b">
                                                    {{ $awardee->assigned_lot }}
                                                </td>
                                                <td class="py-2 px-2 text-center border-b">
                                                    {{ $awardee->assigned_relocation_lot_size }} m²
                                                </td>
                                                <td class="py-2 px-2 text-center border-b">
                                                    {{ $awardee->actual_block ?? '-' }}
                                                </td>
                                                <td class="py-2 px-2 text-center border-b">
                                                    {{ $awardee->actual_lot ?? '-' }}
                                                </td>
                                                <td class="py-2 px-2 text-center border-b">
                                                    {{ $awardee->actual_relocation_lot_size ?? '-' }} {{ $awardee->actual_relocation_lot_size ? 'm²' : '' }}
                                                </td>
                                                <td class="py-2 px-2 text-center border-b">
                                                    @if($awardee->actual_relocation_lot_size)
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Actual Lot Assigned
                                                </span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Temporary Lot
                                                </span>
                                                    @endif
                                                </td>
                                                <td class="py-2 px-2 text-center border-b">
                                                    {{ $awardee->grant_date ? \Carbon\Carbon::parse($awardee->grant_date)->format('m/d/Y') : '-' }}
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
