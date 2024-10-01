<x-app-layout>
    <div class="p-10 h-screen ml-[17%] mt-[60px]">
        <div class="flex bg-gray-100 text-[12px]">
            <div x-data="formHandler()" class="flex-1 p-6 overflow-auto">
                <div class="bg-white rounded shadow mb-4 flex items-center justify-between p-3 fixed top-[80px] left-[20%] right-[3%] z-0">
                    <div class="flex items-center">
                        <a href="{{ route('transaction-request') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                 stroke="currentColor" class="w-5 h-5 text-custom-yellow mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                        <h2 class="text-[13px] ml-2 items-center text-gray-700">Add New Affected Occupants</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design"
                         class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                    <div x-data="{ saved: false }" class="flex space-x-2 z-10">
                        <button type="submit" @click="saved = true"
                                class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white text-xs font-medium px-6 py-2 rounded">
                            ADD OCCUPANT
                        </button>
                        <button @click="resetForm;" type="button" class="bg-gray-700 text-white text-xs font-medium px-6 py-2 rounded">
                            CANCEL
                        </button>
                    </div>
                </div>


                <div class="flex flex-col p-3 rounded mt-4">
                    <h2 class="text-[13px] ml-2 items-center font-bold text-gray-700">PERSONAL INFORMATION</h2>
                    <p class="text-[12px] ml-2 items-center text-gray-700">Encode here the personal information of the
                        Applicant from the form.</p>
                </div>

                <div class="bg-white p-6 rounded shadow mb-6">
                    <form x-ref="form">
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="first-name" class="block text-[13px] font-medium text-gray-700 mb-1">FIRST
                                    NAME</label>
                                <input type="text" id="first-name" name="first-name" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:ring-1 focus:ring-custom-red">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="middle-name" class="block text-[13px] font-medium text-gray-700 mb-1">MIDDLE
                                    NAME</label>
                                <input type="text" id="middle-name" name="middle-name" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="last-name" class="block text-[13px] font-medium text-gray-700 mb-1">LAST
                                    NAME</label>
                                <input type="text" id="last-name" name="last-name" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="name-suffix" class="block text-[13px] font-medium text-gray-700 mb-1">NAME
                                    SUFFIX</label>
                                <input type="text" id="name-suffix" name="name-suffix" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
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
                                <select id="purok" name="purok"
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
                                <input type="number" id="contactNo" name="contactNo" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="tribe" class="block text-[13px] font-medium text-gray-700 mb-1">TRIBE/ETHNICITY</label>
                                <select id="tribe" name="tribe" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select tribe/ethnicity</option>
                                    <option value="barangay1">Barangay 1</option>
                                    <option value="barangay2">Barangay 2</option>
                                    <option value="barangay3">Barangay 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="gender" class="block text-[13px] font-medium text-gray-700 mb-1">GENDER</label>
                                <select id="gender" name="gender" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select gender</option>
                                    <option value="purok1">Male</option>
                                    <option value="purok2">Female</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="age" class="block text-[13px] font-medium text-gray-700 mb-1">AGE</label>
                                <input type="number" id="age" name="age" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="religion" class="block text-[13px] font-medium text-gray-700 mb-1">RELIGION</label>
                                <input type="text" id="religion" name="religion" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="occupation" class="block text-[13px] font-medium text-gray-700 mb-1">OCCUPATION</label>
                                <input type="text" id="occupation" name="occupation" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="monthlyincome" class="block text-[13px] font-medium text-gray-700 mb-1">MONTHLY
                                    INCOME</label>
                                <input type="text" id="monthlyincome" name="monthlyincome" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="familyincome" class="block text-[13px] font-medium text-gray-700 mb-1">FAMILY
                                    INCOME</label>
                                <input type="text" id="familyincome" name="familyincome" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>
                        <hr class="mt-2 mb-2 ">
                        <h2 class="block text-[13px] font-medium text-gray-700 mb-2">SPOUSE MAIDEN NAME</h2>
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spousefirstname" class="block text-[13px] font-medium text-gray-700 mb-1">
                                    FIRST NAME</label>
                                <input type="text" id="spousefirstname" name="spousefirstname" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spousemiddlename" class="block text-[13px] font-medium text-gray-700 mb-1">
                                    MIDDLE NAME</label>
                                <input type="text" id="spousemiddlename" name="spousemiddlename" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spouselastname" class="block text-[13px] font-medium text-gray-700 mb-1">
                                    LAST NAME</label>
                                <input type="text" id="spouselastname" name="spouselastname" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                           
                        </div>
                        <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spouse-occupation" class="block text-[13px] font-medium text-gray-700 mb-1">OCCUPATION</label>
                                <input type="text" id="spouse-occupation" name="spouse-occupation" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spouse-monthlyincome" class="block text-[13px] font-medium text-gray-700 mb-1">MONTHLY
                                    INCOME</label>
                                <input type="text" id="spouse-monthlyincome" name="spouse-monthlyincome" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
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
                            <div class="flex justify-end mt-2">
                                <button @click="addRow()" class="bg-green-500 text-white p-2 rounded-full shadow-lg hover:bg-green-600 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="bg-white p-6 rounded shadow mb-6">
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="awardDate" class="block text-[13px] font-medium text-gray-700 mb-1">AWARD
                                DATE
                            </label>
                            <input type="date" id="awardDate" name="awardDate" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="livingSituation" class="block text-[13px] font-medium text-gray-700 mb-1">LIVING
                                SITUATION (CASE)
                            </label>
                            <select id="livingSituation" name="livingSituation" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select situation</option>
                                <option value="barangay1">Barangay 1</option>
                                <option value="barangay2">Barangay 2</option>
                                <option value="barangay3">Barangay 3</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="caseSpecific" class="block text-[13px] font-medium text-gray-700 mb-1">CASE
                                SPECIFICATION
                            </label>
                            <select id="caseSpecific" name="caseSpecific" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
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
                                ASSISTANCE FROM THE GOVERNMENT
                            </label>
                            <select id="govAssistance" name="govAssistance" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select type of assistance</option>
                                <option value="barangay1">Barangay 1</option>
                                <option value="barangay2">Barangay 2</option>
                                <option value="barangay3">Barangay 3</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="livingStatus" class="block text-[13px] font-medium text-gray-700 mb-1">LIVING
                                STATUS</label>
                            <select id="livingStatus" name="livingStatus" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select status</option>
                                <option value="purok1">Purok 1</option>
                                <option value="purok2">Purok 2</option>
                                <option value="purok3">Purok 3</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="rent" class="block text-[13px] font-medium text-gray-700 mb-1">(if rent)</label>
                            <input type="number" id="rent" name="rent" placeholder="How much monthly?" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label class="block text-[13px] font-medium text-gray-700 mt-1 mb-1">HOUSE MATERIALS</label>
                            <label for="roof" class="block text-[13px] font-medium text-gray-700 mb-1">ROOF</label>
                            <select id="roof" name="roof" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select type of roof</option>
                                <option value="barangay1">Barangay 1</option>
                                <option value="barangay2">Barangay 2</option>
                                <option value="barangay3">Barangay 3</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="wall" class="block text-[13px] font-medium text-gray-700 mt-6 mb-1">WALL</label>
                            <select id="wall" name="wall" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select type of wall</option>
                                <option value="purok1">Purok 1</option>
                                <option value="purok2">Purok 2</option>
                                <option value="purok3">Purok 3</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4">
                            <label for="livingStatus" class="block text-[13px] font-medium mt-6 text-gray-700 mb-1">STATUS</label>
                            <select id="livingStatus" name="livingStatus" class="w-full p-1 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                <option value="">Select status</option>
                                <option value="purok1">Purok 1</option>
                                <option value="purok2">Purok 2</option>
                                <option value="purok3">Purok 3</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full md:w-full px-2 mb-4">
                            <label for="remarks" class="block text-[13px] font-medium text-gray-700 mb-1">REMARKS</label>
                            <input type="text" id="remarks" name="remarks" class="w-full p-3 border text-[13px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                        </div>
                    </div>
                </div>
                <script>
                    function formHandler() {
                        return {
                            addOccupant() {
                                // Handle add occupant logic here
                            },
                            resetForm() {
                                // Reset the form fields
                                this.$refs.form.reset();
                            }
                        }
                    }
                </script>
            </div>
        </div>
    </div>
</x-app-layout>