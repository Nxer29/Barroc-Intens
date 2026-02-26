@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    @php
        $isEdit = isset($contract);
        $formAction = $isEdit ? route('contracts.update', $contract) : route('contracts.store');
    @endphp

    {{-- HEADER --}}
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-white">{{ $isEdit ? 'Contract bewerken' : 'Nieuw contract' }}</h1>
        <p class="text-gray-400 mt-2">
            {{ $isEdit ? 'Pas het contract aan' : 'Maak een nieuw contract aan voor een klant' }}
        </p>
    </div>

    @if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-500 bg-red-900/20 px-4 py-3 text-red-300">
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ $formAction }}" method="POST"
        class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-8 shadow-xl space-y-6">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Klant</label>
                <select name="customer_id" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                    @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}"
                        {{ old('customer_id', $contract->customer_id ?? null) == $customer->id ? 'selected' : '' }}>
                        {{ $customer->company_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Product</label>
                <select name="product_id" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                    @foreach ($products as $product)
                    <option value="{{ $product->id }}"
                        {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }} (€{{ number_format($product->price, 2) }})
                    </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Startdatum</label>
                <input type="date" name="start_date"
                    value="{{ old('start_date', isset($contract) && $contract->start_date ? $contract->start_date->toDateString() : '') }}"
                    class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                    @php $statusVal = old('status', $contract->status ?? 'active'); @endphp
                    <option value="active" {{ $statusVal === 'active' ? 'selected' : '' }}>Actief</option>
                    <option value="paused" {{ $statusVal === 'paused' ? 'selected' : '' }}>Gepauzeerd</option>
                    <option value="ended" {{ $statusVal === 'ended' ? 'selected' : '' }}>Beëindigd</option>
                </select>
            </div>

        </div>

        {{-- BKR CHECK --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">BKR-check status</label>
                @php $bkrVal = old('bkr_status', $contract->bkr_status ?? 'not_started'); @endphp
                <select name="bkr_status" class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                    <option value="not_started" {{ $bkrVal === 'not_started' ? 'selected' : '' }}>Niet gestart</option>
                    <option value="in_progress" {{ $bkrVal === 'in_progress' ? 'selected' : '' }}>In behandeling</option>
                    <option value="approved" {{ $bkrVal === 'approved' ? 'selected' : '' }}>Akkoord</option>
                    <option value="rejected" {{ $bkrVal === 'rejected' ? 'selected' : '' }}>Afgekeurd</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">BKR-check datum</label>
                <input type="date" name="bkr_status_date"
                    value="{{ old('bkr_status_date', isset($contract) && $contract->bkr_status_date ? $contract->bkr_status_date->toDateString() : '') }}"
                    class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Toelichting (optioneel)</label>
                <input type="text" name="bkr_note"
                    value="{{ old('bkr_note', $contract->bkr_note ?? '') }}"
                    class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                    placeholder="Bijv. referentie / reden / opmerking">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-300 mb-2">Notities</label>
            <textarea name="notes" rows="4"
                class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-slate-600 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                placeholder="Extra informatie...">{{ old('notes', $contract->notes ?? '') }}</textarea>
        </div>

        <div class="flex justify-end gap-4 pt-4">
            <a href="{{ route('contracts.index') }}" class="px-6 py-3 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">
                Annuleren
            </a>

            <button type="submit" class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-6 py-3 rounded-lg font-semibold transition">
                {{ $isEdit ? 'Opslaan' : 'Contract opslaan' }}
            </button>
        </div>

    </form>

</div>
@endsection
