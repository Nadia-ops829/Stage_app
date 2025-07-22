@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails de l’Étudiant</h1>

    <ul class="list-group">
        <li class="list-group-item"><strong>Nom :</strong> {{ $etudiant->nom }}</li>
        <li class="list-group-item"><strong>Prénom :</strong> {{ $etudiant->prenom }}</li>
        <li class="list-group-item"><strong>Email :</strong> {{ $etudiant->email }}</li>
        <li class="list-group-item"><strong>Téléphone :</strong> {{ $etudiant->telephone }}</li>
        <li class="list-group-item"><strong>Niveau :</strong> {{ $etudiant->niveau }}</li>
        <li class="list-group-item"><strong>Spécialité :</strong> {{ $etudiant->specialite }}</li>
    </ul>

    <a href="{{ route('etudiant.index') }}" class="btn btn-secondary mt-3">Retour</a>
</div>
@endsection
