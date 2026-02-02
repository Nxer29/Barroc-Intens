  @extends('layouts.app')

@section('content')
<div class="w-full max-w-4xl mx-auto py-8">
    <div class="bg-gray-900 rounded-2xl border border-yellow-400/20 p-6">
        <div class="flex items-start justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-yellow-400">Contract #{{ $contract->contract_number ?? $contract->id }}</h1>
                <p class="text-sm text-gray-400 mt-1">Aangemaakt: {{ $contract->created_at->format('Y-m-d') }}</p>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    {{ ($contract->status ?? '') === 'active' ? 'bg-green-800 text-green-300' : 'bg-gray-800 text-gray-300' }}">
                    {{ ucfirst($contract->status ?? '—') }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="p-4 bg-gray-850 rounded border border-gray-800">
                <div class="text-xs text-gray-400">Klant</div>
                <div class="text-sm text-gray-100 font-medium mt-1">{{ $contract->customer->company_name ?? '-' }}</div>
                @if($contract->customer && $contract->customer->email ?? false)
                    <div class="text-xs text-gray-500 mt-1">{{ $contract->customer->email }}</div>
                @endif
            </div>

            <div class="p-4 bg-gray-850 rounded border border-gray-800">
                <div class="text-xs text-gray-400">Periode</div>
                <div class="text-sm text-gray-100 font-medium mt-1">
                    {{ optional($contract->start_date)->format('Y-m-d') ?? '—' }} — {{ optional($contract->end_date)->format('Y-m-d') ?? '—' }}
                </div>
            </div>

            <div class="p-4 bg-gray-850 rounded border border-gray-800">
                <div class="text-xs text-gray-400">Recurring bedrag</div>
                <div class="text-sm text-gray-100 font-medium mt-1">
                    {{ $contract->recurring_amount !== null ? '€ ' . number_format($contract->recurring_amount, 2, ',', '.') : '—' }}
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-semibold text-yellow-300 mb-3">Details</h3>
            <div class="bg-gray-850 rounded p-4 border border-gray-800">
                <p class="text-sm text-gray-300"><span class="text-gray-400">Naam:</span> {{ $contract->name ?? '—' }}</p>
                <p class="text-sm text-gray-300"><span class="text-gray-400">Gemaakt door:</span> {{ $contract->creator->name ?? ($contract->created_by ? 'User #' . $contract->created_by : '—') }}</p>
                <p class="text-sm text-gray-300"><span class="text-gray-400">Contract ID (DB):</span> {{ $contract->id }}</p>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-yellow-300 mb-3">Producten</h3>

            @if($contract->products->isEmpty())
                <div class="p-4 bg-gray-850 rounded border border-gray-800 text-gray-400">
                    Geen producten gekoppeld aan dit contract.
                </div>
            @else
                <div class="overflow-x-auto bg-gray-850 rounded border border-gray-800">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="text-left text-sm text-gray-400 border-b border-gray-800">
                                <th class="px-4 py-3">Product</th>
                                <th class="px-4 py-3">Eenheidsprijs</th>
                                <th class="px-4 py-3">Aantal</th>
                                <th class="px-4 py-3 text-right">Subtotaal</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-200">
                            @php $total = 0; @endphp
                            @foreach($contract->products as $p)
                                @php
                                    $qty = $p->pivot->quantity ?? 1;
                                    $price = $p->pivot->unit_price ?? $p->price ?? 0;
                                    $sub = $qty * floatval($price);
                                    $total += $sub;
                                @endphp
                                <tr class="odd:bg-gray-900 even:bg-gray-850">
                                    <td class="px-4 py-3">{{ $p->name }}</td>
                                    <td class="px-4 py-3">€ {{ number_format($price, 2, ',', '.') }}</td>
                                    <td class="px-4 py-3">{{ $qty }}</td>
                                    <td class="px-4 py-3 text-right">€ {{ number_format($sub, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr class="border-t border-gray-800">
                                <td colspan="3" class="px-4 py-3 text-right font-medium text-gray-200">Totaal</td>
                                <td class="px-4 py-3 text-right font-semibold text-yellow-300">€ {{ number_format($total, 2, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="mt-6 flex items-center gap-3">
            <a href="{{ route('contracts.edit', $contract) }}" class="px-4 py-2 bg-yellow-400 text-gray-900 rounded-md font-medium hover:opacity-95">Bewerk</a>

            <form action="{{ route('contracts.destroy', $contract) }}" method="POST" onsubmit="return confirm('Weet je het zeker?')" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="px-4 py-2 border border-red-600 text-red-400 rounded-md hover:bg-red-900">Verwijder</button>
            </form>

            <a href="{{ route('contracts.index') }}" class="ml-auto text-gray-300 hover:underline">Terug naar overzicht</a>
        </div>
    </div>
</div>
@endsection
