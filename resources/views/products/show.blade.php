@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="flex justify-between items-start mb-12">
        <div>
            <h1 class="text-4xl font-bold text-white">{{ $product->name }}</h1>
            <p class="text-gray-400 mt-2">
                Categorie: {{ $product->category->name ?? 'Geen categorie' }}
            </p>
        </div>
        <a href="{{ route('products.index') }}" class="px-6 py-3 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">
            Terug naar lijst
        </a>
    </div>

    <main>
        <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-8 shadow-xl">
            <div class="md:flex gap-8">


                {{-- Afbeelding --}}
                <div class="md:w-1/3">
                    @php
                        $firstImage = $product->images->first();
                    @endphp

                    @if ($firstImage)
                        <img
                            src="{{ asset('storage/' . $firstImage->path) }}"
                            alt="Productfoto van {{ $product->name }}"
                            class="h-56 w-full object-cover rounded-xl border"
                        >
                    @else
                        <div class="bg-gray-200 h-56 flex items-center justify-center rounded-xl">
                            <span class="text-gray-500 text-sm">Geen afbeelding</span>
                        </div>
                    @endif

                    {{-- Optioneel: thumbnails van alle foto's --}}
                    @if ($product->images->count() > 1)
                        <div class="grid grid-cols-3 gap-2 mt-3">
                            @foreach ($product->images as $img)
                                <img
                                    src="{{ asset('storage/' . $img->path) }}"
                                    alt="Productfoto"
                                    class="h-20 w-full object-cover rounded-lg border"
                                >
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Product info --}}
                <div class="md:flex-1 flex flex-col justify-between">

                    <div>
                        <h2 class="text-3xl font-bold text-white">
                            {{ $product->name }}
                        </h2>

                        <p class="text-sm text-gray-400 mt-1">
                            Categorie: {{ $product->category->name ?? 'Geen categorie' }}
                        </p>

                        <p class="mt-4 text-base text-slate-300 leading-relaxed">
                            {{ $product->description }}
                        </p>
                    </div>

                    {{-- Prijs + acties --}}
                    <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                        <span class="text-3xl font-bold text-white">
                            € {{ number_format((float) $product->price, 2, ',', '.') }}
                        </span>

                        <div class="flex gap-3">
                            <button class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-6 py-3 rounded-lg font-semibold transition">
                                Bestel
                            </button>

                            <button class="px-6 py-3 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">
                                Favoriet
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
</div>
@endsection
