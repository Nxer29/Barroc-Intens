@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-white">Afspraken</h1>
        <p class="text-gray-400 mt-2">
            Overzicht van alle geplande afspraken
        </p>
    </div>

    <div class="flex justify-end items-center mb-6">
        <a href="{{ route('appointments.create') }}"
            class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-semibold px-6 py-3 rounded-lg transition">
            + Nieuwe afspraak
        </a>
    </div>

    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl shadow-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-800 text-gray-400">
                <tr>
                    <th class="p-4 text-left">Klant</th>
                    <th class="p-4">Type</th>
                    <th class="p-4">Datum</th>
                    <th class="p-4">Monteur</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Acties</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-800">
                @foreach ($appointments as $a)
                <tr class="hover:bg-slate-800/50 transition">
                    <td class="p-4 font-medium text-white">
                        {{ $a->customer->company_name ?? '—' }}
                    </td>
                    <td class="p-4 text-gray-300">{{ $a->type->name }}</td>
                    <td class="p-4 text-gray-300">{{ $a->scheduled_at->format('d-m-Y') }}</td>
                    <td class="p-4 text-gray-300">{{ $a->technician->name ?? '—' }}</td>

                    <td class="p-4">
                        <span class="badge-status {{ $a->status }}">
                            @if($a->status === 'completed')
                            ✔
                            @elseif($a->status === 'planned')
                            📅
                            @elseif($a->status === 'cancelled')
                            ✖
                            @else
                            ⏳
                            @endif
                            {{ ucfirst($a->status) }}
                        </span>
                    </td>

                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('appointments.show', $a) }}"
                                class="px-4 py-2 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">
                                Bekijk
                            </a>
                            <a href="{{ route('appointments.edit', $a) }}"
                                class="px-4 py-2 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">
                                Bewerk
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $appointments->links() }}
    </div>
</div>
@endsection