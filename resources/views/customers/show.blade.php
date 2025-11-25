@extends('layouts.app')

@section('content')
<div class="w-full max-w-4xl mx-auto py-8">
    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-900/60 border border-green-500 p-4 text-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-900 rounded-2xl border border-yellow-400/40 p-6 shadow-lg">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold text-yellow-400 mb-1">{{ $customer->company_name }}</h1>
                <p class="text-sm text-gray-400">Klant ID: #{{ $customer->id }}</p>
            </div>

            <div class="text-right">
                <a href="{{ route('customers.create') }}" class="inline-block px-4 py-2 bg-yellow-400 text-gray-900 rounded-lg font-medium hover:opacity-90">Nieuwe klant</a>
            </div>
        </div>

        <hr class="my-4 border-gray-800">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-300">
            <div>
                <p class="mb-2"><span class="font-semibold text-gray-200">Contactpersoon:</span> {{ $customer->contact_name ?? '-' }}</p>
                <p class="mb-2"><span class="font-semibold text-gray-200">Email:</span> {{ $customer->contact_email ?? '-' }}</p>
                <p class="mb-2"><span class="font-semibold text-gray-200">Telefoon:</span> {{ $customer->contact_phone ?? '-' }}</p>
            </div>

            <div>
                <p class="mb-2"><span class="font-semibold text-gray-200">Status:</span> {{ $customer->status ?? '-' }}</p>
                <p class="mb-2"><span class="font-semibold text-gray-200">Aangemaakt door (user id):</span> {{ $customer->created_by ?? '-' }}</p>
            </div>
        </div>

        <hr class="my-4 border-gray-800">

        <div class="text-sm text-gray-400">
            <p class="mb-2"><span class="font-semibold text-gray-200">Invoice address id:</span>
                @if($customer->invoice_address_id)
                    @if(is_numeric($customer->invoice_address_id))
                        <a href="{{ url('/addresses/' . $customer->invoice_address_id) }}" class="text-yellow-300 hover:underline">#{{ $customer->invoice_address_id }}</a>
                    @else
                        {{ $customer->invoice_address_id }}
                    @endif
                @else
                    -
                @endif
            </p>

            <p class="mb-2"><span class="font-semibold text-gray-200">Delivery address id:</span>
                @if($customer->delivery_address_id)
                    @if(is_numeric($customer->delivery_address_id))
                        <a href="{{ url('/addresses/' . $customer->delivery_address_id) }}" class="text-yellow-300 hover:underline">#{{ $customer->delivery_address_id }}</a>
                    @else
                        {{ $customer->delivery_address_id }}
                    @endif
                @else
                    -
                @endif
            </p>

            <p class="mb-2"><span class="font-semibold text-gray-200">Bron:</span>
                {{ $customer->source ? ucfirst($customer->source) : '-' }}
                @if($customer->source_url)
                    — <a href="{{ $customer->source_url }}" target="_blank" class="text-yellow-300 hover:underline">bron</a>
                @endif
            </p>
        </div>

        <div class="mt-6 flex gap-3">
            <a href="{{ route('customers.create') }}" class="px-4 py-2 bg-gray-800 border border-yellow-400/30 text-yellow-300 rounded-lg hover:bg-gray-850">Aanmaken</a>
            <a href="{{ url('/') }}" class="px-4 py-2 border border-gray-700 text-gray-300 rounded-lg hover:bg-gray-850">Terug</a>
        </div>
    </div>
</div>
@endsection