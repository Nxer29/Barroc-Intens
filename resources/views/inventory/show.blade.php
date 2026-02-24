@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="flex justify-between items-start mb-12">
        <div>
            <h1 class="text-4xl font-bold text-white">
                Voorraad
            </h1>
            <p class="text-gray-400 mt-2">
                {{ $inventory->product->name }}
            </p>
        </div>

        <a href="{{ route('inventory.index') }}" class="px-6 py-3 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">← Terug</a>
    </div>

    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-8 shadow-xl space-y-4">

        <p class="text-slate-300"><strong class="text-slate-400">Product:</strong> {{ $inventory->product->name }}</p>
        <p class="text-slate-300"><strong class="text-slate-400">Categorie:</strong> {{ $inventory->product->category->name ?? '—' }}</p>
        <p class="text-slate-300"><strong class="text-slate-400">Locatie:</strong> {{ $inventory->location ?? '—' }}</p>
        <p class="text-slate-300"><strong class="text-slate-400">Minimum voorraad:</strong> {{ $inventory->min_threshold }}</p>

        <p class="text-lg font-bold {{ $inventory->is_below_threshold ? 'text-red-400' : 'text-emerald-400' }}">
            Voorraad: {{ $inventory->quantity }}
        </p>

        <a href="{{ route('inventory.change', $inventory->product_id) }}"
            class="inline-block bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-6 py-3 rounded-lg font-semibold transition mt-4">Voorraad wijzigen</a>
    </div>

</div>
@endsection