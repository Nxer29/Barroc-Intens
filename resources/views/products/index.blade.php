@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-8">

    <h2 class="text-2xl font-bold text-yellow-400 mb-6">Producten</h2>

    {{-- FILTER --}}
    <form method="GET" action="{{ route('products.index') }}" class="mb-6 flex flex-wrap gap-4">
        <input
            name="q"
            value="{{ request('q') }}"
            placeholder="Zoek op naam of beschrijving"
            class="bg-gray-900 border border-gray-700 rounded px-4 py-2 text-gray-200 flex-1"
        >

        <button type="submit"
            class="bg-yellow-400 px-4 py-2 rounded text-gray-900 font-medium hover:opacity-90">
            Zoeken
        </button>

        <a href="{{ route('products.create') }}"
           class="bg-yellow-400 px-4 py-2 rounded text-gray-900 font-medium hover:opacity-90">
            Nieuw product
        </a>
    </form>

    {{-- PRODUCT GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($products as $product)
            <div class="bg-gray-900 border border-yellow-400/30 rounded-xl p-5 hover:bg-gray-800 transition">

                <h3 class="text-lg font-semibold text-yellow-300 mb-1">
                    {{ $product->name }}
                </h3>

                <p class="text-sm text-gray-400 mb-3">
                    {{ $product->category->name ?? 'Geen categorie' }}
                </p>

                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-300">
                        Voorraad: {{ $product->stock }}
                    </span>

                    <span class="text-xl font-bold text-gray-100">
                        € {{ number_format((float) $product->price, 2, ',', '.') }}
                    </span>
                </div>

                <div class="flex gap-4 text-sm">
                    <a href="{{ route('products.show', $product->id) }}"
                       class="text-yellow-300 hover:underline">
                        Bekijk
                    </a>

                    <a href="{{ route('products.edit', $product->id) }}"
                       class="text-yellow-300 hover:underline">
                        Bewerk
                    </a>
                </div>
            </div>
        @empty
            <p class="text-gray-400 italic">Geen producten gevonden.</p>
        @endforelse
    </div>

</div>
@endsection
