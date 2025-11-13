<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
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
                <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-primary">Log uit</button>
                </form>
            </div>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="btn-primary">Login</a>
        @endguest
    </div>
</nav>
