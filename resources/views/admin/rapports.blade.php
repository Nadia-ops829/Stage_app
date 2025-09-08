
@extends('layouts.admin')

@section('title', 'Rapports')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <h1 class="h3 mb-0 text-primary fw-bold">
                    <i class="fas fa-book me-2"></i> Rapports
                </h1>
                <a href="#" class="btn btn-gradient-primary text-white shadow-sm">
                    <i class="fas fa-download me-1"></i> Exporter PDF
                </a>
            </div>
            <p class="text-muted mt-2 mb-0">Visualisez et exportez les rapports de la plateforme.</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white mb-3">
                <div class="card-body">
                    <h6 class="card-title mb-1">Total Rapports</h6>
                    <h2 class="fw-bold mb-0">--</h2>
                    <small>À personnaliser</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-gradient-info text-white mb-3">
                <div class="card-body">
                    <h6 class="card-title mb-1">Rapports validés</h6>
                    <h2 class="fw-bold mb-0">--</h2>
                    <small>À personnaliser</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-gradient-secondary text-white mb-3">
                <div class="card-body">
                    <h6 class="card-title mb-1">Rapports en attente</h6>
                    <h2 class="fw-bold mb-0">--</h2>
                    <small>À personnaliser</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex align-items-center justify-content-between">
            <h5 class="mb-0"><i class="fas fa-table me-2"></i> Liste des rapports</h5>
            <a href="#" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus me-1"></i> Nouveau rapport</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                           
                            <th>Étudiant</th>
                            <th>Stage</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rapports as $rapport)
                            <tr>
                                <td>{{ $rapport->id }}</td>
                                <td>{{ $rapport->etudiant->nom ?? '-' }} {{ $rapport->etudiant->prenom ?? '' }}</td>
                                <td>{{ $rapport->stage->titre ?? '-' }}</td>
                                <td>{{ $rapport->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if($rapport->statut === 'valide')
                                        <span class="badge bg-success">Validé</span>
                                    @else
                                        <span class="badge bg-warning text-dark">En attente</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-secondary"><i class="fas fa-download"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucun rapport trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #667eea, #764ba2) !important;
}
.bg-gradient-info {
    background: linear-gradient(45deg, #17a2b8, #20c997) !important;
}
.bg-gradient-secondary {
    background: linear-gradient(45deg, #6c757d, #adb5bd) !important;
}
.btn-gradient-primary {
    background: linear-gradient(45deg, #667eea, #764ba2) !important;
    border: none;
}
.btn-gradient-primary:hover {
    background: linear-gradient(45deg, #764ba2, #667eea) !important;
}
</style>

@endsection
