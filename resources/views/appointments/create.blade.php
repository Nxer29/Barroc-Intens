@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-10">

    <div>
        <h1 class="text-3xl font-bold text-white">Nieuwe afspraak</h1>
        <p class="subtext">Plan een nieuwe afspraak voor een klant</p>
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

    <form action="{{ route('appointments.store') }}" method="POST" class="card space-y-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="subtext block mb-2">Klant</label>
                <select name="customer_id" class="input">
                    <option value="">Selecteer klant</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">
                            {{ $customer->company_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="subtext block mb-2">Type afspraak</label>
                <select name="type_id" class="input">
                    <option value="">Selecteer type</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="subtext block mb-2">Datum</label>
                <input type="date" name="scheduled_at" class="input">
            </div>

            <div>
                <label class="subtext block mb-2">Monteur</label>
                <select name="technician_id" class="input">
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
            <label class="subtext block mb-2">Notities</label>
            <textarea name="notes" rows="4" class="input"></textarea>
        </div>

        <div class="flex justify-end gap-4 pt-4">
            <a href="{{ route('appointments.index') }}" class="btn-outline">
                Annuleren
            </a>

            <button type="submit" class="btn-primary">
                Afspraak opslaan
            </button>
        </div>

    </form>
</div>
@endsection
