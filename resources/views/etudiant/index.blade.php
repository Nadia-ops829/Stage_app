@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Étudiants</h1>
    <a href="{{ route('etudiant.create') }}" class="btn btn-primary mb-3">Ajouter un étudiant</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($etudiants as $etudiant)
            <tr>
                <td>{{ $etudiant->nom }}</td>
                <td>{{ $etudiant->prenom }}</td>
                <td>{{ $etudiant->email }}</td>
                <td>
                    <a href="{{ route('etudiant.show', $etudiant) }}" class="btn btn-info btn-sm">Voir</a>
                    <a href="{{ route('etudiant.edit', $etudiant) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('etudiant.destroy', $etudiant) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
