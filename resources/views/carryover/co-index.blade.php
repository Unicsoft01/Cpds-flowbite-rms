<div>

    @php

        // if ($dept_id) {
        //     $firstDepartment = $courses->first()?->department->department ?? 'the Department';
        //     $pageHeader = 'Courses in ' . $firstDepartment;
        // } else {
        $pageHeader = 'Carry over';
        // }
    @endphp

    <x-pagetop.cod-page-top :$pageHeader>
        {{-- alert --}}
        @if (session()->has('error'))
            <x-alerts.alert-bordered-danger>
                {{ session('error') }}
            </x-alerts.alert-bordered-danger>
        @endif
        {{-- CTA and xpt --}}
        <div class="sm:flex mb-4">
            <div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                <x-pagination-per-page />

                <x-icons.bulk-delete />
            </div>

            <div class="flex items-center ml-auto space-x-2 sm:space-x-3">

                <x-light-button wire:click.prevent="OpenImportView()">
                    <x-icons.file-import />
                    Import Excel
                </x-light-button>

                <x-light-button wire:click.prevent="$dispatch('export-prompt')">
                    <x-icons.file-export />
                    Export Excel
                </x-light-button>

                <x-primary-button class="inline-flex items-center justify-center w-1/2 px-3 py-2 "
                    wire:click='OpenCreatePage'>
                    <x-icons.plus-icon />
                New student CO reg
                </x-primary-button>
            </div>
        </div>
        {{-- new search ad  --}}
        <div
            class="flex items-center justify-between flex-column flex-wraps md:flex-row space-y-4 md:space-y-0 bg-white dark:bg-gray-800">

            <div class="grid md:grid-cols-4 gap-2 mb-0">

                <x-dropdowns.dept-id title="Filter by Department" />

            </div>

            <x-dropdowns.searchbox placeholder="Search courses/codes/units" />

        </div>
    </x-pagetop.cod-page-top>

    <x-table.table-body>

        <x-table.table-head>

            <th scope="col"
                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 cursor-pointer"
                wire:click="setSortBy('course_title')">
                <span class="flex">
                    Course Title

                </span>
            </th>


            <x-table.th>heading 1</x-table.th>

            <th scope="col"
                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 cursor-pointer"
                wire:click="setSortBy('course_code')">
                <span class="flex">
                    Course code

                </span>
            </th>

            <th scope="col"
                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 cursor-pointer"
                wire:click="setSortBy('unit')">
                <span class="flex">
                    unit

                </span>
            </th>

            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                Level
            </th>

            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                Semester
            </th>

            <th scope="col" class="p-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                Status
            </th>

            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                Active Status
            </th>
            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                Actions
            </th>
        </x-table.table-head>


        {{-- <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
            @forelse ($courses as $course)
                <tr
                    class="hover:bg-gray-100 dark:hover:bg-gray-700 @if ($this->indicateChecked($course->course_id)) bg-blue-300 hover:bg-gray-200 dark:hover:bg-gray-900 dark:bg-blue-900 @endif">
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input wire:model.live="checked" value="{{ $course->course_id }}"
                                id="{{ $course->course_id }}" aria-describedby="{{ $course->course_id }}"
                                type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                            <label for="{{ $course->course_id }}" class="sr-only">checkbox</label>
                        </div>
                    </td>
                    <td class="w-4 p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="flex items-center">
                            {{ $loop->iteration }}
                        </div>
                    </td>
                    <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                        <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                            <div class="text-base font-semibold text-gray-900 dark:text-white"
                                title="{{ Str::of($course->course_title)->headline }}">
                                {{ Str::of(Str::limit($course->course_title, $limit = 30, $end = '...'))->headline }}
                            </div>
                            <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                Created {!! date('D, d-M-Y', strtotime($course->created_at)) !!}</div>
                        </div>
                    </td>

                    <td class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="flex items-center">
                            {{ Str::of($course->department->department)->headline }}
                        </div>
                    </td>

                    <td class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="flex items-center">
                            {{ Str::of($course->course_code)->headline }}
                        </div>
                    </td>

                    <td class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="flex items-center">
                            {{ Str::of($course->unit)->headline }}
                        </div>
                    </td>

                    <td class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="flex items-center">
                            {{ Str::of($course->level->level)->headline }}
                        </div>
                    </td>

                    <td class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="flex items-center">
                            {{ Str::of($course->semester->sem) }} Sem.
                        </div>
                    </td>

                    <td class="p-2 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="flex items-center">
                            {{ Str::of($course->status)->headline }}
                        </div>
                    </td>

                    <td class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="flex items-center">
                            <div class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div> Active
                        </div>
                    </td>
                    <td class="p-4 space-x-2 whitespace-nowrap">
                        <x-primary-button class="inline-flex items-center justify-center w-1/2 px-3 py-2 "
                            wire:click="$dispatch('edit-course', {id: {{ $course->course_id }}})"
                            title="Edit {{ $course->course }}">
                            <x-icons.edit-icon />
                            Edit
                        </x-primary-button>

                        <x-danger-button wire:click="$dispatch('delete-prompt', {id: {{ $course->course_id }}})"
                            title="delete {{ $course->course }}">
                            <x-icons.trash-icon />
                            Delete
                        </x-danger-button>

                    </td>
                </tr>
            @empty
                <x-table.table-empty colspan="11" />
            @endforelse
        </tbody> --}}
    </x-table.table-body>
    {{-- pagination --}}
    {{-- {{ $courses->links() }} --}}

    @include('components.alerts')
</div>
