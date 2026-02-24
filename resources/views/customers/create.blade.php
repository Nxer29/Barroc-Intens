@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-white">Nieuwe klant aanmaken</h1>
        <p class="text-gray-400 mt-2">
            Voeg een nieuwe klant toe aan het systeem
        </p>
    </div>

    @if(session('success'))
    <div class="mb-6 rounded-lg bg-emerald-900/20 border border-emerald-500 p-4 text-emerald-300">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 rounded-lg bg-red-900/20 border border-red-500 p-4 text-red-300">
        <strong class="block font-semibold mb-2">Fouten:</strong>
        <ul class="list-disc list-inside text-sm">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Duplicaat-afhandeling --}}
    @if(session('duplicates'))
    <div class="mb-6 rounded-lg bg-yellow-900/10 border border-yellow-400 p-6">
        <h3 class="text-lg font-semibold text-yellow-400 mb-2">Mogelijke duplicaten gevonden</h3>
        <p class="text-sm text-slate-300 mb-3">Er zijn klanten gevonden die mogelijk hetzelfde zijn. Controleer of je wilt doorgaan of kies "Toch aanmaken".</p>

        <div class="space-y-3 mb-4">
            @foreach(session('duplicates') as $d)
            <div class="p-4 bg-slate-800 rounded-lg border border-yellow-400/20">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="font-semibold text-yellow-400">{{ $d->company_name }}</div>
                        <div class="text-sm text-slate-400">
                            @if($d->contact_name) Contact: {{ $d->contact_name }} • @endif
                            @if($d->contact_email) Email: {{ $d->contact_email }} • @endif
                            @if($d->contact_phone) Tel: {{ $d->contact_phone }} @endif
                        </div>
                    </div>
                    <div class="text-sm">
                        <a href="{{ route('customers.show', ['customer' => $d->id]) }}" target="_blank" class="px-3 py-1.5 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">Bekijk</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <form method="POST" action="{{ route('customers.store') }}" class="flex items-center gap-3">
            @csrf
            {{-- hergebruik oude input --}}
            @foreach(session()->getOldInput() as $k => $v)
            @if(is_array($v))
            @foreach($v as $subk => $subv)
            <input type="hidden" name="{{ $k }}[{{ $subk }}]" value="{{ $subv }}">
            @endforeach
            @else
            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
            @endif
            @endforeach

            <input type="hidden" name="force" value="1">
            <button type="submit" class="px-5 py-3 bg-yellow-400 hover:bg-yellow-300 text-gray-900 rounded-lg font-semibold transition">Toch aanmaken (forceer)</button>
            <a href="{{ route('customers.create') }}" class="text-sm text-slate-300 hover:text-white transition">Terug</a>
        </form>
    </div>
    @endif

    {{-- Hoofdformulier --}}
    <form method="POST" action="{{ route('customers.store') }}" class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 p-8 shadow-xl">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Bedrijfsnaam*</label>
                <input type="text" name="company_name" value="{{ old('company_name') }}" required
                    class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Contactpersoon</label>
                <input type="text" name="contact_name" value="{{ old('contact_name') }}"
                    class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Contact email</label>
                <input type="email" name="contact_email" value="{{ old('contact_email') }}"
                    class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Contact telefoon</label>
                <input type="text" name="contact_phone" value="{{ old('contact_phone') }}"
                    class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Status</label>
                <input type="text" name="status" value="{{ old('status', 'active') }}"
                    class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
            </div>

            <!-- Invoice / Delivery address id (tekstveld) -->
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Invoice address id</label>
                <input type="text" name="invoice_address_id" value="{{ old('invoice_address_id') }}"
                    class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                <p class="text-xs text-slate-400 mt-1">Optioneel: een id of externe referentie naar het factuuradres.</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Delivery address id</label>
                <input type="text" name="delivery_address_id" value="{{ old('delivery_address_id') }}"
                    class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                <p class="text-xs text-slate-400 mt-1">Optioneel: een id of externe referentie naar het afleveradres.</p>
            </div>

            <!-- Source (manual/online) -->
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Bron</label>
                <select name="source" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                    <option value="">Kies...</option>
                    <option value="manual" {{ old('source') === 'manual' ? 'selected' : '' }}>Handmatig</option>
                    <option value="online" {{ old('source') === 'online' ? 'selected' : '' }}>Online bron</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Bron URL (optioneel)</label>
                <input type="url" name="source_url" value="{{ old('source_url') }}"
                    class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
            </div>
        </div>

        <div class="mt-8 flex items-center gap-4">
            <button type="submit" class="px-6 py-3 bg-yellow-400 hover:bg-yellow-300 text-gray-900 rounded-lg font-semibold transition">Opslaan</button>
            <a href="{{ url('/') }}" class="px-6 py-3 border border-slate-600 text-slate-300 rounded-lg hover:bg-slate-700 transition">Annuleren</a>
        </div>
    </form>
</div>
@endsection