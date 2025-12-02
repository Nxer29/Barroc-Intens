@extends('layouts.app')

@section('content')
<div class="w-full max-w-4xl mx-auto py-8">
    <h1 class="text-3xl font-bold text-yellow-400 mb-6">Nieuwe klant aanmaken</h1>

    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-900/60 border border-green-500 p-4 text-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-lg bg-red-900/60 border border-red-600 p-4 text-red-200">
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
        <div class="mb-6 rounded-lg bg-yellow-900/10 border border-yellow-400 p-4">
            <h3 class="text-lg font-semibold text-yellow-300 mb-2">Mogelijke duplicaten gevonden</h3>
            <p class="text-sm text-gray-300 mb-3">Er zijn klanten gevonden die mogelijk hetzelfde zijn. Controleer of je wilt doorgaan of kies "Toch aanmaken".</p>

            <div class="space-y-3 mb-4">
                @foreach(session('duplicates') as $d)
                    <div class="p-3 bg-gray-900 rounded-md border border-yellow-400/20">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="font-semibold text-yellow-400">{{ $d->company_name }}</div>
                                <div class="text-sm text-gray-400">
                                    @if($d->contact_name) Contact: {{ $d->contact_name }} • @endif
                                    @if($d->contact_email) Email: {{ $d->contact_email }} • @endif
                                    @if($d->contact_phone) Tel: {{ $d->contact_phone }} @endif
                                </div>
                            </div>
                            <div class="text-sm">
                                <a href="{{ route('customers.show', ['customer' => $d->id]) }}" target="_blank" class="text-yellow-300 hover:underline">Bekijk</a>
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
                <button type="submit" class="px-4 py-2 bg-yellow-400 text-gray-900 rounded-md font-medium hover:opacity-95">Toch aanmaken (forceer)</button>
                <a href="{{ route('customers.create') }}" class="text-sm text-gray-300 hover:underline">Terug</a>
            </form>
        </div>
    @endif

    {{-- Hoofdformulier --}}
    <form method="POST" action="{{ route('customers.store') }}" class="bg-gray-900 rounded-2xl border border-yellow-400/20 p-6 shadow-lg">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-200">Bedrijfsnaam*</label>
                <input type="text" name="company_name" value="{{ old('company_name') }}" required
                       class="mt-1 block w-full rounded-md bg-gray-800 border border-gray-700 text-gray-100 px-3 py-2 focus:outline-none focus:border-yellow-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-200">Contactpersoon</label>
                <input type="text" name="contact_name" value="{{ old('contact_name') }}"
                       class="mt-1 block w-full rounded-md bg-gray-800 border border-gray-700 text-gray-100 px-3 py-2 focus:outline-none focus:border-yellow-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-200">Contact email</label>
                <input type="email" name="contact_email" value="{{ old('contact_email') }}"
                       class="mt-1 block w-full rounded-md bg-gray-800 border border-gray-700 text-gray-100 px-3 py-2 focus:outline-none focus:border-yellow-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-200">Contact telefoon</label>
                <input type="text" name="contact_phone" value="{{ old('contact_phone') }}"
                       class="mt-1 block w-full rounded-md bg-gray-800 border border-gray-700 text-gray-100 px-3 py-2 focus:outline-none focus:border-yellow-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-200">Status</label>
                <input type="text" name="status" value="{{ old('status', 'active') }}"
                       class="mt-1 block w-full rounded-md bg-gray-800 border border-gray-700 text-gray-100 px-3 py-2 focus:outline-none focus:border-yellow-400">
            </div>

            <!-- Invoice / Delivery address id (tekstveld) -->
            <div>
                <label class="block text-sm font-medium text-gray-200">Invoice address id</label>
                <input type="text" name="invoice_address_id" value="{{ old('invoice_address_id') }}"
                       class="mt-1 block w-full rounded-md bg-gray-800 border border-gray-700 text-gray-100 px-3 py-2 focus:outline-none focus:border-yellow-400">
                <p class="text-xs text-gray-500 mt-1">Optioneel: een id of externe referentie naar het factuuradres.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-200">Delivery address id</label>
                <input type="text" name="delivery_address_id" value="{{ old('delivery_address_id') }}"
                       class="mt-1 block w-full rounded-md bg-gray-800 border border-gray-700 text-gray-100 px-3 py-2 focus:outline-none focus:border-yellow-400">
                <p class="text-xs text-gray-500 mt-1">Optioneel: een id of externe referentie naar het afleveradres.</p>
            </div>

            <!-- Source (manual/online) -->
            <div>
                <label class="block text-sm font-medium text-gray-200">Bron</label>
                <select name="source" class="mt-1 block w-full rounded-md bg-gray-800 border border-gray-700 text-gray-100 px-3 py-2">
                    <option value="">Kies...</option>
                    <option value="manual" {{ old('source') === 'manual' ? 'selected' : '' }}>Handmatig</option>
                    <option value="online" {{ old('source') === 'online' ? 'selected' : '' }}>Online bron</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-200">Bron URL (optioneel)</label>
                <input type="url" name="source_url" value="{{ old('source_url') }}"
                       class="mt-1 block w-full rounded-md bg-gray-800 border border-gray-700 text-gray-100 px-3 py-2">
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <button type="submit" class="px-4 py-2 bg-yellow-400 text-gray-900 rounded-md font-medium hover:opacity-95">Opslaan</button>
            <a href="{{ url('/') }}" class="px-4 py-2 border border-gray-700 text-gray-300 rounded-md hover:bg-gray-850">Annuleren</a>
        </div>
    </form>
</div>
@endsection