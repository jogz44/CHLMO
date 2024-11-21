<div x-data="{ openFilters: false }" class="p-10  ml-[17%] mt-[60px]">
    <div class="flex bg-gray-100 text-[12px]">
        <!-- Main Content -->
        <div x-data="pagination()" class="flex-1 p-6 overflow-auto">
            <div class="bg-white rounded shadow mb-4 flex items-center justify-between z-0 relative p-3">
                <div class="flex items-center">
                    <h2 class="text-[13px] ml-5 text-gray-700">ACTIVITY LOGS</h2>
                </div>
                <img src="{{ asset('storage/images/design.png') }}" alt="Design" class="absolute right-0 top-0 h-full object-cover opacity-100 z-0">
                <div x-data class="relative z-0">
                    <button class="bg-custom-green text-white px-4 py-2 rounded">Export</button>
                </div>
            </div>

            <div class="bg-white p-4 rounded shadow">
            </div>

            <div x-data="{ openModalTransfer: false, openPreviewModal: false }" class="overflow-x-auto">
                <!-- Table with activity logs -->
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-2 border-b text-center font-medium text-[12px]">User</th>
                            <th class="py-2 px-2 border-b text-center font-medium text-[12px]">Role</th>
                            <th class="py-2 px-2 border-b text-center font-medium text-[12px]">Activity Description</th>
                            <th class="py-2 px-2 border-b text-center font-medium text-[12px]">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr class="cursor-pointer border-b">
                            <td class="px-6 py-2 text-center text-[12px]">
                            {{ optional($log->causer)->first_name ?? 'System' }}
                            {{ optional($log->causer)->last_name ?? 'System' }}
                            </td>
                            <td class="px-6 py-2 text-center text-[12px]">
                                {{ optional($log->causer->roles->first())->name ?? 'N/A' }} <!-- Display Role -->
                            </td>
                            <td class="px-6 py-2 text-center text-[12px]">
                                {{ $log->description }}
                            </td>
                            <td class="px-6 py-2 text-center text-[12px]">
                                <div>{{ $log->created_at->diffForHumans() }}</div>
                                <div>{{ $log->created_at->format('m/d/Y h:i A') }}</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                No activity logs available.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>