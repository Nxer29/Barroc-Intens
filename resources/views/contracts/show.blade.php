@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto px-6 py-12 space-y-10">

    {{-- HEADER --}}
    <div class="flex justify-between items-start">

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
               class="btn-primary">
                Bewerken
            </a>

            <a href="{{ route('contracts.index') }}"
               class="btn-outline bg-white/90">
                Terug
            </a>
        </div>

    </div>


    {{-- INFO GRID --}}
    <div class="card p-10">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

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
                    $statusMap = [
                        'active' => 'badge-status pending',
                        'paused' => 'badge-status planned',
                        'ended'  => 'badge-status cancelled',
                    ];
                @endphp

                <div class="mt-3">
                    <span class="{{ $statusMap[$contract->status] ?? 'badge-status' }}">
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
    <div class="card p-10 space-y-6">

        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-white">
                Producten
            </h2>

            <span class="text-gray-400 text-sm">
                {{ $contract->products->count() }} gekoppeld
            </span>
        </div>

        @forelse($contract->products as $product)
            <div class="flex justify-between items-center py-4 border-b border-white/5 last:border-0">

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
        <div class="card p-10 space-y-4">

            <h2 class="text-2xl font-semibold text-white">
                Notities
            </h2>

            <p class="text-gray-300 leading-relaxed text-lg">
                {{ $contract->notes }}
            </p>

        </div>
    @endif

</div>

@endsection
