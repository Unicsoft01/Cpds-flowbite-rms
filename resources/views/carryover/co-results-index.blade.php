<div>

    <x-pagetop.cod-page-top pageHeader="Carryover Results">
        {{-- alert --}}
        @if (session()->has('error'))
            <x-alerts.alert-bordered-danger>
                {{ session('error') }}
            </x-alerts.alert-bordered-danger>
        @endif


        @if (session()->has('success'))
            <x-toast message="{{ session('success') }}" id="rest">
                <x-checked.rounded-check-success />
            </x-toast>
        @endif
        {{-- CTA and xpt --}}
        <div class="sm:flex
                mb-4">
            <div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                <x-pagination-per-page />

            </div>

            <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                {{-- <x-success-button class="bg-green-500 hover:bg-green-700 dark:hover:bg-green-800 dark:bg-green-600"
                    wire:click="releaseResults">
                    <x-icons.edit-icon />
                    Release selection results ({{ count($this->checked) }})
                </x-success-button> --}}

                <x-primary-button class="inline-flex items-center justify-center w-1/2 px-3 py-2 "
                    wire:click='viewSelectionResults'>
                    View selection results ({{ count($this->checked) }})
                </x-primary-button>
            </div>
        </div>
        {{-- new search ad  --}}
        <div
            class="flex items-center justify-between flex-column flex-wraps md:flex-row space-y-4 md:space-y-0 bg-white dark:bg-gray-800">

            <div class="grid md:grid-cols-4 gap-2 mb-0">

                <x-dropdowns.dept-id title="Filter by Department" />

                <x-dropdowns.set title="Filter by Academic set" />

                <x-dropdowns.class title="Filter by Class" />

            </div>

            <x-dropdowns.searchbox />

        </div>
    </x-pagetop.cod-page-top>

    <div class="flex flex-col">
        <div class="overflow-x-auto overflow-y-auto md:max-h-[500px] 2xl:max-h-fit">
            <div class="inline-block min-w-full align-middle">
                @if ($students)
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
                                        <div class="flex items-center">
                                            S/N
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Student name
                                    </th>

                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Matric Number
                                    </th>
                                    {{-- <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Actions
                                    </th> --}}
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse ($students as $student)
                                    <tr
                                        class="hover:bg-gray-100 dark:hover:bg-gray-700 @if ($this->indicateChecked($student->student_id)) bg-blue-300 hover:bg-gray-200 dark:hover:bg-gray-900 dark:bg-blue-900 @endif">
                                        <td class="w-4 p-4">
                                            <div class="flex items-center">
                                                <input wire:model.live="checked" value="{{ $student->student_id }}"
                                                    id="{{ $student->student_id }}"
                                                    aria-describedby="{{ $student->student_id }}" type="checkbox"
                                                    class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="{{ $student->student_id }}" class="sr-only">checkbox</label>
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
                                                    title="">
                                                    {{ Str::of($student->students->surname)->headline }}
                                                    {{ Str::of($student->students->middlename)->headline }}
                                                    {{ Str::of($student->students->firstname)->headline }}
                                                </div>
                                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                    Created {!! date('D, d-M-Y', strtotime($student->created_at)) !!}</div>
                                            </div>
                                        </td>

                                        <td
                                            class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center uppercase">
                                                {{ Str::of($student->students->regno)->headline }}
                                            </div>
                                        </td>

                                        {{-- <td class="p-4 space-x-2 whitespace-nowrap">
                                            <x-primary-button
                                                class="inline-flex items-center justify-center w-1/2 px-3 py-2 "
                                                wire:click="$dispatch('edit-course', {id: {{ $student->student_id }}})"
                                                title="Edit {{ $student->name }}">
                                                <x-icons.edit-icon />
                                                Generate Transcript
                                            </x-primary-button>

                                            <x-success-button
                                                class="bg-green-500 hover:bg-green-700 dark:hover:bg-green-800 dark:bg-green-600"
                                                wire:click="$dispatch('delete-prompt', {id: {{ $student->student_id }}})"
                                                title="delete {{ $student->student }}">
                                                <x-icons.edit-icon />
                                                Statement of Result
                                            </x-success-button>

                                        </td> --}}

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="p-4 text-base text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            No records available at the moment, Create or import some!!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            <tr>
                                <td colspan="9"
                                    class="p-4 text-base text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Use filters to fetch Students Scores!!
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
    {{-- pagination --}}
    {{-- {{ $students->links() }} --}}

    @include('components.alerts')

</div>
