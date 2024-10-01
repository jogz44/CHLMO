<x-app-layout>
    <div class="p-10 h-screen ml-[17%] mt-[60px]">
        <div class="flex bg-gray-100 text-[12px]">
            <div x-data="{ isEditable: false }" class="flex-1 p-6 overflow-auto">
                <div x-data="{ openModalBlacklist: false }"
                    class="bg-white rounded shadow mb-4 flex items-center justify-between p-3 fixed top-[80px] left-[20%] right-[3%] z-50">
                    <div class="flex items-center">
                        <a href="{{ route('transaction-walkin') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-custom-yellow mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <h2 class="text-[13px] ml-2 items-center text-gray-700">Awardee Personal Information</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design"
                        class="absolute right-0 top-0 h-full object-cover opacity-10  0 z-0">
                    <div x-data="{ saved: false }" class="flex space-x-2 z-0">
                        <button
                            class="bg-custom-dark-green text-white text-xs font-medium px-6 py-2 rounded"
                            @click="openModalBlacklist = true">
                            BLACKLIST
                        </button>
                        <button
                            :disabled="!isEditable || saved"
                            class="bg-custom-yellow text-white text-xs font-medium px-6 py-2 rounded"
                            @click="saved = true; message = 'Data has been saved successfully!'; isEditable = false">
                            SAVE
                        </button>
                        <button
                            @click="isEditable = !isEditable"
                            type="button"
                            class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white text-xs font-medium px-6 py-2 rounded">
                            EDIT
                        </button>
                    </div>

                    <div x-show="openModalBlacklist" x-cloak
                        class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-40">
                        <!-- Modal -->
                        <div class="bg-white rounded-lg shadow-lg w-[400px] p-6 relative z-50"
                            @click.away="openModal = false">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-md font-semibold text-black " style="font-family:'Poppins', sans-serif;">
                                    BLACKLIST AWARDEE</h3>
                                <button @click="openModalBlacklist = false"
                                    class="text-red-500 hover:text-red-700 font-bold text-sm">&times;
                                </button>
                            </div>

                            <form>
                                <!-- Reason Field -->
                                <div class="mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-gray-700" for="reason">REASON
                                        BEING BLACKLISTED</label>
                                    <textarea id="reason" rows="4"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                        placeholder="Enter reason..."></textarea>
                                </div>

                                <!-- Updated By Field -->
                                <div class="mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-gray-700" for="updated-by">UPDATED
                                        BY</label>
                                    <input type="text" id="updated-by"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                        placeholder="Updated by...">
                                </div>

                                <!-- Buttons -->
                                <div class="flex justify-between items-center">
                                    <!-- Blacklist Button -->
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-[12px] text-white rounded-lg hover:bg-red-700">
                                        BLACKLIST
                                    </button>
                                    <!-- Cancel Button -->
                                    <button type="button" @click="openModalBlacklist = false"
                                        class="px-4 py-2 bg-gray-500 text-[12px] text-white rounded-lg hover:bg-gray-600">
                                        CANCEL
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>


                <div class="flex flex-col p-3 rounded">
                    <h2 class="text-[13px] ml-2 items-center font-bold text-gray-700">PERSONAL INFORMATION</h2>
                    <p class="text-[12px] ml-2 items-center text-gray-700">Encode here the personal information of the
                        Applicant from the form.</p>
                </div>

                <div class="bg-white p-6 rounded shadow mb-6">
                    <form>
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="first-name" class="block text-[13px] font-medium text-gray-700 mb-1">FIRST
                                    NAME</label>
                                <input type="text" id="first-name" name="first-name"
                                    :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="middle-name" class="block text-[13px] font-medium text-gray-700 mb-1">MIDDLE
                                    NAME</label>
                                <input type="text" id="middle-name" name="middle-name"
                                    :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="last-name" class="block text-[13px] font-medium text-gray-700 mb-1">LAST
                                    NAME</label>
                                <input type="text" id="last-name" name="last-name"
                                    :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="name-suffix" class="block text-[13px] font-medium text-gray-700 mb-1">NAME
                                    SUFFIX</label>
                                <input type="text" id="name-suffix" name="name-suffix"
                                    :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="barangay"
                                    class="block text-[13px] font-medium text-gray-700 mb-1">BARANGAY</label>
                                <select id="barangay" name="barangay" :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select Barangay</option>
                                    <option value="barangay1">Barangay 1</option>
                                    <option value="barangay2">Barangay 2</option>
                                    <option value="barangay3">Barangay 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="purok" class="block text-[13px] font-medium text-gray-700 mb-1">PUROK</label>
                                <select id="purok" name="purok" :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select Purok</option>
                                    <option value="purok1">Purok 1</option>
                                    <option value="purok2">Purok 2</option>
                                    <option value="purok3">Purok 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="specificaddress" class="block text-[13px] font-medium text-gray-700 mb-1">SPECIFIC ADDRESS</label>
                                <input type="text" id="specificaddress" name="specificaddress" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="civilstatus" class="block text-[13px] font-medium text-gray-700 mb-1">CIVIL STATUS</label>
                                <select id="civilstatus" name="civilstatus"
                                        class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select Status</option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="widow">Widow</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="contactNo" class="block text-[13px] font-medium text-gray-700 mb-1">CONTACT
                                    NUMBER</label>
                                <input type="number" id="contactNo" name="contactNo"
                                    :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="tribe"
                                    class="block text-[13px] font-medium text-gray-700 mb-1">TRIBE/ETHNICITY</label>
                                <select id="tribe" name="tribe" :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select tribe/ethnicity</option>
                                    <option value="barangay1">Barangay 1</option>
                                    <option value="barangay2">Barangay 2</option>
                                    <option value="barangay3">Barangay 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="gender" class="block text-[13px] font-medium text-gray-700 mb-1">GENDER</label>
                                <select id="gender" name="gender" :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select gender</option>
                                    <option value="purok1">Male</option>
                                    <option value="purok2">Female</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="age" class="block text-[13px] font-medium text-gray-700 mb-1">AGE</label>
                                <input type="number" id="age" name="age"
                                    :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="religion"
                                    class="block text-[13px] font-medium text-gray-700 mb-1">RELIGION</label>
                                <input type="text" id="religion" name="religion"
                                    :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="occupation"
                                    class="block text-[13px] font-medium text-gray-700 mb-1">OCCUPATION</label>
                                <input type="text" id="occupation" name="occupation"
                                    :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="monthlyincome" class="block text-[13px] font-medium text-gray-700 mb-1">MONTHLY
                                    INCOME</label>
                                <input type="text" id="monthlyincome" name="monthlyincome"
                                    :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="familyincome" class="block text-[13px] font-medium text-gray-700 mb-1">FAMILY
                                    INCOME</label>
                                <input type="text" id="familyincome" name="familyincome"
                                    :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>

                        <hr class="mt-2 mb-2 ">
                        <h2 class="block text-[13px] font-medium text-gray-700 mb-2">SPOUSE MAIDEN NAME</h2>
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spousename" class="block text-[13px] font-medium text-gray-700 mb-1">SPOUSE
                                    NAME</label>
                                <input type="text" id="spousename" name="spousename"
                                       :disabled="!isEditable"
                                       class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spouse-occupation" class="block text-[13px] font-medium text-gray-700 mb-1">OCCUPATION</label>
                                <input type="text" id="spouse-occupation" name="spouse-occupation"
                                    :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spouse-monthlyincome" class="block text-[13px] font-medium text-gray-700 mb-1">MONTHLY
                                    INCOME</label>
                                <input type="text" id="spouse-monthlyincome" name="spouse-monthlyincome"
                                    :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>

                        <div class="mt-6">
                            <h2 class="text-[13px] font-medium text-gray-700 mb-2">DEPENDENTS</h2>
                            <table class="w-full ">
                                <thead>
                                    <tr class="text-center border border-gray-700">
                                        <th class="p-2 border-b">Name</th>
                                        <th class="p-2 border-b">Civil Status</th>
                                        <th class="p-2 border-b">Age</th>
                                        <th class="p-2 border-b">Occupation</th>
                                        <th class="p-2 border-b">Monthly Income</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd:bg-custom-green/50 even:bg-transparent text-center "
                                        style="background-color: rgba(163, 214, 163, 0.5);">
                                        <td class="p-2 border-b" style="background-color: rgba(163, 214, 163, 0.5);">John Doe
                                        </td>
                                        <td class="p-2 border-b">Single</td>
                                        <td class="p-2 border-b">30</td>
                                        <td class="p-2 border-b">Engineer</td>
                                        <td class="p-2 border-b">$4000</td>
                                    </tr>
                                    <tr class="odd:bg-custom-green/50 even:bg-transparent text-center ">
                                        <td class="p-2 border-b" style="background-color: rgba(163, 214, 163, 0.5);">Jane
                                            Smith
                                        </td>
                                        <td class="p-2 border-b">Married</td>
                                        <td class="p-2 border-b">28</td>
                                        <td class="p-2 border-b">Doctor</td>
                                        <td class="p-2 border-b">$5000</td>
                                    </tr>
                                    <tr class="odd:bg-custom-green/50 even:bg-transparent text-center "
                                        style="background-color: rgba(163, 214, 163, 0.5);">
                                        <td class="p-2 border-b" style="background-color: rgba(163, 214, 163, 0.5);">Jane
                                            Smith
                                        </td>
                                        <td class="p-2 border-b">Married</td>
                                        <td class="p-2 border-b">28</td>
                                        <td class="p-2 border-b">Doctor</td>
                                        <td class="p-2 border-b">$5000</td>
                                    </tr>
                                    <tr class="odd:bg-custom-green/50 even:bg-transparent text-center ">
                                        <td class="p-2 border-b" style="background-color: rgba(163, 214, 163, 0.5);">John Doe
                                        </td>
                                        <td class="p-2 border-b">Single</td>
                                        <td class="p-2 border-b">30</td>
                                        <td class="p-2 border-b">Engineer</td>
                                        <td class="p-2 border-b">$4000</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                    </form>
                </div>

                <div class="bg-white p-6 rounded shadow mb-6">
                    <form>
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="awardDate" class="block text-[13px] font-medium text-gray-700 mb-1">AWARD
                                    DATE</label>
                                <input type="date" id="awardDate" name="awardDate"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="livingSituation" class="block text-[13px] font-medium text-gray-700 mb-1">LIVING
                                    SITUATION (CASE)</label>
                                <select id="livingSituation" name="livingSituation" :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select situation</option>
                                    <option value="barangay1">Barangay 1</option>
                                    <option value="barangay2">Barangay 2</option>
                                    <option value="barangay3">Barangay 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="caseSpecific" class="block text-[13px] font-medium text-gray-700 mb-1">CASE
                                    SPECIFICATION</label>
                                <select id="caseSpecific" name="caseSpecific" :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select specification</option>
                                    <option value="purok1">Purok 1</option>
                                    <option value="purok2">Purok 2</option>
                                    <option value="purok3">Purok 3</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="govAssistance" class="block text-[13px] font-medium text-gray-700 mb-1">RECIEVED
                                    ASSISTANCE FROM THE GOVERNMENT</label>
                                <select id="govAssistance" name="govAssistance" :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select type of assistance</option>
                                    <option value="barangay1">Barangay 1</option>
                                    <option value="barangay2">Barangay 2</option>
                                    <option value="barangay3">Barangay 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="livingStatus" class="block text-[13px] font-medium text-gray-700 mb-1">LIVING
                                    STATUS</label>
                                <select id="livingStatus" name="livingStatus" :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select status</option>
                                    <option value="purok1">Purok 1</option>
                                    <option value="purok2">Purok 2</option>
                                    <option value="purok3">Purok 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="rent" class="block text-[13px] font-medium text-gray-700 mb-1">(if rent)</label>
                                <input type="number" id="rent" name="rent"
                                    :disabled="!isEditable"
                                    placeholder="How much monthly?"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label class="block text-[13px] font-medium text-gray-700 mt-1 mb-1">HOUSE MATERIALS</label>
                                <label for="roof" class="block text-[13px] font-medium text-gray-700 mb-1">ROOF</label>
                                <select id="roof" name="roof" :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select type of roof</option>
                                    <option value="barangay1">Barangay 1</option>
                                    <option value="barangay2">Barangay 2</option>
                                    <option value="barangay3">Barangay 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="wall" class="block text-[13px] font-medium text-gray-700 mt-6 mb-1">WALL</label>
                                <select id="wall" name="wall" :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select type of wall</option>
                                    <option value="purok1">Purok 1</option>
                                    <option value="purok2">Purok 2</option>
                                    <option value="purok3">Purok 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="livingStatus" class="block text-[13px] font-medium mt-6 text-gray-700 mb-1">STATUS</label>
                                <select id="livingStatus" name="livingStatus" :disabled="!isEditable"
                                    class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select status</option>
                                    <option value="purok1">Purok 1</option>
                                    <option value="purok2">Purok 2</option>
                                    <option value="purok3">Purok 3</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-full px-2 mb-4">
                                <label for="remarks"
                                    class="block text-[13px] font-medium text-gray-700 mb-1">REMARKS</label>
                                <input type="text" id="remarks" name="remarks"
                                    :disabled="!isEditable"
                                    class="w-full p-3 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>

                        </div>
                    </form>
                </div>

                <div class="p-3 rounded">
                    <h2 class="text-[13px] ml-2 items-center font-bold text-gray-700">UPLOADED DOCUMENTS</h2>
                    <p class="text-[12px] ml-2 items-center text-gray-700">Upload here the captured requirements submitted
                        by the qualified applicants.</p>
                </div>
                <div x-data="fileUpload()" class="bg-white p-6 rounded shadow mb-6">
                    <!-- Form -->
                    <form @submit.prevent>
                        <div class="grid grid-cols-2 gap-2">
                            <!-- Drag and Drop Area -->
                            <div class="border-2 border-dashed border-green-500 rounded-lg p-4 flex flex-col items-center space-y-1">
                                <svg class="w-10 h-10 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 15a4 4 0 011-7.874V7a5 5 0 018.874-2.485A5.5 5.5 0 1118.5 15H5z" />
                                </svg>
                                <p class="text-gray-500 text-xs">DRAG AND DROP FILES</p>
                                <p class="text-gray-500 text-xs">or</p>
                                <button type="button"
                                    class="px-3 py-1 bg-green-600 text-white rounded-md text-xs hover:bg-green-700"
                                    @click="$refs.fileInput.click()">BROWSE FILES
                                </button>

                                <!-- Hidden File Input for Multiple Files -->
                                <input type="file" x-ref="fileInput" @change="addFiles($refs.fileInput.files)" multiple
                                    class="hidden" />
                            </div>

                            <!-- Show selected files and progress bars -->
                            <div class="w-full grid grid-cols-1 gap-2 border-2 border-dashed border-green-500 rounded-lg p-2">
                                <template x-for="(fileWrapper, index) in files" :key="index">
                                    <div @click="openPreviewModal = true; selectedFile = fileWrapper"
                                        class="bg-white p-2 shadow border-2 border-green-500 rounded-lg">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-orange-500" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 3v6h4l1 1h4V3H7z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 8v10h14V8H5z" />
                                                </svg>
                                                <span class="text-xs font-medium text-gray-700"
                                                    x-text="fileWrapper.displayName, selectedFile.displayName"></span>
                                            </div>
                                            <!-- Status -->
                                            <span class="text-xs text-green-500 font-medium">100%</span>
                                        </div>
                                        <!-- Progress Bar -->
                                        <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden cursor-pointer">
                                            <div class="w-full h-full bg-green-500"></div>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Preview Modal (Triggered by Clicking a Progress Bar) -->
                            <div x-show="openPreviewModal"
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 shadow-lg"
                                x-cloak>
                                <div class="bg-white w-[600px] rounded-lg shadow-lg p-6 relative">
                                    <!-- Modal Header with File Name -->
                                    <div class="flex justify-between items-center mb-4">
                                        <input type="text" x-model="selectedFile.displayName"
                                            class="text-[13px] w-[60%] font-regular text-black border-none focus:outline-none focus:ring-0">
                                        <button class="text-orange-500 underline text-sm" @click="renameFile()">Rename
                                            File
                                        </button>
                                        <button @click="openPreviewModal = false" class="text-gray-400 hover:text-gray-200">
                                            &times;
                                        </button>
                                    </div>

                                    <!-- Display Image -->
                                    <div class="flex justify-center mb-4">
                                        <img :src="selectedFile ? URL.createObjectURL(selectedFile.file) : '/path/to/default/image.jpg'"
                                            alt="Preview Image" class="w-full h-auto max-h-[60vh] object-contain">
                                    </div>
                                    <!-- Modal Buttons -->
                                    <div class="flex justify-between mt-4">
                                        <button class="px-4 py-2 bg-green-600 text-white rounded-lg"
                                            @click="openPreviewModal = false">CONFIRM
                                        </button>
                                        <button class="px-4 py-2 bg-red-600 text-white rounded-lg"
                                            @click="removeFile(selectedFile); openPreviewModal = false">REMOVE
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <script>
                    function fileUpload() {
                        return {
                            files: [],
                            selectedFile: null,
                            openPreviewModal: false,
                            addFiles(fileList) {
                                for (let i = 0; i < fileList.length; i++) {
                                    const file = fileList[i];
                                    this.files.push({
                                        file,
                                        displayName: file.name
                                    });
                                }
                            },
                            removeFile(fileWrapper) {
                                this.files = this.files.filter(f => f !== fileWrapper);
                            },
                            renameFile() {
                                if (this.selectedFile) {
                                    const newName = prompt('Rename File', this.selectedFile.displayName);
                                    if (newName) {
                                        this.selectedFile.displayName = newName;
                                        const fileIndex = this.files.findIndex(f => f === this.selectedFile);
                                        if (fileIndex > -1) {
                                            this.files[fileIndex].displayName = newName;
                                        }

                                    }
                                }
                            }
                        }
                    }
                </script>
            </div>
        </div>
    </div>
</x-app-layout>