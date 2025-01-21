<div>
    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900 mb-2">
        <div class="mb-4 col-span-full xl:mb-2">

            {{-- {{ $grades }} --}}
            <h1 class="text-md font-semibold text-gray-900 sm:text-2xl dark:text-white capitalize" style="">

                @if ($courseForm->level_id && $courseForm->dept_id && $courseForm->semester_id)
                    @php
                        $level = \App\Models\Level::find($courseForm->level_id)->level;
                        $dept = \App\Models\Dept::find($courseForm->dept_id)->department;
                        $see = \App\Models\Semester::find($courseForm->semester_id)->sem;
                    @endphp
                    {{ $level }} {{ $see }} Sem. Course for {{ $dept }} Dept
                @else
                    New Course Registeration
                @endif
            </h1>
        </div>

    </div>
    <div class="grid grid-cols-1 px-4 xl:grid-cols-1 xl:gap-4">
        <form wire:submit="CreateOrUpdate" novalidate>
            {{-- sort --}}
            <div
                class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

                <div class="grid md:grid-cols-3 gap-6 mb-0">
                    <div>
                        <select wire:model.live="courseForm.dept_id" id="dept_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center">
                            <option value="">Select a Department</option>
                            @forelse (\App\Models\Dept::orderBy('department', 'asc')->where('user_id', Auth::User()->user_id)->get(['dept_id', 'department']) as $dep)
                                <option value="{{ $dep->dept_id }}">
                                    {{ Str::of($dep->department)->headline }}
                                </option>
                            @empty
                                <option value="">Go create some Dept first!</option>
                            @endforelse
                        </select>
                        <x-input-error :messages="$errors->get('courseForm.dept_id')" class="mt-2" />
                    </div>


                    <div>
                        <select wire:model.live="courseForm.level_id" id="level_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center">
                            <option value="">Select a Level</option>
                            @forelse (\App\Models\Level::orderBy('level', 'asc')->get(['level_id', 'level']) as $level)
                                <option value="{{ $level->level_id }}">
                                    {{ Str::of($level->level)->headline }}
                                </option>
                            @empty
                                <option value="">Go create some Level first!</option>
                            @endforelse
                        </select>
                        <x-input-error :messages="$errors->get('courseForm.level_id')" class="mt-2" />
                    </div>

                    <div>
                        <select wire:model.live="courseForm.semester_id" id="semester_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center">
                            <option value="">Select Semester</option>
                            @forelse (\App\Models\Semester::get() as $sem)
                                <option value="{{ $sem->semester_id }}">
                                    {{ Str::of($sem->sem) }} Semester
                                </option>
                            @empty
                                <option value="">Go create some Semesters first!</option>
                            @endforelse
                        </select>
                        <x-input-error :messages="$errors->get('courseForm.semester_id')" class="mt-2" />
                    </div>

                </div>
            </div>

            @if ($courseForm->editMode)
                <div
                    class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

                    <div
                        class="grid @if ($courseForm->editMode) md:grid-cols-4 @else md:grid-cols-5 @endif gap-6 mb-4">
                        <div>
                            <x-input-label for="course_title" value="Course Title" />
                            <x-text-input wire:model="courseForm.course_title" type="text"
                                placeholder="E.g Introduction to Computer" required />
                            <x-input-error :messages="$errors->get('courseForm.course_title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="course_code" value="Course Code" />
                            <x-text-input wire:model="courseForm.course_code" id="course_code" type="text" required
                                placeholder="E.g csc101" required />
                            <x-input-error :messages="$errors->get('courseForm.course_code')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="unit" value="Course Unit" />

                            <select wire:model="courseForm.unit" id="unit" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center">
                                <option value="">Course Unit</option>
                                @foreach (\App\Enums\CourseUnits::cases() as $unit)
                                    @if ($loop->iteration > 1)
                                        <option value="{{ $unit->value }}">
                                            {{ $unit->value }} Units
                                        </option>
                                    @else
                                        <option value="{{ $unit->value }}">
                                            {{ $unit->value }} Unit
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('courseForm.unit')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" value="Course Status" />
                            <select wire:model="courseForm.status" id="status" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach (\App\Enums\CourseStatus::cases() as $status)
                                    <option value="{{ $status->value }}">
                                        {{ $status->name }} Course
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('courseForm.status')" class="mt-2" />
                        </div>

                    </div>
                </div>
            @else
                @foreach ($courseForm->formInputs as $key => $input)
                    <div
                        class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                        {{-- {{ $key }} --}}

                        <div
                            class="grid @if ($courseForm->editMode) md:grid-cols-4 @else md:grid-cols-5 @endif gap-6 mb-4">
                            <div>
                                <x-input-label for="course_title" value="Course Title" />
                                <x-text-input wire:model="courseForm.course_title.{{ $key }}" type="text"
                                    placeholder="E.g Introduction to Computer" required />
                                <x-input-error :messages="$errors->get('courseForm.course_title')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="course_code" value="Course Code" />
                                <x-text-input wire:model="courseForm.course_code.{{ $key }}" id="course_code"
                                    type="text" required placeholder="E.g csc101" required />
                                <x-input-error :messages="$errors->get('courseForm.course_code')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="unit" value="Course Unit" />
                                <select wire:model="courseForm.unit.{{ $key }}" id="unit" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Course Unit</option>
                                    @forelse (\App\Enums\CourseUnits::cases() as $unit)
                                        @if ($loop->iteration > 1)
                                            <option value="{{ $unit->value }}">
                                                {{ $unit->value }} Units
                                            </option>
                                        @else
                                            <option value="{{ $unit->value }}">
                                                {{ $unit->value }} Unit
                                            </option>
                                        @endif
                                    @empty
                                        <option value="">You Should go create records first</option>
                                    @endforelse
                                </select>
                                <x-input-error :messages="$errors->get('courseForm.unit')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="status" value="Course Status" />
                                <select wire:model="courseForm.status.{{ $key }}" id="status" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Course Status</option>
                                    @foreach (\App\Enums\CourseStatus::cases() as $status)
                                        <option value="{{ $status->value }}">
                                            {{ $status->name }} Course
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('courseForm.status')" class="mt-2" />
                            </div>

                            @if (!$courseForm->editMode)
                                <div class="flex justify-evenly ">

                                    <x-primary-button
                                        wire:click.prevent="addCourseForm({{ $courseForm->inputCounter }})"
                                        data-tooltip-target="tooltip-default" type="button" class="mt-7 pr-2"
                                        style="border-radius: 4pc;">
                                        <x-icons.plus-icon class="w-7 h-10" />
                                    </x-primary-button>

                                    <x-danger-button wire:click.prevent="removeCourseForm({{ $key }})"
                                        type="button" class="mt-7 pr-3" style="border-radius: 4pc;">
                                        <x-icons.minus-icon />
                                    </x-danger-button>
                                </div>
                            @endif

                        </div>
                    </div>
                @endforeach
            @endif
            <div
                class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <div class="flex justify-end col-span-6 sm:col-full">
                    @if ($courseForm->editMode)
                        <x-primary-button value="Update Record" />
                    @else
                        <x-primary-button value="Save Record" />
                    @endif
                </div>
            </div>
        </form>

        @include('components.alerts')

    </div>
</div>
