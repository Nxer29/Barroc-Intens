@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

  <h1 class="text-4xl font-bold text-white mb-2">Klantenlijst</h1>
  <p class="text-gray-400 mt-2 mb-12">Overzicht van alle klanten</p>

  <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 rounded-2xl border border-slate-700 shadow-xl overflow-x-auto">
    <table class="min-w-full">
      <thead class="bg-slate-800 text-slate-300">
        <tr>
          <th class="py-4 px-4 text-left">Naam</th>
          <th class="py-4 px-4 text-left">Email</th>
          <th class="py-4 px-4 text-left">Status</th>
          <th class="py-4 px-4 text-right">Actie</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-700">
        <tr class="hover:bg-slate-800/50 transition">
          <td class="py-4 px-4 text-white">Kevin Robbemont</td>
          <td class="py-4 px-4 text-slate-300">kevin@barroc.nl</td>
          <td class="py-4 px-4 text-slate-300">Actief</td>
          <td class="py-4 px-4 text-right"><a href="{{ route('detail') }}" class="px-4 py-2 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">Bekijken</a></td>
        </tr>
        <tr class="hover:bg-slate-800/50 transition">
          <td class="py-4 px-4 text-white">Bram Daalmans</td>
          <td class="py-4 px-4 text-slate-300">bram@barroc.nl</td>
          <td class="py-4 px-4 text-slate-300">Inactief</td>
          <td class="py-4 px-4 text-right"><a href="{{ route('detail') }}" class="px-4 py-2 rounded-lg border border-slate-600 text-slate-300 hover:bg-slate-700 hover:text-white transition font-medium">Bekijken</a></td>
        </tr>
      </tbody>
    </table>
  </div>

</div>
@endsection