<div>

    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900 mb-2">
        <div class="mb-4 col-span-full xl:mb-2">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="#"
                            class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="#"
                                class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Users</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500"
                                aria-current="page">Settings</span>
                        </div>
                    </li>
                </ol>
            </nav>

            {{-- {{ $grades }} --}}
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Grading System</h1>
        </div>

    </div>
    <div class="grid grid-cols-1 px-4 xl:grid-cols-1 xl:gap-4">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="mb-4 text-xl font-semibold dark:text-white">Grading details</h3>
            <form wire:submit="updateGrades" novalidate>
                <div class="grid grid-cols-4 gap-6 mb-4">
                    <div>
                        <x-input-label for="a" value="Grade" />
                        <x-text-input wire:model.blur="a" id="a" type="text"
                            placeholder="Grade {{ $a }}" required />
                        <x-input-error :messages="$errors->get('a')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="a_lower_bound" value="Lower bound" />
                        <x-text-input wire:model.blur="a_lower_bound" id="a_lower_bound" type="number" required
                            placeholder="lower bound for grade {{ $a }}" required />
                        <x-input-error :messages="$errors->get('a_lower_bound')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="a_upper_bound" value="Upper bound" />
                        <x-text-input wire:model.blur="a_upper_bound" id="a_upper_bound" type="number" required
                            placeholder="Upper bound for grade {{ $a }}" required />
                        <x-input-error :messages="$errors->get('a_upper_bound')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="a_grade_point" value="Grade Point" />
                        <x-text-input wire:model.blur="a_grade_point" id="a_grade_point" type="number" required
                            placeholder="GP for {{ $a }}" required />
                        <x-input-error :messages="$errors->get('a_grade_point')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-6 mb-4">
                    <div>
                        <x-input-label for="b" value="Grade" />
                        <x-text-input wire:model.blur="b" id="b" type="text"
                            placeholder="Grade {{ $b }}" required />
                        <x-input-error :messages="$errors->get('b')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="b_lower_bound" value="Lower bound" />
                        <x-text-input wire:model.blur="b_lower_bound" id="b_lower_bound" type="number" required
                            placeholder="lower bound for grade {{ $b }}" required />
                        <x-input-error :messages="$errors->get('b_lower_bound')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="b_upper_bound" value="Upper bound" />
                        <x-text-input wire:model.blur="b_upper_bound" id="b_upper_bound" type="number" required
                            placeholder="Upper bound for grade {{ $b }}" required />
                        <x-input-error :messages="$errors->get('b_upper_bound')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="b_grade_point" value="Grade Point" />
                        <x-text-input wire:model.blur="b_grade_point" id="b_grade_point" type="number" required
                            placeholder="GP for {{ $b }}" required />
                        <x-input-error :messages="$errors->get('b_grade_point')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-6 mb-4">
                    <div>
                        <x-input-label for="c" value="Grade" />
                        <x-text-input wire:model.blur="c" id="c" type="text"
                            placeholder="Grade {{ $c }}" required />
                        <x-input-error :messages="$errors->get('c')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="c_lower_bound" value="Lower bound" />
                        <x-text-input wire:model.blur="c_lower_bound" id="c_lower_bound" type="number" required
                            placeholder="lower bound for grade {{ $c }}" required />
                        <x-input-error :messages="$errors->get('c_lower_bound')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="b_upper_bound" value="Upper bound" />
                        <x-text-input wire:model.blur="c_upper_bound" id="c_upper_bound" type="number" required
                            placeholder="Upper bound for grade {{ $c }}" required />
                        <x-input-error :messages="$errors->get('c_upper_bound')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="b_grade_point" value="Grade Point" />
                        <x-text-input wire:model.blur="c_grade_point" id="c_grade_point" type="number" required
                            placeholder="GP for {{ $c }}" required />
                        <x-input-error :messages="$errors->get('c_grade_point')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-6 mb-4">
                    <div>
                        <x-input-label for="d" value="Grade" />
                        <x-text-input wire:model.blur="d" id="d" type="text"
                            placeholder="Grade {{ $d }}" required />
                        <x-input-error :messages="$errors->get('d')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="d_lower_bound" value="Lower bound" />
                        <x-text-input wire:model.blur="d_lower_bound" id="d_lower_bound" type="number" required
                            placeholder="lower bound for grade {{ $d }}" required />
                        <x-input-error :messages="$errors->get('d_lower_bound')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="d_upper_bound" value="Upper bound" />
                        <x-text-input wire:model.blur="d_upper_bound" id="d_upper_bound" type="number" required
                            placeholder="Upper bound for grade {{ $d }}" required />
                        <x-input-error :messages="$errors->get('d_upper_bound')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="d_grade_point" value="Grade Point" />
                        <x-text-input wire:model.blur="d_grade_point" id="d_grade_point" type="number" required
                            placeholder="GP for {{ $d }}" required />
                        <x-input-error :messages="$errors->get('d_grade_point')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-6 mb-4">
                    <div>
                        <x-input-label for="e" value="Grade" />
                        <x-text-input wire:model.blur="e" id="e" type="text"
                            placeholder="Grade {{ $e }}" required />
                        <x-input-error :messages="$errors->get('e')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="e_lower_bound" value="Lower bound" />
                        <x-text-input wire:model.blur="e_lower_bound" id="e_lower_bound" type="number" required
                            placeholder="lower bound for grade {{ $e }}" required />
                        <x-input-error :messages="$errors->get('e_lower_bound')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="e_upper_bound" value="Upper bound" />
                        <x-text-input wire:model.blur="e_upper_bound" id="e_upper_bound" type="number" required
                            placeholder="Upper bound for grade {{ $e }}" required />
                        <x-input-error :messages="$errors->get('e_upper_bound')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="e_grade_point" value="Grade Point" />
                        <x-text-input wire:model.blur="e_grade_point" id="e_grade_point" type="number" required
                            placeholder="GP for {{ $e }}" required />
                        <x-input-error :messages="$errors->get('e_grade_point')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-6 mb-4">
                    <div>
                        <x-input-label for="f" value="Grade" />
                        <x-text-input wire:model.blur="f" id="f" type="text"
                            placeholder="Grade {{ $f }}" required />
                        <x-input-error :messages="$errors->get('f')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="f_lower_bound" value="Lower bound" />
                        <x-text-input wire:model.blur="f_lower_bound" id="f_lower_bound" type="number" required
                            placeholder="lower bound for grade {{ $f }}" required />
                        <x-input-error :messages="$errors->get('f_lower_bound')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="f_upper_bound" value="Upper bound" />
                        <x-text-input wire:model.blur="f_upper_bound" id="f_upper_bound" type="number" required
                            placeholder="Upper bound for grade {{ $f }}" required />
                        <x-input-error :messages="$errors->get('f_upper_bound')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="f_grade_point" value="Grade Point" />
                        <x-text-input wire:model.blur="f_grade_point" id="f_grade_point" type="number" required
                            placeholder="GP for {{ $f }}" required />
                        <x-input-error :messages="$errors->get('f_grade_point')" class="mt-2" />
                    </div>
                </div>



                <div class="col-span-6 sm:col-full">
                    <x-primary-button value="Update Grading Systems" />
                </div>
            </form>
        </div>
    </div>
    @include('components.alerts')

</div>
