@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-[var(--brand-yellow)]">Voorraadbeheer</h1>
</div>

<div class="overflow-hidden rounded-xl border border-gray-700 dark:border-gray-600 shadow-xl">
    <table class="w-full">
        <thead class="bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
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

        <tbody class="bg-white dark:bg-gray-900">
        @foreach ($products as $product)
            @php
                $inventory = $product->inventory;
                $qty = $inventory->quantity ?? 0;
                $min = $inventory->min_threshold ?? 0;
                $location = $inventory->location ?? '—';
            @endphp

            <tr class="border-b border-gray-300 dark:border-gray-800">
                <td class="p-4">{{ $product->name }}</td>
                <td class="p-4">{{ $product->category->name ?? '—' }}</td>

                <td class="p-4 font-semibold">{{ $qty }}</td>
                <td class="p-4">{{ $min }}</td>
                <td class="p-4">{{ $location }}</td>

                <td class="p-4">
                    @if($qty < $min)
                        <span class="text-red-500 font-bold">⚠ Te laag</span>
                    @elseif($qty == $min)
                        <span class="text-yellow-400 font-bold">Bij drempel</span>
                    @else
                        <span class="text-green-500 font-bold">Goed</span>
                    @endif
                </td>

                <td class="p-4 flex gap-3">
                    @if($inventory)
                        <a href="{{ route('inventory.show', $inventory->id) }}" class="btn-ghost">Bekijken</a>
                        <a href="{{ route('inventory.edit', $inventory->id) }}" class="btn-yellow px-3 py-1">Instellingen</a>
                    @endif
                    <a href="{{ route('inventory.change', $product->id) }}" class="btn-yellow px-3 py-1">Voorraad wijzigen</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
