@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-white">Afspraak details</h1>

        <div class="space-x-3">
            <a href="{{ route('appointments.edit', $appointment) }}"
               class="btn-primary">
                Bewerken
            </a>

            <a href="{{ route('appointments.index') }}"
               class="btn-outline">
                Terug
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- Algemene info --}}
        <div class="bg-slate-900 rounded-xl p-6 border border-slate-800">
            <h2 class="text-xl font-semibold text-white mb-6">Algemene informatie</h2>

            <dl class="space-y-4 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-400">Klant</dt>
                    <dd class="text-white font-medium">
                        {{ $appointment->customer->company_name ?? '—' }}
                    </dd>
                </div>

                <div class="flex justify-between">
                    <dt class="text-gray-400">Type</dt>
                    <dd class="text-white">{{ $appointment->type->name }}</dd>
                </div>

                <div class="flex justify-between">
                    <dt class="text-gray-400">Datum</dt>
                    <dd class="text-white">
                        {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('d-m-Y') }}
                    </dd>
                </div>

                <div class="flex justify-between">
                    <dt class="text-gray-400">Technicus</dt>
                    <dd class="text-white">
                        {{ $appointment->technician->name ?? '—' }}
                    </dd>
                </div>
            </dl>
        </div>

        {{-- Status kaart --}}
        <div class="bg-slate-900 rounded-xl p-6 border border-slate-800 flex flex-col justify-center items-center">

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
