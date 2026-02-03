@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">

    <h1 class="text-2xl font-bold text-yellow-400 mb-6">
        Nieuwe storingsaanvraag – {{ $customer->displayName() }}
    </h1>

    <form method="POST" action="{{ route('maintenance-requests.store') }}"
          class="bg-gray-900 border border-gray-800 rounded-2xl p-6 space-y-6">
        @csrf

        <input type="hidden" name="customer_id" value="{{ $customer->id }}">

        {{-- CONTRACT --}}
        <div>
            <label class="block text-sm text-gray-400 mb-1">Contract</label>
            <select name="contract_id" required class="w-full bg-gray-800 border border-gray-700 rounded-lg p-2">
                @foreach($contracts as $contract)
                    <option value="{{ $contract->id }}">
                        {{ $contract->name }} ({{ $contract->status }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- PRODUCT --}}
        <div>
            <label class="block text-sm text-gray-400 mb-1">Apparaat / Product</label>
            <select name="product_id" required class="w-full bg-gray-800 border border-gray-700 rounded-lg p-2">
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
            <label class="block text-sm text-gray-400 mb-1">Urgentie</label>
            <select name="urgency" required class="w-full bg-gray-800 border border-gray-700 rounded-lg p-2">
                <option value="low">Laag</option>
                <option value="medium">Normaal</option>
                <option value="high">Hoog</option>
            </select>
        </div>

        {{-- OMSCHRIJVING --}}
        <div>
            <label class="block text-sm text-gray-400 mb-1">Omschrijving storing</label>
            <textarea name="issue_description" rows="4" required
                      class="w-full bg-gray-800 border border-gray-700 rounded-lg p-2"></textarea>
        </div>

        {{-- ACTIONS --}}
        <div class="flex gap-3">
            <button class="px-4 py-2 bg-yellow-400 text-gray-900 rounded-lg font-medium">
                Doorzetten naar Maintenance
            </button>

            <a href="{{ route('customers.show', $customer) }}"
               class="px-4 py-2 border border-gray-700 text-gray-300 rounded-lg">
                Annuleren
            </a>
        </div>

    </form>
</div>
@endsection
