<div class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <div x-data="{ isEditable: false }" class="flex-1 p-6 overflow-auto">
            <form wire:submit.prevent="store">
                <div class="bg-white rounded shadow mb-4 flex items-center justify-between p-3 fixed top-[80px] left-[20%] right-[3%] z-5">
                    <div class="flex items-center">
                        <a href="{{ route('shelter-transaction-applicants') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-custom-yellow mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <h2 class="text-[13px] ml-2 items-center text-gray-700">Tag Applicant</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design"
                        class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                        <div class="flex space-x-2 z-[1000]">
                        <div class="z-50">
                            <div class="alert mt-14"
                                 :class="{primary:'alter-primary', success:'alert-success', danger:'alert-danger', warning:'alter-warning'}[(alert.type ?? 'primary')]"
                                 x-data="{ open:false, alert:{} }"
                                 x-show="open" x-cloak
                                 x-transition:enter="animate-alert-show"
                                 x-transition:leave="animate-alert-hide"
                                 @alert.window="open = true; setTimeout( () => open=false, 3000 ); alert=$event.detail[0]"
                            >
                                <div class="alert-wrapper">
                                    <strong x-html="alert.title">Title</strong>
                                    <p x-html="alert.message">Description</p>
                                </div>
                                <i class="alert-close fa-solid fa-xmark" @click="open=false"></i>
                            </div>
                            <!-- SUBMIT Button -->
                            <button type="submit"
                                    class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white text-xs font-medium px-6 py-2 rounded">
                                SUBMIT
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


                <div class="flex flex-col p-3 rounded mt-5">
                    <h2 class="text-[30px] ml-2 items-center font-bold text-gray-700 underline">{{ $applicant->profile_no }}</h2>
                    <h1 class="text-[25px] ml-2 items-center font-bold text-gray-700 mb-3">
                        {{ $applicant->last_name }}, {{ $applicant->first_name }}
                        @if($applicant->middle_name) {{ $applicant->middle_name }} @endif
                    </h1>
                    <h2 class="text-[13px] ml-2 items-center font-bold text-gray-700">PERSONAL INFORMATION</h2>
                    <p class="text-[12px] ml-2 items-center text-gray-700">Encode here the personal information of the
                        Applicant from the form.</p>
                </div>



                <div class="bg-white p-6 rounded shadow mb-6">
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="first-name" class="block text-[13px] font-medium text-gray-700 mb-1">FIRST
                                NAME</label>
                            <input type="text" id="first-name" name="first-name"
                                :disabled="!isEditable" wire:model="first_name"
                                class="capitalize w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @error('first_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="middle-name" class="block text-[13px] font-medium text-gray-700 mb-1">MIDDLE
                                NAME</label>
                            <input type="text" id="middle-name" name="middle-name"
                                :disabled="!isEditable" wire:model="middle_name"
                                class="capitalize w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="last-name" class="block text-[13px] font-medium text-gray-700 mb-1">LAST
                                NAME</label>
                            <input type="text" id="last-name" name="last-name"
                                :disabled="!isEditable" wire:model="last_name"
                                class="capitalize w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="name-suffix" class="block text-[13px] font-medium text-gray-700 mb-1">NAME
                                SUFFIX</label>
                            <input type="text" id="name-suffix" name="name-suffix"
                                :disabled="!isEditable"
                                class="capitalize w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="origin-request"
                                class="block text-[13px] font-medium text-gray-700 mb-1">ORIGIN OF REQUEST</label>
                            <input wire:model="origin_name" id="origin-request" name="origin-request"
                                class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow capitalize cursor-default" readonly>
                            @error('origin-request') <span class="text-red-600 error">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="requestDate" class="block text-[13px] font-medium text-gray-700 mb-1">REQUEST DATE</label>
                            <input type="date" wire:model="request_date" id="requestDate" name="requestDate"
                                class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" readonly>
                        </div>
                    </div>
                </div>


                <div x-data="{ civilStatus: '' }" class="bg-white p-6 rounded shadow mb-6">
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="age" class="block text-[13px] font-medium text-gray-700 mb-1">AGE</label>
                            <input type="number" id="age" name="age" wire:model="age"
                                class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="sex" class="block text-[12px] font-medium text-gray-700 mb-1">SEX <span class="text-red-500">*</span></label>
                                <div class="flex items-center">
                                    <div class="mr-6">
                                        <input type="radio" wire:model="sex" value="Male" id="male" class="mr-2" required>
                                        <label for="male" class="cursor-pointer">Male</label>
                                    </div>
                                    <div>
                                        <input type="radio" wire:model="sex" value="Female" id="female" class="mr-2" required>
                                        <label for="female" class="cursor-pointer">Female</label>
                                    </div>
                                </div>
                                @error('sex') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="occupation"
                                class="block text-[13px] font-medium text-gray-700 mb-1">OCCUPATION</label>
                            <input type="text" id="occupation" name="occupation" wire:model="occupation"
                                class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="years-residency"
                                class="block text-[13px] font-medium text-gray-700 mb-1">YEARS OF RESIDENCY</label>
                            <input type="number" id="years-residency" name="years-residency" wire:model="year_of_residency"
                                class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="civil_status" class="block text-[13px] font-medium text-gray-700 mb-1">CIVIL STATUS</label>
                            <select id="civil_status" name="civil_status" wire:model="civil_status_id" x-model="civilStatus"
                                class="w-full p-1.5 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select Status</option>
                                @foreach($civil_statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->civil_status }}</option>
                                @endforeach
                            </select>
                            @error('civil_status') <span class="text-red-600 error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    
                    <template x-if="civilStatus === '2'">
                            <div class="bg-gray-100 p-2 mb-4">
                                <h2 class="block text-[12px] font-medium text-gray-700 mb-2">PARTNER DETAILS</h2>
                                <div class="flex flex-wrap -mx-2">
                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="partner_first_name" class="block text-[12px] font-medium text-gray-700 mb-1">
                                            FIRST NAME <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               id="partner_first_name"
                                               wire:model="partner_first_name"
                                               class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">
                                        @error('partner_first_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="partner_middle_name" class="block text-[12px] font-medium text-gray-700 mb-1">
                                            MIDDLE NAME <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               id="partner_middle_name"
                                               wire:model="partner_middle_name"
                                               class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">
                                        @error('partner_middle_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="partner_last_name" class="block text-[12px] font-medium text-gray-700 mb-1">
                                            LAST NAME <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               id="partner_last_name"
                                               wire:model="partner_last_name"
                                               class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">
                                        @error('partner_last_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </template>

                        <template x-if="civilStatus === '3'">
                            <div>
                                <hr class="mt-2 mb-2 ">
                                <h2 class="block text-[12px] font-medium text-gray-700 mb-2">SPOUSE DETAILS</h2>
                                <div class="flex flex-wrap -mx-2">
                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="spouse_first_name" class="block text-[12px] font-medium text-gray-700 mb-1">
                                            FIRST NAME <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="spouse_first_name" wire:model="spouse_first_name" class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">
                                        @error('spouse_first_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="spouse_middle_name" class="block text-[12px] font-medium text-gray-700 mb-1">
                                            MIDDLE NAME <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="spouse_middle_name" wire:model="spouse_middle_name" class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">
                                        @error('spouse_middle_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="w-full md:w-1/3 px-2 mb-4">
                                        <label for="spouse_last_name" class="block text-[12px] font-medium text-gray-700 mb-1">
                                            LAST NAME <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="spouse_last_name" wire:model="spouse_last_name" class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">
                                        @error('spouse_last_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </template>


                    <div class="flex flex-wrap -mx-2">

                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="religion" class="block text-[13px] font-medium text-gray-700 mb-1">RELIGION</label>
                            <select wire:model="religion_id" id="religion" name="religion" class="w-full p-1.5 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select Religion</option>
                                @foreach($religions as $religion)
                                <option value="{{ $religion->id }}">{{ $religion->religion_name }}</option>
                                @endforeach
                            </select>
                            @error('religion') <span class="text-red-600 error">{{ $message }}</span> @enderror
                        </div>

                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="tribe" class="block text-[13px] font-medium text-gray-700 mb-1">TRIBE/ETHNICITY <span class="text-red-500">*</span></label>
                            <select wire:model="tribe_id" id="tribe" name="tribe" required class="w-full p-1.5 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow capitalize">
                                <option value="">Select Tribe/Ethnicity</option>
                                @foreach($tribes as $tribe)
                                <option value="{{ $tribe->id }}">{{ $tribe->tribe_name }}</option>
                                @endforeach
                            </select>
                            @error('tribe') <span class="text-red-600 error">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="contactNo" class="block text-[13px] font-medium text-gray-700 mb-1">CONTACT
                                NUMBER</label>
                            <input type="number" id="contactNo" name="contactNo" wire:model="contact_number"

                                class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>


                    </div>

                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="barangay" class="block text-[13px] font-medium text-gray-700 mb-1">
                                BARANGAY
                            </label>
                            <select id="barangay" name="barangay" wire:model.live="barangay_id"
                                class="w-full p-1.5 border text-gray-800 text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select Barangay</option>
                                @foreach($barangays as $barangay)
                                <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                @endforeach
                            </select>
                            @error('barangay_id') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="purok" class="block text-[13px] font-medium text-gray-700 mb-1">
                                PUROK
                            </label>
                            <select id="purok" name="purok" wire:model.live="purok_id"
                                class="w-full p-1.5 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select Purok</option>
                                @foreach($puroks as $purok)
                                <option value="{{ $purok->id }}">{{ $purok->name }}</option>
                                @endforeach
                            </select>
                            @error('purok_id') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="houseNo"
                                class="block text-[13px] font-medium text-gray-700 mb-1">FULL ADDRESS</label>
                            <input type="text" id="houseNo" name="houseNo" wire:model="full_address"
                                class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="govAssistance" class="block text-[13px] font-medium text-gray-700 mb-1">SOCIAL WELFARE SECTOR</label>
                            <select id="govAssistance" name="govAssistance" wire:model="government_program_id"
                                class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select type of assistance</option>
                                @foreach($governmentPrograms as $governmentProgram)
                                <option value="{{ $governmentProgram->id }}">{{ $governmentProgram->program_name }}</option>
                                @endforeach
                            </select>
                            @error('government_program') <span class="error text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="livingStatus" class="block text-[13px] font-medium text-gray-700 mb-1">LIVING
                                STATUS</label>
                            <select id="livingStatus" name="livingStatus" wire:model="shelter_living_status_id"
                                class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select status</option>
                                @foreach($shelterLivingStatuses as $shelterLivingStatus)
                                <option value="{{ $shelterLivingStatus->id }}">{{ $shelterLivingStatus->shelter_living_status_name }}</option>
                                @endforeach
                            </select>
                            @error('government_program') <span class="error text-red-600">{{ $message }}</span> @enderror
                            </select>
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="taggedDate" class="block text-[13px] font-medium text-gray-700 mb-1">DATE PROFILED/TAGGED</label>
                            <input type="date" id="taggedDate" name="taggedDate" wire:model="date_tagged" max="{{ date('Y-m-d') }}"
                                class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @error('date_tagged') <span class="text-red-600 error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-full px-2 mb-4">
                            <label for="remarks"
                                class="block text-[13px] font-medium text-gray-700 mb-1">REMARKS</label>
                            <input type="text" id="remarks" name="remarks" whire:model="remarks"
                                class="capitalize w-full p-3 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">
                        </div>

                    </div>

                </div>
            </form>
        </div>
        <script>
            function capitalizeInput(input) {
                input.value = input.value.toLowerCase().replace(/\b\w/g, function(char) {
                    return char.toUpperCase();
                });
            }
        </script>
    </div>
</div>