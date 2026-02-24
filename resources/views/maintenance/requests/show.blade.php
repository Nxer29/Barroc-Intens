@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- SUCCESS --}}
    @if(session('success'))
    <div class="mb-6 rounded-lg border border-green-500 bg-green-900/20 px-4 py-3 text-green-300">
        {{ session('success') }}
    </div>
    @endif

    {{-- HEADER --}}
    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-8 shadow-xl mb-8">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-4xl font-bold text-white">
                    Storingsaanvraag {{ $maintenanceRequest->request_number }}
                </h1>
                <p class="text-gray-400 mt-2">
                    Aangemaakt op {{ $maintenanceRequest->created_at->format('d-m-Y H:i') }}
                </p>
            </div>

            @php
            $statusClasses = [
            'open' => 'bg-red-500/10 text-red-400 border-red-500/50',
            'planned' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/50',
            'closed' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/50',
            ];
            @endphp

            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $statusClasses[$maintenanceRequest->status] ?? 'bg-slate-700/50 text-slate-300 border-slate-600' }}">
                {{ ucfirst($maintenanceRequest->status) }}
            </span>
        </div>
    </div>

    {{-- INFO GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        {{-- KLANT / CONTRACT --}}
        <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-6 shadow-xl">
            <h2 class="text-lg font-semibold text-white mb-4">Klantinformatie</h2>

            <p class="mb-3">
                <span class="text-gray-400 text-sm">Klant:</span><br>
                <span class="font-medium text-white">{{ $maintenanceRequest->customer->displayName() ?? '-' }}</span>
            </p>

            <p class="mb-3">
                <span class="text-gray-400 text-sm">Contract ID:</span><br>
                <span class="text-white">#{{ $maintenanceRequest->contract_id }}</span>
            </p>

            <p>
                <span class="text-gray-400 text-sm">Product ID:</span><br>
                <span class="text-white">#{{ $maintenanceRequest->product_id }}</span>
            </p>
        </div>

        {{-- PRIORITEIT / MELDER --}}
        <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-6 shadow-xl">
            <h2 class="text-lg font-semibold text-white mb-4">Details</h2>

            <p class="mb-3">
                <span class="text-gray-400 text-sm">Urgentie:</span><br>
                <span class="font-semibold text-red-400">
                    {{ ucfirst($maintenanceRequest->urgency) }}
                </span>
            </p>

            <p class="mb-3">
                <span class="text-gray-400 text-sm">Prioriteit:</span><br>
                <span class="font-semibold text-yellow-400">
                    {{ ucfirst($maintenanceRequest->priority) }}
                </span>
            </p>

            <p>
                <span class="text-gray-400 text-sm">Gemeld door (user ID):</span><br>
                <span class="text-white">{{ $maintenanceRequest->reported_by ?? '-' }}</span>
            </p>
        </div>
    </div>

    {{-- PROBLEEMOMSCHRIJVING --}}
    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-6 shadow-xl mb-8">
        <h2 class="text-lg font-semibold text-white mb-4">
            Probleemomschrijving
        </h2>

        <p class="text-slate-300 whitespace-pre-line">
            {{ $maintenanceRequest->issue_description }}
        </p>
    </div>

    {{-- STATUS ACTIE --}}
    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-6 shadow-xl mb-8">
        <h2 class="text-lg font-semibold text-white mb-4">
            Status bijwerken
        </h2>

        <form method="POST"
            action="{{ route('maintenance.requests.status', $maintenanceRequest) }}"
            class="flex flex-col md:flex-row gap-4 items-start md:items-end">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Status</label>
                <select name="status"
                    class="px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                    <option value="open" @selected($maintenanceRequest->status === 'open')>Open</option>
                    <option value="planned" @selected($maintenanceRequest->status === 'planned')>Ingepland</option>
                    <option value="closed" @selected($maintenanceRequest->status === 'closed')>Afgerond</option>
                </select>
            </div>

            <button class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-6 py-3 rounded-lg font-semibold transition">
                Opslaan
            </button>
        </form>
    </div>

    {{-- TERUG --}}
    <div>
        <a href="{{ route('maintenance.requests.index') }}"
            class="text-slate-400 hover:text-yellow-400 transition">
            ← Terug naar maintenance overzicht
        </a>
    </div>

</div>
@endsection