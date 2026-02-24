@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-white">Factuuroverzicht</h1>
        <p class="text-gray-400 mt-2">
            Beheer en bekijk alle facturen
        </p>
    </div>

    <div class="flex justify-end mb-6">
        <a href="{{ route('invoices.create') }}"
            class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-semibold px-6 py-3 rounded-lg transition shadow-sm">
            + Nieuwe factuur
        </a>
    </div>

    {{-- Success melding --}}
    @if (session('success'))
    <div id="success-alert" class="mb-6 rounded-lg border border-emerald-500 bg-emerald-900/20 px-4 py-3 text-sm text-emerald-300 flex items-center gap-2">
        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400">✓</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    {{-- Filters --}}
    <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <input name="customer"
            value="{{ request('customer') }}"
            placeholder="Klantnaam"
            class="w-full rounded-lg border border-slate-600 bg-slate-700/50 px-4 py-3 text-white placeholder-slate-400 focus:ring-2 focus:ring-yellow-400 focus:outline-none focus:border-transparent">

        <select name="status"
            class="w-full rounded-lg border border-slate-600 bg-slate-700/50 px-4 py-3 text-white focus:ring-2 focus:ring-yellow-400 focus:outline-none focus:border-transparent">
            <option value="">Factuurstatus</option>
            <option value="concept" @selected(request('status')==='concept' )>Concept</option>
            <option value="onbetald" @selected(request('status')==='onbetald' )>Onbetaald</option>
            <option value="betaald" @selected(request('status')==='betaald' )>Betaald</option>
        </select>

        <button type="submit"
            class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-semibold px-5 py-3 rounded-lg transition shadow-sm">
            Filter
        </button>
    </form>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl shadow-xl border border-slate-700">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-800 text-slate-300">
                <tr>
                    <th class="py-4 px-4 text-left font-semibold">Factuurnr.</th>
                    <th class="py-4 px-4 text-left font-semibold">Klant</th>
                    <th class="py-4 px-4 text-left font-semibold">Bedrag</th>
                    <th class="py-4 px-4 text-left font-semibold">Status</th>
                    <th class="py-4 px-4 text-left font-semibold">Acties</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-700">
                @forelse($invoices as $invoice)
                <tr class="transition hover:bg-slate-800/50 {{ $invoice->status === 'onbetald' ? 'bg-red-900/10' : '' }}">
                    <td class="py-4 px-4 text-white font-medium">{{ $invoice->invoice_number }}</td>
                    <td class="py-4 px-4 text-slate-300">{{ $invoice->customer->company_name ?? '-' }}</td>
                    <td class="py-4 px-4 font-semibold text-white">€ {{ number_format($invoice->total_amount, 2, ',', '.') }}</td>
                    <td class="py-4 px-4">
                        @if($invoice->status === 'betaald')
                        <span class="inline-flex items-center gap-1 bg-emerald-500/20 text-emerald-300 px-3 py-1 rounded-full text-xs font-semibold border border-emerald-500/30">
                            ● Betaald
                        </span>
                        @elseif($invoice->status === 'onbetald')
                        <span class="inline-flex items-center gap-1 bg-red-500/20 text-red-300 px-3 py-1 rounded-full text-xs font-semibold border border-red-500/30">
                            ● Onbetaald
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 bg-slate-500/20 text-slate-300 px-3 py-1 rounded-full text-xs font-semibold border border-slate-500/30">
                            ● Concept
                        </span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('invoices.show', $invoice->id) }}"
                                class="px-3 py-1.5 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white text-xs transition font-medium">
                                Bekijk
                            </a>

                            <a href="{{ route('invoices.pdf', $invoice->id) }}"
                                class="px-3 py-1.5 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white text-xs transition font-medium">
                                PDF
                            </a>

                            <form method="POST" action="{{ route('invoices.send', $invoice->id) }}">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-1.5 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white text-xs transition font-medium">
                                    Mail
                                </button>
                            </form>

                            <form method="POST" action="{{ route('invoices.status', $invoice->id) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="rounded-lg border border-slate-600 bg-slate-700/50 px-3 py-1.5 text-xs text-white select-with-arrow-xs w-28">
                                    <option value="concept" @selected($invoice->status === 'concept')>Concept</option>
                                    <option value="onbetald" @selected($invoice->status === 'onbetald')>Onbetaald</option>
                                    <option value="betaald" @selected($invoice->status === 'betaald')>Betaald</option>
                                </select>
                                <button type="submit"
                                    class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 text-xs font-semibold px-3 py-1.5 rounded-lg transition shadow-sm">
                                    Opslaan
                                </button>
                            </form>

                            <form method="POST" action="{{ route('invoices.destroy', $invoice->id) }}"
                                onsubmit="return confirm('Factuur definitief verwijderen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1.5 rounded-lg border border-red-500 text-red-400 hover:bg-red-500/10 text-xs transition font-medium">
                                    Verwijder
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-6 text-center text-gray-500">Geen facturen gevonden.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $invoices->links() }}
        </div>
    </div>
</div>

@if (session('success'))
<script>
    setTimeout(() => {
        const el = document.getElementById('success-alert');
        if (el) el.remove();
    }, 3000);
</script>
@endif
@endsection