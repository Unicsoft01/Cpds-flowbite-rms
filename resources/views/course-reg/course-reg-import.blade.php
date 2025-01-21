<div>
    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900 mb-2">

        @if (session()->has('error'))
            <x-alerts.alert-bordered-danger>
                {{ session('error') }}
            </x-alerts.alert-bordered-danger>
        @endif

        <div class="mb-4 col-span-full xl:mb-2">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="#"
                            class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="#"
                                class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Users</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500"
                                aria-current="page">Settings</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <h1 class="text-md font-semibold text-gray-900 sm:text-2xl dark:text-white capitalize" style="">
                New Course Registeration
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
            {{-- sort --}}
            <div
                class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

                <div class="grid md:grid-cols-4 gap-6 mb-0">

                    <x-dropdowns.dept-id />

                    <button id="dropdownBgHoverButton" data-dropdown-toggle="dropdownBgHover"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center capitalize"
                        type="button">
                        Choose Course(s)
                    </button>

                    <!-- Dropdown menu -->
                    <div id="dropdownBgHover" class="z-10 hidden w-48 bg-white rounded-lg shadow dark:bg-gray-700">
                        <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownBgHoverButton">
                            @forelse ($courses as $course)
                                <li>
                                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <input wire:model="checked" value="{{ $course->course_id }}"
                                            id="{{ $course->course_id }}" aria-describedby="{{ $course->course_id }}"
                                            type="checkbox"
                                            class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="{{ $course->course_id }}"
                                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300 uppercase">
                                            {{ $course->course_code }}
                                        </label>

                                    </div>
                                </li>
                            @empty
                                <option value="">Go create some Courses first!</option>
                            @endforelse
                        </ul>
                    </div>

                    {{-- <x-dropdowns.courses /> --}}
                    <x-dropdowns.session-id />
                    <x-dropdowns.class />

                </div>
            </div>

            <x-importer.import-section
                message="Always use the template file to organize courses to be uploaded for a single,department,level and semester" />

        </form>

        @include('components.alerts')
    </div>
</div>
