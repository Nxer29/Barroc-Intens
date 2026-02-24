@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-white">Klanten</h1>
        <p class="text-gray-400 mt-2">
            Overzicht van alle klanten in het systeem
        </p>
    </div>

    <div class="flex items-center justify-between mb-6">

        <a href="{{ route('customers.create') }}"
            class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-semibold px-6 py-3 rounded-lg transition">
            + Nieuwe klant
        </a>
    </div>

    {{-- Zoekbalk --}}
    <form method="GET" class="mb-6">
        <input
            type="text"
            name="q"
            value="{{ $search }}"
            placeholder="Zoek op klantnaam of ID…"
            class="w-full md:w-1/3 px-4 py-3 rounded-lg bg-slate-800 border border-slate-700 text-gray-200 focus:border-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-400/20">
    </form>

    {{-- Success melding --}}
    @if(session('success'))
    <div class="mb-6 rounded-lg border border-emerald-500 bg-emerald-900/20 px-4 py-3 text-sm text-emerald-300">
        {{ session('success') }}
    </div>
    @endif

    {{-- Klanten tabel --}}
    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 shadow-xl overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-800 text-slate-300 text-sm uppercase">
                <tr>
                    <th class="px-6 py-4">ID</th>
                    <th class="px-6 py-4">Bedrijf</th>
                    <th class="px-6 py-4">Contact</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Acties</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-700 text-gray-300">
                @forelse($customers as $customer)
                <tr class="hover:bg-slate-800/50 transition">
                    <td class="px-6 py-4 text-slate-400">#{{ $customer->id }}</td>

                    <td class="px-6 py-4 font-semibold text-white">
                        <a href="{{ route('customers.show', $customer) }}" class="hover:text-yellow-400 transition">{{ $customer->displayName() }}</a>
                    </td>

                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-slate-200">{{ $customer->contact_name ?? '-' }}</div>
                        <div class="text-xs text-slate-400">
                            {{ $customer->contact_email ?? '—' }}
                            @if($customer->contact_phone) · {{ $customer->contact_phone }} @endif
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $customer->isActive() ? 'bg-emerald-900/30 text-emerald-300 border border-emerald-500/30' : 'bg-slate-700 text-slate-300' }}">
                            {{ $customer->status ?? 'onbekend' }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('customers.show', $customer) }}" class="px-4 py-2 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">Bekijk</a>
                            <a href="{{ route('customers.edit', $customer) }}" class="px-4 py-2 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">Bewerk</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-6 text-center text-gray-400">Geen klanten gevonden</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginatie --}}
    <div class="mt-6">
        {{ $customers->links() }}
    </div>

</div>
@endsection