@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-10">

    <div>
        <h1 class="text-3xl font-bold text-white">Afspraak bewerken</h1>
        <p class="subtext">Pas de gegevens van deze afspraak aan</p>
    </div>

    @if ($errors->any())
        <div class="rounded-lg border border-red-500/40 bg-red-500/10 p-4 text-red-300">
            <ul class="list-disc ml-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('appointments.update', $appointment) }}"
          method="POST"
          class="card space-y-8">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="subtext block mb-2">Klant</label>
                <select name="customer_id" class="input">
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}"
                            {{ old('customer_id', $appointment->customer_id) == $customer->id ? 'selected' : '' }}>
                            {{ $customer->company_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="subtext block mb-2">Type afspraak</label>
                <select name="type_id" class="input">
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}"
                            {{ old('type_id', $appointment->type_id) == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="subtext block mb-2">Datum</label>
                <input type="date"
                       name="scheduled_at"
                       value="{{ old('scheduled_at', \Carbon\Carbon::parse($appointment->scheduled_at)->format('Y-m-d')) }}"
                       class="input">
            </div>

            <div>
                <label class="subtext block mb-2">Monteur</label>
                <select name="technician_id" class="input">
                    <option value="">Niet toegewezen</option>
                    @foreach ($technicians as $tech)
                        <option value="{{ $tech->id }}"
                            {{ old('technician_id', $appointment->technician_id) == $tech->id ? 'selected' : '' }}>
                            {{ $tech->name }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div>
            <label class="subtext block mb-2">Status</label>
            <select name="status" class="input">
                @php
                    $statuses = [
                        'pending' => 'In afwachting',
                        'planned' => 'Ingepland',
                        'completed' => 'Voltooid',
                        'cancelled' => 'Geannuleerd'
                    ];
                @endphp

                @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}"
                        {{ old('status', $appointment->status) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="subtext block mb-2">Notities</label>
            <textarea name="notes" rows="4" class="input">
                {{ old('notes', $appointment->notes) }}
            </textarea>
        </div>

        <div class="flex justify-end gap-4 pt-4">
            <a href="{{ route('appointments.index') }}" class="btn-outline">
                Terug
            </a>

            <button type="submit" class="btn-primary">
                Wijzigingen opslaan
            </button>
        </div>

    </form>
</div>
@endsection
