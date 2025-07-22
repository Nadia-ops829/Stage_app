@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Liste des administrateurs</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('superadmin.admins.create') }}" class="btn btn-primary mb-3">+ Ajouter un admin</a>

    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Date de création</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
            <tr>
                <td>{{ $admin->nom }}</td>
                <td>{{ $admin->prenom }}</td>
                <td>{{ $admin->email }}</td>
                <td>{{ $admin->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
