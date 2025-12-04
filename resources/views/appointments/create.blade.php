@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Titel --}}
    <h1 class="text-3xl font-bold text-yellow-400 mb-6">
        Nieuwe afspraak inplannen
    </h1>

    {{-- Fouten --}}
    @if ($errors->any())
        <div class="bg-red-800/40 border border-red-500 text-red-300 p-4 rounded-lg mb-6">
            <strong>Er zijn fouten:</strong>
            <ul class="mt-2 list-disc ml-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulier --}}
    <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Rij 1: klant + type --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Klant --}}
            <div>
                <label class="block text-sm text-gray-300 mb-1">Klant</label>
                <select name="customer_id"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:ring-yellow-400">

                    <option value="">-- Kies klant --</option>

                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->company_name }}
                            @if($customer->contact_name)
                                — {{ $customer->contact_name }}
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Type afspraak --}}
            <div>
                <label class="block text-sm text-gray-300 mb-1">Type afspraak</label>
                <select name="type_id"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:ring-yellow-400">
                    <option value="">-- Kies type --</option>

                    @foreach ($types as $type)
                        <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- Rij 2: datum + monteur --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Datum --}}
            <div>
                <label class="block text-sm text-gray-300 mb-1">Datum</label>
                <input type="date" name="scheduled_at"
                       value="{{ old('scheduled_at') }}"
                       class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:ring-yellow-400">
            </div>

            {{-- Monteur --}}
            <div>
                <label class="block text-sm text-gray-300 mb-1">Monteur</label>
                <select name="technician_id"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:ring-yellow-400">

                    <option value="">-- Kies monteur --</option>

                    @foreach ($technicians as $tech)
                        <option value="{{ $tech->id }}" {{ old('technician_id') == $tech->id ? 'selected' : '' }}>
                            {{ $tech->name }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- Beschrijving --}}
        <div>
            <label class="block text-sm text-gray-300 mb-1">Beschrijving (optioneel)</label>
            <textarea name="notes" rows="4"
                      class="w-full bg-gray-900 border border-gray-700 rounded-lg p-3 text-white focus:ring-yellow-400"
                      placeholder="Geef aanvullende informatie over de afspraak...">{{ old('notes') }}</textarea>
        </div>

        {{-- Verzendknop --}}
        <button class="bg-yellow-400 text-black px-6 py-3 rounded-lg font-semibold hover:bg-yellow-500 transition">
            Opslaan
        </button>

    </form>
</div>

@endsection
