@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-8">
    <h2 class="text-2xl font-bold mb-6">Factuuroverzicht</h2>

    <form method="GET" class="mb-6 flex flex-wrap gap-4">
        <input name="customer" value="{{ request('customer') }}" class="form-input" placeholder="Klantnaam">
        <select name="status" class="form-input">
            <option value="">Factuurstatus</option>
            <option value="openstaand" @if(request('status')==='openstaand')selected @endif>Openstaand</option>
            <option value="betaald" @if(request('status')==='betaald')selected @endif>Betaald</option>
            <option value="vervallen" @if(request('status')==='vervallen')selected @endif>Vervallen</option>
        </select>
        <select name="contract" class="form-input">
            <option value="">Contract (id)</option>
            @foreach($contracts as $contract)
                <option value="{{ $contract->id }}" @if(request('contract')==$contract->id)selected @endif>
                    #{{ $contract->id }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="bg-yellow-400 px-4 py-2 rounded">Filter</button>
    </form>

    <div class="overflow-x-auto bg-white/5 rounded border border-yellow-400/30">
        <table class="min-w-full">
            <thead class="bg-yellow-400 text-black">
                <tr>
                    <th class="py-3 px-4 text-left">Factuurnr.</th>
                    <th class="py-3 px-4 text-left">Klant</th>
                    <th class="py-3 px-4 text-left">Contract</th>
                    <th class="py-3 px-4 text-left">Bedrag</th>
                    <th class="py-3 px-4 text-left">Status</th>
                    <th class="py-3 px-4 text-left">Actie</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    <tr class="hover:bg-gray-900">
                        <td class="py-2 px-4">{{ $invoice->invoice_number }}</td>
                        <td class="py-2 px-4">{{ $invoice->customer->company_name ?? '-' }}</td>
                        <td class="py-2 px-4">#{{ $invoice->contract_id ?? '-' }}</td>
                        <td class="py-2 px-4">€ {{ number_format($invoice->total_amount,2,',','.') }}</td>
                        <td class="py-2 px-4">
                            @if($invoice->status === 'betaald')
                                <span class="bg-green-600 text-white rounded px-2 py-1 text-xs">Betaald</span>
                            @elseif($invoice->status === 'openstaand')
                                <span class="bg-yellow-500 text-black rounded px-2 py-1 text-xs">Openstaand</span>
                            @else
                                <span class="bg-gray-500 text-white rounded px-2 py-1 text-xs">{{ ucfirst($invoice->status) }}</span>
                            @endif
                        </td>
                        <td class="py-2 px-4">
                            <a href="{{ route('invoices.show', $invoice->id) }}" class="text-yellow-400">Bekijk</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="py-4 px-4 text-center text-gray-400" colspan="6">Geen facturen gevonden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection