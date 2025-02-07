<div>

    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900 mb-2">
        <div class="mb-4 col-span-full xl:mb-2">

            {{-- {{ $grades }} --}}
            {{-- <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Grading System</h1> --}}
        </div>

    </div>
    <div class="grid grid-cols-1 px-4 xl:grid-cols-1 xl:gap-4">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="mb-4 text-xl font-semibold dark:text-white">
                @if ($deptForm->editMode)
                    Edit Records
                @else
                    Create New Department
                @endif
            </h3>
            <form wire:submit="CreateOrUpdate" novalidate>
                <div class="grid md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <x-input-label for="department" value="Department" />
                        <x-text-input wire:model.live="deptForm.department" id="department" type="text"
                            placeholder="Enter a valid name for Department" required />
                        <x-input-error :messages="$errors->get('deptForm.department')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="faculty" value="Faculty" />

                        <select wire:model.live="deptForm.faculty_id" id="faculty_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 uppercase">
                            <option value="">Select a faculty</option>
                            @foreach (\App\Models\Faculties::orderBy('faculty', 'asc')->get() as $facs)
                                <option value="{{ $facs->faculty_id }}">
                                    {{ $facs->faculty }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('deptForm.faculty_id')" class="mt-2" />
                    </div>
                </div>


                <div class="col-span-6 sm:col-full">
                    @if ($deptForm->editMode)
                        <x-primary-button value="Update Record" />
                    @else
                        <x-primary-button value="Save Record" />
                    @endif
                </div>
            </form>
        </div>
    </div>
    @include('components.alerts')

</div>
