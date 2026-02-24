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

        </div>

        @endsection