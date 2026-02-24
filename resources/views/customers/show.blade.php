@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    @if(session('success'))
    <div class="mb-6 rounded-lg bg-emerald-900/20 border border-emerald-500 p-4 text-emerald-300">
        {{ session('success') }}
    </div>
    @endif

    {{-- HEADER --}}
    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 p-8 shadow-xl mb-6">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-4xl font-bold text-white mb-1">{{ $customer->displayName() }}</h1>
                <p class="text-sm text-slate-400">Klant ID: #{{ $customer->id }}</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('customers.create') }}" class="px-5 py-3 bg-yellow-400 hover:bg-yellow-300 text-gray-900 rounded-lg font-semibold transition">Nieuwe klant</a>
                <a href="{{ route('customers.edit', $customer) }}" class="px-5 py-3 bg-yellow-400 hover:bg-yellow-300 text-gray-900 rounded-lg font-semibold transition">Bewerk</a>
                <a href="{{ route('maintenance.requests.create', $customer) }}"
                   class="px-5 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition">
                    Storingsaanvraag
                </a>
            </div>
        </div>

        {{-- QUICK STATS --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-slate-700/30 rounded-xl p-5 text-center border border-slate-600">
                <p class="text-sm text-slate-400 mb-1">Contracten</p>
                <p class="text-3xl font-bold text-yellow-400">{{ $customer->contracts->count() }}</p>
            </div>
            <div class="bg-slate-700/30 rounded-xl p-5 text-center border border-slate-600">
                <p class="text-sm text-slate-400 mb-1">Bestellingen</p>
                <p class="text-3xl font-bold text-yellow-400">{{ $customer->orders->count() }}</p>
            </div>
            <div class="bg-slate-700/30 rounded-xl p-5 text-center border border-slate-600">
                <p class="text-sm text-slate-400 mb-1">Facturen</p>
                <p class="text-3xl font-bold text-yellow-400">{{ $customer->invoices->count() }}</p>
            </div>
            <div class="bg-slate-700/30 rounded-xl p-5 text-center border border-slate-600">
                <p class="text-sm text-slate-400 mb-1">Afspraken</p>
                <p class="text-3xl font-bold text-yellow-400">{{ $customer->appointments->count() }}</p>
            </div>
        </div>
    </div>

    {{-- DETAILS --}}
    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 shadow-xl p-8 mb-6">
        <h2 class="text-lg font-semibold text-white mb-6">Klantgegevens</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
            <div>
                <strong class="text-slate-400">Contactpersoon</strong>
                <div class="text-white mt-1">{{ $customer->contact_name ?? '-' }}</div>
            </div>

            <div>
                <strong class="text-slate-400">E-mail</strong>
                <div class="text-white mt-1">{{ $customer->contact_email ?? '-' }}</div>
            </div>

            <div>
                <strong class="text-slate-400">Telefoon</strong>
                <div class="text-white mt-1">{{ $customer->contact_phone ?? '-' }}</div>
            </div>

            <div>
                <strong class="text-slate-400">Status</strong>
                <div class="text-white mt-1">{{ $customer->status ?? '-' }}</div>
            </div>
        </div>
    </div>

    {{-- TABS --}}
    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 shadow-xl">
        <div class="border-b border-slate-700 flex gap-6 px-8 pt-6 text-sm font-semibold">
            <button data-tab="contracts" class="tab-btn text-yellow-400 border-b-2 border-yellow-400 pb-3">
                Contracten
            </button>
            <button data-tab="orders" class="tab-btn text-slate-400 pb-3 hover:text-slate-200 transition">
                Bestellingen
            </button>
            <button data-tab="invoices" class="tab-btn text-slate-400 pb-3 hover:text-slate-200 transition">
                Facturen
            </button>
            <button data-tab="appointments" class="tab-btn text-slate-400 pb-3 hover:text-slate-200 transition">
                Afspraken
            </button>
        </div>

        <div class="p-8 space-y-10">

            {{-- CONTRACTEN --}}
            <section id="contracts" class="tab-content">
                <h2 class="text-xl font-semibold text-white mb-4">Contracten</h2>

                @forelse($customer->contracts as $contract)
                <div class="bg-slate-700/30 rounded-lg p-5 mb-3 border border-slate-600">
                    <p class="font-medium text-white">Contract #{{ $contract->id }}</p>
                    <p class="text-sm text-slate-400">Status: {{ $contract->status ?? '-' }}</p>
                </div>
                @empty
                <p class="text-slate-400 italic">Geen contracten gevonden.</p>
                @endforelse
            </section>

            {{-- BESTELLINGEN --}}
            <section id="orders" class="tab-content hidden">
                <h2 class="text-xl font-semibold text-white mb-4">Bestellingen</h2>

                @forelse($customer->orders as $order)
                <div class="bg-slate-700/30 rounded-lg p-5 mb-3 border border-slate-600">
                    <p class="font-medium text-white">Bestelling #{{ $order->id }}</p>
                    <p class="text-sm text-slate-400">Status: {{ $order->status ?? '-' }}</p>
                </div>
                @empty
                <p class="text-slate-400 italic">Geen bestellingen gevonden.</p>
                @endforelse
            </section>

            {{-- FACTUREN --}}
            <section id="invoices" class="tab-content hidden">
                <h2 class="text-xl font-semibold text-white mb-4">Facturen</h2>

                @forelse($customer->invoices as $invoice)
                <div class="bg-slate-700/30 rounded-lg p-5 mb-3 border border-slate-600">
                    <p class="font-medium text-white">Factuur #{{ $invoice->id }}</p>
                    <p class="text-sm text-slate-400">
                        Bedrag: €{{ number_format($invoice->total ?? 0, 2, ',', '.') }}
                    </p>
                </div>
                @empty
                <p class="text-slate-400 italic">Geen facturen gevonden.</p>
                @endforelse
            </section>

            {{-- AFSPRAKEN --}}
            <section id="appointments" class="tab-content hidden">
                <h2 class="text-xl font-semibold text-white mb-4">Afspraken</h2>

                @forelse($customer->appointments as $appointment)
                <div class="bg-slate-700/30 rounded-lg p-5 mb-3 border border-slate-600">
                    <p class="font-medium text-white">Afspraak #{{ $appointment->id }}</p>
                    <p class="text-sm text-slate-400">
                        Datum: {{ $appointment->date ?? '-' }} |
                        Status: {{ $appointment->status ?? '-' }}
                    </p>
                </div>
                @empty
                <p class="text-slate-400 italic">Geen afspraken gevonden.</p>
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