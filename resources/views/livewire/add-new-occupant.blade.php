<div class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <div class="flex-1 p-6 overflow-auto">
            <form wire:submit.prevent="store"
                  x-on:submit="console.log('Form submitted')">
                <div class="bg-white rounded shadow mb-4 flex items-center justify-between p-3 fixed top-[80px] left-[20%] right-[3%] z-0">
                    <div class="flex items-center">
                        <a href="javascript:void(0)" onclick="window.history.length > 1 ? history.back() : window.location.href='/transaction-request'">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                 stroke="currentColor" class="w-5 h-5 text-custom-yellow mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <h2 class="text-[13px] ml-2 items-center text-gray-700">ADD NEW OCCUPANT</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design"
                         class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                    <div x-data="{ saved: false }" class="flex space-x-2 z-10">
                        <button type="submit"
                                wire:loading.attr="disabled"
                                class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white text-xs font-medium px-6 py-2 rounded">
                            <span wire:loading.remove>
                                {{ $isTransfer ? 'SUBMIT TRANSFER' : 'SUBMIT NEW OCCUPANT' }}
                            </span>
                            <span wire:loading class="flex items-center">
                                <svg class="animate-spin h-4 w-4 text-white mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                                Processing...
                            </span>
                        </button>
                    </div>
                </div>

                @if($isTransfer && $previousAwardeeData)
                    <div class="flex flex-col p-3 rounded bg-gray-200 mt-16">
                        <h2 class="text-[13px] ml-2 items-center font-bold text-gray-700">PREVIOUS AWARDEE INFORMATION</h2>
                        <p class="text-[12px] ml-2 items-center text-gray-700">
                            <strong>Name:</strong> {{ $previousAwardeeData['previous_awardee_name'] ?? 'N/A' }}
                        </p>
                        <p class="text-[12px] ml-2 items-center text-gray-700">
                            <strong>Relocation Site:</strong> {{ $previousAwardeeData['relocation_site'] ?? 'N/A' }}
                        </p>
                        <p class="text-[12px] ml-2 items-center text-gray-700">
                            <strong>Block and Lot:</strong>
                            {{ $previousAwardeeData['block'] ?? 'N/A' }},
                            {{ $previousAwardeeData['lot'] ?? 'N/A' }}
                        </p>
                    </div>
                @endif

                <div class="flex flex-col p-3 rounded {{ $isTransfer ? 'mt-2' : 'mt-12' }}">
                    <h2 class="text-[13px] ml-2 items-center font-bold text-gray-700">PERSONAL INFORMATION</h2>
                    <p class="text-[12px] ml-2 items-center text-gray-700">Encode here the personal information of the new occupant.</p>
                </div>

                <div class="bg-white p-6 rounded shadow mb-6">
                    <div class="flex flex-wrap -mx-2">
                        <!-- FIRST NAME (required) -->
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label class="block text-[13px] font-medium text-gray-700 mb-1">
                                FIRST NAME <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="first_name"
                                   type="text"
                                   required
                                   placeholder="First name..."
                                   class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:ring-1 focus:ring-custom-red">
                        </div>
                        <!-- MIDDLE NAME (not required) -->
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="middle-name" class="block text-[13px] font-medium text-gray-700 mb-1">
                                MIDDLE NAME
                            </label>
                            <input wire:model="middle_name"
                                   type="text"
                                   placeholder="Middle name..."
                                   class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <!-- LAST NAME (required) -->
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="last-name" class="block text-[13px] font-medium text-gray-700 mb-1">
                                LAST NAME <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="last_name"
                                   type="text"
                                   required
                                   placeholder="Last name..."
                                   class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <!-- SUFFIX NAME (not required) -->
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="suffix-name" class="block text-[13px] font-medium text-gray-700 mb-1">
                                SUFFIX NAME
                            </label>
                            <input wire:model="suffix_name"
                                   type="text"
                                   placeholder="Suffix name..."
                                   class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
{{--                        <div class="w-full md:w-1/4 px-2 mb-4 {{ !$isTransfer ? 'hidden' : '' }}">--}}
{{--                            <label for="last-name" class="block text-[13px] font-medium text-gray-700 mb-1">--}}
{{--                                RELATIONSHIP TO THE AWARDEE <span class="text-red-500">*</span>--}}
{{--                            </label>--}}
{{--                            <input wire:model="relationship"--}}
{{--                                   type="text"--}}
{{--                                   required--}}
{{--                                   placeholder="Relationship"--}}
{{--                                   class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">--}}
{{--                        </div>--}}
{{--                        <div class="w-full md:w-1/4 px-2 mb-4 {{ !$isTransfer ? 'hidden' : '' }}">--}}
{{--                            <label for="reason_for_transfer" class="block text-[13px] font-medium text-gray-700 mb-1">--}}
{{--                                REASON FOR TRANSFER <span class="text-red-500">*</span>--}}
{{--                            </label>--}}
{{--                            <input wire:model="reason_for_transfer"--}}
{{--                                   type="text"--}}
{{--                                   required--}}
{{--                                   placeholder="Reason for transfer"--}}
{{--                                   class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">--}}
{{--                        </div>--}}
                        <!-- Transfer-specific fields -->
                        @if($isTransfer)
                            <div class="w-full flex flex-wrap -mx-2">
                                <!-- Relationship field -->
                                <div class="w-full md:w-1/4 px-2 mb-4">
                                    <label for="relationship" class="block text-[13px] font-medium text-gray-700 mb-1">
                                        RELATIONSHIP TO THE AWARDEE
                                    </label>
                                    <input wire:model="relationship"
                                           id="relationship"
                                           type="text"
                                           required
                                           placeholder="Relationship"
                                           class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>

                                <!-- Reason for transfer field -->
                                <div class="w-full md:w-1/4 px-2 mb-4">
                                    <label for="reason_for_transfer" class="block text-[13px] font-medium text-gray-700 mb-1">
                                        REASON FOR TRANSFER
                                    </label>
                                    <input wire:model="reason_for_transfer"
                                           id="reason_for_transfer"
                                           type="text"
                                           required
                                           placeholder="Reason for transfer"
                                           class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                </div>
                            </div>
                        @endif
                    </div>

                    <div x-data="{ civilStatus: '' }">
                        <div class="flex flex-wrap -mx-2">
                            <!-- BARANGAY (required) -->
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black">
                                    BARANGAY <span class="text-red-500">*</span>
                                </label>
                                <select wire:model.live="barangay_id"
                                        class="w-full px-3 py-1 text-[12px] select2-barangay bg-white border border-gray-300 rounded-lg text-gray-800 uppercase" required>
                                    <option value="">Select Barangay</option>
                                    @foreach($barangays as $barangay)
                                        <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                    @endforeach
                                </select>
                                @error('barangay_id') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <!-- PUROK (required) -->
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black">
                                    PUROK <span class="text-red-500">*</span>
                                </label>
                                <select wire:model.live="purok_id"
                                        class="w-full px-3 py-1 text-[12px] select2-purok bg-white border border-gray-300 rounded-lg focus:outline-none text-gray-800 uppercase" required>
                                    <option value="">Select Purok</option>
                                    @foreach($puroks as $purok)
                                        <option value="{{ $purok->id }}">{{ $purok->name }}</option>
                                    @endforeach
                                </select>
                                @error('purok_id') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <!-- FULL ADDRESS (not required) -->
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label class="block text-[12px] font-medium text-gray-700 mb-1">
                                    FULL ADDRESS
                                </label>
                                <input wire:model="full_address"
                                       type="text"
                                       placeholder="Full Address"
                                       class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow" oninput="capitalizeInput(this)">
                                @error('full_address') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                            <!-- Civil Status (required) -->
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label class="block text-[12px] font-medium text-gray-700 mb-1">
                                    CIVIL STATUS <span class="text-red-500">*</span>
                                </label>
                                <select x-model="civilStatus"
                                        wire:model="civil_status_id"
                                        class="w-full p-1 bg-white border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select Status</option>
                                    @foreach($civil_statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->civil_status }}</option>
                                    @endforeach
                                </select>
                                @error('civil_status_id') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <!-- Contact Number (required) -->
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label class="block text-[13px] font-medium text-gray-700 mb-1">
                                    CONTACT NUMBER <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="contact_number"
                                       type="text"
                                       pattern="^09\d{9}$"
                                       title="Enter a valid phone number (e.g., 09123456789)"
                                       maxlength="11"
                                       required
                                       class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       placeholder="09xxxxxxxxx"
                                       oninput="validateNumberInput(this)">
                            </div>
                            <!-- Tribe/Ethnicity (required) -->
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="tribe" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    TRIBE/ETHNICITY <small>(Put N/A if none)</small> <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="tribe"
                                       type="text"
                                       id="tribe"
                                       required
                                       placeholder="Tribe"
                                       class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow capitalize"
                                       oninput="capitalizeInput(this)">
                                @error('tribe') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                            <!-- Sex (required) -->
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
                            <!-- Date of birth -->
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
                            <!-- Occupation -->
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
                            <!-- Monthly Income -->
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="monthly_income" class="block text-[12px] font-semibold text-gray-700 mb-1">
                                    MONTHLY INCOME <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="monthly_income" wire:model="monthly_income"
                                       class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                       oninput="validateNumberInput(this)">
                                @error('monthly_income') <span class="text-red-600 error">{{ $message }}</span> @enderror
                            </div>
                            <!-- Length of Residency -->
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
                            <!-- Voters ID Number -->
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
                                    <!-- Partner's First Name -->
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
                                    <!-- Partner's Middle Name -->
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
                                    <!-- Partner's Last Name -->
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
                                    <!-- Partner's Occupation -->
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
                                    <!-- Partner's Monthly Income -->
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
                        <template x-if="livingSituation >= '1' && livingSituation <= '7'">
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
                        <template x-if="livingSituation == '9'">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="non_informal_settler_case_specification"
                                       class="block text-[13px] font-semibold text-gray-700 mb-1">
                                    NON-INFORMAL SETTLER CASE SPECIFICATION <span class="text-red-500">*</span>
                                </label>
                                <textarea wire:model="non_informal_settler_case_specification"
                                          type="text"
                                          id="non_informal_settler_case_specification"
                                          placeholder="Non Dwelling"
                                          class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow"
                                          required
                                          oninput="capitalizeInput(this)">
                                </textarea>
                                @error('non_informal_settler_case_specification') <span class="error text-red-600">{{ $message }}</span> @enderror
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
    <!-- Function to allow only numeric input -->
    function validateNumberInput(input) {
        // Remove any characters that are not digits
        input.value = input.value.replace(/[^0-9]/g, '');
    }
</script>