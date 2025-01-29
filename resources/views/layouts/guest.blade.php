<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

</head>

<body class="bg-gray-100 dark:bg-gray-900">

    <main class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 pt-8 mx-auto md:h-screen pt:mt-0 dark:bg-gray-900">
            <a href="{{ route('login') }}"
                class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
                <img src="{{ url('/') }}/images/logo.svg" class="mr-4 h-11" alt="FlowBite Logo">
                <span>CPDS-Online</span>
            </a>
            <!-- Card -->
            {{ $slot }}
        </div>

    </main>

    @livewireScripts

    <script data-navigate-once src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

    <script data-navigate-once src="{{ url('/') }}/buttons.github.io/buttons.js"></script>
    <script data-navigate-once src="{{ url('/') }}/app.bundle.js"></script>
    <script data-navigate-once src="{{ url('/') }}/cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.2/datepicker.min.js">
    </script>

    <svg id="SvgjsSvg1001" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1"
        xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev"
        style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;">
        <defs id="SvgjsDefs1002"></defs>
        <polyline id="SvgjsPolyline1003" points="0,0"></polyline>
        <path id="SvgjsPath1004" d="M0 0 "></path>
    </svg>
</body>

</html>
