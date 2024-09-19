<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-5 relative">
                <div class="absolute inset-y-0 left-0 pl-3 mt-5 flex items-center pointer-events-none">
                    <svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <rect x="0.314941" y="0.882812" width="37" height="37" fill="url(#pattern0_280_3148)"/>
                        <defs>
                            <pattern id="pattern0_280_3148" patternContentUnits="objectBoundingBox" width="1" height="1">
                                <use xlink:href="#image0_280_3148" transform="scale(0.0111111)"/>
                            </pattern>
                            <image id="image0_280_3148" width="51" height="51" xlink:href="data:image/png;base64,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"/>
                        </defs>
                    </svg>
                </div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email"/>
            </div>

            <div class="mt-4 mb-5 relative">
                <div class="absolute inset-y-0 left-0 pl-3 mt-5 flex items-center pointer-events-none">
                    <svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <rect x="0.314941" y="0.882812" width="37" height="37" fill="url(#pattern0_280_3148)"/>
                        <defs>
                            <pattern id="pattern0_280_3148" patternContentUnits="objectBoundingBox" width="1" height="1">
                                <use xlink:href="#image0_280_3148" transform="scale(0.0111111)"/>
                            </pattern>
                            <image id="image0_280_3148" width="51" xlink:href="data:image/png;base64,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"/>
                        </defs>
                    </svg>
                </div>
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Password"/>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-green-600 hover:text-green-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
