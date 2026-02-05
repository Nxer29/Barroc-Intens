@extends('layouts.app')

@section('content')
<div class="w-full max-w-6xl mx-auto py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-yellow-400">
            Klanten
        </h1>

        <a href="{{ route('customers.create') }}"
            class="px-4 py-2 bg-yellow-400 text-gray-900 rounded-lg font-medium hover:opacity-90">
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
            class="w-full md:w-1/3 px-4 py-2 rounded-lg bg-gray-900 border border-gray-700 text-gray-200 focus:border-yellow-400 focus:outline-none">
    </form>

    {{-- Success melding --}}
    @if(session('success'))
    <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
    </div>
    @endif

    {{-- Klanten tabel --}}
    <div class="bg-gray-900 rounded-2xl border border-yellow-400/40 shadow-lg overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-800 text-gray-300 text-sm uppercase">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Bedrijf</th>
                    <th class="px-6 py-3">Contact</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Acties</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-800 text-gray-300">
                @forelse($customers as $customer)
                <tr class="hover:bg-gray-800 transition">
                    <td class="px-6 py-4 text-gray-400">#{{ $customer->id }}</td>

                    <td class="px-6 py-4 font-semibold text-yellow-300">
                        <a href="{{ route('customers.show', $customer) }}" class="hover:underline">{{ $customer->displayName() }}</a>
                    </td>

                    <td class="px-6 py-4">
                        <div class="text-sm font-medium">{{ $customer->contact_name ?? '-' }}</div>
                        <div class="text-xs text-gray-500">
                            {{ $customer->contact_email ?? '—' }}
                            @if($customer->contact_phone) · {{ $customer->contact_phone }} @endif
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-xs {{ $customer->isActive() ? 'bg-green-900 text-green-300' : 'bg-gray-700 text-gray-300' }}">
                            {{ $customer->status ?? 'onbekend' }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('customers.show', $customer) }}" class="text-yellow-300 hover:underline">Bekijk</a>
                            <a href="{{ route('customers.edit', $customer) }}" class="text-gray-300 hover:underline">Bewerk</a>
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