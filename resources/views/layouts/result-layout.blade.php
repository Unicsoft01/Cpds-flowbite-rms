<html>

<head>
    <meta charset="utf-8">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ url('/') }}/images/logo.png" type="image/x-icon">

    <script type="text/javascript" src="{{ url('/') }}/sbyte/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/sbyte/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/sbyte/font-awesome.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap"
        rel="stylesheet">
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&family=Work+Sans&display=swap"
        rel="stylesheet"> --}}

    <!-- <script src="bootstrap.min.js"></script> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

</head>

{{-- <body style="font-family: 'Work Sans','Roboto Slab', 'Times New Roman', Times, serif"> --}}

<body>


    <nav
        class="print:hidden mb-40 bg-gray-900 text-white fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <div>
                <a href="{{ route('results.index') }}"
                    class="text-white bg-blue-700 hover:text-white hover:bg-blue-800 font-sm rounded-lg text-xl px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mr-2">
                    back
                </a>
                <button type="button" wire:click='$refresh'
                    class="text-white bg-green-700 hover:bg-blue-800 font-sm rounded-lg text-xl px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Reload
                </button>
            </div>
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="https://flowbite.com/docs/images/logo.png" class="h-8" alt="Flowbite Logo">
                <span
                    class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">CPDS-PAAU-Online</span>
            </a>
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">

                @if (Route::is('results.page'))
                    <button type="button"
                        class="reveal text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-2xl px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Hide Result Status
                    </button>
                @endif

                {{-- 
                <button type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-2xl px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Hide
                </button> --}}
                {{-- {{ $actions }} --}}
                @yield('actions')


            </div>
        </div>
    </nav>
    <div class="print:hidden" style="margin-bottom: 70px;"></div>

    @yield('content')

    @livewireScripts

    <script data-navigate-track data-navigate-once src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js">
    </script>
    <script>
        // event.ctrlKey
        // event.altKey
        // event.metaKey
        $(document).on('keydown', function(e) {
            // You may replace `c` with whatever key you want
            if ((e.metaKey || e.ctrlKey) && (String.fromCharCode(e.which).toLowerCase() === 'p')) {
                window.print();
            }
        });


        $(document).bind('keypress', function(event) {
            if (event.which === 80 && event.shiftKey) {
                window.print();
            }
        });

        $(document).keyup(function(e) {
            //find out which key was pressed
            switch (e.keyCode) {
                case 80:
                    window.print();
                    break; // p
                    // case 65	:	console.log('a');	break;	// a
                    // case 66	:	console.log('b');	break;	// b
                    // case 67	:	console.log('c');	break;	// c
                    // case 68	:	console.log('d');	break;	// d
                    // case 69	:	console.log('e');	break;	// e
                    // case 70	:	console.log('f');	break;	// f
                    // case 71	:	console.log('g');	break;	// g
                    // case 72	:	console.log('h');	break;	// h
                    // case 73	:	console.log('i');	break;	// i
                    // case 74	:	console.log('j');	break;	// j
                    // case 75	:	console.log('k');	break;	// k
                    // case 76	:	console.log('l');	break;	// l
                    // case 77	:	console.log('m');	break;	// m
                    // case 78	:	console.log('n');	break;	// n
                    // case 79	:	console.log('o');	break;	// o

                    //case 80	:	console.log('p');	break;	// p

                    // case 81	:	console.log('q');	break;	// q
                    // case 82	:	console.log('r'); 	break;	// r
                    // case 83	:	console.log('s');	break;	// s
                    // case 84	:	console.log('t');	break;	// t
                    // case 85	:	console.log('u');	break;	// u
                    // case 86	:	console.log('v');	break;	// v
                    // case 87	:	console.log('w');	break;	// w
                    // case 88	:	console.log('x');	break;	// x
                    // case 89	:	console.log('y');	break;	// y
                    // case 90	:	console.log('z');	break;	// z
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".toggle_container").show();
            $("button.reveal").click(function() {
                $(this).toggleClass("active").next().slideToggle("fast");

                if ($.trim($(this).text()) === 'Hide Result Status') {
                    $(this).text('Show Result Status');
                    $(".toggle_container").hide();
                } else {
                    $(this).text('Hide Result Status');
                    $(".toggle_container").show();
                }

                return false;
            });
            $("a[href='" + window.location.hash + "']").parent(".reveal").click();
        });
    </script>

</body>

</html>
