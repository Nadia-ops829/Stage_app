@extends('layouts.admin')

@section('title', 'Offres de Stage')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2">
                        <i class="fas fa-briefcase me-2"></i>
                        Offres de Stage
                    </h1>
                    <p class="text-muted mb-0">Découvrez les opportunités de stage disponibles</p>
                </div>
                @if(Auth::user()->role === 'entreprise')
                    <div class="d-flex gap-2">
                        <a href="{{ route('stages.create') }}" class="btn btn-success">
                            <i class="fas fa-plus me-1"></i>
                            Publier une offre
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('stages.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="domaine" class="form-label">Domaine</label>
                            <select name="domaine" id="domaine" class="form-select">
                                <option value="">Tous les domaines</option>
                                <option value="Technologies" {{ request('domaine') === 'Technologies' ? 'selected' : '' }}>Technologies</option>
                                <option value="Finance" {{ request('domaine') === 'Finance' ? 'selected' : '' }}>Finance</option>
                                <option value="Marketing" {{ request('domaine') === 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="Santé" {{ request('domaine') === 'Santé' ? 'selected' : '' }}>Santé</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="lieu" class="form-label">Lieu</label>
                            <input type="text" name="lieu" id="lieu" class="form-control" value="{{ request('lieu') }}" placeholder="Paris, Lyon...">
                        </div>
                        <div class="col-md-3">
                            <label for="niveau" class="form-label">Niveau</label>
                            <select name="niveau" id="niveau" class="form-select">
                                <option value="">Tous les niveaux</option>
                                <option value="Licence" {{ request('niveau') === 'Licence' ? 'selected' : '' }}>Licence</option>
                                <option value="Master" {{ request('niveau') === 'Master' ? 'selected' : '' }}>Master</option>
                                <option value="Doctorat" {{ request('niveau') === 'Doctorat' ? 'selected' : '' }}>Doctorat</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search me-1"></i>
                                Filtrer
                            </button>
                            <a href="{{ route('stages.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>
                                Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Stages List -->
    <div class="row">
        @forelse($stages as $stage)
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title mb-1">{{ $stage->titre }}</h5>
                                <p class="text-muted mb-0">{{ $stage->entreprise }}</p>
                            </div>
                            <span class="badge bg-success">Active</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <p class="card-text text-muted">{{ Str::limit($stage->description, 150) }}</p>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $stage->lieu }}
                                </small>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $stage->duree }}
                                </small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <small class="text-muted">
                                    <i class="fas fa-graduation-cap me-1"></i>
                                    {{ $stage->niveau_requis }}
                                </small>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">
                                    <i class="fas fa-users me-1"></i>
                                    {{ $stage->getPlacesRestantes() }} places
                                </small>
                            </div>
                        </div>

                        @if($stage->remuneration)
                            <div class="mb-3">
                                <small class="text-success">
                                    <i class="fas fa-fcfa-sign me-1"></i>
                                    {{ $stage->remuneration }}FCFA/mois
                                </small>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary">{{ $stage->domaine }}</span>
                            <a href="{{ route('stages.show', $stage) }}" class="btn btn-outline-primary btn-sm">
                                Voir détails
                            </a>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            Du {{ $stage->date_debut->format('d/m/Y') }} au {{ $stage->date_fin->format('d/m/Y') }}
                        </small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Aucune offre de stage</h5>
                        <p class="text-muted">Aucune offre de stage ne correspond à vos critères.</p>
                        @if(Auth::user()->role === 'entreprise')
                            <a href="{{ route('stages.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>
                                Publier une offre
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($stages->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $stages->links() }}
        </div>
    @endif
</div>
@endsection 