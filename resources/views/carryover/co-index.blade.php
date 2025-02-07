<div>


    <x-pagetop.cod-page-top pageHeader="Carryover page">
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

                {{-- <x-icons.bulk-delete /> --}}
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
                    Register Carryover
                </x-primary-button>
            </div>
        </div>
        {{-- new search ad  --}}
        <div
            class="flex items-center justify-between flex-column flex-wraps md:flex-row space-y-4 md:space-y-0 bg-white dark:bg-gray-800">

            <div class="grid md:grid-cols-5 gap-2 mb-0">
                <x-dropdowns.dept-id title="Filter by Department" />
                <x-dropdowns.class title="Filter by Class" />
                <x-dropdowns.session-id title="Filter by Academic session" />

            </div>

            <x-dropdowns.searchbox placeholder="Search Name/Reg no." />

        </div>
    </x-pagetop.cod-page-top>


    <div class="flex flex-col">
        <div class="overflow-x-auto overflow-y-auto md:max-h-[500px] 2xl:max-h-fit">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <input wire:model.live='selectAll' id="checkbox-all"
                                            aria-describedby="checkbox-1" type="checkbox"
                                            class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-all" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    <div class="flex items-center  text-center">
                                        S/N
                                    </div>
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium  text-gray-500 uppercase dark:text-gray-400 cursor-pointer  text-center"
                                    wire:click="setSortBy('course_title')">
                                    <span class="flex">
                                        Student name {{-- @if ($orderBy !== 'course_title') --}}
                                        <x-icons.chevron-sort />
                                        {{-- @elseif ($sortDir === 'asc')
                                            <x-icons.chevron-down />
                                        @else
                                            <x-icons.chevron-up />
                                        @endif --}}
                                    </span>
                                </th>

                                <th scope="col"
                                    class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                    Reg. Number
                                </th>

                                <th scope="col"
                                    class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                    Academic session
                                </th>

                                <th scope="col"
                                    class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                    Carryover courses
                                </th>

                                <th scope="col"
                                    class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                    Level/Semester
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($courseRegs as $reg)
                                <tr
                                    class="hover:bg-gray-100 dark:hover:bg-gray-700 @if ($this->indicateChecked($reg->student_id)) bg-blue-300 hover:bg-gray-200 dark:hover:bg-gray-900 dark:bg-blue-900 @endif">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input wire:model.live="checked" value="{{ $reg->student_id }}"
                                                id="{{ $reg->student_id }}" aria-describedby="{{ $reg->student_id }}"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="{{ $reg->student_id }}" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <td
                                        class="w-4 p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center">
                                            {{ $loop->iteration }}
                                        </div>
                                    </td>
                                    <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                        <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                            <div class="text-base font-semibold text-gray-900 dark:text-white"
                                                title="{{ $myHelpers->fullName($reg->surname, $reg->middlename, $reg->firstname) }}">
                                                {{ Str::of($myHelpers->fullName($reg->surname, $reg->middlename, $reg->firstname))->headline }}
                                            </div>
                                            <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                Some processes are automated
                                                {{-- {!! date('D, d-M-Y', strtotime($reg->created_at)) !!} --}}
                                            </div>
                                    </td>
                                    <td
                                        class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center uppercase">
                                            {{ Str::of($reg->regno) }}
                                        </div>
                                    </td>

                                    <td
                                        class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center">
                                            {{ $reg->session }}/{{ $reg->session + 1 }}
                                        </div>
                                    </td>

                                    <td
                                        class="p-4 text-base  text-center font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center text-center">
                                            {{ $reg->course_count }} Courses
                                        </div>
                                    </td>

                                    <td
                                        class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center">
                                            {{ Str::of($reg->level)->headline }}/{{ Str::of($reg->sem) }}
                                            Sem.
                                        </div>
                                    </td>

                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        {{-- <x-primary-button
                                            class="inline-flex items-center justify-center w-1/2 px-3 py-2 "
                                            wire:click="$dispatch('edit-course', {id: {{ $reg->student_id }}})"
                                            title="Edit {{ $reg->student_id }}">
                                            <x-icons.edit-icon />
                                            More
                                        </x-primary-button>

                                        <x-danger-button
                                            wire:click="$dispatch('delete-prompt', {id: {{ $reg->student_id }}})"
                                            title="delete {{ $reg->student_id }}">
                                            <x-icons.trash-icon />
                                            Delete
                                        </x-danger-button> --}}

                                    </td>


                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9"
                                        class="p-4 text-base text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        No records available at the moment, Create or import some!!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- pagination --}}
    {{ $courseRegs->links() }}

    @include('components.alerts')
</div>
