<div class="app-page">
    <div class="flex bg-gray-100 text-[12px]">

        <!-- Main Content -->
        <div class="app-table-scroll">
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

            <div class="grid grid-row-2 gap-2">
                <!-- Applicant Stat Cards -->
                <div class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white p-2 rounded-lg">
                    <h4 class="text-lg font-bold text-center">RELOCATION LOT APPLICANTS</h4>
                    <div class="text-center text-xs text-white">
                        Summary of Housing Applicants
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <!-- Walk-in Applicants -->
                    <div class="rounded-lg shadow border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-custom-red to-custom-green text-white px-4 py-2 opacity-[60%]">
                            <h4 class="text-sm font-semibold text-center tracking-wide">WALK-IN APPLICANTS</h4>
                        </div>
                        <div class="p-2 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-800 text-xs">Total</span>
                                <span class="text-xl font-bold text-gray-800">{{ $walkInApplicants }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-green-600 text-xs">Tagged</span>
                                <span class="text-base font-semibold text-green-600">{{ $taggedWalkInApplicants }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-red-500 text-xs">Untagged</span>
                                <span class="text-base font-semibold text-red-500">{{ $untaggedWalkInApplicants }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tagged and Validated Applicants -->
                    <div class="rounded-lg shadow border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-custom-red to-custom-green text-white px-4 py-2 opacity-[60%]">
                            <h4 class="text-sm font-semibold text-center tracking-wide">TAGGED &amp; VALIDATED</h4>
                        </div>
                        <div class="p-2 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-80 text-xs">Total</span>
                                <span class="text-xl font-bold text-gray-800">{{ $totalTaggedValidated }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-amber-600 text-xs">Informal Settlers</span>
                                <span class="text-base font-semibold text-amber-600">{{ $informalSettlers }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-blue-600 text-xs">Non-informal Settlers</span>
                                <span class="text-base font-semibold text-blue-600">{{ $nonInformalSettlers }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Identified Informal Settlers -->
                    <div class="rounded-lg shadow border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-custom-red to-custom-green text-white px-4 py-2 opacity-[60%]">
                            <h4 class="text-sm font-semibold text-center tracking-wide">IDENTIFIED INFORMAL SETTLERS</h4>
                        </div>
                        <div class="p-2 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-800 text-xs">Total</span>
                                <span class="text-xl font-bold text-gray-800">{{ $totalInformalSettlers }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-green-600 text-xs">Awarded</span>
                                <span class="text-base font-semibold text-green-600">{{ $awardedInformalSettlers }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-red-500 text-xs">Non-awarded</span>
                                <span class="text-base font-semibold text-red-500">{{ $nonAwardedInformalSettlers }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Applicants (highlighted) -->
                    <div class="rounded-lg shadow-md border-2 border-custom-green overflow-hidden bg-gradient-to-br from-custom-red/5 to-custom-green/5 flex flex-col justify-between">
                        <div class="px-4 pt-3">
                            <h4 class="text-xs font-semibold text-gray-600 text-center tracking-wide">
                                TOTAL RELOCATION LOT APPLICANTS
                            </h4>
                        </div>
                        <div class="flex-1 flex items-center justify-center py-4">
                            <span class="text-4xl font-extrabold text-gray-800">{{ $totalRelocationApplicants }}</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Informal Settlers Classification (unchanged) -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden mt-4">
                <div class="bg-gradient-to-r from-custom-red to-custom-green hover:bg-gradient-to-r hover:from-custom-red hover:to-custom-red text-white p-2">
                    <h4 class="text-lg font-bold text-center">INFORMAL SETTLERS CLASSIFICATION</h4>
                    <div class="text-center text-xs text-white">
                        Classification for Relocation Lot Applicants
                    </div>
                </div>
                <div class="p-4">
                    <h4 class="text-xs font-semibold mb-4 text-gray-800">
                        NOTE: THE FOLLOWING CASES ARE CLASSIFIED AS INFORMAL SETTLERS
                    </h4>
                    <ul class="space-y-3 pl-6 list-disc text-gray-700 text-xs">
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
            </div>

        </div>
    </div>
</div>