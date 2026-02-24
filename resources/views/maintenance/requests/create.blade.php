@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-8 shadow-xl">
        <h1 class="text-4xl font-bold text-white mb-2">
            Storingsaanvraag aanmaken
        </h1>

        <p class="text-gray-400 mt-2 mb-8">
            Klant: <span class="text-white font-medium">{{ $customer->displayName() }}</span>
        </p>

        {{-- FOUTMELDINGEN --}}
        @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-500 bg-red-900/20 px-4 py-3 text-red-300">
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
                <label class="block text-sm font-semibold text-slate-300 mb-2">
                    Contract
                </label>
                <select name="contract_id" required
                    class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
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
                <label class="block text-sm font-semibold text-slate-300 mb-2">
                    Apparaat
                </label>
                <select name="product_id" required
                    class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
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
                <label class="block text-sm font-semibold text-slate-300 mb-2">
                    Urgentie
                </label>
                <select name="urgency" required
                    class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                    <option value="">Selecteer urgentie</option>
                    <option value="laag">Laag</option>
                    <option value="normaal">Normaal</option>
                    <option value="hoog">Hoog</option>
                    <option value="kritiek">Kritiek</option>
                </select>
            </div>

            {{-- PRIORITEIT --}}
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">
                    Prioriteit
                </label>
                <select name="priority" required
                    class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                    <option value="">Selecteer prioriteit</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>

            {{-- OMSCHRIJVING --}}
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">
                    Probleembeschrijving
                </label>
                <textarea name="issue_description" rows="4" required
                    class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                    placeholder="Omschrijf de storing zo duidelijk mogelijk..."></textarea>
            </div>

            {{-- ACTIES --}}
            <div class="flex gap-4 pt-4">
                <button type="submit"
                    class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-6 py-3 rounded-lg font-semibold transition">
                    Verstuur naar Maintenance
                </button>

                <a href="{{ route('customers.show', $customer) }}"
                    class="px-6 py-3 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">
                    Annuleren
                </a>
            </div>

        </form>
    </div>
</div>
@endsection