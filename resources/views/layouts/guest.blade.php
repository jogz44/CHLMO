<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HLMS') }}</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

        <!-- Include Alpine.js (add this to your HTML head) -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Import Poppins font from Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="bg-gray-100 min-h-screen flex justify-center items-center" style="font-family:'Poppins', sans-serif;">
        <!-- Background Images -->
        <div class="absolute top-0 left-0 z-0">
            {{--left-top design--}}
            <svg width="959" height="730" viewBox="0 0 959 950" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g opacity="0.85">
                    <ellipse cx="137.865" cy="144.13" rx="639.695" ry="558.986" transform="rotate(-26.2257 137.865 144.13)" fill="#66A981" fill-opacity="0.5"/>
                    <ellipse cx="116.57" cy="100.903" rx="509.325" ry="484.026" transform="rotate(-26.2257 116.57 100.903)" fill="#4C9B6C" fill-opacity="0.8"/>
                    <ellipse cx="54.5247" cy="57.4554" rx="418.729" ry="417.633" transform="rotate(-26.2257 54.5247 57.4554)" fill="#328D56" fill-opacity="0.9"/>
                </g>
            </svg>
        </div>
        {{--right-bottom design--}}
        <div class="absolute bottom-0 right-0 z-0">
            <svg width="653" height="735" viewBox="0 0 853 935" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g opacity="0.45">
                    <ellipse cx="778.754" cy="770.914" rx="579" ry="522" transform="rotate(140.581 778.754 770.914)" fill="#66A981" fill-opacity="0.7"/>
                    <ellipse cx="807.328" cy="805.677" rx="461" ry="452" transform="rotate(140.581 807.328 805.677)" fill="#4C9B6C" fill-opacity="0.9"/>
                    <ellipse cx="872.19" cy="832.619" rx="379" ry="390" transform="rotate(140.581 872.19 832.619)" fill="#328D56"/>
                </g>
            </svg>
        </div>

        <div class="space-y-4">
            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>
