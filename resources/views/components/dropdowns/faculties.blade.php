@props([
    'title' => 'Select a Faculty',
])
<div>
    <select wire:model.live="faculty_id" name="faculty_id" id="faculty_id" required
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
        <option value="">{{ $title }}</option>
        @foreach (\App\Models\Faculties::orderBy('faculty', 'asc')->get() as $facs)
            <option value="{{ $facs->faculty_id }}">
                {{ $facs->faculty }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('faculty_id')" class="mt-2" />
</div>
