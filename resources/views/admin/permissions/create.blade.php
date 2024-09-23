<x-admin-wow-layout>
    <div class="p-10 h-screen ml-[17%] mt-[60px]">
        <div class="grid grid-cols-1 gap-10 mb-6">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Users</h1>
                        <p class="mt-2 text-sm text-gray-700">A list of all the users in your account including their name, title, email and role.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a href="{{ route('admin.permissions.index') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 cursor-pointer">Permission Index</a>
                    </div>
                </div>
                <div class="-mx-4 mt-8 sm:-mx-0">
                    {{--                    <form action=""></form>--}}
                    <form method="POST" action="{{ route('admin.permissions.store') }}">
                        @csrf
                        <div class="sm:col-span-6">
                            <label for="name" class="block text-sm font-medium text-gray-700">Permission</label>
                            <div class="mt-1">
                                <input type="text" id="name" name="name" class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                            </div>
                            @error('name') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="sm:col-span-6 pt-5">
                            <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-wow-layout>
