<div>
    <div x-data="{ openFilters: false }" class="p-10 h-screen ml-[17%] mt-[100px]">
        <div class="flex bg-gray-100 text-[12px]">
            <!-- Main Content -->
            <div x-data="pagination()" class="flex-1 h-screen p-6 overflow-auto">
                <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-5 relative p-3">
                    <div class="flex items-center">
                        <h2 class="text-[13px] ml-5 text-gray-700 font-semibold">REPORT ON AVAILABILITY OF MATERIALS UNDER THE SHELTER ASSISTANCE PROGRAM</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                    <div class="relative z-0">
                        <button class="bg-custom-green text-white px-4 py-2 rounded">Export</button>
                    </div>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2">

                        </div>
                        <!-- Filter Dropdown and Clear Button -->
                        <div class="flex justify-end">
                            <select wire:model.live="selectedPrPo" class="border text-[13px] border-gray-300 text-gray-600 rounded px-2 py-1 shadow-sm">
                                <option value="">Select PO and PR</option>
                                @foreach($prPoHeaders as $header)
                                <option value="{{ $header->pr_number }}-{{ $header->po_number }}">
                                    PR {{ $header->pr_number }} - PO {{ $header->po_number }}
                                </option>
                                @endforeach
                            </select>
                            <button wire:click="clearFilter" class="ml-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-4 py-1.5 rounded-full">
                                Clear Filter
                            </button>
                        </div>
                    </div>
                </div>

                <div x-data="{ openModalGrant: false, openPreviewModal: false, selectedFile: null, fileName: '' }" class="overflow-x-auto">

                    <table class="min-w-full bg-white border border-gray-200 shadow-sm ">
                        <thead class="bg-gray-100 font-bold">
                            <tr>
                                <th class="py-2 px-4 text-center text-gray-700">ITEM NO.</th>
                                <th class="py-2 px-4 text-center text-gray-700">ITEM DESCRIPTION</th>
                                <th class="py-2 px-4 text-center text-gray-700">UNIT</th>
                                @if(!$isFiltered)
                                @foreach($prPoHeaders as $header)
                                <th class="py-2 px-4 text-center text-gray-700 whitespace-nowrap">
                                    PR {{ $header->pr_number }}<br>PO {{ $header->po_number }}
                                </th>
                                @endforeach
                                @else
                                <th class="py-2 px-4 text-center text-gray-700">TOTAL QUANTITY</th>
                                <th class="py-2 px-4 text-center text-gray-700">WITHDRAWAL</th>
                                <th class="py-2 px-4 text-center text-gray-700">AVAILABLE MATERIALS</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if($materials && count($materials) > 0)
                            @foreach($materials as $key => $materialGroup)
                            @php
                            $firstMaterial = $materialGroup->first(); // First entry of grouped materials
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 text-center border-b text-sm text-gray-600">{{ $key + 1 }}</td>
                                <td class="py-2 px-4 text-center border-b text-sm text-gray-600 whitespace-nowrap">{{ $firstMaterial->description }}</td>
                                <td class="py-2 px-4 text-center border-b text-sm text-gray-600">{{ $firstMaterial->unit }}</td>
                                @if(!$isFiltered)
                                @foreach($prPoHeaders as $header)
                                @php
                                $quantity = $materialGroup->where('pr_number', $header->pr_number)
                                ->where('po_number', $header->po_number)
                                ->first()->available_quantity ?? 0;
                                @endphp
                                <td class="py-2 px-4 text-center border-b text-sm text-gray-600">
                                    {{ $quantity }}
                                </td>
                                @endforeach
                                @else
                                <td class="py-2 px-4 text-center border-b text-sm text-gray-600">{{ $firstMaterial->total_quantity }}</td>
                                <td class="py-2 px-4 text-center border-b text-sm text-gray-600">{{ $firstMaterial->delivered_quantity }}</td>
                                <td class="py-2 px-4 text-center border-b text-sm text-gray-600">{{ $firstMaterial->available_quantity }}</td>
                                @endif
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="{{ !$isFiltered ? 3 + count($prPoHeaders) : 6 }}" class="py-4 px-2 text-center text-gray-600">
                                    No data available.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
</div>