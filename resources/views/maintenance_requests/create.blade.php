@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <h1 class="text-4xl font-bold text-white mb-2">
        Nieuwe storingsaanvraag
    </h1>
    <p class="text-gray-400 mt-2 mb-12">
        {{ $customer->displayName() }}
    </p>

    <form method="POST" action="{{ route('maintenance-requests.store') }}"
        class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-8 shadow-xl space-y-6">
        @csrf

        <input type="hidden" name="customer_id" value="{{ $customer->id }}">

        {{-- CONTRACT --}}
        <div>
            <label class="block text-sm font-semibold text-slate-300 mb-2">Contract</label>
            <select name="contract_id" required class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                @foreach($contracts as $contract)
                <option value="{{ $contract->id }}">
                    {{ $contract->name }} ({{ $contract->status }})
                </option>
                @endforeach
            </select>
        </div>

        {{-- PRODUCT --}}
        <div>
            <label class="block text-sm font-semibold text-slate-300 mb-2">Apparaat / Product</label>
            <select name="product_id" required class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                @foreach($contracts as $contract)
                <optgroup label="Contract: {{ $contract->name }}">
                    @foreach($contract->products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }}
                    </option>
                    @endforeach
                </optgroup>
                @endforeach
            </select>
        </div>

        {{-- URGENTIE --}}
        <div>
            <label class="block text-sm font-semibold text-slate-300 mb-2">Urgentie</label>
            <select name="urgency" required class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                <option value="low">Laag</option>
                <option value="medium">Normaal</option>
                <option value="high">Hoog</option>
            </select>
        </div>

        {{-- OMSCHRIJVING --}}
        <div>
            <label class="block text-sm font-semibold text-slate-300 mb-2">Omschrijving storing</label>
            <textarea name="issue_description" rows="4" required
                class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"></textarea>
        </div>

        {{-- ACTIONS --}}
        <div class="flex gap-4">
            <button class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-6 py-3 rounded-lg font-semibold transition">
                Doorzetten naar Maintenance
            </button>

            <a href="{{ route('customers.show', $customer) }}"
                class="px-6 py-3 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">
                Annuleren
            </a>
        </div>

    </form>
</div>
@endsection