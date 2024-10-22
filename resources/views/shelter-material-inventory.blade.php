<x-adminshelter-layout>
    <div x-data="{ openFilters: false }" class="p-10 h-screen ml-[17%] mt-[60px]">
        <div class="flex bg-gray-100 text-[12px]">
            <!-- Main Content -->
            <div class="flex-1 h-screen p-6 overflow-auto">
                <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-0 relative p-3">
                    <div class="flex items-center">
                        <h2 class="text-[13px] ml-5 text-gray-700">SET UP MATERIAL INVENTORY</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                    <div class="relative z-0">
                        <button class="bg-transparent text-white px-4 py-2 rounded"></button>
                    </div>
                </div>

                <form>
                    <div class="bg-white p-6 rounded shadow mb-6">
                        <div class="relative hidden md:block border-gray-300 mb-4">
                            <svg class="absolute top-[9px] left-4" width="19" height="19" viewBox="0 0 21 21"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.625 16.625C13.491 16.625 16.625 13.491 16.625 9.625C16.625 5.75901 13.491 2.625 9.625 2.625C5.75901 2.625 2.625 5.75901 2.625 9.625C2.625 13.491 5.75901 16.625 9.625 16.625Z"
                                    stroke="#787C7F" stroke-width="1.75" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M18.3746 18.375L14.5684 14.5688" stroke="#787C7F" stroke-width="1.75"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <input type="search" name="search" id="search"
                                class="rounded-md px-12 py-2 placeholder:text-[13px] z-10 border border-gray-300 bg-[#f7f7f9] hover:ring-custom-yellow focus:ring-custom-yellow"
                                placeholder="Search">
                        </div>
                        <div class="w-full lg:w-1/2 pr-4">
                            <div class="flex flex-wrap -mx-2 mb-1">
                                <div class="w-full md:w-1/2 px-2 mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black"
                                        for="delivery-date">PURCHASE ORDER NO.</label>
                                    <input type="text" id="delivery-date" :disabled="!isEditable"
                                        class="uppercase w-full px-3 py-1 bg-white-700 border border-gray-300 rounded-md placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]">
                                </div>
                                <div class="w-full md:w-1/2 px-2 mb-4">
                                    <label class="block text-[12px] font-medium mb-2 text-black"
                                        for="irs-date">PR NO.</label>
                                    <input type="text" id="irs-date" :disabled="!isEditable"
                                        class="uppercase w-full px-3 py-1 bg-white-700 border border-gray-300 rounded-md placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]">
                                </div>
                            </div>
                        </div>
                        <div x-data="{ rows: [{ item: '', quantity: '', unit: '' }], addRow() {this.rows.push({ item: '', quantity: '', unit: '' });}}">
                            <div class="mb-4">
                                <label class="block text-[13px] font-medium text-gray-700 mb-2">MATERIAL INVENTORY</label>
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr class="w-full text-center text-[12px] border border-gray-400">
                                            <th class="px-4 py-2">ITEMS DESCRIPTION</th>
                                            <th class="px-4 py-2">QUANTITY</th>
                                            <th class="px-4 py-2">UNIT</th>
                                            <th class="px-4 py-2"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="(row, index) in rows" :key="index">
                                            <tr class="odd:bg-custom-green-light even:bg-transparent text-center">
                                                <td class="border px-4 py-2" style="background-color: rgba(163, 214, 163, 0.5);">
                                                    <input type="text" x-model="row.item"
                                                        class="uppercase w-full px-3 py-1 bg-transparent focus:outline-none  text-[12px]" >
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <input type="number" x-model="row.quantity"
                                                        class="uppercase w-full px-3 py-1 bg-transparent  focus:outline-none  text-[12px]">
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <input type="text" x-model="row.unit"
                                                        class="uppercase w-full px-3 py-1 bg-transparent  focus:outline-none  text-[12px]">
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <button @click.prevent="rows.splice(index, 1)" type="button" class="text-red-500 hover:text-red-700 text-[14px]">
                                                        ✕
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Add Row Button -->
                            <div class="flex justify-end mb-4">
                                <button @click.prevent="addRow()" type="button"
                                    class="text-white bg-green-500 hover:bg-green-600 text-[13px] px-2 py-2 rounded-md flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="w-5 h-5 mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Add Row
                                </button>
                            </div>

                            <!-- Save Button -->
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="w-[94px] py-2 bg-gradient-to-r from-custom-yellow to-iroad-orange hover:bg-gradient-to-r hover:from-custom-yellow hover:to-custom-yellow text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                    SAVE
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
        </x-adminshelter-layout>