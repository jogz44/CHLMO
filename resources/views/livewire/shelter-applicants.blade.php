<div x-data="{ openFilters: false, openModal: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <!-- Main Content -->
        <div class="flex-1 h-screen p-6 overflow-auto">
            <!-- Header -->
            <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-0 relative p-3">
                <h2 class="text-[13px] ml-5 text-gray-700">SHELTER ASSISTANCE PROGRAM APPLICANTS</h2>
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
                        <div class="flex relative z-10 md:block border-gray-300">
                            <svg class="absolute top-[8px] left-4" width="19" height="19" viewBox="0 0 21 21"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.625 16.625C13.491 16.625 16.625 13.491 16.625 9.625C16.625 5.75901 13.491 2.625 9.625 2.625C5.75901 2.625 2.625 5.75901 2.625 9.625C2.625 13.491 5.75901 16.625 9.625 16.625Z"
                                    stroke="#787C7F" stroke-width="1.75" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M18.3746 18.375L14.5684 14.5688" stroke="#787C7F" stroke-width="1.75"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <input type="search" name="search" wire:model.live.debounce.300ms="search"
                                class="capitalize rounded-md px-12 py-2 placeholder:text-[13px] border border-gray-300 bg-[#f7f7f9] hover:ring-custom-yellow focus:ring-custom-yellow"
                                placeholder="Search">
                            <button wire:click="clearSearch" class="absolute bottom-1 right-4 text-2xl text-gray-500">
                                &times; <!-- This is the "x" symbol -->
                            </button>
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
                    </div>
                </div>

                <div x-show="openFilters" class="flex space-x-2 mb-1 mt-5">
                    <select wire:model.live="selectedOriginOfRequest" class="border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                        <option value="">Select Request Origin</option>
                        @foreach ($OriginOfRequests as $origin)
                        <option value="{{ $origin->id }}">{{ $origin->name }}</option>
                        @endforeach
                    </select>
                    <select wire:model.live="selectedTaggingStatus" class="bg-gray-50 border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                        <option value="">Status</option>
                        @foreach($taggingStatuses as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                    <button wire:click="resetFilters" class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-4 py-1.5 rounded-full">
                        Reset Filter
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div x-data="{isEditModalOpen: false}" class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-2 border-b text-center font-medium">PROFILE NO.</th>
                            <th class="py-2 px-2 border-b text-center font-medium">NAME</th>
                            <th class="py-2 px-2 border-b text-center font-medium">DATE REQUEST</th>
                            <th class="py-2 px-2 border-b text-center font-medium">ORIGIN OF REQUEST</th>
                            <th class="py-2 px-2 border-b text-center font-medium">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applicants as $applicant)
                        <tr>
                            <td class="py-4 px-2 text-center border-b">{{ $applicant->profile_no }}</td>
                            <td class="py-4 px-2 text-center capitalize border-b">{{ optional($applicant->person)->full_name }}</td>
                            <td class="py-4 px-2 text-center capitalize border-b">{{ $applicant->date_request->format('Y-m-d') }}</td>
                            <td class="py-4 px-2 text-center capitalize border-b">{{ $applicant->OriginOfRequest->name ?? 'N/A' }}</td>
                            <td class="py-4 px-2 text-center border-b">
                                <button wire:click="openModalEdit({{ $applicant->id }})" @click="isEditModalOpen = true" class="text-custom-red underline px-4 py-1.5">Edit</button>
                                @if ($applicant->profiledTagged)
                                <button class="bg-gray-400 text-white px-5 py-1.5 rounded-full cursor-not-allowed">
                                    Tagged
                                </button>
                                @else
                                <button @click="window.location.href='{{ route('shelter-applicant-details', ['profileNo' => $applicant->id]) }}'"
                                    class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-8 py-1.5 rounded-full">
                                    Tag
                                </button>
                                @endif

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No applicants found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="py-4 px-3">
                    {{ $applicants->links() }}
                </div>

                <!-- EDIT APPLICANT MODAL -->
                <div x-cloak x-show="isEditModalOpen" class="fixed inset-0 flex z-50 items-center justify-center w-full bg-black bg-opacity-50 shadow-lg">
                    <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-black">Edit Applicant</h3>
                            <button @click="isEditModalOpen = false" class="text-gray-400 hover:text-gray-200">&times;</button>
                        </div>
                        <!-- Form -->
                        <form wire:submit.prevent="submitForm">

                            <!-- Name Fields -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="first-name">FIRST NAME</label>
                                    <input type="text" id="first-name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" wire:model="first_name">
                                </div>

                                <div>
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="middle-name">MIDDLE NAME</label>
                                    <input type="text" id="middle-name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" wire:model="middle_name">
                                </div>

                                <div>
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="last-name">LAST NAME</label>
                                    <input type="text" id="last-name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" wire:model="last_name">
                                </div>

                                <div>
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="suffix-name">SUFFIX NAME</label>
                                    <input type="text" id="suffix-name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" wire:model="suffix_name">
                                </div>
                            </div>

                            <!-- Origin of Request -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="origin-of-request">ORIGIN OF REQUEST</label>
                                <input type="text" id="origin-of-request" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px]" wire:model="origin_name" placeholder="Origin of Request">
                            </div>

                            <!-- Buttons -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <div class="alert"
                                        :class="{primary:'alter-primary', success:'alert-success', danger:'alert-danger', warning:'alter-warning'}[(alert.type ?? 'primary')]"
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
                                    <!-- SAVE Button -->
                                    <button type="submit" wire:click.prevent="submitForm"
                                        class="w-full py-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                        <span class="text-[12px]"> SAVE </span>
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
                                <button type="button" @click="isEditModalOpen = false" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
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
            <form wire:submit.prevent="submitForm">

                <!-- Date Applied Field -->
                <div class="mb-4">
                    <label class="block text-[12px] font-medium mb-2 text-black" for="date-applied">DATE OF REQUEST</label>
                    <input type="date" id="date-applied" wire:model="date_request"
                        class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px]"
                        max="{{ now()->toDateString() }}">
                    @error('date_request') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Name Fields -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-[12px] font-medium mb-2 text-black" for="first-name">FIRST NAME</label>
                        <input type="text" id="first-name" wire:model="first_name"
                            class="w-full uppercase px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px]"
                            placeholder="First Name">
                        @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[12px] font-medium mb-2 text-black" for="middle-name">MIDDLE NAME</label>
                        <input type="text" id="middle-name" wire:model="middle_name"
                            class="w-full uppercase px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px]"
                            placeholder="Middle Name">
                        @error('middle_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[12px] font-medium mb-2 text-black" for="last-name">LAST NAME</label>
                        <input type="text" id="last-name" wire:model="last_name"
                            class="w-full uppercase px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px]"
                            placeholder="Last Name">
                        @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[12px] font-medium mb-2 text-black" for="suffix-name">SUFFIX NAME</label>
                        <input type="text" id="suffix-name" wire:model="suffix_name"
                            class="w-full uppercase px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px]"
                            placeholder="Suffix Name">
                        @error('suffix_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Request Origin Field -->
                <div class="mb-4">
                    <label class="block text-[12px] font-medium mb-2 text-black" for="request_origin_id">ORIGIN OF REQUEST</label>
                    <select wire:model="request_origin_id" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px]">
                        <option value="">Select Origin of Request</option>
                        @foreach ($OriginOfRequests as $origin)
                        <option value="{{ $origin->id }}">{{ $origin->name }}</option>
                        @endforeach
                    </select>
                    @error('request_origin_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <button type="submit" wire:click.prevent="submitForm" class="w-full py-2 bg-custom-green hover:bg-custom-red text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                        <span class="text-sm">+ ADD APPLICANT</span>
                    </button>

                    <button type="button" @click="openModal = false"
                        class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                        <span class="text-[12px]">CANCEL</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    function capitalizeInput(input) {
        input.value = input.value.toLowerCase().replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }
</script>