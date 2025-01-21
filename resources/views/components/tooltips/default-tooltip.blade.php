@props(['text'])

<div id="{{ $text }}" role="tooltip"
    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum aliquid esse eligendi pariatur quaerat, quae quod quo autem repellat iste corporis rem. Quisquam minima odio maxime cumque, quibusdam sapiente quasi?
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
