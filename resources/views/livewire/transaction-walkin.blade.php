<div x-data="{ openFilters: false }" class="p-10 h-screen  ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <!-- Main Content -->
        <div class="flex-1 h-screen p-6 overflow-auto">
            <div class="relative z-0 mb-2">
                @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
                @endif
            </div>
            <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-5 relative p-3">
                <div class="flex items-center">
                    <h2 class="text-[13px] ml-5 text-gray-700">APPLICANTS</h2>
                </div>
                <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                <div class="relative z-0">
                    <button wire:click="$set('isModalOpen', true)" class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-4 py-2 rounded">Add
                        Applicant
                    </button>
                </div>
            </div>

            <!-- Table with transaction requests -->
            <div x-data="{openModalAward: false, openModalTag: false, openPreviewModal: false, selectedFile: null, fileName: ''}"
                class="px-3 py-6 bg-white">
{{--                <livewire:walkin-applicants-table-v2/>--}}
                <div class="p-4">
                    <!-- Search Input -->
                    <div>
                        <input type="search" wire:model.debounce.300ms="search" placeholder="Search..." class="input input-bordered w-full mb-4">
                        <div>Search term: {{ $search }}</div>
                    </div>
                    <!-- Filters: Barangay and Purok -->
                    <div class="flex space-x-4 mb-4">
                        <div>
                            <select wire:model="barangay" class="select select-bordered">
                                <option value="">All Barangays</option>
                                @foreach ($barangays as $barangay)
                                    <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <select wire:model="purok" class="select select-bordered">
                                <option value="">All Puroks</option>
                                @foreach ($puroks as $purok)
                                    <option value="{{ $purok->id }}">{{ $purok->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <button wire:click="resetFilters" class="btn btn-outline w-full">Reset Filters</button>
                        </div>
                    </div>

                    <!-- Applicants Table -->
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                            <tr>
                                <th>Applicant ID</th>
                                <th>First Name</th>
                                <th>Contact Number</th>
                                <th>Barangay</th>
                                <th>Purok</th>
                                <th>Date Applied</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($applicants as $applicant)
                                <tr>
                                    <td>{{ $applicant->applicant_id }}</td>
                                    <td>{{ $applicant->first_name }}</td>
                                    <td>{{ $applicant->contact_number }}</td>
                                    <td>{{ $applicant->address->barangay->name ?? 'N/A' }}</td>
                                    <td>{{ $applicant->address->purok->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($applicant->date_applied)->format('m/d/Y') }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="bg-custom-red text-white px-4 py-2 rounded" wire:click="edit({{ $applicant->id }})">Edit</button>
                                        <!-- Tag Button -->
                                        @if ($applicant->taggedAndValidated)
                                            <span class="bg-gray-500 text-white px-4 py-2 rounded cursor-not-allowed">Tagged</span>
                                        @else
                                            <button onclick="window.location.href='{{ route('applicant-details', ['applicantId' => $applicant->id]) }}'"
                                                    class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-8 py-1.5 rounded-full">
                                                Tag
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">No applicants found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        setTimeout(function() {
                            var flashMessage = document.getElementById('flash-message');
                            if (flashMessage) {
                                flashMessage.style.transition = 'opacity 0.5s ease';  // Smooth fade-out effect
                                flashMessage.style.opacity = '0';  // Start fading out
                                setTimeout(function() {
                                    flashMessage.remove();  // Remove the element from the DOM after the fade-out
                                }, 500);  // Wait for the fade-out transition to complete (0.5s)
                            }
                        }, 3000);  // Delay before the fade-out starts (3 seconds)
                    });
                </script>
                <!-- Award Applicant Modal -->
                <div x-show="openModalAward"
                    class="fixed inset-0 flex z-50 items-center justify-center bg-black bg-opacity-50 shadow-lg"
                    x-cloak style="font-family: 'Poppins', sans-serif;">
                    <div class="bg-white text-white w-[400px] rounded-lg shadow-lg p-6 relative">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-black">AWARD APPLICANT</h3>
                            <button @click="openModalAward = false" class="text-gray-400 hover:text-gray-200">
                                &times;
                            </button>
                        </div>

                        <!-- Form -->
                        <form>
                            <!-- Award Date Field -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="award_date">AWARD
                                    DATE</label>
                                <input type="date" id="award_date"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                    placeholder="Award Date">
                            </div>

                            <div class="mb-4">
                                <br>
                                <label class="block text-sm font-medium mb-2 text-black" for="lot">LOT
                                    ALLOCATED</label>
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                    for="lot">BARANGAY</label>
                                <input type="text" id="lot"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                    placeholder="Barangay">
                            </div>

                            <!-- Purok Field -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black"
                                    for="awardee-purok">PUROK</label>
                                <input type="text" id="awardee-purok"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                    placeholder="Purok">
                            </div>

                            <!-- Contact Number Field -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="awardee-contact-number">CONTACT
                                    NUMBER</label>
                                <input type="text" id="awardee-contact-number"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                    placeholder="Contact Number">
                            </div>

                            <!-- Interviewer Field -->
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium mb-2 text-black" for="rawr">LOT
                                    SIZE ALLOCATED</label>
                                <input type="text" id="rawr"
                                    class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800  focus:outline-none focus:ring-2 focus:ring-blue-400 text-[12px]"
                                    placeholder="Lot Size Allocated">
                            </div>
                            <br>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <button type="submit"
                                    class="w-full py-2 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg">
                                    AWARD
                                </button>
                                <button type="button" @click="openModalAward = false"
                                    class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg">
                                    CANCEL
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ADD APPLICANT MODAL -->
            @if($isModalOpen)
            <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                <div class="bg-white text-white w-[450px] rounded-lg shadow-lg p-6 relative z-50">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-black">ADD APPLICANT</h3>
                        <button wire:click="$set('isModalOpen', false)" class="text-gray-400 hover:text-gray-200">
                            &times;
                        </button>
                    </div>

                    <!-- Livewire Form -->
                    <form wire:submit.prevent="store">
                        <x-validation-errors class="mb-4" />
                        <!-- Date Applied Field -->
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black" for="date_applied">APPLICATION DATE <span class="text-red-500">*</span></label>
                                <input type="date" id="date_applied" wire:model="date_applied" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none ">
                                @error('date_applied') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Transaction Type Field -->
{{--                            <div>--}}
{{--                                <label class="block text-[12px] font-medium mb-2 text-black" for="transaction_type">TRANSACTION TYPE</label>--}}
{{--                                <input type="text" wire:model="transaction-type-id" id="transaction-type-id" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" required>--}}
{{--                            </div>--}}
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black" for="transaction_type">TRANSACTION TYPE</label>
                                <select wire:model="transaction_type_id" id="transaction_type_id" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg text-gray-800 focus:outline-none text-[12px] uppercase" required>
                                    @foreach ($transactionTypes as $type)
                                        <option value="{{ $type->id }}" {{ $type->type_name == 'Walk-in' ? 'selected' : '' }}>{{ $type->type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Main Fields -->
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <!-- First Name Field -->
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black" for="first_name">FIRST NAME <span class="text-red-500">*</span> </label>
                                <input type="text" wire:model="first_name" id="first_name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" required>
                                @error('first_name') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Middle Name Field -->
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black" for="middle_name">MIDDLE NAME <span class="text-red-500">*</span> </label>
                                <input type="text" wire:model="middle_name" id="middle_name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase">
                                @error('middle_name') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Last Name Field -->
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black" for="last_name">LAST NAME <span class="text-red-500">*</span> </label>
                                <input type="text" wire:model="last_name" id="last_name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" required>
                                @error('last_name') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Suffix Name Field -->
                            <div>
                                <label class="block text-[12px] font-medium mb-2 text-black" for="suffix_name">SUFFIX NAME</label>
                                <input type="text" wire:model="suffix_name" id="suffix_name" class="w-full px-3 py-1 bg-white border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase">
                                @error('suffix_name') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Barangay Field -->
                        <div class="mb-3">
                            <label class="block text-[12px] font-medium mb-2 text-black" for="barangay">BARANGAY <span class="text-red-500">*</span> </label>
                            <select id="barangay" wire:model.live="barangay_id" class="w-full px-3 py-1 text-[12px] select2-barangay bg-white-700 border border-gray-600 rounded-lg text-gray-800 uppercase" required>
                                <option value="">Select Barangay</option>
                                @foreach($barangays as $barangay)
                                <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                @endforeach
                            </select>
                            @error('barangay_id') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Purok Field -->
                        <div class="mb-3">
                            <label class="block text-[12px] font-medium mb-2 text-black" for="purok">PUROK <span class="text-red-500">*</span> </label>
                            <select id="purok" wire:model.live="purok_id" class="w-full px-3 py-1 text-[12px] select2-purok bg-white-700 border border-gray-600 rounded-lg focus:outline-none text-gray-800 uppercase" required>
                                <option value="">Select Purok</option>
                                @foreach($puroks as $purok)
                                <option value="{{ $purok->id }}">{{ $purok->name }}</option>
                                @endforeach
                            </select>
                            @error('purok_id') <span class="error">{{ $message }}</span> @enderror
                        </div>


                        <!-- Contact Number Field -->
                        <div class="mb-6">
                            <label class="block text-[12px] font-medium mb-2 text-black" for="contact_number">CONTACT NUMBER</label>
                            <input type="text" wire:model="contact_number" id="contact_number" class="w-full px-3 py-1 bg-white-700 border border-gray-600 rounded-lg placeholder-gray-400 text-gray-800 focus:outline-none text-[12px] uppercase" placeholder="Contact Number">
                            @error('contact_number') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <!-- Award Button -->
                            <button type="submit"
                                class="w-full py-2 bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                <span class="text-[12px]"> + ADD APPLICANT</span>
                            </button>

                            <!-- Cancel Button -->
                            <button type="button" wire:click="$set('isModalOpen', false)"
                                class="w-full py-2 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg flex items-center justify-center space-x-2">
                                <span class="text-[12px]">CANCEL</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(function() {
                        var flashMessage = document.getElementById('flash-message');
                        if (flashMessage) {
                            flashMessage.style.transition = 'opacity 0.5s ease';  // Smooth fade-out effect
                            flashMessage.style.opacity = '0';  // Start fading out
                            setTimeout(function() {
                                flashMessage.remove();  // Remove the element from the DOM after the fade-out
                            }, 500);  // Wait for the fade-out transition to complete (0.5s)
                        }
                    }, 3000);  // Delay before the fade-out starts (3 seconds)
                });
            </script>
        </div>
    </div>
</div>