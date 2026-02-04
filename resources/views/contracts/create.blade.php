@extends('layouts.app')

@section('content')
<div class="w-full max-w-4xl mx-auto py-8">
    <div class="bg-gray-900 rounded-2xl border border-yellow-400/20 p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-yellow-400">
                {{ isset($contract) ? 'Contract bewerken' : 'Nieuw contract' }}
            </h1>
            <div class="text-sm">
                <a href="{{ route('contracts.index') }}" class="text-yellow-300 hover:underline">Terug naar lijst</a>
            </div>
        </div>

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

        <form method="POST" action="{{ isset($contract) ? route('contracts.update', $contract) : route('contracts.store') }}" class="space-y-6">
            @csrf
            @if(isset($contract)) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300">Klant</label>
                    <select name="customer_id" required
                            class="mt-1 block w-full rounded-md bg-gray-800 border border-gray-700 text-gray-100 px-3 py-2 focus:outline-none focus:border-yellow-400">
                        @foreach($customers as $cust)
                            <option value="{{ $cust->id }}" {{ old('customer_id', $contract->customer_id ?? '') == $cust->id ? 'selected' : '' }}>
                                {{ $cust->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300">Naam (omschrijving)</label>
                    <input type="text" name="name" value="{{ old('name', $contract->name ?? '') }}"
                           class="mt-1 block w-full rounded-md bg-gray-800 border border-gray-700 text-gray-100 px-3 py-2 focus:outline-none focus:border-yellow-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300">Start datum</label>
                    <input type="date" name="start_date" value="{{ old('start_date', isset($contract) && $contract->start_date ? $contract->start_date->format('Y-m-d') : '') }}" required
                           class="mt-1 block w-full rounded-md bg-gray-800 border border-gray-700 text-gray-100 px-3 py-2 focus:outline-none focus:border-yellow-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300">Eind datum</label>
                    <input type="date" name="end_date" value="{{ old('end_date', isset($contract) && $contract->end_date ? $contract->end_date->format('Y-m-d') : '') }}"
                           class="mt-1 block w-full rounded-md bg-gray-800 border border-gray-700 text-gray-100 px-3 py-2 focus:outline-none focus:border-yellow-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300">Recurring bedrag</label>
                    <input type="number" step="0.01" name="recurring_amount" value="{{ old('recurring_amount', $contract->recurring_amount ?? '') }}"
                           class="mt-1 block w-full rounded-md bg-gray-800 border border-gray-700 text-gray-100 px-3 py-2 focus:outline-none focus:border-yellow-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300">Status</label>
                    <input type="text" name="status" value="{{ old('status', $contract->status ?? 'active') }}"
                           class="mt-1 block w-full rounded-md bg-gray-800 border border-gray-700 text-gray-100 px-3 py-2 focus:outline-none focus:border-yellow-400">
                </div>
            </div>


            <div>
                <h3 class="text-lg font-semibold text-yellow-300 mb-3">Producten</h3>

                <div class="space-y-3">
                    @php
                        $existing = isset($contract) ? $contract->products->keyBy('id') : collect(old('products', []))->flip();
                    @endphp

                    @foreach($products as $p)
                        @php
                            $checked = (isset($contract) && $contract->products->contains('id', $p->id)) || in_array($p->id, (array) old('products', []));
                            $existing = isset($contract) ? $contract->products->keyBy('id') : collect();
                        @endphp

                        <div class="flex items-center gap-4 bg-gray-850 rounded p-3 border border-gray-800">
                            <div class="flex items-center gap-3 w-1/2">
                                <input type="checkbox"
                                       name="products[]"
                                       value="{{ $p->id }}"
                                       id="prod-{{ $p->id }}"
                                       class="h-4 w-4 text-yellow-400"
                                    {{ $checked ? 'checked' : '' }}>
                                <label for="prod-{{ $p->id }}" class="text-gray-200 font-medium">{{ $p->name }}</label>
                            </div>

                            <div class="flex items-center gap-3 ml-auto">
                                <div class="text-sm text-gray-400">Prijs</div>
                                <input type="number"
                                       name="unit_prices[{{ $p->id }}]"
                                       step="0.01"
                                       value="{{ old('unit_prices.' . $p->id, $existing[$p->id]->pivot->unit_price ?? $p->price ?? '') }}"
                                       class="w-28 rounded bg-gray-800 border border-gray-700 px-2 py-1 text-gray-100">

                                <div class="text-sm text-gray-400">Aantal</div>
                                <input type="number"
                                       name="quantities[{{ $p->id }}]"
                                       min="1"
                                       value="{{ old('quantities.' . $p->id, $existing[$p->id]->pivot->quantity ?? 1) }}"
                                       class="w-20 rounded bg-gray-800 border border-gray-700 px-2 py-1 text-gray-100">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-yellow-400 text-gray-900 rounded-md font-medium hover:opacity-95">
                    {{ isset($contract) ? 'Opslaan wijzigingen' : 'Contract aanmaken' }}
                </button>

                <a href="{{ route('contracts.index') }}" class="px-4 py-2 border border-gray-700 text-gray-300 rounded-md hover:bg-gray-850">Annuleren</a>
            </div>
        </form>
    </div>
</div>
@endsection
