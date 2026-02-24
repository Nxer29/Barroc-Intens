@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-white">Contracten</h1>
        <p class="text-gray-400 mt-2">
            Overzicht van alle contracten
        </p>
    </div>

    <div class="flex justify-end mb-6">
        <a href="{{ route('contracts.create') }}" class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-semibold px-6 py-3 rounded-lg transition">
            + Nieuw contract
        </a>
    </div>

    {{-- Card --}}
    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 shadow-xl">

        <div class="divide-y divide-slate-700 p-6">

            @forelse ($contracts as $contract)

            @php
            $statusClasses = [
            'active' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30',
            'paused' => 'bg-yellow-500/20 text-yellow-300 border-yellow-500/30',
            'ended' => 'bg-red-500/20 text-red-300 border-red-500/30',
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

                    <span class="px-4 py-1 rounded-full text-sm font-semibold border
                            {{ $statusClasses[$contract->status] ?? 'bg-slate-700 text-slate-300 border-slate-600' }}">
                        {{ ucfirst($contract->status) }}
                    </span>

                    <a href="{{ route('contracts.show', $contract) }}"
                        class="px-4 py-2 border border-slate-600 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">
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