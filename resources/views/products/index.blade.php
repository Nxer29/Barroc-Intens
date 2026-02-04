
@extends('layouts.app')

@section('content')
    <x-ui.header title="Producten">
        <x-ui.button variant="outline" onclick="location.href='{{ route('products.index') }}'">Refresh</x-ui.button>
    </x-ui.header>

    <main class="max-w-6xl mx-auto p-6">
        <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row gap-3 mb-6">
            <x-ui.input name="q" placeholder="Zoek op naam of beschrijving" class="md:flex-1" />
            <x-ui.button type="submit" class="md:w-40">Zoeken</x-ui.button>
            <a href="{{ route('products.create') }}">
                <x-ui.button type="button" class="md:w-40">Nieuw product</x-ui.button>
            </a>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
                <a href="{{ route('products.edit', $product->id) }}">
                    <x-ui.button type="button" class="md:w-40">Bewerken</x-ui.button>
                </a>

                <a href="{{ route('products.show', $product->id) }}">
                    <x-ui.card>
                        <h3 class="text-lg text-brand-dark">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $product->category }}</p>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="font-display color: var(--color-black);">{{ $product->price }}</span>
                            <span class="text-sm text-gray-500">Voorraad: {{ $product->stock }}</span>
                        </div>
                    </x-ui.card>
                </a>
            @endforeach </div>
    </main>
@endsection
