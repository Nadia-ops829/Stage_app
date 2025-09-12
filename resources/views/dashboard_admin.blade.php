@extends('layouts.admin')

@section('title', 'Tableau de bord Administrateur')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Tableau de bord Administrateur
                    </h1>
                    <p class="text-muted mb-0">Vue d'ensemble de votre plateforme de gestion de stages</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.entreprises.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-building me-1"></i>
                        Gérer les entreprises
                    </a>
                    <a href="{{ route('admin.etudiants.index') }}" class="btn btn-outline-info">
                        <i class="fas fa-user-graduate me-1"></i>
                        Gérer les étudiants
                    </a>
                    <a href="{{ route('admin.candidatures.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-file-alt me-1"></i>
                        Candidatures
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
                                <i class="fas fa-user-graduate text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Total Étudiants</h6>
                            <h3 class="mb-0">{{ $nbEtudiants ?? 0 }}</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                +{{ $nouveauxEtudiantsMois }} ce mois
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
                                <i class="fas fa-building text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Total Entreprises</h6>
                            <h3 class="mb-0">{{ $nbEntreprises ?? 0 }}</h3>
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
                                <i class="fas fa-handshake text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Stages Actifs</h6>
                            <h3 class="mb-0">{{ $stages->count() ?? 0 }}</h3>
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
                                <i class="fas fa-chart-line text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Taux de Placement</h6>
                            <h3 class="mb-0">{{ $tauxPlacement }}%</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Derniers étudiants et entreprises -->
    <div class="row">
        <!-- Derniers étudiants -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-user-graduate me-2"></i>
                        Derniers étudiants inscrits
                    </h5>
                    <a href="{{ route('admin.etudiants.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body p-0">
                    @if($derniersEtudiants->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Étudiant</th>
                                        <th>Email</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($derniersEtudiants as $etudiant)
                                        <tr>
                                            <td>{{ $etudiant->nom }} {{ $etudiant->prenom }}</td>
                                            <td>{{ $etudiant->email }}</td>
                                            <td>{{ $etudiant->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">Aucun étudiant inscrit récemment</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Dernières entreprises -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-building me-2"></i>
                        Dernières entreprises ajoutées
                    </h5>
                    <a href="{{ route('admin.entreprises.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body p-0">
                    @if($dernieresEntreprises->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Entreprise</th>
                                        <th>Domaine</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dernieresEntreprises as $entreprise)
                                        <tr>
                                            <td>{{ $entreprise->nom }}</td>
                                            <td>{{ $entreprise->domaine ?? 'Non renseigné' }}</td>
                                            <td>{{ $entreprise->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">Aucune entreprise ajoutée récemment</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <!-- Quick Actions -->
<div class="row">
    <div class="col-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i> Actions rapides</h5>
            </div>
            <div class="card-body d-flex flex-column gap-3">
                <a href="{{ route('admin.entreprises.create') }}" class="btn btn-outline-success w-100">
                    Ajouter une entreprise
                </a>
                <a href="{{ route('admin.entreprises.index') }}" class="btn btn-outline-primary w-100">
                    Gérer les entreprises
                </a>
                <a href="{{ route('admin.etudiants.index') }}" class="btn btn-outline-info w-100">
                    Gérer les étudiants
                </a>
                <a href="{{ route('admin.candidatures.index') }}" class="btn btn-outline-secondary w-100">
                    Voir les candidatures
                </a>
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
</style>
@endsection
