@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-white">Klant bewerken</h1>
        <p class="text-gray-400 mt-2">
            Wijzig de gegevens van {{ $customer->displayName() }}
        </p>
    </div>

    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 shadow-xl p-8">
        <form method="POST" action="{{ route('customers.update', $customer) }}">
            @csrf
            @method('PUT')

            {{-- Bedrijfsnaam --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-300 mb-2">
                    Bedrijfsnaam
                </label>
                <input
                    type="text"
                    name="company_name"
                    value="{{ old('company_name', $customer->company_name) }}"
                    placeholder="Bedrijfsnaam"
                    class="w-full px-4 py-3 border border-slate-600 rounded-lg
                           text-white placeholder-slate-400 bg-slate-700/50
                           focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent" />
                @error('company_name')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Contactnaam --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-300 mb-2">
                    Contactnaam
                </label>
                <input
                    type="text"
                    name="contact_name"
                    value="{{ old('contact_name', $customer->contact_name) }}"
                    placeholder="Contactnaam"
                    class="w-full px-4 py-3 border border-slate-600 rounded-lg
                           text-white placeholder-slate-400 bg-slate-700/50
                           focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent" />
                @error('contact_name')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- E-mail en Telefoon --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">
                        E-mail
                    </label>
                    <input
                        type="email"
                        name="contact_email"
                        value="{{ old('contact_email', $customer->contact_email) }}"
                        placeholder="info@bedrijf.nl"
                        class="w-full px-4 py-3 border border-slate-600 rounded-lg
                               text-white placeholder-slate-400 bg-slate-700/50
                               focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent" />
                    @error('contact_email')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">
                        Telefoon
                    </label>
                    <input
                        type="text"
                        name="contact_phone"
                        value="{{ old('contact_phone', $customer->contact_phone) }}"
                        placeholder="0612345678"
                        class="w-full px-4 py-3 border border-slate-600 rounded-lg
                               text-white placeholder-slate-400 bg-slate-700/50
                               focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent" />
                    @error('contact_phone')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Status --}}
            <div class="mb-8">
                <label class="block text-sm font-semibold text-slate-300 mb-2">
                    Status
                </label>
                <input
                    type="text"
                    name="status"
                    value="{{ old('status', $customer->status) }}"
                    placeholder="Bijv. actief"
                    class="w-full px-4 py-3 border border-slate-600 rounded-lg
                           text-white placeholder-slate-400 bg-slate-700/50
                           focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent" />
                @error('status')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Acties --}}
            <div class="flex items-center gap-4">
                <button
                    type="submit"
                    class="bg-yellow-400 hover:bg-yellow-300
                           text-gray-900 font-semibold
                           px-6 py-3 rounded-lg transition">
                    Opslaan
                </button>

                <a
                    href="{{ route('customers.index') }}"
                    class="px-6 py-3 rounded-lg
                           border border-slate-600
                           text-slate-300 hover:bg-slate-700 transition">
                    Annuleren
                </a>
            </div>
        </form>
    </div>
</div>
@endsection