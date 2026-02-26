@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0b1220] px-4 py-6 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">

        {{-- HEADER WITH NAVIGATION --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                {{-- Previous Day Button --}}
                <a href="{{ route('maintenance.planning.day', ['date' => $previousDate->toDateString()]) }}"
                    class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-lg bg-slate-800 hover:bg-slate-700 transition text-yellow-400 hover:text-yellow-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>

                {{-- Date Display --}}
                <div class="text-center flex-1">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white">
                        {{ $date->translatedFormat('dddd') }}
                    </h1>
                    <p class="text-base sm:text-lg text-gray-400 mt-1">
                        {{ $date->translatedFormat('d MMMM Y') }}
                    </p>
                </div>

                {{-- Next Day Button --}}
                <a href="{{ route('maintenance.planning.day', ['date' => $nextDate->toDateString()]) }}"
                    class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-lg bg-slate-800 hover:bg-slate-700 transition text-yellow-400 hover:text-yellow-300">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            {{-- View Toggle Buttons --}}
            <div class="flex justify-center gap-2">
                <button class="px-4 py-2 bg-yellow-400 text-gray-900 font-semibold rounded-lg text-xs sm:text-sm">
                    🔧 Dag
                </button>
                <a href="{{ route('maintenance.planning.week', ['date' => $date->toDateString()]) }}"
                    class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-gray-300 font-semibold rounded-lg text-xs sm:text-sm transition">
                    📊 Week
                </a>
            </div>
        </div>

        {{-- MAINTENANCE REQUESTS CONTAINER --}}
        <div class="space-y-4">
            @if($requests->isEmpty())
            {{-- Empty State --}}
            <div class="bg-gradient-to-br from-slate-800/50 to-slate-900/50 border border-slate-700 rounded-2xl p-12 text-center">
                <div class="text-5xl mb-4">🔧</div>
                <h2 class="text-xl sm:text-2xl font-bold text-white mb-2">Geen onderhoud vandaag</h2>
                <p class="text-sm sm:text-base text-gray-400">
                    Er is geen gepland onderhoud voor deze dag
                </p>
            </div>
            @else
            {{-- Requests List --}}
            @foreach($requests as $request)
            <a href="{{ route('maintenance.requests.show', $request) }}"
                class="block no-underline">
                <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 hover:border-yellow-400/50 rounded-xl p-4 sm:p-6 transition transform hover:scale-[1.02] hover:shadow-lg cursor-pointer">

                    {{-- Time & Priority --}}
                    <div class="flex items-start justify-between mb-3">
                        <div class="inline-flex items-center gap-2 bg-yellow-400/20 text-yellow-300 px-3 py-1 rounded-lg text-xs sm:text-sm font-semibold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00-.293.707l-2.828 2.829a1 1 0 101.415 1.415L8 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            {{ $request->scheduled_at?->format('H:i') ?? 'TBD' }}
                        </div>

                        {{-- Priority Badge --}}
                        <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-lg
                                    @if($request->priority === 'high')
                                        bg-red-900/50 text-red-300
                                    @elseif($request->priority === 'medium')
                                        bg-yellow-900/50 text-yellow-300
                                    @else
                                        bg-green-900/50 text-green-300
                                    @endif
                                ">
                            {{ ucfirst($request->priority) }}
                        </span>
                    </div>

                    {{-- Type / Issue --}}
                    <p class="text-xs sm:text-sm text-gray-400 font-semibold mb-2">
                        STORING
                    </p>

                    {{-- Customer Name --}}
                    <h3 class="text-base sm:text-lg font-bold text-white mb-2">
                        {{ $request->customer?->company_name ?? 'Onbekende klant' }}
                    </h3>

                    {{-- Product --}}
                    @if($request->product)
                    <p class="text-xs sm:text-sm text-yellow-300 mb-3">
                        {{ $request->product->name }}
                    </p>
                    @endif

                    {{-- Issue Preview --}}
                    @if($request->issue_description)
                    <p class="text-xs sm:text-sm text-gray-400 line-clamp-2 mb-3">
                        {{ $request->issue_description }}
                    </p>
                    @endif

                    {{-- Status & Urgency Badges --}}
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-block text-xs px-2 py-1 bg-blue-900/50 text-blue-300 rounded font-semibold">
                            {{ ucfirst($request->status) }}
                        </span>
                        <span class="inline-block text-xs px-2 py-1 bg-purple-900/50 text-purple-300 rounded font-semibold">
                            {{ ucfirst($request->urgency) }}
                        </span>
                    </div>

                    {{-- Click to view details hint --}}
                    <div class="flex items-center justify-between mt-3">
                        <span class="text-xs text-gray-500">Tap voor details →</span>
                    </div>
                </div>
            </a>
            @endforeach
            @endif
        </div>

        {{-- Stats --}}
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-gradient-to-br from-slate-800/50 to-slate-900/50 border border-slate-700 rounded-2xl p-5 sm:p-6 text-center">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-2 font-semibold">Totaal</p>
                <p class="text-3xl sm:text-4xl font-bold text-yellow-400">{{ $requests->count() }}</p>
            </div>
            <div class="bg-gradient-to-br from-slate-800/50 to-slate-900/50 border border-slate-700 rounded-2xl p-5 sm:p-6 text-center">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-2 font-semibold">Hoog prioriteit</p>
                <p class="text-3xl sm:text-4xl font-bold text-red-400">{{ $requests->where('priority', 'high')->count() }}</p>
            </div>
            <div class="bg-gradient-to-br from-slate-800/50 to-slate-900/50 border border-slate-700 rounded-2xl p-5 sm:p-6 text-center">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-2 font-semibold">Gepland</p>
                <p class="text-3xl sm:text-4xl font-bold text-blue-400">{{ $requests->where('status', 'planned')->count() }}</p>
            </div>
        </div>

    </div>
</div>
@endsection