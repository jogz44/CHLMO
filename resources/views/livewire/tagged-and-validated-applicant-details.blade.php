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

{{--                    <div x-show="isRenting()" class="flex flex-wrap -mx-2">--}}
{{--                        <div class="w-full md:w-1/3 px-2 mb-4 ml-[33%]">--}}
{{--                            <label for="rent_fee" class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
{{--                                MONTHLY RENT FEE <small class="text-red-500">(if rent)</small>--}}
{{--                            </label>--}}
{{--                            <input type="text"--}}
{{--                                   value="{{ $rent_fee }}"--}}
{{--                                   disabled--}}
{{--                                   class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">--}}
{{--                        </div>--}}

{{--                        <div class="w-full md:w-1/3 px-2 mb-4">--}}
{{--                            <label for="rent_fee" class="block text-[12px] font-semibold text-gray-700 mb-1">--}}
{{--                                LANDLORD NAME <small class="text-red-500">(if rent)</small>--}}
{{--                            </label>--}}
{{--                            <input type="text"--}}
{{--                                   value="{{ $landlord }}"--}}
{{--                                   disabled--}}
{{--                                   class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">--}}
{{--                        </div>--}}
{{--                    </div>--}}

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
            <!-- Display images -->
            <div class="bg-white p-6 rounded shadow mb-6">
                <!-- Image Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
                    @forelse($images as $image)
                        <div class="relative group cursor-pointer" wire:click="viewImage({{ $image->id }})">
                            <img
                                    src="{{ asset('storage/' . $image->image_path) }}"
                                    alt="{{ $image->display_name }}"
                                    class="w-full h-48 object-cover rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
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

