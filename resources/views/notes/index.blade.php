@extends('layouts.app')

@section('content')
<div class="w-full max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold text-yellow-400 mb-6">Notities</h1>

    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-700 text-white">{{ session('success') }}</div>
    @endif

    <!-- Toolbar: 'Alle notities' link en per-klant filter -->
    <div class="bg-gray-850 rounded-2xl border border-yellow-400/30 p-4 mb-6 flex flex-col sm:flex-row sm:items-center gap-3">
        <div class="flex items-center gap-2">
            <!-- Alle notities: link zonder parameter -->
            <a href="{{ route('notes.index') }}"
               class="px-3 py-1 rounded-full {{ !request()->filled('customer_id') ? 'bg-yellow-400 text-gray-900' : 'bg-gray-800 text-yellow-300' }}">
               Alle notities
            </a>

            <!-- Per klant: select + Toon -->
            <form method="GET" action="{{ route('notes.index') }}" class="flex items-center gap-2">
                <label for="customer_id_toolbar" class="sr-only">Per klant</label>
                <select id="customer_id_toolbar" name="customer_id" class="bg-gray-800 border border-gray-700 rounded p-2 text-gray-100">
                    <option value="">Per klant…</option>
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}" @selected(request('customer_id') == $c->id)>{{ $c->company_name ?? $c->contact_name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-3 py-1 rounded bg-yellow-400 text-gray-900">Toon</button>
            </form>
        </div>

        <div class="ml-auto flex items-center gap-3">
            <div class="text-sm text-gray-300">Totaal: <span class="font-semibold text-yellow-300">{{ $notes->total() }}</span></div>

            <details class="group">
                <summary class="px-3 py-1 rounded bg-gray-800 text-yellow-300 cursor-pointer list-none">Nieuwe notitie</summary>

                <div class="mt-3 p-3 bg-gray-900 rounded border border-gray-700">
                    <form method="POST" action="{{ route('notes.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-sm text-gray-300 mb-1">Klant</label>
                                <select name="customer_id" required class="w-full bg-gray-800 border border-gray-700 rounded p-2 text-gray-100">
                                    <option value="">Selecteer klant</option>
                                    @foreach($customers as $c)
                                        <option value="{{ $c->id }}">{{ $c->company_name ?? $c->contact_name }}</option>
                                    @endforeach
                                </select>
                                @error('customer_id') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm text-gray-300 mb-1">Notitie</label>
                                <textarea name="body" rows="3" required class="w-full bg-gray-800 border border-gray-700 rounded p-2 text-gray-100" placeholder="Schrijf hier je notitie...">{{ old('body') }}</textarea>
                                @error('body') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mt-3 text-right">
                            <button type="submit" class="px-4 py-2 bg-yellow-400 text-gray-900 rounded">Opslaan</button>
                        </div>
                    </form>
                </div>
            </details>
        </div>
    </div>

    <!-- List view -->
    <div class="space-y-3">
        @forelse($notes as $note)
            <div class="bg-gray-900 rounded p-4 border border-gray-700">
                <div class="flex justify-between items-start gap-4">
                    <div>
                        <div class="text-sm text-yellow-300 font-semibold">
                            {{ $note->customer?->company_name ?? $note->customer?->contact_name ?? 'Onbekende klant' }}
                        </div>
                        <div class="text-xs text-gray-400">
                            {{ $note->author?->name ?? 'Onbekende auteur' }} — {{ $note->created_at->format('Y-m-d H:i') }}
                        </div>
                    </div>

                    <div class="text-right text-sm text-gray-400">
                        <div>{{ $note->created_at->diffForHumans() }}</div>
                    </div>
                </div>

                <p class="mt-3 text-gray-100 whitespace-pre-wrap">{{ $note->body }}</p>
            </div>
        @empty
            <div class="text-gray-300">Geen notities gevonden.</div>
        @endforelse

        <div class="mt-4">
            {{ $notes->links() }}
        </div>
    </div>
</div>
@endsection