@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="flex justify-between items-start mb-12">

        <div>
            <h1 class="text-4xl font-bold text-white tracking-tight">
                Contract
            </h1>
            <p class="text-gray-400 mt-2 text-lg">
                {{ $contract->contract_number }}
            </p>
        </div>

        <div class="flex gap-4">
            <a href="{{ route('contracts.edit', $contract) }}"
                class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-6 py-3 rounded-lg font-semibold transition">
                Bewerken
            </a>

            <a href="{{ route('contracts.index') }}"
                class="px-6 py-3 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">
                Terug
            </a>
        </div>

    </div>


    {{-- INFO GRID --}}
    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-8 shadow-xl mb-8">

        <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-8 shadow-xl mb-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- Klant --}}
                <div>
                    <p class="text-gray-400 text-sm uppercase tracking-wider">
                        Klant
                    </p>
                    <p class="text-2xl font-semibold text-white mt-2">
                        {{ $contract->customer->company_name }}
                    </p>
                </div>

                {{-- Status --}}
                <div>
                    <p class="text-gray-400 text-sm uppercase tracking-wider">
                        Status
                    </p>

                    @php
                    $statusClasses = [
                    'active' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/50',
                    'paused' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/50',
                    'ended' => 'bg-red-500/10 text-red-400 border-red-500/50',
                    ];
                    @endphp

                    <div class="mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $statusClasses[$contract->status] ?? 'bg-slate-700/50 text-slate-300 border-slate-600' }}">
                            {{ ucfirst($contract->status) }}
                        </span>
                    </div>
                </div>

                {{-- Startdatum --}}
                <div>
                    <p class="text-gray-400 text-sm uppercase tracking-wider">
                        Startdatum
                    </p>
                    <p class="text-xl text-white font-medium mt-2">
                        {{ \Carbon\Carbon::parse($contract->start_date)->format('d-m-Y') }}
                    </p>
                </div>

                {{-- BKR status --}}
                <div>
                    <p class="text-gray-400 text-sm uppercase tracking-wider">
                        BKR-check
                    </p>

                    @php
                        $bkrLabels = [
                            'not_started' => 'Niet gestart',
                            'in_progress' => 'In behandeling',
                            'approved' => 'Akkoord',
                            'rejected' => 'Afgekeurd',
                        ];

                        $bkrClasses = [
                            'not_started' => 'bg-slate-700/50 text-slate-300 border-slate-600',
                            'in_progress' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/50',
                            'approved' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/50',
                            'rejected' => 'bg-red-500/10 text-red-400 border-red-500/50',
                        ];
                    @endphp

                    <div class="mt-3 flex flex-col gap-2">
                        <span class="inline-flex items-center w-fit px-3 py-1 rounded-full text-sm font-medium border {{ $bkrClasses[$contract->bkr_status] ?? 'bg-slate-700/50 text-slate-300 border-slate-600' }}">
                            {{ $bkrLabels[$contract->bkr_status] ?? ($contract->bkr_status ?? 'Niet ingesteld') }}
                        </span>

                        <p class="text-gray-300 text-sm">
                            Datum:
                            <span class="text-white">
                                {{ $contract->bkr_status_date ? $contract->bkr_status_date->format('d-m-Y') : '—' }}
                            </span>
                        </p>

                        @if(!empty($contract->bkr_note))
                            <p class="text-gray-300 text-sm">
                                Opmerking:
                                <span class="text-white">{{ $contract->bkr_note }}</span>
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Einddatum --}}
                <div>
                    <p class="text-gray-400 text-sm uppercase tracking-wider">
                        Einddatum
                    </p>
                    <p class="text-xl text-white font-medium mt-2">
                        {{ $contract->end_date
                        ? \Carbon\Carbon::parse($contract->end_date)->format('d-m-Y')
                        : 'Niet ingesteld' }}
                    </p>
                </div>

            </div>

        </div>


        {{-- PRODUCTEN --}}
        <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-8 shadow-xl mb-8">

            <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-8 shadow-xl mb-8">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-white">
                        Producten
                    </h2>

                    <span class="text-gray-400 text-sm">
                        {{ $contract->products->count() }} gekoppeld
                    </span>
                </div>

                @forelse($contract->products as $product)
                <div class="flex justify-between items-center py-4 border-b border-slate-700 last:border-0">

                    <div>
                        <p class="text-white font-medium">
                            {{ $product->name }}
                        </p>
                        <p class="text-gray-400 text-sm">
                            Aantal: {{ $product->pivot->quantity }}
                        </p>
                    </div>

                    <div class="text-lg font-semibold text-white">
                        €{{ number_format($product->pivot->unit_price, 2) }}
                    </div>

                </div>
                @empty
                <div class="py-10 text-center text-gray-500">
                    Geen producten gekoppeld aan dit contract.
                </div>
                @endforelse

            </div>


            {{-- NOTITIES --}}
            @if($contract->notes)
            <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-8 shadow-xl">

                <h2 class="text-2xl font-semibold text-white mb-4">
                    Notities
                </h2>

                <p class="text-gray-300 leading-relaxed text-lg">
                    {{ $contract->notes }}
                </p>

            </div>
            @endif

            {{-- WIJZIGINGEN (AUDIT) --}}
            @if(isset($auditLogs) && $auditLogs->count())
            <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-8 shadow-xl mt-8">
                <h2 class="text-2xl font-semibold text-white mb-4">
                    Laatste wijzigingen
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="text-slate-300 border-b border-slate-700">
                                <th class="py-2 pr-4">Wanneer</th>
                                <th class="py-2 pr-4">Wie</th>
                                <th class="py-2 pr-4">Actie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($auditLogs as $log)
                                <tr class="border-b border-slate-800">
                                    <td class="py-2 pr-4 text-slate-200">{{ $log->timestamp?->format('d-m-Y H:i') }}</td>
                                    <td class="py-2 pr-4 text-slate-200">{{ $log->user?->name ?? 'Onbekend' }}</td>
                                    <td class="py-2 pr-4 text-slate-200">{{ $log->action }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>

        @endsection
