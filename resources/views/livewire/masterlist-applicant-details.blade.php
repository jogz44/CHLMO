<div>
    <div class="p-10 h-screen ml-[17%] mt-[60px]">
        <div class="flex bg-gray-100 text-[12px]">
            <div x-data="{ isEditable: false }" class="flex-1 p-6 overflow-auto">
                <div class="bg-white rounded shadow mb-4 flex items-center justify-between p-3 fixed top-[80px] left-[20%] right-[3%] z-0  ">
                    <div class="flex items-center">
                        <a href="{{ route('masterlist-applicants') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                 stroke="currentColor" class="w-5 h-5 text-custom-yellow mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                        <h2 class="text-[13px] ml-2 items-center text-gray-700">Applicant Details</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design"
                         class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
{{--                    <div x-data="{ saved: false }" class="flex space-x-2 z-0">--}}
{{--                        <button--}}
{{--                                :disabled="!isEditable || saved"--}}
{{--                                class="bg-custom-yellow text-white text-xs font-medium px-6 py-2 rounded"--}}
{{--                                @click="saved = true; message = 'Data has been saved successfully!'; isEditable = false">--}}
{{--                            SAVE--}}
{{--                        </button>--}}
{{--                        <button--}}
{{--                                @click="isEditable = !isEditable"--}}
{{--                                type="button"--}}
{{--                                class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white text-xs font-medium px-6 py-2 rounded">--}}
{{--                            EDIT--}}
{{--                        </button>--}}
{{--                    </div>--}}
                </div>

                <div class="flex flex-col p-3 rounded mt-11">
                    <h2 class="text-[30px] items-center font-bold text-gray-700 underline"> {{ $applicant->applicant_id }}</h2>
                    <h1 class="text-[25px] items-center font-bold text-gray-700">
                        {{ $people->first_name }}
                        @if($people->middle_name) {{ substr($people->middle_name, 0, 1) }}. @endif
                        {{ $people->last_name }}
                        {{ $people->suffix_name }}
                    </h1>
                </div>

                <div class="bg-white p-6 rounded shadow mb-6">
                    <form>
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="first-name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    FIRST NAME</label>
                                <input wire:model="first_name" type="text" id="first-name" name="first-name"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                @error('first_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="middle-name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    MIDDLE NAME</label>
                                <input wire:model="middle_name" type="text" id="middle-name" name="middle-name"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                @error('middle_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="last-name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    LAST NAME</label>
                                <input wire:model="last_name" type="text" id="last-name" name="last-name"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                @error('last_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="suffix-name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    SUFFIX NAME</label>
                                <input wire:model="suffix_name" type="text" id="suffix-name" name="suffix-name"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                @error('suffix_name') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="barangay" class="block text-[12px] font-semibold text-gray-700 mb-1">BARANGAY</label>
                                <input wire:model="barangay" id="barangay" name="barangay" :disabled="!isEditable"
                                        class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                @error('barangay') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="purok" class="block text-[12px] font-semibold text-gray-700 mb-1">PUROK</label>
                                <input wire:model="purok" id="purok" name="purok" :disabled="!isEditable"
                                        class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                @error('purok') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="full_address" class="block text-[12px] font-semibold text-gray-700 mb-1">FULL ADDRESS</label>
                                <input wire:model="full_address" type="text" id="full_address" name="full_address"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                @error('full_address') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="civilstatus" class="block text-[12px] font-semibold text-gray-700 mb-1">CIVIL STATUS</label>
                                <input wire:model="civil_status" id="civilstatus" name="civilstatus"
                                        :disabled="!isEditable"
                                        class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="contact_number" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    CONTACT NUMBER</label>
                                <input wire:model="contact_number" type="contact_number" id="contact_number" name="contact_number"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                @error('contact_number') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="tribe"
                                       class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    TRIBE/ETHNICITY</label>
                                <input wire:model="tribe" id="tribe" name="tribe" :disabled="!isEditable"
                                        class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </input>
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="sex" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    SEX</label>
                                <input wire:model="sex" id="sex" name="sex" :disabled="!isEditable"
                                        class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="date_of_birth" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    DATE OF BIRTH</label>
                                <input wire:model="date_of_birth" type="text" id="date_of_birth" name="date_of_birth"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="religion"
                                       class="block text-[12px] font-semibold text-gray-700 mb-1">RELIGION</label>
                                <input wire:model="religion" type="text" id="religion" name="religion"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="occupation"
                                       class="block text-[12px] font-semibold text-gray-700 mb-1">OCCUPATION</label>
                                <input wire:model="occupation" type="text" id="occupation" name="occupation"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="monthlyIncome" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    MONTHLY INCOME</label>
                                <input wire:model="monthly_income" type="text" id="monthlyIncome" name="monthlyIncome"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="familyIncome" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    FAMILY INCOME</label>
                                <input wire:model="family_income" type="text" id="familyIncome" name="familyIncome"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>

                        <h2 class="block text-[16px] font-semibold text-gray-700 mb-2 mt-2">PARTNER'S MAIDEN NAME</h2>
                        <hr class="mb-2">
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="partner_first_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    FIRST NAME</label>
                                <input wire:model="partner_first_name"
                                       type="text"
                                       id="partner_first_name"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="partner_middle_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    MIDDLE NAME</label>
                                <input wire:model="partner_middle_name"
                                       type="text"
                                       id="partner_middle_name"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="partner_last_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    LAST NAME</label>
                                <input wire:model="partner_last_name"
                                       type="text"
                                       id="partner_last_name"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="partner-occupation" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    OCCUPATION
                                </label>
                                <input wire:model="partner_occupation"
                                       type="text"
                                       id="partner_occupation"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="partner_monthly_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    MONTHLY INCOME</label>
                                <input wire:model="partner_monthly_income"
                                       type="text"
                                       id="partner_monthly_income"
                                       name="partner_monthly_income"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>

                        <h2 class="block text-[16px] font-semibold text-gray-700 mb-2 mt-4">SPOUSE MAIDEN NAME</h2>
                        <hr class="mb-2">
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spouse_first_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    FIRST NAME</label>
                                <input wire:model="spouse_first_name" type="text" id="spouse_first_name" name="spouse_first_name"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spouse_middle_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    MIDDLE NAME</label>
                                <input wire:model="spouse_middle_name" type="text" id="spouse_middle_name" name="spouse_middle_name"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spouse_last_name" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    LAST NAME</label>
                                <input wire:model="spouse_last_name" type="text" id="spouse_last_name" name="spouse_last_name"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spouse-occupation" class="block text-[12px] font-semibold text-gray-700 mb-1">OCCUPATION</label>
                                <input wire:model="spouse_occupation" type="text" id="spouse-occupation" name="spouse-occupation"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spouse-monthlyincome" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    MONTHLY INCOME</label>
                                <input wire:model="spouse_monthly_income" type="text" id="spouse-monthlyincome" name="spouse-monthlyincome"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>

                        <div class="mt-6">
                            <div class="flex justify-between">
                                <div class="mt-4 flex justify-start">
                                    <h2 class="text-[12px] font-medium text-gray-700 mb-2">DEPENDENTS</h2>
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
                                @foreach($dependents as $dependent)
                                    <tr class="odd:bg-custom-green-light even:bg-transparent text-center">
                                        <td class="border px-4 py-2">{{ $dependent->dependent_first_name }}</td>
                                        <td class="border px-4 py-2">{{ $dependent->dependent_middle_name }}</td>
                                        <td class="border px-4 py-2">{{ $dependent->dependent_last_name }}</td>
                                        <td class="border px-4 py-2">{{ $dependent->dependent_sex }}</td>
                                        <td class="border px-1 py-2">{{ $dependent->civilStatus?->civil_status ?? 'N/A' }}</td>
                                        <td class="border px-4 py-2">{{ $dependent->dependent_date_of_birth ? date('M d, Y', strtotime($dependent->dependent_date_of_birth)) : 'N/A' }}</td>
                                        <td class="border px-4 py-2">{{ $dependent->dependent_relationship }}</td>
                                        <td class="border px-4 py-2">{{ $dependent->dependent_occupation }}</td>
                                        <td class="border px-4 py-2">{{ $dependent->dependent_monthly_income }}</td>
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
                                <label for="ldate_applied" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    DATE APPLIED</label>
                                <input wire:model="date_applied" type="text" id="date_applied" name="date_applied" :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-4/12 px-2 mb-4">
                                <label for="date_tagged" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    DATE TAGGED</label>
                                <input wire:model="tagging_date" type="text" id="date_tagged" name="date_tagged" :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-4/12 px-2 mb-4">
                                <label for="awarding_date" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    DATE AWARDED</label>
                                <input wire:model="awarding_date" type="text" id="awarding_date" name="awarding_date" :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-4/12 px-2 mb-4">
                                <label for="livingSituation" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    LIVING SITUATION (CASE)</label>
                                <textarea wire:model="living_situation" rows="2" id="livingSituation" name="livingSituation" :disabled="!isEditable"
                                        class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </textarea>
                            </div>
                            <div class="w-full md:w-4/12 px-2 mb-4">
                                <label for="caseSpecific" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    CASE SPECIFICATION</label>
                                <textarea wire:model="case_specification" rows="2" id="caseSpecific" name="caseSpecific" :disabled="!isEditable"
                                        class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </textarea>
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="govAssistance" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    SOCIAL WELFARE SECTOR
                                </label>
                                <input wire:model="government_program" type="text" id="govAssistance" name="govAssistance" :disabled="!isEditable"
                                        class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="livingStatus" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    LIVING STATUS</label>
                                <textarea wire:model="living_status" rows="2" id="livingStatus" name="livingStatus" :disabled="!isEditable"
                                        class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </textarea>
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="rent" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    MONTHLY RENT FEE <small class="text-red-500">(if rent)</small>
                                </label>
                                <input wire:model="rent_fee" type="text" id="rent" name="rent"
                                       :disabled="!isEditable"
                                       class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <h2 class="block text-[16px] font-semibold text-gray-700 mb-2 mt-2">HOUSE MATERIALS</h2>
                                <hr class="mb-2">
                                <label for="roof" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    ROOF
                                </label>
                                <input wire:model="roof_type" type="text" id="roof" name="roof" :disabled="!isEditable"
                                        class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4 mt-6">
                                <label for="wall" class="block text-[12px] font-semibold text-gray-700 mt-6 mb-1">
                                    WALL
                                </label>
                                <input wire:model="wall_type" type="text" id="wall" name="wall" :disabled="!isEditable"
                                        class="capitalize w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <!-- TODO - update this when you updated the adding of applicants to add a dropdown of transaction type -->
                            <div class="w-full md:w-1/3 px-2 mb-4 mt-5">
                                <label for="livingStatus" class="block text-[13px] font-semibold mt-6 text-gray-700 mb-1">
                                    TRANSACTION TYPE
                                </label>
                                <input wire:model="transaction_type" type="text" id="livingStatus" :disabled="!isEditable"
                                        class="capitalize w-full p-1 border-b text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-full px-2 mb-4">
                                <label for="remarks"
                                       class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    REMARKS
                                </label>
                                <input wire:model="remarks" type="text" id="remarks" name="remarks"
                                       :disabled="!isEditable"
                                       class="capitalize italic w-full p-3 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
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
                </div>

                <div class="p-3 rounded">
                    <h2 class="text-[12px] ml-2 items-center font-bold text-gray-700">UPLOADED REQUIREMENT DURING AWARDING</h2>
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
                                        loading="lazy"
                                >
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
        </div>
    </div>
</div>
