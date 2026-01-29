@extends('layouts.app')

@section('content')
<div class="w-full max-w-7xl mx-auto">

    {{-- Titel --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-yellow-400">
            Dashboard
        </h1>
        <p class="text-gray-400">
            Overzicht van je werkzaamheden
        </p>
    </div>

    {{-- Widgets --}}
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @foreach($widgets as $widget)
            <div class="bg-gray-900 rounded-2xl border border-yellow-400/30 p-6 shadow-lg
                        hover:scale-[1.02] hover:border-yellow-400 transition duration-200">

                {{-- Titel --}}
                <h3 class="text-lg font-semibold text-yellow-400 mb-2">
                    {{ $widget['title'] }}
                </h3>

                {{-- Waarde --}}
                <p class="text-3xl font-extrabold text-white mb-4">
                    {{ $widget['value'] }}
                </p>

                {{-- Actie --}}
                @if(isset($widget['route']))
                    <a href="{{ route($widget['route']) }}"
                       class="inline-flex items-center text-yellow-300 hover:text-yellow-500 font-medium">
                        Openen
                        <span class="ml-2">→</span>
                    </a>
                @endif


            </div>
        @endforeach

        {{-- Extra lege kaart voor toekomst --}}
        <div class="bg-gray-900/40 rounded-2xl border border-dashed border-gray-700
                    p-6 flex items-center justify-center text-gray-500 text-sm">
            Meer widgets volgen…
        </div>
        <div class="bg-gray-900 rounded-2xl border border-yellow-400/40 p-6 shadow-lg hover:scale-[1.02] transition">
            <h3 class="text-xl font-semibold text-yellow-400 mb-2">Factuuroverzicht</h3>
            <p class="text-gray-300 mb-3">Facturen, contracten en status filteren en beheren.</p>
            <a href="{{ route('invoices.overview') }}" class="text-yellow-300 hover:text-yellow-500 font-medium">Openen →</a>
        </div>
    </div>

</div>
@endsection