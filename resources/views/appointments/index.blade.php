@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Afspraken</h1>
            <p class="text-gray-400">Overzicht van alle geplande afspraken</p>
        </div>

        <a href="{{ route('appointments.create') }}"
           class="btn-primary">
            + Nieuwe afspraak
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-700 rounded-2xl overflow-hidden">
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

                    <td class="p-4 text-right space-x-3">
                        <a href="{{ route('appointments.show', $a) }}"
                           class="text-gray-400 hover:text-white transition">
                            Bekijk
                        </a>
                        <a href="{{ route('appointments.edit', $a) }}"
                           class="text-yellow-400 hover:text-yellow-300 transition">
                            Bewerk
                        </a>
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
