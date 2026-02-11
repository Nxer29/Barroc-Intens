@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- Header --}}
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-white">Gebruikersbeheer</h1>
        <p class="text-gray-400 mt-1">
            Beheer gebruikers en hun rollen
        </p>
    </div>

    {{-- Card --}}
    <div class="bg-slate-900 rounded-2xl border border-slate-700 shadow-xl overflow-hidden">

        <div class="px-6 py-4 border-b border-slate-700">
            <h2 class="text-lg font-semibold text-white">Alle gebruikers</h2>
        </div>

        <div class="divide-y divide-slate-800">
            @foreach($users as $user)
                <div id="user-row-{{ $user->id }}"
                     class="grid grid-cols-1 md:grid-cols-4 gap-8 px-6 py-6
                            hover:bg-slate-800/50 transition items-center">

                    {{-- USER INFO (links) --}}
                    <div>
                        <p class="text-white font-semibold text-lg">
                            {{ $user->name }}
                        </p>
                        <p class="text-sm text-gray-400">
                            {{ $user->email }}
                        </p>
                    </div>

                    {{-- ACTIEVE ROLLEN (midden) --}}
                    <div class="flex justify-center">
                        <div class="flex flex-wrap gap-2 justify-center user-roles">
                            @foreach($user->getRoleNames() as $r)
                                <span
                                    class="text-xs font-medium px-3 py-1 rounded-full
                                           bg-blue-500/15 text-blue-400
                                           border border-blue-500/30">
                                    {{ ucfirst($r) }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    {{-- ROLES CHECKLIST (rechts, breed) --}}
                    <div class="md:col-span-2">
                        <div class="space-y-3 max-w-sm ml-auto">
                            @foreach($roles as $role)
                                @php $has = $user->hasRole($role->name); @endphp
                                <label
                                    class="flex items-center gap-3 text-sm text-gray-300
                                           cursor-pointer select-none">
                                    <input type="checkbox"
                                           class="role-checkbox w-4 h-4 accent-blue-500"
                                           data-user-id="{{ $user->id }}"
                                           data-role="{{ $role->name }}"
                                           @checked($has)>
                                    <span>{{ ucfirst($role->name) }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- JS --}}
<script>
document.querySelectorAll('.role-checkbox').forEach(cb => {
    cb.addEventListener('change', () => {
        const userId = cb.dataset.userId;
        const role = cb.dataset.role;
        const token = document.querySelector('meta[name="csrf-token"]').content;

        fetch(`/admin/users/roles/${userId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ role })
        })
        .then(r => r.json())
        .then(data => {
            const row = document.getElementById(`user-row-${userId}`);
            const rolesCell = row.querySelector('.user-roles');
            rolesCell.innerHTML = '';

            data.roles.forEach(r => {
                const span = document.createElement('span');
                span.className =
                    'text-xs font-medium px-3 py-1 rounded-full bg-blue-500/15 text-blue-400 border border-blue-500/30';
                span.textContent = r;
                rolesCell.appendChild(span);
            });
        })
        .catch(() => {
            cb.checked = !cb.checked;
            alert('Opslaan mislukt');
        });
    });
});
</script>
@endsection
