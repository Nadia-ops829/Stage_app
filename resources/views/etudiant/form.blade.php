<div class="mb-3">
    <label for="nom" class="form-label">Nom</label>
    <input type="text" name="nom" class="form-control" value="{{ old('nom', $etudiant->nom ?? '') }}">
</div>

<div class="mb-3">
    <label for="prenom" class="form-label">Prénom</label>
    <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $etudiant->prenom ?? '') }}">
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $etudiant->email ?? '') }}">
</div>

<div class="mb-3">
    <label for="telephone" class="form-label">Téléphone</label>
    <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $etudiant->telephone ?? '') }}">
</div>

<div class="mb-3">
    <label for="niveau" class="form-label">Niveau d'étude</label>
    <input type="text" name="niveau" class="form-control" value="{{ old('niveau', $etudiant->niveau ?? '') }}">
</div>

<div class="mb-3">
    <label for="specialite" class="form-label">Spécialité</label>
    <input type="text" name="specialite" class="form-control" value="{{ old('specialite', $etudiant->specialite ?? '') }}">
</div>
