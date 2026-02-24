@props(['variant' => 'primary'])

@php
$classes = match($variant) {
'outline' => 'px-6 py-3 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium',
'secondary' => 'px-6 py-3 rounded-lg bg-slate-700 text-white hover:bg-slate-600 transition font-medium',
default => 'bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-6 py-3 rounded-lg font-semibold transition'
};
@endphp

<button {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>