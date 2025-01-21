@props([
    'grade',
    'lower_bound',
    'upper_bound',
    'grade_point',
    ])


<div class="grid grid-cols-4 gap-6 mb-4">
    <div>
        <x-input-label for="{{ $grade }}" value="Grade" />
        <x-text-input wire:model.blur="{{ $grade }}" id="{{ $grade }}" type="text" placeholder="{{ $grade }}" required />

        <x-input-error :messages="$errors->get('{{ $grade }}')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="{{ $lower_bound }}" value="Lower bound" />
        <x-text-input wire:model.blur="{{ $lower_bound }}" id="{{ $lower_bound }}" type="number" required placeholder="Lower bound"
            required />
    </div>
    <div>
        <x-input-label for="{{ $grade }}" value="Upper bound" />
        <x-text-input wire:model.blur="{{ $grade }}" id="{{ $grade }}" type="number" required placeholder="Upper bound" required />
    </div>
    <div>
        <x-input-label for="{{ $grade_point }}" value="Grade Point" />
        <x-text-input wire:model.blur="{{ $grade_point }}" id="{{ $grade_point }}" type="number" required placeholder="100"
            required />
    </div>
</div>
