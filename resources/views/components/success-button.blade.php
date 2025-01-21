<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-800 focus:ring-4 focus:ring-green-300 dark:focus:ring-green-900']) }}>
    {{ $slot }}
</button>

