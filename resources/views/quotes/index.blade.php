@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="mb-12">
        <h1 class="text-4xl font-bold text-white">Offerteoverzicht</h1>
        <p class="text-gray-400 mt-2">Beheer en bekijk alle offertes</p>
    </div>

    <div class="flex justify-end mb-6">
        <a href="{{ route('quotes.create') }}"
            class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-semibold px-6 py-3 rounded-lg transition shadow-sm">
            + Nieuwe offerte
        </a>
    </div>

    @if (session('success'))
    <div id="success-alert" class="mb-6 rounded-lg border border-emerald-500 bg-emerald-900/20 px-4 py-3 text-sm text-emerald-300 flex items-center gap-2">
        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400">✓</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="overflow-x-auto bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl shadow-xl border border-slate-700">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-800 text-slate-300">
                <tr>
                    <th class="py-4 px-4 text-left font-semibold">Offertenr.</th>
                    <th class="py-4 px-4 text-left font-semibold">Klant</th>
                    <th class="py-4 px-4 text-left font-semibold">Bedrag</th>
                    <th class="py-4 px-4 text-left font-semibold">Status</th>
                    <th class="py-4 px-4 text-left font-semibold">Acties</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-700">
                @forelse($quotes as $quote)
                <tr class="transition hover:bg-slate-800/50">
                    <td class="py-4 px-4 text-white font-medium">{{ $quote->quote_number }}</td>
                    <td class="py-4 px-4 text-slate-300">{{ $quote->customer->company_name ?? '-' }}</td>
                    <td class="py-4 px-4 font-semibold text-white">€ {{ number_format($quote->total_amount, 2, ',', '.') }}</td>
                    <td class="py-4 px-4">
                        <span class="inline-flex items-center gap-1 bg-slate-500/20 text-slate-300 px-3 py-1 rounded-full text-xs font-semibold border border-slate-500/30">
                            ● {{ $quote->status ?? 'draft' }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('quotes.show', $quote->id) }}"
                                class="px-3 py-1.5 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white text-xs transition font-medium">
                                Bekijk
                            </a>
                            <a href="{{ route('quotes.pdf', $quote->id) }}"
                                class="px-3 py-1.5 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white text-xs transition font-medium">
                                PDF
                            </a>
                            <form method="POST" action="{{ route('quotes.send', $quote->id) }}">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-1.5 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white text-xs transition font-medium">
                                    Mail
                                </button>
                            </form>
                            <form method="POST" action="{{ route('quotes.destroy', $quote->id) }}"
                                onsubmit="return confirm('Offerte definitief verwijderen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1.5 rounded-lg border border-red-500 text-red-400 hover:bg-red-500/10 text-xs transition font-medium">
                                    Verwijder
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-6 text-center text-gray-500">Geen offertes gevonden.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $quotes->links() }}
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