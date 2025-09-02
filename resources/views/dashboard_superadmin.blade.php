@extends('layouts.admin')

@section('title', 'Dashboard Super Administrateur')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2">
                        <i class="fas fa-crown me-2"></i>
                        Dashboard Super Administrateur
                    </h1>
                    <p class="text-muted mb-0">Contrôle total de la plateforme de gestion de stages</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('superadmin.admins.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-users-cog me-1"></i>
                        Gérer les admins
                    </a>
                    <a href="#" class="btn btn-outline-success">
                        <i class="fas fa-chart-line me-1"></i>
                        Statistiques globales
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
                                <i class="fas fa-users-cog text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Administrateurs</h6>
                            <h3 class="mb-0">{{ \App\Models\User::where('role', 'admin')->count() }}</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                +{{ \App\Models\User::where('role', 'admin')->where('created_at', '>=', now()->startOfMonth())->count() }} ce mois
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
                                <i class="fas fa-user-graduate text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Total Étudiants</h6>
                            <h3 class="mb-0">{{ $totalEtudiants }}</h3>
                            <small class="text-success">
                                <i class="fas fa-thumbs-up me-1"></i>
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
                            <div class="bg-warning rounded-circle p-3">
                                <i class="fas fa-building text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Total Entreprises</h6>
                            <h3 class="mb-0">{{ $totalEntreprises }}</h3>
                            <small class="text-warning">
                                <i class="fas fa-clock me-1"></i>
                                +{{ $nouvellesEntreprisesMois }} ce mois
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
                                <i class="fas fa-handshake text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Stages Actifs</h6>
                            <h3 class="mb-0">{{ $totalStages }}</h3>
                            <small class="text-info">
                                <i class="fas fa-chart-line me-1"></i>
                                +{{ $nouveauxStagesMois }} ce mois
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- System Overview -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar me-2"></i>
                            Vue d'ensemble du système
                        </h5>
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            Voir détails
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card border h-100">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-server me-2"></i>
                                        Performance système
                                    </h6>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small>CPU</small>
                                            <small>65%</small>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-success" style="width: 65%"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small>Mémoire</small>
                                            <small>42%</small>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-info" style="width: 42%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <small>Stockage</small>
                                            <small>78%</small>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-warning" style="width: 78%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border h-100">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-shield-alt me-2"></i>
                                        Sécurité
                                    </h6>
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span class="small">Authentification sécurisée</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span class="small">Chiffrement SSL actif</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span class="small">Sauvegarde automatique</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                            <span class="small">Mise à jour recommandée</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Profile -->
        <div class="col-lg-4 mb-4">
            <!-- Superadmin Profile Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-crown me-2"></i>
                        Super Administrateur
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="bg-gradient-warning rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                            <span class="text-white fw-bold fs-4">{{ strtoupper(substr(Auth::user()->nom, 0, 1) . substr(Auth::user()->prenom, 0, 1)) }}</span>
                        </div>
                    </div>
                    <h6 class="mb-1">{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</h6>
                    <p class="text-muted mb-2">{{ Auth::user()->email }}</p>
                    <span class="badge bg-warning">Super Administrateur</span>
                    <p class="text-muted small mt-2 mb-0">
                        <i class="fas fa-calendar me-1"></i>
                        Connecté depuis {{ now()->format('d/m/Y à H:i') }}
                    </p>
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
                        <a href="{{ route('superadmin.admins.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-users-cog me-2"></i>
                            Gérer les administrateurs
                        </a>
                        <a href="#" class="btn btn-outline-success">
                            <i class="fas fa-chart-line me-2"></i>
                            Statistiques globales
                        </a>
                        <a href="#" class="btn btn-outline-info">
                            <i class="fas fa-cog me-2"></i>
                            Configuration système
                        </a>
                        <a href="#" class="btn btn-outline-warning">
                            <i class="fas fa-database me-2"></i>
                            Sauvegarde
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Management -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-tools me-2"></i>
                        Gestion du système
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="card border h-100">
                                <div class="card-body text-center">
                                    <div class="bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                                        <i class="fas fa-users-cog text-white"></i>
                                    </div>
                                    <h6 class="card-title">Administrateurs</h6>
                                    <p class="card-text small text-muted">Gérer les comptes admin</p>
                                    <a href="{{ route('superadmin.admins.index') }}" class="btn btn-sm btn-outline-primary">Gérer</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border h-100">
                                <div class="card-body text-center">
                                    <div class="bg-gradient-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                                        <i class="fas fa-chart-line text-white"></i>
                                    </div>
                                    <h6 class="card-title">Statistiques</h6>
                                    <p class="card-text small text-muted">Analyses détaillées</p>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border h-100">
                                <div class="card-body text-center">
                                    <div class="bg-gradient-info rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                                        <i class="fas fa-cog text-white"></i>
                                    </div>
                                    <h6 class="card-title">Configuration</h6>
                                    <p class="card-text small text-muted">Paramètres système</p>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Configurer</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border h-100">
                                <div class="card-body text-center">
                                    <div class="bg-gradient-warning rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                                        <i class="fas fa-shield-alt text-white"></i>
                                    </div>
                                    <h6 class="card-title">Sécurité</h6>
                                    <p class="card-text small text-muted">Contrôles de sécurité</p>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Sécuriser</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>
                        Activité récente du système
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">Action</th>
                                    <th class="border-0">Utilisateur</th>
                                    <th class="border-0">Détails</th>
                                    <th class="border-0">Date</th>
                                    <th class="border-0">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <i class="fas fa-user-plus text-success me-2"></i>
                                        Nouvel administrateur créé
                                    </td>
                                    <td>admin@example.com</td>
                                    <td>Compte admin ajouté</td>
                                    <td>15/01/2025 14:30</td>
                                    <td><span class="badge bg-success">Succès</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fas fa-database text-info me-2"></i>
                                        Sauvegarde automatique
                                    </td>
                                    <td>Système</td>
                                    <td>Base de données sauvegardée</td>
                                    <td>15/01/2025 02:00</td>
                                    <td><span class="badge bg-success">Succès</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                        Tentative de connexion échouée
                                    </td>
                                    <td>unknown@example.com</td>
                                    <td>IP: 192.168.1.100</td>
                                    <td>15/01/2025 13:45</td>
                                    <td><span class="badge bg-danger">Échec</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fas fa-chart-line text-primary me-2"></i>
                                        Rapport généré
                                    </td>
                                    <td>superadmin@example.com</td>
                                    <td>Rapport mensuel</td>
                                    <td>15/01/2025 10:15</td>
                                    <td><span class="badge bg-success">Succès</span></td>
                                </tr>
                            </tbody>
                        </table>
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
.bg-gradient-success {
    background: linear-gradient(45deg, #28a745, #20c997);
}
.bg-gradient-info {
    background: linear-gradient(45deg, #17a2b8, #20c997);
}
.bg-gradient-warning {
    background: linear-gradient(45deg, #ffc107, #fd7e14);
}
</style>
@endsection 