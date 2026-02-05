@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-8 text-gray-900">

    <style>
        .select-with-arrow {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'><path d='M0 0L5 6L10 0Z' fill='%232b2b2b'/></svg>");
            background-repeat: no-repeat;
            background-position: right 0.9rem center;
            background-size: 10px 6px;
            padding-right: 2.25rem;
        }
        .select-with-arrow-xs {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='8' height='5' viewBox='0 0 8 5'><path d='M0 0L4 5L8 0Z' fill='%232b2b2b'/></svg>");
            background-repeat: no-repeat;
            background-position: right 0.5rem center;
            background-size: 8px 5px;
            padding-right: 1.5rem;
        }
    </style>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h2 class="text-3xl font-bold">Factuuroverzicht</h2>

        <a href="{{ route('invoices.create') }}"
           class="inline-flex items-center justify-center bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg transition shadow-sm">
            + Nieuwe factuur
        </a>
    </div>

    {{-- Success melding --}}
    @if (session('success'))
        <div id="success-alert" class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 flex items-center gap-2">
            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-green-100 text-green-700">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Filters --}}
    <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <input name="customer"
               value="{{ request('customer') }}"
               placeholder="Klantnaam"
               class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none">

        <select name="status"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 select-with-arrow focus:ring-2 focus:ring-yellow-400 focus:outline-none">
            <option value="">Factuurstatus</option>
            <option value="concept" @selected(request('status')==='concept')>Concept</option>
            <option value="onbetald" @selected(request('status')==='onbetald')>Onbetaald</option>
            <option value="betaald" @selected(request('status')==='betaald')>Betaald</option>
        </select>

        <button type="submit"
                class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-5 py-2 rounded-lg transition shadow-sm">
            Filter
        </button>
    </form>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200">
        <table class="min-w-full text-sm">
            <thead class="bg-yellow-400 text-black">
                <tr>
                    <th class="py-3 px-4 text-left font-semibold">Factuurnr.</th>
                    <th class="py-3 px-4 text-left font-semibold">Klant</th>
                    <th class="py-3 px-4 text-left font-semibold">Bedrag</th>
                    <th class="py-3 px-4 text-left font-semibold">Status</th>
                    <th class="py-3 px-4 text-left font-semibold">Acties</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse($invoices as $invoice)
                    <tr class="transition {{ $invoice->status === 'onbetald' ? 'bg-red-50 hover:bg-red-100' : 'hover:bg-gray-50' }}">
                        <td class="py-3 px-4">{{ $invoice->invoice_number }}</td>
                        <td class="py-3 px-4">{{ $invoice->customer->company_name ?? '-' }}</td>
                        <td class="py-3 px-4 font-medium">€ {{ number_format($invoice->total_amount, 2, ',', '.') }}</td>
                        <td class="py-3 px-4">
                            @if($invoice->status === 'betaald')
                                <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    ● Betaald
                                </span>
                            @elseif($invoice->status === 'onbetald')
                                <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    ● Onbetaald
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    ● Concept
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex flex-wrap items-center gap-3">
                                <a href="{{ route('invoices.show', $invoice->id) }}"
                                   class="text-yellow-600 hover:underline font-medium">
                                    Bekijk
                                </a>

                                <a href="{{ route('invoices.pdf', $invoice->id) }}"
                                   class="border border-yellow-400 text-yellow-700 hover:bg-yellow-50 px-3 py-1.5 rounded text-xs transition">
                                    PDF
                                </a>

                                <form method="POST" action="{{ route('invoices.send', $invoice->id) }}">
                                    @csrf
                                    <button type="submit"
                                            class="border border-yellow-400 text-yellow-700 hover:bg-yellow-50 px-3 py-1.5 rounded text-xs transition">
                                        Mail
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('invoices.status', $invoice->id) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="rounded border border-gray-300 px-2 py-1 text-xs select-with-arrow-xs w-28">
                                        <option value="concept" @selected($invoice->status === 'concept')>Concept</option>
                                        <option value="onbetald" @selected($invoice->status === 'onbetald')>Onbetaald</option>
                                        <option value="betaald" @selected($invoice->status === 'betaald')>Betaald</option>
                                    </select>
                                    <button type="submit"
                                            class="bg-yellow-400 hover:bg-yellow-500 text-black text-xs font-semibold px-3 py-1.5 rounded transition shadow-sm">
                                        Opslaan
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('invoices.destroy', $invoice->id) }}"
                                      onsubmit="return confirm('Factuur definitief verwijderen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="border border-red-500 text-red-600 hover:bg-red-50 px-3 py-1.5 rounded text-xs transition">
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