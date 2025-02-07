<div>
    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900 mb-2">

        @if (session()->has('error'))
            <x-alerts.alert-bordered-danger message="{{ session('error') }}" />
        @endif

        <div class="mb-4 col-span-full xl:mb-2">
            <h1 class="text-md font-semibold text-gray-900 sm:text-2xl dark:text-white capitalize" style="">
                Upload Faculties from Excel file
            </h1>
        </div>

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

    <div class="grid grid-cols-1 px-4 xl:grid-cols-1 xl:gap-4">
        <form wire:submit="uploadFile" novalidate>

            <x-importer.import-section />

        </form>

        @include('components.alerts')
    </div>
</div>
