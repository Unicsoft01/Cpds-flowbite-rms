<div>
    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900 mb-2">
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
        </div>

    </div>
    <div class="grid grid-cols-1 px-4 xl:grid-cols-1 xl:gap-4">
        <div
            class="p-4 mb-1 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800 dark:text-white">
            <h3 class="text-md font-semibold sm:text-2xl text-center sm:col-full">
                New Student Course Registeration
            </h3>
        </div>
        {{--  --}}
        @if (session()->has('error'))
            <x-alerts.alert-bordered-danger>
                {{ session('error') }}
            </x-alerts.alert-bordered-danger>
        @endif
        {{--  --}}

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
                                        Dept: {{ Str::of($student->dept_id)->headline }}
                                    </h3>
                                    <h3>
                                        Phone: {{ Str::of($student->phone)->headline }}
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

                                        <div class="grid md:grid-cols-3 gap-6 mb-0">
                                            <div>
                                                <select wire:model.live="session_id" id="session_id" required
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center">
                                                    <option value="">Select a Session</option>
                                                    @forelse (\App\Models\AcademicSessions::orderBy('session', 'desc')->get() as $session)
                                                        <option value="{{ $session->session_id }}">
                                                            {{ $session->session }}/{{ $session->session + 1 }}
                                                        </option>
                                                    @empty
                                                        <option value="">Go create some Session first!</option>
                                                    @endforelse
                                                </select>
                                                <x-input-error :messages="$errors->get('session_id')" class="mt-2" />
                                            </div>

                                            <div>
                                                <select wire:model.live="level_id" id="level_id" required
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center">
                                                    <option value="">Select a Level</option>
                                                    @foreach (\App\Models\Level::get() as $level)
                                                        <option value="{{ $level->level_id }}">
                                                            {{ Str::of($level->level)->headline }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <x-input-error :messages="$errors->get('level_id')" class="mt-2" />
                                            </div>

                                            <div>
                                                <select wire:model.live="semester_id" id="semester_id" required
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center">
                                                    <option value="">Select a Semester</option>
                                                    @foreach (\App\Models\Semester::get() as $sem)
                                                        <option value="{{ $sem->semester_id }}">
                                                            {{ $sem->sem }} Semester
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <x-input-error :messages="$errors->get('semester_id')" class="mt-2" />
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Alert users of actions --}}
                                    @if (session()->has('success'))
                                        <div class="mt-4 text-green-600">{{ session('success') }}</div>
                                    @elseif (session()->has('error'))
                                        <div class="bg-white dark:bg-gray-800 sm:col-span-8">
                                            <x-alerts.alert-bordered-danger class="m-0"
                                                message="{{ session('error') }}" />
                                        </div>
                                    @endif

                                    {{--  --}}
                                    <div
                                        class="min-h-[100px] rounded-lg sm:col-span-8  bg-white border border-gray-200  shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white">

                                        <div class="overflow-x-auto">
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
                                                            </tr>
                                                        </thead>
                                                        <tbody
                                                            class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                                            @foreach ($this->StudentCourses as $key => $courses)
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
                                                                        class="flex items-center p-4 mr-4 space-x-6 whitespace-nowrapwwwwwwwwwwwww">
                                                                        <div
                                                                            class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                                            <div
                                                                                class="text-base font-semibold text-gray-900 dark:text-white">
                                                                                {{ Str::of($courses->course_title)->headline }}
                                                                            </div>
                                                                            <div
                                                                                class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                                                {{ Str::of($courses->course_code)->headline }}
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td
                                                                        class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                                                        <div class="flex items-center">
                                                                            @if ($loop->iteration > 1)
                                                                                {{ $courses->unit }} Unit
                                                                            @else
                                                                                {{ $courses->unit }} Units
                                                                                </option>
                                                                            @endif

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
        @else
            <div class="grid grid-cols-1 px-4 xl:grid-cols-1 xl:gap-4">
                <div
                    class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                    <h3 class="mb-4 text-xl font-semibold dark:text-white">
                        Find student by RegNo
                    </h3>
                    <form wire:submit="searchStudent" novalidate>
                        <div class="grid grid-cols-1 gap-6 mb-4">
                            <div>
                                <x-input-label for="regno" value="Student Matriculation Number:" />
                                <x-text-input wire:model.blur="regno" id="regno" type="text"
                                    placeholder="Enter Reg. No. to proceed" required />
                                <x-input-error :messages="$errors->get('regno')" class="mt-2" />
                            </div>
                        </div>

                        <div class="col-span-6 sm:col-full">

                            <x-primary-button value="Proceed to Course Reg." />

                        </div>
                    </form>
                </div>
            </div>
        @endif



        @include('components.alerts')
    </div>
</div>
