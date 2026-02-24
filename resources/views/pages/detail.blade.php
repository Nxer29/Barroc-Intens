@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

  <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl p-8 shadow-xl">
    <div class="flex items-start gap-6">
      <div class="flex-1">
        <h2 class="text-4xl font-bold text-white">Kevin Robbemont</h2>
        <p class="text-slate-400 mt-2">kevin@barroc.nl — Barroc Intens B.V.</p>
        <p class="mt-6 text-slate-300">Beschrijving: Project details en notities hier.</p>

        <div class="mt-8 flex gap-4">
          <a class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-6 py-3 rounded-lg font-semibold transition" href="#">Bewerken</a>
          <a class="px-6 py-3 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium" href="{{ route('list') }}">Terug naar lijst</a>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection