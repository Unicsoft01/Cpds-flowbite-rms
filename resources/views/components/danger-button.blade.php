<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900']) }}>
    {{ $slot }}
</button>
