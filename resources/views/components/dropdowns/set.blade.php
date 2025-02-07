@props([
    'title' => 'Select a Set',
    'makeLive' => true,
])
<div>
    <select @if ($makeLive) wire:model.live="set"
    @else wire:model="set" @endif name="set"
        id="set" required
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center">
        <option value="">{{ $title }}</option>
        @forelse (\App\Models\AcademicSessions::orderBy('session', 'desc')->get(['session_id', 'session']) as $set)
            <option value="{{ $set->session_id }}">
                {{ $set->session }}/{{ $set->session + 1 }}
            </option>
        @empty
            <option value="">Go create some Session first!</option>
        @endforelse
    </select>
    <x-input-error :messages="$errors->get('set')" class="mt-2" />
</div>
