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
                                <input wire:model.live.debounce.500ms="search"
                                        type="search"
                                       class="rounded-md px-12 py-2 placeholder:text-[13px] z-10 border border-gray-300 bg-[#f7f7f9] hover:ring-custom-yellow focus:ring-custom-yellow"
                                       placeholder="Search">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <label class="text-center mt-2 mr-1" for="start_date">
                                Date Applied From:
                            </label>
                            <input wire:model.live="startDate"
                                   type="date"
                                   class="border text-[13px] border-gray-300 rounded px-2 py-1"
                                   max="{{ now()->toDateString() }}"
                                   value="{{ now()->toDateString() }}">
                            <label class="text-center mt-2 ml-2 mr-1" for="end_date">
                                To:
                            </label>
                            <input wire:model.live="endDate"
                                   type="date"
                                   class="border text-[13px] border-gray-300 rounded px-2 py-1 mr-1"
                                   max="{{ now()->toDateString() }}"
                                   value="{{ now()->toDateString() }}">

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
                        <select wire:model.live="barangay"
                                class="bg-white border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">All Barangays</option>
                            @foreach($barangays as $brgy)
                                <option value="{{ $brgy}}">{{ $brgy}}</option>
                            @endforeach
                        </select>
                        <select wire:model.live="purok"
                                class="bg-white border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">All Puroks</option>
                            @foreach($puroks as $purokName)
                                <option value="{{ $purokName}}">{{ $purokName}}</option>
                            @endforeach
                        </select>
                        <select wire:model.live="relocation_site"
                                class="bg-white border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                            <option value="">All Relocation Sites</option>
                            @foreach($relocationSites as $site)
                                <option value="{{ $site}}">{{ $site }}</option>
                            @endforeach
                        </select>
                        <button wire:click="resetFilters"
                                class="bg-gray-300 px-2 py-1 rounded-full">
                            Reset Filters
                        </button>
                    </div>
                </div>

                <!-- Table with transaction requests -->
                <div x-data="{openModalTransfer: false, openPreviewModal: false}" class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-2  text-center font-medium whitespace-nowrap">ID</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words">Awardee</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words">Lot</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words">Block</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words">Barangay</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words">Purok</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words">Relocation Site</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal break-words">Lot Size (m&sup2;)</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">Grant Date</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-normal">Status</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($awardees as $awardee)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4 px-2 text-center border-b whitespace-nowrap">{{ $awardee->taggedAndValidatedApplicant->applicant->applicant_id }}</td>
                                    <td class="py-4 px-2 text-center border-b whitespace-normal break-words">
                                        <button @click="window.location.href = '{{ route('awardee-details', ['applicantId' => $awardee->id]) }}'"
                                                class="underline">
{{--                                            Details--}}
                                            {{ $awardee->taggedAndValidatedApplicant->applicant->person->full_name ?? 'N/A' }}
                                        </button>
                                    </td>
                                    <td class="py-4 px-2 text-center border-b whitespace-normal break-words">{{ $awardee->relocationLot->lot_number ?? 'N/A' }}</td>
                                    <td class="py-4 px-2 text-center border-b whitespace-normal break-words">{{ $awardee->relocationLot->block_identifier ?? 'N/A' }}</td>
                                    <td class="py-4 px-2 text-center border-b whitespace-normal break-words">{{ $awardee->relocationLot->address->barangay->name ?? 'N/A' }}</td>
                                    <td class="py-4 px-2 text-center border-b whitespace-normal break-words">{{ $awardee->relocationLot->address->purok->name ?? 'N/A' }}</td>
                                    <td class="py-4 px-2 text-center border-b whitespace-normal break-words">{{ $awardee->relocationLot->relocation_site_name ?? 'N/A' }}</td>
                                    <td class="py-4 px-2 text-center border-b whitespace-normal">{{ $awardee->lot_size }} {{ $awardee->lotSizeUnit->lot_size_unit_short_name ?? '' }} m&sup2;</td>
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
                                    <td class="py-4 px-2 text-center border-b whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            @if($awardee->is_blacklisted)
                                                <!-- Blacklisted Button -->
                                                <button
                                                        class="px-4 py-2 bg-red-500 text-white rounded cursor-not-allowed"
                                                        disabled>
                                                    Blacklisted
                                                </button>
                                            @elseif($awardee->documents_submitted)
                                                <!-- Documents Submitted Button and Transfer -->
                                                <button
                                                        class="px-4 py-2 bg-green-600 text-white rounded cursor-default">
                                                    Submitted
                                                </button>
                                                <button
                                                        wire:click="openConfirmModal({{ $awardee->id }})"
                                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                                    Transfer
                                                </button>
                                            @else
                                                <!-- Initial Transfer Button -->
                                                <button
                                                        wire:click="openTransferModal({{ $awardee->id }})"
                                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                                    Transfer
                                                    <div wire:loading>
                                                        <svg aria-hidden="true"
                                                             class="w-3 h-3 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
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
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $awardees->links() }}
                    </div>

                    <!-- First Modal - Dependent Selection -->
                    <div x-show="$wire.showTransferModal"
                         class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center overflow-y-auto"
                         x-cloak>
                        <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4 my-8">
                            <h2 class="text-xl font-bold mb-4">Transfer Award</h2>

                            @if(count($eligibleDependents) > 0)
                                <p class="mb-4">Please select the eligible dependent to transfer the award to:</p>

                                <div class="max-h-[60vh] overflow-y-auto">
                                    <div class="space-y-4">
                                        @if(isset($spouse))
                                            <div class="p-4 border rounded hover:bg-gray-50 cursor-pointer transition duration-150"
                                                 wire:click="confirmTransfer({{ $spouse->id }})">
                                                <div class="font-semibold">
                                                    {{ $spouse->spouse_last_name }}, {{ $spouse->spouse_first_name }} {{ $spouse->spouse_middle_name }} (Spouse)
                                                </div>
                                                <div class="text-sm text-gray-600">
                                                    Relationship: Spouse
                                                </div>
                                            </div>
                                        @endif

                                        @foreach($eligibleDependents as $dependent)
                                            <div class="p-4 border rounded hover:bg-gray-50 cursor-pointer transition duration-150"
                                                 wire:click="confirmTransfer({{ $dependent->id }})">
                                                <div class="font-semibold">
                                                    {{ $dependent->dependent_last_name }}, {{ $dependent->dependent_first_name }} {{ $dependent->dependent_middle_name }}
                                                </div>
                                                <div class="text-sm text-gray-600">
                                                    Relationship: {{ $dependent->dependentRelationship->relationship ?? 'Unknown' }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <p class="text-red-600">No eligible dependents found for this awardee.</p>
                            @endif

                            <div class="mt-6 flex justify-end space-x-3 border-t pt-4">
                                <button
                                        wire:click="$set('showTransferModal', false)"
                                        class="px-4 py-2 border rounded hover:bg-gray-100 transition duration-150">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 2nd modal - Requirements Modal -->
                    <div x-show="$wire.showRequirementsModal"
                         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                         x-cloak
                         style="font-family: 'Poppins', sans-serif;">
                        <!-- Modal -->
                        <div class="bg-white w-full max-w-7xl mx-4 rounded-xl shadow-2xl relative max-h-[90vh] flex flex-col">
                            <!-- Modal Header -->
                            <div class="flex-none flex justify-between items-center p-4 border-b border-gray-200">
                                <h3 class="text-lg font-bold text-gray-900">SUBMIT TRANSFER REQUIREMENTS</h3>
                                <button wire:click="closeRequirementsModal"
                                        class="text-gray-500 hover:text-gray-700 text-2xl font-bold">
                                    &times;
                                </button>
                            </div>

                            <!-- Modal Content - Scrollable Area -->
                            <div class="flex-1 p-8 overflow-y-auto">
                                <form wire:submit.prevent="submit">
                                    <!-- Horizontal Scrollable Container -->
                                    <div class="w-full overflow-x-auto pb-4">
                                        <!-- 1st Attachment - ORIGINAL COPY OF NOTICE OF AWARD -->
                                        <div class="flex flex-nowrap gap-4 min-w-full">
                                            <div class="flex-none w-80 bg-gray-50 p-2 rounded-lg shadow-sm">
                                                <p class="uppercase font-bold text-gray-900 text-sm">
                                                    {{ $attachmentLists->where('id', 1)->first()->attachment_name ?? 'Letter of Intent' }}
                                                    <span class="text-red-500">*</span>
                                                </p>

                                                <!-- File Upload -->
                                                <div wire:ignore x-data="{ isUploading: false }" x-init="
                                                    FilePond.registerPlugin(FilePondPluginImagePreview);
                                                    const pond = FilePond.create($refs.input, {
                                                        allowFileEncode: true,
                                                        onprocessfilestart: () => { isUploading = true; },
                                                        onprocessfile: (error, file) => { isUploading = false; },
                                                        server: {
                                                            process: (fileName, file, metadata, load, error, progress, abort, transfer, options) => {
                                                                @this.upload('originalCopyOfNoticeOfAward', file, load, error, progress);
                                                            },
                                                            revert: (fileName, load) => {
                                                                @this.removeUpload('originalCopyOfNoticeOfAward', fileName, load);
                                                            },
                                                        },
                                                    });">
                                                    <input x-ref="input" type="file" accept="image/*,application/pdf" wire:model="originalCopyOfNoticeOfAward">
                                                    @error('originalCopyOfNoticeOfAward')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                            <!-- 2nd Attachment - DEATH CERTIFICATE -->
                                            <div class="flex-none w-80 bg-gray-50 p-2 rounded-lg shadow-sm">
                                                <p class="uppercase font-bold text-gray-900 text-sm">
                                                    {{ $attachmentLists->where('id', 2)->first()->attachment_name ?? 'Death Certificate' }}
                                                    <span class="text-red-500">*</span>
                                                </p>
                                                <div wire:ignore x-data="{ isUploading: false }" x-init="
                                                    FilePond.registerPlugin(FilePondPluginImagePreview);
                                                    const pond = FilePond.create($refs.input, {
                                                        allowFileEncode: true,
                                                        onprocessfilestart: () => { isUploading = true; },
                                                        onprocessfile: (error, file) => { isUploading = false; },
                                                        server: {
                                                            process: (fileName, file, metadata, load, error, progress, abort, transfer, options) => {
                                                                @this.upload('deathCert', file, load, error, progress);
                                                            },
                                                            revert: (fileName, load) => {
                                                                @this.removeUpload('deathCert', fileName, load);
                                                            },
                                                        },
                                                    });">
                                                    <input x-ref="input" type="file" accept="image/*,application/pdf" wire:model="deathCert">
                                                    @error('deathCert')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                            <!-- 3rd Attachment - MARRIAGE CERTIFICATE -->
                                            <div class="flex-none w-80 bg-gray-50 p-2 rounded-lg shadow-sm">
                                                <p class="uppercase font-bold text-gray-900 text-sm">
                                                    {{ $attachmentLists->where('id', 3)->first()->attachment_name ?? 'Marriage Certificate' }}
                                                    <span class="text-red-500">*</span>
                                                </p>
                                                 <div wire:ignore x-data="{ isUploading: false }" x-init="
                                                    FilePond.registerPlugin(FilePondPluginImagePreview);
                                                    const pond = FilePond.create($refs.input, {
                                                        allowFileEncode: true,
                                                        onprocessfilestart: () => { isUploading = true; },
                                                        onprocessfile: (error, file) => { isUploading = false; },
                                                        server: {
                                                            process: (fileName, file, metadata, load, error, progress, abort, transfer, options) => {
                                                                @this.upload('marriageCert', file, load, error, progress);
                                                            },
                                                            revert: (fileName, load) => {
                                                                @this.removeUpload('marriageCert', fileName, load);
                                                            },
                                                        },
                                                    });">
                                                     <input x-ref="input" type="file" accept="image/*,application/pdf" wire:model="marriageCert">
                                                     @error('marriageCert')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
                                                 </div>
                                            </div>
                                            <!-- 4th Attachment - VALID ID 1 -->
                                            <div class="flex-none w-80 bg-gray-50 p-2 rounded-lg shadow-sm">
                                                <p class="uppercase font-bold text-gray-900 text-sm">
                                                    {{ $attachmentLists->where('id', 4)->first()->attachment_name ?? 'Valid ID (1)' }}
                                                    <span class="text-red-500">*</span>
                                                </p>
                                                <div wire:ignore x-data="{ isUploading: false }" x-init="
                                                    FilePond.registerPlugin(FilePondPluginImagePreview);
                                                    const pond = FilePond.create($refs.input, {
                                                        allowFileEncode: true,
                                                        onprocessfilestart: () => { isUploading = true; },
                                                        onprocessfile: (error, file) => { isUploading = false; },
                                                        server: {
                                                            process: (fileName, file, metadata, load, error, progress, abort, transfer, options) => {
                                                                @this.upload('validId1', file, load, error, progress);
                                                            },
                                                            revert: (fileName, load) => {
                                                                @this.removeUpload('validId1', fileName, load);
                                                            },
                                                        },
                                                    });">
                                                    <input x-ref="input" type="file" accept="image/*,application/pdf" wire:model="validId1">
                                                    @error('validId1')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                            <!-- 5th Attachment - VALID ID 2 -->
                                            <div class="flex-none w-80 bg-gray-50 p-2 rounded-lg shadow-sm">
                                                <p class="uppercase font-bold text-gray-900 text-sm">
                                                    {{ $attachmentLists->where('id', 5)->first()->attachment_name ?? 'Valid ID (2)' }}
                                                    <span class="text-red-500">*</span>
                                                </p>
                                                <div wire:ignore x-data="{ isUploading: false }" x-init="
                                                    FilePond.registerPlugin(FilePondPluginImagePreview);
                                                    const pond = FilePond.create($refs.input, {
                                                        allowFileEncode: true,
                                                        onprocessfilestart: () => { isUploading = true; },
                                                        onprocessfile: (error, file) => { isUploading = false; },
                                                        server: {
                                                            process: (fileName, file, metadata, load, error, progress, abort, transfer, options) => {
                                                                @this.upload('validId2', file, load, error, progress);
                                                            },
                                                            revert: (fileName, load) => {
                                                                @this.removeUpload('validId2', fileName, load);
                                                            },
                                                        },
                                                    });">
                                                    <input x-ref="input" type="file" accept="image/*,application/pdf" wire:model="validId2">
                                                    @error('validId2')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                            <!-- 6th Attachment - VOTERS CERT -->
                                            <div class="flex-none w-80 bg-gray-50 p-2 rounded-lg shadow-sm">
                                                <p class="uppercase font-bold text-gray-900 text-sm">
                                                    {{ $attachmentLists->where('id', 6)->first()->attachment_name ?? 'Voter\'s Certificate' }}
                                                    <span class="text-red-500">*</span>
                                                </p>
                                                <div wire:ignore x-data="{ isUploading: false }" x-init="
                                                    FilePond.registerPlugin(FilePondPluginImagePreview);
                                                    const pond = FilePond.create($refs.input, {
                                                        allowFileEncode: true,
                                                        onprocessfilestart: () => { isUploading = true; },
                                                        onprocessfile: (error, file) => { isUploading = false; },
                                                        server: {
                                                            process: (fileName, file, metadata, load, error, progress, abort, transfer, options) => {
                                                                @this.upload('votersCert', file, load, error, progress);
                                                            },
                                                            revert: (fileName, load) => {
                                                                @this.removeUpload('votersCert', fileName, load);
                                                            },
                                                        },
                                                    });">
                                                    <input x-ref="input" type="file" accept="image/*,application/pdf" wire:model="votersCert">
                                                    @error('votersCert')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                            <!-- 7th Attachment - BIRTH CERT -->
                                            <div class="flex-none w-80 bg-gray-50 p-2 rounded-lg shadow-sm">
                                                <p class="uppercase font-bold text-gray-900 text-sm">
                                                    {{ $attachmentLists->where('id', 7)->first()->attachment_name ?? 'Birth Certificate' }}
                                                    <span class="text-red-500">*</span>
                                                </p>
                                                <div wire:ignore x-data="{ isUploading: false }" x-init="
                                                    FilePond.registerPlugin(FilePondPluginImagePreview);
                                                    const pond = FilePond.create($refs.input, {
                                                        allowFileEncode: true,
                                                        onprocessfilestart: () => { isUploading = true; },
                                                        onprocessfile: (error, file) => { isUploading = false; },
                                                        server: {
                                                            process: (fileName, file, metadata, load, error, progress, abort, transfer, options) => {
                                                                @this.upload('birthCert', file, load, error, progress);
                                                            },
                                                            revert: (fileName, load) => {
                                                                @this.removeUpload('birthCert', fileName, load);
                                                            },
                                                        },
                                                    });">
                                                    <input x-ref="input" type="file" accept="image/*,application/pdf" wire:model="birthCert">
                                                    @error('birthCert')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                            <!-- 8th Attachment - EXTRAJUDICIAL SETTLEMENT / WAIVER OF RIGHTS -->
                                            <div class="flex-none w-80 bg-gray-50 p-2 rounded-lg shadow-sm">
                                                <p class="uppercase font-bold text-gray-900 text-sm">
                                                    {{ $attachmentLists->where('id', 8)->first()->attachment_name ?? 'Extrajudicial Settlement / Waiver of Rights' }}
                                                    <span class="text-red-500">*</span>
                                                </p>
                                                <div wire:ignore x-data="{ isUploading: false }" x-init="
                                                    FilePond.registerPlugin(FilePondPluginImagePreview);
                                                    const pond = FilePond.create($refs.input, {
                                                        allowFileEncode: true,
                                                        onprocessfilestart: () => { isUploading = true; },
                                                        onprocessfile: (error, file) => { isUploading = false; },
                                                        server: {
                                                            process: (fileName, file, metadata, load, error, progress, abort, transfer, options) => {
                                                                @this.upload('extraJudicialSettlement', file, load, error, progress);
                                                            },
                                                            revert: (fileName, load) => {
                                                                @this.removeUpload('extraJudicialSettlement', fileName, load);
                                                            },
                                                        },
                                                    });">
                                                    <input x-ref="input" type="file" accept="image/*,application/pdf" wire:model="extraJudicialSettlement">
                                                    @error('extraJudicialSettlement')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                            <!-- 9th Attachment - CERTIFICATE OF NO LAND HOLDING -->
                                            <div class="flex-none w-80 bg-gray-50 p-2 rounded-lg shadow-sm">
                                                <p class="uppercase font-bold text-gray-900 text-sm">
                                                    {{ $attachmentLists->where('id', 9)->first()->attachment_name ?? 'Certificate of No Land Holding' }}
                                                    <span class="text-red-500">*</span>
                                                </p>
                                                <div wire:ignore x-data="{ isUploading: false }" x-init="
                                                    FilePond.registerPlugin(FilePondPluginImagePreview);
                                                    const pond = FilePond.create($refs.input, {
                                                        allowFileEncode: true,
                                                        onprocessfilestart: () => { isUploading = true; },
                                                        onprocessfile: (error, file) => { isUploading = false; },
                                                        server: {
                                                            process: (fileName, file, metadata, load, error, progress, abort, transfer, options) => {
                                                                @this.upload('certOfNoLandHolding', file, load, error, progress);
                                                            },
                                                            revert: (fileName, load) => {
                                                                @this.removeUpload('certOfNoLandHolding', fileName, load);
                                                            },
                                                        },
                                                    });">
                                                    <input x-ref="input" type="file" accept="image/*,application/pdf" wire:model="certOfNoLandHolding">
                                                    @error('certOfNoLandHolding')<div class="text-red-400 text-sm">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Button Section - Fixed at bottom -->
                                    <div class="mt-4">
                                        <button type="submit"
                                                class="w-full py-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white font-semibold rounded-lg flex items-center justify-center space-x-2"
                                                :disabled="!$wire.isRequirementsComplete">
                                            <span class="text-[12px]">SUBMIT</span>
                                            <div wire:loading>
                                                <svg aria-hidden="true"
                                                     class="w-5 h-5 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                                     viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                          fill="currentColor"/>
                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                          fill="currentFill"/>
                                                </svg>
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Third Modal - Confirmation -->
                    <div x-show="$wire.showConfirmationModal"
                         class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center"
                         x-cloak>
                        <div class="bg-white rounded-lg p-6 max-w-lg w-full mx-4">
                            <h2 class="text-xl font-bold mb-4">Confirm Award Transfer</h2>

                            @if($selectedDependent)
                                <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                    <p class="text-sm text-gray-600 mb-4">
                                        Are you sure you want to transfer the award to:
                                    </p>
                                    <p class="font-medium">
                                        @if($isSpouseTransfer)
                                            {{ $selectedDependent->spouse_last_name }},
                                            {{ $selectedDependent->spouse_first_name }}
                                            {{ $selectedDependent->spouse_middle_name }}
                                        @else
                                            {{ $selectedDependent->dependent_last_name }},
                                            {{ $selectedDependent->dependent_first_name }}
                                            {{ $selectedDependent->dependent_middle_name }}
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Relationship: {{ $isSpouseTransfer ? 'Spouse' : $selectedDependent->dependentRelationship->relationship }}
                                    </p>
                                </div>
                            @endif

                            <div class="mt-6 flex justify-end space-x-3 border-t pt-4">
                                <button
                                        wire:click="$set('showConfirmationModal', false)"
                                        class="px-4 py-2 border rounded hover:bg-gray-100">
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
                                    <button
                                            wire:click="proceedWithTransfer"
                                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition duration-150">
                                        Confirm Transfer
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
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
