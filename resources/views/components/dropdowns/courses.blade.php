<div>
    <select wire:model.live="course_id" id="course_id" required
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center">
        <option value="">Select a course</option>
        @forelse (\App\Models\Courses::where('user_id', Auth::user()->user_id)->orderBy('course_code', 'asc')->get(['course_id', 'course_code']) as $cus)
            <option value="{{ $cus->course_id }}">
                {{ $cus->course_code }}
            </option>
        @empty
            <option value="">Go create some Courses first!</option>
        @endforelse
    </select>
    <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
</div>
