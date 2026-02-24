<nav x-data="{ open: false }" class="bg-slate-900/90 border-b border-slate-800 shadow-sm backdrop-blur">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between h-16 items-center">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <img src="{{ asset('images/Logo6_klein.png') }}" alt="Barroc Intens" class="h-auto w-auto">
        </a>

        @auth
        <div class="hidden sm:flex space-x-6">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-nav-link>
            <x-nav-link :href="route('list')" :active="request()->routeIs('list')">
                Lijst
            </x-nav-link>
        </div>

        <div class="hidden sm:flex items-center space-x-4">
            <span class="text-sm text-slate-300">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-6 py-2 rounded-lg font-semibold transition">Log uit</button>
            </form>
        </div>
        @endauth

        @guest
        <a href="{{ route('login') }}" class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-6 py-2 rounded-lg font-semibold transition">Login</a>
        @endguest
    </div>
</nav>