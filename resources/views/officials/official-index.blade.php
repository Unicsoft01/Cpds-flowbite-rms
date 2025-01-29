<div>

    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900 mb-2">
        <div class="mb-4 col-span-full xl:mb-2">

            {{-- {{ $grades }} --}}
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Result officials</h1>
        </div>

    </div>
    <div class="grid grid-cols-1 px-4 xl:grid-cols-1 xl:gap-4">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="mb-4 text-xl font-semibold dark:text-white">Officials</h3>
            <form wire:submit="CreateOrUpdate" novalidate>
                <div class="grid grid-cols-2 gap-6 mb-4">
                    <div>
                        <x-input-label for="hod" value="Dean/Director" />
                        <x-text-input wire:model.live="officials.hod" id="hod" type="text"
                            placeholder="Enter name of Dean/Director" required />
                        <x-input-error :messages="$errors->get('officials.hod')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="exam_officer" value="HOD/Coordinator/Exam Officer" />
                        <x-text-input wire:model.live="officials.exam_officer" id="exam_officer" type="text" required
                            placeholder="Enter name of  HOD/Coordinator/Exam officer" required />
                        <x-input-error :messages="$errors->get('officials.exam_officer')" class="mt-2" />
                    </div>
                </div>



                <div class="col-span-6 sm:col-full">
                    <x-primary-button value="Update Officials" />
                </div>
            </form>
        </div>
    </div>
    @include('components.alerts')

</div>
