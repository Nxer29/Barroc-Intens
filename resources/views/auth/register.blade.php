@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen">
    <div class="bg-white/10 backdrop-blur-md border border-yellow-400/40 rounded-3xl shadow-2xl p-10 w-full max-w-md text-gray-100">
        <h2 class="text-3xl font-bold text-center text-yellow-400 mb-6">Account aanmaken</h2>
        <p class="text-center text-gray-300 mb-8">Registreer om het Barroc Intens platform te gebruiken</p>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm text-gray-300 mb-1">Naam</label>
                <input type="text" name="name" required
                    class="w-full rounded-xl border border-gray-700 bg-gray-900 text-gray-100 px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-1">E-mailadres</label>
                <input type="email" name="email" required
                    class="w-full rounded-xl border border-gray-700 bg-gray-900 text-gray-100 px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-1">Wachtwoord</label>
                <input type="password" name="password" required
                    class="w-full rounded-xl border border-gray-700 bg-gray-900 text-gray-100 px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-1">Bevestig wachtwoord</label>
                <input type="password" name="password_confirmation" required
                    class="w-full rounded-xl border border-gray-700 bg-gray-900 text-gray-100 px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
            </div>

            <button type="submit" class="w-full bg-yellow-400 text-black font-semibold py-2 rounded-xl hover:bg-yellow-500 transition">
                Registreren
            </button>

            <p class="text-center text-sm mt-6 text-gray-400">
                Al een account?
                <a href="{{ route('login') }}" class="text-yellow-400 hover:underline">Log in</a>
            </p>
        </form>
    </div>
</div>
@endsection