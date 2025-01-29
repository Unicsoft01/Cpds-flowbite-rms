<div>
    <select id="paginate" wire:model.live="paginate"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[80px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <option value="">Showing</option>

        <option value="10">10</option>
        <option value="100">100 (Default)</option>
        <option value="200">200</option>
        <option value="300">300</option>
        <option value="400">400</option>
    </select>
    <x-input-error :messages="$errors->get('paginate')" class="mt-2" />
</div>
