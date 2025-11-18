@props(['title'])

<header class="w-full bg-brand-dark text-brand-yellow py-4 px-6 flex items-center justify-between rounded-b-2xl shadow">
    <h1 class="text-2xl font-display uppercase tracking-wide">{{ $title }}</h1>
    <div>
        {{ $slot }}
    </div>
</header>
