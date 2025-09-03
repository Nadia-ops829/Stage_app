@extends('layouts.admin')

@section('title', 'Détails de l\'Entreprise')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">
                                <i class="fas fa-building me-2"></i>
                                {{ $entreprise->nom }}
                            </h4>
                            <small>Détails de l'entreprise</small>
                        </div>
                        <div>
                            <a href="{{ route('admin.entreprises.edit', $entreprise->id) }}" class="btn btn-warning btn-sm me-2">
                                <i class="fas fa-edit me-1"></i>
                                Modifier
                            </a>
                            <a href="{{ route('admin.entreprises.index') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>
                                Retour à la liste
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Info Card -->
            <div class="row">
                <!-- Informations principales -->
                <div class="col-md-8 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Informations générales
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">
                                        <i class="fas fa-building me-2"></i>
                                        Nom de l'entreprise
                                    </h6>
                                    <p class="mb-0">{{ $entreprise->nom }}</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">
                                        <i class="fas fa-envelope me-2"></i>
                                        Email
                                    </h6>
                                    <p class="mb-0">
                                        <a href="mailto:{{ $entreprise->user->email }}">
                                            {{ $entreprise->user->email }}
                                        </a>
                                    </p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">
                                        <i class="fas fa-phone me-2"></i>
                                        Téléphone
                                    </h6>
                                    <p class="mb-0">
                                        @if($entreprise->user->telephone)
                                            <a href="tel:{{ $entreprise->user->telephone }}">
                                                {{ $entreprise->user->telephone }}
                                            </a>
                                        @else
                                            <span class="text-muted">Non renseigné</span>
                                        @endif
                                    </p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">
                                        <i class="fas fa-industry me-2"></i>
                                        Domaine d'activité
                                    </h6>
                                    <p class="mb-0">{{ $entreprise->user->domaine ?? 'Non spécifié' }}</p>
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <h6 class="text-muted">
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        Adresse
                                    </h6>
                                    <p class="mb-0">{{ $entreprise->user->adresse ?? 'Non renseignée' }}</p>
                                </div>
                                
                                @if($entreprise->site_web)
                                <div class="col-12 mb-3">
                                    <h6 class="text-muted">
                                        <i class="fas fa-globe me-2"></i>
                                        Site web
                                    </h6>
                                    <p class="mb-0">
                                        <a href="{{ $entreprise->site_web }}" target="_blank" rel="noopener noreferrer">
                                            {{ $entreprise->site_web }}
                                        </a>
                                    </p>
                                </div>
                                @endif
                                
                                @if($entreprise->description)
                                <div class="col-12">
                                    <h6 class="text-muted">
                                        <i class="fas fa-align-left me-2"></i>
                                        Description
                                    </h6>
                                    <p class="mb-0">{{ $entreprise->description }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Statuts et métadonnées -->
                <div class="col-md-4 mb-4">
                    <!-- Statut -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-line me-2"></i>
                                Statut
                            </h6>
                        </div>
                        <div class="card-body text-center py-4">
                            <div class="mb-3">
                                <span class="badge bg-success p-3" style="font-size: 1rem;">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Compte actif
                                </span>
                            </div>
                            
                            <div class="mt-4">
                                <p class="mb-1">
                                    <i class="fas fa-user-shield me-2"></i>
                                    Rôle: <span class="fw-bold">Entreprise</span>
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-calendar-plus me-2"></i>
                                    Inscrit le: {{ $entreprise->created_at->format('d/m/Y') }}
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-clock me-2"></i>
                                    Dernière connexion: 
                                    @if($entreprise->user->last_login_at)
                                        {{ $entreprise->user->last_login_at->diffForHumans() }}
                                    @else
                                        <span class="text-muted">Jamais connecté</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions rapides -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-bolt me-2"></i>
                                Actions rapides
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <a href="mailto:{{ $entreprise->user->email }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-envelope me-2 text-primary"></i>
                                    Envoyer un email
                                </a>
                                @if($entreprise->user->telephone)
                                <a href="tel:{{ $entreprise->user->telephone }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-phone me-2 text-success"></i>
                                    Appeler l'entreprise
                                </a>
                                @endif
                                <a href="{{ route('admin.entreprises.edit', $entreprise->id) }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-edit me-2 text-warning"></i>
                                    Modifier les informations
                                </a>
                                <form action="{{ route('admin.entreprises.destroy', $entreprise->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="list-group-item list-group-item-action text-danger" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ? Cette action est irréversible.')">
                                        <i class="fas fa-trash-alt me-2"></i>
                                        Supprimer l'entreprise
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Dernières activités (à implémenter si nécessaire) -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>
                        Dernières activités
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Le suivi des activités sera bientôt disponible.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
