<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Housing System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-poppins antialiased bg-gray-100">
    <!-- Sidebar -->
    <x-sidebar/>

    <!-- Header -->
    <x-header/>

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Toastr script for livewire -->
    <script>
        $(document).ready(function (){
            toastr.options = {
                "progressBar": true,
                "positionClass": "toast-top-right"
            }
        });

        window.addEventListener('success', event => {
            toastr.success(event.details.message);
        });
        window.addEventListener('warning', event => {
            toastr.warning(event.details.message);
        });
        window.addEventListener('error', event => {
            toastr.error(event.details.message);
        });
    </script>

    @stack('modals')
    @stack('scripts')
    <!-- Scripts -->
    @livewireScripts
</body>
</html>
