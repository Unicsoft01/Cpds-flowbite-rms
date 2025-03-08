<div>

    <x-pagetop.cod-page-top pageHeader="Semester results">
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

                {{-- <div class="flex pl-0 mt-3 space-x-1 sm:pl-2 sm:mt-0">
                    <a href="#"
                        class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#"
                        class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#"
                        class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#"
                        class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                            </path>
                        </svg>
                    </a>
                </div> --}}
            </div>

            <div class="flex items-center ml-auto space-x-2 sm:space-x-3">

                @if (auth()->user()->hasRole('User') || auth()->user()->hasRole('Super_admin'))
                    <x-success-button class="bg-green-500 hover:bg-green-700 dark:hover:bg-green-800 dark:bg-green-600"
                        wire:click="releaseResults">
                        Release selection results ({{ count($this->checked) }})
                    </x-success-button>
                @endif


                <x-primary-button class="inline-flex items-center justify-center w-1/2 px-3 py-2 "
                    wire:click='viewSelectionResults'>
                    View selection results ({{ count($this->checked) }})
                </x-primary-button>

                <x-primary-button class="inline-flex items-center justify-center w-1/2 px-3 py-2 "
                    wire:click='viewSelectionResultsExternal'>
                    View results [External] ({{ count($this->checked) }})
                </x-primary-button>
            </div>
        </div>
        {{-- new search ad  --}}
        <div
            class="flex items-center justify-between flex-column flex-wraps md:flex-row space-y-4 md:space-y-0 bg-white dark:bg-gray-800">

            <div class="grid md:grid-cols-4 gap-2 mb-0">
                <x-dropdowns.dept-id />

                <x-dropdowns.set />

                <x-dropdowns.class />

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
                                                    {{ Str::of($student->surname)->headline }}
                                                </div>
                                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
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
    {{ $students->links() }}

    @include('components.alerts')

    {{-- <script>
        document.addEventListener('livewire:init', () => {
            $wire.on('log', (event) => {
            try{
              console[event[0].level](event[0].obj);
            }
            catch{
              console.log(event[0]);
            }
          });
        });
      </script> --}}
</div>
