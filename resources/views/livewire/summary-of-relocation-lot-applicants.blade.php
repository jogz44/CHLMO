<div class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">

        <!-- Main Content -->
        <div class="flex-1 h-screen p-6 overflow-auto">
            <div class="bg-white rounded shadow mb-6 flex items-center justify-between relative p-3">
                <div class="flex items-center">
                    <h2 class="text-[13px] ml-2 items-center text-gray-700">Relocation Applicant Summary</h2>
                </div>
                <img src="{{ asset('storage/images/design.png') }}" alt="Design"
                     class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                <div class="relative z-0">
                    <button wire:click="exportPDF" wire:ignore wire:loading.attr="disabled"
                            class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white px-4 py-2 rounded">
                        <span wire:loading wire:target="export">Exporting PDF...</span>
                        <span wire:loading.remove>Export to PDF</span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white p-4">
                        <h3 class="text-xl font-bold text-center">INFORMAL SETTLERS CLASSIFICATION</h3>
                    </div>
                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-4 text-gray-800">
                            NOTE: THE FOLLOWING CASES ARE CLASSIFIED AS INFORMAL SETTLERS
                        </h4>
                        <ul class="space-y-3 pl-6 list-disc text-gray-700">
                            <li>AFFECTED BY GOVERNMENT INFRASTRUCTURE</li>
                            <li>GOVERNMENT PROPERTIES</li>
                            <li>WITH COURT ORDER FOR DEMOLITION AND EVICTION</li>
                            <li>WITH NOTICE TO VACATE</li>
                            <li>PRIVATE PROPERTIES</li>
                            <li>PRIVATE CONSTRUCTION PROJECTS</li>
                            <li>ALIENABLE AND DISPOSABLE LAND</li>
                            <li>
                                DANGER ZONE: ACCRETION AREA, LANDSLIDE PRONE AREA, IDENTIFIED FLOOD PRONE AREA,
                                NPC LINE, ALONG THE CREEK, ALONG THE RIVER, ETC.
                            </li>
                            <li>AND OTHER CASES</li>
                        </ul>
                    </div>
                    <div class="bg-gray-100 p-4 text-center text-sm text-gray-600">
                        Classification for Relocation Lot Applicants
                    </div>
                </div>

                <!-- Table with transaction requests -->
                <div class="overflow-x-auto max-w-2xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white p-4">
                            <tr>
                                <th class="p-4 px-32 text-xl font-semibold text-center">
                                    <h3 class="text-xl font-bold text-center">RELOCATION LOT APPLICANTS</h3>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-lg font-semibold mb-4 py-2 px-2 text-center border-b text-gray-800">
                                    WALK-IN APPLICANTS
                                </td>
                            </tr>
                            <tr>
                                <td class="text-[16px] py-2 px-2 border-b text-gray-700 text-center font-medium">
                                    {{ $walkInApplicants }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-lg font-semibold mb-4 py-2 px-2 text-center border-b text-gray-800">
                                    TAGGED AND VALIDATED
                                </td>
                            </tr>
                            <tr>
                                <td class="text-[16px] py-2 px-2 border-b text-gray-700 text-center font-medium">
                                    {{ $taggedAndValidated }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-lg font-semibold mb-4 py-2 px-2 text-center border-b text-gray-800">
                                    IDENTIFIED INFORMAL SETTLERS
                                </td>
                            </tr>
                            <tr>
                                <td class="text-[16px] py-2 px-2 border-b text-gray-700 text-center font-medium">
                                    {{ $identifiedInformalSettlers }}
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-lg font-semibold mb-4 py-2 px-2 text-center border-b text-gray-800">
                                    TOTAL NUMBER RELOCATION LOT APPLICANTS
                                </td>
                            </tr>
                            <tr>
                                <td class="text-lg py-2 px-2 border-b text-gray-700 text-center font-medium">
                                    {{ $totalRelocationLotApplicants }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>