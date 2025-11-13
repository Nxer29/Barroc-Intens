@extends('layouts.app')

@section('content')
<x-ui.header title="Componenten – Styleguide">
    <x-ui.button variant="outline" onclick="location.href='{{ url('/') }}'">Home</x-ui.button>
</x-ui.header>

<main class="max-w-5xl mx-auto p-6 space-y-8">
    <section>
        <h2 class="text-xl mb-3">Kleuren</h2>
        <div class="flex gap-4">
            <div class="w-28 h-28 bg-brand-dark border"></div>
            <div class="w-28 h-28 bg-brand-yellow border"></div>
            <div class="w-28 h-28 bg-white border"></div>
        </div>
    </section>

    <section>
        <h2 class="text-xl mb-3">Buttons</h2>
        <div class="flex gap-3">
            <x-ui.button>Primair</x-ui.button>
            <x-ui.button variant="outline">Outline</x-ui.button>
            <x-ui.button variant="secondary">Secondary</x-ui.button>
        </div>
    </section>

    <section>
        <h2 class="text-xl mb-3">Formulier elementen</h2>
        <form class="max-w-md">
            <x-ui.input label="Naam" name="name" />
            <x-ui.input label="E-mail" name="email" />
            <x-ui.button type="submit">Verstuur</x-ui.button>
        </form>
    </section>

    <section>
        <h2 class="text-xl mb-3">Cards / Layout</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-ui.card>Voorbeeld card content</x-ui.card>
            <x-ui.card>Nog een card</x-ui.card>
        </div>
    </section>
</main>
@endsection
