<div class="app-page">
    <div class="flex bg-gray-100 text-[12px]">
        <div x-data="{ isEditable: false, openPreviewModal: false }" class="flex-1 overflow-auto">
            <form wire:submit.prevent="grantApplicant">
                <div class="app-page-heading">
                    <div class="flex items-center">
                        <a href="{{ route('shelter-profiled-tagged-applicants') }}" class="z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-custom-yellow mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <h2 class="text-[13px] font-semibold ml-2 items-center text-gray-700">GRANT APPLICANT</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}" alt="Design"
                        class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                    <!-- Buttons -->
                    <div class="flex space-x-2  z-[60]">
                        <div>
                            <div class="alert mt-14"
                                :class="{primary:'alert-primary', success:'alert-success', danger:'alert-danger', warning:'alert-warning'}[(alert.type ?? 'primary')]"
                                x-data="{ open:false, alert:{} }"
                                x-show="open" x-cloak
                                x-transition:enter="animate-alert-show"
                                x-transition:leave="animate-alert-hide"
                                @alert.window="open = true; setTimeout( () => open=false, 3000 ); alert=$event.detail[0]">
                                <div class="alert-wrapper">
                                    <strong x-html="alert.title">Title</strong>
                                    <p x-html="alert.message">Description</p>
                                </div>
                                <i class="alert-close fa-solid fa-xmark" @click="open=false"></i>
                            </div>
                            <button type="submit"
                                class="w-full px-4 py-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                <span class="text-[12px]">GRANT</span>
                                <div wire:loading>
                                    <svg aria-hidden="true"
                                        class="w-5 h-5 mx-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="currentColor" />
                                        <path
                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentFill" />
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </button>
                        </div>
                        <script>
                            document.addEventListener('livewire.initialized', () => {
                                let obj = @json(session('alert') ?? []);
                                if (Object.keys(obj).length) {
                                    Livewire.dispatch('alert', [obj])
                                }
                            })
                        </script>
                    </div>
                </div>
                <!-- GRANT Modal -->



                <div class="bg-white rounded shadow p-6 mb-4 mt-6">
                    <div class="relative flex justify-between">
                        <div class="flex flex-wrap -mx-2 w-[50%] justify-items-start">
                            <!-- Tagging and Validation Date Field -->
                            <div class="w-full md:w-1/2 px-2 mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                    for="irs-date">DATE OF RIS</label>
                                <input type="date" id="irs-date" wire:model="date_of_ris" max="{{ now()->toDateString() }}" required
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]">
                                @error('date_of_ris') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-full md:w-1/2 px-2 mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                    for="delivery-date">DATE OF DELIVERY</label>
                                <input type="date" id="delivery-date" wire:model="date_of_delivery" required
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                    max="{{ now()->toDateString() }}">
                                @error('date_of_delivery') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-2 w-[50%] justify-items-end">
                            <div class="w-full md:w-1/2 px-2 mb-4 ml-auto">
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                    for="ar_no">AR N0.</label>
                                <input type="number" id="ar_no" wire:model="ar_no"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]">
                                @error('ar_no') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-2 mt-6 flex items-center justify-between">
                        <label class="text-[13px] font-semibold uppercase tracking-wide text-gray-700">Materials Delivered</label>
                        <span class="text-[11px] text-gray-400">{{ count($materials) }} {{ count($materials) === 1 ? 'item' : 'items' }}</span>
                    </div>

                    <div class="overflow-x-auto rounded-md border border-gray-200" x-data="{ query: '', suggestions: [], showSuggestions: false }" @click.away="showSuggestions = false">
                        <table class="min-w-full bg-white text-[12px]">
                            <thead>
                                <tr class="bg-gray-200 text-left text-[11px] uppercase tracking-wide">
                                    <th class="px-4 py-3 text-gray-800">Item</th>
                                    <th class="lg:w-32 px-4 py-3 text-center text-gray-800">Stock</th>
                                    <th class="lg:w-32 px-4 py-3 text-center text-gray-800">Qty</th>
                                    <th class="lg:w-40 px-4 py-3 text-center text-gray-800">Unit</th>
                                    <th class="lg:w-40 px-4 py-3 text-center text-gray-800">PO No.</th>
                                    <th class="lg:w-12 px-4 py-3 text-gray-800"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($materials as $index => $material)
                                <tr wire:key="material-{{ $index }}" class="odd:bg-gray-50/60 even:bg-white hover:bg-green-50/40">
                                    <td class="relative px-4 py-2">
                                        <input
                                            type="text"
                                            x-model="query"
                                            @input.debounce.300ms="$wire.searchMaterials(query).then(data => { suggestions = data; showSuggestions = true; })"
                                            placeholder="Type to search materials..."
                                            class="uppercase w-40 lg:w-full md:w-full rounded border border-transparent bg-transparent px-2 py-1.5 text-gray-800 focus:border-gray-300 focus:bg-white focus:outline-none">
                                        @error('materials.' . $index . '.material_id')
                                        <span class="mt-1 block text-[11px] text-red-600">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="text" wire:model="materials.{{ $index }}.available_quantity" readonly class="uppercase w-20 lg:w-full md:w-full rounded border border-transparent bg-transparent px-1 py-1.5 text-center text-gray-800 focus:outline-none" placeholder="Available">
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="number" wire:model="materials.{{ $index }}.grantee_quantity" required class="w-20 lg:w-full md:w-full rounded border border-transparent bg-transparent px-1 py-1.5 text-center text-gray-800 focus:border-gray-300 focus:bg-white focus:outline-none" placeholder="0">
                                        @error('materials.' . $index . '.grantee_quantity') <span class="mt-1 block text-[11px] text-red-600">{{ $message }}</span> @enderror
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="text" wire:model="materials.{{ $index }}.materialUnitDisplay" readonly class="uppercase w-20 lg:w-full md:w-full rounded border border-transparent bg-transparent px-1 py-1.5 text-center text-gray-800 focus:outline-none" placeholder="Unit">
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="text" wire:model="materials.{{ $index }}.purchaseOrderDisplay" readonly class="uppercase w-20 lg:w-full md:w-full rounded border border-transparent bg-transparent px-1 py-1.5 text-center text-gray-800 focus:outline-none" placeholder="PO Number">
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <button
                                            type="button"
                                            wire:click="removeMaterial({{ $index }})"
                                            class="rounded p-1 text-gray-400 hover:bg-red-50 hover:text-red-600"
                                            title="Remove material">
                                            &#x2715;
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-[12px] text-gray-400">
                                        No materials added yet. Click "Add Material" to get started.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div x-show="showSuggestions && suggestions.length" class="absolute">
                            <ul x-cloak class="left-4 right-4 z-10 mt-1 max-h-44 overflow-y-auto rounded-md border border-gray-200 bg-white py-1 text-[12px] uppercase text-gray-700 shadow-lg">
                                <template x-for="(item, suggestionIndex) in suggestions" :key="suggestionIndex">
                                    <li
                                        @click="$wire.selectMaterial({{ $index }}, item.id); query = item.item_description; showSuggestions = false;"
                                        class="cursor-pointer px-3 py-2 hover:bg-green-50">
                                        <span class="font-medium" x-text="item.item_description"></span>
                                        <span class="ml-2 text-gray-500" x-text="item.purchaseOrderDisplay ? item.purchaseOrderDisplay : 'PO: Not available'"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button
                            type="button"
                            wire:click="addMaterial"
                            class="flex items-center gap-1.5 rounded-md border border-green-600 px-3 py-1.5 text-[12px] font-medium text-green-700 hover:bg-green-50">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Add Material
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded shadow py-4 px-6 mb-4 mt-4">
                    <div class="p-3 rounded">
                        <h2 class="block text-[12px] font-semibold text-gray-700">UPLOAD PHOTO</h2>
                        <p class="text-gray-500 text-xs">Upload here the photo after delivery.</p>
                    </div>

                    <div class="mx-auto w-full">
                        <div wire:ignore x-data="{ isUploading: false }" x-init="
                            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType);
                            const pond = FilePond.create($refs.input, {
                                allowMultiple: true,
                                acceptedFileTypes: ['image/*'],
                                labelIdle: 'Drag & Drop your photos or <span class=&quot;filepond--label-action&quot;>Browse</span>',
                                server: {
                                    process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                                        @this.upload('images', file,
                                            (uploadedFileName) => {
                                                load(uploadedFileName);
                                            },
                                            () => {
                                                error('Upload failed');
                                            },
                                            (event) => {
                                                progress(event.lengthComputable, event.loaded, event.total);
                                            }
                                        );
                                    },
                                    revert: (filename, load) => {
                                        @this.removeUpload('images', filename, load);
                                    }
                                },
                                allowProcess: true
                            });
                        ">
                            <input type="file" x-ref="input" multiple accept="image/*">
                            @error('images.*')
                            <span class="mt-2 block text-[11px] text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>