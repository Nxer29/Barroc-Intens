@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-white">Producten</h1>
        <p class="text-gray-400 mt-2">
            Overzicht van alle producten en categorieën
        </p>
    </div>

    {{-- FILTER --}}
    <form method="GET" action="{{ route('products.index') }}" class="mb-8 flex flex-wrap gap-4">
        <input
            name="q"
            value="{{ request('q') }}"
            placeholder="Zoek op naam of beschrijving"
            class="bg-slate-800 border border-slate-700 rounded-lg px-4 py-3 text-gray-200 flex-1 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">

        <button type="submit"
            class="bg-yellow-400 hover:bg-yellow-300 px-6 py-3 rounded-lg text-gray-900 font-semibold transition">
            Zoeken
        </button>

        <a href="{{ route('products.create') }}"
            class="bg-yellow-400 hover:bg-yellow-300 px-6 py-3 rounded-lg text-gray-900 font-semibold transition">
            Nieuw product
        </a>
    </form>

    {{-- PRODUCT GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($products as $product)
        <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-6 hover:shadow-2xl hover:border-slate-600 transition-all duration-300">

            <h3 class="text-lg font-semibold text-white mb-1">
                {{ $product->name }}
            </h3>

            <p class="text-sm text-slate-400 mb-4">
                {{ $product->category->name ?? 'Geen categorie' }}
            </p>

            <div class="flex justify-between items-center mb-5">
                <span class="text-slate-300 text-sm">
                    Voorraad: <span class="font-semibold">{{ $product->stock }}</span>
                </span>

                <span class="text-2xl font-bold text-white">
                    € {{ number_format((float) $product->price, 2, ',', '.') }}
                </span>
            </div>

            <div class="flex gap-3 text-sm">
                <a href="{{ route('products.show', $product->id) }}"
                    class="px-4 py-2 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">
                    Bekijk
                </a>

                <a href="{{ route('products.edit', $product->id) }}"
                    class="px-4 py-2 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">
                    Bewerk
                </a>
            </div>
        </div>
        @empty
        <p class="text-slate-400 italic">Geen producten gevonden.</p>
        @endforelse
    </div>

</div>
@endsection