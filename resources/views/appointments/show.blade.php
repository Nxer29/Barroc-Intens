@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <h1 class="text-3xl font-bold text-yellow-400 mb-6">Afspraakdetails</h1>

    <div class="bg-gray-900 border border-gray-700 rounded-xl p-6 shadow-lg space-y-4">

        <p><strong class="text-yellow-400">Klant:</strong>
            {{ $appointment->customer->company_name }}</p>

        <p><strong class="text-yellow-400">Type:</strong>
            {{ $appointment->type->name }}</p>

        <p><strong class="text-yellow-400">Datum:</strong>
            {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('d-m-Y') }}</p>

        <p><strong class="text-yellow-400">Monteur:</strong>
            {{ $appointment->technician->name ?? 'Niet toegewezen' }}</p>

        <p><strong class="text-yellow-400">Status:</strong>
            {{ $appointment->status ?? 'Onbekend' }}</p>

        <p><strong class="text-yellow-400">Notities:</strong><br>
            {{ $appointment->notes ?? '—' }}</p>

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
