@extends('layouts.admin')

@section('title', $stage->titre)

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2">
                        <i class="fas fa-briefcase me-2"></i>
                        {{ $stage->titre }}
                    </h1>
                    <p class="text-muted mb-0">
                        @if($stage->entreprise)
                            {{ $stage->entreprise->user->nom ?? $stage->entreprise->nom ?? 'Entreprise' }}
                        @else
                            Entreprise non spécifiée
                        @endif
                        • {{ $stage->lieu }}
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('stages.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Retour aux offres
                    </a>
                    @if(Auth::user()->role === 'entreprise' && Auth::id() === $stage->entreprise_id)
                        <a href="{{ route('stages.edit', $stage) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-1"></i>
                            Modifier
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Stage Details -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Détails du stage
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Description</h6>
                            <p class="mb-3">{{ $stage->description }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Informations clés</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <strong>Lieu :</strong> {{ $stage->lieu }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    <strong>Durée :</strong> {{ $stage->duree }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-graduation-cap text-primary me-2"></i>
                                    <strong>Niveau requis :</strong> {{ $stage->niveau_requis }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-users text-primary me-2"></i>
                                    <strong>Places :</strong> {{ $stage->getPlacesRestantes() }} restantes sur {{ $stage->nombre_places }}
                                </li>
                                @if($stage->remuneration)
                                    <li class="mb-2">
                                        <i class="fas fa-fcfa-sign text-success me-2"></i>
                                        <strong>Rémunération :</strong> {{ $stage->remuneration }}FCFA/mois
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Période</h6>
                            <p class="mb-0">
                                <i class="fas fa-calendar text-primary me-2"></i>
                                Du {{ $stage->date_debut->format('d/m/Y') }} au {{ $stage->date_fin->format('d/m/Y') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Domaine</h6>
                            <span class="badge bg-primary fs-6">{{ $stage->domaine }}</span>
                        </div>
                    </div>

                    @if($stage->competences_requises)
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">Compétences requises</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($stage->competences_requises as $competence)
                                    <span class="badge bg-light text-dark">{{ $competence }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Company Info & Application -->
        <div class="col-lg-4 mb-4">
            <!-- Company Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-building me-2"></i>
                        Entreprise
                    </h5>
                </div>
                <div class="card-body text-center">
                    @if($stage->entreprise)
                        <div class="mb-3">
                            @php
                                $nomEntreprise = $stage->entreprise->user->nom ?? $stage->entreprise->nom ?? 'Entreprise';
                                $initials = '';
                                $nameParts = explode(' ', $nomEntreprise);
                                foreach ($nameParts as $part) {
                                    $initials .= strtoupper(substr($part, 0, 1));
                                    if (strlen($initials) >= 2) break;
                                }
                            @endphp
                            <div class="bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                                <span class="text-white fw-bold fs-4">{{ $initials }}</span>
                            </div>
                        </div>
                        <h6 class="mb-1">{{ $nomEntreprise }}</h6>
                        @if($stage->entreprise->user)
                            <p class="mb-1"><i class="fas fa-envelope me-2"></i> {{ $stage->entreprise->user->email ?? 'Non spécifié' }}</p>
                            <p class="mb-1"><i class="fas fa-phone me-2"></i> {{ $stage->entreprise->user->telephone ?? 'Non spécifié' }}</p>
                            <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i> {{ $stage->entreprise->user->adresse ?? 'Non spécifiée' }}</p>
                        @else
                            <p class="mb-1"><i class="fas fa-envelope me-2"></i> {{ $stage->entreprise->email ?? 'Non spécifié' }}</p>
                            <p class="mb-1"><i class="fas fa-phone me-2"></i> {{ $stage->entreprise->telephone ?? 'Non spécifié' }}</p>
                            <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i> {{ $stage->entreprise->adresse ?? 'Non spécifiée' }}</p>
                        @endif
                        @if($stage->entreprise->domaine)
                            <span class="badge bg-primary mt-2">{{ $stage->entreprise->domaine }}</span>
                        @endif
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Les informations de l'entreprise ne sont pas disponibles
                        </div>
                    @endif
                </div>
            </div>

            <!-- Application Form -->
            @if(Auth::user()->role === 'etudiant')
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-paper-plane me-2"></i>
                            Candidature
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($aDejaPostule)
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Vous avez déjà postulé à ce stage.
                            </div>
                        @else
                            <form action="{{ route('stages.postuler', $stage) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                

                                 <div class="mb-3">
                                    <label for="lettre_motivation" class="form-label">Lettre de motivation *</label>
                                    <input type="file" name="lettre_motivation" id="lettre_motivation" class="form-control @error('lettre_motivation') is-invalid @enderror" accept=".pdf,.doc,.docx">
                                    @error('lettre_motivation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">PDF, DOC ou DOCX (max 2MB)</small>
                                </div>


                                <div class="mb-3">
                                    <label for="cv" class="form-label">CV (optionnel)</label>
                                    <input type="file" name="cv" id="cv" class="form-control @error('cv') is-invalid @enderror" accept=".pdf,.doc,.docx">
                                    @error('cv')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">PDF, DOC ou DOCX (max 2MB)</small>
                                </div>

                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-paper-plane me-1"></i>
                                    Postuler
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #007bff, #6610f2);
}
</style>
@endsection 