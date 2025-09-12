@extends('layouts.admin')

@section('title', 'Dashboard Entreprise')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
               <div>
                    <h1 class="h3 mb-2">
                         <i class="fas fa-building me-2"></i>
                          {{ Auth::user()->entreprise->nom }}
                    </h1>
                    <p class="text-muted mb-0">
                        Bienvenue {{ Auth::user()->nom }} ! Gérez vos offres de stage
                    </p>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('stages.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>
                            Publier une offre
                        </a>
                    <a href="{{ route('candidatures.recues') }}"class="btn btn-outline-success">
                        <i class="fas fa-users me-1"></i>
                        Gérer les candidatures
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('rapports.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-info rounded-circle p-3">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title text-muted mb-1">Rapports</h6>
                                <h3 class="mb-0">{{ $stats['rapports'] ?? 0 }}</h3>
                                <small class="text-muted">
                                    <i class="fas fa-eye me-1"></i>
                                    Voir les rapports
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary rounded-circle p-3">
                                <i class="fas fa-briefcase text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Offres Actives</h6>
                            <h3 class="mb-0">{{ $stats['offres_actives'] ?? 0 }}</h3>
                            <small class="text-muted">
                                <i class="fas fa-briefcase me-1"></i>
                                Offres publiées
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success rounded-circle p-3">
                                <i class="fas fa-users text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Candidatures</h6>
                            <h3 class="mb-0">{{ $stats['candidatures_total'] ?? 0 }}</h3>
                            <small class="text-muted">
                                <i class="fas fa-file-alt me-1"></i>
                                Total des candidatures
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning rounded-circle p-3">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">En attente</h6>
                            <h3 class="mb-0">{{ $stats['candidatures_en_attente'] ?? 0 }}</h3>
                            <small class="text-warning">
                                <i class="fas fa-clock me-1"></i>
                                En attente de traitement
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

    <!-- Main Content Row -->
    <div class="row">
    <!-- Recent Applications -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Dernières candidatures reçues
                    </h5>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">Candidat</th>
                                <th class="border-0">Poste</th>
                                <th class="border-0">Statut</th>
                                <th class="border-0">Date</th>
                                <th class="border-0 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($candidatures as $candidature)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                @php
                                                    $initials = strtoupper(substr($candidature->etudiant->nom, 0, 1) . substr($candidature->etudiant->prenom, 0, 1));
                                                @endphp
                                                <div class="bg-gradient-info rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    <span class="text-white fw-bold small">{{ $initials }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <small class="fw-bold">{{ $candidature->etudiant->nom }} {{ $candidature->etudiant->prenom }}</small>
                                                <br>
                                                <small class="text-muted">{{ $candidature->etudiant->niveau ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="fw-bold">{{ $candidature->stage->titre }}</small>
                                    </td>
                                    <td>
                                        @if($candidature->statut === 'acceptee')
                                            <span class="badge bg-success">Acceptée</span>
                                        @elseif($candidature->statut === 'refusee')
                                            <span class="badge bg-danger">Refusée</span>
                                        @else
                                            <span class="badge bg-warning">En attente</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $candidature->created_at->format('d/m/Y') }}</small>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('candidatures.show', $candidature) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <!-- <form action="{{ route('candidatures.repondre', $candidature) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="statut" value="acceptee">
                                                <button type="submit" class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('candidatures.repondre', $candidature) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="statut" value="refusee">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form> -->
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        Aucune candidature reçue pour le moment.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


        <!-- Quick Actions & Profile -->
        <div class="col-lg-4 mb-4">
            <!-- Company Profile Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-building me-2"></i>
                        Profil Entreprise
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                            <span class="text-white fw-bold fs-4">{{ strtoupper(substr(Auth::user()->nom, 0, 2)) }}</span>
                        </div>
                    </div>
                    <h6 class="mb-1">{{ Auth::user()->nom }}</h6>
                    <p class="text-muted mb-2">{{ Auth::user()->email }}</p>
                    @if(Auth::user()->domaine)
                        <span class="badge bg-primary">{{ Auth::user()->domaine }}</span>
                    @endif
                    @if(Auth::user()->adresse)
                        <p class="text-muted small mt-2 mb-0">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ Auth::user()->adresse }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Actions rapides
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('stages.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>
                            Publier une offre
                        </a>
                        <a href="{{ route('candidatures.recues') }}" class="btn btn-outline-success">
                            <i class="fas fa-users me-2"></i>
                            Gérer les candidatures
                        </a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-info">
                            <i class="fas fa-building me-2"></i>
                            Modifier le profil
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Job Offers -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-briefcase me-2"></i>
                    Offres de stage de {{ $entreprise->nom }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($offres as $offre)
                        <div class="col-md-4 mb-3">
                            <div class="card border h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h6 class="card-title mb-0">{{ $offre->titre }}</h6>
                                        <span class="badge bg-success">{{ ucfirst($offre->statut) }}</span>
                                    </div>
                                    <p class="card-text small text-muted mb-3">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $offre->lieu ?? 'Non précisé' }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-users me-1"></i>
                                            {{ $offre->candidatures->count() }} candidatures
                                        </small>
                                        <a href="{{ route('stages.show', $offre->id) }}" class="btn btn-sm btn-outline-primary">
                                            Voir détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4">
                            <i class="fas fa-briefcase fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Aucune offre active pour le moment</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #007bff, #6610f2);
}
.bg-gradient-info {
    background: linear-gradient(45deg, #17a2b8, #20c997);
}
.bg-gradient-success {
    background: linear-gradient(45deg, #28a745, #20c997);
}
</style>
@endsection