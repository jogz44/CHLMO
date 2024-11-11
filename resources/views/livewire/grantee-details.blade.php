<div class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <div x-data="{ isEditable: false }" class="flex-1 p-6 overflow-auto">
            <div class="bg-white rounded shadow mb-4 flex items-center justify-between p-3 fixed top-[80px] left-[20%] right-[3%] z-5">
                <div class="flex items-center">
                    <a href="{{ route('shelter-grantees') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5 text-custom-yellow mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h2 class="text-[13px] ml-2 items-center text-gray-700">Shelter Assistance Grantee's Details</h2>
                </div>
                <img src="{{ asset('storage/images/design.png') }}" alt="Design"
                    class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                <div x-data="{ saved: false }" class="flex space-x-2 z-0">
                    <button
                        :disabled="!isEditable || saved"
                        class="bg-gradient-to-r from-custom-yellow to-iroad-orange hover:bg-gradient-to-r hover:from-custom-yellow hover:to-custom-yellow text-white text-xs font-medium px-6 py-2 rounded"
                        @click="saved = true; message = 'Data has been saved successfully!'; isEditable = false">
                        SAVE
                    </button>
                    <button
                        @click="isEditable = !isEditable"
                        type="button"
                        class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white text-xs font-medium px-6 py-2 rounded">
                        EDIT
                    </button>
                </div>
            </div>


            <div class="flex flex-col p-3 rounded mt-5">
                @if($shelterApplicant)
                <h2 class="text-[30px] items-center font-bold text-gray-700 underline">{{ $shelterApplicant->profile_no }}</h2>
                <h1 class="text-[25px] items-center font-bold text-gray-700">
                    {{ $shelterApplicant->last_name }}, {{ $shelterApplicant->first_name }}
                    @if($shelterApplicant->middle_name) {{ $shelterApplicant->middle_name }} @endif
                </h1>
                @else
                <p class="text-red-500">Shelter applicant not found.</p>
                @endif
            </div>


            <form wire:submit.prevent="saveChanges">
                <div class="bg-white p-6 rounded shadow mb-6">
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="first-name" class="block text-[12px] font-semibold text-gray-700 mb-1">FIRST
                                NAME</label>
                            <input type="text" id="first-name" name="first-name"
                                :disabled="!isEditable" wire:model="first_name"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @error('first_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="middle-name" class="block text-[12px] font-medium text-gray-700 mb-1">MIDDLE
                                NAME</label>
                            <input type="text" id="middle-name" name="middle-name"
                                :disabled="!isEditable" wire:model="middle_name"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="last-name" class="block text-[12px] font-medium text-gray-700 mb-1">LAST
                                NAME</label>
                            <input type="text" id="last-name" name="last-name"
                                :disabled="!isEditable" wire:model="last_name"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="name-suffix" class="block text-[12px] font-medium text-gray-700 mb-1">NAME
                                SUFFIX</label>
                            <input type="text" id="name-suffix" name="name-suffix"
                                :disabled="!isEditable"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="origin-request"
                                class="block text-[12px] font-medium text-gray-700 mb-1">ORIGIN OF REQUEST</label>
                            @if($isEditing)
                            <select wire:model="request_origin_id"
                                id="request_origin_id"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 bg-white rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select Origin of Request</option>
                                @foreach($originOfRequests as $originOfRequest)
                                <option value="{{ $originOfRequest->id }}">{{ $originOfRequest->name }}</option>
                                @endforeach
                            </select>
                            @error('request_origin_id') <span class="text-danger">{{ $message }}</span> @enderror
                            @else
                            <input type="text"
                                wire:model="request_origin_id"
                                disabled
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="requestDate" class="block text-[12px] font-medium text-gray-700 mb-1">REQUEST DATE</label>
                            <input type="date" id="requestDate" name="requestDate" :disabled="!isEditable" wire:model="date_request"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="date_tagged" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                DATE PROFILED/TAGGED
                            </label>
                            @if($isEditing)
                            <input wire:model="date_tagged"
                                type="date"
                                id="date_tagged"
                                @disabled(!$isEditing)
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @else
                            <input type="text"
                                value="{{ $profiledTagged->date_tagged ? date('F d, Y', strtotime($profiledTagged->date_tagged)) : 'N/A' }}"
                                disabled
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                        </div>
                    </div>
                </div>

                <div x-data="{ civilStatus: '' }" class="bg-white p-6 rounded shadow mb-6">
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/2 px-2 mb-4">
                            <label for="age" class="block text-[12px] font-medium text-gray-700 mb-1">AGE</label>
                            <input type="number" id="age" name="age" :disabled="!isEditable" wire:model="age"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/2 px-2 mb-4">
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
                                    value="{{ $profiledTagged->sex }}"
                                    disabled
                                    class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                @endif
                                @error('sex')
                                <span class="text-red-600 error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
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
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="year_of_residency" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                YEARS OF RESIDENCY
                            </label>
                            <input wire:model="year_of_residency"
                                type="number"
                                id="year_of_residency"
                                @disabled(!$isEditing)
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                oninput="capitalizeInput(this)">
                            @error('year_of_residency')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="civil_status_id" class="block text-[12px] font-semibold text-gray-700 mb-1">CIVIL STATUS</label>
                            @if($isEditing)
                            <select wire:model="civil_status_id"
                                id="civil_status_id"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 bg-white rounded-md focus:outline-none focus:ring-custom-yellow">
                                @foreach($civilStatuses as $status)
                                <option value="{{ $status->id }}">{{ $status->civil_status }}</option>
                                @endforeach
                            </select>
                            @else
                            <input type="text"
                                value="{{ $profiledTagged->civilStatus->civil_status }}"
                                disabled
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                            @error('civil_status_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @if ($civil_status_id == $liveInPartnerStatusId)
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
                                    @disabled(!$isEditing)
                                    oninput="capitalizeInput(this)"
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

                        @endif

                        @if ($civil_status_id == $marriedStatusId)

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
                    @endif

                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
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
                                value="{{ $profiledTagged->religion->religion_name }}"
                                disabled
                                class="uppercase w-full p-1 border-b text-[12px] bg-white border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                            @error('religion_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
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
                                value="{{ $profiledTagged->tribe->tribe_name }}"
                                disabled
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                            @error('tribe_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
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


                    </div>

                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
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
                                value="{{  $profiledTagged->address?->barangay?->name ?? '--' }}"
                                disabled
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
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
                                value="{{  $profiledTagged->address?->purok?->name ?? '--' }}"
                                disabled
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="full-address" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                FULL ADDRESS
                            </label>
                            <input wire:model="full_address"
                                type="text"
                                id="full-address"
                                @disabled(!$isEditing)
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                oninput="capitalizeInput(this)">
                            @error('full-address')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
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
                                value="{{ $profiledTagged->governmentProgram->program_name }}"
                                disabled
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                            @error('government_program_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
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
                                class="justify-items-start uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">{{ optional($profiledTagged->livingSituation)->living_situation_description ?? '--' }}
                            </textarea>
                            @endif
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
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
                            @if($profiledTagged->living_situation_id == 8)
                            <textarea rows="2"
                                disabled
                                class="justify-items-start uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">{{ optional($profiledTagged->caseSpecification)->case_specification_name ?? '--' }}
                            </textarea>
                            @else
                            <textarea rows="2"
                                disabled
                                class="justify-items-start uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">{{ $profiledTagged->living_situation_case_specification ?? '--' }}
                            </textarea>
                            @endif
                            @endif
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
                </div>


                <div class="flex flex-col p-3 rounded mt-5 mb-1">
                    <h2 class="text-[12px] ml-2 items-center font-bold text-gray-700">DELIVERY DETAILS</h2>
                </div>

                <div class="bg-white p-6 rounded shadow mb-6">
                    <div class="flex flex-wrap ">
                        <div class="w-full lg:w-1/2 pr-4">
                            <div class="flex flex-wrap -mx-2 mb-1">
                                <div class="w-full md:w-1/2 px-2 mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black"
                                        for="delivery-date">DATE OF DELIVERY</label>
                                    <input type="date" id="delivery-date" :disabled="!isEditable"
                                        class="w-full px-3 py-1 bg-white-700 border border-gray-300 rounded-md placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]">
                                </div>
                                <div class="w-full md:w-1/2 px-2 mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black"
                                        for="irs-date">DATE OF IRS</label>
                                    <input type="date" id="irs-date" :disabled="!isEditable"
                                        class="w-full px-3 py-1 bg-white-700 border border-gray-300 rounded-md placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]">
                                </div>
                            </div>

                            <label class="block text-[12px] font-medium text-gray-700 mb-4">MATERIALS DELIVERED</label>

                            <div class="flex flex-wrap -mx-2 mb-1">
                                <!-- Material Select -->
                                <div class="w-full md:w-2/4 px-2 mb-2">
                                    <label for="material"
                                        class="block text-[12px] font-medium text-gray-700 mb-1">MATERIAL</label>
                                    <select x-model="material.material" :disabled="!isEditable"
                                        class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                        <option value="">Select Material</option>
                                        <option value="barangay1">Barangay 1</option>
                                    </select>
                                </div>

                                <!-- Quantity Input -->
                                <div class="w-full md:w-1/4 px-2 mb-2">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="qty">QUANTITY</label>
                                    <input type="number" x-model="material.qty" :disabled="!isEditable"
                                        class="uppercase w-full px-3 py-1 bg-white-700 border border-gray-300 rounded-md placeholder-gray-400 text-gray-800 focus:outline-none text-[12px]"
                                        placeholder="Quantity">
                                </div>

                                <!-- PO Number Select -->
                                <div class="w-full md:w-1/4 px-2 mb-2">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="PoNum">PO NUMBER</label>
                                    <select x-model="material.poNum" :disabled="!isEditable"
                                        class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                        <option value="">Select</option>
                                        <option value="barangay1">Barangay 1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-2 mb-1">
                                <!-- Material Select -->
                                <div class="w-full md:w-2/4 px-2 mb-2">
                                    <select x-model="material.material" :disabled="!isEditable"
                                        class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                        <option value="">Select Material</option>
                                        <option value="barangay1">Barangay 1</option>
                                    </select>
                                </div>

                                <!-- Quantity Input -->
                                <div class="w-full md:w-1/4 px-2 mb-2">
                                    <input type="number" x-model="material.qty" :disabled="!isEditable"
                                        class="uppercase w-full px-3 py-1 bg-white-700 border border-gray-300 rounded-md placeholder-gray-400 text-gray-800 focus:outline-none text-[12px]"
                                        placeholder="Quantity">
                                </div>

                                <!-- PO Number Select -->
                                <div class="w-full md:w-1/4 px-2 mb-2">
                                    <select x-model="material.poNum" :disabled="!isEditable"
                                        class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                        <option value="">Select</option>
                                        <option value="barangay1">Barangay 1</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div x-data="{ open: false, imgSrc: '' }" class="w-full lg:w-1/2 pl-4 mt-[10%]">
                            <label class="block text-[12px] font-medium text-gray-700 mb-2">UPLOADED PHOTOS</label>
                            <div class="flex space-x-4">
                                <!-- Image 1 -->
                                <div @click="open = true; imgSrc = '{{ asset('storage/images/designDasboard.png') }}';" class="relative w-1/2 border border-bg-gray-700">
                                    <img src="{{ asset('storage/images/designDasboard.png') }}" alt="House Situation" class="w-full h-auto rounded-md cursor-pointer">
                                    <span class="absolute bottom-0 left-0 bg-black bg-opacity-50 text-white text-[12px] px-2 py-1 rounded-br-md">House Situation.jpeg</span>
                                </div>

                                <!-- Image 2 -->
                                <div @click="open = true; imgSrc = '{{ asset('storage/images/designDasboard.png') }}';" class="relative w-1/2 border border-bg-gray-700">
                                    <img src="{{ asset('storage/images/designDasboard.png') }}" alt="House Situation 2" class="w-full h-auto rounded-md cursor-pointer">
                                    <span class="absolute bottom-0 left-0 bg-black bg-opacity-50 text-white text-[12px] px-2 py-1 rounded-br-md">House Situation2.jpeg</span>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 z-50">
                                <div @click.away="open = false" class="relative w-auto h-auto max-w-[90%] max-h-[90%] p-2 rounded-md">
                                    <img :src="imgSrc" alt="Preview" class="w-auto h-auto max-w-full max-h-[80vh] object-cover rounded-md">

                                </div>
                            </div>
                        </div>



                    </div>
                </div>
        </div>


        </form>
    </div>

</div>
</div>