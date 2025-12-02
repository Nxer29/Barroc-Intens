@extends('layouts.app')

@section('content')
<div class="w-full max-w-6xl mx-auto py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-yellow-400">Contracten</h1>
        <a href="{{ route('contracts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-400 text-gray-900 rounded-md shadow hover:opacity-95">
            Nieuw contract
        </a>
    </div>

    @if($contracts->isEmpty())
        <div class="bg-gray-900 rounded-2xl border border-yellow-400/20 p-6 text-center">
            <p class="text-gray-300 mb-3">Er zijn nog geen contracten.</p>
            <a href="{{ route('contracts.create') }}" class="text-yellow-300 hover:underline">Maak het eerste contract aan</a>
        </div>
    @else
        <div class="overflow-x-auto bg-gray-900 rounded-2xl border border-yellow-400/10 p-4">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="text-left text-sm text-gray-300 border-b border-gray-800">
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Klant</th>
                        <th class="px-4 py-3">Start</th>
                        <th class="px-4 py-3">Eind</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Acties</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-200">
                    @foreach($contracts as $c)
                        <tr class="odd:bg-gray-850 even:bg-gray-800">
                            <td class="px-4 py-3 align-top">{{ $c->id }}</td>
                            <td class="px-4 py-3 align-top">{{ $c->customer->company_name ?? '-' }}</td>
                            <td class="px-4 py-3 align-top">
                                {{ optional($c->start_date)->format('Y-m-d') ?? '-' }}
                            </td>
                            <td class="px-4 py-3 align-top">
                                {{ optional($c->end_date)->format('Y-m-d') ?? '-' }}
                            </td>
                            <td class="px-4 py-3 align-top">
                                <span class="inline-flex items-center px-2 py-1 text-xs rounded-full
                                    {{ $c->status === 'active' ? 'bg-green-800 text-green-300' : 'bg-gray-800 text-gray-300' }}">
                                    {{ $c->status ?? '—' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 align-top">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('contracts.show', $c) }}" class="text-yellow-300 hover:underline text-sm">Bekijk</a>
                                    <a href="{{ route('contracts.edit', $c) }}" class="text-gray-200 bg-gray-800 px-2 py-1 rounded text-sm border border-gray-700 hover:bg-gray-850">Bewerk</a>
                                    <form action="{{ route('contracts.destroy', $c) }}" method="POST" onsubmit="return confirm('Weet je het zeker?')" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-sm text-red-400 hover:text-red-500 ml-1">Verwijder</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if(method_exists($contracts, 'links'))
            <div class="mt-4">
                {{ $contracts->links() }}
            </div>
        @endif
    @endif
</div>
@endsection