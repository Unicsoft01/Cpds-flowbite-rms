<div>
    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900 mb-2">
        <div class="mb-4 col-span-full xl:mb-2">

        </div>
    </div>
    <div class="mt-5s grid grid-cols-1 px-4 xl:grid-cols-1 xl:gap-4">
        <div class="w-full mx-auto max-w-xl p-6 space-y-8d sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800">

            <x-auth-session-status
                class="rounded dark:bg-gray-600 bg-gray-200 p-3 text-center text-gray-900 dark:text-white"
                :status="session('status')" />

            <h2 class="md:text-2xl font-bold text-center text-gray-900 dark:text-white">
                Edit student details
            </h2>
            <form class="mt-8 space-y-6" wire:submit="StudentEdit" novalidate>

                <!-- Name -->
                <div>
                    <x-input-label for="surname" :value="__('Surname')" />

                    <x-text-input wire:model="surname" id="surname" type="text" name="surname" autofocus
                        autocomplete="surname" placeholder="Enter your surname" required />

                    <x-input-error :messages="$errors->get('surname')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="middlename" :value="__('Middlename (Optional) ')" />

                    <x-text-input wire:model="middlename" id="middlename" type="text" name="middlename"
                        placeholder="Enter a middlename" />

                    <x-input-error :messages="$errors->get('middlename')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="firstname" :value="__('Firstname')" />

                    <x-text-input wire:model="firstname" id="firstname" type="text" name="firstname"
                        placeholder="Enter your firstname" required />

                    <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="regno" :value="__('Reg/Mat No.')" />

                    <x-text-input wire:model="regno" id="regno" type="text" name="regno"
                        placeholder="Enter your Reg/Mat No." required />

                    <x-input-error :messages="$errors->get('regno')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="faculty_id" :value="__('Faculty')" />

                    <select wire:model.live="faculty_id" id="faculty_id" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center capitalize">
                        <option value="">Student Faculty</option>
                        @forelse ($faculties as $faculty)
                            <option value="{{ $faculty->faculty_id }}">
                                {{ $faculty->faculty }}
                            </option>
                        @empty
                            <option value="">No Faculty at the moment!</option>
                        @endforelse
                    </select>
                    <x-input-error :messages="$errors->get('faculty_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="dept_id" :value="__('Department')" />

                    <select wire:model.live="dept_id" id="dept_id" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center capitalize">
                        <option value="">Select Student's Department</option>
                        @forelse ($departments as $dept)
                            <option value="{{ $dept->dept_id }}">
                                {{ $dept->department }}
                            </option>
                        @empty
                            <option value="">No department at the moment!</option>
                        @endforelse
                    </select>
                    <x-input-error :messages="$errors->get('dept_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="session_id" :value="__('Academic set')" />
                    <select wire:model="session_id" id="session_id" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center">
                        <option value="">Select your Academic set</option>
                        @forelse ($acad as $set)
                            <option value="{{ $set->session_id }}">
                                {{ $set->session }}/{{ $set->session + 1 }}
                            </option>
                        @empty
                            <option value="">Go create some Session first!</option>
                        @endforelse
                    </select>
                    <x-input-error :messages="$errors->get('set')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Student\'s passwprd (Unchanged)')" />

                    <x-text-input value="********" class="block mt-1 w-full" type="text" readonly />
                </div>

                <x-primary-button class="w-full">
                    {{ __('Save student profile') }}
                </x-primary-button>


            </form>


            @include('components.alerts')
        </div>
    </div>
