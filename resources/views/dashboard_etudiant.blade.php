@extends('layouts.admin')

@section('title', 'Dashboard Étudiant')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2">
                        <i class="fas fa-user-graduate me-2"></i>
                        Mon Dashboard Étudiant
                    </h1>
                    <p class="text-muted mb-0">Bienvenue {{ Auth::user()->nom }} {{ Auth::user()->prenom }} !</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-primary">
                        <i class="fas fa-search me-1"></i>
                        Rechercher des stages
                    </a>
                    <a href="#" class="btn btn-outline-success">
                        <i class="fas fa-file-alt me-1"></i>
                        Mon CV
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary rounded-circle p-3">
                                <i class="fas fa-paper-plane text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Candidatures</h6>
                            <h3 class="mb-0">{{ $stats['candidatures'] ?? 0 }}</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                +{{ rand(1, 3) }} cette semaine
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
                                <i class="fas fa-check-circle text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Réponses</h6>
                            <h3 class="mb-0">{{ $stats['reponses'] ?? 0 }}</h3>
                            <small class="text-success">
                                <i class="fas fa-thumbs-up me-1"></i>
                                Positives
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
                            <h3 class="mb-0">{{ $stats['en_attente'] ?? 0 }}</h3>
                            <small class="text-warning">
                                <i class="fas fa-hourglass-half me-1"></i>
                                En cours
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
                            <div class="bg-info rounded-circle p-3">
                                <i class="fas fa-star text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Score</h6>
                            <h3 class="mb-0">{{ $stats['score'] ?? '4.2/5' }}</h3>
                            <small class="text-info">
                                <i class="fas fa-chart-line me-1"></i>
                                Excellent
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
                            Mes dernières candidatures
                        </h5>
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            Voir tout
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(isset($candidatures) && count($candidatures) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Entreprise</th>
                                        <th class="border-0">Poste</th>
                                        <th class="border-0">Statut</th>
                                        <th class="border-0">Date</th>
                                        <th class="border-0 text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($candidatures as $candidature)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-gradient-{{ $candidature['couleur'] }} rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                            <span class="text-white fw-bold small">{{ $candidature['logo'] }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <small class="fw-bold">{{ $candidature['entreprise'] }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="fw-bold">{{ $candidature['poste'] }}</small>
                                            </td>
                                            <td>
                                                @if($candidature['statut'] === 'acceptée')
                                                    <span class="badge bg-success">Acceptée</span>
                                                @elseif($candidature['statut'] === 'en_attente')
                                                    <span class="badge bg-warning">En attente</span>
                                                @else
                                                    <span class="badge bg-danger">Refusée</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $candidature['date'] }}</small>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-paper-plane fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Aucune candidature pour le moment</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions & Profile -->
        <div class="col-lg-4 mb-4">
            <!-- Profile Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>
                        Mon Profil
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="bg-gradient-info rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                            <span class="text-white fw-bold fs-4">{{ strtoupper(substr(Auth::user()->nom, 0, 1) . substr(Auth::user()->prenom, 0, 1)) }}</span>
                        </div>
                    </div>
                    <h6 class="mb-1">{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</h6>
                    <p class="text-muted mb-2">{{ Auth::user()->email }}</p>
                    @if(Auth::user()->niveau)
                        <span class="badge bg-primary">{{ Auth::user()->niveau }}</span>
                    @endif
                    @if(Auth::user()->specialite)
                        <span class="badge bg-info ms-1">{{ Auth::user()->specialite }}</span>
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
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-search me-2"></i>
                            Rechercher des stages
                        </a>
                        <a href="#" class="btn btn-outline-success">
                            <i class="fas fa-file-alt me-2"></i>
                            Mettre à jour mon CV
                        </a>
                        <a href="#" class="btn btn-outline-info">
                            <i class="fas fa-user-edit me-2"></i>
                            Modifier mon profil
                        </a>
                        <a href="#" class="btn btn-outline-warning">
                            <i class="fas fa-bell me-2"></i>
                            Mes notifications
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recommended Companies -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-star me-2"></i>
                        Entreprises recommandées pour vous
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(isset($entreprisesRecommandees))
                            @foreach($entreprisesRecommandees as $entreprise)
                                <div class="col-md-3 mb-3">
                                    <div class="card border h-100">
                                        <div class="card-body text-center">
                                            <div class="bg-gradient-{{ $entreprise['couleur'] }} rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                                                <span class="text-white fw-bold">{{ $entreprise['logo'] }}</span>
                                            </div>
                                            <h6 class="card-title">{{ $entreprise['nom'] }}</h6>
                                            <p class="card-text small text-muted">{{ $entreprise['domaine'] }}</p>
                                            <a href="#" class="btn btn-sm btn-outline-primary">Voir les offres</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center py-4">
                                <i class="fas fa-building fa-2x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Aucune recommandation pour le moment</p>
                            </div>
                        @endif
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
.bg-gradient-warning {
    background: linear-gradient(45deg, #ffc107, #fd7e14);
}
</style>
@endsection 