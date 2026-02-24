@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen">
    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 backdrop-blur-md border border-slate-700 rounded-3xl shadow-2xl p-10 w-full max-w-md text-white">
        <h2 class="text-4xl font-bold text-center text-white mb-2">Account aanmaken</h2>
        <p class="text-center text-gray-400 mb-8">Registreer om het Barroc Intens platform te gebruiken</p>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Naam</label>
                <input type="text" name="name" required
                    class="w-full rounded-lg border border-slate-600 bg-slate-700/50 text-white px-4 py-3 focus:ring-2 focus:ring-yellow-400 focus:outline-none placeholder-slate-400">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">E-mailadres</label>
                <input type="email" name="email" required
                    class="w-full rounded-lg border border-slate-600 bg-slate-700/50 text-white px-4 py-3 focus:ring-2 focus:ring-yellow-400 focus:outline-none placeholder-slate-400">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Wachtwoord</label>
                <input type="password" name="password" required
                    class="w-full rounded-lg border border-slate-600 bg-slate-700/50 text-white px-4 py-3 focus:ring-2 focus:ring-yellow-400 focus:outline-none placeholder-slate-400">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Bevestig wachtwoord</label>
                <input type="password" name="password_confirmation" required
                    class="w-full rounded-lg border border-slate-600 bg-slate-700/50 text-white px-4 py-3 focus:ring-2 focus:ring-yellow-400 focus:outline-none placeholder-slate-400">
            </div>

            <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-semibold py-3 rounded-lg transition">
                Registreren
            </button>

            <p class="text-center text-sm mt-6 text-gray-400">
                Al een account?
                <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 transition">Log in</a>
            </p>
        </form>
    </div>
</div>
@endsection