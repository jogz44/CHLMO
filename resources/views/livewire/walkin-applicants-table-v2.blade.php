{{--<div class="p-4">--}}
{{--    <!-- Search Input -->--}}
{{--    <input type="text" wire:model.debounce.500ms="search" placeholder="Search..." class="input input-bordered w-full mb-4">--}}

{{--    <!-- Filters: Barangay and Purok -->--}}
{{--    <div class="flex space-x-4 mb-4">--}}
{{--        <div>--}}
{{--            <select wire:model="barangay" class="select select-bordered">--}}
{{--                <option value="">All Barangays</option>--}}
{{--                @foreach ($barangays as $barangay)--}}
{{--                    <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}

{{--        <div>--}}
{{--            <select wire:model="purok" class="select select-bordered">--}}
{{--                <option value="">All Puroks</option>--}}
{{--                @foreach ($puroks as $purok)--}}
{{--                    <option value="{{ $purok->id }}">{{ $purok->name }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <!-- Applicants Table -->--}}
{{--    <table class="table-auto w-full">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th>Applicant ID</th>--}}
{{--            <th>Full Name</th>--}}
{{--            <th>Contact Number</th>--}}
{{--            <th>Barangay</th>--}}
{{--            <th>Purok</th>--}}
{{--            <th>Date Applied</th>--}}
{{--            <th>Actions</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @foreach($applicants as $applicant)--}}
{{--            <tr>--}}
{{--                <td>{{ $applicant->applicant_id }}</td>--}}
{{--                <td>{{ $applicant->last_name }}, {{ $applicant->first_name }} {{ $applicant->middle_name }}</td>--}}
{{--                <td>{{ $applicant->contact_number }}</td>--}}
{{--                <td>{{ $applicant->address->barangay->name ?? 'N/A' }}</td>--}}
{{--                <td>{{ $applicant->address->purok->name ?? 'N/A' }}</td>--}}
{{--                <td>{{ \Carbon\Carbon::parse($applicant->date_applied)->format('m/d/Y') }}</td>--}}
{{--                <td>--}}
{{--                    <!-- Edit Button -->--}}
{{--                    <button class="bg-custom-red text-white px-4 py-2 rounded" wire:click="edit({{ $applicant->id }})">Edit</button>--}}
{{--                    <!-- Tag Button -->--}}
{{--                    @if ($applicant->taggedAndValidated)--}}
{{--                        <span class="bg-gray-500 text-white px-4 py-2 rounded cursor-not-allowed">Tagged</span>--}}
{{--                    @else--}}
{{--                        <button onclick="window.location.href='{{ route('applicant-details', ['applicantId' => $applicant->id]) }}'"--}}
{{--                                class="bg-gradient-to-r from-custom-red to-green-700 hover:bg-gradient-to-r hover:from-custom-green hover:to-custom-green text-white px-8 py-1.5 rounded-full">--}}
{{--                            Tag--}}
{{--                        </button>--}}
{{--                    @endif--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        </tbody>--}}
{{--    </table>--}}

{{--    <!-- Pagination -->--}}
{{--    <div class="mt-4">--}}
{{--        {{ $applicants->links() }}--}}
{{--    </div>--}}
{{--</div>--}}
{{--<script>--}}
{{--    document.addEventListener('DOMContentLoaded', function() {--}}
{{--        setTimeout(function() {--}}
{{--            var flashMessage = document.getElementById('flash-message');--}}
{{--            if (flashMessage) {--}}
{{--                flashMessage.style.transition = 'opacity 0.5s ease';  // Smooth fade-out effect--}}
{{--                flashMessage.style.opacity = '0';  // Start fading out--}}
{{--                setTimeout(function() {--}}
{{--                    flashMessage.remove();  // Remove the element from the DOM after the fade-out--}}
{{--                }, 500);  // Wait for the fade-out transition to complete (0.5s)--}}
{{--            }--}}
{{--        }, 3000);  // Delay before the fade-out starts (3 seconds)--}}
{{--    });--}}
{{--</script>--}}
