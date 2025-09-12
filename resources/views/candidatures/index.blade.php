@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-briefcase me-2"></i>
                    Toutes les candidatures reçues
                </h1>
                <a href="{{ route('stages.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Retour aux offres
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($candidatures->count() > 0)
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Étudiant</th>
                                    <th>Email</th>
                                    <th>Stage</th>
                                    <th>Date de candidature</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($candidatures as $candidature)
                                    <tr>
                                        <td>
                                            <strong>{{ $candidature->etudiant->nom }} {{ $candidature->etudiant->prenom }}</strong>
                                        </td>
                                        <td>{{ $candidature->etudiant->email }}</td>
                                        <td>{{ $candidature->stage->titre ?? 'Non défini' }}</td>
                                        <td>{{ $candidature->created_at->format('d/m/Y H:i') }}</td>
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
                        {{ $candidatures->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Aucune candidature trouvée</h4>
                    <p class="text-muted">Aucune candidature n’a encore été déposée.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal réponse -->
<div class="modal fade" id="repondreModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="repondreForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Répondre à la candidature</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="commentaire" class="form-label">Commentaire (optionnel)</label>
                        <textarea class="form-control" name="commentaire" id="commentaire" rows="3"></textarea>
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
