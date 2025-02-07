@props([
    'title' => 'Level/Semester',
])
<div>
    <select wire:model.live="level" name="level" id="level" required
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center">
        <option value="">{{ $title }}</option>
        <option value="1">Dip 1/1st Semester</option>
        <option value="2">Dip 1/2nd Semester</option>
        <option value="3">Dip 2/1st Semester</option>
        <option value="4">Dip 2/2nd Semester</option>
    </select>
    <x-input-error :messages="$errors->get('level')" class="mt-2" />
</div>
