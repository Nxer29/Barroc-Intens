@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
  <div class="card">
    <div class="flex items-start gap-6">
      <div class="flex-1">
        <h2 class="text-2xl font-bold">Kevin Robbemont</h2>
        <p class="text-sm text-gray-600 mt-1">kevin@barroc.nl — Barroc Intens B.V.</p>
        <p class="mt-4 text-gray-700">Beschrijving: Project details en notities hier.</p>

        <div class="mt-6 flex gap-3">
          <a class="btn-primary" href="#">Bewerken</a>
          <a class="btn-outline" href="{{ route('list') }}">Terug naar lijst</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
