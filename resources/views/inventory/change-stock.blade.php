@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold text-[var(--brand-yellow)] mb-6">
    Voorraad wijzigen — {{ $product->name }}
</h1>

<form action="{{ route('inventory.change.post', $product->id) }}" 
      method="POST"
      class="bg-gray-100 dark:bg-gray-900 p-8 rounded-xl border border-gray-700 space-y-6">
    @csrf

    <div>
        <label class="font-medium">Aantal wijzigen (+ of -)</label>
        <input type="number" name="change" class="input w-full" required>
    </div>

    <div>
        <label class="font-medium">Reden</label>
        <input type="text" name="reason" class="input w-full" placeholder="Optioneel">
    </div>

    <div>
        <label class="font-medium">Locatie</label>
        <input type="text" name="location" class="input w-full" placeholder="Optioneel">
    </div>

    <button class="btn-yellow px-6 py-2">Opslaan</button>
</form>
@endsection
