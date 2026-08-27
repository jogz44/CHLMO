<div class="app-page">
    <div class="mb-5 flex flex-col gap-3 z-0 relative rounded bg-white p-4 shadow sm:flex-row sm:items-center sm:justify-between">
     <div class="flex-col items-center">
                        <h1 class="font-semibold text-[14px] text-gray-800">Shelter System Configuration</h1>
                        <p class="mt-1 text-[12px] text-gray-500">Manage lookup values directly from each card.</p>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}"
                         alt="Design"
                         class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                </div>

    @if (session('message'))
        <div class="mb-5 rounded border border-green-200 bg-green-50 px-4 py-3 text-[12px] text-green-700">
            {{ session('message') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-5 rounded border border-red-200 bg-red-50 px-4 py-3 text-[12px] text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-5 xl:grid-cols-2 2xl:grid-cols-3">
        @foreach ($this->cards as $card)
            <section wire:key="card-{{ $card['key'] }}" class="flex flex-col rounded bg-white p-4 shadow">
                <div class="mb-4 flex items-start justify-between gap-3 border-b border-gray-100 pb-3">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-800">{{ $card['label'] }}</h2>
                        <p class="text-[12px] text-gray-500">
                            Showing {{ $card['items']->count() }} of {{ $card['total'] }} records
                        </p>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="mb-2 block text-[12px] font-medium text-gray-600">Search</label>
                    <input
                        type="search"
                        wire:model.live.debounce.400ms="search.{{ $card['key'] }}"
                        class="w-full rounded border border-gray-300 bg-gray-50 px-3 py-2 text-[12px] text-gray-700 focus:border-green-600 focus:ring-green-600"
                        placeholder="Search {{ $card['label'] }}"
                    >
                </div>

                <form wire:submit.prevent="addItem('{{ $card['key'] }}')" class="mb-4 flex gap-2">
                    <input
                        type="text"
                        wire:model="newValue.{{ $card['key'] }}"
                        class="min-w-0 flex-1 rounded border border-gray-300 bg-white px-3 py-2 text-[12px] text-gray-700 focus:border-green-600 focus:ring-green-600"
                        placeholder="Add {{ $card['label'] }}"
                    >
                    <button type="submit" class="rounded bg-green-700 px-4 py-2 text-[12px] font-semibold text-white hover:bg-green-600">
                        Add
                    </button>
                </form>
                @error('newValue.' . $card['key'])
                    <p class="mb-3 text-[11px] text-red-600">{{ $message }}</p>
                @enderror

                @if ($card['items']->count() > 0)
                    <div x-data="{ expanded: false }" wire:key="list-{{ $card['key'] }}">
                        <div
                            class="relative space-y-2 overflow-hidden transition-[max-height] duration-300 ease-in-out"
                            :class="expanded ? 'max-h-none' : 'max-h-[260px]'"
                        >
                            @foreach ($card['items'] as $item)
                                <div wire:key="item-{{ $card['key'] }}-{{ $item->id }}" class="flex items-center justify-between gap-3 rounded border border-gray-200 bg-gray-50 px-3 py-2">
                                    <span class="min-w-0 break-words text-[12px] text-gray-700">{{ $item->{$card['column']} }}</span>
                                    <button
                                        type="button"
                                        wire:click="confirmRemove('{{ $card['key'] }}', {{ $item->id }})"
                                        class="text-[12px] font-medium text-red-600 hover:text-red-700"
                                    >
                                        Remove
                                    </button>
                                </div>
                            @endforeach

                            <div
                                x-show="!expanded"
                                class="pointer-events-none absolute inset-x-0 bottom-0 h-5 bg-gradient-to-t from-white to-transparent"
                            ></div>
                        </div>

                        @if ($card['items']->count() > 5)
                            <button
                                type="button"
                                @click="expanded = !expanded"
                                class="mt-2 text-[12px] font-medium text-green-700 hover:text-green-600"
                                x-text="expanded ? 'Show less' : 'Show more ({{ $card['items']->count() }})'"
                            ></button>
                        @endif
                    </div>
                @else
                    <div class="rounded border border-dashed border-gray-300 px-3 py-6 text-center text-[12px] text-gray-500">
                        No records found.
                    </div>
                @endif
            </section>
        @endforeach

        <section class="flex flex-col rounded bg-white p-4 shadow xl:col-span-2 2xl:col-span-1">
            <div class="mb-4 flex items-start justify-between gap-3 border-b border-gray-100 pb-3">
                <div>
                    <h2 class="text-sm font-semibold text-gray-800">Purok</h2>
                    <p class="text-[12px] text-gray-500">Showing {{ $this->puroks->count() }} records</p>
                </div>
            </div>

            <div class="mb-4">
                <label class="mb-2 block text-[12px] font-medium text-gray-600">Search</label>
                <input
                    type="search"
                    wire:model.live.debounce.400ms="purokSearch"
                    class="w-full rounded border border-gray-300 bg-gray-50 px-3 py-2 text-[12px] text-gray-700 focus:border-green-600 focus:ring-green-600"
                    placeholder="Search Purok or Barangay"
                >
            </div>

            <form wire:submit.prevent="addPurok" class="mb-4 grid grid-cols-1 gap-2 md:grid-cols-[1fr_1fr_auto]">
                <input
                    type="text"
                    wire:model="newPurok"
                    class="rounded border border-gray-300 bg-white px-3 py-2 text-[12px] text-gray-700 focus:border-green-600 focus:ring-green-600"
                    placeholder="Add Purok"
                >
                <select
                    wire:model="barangay_id"
                    class="rounded border border-gray-300 bg-white px-3 py-2 text-[12px] text-gray-700 focus:border-green-600 focus:ring-green-600"
                >
                    <option value="">Select Barangay</option>
                    @foreach ($this->barangays as $barangay)
                        <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded bg-green-700 px-4 py-2 text-[12px] font-semibold text-white hover:bg-green-600">
                    Add
                </button>
            </form>
            @error('newPurok') <p class="mb-2 text-[11px] text-red-600">{{ $message }}</p> @enderror
            @error('barangay_id') <p class="mb-2 text-[11px] text-red-600">{{ $message }}</p> @enderror

            @if ($this->puroks->count() > 0)
                <div x-data="{ expanded: false }" wire:key="list-purok">
                    <div
                        class="relative space-y-2 overflow-hidden transition-[max-height] duration-300 ease-in-out"
                        :class="expanded ? 'max-h-none' : 'max-h-[260px]'"
                    >
                        @foreach ($this->puroks as $purok)
                            <div wire:key="purok-{{ $purok->id }}" class="flex items-center justify-between gap-3 rounded border border-gray-200 bg-gray-50 px-3 py-2">
                                <div class="min-w-0">
                                    <p class="break-words text-[12px] font-medium text-gray-800">{{ $purok->name }}</p>
                                    <p class="break-words text-[11px] text-gray-500">
                                        Barangay: {{ $purok->barangay?->name ?? 'Unassigned' }}
                                    </p>
                                </div>
                                <button
                                    type="button"
                                    wire:click="confirmRemove('purok', {{ $purok->id }})"
                                    class="text-[12px] font-medium text-red-600 hover:text-red-700"
                                >
                                    Remove
                                </button>
                            </div>
                        @endforeach

                        <div
                            x-show="!expanded"
                            class="pointer-events-none absolute inset-x-0 bottom-0 h-10 bg-gradient-to-t from-white to-transparent"
                        ></div>
                    </div>

                    @if ($this->puroks->count() > 5)
                        <button
                            type="button"
                            @click="expanded = !expanded"
                            class="mt-2 text-[12px] font-medium text-green-700 hover:text-green-600"
                            x-text="expanded ? 'Show less' : 'Show more ({{ $this->puroks->count() }})'"
                        ></button>
                    @endif
                </div>
            @else
                <div class="rounded border border-dashed border-gray-300 px-3 py-6 text-center text-[12px] text-gray-500">
                    No puroks found.
                </div>
            @endif
        </section>
    </div>

    @if ($showConfirmModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
            <div class="w-50 max-w-sm rounded bg-white p-5 shadow-lg">
                <h3 class="mb-2 text-sm font-semibold text-gray-800">Confirm removal</h3>
                <p class="mb-4 text-[12px] text-gray-600">Are you sure you want to remove this record?</p>
                <div class="flex justify-end gap-2">
                    <button wire:click="cancelRemove" type="button" class="rounded border border-gray-300 px-3 py-2 text-[12px] text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button wire:click="removeConfirmed" type="button" class="rounded bg-red-600 px-3 py-2 text-[12px] font-semibold text-white hover:bg-red-500">
                        Remove
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>