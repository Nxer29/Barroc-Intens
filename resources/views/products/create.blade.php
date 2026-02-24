@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="flex justify-between items-start mb-12">
        <div>
            <h1 class="text-4xl font-bold text-white">Nieuw product</h1>
            <p class="text-gray-400 mt-2">Voeg een nieuw product toe aan het systeem</p>
        </div>
        <a href="{{ route('products.index') }}" class="px-6 py-3 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">
            Terug naar lijst
        </a>
    </div>

    <main>
        @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-500 bg-red-900/20 px-4 py-3 text-red-300">
            <strong class="block mb-2">Er zijn fouten:</strong>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-8 shadow-xl">
            <form method="POST" action="{{ route('products.store') }}" class="space-y-5">
                @csrf

                <x-ui.input label="SKU" name="sku" value="{{ old('sku') }}" />
                <x-ui.input label="Naam" name="name" value="{{ old('name') }}" required />
                <x-ui.input label="Brand" name="brand" value="{{ old('brand') }}" />

                <x-ui.textarea label="Beschrijving" name="description">
                    {{ old('description') }}
                </x-ui.textarea>

                <div>
                    <label for="category_id" class="block text-sm font-semibold text-slate-300 mb-2">Categorie</label>
                    <select
                        id="category_id"
                        name="category_id"
                        class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                        required>
                        <option value="">Selecteer categorie</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id')==$category->id)>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <x-ui.input
                    label="Unit prijs (€)"
                    name="unit_price"
                    type="number"
                    step="0.01"
                    value="{{ old('unit_price') }}"
                    required />

                <x-ui.input
                    label="Prijs (€)"
                    name="price"
                    type="number"
                    step="0.01"
                    value="{{ old('price') }}"
                    required />

                <x-ui.input
                    label="Voorraad"
                    name="stock"
                    type="number"
                    step="1"
                    min="0"
                    value="{{ old('stock') }}"
                    required />

                <label class="flex items-center gap-3 text-sm text-slate-300">
                    <input
                        type="checkbox"
                        name="is_visible_to_customers"
                        value="1"
                        @checked(old('is_visible_to_customers', true))
                        class="rounded border-slate-600 bg-slate-700/50 text-yellow-400 focus:ring-yellow-400">
                    <span>Zichtbaar voor klanten</span>
                </label>

                <div class="pt-4 flex justify-end gap-4">
                    <a href="{{ route('products.index') }}" class="px-6 py-3 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">
                        Annuleren
                    </a>

                    <button type="submit" class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-6 py-3 rounded-lg font-semibold transition">
                        Product aanmaken
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection