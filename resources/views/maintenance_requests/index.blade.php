@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <h1 class="text-4xl font-bold text-white mb-2">
        Maintenance – Storingsaanvragen
    </h1>
    <p class="text-gray-400 mt-2 mb-12">Overzicht van alle storingsaanvragen</p>

    <div class="bg-gradient-to-br from-slate-800/90 to-slate-900 border border-slate-700 rounded-2xl overflow-hidden shadow-xl">

        <table class="w-full text-sm">
            <thead class="bg-slate-800 text-slate-300">
                <tr>
                    <th class="p-4 text-left">Nr</th>
                    <th class="p-4 text-left">Klant</th>
                    <th class="p-4 text-left">Product</th>
                    <th class="p-4">Urgentie</th>
                    <th class="p-4">Priority</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-left">Gemeld door</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-700">
            <tbody class="divide-y divide-slate-700">
                @forelse($requests as $request)
                <tr class="hover:bg-slate-800/50 transition">
                    <td class="p-4 font-mono text-white">
                        {{ $request->request_number }}
                    </td>

                    <td class="p-4 text-slate-300">
                        {{ $request->customer?->displayName() ?? '-' }}
                    </td>

                    <td class="p-4 text-slate-300">
                        {{ $request->product?->name ?? '-' }}
                    </td>

                    <td class="p-4 text-center text-slate-300">
                        {{ ucfirst($request->urgency) }}
                    </td>

                    <td class="p-4 text-center font-bold
                            {{ $request->priority === 'P1' ? 'text-red-400' : '' }}
                            {{ $request->priority === 'P2' ? 'text-yellow-400' : '' }}
                            {{ $request->priority === 'P3' ? 'text-green-400' : '' }}">
                        {{ $request->priority }}
                    </td>

                    <td class="p-4 text-center text-white">
                        {{ ucfirst($request->status) }}
                    </td>

                    <td class="p-4 text-slate-300">
                        {{ $request->reportedBy?->name ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-6 text-center text-gray-500">
                        Geen storingsaanvragen gevonden.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <div class="mt-4">
        {{ $requests->links() }}
    </div>

</div>
@endsection