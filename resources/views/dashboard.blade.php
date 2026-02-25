@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-white">Dashboard</h1>
        <p class="text-gray-400 mt-2">
            Overzicht van je werkzaamheden en statistieken
        </p>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-14">
        @foreach($widgets as $widget)
        <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl p-6 border border-slate-700 shadow-xl hover:shadow-2xl hover:border-slate-600 transition-all duration-300">
            <p class="text-sm uppercase tracking-wider text-slate-400 font-semibold mb-2">
                {{ $widget['title'] }}
            </p>

            <p class="text-4xl font-bold text-white mb-6">
                {{ $widget['value'] }}
            </p>

            @if(!empty($widget['route']))
            <a href="{{ route($widget['route']) }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-yellow-400 hover:text-yellow-300 transition">
                Bekijken <span>→</span>
            </a>
            @endif
        </div>
        @endforeach
    </div>

    {{-- CHART + QUICK STATS --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-12">

        {{-- ACTIVITY CHART --}}
        <div class="xl:col-span-2 bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl p-6 border border-slate-700 shadow-xl">
            <h2 class="text-lg font-semibold text-white mb-4">
                Activiteit afgelopen week
            </h2>

            <!-- FIX: vaste hoogte -->
            <div class="relative h-[260px]">
                <canvas id="activityChart"></canvas>
            </div>
        </div>


        {{-- QUICK STATS --}}
        <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl p-6 border border-slate-700 shadow-xl">
            <h2 class="text-lg font-semibold text-white mb-6">
                Snelle statistieken
            </h2>

            <div class="space-y-4">
                <div class="flex justify-between items-center pb-4 border-b border-slate-700">
                    <span class="text-slate-300">Vandaag</span>
                    <span class="text-2xl font-bold text-yellow-400">
                        {{ $appointmentsToday }}
                    </span>
                </div>

                <div class="flex justify-between items-center pb-4 border-b border-slate-700">
                    <span class="text-slate-300">Openstaande</span>
                    <span class="text-2xl font-bold text-blue-400">
                        {{ $openTasks }}
                    </span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-slate-300">Berichten</span>
                    <span class="text-2xl font-bold text-emerald-400">
                        {{ $newMessages ?? 0 }}
                    </span>
                </div>
            </div>
        </div>

    </div>

    {{-- RECENT ACTIVITY + QUICK ACTIONS --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">

        {{-- RECENT ACTIVITY --}}
        @if(count($recentActivity) > 0)
        <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl p-6 border border-slate-700 shadow-xl">
            <h2 class="text-lg font-semibold text-white mb-6">
                Recente activiteit
            </h2>

            <div class="space-y-4">
                @foreach($recentActivity as $activity)
                <div class="flex items-center gap-4 pb-4 border-b border-slate-700 last:border-0">
                    <div class="w-2 h-2 rounded-full mt-1
                        @if($activity['color'] === 'yellow') bg-yellow-400
                        @elseif($activity['color'] === 'blue') bg-blue-400
                        @elseif($activity['color'] === 'emerald') bg-emerald-400
                        @endif">
                    </div>
                    <div>
                        <p class="text-sm text-white font-medium">
                            {{ $activity['type'] }}
                        </p>
                        <p class="text-xs text-slate-400">
                            {{ $activity['title'] }} · {{ $activity['time'] }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- QUICK ACTIONS --}}
        <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl p-6 border border-slate-700 shadow-xl {{ count($recentActivity) > 0 ? '' : 'xl:col-span-2' }}">
            <h2 class="text-lg font-semibold text-white mb-6">
                Snelle acties
            </h2>

            <div class="space-y-3">
                {{-- Planning link voor maintenance accounts --}}
                @if(auth()->user()->hasRole('maintenance'))
                <a href="{{ route('calendar.day') }}" class="block p-4 bg-gradient-to-r from-yellow-500 to-yellow-400 hover:from-yellow-600 hover:to-yellow-500 rounded-xl text-slate-900 font-bold transition shadow-lg">
                    Mijn Planning
                </a>
                @endif

                <a href="{{ route('invoices.overview') }}" class="block p-4 bg-slate-700/50 hover:bg-slate-700 rounded-xl text-white transition">
                    Facturen overzicht
                </a>
                @if(auth()->user()->hasRole('Admin'))
                <a href="{{ route('invoices.create') }}" class="block p-4 bg-slate-700/50 hover:bg-slate-700 rounded-xl text-white transition">
                    Nieuwe factuur
                </a>
                <a href="{{ route('appointments.create') }}" class="block p-4 bg-slate-700/50 hover:bg-slate-700 rounded-xl text-white transition">
                    Nieuwe afspraak
                </a>
                <a href="{{ route('contracts.create') }}" class="block p-4 bg-slate-700/50 hover:bg-slate-700 rounded-xl text-white transition">
                    Nieuw contract
                </a>
                <a href="{{ route('customers.create') }}" class="block p-4 bg-slate-700/50 hover:bg-slate-700 rounded-xl text-white transition">
                    Nieuwe klant
                </a>
                <a href="{{ route('quotes.overview') }}" class="block p-4 bg-slate-700/50 hover:bg-slate-700 rounded-xl text-white transition">
                    Offertes beheren
                </a>
                @endif
            </div>
        </div>

    </div>

</div>

{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('activityChart');

    if (ctx) {
        const activityData = @json($activityData);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za', 'Zo'],
                datasets: [{
                    label: 'Afspraken',
                    data: activityData,
                    borderColor: '#facc15',
                    backgroundColor: 'rgba(250, 204, 21, 0.12)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#facc15',
                    pointBorderColor: '#0f172a',
                    pointBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // 🔥 FIX
                plugins: {
                    legend: {
                        labels: {
                            color: '#e5e7eb',
                            font: {
                                weight: '600'
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#9ca3af'
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#9ca3af',
                            stepSize: 1
                        },
                        grid: {
                            color: '#1f2937'
                        }
                    }
                }
            }
        });
    }
</script>

@endsection