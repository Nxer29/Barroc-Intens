@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <h1 class="text-3xl font-bold text-yellow-400 mb-6">Geplande afspraken</h1>

    <a href="{{ route('appointments.create') }}"
       class="bg-yellow-400 text-black px-4 py-2 rounded-lg font-semibold hover:bg-yellow-500 transition mb-6 inline-block">
        + Nieuwe afspraak
    </a>

    @if(session('success'))
        <div class="bg-green-800/40 border border-green-500 text-green-300 p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-900 border border-gray-700 rounded-xl overflow-hidden shadow-lg">
        <table class="w-full">
            <thead class="bg-gray-800 text-gray-300">
                <tr>
                    <th class="p-3 text-left">Klant</th>
                    <th class="p-3 text-left">Type</th>
                    <th class="p-3 text-left">Datum</th>
                    <th class="p-3 text-left">Monteur</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Acties</th>
                </tr>
            </thead>

            <tbody>
            @forelse ($appointments as $a)
                <tr class="border-t border-gray-700">
                    <td class="p-3">
                        {{ $a->customer->company_name ?? '—' }}
                    </td>
                    <td class="p-3">{{ $a->type->name }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($a->scheduled_at)->format('d-m-Y') }}</td>
                    <td class="p-3">{{ $a->technician->name ?? 'Niet toegewezen' }}</td>

                    <td class="p-3">
                        <span class="px-3 py-1 rounded-lg text-sm
                            @if($a->status === 'planned') bg-blue-700/50 text-blue-300
                            @elseif($a->status === 'done') bg-green-700/50 text-green-300
                            @else bg-gray-700/50 text-gray-300 @endif">
                            {{ $a->status ?? 'onbekend' }}
                        </span>
                    </td>

                    <td class="p-3 flex gap-3">
                        <a href="{{ route('appointments.show', $a) }}"
                           class="text-yellow-400 hover:text-yellow-500">Bekijken</a>

                        <a href="{{ route('appointments.edit', $a) }}"
                           class="text-blue-400 hover:text-blue-500">Bewerken</a>

                        <form action="{{ route('appointments.destroy', $a) }}" method="POST"
                              onsubmit="return confirm('Weet je zeker dat je dit wilt verwijderen?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-400 hover:text-red-500">Verwijderen</button>
                        </form>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="6" class="p-6 text-center text-gray-400">Geen afspraken gevonden.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 text-gray-400">
        {{ $appointments->links() }}
    </div>

</div>

@endsection
