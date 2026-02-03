@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 space-y-6">

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="rounded-lg bg-green-900/60 border border-green-500 p-4 text-green-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- HEADER --}}
    <div class="bg-gray-900 rounded-2xl border border-yellow-400/40 p-6 shadow-lg">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-yellow-400">
                    Storingsaanvraag {{ $maintenanceRequest->request_number }}
                </h1>
                <p class="text-sm text-gray-400 mt-1">
                    Aangemaakt op {{ $maintenanceRequest->created_at->format('d-m-Y H:i') }}
                </p>
            </div>

            <span class="px-3 py-1 rounded-full text-sm font-semibold
                @if($maintenanceRequest->status === 'open') bg-red-900 text-red-300
                @elseif($maintenanceRequest->status === 'planned') bg-yellow-900 text-yellow-300
                @else bg-green-900 text-green-300 @endif">
                {{ ucfirst($maintenanceRequest->status) }}
            </span>
        </div>
    </div>

    {{-- INFO GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- KLANT / CONTRACT --}}
        <div class="bg-gray-900 rounded-2xl border border-gray-800 p-6">
            <h2 class="text-lg font-semibold text-yellow-400 mb-4">Klantinformatie</h2>

            <p class="mb-2">
                <span class="text-gray-400">Klant:</span><br>
                <span class="font-medium">{{ $maintenanceRequest->customer->displayName() ?? '-' }}</span>
            </p>

            <p class="mb-2">
                <span class="text-gray-400">Contract ID:</span><br>
                #{{ $maintenanceRequest->contract_id }}
            </p>

            <p>
                <span class="text-gray-400">Product ID:</span><br>
                #{{ $maintenanceRequest->product_id }}
            </p>
        </div>

        {{-- PRIORITEIT / MELDER --}}
        <div class="bg-gray-900 rounded-2xl border border-gray-800 p-6">
            <h2 class="text-lg font-semibold text-yellow-400 mb-4">Details</h2>

            <p class="mb-2">
                <span class="text-gray-400">Urgentie:</span><br>
                <span class="font-semibold text-red-400">
                    {{ ucfirst($maintenanceRequest->urgency) }}
                </span>
            </p>

            <p class="mb-2">
                <span class="text-gray-400">Prioriteit:</span><br>
                <span class="font-semibold text-yellow-300">
                    {{ ucfirst($maintenanceRequest->priority) }}
                </span>
            </p>

            <p>
                <span class="text-gray-400">Gemeld door (user ID):</span><br>
                {{ $maintenanceRequest->reported_by ?? '-' }}
            </p>
        </div>
    </div>

    {{-- PROBLEEMOMSCHRIJVING --}}
    <div class="bg-gray-900 rounded-2xl border border-gray-800 p-6">
        <h2 class="text-lg font-semibold text-yellow-400 mb-4">
            Probleemomschrijving
        </h2>

        <p class="text-gray-300 whitespace-pre-line">
            {{ $maintenanceRequest->issue_description }}
        </p>
    </div>

    {{-- STATUS ACTIE --}}
    <div class="bg-gray-900 rounded-2xl border border-gray-800 p-6">
        <h2 class="text-lg font-semibold text-yellow-400 mb-4">
            Status bijwerken
        </h2>

        <form method="POST"
              action="{{ route('maintenance.requests.status', $maintenanceRequest) }}"
              class="flex flex-col md:flex-row gap-4 items-start md:items-end">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm text-gray-400 mb-1">Status</label>
                <select name="status"
                        class="bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white">
                    <option value="open" @selected($maintenanceRequest->status === 'open')>Open</option>
                    <option value="planned" @selected($maintenanceRequest->status === 'planned')>Ingepland</option>
                    <option value="closed" @selected($maintenanceRequest->status === 'closed')>Afgerond</option>
                </select>
            </div>

            <button class="px-6 py-2 bg-yellow-400 text-gray-900 rounded-lg font-medium hover:opacity-90">
                Opslaan
            </button>
        </form>
    </div>

    {{-- TERUG --}}
    <div>
        <a href="{{ route('maintenance.requests.index') }}"
           class="text-gray-400 hover:text-yellow-400">
            ← Terug naar maintenance overzicht
        </a>
    </div>

</div>
@endsection
