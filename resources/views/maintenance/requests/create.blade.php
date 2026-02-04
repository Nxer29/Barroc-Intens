@extends('layouts.app')

@section('content')
<div class="w-full max-w-4xl mx-auto py-8">

    <div class="bg-gray-900 rounded-2xl border border-yellow-400/40 p-6 shadow-lg">
        <h1 class="text-2xl font-bold text-yellow-400 mb-2">
            Storingsaanvraag aanmaken
        </h1>

        <p class="text-sm text-gray-400 mb-6">
            Klant: <span class="text-gray-200 font-medium">{{ $customer->displayName() }}</span>
        </p>

        {{-- FOUTMELDINGEN --}}
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-900/50 border border-red-500 p-4 text-red-200">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('maintenance.requests.store') }}" class="space-y-6">
            @csrf

            {{-- VERBORGEN KLANT --}}
            <input type="hidden" name="customer_id" value="{{ $customer->id }}">

            {{-- CONTRACT --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">
                    Contract
                </label>
                <select name="contract_id" required
                        class="w-full rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2">
                    <option value="">Selecteer contract</option>
                    @foreach($contracts as $contract)
                        <option value="{{ $contract->id }}">
                            {{ $contract->name }} ({{ $contract->status ?? 'onbekend' }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- PRODUCT / APPARAAT --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">
                    Apparaat
                </label>
                <select name="product_id" required
                        class="w-full rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2">
                    <option value="">Selecteer apparaat</option>

                    @foreach($contracts as $contract)
                        @foreach($contract->products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }} (contract: {{ $contract->name }})
                            </option>
                        @endforeach
                    @endforeach
                </select>
            </div>

            {{-- URGENTIE --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">
                    Urgentie
                </label>
                <select name="urgency" required
                        class="w-full rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2">
                    <option value="">Selecteer urgentie</option>
                    <option value="laag">Laag</option>
                    <option value="normaal">Normaal</option>
                    <option value="hoog">Hoog</option>
                    <option value="kritiek">Kritiek</option>
                </select>
            </div>

            {{-- PRIORITEIT --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">
                    Prioriteit
                </label>
                <select name="priority" required
                        class="w-full rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2">
                    <option value="">Selecteer prioriteit</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>

            {{-- OMSCHRIJVING --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">
                    Probleembeschrijving
                </label>
                <textarea name="issue_description" rows="4" required
                          class="w-full rounded-lg bg-gray-800 border border-gray-700 text-gray-200 p-2"
                          placeholder="Omschrijf de storing zo duidelijk mogelijk..."></textarea>
            </div>

            {{-- ACTIES --}}
            <div class="flex gap-3 pt-4">
                <button type="submit"
                        class="px-5 py-2 bg-yellow-400 text-gray-900 rounded-lg font-medium hover:opacity-90">
                    Verstuur naar Maintenance
                </button>

                <a href="{{ route('customers.show', $customer) }}"
                   class="px-5 py-2 border border-gray-700 text-gray-300 rounded-lg hover:bg-gray-800">
                    Annuleren
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
