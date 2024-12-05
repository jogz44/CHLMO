<div class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <div class="flex-1 p-6 overflow-auto">
            <!-- Top Navigation Bar -->
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
                <div class="flex justify-end z-20">
                    <button wire:click="$set('showAssignSiteModal', true)"
                            class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-4 py-2 rounded-md text-sm flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Assign Relocation Site
                    </button>
                </div>
            </div>

            <!-- Applicant Header -->
            <div class="flex flex-col p-3 rounded mt-12">
                <h2 class="text-[30px] items-center font-bold text-gray-700 underline">
                    {{ $taggedAndValidatedApplicant->applicant->applicant_id }}
                </h2>
                <h1 class="text-[25px] items-center font-bold text-gray-700">
                    {{ $taggedAndValidatedApplicant->applicant->person->full_name }}
                </h1>
            </div>

            <!-- Group 1: Primary Information -->

            <div class="bg-white p-6 rounded shadow mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Primary Information</h2>
                    <button wire:click="openPrimaryInfoModal"
                            class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-3 py-1 rounded-md text-sm relative">
                        <span wire:loading.remove>
                            Edit
                        </span>
                        <span wire:loading class="flex items-center">
                            <svg class="animate-spin h-4 w-4 text-white mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Loading...
                        </span>
                    </button>
                </div>

                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-1/4 px-2 mb-4">
                        <label for="first-name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                            FIRST NAME
                        </label>
                        <input wire:model="first_name"
                               type="text"
                               id="first_name"
                               disabled
                               class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 rounded-md focus:outline-none focus:ring-custom-yellow">
                    </div>
                    <div class="w-full md:w-1/4 px-2 mb-4">
                        <label for="middle-name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                            MIDDLE NAME
                        </label>
                        <input wire:model="middle_name"
                               type="text"
                               id="middle-name"
                               disabled
                               class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 rounded-md focus:outline-none focus:ring-custom-yellow">
                    </div>
                    <div class="w-full md:w-1/4 px-2 mb-4">
                        <label for="last-name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                            LAST NAME
                        </label>
                        <input wire:model="last_name"
                               type="text"
                               id="last-name"
                               disabled
                               class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 rounded-md focus:outline-none focus:ring-custom-yellow">
                    </div>
                    <div class="w-full md:w-1/4 px-2 mb-4">
                        <label for="suffix_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                            SUFFIX NAME
                        </label>
                        <input wire:model="suffix_name"
                               type="text"
                               id="suffix_name"
                               disabled
                               class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 rounded-md focus:outline-none focus:ring-custom-yellow">
                    </div>
                </div>

                <div x-data="{ civilStatus: '{{ $taggedAndValidatedApplicant->civil_status_id }}' }">
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="barangay_id"
                                   class="block text-[12px] font-semibold text-gray-700 mb-1">BARANGAY</label>
                            <input type="text"
                                   value="{{ $taggedAndValidatedApplicant->applicant?->address?->barangay?->name ?? '--' }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 rounded-md focus:outline-none focus:ring-custom-yellow">

                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="purok_id" class="block text-[12px] font-semibold text-gray-700 mb-1">PUROK</label>
                            <input type="text"
                                   value="{{ $taggedAndValidatedApplicant->applicant?->address?->purok?->name ?? '--' }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="full-address" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                FULL ADDRESS
                            </label>
                            <input wire:model="full_address"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border text-[12px] bg-gray-200 rounded-md focus:outline-none focus:ring-custom-yellow transition-colors">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="civil_status_id" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                CIVIL STATUS
                            </label>
                            <input type="text"
                                   value="{{ $taggedAndValidatedApplicant->civilStatus->civil_status }}"
                                   disabled
                                   class="uppercase w-full p-1 border text-[12px] bg-gray-200 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="contactNo" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                CONTACT NUMBER
                            </label>
                            <input wire:model="contact_number"
                                   type="text"
                                   disabled
                                   class="uppercase w-full p-1 border text-[12px] bg-gray-200 rounded-md focus:outline-none focus:ring-custom-yellow transition-colors">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="tribe" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                TRIBE/ETHNICITY
                            </label>
                            <input wire:model="tribe"
                                    type="text"
                                    disabled
                                    class="uppercase w-full p-1 border text-[12px] bg-gray-200 rounded-md focus:outline-none focus:ring-custom-yellow transition-colors">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="sex" class="block text-[12px] font-semibold text-gray-700 mb-1">SEX</label>
                            <input wire:model="sex"
                                    type="text"
                                   disabled
                                   class="uppercase w-full p-1 border text-[12px] bg-gray-200 rounded-md focus:outline-none focus:ring-custom-yellow transition-colors bg-gray-200">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="age" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                DATE OF BIRTH
                            </label>
                            <input type="text"
                                   value="{{ $this->formattedDateOfBirth }}"
                                   disabled
                                   class="uppercase w-full p-1 border text-[12px] bg-gray-200 rounded-md focus:outline-none focus:ring-custom-yellow bg-gray-200">
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
                                   disabled
                                   value="{{ $taggedAndValidatedApplicant->religion }}"
                                   class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="occupation" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                OCCUPATION
                            </label>
                            <input wire:model="occupation"
                                   type="text"
                                   id="occupation"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="monthly_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                MONTHLY INCOME
                            </label>
                            <input wire:model="monthly_income"
                                   value="{{ $taggedAndValidatedApplicant->monthly_income }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="years_of_residency" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                LENGTH OF RESIDENCY
                            </label>
                            <input wire:model="years_of_residency"
                                   value="{{ $taggedAndValidatedApplicant->years_of_residency }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="voters_id_number" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                VOTER'S ID NUMBER
                            </label>
                            <input wire:model="voters_id_number"
                                   value="{{ $taggedAndValidatedApplicant->voters_id_number }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>
                    @if($taggedAndValidatedApplicant->liveInPartner)
                        <div>
                            <hr class="mt-2 mb-2">
                            <h2 class="block text-[16px] font-semibold text-gray-700 mb-2">PARTNER DETAILS</h2>
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label class="block text-[12px] font-semibold text-gray-700 mb-1">FIRST NAME</label>
                                    <input type="text"
                                           value="{{ $taggedAndValidatedApplicant->liveInPartner->partner_first_name }}"
                                           disabled
                                           class="w-full p-1 border text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label class="block text-[12px] font-semibold text-gray-700 mb-1">MIDDLE NAME</label>
                                    <input type="text"
                                           value="{{ $taggedAndValidatedApplicant->liveInPartner->partner_middle_name }}"
                                           disabled
                                           class="w-full p-1 border text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label class="block text-[12px] font-semibold text-gray-700 mb-1">LAST NAME</label>
                                    <input type="text"
                                           value="{{ $taggedAndValidatedApplicant->liveInPartner->partner_last_name }}"
                                           disabled
                                           class="w-full p-1 border text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label class="block text-[12px] font-semibold text-gray-700 mb-1">OCCUPATION</label>
                                    <input type="text"
                                           value="{{ $taggedAndValidatedApplicant->liveInPartner->partner_occupation }}"
                                           disabled
                                           class="w-full p-1 border text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label class="block text-[12px] font-semibold text-gray-700 mb-1">MONTHLY INCOME</label>
                                    <input type="text"
                                           value="{{ $taggedAndValidatedApplicant->liveInPartner->partner_monthly_income }}"
                                           disabled
                                           class="w-full p-1 border text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($taggedAndValidatedApplicant->spouse)
                        <div>
                            <hr class="mt-2 mb-2">
                            <h2 class="block text-[16px] font-semibold text-gray-700 mb-2">SPOUSE DETAILS</h2>
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label class="block text-[12px] font-semibold text-gray-700 mb-1">FIRST NAME</label>
                                    <input type="text"
                                           value="{{ $taggedAndValidatedApplicant->spouse->spouse_first_name }}"
                                           disabled
                                           class="w-full p-1 border text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label class="block text-[12px] font-semibold text-gray-700 mb-1">MIDDLE NAME</label>
                                    <input type="text"
                                           value="{{ $taggedAndValidatedApplicant->spouse->spouse_middle_name }}"
                                           disabled
                                           class="w-full p-1 border text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label class="block text-[12px] font-semibold text-gray-700 mb-1">LAST NAME</label>
                                    <input type="text"
                                           value="{{ $taggedAndValidatedApplicant->spouse->spouse_last_name }}"
                                           disabled
                                           class="w-full p-1 border text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label class="block text-[12px] font-semibold text-gray-700 mb-1">OCCUPATION</label>
                                    <input type="text"
                                           value="{{ $taggedAndValidatedApplicant->spouse->spouse_occupation }}"
                                           disabled
                                           class="w-full p-1 border text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                                <div class="w-full md:w-1/3 px-2 mb-4">
                                    <label class="block text-[12px] font-semibold text-gray-700 mb-1">MONTHLY INCOME</label>
                                    <input type="text"
                                           value="{{ $taggedAndValidatedApplicant->spouse->spouse_monthly_income }}"
                                           disabled
                                           class="w-full p-1 border text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Group 2: Dependents -->
            <div class="bg-white p-6 rounded shadow mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Dependents</h2>
                    <button wire:click="openDependentsModal"
                            class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-3 py-1 rounded-md text-sm">
                        <span wire:loading.remove>
                            Edit
                        </span>
                        <span wire:loading class="flex items-center">
                            <svg class="animate-spin h-4 w-4 text-white mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Loading...
                        </span>
                    </button>
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
            </div>

            <!-- Group 3: Living Situation -->
            <div class="bg-white p-6 rounded shadow mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Living Situation</h2>
                    <button wire:click="openLivingSituationModal"
                            class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-3 py-1 rounded-md text-sm">
                        <span wire:loading.remove>
                            Edit
                        </span>
                        <span wire:loading class="flex items-center">
                            <svg class="animate-spin h-4 w-4 text-white mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Loading...
                        </span>
                    </button>
                </div>

                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-4/12 px-2 mb-4">
                        <label for="date_applied" class="block text-[12px] font-semibold text-gray-700 mb-1">
                            DATE APPLIED
                        </label>
                        <input type="text"
                               value="{{ $taggedAndValidatedApplicant->applicant->date_applied ? date('F d, Y', strtotime($taggedAndValidatedApplicant->applicant->date_applied)) : 'N/A' }}"
                               disabled
                               class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                    </div>
                    <div class="w-full md:w-4/12 px-2 mb-4">
                        <label for="tagging_date" class="block text-[12px] font-semibold text-gray-700 mb-1">
                            DATE TAGGED
                        </label>
                        <input type="text"
                               value="{{ $taggedAndValidatedApplicant->tagging_date ? date('F d, Y', strtotime($taggedAndValidatedApplicant->tagging_date)) : 'N/A' }}"
                               disabled
                               class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
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
                                  class="justify-items-start uppercase w-full p-1 text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">{{ optional($taggedAndValidatedApplicant->livingSituation)->living_situation_description ?? '--' }}
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
                                      class="justify-items-start uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">{{ optional($taggedAndValidatedApplicant->caseSpecification)->case_specification_name ?? '--' }}
                            </textarea>
                        @else
                            <textarea rows="2"
                                      disabled
                                      class="justify-items-start uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">{{ $taggedAndValidatedApplicant->living_situation_case_specification ?? '--' }}
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
                               class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                    </div>
                    <div class="w-full md:w-1/3 px-2 mb-4">
                        <label for="living_status_id" class="block text-[12px] font-semibold text-gray-700 mb-1">
                            LIVING STATUS
                        </label>
                        <textarea rows="2"
                                  disabled
                                  class="justify-items-start uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            {{ $livingStatuses->firstWhere('id', $taggedAndValidatedApplicant->living_status_id)?->living_status_name ?? '--' }}
                        </textarea>
                    </div>
                </div>

                @if($taggedAndValidatedApplicant->living_status_id == 1)
                    <div class="flex flex-wrap -mx-2 ml-[33%]">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label class="block text-[12px] font-semibold text-gray-700 mb-1">
                                ROOM RENT FEE
                            </label>
                            <input type="text"
                                   value="{{ $taggedAndValidatedApplicant->room_rent_fee ?? '--' }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label class="block text-[12px] font-semibold text-gray-700 mb-1">
                                LANDLORD
                            </label>
                            <input type="text"
                                   value="{{ $taggedAndValidatedApplicant->room_landlord ?? '--' }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>
                @elseif($taggedAndValidatedApplicant->living_status_id == 2)
                    <div class="flex flex-wrap -mx-2 ml-[33%]">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label class="block text-[12px] font-semibold text-gray-700 mb-1">
                                HOUSE RENT FEE
                            </label>
                            <input type="text"
                                   value="{{ $taggedAndValidatedApplicant->house_rent_fee ?? '--' }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label class="block text-[12px] font-semibold text-gray-700 mb-1">
                                LANDLORD
                            </label>
                            <input type="text"
                                   value="{{ $taggedAndValidatedApplicant->house_landlord ?? '--' }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>
                @elseif($taggedAndValidatedApplicant->living_status_id == 3)
                    <div class="flex flex-wrap -mx-2 ml-[33%]">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label class="block text-[12px] font-semibold text-gray-700 mb-1">
                                LOT RENT FEE
                            </label>
                            <input type="text"
                                   value="{{ $taggedAndValidatedApplicant->lot_rent_fee ?? '--' }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label class="block text-[12px] font-semibold text-gray-700 mb-1">
                                LANDLORD
                            </label>
                            <input type="text"
                                   value="{{ $taggedAndValidatedApplicant->lot_landlord ?? '--' }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>
                @elseif($taggedAndValidatedApplicant->living_status_id == 8)
                    <div class="flex flex-wrap -mx-2 ml-[33%]">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label class="block text-[12px] font-semibold text-gray-700 mb-1">
                                HOUSE OWNER NAME
                            </label>
                            <input type="text"
                                   value="{{ $taggedAndValidatedApplicant->house_owner ?? '--' }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label class="block text-[12px] font-semibold text-gray-700 mb-1">
                                RELATIONSHIP
                            </label>
                            <input type="text"
                                   value="{{ $taggedAndValidatedApplicant->relationship_to_house_owner ?? '--' }}"
                                   disabled
                                   class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>
                @endif

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
                               class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                    </div>
                    <div class="w-full md:w-1/3 px-2 mb-4">
                        <label for="wall" class="block text-[12px] font-semibold text-gray-700 mt-6 mb-1">
                            WALL TYPE
                        </label>
                        <input type="text"
                               value="{{ $taggedAndValidatedApplicant->wallType->wall_type_name }}"
                               disabled
                               class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                    </div>
                    <div class="w-full md:w-1/3 px-2 mb-4">
                        <label for="wall" class="block text-[12px] font-semibold text-gray-700 mt-6 mb-1">
                            TRANSACTION TYPE
                        </label>
                        <input type="text"
                               value="{{ $taggedAndValidatedApplicant->applicant->transactionType->type_name }}"
                               disabled
                               class="uppercase w-full p-1 border-b text-[12px] bg-gray-200 bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
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
                               class="capitalize italic w-full p-1 border-b text-[12px] bg-gray-200 border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                    </div>
                </div>
            </div>

            {{-- Group 4: Photos --}}
            <div class="p-3 rounded">
                <h2 class="text-[12px] ml-2 items-center font-bold text-gray-700">UPLOADED DOCUMENTS DURING TAGGING</h2>
            </div>

            <div class="bg-white p-6 rounded shadow mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Photos</h2>
                    <button wire:click="openPhotosModal"
                            class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-3 py-1 rounded-md text-sm">
                        <span wire:loading.remove>
                            Edit
                        </span>
                        <span wire:loading class="flex items-center">
                            <svg class="animate-spin h-4 w-4 text-white mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Loading...
                        </span>
                    </button>
                </div>

                <!-- Document Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
                    @forelse($taggedDocuments as $document)
                        <div class="relative group cursor-pointer" wire:click="viewDocument({{ $document->id }})">
                            <img
                                    src="{{ url('storage/tagging-house-structure-images/' . $document->file_path) }}"
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
                                    src="{{ url('storage/tagging-house-structure-images/' . $selectedDocument->file_path) }}"
                                    alt="{{ $selectedDocument->file_name }}"
                                    class="max-w-full h-auto">
                            <div class="mt-2 text-center text-gray-700">
                                {{ $selectedDocument->file_name }}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Modals -->
                <!-- Primary Information Modal -->
                <div class="modal" wire:model="showPrimaryInfoModal">
                    @if($showPrimaryInfoModal)
                        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                                <!-- Background overlay -->
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                                <!-- Modal panel -->
                                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                                    <form wire:submit.prevent="updatePrimaryInfo">
                                        <div x-data="{ civilStatus: @entangle('editPrimaryInfo.civil_status_id') }" class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="flex justify-between items-center pb-4 mb-4 border-b">
                                                <h3 class="text-lg font-semibold text-gray-900">Edit Primary Information</h3>
                                                <button type="button" wire:click="$set('showPrimaryInfoModal', false)" class="text-gray-400 hover:text-gray-500">
                                                    <span class="sr-only">Close</span>
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4">
                                                <!-- Full Address -->
                                                <div>
                                                    <label for="edit_full_address" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Full Address
                                                    </label>
                                                    <input type="text" id="edit_full_address"
                                                           wire:model="editPrimaryInfo.full_address"
                                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                    @error('editPrimaryInfo.full_address')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <!-- Civil Status -->
                                                <div>
                                                    <label for="edit_civil_status" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Civil Status
                                                    </label>
                                                    <select id="edit_civil_status"
                                                            x-model="civilStatus"
                                                            wire:model="editPrimaryInfo.civil_status_id"
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                        <option value="">Select Status</option>
                                                        @foreach($civilStatuses as $status)
                                                            <option value="{{ $status->id }}">{{ $status->civil_status }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('editPrimaryInfo.civil_status_id')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <!-- Tribe -->
                                                <div>
                                                    <label for="edit_tribe" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Tribe/Ethnicity
                                                    </label>
                                                    <input type="text" id="edit_tribe"
                                                           wire:model="editPrimaryInfo.tribe"
                                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                    @error('editPrimaryInfo.tribe')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <!-- Sex -->
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Sex</label>
                                                    <div class="mt-2 space-x-4">
                                                        <label class="inline-flex items-center">
                                                            <input type="radio" wire:model="editPrimaryInfo.sex" value="Male"
                                                                   class="form-radio text-blue-600">
                                                            <span class="ml-2">Male</span>
                                                        </label>
                                                        <label class="inline-flex items-center">
                                                            <input type="radio" wire:model="editPrimaryInfo.sex" value="Female"
                                                                   class="form-radio text-blue-600">
                                                            <span class="ml-2">Female</span>
                                                        </label>
                                                    </div>
                                                    @error('editPrimaryInfo.sex')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <!-- Date of Birth -->
                                                <div>
                                                    <label for="edit_date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Date of Birth
                                                    </label>
                                                    <input type="date" id="edit_date_of_birth"
                                                           wire:model="editPrimaryInfo.date_of_birth"
                                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                    @error('editPrimaryInfo.date_of_birth')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <!-- Religion -->
                                                <div>
                                                    <label for="edit_religion" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Religion
                                                    </label>
                                                    <input type="text" id="edit_religion"
                                                           wire:model="editPrimaryInfo.religion"
                                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                    @error('editPrimaryInfo.religion')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <!-- Occupation -->
                                                <div>
                                                    <label for="edit_occupation" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Occupation
                                                    </label>
                                                    <input type="text" id="edit_occupation"
                                                           wire:model="editPrimaryInfo.occupation"
                                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                    @error('editPrimaryInfo.occupation')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <!-- Monthly Income -->
                                                <div>
                                                    <label for="edit_monthly_income" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Monthly Income
                                                    </label>
                                                    <input type="number" id="edit_monthly_income"
                                                           wire:model="editPrimaryInfo.monthly_income"
                                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                    @error('editPrimaryInfo.monthly_income')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <!-- Length of Residency -->
                                                <div>
                                                    <label for="edit_length_of_residency" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Length of Residency
                                                    </label>
                                                    <input type="number" id="edit_length_of_residency"
                                                           wire:model="editPrimaryInfo.length_of_residency"
                                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                    @error('editPrimaryInfo.length_of_residency')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <!-- Voter's ID Number -->
                                                <div>
                                                    <label for="edit_voters_id" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Voter's ID Number
                                                    </label>
                                                    <input type="text" id="edit_voters_id"
                                                           wire:model="editPrimaryInfo.voters_id_number"
                                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                    @error('editPrimaryInfo.voters_id_number')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                            </div>

                                            <!-- Live-in Partner Details -->
                                            <template x-if="civilStatus === '2'">
                                                <div>
                                                    <hr class="my-4">
                                                    <h4 class="text-md font-semibold text-gray-700 mb-3">Partner Details</h4>
                                                    <div class="grid grid-cols-3 gap-4">
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                                            <input type="text"
                                                                   wire:model="editPrimaryInfo.partner_first_name"
                                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                            @error('editPrimaryInfo.partner_first_name')
                                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">Middle Name</label>
                                                            <input type="text"
                                                                   wire:model="editPrimaryInfo.partner_middle_name"
                                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                                            <input type="text"
                                                                   wire:model="editPrimaryInfo.partner_last_name"
                                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                            @error('editPrimaryInfo.partner_last_name')
                                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">Occupation</label>
                                                            <input type="text"
                                                                   wire:model="editPrimaryInfo.partner_occupation"
                                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                            @error('editPrimaryInfo.partner_occupation')
                                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">Monthly Income</label>
                                                            <input type="number"
                                                                   wire:model="editPrimaryInfo.partner_monthly_income"
                                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                            @error('editPrimaryInfo.partner_monthly_income')
                                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>

                                            <!-- Spouse Details -->
                                            <template x-if="civilStatus === '3'">
                                                <div>
                                                    <hr class="my-4">
                                                    <h4 class="text-md font-semibold text-gray-700 mb-3">Spouse Details</h4>
                                                    <div class="grid grid-cols-3 gap-4">
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                                            <input type="text"
                                                                   wire:model="editPrimaryInfo.spouse_first_name"
                                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                            @error('editPrimaryInfo.spouse_first_name')
                                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">Middle Name</label>
                                                            <input type="text"
                                                                   wire:model="editPrimaryInfo.spouse_middle_name"
                                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                                            <input type="text"
                                                                   wire:model="editPrimaryInfo.spouse_last_name"
                                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                            @error('editPrimaryInfo.spouse_last_name')
                                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">Occupation</label>
                                                            <input type="text"
                                                                   wire:model="editPrimaryInfo.spouse_occupation"
                                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                            @error('editPrimaryInfo.spouse_occupation')
                                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">Monthly Income</label>
                                                            <input type="number"
                                                                   wire:model="editPrimaryInfo.spouse_monthly_income"
                                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                            @error('editPrimaryInfo.spouse_monthly_income')
                                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>

                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button type="submit"
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                Save Changes
                                            </button>
                                            <button type="button"
                                                    wire:click="$set('showPrimaryInfoModal', false)"
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Dependents Modal -->
                <div class="modal" wire:model="showDependentsModal">
                    @if($showDependentsModal)
                        <div class="fixed inset-0 z-40 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                                <!-- Background overlay -->
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                                <!-- Modal panel -->
                                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-7xl sm:w-full">
                                    <form wire:submit.prevent="updateDependents">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="flex justify-between items-center pb-4 mb-4 border-b">
                                                <h3 class="text-lg font-semibold text-gray-900">Edit Dependents</h3>
                                                <button type="button" wire:click="$set('showDependentsModal', false)" class="text-gray-400 hover:text-gray-500">
                                                    <span class="sr-only">Close</span>
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Add Dependent Button -->
                                            <div class="mb-4">
                                                <button type="button" wire:click="addDependentRow"
                                                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
                                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    Add Dependent
                                                </button>
                                            </div>

                                            <!-- Dependents Table -->
                                            <div class="overflow-x-auto">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead class="bg-gray-50">
                                                    <tr>
                                                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">First Name</th>
                                                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Middle Name</th>
                                                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Last Name</th>
                                                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sex</th>
                                                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Civil Status</th>
                                                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date of Birth</th>
                                                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Relationship</th>
                                                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Occupation</th>
                                                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monthly Income</th>
                                                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach($editDependents as $index => $dependent)
                                                        <tr>
                                                            <td class="px-2 py-2">
                                                                <input type="text"
                                                                       wire:model="editDependents.{{ $index }}.dependent_first_name"
                                                                       class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-custom-red focus:ring-custom-red">
                                                                @error("editDependents.$index.dependent_first_name")
                                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </td>
                                                            <td class="px-2 py-2">
                                                                <input type="text"
                                                                       wire:model="editDependents.{{ $index }}.dependent_middle_name"
                                                                       class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-custom-red focus:ring-custom-red">
                                                            </td>
                                                            <td class="px-2 py-2">
                                                                <input type="text"
                                                                       wire:model="editDependents.{{ $index }}.dependent_last_name"
                                                                       class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-custom-red focus:ring-custom-red">
                                                                @error("editDependents.$index.dependent_last_name")
                                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </td>
                                                            <td class="px-2 py-2">
                                                                <select wire:model="editDependents.{{ $index }}.dependent_sex"
                                                                        class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-custom-red focus:ring-custom-red">
                                                                    <option value="">Select</option>
                                                                    <option value="Male">Male</option>
                                                                    <option value="Female">Female</option>
                                                                </select>
                                                                @error("editDependents.$index.dependent_sex")
                                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </td>
                                                            <td class="px-2 py-2">
                                                                <select wire:model="editDependents.{{ $index }}.dependent_civil_status_id"
                                                                        class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-custom-red focus:ring-custom-red">
                                                                    <option value="">Select</option>
                                                                    @foreach($dependent_civilStatuses as $status)
                                                                        <option value="{{ $status->id }}">{{ $status->civil_status }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error("editDependents.$index.dependent_civil_status_id")
                                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </td>
                                                            <td class="px-2 py-2">
                                                                <input type="date"
                                                                       wire:model="editDependents.{{ $index }}.dependent_date_of_birth"
                                                                       class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-custom-red focus:ring-custom-red">
                                                                @error("editDependents.$index.dependent_date_of_birth")
                                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </td>
                                                            <td class="px-2 py-2">
                                                                <select wire:model="editDependents.{{ $index }}.dependent_relationship_id"
                                                                        class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-custom-red focus:ring-custom-red">
                                                                    <option value="">Select</option>
                                                                    @foreach($dependentRelationships as $relationship)
                                                                        <option value="{{ $relationship->id }}">{{ $relationship->relationship }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error("editDependents.$index.dependent_relationship_id")
                                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </td>
                                                            <td class="px-2 py-2">
                                                                <input type="text"
                                                                       wire:model="editDependents.{{ $index }}.dependent_occupation"
                                                                       class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-custom-red focus:ring-custom-red">
                                                                @error("editDependents.$index.dependent_occupation")
                                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </td>
                                                            <td class="px-2 py-2">
                                                                <input type="number"
                                                                       wire:model="editDependents.{{ $index }}.dependent_monthly_income"
                                                                       class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-custom-red focus:ring-custom-red">
                                                                @error("editDependents.$index.dependent_monthly_income")
                                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                                                @enderror
                                                            </td>
                                                            <td class="px-2 py-2">
                                                                <button type="button"
                                                                        wire:click.prevent="confirmDependentRemoval({{ $index }})"
                                                                        class="text-red-600 hover:text-red-900">
                                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button type="submit"
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                                                <span wire:loading.remove>
                                                    Save Changes
                                                </span>
                                                <span wire:loading class="flex items-center">
                                                    <svg class="animate-spin h-4 w-4 text-white mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                                    </svg>
                                                    Loading...
                                                </span>
                                            </button>
                                            <button type="button"
                                                    wire:click="$set('showDependentsModal', false)"
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-red sm:mt-0 sm:w-auto sm:text-sm">
                                                <span wire:loading.remove>
                                                    Cancel
                                                </span>
                                                <span wire:loading class="flex items-center">
                                                    <svg class="animate-spin h-4 w-4 text-white mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                                    </svg>
                                                    Loading...
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- Password Confirmation Modal -->
                <div class="modal" wire:model="confirmingDependentRemoval">
                    @if($confirmingDependentRemoval)
                        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                                <!-- Background overlay -->
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                                <!-- Modal panel -->
                                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                    <form wire:submit.prevent="removeDependentRow">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                </div>
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                                        Confirm Dependent Removal
                                                    </h3>
                                                    <div class="mt-2">
                                                        <p class="text-sm text-gray-500">
                                                            Please enter your password to confirm the removal of this dependent.
                                                        </p>
                                                        <div class="mt-4">
                                                            <input type="password"
                                                                   wire:model="passwordConfirmation"
                                                                   class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-custom-red focus:ring-custom-red"
                                                                   placeholder="Enter your password">
                                                            @error('passwordConfirmation')
                                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button type="submit"
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                Confirm Removal
                                            </button>
                                            <button type="button"
                                                    wire:click="cancelDependentRemoval"
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-red sm:mt-0 sm:w-auto sm:text-sm">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Living Situation Modal -->
                <div class="modal" wire:model="showLivingSituationModal">
                    @if($showLivingSituationModal)
                        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                                <!-- Background overlay -->
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                                <!-- Modal panel -->
                                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                                    <form wire:submit.prevent="updateLivingSituation"
                                          x-data="{
                                              livingStatus: @entangle('editLivingSituation.living_status'),
                                              livingSituationId: @entangle('editLivingSituation.living_situation_id')
                                          }">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="flex justify-between items-center pb-4 mb-4 border-b">
                                                <h3 class="text-lg font-semibold text-gray-900">Edit Living Situation</h3>
                                                <button type="button" wire:click="$set('showLivingSituationModal', false)" class="text-gray-400 hover:text-gray-500">
                                                    <span class="sr-only">Close</span>
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4">
                                                <!-- Date Tagged -->
                                                <div>
                                                    <label for="date_tagged" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Date Tagged
                                                    </label>
                                                    <input type="date" id="date_tagged"
                                                           wire:model="editLivingSituation.date_tagged"
                                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-red focus:ring-custom-red sm:text-sm"
                                                           readonly>
                                                </div>

                                                <!-- Living Situation (Case) -->
                                                <div>
                                                    <label for="living_situation_id" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Living Situation (Case)
                                                    </label>
                                                    <select id="living_situation_id"
                                                            wire:model="editLivingSituation.living_situation_id"
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-red focus:ring-custom-red sm:text-sm">
                                                        <option value="">Select Situation</option>
                                                        @foreach($livingSituations as $situation)
                                                            <option value="{{ $situation->id }}">{{ $situation->living_situation_description }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('editLivingSituation.living_situation_id')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <!-- Case Specification -->
                                                <div x-show="livingSituationId == 8">
                                                    <label for="case_specification_id" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Case Specification
                                                    </label>
                                                    <select id="case_specification_id"
                                                            wire:model="editLivingSituation.case_specification_id"
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-red focus:ring-custom-red sm:text-sm">
                                                        <option value="">Select Specification</option>
                                                        @foreach($caseSpecifications as $spec)
                                                            <option value="{{ $spec->id }}">{{ $spec->case_specification_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('editLivingSituation.case_specification_id')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <!-- Living Situation Case Specification -->
                                                <div x-show="livingSituationId != 8">
                                                    <label for="living_situation_case_specification" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Living Situation Case Specification
                                                    </label>
                                                    <textarea id="living_situation_case_specification"
                                                              wire:model="editLivingSituation.living_situation_case_specification"
                                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-red focus:ring-custom-red sm:text-sm"
                                                              rows="3"></textarea>
                                                    @error('editLivingSituation.living_situation_case_specification')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <!-- Social Welfare Sector -->
                                                <div>
                                                    <label for="social_welfare_sector" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Social Welfare Sector
                                                    </label>
                                                    <select id="social_welfare_sector"
                                                            wire:model="editLivingSituation.social_welfare_sector"
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-red focus:ring-custom-red sm:text-sm">
                                                        <option value="">Select Sector</option>
                                                        @foreach($governmentPrograms as $program)
                                                            <option value="{{ $program->id }}">{{ $program->program_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('editLivingSituation.social_welfare_sector')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <!-- Living Status -->
                                                <div>
                                                    <label for="living_status" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Living Status
                                                    </label>
                                                    <select id="living_status"
                                                            wire:model="editLivingSituation.living_status"
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-red focus:ring-custom-red sm:text-sm">
                                                        <option value="">Select Status</option>
                                                        @foreach($livingStatuses as $status)
                                                            <option value="{{ $status->id }}">{{ $status->living_status_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('editLivingSituation.living_status')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <!-- Room Rent Fields -->
                                                <template x-if="livingStatus == 1">
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                                Room Rent Fee <span class="text-red-500">*</span>
                                                            </label>
                                                            <input type="number"
                                                                   wire:model="editLivingSituation.room_rent_fee"
                                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-red focus:ring-custom-red sm:text-sm"
                                                                   min="0"
                                                                   step="0.01">
                                                            @error('editLivingSituation.room_rent_fee')
                                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                                Landlord <span class="text-red-500">*</span>
                                                            </label>
                                                            <input type="text"
                                                                   wire:model="editLivingSituation.room_landlord"
                                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-red focus:ring-custom-red sm:text-sm uppercase">
                                                            @error('editLivingSituation.room_landlord')
                                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </template>

                                                <!-- House Rent Fields -->
                                                <template x-if="livingStatus == 2">
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                                House Rent Fee <span class="text-red-500">*</span>
                                                            </label>
                                                            <input type="number"
                                                                   wire:model="editLivingSituation.house_rent_fee"
                                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-red focus:ring-custom-red sm:text-sm"
                                                                   min="0"
                                                                   step="0.01">
                                                            @error('editLivingSituation.house_rent_fee')
                                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                                Landlord <span class="text-red-500">*</span>
                                                            </label>
                                                            <input type="text"
                                                                   wire:model="editLivingSituation.house_landlord"
                                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-red focus:ring-custom-red sm:text-sm uppercase">
                                                            @error('editLivingSituation.house_landlord')
                                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </template>

                                                <!-- Lot Rent Fields -->
                                                <template x-if="livingStatus == 3">
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                                Lot Rent Fee <span class="text-red-500">*</span>
                                                            </label>
                                                            <input type="number"
                                                                   wire:model="editLivingSituation.lot_rent_fee"
                                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-red focus:ring-custom-red sm:text-sm"
                                                                   min="0"
                                                                   step="0.01">
                                                            @error('editLivingSituation.lot_rent_fee')
                                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                                Landlord <span class="text-red-500">*</span>
                                                            </label>
                                                            <input type="text"
                                                                   wire:model="editLivingSituation.lot_landlord"
                                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-red focus:ring-custom-red sm:text-sm uppercase">
                                                            @error('editLivingSituation.lot_landlord')
                                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </template>

                                                <!-- Living with Others Fields -->
                                                <template x-if="livingStatus == 8">
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                                House Owner Name <span class="text-red-500">*</span>
                                                            </label>
                                                            <input type="text"
                                                                   wire:model="editLivingSituation.house_owner"
                                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-red focus:ring-custom-red sm:text-sm uppercase">
                                                            @error('editLivingSituation.house_owner')
                                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                                Relationship <span class="text-red-500">*</span>
                                                            </label>
                                                            <input type="text"
                                                                   wire:model="editLivingSituation.relationship_to_house_owner"
                                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-red focus:ring-custom-red sm:text-sm uppercase">
                                                            @error('editLivingSituation.relationship_to_house_owner')
                                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </template>

                                                <!-- House Materials Section -->
                                                <div class="col-span-2 border-t pt-4 mt-4">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-3">House Materials</h4>
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <!-- Roof Type -->
                                                        <div>
                                                            <label for="roof_type" class="block text-sm font-medium text-gray-700 mb-1">
                                                                Roof Type
                                                            </label>
                                                            <select id="roof_type"
                                                                    wire:model="editLivingSituation.roof_type"
                                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-red focus:ring-custom-red sm:text-sm">
                                                                <option value="">Select Roof Type</option>
                                                                @foreach($roofTypes as $type)
                                                                    <option value="{{ $type->id }}">{{ $type->roof_type_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('editLivingSituation.roof_type')
                                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <!-- Wall Type -->
                                                        <div>
                                                            <label for="wall_type" class="block text-sm font-medium text-gray-700 mb-1">
                                                                Wall Type
                                                            </label>
                                                            <select id="wall_type"
                                                                    wire:model="editLivingSituation.wall_type"
                                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-red focus:ring-custom-red sm:text-sm">
                                                                <option value="">Select Wall Type</option>
                                                                @foreach($wallTypes as $type)
                                                                    <option value="{{ $type->id }}">{{ $type->wall_type_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('editLivingSituation.wall_type')
                                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Remarks -->
                                                <div class="col-span-2">
                                                    <label for="remarks" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Remarks
                                                    </label>
                                                    <textarea id="remarks"
                                                              wire:model="editLivingSituation.remarks"
                                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-custom-red focus:ring-custom-red sm:text-sm"
                                                              rows="3"></textarea>
                                                    @error('editLivingSituation.remarks')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button type="submit"
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-red sm:ml-3 sm:w-auto sm:text-sm">
                                                <span wire:loading.remove>
                                                    Save Changes
                                                </span>
                                                <span wire:loading class="flex items-center">
                                                    <svg class="animate-spin h-4 w-4 text-white mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                                    </svg>
                                                    Loading...
                                                </span>
                                            </button>
                                            <button type="button"
                                                    wire:click="$set('showLivingSituationModal', false)"
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-red sm:mt-0 sm:w-auto sm:text-sm">
                                                <span wire:loading.remove>
                                                    Cancel
                                                </span>
                                                <span wire:loading class="flex items-center">
                                                    <svg class="animate-spin h-4 w-4 text-white mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                                    </svg>
                                                    Loading...
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Photos Modal -->
                <div class="modal" wire:model="showPhotosModal">
                    @if($showPhotosModal)
                        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                                <!-- Background overlay -->
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                                <!-- Modal panel -->
                                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                                    <form wire:submit.prevent="updatePhotos">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="flex justify-between items-center pb-4 mb-4 border-b">
                                                <h3 class="text-lg font-semibold text-gray-900">Edit Photos</h3>
                                                <button type="button" wire:click="$set('showPhotosModal', false)" class="text-gray-400 hover:text-gray-500">
                                                    <span class="sr-only">Close</span>
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Current Photos -->
                                            <div class="mb-6">
                                                <h4 class="text-sm font-medium text-gray-700 mb-2">Current Photos</h4>
                                                <div class="grid grid-cols-3 gap-4">
                                                    @forelse($taggedDocuments as $document)
                                                        <div class="relative group">
                                                            <img src="{{ url('storage/tagging-house-structure-images/' . $document->file_path) }}"
                                                                 alt="{{ $document->file_name }}"
                                                                 class="w-full h-48 object-cover rounded-lg">
                                                            <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                                                <button type="button"
                                                                        wire:click="removePhoto({{ $document->id }})"
                                                                        class="text-white bg-red-600 hover:bg-red-700 rounded-full p-2">
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="col-span-3 text-center py-4 text-gray-500">
                                                            No photos available
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>

                                            <!-- Upload New Photos -->
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-700 mb-2">Upload New Photos</h4>
                                                <div class="mt-2"
                                                     x-data="{ isUploading: false, progress: 0 }"
                                                     x-on:livewire-upload-start="isUploading = true"
                                                     x-on:livewire-upload-finish="isUploading = false"
                                                     x-on:livewire-upload-error="isUploading = false"
                                                     x-on:livewire-upload-progress="progress = $event.detail.progress">

                                                    <!-- File Input -->
                                                    <div class="flex items-center justify-center w-full">
                                                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                                <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                                </svg>
                                                                <p class="mb-2 text-sm text-gray-500">
                                                                    <span class="font-semibold">Click to upload</span> or drag and drop
                                                                </p>
                                                                <p class="text-xs text-gray-500">PNG, JPG or JPEG (MAX. 2MB per file)</p>
                                                            </div>
                                                            <input id="dropzone-file"
                                                                   type="file"
                                                                   wire:model="newPhotos"
                                                                   class="hidden"
                                                                   multiple
                                                                   accept="image/*">
                                                        </label>
                                                    </div>

                                                    <!-- Upload Progress Bar -->
                                                    <div x-show="isUploading" class="mt-4">
                                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                            <div class="bg-blue-600 h-2.5 rounded-full"
                                                                 x-bind:style="'width: ' + progress + '%'"></div>
                                                        </div>
                                                        <div class="text-xs text-gray-500 mt-1" x-text="'Uploading: ' + progress + '%'"></div>
                                                    </div>

                                                    <!-- Preview Section -->
                                                    @if($newPhotos)
                                                        <div class="mt-4 grid grid-cols-3 gap-4">
                                                            @foreach($newPhotos as $photo)
                                                                <div class="relative">
                                                                    <img src="{{ $photo->temporaryUrl() }}"
                                                                         class="w-full h-48 object-cover rounded-lg">
                                                                    <button type="button"
                                                                            wire:click="removeNewPhoto({{ $loop->index }})"
                                                                            class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 hover:bg-red-700">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                    @error('newPhotos.*')
                                                    <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button type="submit"
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                <span wire:loading.remove>
                                                    Save Changes
                                                 </span>
                                                <span wire:loading class="flex items-center">
                                                    <svg class="animate-spin h-4 w-4 text-white mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                                    </svg>
                                                    Loading...
                                                </span>
                                            </button>
                                            <button type="button"
                                                    wire:click="$set('showPhotosModal', false)"
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-red sm:mt-0 sm:w-auto sm:text-sm">
                                                <span wire:loading.remove>
                                                    Cancel
                                                </span>
                                                <span wire:loading class="flex items-center">
                                                    <svg class="animate-spin h-4 w-4 text-white mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                                    </svg>
                                                    Loading...
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Component Template -->
    <div x-data="{ showModal: false }"
         x-show="showModal"
         x-on:open-modal.window="showModal = true"
         x-on:close-modal.window="showModal = false"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black opacity-50"></div>
            <div class="relative bg-white rounded-lg max-w-3xl w-full mx-auto">
                <div class="flex justify-between items-center p-4 border-b">
                    <h3 class="text-lg font-semibold" x-text="modalTitle"></h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="p-4">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('closeModal', function () {
                Alpine.dispatch('close-modal');
            });
        });
    </script>
@endpush
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

