<div class="p-10 h-screen ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <div class="flex-1 p-6 overflow-auto">
            <!-- Header -->
            <div class="bg-white rounded shadow mb-4 flex items-center justify-between p-3 fixed top-[80px] left-[20%] right-[3%] z-10">
                <div class="flex items-center">
                    <a href="{{ route('awardee-list') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                             stroke="currentColor" class="w-5 h-5 text-custom-yellow mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h2 class="text-[13px] ml-2 items-center text-gray-700">Awardee Personal Information</h2>
                </div>
                <img src="{{ asset('storage/images/design.png') }}" alt="Design"
                     class="absolute right-0 top-0 h-full object-cover 0 z-0">
                <div class="flex space-x-2 z-0">
                    @if ($awardee->is_blacklisted)
                        <button class="bg-gray-500 text-white text-xs font-semibold px-6 py-2 rounded cursor-not-allowed">
                            BLACKLISTED
                        </button>
                    @else
                        @livewire('award-awardee', ['awardee' => $awardee])
                        @livewire('transfer-awardee', ['awardee' => $awardee])
                        <button
                                class="bg-custom-dark-green text-white text-xs font-semibold px-6 py-2 rounded"
                                wire:click="$set('isBlacklistModalOpen', true)">
                            <span wire:loading.remove>
                                BLACKLIST
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
                </div>
            </div>

            <!-- Awardee Info -->
            <div class="flex flex-col p-3 rounded mt-11">
                <h2 class="text-[30px] items-center font-bold text-gray-700 underline">{{ $applicant->applicant_id }}</h2>
                <h1 class="text-[25px] items-center font-bold text-gray-700">
                    {{ $awardee->taggedAndValidatedApplicant->applicant->person->full_name }}
                </h1>
                <h1 class="text-[15px] items-center font-regular text-gray-700">
                    Previous Awardee:
                </h1>
            </div>

            <!-- DOCUMENT GRID -->
            <div class="bg-white p-6 rounded shadow mb-6">
                <h1 class="text-[20px] font-bold text-gray-700 mb-4">
                    Documents Submitted
                </h1>
                <button wire:click="$set('showEditDocumentsModal', true)"
                        class="bg-custom-red text-white px-4 py-2 rounded-md text-sm flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </button>

                <!-- Image Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
                    @forelse($documents as $document)
                        <div class="flex flex-col">
                            <!-- Document Card -->
                            <div class="relative group cursor-pointer h-48" wire:click="viewDocument({{ $document->id }})">
                                @if(Str::contains($document->file_type, 'image'))
                                    <img src="{{ asset('storage/' . $document->file_path) }}"
                                         alt="{{ $document->document_name }}"
                                         class="w-full h-full object-cover rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 z-10">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 18h12V6h-4V2H4v16zm-2 1V1h11l5 5v13H2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-2 text-sm rounded-b-lg">
                                    Click to view
                                </div>
                            </div>
                            <!-- Document Name -->
                            <div class="mt-2 text-center">
                                <h3 class="text-sm font-medium text-gray-900 truncate" title="{{ $document->document_name }}">
                                    {{ $document->document_name }}
                                </h3>
                                <p class="text-xs text-gray-500">
                                    Uploaded {{ $document->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-4 text-gray-500">
                            No documents available
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Document Viewer Modal -->
            @if($selectedDocument)
                <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg p-4 max-w-4xl max-h-[90vh] overflow-auto">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-lg font-semibold">{{ $selectedDocument->document_name }}</h3>
                                <p class="text-sm text-gray-500">Uploaded {{ $selectedDocument->created_at->diffForHumans() }}</p>
                            </div>
                            <button wire:click="closeDocumentViewer" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        @if(Str::contains($selectedDocument->file_type, 'image'))
                            <img src="{{ asset('storage/' . $document->file_path) }}"
                                 alt="{{ $document->document_name }}"
                                 class="max-w-full h-auto">
                        @else
                            <div class="text-center py-8">
                                <a href="{{ Storage::url($selectedDocument->file_path) }}"
                                   target="_blank"
                                   class="bg-custom-red text-white px-4 py-2 rounded">
                                    Download Document
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Edit Documents Modal -->
            <div class="modal" wire:model="showEditDocumentsModal">
                @if($showEditDocumentsModal)
                    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
                            <!-- Background overlay -->
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                            <!-- Modal panel -->
                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                                <form wire:submit.prevent="updateDocuments">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="flex justify-between items-center pb-4 mb-4 border-b">
                                            <h3 class="text-lg font-semibold text-gray-900">Edit Documents</h3>
                                            <button type="button" wire:click="$set('showEditDocumentsModal', false)" class="text-gray-400 hover:text-gray-500">
                                                <span class="sr-only">Close</span>
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Current Documents -->
                                        <div class="mb-6">
                                            <h4 class="text-sm font-medium text-gray-700 mb-2">Current Documents</h4>
                                            <div class="grid grid-cols-3 gap-4">
                                                @forelse($existingDocuments as $document)
                                                    <div class="relative group">
                                                        @if(Str::contains($document['file_type'], 'image'))
                                                            <img src="{{ asset('storage/' . $document['file_path']) }}"
                                                                 alt="{{ $document['document_name'] }}"
                                                                 class="w-full h-48 object-cover rounded-lg">
                                                        @else
                                                            <div class="w-full h-48 flex items-center justify-center bg-gray-100 rounded-lg">
                                                                <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M4 18h12V6h-4V2H4v16zm-2 1V1h11l5 5v13H2z"></path>
                                                                </svg>
                                                            </div>
                                                        @endif

                                                        <!-- Document Name Input -->
                                                        <div class="mt-2">
                                                            <input type="text"
                                                                   wire:model="existingDocumentNames.{{ $document['id'] }}"
                                                                   class="w-full px-2 py-1 text-sm border rounded focus:ring-blue-500 focus:border-blue-500"
                                                                   placeholder="Document name">
                                                            @error('existingDocumentNames.' . $document['id'])
                                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <!-- Delete Button -->
                                                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                            <button type="button"
                                                                    wire:click="removeDocument({{ $document['id'] }})"
                                                                    class="bg-red-600 text-white rounded-full p-2 hover:bg-red-700">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="col-span-3 text-center py-4 text-gray-500">
                                                        No documents available
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>

                                        <!-- Upload New Documents -->
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-700 mb-2">Upload New Documents</h4>
                                            <div class="mt-2"
                                                 x-data="{ isUploading: false, progress: 0 }"
                                                 x-on:livewire-upload-start="isUploading = true"
                                                 x-on:livewire-upload-finish="isUploading = false"
                                                 x-on:livewire-upload-error="isUploading = false"
                                                 x-on:livewire-upload-progress="progress = $event.detail.progress">

                                                <!-- File Input -->
                                                <div class="flex items-center justify-center w-full">
                                                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                            <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                            </svg>
                                                            <p class="mb-2 text-sm text-gray-500">
                                                                <span class="font-semibold">Click to upload</span> or drag and drop
                                                            </p>
                                                            <p class="text-xs text-gray-500">PNG, JPG or JPEG (MAX. 2MB per file)</p>
                                                        </div>
                                                        <input id="dropzone-file"
                                                               type="file"
                                                               wire:model="newDocuments"
                                                               class="hidden"
                                                               multiple
                                                               accept="image/*">
                                                    </label>
                                                </div>

                                                <!-- Upload Progress Bar -->
                                                <div x-show="isUploading" class="mt-4">
                                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                        <div class="bg-blue-600 h-2.5 rounded-full" x-bind:style="'width: ' + progress + '%'"></div>
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-1" x-text="'Uploading: ' + progress + '%'"></div>
                                                </div>

                                                <!-- Preview Section with Name Inputs -->
                                                @if($newDocuments)
                                                    <div class="mt-4 grid grid-cols-3 gap-4">
                                                        @foreach($newDocuments as $index => $document)
                                                            <div class="relative">
                                                                <img src="{{ $document->temporaryUrl() }}"
                                                                     class="w-full h-48 object-cover rounded-lg">

                                                                <!-- Document Name Input -->
                                                                <div class="mt-2">
                                                                    <input type="text"
                                                                           wire:model="newDocumentNames.{{ $index }}"
                                                                           class="w-full px-2 py-1 text-sm border rounded focus:ring-blue-500 focus:border-blue-500"
                                                                           placeholder="Document name">
                                                                    @error('newDocumentNames.' . $index)
                                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                                    @enderror
                                                                </div>

                                                                <!-- Remove Button -->
                                                                <button type="button"
                                                                        wire:click="removeNewDocument({{ $index }})"
                                                                        class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 hover:bg-red-700">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                @error('newDocuments.*')
                                                <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit"
                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Save Changes
                                        </button>
                                        <button type="button"
                                                wire:click="$set('showEditDocumentsModal', false)"
                                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Blacklist Modal -->
            @if($isBlacklistModalOpen)
                <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg p-6 max-w-md w-full">
                        <h3 class="text-lg font-semibold mb-4">Blacklist Awardee</h3>

                        <form wire:submit.prevent="confirmBlacklist">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Date</label>
                                    <input type="date" wire:model="blacklistForm.date_blacklisted"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('blacklistForm.date_blacklisted') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Reason</label>
                                    <textarea wire:model="blacklistForm.reason"
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                              rows="3"></textarea>
                                    @error('blacklistForm.reason') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                    <input type="password" wire:model="blacklistForm.confirmation_password"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('blacklistForm.confirmation_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="submit"
                                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                    <span wire:loading.remove>
                                        Confirm Blacklist
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
                                        wire:click="$set('isBlacklistModalOpen', false)"
                                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

