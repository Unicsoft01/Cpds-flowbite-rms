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
            <h1 class="text-md font-semibold text-gray-900 sm:text-2xl dark:text-white" style="">
                New Students from Excel
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
        <form action="{{ route('upload-student-file.upload') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            {{-- sort --}}
            <div
                class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

                <div class="grid md:grid-cols-3 gap-6 mb-0">

                    <x-dropdowns.faculties />
                    <x-dropdowns.dept-id />
                    <x-dropdowns.set />

                </div>
            </div>

            <x-importer.import-section
                message="Always use the template file to organize Students to be uploaded for a department, faculty and Set(Year of Admission)" />

        </form>

        @include('components.alerts')
    </div>
</div>
