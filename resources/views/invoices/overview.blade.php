@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold">Factuuroverzicht</h2>
        <a href="{{ route('invoices.create') }}" class="bg-yellow-400 px-5 py-2.5 rounded text-black text-base font-semibold">Nieuwe factuur</a>
    </div>

    <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 text-base">
        <input name="customer" value="{{ request('customer') }}" class="form-input py-2" placeholder="Klantnaam">
        <select name="status" class="form-input py-2">
            <option value="">Factuurstatus</option>
            <option value="concept" @if(request('status')==='concept')selected @endif>Concept</option>
            <option value="onbetald" @if(request('status')==='onbetald')selected @endif>Onbetaald</option>
            <option value="betaald" @if(request('status')==='betaald')selected @endif>Betaald</option>
        </select>
        <button type="submit" class="bg-yellow-400 px-5 py-2.5 rounded text-black font-semibold">Filter</button>
    </form>

    <div class="overflow-x-auto bg-white/5 rounded border border-yellow-400/30">
        <table class="min-w-full text-base">
            <thead class="bg-yellow-400 text-black">
                <tr>
                    <th class="py-3 px-4 text-left">Factuurnr.</th>
                    <th class="py-3 px-4 text-left">Klant</th>
                    <th class="py-3 px-4 text-left">Bedrag</th>
                    <th class="py-3 px-4 text-left">Status</th>
                    <th class="py-3 px-4 text-left">Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    <tr class="hover:bg-gray-900">
                        <td class="py-3 px-4">{{ $invoice->invoice_number }}</td>
                        <td class="py-3 px-4">{{ $invoice->customer->company_name ?? '-' }}</td>
                        <td class="py-3 px-4">€ {{ number_format($invoice->total_amount,2,',','.') }}</td>
                        <td class="py-3 px-4">
                            @if($invoice->status === 'betaald')
                                <span class="bg-green-600 text-white rounded px-2.5 py-1 text-sm">Betaald</span>
                            @elseif($invoice->status === 'onbetald')
                                <span class="bg-yellow-500 text-black rounded px-2.5 py-1 text-sm">Onbetaald</span>
                            @else
                                <span class="bg-gray-500 text-white rounded px-2.5 py-1 text-sm">{{ ucfirst($invoice->status) }}</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex flex-wrap items-center gap-3">
                                <a href="{{ route('invoices.show', $invoice->id) }}" class="text-yellow-400 text-base">Bekijk</a>

                                <form method="POST" action="{{ route('invoices.status', $invoice->id) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-input text-sm py-1.5 px-2.5">
                                        <option value="concept" @selected($invoice->status === 'concept')>Concept</option>
                                        <option value="onbetald" @selected($invoice->status === 'onbetald')>Onbetaald</option>
                                        <option value="betaald" @selected($invoice->status === 'betaald')>Betaald</option>
                                    </select>
                                    <button type="submit" class="bg-yellow-400 text-black px-3 py-1.5 rounded text-sm font-semibold">
                                        Opslaan
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('invoices.destroy', $invoice->id) }}" onsubmit="return confirm('Factuur definitief verwijderen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="border border-red-500 text-red-300 px-3 py-1.5 rounded text-sm hover:bg-red-500/10">
                                        Verwijder
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="py-5 px-4 text-center text-gray-400" colspan="5">Geen facturen gevonden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-5">
            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection