@extends('layouts.admin')

@section('title', 'Gestion des Étudiants')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div>
                    <h1 class="h3 mb-2">
                        <i class="fas fa-user-graduate me-2"></i>
                        Gestion des Étudiants
                    </h1>
                    <p class="text-muted mb-0">Gérez tous les étudiants inscrits sur votre plateforme</p>
                </div>
                <div class="mt-3 mt-md-0">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Retour au Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary rounded-circle p-3">
                                <i class="fas fa-user-graduate text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Total Étudiants</h6>
                            <h3 class="mb-0">{{ $etudiants->total() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success rounded-circle p-3">
                                <i class="fas fa-user-check text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Actifs</h6>
                            <h3 class="mb-0">{{ $etudiants->where('created_at', '>=', now()->subDays(30))->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning rounded-circle p-3">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Nouveaux ce mois</h6>
                            <h3 class="mb-0">{{ $etudiants->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content -->
    <div class="card border-0 shadow">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>
                Liste des Étudiants
            </h5>
        </div>
        
        @if($etudiants->count() > 0)
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">Étudiant</th>
                                <th class="border-0">Contact</th>
                                <th class="border-0">Formation</th>
                                <th class="border-0">Date d'inscription</th>
                                <th class="border-0 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($etudiants as $etudiant)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="bg-gradient-info rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <span class="text-white fw-bold">{{ strtoupper(substr($etudiant->nom, 0, 1) . substr($etudiant->prenom, 0, 1)) }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">{{ $etudiant->nom }} {{ $etudiant->prenom }}</h6>
                                                <span class="badge bg-success">Actif</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="fas fa-envelope text-muted me-2"></i>
                                                <small>{{ $etudiant->email }}</small>
                                            </div>
                                            @if($etudiant->telephone)
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-phone text-muted me-2"></i>
                                                    <small class="text-muted">{{ $etudiant->telephone }}</small>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            @if($etudiant->niveau)
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="fas fa-graduation-cap text-muted me-2"></i>
                                                    <small>{{ $etudiant->niveau }}</small>
                                                </div>
                                            @endif
                                            @if($etudiant->specialite)
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-book text-muted me-2"></i>
                                                    <small class="text-muted">{{ $etudiant->specialite }}</small>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $etudiant->created_at->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-info" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#studentModal{{ $etudiant->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal for student details -->
                                <div class="modal fade" id="studentModal{{ $etudiant->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-user-graduate me-2"></i>
                                                    Détails de l'étudiant
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p><strong>Nom :</strong> {{ $etudiant->nom }}</p>
                                                        <p><strong>Prénom :</strong> {{ $etudiant->prenom }}</p>
                                                        <p><strong>Email :</strong> {{ $etudiant->email }}</p>
                                                        <p><strong>Téléphone :</strong> {{ $etudiant->telephone ?? 'Non renseigné' }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p><strong>Niveau :</strong> {{ $etudiant->niveau ?? 'Non renseigné' }}</p>
                                                        <p><strong>Spécialité :</strong> {{ $etudiant->specialite ?? 'Non renseigné' }}</p>
                                                        <p><strong>Adresse :</strong> {{ $etudiant->adresse ?? 'Non renseigné' }}</p>
                                                        <p><strong>Inscrit le :</strong> {{ $etudiant->created_at->format('d/m/Y à H:i') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                <a href="#" class="btn btn-primary">Modifier</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="card-body text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-user-graduate fa-3x text-muted"></i>
                </div>
                <h5 class="text-muted">Aucun étudiant</h5>
                <p class="text-muted">Aucun étudiant n'est encore inscrit sur la plateforme.</p>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($etudiants->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $etudiants->links() }}
        </div>
    @endif
</div>

<style>
.bg-gradient-info {
    background: linear-gradient(45deg, #17a2b8, #20c997);
}
</style>
@endsection 