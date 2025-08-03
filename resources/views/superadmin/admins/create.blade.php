@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Créer un nouvel administrateur</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('superadmin.admins.store') }}">
        @csrf
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmer mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Rôle</label>
            <select name="role" id="role-select" class="form-control" required onchange="toggleEntrepriseFields()">
                <option value="admin">Administrateur</option>
                <option value="entreprise">Entreprise</option>
            </select>
        </div>
        <div id="entreprise-fields" style="display:none;">
            <div class="mb-3">
                <label for="domaine" class="form-label">Domaine</label>
                <input type="text" name="domaine" class="form-control">
            </div>
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" name="adresse" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Créer l'utilisateur</button>
    </form>
    <script>
        function toggleEntrepriseFields() {
            var role = document.getElementById('role-select').value;
            var entrepriseFields = document.getElementById('entreprise-fields');
            entrepriseFields.style.display = (role === 'entreprise') ? 'block' : 'none';
        }
        document.addEventListener('DOMContentLoaded', function() {
            toggleEntrepriseFields();
        });
    </script>
</div>
@endsection
