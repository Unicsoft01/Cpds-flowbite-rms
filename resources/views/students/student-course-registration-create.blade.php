<div>
    <div class="grid grid-cols-1 px-4 pt-2 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900 mb-2">

    </div>
    <div class="grid grid-cols-1 px-4 xl:grid-cols-1 xl:gap-4">
        <div
            class="p-4 mb-1 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800 dark:text-white">
            <h3 class="text-md font-semibold sm:text-2xl text-center sm:col-full">
                New Course Registeration
            </h3>
        </div>

        {{-- sect --}}
        @if ($student)
            <div
                class="p-4 mb-1 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800 dark:text-white">
                <form wire:submit="registerCourses" novalidate>
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-12">
                        <div
                            class="min-h-[100px] rounded-lg sm:col-span-4 bg-white border border-gray-200  shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            <!--  -->
                            <div class="sm:grid-cols-12s m-4 grid grid-cols-2sssssss gap-4">
                                <div
                                    class="min-h-[100px] rounded-lg bg-white sm:border sm:border-gray-200  shadow-sm sm:dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:col-span-8 flex justify-center">
                                    {{-- <img class="rounded-full w-36 h-36" src="http://127.0.0.1:8000/images/users/neil-sims.png" alt="Extra large avatar"> --}}

                                    <div
                                        class="relative w-36 h-36 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                                        <svg class="absolute w-38 h-38 text-gray-400 -left-1" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd">
                                            </path>
                                        </svg>
                                    </div>

                                </div>
                                <div
                                    class="min-h-[100px] rounded-lg sm:col-span-8 bg-white shadow-sm dark:bg-gray-800 dark:text-white">
                                    <h3>
                                        Name: {{ Str::of($student->surname)->headline }}
                                        {{ Str::of($student->middlename)->headline }}
                                        {{ Str::of($student->firstname)->headline }}
                                    </h3>
                                    <h3>
                                        Matric No.:
                                        <span class="lowercase">
                                            {{ Str::of($student->regno)->headline }}
                                        </span>
                                    </h3>
                                    <h3>
                                        Programme: {{ Str::of($student->programme->program)->headline }} in
                                        {{ Str::of($student->department->department)->headline }}
                                    </h3>
                                    <h3>
                                        Faculty: {{ Str::of($student->faculty->faculty)->headline }}
                                    </h3>
                                    <h3>
                                        Phone: {{ Str::of($student->phone) }}
                                    </h3>
                                </div>
                            </div>
                            <!--  -->
                        </div>

                        <div class="min-h-[100px] rounded-lg sm:col-span-8">
                            <div class="sm:grid-cols-12s grid grid-cols-1 gap-4">
                                <!--  -->
                                <div class=" grid grid-cols-1 gap-4">
                                    <div
                                        class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800  sm:col-span-8">

                                        <div class="grid md:grid-cols-2 gap-6 mb-0">

                                            <x-dropdowns.session-id />

                                            <x-dropdowns.class />

                                        </div>
                                    </div>
                                    {{-- Alert users of actions --}}
                                    @if (session()->has('error'))
                                        <x-alerts.alert-bordered-danger>
                                            {{ session('error') }}
                                        </x-alerts.alert-bordered-danger>
                                    @endif

                                    @if (session()->has('success'))
                                        <x-toast message="{{ session('success') }}" id="{{ session('success') }}">
                                            <x-checked.rounded-check-success />
                                        </x-toast>
                                    @endif

                                    {{--  --}}
                                    <div
                                        class="min-h-[100px] rounded-lg sm:col-span-8  bg-white border border-gray-200  shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white">

                                        <div class="overflow-x-auto overflow-y-auto max-h-[300px] 2xl:max-h-fit">
                                            <div class="inline-block min-w-full align-middle">
                                                <div class="overflow-hidden shadow">
                                                    <table
                                                        class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                                                        <thead class="bg-gray-100 dark:bg-gray-700">
                                                            <tr>
                                                                <th scope="col" class="p-4">
                                                                    <div class="flex items-center">
                                                                        <input id="checkbox-all"
                                                                            aria-describedby="checkbox-1"
                                                                            type="checkbox"
                                                                            class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                                                        <label for="checkbox-all"
                                                                            class="sr-only">checkbox</label>
                                                                    </div>
                                                                </th>
                                                                <th scope="col"
                                                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                                    Courses
                                                                </th>

                                                                <th scope="col"
                                                                    class="p-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                                    Unit
                                                                </th>

                                                                <th scope="col"
                                                                    class="p-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                                    status
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody
                                                            class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                                            @foreach ($StudentCourses as $key => $courses)
                                                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                                                    <td class="w-4 p-4">
                                                                        <div class="flex items-center">
                                                                            <input wire:model.live="selectedCourses"
                                                                                value="{{ $courses->course_id }}"
                                                                                id="selectedCourses"
                                                                                aria-describedby="selectedCourses"
                                                                                type="checkbox"
                                                                                class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                                                            <label for="selectedCourses"
                                                                                class="sr-only">checkbox</label>
                                                                        </div>
                                                                        <x-input-error :messages="$errors->get('selectedCourses')"
                                                                            class="mt-2" />
                                                                    </td>
                                                                    <td
                                                                        class="flex items-center p-4 mr-1 space-x-2 whitespace-nowrapwwwwwwwwwwwww">
                                                                        <div
                                                                            class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                                            <div
                                                                                class="text-base font-semibold text-gray-900 dark:text-white">
                                                                                {{ Str::of($courses->course_title)->headline }}
                                                                            </div>
                                                                            <div
                                                                                class="text-sm font-normal text-blue-700 dark:text-blue-500">
                                                                                {{ Str::of($courses->course_code)->headline }}
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td
                                                                        class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                                                        <div class="flex items-center">
                                                                            @if ($courses->unit == 1)
                                                                                {{ $courses->unit }} Unit
                                                                            @else
                                                                                {{ $courses->unit }} Units
                                                                                </option>
                                                                            @endif

                                                                        </div>
                                                                    </td>

                                                                    <td
                                                                        class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                                                        <div class="flex items-center">
                                                                            {{ $courses->status }}
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>




                                    </div>
                                </div>
                                <!--  -->
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-4 mt-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                        <div class="flex justify-end col-span-6 sm:col-full">
                            <x-primary-button value="Register Courses" />

                        </div>
                    </div>
                </form>
            </div>
        
        @endif

        @include('components.alerts')
    </div>
</div>
