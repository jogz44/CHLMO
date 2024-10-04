<x-app-layout>
    <div class="p-10 h-screen ml-[17%] mt-[60px]">
        <div x-data="{ openModalBlacklist: false }" class="flex bg-gray-100 text-[12px]">
            <div x-data="{ isEditable: false }" class="flex-1 p-6 overflow-auto">

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
                </div>


                <div class="flex flex-col p-3 rounded mt-4">
                    <h2 class="text-[13px] ml-2 items-center font-bold text-gray-700">PERSONAL INFORMATION</h2>
                    <p class="text-[12px] ml-2 items-center text-gray-700">Encoded personal information of the
                        Awardee from the form.</p>
                </div>

                <div class="bg-white p-6 rounded shadow mb-6">
                    <form>
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="first-name" class="block text-[12px] font-medium text-gray-700 mb-1">FIRST
                                    NAME</label>
                                <input type="text" id="first-name" name="first-name"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="middle-name" class="block text-[12px] font-medium text-gray-700 mb-1">MIDDLE
                                    NAME</label>
                                <input type="text" id="middle-name" name="middle-name"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="last-name" class="block text-[12px] font-medium text-gray-700 mb-1">LAST
                                    NAME</label>
                                <input type="text" id="last-name" name="last-name"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="name-suffix" class="block text-[12px] font-medium text-gray-700 mb-1">NAME
                                    SUFFIX</label>
                                <input type="text" id="name-suffix" name="name-suffix"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="barangay"
                                    class="block text-[12px] font-medium text-gray-700 mb-1">BARANGAY</label>
                                <select id="barangay" name="barangay" :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select Barangay</option>
                                    <option value="barangay1">Barangay 1</option>
                                    <option value="barangay2">Barangay 2</option>
                                    <option value="barangay3">Barangay 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="purok" class="block text-[12px] font-medium text-gray-700 mb-1">PUROK</label>
                                <select id="purok" name="purok" :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select Purok</option>
                                    <option value="purok1">Purok 1</option>
                                    <option value="purok2">Purok 2</option>
                                    <option value="purok3">Purok 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="specificaddress" class="block text-[12px] font-medium text-gray-700 mb-1">SPECIFIC ADDRESS</label>
                                <input type="text" id="specificaddress" name="specificaddress"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="civilstatus" class="block text-[12px] font-medium text-gray-700 mb-1">CIVIL STATUS</label>
                                <select id="civilstatus" name="civilstatus"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select Status</option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="widow">Widow</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="contactNo" class="block text-[12px] font-medium text-gray-700 mb-1">CONTACT
                                    NUMBER</label>
                                <input type="number" id="contactNo" name="contactNo"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="tribe"
                                    class="block text-[12px] font-medium text-gray-700 mb-1">TRIBE/ETHNICITY</label>
                                <select id="tribe" name="tribe" :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select tribe/ethnicity</option>
                                    <option value="barangay1">Barangay 1</option>
                                    <option value="barangay2">Barangay 2</option>
                                    <option value="barangay3">Barangay 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="sex" class="block text-[12px] font-medium text-gray-700 mb-1">SEX</label>
                                <select id="sex" name="sex" :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select sex</option>
                                    <option value="purok1">Male</option>
                                    <option value="purok2">Female</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="age" class="block text-[12px] font-medium text-gray-700 mb-1">AGE</label>
                                <input type="number" id="age" name="age"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="religion"
                                    class="block text-[12px] font-medium text-gray-700 mb-1">RELIGION</label>
                                <input type="text" id="religion" name="religion"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="occupation"
                                    class="block text-[12px] font-medium text-gray-700 mb-1">OCCUPATION</label>
                                <input type="text" id="occupation" name="occupation"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="monthlyincome" class="block text-[12px] font-medium text-gray-700 mb-1">MONTHLY
                                    INCOME</label>
                                <input type="text" id="monthlyincome" name="monthlyincome"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/4 px-2 mb-4">
                                <label for="familyincome" class="block text-[12px] font-medium text-gray-700 mb-1">FAMILY
                                    INCOME</label>
                                <input type="text" id="familyincome" name="familyincome"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>

                        <hr class="mt-2 mb-2 ">
                        <h2 class="block text-[12px] font-medium text-gray-700 mb-2">SPOUSE MAIDEN NAME</h2>
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spousefirstname" class="block text-[12px] font-medium text-gray-700 mb-1">
                                    FIRST NAME</label>
                                <input type="text" id="spousefirstname" name="spousefirstname"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spousemiddlename" class="block text-[12px] font-medium text-gray-700 mb-1">
                                    MIDDLE NAME</label>
                                <input type="text" id="spousemiddlename" name="spousemiddlename"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spouselastname" class="block text-[12px] font-medium text-gray-700 mb-1">
                                    LAST NAME</label>
                                <input type="text" id="spouselastname" name="spouselastname"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spouse-occupation" class="block text-[12px] font-medium text-gray-700 mb-1">OCCUPATION</label>
                                <input type="text" id="spouse-occupation" name="spouse-occupation"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="spouse-monthlyincome" class="block text-[12px] font-medium text-gray-700 mb-1">MONTHLY
                                    INCOME</label>
                                <input type="text" id="spouse-monthlyincome" name="spouse-monthlyincome"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>

                        <div x-data="{ 
                            rows: [
                                { name: 'Anton Corporal', civilStatus: 'Married', age: '32', occupation: 'Medical Doctor', monthlyIncome: '20000', relationship: 'Husband' },
                            ], 
                            addRow() {
                                this.rows.push({ name: '', civilStatus: '', age: '', occupation: '', monthlyIncome: '', relationship: '' });
                            } 
                        }"
                            class="mt-6">

                            <h2 class="text-[12px] font-medium text-gray-700 mb-2">DEPENDENTS</h2>
                            <table class="w-full">
                                <thead>
                                    <tr class="text-center border border-gray-700">
                                        <th class="p-2 border-b">Name</th>
                                        <th class="p-2 border-b">Civil Status</th>
                                        <th class="p-2 border-b">Age</th>
                                        <th class="p-2 border-b">Occupation</th>
                                        <th class="p-2 border-b">Monthly Income</th>
                                        <th class="p-2 border-b">Relationship</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(row, index) in rows" :key="index">
                                        <tr class="odd:bg-custom-green-light even:bg-transparent text-center">
                                            <td class="border px-4 py-2" style="background-color: rgba(163, 214, 163, 0.5);">
                                                <input type="text" x-model="row.name"
                                                    class="uppercase w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]">
                                            </td>
                                            <td class="border px-4 py-2">
                                                <input type="text" x-model="row.civilStatus"
                                                    class="uppercase w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]">
                                            </td>
                                            <td class="border px-4 py-2">
                                                <input type="text" x-model="row.age"
                                                    class="uppercase w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]">
                                            </td>
                                            <td class="border px-4 py-2">
                                                <input type="text" x-model="row.occupation"
                                                    class="uppercase w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]">
                                            </td>
                                            <td class="border px-4 py-2">
                                                <input type="text" x-model="row.monthlyIncome"
                                                    class="uppercase w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]">
                                            </td>
                                            <td class="border px-4 py-2">
                                                <input type="text" x-model="row.relationship"
                                                    class="uppercase w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]">
                                            </td>
                                            <td class="border px-4 py-2">
                                                <button @click.prevent="rows.splice(index, 1)" type="button"
                                                    :disabled="!isEditable"
                                                    class="text-red-500 hover:text-red-700 text-[14px]">
                                                    ✕
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>

                            <!-- Add Row Button -->
                            <div class="flex justify-end mb-4 mt-4">
                                <button @click.prevent="addRow()" type="button" :disabled="!isEditable"
                                    class="text-white bg-green-500 hover:bg-green-600 text-[12px] px-2 py-2 rounded-md flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-5 h-5 mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Add Row
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="bg-white p-6 rounded shadow mb-6">
                    <form>

                        <h2 class="block text-[12px] font-medium text-gray-700 mb-2">PREVIOUS AWARDEE NAME</h2>
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="prevfirstname" class="block text-[12px] font-medium text-gray-700 mb-1">
                                    FIRST NAME</label>
                                <input type="text" id="prevfirstname" name="prevfirstname"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="prevmiddlename" class="block text-[12px] font-medium text-gray-700 mb-1">
                                    MIDDLE NAME</label>
                                <input type="text" id="prevmiddlename" name="prevmiddlename"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="prevlastname" class="block text-[12px] font-medium text-gray-700 mb-1">
                                    LAST NAME</label>
                                <input type="text" id="prevlastname" name="prevlastname"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>

                        </div>
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="taggedDate" class="block text-[12px] font-medium text-gray-700 mb-1">TRANSFERED
                                    DATE</label>
                                <input type="date" id="taggedDate" name="taggedDate"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="bg-white p-6 rounded shadow mb-6">
                    <form>
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-2/12 px-2 mb-4">
                                <label for="taggedDate" class="block text-[12px] font-medium text-gray-700 mb-1">TAGGED
                                    DATE</label>
                                <input type="date" id="taggedDate" name="taggedDate"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-2/12 px-2 mb-4">
                                <label for="awardDate" class="block text-[12px] font-medium text-gray-700 mb-1">AWARDED
                                    DATE</label>
                                <input type="date" id="awardDate" name="awardDate"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                            <div class="w-full md:w-4/12 px-2 mb-4">
                                <label for="livingSituation" class="block text-[12px] font-medium text-gray-700 mb-1">LIVING
                                    SITUATION (CASE)</label>
                                <select id="livingSituation" name="livingSituation" :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select situation</option>
                                    <option value="barangay1">Barangay 1</option>
                                    <option value="barangay2">Barangay 2</option>
                                    <option value="barangay3">Barangay 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-4/12 px-2 mb-4">
                                <label for="caseSpecific" class="block text-[12px] font-medium text-gray-700 mb-1">CASE
                                    SPECIFICATION</label>
                                <select id="caseSpecific" name="caseSpecific" :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select specification</option>
                                    <option value="purok1">Purok 1</option>
                                    <option value="purok2">Purok 2</option>
                                    <option value="purok3">Purok 3</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="govAssistance" class="block text-[12px] font-medium text-gray-700 mb-1">SOCIAL WELFARE SECTOR</label>
                                <select id="govAssistance" name="govAssistance" :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select type of assistance</option>
                                    <option value="barangay1">Barangay 1</option>
                                    <option value="barangay2">Barangay 2</option>
                                    <option value="barangay3">Barangay 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="livingStatus" class="block text-[12px] font-medium text-gray-700 mb-1">LIVING
                                    STATUS</label>
                                <select id="livingStatus" name="livingStatus" :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select status</option>
                                    <option value="purok1">Purok 1</option>
                                    <option value="purok2">Purok 2</option>
                                    <option value="purok3">Purok 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="rent" class="block text-[12px] font-medium text-gray-700 mb-1">(if rent)</label>
                                <input type="number" id="rent" name="rent"
                                    :disabled="!isEditable"
                                    placeholder="How much monthly?"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label class="block text-[12px] font-medium text-gray-700 mt-1 mb-1">HOUSE MATERIALS</label>
                                <label for="roof" class="block text-[12px] font-medium text-gray-700 mb-1">ROOF</label>
                                <select id="roof" name="roof" :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select type of roof</option>
                                    <option value="barangay1">Barangay 1</option>
                                    <option value="barangay2">Barangay 2</option>
                                    <option value="barangay3">Barangay 3</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/3 px-2 mb-4">
                                <label for="wall" class="block text-[12px] font-medium text-gray-700 mt-6 mb-1">WALL</label>
                                <select id="wall" name="wall" :disabled="!isEditable"
                                    class="uppercase w-full p-1 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
                                    <option value="">Select type of wall</option>
                                    <option value="purok1">Purok 1</option>
                                    <option value="purok2">Purok 2</option>
                                    <option value="purok3">Purok 3</option>
                                </select>
                            </div>
                        </div>


                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-full px-2 mb-4">
                                <label for="remarks"
                                    class="block text-[12px] font-medium text-gray-700 mb-1">REMARKS</label>
                                <input type="text" id="remarks" name="remarks"
                                    :disabled="!isEditable"
                                    class="uppercase w-full p-3 border text-[12px] border-gray-300 rounded-md focus:outline-none focus:ring-custom-yellow">
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
                    <div x-data="{ open: false, imgSrc: '' }" class="w-full lg:w-1/2 pl-4 mt-4">
                        <label class="block text-[12px] font-medium text-gray-700 mb-2">UPLOADED PHOTOS</label>
                        <div class="flex space-x-4">
                            <!-- Image 1 -->
                            <div @click="open = true; imgSrc = '{{ asset('storage/images/designDasboard.png') }}';" class="relative w-1/2 border border-bg-gray-700">
                                <img src="{{ asset('storage/images/designDasboard.png') }}" alt="House Situation" class="w-full h-auto rounded-md cursor-pointer">
                                <span class="absolute bottom-0 left-0 bg-gray-700 bg-opacity-50 text-white text-[12px] px-2 py-1 rounded-br-md">House Situation.jpeg</span>
                            </div>

                            <!-- Image 2 -->
                            <div @click="open = true; imgSrc = '{{ asset('storage/images/designDasboard.png') }}';" class="relative w-1/2 border border-bg-gray-700">
                                <img src="{{ asset('storage/images/designDasboard.png') }}" alt="House Situation 2" class="w-full h-auto rounded-md cursor-pointer">
                                <span class="absolute bottom-0 left-0 bg-gray-700 bg-opacity-50 text-white text-[12px] px-2 py-1 rounded-br-md">House Situation2.jpeg</span>
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
                                BEING BLACKLISTED <span class="text-red-500">*</span></label>
                            <textarea id="reason" rows="4"
                                class="uppercase w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                placeholder="Enter reason..."></textarea>
                        </div>

                        <!-- Updated By Field -->
                        <div class="mb-4">
                            <label class="block text-[12px] font-medium mb-2 text-gray-700" for="updated-by">UPDATED
                                BY</label>
                            <input type="text" id="updated-by"
                                class="uppercase    w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
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
</x-app-layout>