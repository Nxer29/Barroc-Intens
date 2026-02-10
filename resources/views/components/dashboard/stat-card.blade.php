@props([
'title',
'value',
'icon' => null,
'actionText' => null,
'actionUrl' => null,
])

<x-ui.card class="relative overflow-hidden p-6 bg-gradient-to-br from-slate-900 to-slate-800 text-white">

    @if($icon)
    <div class="absolute top-4 right-4 opacity-20 text-6xl">
        <i class="{{ $icon }}"></i>
    </div>
    @endif

    <div class="space-y-2">
        <p class="text-sm uppercase tracking-wide text-slate-300">
            {{ $title }}
        </p>

        <p class="text-4xl font-bold">
            {{ $value }}
        </p>
    </div>

    @if($actionText && $actionUrl)
    <a href="{{ $actionUrl }}"
        class="inline-flex items-center mt-6 text-sm font-medium text-yellow-400 hover:underline">
        {{ $actionText }} →
    </a>
    @endif

</x-ui.card>