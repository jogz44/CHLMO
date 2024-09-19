<x-admin-wow-layout>
    <div class="p-10 h-screen ml-[17%] mt-[60px]">
        <div class="grid grid-cols-4 gap-10 mb-6">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    {{--                    <div class="sm:flex-auto">--}}
                    {{--                        <h1 class="text-base font-semibold leading-6 text-gray-900">Users</h1>--}}
                    {{--                        <p class="mt-2 text-sm text-gray-700">A list of all the users in your account including their name, title, email and role.</p>--}}
                    {{--                    </div>--}}
                    <div class="mt-4 sm:mt-0 sm:flex-none">
                        <a href="{{ route('admin.roles.index') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 cursor-pointer">Role Index</a>
                    </div>
                </div>
                <div class="mt-6 p-4 bg-slate-100 rounded-md">
                    {{--                    <form action=""></form>--}}
                    <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="sm:col-span-6">
                            <label for="name" class="block text-sm font-medium text-gray-700">Role</label>
                            <div class="mt-1">
                                <input type="text" id="name" name="name" class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" value="{{ $role->name }}"/>
                            </div>
                            @error('name')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="sm:col-span-6 pt-5">
                            <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Update</button>
                        </div>
                    </form>
                </div>

                <div class="mt-6 p-4 bg-slate-100 rounded-md">
                    <h2 class="text-2xl font-semibold">Role Permissions</h2>
                    <div class="flex space-x-2 mt-4">
                        @if($role->permissions)
                            @foreach($role->permissions as $role_permission)
                                <form method="POST" action="{{ route('admin.roles.permissions.revoke', [$role->id, $role_permission->id]) }}" onsubmit="return confirm('Are you sure?');" class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">{{ $role_permission->name }}</button>
                                </form>
                            @endforeach
                        @endif
                    </div>
                    <div class="-mx-4 sm:-mx-0 mt-6">
                        <form method="POST" action="{{ route('admin.roles.permissions', $role->id) }}">
                            @csrf
                            <div class="sm:col-span-6">
                                <label for="permission"
                                       class="block text-sm font-medium text-gray-700">Permissions</label>
                                <select id="permission" name="permission" autocomplete="permission-name"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                                @error('name')
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="sm:col-span-6 pt-5">
                                <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Assign</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin-wow-layout>
