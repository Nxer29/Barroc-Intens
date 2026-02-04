@extends('layouts.app')

@section('content')
<x-ui.header title="{{ $product->name }}">
    <x-ui.button
        variant="outline"
        class="border-gray-300 text-gray-800 hover:bg-gray-200 hover:text-gray-900"
        onclick="history.back()"
    >
        Terug
    </x-ui.button>
</x-ui.header>

<main class="max-w-4xl mx-auto p-6">
    <x-ui.card class="bg-white text-gray-900">
        <div class="md:flex gap-8">

            {{-- Afbeelding --}}
            <div class="md:w-1/3">
                <div class="bg-gray-200 h-56 flex items-center justify-center rounded-xl">
                    <span class="text-gray-500 text-sm">Geen afbeelding</span>
                </div>
            </div>

            {{-- Product info --}}
            <div class="md:flex-1 flex flex-col justify-between">

                <div>
                    <h2 class="text-3xl font-bold text-gray-900">
                        {{ $product->name }}
                    </h2>

                    <p class="text-sm text-gray-600 mt-1">
                        Categorie: {{ $product->category->name ?? 'Geen categorie' }}
                    </p>

                    <p class="mt-4 text-base text-gray-700 leading-relaxed">
                        {{ $product->description }}
                    </p>
                </div>

                {{-- Prijs + acties --}}
                <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    <span class="text-3xl font-bold text-gray-900">
                        € {{ number_format((float) $product->price, 2, ',', '.') }}
                    </span>

                    <div class="flex gap-3">
                        <x-ui.button class="bg-brand text-white hover:bg-brand-dark">
                            Bestel
                        </x-ui.button>

                        <x-ui.button
                            variant="outline"
                            class="border-gray-400 text-gray-800 hover:bg-gray-100 hover:text-gray-900"
                        >
                            Favoriet
                        </x-ui.button>
                    </div>
                </div>

            </div>
        </div>
    </x-ui.card>
</main>
@endsection
