@props([
    'title' => 'Select a Department',
])
<div>
    <select wire:model.live="dept_id" id="dept_id" required
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center capitalize">
        <option value="">{{ $title }}</option>
        @forelse (\App\Models\Dept::where('user_id', Auth::user()->user_id)->orderBy('department', 'asc')->get(['dept_id', 'department']) as $dept)
            <option value="{{ $dept->dept_id }}">
                {{ $dept->department }}
            </option>
        @empty
            <option value="">Go create some Dept first!</option>
        @endforelse
    </select>
    <x-input-error :messages="$errors->get('dept_id')" class="mt-2" />
</div>
