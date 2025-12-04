@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-[var(--brand-yellow)]">
        Voorraad — {{ $inventory->product->name }}
    </h1>

    <a href="{{ route('inventory.index') }}" class="btn-ghost">← Terug</a>
</div>

<div class="bg-gray-100 dark:bg-gray-900 p-8 rounded-xl border border-gray-700 space-y-4">

    <p><strong>Product:</strong> {{ $inventory->product->name }}</p>
    <p><strong>Categorie:</strong> {{ $inventory->product->category->name ?? '—' }}</p>
    <p><strong>Locatie:</strong> {{ $inventory->location ?? '—' }}</p>
    <p><strong>Minimum voorraad:</strong> {{ $inventory->min_threshold }}</p>

    <p class="text-lg font-bold {{ $inventory->is_below_threshold ? 'text-red-500' : 'text-green-400' }}">
        Voorraad: {{ $inventory->quantity }}
    </p>

    <a href="{{ route('inventory.change', $inventory->product_id) }}" 
       class="btn-yellow px-5 py-2">Voorraad wijzigen</a>
</div>
@endsection
