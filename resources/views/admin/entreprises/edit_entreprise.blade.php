@extends('layouts.admin')

@section('content')
<h1>Modifier l'entreprise</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.entreprises.update', $entreprise->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" id="nom" name="nom" value="{{ old('nom', $entreprise->nom) }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="prenom" class="form-label">Prénom</label>
        <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $entreprise->prenom) }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $entreprise->email) }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="domaine" class="form-label">Domaine</label>
        <input type="text" id="domaine" name="domaine" value="{{ old('domaine', $entreprise->domaine) }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="adresse" class="form-label">Adresse</label>
        <input type="text" id="adresse" name="adresse" value="{{ old('adresse', $entreprise->adresse) }}" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Enregistrer</button>
    <a href="{{ route('admin.entreprises.index') }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection
