@props(['linktext' => 'link'])

@php
    $classes =
        'flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700';
@endphp

<li>
    <a {{ $attributes->merge(['href' => '#', 'class' => $classes]) }} wire:navigate
        wire:current="hover:bg-gray-300 bg-gray-200 dark:hover:bg-gray-900 dark:bg-gray-700">
        {{ $linktext }}
    </a>
</li>
