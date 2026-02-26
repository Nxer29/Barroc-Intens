@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="mb-12 flex justify-between items-start">
        <div>
            <h1 class="text-4xl font-bold text-white">Werkbezoek details</h1>
            <p class="text-gray-400 mt-2">
                Bekijk de volledige informatie over deze geplande afspraak
            </p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('appointments.edit', $appointment) }}"
                class="px-6 py-3 bg-yellow-400 hover:bg-yellow-300 text-gray-900 rounded-lg font-semibold transition">
                Bewerken
            </a>

            <a href="{{ route('appointments.index') }}"
                class="px-6 py-3 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">
                Terug
            </a>
        </div>
    </div>

    {{-- MAIN CONTENT GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- LEFT COLUMN: General Info & Status --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Algemene info --}}
            <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl p-8 border border-slate-700 shadow-xl">
                <h2 class="text-xl font-semibold text-white mb-6">📋 Algemene informatie</h2>

                <dl class="space-y-4 text-sm">
                    <div class="flex justify-between border-b border-slate-700 pb-3">
                        <dt class="text-slate-400 font-medium">Type</dt>
                        <dd class="text-white font-semibold">{{ $appointment->type->name }}</dd>
                    </div>

                    <div class="flex justify-between border-b border-slate-700 pb-3">
                        <dt class="text-slate-400 font-medium">Datum</dt>
                        <dd class="text-white">
                            {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('d-m-Y H:i') }}
                        </dd>
                    </div>

                    <div class="flex justify-between pb-3">
                        <dt class="text-slate-400 font-medium">Technicus</dt>
                        <dd class="text-white">
                            {{ $appointment->technician->name ?? '—' }}
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Status kaart --}}
            <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl p-8 border border-slate-700 shadow-xl flex flex-col justify-center items-center">
                <h2 class="text-xl font-semibold text-white mb-6">Status</h2>
                <span class="badge-status {{ $appointment->status }} text-lg px-6 py-3 font-bold">
                    @if($appointment->status === 'completed')
                    ✔ Voltooid
                    @elseif($appointment->status === 'planned')
                    📅 Ingepland
                    @elseif($appointment->status === 'cancelled')
                    ✖ Geannuleerd
                    @else
                    ⏳ In afwachting
                    @endif
                </span>
            </div>

        </div>

        {{-- MIDDLE & RIGHT CONTENT: Customer, Problem, Materials, Contract --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- KLANT INFO --}}
            <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl p-8 border border-slate-700 shadow-xl">
                <h2 class="text-xl font-semibold text-white mb-6">👤 Klantinformatie</h2>

                <div class="space-y-4">
                    <div>
                        <p class="text-slate-400 text-sm font-medium mb-2">Bedrijf</p>
                        <p class="text-white text-lg font-semibold">{{ $appointment->customer->company_name ?? '—' }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-slate-400 text-sm font-medium mb-1">Contactpersoon</p>
                            <p class="text-gray-200">{{ $appointment->customer->contact_name ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm font-medium mb-1">Email</p>
                            <p class="text-blue-300 break-all">{{ $appointment->customer->contact_email ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm font-medium mb-1">Telefoon</p>
                            <p class="text-yellow-300">{{ $appointment->customer->contact_phone ?? '—' }}</p>
                        </div>
                    </div>

                    @if($activeContract && $activeContract->products->count() > 0)
                    <div class="pt-4 border-t border-slate-700">
                        <p class="text-slate-400 text-sm font-medium mb-2">Locatie</p>
                        @php
                        $address = $appointment->customer->delivery_address_id
                        ? \App\Models\Address::find($appointment->customer->delivery_address_id)
                        : ($appointment->customer->invoice_address_id ? \App\Models\Address::find($appointment->customer->invoice_address_id) : null);
                        @endphp
                        @if($address)
                        <p class="text-gray-200 font-semibold">{{ $address->street }}</p>
                        <p class="text-gray-300">{{ $address->postal_code }} {{ $address->city }}</p>
                        <p class="text-gray-400 text-sm">{{ $address->country }}</p>
                        @else
                        <p class="text-gray-400 text-sm">Geen adres beschikbaar</p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            {{-- PROBLEEM/STORINGSOMSCHRIJVING --}}
            @if($maintenanceRequest && $maintenanceRequest->issue_description)
            <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl p-8 border border-red-900/50 border-slate-700 shadow-xl">
                <h2 class="text-xl font-semibold text-white mb-6">⚠️ Probleemomschrijving</h2>

                <p class="text-gray-200 leading-relaxed mb-4">{{ $maintenanceRequest->issue_description }}</p>

                @if($maintenanceRequest->request_number)
                <div class="pt-4 border-t border-slate-700">
                    <p class="text-slate-400 text-sm font-medium mb-2">Storingsreferentie</p>
                    <p class="text-white font-mono bg-slate-900 rounded px-3 py-2 inline-block">#{{ $maintenanceRequest->request_number }}</p>
                </div>
                @endif

                @if($maintenanceRequest->product)
                <div class="pt-4 border-t border-slate-700">
                    <p class="text-slate-400 text-sm font-medium mb-2">Betreffende product</p>
                    <p class="text-yellow-300 font-semibold">{{ $maintenanceRequest->product->name }}</p>
                </div>
                @endif

                @if($maintenanceRequest->urgency)
                <div class="pt-4 border-t border-slate-700">
                    <p class="text-slate-400 text-sm font-medium mb-2">Urgentie</p>
                    <span class="inline-block px-3 py-1 rounded-lg text-sm font-bold bg-orange-900/40 text-orange-200">
                        {{ ucfirst($maintenanceRequest->urgency) }}
                    </span>
                </div>
                @endif
            </div>
            @elseif($appointment->notes)
            <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl p-8 border border-slate-700 shadow-xl">
                <h2 class="text-xl font-semibold text-white mb-6">📝 Notities</h2>
                <p class="text-gray-200 leading-relaxed">{{ $appointment->notes }}</p>
            </div>
            @endif

            {{-- CONTRACT & BENODIGDE SPULLEN --}}
            @if($activeContract)
            <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl p-8 border border-slate-700 shadow-xl">
                <h2 class="text-xl font-semibold text-white mb-6">📋 Contractgegevens & Benodigde spullen</h2>

                <div class="space-y-4 mb-6">
                    <div>
                        <p class="text-slate-400 text-sm font-medium mb-1">Contract</p>
                        <p class="text-white text-lg font-semibold">{{ $activeContract->name }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <p class="text-slate-400 text-sm font-medium mb-1">Status</p>
                            <span class="inline-block px-3 py-1 rounded-lg text-xs font-bold {{ $activeContract->status === 'active' ? 'bg-green-900/40 text-green-200' : 'bg-gray-900/40 text-gray-300' }}">
                                {{ ucfirst($activeContract->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm font-medium mb-1">Start</p>
                            <p class="text-gray-200">{{ $activeContract->start_date?->format('d-m-Y') ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm font-medium mb-1">Einde</p>
                            <p class="text-gray-200">{{ $activeContract->end_date?->format('d-m-Y') ?? '—' }}</p>
                        </div>
                    </div>
                </div>

                @if($activeContract->products && $activeContract->products->count() > 0)
                <div class="pt-6 border-t border-slate-700">
                    <p class="text-slate-300 font-semibold mb-4">Producten onder contract:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($activeContract->products as $product)
                        <div class="bg-slate-800/50 rounded-lg p-4 border border-slate-600 hover:border-yellow-400/50 transition">
                            <p class="text-white font-semibold">{{ $product->name }}</p>
                            <div class="flex justify-between items-center mt-2 text-sm text-gray-400">
                                <span>Hoeveelheid: <span class="text-yellow-300 font-bold">{{ $product->pivot->quantity ?? 1 }}x</span></span>
                                @if($product->pivot->unit_price)
                                <span class="text-gray-300">€ {{ number_format($product->pivot->unit_price, 2, ',', '.') }}</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="pt-6 border-t border-slate-700">
                    <p class="text-gray-400 text-sm">Geen producten gedefinieerd onder dit contract.</p>
                </div>
                @endif
            </div>
            @endif

        </div>

    </div>

</div>
@endsection