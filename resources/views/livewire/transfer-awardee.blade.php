<div>
    <div x-data="{ showModal: false }">
        <button
            class="bg-amber-400 hover:bg-amber-500 text-white text-xs font-semibold px-6 py-2 rounded"
            @click="showModal = true">
            TRANSFER
        </button>

        <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" x-transition>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div class="relative bg-white rounded-lg max-w-lg w-full p-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium">Confirm Transfer</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Are you sure you want to transfer the lot from {{ $awardee->taggedAndValidatedApplicant->applicant->person->full_name }}?
                            This will mark them as a previous awardee and allow you to assign a new occupant.
                        </p>
                    </div>

                    <div class="mt-5 flex justify-end gap-3">
                        <button
                            class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded text-sm"
                            @click="showModal = false">
                            Cancel
                        </button>
                        <button
                            class="bg-amber-400 hover:bg-amber-500 text-white px-4 py-2 rounded text-sm"
                            wire:click="initiateTransfer">
                            Proceed with Transfer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
