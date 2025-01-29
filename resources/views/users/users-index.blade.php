<div>

    @php

        $pageHeader = 'All registered Users';

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

                {{-- <x-light-button wire:click.prevent="OpenImportView()">
                    <x-icons.file-import />
                    Import CSV
                </x-light-button>

                <x-light-button wire:click.prevent="$dispatch('export-prompt')">
                    <x-icons.file-export />
                    Export CSV
                </x-light-button>

                <x-primary-button class="inline-flex items-center justify-center w-1/2 px-3 py-2 "
                    wire:click='OpenCreatePage'>
                    <x-icons.plus-icon />
                    New Student
                </x-primary-button> --}}
            </div>
        </div>
        {{-- new search ad  --}}
        <div
            class="flex items-center justify-between flex-column flex-wraps md:flex-row space-y-4 md:space-y-0 bg-white dark:bg-gray-800">

            <div class="grid md:grid-cols-4 gap-2 mb-0">
                {{-- <x-dropdowns.dept-id title="Filter by Department" /> --}}

            </div>

            <x-dropdowns.searchbox placeholder="Search name/Email/Phone" />

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
                                    <div class="flex items-center">
                                        S/N
                                    </div>
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 cursor-pointer"
                                    wire:click="setSortBy('name')">
                                    <span class="flex">
                                        Fullname
                                        @if ($orderBy !== 'name')
                                            <x-icons.chevron-sort />
                                        @elseif ($sortDir === 'desc')
                                            <x-icons.chevron-down />
                                        @else
                                            <x-icons.chevron-up />
                                        @endif
                                    </span>
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 cursor-pointer"
                                    wire:click="setSortBy('email')">
                                    <span class="flex">
                                        Email
                                        @if ($orderBy !== 'email')
                                            <x-icons.chevron-sort />
                                        @elseif ($sortDir === 'desc')
                                            <x-icons.chevron-down />
                                        @else
                                            <x-icons.chevron-up />
                                        @endif
                                    </span>
                                </th>

                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Contact no.
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($users as $user)
                                <tr
                                    class="hover:bg-gray-100 dark:hover:bg-gray-700 @if ($this->indicateChecked($user->user_id)) bg-blue-300 hover:bg-gray-200 dark:hover:bg-gray-900 dark:bg-blue-900 @endif">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input wire:model.live="checked" value="{{ $user->user_id }}"
                                                id="{{ $user->user_id }}" aria-describedby="{{ $user->user_id }}"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="{{ $user->user_id }}" class="sr-only">checkbox</label>
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
                                                {{ Str::of($user->name)->headline }}
                                            </div>
                                            <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                Joined {!! date('D, d-M-Y', strtotime($user->created_at)) !!}</div>
                                        </div>
                                    </td>

                                    <td
                                        class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center uppercase">
                                            {{ Str::of($user->email)->headline }}
                                        </div>
                                    </td>

                                    <td
                                        class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center uppercase">
                                            {{ Str::of($user->phone)->headline }}
                                        </div>
                                    </td>

                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        <x-primary-button
                                            class="inline-flex items-center justify-center w-1/2 px-3 py-2 "
                                            wire:click="$dispatch('edit-course', {id: {{ $user->user_id }}})"
                                            title="Edit {{ $user->name }}">
                                            <x-icons.edit-icon />
                                            Edit
                                        </x-primary-button>

                                        <x-danger-button
                                            wire:click="$dispatch('delete-prompt', {id: {{ $user->user_id }}})"
                                            title="delete {{ $user->name }}">
                                            <x-icons.trash-icon />
                                            Delete
                                        </x-danger-button>

                                    </td>

                                </tr>
                            @empty
                                <x-table.table-empty colspan="7" />
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- pagination --}}
    {{ $users->links() }}

    @include('components.alerts')
</div>
