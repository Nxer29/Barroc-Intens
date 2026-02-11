@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">

    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-white">Nieuw contract</h1>
        <p class="subtext">Maak een nieuw contract aan</p>
    </div>

    @if ($errors->any())
        <div class="rounded-lg border border-red-500/40 bg-red-500/10 p-4 text-red-300">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contracts.store') }}" method="POST"
          class="card space-y-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="subtext block mb-2">Klant</label>
                <select name="customer_id" class="input">
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}"
                            {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->company_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="subtext block mb-2">Product</label>
                <select name="product_id" class="input">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}"
                            {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} (€{{ number_format($product->price, 2) }})
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="subtext block mb-2">Startdatum</label>
                <input type="date" name="start_date"
                       value="{{ old('start_date') }}"
                       class="input">
            </div>

            <div>
                <label class="subtext block mb-2">Status</label>
                <select name="status" class="input">
                    <option value="active">Actief</option>
                    <option value="paused">Gepauzeerd</option>
                    <option value="ended">Beëindigd</option>
                </select>
            </div>

        </div>

        <div>
            <label class="subtext block mb-2">Notities</label>
            <textarea name="notes" rows="4"
                      class="input"
                      placeholder="Extra informatie...">{{ old('notes') }}</textarea>
        </div>

        <div class="flex justify-end gap-4 pt-4">
            <a href="{{ route('contracts.index') }}" class="btn-outline">
                Annuleren
            </a>

            <button type="submit" class="btn-primary">
                Contract opslaan
            </button>
        </div>

    </form>

</div>
@endsection
