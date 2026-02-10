@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="mb-12">
        <h1 class="text-3xl font-bold text-white">Admin dashboard</h1>
        <p class="text-gray-400 mt-1">
            Overzicht van gebruikers, rollen en producten
        </p>
    </div>

    {{-- KPI CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-14">
        @php
            $card = "bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl p-6 border border-slate-700 shadow-xl";
        @endphp

        <div class="{{ $card }}">
            <p class="text-sm text-gray-400 mb-2">Gebruikers</p>
            <p class="text-4xl font-bold text-white mb-4">{{ $userCount }}</p>
            <a href="{{ route('admin-dashboard.users') }}"
               class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-semibold px-4 py-2 rounded-lg">
                Gebruikers beheren
            </a>
        </div>

        <div class="{{ $card }}">
            <p class="text-sm text-gray-400 mb-2">Rollen</p>
            <p class="text-4xl font-bold text-white">{{ $roles->count() }}</p>
        </div>

        <div class="{{ $card }}">
            <p class="text-sm text-gray-400 mb-2">Producten</p>
            <p class="text-4xl font-bold text-white mb-4">{{ $productCount }}</p>
            <a href="{{ route('products.index') }}"
               class="text-yellow-400 hover:text-yellow-300 font-medium">
                Producten bekijken →
            </a>
        </div>

        <div class="{{ $card }}">
            <p class="text-sm text-gray-400 mb-2">Categorieën</p>
            <p class="text-4xl font-bold text-white">{{ $productCategoryCount }}</p>
        </div>
    </div>

    {{-- CHARTS --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-12">

        <div class="bg-slate-900 rounded-2xl p-6 border border-slate-700 shadow-xl">
            <h2 class="text-lg font-semibold text-white mb-4">Gebruikers per rol</h2>
            <canvas id="rolesChart" height="220"></canvas>
        </div>

        <div class="xl:col-span-2 bg-slate-900 rounded-2xl p-6 border border-slate-700 shadow-xl">
            <h2 class="text-lg font-semibold text-white mb-4">Gebruikersgroei</h2>
            <canvas id="usersChart" height="110"></canvas>
        </div>
    </div>

    {{-- EXTRA --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">

        <div class="bg-slate-900 rounded-2xl p-6 border border-slate-700 shadow-xl">
            <h2 class="text-lg font-semibold text-white mb-4">Gebruikers per rol (details)</h2>

            <div class="space-y-3">
                @foreach($roleCounts as $role => $count)
                    <div class="flex justify-between bg-slate-800 px-4 py-3 rounded-lg">
                        <span class="text-gray-200">{{ ucfirst($role) }}</span>
                        <span class="bg-yellow-400 text-gray-900 text-sm font-bold px-3 py-1 rounded-full">
                            {{ $count }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-slate-900 rounded-2xl p-6 border border-slate-700 shadow-xl">
            <h2 class="text-lg font-semibold text-white mb-4">Producten per categorie</h2>
            <canvas id="productsChart" height="180"></canvas>
        </div>

    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* USERS PER ROLE */
new Chart(document.getElementById('rolesChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(array_keys($roleCounts)) !!},
        datasets: [{
            data: {!! json_encode(array_values($roleCounts)) !!},
            backgroundColor: ['#facc15', '#38bdf8', '#a78bfa', '#34d399']
        }]
    },
    options: {
        plugins: { legend: { labels: { color: '#e5e7eb' }}}
    }
});

/* USER GROWTH */
new Chart(document.getElementById('usersChart'), {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mrt','Apr','Mei','Jun'],
        datasets: [{
            label: 'Gebruikers',
            data: [1,2,3,3,4,{{ $userCount }}],
            borderColor: '#facc15',
            tension: 0.4
        }]
    },
    options: {
        scales: {
            x: { ticks: { color: '#9ca3af' }},
            y: { ticks: { color: '#9ca3af' }}
        },
        plugins: { legend: { labels: { color: '#e5e7eb' }}}
    }
});

/* PRODUCTS PER CATEGORY */
new Chart(document.getElementById('productsChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($productPerCategory->pluck('name')) !!},
        datasets: [{
            data: {!! json_encode($productPerCategory->pluck('products_count')) !!},
            backgroundColor: '#38bdf8',
            borderRadius: 8
        }]
    },
    options: {
        scales: {
            x: { ticks: { color: '#9ca3af' }, grid: { display: false }},
            y: { ticks: { color: '#9ca3af' }, grid: { color: '#1f2937' }}
        },
        plugins: { legend: { display: false }}
    }
});
</script>
@endsection
