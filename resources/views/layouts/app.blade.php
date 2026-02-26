<!doctype html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name','Barroc Intens') }}</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#0b1220] text-gray-200 font-sans antialiased">

    {{-- BACKGROUND GLOW --}}
    <div class="fixed inset-0 -z-10">
        <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] bg-blue-500/20 blur-[120px]"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[500px] h-[500px] bg-yellow-400/10 blur-[120px]"></div>
    </div>

    {{-- TOPBAR --}}
    <header class="sticky top-0 z-40 backdrop-blur bg-[#0b1220]/80 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">

            {{-- Logo --}}
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo6_groot.png') }}"
                    class="h-10" alt="Barroc Intens">

                <span class="hidden sm:inline text-lg font-bold tracking-wide text-yellow-400">
                    Barroc Intens
                </span>
            </div>

            {{-- Navigation --}}
            @auth
            <nav class="hidden md:flex items-center gap-6 text-sm">
                <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('products.index') }}" class="nav-link">Producten</a>
                <a href="{{ route('inventory.index') }}" class="nav-link">Voorraad</a>
                <a href="{{ route('contracts.index') }}" class="nav-link">Contracten</a>
                <a href="{{ route('invoices.overview') }}" class="nav-link">Facturen</a>
                <a href="{{ route('contact') }}" class="nav-link">Contact</a>

                @role('Admin')
                <a href="{{ route('admin-dashboard.index') }}" class="nav-link text-yellow-400 font-semibold">
                    Admin
                </a>
                @endrole
            </nav>

            {{-- User --}}
            <div class="flex items-center gap-4">
                <span class="hidden sm:inline text-sm text-gray-400">
                    {{ Auth::user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="px-4 py-1.5 rounded-lg bg-yellow-400 text-gray-900 font-semibold hover:bg-yellow-300 transition">
                        Uitloggen
                    </button>
                </form>
            </div>
            @endauth

        </div>
    </header>

    {{-- CONTENT --}}
    <main class="py-12 px-6">
        <div class="max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="text-center text-xs text-gray-500 py-6">
        © {{ date('Y') }} Barroc Intens
    </footer>

</body>

</html>