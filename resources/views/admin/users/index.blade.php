<x-admin-wow-layout>
    <div class="p-10 h-screen ml-[17%] mt-[60px]">
        <div class="grid grid-cols-4 gap-10 mb-6">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Users</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all the users in your account including their name, title, email and role.</p>
            </div>
        </div>
        <div class="-mx-4 mt-8 sm:-mx-0">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-bold text-gray-900 sm:pl-0">USERNAME</th>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-bold text-gray-900 sm:pl-0">NAME</th>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-bold text-gray-900 sm:pl-0">EMAIL</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($users as $user)
                    <tr>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                            <div class="flex items-center">
                                {{ $user->username }}
                            </div>
                        </td>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                            <div class="flex items-center">
                                {{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}
                            </div>
                        </td>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                            <div class="flex items-center">
                                {{ $user->email }}
                            </div>
                        </td>
                        {{--                                    <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-gray-500 sm:table-cell">Front-end Developer</td>--}}
                        {{--                                    <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-gray-500 lg:table-cell">lindsay.walton@example.com</td>--}}
                        {{--                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Member</td>--}}
                        <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                            <div class="flex justify-end">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="px-4 py-2 bg-custom-yellow text-white rounded-md">Roles</a>
                                    {{--                                                <a href="#" class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md">Delete</a>--}}
                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('Are you sure?');" class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- More people... -->
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-wow-layout>
