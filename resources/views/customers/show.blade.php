@extends('layouts.app')

@section('content')
<div class="w-full max-w-6xl mx-auto py-8">

    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-900/60 border border-green-500 p-4 text-green-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- HEADER --}}
    <div class="bg-gray-900 rounded-2xl border border-yellow-400/40 p-6 shadow-lg mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold text-yellow-400 mb-1">
                    {{ $customer->displayName() }}
                </h1>
                <p class="text-sm text-gray-400">Klant ID: #{{ $customer->id }}</p>
            </div>

            <a href="{{ route('customers.create') }}"
               class="px-4 py-2 bg-yellow-400 text-gray-900 rounded-lg font-medium hover:opacity-90">
                Nieuwe klant
            </a>
        </div>

        {{-- QUICK STATS --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
            <div class="bg-gray-800 rounded-xl p-4 text-center">
                <p class="text-sm text-gray-400">Contracten</p>
                <p class="text-2xl font-bold text-yellow-300">{{ $customer->contracts->count() }}</p>
            </div>

            <div class="bg-gray-800 rounded-xl p-4 text-center">
                <p class="text-sm text-gray-400">Bestellingen</p>
                <p class="text-2xl font-bold text-yellow-300">{{ $customer->orders->count() }}</p>
            </div>

            <div class="bg-gray-800 rounded-xl p-4 text-center">
                <p class="text-sm text-gray-400">Facturen</p>
                <p class="text-2xl font-bold text-yellow-300">{{ $customer->invoices->count() }}</p>
            </div>

            <div class="bg-gray-800 rounded-xl p-4 text-center">
                <p class="text-sm text-gray-400">Afspraken</p>
                <p class="text-2xl font-bold text-yellow-300">{{ $customer->appointments->count() }}</p>
            </div>
        </div>
    </div>

    {{-- TABS --}}
    <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-lg">
        <div class="border-b border-gray-800 flex gap-6 px-6 pt-4 text-sm font-medium">
            <button data-tab="contracts" class="tab-btn text-yellow-400 border-b-2 border-yellow-400 pb-3">
                Contracten
            </button>
            <button data-tab="orders" class="tab-btn text-gray-400 pb-3">
                Bestellingen
            </button>
            <button data-tab="invoices" class="tab-btn text-gray-400 pb-3">
                Facturen
            </button>
            <button data-tab="appointments" class="tab-btn text-gray-400 pb-3">
                Afspraken
            </button>
        </div>

        <div class="p-6 space-y-10">

            {{-- CONTRACTEN --}}
            <section id="contracts" class="tab-content">
                <h2 class="text-xl font-semibold text-yellow-400 mb-4">Contracten</h2>

                @forelse($customer->contracts as $contract)
                    <div class="bg-gray-800 rounded-lg p-4 mb-3">
                        <p class="font-medium">Contract #{{ $contract->id }}</p>
                        <p class="text-sm text-gray-400">Status: {{ $contract->status ?? '-' }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 italic">Geen contracten gevonden.</p>
                @endforelse
            </section>

            {{-- BESTELLINGEN --}}
            <section id="orders" class="tab-content hidden">
                <h2 class="text-xl font-semibold text-yellow-400 mb-4">Bestellingen</h2>

                @forelse($customer->orders as $order)
                    <div class="bg-gray-800 rounded-lg p-4 mb-3">
                        <p class="font-medium">Bestelling #{{ $order->id }}</p>
                        <p class="text-sm text-gray-400">Status: {{ $order->status ?? '-' }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 italic">Geen bestellingen gevonden.</p>
                @endforelse
            </section>

            {{-- FACTUREN --}}
            <section id="invoices" class="tab-content hidden">
                <h2 class="text-xl font-semibold text-yellow-400 mb-4">Facturen</h2>

                @forelse($customer->invoices as $invoice)
                    <div class="bg-gray-800 rounded-lg p-4 mb-3">
                        <p class="font-medium">Factuur #{{ $invoice->id }}</p>
                        <p class="text-sm text-gray-400">
                            Bedrag: €{{ number_format($invoice->total ?? 0, 2, ',', '.') }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-500 italic">Geen facturen gevonden.</p>
                @endforelse
            </section>

            {{-- AFSPRAKEN --}}
            <section id="appointments" class="tab-content hidden">
                <h2 class="text-xl font-semibold text-yellow-400 mb-4">Afspraken</h2>

                @forelse($customer->appointments as $appointment)
                    <div class="bg-gray-800 rounded-lg p-4 mb-3">
                        <p class="font-medium">Afspraak #{{ $appointment->id }}</p>
                        <p class="text-sm text-gray-400">
                            Datum: {{ $appointment->date ?? '-' }} |
                            Status: {{ $appointment->status ?? '-' }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-500 italic">Geen afspraken gevonden.</p>
                @endforelse
            </section>

        </div>
    </div>
</div>

{{-- TAB SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buttons = document.querySelectorAll('.tab-btn');
        const tabs = document.querySelectorAll('.tab-content');

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                const target = btn.dataset.tab;

                buttons.forEach(b => {
                    b.classList.remove('text-yellow-400', 'border-yellow-400');
                    b.classList.add('text-gray-400');
                });

                tabs.forEach(tab => tab.classList.add('hidden'));

                btn.classList.add('text-yellow-400', 'border-yellow-400');
                btn.classList.remove('text-gray-400');
                document.getElementById(target).classList.remove('hidden');
            });
        });
    });
</script>
@endsection
