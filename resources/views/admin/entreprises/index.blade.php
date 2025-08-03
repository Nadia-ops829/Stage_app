@extends('layouts.admin')

@section('title', 'Gestion des Entreprises')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div>
                    <h1 class="h3 mb-2">
                        <i class="fas fa-building me-2"></i>
                        Gestion des Entreprises
                    </h1>
                    <p class="text-muted mb-0">Gérez toutes les entreprises partenaires de votre plateforme</p>
                </div>
                <div class="mt-3 mt-md-0">
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.entreprises.create') }}" 
                           class="btn btn-success">
                            <i class="fas fa-plus me-1"></i>
                            Ajouter une entreprise
                        </a>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="btn btn-primary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Retour au Dashboard
                        </a>
                    </div>
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
                                <i class="fas fa-building text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Total Entreprises</h6>
                            <h3 class="mb-0">{{ $entreprises->total() }}</h3>
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
                                <i class="fas fa-check-circle text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Actives</h6>
                            <h3 class="mb-0">{{ $entreprises->where('created_at', '>=', now()->subDays(30))->count() }}</h3>
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
                            <h6 class="card-title text-muted mb-1">Nouvelles ce mois</h6>
                            <h3 class="mb-0">{{ $entreprises->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
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
                Liste des Entreprises
            </h5>
        </div>
        
        @if($entreprises->count() > 0)
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">Entreprise</th>
                                <th class="border-0">Contact</th>
                                <th class="border-0">Domaine</th>
                                <th class="border-0">Date d'ajout</th>
                                <th class="border-0 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($entreprises as $entreprise)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <span class="text-white fw-bold">{{ strtoupper(substr($entreprise->nom, 0, 2)) }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">{{ $entreprise->nom }}</h6>
                                                <span class="badge bg-success">Actif</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="fas fa-envelope text-muted me-2"></i>
                                                <small>{{ $entreprise->email }}</small>
                                            </div>
                                            @if($entreprise->adresse)
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                                    <small class="text-muted">{{ Str::limit($entreprise->adresse, 30) }}</small>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $entreprise->domaine ?? 'Non renseigné' }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $entreprise->created_at->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.entreprises.edit', $entreprise->id) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.entreprises.destroy', $entreprise->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="card-body text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-building fa-3x text-muted"></i>
                </div>
                <h5 class="text-muted">Aucune entreprise</h5>
                <p class="text-muted">Commencez par ajouter votre première entreprise.</p>
                <a href="{{ route('admin.entreprises.create') }}" 
                   class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Ajouter une entreprise
                </a>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($entreprises->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $entreprises->links() }}
        </div>
    @endif
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #007bff, #6610f2);
}
</style>
@endsection

