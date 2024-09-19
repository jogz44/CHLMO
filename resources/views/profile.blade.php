<x-app-layout>
    <div class="p-10 h-screen ml-[17%] mt-[60px]">
        <div class="flex flex-col lg:flex-row p-6 h-screen bg-transparent">
            <div x-data="imageUpload()" class="w-full lg:w-1/3 flex justify-center">
                <div class="bg-white shadow-lg p-6 rounded-md h-3/6 w-[90%] text-center relative">
                    <img src="/storage/images/designProfile.png" alt="Design Profile"
                         class="absolute right-0 top-0 h-full object-cover opacity-70 z-0 pointer-events-none">

                    <div class="relative z-10">
                        <img :src="imageUrl" alt="Profile Picture"
                             class="w-32 mt-6 h-32 rounded-full mx-auto object-cover border border-gray-300"
                             id="profile-picture">

                        <!-- Name and Role -->
                        <h2 class="mt-4 text-[15px] font-semibold">Katie Penalosa</h2>
                        <p class="text-gray-600 text-[13px] mt-1">Housing Administrator I</p>

                        <!-- Edit Picture Button -->
                        <button @click="$refs.fileInput.click()"
                                class="mt-4 text-[13px] px-4 py-2 bg-green-500 text-white rounded-full hover:bg-green-600">
                            <i class="fas fa-edit "></i> Edit Picture
                        </button>

                        <input type="file" accept="image/*" @change="previewImage" class="hidden" x-ref="fileInput">
                    </div>
                </div>
            </div>

            <!-- Right Section (Form) -->
            <div x-data="formHandler()" class="w-full lg:w-2/3 mt-6 lg:mt-0">
                <div class="bg-white shadow-lg p-6 rounded-md">
                    <h3 class="text-[13px] font-semibold mb-4">Personal Information</h3>
                    <form>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <label class="block text-[13px] font-medium text-gray-700">First Name</label>
                                <input type="text" x-model="formData.firstName" :disabled="!isEditing"
                                       class="mt-1 text-[13px] block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            </div>

                            <div class="col-span-1">
                                <label class="block text-[13px] font-medium text-gray-700">Middle Name</label>
                                <input type="text" x-model="formData.middleName" :disabled="!isEditing"
                                       class="mt-1 text-[13px] block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            </div>

                            <div class="col-span-1">
                                <label class="block text-[13px] font-medium text-gray-700">Last Name</label>
                                <input type="text" x-model="formData.lastName" :disabled="!isEditing"
                                       class="mt-1 text-[13px] block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            </div>

                            <div class="col-span-1">
                                <label class="block text-[13px] font-medium text-gray-700">Contact Number</label>
                                <input type="text" x-model="formData.contactNumber" :disabled="!isEditing"
                                       class="mt-1 text-[13px] block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            </div>

                            <div class="col-span-1">
                                <label class="block text-[13px] font-medium text-gray-700">Designation</label>
                                <select x-model="formData.designation" :disabled="!isEditing"
                                        class="mt-1 block w-full px-3 py-2 border text-[13px] border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                    <option value="Housing Administrator">Housing Administrator</option>
                                    <option value="Other Role">Other Role</option>
                                </select>
                            </div>

                            <div class="col-span-1">
                                <label class="block text-[13px] font-medium text-gray-700">Username</label>
                                <input type="text" x-model="formData.username" :disabled="!isEditing"
                                       class="mt-1 text-[13px] block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            </div>

                            <div class="col-span-1">
                                <label class="block text-[13px] font-medium text-gray-700">Password</label>
                                <input type="password" x-model="formData.password" :disabled="!isEditing"
                                       class="mt-1 text-[13px] block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" @click="toggleEditMode"
                                    class="mr-4 text-[13px] px-4 py-2 bg-custom-yellow text-white hover:bg-orange-500 rounded-full"
                                    x-text="isEditing ? 'Cancel' : 'Edit Profile'"></button>
                            <button type="button" @click="saveData" x-show="isEditing"
                                    class="px-4 text-[13px] py-2 bg-green-500 text-white rounded-full hover:bg-green-600">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function imageUpload() {
                return {
                    imageUrl: "{{ asset('images/user-placeholder.jpg') }}",

                    previewImage(event) {
                        console.log('Preview Image triggered');
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.imageUrl = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    }
                };
            }

            function formHandler() {
                return {
                    isEditing: false,
                    formData: {
                        firstName: 'Katie',
                        middleName: '',
                        lastName: 'Penalosa',
                        contactNumber: '09474463572',
                        designation: 'Housing Administrator',
                        username: 'Katieecutiee',
                        password: '********'
                    },

                    toggleEditMode() {
                        this.isEditing = !this.isEditing;
                    },

                    saveData() {
                        // Logic to save data via Ajax or form submission can go here
                        console.log('Saving data...', this.formData);
                        this.isEditing = false;
                    }
                };
            }
        </script>
    </div>
</x-app-layout>