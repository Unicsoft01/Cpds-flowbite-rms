<div>

    <x-pagetop.cod-page-top>
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

                @if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super_admin'))
                    <x-icons.bulk-delete />
                @endif
            </div>

            <div class="flex items-center ml-auto space-x-2 sm:space-x-3">

                @if (auth()->user()->hasRole('User'))
                    <x-light-button wire:click.prevent="OpenImportView()">
                        <x-icons.file-import />
                        Import Excel
                    </x-light-button>
                @endif

                <x-light-button wire:click.prevent="$dispatch('export-prompt')">
                    <x-icons.file-export />
                    Export Excel
                </x-light-button>

                <x-primary-button class="inline-flex items-center justify-center w-1/2 px-3 py-2 "
                    wire:click='OpenCreatePage'>
                    <x-icons.plus-icon />
                    New Faculty
                </x-primary-button>
            </div>
        </div>
        {{-- new search ad  --}}
        <div
            class="flex items-center justify-between flex-column flex-wraps md:flex-row space-y-4 md:space-y-0 bg-white dark:bg-gray-800">

            <div class="grid md:grid-cols-4 gap-2 mb-0">

            </div>

            <x-dropdowns.searchbox placeholder="Search Faculties" />

        </div>
    </x-pagetop.cod-page-top>

    <div class="flex flex-col">
        <div class="overflow-x-auto">
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
                                    <div class="flex items-center">
                                        S/N
                                    </div>
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Faculties
                                </th>

                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Status
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($faculties as $faculty)
                                <tr
                                    class="hover:bg-gray-100 dark:hover:bg-gray-700 @if ($this->indicateChecked($faculty->faculty_id)) bg-blue-300 hover:bg-gray-200 dark:hover:bg-gray-900 dark:bg-blue-900 @endif">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input wire:model.live="checked" value="{{ $faculty->faculty_id }}"
                                                id="{{ $faculty->faculty_id }}"
                                                aria-describedby="{{ $faculty->faculty_id }}" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="{{ $faculty->faculty_id }}" class="sr-only">checkbox</label>
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
                                            <div class="text-base font-semibold text-gray-900 dark:text-white">
                                                {{ Str::of($faculty->faculty)->headline }}
                                            </div>
                                            <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                Created {!! date('D, d-M-Y', strtotime($faculty->created_at)) !!}</div>
                                        </div>
                                    </td>

                                    <td
                                        class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div> Active
                                        </div>
                                    </td>
                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        <x-primary-button
                                            class="inline-flex items-center justify-center w-1/2 px-3 py-2 "
                                            wire:click="$dispatch('edit-faculty', {id: {{ $faculty->faculty_id }}})"
                                            title="Edit {{ $faculty->faculty }}">
                                            <x-icons.edit-icon />
                                            Edit
                                        </x-primary-button>


                                        @if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super_admin'))
                                            <x-danger-button
                                                wire:click="$dispatch('delete-prompt', {id: {{ $faculty->faculty_id }}})"
                                                title="delete {{ $faculty->faculty }}">
                                                <x-icons.trash-icon />
                                                Delete
                                            </x-danger-button>
                                        @endif


                                    </td>
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
            </div>
        </div>
    </div>
    {{-- pagination --}}
    {{ $faculties->links() }}

    @include('components.alerts')
</div>
