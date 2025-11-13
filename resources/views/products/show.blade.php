@extends('layouts.app')

@section('content')
<x-ui.header title="{{ $product->name }}">
    <x-ui.button variant="outline" onclick="history.back()">Terug</x-ui.button>
</x-ui.header>

<main class="max-w-4xl mx-auto p-6">
    <x-ui.card>
        <div class="md:flex gap-6">
            <div class="md:w-1/3 mb-4 md:mb-0">
                <div class="bg-gray-100 h-48 flex items-center justify-center rounded-xl">
                    <span class="text-gray-400">Afbeelding</span>
                </div>
            </div>
            <div class="md:flex-1">
                <h2 class="text-2xl text-brand-dark">{{ $product->name }}</h2>
                <p class="text-sm text-gray-600 mt-2">{{ $product->category }}</p>
                <p class="mt-4 text-base">{{ $product->description }}</p>

                <div class="mt-6 flex items-center gap-4">
                    <span class="text-2xl">{{ $product->price }}</span>
                    <x-ui.button>Bestel</x-ui.button>
                    <x-ui.button variant="outline">Favoriet</x-ui.button>
                </div>
            </div>
        </div>
    </x-ui.card>
</main>
@endsection
