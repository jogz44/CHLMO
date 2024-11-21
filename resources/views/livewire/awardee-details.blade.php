<div class="p-10 h-screen ml-[17%] mt-[60px]">
    <div x-data="{
        openModalBlacklist: false,
        living_situation_id: @entangle('living_situation_id'),
        livingStatusId: @entangle('living_status_id'),
        isRenting() { return this.livingStatusId == 1 },
        isLivingWithOthers() { return this.livingStatusId == 5 } }"
         class="flex bg-gray-100 text-[12px]">
        <div class="flex-1 p-6 overflow-auto">
            <div class="bg-white rounded shadow mb-4 flex items-center justify-between p-3 fixed top-[80px] left-[20%] right-[3%] z-5">
                <div class="flex items-center">
                    <a href="{{ route('awardee-list') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                             stroke="currentColor" class="w-5 h-5 text-custom-yellow mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h2 class="text-[13px] ml-2 items-center text-gray-700">Awardee Personal Information</h2>
                </div>
                <img src="{{ asset('storage/images/design.png') }}" alt="Design"
                     class="absolute right-0 top-0 h-full object-cover 0 z-0">
                <div x-data="{ saved: false }" class="flex space-x-2 z-0">
                    @if ($awardee->is_blacklisted)
                        <button class="bg-gray-500 text-white text-xs font-semibold px-6 py-2 rounded cursor-not-allowed">
                            BLACKLISTED
                        </button>
                    @else
                        <button
                                class="bg-custom-dark-green text-white text-xs font-semibold px-6 py-2 rounded"
                                @click="openModalBlacklist = true">
                            BLACKLIST
                        </button>
                    @endif
                </div>
            </div>

            <div class="flex flex-col p-3 rounded mt-11">
                <h2 class="text-[30px] items-center font-bold text-gray-700 underline">{{ $applicant->applicant_id }}</h2>
                <h1 class="text-[25px] items-center font-bold text-gray-700">
                    {{ $awardee->taggedAndValidatedApplicant->applicant->person->full_name }}
                </h1>
            </div>

            <div class="bg-white p-6 rounded shadow mb-6">
                <form wire:submit.prevent="saveChanges">
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="first-name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                FIRST NAME
                            </label>
                            <input wire:model="first_name"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="middle-name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                MIDDLE NAME
                            </label>
                            <input wire:model="middle_name"
                                    type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="last-name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                LAST NAME
                            </label>
                            <input wire:model="last_name"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="suffix_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                SUFFIX NAME
                            </label>
                            <input wire:model="suffix_name"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="barangay_id" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                BARANGAY
                            </label>
                            <input wire:model="barangay_id"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="purok_id" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                PUROK
                            </label>
                            <input wire:model="purok_id"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="full-address" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                FULL ADDRESS
                            </label>
                            <input wire:model="full_address"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="civil_status_id" class="block text-[12px] font-semibold text-gray-700 mb-1">CIVIL STATUS</label>
                            <input type="text"
                                   value="{{ $taggedApplicant->civilStatus->civil_status }}"
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
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="tribe" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                TRIBE/ETHNICITY
                            </label>
                                <input wire:model="tribe"
                                       type="text"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="sex" class="block text-[12px] font-semibold text-gray-700 mb-1">SEX</label>
                            <div class="flex items-center">
                                <input type="text"
                                       value="{{ $taggedApplicant->sex }}"
                                       disabled
                                       class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="age" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                DATE OF BIRTH
                            </label>
                            <input type="text"
                                   value="{{ $taggedApplicant->date_of_birth ? date('F d, Y', strtotime($taggedApplicant->date_of_birth)) : 'N/A' }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="religion" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                RELIGION
                            </label>
                            <input wire:model="religion"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="occupation" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                OCCUPATION
                            </label>
                            <input wire:model="occupation"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="monthly_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                MONTHLY INCOME
                            </label>
                            <input wire:model="monthly_income"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="family_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                FAMILY INCOME
                            </label>
                            <input wire:model="family_income"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>

                    <hr class="mt-2 mb-2 ">
                    <h2 class="block text-[12px] font-semibold text-gray-700 mb-2">LIVE-IN PARTNER'S MAIDEN NAME</h2>
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="partner_first_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                FIRST NAME</label>
                            <input wire:model="partner_first_name"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="partner_middle_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                MIDDLE NAME
                            </label>
                            <input wire:model="partner_middle_name"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="partner_last_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                LAST NAME</label>
                            <input wire:model="partner_last_name"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="partner_occupation" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                OCCUPATION
                            </label>
                            <input wire:model="partner_occupation"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="partner_monthly_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                MONTHLY INCOME
                            </label>
                            <input wire:model="partner_monthly_income"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>

                    <hr class="mt-2 mb-2 ">
                    <h2 class="block text-[12px] font-semibold text-gray-700 mb-2">SPOUSE MAIDEN NAME</h2>
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="spouse_first_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                FIRST NAME</label>
                            <input wire:model="spouse_first_name"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="spouse_middle_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                MIDDLE NAME
                            </label>
                            <input wire:model="spouse_middle_name"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="spouse_last_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                LAST NAME</label>
                            <input wire:model="spouse_last_name"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="spouse_occupation" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                OCCUPATION
                            </label>
                            <input wire:model="spouse_occupation"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="spouse_monthly_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                MONTHLY INCOME
                            </label>
                            <input wire:model="spouse_monthly_income"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
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
                                            {{ $dependentRelationships->find($dependent['dependent_relationship_id'])?->relationship ?? 'N/A' }}
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
                                   value="{{ $applicant->date_applied ? date('F d, Y', strtotime($applicant->date_applied)) : 'N/A' }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-4/12 px-2 mb-4">
                            <label for="tagging_date" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                DATE TAGGED
                            </label>
                            <input type="text"
                                   value="{{ $taggedApplicant->tagging_date ? date('F d, Y', strtotime($taggedApplicant->tagging_date)) : 'N/A' }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-4/12 px-2 mb-4">
                            <label for="grant_date" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                DATE AWARDED
                            </label>
                            <input type="text"
                                   value="{{ $awardee->grant_date ? date('F d, Y', strtotime($awardee->grant_date)) : 'N/A' }}"
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
                                      class="justify-items-start uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">{{ optional($taggedApplicant->livingSituation)->living_situation_description ?? '--' }}
                            </textarea>
                        </div>

                        <!-- Case Specification section -->
                        <div class="w-full md:w-4/12 px-2 mb-4">
                            <label class="block text-[12px] font-semibold text-gray-700 mb-1">
                                CASE SPECIFICATION
                            </label>
                                @if($taggedApplicant->living_situation_id == 8)
                                    <textarea rows="2"
                                              disabled
                                              class="justify-items-start uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">{{ optional($taggedApplicant->caseSpecification)->case_specification_name ?? '--' }}
                                    </textarea>
                                @else
                                    <textarea rows="2"
                                              disabled
                                              class="justify-items-start uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">{{ $taggedApplicant->living_situation_case_specification ?? '--' }}
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
                                   value="{{ $taggedApplicant->governmentProgram->program_name }}"
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

                    <div x-show="isRenting()" class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4 ml-[33%]">
                            <label for="rent_fee" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                MONTHLY RENT FEE <small class="text-red-500">(if rent)</small>
                            </label>
                            <input type="text"
                                   value="{{ $rent_fee }}"
                                   disabled
                                   class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>

                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="rent_fee" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                LANDLORD NAME <small class="text-red-500">(if rent)</small>
                            </label>
                            <input type="text"
                                   value="{{ $landlord }}"
                                   disabled
                                   class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
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
                                   value="{{ $taggedApplicant->roofType->roof_type_name }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="wall" class="block text-[12px] font-semibold text-gray-700 mt-6 mb-1">
                                WALL TYPE
                            </label>
                            <input type="text"
                                   value="{{ $taggedApplicant->wallType->wall_type_name }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="wall" class="block text-[12px] font-semibold text-gray-700 mt-6 mb-1">
                                TRANSACTION TYPE
                            </label>
                            <input type="text"
                                   value="{{ $applicant->transactionType->type_name }}"
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
                                   disabled
                                   class="capitalize italic w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>
                </form>
            </div>

            <div class="p-3 rounded">
                <h2 class="text-[12px] ml-2 items-center font-bold text-gray-700">UPLOADED REQUIREMENTS DURING AWARDING</h2>
            </div>
            <!-- Display images -->
            <div class="bg-white p-6 rounded shadow mb-6">
                <!-- Image Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
                    @forelse($imagesForAwarding as $fileName)
                        <div class="relative group cursor-pointer" wire:click="viewAttachment('{{ $fileName }}')">
                            <img
                                    src="{{ asset('awardee-photo-requirements/documents/' . $fileName) }}"
                                    alt="{{ $fileName }}"
                                    class="w-full h-48 object-cover rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300"
                                    loading="lazy">
                            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-2 text-sm rounded-b-lg">
                                {{ $fileName }}
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-4 text-gray-500">
                            No images available
                        </div>
                    @endforelse
                </div>

                <!-- Modal -->
                @if($selectedAttachment)
                    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg p-4 max-w-4xl max-h-[90vh] overflow-auto">
                            <div class="flex justify-end mb-2">
                                <button wire:click="closeAttachment" class="text-gray-500 hover:text-gray-700">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <img src="{{ asset('awardee-photo-requirements/documents/' . $selectedAttachment) }}"
                                 alt="{{ $selectedAttachment }}"
                                 class="max-w-full h-auto">
                            <div class="mt-2 text-center text-gray-700">
                                {{ $selectedAttachment }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div x-show="openModalBlacklist" x-cloak
             class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-40">
            <!-- Modal -->
            <div class="bg-white rounded-lg shadow-lg w-[400px] p-6 relative z-50"
                 @click.away="openModal = false">
                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-md font-semibold text-black " style="font-family:'Poppins', sans-serif;">
                        BLACKLIST AWARDEE
                    </h3>
                    <button @click="openModalBlacklist = false"
                            class="text-red-500 hover:text-red-700 font-bold text-sm">&times;
                    </button>
                </div>

                <form wire:submit.prevent="store">
                    <!-- Date blacklisted (default now()) -->
                    <div class="mb-4">
                        <label class="block text-[12px] font-semibold mb-2 text-gray-700" for="date_blacklisted">
                            DATE BLACKLISTED
                        </label>
                        <input wire:model="date_blacklisted"
                               type="date"
                               id="date_blacklisted"
                               class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none"
                               required
                               max="{{ now()->toDateString() }}">
                        @error('date_blacklisted') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Reason Field -->
                    <div class="mb-4">
                        <label class="block text-[12px] font-semibold mb-2 text-gray-700" for="reason">
                            REASON FOR BEING BLACKLISTED <span class="text-red-500">*</span>
                        </label>
                        <textarea  wire:model="blacklist_reason_description"
                                   id="reason"
                                   rows="4"
                                   class="uppercase w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                   required
                                   placeholder="Enter reason..."></textarea>
                    </div>

                    <!-- Updated By Field -->
                    <div class="mb-4">
                        <label class="block text-[12px] font-semibold mb-2 text-gray-700" for="updated-by">
                            UPDATED BY
                        </label>
                        <input wire:model="updated_by"
                               type="text"
                               id="updated-by"
                               disabled
                               class="uppercase w-full px-3 py-2 bg-gray-300 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px] cursor-not-allowed"
                               placeholder="Updated by...">
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-between items-center">
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
                            <!-- Blacklist Button -->
                            <button type="submit" wire:click.prevent="store"
                                    class="px-4 py-2 bg-red-600 text-[12px] text-white rounded-lg hover:bg-red-700">
                                BLACKLIST
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
                        <!-- Cancel Button -->
                        <button type="button" @click="openModalBlacklist = false"
                                class="px-4 py-2 bg-gray-500 text-[12px] text-white rounded-lg hover:bg-gray-600">
                            CANCEL
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div>
            @if($showBlacklistConfirmationModal)
                <div class="modal">
                    <div class="modal-content">
                        <h2 class="text-red-600 font-bold mb-4">Confirm Blacklisting</h2>

                        <p class="text-red-500 mb-4 font-semibold">
                            ⚠️ WARNING: This action CANNOT be undone.
                            Please double-check your transaction before proceeding.
                        </p>

                        @if($blacklistError)
                            <p class="text-red-500 mb-2">{{ $blacklistError }}</p>
                        @endif

                        <div class="mb-4">
                            <label for="confirmPassword" class="block mb-2">
                                Enter your password to confirm:
                            </label>
                            <input
                                    type="password"
                                    wire:model="confirmationPassword"
                                    class="w-full px-3 py-2 border rounded-md"
                                    required>
                        </div>

                        <div class="flex justify-between">
                            <button
                                    wire:click="cancelBlacklisting"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg">
                                Cancel
                            </button>
                            <button
                                    wire:click="store"
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                Confirm Blacklist
                            </button>
                        </div>
                    </div>
                </div>
            @endif
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

