<div>

    <div
        class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Academic Sessions</h1>
            </div>
            <div class="sm:flex">

                <div class="flex items-center ml-auto space-x-2 sm:space-x-3">

                    <x-primary-button class="inline-flex items-center justify-center w-1/2 px-3 py-2 "
                        wire:click='OpenCreatePage'>
                        <x-icons.plus-icon />
                        New Session
                    </x-primary-button>

                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>

                                @if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('Admin'))
                                    <th scope="col" class="p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-all" aria-describedby="checkbox-1" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-all" class="sr-only">checkbox</label>
                                        </div>
                                    </th>
                                @endif
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    S/N
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Sessions
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
                            @forelse ($sessions as $session)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">

                                    @if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('Admin'))
                                        <td class="w-4 p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-1" aria-describedby="checkbox-1" type="checkbox"
                                                    class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-1" class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                    @endif

                                    <td
                                        class="w-4 p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center">
                                            {{ $loop->iteration }}
                                        </div>
                                    </td>
                                    <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                        <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                            <div class="text-base font-semibold text-gray-900 dark:text-white">
                                                {{ $session->session }}/{{ $session->session + 1 }}
                                            </div>
                                            <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                Created {!! date('D, d-M-Y', strtotime($session->created_at)) !!}</div>
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
                                            wire:click="$dispatch('edit-session', {id: {{ $session->session_id }}})"
                                            title="Edit {{ $session->session }}">
                                            <x-icons.edit-icon />
                                            Edit
                                        </x-primary-button>

                                        @if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('Admin'))
                                            <x-danger-button
                                                wire:click="$dispatch('delete-prompt', {id: {{ $session->session_id }}})"
                                                title="delete {{ $session->session }}">
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

    @include('components.alerts')
</div>
