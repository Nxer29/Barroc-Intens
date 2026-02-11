@props(['class' => ''])

<div {{ $attributes->merge([
    'class' => "
        relative
        rounded-2xl
        bg-gradient-to-br from-[#121a2e] to-[#0e1628]
        border border-white/5
        shadow-[0_20px_50px_rgba(0,0,0,0.4)]
        p-6
        {$class}
    "
]) }}>
    {{ $slot }}
</div>
