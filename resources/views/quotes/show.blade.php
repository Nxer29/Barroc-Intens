@extends('layouts.app')

@section('content')
@php
$subtotal = $quote->items->sum('line_total');
$btw = round($subtotal * 0.21, 2);
$totaal = round($subtotal + $btw, 2);
@endphp

<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="mb-12 flex justify-between items-start">
        <div>
            <h1 class="text-4xl font-bold text-white">Offerte {{ $quote->quote_number }}</h1>
            <p class="text-gray-400 mt-2">Bekijk offerte details en regels</p>
        </div>
        <a href="{{ route('quotes.overview') }}" class="px-6 py-3 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">Terug naar overzicht</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-6 shadow-xl">
            <h3 class="font-semibold text-white mb-3 text-lg">Klant</h3>
            <p class="text-slate-300">{{ $quote->customer->company_name ?? '-' }}</p>
        </div>

        <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-6 shadow-xl">
            <h3 class="font-semibold text-white mb-3 text-lg">Offertegegevens</h3>
            <p class="text-slate-300"><strong class="text-slate-400">Geldig tot:</strong> {{ $quote->valid_until }}</p>
            <p class="text-slate-300"><strong class="text-slate-400">Status:</strong> {{ ucfirst($quote->status ?? 'draft') }}</p>
        </div>
    </div>

    <div class="overflow-x-auto bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl shadow-xl border border-slate-700">
        <table class="min-w-full">
            <thead class="bg-slate-800 text-slate-300">
                <tr>
                    <th class="py-4 px-4 text-left">Omschrijving</th>
                    <th class="py-4 px-4 text-left">Aantal</th>
                    <th class="py-4 px-4 text-left">Prijs p/st</th>
                    <th class="py-4 px-4 text-left">Totaal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                @foreach($quote->items as $item)
                <tr class="hover:bg-slate-800/50 transition">
                    <td class="py-4 px-4 text-white">{{ $item->description }}</td>
                    <td class="py-4 px-4 text-slate-300">{{ $item->quantity }}</td>
                    <td class="py-4 px-4 text-slate-300">€ {{ number_format($item->unit_price,2,',','.') }}</td>
                    <td class="py-4 px-4 text-white font-semibold">€ {{ number_format($item->line_total,2,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-8 text-right bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-6 shadow-xl">
        <p class="text-slate-300 mb-2"><strong class="text-slate-400">Subtotaal:</strong> € {{ number_format($subtotal,2,',','.') }}</p>
        <p class="text-slate-300 mb-2"><strong class="text-slate-400">BTW (21%):</strong> € {{ number_format($btw,2,',','.') }}</p>
        <p class="text-white text-xl font-bold"><strong class="text-slate-400">Totaal:</strong> € {{ number_format($totaal,2,',','.') }}</p>
    </div>
</div>
@endsection