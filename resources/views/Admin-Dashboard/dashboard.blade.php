@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- Header --}}
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-white">Admin dashboard</h1>
        <p class="text-gray-400 mt-1">
            Overzicht van gebruikers, rollen en producten
        </p>
    </div>

    {{-- KPI CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">

        {{-- Gebruikers --}}
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700 shadow-lg">
            <p class="text-sm text-gray-400 mb-2">Gebruikers</p>
            <p class="text-4xl font-bold text-white mb-4">
                {{ $userCount ?? 0 }}
            </p>

            <a href="{{ route('admin-dashboard.users') }}"
               class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-semibold px-4 py-2 rounded-lg transition">
                Gebruikers beheren
            </a>
        </div>

        {{-- Rollen --}}
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700 shadow-lg">
            <p class="text-sm text-gray-400 mb-2">Rollen</p>
            <p class="text-4xl font-bold text-white">
                {{ $roles->count() ?? 0 }}
            </p>
        </div>

        {{-- Producten --}}
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700 shadow-lg">
            <p class="text-sm text-gray-400 mb-2">Producten</p>
            <p class="text-4xl font-bold text-white mb-4">
                {{ $productCount ?? 0 }}
            </p>

            <a href="{{ route('products.index') }}"
               class="text-yellow-400 hover:text-yellow-300 font-medium transition">
                Producten bekijken →
            </a>
        </div>

        {{-- Categorieën --}}
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700 shadow-lg">
            <p class="text-sm text-gray-400 mb-2">Categorieën</p>
            <p class="text-4xl font-bold text-white">
                {{ $productCategoryCount ?? 0 }}
            </p>
        </div>
    </div>

    {{-- DETAIL SECTIE --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">

        {{-- Gebruikers per rol --}}
        <div class="bg-slate-900 rounded-2xl p-6 border border-slate-700 shadow-lg">
            <h2 class="text-xl font-semibold text-white mb-4">
                Gebruikers per rol
            </h2>

            <div class="space-y-3">
                @foreach($roleCounts ?? [] as $roleName => $count)
                    <div class="flex items-center justify-between bg-slate-800 rounded-lg px-4 py-3">
                        <span class="text-gray-200">{{ $roleName }}</span>
                        <span class="bg-yellow-400 text-gray-900 text-sm font-bold px-3 py-1 rounded-full">
                            {{ $count }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Placeholder voor grafiek / metrics --}}
        <div class="bg-slate-900 rounded-2xl p-6 border border-slate-700 shadow-lg flex items-center justify-center text-gray-400">
            <div class="text-center">
                <p class="text-lg font-semibold text-white mb-2">Analytics</p>
                <p class="text-sm">
                    Hier kun je later grafieken plaatsen<br>
                    (gebruikersgroei, activiteit, etc.)
                </p>
            </div>
        </div>

    </div>

</div>
@endsection
