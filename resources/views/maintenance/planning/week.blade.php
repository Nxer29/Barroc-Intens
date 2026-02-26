@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 px-2 py-4 sm:px-6 sm:py-6">
    <div class="max-w-7xl mx-auto">

        {{-- HEADER WITH NAVIGATION --}}
        <div class="mb-6 sm:mb-8">
            <div class="flex items-center justify-between mb-4 gap-2">
                {{-- Previous Week Button --}}
                <a href="{{ route('maintenance.planning.week', ['date' => $previousWeekStart->toDateString()]) }}"
                    class="inline-flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-slate-700 hover:bg-yellow-400 transition text-yellow-400 hover:text-slate-900 font-bold text-xl">
                    ←
                </a>

                {{-- Week Display --}}
                <div class="text-center flex-1 px-2">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white leading-tight">
                        Week {{ $weekStart->weekOfYear }}
                    </h1>
                    <p class="text-xs sm:text-sm text-yellow-400 font-semibold mt-1">
                        {{ $weekStart->format('d F') }} - {{ $weekEnd->format('d F Y') }}
                    </p>
                </div>

                {{-- Next Week Button --}}
                <a href="{{ route('maintenance.planning.week', ['date' => $nextWeekStart->toDateString()]) }}"
                    class="inline-flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-slate-700 hover:bg-yellow-400 transition text-yellow-400 hover:text-slate-900 font-bold text-xl">
                    →
                </a>
            </div>

            {{-- View Toggle Buttons --}}
            <div class="flex justify-center gap-3">
                <a href="{{ route('maintenance.planning.day', ['date' => $weekStart->toDateString()]) }}"
                    class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-yellow-400 font-bold rounded-xl text-xs sm:text-base transition">
                    🔧 Dag
                </a>
                <button class="px-6 py-3 bg-yellow-400 text-slate-900 font-bold rounded-xl text-xs sm:text-base transition hover:shadow-lg">
                    📊 Week
                </button>
            </div>
        </div>

        {{-- WEEK GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            @php
            $daysOfWeek = [
            0 => ['name' => 'Maandag', 'abbr' => 'Ma'],
            1 => ['name' => 'Dinsdag', 'abbr' => 'Di'],
            2 => ['name' => 'Woensdag', 'abbr' => 'Wo'],
            3 => ['name' => 'Donderdag', 'abbr' => 'Do'],
            4 => ['name' => 'Vrijdag', 'abbr' => 'Vr'],
            5 => ['name' => 'Zaterdag', 'abbr' => 'Za'],
            6 => ['name' => 'Zondag', 'abbr' => 'Zo'],
            ];

            // Group requests by day
            $requestsByDay = $requests->groupBy(function($request) {
            return $request->scheduled_at?->toDateString() ?? 'unknown';
            });
            @endphp

            @for ($i = 0; $i < 7; $i++)
                @php
                $currentDay=$weekStart->copy()->addDays($i);
                $dayRequests = $requestsByDay[$currentDay->toDateString()] ?? collect();
                $isToday = $currentDay->isToday();
                @endphp
                <div class="flex flex-col">
                    {{-- Day Header --}}
                    <div class="@if($isToday) bg-yellow-400 @else bg-slate-700 @endif rounded-t-xl p-3 sm:p-4 text-center mb-0">
                        <p class="text-xs font-bold @if($isToday) text-slate-900 @else text-gray-300 @endif uppercase tracking-widest">
                            {{ $daysOfWeek[$i]['abbr'] }}
                        </p>
                        <p class="text-lg sm:text-xl font-bold @if($isToday) text-slate-900 @else text-white @endif">
                            {{ $currentDay->format('d') }}
                        </p>
                    </div>

                    {{-- Requests Container --}}
                    <div class="bg-slate-800/60 border border-slate-700 rounded-b-xl p-2 sm:p-3 flex-1 space-y-2 overflow-y-auto max-h-80 sm:max-h-96">
                        @if($dayRequests->isEmpty())
                        <div class="h-full flex items-center justify-center">
                            <p class="text-xs text-gray-500 text-center">Geen onderhoud</p>
                        </div>
                        @else
                        @foreach($dayRequests as $request)
                        <a href="{{ route('maintenance.requests.show', $request) }}"
                            class="block touch-manipulation focus:outline-none no-underline">
                            <div class="bg-gradient-to-br from-slate-700/80 to-slate-800 border border-slate-600 hover:border-yellow-400 rounded-lg p-2 sm:p-3 transition hover:scale-[1.02] active:scale-95 cursor-pointer">

                                {{-- Time --}}
                                <div class="flex items-center gap-1 mb-1">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00-.293.707l-2.828 2.829a1 1 0 101.415 1.415L8 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs sm:text-sm font-bold text-yellow-300">
                                        {{ $request->scheduled_at?->format('H:i') ?? 'TBD' }}
                                    </span>
                                </div>

                                {{-- Customer Name (truncated) --}}
                                <p class="text-xs sm:text-sm font-semibold text-white truncate">
                                    {{ \Str::limit($request->customer?->company_name ?? 'Onbekend', 20) }}
                                </p>

                                {{-- Priority Badge --}}
                                <div class="mt-1 flex gap-1">
                                    <span class="inline-block text-xs px-2 py-0.5 rounded font-bold
                                        @if($request->priority === 'high') bg-red-900/60 text-red-200
                                        @elseif($request->priority === 'medium') bg-yellow-900/60 text-yellow-200
                                        @else bg-green-900/60 text-green-200
                                        @endif">
                                        {{ ucfirst($request->priority) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                        @endif
                    </div>
                </div>
                @endfor
        </div>

        {{-- Stats --}}
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-gradient-to-br from-slate-800/50 to-slate-900/50 border border-slate-700 rounded-2xl p-5 sm:p-6 text-center">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-2 font-semibold">Totaal onderhoud</p>
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