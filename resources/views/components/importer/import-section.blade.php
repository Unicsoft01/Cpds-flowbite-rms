@props([
    'message' =>
        'Always use the template file to organize records to be uploaded. Download, Populate with you own data and Upload!!',
])

<div>
    <div
        class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

        <div class="grid md:grid-cols-3 gap-2 mb-4">
            <div>
                <x-input-label for="importFile" value="File upload" />
                <input name="importFile"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    aria-describedby="file_input_help" id="file_input" type="file">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">XLSX,CSV (MAX.
                    1MB).</p>
                <x-input-error :messages="$errors->get('importFile')" class="mt-2" />

            </div>

            <div class="sm:p-6">
                <div
                    class="flexs justify-center sm:col-full nowrap text-md text-gray-900 dark:text-gray-300 text-justify">
                    {{ $message }}
                </div>
            </div>

            <div class=" sm:p-6">
                <div class="col-span-12 sm:col-full">
                    <x-primary-button wire:click.prevent="downloadSample" type="button"
                        class="bg-green-700 hover:bg-green-800 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                        <x-icons.download />

                        Download Template CSV file
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
    <div
        class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <div class="flex justify-start col-span-6">
            <div wire:loading wire:target="importFile" class=" progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated text-sm font-semibold text-red-700 dark:text-red-700 capitalize"
                    role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                    Preparing for Upload, Please wait...
                </div>
            </div>
        </div>
        <div class="flex justify-end col-span-6 sm:col-full">
            <x-primary-button value="Upload file records" />
        </div>
    </div>
</div>
