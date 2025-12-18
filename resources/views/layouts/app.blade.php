<!doctype html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ config('app.name','Barroc Intens') }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col font-sans transition-smooth bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <!-- ✨ ORIGINELE HEADER (ALLEEN VISIBILITY FIXED) -->
    <header class="sticky top-0 z-40 bg-white dark:bg-black shadow-md border-b border-yellow-400/50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-4">
                <img src="{{ asset('images/logo6_groot.png') }}"
                     alt="Barroc Intens"
                     class="h-12 transition-smooth dark:brightness-90" />
                <span class="hidden sm:inline text-xl font-bold tracking-wide text-yellow-500">
                    BARROC INTENS
                </span>
            </a>

            <!-- Navigation -->
            @auth
            <nav class="hidden md:flex items-center gap-6 text-sm">
                <a href="{{ route('dashboard') }}" class="hover:text-yellow-400">Dashboard</a>
                <a href="{{ route('products.index') }}" class="hover:text-yellow-400">Lijst</a>
                <a href="{{ route('inventory.index') }}" class="hover:text-yellow-400">Voorraad</a>
                <a href="{{ route('contracts.index') }}" class="hover:text-yellow-400">Contracts</a>
                @role('Admin')
                <a href="{{ route('admin-dashboard.index') }}" class="hover:text-yellow-400">Admin-Dashboard</a>
                @endrole
            </nav>

            <div class="flex items-center gap-3 ml-4">

                <!-- Theme toggle -->
                <button id="theme-toggle-btn"
                        class="text-sm px-3 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition"
                        title="Thema wisselen">
                    <i class="fa-solid fa-circle-half-stroke"></i>
                </button>

                <!-- User & logout -->
                <div class="hidden sm:flex items-center gap-3">
                    <span class="text-sm font-medium text-yellow-500">
                        {{ Auth::user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="bg-yellow-400 text-black px-4 py-1.5 rounded-lg hover:bg-yellow-500 transition">
                            Uitloggen
                        </button>
                    </form>
                </div>

            </div>
            @endauth
        </div>
    </header>

    <!-- MAIN CONTENT (ORIGINEEL GELATEN) -->
    <main class="flex-grow py-10 px-6">
        <div class="max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    <!-- FOOTER -->
<footer class="text-center text-gray-400 py-4 text-sm border-t border-gray-600 dark:border-gray-800">
        © {{ date('Y') }} Barroc Intens — All rights reserved by Bram.
    </footer>

</body>
</html>
