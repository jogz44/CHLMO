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


            <form>
                <div class="bg-white p-6 rounded shadow mb-6">
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="first-name" class="block text-[12px] font-semibold text-gray-700 mb-1">FIRST
                                NAME</label>
                            <input type="text" id="first-name" name="first-name"
                                :disabled="!isEditable" wire:model="firstName"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            @error('firstName') <span class="text-red-600 error">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="middle-name" class="block text-[12px] font-medium text-gray-700 mb-1">MIDDLE
                                NAME</label>
                            <input type="text" id="middle-name" name="middle-name"
                                :disabled="!isEditable" wire:model="middleName"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/4 px-2 mb-4">
                            <label for="last-name" class="block text-[12px] font-medium text-gray-700 mb-1">LAST
                                NAME</label>
                            <input type="text" id="last-name" name="last-name"
                                :disabled="!isEditable" wire:model="lastName"
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
                            <input wire:model="originOfRequest" id="origin-request" name="origin-request"
                                class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow capitalize cursor-default" readonly>
                            @error('originOfRequest') <span class="text-red-600 error">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="requestDate" class="block text-[12px] font-medium text-gray-700 mb-1">REQUEST DATE</label>
                            <input type="date" id="requestDate" name="requestDate" :disabled="!isEditable" wire:model="requestDate"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded shadow mb-6">
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="age" class="block text-[12px] font-medium text-gray-700 mb-1">AGE</label>
                            <input type="number" id="age" name="age" :disabled="!isEditable" wire:model="age"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="gender" class="block text-[12px] font-medium text-gray-700 mb-1">GENDER</label>
                            <select id="gender" name="gender" :disabled="!isEditable"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select gender</option>
                                <option value="purok1">Male</option>
                                <option value="purok2">Female</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="tribe"
                                class="block text-[12px] font-medium text-gray-700 mb-1">CIVIL STATUS</label>
                            <select id="tribe" name="tribe" :disabled="!isEditable"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select Status</option>
                                <option value="barangay1">Barangay 1</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="occupation"
                                class="block text-[12px] font-medium text-gray-700 mb-1">OCCUPATION</label>
                            <input type="text" id="occupation" name="occupation" :disabled="!isEditable"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="spousename" class="block text-[12px] font-medium text-gray-700 mb-1">SPOUSE
                                NAME</label>
                            <input type="text" id="spousename" name="spousename" :disabled="!isEditable"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="years-residency"
                                class="block text-[12px] font-medium text-gray-700 mb-1">YEARS OF RESIDENCY</label>
                            <input type="text" id="years-residency" name="years-residency" :disabled="!isEditable"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-2">

                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="religion"
                                class="block text-[12px] font-medium text-gray-700 mb-1">RELIGION</label>
                            <input type="text" id="religion" name="religion" :disabled="!isEditable"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="tribe"
                                class="block text-[12px] font-medium text-gray-700 mb-1">TRIBE/ETHNICITY</label>
                            <select id="tribe" name="tribe" :disabled="!isEditable"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select tribe/ethnicity</option>
                                <option value="barangay1">Barangay 1</option>
                                <option value="barangay2">Barangay 2</option>
                                <option value="barangay3">Barangay 3</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="contactNo" class="block text-[12px] font-medium text-gray-700 mb-1">CONTACT
                                NUMBER</label>
                            <input type="number" id="contactNo" name="contactNo"
                                :disabled="!isEditable"
                                class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>


                    </div>

                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="barangay"
                                class="block text-[12px] font-medium text-gray-700 mb-1">BARANGAY</label>
                            <select id="barangay" name="barangay" :disabled="!isEditable"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select Barangay</option>
                                <option value="barangay1">Barangay 1</option>
                                <option value="barangay2">Barangay 2</option>
                                <option value="barangay3">Barangay 3</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="purok" class="block text-[12px] font-medium text-gray-700 mb-1">PUROK</label>
                            <select id="purok" name="purok" :disabled="!isEditable"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select Purok</option>
                                <option value="purok1">Purok 1</option>
                                <option value="purok2">Purok 2</option>
                                <option value="purok3">Purok 3</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="houseNo"
                                class="block text-[12px] font-medium text-gray-700 mb-1">HOUSE NO/STREET NAME</label>
                            <input type="text" id="houseNo" name="houseNo" :disabled="!isEditable"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="govAssistance" class="block text-[12px] font-medium text-gray-700 mb-1">SOCIAL WELFARE SECTOR</label>
                            <select id="govAssistance" name="govAssistance" :disabled="!isEditable"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select Type</option>
                                <option value="barangay1">Barangay 1</option>
                                <option value="barangay2">Barangay 2</option>
                                <option value="barangay3">Barangay 3</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="livingStatus" class="block text-[12px] font-medium text-gray-700 mb-1">LIVING
                                SITUATION</label>
                            <select id="livingStatus" name="livingStatus" :disabled="!isEditable"
                                class="uppercase w-full p-1 border-b text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select status</option>
                                <option value="purok1">Purok 1</option>
                                <option value="purok2">Purok 2</option>
                                <option value="purok3">Purok 3</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="taggedDate" class="block text-[12px] font-medium text-gray-700 mb-1">DATE PROFILED/TAGGED</label>
                            <input type="date" id="taggedDate" name="taggedDate" :disabled="!isEditable"
                                class="w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-full px-2 mb-4">
                            <label for="remarks"
                                class="block text-[12px] font-medium text-gray-700 mb-1">REMARKS</label>
                            <input type="text" id="remarks" name="remarks" :disabled="!isEditable"
                                class="uppercase w-full p-3 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
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