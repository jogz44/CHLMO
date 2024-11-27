<div>
    <div class="p-10 h-screen ml-[17%] mt-[60px]">
        <div x-data="{ openModal: false, openFilters: false}" class="flex bg-gray-100 text-[12px]">

            <!-- Main Content -->
            <div class="flex-1 h-screen p-6 overflow-auto">

                <!-- Container for the Title -->
                <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-0 relative p-3">
                    <div class="flex items-center">
                        <h2 class="text-[13px] ml-5 text-gray-700">MASTERLIST OF APPLICANTS</h2>
                    </div>
                    <img src="{{ asset('storage/images/design.png') }}"
                         alt="Design"
                         class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                </div>

                <!-- Search and Filters -->
                <div class="bg-white p-6 rounded shadow">
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2">
                            <!-- Search -->
                            <div class="relative hidden md:block border-gray-300 z-60">
                                <svg class="absolute top-[8px] left-4" width="19" height="19" viewBox="0 0 21 21"
                                     fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.625 16.625C13.491 16.625 16.625 13.491 16.625 9.625C16.625 5.75901 13.491 2.625 9.625 2.625C5.75901 2.625 2.625 5.75901 2.625 9.625C2.625 13.491 5.75901 16.625 9.625 16.625Z"
                                          stroke="#787C7F" stroke-width="1.75" stroke-linecap="round"
                                          stroke-linejoin="round" />
                                    <path d="M18.3746 18.375L14.5684 14.5688" stroke="#787C7F" stroke-width="1.75"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <input wire:model.live.debounce.300ms="search"
                                       type="search"
                                       name="search"
                                       class="rounded-md px-12 py-2 placeholder:text-[13px] z-60 border border-gray-300 bg-[#f7f7f9] hover:ring-custom-yellow focus:ring-custom-yellow"
                                       placeholder="Search by name...">
                            </div>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <select wire:model.live="filterApplicationType"
                                    class="border text-[13px] border-white text-gray-600 rounded px-2 py-1 shadow-sm">
                                <option value="">All Applications</option>
                                <option value="Housing Applicant">Housing Applicants</option>
                                <option value="Shelter Applicant">Shelter Applicants</option>
                            </select>
                            <select class="border text-[13px] border-white text-gray-600 rounded px-2 py-1 shadow-sm">
                                <option value="">Status</option>
                                <option value="status1">Status 1</option>
                                <option value="status2">Status 2</option>
                                <option value="status3">Status 3</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table for Applicants Master   list -->
                <div x-data="{ openModalAward: false, openModalTag: false, openPreviewModal: false, selectedFile: null, fileName: '' }" class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-2 border-b text-center font-medium">ID</th>
                            <th class="py-2 px-2 border-b text-start font-medium whitespace-nowrap">Name</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">Contact</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">Type</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">Date Applied</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">Status</th>
                            <th class="py-2 px-2 border-b text-center font-medium whitespace-nowrap">Aging</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse ($people as $person)
                                <tr>
                                    <td class="py-4 px-2 text-center border-b capitalize whitespace-nowrap">
                                        <div class="flex items-center justify-center">
                                            @if($person->application_type === 'Housing Applicant' && $person->applicants->first())
                                                {{ $person->applicants->first()->applicant_id }}
                                            @elseif($person->application_type === 'Shelter Applicant' && $person->shelterApplicants->first())
                                                {{ $person->shelterApplicants->first()->profile_no }}
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-2 border-b capitalize whitespace-normal break-words name-col">
                                        {{ $person->last_name }}, {{ $person->first_name }} {{ $person->middle_name }}
                                    </td>
                                    <td class="py-4 px-2 text-center border-b capitalize whitespace-normal break-words">
                                    @if($person->application_type === 'Housing Applicant' && $person->applicants->first())
                                        {{ $person->contact_number ?? 'N/A' }}
                                        @elseif($person->application_type === 'Shelter Applicant' && $person->shelterApplicants->first())
                                            {{ $person->shelterApplicants->first()->contact_number ?? 'N/A' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-4 px-2 text-center border-b capitalize whitespace-normal break-words">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $person->application_type === 'Housing Applicant' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ ucfirst($person->application_type) }}
                                            </span>
                                    </td>
                                    <td class="py-4 px-2 text-center border-b capitalize whitespace-normal break-words">
                                        @if($person->application_type === 'Housing Applicant' && $person->applicants->first())
                                            {{ $person->applicants->first()->date_applied->format('M d, Y') }}
                                        @elseif($person->application_type === 'Shelter Applicant' && $person->shelterApplicants->first())
                                            {{ $person->shelterApplicants->first()->date_request->format('M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-4 px-2 text-center border-b capitalize whitespace-normal break-words">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $person->application_type === 'Housing Applicant' && $person->applicants->first()?->is_tagged ? 'bg-green-100 text-green-800' :
                                                   ($person->application_type === 'Shelter Applicant' && $person->shelterApplicants->first()?->is_tagged ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ $person->application_type === 'Housing Applicant' && $person->applicants->first()?->is_tagged ? 'Tagged' :
                                                   ($person->application_type === 'Shelter Applicant' && $person->shelterApplicants->first()?->is_tagged ? 'Tagged' : 'Pending') }}
                                            </span>
                                    </td>
                                    <td class="py-4 px-2 text-center text-red-600 border-b whitespace-normal break-words">
                                        <div class="flex items-center justify-center w-full">
                                            @if($person->application_type === 'Housing Applicant' && $person->applicants->first())
                                                {{ $person->applicants->first()->date_applied->shortAbsoluteDiffForHumans() }}
                                            @elseif($person->application_type === 'Shelter Applicant' && $person->shelterApplicants->first())
                                                {{ $person->shelterApplicants->first()->date_request->shortAbsoluteDiffForHumans() }}
                                            @else
                                                N/A
                                            @endif
                                            <span class="ml-1">
                                                <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                <lord-icon src="https://cdn.lordicon.com/lzgqzxrq.json" trigger="loop" delay="3000" style="width: 20px; height: 20px"></lord-icon>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-4 px-2 text-center border-b">No applicants found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="mt-4">
                    {{ $people->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
