@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-8">

    {{-- HEADER --}}
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-yellow-400">
            Factuuroverzicht
        </h1>
    </div>

    {{-- FILTERS --}}
    <form method="GET" class="mb-6 flex flex-wrap gap-4 bg-gray-900 border border-yellow-400/30 rounded-xl p-4">

        <input
            name="customer"
            value="{{ request('customer') }}"
            placeholder="Klantnaam"
            class="bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2"
        >

        <select name="status"
                class="bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2">
            <option value="">Status</option>
            <option value="openstaand" @selected(request('status')==='openstaand')>Openstaand</option>
            <option value="betaald" @selected(request('status')==='betaald')>Betaald</option>
            <option value="vervallen" @selected(request('status')==='vervallen')>Vervallen</option>
        </select>

        <select name="contract"
                class="bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2">
            <option value="">Contract</option>
            @foreach($contracts as $contract)
                <option value="{{ $contract->id }}"
                    @selected(request('contract') == $contract->id)>
                    #{{ $contract->id }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="bg-yellow-400 text-gray-900 font-medium px-4 py-2 rounded hover:opacity-90">
            Filter
        </button>
    </form>

    {{-- TABEL --}}
    <div class="overflow-x-auto bg-gray-900 border border-yellow-400/30 rounded-xl">

        <table class="w-full text-sm text-left text-gray-300">
            <thead class="text-xs uppercase text-gray-400 border-b border-gray-800">
                <tr>
                    <th class="px-4 py-3">Factuurnr</th>
                    <th class="px-4 py-3">Klant</th>
                    <th class="px-4 py-3">Contract</th>
                    <th class="px-4 py-3">Bedrag</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>

            <tbody>
            @forelse($invoices as $invoice)
                <tr class="border-b border-gray-800 hover:bg-gray-800/40 transition">
                    <td class="px-4 py-3 font-mono text-yellow-300">
                        {{ $invoice->invoice_number }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $invoice->customer->company_name ?? '-' }}
                    </td>

                    <td class="px-4 py-3">
                        #{{ $invoice->contract_id ?? '-' }}
                    </td>

                    <td class="px-4 py-3">
                        € {{ number_format((float) $invoice->total_amount, 2, ',', '.') }}
                    </td>

                    <td class="px-4 py-3">
                        @if($invoice->status === 'betaald')
                            <span class="px-2 py-1 rounded text-xs bg-green-900/60 text-green-300">
                                Betaald
                            </span>
                        @elseif($invoice->status === 'openstaand')
                            <span class="px-2 py-1 rounded text-xs bg-yellow-900/60 text-yellow-300">
                                Openstaand
                            </span>
                        @else
                            <span class="px-2 py-1 rounded text-xs bg-gray-700 text-gray-300">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('invoices.show', $invoice) }}"
                           class="text-yellow-300 hover:underline">
                            Bekijk
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6"
                        class="px-4 py-6 text-center text-gray-500 italic">
                        Geen facturen gevonden
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{-- PAGINATIE --}}
        <div class="p-4">
            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection
