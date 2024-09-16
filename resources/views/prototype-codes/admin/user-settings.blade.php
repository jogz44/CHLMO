@extends('layouts.admin')

@section('sidebar')
@include('prototype-codes.components.sidebar')
@endsection

@section('header')
@include('prototype-codes.components.header')
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
        <div class="bg-white rounded shadow mb-4 mt-[60px] flex items-center justify-between">
            <h2 class="text-[13px] ml-5 text-gray-700">USER SETTINGS</h2>
            <img src="{{ asset('storage/halmsAssets/design.png') }}" alt="Design" class="h-full object-cover">
        </div>

        <div x-data="fileUpload()" class="bg-white p-6 rounded shadow">
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
                <div x-data="{ openModalUser: false}" class="flex space-x-2">
                    <button @click="openModalUser = true" class="bg-custom-yellow text-white px-4 py-2 rounded">Add User</button>
                    <button class="bg-custom-green text-white px-4 py-2 rounded">Export</button>

                    <div x-show="openModalUser" class="fixed z-50 inset-0 flex items-center justify-center bg-black bg-opacity-50" x-cloak style="font-family: 'Poppins', sans-serif;">
                        <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-[16px] font-semibold text-black">ADD USER</h3>
                                <button @click="openModalUser = false" class="text-gray-400 hover:text-gray-200">&times;</button>
                            </div>

                            <div class="grid grid-cols-2 gap-3 mb-2">
                                <div>
                                    <label class="block  text-[12px] font-medium mb-2 text-black" for="first-name">FIRST NAME</label>
                                    <input type="text" id="first-name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" placeholder="First Name">
                                </div>
                                <div>
                                    <label class="block  text-[12px] font-medium mb-2 text-black" for="middle-name">MIDDLE NAME</label>
                                    <input type="text" id="middle-name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" placeholder="Middle Name">
                                </div>
                                <div>
                                    <label class="block  text-[12px] font-medium mb-2 text-black" for="last-name">LAST NAME</label>
                                    <input type="text" id="last-name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" placeholder="Last Name">
                                </div>
                                <div>
                                    <label class="block  text-[12px] font-medium mb-2 text-black" for="suffix-name">SUFFIX NAME</label>
                                    <input type="text" id="suffix-name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" placeholder="Suffix Name">
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="contact number">CONTACT NUMBER</label>
                                <input type="text" id="contact-number" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" placeholder="Contact Number">
                            </div>
                            <div class="mb-2">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="designation">DESIGNATION</label>
                                <input type="text" id="designation" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" placeholder="Designation">
                            </div>
                            <div class="mb-2">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="username">USERNAME</label>
                                <input type="text" id="username" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" placeholder="Username">
                            </div>
                            <div class="mb-2">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="password">PASSWORD</label>
                                <input type="text" id="password" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" placeholder="Password">
                            </div>
                            <div class="mb-2 py-3">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="interviewer">PERMISSION</label>
                                <select class="w-full px-3 py-3 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" style="padding: 4px 4px;">
                                    <option value="">Permission</option>
                                    <option value="barangay1">Admin</option>
                                    <option value="barangay2">Editor</option>
                                    <option value="barangay3">Member</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <button type="submit" class="w-full py-2 bg-custom-yellow hover:bg-custom-yellow text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                    <span class="text-[12px]">ADD USER</span>
                                </button>
                                <!-- Cancel Button -->
                                <button type="submit" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                    <span @click="openModalUser = false" class="text-[12px]">CANCEL</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table with transaction requests -->
            <div x-data="{openModalEditUser: false, openModalDisable: false}" class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-2  text-center font-medium">Name</th>
                            <th class="py-2 px-2 border-b text-center  font-medium">Contact No.</th>
                            <th class="py-2 px-2 border-b text-center font-medium">Designation</th>
                            <th class="py-2 px-2 border-b text-center font-medium">Username</th>
                            <th class="py-2 px-2 border-b text-center font-medium">Password</th>
                            <th class="py-2 px-2 border-b text-center font-medium">Permission</th>
                            <th class="py-2 px-2 border-b text-center font-medium">Status</th>
                            <th class="py-2 px-2 border-b text-center font-medium"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 px-2 text-center  border-b"></td>
                            <td class="py-2 px-2 text-center  border-b"></td>
                            <td class="py-2 px-2 border-gray-800 text-center font-medium">
                                <select class="block text-[11px] mt-1 w-full border-gray-300 rounded-md shadow-sm" style="padding: 2px 4px;">
                                    <option value="">Designation</option>
                                    <option value="barangay1">Clerk I</option>
                                    <option value="barangay2">Housing Admin</option>
                                    <option value="barangay3">Barangay 3</option>
                                </select>
                            </td>
                            <td class="py-2 px-2 text-center border-b"></td>
                            <td class="py-2 px-2 text-center border-b"></td>
                            <td class="py-2 px-2 border-gray-800 text-center font-medium">
                                <select class="block text-[11px] mt-1 w-full border-gray-300 rounded-md shadow-sm" style="padding: 2px 4px;">
                                    <option value="">Permission</option>
                                    <option value="barangay1">Admin</option>
                                    <option value="barangay2">Editor</option>
                                    <option value="barangay3">Member</option>
                                </select>
                            </td>
                            <td class="py-2 px-2 border-gray-800 text-center font-medium">
                                <select class="block text-[11px] mt-1 w-full border-gray-300 rounded-md shadow-sm" style="padding: 2px 4px;">
                                    <option value="">Status</option>
                                    <option value="barangay1">Active</option>
                                    <option value="barangay2">Disabled</option>
                                </select>
                            </td>
                            <td class="py-2 px-2 text-center border-b space-x-2">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 px-2 text-center  border-b">Kayden Break</td>
                            <td class="py-4 px-2 text-center border-b">098736648374</td>
                            <td class="py-4 px-2 text-center border-b">CEO</td>
                            <td class="py-4 px-2 text-center border-b">meowmeow</td>
                            <td class="py-4 px-2 text-center border-b">asfsfdgdzzer</td>
                            <td class="py-2 px-2 text-center border-b">admin</td>
                            <td class="py-2 px-2 text-center border-b">active</td>
                            <td class="py-4 px-2 text-center border-b space-x-2">
                                <button
                                    @click="openModalEditUser = true"
                                    class="text-custom-red text-bold underline px-4 py-1.5">Edit</button>
                                <button @click="openModalDisable = true" class="bg-custom-red text-white px-4 py-2 rounded">Disable</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 px-2 text-center  border-b">Callisto Regulus</td>
                            <td class="py-4 px-2 text-center border-b">09467838495</td>
                            <td class="py-4 px-2 text-center border-b">Engineering Aide</td>
                            <td class="py-4 px-2 text-center border-b">callistopogi</td>
                            <td class="py-4 px-2 text-center border-b">FhsdJsvdJKbxs</td>
                            <td class="py-2 px-2 text-center border-b">admin</td>
                            <td class="py-2 px-2 text-center border-b">active</td>
                            <td class="py-4 px-2 text-center border-b space-x-2">
                                <button
                                    @click="openModalEditUser = true"
                                    class="text-custom-red text-bold underline px-4 py-1.5">Edit</button>
                                <button @click="openModalDisable = true" class="bg-custom-red text-white px-4 py-2 rounded">Disable</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 px-2 text-center  border-b">Gage Acheron</td>
                            <td class="py-4 px-2 text-center border-b">098736648374</td>
                            <td class="py-4 px-2 text-center border-b">Sheleter Asst Admin</td>
                            <td class="py-4 px-2 text-center border-b">kitttenn</td>
                            <td class="py-4 px-2 text-center border-b">IDFShsfHsdjd,</td>
                            <td class="py-2 px-2 text-center border-b">admin</td>
                            <td class="py-2 px-2 text-center border-b">disabled</td>
                            <td class="py-4 px-2 text-center border-b space-x-2">
                                <button
                                    @click="openModalEditUser = true"
                                    class="text-custom-red text-bold underline px-4 py-1.5">Edit</button>
                                <button @click="openModalDisable = true" class="bg-custom-red text-white px-4 py-2 rounded">Disable</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 px-2 text-center  border-b">Gage Acheron</td>
                            <td class="py-4 px-2 text-center border-b">098736648374</td>
                            <td class="py-4 px-2 text-center border-b">Sheleter Asst Admin</td>
                            <td class="py-4 px-2 text-center border-b">kitttenn</td>
                            <td class="py-4 px-2 text-center border-b">IDFShsfHsdjd,</td>
                            <td class="py-2 px-2 text-center border-b">admin</td>
                            <td class="py-2 px-2 text-center border-b">disabled</td>
                            <td class="py-4 px-2 text-center border-b space-x-2">
                                <button
                                    @click="openModalEditUser = true"
                                    class="text-custom-red text-bold underline px-4 py-1.5">Edit</button>
                                <button  @click="openModalDisable = true" class="bg-custom-red text-white px-4 py-2 rounded">Disable</button>
                            </td>
                        </tr>

                    </tbody>
                </table>

                <div x-show="openModalEditUser" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak style="font-family: 'Poppins', sans-serif;">
                    <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-[16px] font-semibold text-black">EDIT USER</h3>
                            <button @click="openModalEditUser = false" class="text-gray-400 hover:text-gray-200">&times;</button>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-2">
                            <div>
                                <label class="block  text-[12px] font-medium mb-2 text-black" for="first-name">FIRST NAME</label>
                                <input type="text" id="first-name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" placeholder="First Name">
                            </div>
                            <div>
                                <label class="block  text-[12px] font-medium mb-2 text-black" for="middle-name">MIDDLE NAME</label>
                                <input type="text" id="middle-name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" placeholder="Middle Name">
                            </div>
                            <div>
                                <label class="block  text-[12px] font-medium mb-2 text-black" for="last-name">LAST NAME</label>
                                <input type="text" id="last-name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" placeholder="Last Name">
                            </div>
                            <div>
                                <label class="block  text-[12px] font-medium mb-2 text-black" for="suffix-name">SUFFIX NAME</label>
                                <input type="text" id="suffix-name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" placeholder="Suffix Name">
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="block text-[12px] font-medium mb-2 text-black" for="contact number">CONTACT NUMBER</label>
                            <input type="text" id="contact-number" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" placeholder="Contact Number">
                        </div>
                        <div class="mb-2">
                            <label class="block text-[12px] font-medium mb-2 text-black" for="designation">DESIGNATION</label>
                            <input type="text" id="designation" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" placeholder="Designation">
                        </div>
                        <div class="mb-2">
                            <label class="block text-[12px] font-medium mb-2 text-black" for="username">USERNAME</label>
                            <input type="text" id="username" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" placeholder="Username">
                        </div>
                        <div class="mb-2">
                            <label class="block text-[12px] font-medium mb-2 text-black" for="password">PASSWORD</label>
                            <input type="text" id="password" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" placeholder="Password">
                        </div>
                        <div class="mb-2 py-3">
                            <label class="block text-[12px] font-medium mb-2 text-black" for="interviewer">PERMISSION</label>
                            <select class="w-full px-3 py-3 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-1 focus:ring-gray-600 text-[12px]" style="padding: 4px 4px;">
                                <option value="">Permission</option>
                                <option value="barangay1">Admin</option>
                                <option value="barangay2">Editor</option>
                                <option value="barangay3">Member</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <button type="submit" class="w-full py-2 bg-yellow-500 hover:bg-yellow-400 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                <span class="text-[12px]">SAVE</span>
                            </button>
                            <button type="submit" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                <span class="text-[12px]">CANCEL</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div x-show="openModalDisable" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak style="font-family: 'Poppins', sans-serif;">
                    <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                        <div class="flex flex-col items-center gap-4 mt-4 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0 0 48 48">
                                <path d="M 17.5 4 C 11.995178 4 7.5 8.4951777 7.5 14 C 7.5 19.504822 11.995178 24 17.5 24 C 21.403846 24 25.168433 21.656029 28.091797 19.447266 C 31.015161 17.238502 33.091797 15.027344 33.091797 15.027344 A 1.50015 1.50015 0 0 0 33.091797 12.972656 C 33.091797 12.972656 31.015161 10.761498 28.091797 8.5527344 C 25.168433 6.3439707 21.403846 4 17.5 4 z M 17.5 7 C 20.096154 7 23.581567 8.9060289 26.283203 10.947266 C 28.304742 12.47465 29.074006 13.328143 29.744141 14 C 29.074006 14.671857 28.304742 15.52535 26.283203 17.052734 C 23.581567 19.093971 20.096154 21 17.5 21 C 13.616822 21 10.5 17.883178 10.5 14 C 10.5 10.116822 13.616822 7 17.5 7 z M 35 24 C 28.925 24 24 28.925 24 35 C 24 41.075 28.925 46 35 46 C 41.075 46 46 41.075 46 35 C 46 28.925 41.075 24 35 24 z M 6.6132812 28 C 4.5612812 28 2.8925781 29.784516 2.8925781 31.978516 L 2.8925781 33.5 C 2.8925781 36.781 4.5879687 39.632344 7.6679688 41.527344 C 10.258969 43.122344 13.712578 44 17.392578 44 C 19.944578 44 22.379 43.568344 24.5 42.777344 C 23.892 41.967344 23.368938 41.091391 22.960938 40.150391 C 21.223938 40.717391 19.286578 41 17.392578 41 C 11.853578 41 5.8925781 38.653 5.8925781 33.5 L 5.8925781 31.978516 C 5.8925781 31.447516 6.2222813 31 6.6132812 31 L 22.527344 31 C 22.873344 29.932 23.359078 28.928 23.955078 28 L 6.6132812 28 z M 30 29 C 30.25575 29 30.511531 29.097469 30.707031 29.292969 L 35 33.585938 L 39.292969 29.292969 C 39.683969 28.901969 40.316031 28.901969 40.707031 29.292969 C 41.098031 29.683969 41.098031 30.316031 40.707031 30.707031 L 36.414062 35 L 40.707031 39.292969 C 41.098031 39.683969 41.098031 40.316031 40.707031 40.707031 C 40.512031 40.902031 40.256 41 40 41 C 39.744 41 39.487969 40.902031 39.292969 40.707031 L 35 36.414062 L 30.707031 40.707031 C 30.512031 40.902031 30.256 41 30 41 C 29.744 41 29.487969 40.902031 29.292969 40.707031 C 28.901969 40.316031 28.901969 39.683969 29.292969 39.292969 L 33.585938 35 L 29.292969 30.707031 C 28.901969 30.316031 28.901969 29.683969 29.292969 29.292969 C 29.488469 29.097469 29.74425 29 30 29 z"></path>
                            </svg>
                            <h3 class="text-[16px] font-semibold mb-8 text-black">DISABLE USER?</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <button type="submit" class="w-full py-2 bg-custom-red hover:bg-custom-red text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                <span class="text-[12px]">CONFIRM</span>
                            </button>
                            <button @click="openModalDisable = false" type="submit" class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                <span class="text-[12px]">CANCEL</span>
                            </button>
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
        </div>
    </div>

    @endsection