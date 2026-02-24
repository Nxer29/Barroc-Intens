@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <h1 class="text-4xl font-bold text-white mb-2">
        Voorraadinstellingen
    </h1>
    <p class="text-gray-400 mt-2 mb-12">
        {{ $inventory->product->name }}
    </p>

    <form action="{{ route('inventory.update', $inventory->id) }}" method="POST"
        class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-8 shadow-xl">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Minimum voorraad</label>
                <input type="number" name="min_threshold"
                    class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                    value="{{ $inventory->min_threshold }}" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Locatie</label>
                <input type="text" name="location"
                    class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                    value="{{ $inventory->location }}">
            </div>

        </div>

        <button class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-6 py-3 rounded-lg font-semibold transition mt-6">Opslaan</button>
    </form>

</div>
@endsection