@extends('layouts.app')

@section('content')
<x-ui.header title="Product bewerken">
    <x-ui.button
        variant="outline"
        class="border-gray-300 text-gray-800 hover:bg-gray-200 hover:text-gray-900"
        onclick="location.href='{{ route('products.index') }}'"
    >
        Terug naar lijst
    </x-ui.button>
</x-ui.header>

<main class="max-w-4xl mx-auto p-6">

    {{-- Validatie fouten --}}
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-100 border border-red-300 text-red-800">
            <strong class="block mb-2">Er zijn fouten:</strong>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <x-ui.card class="bg-white text-gray-900">
        <form
            method="POST"
            action="{{ route('products.update', $product) }}"
            class="space-y-5"
        >
            @csrf
            @method('PUT')

            <x-ui.input
                label="Naam"
                name="name"
                value="{{ old('name', $product->name) }}"
                required
            />

            <x-ui.input
                label="Categorie"
                name="category"
                value="{{ old('category', $product->category) }}"
            />

            <x-ui.textarea
                label="Beschrijving"
                name="description"
            >{{ old('description', $product->description) }}</x-ui.textarea>

            <x-ui.input
                label="Prijs (€)"
                name="price"
                type="number"
                step="0.01"
                value="{{ old('price', $product->price) }}"
                required
            />

            <label class="flex items-center gap-3 text-sm text-gray-700">
                <input
                    type="checkbox"
                    name="is_visible_to_customers"
                    value="1"
                    @checked(old('is_visible_to_customers', $product->is_visible_to_customers))
                    class="rounded border-gray-300 text-brand focus:ring-brand"
                >
                <span>Zichtbaar voor klanten</span>
            </label>

            <div class="pt-4 flex justify-end gap-3">
                <x-ui.button
                    variant="outline"
                    class="border-gray-400 text-gray-800 hover:bg-gray-100"
                    onclick="location.href='{{ route('products.index') }}'"
                    type="button"
                >
                    Annuleren
                </x-ui.button>

                <x-ui.button class="bg-brand text-white hover:bg-brand-dark">
                    Opslaan
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>
</main>
@endsection
