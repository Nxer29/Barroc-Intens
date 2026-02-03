@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8">

    <h1 class="text-3xl font-bold text-yellow-400 mb-6">
        Maintenance – Storingsaanvragen
    </h1>

    <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-800 text-gray-400">
                <tr>
                    <th class="p-3 text-left">Nr</th>
                    <th class="p-3 text-left">Klant</th>
                    <th class="p-3 text-left">Product</th>
                    <th class="p-3">Urgentie</th>
                    <th class="p-3">Priority</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-left">Gemeld door</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-800">
                @forelse($requests as $request)
                    <tr class="hover:bg-gray-850">
                        <td class="p-3 font-mono">
                            {{ $request->request_number }}
                        </td>

                        <td class="p-3">
                            {{ $request->customer?->displayName() ?? '-' }}
                        </td>

                        <td class="p-3">
                            {{ $request->product?->name ?? '-' }}
                        </td>

                        <td class="p-3 text-center">
                            {{ ucfirst($request->urgency) }}
                        </td>

                        <td class="p-3 text-center font-bold
                            {{ $request->priority === 'P1' ? 'text-red-400' : '' }}
                            {{ $request->priority === 'P2' ? 'text-yellow-400' : '' }}
                            {{ $request->priority === 'P3' ? 'text-green-400' : '' }}">
                            {{ $request->priority }}
                        </td>

                        <td class="p-3 text-center">
                            {{ ucfirst($request->status) }}
                        </td>

                        <td class="p-3">
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
