@extends('layouts.admin')

@section('sidebar')
@include('prototype-codes.admin.components.sidebar')
@endsection

@section('header')
@include('prototype-codes.admin.components.header')
@endsection

@section('content')
<div class="flex bg-gray-100 text-[12px]">
    <!-- Sidebar -->
    <aside class="w-[17%] bg-white h-full shadow-md">
        <!-- Sidebar content -->
        <!-- Your existing sidebar code here -->
    </aside>

    <!-- Main Content -->
    <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">
        <!-- Container for the Title -->
        <div class="bg-white rounded shadow mb-4 mt-[60px] flex items-center justify-between">
            <h2 class="text-[13px] ml-5 text-gray-700">SHELTER ASSISTANCE APPLICANTS</h2>
            <img src="{{ asset('storage/halmsAssets/design.png') }}" alt="Design" class="h-full object-cover">
        </div>

        <!-- Container for the Buttons, Search bar, Filters, and Table -->
        <div class="bg-white p-6 rounded shadow">
            <!-- Page Header with buttons, search bar, and filters -->
            <div class="flex justify-between items-center mb-4">
                <div class="flex space-x-2">
                    <!-- Search -->
                    <div class="relative hidden md:block">
                        <svg class="absolute top-[13px] left-4" width="19" height="19" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.625 16.625C13.491 16.625 16.625 13.491 16.625 9.625C16.625 5.75901 13.491 2.625 9.625 2.625C5.75901 2.625 2.625 5.75901 2.625 9.625C2.625 13.491 5.75901 16.625 9.625 16.625Z" stroke="#787C7F" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M18.3746 18.375L14.5684 14.5688" stroke="#787C7F" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <input type="search" name="search" id="search" class="rounded-md px-12 py-2 placeholder:text-[13px] outline-none border-none z-10 bg-[#f7f7f9] hover:ring-custom-yellow focus:ring-custom-yellow" placeholder="Search">
                    </div>
                </div>

                <!-- filters and button -->
                <div x-data="{ openModal: false}" class="flex space-x-2">
                    <label for="start-date" class="text-[13px] py-2 font-medium">Date Range:</label>
                    <input type="date" id="start-date" class="border text-[13px] border-gray-300 rounded px-2 py-1">
                    <input type="date" id="end-date" class="border text-[13px] border-gray-300 rounded px-2 py-1">
                    <button class="bg-custom-yellow text-white px-4 py-2 rounded">Filter</button>

                    <button @click="openModal = true" class="bg-custom-red text-white px-4 py-2 rounded">Add Applicant</button>
                    <button class="bg-custom-green text-white px-4 py-2 rounded">Export</button>

                    <!-- ADD APPLICANT MODAL -->
                    <div x-show="openModal" class="fixed inset-0 flex z-50 items-center justify-center w-full bg-black bg-opacity-50 shadow-lg" x-cloak>
                        <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-black">ADD APPLICANT</h3>
                                <button @click="openModal = false" class="text-gray-400 hover:text-gray-200">&times;</button>
                            </div>

                            <!-- Form -->
                            <form>
                                <!-- Date Applied Field -->
                                <div class="mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="date-applied">DATE APPLIED</label>
                                    <input type="date" id="date-applied" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]" placeholder="Date Applied">
                                </div>
                                <!-- Main Fields -->
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <!-- First Name Field -->
                                    <div>
                                        <label class="block  text-[12px] font-medium mb-2 text-black" for="first-name">FIRST NAME</label>
                                        <input type="text" id="first-name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]" placeholder="First Name">
                                    </div>

                                    <!-- Middle Name Field -->
                                    <div>
                                        <label class="block  text-[12px] font-medium mb-2 text-black" for="middle-name">MIDDLE NAME</label>
                                        <input type="text" id="middle-name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]" placeholder="Middle Name">
                                    </div>

                                    <!-- Last Name Field -->
                                    <div>
                                        <label class="block  text-[12px] font-medium mb-2 text-black" for="last-name">LAST NAME</label>
                                        <input type="text" id="last-name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]" placeholder="Last Name">
                                    </div>

                                    <!-- Suffix Name Field -->
                                    <div>
                                        <label class="block  text-[12px] font-medium mb-2 text-black" for="suffix-name">SUFFIX NAME</label>
                                        <input type="text" id="suffix-name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]" placeholder="Suffix Name">
                                    </div>
                                </div>

                                <!-- Barangay Field -->
                                <div class="mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="barangay">BARANGAY</label>
                                    <input type="text" id="barangay" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]" placeholder="Barangay">
                                </div>

                                <!-- Purok Field -->
                                <div class="mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="purok">PUROK</label>
                                    <input type="text" id="purok" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]" placeholder="Purok">
                                </div>

                                <!-- Contact Number Field -->
                                <div class="mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="contact number">CONTACT NUMBER</label>
                                    <input type="text" id="contact-number" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]" placeholder="Contact Number">
                                </div>

                                <!-- Interviewer Field -->
                                <div class="mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black" for="interviewer">INITIALLY INTERVIEWED BY</label>
                                    <input type="text" id="initially-interviewed-by" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]" placeholder="Initially Interviewed By">
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <!-- Award Button -->
                                    <button type="submit" class="w-full py-2 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                        <span class="text-sm"> + ADD APPLICANT</span>
                                    </button>

                                    <!-- Cancel Button -->
                                    <button type="submit" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                        <span class="text-[12px]">CANCEL</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>


            <!-- Table with transaction requests -->
            <div x-data="{openModalGrant: false, openModalTag: false, openPreviewModal: false, selectedFile: null, fileName: ''}" class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-2  text-center font-medium">Name</th>
                            <th class="py-2 px-2 border-b text-center  font-medium">Purok</th>
                            <th class="py-2 px-2 border-b text-center font-medium">Barangay</th>
                            <th class="py-2 px-2 border-b text-center font-medium">Contact Number</th>
                            <th class="py-2 px-2 border-b text-center font-medium">Date Applied</th>
                            <th class="py-2 px-2 border-b text-center font-medium">Status</th>
                            <th class="py-2 px-2 border-b text-center font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody x-data>
                        <tr>
                            <td class="py-2 px-2 text-center  border-b"></td>
                            <td class="py-2 px-2 border-b text-center font-medium">
                                <select class="block text-[11px] mt-1 w-full border-gray-300 rounded-md shadow-sm" style="padding: 2px 4px;">
                                    <option value="">Purok</option>
                                    <option value="purok1">Purok 1</option>
                                    <option value="purok2">Purok 2</option>
                                    <option value="purok3">Purok 3</option>
                                </select>
                            </td>
                            <td class="py-2 px-2 border-b text-center font-medium">
                                <select class="block text-[11px] mt-1 w-full border-gray-300 rounded-md shadow-sm" style="padding: 2px 4px;">
                                    <option value="">Barangay</option>
                                    <option value="barangay1">Barangay 1</option>
                                    <option value="barangay2">Barangay 2</option>
                                    <option value="barangay3">Barangay 3</option>
                                </select>
                            </td>
                            <td class="py-2 px-2 text-center border-b"></td>
                            <td class="py-2 px-2 text-center border-b"></td>
                            <td class="py-2 px-2 border-b text-center font-medium">
                                <select class="block text-[11px] mt-1 w-full border-gray-300 rounded-md shadow-sm" style="padding: 2px 4px;">
                                    <option value="">Status</option>
                                    <option value="barangay1">Barangay 1</option>
                                    <option value="barangay2">Barangay 2</option>
                                    <option value="barangay3">Barangay 3</option>
                                </select>
                            </td>
                            <td class="py-2 px-2 text-center border-b space-x-2">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 px-2 text-center  border-b">John Doe</td>
                            <td class="py-4 px-2 text-center border-b">Suaybaguio</td>
                            <td class="py-4 px-2 text-center border-b">Magugpo North</td>
                            <td class="py-4 px-2 text-center border-b">09637894863</td>
                            <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                            <td class="py-4 px-2 text-center border-b">Pending</td>
                            <td class="py-4 px-2 text-center border-b space-x-2">
                                <button
                                    @click="window.location.href = '{{ route('shelterAsst-details') }}'"
                                    class="text-custom-red text-bold underline px-4 py-1.5">Details</button>
                                <button @click="openModalTag = true" class="bg-custom-yellow text-white px-8 py-1.5 rounded-full">Tag</button>
                                <button @click="openModalGrant = true" class="bg-custom-green text-white px-8 py-1.5 rounded-full">Grant</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 px-2 text-center  border-b">John Doe</td>
                            <td class="py-4 px-2 text-center border-b">Suaybaguio</td>
                            <td class="py-4 px-2 text-center border-b">Magugpo North</td>
                            <td class="py-4 px-2 text-center border-b">09637894863</td>
                            <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                            <td class="py-4 px-2 text-center border-b">Pending</td>
                            <td class="py-4 px-2 text-center border-b space-x-2">
                                <button
                                    @click="window.location.href = '{{ route('applicant-details') }}'"
                                    class="text-custom-red text-bold underline px-4 py-1.5">Details</button>
                                <button class="bg-custom-yellow text-white px-8 py-1.5 rounded-full">Tag</button>
                                <button class="bg-custom-green text-white px-8 py-1.5 rounded-full">Grant</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 px-2 text-center  border-b">John Doe</td>
                            <td class="py-4 px-2 text-center border-b">Suaybaguio</td>
                            <td class="py-4 px-2 text-center border-b">Magugpo North</td>
                            <td class="py-4 px-2 text-center border-b">09637894863</td>
                            <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                            <td class="py-4 px-2 text-center border-b">Pending</td>
                            <td class="py-4 px-2 text-center border-b space-x-2">
                                <button
                                    @click="window.location.href = '{{ route('applicant-details') }}'"
                                    class="text-custom-red text-bold underline px-4 py-1.5">Details</button>
                                <button class="bg-custom-yellow text-white px-8 py-1.5 rounded-full">Tag</button>
                                <button class="bg-custom-green text-white px-8 py-1.5 rounded-full">Grant</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 px-2 text-center  border-b">John Doe</td>
                            <td class="py-4 px-2 text-center border-b">Suaybaguio</td>
                            <td class="py-4 px-2 text-center border-b">Magugpo North</td>
                            <td class="py-4 px-2 text-center border-b">09637894863</td>
                            <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                            <td class="py-4 px-2 text-center border-b">Pending</td>
                            <td class="py-4 px-2 text-center border-b space-x-2">
                                <button
                                    @click="window.location.href = '{{ route('applicant-details') }}'"
                                    class="text-custom-red text-bold underline px-4 py-1.5">Details</button>
                                <button class="bg-custom-yellow text-white px-8 py-1.5 rounded-full">Tag</button>
                                <button class="bg-custom-green text-white px-8 py-1.5 rounded-full">Grant</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 px-2 text-center  border-b">John Doe</td>
                            <td class="py-4 px-2 text-center border-b">Suaybaguio</td>
                            <td class="py-4 px-2 text-center border-b">Magugpo North</td>
                            <td class="py-4 px-2 text-center border-b">09637894863</td>
                            <td class="py-4 px-2 text-center border-b">11/23/2023</td>
                            <td class="py-4 px-2 text-center border-b">Pending</td>
                            <td class="py-4 px-2 text-center border-b space-x-2">
                                <button
                                    @click="window.location.href = '{{ route('applicant-details') }}'"
                                    class="text-custom-red text-bold underline px-4 py-1.5">Details</button>
                                <button class="bg-custom-yellow text-white px-8 py-1.5 rounded-full">Tag</button>
                                <button class="bg-custom-green text-white px-8 py-1.5 rounded-full">Grant</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Award Applicant Modal -->
                <div x-data="{
                        materials: [
                        { material: '', quantity: '' }
                        ],
                        addMaterial() {
                            this.materials.push({ material: '', quantity: '' });
                        }}"
                    x-show="openModalGrant" class="fixed inset-0 flex z-50 items-center justify-center bg-black bg-opacity-50 shadow-lg"
                    x-cloak style="font-family: 'Poppins', sans-serif;">
                    <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-black">GRANT APPLICANT</h3>
                            <button @click="openModalGrant = false" class="text-gray-400 hover:text-gray-200">&times;</button>
                        </div>

                        <!-- Form -->
                        <form>
                            <!-- Award Date Field -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="date-applied">GRANT DATE</label>
                                <input type="date" id="award-date" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" placeholder="Award Date">
                            </div>

                            <!-- Materials Provided Section -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black">MATERIALS PROVIDED</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <select class="w-full px-3 py-2 border border-gray-600 rounded-lg text-gray-800 text-[12px] focus:outline-none focus:ring-1 focus:ring-gray-600">
                                            <option>Metal Sheet</option>
                                            <option>Hollow Block</option>
                                            <option>Balas</option>
                                            <option>Cement</option>
                                        </select>
                                    </div>
                                    <div>
                                        <input type="text" placeholder="10 pcs" class="w-full px-3 py-2 border border-gray-600 rounded-lg text-gray-800 text-[12px] focus:outline-none focus:ring-1 focus:ring-gray-600">
                                    </div>
                                    <div>
                                        <select class="w-full px-3 py-2 border border-gray-600 rounded-lg text-gray-800 text-[12px] focus:outline-none focus:ring-1 focus:ring-gray-600">
                                            <option>Metal Sheet</option>
                                            <option>Hollow Block</option>
                                            <option>Balas</option>
                                            <option>Cement</option>
                                        </select>
                                    </div>
                                    <div>
                                        <input type="text" placeholder="10 pcs" class="w-full px-3 py-2 border border-gray-600 rounded-lg text-gray-800 text-[12px] focus:outline-none focus:ring-1 focus:ring-gray-600">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mt-3 mb-2">
                                    <input type="text" x-model="materials[0].material" class="w-full px-3 py-2 border border-gray-600 rounded-lg text-gray-800 text-[12px] focus:outline-none focus:ring-1 focus:ring-gray-600" placeholder="Material">
                                    <input type="text" x-model="materials[0].quantity" class="w-full px-3 py-2 border border-gray-600 rounded-lg text-gray-800 text-[12px] focus:outline-none focus:ring-1 focus:ring-gray-600" placeholder="Quantity">
                                </div>

                                <!-- Dynamically added input fields for additional materials and quantities -->
                                <template x-for="(item, index) in materials.slice(1)" :key="index">
                                    <div class="grid grid-cols-2 gap-4 mb-2">
                                        <input type="text" x-model="item.material" class="w-full px-3 py-2 border border-gray-600 rounded-lg text-gray-800 text-[12px] focus:outline-none focus:ring-1 focus:ring-gray-600" placeholder="Material">
                                        <input type="text" x-model="item.quantity" class="w-full px-3 py-2 border border-gray-600 rounded-lg text-gray-800 text-[12px] focus:outline-none focus:ring-1 focus:ring-gray-600" placeholder="Quantity">
                                    </div>
                                </template>
                                <!-- Add Button -->
                                <div class="flex justify-center mt-4">
                                    <button type="button" @click="addMaterial" class="px-3 py-1 bg-custom-yellow text-white rounded-md text-xs hover:bg-custom-yellow">ADD</button>
                                </div>
                            </div>

                            <br>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <button type="submit"
                                    class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg">
                                    AWARD
                                </button>
                                <button type="button" @click="openModalGrant = false"
                                    class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg">
                                    CANCEL
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tagging/Validation Modal -->
                <div x-show="openModalTag" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 shadow-lg" x-cloak style="font-family: 'Poppins', sans-serif;">
                    <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-black">TAGGED/VALIDATED</h3>
                            <button @click="openModalTag = false" class="text-gray-400 hover:text-gray-200">&times;</button>
                        </div>

                        <!-- Form -->
                        <form @submit.prevent>
                            <!-- Tagging and Validation Date Field -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="tagging-validation-date">TAGGING AND VALIDATION DATE</label>
                                <input type="date" id="tagging-validation-date" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]">
                            </div>

                            <!-- Validator's Name Field -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="validator-name">VALIDATOR'S NAME</label>
                                <input type="text" id="validator-name" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]" placeholder="Validator's Name">
                            </div>

                            <!-- House Situation Upload -->
                            <h2 class="block text-[12px] font-medium mb-2 text-black">UPLOAD HOUSE SITUATION</h2>

                            <!-- Drag and Drop Area -->
                            <div class="border-2 border-dashed border-green-500 rounded-lg p-4 flex flex-col items-center space-y-1">
                                <svg class="w-10 h-10 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 011-7.874V7a5 5 0 018.874-2.485A5.5 5.5 0 1118.5 15H5z" />
                                </svg>
                                <p class="text-gray-500 text-xs">DRAG AND DROP FILES</p>
                                <p class="text-gray-500 text-xs">or</p>
                                <button type="button" class="px-3 py-1 bg-green-600 text-white rounded-md text-xs hover:bg-green-700" @click="$refs.fileInput.click()">BROWSE FILES</button>

                                <!-- Hidden File Input -->
                                <input type="file" x-ref="fileInput" @change="selectedFile = $refs.fileInput.files[0]; fileName = selectedFile.name" class="hidden" />
                            </div>

                            <!-- Show selected file and progress bar when a file is selected -->
                            <template x-if="selectedFile">
                                <div @click="openPreviewModal = true" class="mt-4 bg-white p-2 rounded-lg shadow">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 3v6h4l1 1h4V3H7z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8v10h14V8H5z" />
                                            </svg>
                                            <span class="text-xs font-medium text-gray-700" x-text="fileName"></span>

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

                            <!-- Buttons -->
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <button type="submit" class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg">
                                    TAGGED & VALIDATED
                                </button>
                                <button type="button" @click="openModalTag = false" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg">
                                    CANCEL
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Preview Modal (Triggered by Clicking the Progress Bar) -->
                <div x-show="openPreviewModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 shadow-lg" x-cloak>
                    <div class="bg-white w-[600px] rounded-lg shadow-lg p-6 relative">
                        <!-- Modal Header with File Name -->
                        <div class="flex justify-between items-center mb-4">
                            <input type="text" x-model="fileName" class="text-[13px] w-[60%] font-regular text-black border-none focus:outline-none focus:ring-0">
                            <button class="text-orange-500 underline text-sm" @click="fileName = prompt('Rename File', fileName) || fileName">Rename File</button>
                            <button @click="openPreviewModal = false" class="text-gray-400 hover:text-gray-200">&times;</button>
                        </div>

                        <!-- Display Image -->
                        <div class="flex justify-center mb-4">
                            <img :src="selectedFile ? URL.createObjectURL(selectedFile) : '/path/to/default/image.jpg'" alt="Preview Image" class="w-full h-auto max-h-[60vh] object-contain">
                        </div>
                        <!-- Modal Buttons -->
                        <div class="flex justify-between mt-4">
                            <button class="px-4 py-2 bg-green-600 text-white rounded-lg" @click="openPreviewModal = false">CONFIRM</button>
                            <button class="px-4 py-2 bg-red-600 text-white rounded-lg" @click="selectedFile = null; openPreviewModal = false">REMOVE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pagination controls -->
        <div class="flex justify-end text-[12px] mt-4">
            <button
                @click="prevPage"
                :disabled="currentPage === 1"
                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-l disabled:opacity-50">
                Prev
            </button>
            <template x-for="page in totalPages" :key="page">
                <button
                    @click="goToPage(page)"
                    :class="{'bg-custom-green text-white': page === currentPage, 'bg-gray-200': page !== currentPage}"
                    class="px-4 py-2 mx-1 rounded">
                    <span x-text="page"></span>
                </button>
            </template>
            <button
                @click="nextPage"
                :disabled="currentPage === totalPages"
                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-r disabled:opacity-50">
                Next
            </button>
        </div>
    </div>
</div>
</div>

<script>
    function pagination() {
        return {
            currentPage: 1,
            totalPages: 3, // Set this to the total number of pages you have

            prevPage() {
                if (this.currentPage > 1) this.currentPage--;
            },
            nextPage() {
                if (this.currentPage < this.totalPages) this.currentPage++;
            },
            goToPage(page) {
                this.currentPage = page;
            }
        }
    }
</script>
@endsection