<x-admin-wow-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    {{--                    <div class="sm:flex-auto">--}}
                    {{--                        <h1 class="text-base font-semibold leading-6 text-gray-900">Users</h1>--}}
                    {{--                        <p class="mt-2 text-sm text-gray-700">A list of all the users in your account including their name, title, email and role.</p>--}}
                    {{--                    </div>--}}
                    <div class="mt-4 sm:mt-0 sm:flex-none">
                        <a href="{{ route('admin.users.index') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 cursor-pointer">Users Index</a>
                    </div>
                </div>
                <div class="mt-6 p-4 bg-slate-100 rounded-md">
                    <div>User Name: {{ $user->name }}</div>
                    <div>Email: {{ $user->email }}</div>
                </div>

                <div class="mt-6 p-4 bg-slate-100 rounded-md">
                    <h2 class="text-2xl font-semibold">Roles</h2>
                    <div class="flex space-x-2 mt-4">
                        @if($user->roles)
                            @foreach($user->roles as $user_role)
                                <form method="POST" action="{{ route('admin.users.roles.remove', [$user->id, $user_role->id]) }}" onsubmit="return confirm('Are you sure?');" class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">{{ $user_role->name }}</button>
                                </form>
                            @endforeach
                        @endif
                    </div>
                    <div class="-mx-4 sm:-mx-0 mt-6">
                        <form method="POST" action="{{ route('admin.users.roles', $user->id) }}">
                            @csrf
                            <div class="sm:col-span-6">
                                <label for="role"
                                       class="block text-sm font-medium text-gray-700">Roles</label>
                                <select id="role" name="role" autocomplete="role-name"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="sm:col-span-6 pt-5">
                                <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Assign</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-slate-100 rounded-md">
                    <h2 class="text-2xl font-semibold">Permissions</h2>
                    <div class="flex space-x-2 mt-4">
                        @if($user->permissions)
                            @foreach($user->permissions as $user_permission)
                                <form method="POST" action="{{ route('admin.users.permissions.revoke', [$user->id, $user_permission->id]) }}" onsubmit="return confirm('Are you sure?');" class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">{{ $user_permission->name }}</button>
                                </form>
                            @endforeach
                        @endif
                    </div>
                    <div class="-mx-4 sm:-mx-0 mt-6">
                        <form method="POST" action="{{ route('admin.users.permissions', $user->id) }}">
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
