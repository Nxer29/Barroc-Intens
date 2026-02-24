@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-white">Voorraadbeheer</h1>
        <p class="text-gray-400 mt-2">
            Overzicht van alle producten en voorraadniveaus
        </p>
    </div>

    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 shadow-xl overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-800 text-slate-300">
                <tr>
                    <th class="p-4 text-left">Product</th>
                    <th class="p-4 text-left">Categorie</th>
                    <th class="p-4 text-left">Voorraad</th>
                    <th class="p-4 text-left">Min.</th>
                    <th class="p-4 text-left">Locatie</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Acties</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-700">
                @foreach ($products as $product)
                @php
                $inventory = $product->inventory;
                $qty = $inventory->quantity ?? 0;
                $min = $inventory->min_threshold ?? 0;
                $location = $inventory->location ?? '—';
                @endphp

                <tr class="hover:bg-slate-800/50 transition">
                    <td class="p-4 text-white">{{ $product->name }}</td>
                    <td class="p-4 text-slate-300">{{ $product->category->name ?? '—' }}</td>

                    <td class="p-4 font-semibold text-white">{{ $qty }}</td>
                    <td class="p-4 text-slate-300">{{ $min }}</td>
                    <td class="p-4 text-slate-300">{{ $location }}</td>

                    <td class="p-4">
                        @if($qty < $min)
                            <span class="text-red-400 font-bold">⚠ Te laag</span>
                            @elseif($qty == $min)
                            <span class="text-yellow-400 font-bold">Bij drempel</span>
                            @else
                            <span class="text-emerald-400 font-bold">Goed</span>
                            @endif
                    </td>

                    <td class="p-4">
                        <div class="flex flex-wrap gap-3">
                            @if($inventory)
                            <a href="{{ route('inventory.show', $inventory->id) }}" class="px-4 py-2 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">Bekijken</a>
                            <a href="{{ route('inventory.edit', $inventory->id) }}" class="px-4 py-2 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">Instellingen</a>
                            @endif
                            <a href="{{ route('inventory.change', $product->id) }}" class="px-4 py-2 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">Voorraad wijzigen</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection