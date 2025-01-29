<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap"
        rel="stylesheet">


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="bg-gray-50mine  bg-gray-200 dark:bg-gray-900">

    <livewire:navbars.cod-navbar />

    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">

        <livewire:sidebars.cod-sidebar />

        <div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>

        <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-200 lg:ml-64 dark:bg-gray-900">
            <main>
                {{ $slot }}
            </main>

            <x-footer />

        </div>

    </div>


    {{-- scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @livewireScripts
    <script data-navigate-track data-navigate-once src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js">
    </script>

    <script data-navigate-track src="{{ url('/') }}/buttons.github.io/buttons.js"></script>
    <script data-navigate-track src="{{ url('/') }}/app.bundle.js"></script>
    <script data-navigate-track src="{{ url('/') }}/cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.2/datepicker.min.js">
    </script>
</body>

</html>
