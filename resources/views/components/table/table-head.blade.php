<thead class="bg-gray-100 dark:bg-gray-700">
    <tr>
        <th scope="col" class="p-4">
            <div class="flex items-center">
                <input wire:model.live='selectAll' id="checkbox-all" aria-describedby="checkbox-1" type="checkbox"
                    class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                <label for="checkbox-all" class="sr-only">checkbox</label>
            </div>
        </th>
        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
            <div class="flex items-center">
                S/N
            </div>
        </th>
        {{ $slot }}
    </tr>
</thead>
