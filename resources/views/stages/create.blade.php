@extends('layouts.admin')

@section('title', 'Publier une Offre de Stage')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">
                                <i class="fas fa-plus me-2"></i>
                                Publier une Offre de Stage
                            </h4>
                            <small>Créez une nouvelle offre de stage pour attirer les talents</small>
                        </div>
                        <a href="{{ route('stages.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>
                            Retour aux offres
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6 class="alert-heading">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Erreurs de validation
                            </h6>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('stages.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <!-- Titre du stage -->
                            <div class="col-md-12 mb-3">
                                <label for="titre" class="form-label">
                                    <i class="fas fa-briefcase me-1"></i>
                                    Titre du stage <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('titre') is-invalid @enderror" 
                                       id="titre" 
                                       name="titre" 
                                       value="{{ old('titre') }}" 
                                       placeholder="Ex: Développeur Full-Stack"
                                       required>
                                @error('titre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">
                                    <i class="fas fa-align-left me-1"></i>
                                    Description détaillée <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="6" 
                                          placeholder="Décrivez les missions, les responsabilités et les objectifs du stage..."
                                          required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Domaine -->
                            <div class="col-md-6 mb-3">
                                <label for="domaine" class="form-label">
                                    <i class="fas fa-industry me-1"></i>
                                    Domaine <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('domaine') is-invalid @enderror" 
                                        id="domaine" 
                                        name="domaine" 
                                        required>
                                    <option value="">Sélectionnez un domaine</option>
                                    <option value="Technologies" {{ old('domaine') === 'Technologies' ? 'selected' : '' }}>Technologies</option>
                                    <option value="Finance" {{ old('domaine') === 'Finance' ? 'selected' : '' }}>Finance</option>
                                    <option value="Marketing" {{ old('domaine') === 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                    <option value="Santé" {{ old('domaine') === 'Santé' ? 'selected' : '' }}>Santé</option>
                                    <option value="Éducation" {{ old('domaine') === 'Éducation' ? 'selected' : '' }}>Éducation</option>
                                    <option value="Commerce" {{ old('domaine') === 'Commerce' ? 'selected' : '' }}>Commerce</option>
                                </select>
                                @error('domaine')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Niveau requis -->
                            <div class="col-md-6 mb-3">
                                <label for="niveau_requis" class="form-label">
                                    <i class="fas fa-graduation-cap me-1"></i>
                                    Niveau requis <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('niveau_requis') is-invalid @enderror" 
                                        id="niveau_requis" 
                                        name="niveau_requis" 
                                        required>
                                    <option value="">Sélectionnez un niveau</option>
                                    <option value="Licence" {{ old('niveau_requis') === 'Licence' ? 'selected' : '' }}>Licence</option>
                                    <option value="Master" {{ old('niveau_requis') === 'Master' ? 'selected' : '' }}>Master</option>
                                    <option value="Doctorat" {{ old('niveau_requis') === 'Doctorat' ? 'selected' : '' }}>Doctorat</option>
                                </select>
                                @error('niveau_requis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Lieu -->
                            <div class="col-md-6 mb-3">
                                <label for="lieu" class="form-label">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    Lieu <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('lieu') is-invalid @enderror" 
                                       id="lieu" 
                                       name="lieu" 
                                       value="{{ old('lieu') }}" 
                                       placeholder="Ex: Ouagdougou,..."
                                       required>
                                @error('lieu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Durée -->
                            <div class="col-md-6 mb-3">
                                <label for="duree" class="form-label">
                                    <i class="fas fa-clock me-1"></i>
                                    Durée <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('duree') is-invalid @enderror" 
                                       id="duree" 
                                       name="duree" 
                                       value="{{ old('duree') }}" 
                                       placeholder="Ex: 6 mois, 3 mois..."
                                       required>
                                @error('duree')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Rémunération -->
                            <div class="col-md-6 mb-3">
                                <label for="remuneration" class="form-label">
                                    <i class="fas fa-fcfa-sign me-1"></i>
                                    Rémunération (optionnel)
                                </label>
                                <input type="number" 
                                       class="form-control @error('remuneration') is-invalid @enderror" 
                                       id="remuneration" 
                                       name="remuneration" 
                                       value="{{ old('remuneration') }}" 
                                       placeholder="Montant en  FCFA par mois"
                                       min="0" 
                                       step="0.01">
                                @error('remuneration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nombre de places -->
                            <div class="col-md-6 mb-3">
                                <label for="nombre_places" class="form-label">
                                    <i class="fas fa-users me-1"></i>
                                    Nombre de places <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('nombre_places') is-invalid @enderror" 
                                       id="nombre_places" 
                                       name="nombre_places" 
                                       value="{{ old('nombre_places', 1) }}" 
                                       min="1" 
                                       required>
                                @error('nombre_places')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Date de début -->
                            <div class="col-md-6 mb-3">
                                <label for="date_debut" class="form-label">
                                    <i class="fas fa-calendar me-1"></i>
                                    Date de début <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('date_debut') is-invalid @enderror" 
                                       id="date_debut" 
                                       name="date_debut" 
                                       value="{{ old('date_debut') }}" 
                                       min="{{ date('Y-m-d') }}"
                                       required>
                                @error('date_debut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Date de fin -->
                            <div class="col-md-6 mb-3">
                                <label for="date_fin" class="form-label">
                                    <i class="fas fa-calendar me-1"></i>
                                    Date de fin <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('date_fin') is-invalid @enderror" 
                                       id="date_fin" 
                                       name="date_fin" 
                                       value="{{ old('date_fin') }}" 
                                       required>
                                @error('date_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('stages.index') }}" 
                               class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane me-1"></i>
                                Publier l'offre
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validation des dates
document.getElementById('date_debut').addEventListener('change', function() {
    const dateFin = document.getElementById('date_fin');
    dateFin.min = this.value;
    if (dateFin.value && dateFin.value < this.value) {
        dateFin.value = this.value;
    }
});
</script>
@endsection 