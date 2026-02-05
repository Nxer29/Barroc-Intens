@props(['label' => null, 'name' => '', 'placeholder' => ''])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-display uppercase text-brand-dark mb-1 text-black">
            {{ $label }}
        </label>
    @endif

    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'border border-brand-dark rounded-xl w-full px-3 py-2 text-brand-dark focus:outline-none focus:ring-2 focus:ring-brand-yellow transition']) }}
    >{{ $slot }}</textarea>
</div>
