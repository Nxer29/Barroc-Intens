@extends('layouts.app')

@section('content')
<div class="w-full max-w-6xl mx-auto py-8">

    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-900/60 border border-green-500 p-4 text-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-900 rounded-2xl border border-yellow-400/40 p-6 shadow-lg">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-yellow-400">
                Maintenance – Storingsaanvragen
            </h1>
        </div>
<form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

    {{-- Status --}}
    <select name="status" class="bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-gray-300">
        <option value="">Alle statussen</option>
        <option value="open" @selected(request('status') === 'open')>Open</option>
        <option value="planned" @selected(request('status') === 'planned')>Gepland</option>
        <option value="closed" @selected(request('status') === 'closed')>Afgerond</option>
    </select>

    {{-- Prioriteit --}}
    <select name="priority" class="bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-gray-300">
        <option value="">Alle prioriteiten</option>
        <option value="low" @selected(request('priority') === 'low')>Laag</option>
        <option value="medium" @selected(request('priority') === 'medium')>Middel</option>
        <option value="high" @selected(request('priority') === 'high')>Hoog</option>
    </select>

    {{-- Vanaf datum --}}
    <input type="date"
           name="from_date"
           value="{{ request('from_date') }}"
           class="bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-gray-300">

    {{-- Tot datum --}}
    <input type="date"
           name="to_date"
           value="{{ request('to_date') }}"
           class="bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-gray-300">

    <div class="md:col-span-4 flex gap-3">
        <button class="px-4 py-2 bg-yellow-400 text-gray-900 rounded-lg font-medium">
            Filteren
        </button>

        <a href="{{ route('maintenance.requests.index') }}"
           class="px-4 py-2 border border-gray-700 rounded-lg text-gray-300">
            Reset
        </a>
    </div>
</form>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-300">
                <thead class="text-xs uppercase text-gray-400 border-b border-gray-800">
                    <tr>
                        <th class="py-3 px-3">Nr</th>
                        <th class="py-3 px-3">Klant</th>
                        <th class="py-3 px-3">Prioriteit</th>
                        <th class="py-3 px-3">Urgentie</th>
                        <th class="py-3 px-3">Status</th>
                        <th class="py-3 px-3">Aangemaakt</th>
                        <th class="py-3 px-3"></th>
                    </tr>
                </thead>

                <tbody>
                @forelse($requests as $request)
                    <tr class="border-b border-gray-800 hover:bg-gray-800/40">
                        <td class="py-3 px-3 font-mono text-yellow-300">
                            {{ $request->request_number }}
                        </td>

                        <td class="py-3 px-3">
                            {{ $request->customer?->displayName() ?? '-' }}
                        </td>

                        <td class="py-3 px-3">
                            {{ ucfirst($request->priority) }}
                        </td>

                        <td class="py-3 px-3">
                            {{ ucfirst($request->urgency) }}
                        </td>

                        <td class="py-3 px-3">
                            <span class="px-2 py-1 rounded text-xs
                                @if($request->status === 'open') bg-red-900/50 text-red-300
                                @elseif($request->status === 'planned') bg-yellow-900/50 text-yellow-300
                                @else bg-green-900/50 text-green-300
                                @endif">
                                {{ ucfirst($request->status) }}
                            </span>
                        </td>

                        <td class="py-3 px-3 text-gray-400">
                            {{ $request->created_at->format('d-m-Y') }}
                        </td>

                        <td class="py-3 px-3 text-right">
                            <a href="{{ route('maintenance.requests.show', $request) }}"
                               class="text-yellow-300 hover:underline">
                                Bekijk
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-gray-500 italic">
                            Geen storingsaanvragen gevonden
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $requests->links() }}
        </div>
    </div>
</div>
@endsection
