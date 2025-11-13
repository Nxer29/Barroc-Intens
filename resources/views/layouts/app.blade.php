<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barroc Intens</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black text-gray-100 min-h-screen flex flex-col">

    <!-- HEADER -->
    <header class="bg-black/90 backdrop-blur shadow-md border-b border-yellow-400">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/Logo6_klein.png') }}" alt="Barroc Intens" class="h-10">
                <h1 class="text-2xl font-semibold text-white tracking-wide">BARROC INTENS</h1>
            </div>

            @auth
            <nav class="flex gap-6 text-sm font-medium">
                <a href="{{ route('dashboard') }}" class="hover:text-yellow-400 transition">Dashboard</a>
                <a href="{{ route('products.index') }}" class="hover:text-yellow-400 transition">Lijst</a>
                <a href="{{ route('profile.edit') }}" class="hover:text-yellow-400 transition">Profiel</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="bg-yellow-400 text-black px-4 py-1.5 rounded-lg hover:bg-yellow-500 transition">Log uit</button>
                </form>
            </nav>
            @endauth
        </div>
    </header>

    <!-- CONTENT -->
    <main class="flex-grow flex items-center justify-center p-6">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="text-center text-gray-400 py-4 text-sm border-t border-gray-700">
        © {{ date('Y') }} Barroc Intens — Ontwikkeld met passie & precisie.
    </footer>

</body>
</html>
