<div class="app-page">
    <div class="mb-5 flex flex-col gap-3 rounded relative bg-white p-4 shadow sm:flex-row sm:items-center sm:justify-between">
        <div class="flex-col items-center">
            <h1 class="text-base font-semibold text-gray-800">Set Up Material Inventory</h1>
            <p class="mt-1 text-[12px] text-gray-500">Record a purchase order and list the materials it covers.</p>
        </div>
        <img src="{{ asset('storage/images/design.png') }}"
                         alt="Design"
                         class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
    </div>

    <form wire:submit.prevent="save">
         @if (session()->has('message'))
            <div class="mt-4 mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-[12px] text-green-700">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mt-4 mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-[12px] text-red-700">
                {{ session('error') }}
            </div>
        @endif
        <div class="rounded bg-white p-6 shadow">
            <!-- Purchase Order Details -->
            <div class="mb-8 grid grid-cols-1 gap-6 border-b border-gray-100 pb-8 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-[12px] font-semibold uppercase tracking-wide text-gray-600">
                        Purchase Order No.
                    </label>
                    <input
                        type="text"
                        wire:model="purchaseOrderNo"
                        class="uppercase w-full rounded-md border border-gray-300 px-3 py-2 text-[13px] text-gray-800 focus:border-[#828181] focus:outline-none focus:ring-1 focus:ring-[#828181]"
                        placeholder="Enter PO No."
                        required
                    >
                    @error('purchaseOrderNo') <span class="mt-1 block text-[11px] text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-[12px] font-semibold uppercase tracking-wide text-gray-600">
                        Purchase Requisition No.
                    </label>
                    <input
                        type="text"
                        wire:model="purchaseRequisitionNo"
                        class="uppercase w-full rounded-md border border-gray-300 px-3 py-2 text-[13px] text-gray-800 focus:border-[#828181] focus:outline-none focus:ring-1 focus:ring-[#828181]"
                        placeholder="Enter PR No."
                        required
                    >
                    @error('purchaseRequisitionNo') <span class="mt-1 block text-[11px] text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Material Inventory Table -->
            <div class="mb-2 flex items-center justify-between">
                <label class="text-[13px] font-semibold uppercase tracking-wide text-gray-700">Material Inventory</label>
                <span class="text-[11px] text-gray-400">{{ count($rows) }} {{ count($rows) === 1 ? 'item' : 'items' }}</span>
            </div>
            

            <div class="overflow-hidden rounded-md border border-gray-200 overflow-x-auto">
                <table class="min-w-full bg-white text-[12px]">
                    <thead>
                        <tr class="bg-gray-200 text-left text-[11px] uppercase tracking-wide text-white">
                            <th class="px-4 py-3 text-gray-800">Item Description</th>
                            <th class="lg:w-32 px-4 py-3 text-gray-800 text-center">Quantity</th>
                            <th class="lg:w-56 px-4 py-3 text-gray-800 text-center">Unit</th>
                            <th class="lg:w-12 px-4 py-3 text-gray-800"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($rows as $index => $row)
                            <tr wire:key="row-{{ $index }}" class="odd:bg-gray-50/60 even:bg-white hover:bg-green-50/40">
                                <td class="px-4 py-2">
                                    <input
                                        type="text"
                                        wire:model="rows.{{ $index }}.item_description"
                                        class="w-40 lg:w-full md:w-full uppercase rounded border border-transparent bg-transparent px-2 py-1.5 text-gray-800 focus:border-gray-300 focus:bg-white focus:outline-none"
                                        placeholder="Item description"
                                        required
                                    >
                                </td>
                                <td class="px-4 py-2">
                                    <input
                                        type="number"
                                        wire:model="rows.{{ $index }}.quantity"
                                        class=" w-20 lg:w-full md:w-full rounded border border-transparent bg-transparent px-2 py-1.5 text-center text-gray-800 focus:border-gray-300 focus:bg-white focus:outline-none"
                                        placeholder="0"
                                        required
                                    >
                                </td>
                                <td class="px-4 py-2">
                                    <select
                                        wire:model="rows.{{ $index }}.unit"
                                        class=" w-20 lg:w-full md:w-full rounded border border-transparent bg-transparent px-2 py-1.5 text-center text-gray-800 focus:border-gray-300 focus:bg-white focus:outline-none"
                                    >
                                        <option value="">Select unit</option>
                                        @foreach ($materialUnits as $materialUnit)
                                            <option value="{{ $materialUnit->id }}">{{ $materialUnit->unit }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <button
                                        type="button"
                                        wire:click="removeRow({{ $index }})"
                                        class="rounded p-1 text-gray-400 hover:bg-red-50 hover:text-red-600"
                                        title="Remove row"
                                    >
                                        &#x2715;
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-[12px] text-gray-400">
                                    No materials added yet. Click "Add Row" to get started.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Add Row -->
            <div class="mt-4 flex justify-end">
                <button
                    type="button"
                    wire:click="addRow"
                    class="flex items-center gap-1.5 rounded-md border border-green-600 px-3 py-1.5 text-[12px] font-medium text-green-700 hover:bg-green-50"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add Row
                </button>
            </div>

            <!-- Save -->
            <div class="mt-8 flex justify-end border-t border-gray-100 pt-6">
                <button
                    type="submit"
                    class="rounded-md bg-gradient-to-r from-custom-yellow to-iroad-orange px-8 py-2.5 text-[13px] font-semibold text-white shadow-sm hover:opacity-95"
                >
                    Save
                </button>
            </div>
        </div>
    </form>
</div>