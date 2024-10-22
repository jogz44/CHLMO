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
                    <div x-data="{ saved: false }" class="flex space-x-2 z-0">
                        <button
                            :disabled="!isEditable || saved"
                            class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white text-xs font-medium px-6 py-2 rounded"
                            @click="saved = true; message = 'Data has been saved successfully!'; isEditable = false">
                            TAG
                        </button>
                        <button
                            @click="window.location.href = '{{ route('shelter-transaction-applicants') }}'"
                            type="button"
                            class="bg-gray-600 hover:bg-gray-400 text-white text-xs font-medium px-6 py-2 rounded">
                            CANCEL
                        </button>
                    </div>
                </div>


                <div class="flex flex-col p-3 rounded mt-5">
                    <h2 class="text-[13px] ml-2 items-center font-bold text-gray-700">PERSONAL INFORMATION</h2>
                    <p class="text-[12px] ml-2 items-center text-gray-700">Encode here the personal information of the
                        Applicant from the form.</p>
                </div>


                <form>
                    <div class="bg-white p-6 rounded shadow mb-6">
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="first-name" class="block text-[13px] font-medium text-gray-700 mb-1">FIRST
                                    NAME</label>
                                <input type="text" id="first-name" name="first-name"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="middle-name" class="block text-[13px] font-medium text-gray-700 mb-1">MIDDLE
                                    NAME</label>
                                <input type="text" id="middle-name" name="middle-name"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="last-name" class="block text-[13px] font-medium text-gray-700 mb-1">LAST
                                    NAME</label>
                                <input type="text" id="last-name" name="last-name"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="name-suffix" class="block text-[13px] font-medium text-gray-700 mb-1">NAME
                                    SUFFIX</label>
                                <input type="text" id="name-suffix" name="name-suffix"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="origin-request"
                                    class="block text-[13px] font-medium text-gray-700 mb-1">ORIGIN OF REQUEST</label>
                                <select id="origin-request" name="origin-request" :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select Origin of Request</option>
                                    <option value="origin-request1">SPMO</option>
                                    <option value="origin-request2">CMO</option>
                                    <option value="origin-request3">Walkin</option>
                                    <option value="origin-request3">Walkin</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="requestDate" class="block text-[13px] font-medium text-gray-700 mb-1">REQUEST DATE</label>
                                <input type="date" id="requestDate" name="requestDate"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded shadow mb-6">
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="age" class="block text-[13px] font-medium text-gray-700 mb-1">AGE</label>
                                <input type="number" id="age" name="age"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="gender" class="block text-[13px] font-medium text-gray-700 mb-1">GENDER</label>
                                <select id="gender" name="gender"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select gender</option>
                                    <option value="purok1">Male</option>
                                    <option value="purok2">Female</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="tribe"
                                    class="block text-[13px] font-medium text-gray-700 mb-1">CIVIL STATUS</label>
                                <select id="tribe" name="tribe"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select Status</option>
                                    <option value="barangay1">Barangay 1</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="occupation"
                                    class="block text-[13px] font-medium text-gray-700 mb-1">OCCUPATION</label>
                                <input type="text" id="occupation" name="occupation"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spousename" class="block text-[13px] font-medium text-gray-700 mb-1">SPOUSE
                                    NAME</label>
                                <input type="text" id="spousename" name="spousename"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="years-residency"
                                    class="block text-[13px] font-medium text-gray-700 mb-1">YEARS OF RESIDENCY</label>
                                <input type="text" id="years-residency" name="years-residency"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-2">

                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="religion"
                                    class="block text-[13px] font-medium text-gray-700 mb-1">RELIGION</label>
                                <input type="text" id="religion" name="religion"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="tribe"
                                    class="block text-[13px] font-medium text-gray-700 mb-1">TRIBE/ETHNICITY</label>
                                <select id="tribe" name="tribe"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select tribe/ethnicity</option>
                                    <option value="barangay1">Barangay 1</option>
                                    <option value="barangay2">Barangay 2</option>
                                    <option value="barangay3">Barangay 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="contactNo" class="block text-[13px] font-medium text-gray-700 mb-1">CONTACT
                                    NUMBER</label>
                                <input type="number" id="contactNo" name="contactNo"

                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>


                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="barangay"
                                    class="block text-[13px] font-medium text-gray-700 mb-1">BARANGAY</label>
                                <select id="barangay" name="barangay"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select Barangay</option>
                                    <option value="barangay1">Barangay 1</option>
                                    <option value="barangay2">Barangay 2</option>
                                    <option value="barangay3">Barangay 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="purok" class="block text-[13px] font-medium text-gray-700 mb-1">PUROK</label>
                                <select id="purok" name="purok"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select Purok</option>
                                    <option value="purok1">Purok 1</option>
                                    <option value="purok2">Purok 2</option>
                                    <option value="purok3">Purok 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="houseNo"
                                    class="block text-[13px] font-medium text-gray-700 mb-1">HOUSE NO/STREET NAME</label>
                                <input type="text" id="houseNo" name="houseNo"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="govAssistance" class="block text-[13px] font-medium text-gray-700 mb-1">SOCIAL WELFARE SECTOR</label>
                                <select id="govAssistance" name="govAssistance"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select Type</option>
                                    <option value="barangay1">Barangay 1</option>
                                    <option value="barangay2">Barangay 2</option>
                                    <option value="barangay3">Barangay 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="livingStatus" class="block text-[13px] font-medium text-gray-700 mb-1">LIVING
                                    SITUATION</label>
                                <select id="livingStatus" name="livingStatus"
                                    class="uppercase w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select status</option>
                                    <option value="purok1">Purok 1</option>
                                    <option value="purok2">Purok 2</option>
                                    <option value="purok3">Purok 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="taggedDate" class="block text-[13px] font-medium text-gray-700 mb-1">DATE PROFILED/TAGGED</label>
                                <input type="date" id="taggedDate" name="taggedDate"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-full px-2 mb-4">
                                <label for="remarks"
                                    class="block text-[13px] font-medium text-gray-700 mb-1">REMARKS</label>
                                <input type="text" id="remarks" name="remarks"
                                    class="uppercase w-full p-3 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>

                        </div>

                    </div>


                </form>
            </form>
        </div>

    </div>
</div>