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
        <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl overflow-hidden hover:shadow-2xl hover:border-slate-600 transition-all duration-300 group">

            {{-- Product Image --}}
            <div class="relative h-48 bg-slate-900/50 overflow-hidden">
                @if($product->images && $product->images->first())
                <img
                    src="{{ $product->images->first()->url }}"
                    alt="{{ $product->name }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                    onerror="this.src='{{ asset('images/no-image.png') }}'; this.onerror=null;">
                @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                @endif

                {{-- Stock Badge --}}
                <div class="absolute top-3 right-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $product->stock > 0 ? 'bg-green-500/90 text-white' : 'bg-red-500/90 text-white' }}">
                        @if($product->stock > 0)
                        Op voorraad ({{ $product->stock }})
                        @else
                        Uitverkocht
                        @endif
                    </span>
                </div>
            </div>

            {{-- Product Info --}}
            <div class="p-6">
                <h3 class="text-lg font-semibold text-white mb-1">
                    {{ $product->name }}
                </h3>

                <p class="text-sm text-slate-400 mb-4">
                    {{ $product->category->name ?? 'Geen categorie' }}
                </p>

                <div class="flex justify-between items-center mb-5">
                    <span class="text-slate-300 text-sm">
                        SKU: <span class="font-semibold">{{ $product->sku ?: 'N/A' }}</span>
                    </span>

                    <span class="text-2xl font-bold text-white">
                        € {{ number_format((float) $product->price, 2, ',', '.') }}
                    </span>
                </div>

                <div class="flex gap-3 text-sm">
                    <a href="{{ route('products.show', $product->id) }}"
                        class="flex-1 px-4 py-2 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium text-center">
                        Bekijk
                    </a>

                    <a href="{{ route('products.edit', $product->id) }}"
                        class="flex-1 px-4 py-2 rounded-lg bg-yellow-400/10 border border-yellow-400/30 text-yellow-400 hover:bg-yellow-400/20 transition font-medium text-center">
                        Bewerk
                    </a>
                </div>
            </div>
        </div>
        @empty
        <p class="text-slate-400 italic">Geen producten gevonden.</p>
        @endforelse
    </div>

</div>
@endsection