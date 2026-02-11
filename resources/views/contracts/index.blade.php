@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white">Contracten</h1>
            <p class="subtext">Overzicht van alle contracten</p>
        </div>

        <a href="{{ route('contracts.create') }}" class="btn-primary">
            + Nieuw contract
        </a>
    </div>

    <!-- Card -->
    <div class="card">

        <div class="divide-y divide-slate-800">

            @forelse ($contracts as $contract)

                @php
                    $statusClasses = [
                        'active' => 'bg-green-500/20 text-green-400',
                        'paused' => 'bg-yellow-500/20 text-yellow-400',
                        'ended'  => 'bg-red-500/20 text-red-400',
                    ];
                @endphp

                <div class="py-5 flex justify-between items-center hover:bg-slate-800/40 px-4 rounded-lg transition">

                    <div>
                        <p class="font-semibold text-white text-lg">
                            {{ $contract->customer->company_name }}
                        </p>
                        <p class="text-sm text-slate-400">
                            {{ $contract->contract_number }}
                        </p>
                    </div>

                    <div class="flex items-center gap-6">

                        <span class="px-4 py-1 rounded-full text-sm font-semibold
                            {{ $statusClasses[$contract->status] ?? 'bg-slate-700 text-slate-300' }}">
                            {{ ucfirst($contract->status) }}
                        </span>

                        <a href="{{ route('contracts.show', $contract) }}"
                           class="btn-outline text-sm">
                            Bekijken
                        </a>

                    </div>

                </div>

            @empty

                <div class="py-12 text-center text-slate-400">
                    Geen contracten gevonden
                </div>

            @endforelse

        </div>

    </div>

</div>
@endsection
