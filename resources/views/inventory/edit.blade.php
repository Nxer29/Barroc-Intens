@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold text-[var(--brand-yellow)] mb-6">
    Voorraadinstellingen — {{ $inventory->product->name }}
</h1>

<form action="{{ route('inventory.update', $inventory->id) }}" method="POST"
      class="bg-gray-100 dark:bg-gray-900 p-8 rounded-xl border border-gray-700">
    @csrf @method('PUT')

    <div class="grid grid-cols-2 gap-6">

        <div>
            <label class="font-medium">Minimum voorraad</label>
            <input type="number" name="min_threshold"
                   class="input w-full"
                   value="{{ $inventory->min_threshold }}" required>
        </div>

        <div>
            <label class="font-medium">Locatie</label>
            <input type="text" name="location"
                   class="input w-full"
                   value="{{ $inventory->location }}">
        </div>

    </div>

    <button class="btn-yellow px-6 py-2 mt-6">Opslaan</button>
</form>
@endsection
