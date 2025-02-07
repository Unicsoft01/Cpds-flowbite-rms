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
                @if ($fac->editMode)
                    Edit Faculty Records
                @else
                    Create New Faculty
                @endif
            </h3>
            <form wire:submit="CreateOrUpdate" novalidate>
                <div class="grid grid-cols-1 gap-s6 mb-4">
                    <div>
                        <x-input-label for="faculty" value="Faculty Name" />
                        <x-text-input wire:model.blur="fac.faculty" id="faculty" type="text"
                            placeholder="Enter faculty name" required />
                        <x-input-error :messages="$errors->get('fac.faculty')" class="mt-2" />
                    </div>
                </div>



                <div class="col-span-6 sm:col-full">
                    @if ($fac->editMode)
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
