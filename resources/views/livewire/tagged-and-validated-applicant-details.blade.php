{{--<div class="p-10 h-screen ml-[17%] mt-[60px]">--}}
{{--    <div class="flex bg-gray-100 text-[12px]">--}}
{{--        <div x-data="{ isEditable: false }"--}}
{{--             class="flex-1 p-6 overflow-auto">--}}
{{--            <form wire:submit.prevent="update">--}}
{{--                <div class="bg-white rounded shadow mb-4 flex items-center justify-between p-3 fixed top-[80px] left-[20%] right-[3%] z-0">--}}
{{--                    <div class="flex items-center">--}}
{{--                        <a href="{{ route('transaction-request') }}">--}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"--}}
{{--                                 stroke="currentColor" class="w-5 h-5 text-custom-yellow mr-2">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />--}}
{{--                            </svg>--}}
{{--                        </a>--}}
{{--                        <h2 class="text-[13px] ml-2 items-center text-gray-700">Tagged and Validated Applicant Details</h2>--}}
{{--                    </div>--}}
{{--                    <img src="{{ asset('storage/images/design.png') }}" alt="Design"--}}
{{--                         class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">--}}
{{--                    <div class="flex space-x-2 z-[1000]">--}}
{{--                    @if(!$isEditing)--}}
{{--                        <button--}}
{{--                                wire:click="toggleEdit"--}}
{{--                                type="button"--}}
{{--                                class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white text-xs font-semibold px-6 py-2 rounded">--}}
{{--                            EDIT--}}
{{--                            <div wire:loading>--}}
{{--                                <svg aria-hidden="true"--}}
{{--                                     class="w-3.5 h-3.5 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"--}}
{{--                                     viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                    <path--}}
{{--                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"--}}
{{--                                            fill="currentColor" />--}}
{{--                                    <path--}}
{{--                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"--}}
{{--                                            fill="currentFill" />--}}
{{--                                </svg>--}}
{{--                                <span class="sr-only">Loading...</span>--}}
{{--                            </div>--}}
{{--                        </button>--}}
{{--                    @else--}}
{{--                        <button wire:click="saveChanges"--}}
{{--                                class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white text-xs font-semibold px-6 py-2 rounded">--}}
{{--                            SAVE--}}
{{--                            <div wire:loading>--}}
{{--                                <svg aria-hidden="true"--}}
{{--                                     class="w-3.5 h-3.5 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"--}}
{{--                                     viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                    <path--}}
{{--                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"--}}
{{--                                            fill="currentColor" />--}}
{{--                                    <path--}}
{{--                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"--}}
{{--                                            fill="currentFill" />--}}
{{--                                </svg>--}}
{{--                                <span class="sr-only">Loading...</span>--}}
{{--                            </div>--}}
{{--                        </button>--}}
{{--                        <button wire:click="toggleEdit"--}}
{{--                                class="bg-custom-yellow text-white text-xs font-semibold px-6 py-2 rounded">--}}
{{--                            CANCEL--}}
{{--                            <div wire:loading>--}}
{{--                                <svg aria-hidden="true"--}}
{{--                                     class="w-3.5 h-3.5 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"--}}
{{--                                     viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                    <path--}}
{{--                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"--}}
{{--                                            fill="currentColor" />--}}
{{--                                    <path--}}
{{--                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"--}}
{{--                                            fill="currentFill" />--}}
{{--                                </svg>--}}
{{--                                <span class="sr-only">Loading...</span>--}}
{{--                            </div>--}}
{{--                        </button>--}}
{{--                    @endif--}}


{{--                        <div class="z-[2000]">--}}
{{--                            <div class="alert"--}}
{{--                                 :class="{primary:'alert-primary', success:'alert-success', danger:'alert-danger', warning:'alert-warning'}[(alert.type ?? 'primary')]"--}}
{{--                                 x-data="{ open:false, alert:{} }"--}}
{{--                                 x-show="open" x-cloak--}}
{{--                                 x-transition:enter="animate-alert-show"--}}
{{--                                 x-transition:leave="animate-alert-hide"--}}
{{--                                 @alert.window="open = true; setTimeout( () => open=false, 3000 ); alert=$event.detail[0]">--}}
{{--                                <div class="alert-wrapper">--}}
{{--                                    <strong x-html="alert.title">Title</strong>--}}
{{--                                    <p x-html="alert.message">Description</p>--}}
{{--                                </div>--}}
{{--                                <i class="alert-close fa-solid fa-xmark" @click="open=false"></i>--}}
{{--                            </div>--}}
{{--                            <!-- SUBMIT Button -->--}}
{{--                            <button type="submit"--}}
{{--                                    class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white text-xs font-medium px-6 py-2 rounded">--}}
{{--                                SUBMIT--}}
{{--                                <div wire:loading>--}}
{{--                                    <svg aria-hidden="true"--}}
{{--                                         class="w-3.5 h-3.5 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"--}}
{{--                                         viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                        <path--}}
{{--                                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"--}}
{{--                                                fill="currentColor" />--}}
{{--                                        <path--}}
{{--                                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"--}}
{{--                                                fill="currentFill" />--}}
{{--                                    </svg>--}}
{{--                                    <span class="sr-only">Loading...</span>--}}
{{--                                </div>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                        <script>--}}
{{--                            document.addEventListener('livewire.initialized', () => {--}}
{{--                                let obj = @json(session('alert') ?? []);--}}
{{--                                if (Object.keys(obj).length){--}}
{{--                                    Livewire.dispatch('alert', [obj])--}}
{{--                                }--}}
{{--                            })--}}
{{--                        </script>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="flex flex-col p-3 rounded mt-12">--}}
{{--                    <h2 class="text-[30px] ml-2 items-center font-bold text-gray-700 underline">{{ $taggedAndValidatedApplicant->applicant->applicant_id }}</h2>--}}
{{--                    <h1 class="text-[25px] ml-2 items-center font-bold text-gray-700">--}}
{{--                        {{ $taggedAndValidatedApplicant->applicant->last_name }}, {{ $taggedAndValidatedApplicant->applicant->first_name }}--}}
{{--                        @if($taggedAndValidatedApplicant->applicant->middle_name) {{ $taggedAndValidatedApplicant->applicant->middle_name }} @endif--}}
{{--                    </h1>--}}
{{--                </div>--}}

{{--                <div class="bg-white p-6 rounded shadow mb-6">--}}
{{--                    <div class="flex flex-wrap -mx-2">--}}
{{--                        <div class="w-full md:w-1/4 px-2 mb-4">--}}
{{--                            <label for="first-name"--}}
{{--                                   class="block text-[12px] font-semibold text-gray-700 mb-1"--}}
{{--                                   aria-describedby>--}}
{{--                                FIRST NAME--}}
{{--                            </label>--}}
{{--                            <input type="text"--}}
{{--                                   wire:model="first_name"--}}
{{--                                   id="first-name"--}}
{{--                                   class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow cursor-default"--}}
{{--                                   readonly>--}}
{{--                            @error('first_name')--}}
{{--                                <span class="text-red-600 error">{{ $message }}</span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                        <div class="w-full md:w-1/4 px-2 mb-4">--}}
{{--                            <label for="middle_name"--}}
{{--                                   class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
{{--                                MIDDLE NAME--}}
{{--                            </label>--}}
{{--                            <input type="text"--}}
{{--                                   wire:model="middle_name"--}}
{{--                                   id="middle_name"--}}
{{--                                   class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow cursor-default"--}}
{{--                                   readonly>--}}
{{--                            @error('middle_name')--}}
{{--                                <span class="text-red-600 error">{{ $message }}</span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                        <div class="w-full md:w-1/4 px-2 mb-4">--}}
{{--                            <label for="last_name"--}}
{{--                                   class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
{{--                                LAST NAME--}}
{{--                            </label>--}}
{{--                            <input type="text"--}}
{{--                                    wire:model="last_name"--}}
{{--                                   id="last_name" class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow cursor-default"--}}
{{--                                   readonly>--}}
{{--                            @error('last_name')--}}
{{--                                <span class="text-red-600 error">{{ $message }}</span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                        <div class="w-full md:w-1/4 px-2 mb-4">--}}
{{--                            <label for="suffix_name"--}}
{{--                                   class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
{{--                                SUFFIX NAME--}}
{{--                            </label>--}}
{{--                            <input type="text"--}}
{{--                                    wire:model="suffix_name"--}}
{{--                                   id="suffix_name"--}}
{{--                                   class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow cursor-default"--}}
{{--                                   readonly>--}}
{{--                            @error('suffix_name')--}}
{{--                                <span class="text-red-600 error">{{ $message }}</span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div x-data="{ civilStatus: '' }">--}}
{{--                        <div class="flex flex-wrap -mx-2">--}}
{{--                            <div class="w-full md:w-1/4 px-2 mb-4">--}}
{{--                                <label for="barangay" class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
{{--                                    BARANGAY--}}
{{--                                </label>--}}
{{--                                <input wire:model="barangay"--}}
{{--                                       id="barangay"--}}
{{--                                       class="w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow capitalize cursor-default" readonly>--}}
{{--                                @error('barangay')--}}
{{--                                    <span class="text-red-600 error">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="w-full md:w-1/4 px-2 mb-4">--}}
{{--                                <label for="purok" class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
{{--                                    PUROK--}}
{{--                                </label>--}}
{{--                                <input wire:model="purok"--}}
{{--                                       id="purok"--}}
{{--                                       class="w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow capitalize cursor-default" readonly>--}}
{{--                                @error('purok')--}}
{{--                                    <span class="text-red-600 error">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="w-full md:w-1/4 px-2 mb-4">--}}
{{--                                <label for="full_address"--}}
{{--                                       class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
{{--                                    FULL ADDRESS--}}
{{--                                </label>--}}
{{--                                <input wire:model="full_address"--}}
{{--                                       type="text"--}}
{{--                                       id="full_address"--}}
{{--                                       class="w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">--}}
{{--                                @error('full_address')--}}
{{--                                    <span class="text-red-600 error">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="w-full md:w-1/4 px-2 mb-4">--}}
{{--                                <label for="civil_status"--}}
{{--                                       class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
{{--                                    CIVIL STATUS--}}
{{--                                </label>--}}
{{--                                <select x-model="civilStatus"--}}
{{--                                        wire:model="civil_status_id"--}}
{{--                                        id="civil_status"--}}
{{--                                        class="w-full p-1 bg-white border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">--}}
{{--                                    <option value="">Select Status</option>--}}
{{--                                    @foreach($civil_statuses as $status)--}}
{{--                                        <option value="{{ $status->id }}">{{ $status->civil_status }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                                @error('civil_status') <span class="text-red-600 error">{{ $message }}</span> @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="flex flex-wrap -mx-2">--}}
{{--                            <div class="w-full md:w-1/4 px-2 mb-4">--}}
{{--                                <label for="contact_number" class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
{{--                                    CONTACT NUMBER--}}
{{--                                </label>--}}
{{--                                <input wire:model="contact_number"--}}
{{--                                       type="text"--}}
{{--                                       id="contact_number"--}}
{{--                                       required class="w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow capitalize cursor-default"--}}
{{--                                       readonly oninput="validateNumberInput(this)">--}}
{{--                                @error('contact_number') <span class="text-red-600 error">{{ $message }}</span> @enderror--}}
{{--                            </div>--}}
{{--                            <div class="w-full md:w-1/4 px-2 mb-4">--}}
{{--                                <label for="tribe" class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
{{--                                    TRIBE/ETHNICITY--}}
{{--                                </label>--}}
{{--                                <select wire:model="tribe_id"--}}
{{--                                        id="tribe"--}}
{{--                                        required--}}
{{--                                        class="w-full p-1 bg-white border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow capitalize">--}}
{{--                                    <option value="">Select Tribe/Ethnicity</option>--}}
{{--                                    @foreach($tribes as $tribe)--}}
{{--                                        <option value="{{ $tribe->id }}">{{ $tribe->tribe_name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                                @error('tribe') <span class="text-red-600 error">{{ $message }}</span> @enderror--}}
{{--                            </div>--}}
{{--                            <div class="w-full md:w-1/4 px-2 mb-4">--}}
{{--                                <label for="sex" class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
{{--                                    SEX--}}
{{--                                </label>--}}
{{--                                <div class="flex items-center">--}}
{{--                                    <div class="mr-6">--}}
{{--                                        <input type="radio"--}}
{{--                                               wire:model="sex"--}}
{{--                                               value="Male"--}}
{{--                                               id="male"--}}
{{--                                               class="mr-2"--}}
{{--                                               required>--}}
{{--                                        <label for="male" class="cursor-pointer">Male</label>--}}
{{--                                    </div>--}}
{{--                                    <div>--}}
{{--                                        <input type="radio"--}}
{{--                                               wire:model="sex"--}}
{{--                                               value="Female"--}}
{{--                                               id="female"--}}
{{--                                               class="mr-2"--}}
{{--                                               required>--}}
{{--                                        <label for="female" class="cursor-pointer">Female</label>--}}
{{--                                    </div>--}}
{{--                                    @error('sex') <span class="text-red-600 error">{{ $message }}</span> @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="w-full md:w-1/4 px-2 mb-4">--}}
{{--                                <label for="date_of_birth" class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
{{--                                    DATE OF BIRTH--}}
{{--                                </label>--}}
{{--                                <input wire:model="date_of_birth"--}}
{{--                                       type="date"--}}
{{--                                       id="date_of_birth"--}}
{{--                                       name="date_of_birth"--}}
{{--                                       required--}}
{{--                                       class="w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">--}}
{{--                                @error('date_of_birth') <span class="text-red-600 error">{{ $message }}</span> @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="flex flex-wrap -mx-2">--}}
{{--                            <div class="w-full md:w-1/4 px-2 mb-4">--}}
{{--                                <label for="religion" class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
{{--                                    RELIGION--}}
{{--                                </label>--}}
{{--                                <select wire:model="religion_id"--}}
{{--                                        id="religion"--}}
{{--                                        class="w-full p-1 bg-white border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">--}}
{{--                                    <option value="">Select Religion</option>--}}
{{--                                    @foreach($religions as $religion)--}}
{{--                                        <option value="{{ $religion->id }}">{{ $religion->religion_name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                                @error('religion') <span class="text-red-600 error">{{ $message }}</span> @enderror--}}
{{--                            </div>--}}
{{--                            <div class="w-full md:w-1/4 px-2 mb-4">--}}
{{--                                <label for="occupation"--}}
{{--                                       class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
{{--                                    OCCUPATION--}}
{{--                                </label>--}}
{{--                                <input type="text"--}}
{{--                                       id="occupation"--}}
{{--                                       wire:model="occupation"--}}
{{--                                       class="w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" --}}
{{--                                       oninput="capitalizeInput(this)">--}}
{{--                                @error('occupation') --}}
{{--                                    <span class="text-red-600 error">{{ $message }}</span> --}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="w-full md:w-1/4 px-2 mb-4">--}}
{{--                                <label for="monthly_income" class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
{{--                                    MONTHLY INCOME--}}
{{--                                </label>--}}
{{--                                <input type="number" id="monthly_income" wire:model="monthly_income"--}}
{{--                                       class="w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"--}}
{{--                                       oninput="validateNumberInput(this)">--}}
{{--                                @error('monthly_income') --}}
{{--                                    <span class="text-red-600 error">{{ $message }}</span> --}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="w-full md:w-1/4 px-2 mb-4">--}}
{{--                                <label for="family_income" class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
{{--                                    FAMILY INCOME--}}
{{--                                </label>--}}
{{--                                <input type="number" id="family_income" wire:model="family_income"--}}
{{--                                       class="w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"--}}
{{--                                       oninput="validateNumberInput(this)">--}}
{{--                                @error('family_income') --}}
{{--                                    <span class="text-red-600 error">{{ $message }}</span> --}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <template x-if="civilStatus === '2'">--}}
{{--                            <div>--}}
{{--                                <hr class="mt-2 mb-2 ">--}}
{{--                                <h2 class="block text-[16px] font-semibold text-gray-700 mb-2">--}}
{{--                                    PARTNER DETAILS--}}
{{--                                </h2>--}}
{{--                                <div class="flex flex-wrap -mx-2">--}}
{{--                                    <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                                        <label for="partner_first_name" --}}
{{--                                               class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
{{--                                            FIRST NAME--}}
{{--                                        </label>--}}
{{--                                        <input type="text"--}}
{{--                                               id="partner_first_name"--}}
{{--                                               wire:model="partner_first_name"--}}
{{--                                               class="w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" --}}
{{--                                               oninput="capitalizeInput(this)">--}}
{{--                                        @error('partner_first_name') --}}
{{--                                            <span class="text-red-600 error">{{ $message }}</span> --}}
{{--                                        @enderror--}}
{{--                                    </div>--}}
{{--                                    <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                                        <label for="partner_middle_name" class="block text-[12px] font-medium text-gray-700 mb-1">--}}
{{--                                            MIDDLE NAME <span class="text-red-500">*</span>--}}
{{--                                        </label>--}}
{{--                                        <input type="text"--}}
{{--                                               id="partner_middle_name"--}}
{{--                                               wire:model="partner_middle_name"--}}
{{--                                               class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">--}}
{{--                                        @error('partner_middle_name') <span class="text-red-600 error">{{ $message }}</span> @enderror--}}
{{--                                    </div>--}}
{{--                                    <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                                        <label for="partner_last_name" class="block text-[12px] font-medium text-gray-700 mb-1">--}}
{{--                                            LAST NAME <span class="text-red-500">*</span>--}}
{{--                                        </label>--}}
{{--                                        <input type="text"--}}
{{--                                               id="partner_last_name"--}}
{{--                                               wire:model="partner_last_name"--}}
{{--                                               class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">--}}
{{--                                        @error('partner_last_name') <span class="text-red-600 error">{{ $message }}</span> @enderror--}}
{{--                                    </div>--}}

{{--                                    <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                                        <label for="partner_occupation" class="block text-[12px] font-medium text-gray-700 mb-1">--}}
{{--                                            OCCUPATION <span class="text-red-500">*</span>--}}
{{--                                        </label>--}}
{{--                                        <input type="text"--}}
{{--                                               id="partner_occupation"--}}
{{--                                               wire:model="partner_occupation"--}}
{{--                                               class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">--}}
{{--                                        @error('partner_occupation') <span class="text-red-600 error">{{ $message }}</span> @enderror--}}
{{--                                    </div>--}}
{{--                                    <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                                        <label for="partner_monthly_income" class="block text-[12px] font-medium text-gray-700 mb-1">--}}
{{--                                            MONTHLY INCOME <span class="text-red-500">*</span>--}}
{{--                                        </label>--}}
{{--                                        <input type="number"--}}
{{--                                               id="partner_monthly_income"--}}
{{--                                               wire:model="partner_monthly_income"--}}
{{--                                               class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"--}}
{{--                                               oninput="validateNumberInput(this)">--}}
{{--                                        @error('spouse_monthly_income') <span class="text-red-600 error">{{ $message }}</span> @enderror--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </template>--}}

{{--                        <template x-if="civilStatus === '3'">--}}
{{--                            <div>--}}
{{--                                <hr class="mt-2 mb-2 ">--}}
{{--                                <h2 class="block text-[12px] font-medium text-gray-700 mb-2">SPOUSE DETAILS</h2>--}}
{{--                                <div class="flex flex-wrap -mx-2">--}}
{{--                                    <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                                        <label for="spouse_first_name" class="block text-[12px] font-medium text-gray-700 mb-1">--}}
{{--                                            FIRST NAME <span class="text-red-500">*</span>--}}
{{--                                        </label>--}}
{{--                                        <input type="text" id="spouse_first_name" wire:model="spouse_first_name" class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">--}}
{{--                                        @error('spouse_first_name') <span class="text-red-600 error">{{ $message }}</span> @enderror--}}
{{--                                    </div>--}}
{{--                                    <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                                        <label for="spouse_middle_name" class="block text-[12px] font-medium text-gray-700 mb-1">--}}
{{--                                            MIDDLE NAME <span class="text-red-500">*</span>--}}
{{--                                        </label>--}}
{{--                                        <input type="text" id="spouse_middle_name" wire:model="spouse_middle_name" class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">--}}
{{--                                        @error('spouse_middle_name') <span class="text-red-600 error">{{ $message }}</span> @enderror--}}
{{--                                    </div>--}}
{{--                                    <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                                        <label for="spouse_last_name" class="block text-[12px] font-medium text-gray-700 mb-1">--}}
{{--                                            LAST NAME <span class="text-red-500">*</span>--}}
{{--                                        </label>--}}
{{--                                        <input type="text" id="spouse_last_name" wire:model="spouse_last_name" class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">--}}
{{--                                        @error('spouse_last_name') <span class="text-red-600 error">{{ $message }}</span> @enderror--}}
{{--                                    </div>--}}

{{--                                    <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                                        <label for="spouse_occupation" class="block text-[12px] font-medium text-gray-700 mb-1">--}}
{{--                                            OCCUPATION <span class="text-red-500">*</span>--}}
{{--                                        </label>--}}
{{--                                        <input type="text" id="spouse_occupation"--}}
{{--                                               wire:model="spouse_occupation"--}}
{{--                                               class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"--}}
{{--                                               oninput="capitalizeInput(this)">--}}
{{--                                        @error('spouse_occupation') <span class="text-red-600 error">{{ $message }}</span> @enderror--}}
{{--                                    </div>--}}
{{--                                    <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                                        <label for="spouse_monthly_income" class="block text-[12px] font-medium text-gray-700 mb-1">--}}
{{--                                            MONTHLY INCOME <span class="text-red-500">*</span>--}}
{{--                                        </label>--}}
{{--                                        <input type="number"--}}
{{--                                               id="spouse_monthly_income"--}}
{{--                                               wire:model="spouse_monthly_income"--}}
{{--                                               class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"--}}
{{--                                               oninput="validateNumberInput(this)">--}}
{{--                                        @error('spouse_monthly_income') <span class="text-red-600 error">{{ $message }}</span> @enderror--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </template>--}}
{{--                    </div>--}}

{{--                    <div class="mt-6">--}}
{{--                        <div class="flex justify-between">--}}
{{--                            <div class="mt-4 flex justify-start">--}}
{{--                                <h2 class="text-[12px] font-medium text-gray-700 mb-2">DEPENDENTS</h2>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <table class="w-full">--}}
{{--                            <thead>--}}
{{--                            <tr class="text-center border border-gray-700">--}}
{{--                                <th class="p-2 border-b">First Name</th>--}}
{{--                                <th class="p-2 border-b">Middle Name</th>--}}
{{--                                <th class="p-2 border-b">Last Name</th>--}}
{{--                                <th class="p-2 border-b">Sex</th>--}}
{{--                                <th class="p-2 border-b">Civil Status</th>--}}
{{--                                <th class="p-2 border-b">Date of Birth</th>--}}
{{--                                <th class="p-2 border-b">Occupation</th>--}}
{{--                                <th class="p-2 border-b">Monthly Income</th>--}}
{{--                                <th class="p-2 border-b">Relationship</th>--}}
{{--                                <th class="p-2 border-b"></th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach($dependents as $index => $dependent)--}}
{{--                                <tr class="odd:bg-custom-green-light even:bg-transparent text-center">--}}
{{--                                    <td class="border px-4 py-2">--}}
{{--                                        <input type="text" wire:model="dependents.{{$index}}.dependent_first_name"--}}
{{--                                               placeholder="First name..."--}}
{{--                                               class="capitalize w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]" oninput="capitalizeInput(this)">--}}
{{--                                    </td>--}}
{{--                                    <td class="border px-4 py-2">--}}
{{--                                        <input type="text" wire:model="dependents.{{$index}}.dependent_middle_name"--}}
{{--                                               placeholder="Middle name..."--}}
{{--                                               class="capitalize w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]" oninput="capitalizeInput(this)">--}}
{{--                                    </td>--}}
{{--                                    <td class="border px-4 py-2">--}}
{{--                                        <input type="text" wire:model="dependents.{{$index}}.dependent_last_name"--}}
{{--                                               placeholder="Last name..."--}}
{{--                                               class="capitalize w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]" oninput="capitalizeInput(this)">--}}
{{--                                    </td>--}}
{{--                                    <td class="border px-4 py-2">--}}
{{--                                        <div class="flex items-center">--}}
{{--                                            <div class="mr-6">--}}
{{--                                                <input type="radio" wire:model="dependents.{{$index}}.dependent_sex"--}}
{{--                                                       value="Male" id="male" class="mr-2">--}}
{{--                                                <label for="male" class="cursor-pointer">Male</label>--}}
{{--                                            </div>--}}
{{--                                            <div>--}}
{{--                                                <input type="radio" wire:model="dependents.{{$index}}.dependent_sex"--}}
{{--                                                       value="Female" id="female" class="mr-2">--}}
{{--                                                <label for="female" class="cursor-pointer">Female</label>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td class="border px-1 py-2">--}}
{{--                                        <select wire:model="dependents.{{$index}}.dependent_civil_status_id"--}}
{{--                                                class="capitalize w-full py-1 bg-transparent focus:outline-none text-[12px]" oninput="capitalizeInput(this)">--}}
{{--                                            <option value="">Select Status</option>--}}
{{--                                            @foreach($dependent_civil_statuses as $dependentStatus)--}}
{{--                                                <option value="{{ $dependentStatus->id }}">{{ $dependentStatus->civil_status }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </td>--}}
{{--                                    <td class="border px-4 py-2">--}}
{{--                                        <input type="date" wire:model="dependents.{{$index}}.dependent_date_of_birth"--}}
{{--                                               class="capitalize w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]">--}}
{{--                                    </td>--}}
{{--                                    <td class="border px-4 py-2">--}}
{{--                                        <input type="text" wire:model="dependents.{{$index}}.dependent_relationship"--}}
{{--                                               placeholder="Mother..."--}}
{{--                                               class="capitalize w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]" oninput="capitalizeInput(this)">--}}
{{--                                    </td>--}}
{{--                                    <td class="border px-4 py-2">--}}
{{--                                        <input type="text" wire:model="dependents.{{$index}}.dependent_occupation"--}}
{{--                                               placeholder="Occupation..."--}}
{{--                                               class="capitalize w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]" oninput="capitalizeInput(this)">--}}
{{--                                    </td>--}}
{{--                                    <td class="border px-4 py-2">--}}
{{--                                        <input type="number" wire:model="dependents.{{$index}}.dependent_monthly_income"--}}
{{--                                               placeholder="9000"--}}
{{--                                               class="capitalize w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]" oninput="capitalizeInput(this)">--}}
{{--                                    </td>--}}
{{--                                    <td class="border px-4 py-2">--}}
{{--                                        <button type="button" wire:click="remove({{ $index }})"--}}
{{--                                                class="text-red-500 hover:text-red-700 text-[14px]">--}}
{{--                                            ✕--}}
{{--                                        </button>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                        <!-- Add Row Button -->--}}
{{--                        <div class="flex justify-end mb-4 mt-4">--}}
{{--                            <button type="button" wire:click="add()"--}}
{{--                                    class="text-white bg-green-500 hover:bg-green-600 text-[12px] px-2 py-2 rounded-md flex items-center">--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"--}}
{{--                                     class="w-5 h-5 mr-1">--}}
{{--                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />--}}
{{--                                </svg>--}}
{{--                                Add Dependent--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div x-data="{--}}
{{--                    livingSituation: @entangle('living_situation_id'),--}}
{{--                    livingStatus: @entangle('living_status_id')}"--}}
{{--                     class="bg-white p-6 rounded shadow mb-6">--}}

{{--                    <div class="flex flex-wrap -mx-2">--}}
{{--                        <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                            <label for="tagging_date" class="block text-[12px] font-medium text-gray-700 mb-1">TAGGING DATE <span class="text-red-500">*</span></label>--}}
{{--                            <input wire:model="tagging_date" type="date" id="tagging_date" name="tagging_date" required class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow uppercase"--}}
{{--                                   max="{{ date('Y-m-d') }}">--}}
{{--                            @error('tagging_date') <span class="text-red-600 error">{{ $message }}</span> @enderror--}}
{{--                        </div>--}}
{{--                        <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                            <label for="living_situation" class="block text-[13px] font-medium text-gray-700 mb-1">LIVING SITUATION (CASE) <span class="text-red-500">*</span></label>--}}
{{--                            <select x-model.number="livingSituation" wire:model="living_situation_id" id="living_situation" name="living_situation"--}}
{{--                                    required class="w-full p-1 bg-white border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">--}}
{{--                                <option value="">Select situation</option>--}}
{{--                                @foreach($livingSituations as $livingSituation)--}}
{{--                                    <option value="{{ $livingSituation->id }}">{{ $livingSituation->living_situation_description }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @error('living_situation') <span class="error text-red-600">{{ $message }}</span> @enderror--}}
{{--                        </div>--}}
{{--                        <template x-if="livingSituation >= '1' && livingSituation <= '7'  || livingSituation === '9'">--}}
{{--                            <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                                <label for="living_situation_case_specification" class="block text-[13px] font-medium text-gray-700 mb-1">LIVING SITUATION CASE SPECIFICATION <span class="text-red-500">*</span></label>--}}
{{--                                <textarea wire:model="living_situation_case_specification" type="text" id="living_situation_case_specification" name="living_situation_case_specification" placeholder="Enter case details"--}}
{{--                                          class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" required>--}}
{{--                                </textarea>--}}
{{--                                @error('living_situation_case_specification') <span class="error text-red-600">{{ $message }}</span> @enderror--}}
{{--                            </div>--}}
{{--                        </template>--}}
{{--                        <template x-if="livingSituation == '8'">--}}
{{--                            <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                                <label for="case_specification" class="block text-[13px] font-medium text-gray-700 mb-1">CASE SPECIFICATION <span class="text-red-500">*</span></label>--}}
{{--                                <select wire:model="case_specification_id" id="case_specification" name="case_specification"--}}
{{--                                        class="w-full p-1 bg-white border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow uppercase" required>--}}
{{--                                    <option value="">Select specification</option>--}}
{{--                                    @foreach($caseSpecifications as $caseSpecification)--}}
{{--                                        <option value="{{ $caseSpecification->id }}">{{ $caseSpecification->case_specification_name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                                @error('case_specification') <span class="error text-red-600">{{ $message }}</span> @enderror--}}
{{--                            </div>--}}
{{--                        </template>--}}
{{--                    </div>--}}

{{--                    <div class="flex flex-wrap -mx-2">--}}
{{--                        <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                            <label for="government_program" class="block text-[13px] font-medium text-gray-700 mb-1">GOVERNMENT PROGRAMS</label>--}}
{{--                            <select wire:model="government_program_id" id="government_program" name="government_program"--}}
{{--                                    required class="w-full p-1 bg-white border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">--}}
{{--                                <option value="">Select type of assistance</option>--}}
{{--                                @foreach($governmentPrograms as $governmentProgram)--}}
{{--                                    <option value="{{ $governmentProgram->id }}">{{ $governmentProgram->program_name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @error('government_program') <span class="error text-red-600">{{ $message }}</span> @enderror--}}
{{--                        </div>--}}
{{--                        <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                            <label for="living_status" class="block text-[13px] font-medium text-gray-700 mb-1">LIVING STATUS <span class="text-red-500">*</span></label>--}}
{{--                            <select x-model.number="livingStatus" wire:model="living_status_id" id="living_status" name="living_status"--}}
{{--                                    required class="w-full p-1 bg-white border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">--}}
{{--                                <option value="">Select status</option>--}}
{{--                                @foreach($livingStatuses as $livingStatus)--}}
{{--                                    <option value="{{ $livingStatus->id }}">{{ $livingStatus->living_status_name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @error('living_status') <span class="error text-red-600">{{ $message }}</span> @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <template x-if="livingStatus === '1'">--}}
{{--                        <div class="flex flex-wrap -mx-2 ml-[33%]">--}}
{{--                            <div class="w-full md:w-2/4 px-2 mb-4">--}}
{{--                                <label for="rent_fee" class="block text-[13px] font-medium text-gray-700 mb-1">RENT FEE <span class="text-red-500">*</span></label>--}}
{{--                                <input wire:model="rent_fee" type="number" id="rent_fee" name="rent_fee" placeholder="How much monthly?"--}}
{{--                                       class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"--}}
{{--                                       min="0" step="0.01" oninput="validateNumberInput(this)">--}}
{{--                                @error('rent_fee') <span class="error text-red-600">{{ $message }}</span> @enderror--}}
{{--                            </div>--}}
{{--                            <div class="w-full md:w-2/4 px-2 mb-4">--}}
{{--                                <label for="landlord" class="block text-[13px] font-medium text-gray-700 mb-1">LANDLORD <span class="text-red-500">*</span></label>--}}
{{--                                <input wire:model="landlord" type="text" id="landlord" name="landlord" placeholder="LANDLORD"--}}
{{--                                       class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">--}}
{{--                                @error('landlord') <span class="error text-red-600">{{ $message }}</span> @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </template>--}}
{{--                    <template x-if="livingStatus === '5'">--}}
{{--                        <div class="flex flex-wrap -mx-2 ml-[33%]">--}}
{{--                            <div class="w-full md:w-2/4 px-2 mb-4">--}}
{{--                                <label for="house_owner" class="block text-[13px] font-medium text-gray-700 mb-1">HOUSE OWNER NAME <span class="text-red-500">*</span></label>--}}
{{--                                <input wire:model="house_owner" type="text" id="house_owner" name="house_owner" placeholder="HOUSE OWNER NAME"--}}
{{--                                       required class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">--}}
{{--                                @error('house_owner') <span class="error text-red-600">{{ $message }}</span> @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </template>--}}

{{--                    <div class="flex flex-wrap -mx-2">--}}
{{--                        <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                            <label class="block text-[13px] font-bold text-gray-700 mt-1 mb-1">HOUSE MATERIALS</label>--}}
{{--                            <label for="roof_type" class="block text-[13px] font-medium text-gray-700 mb-1">ROOF <span class="text-red-500">*</span></label>--}}
{{--                            <select wire:model="roof_type_id" id="roof_type" name="roof_type"--}}
{{--                                    required class="w-full p-1 bg-white border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">--}}
{{--                                <option value="">Select type of roof</option>--}}
{{--                                @foreach($roofTypes as $roofType)--}}
{{--                                    <option value="{{ $roofType->id }}">{{ $roofType->roof_type_name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @error('roof_type') <span class="error text-red-600">{{ $message }}</span> @enderror--}}
{{--                        </div>--}}
{{--                        <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                            <label for="wall_type" class="block text-[13px] font-medium text-gray-700 mt-7 mb-1">WALL <span class="text-red-500">*</span></label>--}}
{{--                            <select wire:model="wall_type_id" id="wall_type" name="wall_type"--}}
{{--                                    required class="w-full p-1 bg-white border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">--}}
{{--                                <option value="">Select type of wall</option>--}}
{{--                                @foreach($wallTypes as $wallType)--}}
{{--                                    <option value="{{ $wallType->id }}">{{ $wallType->wall_type_name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @error('wall_type') <span class="error text-red-600">{{ $message }}</span> @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="flex flex-wrap -mx-2">--}}
{{--                        <div class="w-full md:w-full px-2 mb-4">--}}
{{--                            <label for="remarks" class="block text-[13px] font-medium text-gray-700 mb-1">REMARKS</label>--}}
{{--                            <input wire:model="remarks" type="text" id="remarks" name="remarks" class="w-full p-3 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">--}}
{{--                            @error('remarks') <span class="error text-red-600">{{ $message }}</span> @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="p-3 rounded">--}}
{{--                    <h2 class="text-[13px] ml-2 items-center font-bold text-gray-700">UPLOAD DOCUMENTS</h2>--}}
{{--                    <p class="text-[12px] ml-2 items-center text-gray-700">Upload here the captured requirements submitted by the qualified applicants.</p>--}}
{{--                </div>--}}

{{--                <!-- File Uploads -->--}}
{{--                <div x-data="fileUpload()" class="bg-white p-6 rounded shadow mb-6">--}}
{{--                    <div class="grid grid-cols-2 gap-2">--}}
{{--                        <!-- Drag and Drop Area -->--}}
{{--                        <div class="border-2 border-dashed border-green-500 rounded-lg p-4 flex flex-col items-center space-y-1">--}}
{{--                            <svg class="w-10 h-10 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"--}}
{{--                                 viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                                      d="M3 15a4 4 0 011-7.874V7a5 5 0 018.874-2.485A5.5 5.5 0 1118.5 15H5z" />--}}
{{--                            </svg>--}}
{{--                            --}}{{--                                <p class="text-gray-500 text-xs">DRAG AND DROP FILES</p>--}}
{{--                            --}}{{--                                <p class="text-gray-500 text-xs">or</p>--}}
{{--                            <button type="button"--}}
{{--                                    class="px-3 py-1 bg-green-600 text-white rounded-md text-xs hover:bg-green-700"--}}
{{--                                    @click="$refs.fileInput.click()">BROWSE FILES--}}
{{--                            </button>--}}

{{--                            <!-- Hidden File Input for Multiple Files -->--}}
{{--                            <input wire:model="images" type="file" id="images" name="images" x-ref="fileInput" @change="addFiles($refs.fileInput.files)" multiple--}}
{{--                                   class="hidden" required/>--}}
{{--                            @error('images') <span class="error text-red-600">{{ $message }}</span> @enderror--}}
{{--                        </div>--}}

{{--                        <!-- Show selected files and progress bars -->--}}
{{--                        <div class="w-full grid grid-cols-1 gap-2 border-2 border-dashed border-green-500 rounded-lg p-2">--}}
{{--                            <template x-for="(fileWrapper, index) in files" :key="index">--}}
{{--                                <div @click="openPreviewModal = true; selectedFile = fileWrapper"--}}
{{--                                     class="bg-white p-2 shadow border-2 border-green-500 rounded-lg">--}}
{{--                                    <div class="flex items-center justify-between mb-2">--}}
{{--                                        <div class="flex items-center space-x-2">--}}
{{--                                            <svg class="w-4 h-4 text-orange-500" xmlns="http://www.w3.org/2000/svg"--}}
{{--                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                                                      d="M7 3v6h4l1 1h4V3H7z" />--}}
{{--                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                                                      d="M5 8v10h14V8H5z" />--}}
{{--                                            </svg>--}}
{{--                                            <span class="text-xs font-medium text-gray-700"--}}
{{--                                                  x-text="fileWrapper.displayName"></span>--}}
{{--                                        </div>--}}
{{--                                        <!-- Status -->--}}
{{--                                        <span class="text-xs text-green-500 font-medium">100%</span>--}}
{{--                                    </div>--}}
{{--                                    <!-- Progress Bar -->--}}
{{--                                    <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden cursor-pointer">--}}
{{--                                        <div class="w-full h-full bg-green-500"></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </template>--}}
{{--                        </div>--}}

{{--                        <!-- Preview Modal (Triggered by Clicking a Progress Bar) -->--}}
{{--                        <div x-show="openPreviewModal"--}}
{{--                             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 shadow-lg"--}}
{{--                             x-cloak>--}}
{{--                            <div class="bg-white w-[600px] rounded-lg shadow-lg p-6 relative">--}}
{{--                                <!-- Modal Header with File Name -->--}}
{{--                                <div class="flex justify-between items-center mb-4">--}}
{{--                                    <!-- Only show input if selectedFile is not null -->--}}
{{--                                    <template x-if="selectedFile">--}}
{{--                                        --}}{{--                                        <input type="text" x-model="selectedFile.displayName"--}}
{{--                                        --}}{{--                                               class="text-[13px] w-[60%] font-regular text-black border-none focus:outline-none focus:ring-0">--}}
{{--                                        <input type="text" x-model="selectedFile.displayName" wire:model.defer="renamedFileName"--}}
{{--                                               class="text-[13px] w-[60%] font-regular text-black border-none focus:outline-none focus:ring-0"--}}
{{--                                               placeholder="Rename file">--}}
{{--                                        @error('images') <span class="error text-red-600">{{ $message }}</span> @enderror--}}
{{--                                    </template>--}}
{{--                                    <button class="text-orange-500 underline text-sm" @click="renameFile()">Rename File</button>--}}
{{--                                    <button @click="openPreviewModal = false" class="text-gray-400 hover:text-gray-200">&times;</button>--}}
{{--                                </div>--}}

{{--                                <!-- Display Image -->--}}
{{--                                <div class="flex justify-center mb-4">--}}
{{--                                    --}}{{-- <img :src="selectedFile ? URL.createObjectURL(selectedFile.file) : '/path/to/default/image.jpg'"--}}
{{--                                    <img :src="selectedFile && selectedFile.file ? URL.createObjectURL(selectedFile.file) : '/path/to/default/image.jpg'"--}}
{{--                                         alt="Preview Image" class="w-full h-auto max-h-[60vh] object-contain">--}}
{{--                                </div>--}}
{{--                                <!-- Modal Buttons -->--}}
{{--                                <div class="flex justify-between mt-4">--}}
{{--                                    <button type="button" class="px-4 py-2 bg-green-600 text-white rounded-lg"--}}
{{--                                            @click="confirmFile(); $wire.store(selectedFile.file, selectedFile.renamedFileName)">CONFIRM--}}
{{--                                    </button>--}}
{{--                                    <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg"--}}
{{--                                            @click="removeFile(selectedFile); openPreviewModal = false">REMOVE--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <script>--}}
{{--                    function fileUpload() {--}}
{{--                        return {--}}
{{--                            files: [],--}}
{{--                            selectedFile: null,--}}
{{--                            openPreviewModal: false,--}}
{{--                            addFiles(fileList) {--}}
{{--                                for (let i = 0; i < fileList.length; i++) {--}}
{{--                                    const file = fileList[i];--}}
{{--                                    this.files.push({--}}
{{--                                        file,--}}
{{--                                        displayName: file.name--}}
{{--                                    });--}}
{{--                                    // Also push to the Livewire photo array (make sure you declare this in your component)--}}
{{--                                    this.$wire.set('images', [...this.images, file]);--}}
{{--                                }--}}
{{--                            },--}}
{{--                            removeFile(fileWrapper) {--}}
{{--                                this.files = this.files.filter(f => f !== fileWrapper);--}}
{{--                            },--}}
{{--                            renameFile() {--}}
{{--                                if (this.selectedFile) {--}}
{{--                                    const newName = prompt('Rename File', this.selectedFile.displayName);--}}
{{--                                    if (newName) {--}}
{{--                                        this.selectedFile.displayName = newName;--}}
{{--                                        const fileIndex = this.files.findIndex(f => f === this.selectedFile);--}}
{{--                                        if (fileIndex > -1) {--}}
{{--                                            this.files[fileIndex].displayName = newName;--}}
{{--                                        }--}}

{{--                                    }--}}
{{--                                }--}}
{{--                            },--}}
{{--                            confirmFile() {--}}
{{--                                // Logic to handle file confirmation (just close modal)--}}
{{--                                this.openPreviewModal = false;--}}
{{--                            }--}}
{{--                        }--}}
{{--                    }--}}
{{--                </script>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<script>--}}
{{--    function capitalizeInput(input) {--}}
{{--        input.value = input.value.toLowerCase().replace(/\b\w/g, function(char) {--}}
{{--            return char.toUpperCase();--}}
{{--        });--}}
{{--    }--}}
{{--</script>--}}
{{--<script>--}}
{{--    // Function to allow only numeric input--}}
{{--    function validateNumberInput(input) {--}}
{{--        // Remove any characters that are not digits--}}
{{--        input.value = input.value.replace(/[^0-9]/g, '');--}}
{{--    }--}}
{{--</script>--}}

<div class="p-10 h-screen ml-[17%] mt-[60px]">
    <div x-data="{
        openModalBlacklist: false,
        living_situation_id: @entangle('living_situation_id'),
        livingStatusId: @entangle('living_status_id'),
        isRenting() { return this.livingStatusId == 1 },
        isLivingWithOthers() { return this.livingStatusId == 5 } }"
         class="flex bg-gray-100 text-[12px]">
        <div x-data="{ isEditable: false }" class="flex-1 p-6 overflow-auto">
            <div class="bg-white rounded shadow mb-4 flex items-center justify-between p-3 fixed top-[80px] left-[20%] right-[3%] z-5">
                <div class="flex items-center">
                    <a href="{{ route('transaction-request') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                             stroke="currentColor" class="w-5 h-5 text-custom-yellow mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h2 class="text-[13px] ml-2 items-center text-gray-700">Tagged and Validated Applicant Details</h2>
                </div>
                <img src="{{ asset('storage/images/design.png') }}" alt="Design"
                     class="absolute right-0 top-0 h-full object-cover 0 z-0">
                <div x-data="{ saved: false }" class="flex space-x-2 z-0">
                    @if(!$isEditing)
                        <button
                                wire:click="toggleEdit"
                                type="button"
                                class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white text-xs font-semibold px-6 py-2 rounded">
                            EDIT
                            <div wire:loading>
                                <svg aria-hidden="true"
                                     class="w-3.5 h-3.5 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                     viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="currentColor"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentFill"/>
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    @else
                        <button type="submit" wire:click.prevent="update"
                                class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white text-xs font-semibold px-6 py-2 rounded">
                            SAVE
                            <div wire:loading>
                                <svg aria-hidden="true"
                                     class="w-3.5 h-3.5 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                     viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="currentColor"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentFill"/>
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                        <button wire:click="toggleEdit"
                                class="bg-custom-yellow text-white text-xs font-semibold px-6 py-2 rounded">
                            CANCEL
                            <div wire:loading>
                                <svg aria-hidden="true"
                                     class="w-3.5 h-3.5 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                     viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="currentColor"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentFill"/>
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    @endif
                </div>
            </div>

            <div class="flex flex-col p-3 rounded mt-11">
                <h2 class="text-[30px] items-center font-bold text-gray-700 underline">{{ $taggedAndValidatedApplicant->applicant->applicant_id }}</h2>
                <h1 class="text-[25px] items-center font-bold text-gray-700">
                    {{ $taggedAndValidatedApplicant->applicant->first_name }}
                    @if($taggedAndValidatedApplicant->applicant->middle_name) {{ substr($taggedAndValidatedApplicant->applicant->middle_name, 0, 1) }}. @endif
                    {{ $taggedAndValidatedApplicant->applicant->last_name }}
                    {{ $taggedAndValidatedApplicant->applicant->suffix_name }}
                </h1>
            </div>

            <div class="bg-white p-6 rounded shadow mb-6">
                <form wire:submit.prevent="update">
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="first-name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                FIRST NAME
                            </label>
                            <input wire:model="first_name"
                                   type="text"
                                   id="first_name"
                                   @disabled(!$isEditing)
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                   oninput="capitalizeInput(this)">
                            @error('first_name')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="middle-name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                MIDDLE NAME
                            </label>
                            <input wire:model="middle_name"
                                   type="text"
                                   id="middle-name"
                                   @disabled(!$isEditing)
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                   oninput="capitalizeInput(this)">
                            @error('middle_name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="last-name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                LAST NAME
                            </label>
                            <input wire:model="last_name"
                                   type="text"
                                   id="last-name"
                                   @disabled(!$isEditing)
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                   oninput="capitalizeInput(this)">
                            @error('last_name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="suffix_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                SUFFIX NAME
                            </label>
                            <input wire:model="suffix_name"
                                   type="text"
                                   id="suffix_name"
                                   @disabled(!$isEditing)
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                   oninput="capitalizeInput(this)">
                            @error('suffix_name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div x-data="{ civilStatus: '' }">
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="barangay_id"
                                       class="block text-[12px] font-semibold text-gray-700 mb-1">BARANGAY</label>
                                @if($isEditing)
                                    <select wire:model.live="barangay_id"
                                            id="barangay_id"
                                            class="uppercase w-full p-1 border-b text-[12px] border-gray-300 bg-white rounded-md focus:outline-none focus:ring-custom-yellow">
                                        <option value="">Select Barangay</option>
                                        @foreach($barangays as $barangay)
                                            <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('barangay_id') <span class="text-danger">{{ $message }}</span> @enderror
                                @else
                                    <input type="text"
                                           value="{{ $taggedAndValidatedApplicant->applicant?->address?->barangay?->name ?? '--' }}"
                                           disabled
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                @endif
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="purok_id" class="block text-[12px] font-semibold text-gray-700 mb-1">PUROK</label>
                                @if($isEditing)
                                    <div wire:loading wire:target="barangay_id">
                                        <span class="text-muted">Loading puroks...</span>
                                    </div>
                                    <select wire:model.live="purok_id"
                                            id="purok_id"
                                            class="uppercase w-full p-1 border-b text-[12px] border-gray-300 bg-white rounded-md focus:outline-none focus:ring-custom-yellow"
                                            {{ empty($puroks) ? 'disabled' : '' }}>
                                        <option value="">Select Purok</option>
                                        @foreach($puroks as $purok)
                                            <option value="{{ $purok->id }}">{{ $purok->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('purok_id') <span class="text-danger">{{ $message }}</span> @enderror
                                @else
                                    <input type="text"
                                           value="{{ $taggedAndValidatedApplicant->applicant?->address?->purok?->name ?? '--' }}"
                                           disabled
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                @endif
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="full-address" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    FULL ADDRESS
                                </label>
                                <input wire:model="full_address"
                                       type="text"
                                       id="full_address"
                                       @disabled(!$isEditing)
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       oninput="capitalizeInput(this)">
                                @error('full-address')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="civil_status_id"
                                       class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    CIVIL STATUS
                                </label>
                                @if($isEditing)
                                    <select x-model="civilStatus"
                                            wire:model="civil_status_id"
                                            id="civil_status_id"
                                            class="uppercase w-full p-1 border-b text-[12px] border-gray-300 bg-white rounded-md focus:outline-none focus:ring-custom-yellow">
                                        @foreach($civilStatuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->civil_status }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text"
                                           value="{{ $taggedAndValidatedApplicant->civilStatus->civil_status }}"
                                           disabled
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                @endif
                                @error('civil_status_id')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="contactNo" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    CONTACT NUMBER
                                </label>
                                <input wire:model="contact_number"
                                       type="text"
                                       id="contact_number"
                                       @disabled(!$isEditing)
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       oninput="validateNumberInput(this)">
                                @error('contact_number')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="tribe" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    TRIBE/ETHNICITY
                                </label>
                                @if($isEditing)
                                    <select wire:model="tribe_id"
                                            id="tribe_id"
                                            class="uppercase w-full p-1 border text-[12px] bg-white border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                        @foreach($tribes as $tribe)
                                            <option value="{{ $tribe->id }}">{{ $tribe->tribe_name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text"
                                           value="{{ $taggedAndValidatedApplicant->tribe->tribe_name }}"
                                           disabled
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                @endif
                                @error('tribe_id')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="sex" class="block text-[12px] font-semibold text-gray-700 mb-1">SEX</label>
                                <div class="flex items-center">
                                    @if($isEditing)
                                        <div class="mr-6">
                                            <input type="radio" wire:model="sex" value="Male" id="male" class="mr-2" required>
                                            <label for="male" class="cursor-pointer">Male</label>
                                        </div>
                                        <div>
                                            <input type="radio" wire:model="sex" value="Female" id="female" class="mr-2" required>
                                            <label for="female" class="cursor-pointer">Female</label>
                                        </div>
                                    @else
                                        <input type="text"
                                               value="{{ $taggedAndValidatedApplicant->sex }}"
                                               disabled
                                               class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    @endif
                                    @error('sex')
                                        <span class="text-red-600 error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="age" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    DATE OF BIRTH
                                </label>
                                @if($isEditing)
                                    <input wire:model="date_of_birth"
                                           type="date"
                                           id="date_of_birth"
                                           @disabled(!$isEditing)
                                           class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                @else
                                    <input type="text"
                                           value="{{ $taggedAndValidatedApplicant->date_of_birth ? date('F d, Y', strtotime($taggedAndValidatedApplicant->date_of_birth)) : 'N/A' }}"
                                           disabled
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                @endif
                                @error('date_of_birth')
                                <span class="text-red-600 error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="religion"
                                       class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    RELIGION
                                </label>
                                @if($isEditing)
                                    <select wire:model="religion_id"
                                            id="religion_id"
                                            class="uppercase w-full p-1 border text-[12px] bg-white border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                        @foreach($religions as $religion)
                                            <option value="{{ $religion->id }}">{{ $religion->religion_name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text"
                                           value="{{ $taggedAndValidatedApplicant->religion->religion_name }}"
                                           disabled
                                           class="uppercase w-full p-1 border-b text-[12px] bg-white border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                @endif
                                @error('religion_id')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="occupation" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    OCCUPATION
                                </label>
                                <input wire:model="occupation"
                                       type="text"
                                       id="occupation"
                                       @disabled(!$isEditing)
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       oninput="capitalizeInput(this)">
                                @error('occupation')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="monthly_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    MONTHLY INCOME
                                </label>
                                <input wire:model="monthly_income"
                                       type="text"
                                       id="monthly_income"
                                       @disabled(!$isEditing)
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       oninput="validateNumberInput(this)">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="family_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    FAMILY INCOME
                                </label>
                                <input wire:model="family_income"
                                       type="text"
                                       id="family_income"
                                       @disabled(!$isEditing)
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       oninput="validateNumberInput(this)">
                            </div>
                        </div>
                        @if($isEditing)
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
                                                   class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">
                                            @error('partner_first_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="w-full md:w-1/3 px-2 mb-4">
                                            <label for="partner_middle_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                                MIDDLE NAME <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text"
                                                   id="partner_middle_name"
                                                   wire:model="partner_middle_name"
                                                   class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">
                                            @error('partner_middle_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="w-full md:w-1/3 px-2 mb-4">
                                            <label for="partner_last_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                                LAST NAME <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text"
                                                   id="partner_last_name"
                                                   wire:model="partner_last_name"
                                                   class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">
                                            @error('partner_last_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="w-full md:w-1/3 px-2 mb-4">
                                            <label for="partner_occupation" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                                OCCUPATION <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text"
                                                   id="partner_occupation"
                                                   wire:model="partner_occupation"
                                                   class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">
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
                                            <input type="text" id="spouse_first_name" wire:model="spouse_first_name" class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">
                                            @error('spouse_first_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="w-full md:w-1/3 px-2 mb-4">
                                            <label for="spouse_middle_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                                MIDDLE NAME <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" id="spouse_middle_name" wire:model="spouse_middle_name" class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">
                                            @error('spouse_middle_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="w-full md:w-1/3 px-2 mb-4">
                                            <label for="spouse_last_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                                LAST NAME <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" id="spouse_last_name" wire:model="spouse_last_name" class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">
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
                        @else
                            <hr class="mt-2 mb-2 ">
                            <h2 class="block text-[16px] font-semibold text-gray-700 mb-2">LIVE-IN PARTNER'S MAIDEN NAME</h2>
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="partner_first_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        FIRST NAME</label>
                                    <input wire:model="partner_first_name"
                                           type="text" id="partner_first_name"
                                           @disabled(!$isEditing)
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                           oninput="capitalizeInput(this)">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="partner_middle_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        MIDDLE NAME
                                    </label>
                                    <input wire:model="partner_middle_name"
                                           type="text"
                                           id="partner_middle_name"
                                           @disabled(!$isEditing)
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                           oninput="capitalizeInput(this)">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="partner_last_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        LAST NAME</label>
                                    <input wire:model="partner_last_name"
                                           type="text"
                                           id="partner_last_name"
                                           @disabled(!$isEditing)
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                           oninput="capitalizeInput(this)">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="partner_occupation" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        OCCUPATION
                                    </label>
                                    <input wire:model="partner_occupation"
                                           type="text"
                                           id="partner_occupation"
                                           @disabled(!$isEditing)
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                           oninput="capitalizeInput(this)">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="partner_monthly_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        MONTHLY INCOME
                                    </label>
                                    <input wire:model="partner_monthly_income"
                                           type="text"
                                           id="partner_monthly_income"
                                           @disabled(!$isEditing)
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                           oninput="validateNumberInput(this)">
                                </div>
                            </div>

                            <hr class="mt-2 mb-2 ">
                            <h2 class="block text-[16px] font-semibold text-gray-700 mb-2">SPOUSE MAIDEN NAME</h2>
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="spouse_first_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        FIRST NAME</label>
                                    <input wire:model="spouse_first_name"
                                           type="text" id="spouse_first_name"
                                           @disabled(!$isEditing)
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                           oninput="capitalizeInput(this)">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="spouse_middle_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        MIDDLE NAME
                                    </label>
                                    <input wire:model="spouse_middle_name"
                                           type="text"
                                           id="spouse_middle_name"
                                           @disabled(!$isEditing)
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                           oninput="capitalizeInput(this)">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="spouse_last_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        LAST NAME</label>
                                    <input wire:model="spouse_last_name"
                                           type="text"
                                           id="spouse_last_name"
                                           @disabled(!$isEditing)
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                           oninput="capitalizeInput(this)">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="spouse_occupation" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        OCCUPATION
                                    </label>
                                    <input wire:model="spouse_occupation"
                                           type="text"
                                           id="spouse_occupation"
                                           @disabled(!$isEditing)
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                           oninput="capitalizeInput(this)">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="spouse_monthly_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        MONTHLY INCOME
                                    </label>
                                    <input wire:model="spouse_monthly_income"
                                           type="text"
                                           id="spouse_monthly_income"
                                           @disabled(!$isEditing)
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                           oninput="validateNumberInput(this)">
                                </div>
                            </div>
                        @endif
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
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dependents as $index => $dependent)
                                <tr class="odd:bg-custom-green-light even:bg-transparent text-center">
                                    <td class="border px-4 py-2">
                                        @if($isEditing)
                                            <input type="text"
                                                   wire:model="dependents.{{ $index }}.dependent_first_name"
                                                   class="w-full border-gray-300 rounded-md shadow-sm">
                                        @else
                                            {{ $dependent['dependent_first_name'] }}
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">
                                        @if($isEditing)
                                            <input type="text"
                                                   wire:model="dependents.{{ $index }}.dependent_middle_name"
                                                   class="w-full border-gray-300 rounded-md shadow-sm">
                                        @else
                                            {{ $dependent['dependent_middle_name'] }}
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">
                                        @if($isEditing)
                                            <input type="text"
                                                   wire:model="dependents.{{ $index }}.dependent_last_name"
                                                   class="w-full border-gray-300 rounded-md shadow-sm">
                                        @else
                                            {{ $dependent['dependent_last_name'] }}
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">
                                        @if($isEditing)
                                            <input type="text"
                                                   wire:model="dependents.{{ $index }}.dependent_sex"
                                                   class="w-full border-gray-300 rounded-md shadow-sm">
                                        @else
                                            {{ $dependent['dependent_sex'] }}
                                        @endif
                                    </td>
                                    <td class="border px-1 py-2">
                                        @if($isEditing)
                                            <select wire:model="dependents.{{ $index }}.dependent_civil_status_id"
                                                    class="w-full border-gray-300 rounded-md shadow-sm">
                                                <option value="">Select Civil Status</option>
                                                @foreach($civilStatuses as $status)
                                                    <option value="{{ $status->id }}">{{ $status->civil_status }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            {{ $civilStatuses->find($dependent['dependent_civil_status_id'])?->civil_status ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">
                                        @if($isEditing)
                                            <input type="text"
                                                   wire:model="dependents.{{ $index }}.dependent_date_of_birth"
                                                   class="w-full border-gray-300 rounded-md shadow-sm">
                                        @else
                                            {{ $dependent['dependent_date_of_birth'] ? date('M d, Y', strtotime($dependent['dependent_date_of_birth'])) : 'N/A' }}
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">
                                        @if($isEditing)
                                            <input type="text"
                                                   wire:model="dependents.{{ $index }}.dependent_relationship"
                                                   class="w-full border-gray-300 rounded-md shadow-sm">
                                        @else
                                            {{ $dependent['dependent_relationship'] }}
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">
                                        @if($isEditing)
                                            <input type="text"
                                                   wire:model="dependents.{{ $index }}.dependent_occupation"
                                                   class="w-full border-gray-300 rounded-md shadow-sm">
                                        @else
                                            {{ $dependent['dependent_occupation'] }}
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">
                                        @if($isEditing)
                                            <input type="text"
                                                   wire:model="dependents.{{ $index }}.dependent_monthly_income"
                                                   class="w-full border-gray-300 rounded-md shadow-sm">
                                        @else
                                            {{ $dependent['dependent_monthly_income'] }}
                                        @endif
                                    </td>
                                    @if($isEditing)
                                        <td class="px-4 py-2">
                                            <button type="button"
                                                    wire:click="confirmDelete({{ $index }})"
                                                    class="text-red-500 hover:text-red-700 text-[14px]">
                                                ✕
                                                <div wire:loading>
                                                    <svg aria-hidden="true"
                                                         class="w-3.5 h-3.5 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
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
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- Add Row Button -->
                        @if($isEditing)
                            <div class="flex justify-end mb-4 mt-4">
                                <button wire:click="addDependent()"
                                        type="button"
                                        class="text-white bg-green-500 hover:bg-green-600 text-[12px] px-2 py-2 rounded-md flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                         class="w-5 h-5 mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Add Dependent
                                </button>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
            {{--            <div class="bg-white p-6 rounded shadow mb-6">--}}
            {{--                <form>--}}
            {{--                    <h2 class="block text-[12px] font-semibold text-gray-700 mb-2">PREVIOUS AWARDEE NAME</h2>--}}
            {{--                    <div class="flex flex-wrap -mx-2">--}}
            {{--                        <div class="w-full md:w-1/3 px-2 mb-4">--}}
            {{--                            <label for="prevfirstname" class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
            {{--                                FIRST NAME</label>--}}
            {{--                            <input type="text" id="prevfirstname" name="prevfirstname"--}}
            {{--                                   :disabled="!isEditable"--}}
            {{--                                   class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"--}}
            {{--                                   oninput="capitalizeInput(this)">--}}
            {{--                        </div>--}}
            {{--                        <div class="w-full md:w-1/3 px-2 mb-4">--}}
            {{--                            <label for="prevmiddlename" class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
            {{--                                MIDDLE NAME</label>--}}
            {{--                            <input type="text" id="prevmiddlename" name="prevmiddlename"--}}
            {{--                                   :disabled="!isEditable"--}}
            {{--                                   class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"--}}
            {{--                                   oninput="capitalizeInput(this)">--}}
            {{--                        </div>--}}
            {{--                        <div class="w-full md:w-1/3 px-2 mb-4">--}}
            {{--                            <label for="prevlastname" class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
            {{--                                LAST NAME</label>--}}
            {{--                            <input type="text" id="prevlastname" name="prevlastname"--}}
            {{--                                   :disabled="!isEditable"--}}
            {{--                                   class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"--}}
            {{--                                   oninput="capitalizeInput(this)">--}}
            {{--                        </div>--}}

            {{--                    </div>--}}
            {{--                    <div class="flex flex-wrap -mx-2">--}}
            {{--                        <div class="w-full md:w-1/3 px-2 mb-4">--}}
            {{--                            <label for="taggedDate" class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
            {{--                                TRANSFERED DATE--}}
            {{--                            </label>--}}
            {{--                            <input type="date" id="taggedDate" name="taggedDate"--}}
            {{--                                   :disabled="!isEditable"--}}
            {{--                                   class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </form>--}}
            {{--            </div>--}}
            <div class="bg-white p-6 rounded shadow mb-6">
                <form>
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-4/12 px-2 mb-4">
                            <label for="date_applied" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                DATE APPLIED
                            </label>
                            @if($isEditing)
                                <input wire:model="date_applied"
                                       type="date"
                                       id="date_applied"
                                       @disabled(!$isEditing)
                                       class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @else
                                <input type="text"
                                       value="{{ $taggedAndValidatedApplicant->applicant->date_applied ? date('F d, Y', strtotime($taggedAndValidatedApplicant->applicant->date_applied)) : 'N/A' }}"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                        </div>
                        <div class="w-full md:w-4/12 px-2 mb-4">
                            <label for="tagging_date" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                DATE TAGGED
                            </label>
                            @if($isEditing)
                                <input wire:model="tagging_date"
                                       type="date"
                                       id="tagging_date"
                                       @disabled(!$isEditing)
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @else
                                <input type="text"
                                       value="{{ $taggedAndValidatedApplicant->tagging_date ? date('F d, Y', strtotime($taggedAndValidatedApplicant->tagging_date)) : 'N/A' }}"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-2">
                        <!-- Living Situation dropdown -->
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="living_situation_id" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                LIVING SITUATION (CASE)
                            </label>
                            @if($isEditing)
                                <select wire:model="living_situation_id"
                                        x-model="livingSituation"
                                        id="living_situation_id"
                                        class="uppercase w-full p-1 border-b text-[12px] border-gray-300 bg-white rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select Living Situation</option>
                                    @foreach($livingSituations as $livingSituation)
                                        <option value="{{ $livingSituation->id }}">{{ $livingSituation->living_situation_description }}</option>
                                    @endforeach
                                </select>
                                @error('living_situation_id')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            @else
                                <textarea rows="2"
                                          disabled
                                          class="justify-items-start uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">{{ optional($taggedAndValidatedApplicant->livingSituation)->living_situation_description ?? '--' }}
                                </textarea>
                            @endif
                        </div>

                        <!-- Case Specification section -->
                        <div class="w-full md:w-4/12 px-2 mb-4">
                            <label class="block text-[12px] font-semibold text-gray-700 mb-1">
                                CASE SPECIFICATION
                            </label>
                            @if($isEditing)
                                <div x-show="living_situation_id != 8">
                                    <textarea
                                            wire:model="living_situation_case_specification"
                                            placeholder="Enter case details"
                                            class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                            required>

                                    </textarea>
                                    @error('living_situation_case_specification')
                                        <span class="error text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div x-show="living_situation_id == 8">
                                    <select
                                            wire:model="case_specification_id"
                                            class="w-full p-1 bg-white border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow uppercase"
                                            required>
                                        <option value="">Select specification</option>
                                        @foreach($caseSpecifications as $caseSpecification)
                                            <option value="{{ $caseSpecification->id }}">{{ $caseSpecification->case_specification_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('case_specification_id')
                                    <span class="error text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            @else
                                @if($taggedAndValidatedApplicant->livingSituation->living_situation_id == 8)
                                    <textarea rows="2"
                                              disabled
                                              class="justify-items-start uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">{{ optional($taggedAndValidatedApplicant->caseSpecification)->case_specification_name ?? '--' }}
                                    </textarea>
                                @else
                                    <textarea rows="2"
                                              disabled
                                              class="justify-items-start uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">{{ $taggedAndValidatedApplicant->living_situation_case_specification ?? '--' }}
                                    </textarea>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="govAssistance" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                SOCIAL WELFARE SECTOR
                            </label>
                            @if($isEditing)
                                <select wire:model="government_program_id"
                                        id="government_program_id"
                                        class="uppercase w-full p-1 border-b text-[12px] border-gray-300 bg-white rounded-md focus:outline-none focus:ring-custom-yellow">
                                    @foreach($governmentPrograms as $governmentProgram)
                                        <option value="{{ $governmentProgram->id }}">{{ $governmentProgram->program_name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text"
                                       value="{{ $taggedAndValidatedApplicant->governmentProgram->program_name }}"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                            @error('government_program_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="living_status_id" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                LIVING STATUS
                            </label>
                            @if($isEditing)
                                <select x-model="livingStatusId"
                                        wire:model="living_status_id"
                                        id="living_status_id"
                                        class="uppercase w-full p-1 border-b text-[12px] border-gray-300 bg-white rounded-md focus:outline-none focus:ring-custom-yellow">
                                    @foreach($livingStatuses as $livingStatus)
                                        <option value="{{ $livingStatus->id }}">{{ $livingStatus->living_status_name }}</option>
                                    @endforeach
                                </select>
                                @error('living_status_id')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            @else
                                <textarea rows="2"
                                          disabled
                                          class="justify-items-start uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">{{ $livingStatuses->firstWhere('id', $living_status_id)?->living_status_name ?? '--' }}
                                </textarea>
                            @endif
                        </div>
                    </div>

                    <div x-show="isRenting()" class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4 ml-[33%]">
                            <label for="rent_fee" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                MONTHLY RENT FEE <small class="text-red-500">(if rent)</small>
                            </label>
                            @if($isEditing)
                                <input type="number"
                                       wire:model="rent_fee"
                                       id="rent_fee"
                                       placeholder="Enter monthly rent"
                                       class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       x-bind:required="isRenting()">
                                @error('rent_fee')
                                <span class="error text-red-600">{{ $message }}</span>
                                @enderror
                            @else
                                <input type="text"
                                       value="{{ $rent_fee }}"
                                       disabled
                                       class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                        </div>

                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="rent_fee" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                LANDLORD NAME <small class="text-red-500">(if rent)</small>
                            </label>
                            @if($isEditing)
                                <input type="text"
                                       wire:model="landlord"
                                       id="landlord"
                                       placeholder="Enter landlord name"
                                       class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       x-bind:required="isRenting()">
                                @error('landlord')
                                <span class="error text-red-600">{{ $message }}</span>
                                @enderror
                            @else
                                <input type="text"
                                       value="{{ $landlord }}"
                                       disabled
                                       class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                        </div>
                    </div>

                    <div x-show="isLivingWithOthers()" class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4 ml-[33%]">
                            <label for="rent_fee" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                HOUSE OWNER NAME <small class="text-red-500">(if rent)</small>
                            </label>
                            @if($isEditing)
                                <input type="text"
                                       wire:model="house_owner"
                                       id="house_owner"
                                       placeholder="Enter house owner name"
                                       class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       x-bind:required="isLivingWithOthers()">
                                @error('house_owner')
                                <span class="error text-red-600">{{ $message }}</span>
                                @enderror
                            @else
                                <input type="text"
                                       value="{{ $house_owner }}"
                                       disabled
                                       class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label class="block text-[12px] font-semibold text-gray-700 mt-1 mb-1">
                                HOUSE MATERIALS
                            </label>
                            <label for="roof" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                ROOF TYPE
                            </label>
                            @if($isEditing)
                                <select wire:model="roof_type_id"
                                        id="roof_type_id"
                                        class="uppercase w-full p-1 border-b text-[12px] border-gray-300 bg-white rounded-md focus:outline-none focus:ring-custom-yellow">
                                    @foreach($roofTypes as $roofType)
                                        <option value="{{ $roofType->id }}">{{ $roofType->roof_type_name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text"
                                       value="{{ $taggedAndValidatedApplicant->roofType->roof_type_name }}"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                            @error('roof_type_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="wall" class="block text-[12px] font-semibold text-gray-700 mt-6 mb-1">
                                WALL TYPE
                            </label>
                            @if($isEditing)
                                <select wire:model="wall_type_id"
                                        id="wall_type_id"
                                        class="uppercase w-full p-1 border-b text-[12px] border-gray-300 bg-white rounded-md focus:outline-none focus:ring-custom-yellow">
                                    @foreach($wallTypes as $wallType)
                                        <option value="{{ $wallType->id }}">{{ $wallType->wall_type_name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text"
                                       value="{{ $taggedAndValidatedApplicant->wallType->wall_type_name }}"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                            @error('wall_type_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="wall" class="block text-[12px] font-semibold text-gray-700 mt-6 mb-1">
                                TRANSACTION TYPE
                            </label>
                            @if($isEditing)
                                <select wire:model="transaction_type_id"
                                        id="transaction_type_id"
                                        class="uppercase w-full p-1 border-b text-[12px] border-gray-300 bg-white rounded-md focus:outline-none focus:ring-custom-yellow">
                                    @foreach($transactionTypes as $transactionType)
                                        <option value="{{ $transactionType->id }}">{{ $transactionType->type_name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text"
                                       value="{{ $taggedAndValidatedApplicant->applicant->transactionType->type_name }}"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                            @error('transaction_type_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-full px-2 mb-4">
                            <label for="remarks"
                                   class="block text-[12px] font-semibold text-gray-700 mb-1">
                                REMARKS
                            </label>
                            <input wire:model="remarks"
                                   type="text"
                                   id="remarks"
                                   @disabled(!$isEditing)
                                   class="capitalize italic w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                   oninput="capitalizeInput(this)">
                            @error('remarks')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>

            <div class="p-3 rounded">
                <h2 class="text-[12px] ml-2 items-center font-bold text-gray-700">UPLOADED DOCUMENTS DURING TAGGING</h2>
            </div>
            <!-- Display images -->
            <div class="bg-white p-6 rounded shadow mb-6">
                <!-- Image Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
                    @forelse($images as $image)
                        <div class="relative group cursor-pointer" wire:click="viewImage({{ $image->id }})">
                            <img
                                    src="{{ asset('storage/' . $image->image_path) }}"
                                    alt="{{ $image->display_name }}"
                                    class="w-full h-48 object-cover rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300"
                            >
                            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-2 text-sm rounded-b-lg">
                                {{ $image->display_name }}
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-4 text-gray-500">
                            No images available
                        </div>
                    @endforelse
                </div>

                <!-- Modal -->
                @if($selectedImage)
                    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg p-4 max-w-4xl max-h-[90vh] overflow-auto">
                            <div class="flex justify-end mb-2">
                                <button wire:click="closeImage" class="text-gray-500 hover:text-gray-700">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <img src="{{ asset('storage/' . $selectedImage->image_path) }}"
                                 alt="{{ $selectedImage->display_name }}"
                                 class="max-w-full h-auto">
                            <div class="mt-2 text-center text-gray-700">
                                {{ $selectedImage->display_name }}
                            </div>
                        </div>
                    </div>
                @endif

                @if($showDeleteConfirmationModal)
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
                        <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
                            <h3 class="text-lg font-semibold mb-4">Confirm Removing of Dependent</h3>

                            <p class="mb-4 text-gray-600">Please enter your password to confirm deletion of this dependent.</p>

                            <div class="mb-4">
                                <input type="password"
                                       wire:model.defer="confirmationPassword"
                                       class="w-full border-gray-300 rounded-md shadow-sm"
                                       placeholder="Enter your password"
                                       autocomplete="off">

                                @if($deleteError)
                                    <p class="mt-1 text-red-500 text-sm">{{ $deleteError }}</p>
                                @endif
                            </div>

                            <div class="flex justify-end space-x-3">
                                <button
                                        wire:click="cancelDelete()"
                                        class="px-4 py-2 text-gray-600 hover:text-gray-800">
                                    Cancel
                                </button>
                                <div class="z-[1000]">
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
                                    <button wire:click="removeDependent()"
                                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                        Confirm Delete
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
                    </div>
                @endif
            </div>
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

