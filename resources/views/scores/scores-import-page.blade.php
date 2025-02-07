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
                Bulk Scores from Excel
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
        <form action="{{ route('scores-file.upload') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            {{-- sort --}}
            <div
                class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

                <div class="grid md:grid-cols-4 gap-6 mb-0">

                    <x-dropdowns.dept-id />

                    <x-dropdowns.class />

                    <div>
                        <select wire:model.live="course_id" name="course_id" id="course_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center">
                            <option value="">Select a course</option>
                            @forelse ($courses as $cus)
                                <option value="{{ $cus->course_id }}">
                                    {{ $cus->course_code }}
                                </option>
                            @empty
                                <option value="">Go create some Courses first!</option>
                            @endforelse
                        </select>
                        <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                    </div>

                    <x-dropdowns.session-id />

                </div>
            </div>

            <x-importer.import-section
                message="Always use the template file to organize courses to be uploaded for a single,department,level and semester" />

        </form>

        @include('components.alerts')
    </div>
</div>
