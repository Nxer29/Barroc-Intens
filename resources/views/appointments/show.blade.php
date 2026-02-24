@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="mb-12 flex justify-between items-start">
        <div>
            <h1 class="text-4xl font-bold text-white">Afspraak details</h1>
            <p class="text-gray-400 mt-2">
                Bekijk de volledige informatie over deze afspraak
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

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Algemene info --}}
        <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl p-8 border border-slate-700 shadow-xl">
            <h2 class="text-xl font-semibold text-white mb-6">Algemene informatie</h2>

            <dl class="space-y-4 text-sm">
                <div class="flex justify-between border-b border-slate-700 pb-3">
                    <dt class="text-slate-400 font-medium">Klant</dt>
                    <dd class="text-white font-semibold">
                        {{ $appointment->customer->company_name ?? '—' }}
                    </dd>
                </div>

                <div class="flex justify-between border-b border-slate-700 pb-3">
                    <dt class="text-slate-400 font-medium">Type</dt>
                    <dd class="text-white">{{ $appointment->type->name }}</dd>
                </div>

                <div class="flex justify-between border-b border-slate-700 pb-3">
                    <dt class="text-slate-400 font-medium">Datum</dt>
                    <dd class="text-white">
                        {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('d-m-Y') }}
                    </dd>
                </div>

                <div class="flex justify-between">
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

            <span class="badge-status {{ $appointment->status }} text-lg px-6 py-3">

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

</div>
@endsection