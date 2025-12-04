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
            @foreach ($inventories as $item)
                <tr class="border-b border-gray-300 dark:border-gray-800">
                    <td class="p-4">{{ $item->product->name }}</td>
                    <td class="p-4">{{ $item->product->category->name ?? '—' }}</td>

                    <td class="p-4 font-semibold">
                        {{ $item->quantity }}
                    </td>

                    <td class="p-4">{{ $item->min_threshold }}</td>

                    <td class="p-4">{{ $item->location ?? '—' }}</td>

                    <td class="p-4">
                        @if($item->quantity < $item->min_threshold)
                            <span class="text-red-500 font-bold">⚠ Te laag</span>
                        @elseif($item->quantity == $item->min_threshold)
                            <span class="text-yellow-400 font-bold">Bij drempel</span>
                        @else
                            <span class="text-green-500 font-bold">Goed</span>
                        @endif
                    </td>

                    <td class="p-4 flex gap-3">
                        <a href="{{ route('inventory.show', $item->id) }}" class="btn-ghost">Bekijken</a>
                        <a href="{{ route('inventory.edit', $item->id) }}" class="btn-yellow px-3 py-1">Instellingen</a>
                        <a href="{{ route('inventory.change', $item->product_id) }}" class="btn-yellow px-3 py-1">Voorraad wijzigen</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
