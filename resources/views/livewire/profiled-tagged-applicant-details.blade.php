<div class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <div x-data="{ isEditable: false }" class="flex-1 p-6 overflow-auto">
            <div class="bg-white rounded shadow mb-4 flex items-center justify-between p-3 fixed top-[80px] left-[20%] right-[3%] z-5">
                <div class="flex items-center">
                    <a href="{{ route('shelter-profiled-tagged-applicants') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5 text-custom-yellow mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h2 class="text-[13px] ml-2 items-center text-gray-700">Profiled/Tagged Applicant Details</h2>
                </div>
                <img src="{{ asset('storage/images/design.png') }}" alt="Design"
                    class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                <!-- <div x-data="{ saved: false }" class="flex space-x-2 z-0"> -->
                <!-- <button
                        :disabled="!isEditable || saved"
                        class="bg-gradient-to-r from-custom-yellow to-iroad-orange hover:bg-gradient-to-r hover:from-custom-yellow hover:to-custom-yellow text-white text-xs font-medium px-6 py-2 rounded"
                        @click="saved = true; message = 'Data has been saved successfully!'; isEditable = false">
                        SAVE
                    </button> -->
                <!-- <button
                        @click="isEditable = !isEditable"
                        type="button"
                        class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white text-xs font-medium px-6 py-2 rounded">
                        EDIT
                    </button> -->
                <!-- </div> -->
            </div>


            <div class="flex flex-col p-3 rounded mt-11">
                <h2 class="text-[30px] items-center font-bold text-gray-700 underline">{{ $profiledTaggedApplicant->shelterApplicant->profile_no }}</h2>
                <h1 class="text-[25px] items-center font-bold text-gray-700">
                    {{ $profiledTaggedApplicant->shelterApplicant->person->first_name }}
                    @if($profiledTaggedApplicant->shelterApplicant->person->middle_name) {{ substr($profiledTaggedApplicant->shelterApplicant->person->middle_name, 0, 1) }}. @endif
                    {{ $profiledTaggedApplicant->shelterApplicant->person->last_name }}
                </h1>
            </div>

            <form wire:submit.prevent="update">
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
                                value="{{ $profiledTaggedApplicant->shelterApplicant->originOfRequest->name }}"
                                disabled
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="requestDate" class="block text-[12px] font-medium text-gray-700 mb-1">REQUEST DATE</label>
                            @if($isEditing)
                            <input wire:model="date_request"
                                type="date"
                                id="date_request"
                                @disabled(!$isEditing)
                                class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @else
                            <input type="text"
                                value="{{ $profiledTaggedApplicant->shelterApplicant->date_request ? date('F d, Y', strtotime($profiledTaggedApplicant->shelterApplicant->date_request)) : 'N/A' }}"
                                disabled
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="date_tagged" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                DATE PROFILED/TAGGED
                            </label>

                            <input type="text"
                                value="{{ $profiledTaggedApplicant->date_tagged ? date('F d, Y', strtotime($profiledTaggedApplicant->date_tagged)) : 'N/A' }}"
                                disabled
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>
                </div>

                <div x-data="{ civilStatus: '' }" class="bg-white p-6 rounded shadow mb-6">
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="age" class="block text-[12px] font-medium text-gray-700 mb-1">AGE</label>
                            <input type="number" id="age" name="age" :disabled="!isEditable" wire:model="age"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
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
                                value="{{ $profiledTaggedApplicant->civilStatus->civil_status }}"
                                disabled
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                            @error('civil_status_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
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
                                    value="{{ $profiledTaggedApplicant->sex }}"
                                    disabled
                                    class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                @endif
                                @error('sex')
                                <span class="text-red-600 error">{{ $message }}</span>
                                @enderror
                            </div>
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
                                value="{{ $profiledTaggedApplicant->governmentProgram->program_name }}"
                                disabled
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                            @error('government_program_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="religion"
                                class="block text-[12px] font-semibold text-gray-700 mb-1">
                                RELIGION
                            </label>
                            <input wire:model="religion"
                                type="text"
                                id="religion"
                                @disabled(!$isEditing)
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                oninput="capitalizeInput(this)">
                            @error('religion')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="tribe" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                TRIBE/ETHNICITY
                            </label>
                            <input wire:model="tribe"
                                type="text"
                                id="tribe"
                                @disabled(!$isEditing)
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                oninput="capitalizeInput(this)">
                            @error('tribe')
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
                                value="{{  $profiledTaggedApplicant->shelterApplicant->address->barangay->name  ?? '--' }}"
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
                                value="{{  $profiledTaggedApplicant->shelterApplicant->address->purok->name  ?? '--' }}"
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
                            @error('full_address')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="structure_status_id"
                                class="block text-[13px] font-semibold text-gray-700 mb-1">
                                STRUCTURE TYPE STATUS <span class="text-red-500">*</span>
                            </label>
                            @if($isEditing)
                            <select wire:model="structure_status_id"
                                id="structure_status_id"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 bg-white rounded-md focus:outline-none focus:ring-custom-yellow">
                                @foreach($structureStatuses as $structureStatus)
                                <option value="{{ $structureStatus->id }}">{{ $structureStatus->structure_status }}</option>
                                @endforeach
                            </select>
                            @else
                            <input type="text"
                                value="{{ $profiledTaggedApplicant->structureStatus->structure_status }}"
                                disabled
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @endif
                            @error('structure_status_id')
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
                                class="justify-items-start uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">{{ optional($profiledTaggedApplicant->livingSituation)->living_situation_description ?? '--' }}
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
                            @if($profiledTaggedApplicant->living_situation_id == 8)
                            <textarea rows="2"
                                disabled
                                class="justify-items-start uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">{{ optional($profiledTaggedApplicant->caseSpecification)->case_specification_name ?? '--' }}
                            </textarea>
                            @else
                            <textarea rows="2"
                                disabled
                                class="justify-items-start uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">{{ $profiledTaggedApplicant->living_situation_case_specification ?? '--' }}
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


                <div class="p-3 rounded">
                    <h2 class="text-[12px] ml-2 items-center font-bold text-gray-700">UPLOADED DOCUMENTS DURING TAGGING</h2>
                </div>
                
                <!-- Display images -->
                <div class="bg-white p-6 rounded shadow mb-6">
                    <!-- Document Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
                        @forelse($taggedDocuments as $document)
                        <div class="relative group cursor-pointer" wire:click="viewDocument({{ $document->id }})">
                            <img
                                src="{{ asset('tagging-house-structure-images/' . $document->file_path) }}"
                                alt="{{ $document->file_name }}"
                                class="w-full h-48 object-cover rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-2 text-sm rounded-b-lg">
                                {{ $document->file_name }}
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-4 text-gray-500">
                            No documents available
                        </div>
                        @endforelse
                    </div>

                    <!-- Document Viewer Modal -->
                    @if($selectedDocument)
                    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg p-4 max-w-4xl max-h-[90vh] overflow-auto">
                            <div class="flex justify-end mb-2">
                                <button wire:click="closeDocument" class="text-gray-500 hover:text-gray-700">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <img
                                src="{{ asset('tagging-house-structure-images/' . $selectedDocument->file_path) }}"
                                alt="{{ $selectedDocument->file_name }}"
                                class="max-w-full h-auto">
                            <div class="mt-2 text-center text-gray-700">
                                {{ $selectedDocument->file_name }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </form>
        </div>

    </div>

</div>