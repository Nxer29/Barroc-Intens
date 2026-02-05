@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <h1 class="text-3xl font-bold text-yellow-400 mb-6">Bezoekdetails</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- PROBLEEMOMSCHRIJVING --}}
        <div class="bg-gray-900 border border-gray-700 rounded-xl p-6 shadow-lg">
            <h2 class="text-xl font-semibold text-yellow-400 mb-3">Probleemomschrijving</h2>

            @php
                $issue = $maintenanceRequest->issue_description ?? null;
                $notes = $appointment->notes ?? null;
            @endphp

            <p class="text-gray-200 whitespace-pre-line">
                {{ $issue ?: ($notes ?: '—') }}
            </p>

            @if($maintenanceRequest)
                <p class="text-gray-400 mt-4 text-sm">
                    Storingsaanvraag: #{{ $maintenanceRequest->request_number ?? $maintenanceRequest->id }}
                </p>
            @endif
        </div>

        {{-- KLANTINFO --}}
        <div class="bg-gray-900 border border-gray-700 rounded-xl p-6 shadow-lg">
            <h2 class="text-xl font-semibold text-yellow-400 mb-3">Klantinfo</h2>

            <p class="text-gray-200">
                <span class="text-yellow-400 font-semibold">Bedrijf:</span>
                {{ $appointment->customer->company_name ?? '—' }}
            </p>

            <p class="text-gray-200 mt-2">
                <span class="text-yellow-400 font-semibold">Contactpersoon:</span>
                {{ $appointment->customer->contact_name ?? '—' }}
            </p>

            <p class="text-gray-200 mt-2">
                <span class="text-yellow-400 font-semibold">E-mail:</span>
                {{ $appointment->customer->contact_email ?? '—' }}
            </p>

            <p class="text-gray-200 mt-2">
                <span class="text-yellow-400 font-semibold">Telefoon:</span>
                {{ $appointment->customer->contact_phone ?? '—' }}
            </p>

            @php
                $delivery = $appointment->customer ? $appointment->customer->deliveryAddress() : null;
            @endphp

            <div class="mt-4">
                <p class="text-yellow-400 font-semibold">Afleveradres</p>
                @if($delivery)
                    <p class="text-gray-200">
                        {{ $delivery->street ?? '' }}<br>
                        {{ $delivery->postal_code ?? '' }} {{ $delivery->city ?? '' }}<br>
                        {{ $delivery->country ?? '' }}
                    </p>
                    @if(!empty($delivery->extra))
                        <p class="text-gray-400 text-sm mt-1">{{ $delivery->extra }}</p>
                    @endif
                @else
                    <p class="text-gray-400">—</p>
                @endif
            </div>
        </div>

        {{-- BENODIGDE SPULLEN --}}
        <div class="bg-gray-900 border border-gray-700 rounded-xl p-6 shadow-lg">
            <h2 class="text-xl font-semibold text-yellow-400 mb-3">Benodigde spullen</h2>

            @if($maintenanceRequest && $maintenanceRequest->product)
                <p class="text-gray-200 mb-4">
                    <span class="text-yellow-400 font-semibold">Product:</span>
                    {{ $maintenanceRequest->product->name }}
                </p>
            @endif

            @if($activeContract && $activeContract->products && $activeContract->products->count() > 0)
                <ul class="space-y-2">
                    @foreach($activeContract->products as $p)
                        <li class="flex items-start justify-between gap-4 border-b border-gray-800 pb-2">
                            <span class="text-gray-200">{{ $p->name }}</span>
                            <span class="text-gray-300 text-sm">
                                x {{ (int)($p->pivot->quantity ?? 1) }}
                            </span>
                        </li>
                    @endforeach
                </ul>
                <p class="text-gray-400 text-sm mt-3">
                    Gebaseerd op de producten in het contract.
                </p>
            @else
                <p class="text-gray-400">Geen contractproducten gevonden om als spullenlijst te tonen.</p>
            @endif
        </div>

        {{-- CONTRACTREFERENTIE + AFSPRAAK --}}
        <div class="bg-gray-900 border border-gray-700 rounded-xl p-6 shadow-lg">
            <h2 class="text-xl font-semibold text-yellow-400 mb-3">Contractreferentie</h2>

            @if($activeContract)
                <p class="text-gray-200">
                    <span class="text-yellow-400 font-semibold">Contract:</span>
                    #{{ $activeContract->id }} — {{ $activeContract->name ?? '—' }}
                </p>

                <p class="text-gray-200 mt-2">
                    <span class="text-yellow-400 font-semibold">Status:</span>
                    {{ $activeContract->status ?? '—' }}
                </p>

                <p class="text-gray-200 mt-2">
                    <span class="text-yellow-400 font-semibold">Looptijd:</span>
                    {{ optional($activeContract->start_date)->format('d-m-Y') ?? '—' }}
                    t/m
                    {{ optional($activeContract->end_date)->format('d-m-Y') ?? '—' }}
                </p>
            @else
                <p class="text-gray-400">Geen contract gevonden bij deze afspraak.</p>
            @endif

            <hr class="border-gray-800 my-4">

            <h3 class="text-lg font-semibold text-yellow-400 mb-2">Afspraak</h3>

            <p class="text-gray-200">
                <span class="text-yellow-400 font-semibold">Klant:</span>
                {{ $appointment->customer->company_name ?? '—' }}
            </p>

            <p class="text-gray-200 mt-2">
                <span class="text-yellow-400 font-semibold">Type:</span>
                {{ $appointment->type->name ?? '—' }}
            </p>

            <p class="text-gray-200 mt-2">
                <span class="text-yellow-400 font-semibold">Datum/tijd:</span>
                {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('d-m-Y H:i') }}
            </p>

            <p class="text-gray-200 mt-2">
                <span class="text-yellow-400 font-semibold">Monteur:</span>
                {{ $appointment->technician->name ?? 'Niet toegewezen' }}
            </p>

            <p class="text-gray-200 mt-2">
                <span class="text-yellow-400 font-semibold">Status:</span>
                {{ $appointment->status ?? 'Onbekend' }}
            </p>
        </div>

    </div>

    <div class="flex gap-4 mt-6">
        <a href="{{ route('appointments.edit', $appointment) }}"
           class="bg-blue-500 px-5 py-2 rounded-lg font-semibold hover:bg-blue-600">
            Bewerken
        </a>

        <a href="{{ route('appointments.index') }}"
           class="bg-gray-700 px-5 py-2 rounded-lg font-semibold hover:bg-gray-600">
            Terug
        </a>
    </div>

</div>

@endsection
