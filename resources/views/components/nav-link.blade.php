@php
    $classes =
        'flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700';
@endphp

<li>
    <a {{ $attributes->merge(['href' => '#', 'class' => $classes]) }}
        wire:current="hover:bg-gray-300 bg-gray-200 dark:hover:bg-gray-900 dark:bg-gray-700">
        {{ $slot }}
    </a>
</li>
