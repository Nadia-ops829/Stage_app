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
                                       value="{{ old('email', $entreprise->user->email) }}" 
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
                                       value="{{ old('domaine', $entreprise->user->domaine) }}" 
                                       placeholder="Ex: Technologies, Finance, Santé..."
                                       required>
                                @error('domaine')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Adresse -->
                            <div class="col-12 mb-3">
                                <label for="adresse" class="form-label">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    Adresse complète <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('adresse') is-invalid @enderror" 
                                          id="adresse" 
                                          name="adresse" 
                                          rows="2" 
                                          placeholder="Adresse complète de l'entreprise"
                                          required>{{ old('adresse', $entreprise->user->adresse) }}</textarea>
                                @error('adresse')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mot de passe -->
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-1"></i>
                                    Nouveau mot de passe <small class="text-muted">(optionnel)</small>
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('mot_de_passe') is-invalid @enderror" 
                                           id="password" 
                                           name="mot_de_passe" 
                                           placeholder="Laisser vide pour ne pas changer"
                                           autocomplete="new-password">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('mot_de_passe')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">Minimum 8 caractères</small>
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
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informations actuelles
                    </h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Date de création</dt>
                        <dd class="col-sm-9">{{ $entreprise->created_at->format('d/m/Y H:i') }}</dd>
                        
                        <dt class="col-sm-3">Dernière mise à jour</dt>
                        <dd class="col-sm-9">{{ $entreprise->updated_at->format('d/m/Y H:i') }}</dd>
                        
                        <dt class="col-sm-3">Statut</dt>
                        <dd class="col-sm-9">
                            <span class="badge bg-success">Active</span>
                        </dd>
                        
                        @if($entreprise->user)
                            <dt class="col-sm-3">Dernière connexion</dt>
                            <dd class="col-sm-9">
                                {{ $entreprise->user->last_login_at ? $entreprise->user->last_login_at->format('d/m/Y H:i') : 'Jamais connecté' }}
                            </dd>
                        @endif
                    </dl>
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