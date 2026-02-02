@extends('layouts.app')

@section('content')

<x-ui.header title="Nieuw product">
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

    <form method="POST" action="{{ route('products.store') }}" class="space-y-6">
        @csrf
        <div class="bg-gray-900 rounded-2xl border border-yellow-400/20 p-6">

        <div>
            <label class="block text-sm font-medium text-gray-200"></label>
            <x-ui.input label="sku" name="sku" value="{{old('sku')}}" required/>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-200"></label>
            <x-ui.input label="Naam" name="name" value="{{ old('name') }}" required />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-200"></label>
            <x-ui.input label="brand" name="brand" value="{{ old('brand') }}" required />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-200"></label>
            <x-ui.input label="Beschrijving" name="description" value="{{ old('description') }}" required textarea />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-200"></label>
            <x-ui.input label="Categorie" name="category_id" value="{{ old('category_id') }}" required />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-200"></label>
            <x-ui.input label="Unit prijs" name="unit_price" value="{{ old('unit_price') }}" required />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-200"></label>
            <x-ui.input label="Prijs" name="price" value="{{ old('price') }}" required />
        </div>

       <div>
           <label class="block text-sm font-medium text-gray-200"></label>
           <x-ui.input type="checkbox" label="Zichtbaar" name="is_visible_to_customers" value="1" :checked="old('is_visible_to_customers')" required/>
       </div>

        <div>
            <label class="block text-sm font-medium text-gray-200"></label>
            <x-ui.input label="Voorraad" name="stock" value="{{ old('stock') }}" required />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-200"></label>
            <x-ui.button type="submit">Product aanmaken</x-ui.button>
        </div>
</div>
    </form>
</main>
@endsection
