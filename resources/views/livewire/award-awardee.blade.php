<div>
    @if($isAwarded)
        <button class="bg-gray-400 text-white text-xs font-semibold px-6 py-2 rounded cursor-not-allowed" disabled>
            Awarded
        </button>
    @else
        <button wire:click="openModal"
                class="bg-custom-red text-white text-xs font-semibold px-6 py-2 rounded">
            <span wire:loading.remove>
                AWARD THIS APPLICANT
            </span>
            <span wire:loading class="flex items-center">
                <svg class="animate-spin h-4 w-4 text-white mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                Loading...
            </span>
        </button>
    @endif

    <!-- Award Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                     wire:click="closeModal"></div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Award Property
                        </h3>

                        <!-- Awardee Information -->
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">
                                <strong>Awardee:</strong>
                                {{ $awardee->taggedAndValidatedApplicant->applicant->person->full_name }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <strong>Property:</strong>
                                @if($awardee->actualRelocationSite)
                                    {{ $awardee->actualRelocationSite->relocation_site_name }},
                                    Block {{ $awardee->actual_block }},
                                    Lot {{ $awardee->actual_lot }}
                                    <span class="text-green-600 text-xs">(Actual Site)</span>
                                @else
                                    {{ $awardee->assignedRelocationSite->relocation_site_name }},
                                    Block {{ $awardee->assigned_block }},
                                    Lot {{ $awardee->assigned_lot }}
                                    @if($this->canAwardWithAssignedSite()['can_award'])
                                        <span class="text-blue-600 text-xs">(Available)</span>
                                    @else
                                        <span class="text-red-600 text-xs">({{ $this->canAwardWithAssignedSite()['message'] }})</span>
                                    @endif
                                @endif
                            </p>
                        </div>

                        <!-- Award Form -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Grant Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                   wire:model="grantDate"
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   max="{{ now()->format('Y-m-d') }}"
                                   required>
                            @error('grantDate')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Document Verification -->
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox"
                                       wire:model="documentSubmitted"
                                       class="rounded border-gray-300 text-custom-red">
                                <span class="ml-2 text-sm text-gray-700">
                                All required documents have been submitted and verified
                            </span>
                            </label>
                            @error('documentSubmitted')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button"
                                wire:click="award"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                            <span wire:loading.remove>
                                Award Property
                            </span>
                            <span wire:loading class="flex items-center">
                                <svg class="animate-spin h-4 w-4 text-white mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                                Loading...
                            </span>
                        </button>
                        <button type="button"
                                wire:click="closeModal"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-red sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
