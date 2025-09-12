@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-users me-2"></i>
                    Candidatures Reçues
                </h1>
                <a href="{{ route('stages.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Publier une offre
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @php
                $totalCandidatures = 0;
                $candidaturesEnAttente = 0;
                foreach($stages as $stage) {
                    $totalCandidatures += $stage->candidatures->count();
                    $candidaturesEnAttente += $stage->candidatures->where('statut', 'en_attente')->count();
                }
            @endphp

           <!-- Statistiques -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $totalCandidatures }}</h4>
                        <small>Total candidatures</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $candidaturesEnAttente }}</h4>
                        <small>En attente</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $candidaturesRefusees }}</h4>
                        <small>Candidatures refusées</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-times-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $candidaturesAcceptees }}</h4>
                        <small>Candidatures acceptées</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Statistiques -->
<div class="row mb-4">
    <!-- ... tes 4 cartes ici ... -->
</div>

<!-- Liste des candidatures -->
<div class="card">
    <div class="card-header bg-secondary text-white">
        <h5 class="mb-0">Liste des candidatures</h5>
    </div>
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Étudiant</th>
                    <th>Stage</th>
                    <th>Date de candidature</th>
                    <th>Statut</th>
                    <th>Commentaire</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stages as $stage)
                    @foreach($stage->candidatures as $candidature)
                        <tr>
                            <td>{{ $candidature->etudiant->nom }} {{ $candidature->etudiant->prenom }}</td>
                            <td>{{ $stage->titre }}</td>
                            <td>{{ $candidature->date_candidature->format('d/m/Y') }}</td>
                            <td>
                                @if($candidature->statut === 'en_attente')
                                    <span class="badge bg-warning text-dark">En attente</span>
                                @elseif($candidature->statut === 'acceptee')
                                    <span class="badge bg-success">Acceptée</span>
                                @else
                                    <span class="badge bg-danger">Refusée</span>
                                @endif
                            </td>
                            <td>{{ $candidature->commentaire_entreprise ?? '-' }}</td>
                            <td>
                                <a href="{{ route('candidatures.show', $candidature) }}" class="btn btn-sm btn-primary">
                                    Voir
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>



            @if($stages->count() > 0)
                @foreach($stages as $stage)
                    @if($stage->candidatures->count() > 0)
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-briefcase me-2"></i>
                                        {{ $stage->titre }}
                                    </h5>
                                    <span class="badge bg-primary">{{ $stage->candidatures->count() }} candidature(s)</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Étudiant</th>
                                                <th>Date de candidature</th>
                                                <th>Statut</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($stage->candidatures as $candidature)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar me-3">
                                                                <span class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                    {{ strtoupper(substr($candidature->etudiant->nom, 0, 1) . substr($candidature->etudiant->prenom, 0, 1)) }}
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <strong>{{ $candidature->etudiant->nom }} {{ $candidature->etudiant->prenom }}</strong>
                                                                <br>
                                                                <small class="text-muted">{{ $candidature->etudiant->email }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">{{ $candidature->date_candidature->format('d/m/Y H:i') }}</small>
                                                    </td>
                                                    <td>
                                                        @if($candidature->statut === 'en_attente')
                                                            <span class="badge bg-warning">
                                                                <i class="fas fa-clock me-1"></i> En attente
                                                            </span>
                                                        @elseif($candidature->statut === 'acceptee')
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-check-circle me-1"></i> Acceptée
                                                            </span>
                                                        @else
                                                            <span class="badge bg-danger">
                                                                <i class="fas fa-times-circle me-1"></i> Refusée
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('candidatures.show', $candidature) }}" class="btn btn-outline-primary btn-sm">
                                                                <i class="fas fa-eye me-1"></i> Voir
                                                            </a>
                                                            @if($candidature->statut === 'en_attente')
                                                                <button type="button" class="btn btn-outline-success btn-sm" onclick="repondreCandidature({{ $candidature->id }}, 'acceptee')">
                                                                    <i class="fas fa-check me-1"></i> Accepter
                                                                </button>
                                                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="repondreCandidature({{ $candidature->id }}, 'refusee')">
                                                                    <i class="fas fa-times me-1"></i> Refuser
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-users fa-3x text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-3">Aucune candidature</h4>
                    <p class="text-muted mb-4">Vous n'avez pas encore reçu de candidatures pour vos offres de stage.</p>
                    <a href="{{ route('stages.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Publier une offre
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal pour répondre aux candidatures -->
<div class="modal fade" id="repondreModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Répondre à la candidature</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="repondreForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="commentaire" class="form-label">Commentaire (optionnel)</label>
                        <textarea class="form-control" id="commentaire" name="commentaire" rows="3" placeholder="Ajoutez un commentaire..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Confirmer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function repondreCandidature(candidatureId, statut) {
    const form = document.getElementById('repondreForm');
    form.action = `/candidatures/${candidatureId}/repondre`;
    
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'statut';
    input.value = statut;
    form.appendChild(input);
    
    const modal = new bootstrap.Modal(document.getElementById('repondreModal'));
    modal.show();
}
</script>
@endsection 