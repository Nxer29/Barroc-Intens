@extends('layouts.app')

@section('content')
@php
    $subtotal = $invoice->lines->sum('line_total');
    $btw = round($subtotal * 0.21, 2);
    $totaal = round($subtotal + $btw, 2);
@endphp

<div class="max-w-5xl mx-auto p-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Factuur {{ $invoice->invoice_number }}</h2>
        <a href="{{ route('invoices.overview') }}" class="text-yellow-400 hover:underline">Terug naar overzicht</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white/5 border border-yellow-400/30 rounded p-4">
            <h3 class="font-semibold mb-2">Klant</h3>
            <p>{{ $invoice->customer->company_name ?? '-' }}</p>
        </div>

        <div class="bg-white/5 border border-yellow-400/30 rounded p-4">
            <h3 class="font-semibold mb-2">Factuurgegevens</h3>
            <p><strong>Datum:</strong> {{ $invoice->issue_date }}</p>
            <p><strong>Omschrijving:</strong> {{ $invoice->omschrijving }}</p>
            <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>
        </div>
    </div>

    <div class="overflow-x-auto bg-white/5 rounded border border-yellow-400/30">
        <table class="min-w-full">
            <thead class="bg-yellow-400 text-black">
                <tr>
                    <th class="py-3 px-4 text-left">Omschrijving</th>
                    <th class="py-3 px-4 text-left">Aantal</th>
                    <th class="py-3 px-4 text-left">Prijs p/st</th>
                    <th class="py-3 px-4 text-left">Totaal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->lines as $line)
                    <tr class="hover:bg-gray-900">
                        <td class="py-2 px-4">{{ $line->description }}</td>
                        <td class="py-2 px-4">{{ $line->quantity }}</td>
                        <td class="py-2 px-4">€ {{ number_format($line->unit_price,2,',','.') }}</td>
                        <td class="py-2 px-4">€ {{ number_format($line->line_total,2,',','.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6 text-right">
        <p><strong>Subtotaal:</strong> € {{ number_format($subtotal,2,',','.') }}</p>
        <p><strong>BTW (21%):</strong> € {{ number_format($btw,2,',','.') }}</p>
        <p><strong>Totaal:</strong> € {{ number_format($totaal,2,',','.') }}</p>
    </div>
</div>
@endsection