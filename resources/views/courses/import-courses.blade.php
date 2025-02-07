<div>
    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900 mb-2">

        <div class="mb-4 col-span-full xl:mb-2">
            @if (session('error'))
                <x-alerts.alert-bordered-danger>
                    {{ session('error') }}
                </x-alerts.alert-bordered-danger>
            @endif

            @if (session('success'))
                <x-alerts.alert-bordered-success>
                    {{ session('success') }}
                </x-alerts.alert-bordered-success>
            @endif

            <h1 class="text-md font-semibold text-gray-900 sm:text-2xl dark:text-white capitalize" style="">
                New Course from Excel
            </h1>
        </div>
        @if (session()->has('errorss'))
            <x-alerts.alert-bordered-danger>
                <ul>
                    @foreach ($errorss as $error)
                        <li>
                            Row: {{ $error['row'] }}, Attribute: {{ $error['attribute'] }} - {{ $error['error'] }}
                        </li>
                    @endforeach
                </ul>

            </x-alerts.alert-bordered-danger>
        @endif

    </div>
    <div class="grid grid-cols-1 px-4 xl:grid-cols-1 xl:gap-4">
        <form action="{{ route('course-file.upload') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            {{-- sort --}}
            <div
                class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

                <div class="grid md:grid-cols-2 gap-6 mb-0">

                    <x-dropdowns.dept-id />
                    <x-dropdowns.class />

                </div>
            </div>

            <x-importer.import-section
                message="Always use the template file to organize courses to be uploaded for a single,department,level and semester" />

        </form>

        {{-- @include('components.alerts') --}}
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



        {{-- <script>
                document.addEventListener("DOMContentLoaded", function() {
                    @if (session('swal'))
                        Swal.fire({
                            title: "{{ session('swal.title') }}",
                            text: "{{ session('swal.message') }}",
                            icon: "{{ session('swal.icon') }}",
                            customClass: {
                                confirmButton: "px-5 py-2 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 sm:w-auto dark:bg-blue-600 dark:hover:bg-blue-700 transition ease-in-out duration-150",
                            },
                            buttonsStyling: false,
                            showCloseButton: false
                        });
                    @endif
                });
            </script> --}}
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let swalData = @json(session()->get('swal'));
                if (swalData) {
                    console.log("SweetAlert data:", swalData); // Debugging line
                    Swal.fire({
                        title: swalData.title,
                        text: swalData.message,
                        icon: swalData.icon,
                        customClass: {
                            confirmButton: "px-5 py-2 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 sm:w-auto dark:bg-blue-600 dark:hover:bg-blue-700 transition ease-in-out duration-150",
                        },
                        buttonsStyling: false,
                        showCloseButton: false
                    });
                }
            });
        </script>


    </div>
</div>
