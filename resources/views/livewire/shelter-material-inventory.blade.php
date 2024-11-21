<div class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <!-- Main Content -->
        <div class="flex-1 h-screen p-6 overflow-auto mt-4">
            <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-0 relative p-3">
                <div class="flex items-center">
                    <h2 class="text-[13px] ml-5 text-gray-700">SET UP MATERIAL INVENTORY</h2>
                </div>
                <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
            </div>

            <form wire:submit.prevent="save" x-data="{ showTable: false }">
                <div class="bg-white p-6 rounded shadow mb-6">
                    <div class="w-full lg:w-1/2 pr-4 grid grid-cols-1 mt-10 mb-10">
                        <div class="flex flex-wrap -mx-2 mb-1 items-center">
                            <!-- Purchase Order No. -->
                            <div class="w-full md:w-1/3 px-3">
                                <label class=" whitespace-nowrap text-[12px] font-medium mb-2 text-black">
                                    PURCHASE ORDER NO.
                                </label>
                                <input type="text" wire:model="purchaseOrderNo" class="uppercase w-full px-3 py-1 bg-white-700 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-[#828181] focus:border-[#828181] rounded-md text-gray-800 text-[12px]" required>
                                @error('purchaseOrderNo') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Purchase Requisition No. -->
                            <div class="w-full md:w-1/3 px-3 whitespace-nowrap">
                                <label class=" whitespace-nowrap block text-[12px] font-medium mb-2 text-black">
                                    PURCHASE REQUISITION NO.
                                </label>
                                <input type="text" wire:model="purchaseRequisitionNo" class="uppercase w-full px-1 py-1 bg-white-700 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-[#828181] focus:border-[#828181] rounded-md text-gray-800 text-[12px]" required>
                                @error('purchaseRequisitionNo') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Add Button -->
                            <div class="flex items-end md:w-auto mt-6">
                                <button type="button" @click="showTable = true" :disabled="!@this.purchaseOrderNo || !@this.purchaseRequisitionNo" class="text-white bg-green-500 hover:bg-green-600 text-[13px] px-5 py-1 rounded-md flex items-center">
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Material Inventory Table -->
                    <div x-show="showTable" style="display: none;">
                        <label class="block text-[13px] font-medium text-gray-700 mb-2">MATERIAL INVENTORY</label>
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="text-center text-[12px] border border-gray-900">
                                    <th class="px-4 py-2">ITEMS DESCRIPTION</th>
                                    <th class="px-4 py-2">QUANTITY</th>
                                    <th class="px-4 py-2">UNIT</th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $index => $row)
                                <tr class="odd:bg-custom-green-light even:bg-transparent text-center">
                                    <td class="border px-4 py-2">
                                        <input type="text" wire:model="rows.{{ $index }}.item_description" class="uppercase w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]" required>
                                    </td>
                                    <td class="border px-4 py-2">
                                        <input type="number" wire:model="rows.{{ $index }}.quantity" class="uppercase w-full px-3 py-2 bg-transparent focus:outline-none text-[12px]" required>
                                    </td>
                                    <td class="border px-4 py-2">
                                        <!-- <input type="text" wire:model="rows.{{ $index }}.unit" class="uppercase w-full px-3 py-1 bg-transparent focus:outline-none text-[12px]" required> -->
                                        <select wire:model="rows.{{ $index }}.unit" name="material_unit" id="material_unit" class="px-12 py-1 w-3/4 items-center placeholder:text-[13px] z-10 bg-transparent focus:outline-none focus:ring-1 focus:ring-[#c7c7c7] focus:border-[#828181]">
                                            <option value="" class="rounded-lg px-12 py-2 bg-white border border-gray-300 items-center font">Select unit</option>
                                            @foreach($materialUnits as $materialUnit)
                                            <option value="{{ $materialUnit->id }}">{{ $materialUnit->unit }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="border px-4 py-2">
                                        <button type="button" wire:click="removeRow({{ $index }})" class="text-red-500 hover:text-red-700 text-[14px]">✕</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Add Row Button -->
                        <div class="flex justify-end mb-4 mt-4">
                            <button type="button" wire:click="addRow" class="text-white bg-green-500 hover:bg-green-600 text-[13px] px-2 py-2 rounded-md flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Add Row
                            </button>
                        </div>

                        <!-- Save Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="w-[94px] py-2 bg-gradient-to-r from-custom-yellow to-iroad-orange text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                SAVE
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Success Message -->
                @if (session()->has('message'))
                <div class="mt-4 text-green-600">
                    {{ session('message') }}
                </div>
                @endif

                <!-- Error Message -->
                @if (session()->has('error'))
                <div class="mt-4 text-red-600">
                    {{ session('error') }}
                </div>
                @endif
            </form>
        </div>
    </div>
</div>