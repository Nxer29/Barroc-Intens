@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    @if(session('success'))
    <div class="mb-6 rounded-lg bg-emerald-900/20 border border-emerald-500 p-4 text-emerald-300">
        {{ session('success') }}
    </div>
    @endif

    {{-- HEADER --}}
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-white">Storingsaanvragen</h1>
        <p class="text-gray-400 mt-2">
            Beheer en volg alle maintenance requests
        </p>
    </div>

    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 p-8 shadow-xl">

        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

            {{-- Status --}}
            <select name="status" class="bg-slate-700/50 border border-slate-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                <option value="">Alle statussen</option>
                <option value="open" @selected(request('status')==='open' )>Open</option>
                <option value="planned" @selected(request('status')==='planned' )>Gepland</option>
                <option value="closed" @selected(request('status')==='closed' )>Afgerond</option>
            </select>

            {{-- Prioriteit --}}
            <select name="priority" class="bg-slate-700/50 border border-slate-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                <option value="">Alle prioriteiten</option>
                <option value="low" @selected(request('priority')==='low' )>Laag</option>
                <option value="medium" @selected(request('priority')==='medium' )>Middel</option>
                <option value="high" @selected(request('priority')==='high' )>Hoog</option>
            </select>

            {{-- Vanaf datum --}}
            <input type="date"
                name="from_date"
                value="{{ request('from_date') }}"
                class="bg-slate-700/50 border border-slate-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">

            {{-- Tot datum --}}
            <input type="date"
                name="to_date"
                value="{{ request('to_date') }}"
                class="bg-slate-700/50 border border-slate-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">

            <div class="md:col-span-4 flex gap-3">
                <button class="px-6 py-3 bg-yellow-400 hover:bg-yellow-300 text-gray-900 rounded-lg font-semibold transition">
                    Filteren
                </button>

                <a href="{{ route('maintenance.requests.index') }}"
                    class="px-6 py-3 border border-slate-600 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition">
                    Reset
                </a>
            </div>
        </form>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase text-slate-400 border-b border-slate-700">
                    <tr>
                        <th class="py-4 px-4">Nr</th>
                        <th class="py-4 px-4">Klant</th>
                        <th class="py-4 px-4">Prioriteit</th>
                        <th class="py-4 px-4">Urgentie</th>
                        <th class="py-4 px-4">Status</th>
                        <th class="py-4 px-4">Aangemaakt</th>
                        <th class="py-4 px-4"></th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-700">
                    @forelse($requests as $request)
                    <tr class="hover:bg-slate-800/50 transition">
                        <td class="py-4 px-4 font-mono text-yellow-400">
                            {{ $request->request_number }}
                        </td>

                        <td class="py-4 px-4 text-white">
                            {{ $request->customer?->displayName() ?? '-' }}
                        </td>

                        <td class="py-4 px-4 text-slate-300">
                            {{ ucfirst($request->priority) }}
                        </td>

                        <td class="py-4 px-4 text-slate-300">
                            {{ ucfirst($request->urgency) }}
                        </td>

                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold border
                                @if($request->status === 'open') bg-red-500/20 text-red-300 border-red-500/30
                                @elseif($request->status === 'planned') bg-yellow-500/20 text-yellow-300 border-yellow-500/30
                                @else bg-emerald-500/20 text-emerald-300 border-emerald-500/30
                                @endif">
                                {{ ucfirst($request->status) }}
                            </span>
                        </td>

                        <td class="py-3 px-3 text-gray-400">
                            {{ $request->created_at->format('d-m-Y') }}
                        </td>

                        <td class="py-3 px-3 text-right">
                            <a href="{{ route('maintenance.requests.show', $request) }}"
                                class="px-4 py-2 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">
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