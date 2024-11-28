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
            </div>

            <div class="flex flex-col p-3 rounded mt-11">
                <h2 class="text-[30px] items-center font-bold text-gray-700 underline">{{ $taggedAndValidatedApplicant->applicant->applicant_id }}</h2>
                <h1 class="text-[25px] items-center font-bold text-gray-700">
                    {{ $taggedAndValidatedApplicant->applicant->person->first_name }}
                    @if($taggedAndValidatedApplicant->applicant->person->middle_name) {{ substr($taggedAndValidatedApplicant->applicant->person->middle_name, 0, 1) }}. @endif
                    {{ $taggedAndValidatedApplicant->applicant->person->last_name }}
                    {{ $taggedAndValidatedApplicant->applicant->person->suffix_name }}
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
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="middle-name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                MIDDLE NAME
                            </label>
                            <input wire:model="middle_name"
                                   type="text"
                                   id="middle-name"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="last-name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                LAST NAME
                            </label>
                            <input wire:model="last_name"
                                   type="text"
                                   id="last-name"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="suffix_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                SUFFIX NAME
                            </label>
                            <input wire:model="suffix_name"
                                   type="text"
                                   id="suffix_name"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>

                    <div x-data="{ civilStatus: '' }">
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="barangay_id"
                                       class="block text-[12px] font-semibold text-gray-700 mb-1">BARANGAY</label>
                                <input type="text"
                                       value="{{ $taggedAndValidatedApplicant->applicant?->address?->barangay?->name ?? '--' }}"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">

                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="purok_id" class="block text-[12px] font-semibold text-gray-700 mb-1">PUROK</label>
                                <input type="text"
                                       value="{{ $taggedAndValidatedApplicant->applicant?->address?->purok?->name ?? '--' }}"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="full-address" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    FULL ADDRESS
                                </label>
                                <input wire:model="full_address"
                                       type="text"
                                       id="full_address"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="civil_status_id"
                                       class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    CIVIL STATUS
                                </label>
                                <input type="text"
                                       value="{{ $taggedAndValidatedApplicant->civilStatus->civil_status }}"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
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
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="tribe" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    TRIBE/ETHNICITY
                                </label>
                                <input wire:model="tribe"
                                        type="text"
                                       value="{{ $taggedAndValidatedApplicant->tribe }}"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="sex" class="block text-[12px] font-semibold text-gray-700 mb-1">SEX</label>
                                <div class="flex items-center">
                                    <input type="text"
                                           value="{{ $taggedAndValidatedApplicant->sex }}"
                                           disabled
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="age" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    DATE OF BIRTH
                                </label>
                                <input type="text"
                                       value="{{ $taggedAndValidatedApplicant->date_of_birth ? date('F d, Y', strtotime($taggedAndValidatedApplicant->date_of_birth)) : 'N/A' }}"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="religion"
                                       class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    RELIGION
                                </label>
                                <input wire:model="religion"
                                       type="text"
                                       value="{{ $taggedAndValidatedApplicant->religion }}"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] bg-white border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="occupation" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    OCCUPATION
                                </label>
                                <input wire:model="occupation"
                                       type="text"
                                       id="occupation"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="monthly_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    MONTHLY INCOME
                                </label>
                                <input wire:model="monthly_income"
                                       value="{{ $taggedAndValidatedApplicant->monthly_income }}"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="years_of_residency" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    LENGTH OF RESIDENCY
                                </label>
                                <input wire:model="years_of_residency"
                                       value="{{ $taggedAndValidatedApplicant->years_of_residency }}"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="voters_id_number" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    VOTER'S ID NUMBER
                                </label>
                                <input wire:model="voters_id_number"
                                       value="{{ $taggedAndValidatedApplicant->voters_id_number }}"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
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
                                                   disabled
                                                   class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                        </div>
                                        <div class="w-full md:w-1/3 px-2 mb-4">
                                            <label for="partner_middle_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                                MIDDLE NAME <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text"
                                                   id="partner_middle_name"
                                                   wire:model="partner_middle_name"
                                                   disabled
                                                   class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                        </div>
                                        <div class="w-full md:w-1/3 px-2 mb-4">
                                            <label for="partner_last_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                                LAST NAME <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text"
                                                   id="partner_last_name"
                                                   wire:model="partner_last_name"
                                                   disabled
                                                   class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                        </div>

                                        <div class="w-full md:w-1/3 px-2 mb-4">
                                            <label for="partner_occupation" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                                OCCUPATION <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text"
                                                   id="partner_occupation"
                                                   wire:model="partner_occupation"
                                                   disabled
                                                   class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                        </div>
                                        <div class="w-full md:w-1/3 px-2 mb-4">
                                            <label for="partner_monthly_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                                MONTHLY INCOME <span class="text-red-500">*</span>
                                            </label>
                                            <input type="number"
                                                   id="partner_monthly_income"
                                                   wire:model="partner_monthly_income"
                                                   disabled
                                                   class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
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
                                            <input type="text"
                                                   id="spouse_first_name"
                                                   wire:model="spouse_first_name"
                                                   disabled
                                                   class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                        </div>
                                        <div class="w-full md:w-1/3 px-2 mb-4">
                                            <label for="spouse_middle_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                                MIDDLE NAME <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text"
                                                   id="spouse_middle_name"
                                                   wire:model="spouse_middle_name"
                                                   disabled
                                                   class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                        </div>
                                        <div class="w-full md:w-1/3 px-2 mb-4">
                                            <label for="spouse_last_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                                LAST NAME <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text"
                                                   id="spouse_last_name"
                                                   wire:model="spouse_last_name"
                                                   disabled
                                                   class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                        </div>

                                        <div class="w-full md:w-1/3 px-2 mb-4">
                                            <label for="spouse_occupation" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                                OCCUPATION <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" id="spouse_occupation"
                                                   wire:model="spouse_occupation"
                                                   disabled
                                                   class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                        </div>
                                        <div class="w-full md:w-1/3 px-2 mb-4">
                                            <label for="spouse_monthly_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                                MONTHLY INCOME <span class="text-red-500">*</span>
                                            </label>
                                            <input type="number"
                                                   id="spouse_monthly_income"
                                                   wire:model="spouse_monthly_income"
                                                   disabled
                                                   class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
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
                                           disabled
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="partner_middle_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        MIDDLE NAME
                                    </label>
                                    <input wire:model="partner_middle_name"
                                           type="text"
                                           id="partner_middle_name"
                                           disabled
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="partner_last_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        LAST NAME</label>
                                    <input wire:model="partner_last_name"
                                           type="text"
                                           id="partner_last_name"
                                           disabled
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="partner_occupation" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        OCCUPATION
                                    </label>
                                    <input wire:model="partner_occupation"
                                           type="text"
                                           id="partner_occupation"
                                           disabled
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="partner_monthly_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        MONTHLY INCOME
                                    </label>
                                    <input wire:model="partner_monthly_income"
                                           type="text"
                                           id="partner_monthly_income"
                                           disabled
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                            </div>

                            <hr class="mt-2 mb-2 ">
                            <h2 class="block text-[16px] font-semibold text-gray-700 mb-2">SPOUSE MAIDEN NAME</h2>
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="spouse_first_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        FIRST NAME</label>
                                    <input wire:model="spouse_first_name"
                                           type="text"
                                           id="spouse_first_name"
                                           disabled
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="spouse_middle_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        MIDDLE NAME
                                    </label>
                                    <input wire:model="spouse_middle_name"
                                           type="text"
                                           id="spouse_middle_name"
                                           disabled
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="spouse_last_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        LAST NAME</label>
                                    <input wire:model="spouse_last_name"
                                           type="text"
                                           id="spouse_last_name"
                                           disabled
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="spouse_occupation" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        OCCUPATION
                                    </label>
                                    <input wire:model="spouse_occupation"
                                           type="text"
                                           id="spouse_occupation"
                                           disabled
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label for="spouse_monthly_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                        MONTHLY INCOME
                                    </label>
                                    <input wire:model="spouse_monthly_income"
                                           type="text"
                                           id="spouse_monthly_income"
                                           disabled
                                           class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
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
                                            {{ $dependent['dependent_first_name'] }}
                                        </td>
                                        <td class="border px-4 py-2">
                                            {{ $dependent['dependent_middle_name'] }}
                                        </td>
                                        <td class="border px-4 py-2">
                                            {{ $dependent['dependent_last_name'] }}
                                        </td>
                                        <td class="border px-4 py-2">
                                            {{ $dependent['dependent_sex'] }}
                                        </td>
                                        <td class="border px-1 py-2">
                                            {{ $civilStatuses->find($dependent['dependent_civil_status_id'])?->civil_status ?? 'N/A' }}
                                        </td>
                                        <td class="border px-4 py-2">
                                            {{ $dependent['dependent_date_of_birth'] ? date('M d, Y', strtotime($dependent['dependent_date_of_birth'])) : 'N/A' }}
                                        </td>
                                        <td class="border px-4 py-2">
                                            {{ $dependent['dependent_relationship'] }}
                                        </td>
                                        <td class="border px-4 py-2">
                                            {{ $dependent['dependent_occupation'] }}
                                        </td>
                                        <td class="border px-4 py-2">
                                            {{ $dependent['dependent_monthly_income'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <div class="bg-white p-6 rounded shadow mb-6">
                <form>
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-4/12 px-2 mb-4">
                            <label for="date_applied" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                DATE APPLIED
                            </label>
                            <input type="text"
                                   value="{{ $taggedAndValidatedApplicant->applicant->date_applied ? date('F d, Y', strtotime($taggedAndValidatedApplicant->applicant->date_applied)) : 'N/A' }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-4/12 px-2 mb-4">
                            <label for="tagging_date" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                DATE TAGGED
                            </label>
                            <input type="text"
                                   value="{{ $taggedAndValidatedApplicant->tagging_date ? date('F d, Y', strtotime($taggedAndValidatedApplicant->tagging_date)) : 'N/A' }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-2">
                        <!-- Living Situation dropdown -->
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="living_situation_id" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                LIVING SITUATION (CASE)
                            </label>
                            <textarea rows="2"
                                      disabled
                                      class="justify-items-start uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">{{ optional($taggedAndValidatedApplicant->livingSituation)->living_situation_description ?? '--' }}
                            </textarea>
                        </div>

                        <!-- Case Specification section -->
                        <div class="w-full md:w-4/12 px-2 mb-4">
                            <label class="block text-[12px] font-semibold text-gray-700 mb-1">
                                CASE SPECIFICATION
                            </label>
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
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="govAssistance" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                SOCIAL WELFARE SECTOR
                            </label>
                            <input type="text"
                                   value="{{ $taggedAndValidatedApplicant->governmentProgram->program_name }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="living_status_id" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                LIVING STATUS
                            </label>
                            <textarea rows="2"
                                      disabled
                                      class="justify-items-start uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">{{ $livingStatuses->firstWhere('id', $living_status_id)?->living_status_name ?? '--' }}
                            </textarea>
                        </div>
                    </div>

                    <div x-show="isLivingWithOthers()" class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4 ml-[33%]">
                            <label for="rent_fee" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                HOUSE OWNER NAME <small class="text-red-500">(if rent)</small>
                            </label>
                            <input type="text"
                                   value="{{ $house_owner }}"
                                   disabled
                                   class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
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
                            <input type="text"
                                   value="{{ $taggedAndValidatedApplicant->roofType->roof_type_name }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="wall" class="block text-[12px] font-semibold text-gray-700 mt-6 mb-1">
                                WALL TYPE
                            </label>
                            <input type="text"
                                   value="{{ $taggedAndValidatedApplicant->wallType->wall_type_name }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="wall" class="block text-[12px] font-semibold text-gray-700 mt-6 mb-1">
                                TRANSACTION TYPE
                            </label>
                            <input type="text"
                                   value="{{ $taggedAndValidatedApplicant->applicant->transactionType->type_name }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
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
                                   disabled
                                   class="capitalize italic w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>
                </form>
            </div>

            <div class="p-3 rounded">
                <h2 class="text-[12px] ml-2 items-center font-bold text-gray-700">UPLOADED DOCUMENTS DURING TAGGING</h2>
            </div>

            <div class="bg-white p-6 rounded shadow mb-6">
                <!-- Document Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
                    @forelse($taggedDocuments as $document)
                        <div class="relative group cursor-pointer" wire:click="viewDocument({{ $document->id }})">
                            <img
                                    src="{{ asset('tagging-house-structure-images/' . $document->file_path) }}"
                                    alt="{{ $document->file_name }}"
                                    class="w-full h-48 object-cover rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300"
                            >
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
                                    class="max-w-full h-auto"
                            >
                            <div class="mt-2 text-center text-gray-700">
                                {{ $selectedDocument->file_name }}
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

