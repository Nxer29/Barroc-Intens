@extends('layouts.app')

@section('content')
<div class="space-y-6">
  <h2 class="text-2xl font-bold">Klantenlijst</h2>

  <div class="card overflow-x-auto">
    <table class="min-w-full">
      <thead class="bg-[var(--brand-yellow)] text-black">
        <tr>
          <th class="py-3 px-4 text-left">Naam</th>
          <th class="py-3 px-4 text-left">Email</th>
          <th class="py-3 px-4 text-left">Status</th>
          <th class="py-3 px-4 text-right">Actie</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <tr class="hover:bg-gray-50">
          <td class="table-cell">Kevin Robbemont</td>
          <td class="table-cell">kevin@barroc.nl</td>
          <td class="table-cell">Actief</td>
          <td class="table-cell text-right"><a href="{{ route('detail') }}" class="text-[var(--brand-yellow)] font-medium">Bekijken</a></td>
        </tr>
        <tr class="hover:bg-gray-50">
          <td class="table-cell">Bram Daalmans</td>
          <td class="table-cell">bram@barroc.nl</td>
          <td class="table-cell">Inactief</td>
          <td class="table-cell text-right"><a href="{{ route('detail') }}" class="text-[var(--brand-yellow)] font-medium">Bekijken</a></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
