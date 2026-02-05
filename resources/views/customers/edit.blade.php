@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-8">
    <h1 class="text-3xl font-bold text-yellow-400 mb-8">
        Klant bewerken
    </h1>

    <div class="bg-white rounded-xl shadow-lg p-8">
        <form method="POST" action="{{ route('customers.update', $customer) }}">
            @csrf
            @method('PUT')

            {{-- Bedrijfsnaam --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Bedrijfsnaam
                </label>
                <input
                    type="text"
                    name="company_name"
                    value="{{ old('company_name', $customer->company_name) }}"
                    placeholder="Bedrijfsnaam"
                    class="w-full px-4 py-2 border rounded-lg
                           text-gray-900 placeholder-gray-400 bg-white
                           focus:outline-none focus:ring-2 focus:ring-yellow-400" />
                @error('company_name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Contactnaam --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Contactnaam
                </label>
                <input
                    type="text"
                    name="contact_name"
                    value="{{ old('contact_name', $customer->contact_name) }}"
                    placeholder="Contactnaam"
                    class="w-full px-4 py-2 border rounded-lg
                           text-gray-900 placeholder-gray-400 bg-white
                           focus:outline-none focus:ring-2 focus:ring-yellow-400" />
                @error('contact_name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- E-mail en Telefoon --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        E-mail
                    </label>
                    <input
                        type="email"
                        name="contact_email"
                        value="{{ old('contact_email', $customer->contact_email) }}"
                        placeholder="info@bedrijf.nl"
                        class="w-full px-4 py-2 border rounded-lg
                               text-gray-900 placeholder-gray-400 bg-white
                               focus:outline-none focus:ring-2 focus:ring-yellow-400" />
                    @error('contact_email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Telefoon
                    </label>
                    <input
                        type="text"
                        name="contact_phone"
                        value="{{ old('contact_phone', $customer->contact_phone) }}"
                        placeholder="0612345678"
                        class="w-full px-4 py-2 border rounded-lg
                               text-gray-900 placeholder-gray-400 bg-white
                               focus:outline-none focus:ring-2 focus:ring-yellow-400" />
                    @error('contact_phone')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Status --}}
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Status
                </label>
                <input
                    type="text"
                    name="status"
                    value="{{ old('status', $customer->status) }}"
                    placeholder="Bijv. actief"
                    class="w-full px-4 py-2 border rounded-lg
                           text-gray-900 placeholder-gray-400 bg-white
                           focus:outline-none focus:ring-2 focus:ring-yellow-400" />
                @error('status')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Acties --}}
            <div class="flex items-center gap-4">
                <button
                    type="submit"
                    class="bg-yellow-400 hover:bg-yellow-500
                           text-black font-semibold
                           px-6 py-2 rounded-lg transition">
                    Opslaan
                </button>

                <a
                    href="{{ route('customers.index') }}"
                    class="px-6 py-2 rounded-lg
                           border border-gray-300
                           text-gray-700 hover:bg-gray-100 transition">
                    Annuleren
                </a>
            </div>
        </form>
    </div>
</div>
@endsection