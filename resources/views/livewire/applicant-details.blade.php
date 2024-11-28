<div class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <div class="flex-1 p-6 overflow-auto">
            <form wire:submit.prevent="store">
                <div class="bg-white rounded shadow mb-4 flex items-center justify-between p-3 fixed top-[80px] left-[20%] right-[3%] z-10">
                    <div class="flex items-center">
                        <a href="{{ route('applicants') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-custom-yellow mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <h2 class="text-[13px] ml-2 items-center text-gray-700">Tag Applicant</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design"
                        class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                    <div class="flex space-x-2 z-10">
                        <div x-data="{
                                    showQuestionModal: false,
                                    showConfirmationModal: false,
                                    openModalRelocate: false,
                                    handleNoClick() {
                                        this.showQuestionModal = false;
                                        $wire.setRelocationOnly(false);
                                        this.showConfirmationModal = true;
                                    }
                                }">
                            <div class="z-50">
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
                            </div>
                            <!-- Submit Button -->
                            <button type="button"
                                    @click="showQuestionModal = true"
                                    class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white text-xs font-semibold px-6 py-2 rounded">
                                    SUBMIT
                                <div wire:loading>
                                    <svg aria-hidden="true"
                                         class="w-3.5 h-3.5 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                         viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                fill="currentColor"/>
                                        <path
                                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                fill="currentFill"/>
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </button>

                            <!-- Question Modal -->
                            <template x-if="showQuestionModal">
                                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                    <div class="bg-white p-6 rounded-lg shadow-lg">
                                        <h3 class="text-lg font-medium mb-4">
                                            Do you want to <strong>ASSIGN A RELOCATION SITE</strong> for this <bold>Tagged And Validated Applicant</bold>?
                                        </h3>
                                        <div class="flex justify-end space-x-3">
                                            <button @click="handleNoClick()"
                                                    class="px-4 py-2 bg-gray-500 text-white rounded-lg">
                                                No
                                            </button>
                                            <button @click="showQuestionModal = false; $wire.showRelocationModal = true; $wire.setRelocationOnly(true)"
                                                    class="px-4 py-2 bg-custom-red text-white rounded-lg">
                                                Yes
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Modal for Assigning Relocation Site -->
                            <div x-show="$wire.showRelocationModal"
                                 class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                                 x-cloak>
                                <!-- Modal -->
                                <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                                    <!-- Modal Header -->
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-md font-semibold text-black">ASSIGN RELOCATION SITE</h3>
                                        <button @click="$wire.showRelocationModal = false" class="text-gray-400 hover:text-gray-200">
                                            &times;
                                        </button>
                                    </div>
                                    <form wire:submit.prevent="confirmRelocation">
                                        <label class="block text-sm font-medium mb-2 text-black">
                                            LOT ALLOCATION (ASSIGNED RELOCATION SITE)
                                        </label>
                                        <br>
                                        <div class="mb-4">
                                            <div class="mb-4">
                                                <label class="block text-[12px] font-medium mb-2 text-black"
                                                       for="lot_name">RELOCATION SITE <span class="text-red-500">*</span>
                                                </label>
                                                <select wire:model="relocation_lot_id"
                                                        class="uppercase w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-700 focus:outline-none text-[12px]">
                                                    <option value="">Select Relocation Site </option>
                                                    @forelse($relocationSites as $relocationSite)
                                                        <option value="{{ $relocationSite->id }}">{{ $relocationSite->relocation_site_name }}</option>
                                                    @empty
                                                        <option disabled>There's no record available yet.</option>
                                                    @endforelse
                                                </select>
                                                @error('relocation_lot_id') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <br>
                                        <div class="grid grid-cols-2 gap-4 mb-4">
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
                                                <button type="button"
                                                        wire:click="confirmRelocation()"
                                                        class="w-full py-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                                    <span class="text-[12px]">CONFIRM</span>
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
                                            <button type="button"
                                                    @click="$wire.showRelocationModal = false"
                                                    class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2 cursor-pointer">
                                                <span class="text-[12px]">CANCEL</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Confirmation Modal -->
                            <template x-if="showConfirmationModal">
                                <div class="fixed inset-0 z-20 bg-gray-600 bg-opacity-65 overflow-y-auto flex items-center justify-center"
                                    @click.away="showConfirmationModal = false">
                                    <div class="relative bg-white rounded-lg max-w-md w-full p-6">
                                        <!-- Modal content -->
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 text-yellow-400">
                                                    <!-- Warning icon -->
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                    </svg>
                                                </div>
                                                <div class="ml-3">
                                                    <h3 class="text-lg font-medium text-gray-900">
                                                        Confirm Submission
                                                    </h3>
                                                </div>
                                            </div>
{{--                                            <button @click="$wire.showConfirmationModal = false" class="text-gray-400 hover:text-gray-500">--}}
{{--                                                <span class="sr-only">Close</span>--}}
{{--                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>--}}
{{--                                                </svg>--}}
{{--                                            </button>--}}
                                        </div>

                                        <div class="mt-4">
                                            <p class="text-sm text-gray-500">
                                                Please ensure all fields are filled out correctly. This action cannot be undone once submitted.
                                                Are you sure you want to proceed?
                                            </p>
                                        </div>

                                        <div class="mt-6 flex justify-end space-x-3">
                                            <button @click="showConfirmationModal = false"
                                                    type="button"
                                                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md">
                                                Cancel
                                            </button>
                                            <button type="button"
                                                    wire:click="finalSubmit"
                                                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-custom-red border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-red">
                                                <span>Proceed</span>
                                                <div wire:loading wire:target="proceedWithSubmission">
                                                    <svg aria-hidden="true" class="w-5 h-5 ml-2 text-gray-200 animate-spin" viewBox="0 0 100 101" fill="none">
                                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                                    </svg>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
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
                </div>

                <div class="flex flex-col p-3 rounded mt-12">
                    <h2 class="text-[30px] ml-2 items-center font-bold text-gray-700 underline">{{ $applicant->applicant_id }}</h2>
                    <h1 class="text-[25px] ml-2 items-center font-bold text-gray-700 mb-3">
                        {{ $applicant->person->last_name }}, {{ $applicant->person->first_name }}
                        @if($applicant->person->middle_name) {{ $applicant->person->middle_name }} @endif
                    </h1>
                    <h2 class="text-[13px] ml-2 items-center font-bold text-gray-700">PERSONAL INFORMATION</h2>
                    <p class="text-[12px] ml-2 items-center text-gray-700">Encode here the personal information of the
                        Applicant from the form.</p>
                </div>

                <div class="bg-white p-6 rounded shadow mb-6">
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="first-name" class="block text-[12px] font-semibold text-gray-700 mb-1" aria-describedby>
                                FIRST NAME <small class="text-red-500">(read only)</small>
                            </label>
                            <input wire:model="first_name"
                                   type="text" id="first-name"
                                   name="first-name"
                                   class="capitalize w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow cursor-default"
                                   readonly>
                            @error('first_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="middle_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                MIDDLE NAME <small class="text-red-500">(read only)</small>
                            </label>
                            <input wire:model="middle_name"
                                   type="text"
                                   id="middle_name"
                                   name="middle_name"
                                   class="capitalize w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow cursor-default"
                                   readonly>
                            @error('middle_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="last_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                LAST NAME <small class="text-red-500">(read only)</small>
                            </label>
                            <input wire:model="last_name" type="text" id="last_name" name="last-name" class="capitalize w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow cursor-default" readonly>
                            @error('last_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="suffix_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                SUFFIX NAME <small class="text-red-500">(read only)</small>
                            </label>
                            <input wire:model="suffix_name"
                                   type="text"
                                   id="suffix_name"
                                   name="suffix_name"
                                   class="capitalize w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow cursor-default"
                                   readonly>
                            @error('suffix_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div x-data="{ civilStatus: '' }">
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="barangay" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    BARANGAY <small class="text-red-500">(read only)</small>
                                </label>
                                <input wire:model="barangay"
                                       id="barangay"
                                       class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow capitalize cursor-default" readonly>
                                @error('barangay') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="purok" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    PUROK <small class="text-red-500">(read only)</small>
                                </label>
                                <input wire:model="purok"
                                       id="purok"
                                       class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow capitalize cursor-default" readonly>
                                @error('purok') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="full_address"
                                       class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    FULL ADDRESS
                                </label>
                                <input wire:model="full_address"
                                       type="text"
                                       id="full_address"
                                       class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       oninput="capitalizeInput(this)">
                                @error('full_address') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="civil_status"
                                       class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    CIVIL STATUS <span class="text-red-500">*</span>
                                </label>
                                <select x-model="civilStatus"
                                        wire:model="civil_status_id"
                                        id="civil_status"
                                        class="w-full p-1 bg-white border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select Status</option>
                                    @foreach($civil_statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->civil_status }}</option>
                                    @endforeach
                                </select>
                                @error('civil_status') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="contact_number" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    CONTACT NUMBER <small class="text-red-500">(read only)</small>
                                </label>
                                <input wire:model="contact_number"
                                       type="text"
                                       id="contact_number"
                                       required
                                       class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow capitalize cursor-default"
                                       readonly>
                                @error('contact_number') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="tribe" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    TRIBE/ETHNICITY <small>(Put N/A if none)</small> <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="tribe"
                                       type="text"
                                       id="tribe"
                                       required
                                       class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow capitalize"
                                       oninput="capitalizeInput(this)">
                                @error('tribe') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="sex" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    SEX <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center">
                                    <div class="mr-6">
                                        <input type="radio"
                                               wire:model="sex"
                                               value="Male"
                                               id="male"
                                               class="mr-2"
                                               required>
                                        <label for="male" class="cursor-pointer">Male</label>
                                    </div>
                                    <div>
                                        <input type="radio"
                                               wire:model="sex"
                                               value="Female"
                                               id="female"
                                               class="mr-2"
                                               required>
                                        <label for="female" class="cursor-pointer">Female</label>
                                    </div>
                                    @error('sex') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="date_of_birth" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    DATE OF BIRTH <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="date_of_birth"
                                       type="date"
                                       id="date_of_birth"
                                       name="date_of_birth"
                                       required
                                       class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                @error('date_of_birth') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="religion" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    RELIGION <small>(Put N/A if none)</small> <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="religion"
                                       type="text"
                                       id="religion"
                                       required
                                       class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow capitalize"
                                       oninput="capitalizeInput(this)">
                                @error('religion') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="occupation"
                                       class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    OCCUPATION <small>(Put N/A if none)</small> <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="occupation"
                                       wire:model="occupation"
                                       class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       oninput="capitalizeInput(this)">
                                @error('occupation') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="monthly_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    MONTHLY INCOME <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="monthly_income" wire:model="monthly_income"
                                       class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       oninput="validateNumberInput(this)">
                                @error('monthly_income') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="years_of_residency" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    LENGTH OF RESIDENCY <span class="text-red-500">*</span>
                                </label>
                                <input type="number"
                                       wire:model="years_of_residency"
                                       class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       maxlength="3"
                                       oninput="validateNumberInput(this)">
                                @error('years_of_residency') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>

                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="voters_id_number" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    VOTER'S ID NUMBER
                                </label>
                                <input type="text"
                                       wire:model="voters_id_number"
                                       class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       oninput="capitalizeInput(this)">
                                @error('voters_id_number') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <template x-if="civilStatus === '2'">
                            <div>
                                <hr class="mt-2 mb-2 ">
                                <h2 class="block text-[16px] font-semibold text-gray-700 mb-2">PARTNER DETAILS</h2>
                                <div class="flex flex-wrap -mx-2">
                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="partner_first_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                            FIRST NAME <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               id="partner_first_name"
                                               wire:model="partner_first_name"
                                               class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                               oninput="capitalizeInput(this)">
                                        @error('partner_first_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="partner_middle_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                            MIDDLE NAME <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               id="partner_middle_name"
                                               wire:model="partner_middle_name"
                                               class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                               oninput="capitalizeInput(this)">
                                        @error('partner_middle_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="partner_last_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                            LAST NAME <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               id="partner_last_name"
                                               wire:model="partner_last_name"
                                               class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                               oninput="capitalizeInput(this)">
                                        @error('partner_last_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="partner_occupation" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                            OCCUPATION <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               id="partner_occupation"
                                               wire:model="partner_occupation"
                                               class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                               oninput="capitalizeInput(this)">
                                        @error('partner_occupation') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="partner_monthly_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                            MONTHLY INCOME <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number"
                                               id="partner_monthly_income"
                                               wire:model="partner_monthly_income"
                                               class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                               oninput="validateNumberInput(this)">
                                        @error('spouse_monthly_income') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </template>

                        <template x-if="civilStatus === '3'">
                            <div>
                                <hr class="mt-2 mb-2 ">
                                <h2 class="block text-[16px] font-semibold text-gray-700 mb-2">SPOUSE DETAILS</h2>
                                <div class="flex flex-wrap -mx-2">
                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="spouse_first_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                            FIRST NAME <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="spouse_first_name" wire:model="spouse_first_name" class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                               oninput="capitalizeInput(this)">
                                        @error('spouse_first_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="spouse_middle_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                            MIDDLE NAME <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="spouse_middle_name" wire:model="spouse_middle_name" class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                               oninput="capitalizeInput(this)">
                                        @error('spouse_middle_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="spouse_last_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                            LAST NAME <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="spouse_last_name" wire:model="spouse_last_name" class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                               oninput="capitalizeInput(this)">
                                        @error('spouse_last_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="spouse_occupation" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                            OCCUPATION <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="spouse_occupation"
                                               wire:model="spouse_occupation"
                                               class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                               oninput="capitalizeInput(this)">
                                        @error('spouse_occupation') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="spouse_monthly_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                            MONTHLY INCOME <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number"
                                               id="spouse_monthly_income"
                                               wire:model="spouse_monthly_income"
                                               class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                               oninput="validateNumberInput(this)">
                                        @error('spouse_monthly_income') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="mt-6">
                        <div class="flex justify-between">
                            <div class="mt-4 flex justify-start">
                                <h2 class="text-[12px] font-semibold text-gray-700 mb-2">DEPENDENTS</h2>
                            </div>
                        </div>
                        <table class="w-full">
                            <thead>
                            <tr class="text-center border border-gray-700">
                                <th class="p-2 border-b">First Name</th>
                                <th class="p-2 border-b">Middle Name</th>
                                <th class="p-2 border-b">Last Name</th>
                                <th class="p-2 border-b">Sex</th>
                                <th class="p-2 border-b">Civil Status</th>
                                <th class="p-2 border-b">Date of Birth</th>
                                <th class="p-2 border-b">Relationship</th>
                                <th class="p-2 border-b">Occupation</th>
                                <th class="p-2 border-b">Monthly Income</th>
                                <th class="p-2 border-b"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($dependents as $index => $dependent)
                                    <tr class="odd:bg-custom-green-light even:bg-transparent text-center">
                                        <td class="border px-4 py-2">
                                            <input type="text" wire:model="dependents.{{$index}}.dependent_first_name"
                                                   placeholder="First name..."
                                                   class="capitalize w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]"
                                                   oninput="capitalizeInput(this)">
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="text" wire:model="dependents.{{$index}}.dependent_middle_name"
                                                   placeholder="Middle name..."
                                                   class="capitalize w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]"
                                                   oninput="capitalizeInput(this)">
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="text" wire:model="dependents.{{$index}}.dependent_last_name"
                                                   placeholder="Last name..."
                                                   class="capitalize w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]"
                                                   oninput="capitalizeInput(this)">
                                        </td>
                                        <td class="border px-4 py-2">
                                            <div class="flex items-center">
                                                <div class="mr-6">
                                                    <input type="radio" wire:model="dependents.{{$index}}.dependent_sex"
                                                           value="Male" id="male" class="mr-2">
                                                    <label for="male" class="cursor-pointer">Male</label>
                                                </div>
                                                <div>
                                                    <input type="radio" wire:model="dependents.{{$index}}.dependent_sex"
                                                           value="Female" id="female" class="mr-2">
                                                    <label for="female" class="cursor-pointer">Female</label>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border px-1 py-2">
                                            <select wire:model="dependents.{{$index}}.dependent_civil_status_id"
                                                    class="capitalize w-full py-1 bg-transparent focus:outline-none text-[12px]">
                                                <option value="">Select Status</option>
                                                @foreach($dependent_civil_statuses as $dependentStatus)
                                                    <option value="{{ $dependentStatus->id }}">{{ $dependentStatus->civil_status }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="date" wire:model="dependents.{{$index}}.dependent_date_of_birth"
                                                   class="capitalize w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]">
                                        </td>
                                        <td class="border px-1 py-2">
                                            <select wire:model="dependents.{{$index}}.dependent_relationship_id"
                                                    class="capitalize w-full py-1 bg-transparent focus:outline-none text-[12px]">
                                                <option value="">Select Relationship</option>
                                                @foreach($dependentRelationships as $dependentRelationship)
                                                    <option value="{{ $dependentRelationship->id }}">{{ $dependentRelationship->relationship }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="text" wire:model="dependents.{{$index}}.dependent_occupation"
                                                   placeholder="Occupation..."
                                                   class="capitalize w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]"
                                                   oninput="capitalizeInput(this)">
                                        </td>
                                        <td class="border px-4 py-2">
                                            <input type="number" wire:model="dependents.{{$index}}.dependent_monthly_income"
                                                   placeholder="9000"
                                                   class="capitalize w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]"
                                                   oninput="validateNumberInput(this)">
                                        </td>
                                        <td class="border px-4 py-2">
                                            <button type="button" wire:click="remove({{ $index }})"
                                                    class="text-red-500 hover:text-red-700 text-[14px]">
                                                ✕
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Add Row Button -->
                        <div class="flex justify-end mb-4 mt-4">
                            <button type="button" wire:click="add()"
                                    class="text-white bg-green-500 hover:bg-green-600 text-[12px] px-2 py-2 rounded-md flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                     class="w-5 h-5 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Add Dependent
                            </button>
                        </div>
                    </div>
                </div>

                <div x-data="{
                    livingSituation: @entangle('living_situation_id'),
                    livingStatus: @entangle('living_status_id')}"
                    class="bg-white p-6 rounded shadow mb-6">

                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="tagging_date"
                                   class="block text-[12px] font-semibold text-gray-700 mb-1">
                                TAGGING DATE <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="tagging_date"
                                   type="date" id="tagging_date"
                                   required
                                   class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow uppercase"
                                    max="{{ date('Y-m-d') }}">
                            @error('tagging_date') <span class="text-red-600 error">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="living_situation"
                                   class="block text-[13px] font-semibold text-gray-700 mb-1">
                                LIVING SITUATION (CASE) <span class="text-red-500">*</span>
                            </label>
                            <select x-model.number="livingSituation"
                                    wire:model="living_situation_id"
                                    id="living_situation"
                                    required
                                    class="w-full p-1 bg-white border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select situation</option>
                                @foreach($livingSituations as $livingSituation)
                                <option value="{{ $livingSituation->id }}">{{ $livingSituation->living_situation_description }}</option>
                                @endforeach
                            </select>
                            @error('living_situation') <span class="error text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <template x-if="livingSituation >= '1' && livingSituation <= '7'  || livingSituation === '9'">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="living_situation_case_specification"
                                       class="block text-[13px] font-semibold text-gray-700 mb-1">
                                    LIVING SITUATION CASE SPECIFICATION <span class="text-red-500">*</span>
                                </label>
                                <textarea wire:model="living_situation_case_specification"
                                          type="text"
                                          id="living_situation_case_specification"
                                          placeholder="Enter case details"
                                          class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                          required
                                          oninput="capitalizeInput(this)">
                                </textarea>
                                @error('living_situation_case_specification') <span class="error text-red-600">{{ $message }}</span> @enderror
                            </div>
                        </template>
                        <template x-if="livingSituation == '8'">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="case_specification"
                                       class="block text-[13px] font-semibold text-gray-700 mb-1">
                                    CASE SPECIFICATION <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="case_specification_id"
                                        id="case_specification"
                                        class="w-full p-1 bg-white border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow uppercase" required>
                                    <option value="">Select specification</option>
                                    @foreach($caseSpecifications as $caseSpecification)
                                        <option value="{{ $caseSpecification->id }}">{{ $caseSpecification->case_specification_name }}</option>
                                    @endforeach
                                </select>
                                @error('case_specification') <span class="error text-red-600">{{ $message }}</span> @enderror
                            </div>
                        </template>
                    </div>

                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="government_program"
                                   class="block text-[13px] font-semibold text-gray-700 mb-1">
                                SOCIAL WELFARE CATEGORY
                            </label>
                            <select wire:model="government_program_id"
                                    id="government_program"
                                    required
                                    class="w-full p-1 bg-white border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select type of assistance</option>
                                @foreach($governmentPrograms as $governmentProgram)
                                <option value="{{ $governmentProgram->id }}">{{ $governmentProgram->program_name }}</option>
                                @endforeach
                            </select>
                            @error('government_program') <span class="error text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="living_status"
                                   class="block text-[13px] font-semibold text-gray-700 mb-1">
                                LIVING STATUS <span class="text-red-500">*</span>
                            </label>
                            <select x-model.number="livingStatus"
                                    wire:model="living_status_id"
                                    id="living_status"
                                    required
                                    class="w-full p-1 bg-white border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select status</option>
                                @foreach($livingStatuses as $livingStatus)
                                    <option value="{{ $livingStatus->id }}">{{ $livingStatus->living_status_name }}</option>
                                @endforeach
                            </select>
                            @error('living_status') <span class="error text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <template x-if="livingStatus === '1'">
                        <div class="flex flex-wrap -mx-2 ml-[33%]">
                            <div class="w-full md:w-2/4 px-2 mb-4">
                                <label for="rent_fee"
                                       class="block text-[13px] font-semibold text-gray-700 mb-1">
                                    ROOM RENT FEE <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="room_rent_fee"
                                       type="number"
                                       id="room_rent_fee"
                                       placeholder="How much monthly?"
                                       class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       min="0" step="0.01"
                                       oninput="validateNumberInput(this)">
                                @error('room_rent_fee') <span class="error text-red-600">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-2/4 px-2 mb-4">
                                <label for="room_landlord"
                                       class="block text-[13px] font-semibold text-gray-700 mb-1">
                                    LANDLORD <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="room_landlord"
                                       type="text"
                                       id="room_landlord"
                                       placeholder="LANDLORD"
                                       class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       oninput="capitalizeInput(this)">
                                @error('room_landlord') <span class="error text-red-600">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </template>
                    <template x-if="livingStatus === '2'">
                        <div class="flex flex-wrap -mx-2 ml-[33%]">
                            <div class="w-full md:w-2/4 px-2 mb-4">
                                <label for="house_rent_fee"
                                       class="block text-[13px] font-semibold text-gray-700 mb-1">
                                    HOUSE RENT FEE <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="house_rent_fee"
                                       type="number"
                                       id="house_rent_fee"
                                       placeholder="How much monthly?"
                                       class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       min="0" step="0.01"
                                       oninput="validateNumberInput(this)">
                                @error('house_rent_fee') <span class="error text-red-600">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-2/4 px-2 mb-4">
                                <label for="house_landlord"
                                       class="block text-[13px] font-semibold text-gray-700 mb-1">
                                    LANDLORD <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="house_landlord"
                                       type="text"
                                       id="house_landlord"
                                       placeholder="LANDLORD"
                                       class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       oninput="capitalizeInput(this)">
                                @error('house_landlord') <span class="error text-red-600">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </template>
                    <template x-if="livingStatus === '3'">
                        <div class="flex flex-wrap -mx-2 ml-[33%]">
                            <div class="w-full md:w-2/4 px-2 mb-4">
                                <label for="lot_rent_fee"
                                       class="block text-[13px] font-semibold text-gray-700 mb-1">
                                    LOT RENT FEE <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="lot_rent_fee"
                                       type="number"
                                       id="lot_rent_fee"
                                       placeholder="How much monthly?"
                                       class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       min="0" step="0.01"
                                       oninput="validateNumberInput(this)">
                                @error('lot_rent_fee') <span class="error text-red-600">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-2/4 px-2 mb-4">
                                <label for="lot_landlord"
                                       class="block text-[13px] font-semibold text-gray-700 mb-1">
                                    LANDLORD <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="lot_landlord"
                                       type="text"
                                       id="lot_landlord"
                                       placeholder="LANDLORD"
                                       class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       oninput="capitalizeInput(this)">
                                @error('lot_landlord') <span class="error text-red-600">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </template>
                    <template x-if="livingStatus === '8'">
                        <div class="flex flex-wrap -mx-2 ml-[33%]">
                            <div class="w-full md:w-2/4 px-2 mb-4">
                                <label for="house_owner"
                                       class="block text-[13px] font-semibold text-gray-700 mb-1">
                                    HOUSE OWNER NAME <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="house_owner"
                                       type="text"
                                       id="house_owner"
                                       class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       oninput="capitalizeInput(this)">
                                @error('house owner') <span class="error text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <div class="w-full md:w-2/4 px-2 mb-4">
                                <label for="relationship_to_house_owner"
                                       class="block text-[13px] font-semibold text-gray-700 mb-1">
                                    RELATIONSHIP <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="relationship_to_house_owner"
                                       type="text"
                                       id="relationship_to_house_owner"
                                       placeholder="Friend"
                                       required
                                       class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       oninput="capitalizeInput(this)">
                                @error('relationship_to_house_owner') <span class="error text-red-600">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </template>

                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label class="block text-[13px] font-bold text-gray-700 mt-1 mb-1">HOUSE MATERIALS</label>
                            <label for="roof_type"
                                   class="block text-[13px] font-semibold text-gray-700 mb-1">
                                ROOF <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="roof_type_id"
                                    id="roof_type"
                                    required
                                    class="w-full p-1 bg-white border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select type of roof</option>
                                @foreach($roofTypes as $roofType)
                                <option value="{{ $roofType->id }}">{{ $roofType->roof_type_name }}</option>
                                @endforeach
                            </select>
                            @error('roof_type') <span class="error text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="wall_type"
                                   class="block text-[13px] font-semibold text-gray-700 mt-7 mb-1">
                                WALL <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="wall_type_id"
                                    id="wall_type"
                                    required
                                    class="w-full p-1 bg-white border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select type of wall</option>
                                @foreach($wallTypes as $wallType)
                                <option value="{{ $wallType->id }}">{{ $wallType->wall_type_name }}</option>
                                @endforeach
                            </select>
                            @error('wall_type') <span class="error text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="structure_status_id"
                                   class="block text-[13px] font-semibold text-gray-700 mt-7 mb-1">
                                STRUCTURE TYPE STATUS <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="structure_status_id"
                                    id="structure_status_id"
                                    required
                                    class="w-full p-1 bg-white border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select type</option>
                                @foreach($structureStatuses as $structureStatus)
                                    <option value="{{ $structureStatus->id }}">{{ $structureStatus->structure_status }}</option>
                                @endforeach
                            </select>
                            @error('structure_status_id') <span class="error text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-full px-2 mb-4">
                            <label for="remarks"
                                   class="block text-[13px] font-semibold text-gray-700 mb-1">
                                REMARKS
                            </label>
                            <input wire:model="remarks"
                                   type="text"
                                   id="remarks"
                                   class="capitalize w-full p-3 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                   oninput="capitalizeInput(this)">
                            @error('remarks') <span class="error text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="p-3 rounded">
                    <h2 class="text-[13px] ml-2 items-center font-bold text-gray-700">UPLOAD DOCUMENTS</h2>
                    <p class="text-[12px] ml-2 items-center text-gray-700">Upload here the captured house situation of the applicant.</p>
                </div>

                <!-- File Uploads -->
                <div class="bg-white p-6 rounded shadow mb-6">
                    <div class="mb-4">
                        <!-- House Structure Images -->
                        <div wire:ignore x-data="{ isUploading: false }" x-init="
                                FilePond.registerPlugin(FilePondPluginImagePreview);
                                const pond = FilePond.create($refs.input, {
                                    allowMultiple: true,
                                    server: {
                                        process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                                            @this.upload('houseStructureImages', file,
                                                (uploadedFileName) => {
                                                    load(uploadedFileName);
                                                    console.log('File uploaded successfully');
                                                },
                                                (error) => {
                                                    console.error('Upload error:', error);
                                                    error('Upload failed');
                                                },
                                                (event) => {
                                                    progress(event.lengthComputable ? event.loaded/event.total : 0.5);
                                                }
                                            );
                                        },
                                        revert: (filename, load) => {
                                            @this.removeUpload('houseStructureImages', filename, load);
                                        }
                                    },
                                    allowProcess: true
                                });
                            ">
                            <input type="file" x-ref="input" multiple accept="image/*" required>
                            @error('houseStructureImages.*')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
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
<script>
    // Function to allow only numeric input
    function validateNumberInput(input) {
        // Remove any characters that are not digits
        input.value = input.value.replace(/[^0-9]/g, '');
    }
</script>