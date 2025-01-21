@props(['value'])

<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'px-5 py-2 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 sm:w-auto dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition ease-in-out duration-150']) }}>
    <span wire:loading>
        <x-icons.loading-icon />
    </span>
    {{ $value ?? $slot }}
</button>
