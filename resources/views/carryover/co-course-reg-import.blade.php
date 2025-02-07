<div>
    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900 mb-2">

        @if (session()->has('error'))
            <x-alerts.alert-bordered-danger>
                {{ session('error') }}
            </x-alerts.alert-bordered-danger>
        @endif

        <div class="mb-4 col-span-full xl:mb-2">

            <h1 class="text-md font-semibold text-gray-900 sm:text-2xl dark:text-white capitalize" style="">
                New Carry-over Course Reg
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

                    <x-dropdowns.class />

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

                </div>
            </div>

            <x-importer.import-section
                message="Always use the template file to organize List to be imported into the Carry over table!!!" />

        </form>

        @include('components.alerts')
    </div>
</div>
