@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="mb-4">Admin Dashboard</h1>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card p-3">
                    <h6>Aantal gebruikers</h6>
                    <p class="h3">{{ $userCount ?? 0 }}</p>
                    <a href="{{ route('admin-dashboard.users') }}" class="btn btn-sm btn-primary">Bekijk Gebruikers</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3">
                    <h6>Aantal rollen</h6>
                    <p class="h3">{{ $roles->count() ?? 0 }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3">
                    <h6>Producten</h6>
                    <p class="h3">{{ $productCount ?? 0 }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3">
                    <h6>Categorieën</h6>
                    <p class="h3">{{ $productCategoryCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h5>Gebruikers per rol</h5>
            <div class="list-group">
                @foreach($roleCounts ?? [] as $roleName => $count)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>{{ $roleName }}</div>
                        <span class="badge bg-primary rounded-pill">{{ $count }}</span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection
