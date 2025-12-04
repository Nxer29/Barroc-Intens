@extends('layouts.app')

@section('content')
<div class="w-full max-w-6xl">

    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-gray-900 rounded-2xl border border-yellow-400/40 p-6 shadow-lg hover:scale-[1.02] transition">
            <h3 class="text-xl font-semibold text-yellow-400 mb-2">Taken</h3>
            <p class="text-gray-300 mb-3">Bekijk lopende taken en deadlines.</p>
            <a href="#" class="text-yellow-300 hover:text-yellow-500 font-medium">Bekijk meer →</a>
        </div>

        <div class="bg-gray-900 rounded-2xl border border-yellow-400/40 p-6 shadow-lg hover:scale-[1.02] transition">
            <h3 class="text-xl font-semibold text-yellow-400 mb-2">Klantenlijst</h3>
            <p class="text-gray-300 mb-3">Overzicht van klanten en hun status.</p>
            <a href="{{ route('products.index') }}" class="text-yellow-300 hover:text-yellow-500 font-medium">Openen →</a>
        </div>

         <div class="bg-gray-900 rounded-2xl border border-yellow-400/40 p-6 shadow-lg hover:scale-[1.02] transition">
            <h3 class="text-xl font-semibold text-yellow-400 mb-2">Nieuwe klant</h3>
            <p class="text-gray-300 mb-3">Maak snel een nieuwe klant aan (Sales).</p>
            <a href="{{ route('customers.create') }}" class="text-yellow-300 hover:text-yellow-500 font-medium">Aanmaken →</a>
        </div>

        <div class="bg-gray-900 rounded-2xl border border-yellow-400/40 p-6 shadow-lg hover:scale-[1.02] transition">
            <h3 class="text-xl font-semibold text-yellow-400 mb-2">Profiel</h3>
            <p class="text-gray-300 mb-3">Beheer je gegevens en voorkeuren.</p>
            <a href="{{ route('profile.edit') }}" class="text-yellow-300 hover:text-yellow-500 font-medium">Instellingen →</a>
        </div>
        <div class="bg-gray-900 rounded-2xl border border-yellow-400/40 p-6 shadow-lg hover:scale-[1.02] transition">
            <h3 class="text-xl font-semibold text-yellow-400 mb-2">Contracten</h3>
            <p class="text-gray-300 mb-3">Beheer leasecontracten: aanmaken, wijzigen en verwijderen (Finance/Sales).</p>
            <div class="flex gap-3">
                <a href="{{ route('contracts.index') }}" class="text-yellow-300 hover:text-yellow-500 font-medium">Openen →</a>
                <a href="{{ route('contracts.create') }}" class="text-yellow-300 hover:text-yellow-500 font-medium">Nieuw contract →</a>
                <a href="{{ route('notes.index') }}" class="text-yellow-300 hover:text-yellow-500 font-medium">Notities →</a>
            </div>
        </div>
        <div class="bg-gray-900 rounded-2xl border border-yellow-400/40 p-6 shadow-lg hover:scale-[1.02] transition">
            <h3 class="text-xl font-semibold text-yellow-400 mb-2">Appointments</h3>
            <p class="text-gray-300 mb-3"> Maak en zie je Afspraken.</p>
            <div class="flex gap-3">
                <a href="{{ route('appointments.index') }}" class="text-yellow-300 hover:text-yellow-500 font-medium">Openen →</a>
                <a href="{{ route('appointments.create') }}" class="text-yellow-300 hover:text-yellow-500 font-medium">Nieuw Afspraak →</a>
            </div>
        </div>
    </div>
</div>
@endsection
