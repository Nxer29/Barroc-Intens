@extends('layouts.app')

@section('content')
    <x-ui.header title="Nieuw product">
        <x-ui.button
            variant="outline"
            class="border-gray-300 text-gray-800 hover:bg-gray-200 hover:text-gray-900"
            onclick="location.href='{{ route('products.index') }}'"
        >
            Terug naar lijst
        </x-ui.button>
    </x-ui.header>

    <main class="max-w-4xl mx-auto p-6">
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-100 border border-red-300 text-red-800">
                <strong class="block mb-2">Er zijn fouten:</strong>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-ui.card class="bg-white text-gray-900">
            <form method="POST" action="{{ route('products.store') }}" class="space-y-5">
                @csrf

                <x-ui.input label="SKU" name="sku" value="{{ old('sku') }}" />
                <x-ui.input label="Naam" name="name" value="{{ old('name') }}" required />
                <x-ui.input label="Brand" name="brand" value="{{ old('brand') }}" />

                <x-ui.textarea label="Beschrijving" name="description">
                    {{ old('description') }}
                </x-ui.textarea>

                <x-ui.input label="Categorie" name="category_id" value="{{ old('category_id') }}" required />

                <x-ui.input
                    label="Unit prijs (€)"
                    name="unit_price"
                    type="number"
                    step="0.01"
                    value="{{ old('unit_price') }}"
                    required
                />

                <x-ui.input
                    label="Prijs (€)"
                    name="price"
                    type="number"
                    step="0.01"
                    value="{{ old('price') }}"
                    required
                />

                <x-ui.input
                    label="Voorraad"
                    name="stock"
                    type="number"
                    step="1"
                    min="0"
                    value="{{ old('stock') }}"
                    required
                />

                <label class="flex items-center gap-3 text-sm text-gray-700">
                    <input
                        type="checkbox"
                        name="is_visible_to_customers"
                        value="1"
                        @checked(old('is_visible_to_customers', true))
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

                    <x-ui.button class="bg-brand text-white hover:bg-brand-dark" type="submit">
                        Product aanmaken
                    </x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </main>
@endsection
