@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-white">Notities</h1>
        <p class="text-gray-400 mt-2">
            Beheer notities per klant
        </p>
    </div>

    @if(session('success'))
    <div class="mb-6 rounded-lg bg-emerald-900/20 border border-emerald-500 p-4 text-emerald-300">{{ session('success') }}</div>
    @endif

    <!-- Toolbar -->
    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 p-6 mb-6 shadow-xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <!-- Alle notities -->
                <a href="{{ route('notes.index') }}"
                    class="px-4 py-2 rounded-lg font-medium transition {{ !request()->filled('customer_id') ? 'bg-yellow-400 text-gray-900' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' }}">
                    Alle notities
                </a>

                <!-- Per klant -->
                <form method="GET" action="{{ route('notes.index') }}" class="flex items-center gap-2">
                    <label for="customer_id_toolbar" class="sr-only">Per klant</label>
                    <select id="customer_id_toolbar" name="customer_id" class="bg-slate-700/50 border border-slate-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                        <option value="">Per klant…</option>
                        @foreach($customers as $c)
                        <option value="{{ $c->id }}" @selected(request('customer_id')==$c->id)>{{ $c->company_name ?? $c->contact_name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-medium transition">Toon</button>
                </form>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-sm text-slate-300">Totaal: <span class="font-semibold text-yellow-400">{{ $notes->total() }}</span></div>

                <details class="group">
                    <summary class="px-4 py-2 rounded-lg bg-slate-700 hover:bg-slate-600 text-yellow-400 cursor-pointer list-none transition">Nieuwe notitie</summary>

                    <div class="mt-4 p-4 bg-slate-800/50 rounded-lg border border-slate-700">
                        <form method="POST" action="{{ route('notes.store') }}">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-2">Klant</label>
                                    <select name="customer_id" required class="w-full bg-slate-700/50 border border-slate-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                        <option value="">Selecteer klant</option>
                                        @foreach($customers as $c)
                                        <option value="{{ $c->id }}">{{ $c->company_name ?? $c->contact_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('customer_id') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-slate-300 mb-2">Notitie</label>
                                    <textarea name="body" rows="3" required class="w-full bg-slate-700/50 border border-slate-600 rounded-lg px-4 py-2 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent" placeholder="Schrijf hier je notitie...">{{ old('body') }}</textarea>
                                    @error('body') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="mt-4 text-right">
                                <button type="submit" class="px-5 py-2 bg-yellow-400 hover:bg-yellow-300 text-gray-900 rounded-lg font-medium transition">Opslaan</button>
                            </div>
                        </form>
                    </div>
                </details>
            </div>
        </div>
    </div>

    <!-- List view -->
    <div class="space-y-4">
        @forelse($notes as $note)
        <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 p-6 shadow-xl hover:shadow-2xl hover:border-slate-600 transition-all duration-300">
            <div class="flex justify-between items-start gap-4">
                <div>
                    <div class="text-sm text-yellow-400 font-semibold">
                        {{ $note->customer?->company_name ?? $note->customer?->contact_name ?? 'Onbekende klant' }}
                    </div>
                    <div class="text-xs text-slate-400 mt-1">
                        {{ $note->author?->name ?? 'Onbekende auteur' }} — {{ $note->created_at->format('Y-m-d H:i') }}
                    </div>
                </div>

                <div class="text-right text-sm text-slate-400">
                    <div>{{ $note->created_at->diffForHumans() }}</div>
                </div>
            </div>

            <p class="mt-4 text-white whitespace-pre-wrap">{{ $note->body }}</p>
        </div>
        @empty
        <div class="text-center text-slate-400 py-12">Geen notities gevonden.</div>
        @endforelse

        <div class="mt-4">
            {{ $notes->links() }}
        </div>
    </div>
</div>
@endsection