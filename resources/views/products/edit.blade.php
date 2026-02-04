@extends('layouts.app')

@section('content')

<x-ui.header title="Product bewerken">
    <x-ui.button variant="outline" onclick="location.href='{{ route('products.index') }}'">Terug naar lijst</x-ui.button>
</x-ui.header>
<main class="max-w-4xl mx-auto p-6">
    @if($errors->any())
        <div class="mb-4 p-3 rounded bg-red-900/50 border border-red-700 text-red-200">
            <strong class="block mb-1">Er zijn fouten:</strong>
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif




@endsection



        @section('content')
            <x-ui.header title="Producten">
                <x-ui.button variant="outline" onclick="location.href='{{ route('products.create') }}'">Nieuw</x-ui.button>
            </x-ui.header>

            <main class="max-w-4xl mx-auto p-6">
                <x-ui.card>
                    <div class="divide-y divide-gray-800">
                        @forelse($products as $product)
                            <div class="py-4 flex items-center justify-between">
                                <div>
                                    <div class="text-lg text-gray-100">{{ $product->name }}</div>
                                    <div class="text-sm text-gray-400">{{ $product->category }}</div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-ui.button variant="outline" onclick="location.href='{{ route('products.edit', $product) }}'">Bewerk</x-ui.button>
                                    <form method="POST" action="{{ route('products.destroy', $product) }}">
                                        @csrf @method('DELETE')
                                        <x-ui.button type="submit" variant="destructive">Verwijder</x-ui.button>
                                    </form>
                                </div>
                            </div>
                        @empty <div class="py-6 text-gray-400">Geen producten gevonden.</div>
                        @endforelse </div>
                </x-ui.card>
            </main>
        @endsection```

        ```blade@extends('layouts.app')

        @section('content')
            <x-ui.header title="Product bewerken">
                <x-ui.button variant="outline" onclick="location.href='{{ route('products.index') }}'">Terug naar lijst</x-ui.button>
            </x-ui.header>

            <main class="max-w-4xl mx-auto p-6">
                @if($errors->any())
                    <div class="mb-4 p-3 rounded bg-red-900/50 border border-red-700 text-red-200">
                        <strong class="block mb-1">Er zijn fouten:</strong>
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach </ul>
                    </div>
                @endif <x-ui.card>
                    <form method="POST" action="{{ route('products.update', $product) }}" class="space-y-4">
                        @csrf @method('PUT')

                        <x-ui.input label="Naam" name="name" value="{{ old('name', $product->name) }}" required />
                        <x-ui.input label="Categorie" name="category" value="{{ old('category', $product->category) }}" />
                        <x-ui.textarea label="Beschrijving" name="description">{{ old('description', $product->description) }}</x-ui.textarea>
                        <x-ui.input label="Prijs" name="price" type="number" step="0.01" value="{{ old('price', $product->price) }}" required />

                        <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-200">
                            <x-ui.input type="checkbox" name="is_visible_to_customers" value="1" :checked="old('is_visible_to_customers', $product->is_visible_to_customers)" />
                            <span>Zichtbaar</span>
                        </label>

                        <div class="pt-2">
                            <x-ui.button type="submit">Opslaan</x-ui.button>
                        </div>
                    </form>
                </x-ui.card>
            </main>
        @endsection```
