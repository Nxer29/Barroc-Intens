@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-white">Nieuwe afspraak</h1>
        <p class="text-gray-400 mt-2">
            Plan een nieuwe afspraak voor een klant
        </p>
    </div>

    @if ($errors->any())
    <div class="rounded-lg border border-red-500 bg-red-900/20 p-4 text-red-300 mb-6">
        <ul class="list-disc ml-5 space-y-1">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('appointments.store') }}" method="POST" class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 shadow-xl p-8 space-y-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Klant</label>
                <select name="customer_id" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                    <option value="">Selecteer klant</option>
                    @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">
                        {{ $customer->company_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Type afspraak</label>
                <select name="type_id" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                    <option value="">Selecteer type</option>
                    @foreach ($types as $type)
                    <option value="{{ $type->id }}">
                        {{ $type->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Datum</label>
                <input type="date" name="scheduled_at" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Monteur</label>
                <select name="technician_id" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                    <option value="">Niet toegewezen</option>
                    @foreach ($technicians as $tech)
                    <option value="{{ $tech->id }}">
                        {{ $tech->name }}
                    </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-300 mb-2">Notities</label>
            <textarea name="notes" rows="4" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"></textarea>
        </div>

        <div class="flex justify-end gap-4 pt-4">
            <a href="{{ route('appointments.index') }}" class="px-6 py-3 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">
                Annuleren
            </a>

            <button type="submit" class="px-6 py-3 bg-yellow-400 hover:bg-yellow-300 text-gray-900 rounded-lg font-semibold transition">
                Afspraak opslaan
            </button>
        </div>

    </form>
</div>
@endsection