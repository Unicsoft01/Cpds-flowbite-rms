<div>

    <x-pagetop.cod-page-top pageHeader="Set Summary" pageDescription="View and release selection results">
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

                <x-success-button class="bg-green-500 hover:bg-green-700 dark:hover:bg-green-800 dark:bg-green-600"
                    wire:click="viewSelectionKingGraduatesSummary">
                    View King Graduants ({{ count($this->checked) }})
                </x-success-button>

                <x-primary-button class="inline-flex items-center justify-center w-1/2 px-3 py-2 "
                    wire:click='viewSelectionResultsSummary'>
                    View set Summary ({{ count($this->checked) }})
                </x-primary-button>
            </div>
        </div>
        {{-- new search ad  --}}
        <div
            class="flex items-center justify-between flex-column flex-wraps md:flex-row space-y-4 md:space-y-0 bg-white dark:bg-gray-800">

            <div class="grid md:grid-cols-4 gap-2 mb-0">
                <x-dropdowns.dept-id :makeLive="false" />

                <x-dropdowns.set :makeLive="false" />

                <x-dropdowns.class :makeLive="false" />

                <x-success-button class="inline-flex items-center justify-center w-2/3 px-3 py-2"
                    wire:click="applyFilter">
                    <x-icons.edit-icon />
                    Apply filter
                </x-success-button>

            </div>

            <x-dropdowns.searchbox />

        </div>
    </x-pagetop.cod-page-top>

    <div class="flex flex-col">
        <div class="overflow-x-auto overflow-y-auto md:max-h-[500px] 2xl:max-h-fit">
            <div class="inline-block min-w-full align-middle">
                @if (!$filtersApplied)
                    <div
                        class="mt-6 flex min-h-[380px] items-center justify-center rounded-xl
               border border-dashed border-gray-300 bg-white px-6 py-12
               dark:border-gray-700 dark:bg-gray-800">

                        <div class="max-w-lg text-center">

                            {{-- Icon --}}
                            <div
                                class="mx-auto mb-6 flex h-20 w-20 items-center justify-center
                       rounded-full bg-blue-50 dark:bg-blue-900/30">
                                <svg class="h-10 w-10 text-blue-600 dark:text-blue-400" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 4.5h16.5M6.75 9h10.5m-7.5 4.5h4.5m-2.25 0v6m-3-3h6" />
                                </svg>
                            </div>

                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                Select students to display
                            </h3>

                            <p
                                class="mx-auto mt-3 max-w-md text-sm leading-6
                       text-gray-500 dark:text-gray-400">
                                Choose a department and academic set above,
                                then click
                                <span class="font-semibold text-gray-700 dark:text-gray-200">
                                    Apply filter
                                </span>
                                to display the matching student records.
                            </p>

                            <div
                                class="mx-auto mt-6 inline-flex items-center gap-2 rounded-lg
                       bg-gray-50 px-4 py-2 text-xs font-medium
                       text-gray-500 dark:bg-gray-700 dark:text-gray-300">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m9-.75a9 9 0 11-18 0
                           9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>

                                No student records are loaded until a filter is applied.
                            </div>

                        </div>
                    </div>
                @else
                    {{-- YOUR EXISTING STUDENT TABLE --}}
                    @if ($students->isEmpty())
                        <div
                            class="mt-6 flex min-h-[320px] items-center justify-center
               rounded-xl border border-gray-200 bg-white
               dark:border-gray-700 dark:bg-gray-800">
                            <div class="text-center px-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    No students found
                                </h3>

                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    No student records match the selected department and academic set.
                                </p>
                            </div>
                        </div>
                    @else
                        {{-- existing student table --}}
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
                                                Fullname
                                            </th>

                                            <th scope="col"
                                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                Matric Number
                                            </th>
                                            <th scope="col"
                                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody
                                        class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                        @forelse ($students as $student)
                                            <tr
                                                class="hover:bg-gray-100 dark:hover:bg-gray-700 @if ($this->indicateChecked($student->student_id)) bg-blue-300 hover:bg-gray-200 dark:hover:bg-gray-900 dark:bg-blue-900 @endif">
                                                <td class="w-4 p-4">
                                                    <div class="flex items-center">
                                                        <input wire:model.live="checked"
                                                            value="{{ $student->student_id }}"
                                                            id="{{ $student->student_id }}"
                                                            aria-describedby="{{ $student->student_id }}"
                                                            type="checkbox"
                                                            class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                                        <label for="{{ $student->student_id }}"
                                                            class="sr-only">checkbox</label>
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
                                                            {{ Str::of($student->surname)->headline }}
                                                        </div>
                                                        <div
                                                            class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                            Created {!! date('D, d-M-Y', strtotime($student->created_at)) !!}</div>
                                                    </div>
                                                </td>

                                                <td
                                                    class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                                    <div class="flex items-center uppercase">
                                                        {{ Str::of($student->regno)->headline }}
                                                    </div>
                                                </td>

                                                <td class="p-4 space-x-2 whitespace-nowrap">


                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5"
                                                    class="p-4 text-base text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    Use filters to fetch students records!!!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @else
                        @endif
                    @endif

                @endif

            </div>
        </div>
    </div>
    {{-- pagination --}}
    @if ($filtersApplied && $students && $students->isNotEmpty())
        {{ $students->links() }}
    @endif

    @include('components.alerts')

</div>
