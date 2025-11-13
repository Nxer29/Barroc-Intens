@props(['variant' => 'primary'])

@php
    $classes = match($variant) {
        'outline' => 'px-4 py-2 border-2 border-brand-dark text-brand-dark font-display uppercase rounded-xl hover:bg-brand-dark hover:text-brand-white transition',
        'secondary' => 'px-4 py-2 bg-brand-dark text-brand-white font-display uppercase rounded-xl hover:bg-brand-yellow hover:text-brand-dark transition',
        default => 'px-4 py-2 bg-brand-yellow text-brand-dark font-display uppercase rounded-xl hover:bg-yellow-400 transition'
    };
@endphp

<button {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
