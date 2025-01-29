<div x-data="{}">

    @php
        //Score sheet computer science dip1 1st sem. 2024
        // if ($dept_id) {
        //     $firstDepartment = $scores->first()?->department->department ?? 'the Department';
        //     $pageHeader = 'Students in ' . $firstDepartment;
        // } else {
        $pageHeader = 'Score sheet table';
        // }
    @endphp

    <x-pagetop.cod-page-top :$pageHeader>
        {{-- alert --}}

        @if (session()->has('error'))
            <x-alerts.alert-bordered-danger>
                {{ session('error') }}
            </x-alerts.alert-bordered-danger>
        @endif
        
        @if (session()->has('success'))
            <x-toast id="{{ $editingField }}">
                <x-checked.rounded-check-success />
            </x-toast>
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
                    Student course reg.
                </x-primary-button>
            </div>
        </div>
        {{-- new search ad  --}}
        <div
            class="flex items-center justify-between flex-column flex-wraps md:flex-row space-y-4 md:space-y-0 bg-white dark:bg-gray-800">

            <div class="grid md:grid-cols-5 gap-2 mb-0">

                <x-dropdowns.dept-id title="Filter by Department" />

                <x-dropdowns.set title="Filter by Academic set" />

                <x-dropdowns.class title="Filter by Class" />

                <div>
                    <select wire:model.live="course" id="course" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center">
                        <option value="">Filter by courses</option>
                        @forelse ($courses as $cus)
                            <option value="{{ $cus->course_id }}">
                                {{ $cus->course_code }}
                            </option>
                        @empty
                            <option value="">Go create some Dept first!</option>
                        @endforelse
                    </select>
                    <x-input-error :messages="$errors->get('course')" class="mt-2" />
                </div>


            </div>

            <x-dropdowns.searchbox />
        </div>
    </x-pagetop.cod-page-top>

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                @if ($scores)
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr class="">
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
                                        class="p-4  w-90 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Student Name
                                    </th>

                                    <th scope="col"
                                        class="p-4 w-20 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400  text-center">
                                        Reg. Number
                                    </th>

                                    <th scope="col"
                                        class="p-4 w-20 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400  text-center">
                                        Course code
                                    </th>

                                    <th scope="col"
                                        class="p-4 w-40 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 text-ce">
                                        Score
                                    </th>

                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        GP
                                    </th>

                                    <th scope="col"
                                        class="p-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Grade
                                    </th>

                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse ($scores as $index => $score)
                                    <tr
                                        class="hover:bg-gray-100 dark:hover:bg-gray-700 @if ($this->indicateChecked($score->registration_id)) bg-blue-300 hover:bg-gray-200 dark:hover:bg-gray-900 dark:bg-blue-900 @endif">
                                        <td class="w-4 p-4">
                                            <div class="flex items-center">
                                                <input wire:model.live="checked" value="{{ $score->registration_id }}"
                                                    id="{{ $score->registration_id }}"
                                                    aria-describedby="{{ $score->registration_id }}" type="checkbox"
                                                    class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="{{ $score->registration_id }}"
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
                                                    {{ $myHelpers->fullName($score->students->surname, $score->students->middlename, $score->students->firstname) }}
                                                </div>
                                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                    Created {!! date('D, d-M-Y', strtotime($score->created_at)) !!}</div>
                                            </div>
                                        </td>

                                        <td
                                            class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center">
                                                {{ Str::of($score->students->regno)->upper }}
                                            </div>
                                        </td>

                                        <td
                                            class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center">
                                                {{ Str::of($score->courses->course_code)->upper }}
                                            </div>
                                        </td>

                                        <td
                                            class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            @if ($editingField === $score->registration_id)
                                                <x-text-input required="" wire:model="editedData.score"
                                                    wire:keydown.enter="saveScore" wire:keydown.tab="saveScore"
                                                    type="number" placeholder="score" autofocus />
                                                <x-input-error :messages="$errors->get('editedData.score')" class="mt-2" />
                                            @else
                                                <span wire:click="editScore({{ $score->registration_id }})"
                                                    class="cursor-pointer border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                    @if (!is_null($score->score))
                                                        {{ $score->score }}
                                                    @else
                                                        Click to enter score
                                                    @endif
                                                </span>
                                            @endif
                                        </td>

                                        <td
                                            class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center">
                                                {{ $score->grade_point }}
                                            </div>
                                        </td>

                                        <td
                                            class="p-2 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center">
                                                {{ $score->grade }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9"
                                            class="p-4 text-base text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            No records available at the moment, Be sure students registered thier courses or you Create/Import some!!</td>
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


    @include('components.alerts')
</div>
