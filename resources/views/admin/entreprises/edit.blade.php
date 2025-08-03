@extends('layouts.admin')

@section('title', 'Modifier une Entreprise')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-warning text-dark">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">
                                <i class="fas fa-edit me-2"></i>
                                Modifier l'entreprise
                            </h4>
                            <small>Modifiez les informations de {{ $entreprise->nom }}</small>
                        </div>
                        <a href="{{ route('admin.entreprises.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>
                            Retour à la liste
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

                    <form action="{{ route('admin.entreprises.update', $entreprise->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Nom de l'entreprise -->
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">
                                    <i class="fas fa-building me-1"></i>
                                    Nom de l'entreprise <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nom') is-invalid @enderror" 
                                       id="nom" 
                                       name="nom" 
                                       value="{{ old('nom', $entreprise->nom) }}" 
                                       placeholder="Ex: Microsoft France"
                                       required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i>
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $entreprise->email) }}" 
                                       placeholder="contact@entreprise.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Domaine d'activité -->
                            <div class="col-md-6 mb-3">
                                <label for="domaine" class="form-label">
                                    <i class="fas fa-industry me-1"></i>
                                    Domaine d'activité <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('domaine') is-invalid @enderror" 
                                       id="domaine" 
                                       name="domaine" 
                                       value="{{ old('domaine', $entreprise->domaine) }}" 
                                       placeholder="Ex: Technologies, Finance, Santé..."
                                       required>
                                @error('domaine')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Adresse -->
                            <div class="col-md-6 mb-3">
                                <label for="adresse" class="form-label">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    Adresse <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('adresse') is-invalid @enderror" 
                                       id="adresse" 
                                       name="adresse" 
                                       value="{{ old('adresse', $entreprise->adresse) }}" 
                                       placeholder="123 Rue de la Paix, 75001 Paris"
                                       required>
                                @error('adresse')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nouveau mot de passe (optionnel) -->
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-1"></i>
                                    Nouveau mot de passe <small class="text-muted">(optionnel)</small>
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Laissez vide pour conserver l'actuel">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Laissez vide pour conserver le mot de passe actuel
                                </small>
                            </div>

                            <!-- Confirmation mot de passe -->
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock me-1"></i>
                                    Confirmer le nouveau mot de passe
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('password_confirmation') is-invalid @enderror" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder="Confirmez le nouveau mot de passe">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirmation">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.entreprises.index') }}" 
                               class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-1"></i>
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Info Card -->
            <div class="card border-primary mt-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informations actuelles
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Nom :</strong> {{ $entreprise->nom }}</p>
                            <p class="mb-1"><strong>Email :</strong> {{ $entreprise->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Domaine :</strong> {{ $entreprise->domaine ?? 'Non renseigné' }}</p>
                            <p class="mb-1"><strong>Adresse :</strong> {{ $entreprise->adresse ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                    <hr>
                    <p class="mb-0 text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        Créée le {{ $entreprise->created_at->format('d/m/Y à H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle password visibility
document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

document.getElementById('togglePasswordConfirmation').addEventListener('click', function() {
    const password = document.getElementById('password_confirmation');
    const icon = this.querySelector('i');
    
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});
</script>
@endsection 