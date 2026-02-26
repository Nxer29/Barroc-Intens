@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- Header --}}
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-white">Auditlogboek</h1>
        <p class="text-gray-400 mt-2">
            Volg alle acties en wijzigingen in het systeem
        </p>
    </div>

    {{-- Filters Card --}}
    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 shadow-xl overflow-hidden mb-8">

        <div class="px-6 py-4 border-b border-slate-700">
            <h2 class="text-lg font-semibold text-white">Zoeken en Filteren</h2>
        </div>

        <div class="p-6">
            <form method="GET" action="{{ route('auditlogs.index') }}" class="space-y-6">
                {{-- Search Bar --}}
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Zoeken</label>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Zoeken op actie, entiteit, ID, gebruiker..."
                        class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>

                {{-- Filters Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">

                    {{-- Gebruiker Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Gebruiker</label>
                        <select
                            name="user_id"
                            class="w-full px-3 py-2 bg-slate-700/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            <option value="">-- Alle gebruikers --</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected(request('user_id')==$user->id)>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Actie Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Actie</label>
                        <select
                            name="action"
                            class="w-full px-3 py-2 bg-slate-700/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            <option value="">-- Alle acties --</option>
                            @foreach($actions as $action)
                            <option value="{{ $action }}" @selected(request('action')==$action)>
                                {{ ucfirst($action) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Entiteit Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Entiteit</label>
                        <select
                            name="entity"
                            class="w-full px-3 py-2 bg-slate-700/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            <option value="">-- Alle entiteiten --</option>
                            @foreach($entities as $entity)
                            <option value="{{ $entity }}" @selected(request('entity')==$entity)>
                                {{ $entity }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Datum Van --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Van</label>
                        <input
                            type="date"
                            name="date_from"
                            value="{{ request('date_from') }}"
                            class="w-full px-3 py-2 bg-slate-700/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>

                    {{-- Datum Tot --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Tot</label>
                        <input
                            type="date"
                            name="date_to"
                            value="{{ request('date_to') }}"
                            class="w-full px-3 py-2 bg-slate-700/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>

                </div>

                {{-- Buttons --}}
                <div class="flex gap-3 justify-end pt-4">
                    <a
                        href="{{ route('auditlogs.index') }}"
                        class="px-6 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition">
                        Wissen
                    </a>
                    <button
                        type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                        Zoeken
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- Results Count --}}
    <div class="mb-4">
        <p class="text-gray-400 text-sm">
            Totaal: <span class="font-semibold text-white">{{ $auditLogs->total() }}</span> records
        </p>
    </div>

    {{-- Audit Logs Table --}}
    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 shadow-xl overflow-hidden">

        <div class="px-6 py-4 border-b border-slate-700">
            <h2 class="text-lg font-semibold text-white">Auditlogboek</h2>
        </div>

        @if($auditLogs->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-700 bg-slate-900/50">
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Timestamp</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Gebruiker</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Actie</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Entiteit</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">ID</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @foreach($auditLogs as $log)
                    <tr class="hover:bg-slate-800/50 transition">
                        <td class="px-6 py-4 text-sm text-gray-400">
                            {{ $log->timestamp->format('d-m-Y H:i:s') }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($log->user)
                            <div class="text-white font-medium">{{ $log->user->name }}</div>
                            <div class="text-gray-500 text-xs">{{ $log->user->email }}</div>
                            @else
                            <span class="text-gray-500 italic">Verwijderde gebruiker</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium
                                        @if($log->action === 'created')
                                            bg-green-500/15 text-green-400 border border-green-500/30
                                        @elseif($log->action === 'updated')
                                            bg-blue-500/15 text-blue-400 border border-blue-500/30
                                        @elseif($log->action === 'deleted')
                                            bg-red-500/15 text-red-400 border border-red-500/30
                                        @else
                                            bg-gray-500/15 text-gray-400 border border-gray-500/30
                                        @endif">
                                {{ ucfirst($log->action) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-white">
                            {{ $log->entity }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400">
                            {{ $log->entity_id }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-slate-700">
            {{ $auditLogs->links('pagination::tailwind') }}
        </div>
        @else
        <div class="px-6 py-12 text-center">
            <p class="text-gray-400">Geen auditlogboekeintrages gevonden</p>
        </div>
        @endif

    </div>

</div>

@endsection