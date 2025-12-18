@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container">
        <h1 class="mb-4">Gebruikers</h1>

        <table class="table table-striped align-middle">
            <thead>
            <tr>
                <th>#</th>
                <th>Naam</th>
                <th>Email</th>
                <th>Rollen</th>
                <th>Acties</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users ?? collect() as $user)
                <tr id="user-row-{{ $user->id }}">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="user-roles">
                        @foreach($user->getRoleNames() as $r)
                            <span class="badge bg-success me-1">{{ $r }}</span>
                        @endforeach
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                    id="rolesDropdown{{ $user->id }}"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                Rollen beheren
                            </button>
                            <div class="dropdown-menu p-3" aria-labelledby="rolesDropdown{{ $user->id }}"
                                 style="min-width: 240px;">
                                <div class="role-checklist" data-user-id="{{ $user->id }}">
                                    @foreach($roles ?? collect() as $role)
                                        @php $has = $user->hasRole($role->name); @endphp
                                        <div class="form-check mb-1">
                                            <input class="form-check-input role-checkbox"
                                                   type="checkbox"
                                                   id="role-{{ $user->id }}-{{ $role->name }}"
                                                   data-role="{{ $role->name }}"
                                                   data-user-id="{{ $user->id }}"
                                                   @if($has) checked @endif>
                                            <label class="form-check-label" for="role-{{ $user->id }}-{{ $role->name }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

        <script>
            const checkboxs = document.getElementsByClassName('role-checkbox');
            console.log(checkboxs);
            for (const checkbox of checkboxs) {
                checkbox.addEventListener('change', function (e) {
                    const cb = e.target.closest('.role-checkbox');
                    if (!cb) return;

                    const userId = cb.dataset.userId;
                    const role = cb.dataset.role;
                    const assigned = cb.checked;
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // Optional: optimistic UI—disable while saving
                    cb.disabled = true;

                    fetch(`/admin/users/roles/${userId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({role: role, assigned: assigned})
                    })
                        .then(r => r.json().then(data => ({status: r.status, body: data})))
                        .then(res => {
                            cb.disabled = false;
                            if (res.status >= 200 && res.status < 300) {
                                const row = document.getElementById('user-row-' + userId);
                                const rolesCell = row.querySelector('.user-roles');
                                if (res.body.roles) {
                                    rolesCell.innerHTML = '';
                                    res.body.roles.forEach(function (rname) {
                                        const span = document.createElement('span');
                                        span.className = 'badge bg-success me-1';
                                        span.textContent = rname;
                                        rolesCell.appendChild(span);
                                    });
                                }
                            } else {
                                cb.checked = !assigned; // revert
                                alert(res.body.message || 'Er is iets misgegaan');
                            }
                        })
                        .catch(err => {
                            cb.disabled = false;
                            cb.checked = !assigned; // revert
                            console.error(err);
                            alert('Fout bij verbinden met server');
                        });
                });
            };
        </script>
@endsection
