@props(['label' => null, 'name' => '', 'type' => 'text', 'placeholder' => ''])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-display uppercase text-brand-dark mb-1">
            {{ $label }}
        </label>
    @endif

    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'border border-brand-dark rounded-xl w-full px-3 py-2 text-brand-dark focus:outline-none focus:ring-2 focus:ring-brand-yellow transition']) }}>
</div>
