@props([
    'title' => 'Select an Academic Session',
])
<div>
    <select wire:model.live="session_id" id="session_id" required
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center">
        <option value="">{{ $title }}</option>
        @forelse (\App\Models\AcademicSessions::orderBy('session', 'desc')->get(['session_id', 'session']) as $session)
            <option value="{{ $session->session_id }}">
                {{ $session->session }}/{{ $session->session + 1 }}
            </option>
        @empty
            <option value="">Go create some Session first!</option>
        @endforelse
    </select>
    <x-input-error :messages="$errors->get('session_id')" class="mt-2" />
</div>
