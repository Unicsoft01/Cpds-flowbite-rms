<div>
    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900 mb-2">

        @if (session()->has('error'))
            <x-alerts.alert-bordered-danger message="{{ session('error') }}" />
        @endif

        <div class="mb-4 col-span-full xl:mb-2">

            <h1 class="text-md font-semibold text-gray-900 sm:text-2xl dark:text-white capitalize" style="">
                New Departments from Excel
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
        <form wire:submit="uploadFile" novalidate>
            {{-- sort --}}
            <div
                class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

                <div class="grid md:grid-cols-2 gap-6 mb-0">

                    <x-dropdowns.faculties />

                </div>
            </div>

            <x-importer.import-section
                message="Always use the template file to organize your Departments to be uploaded" />

        </form>

        @include('components.alerts')
    </div>
</div>
