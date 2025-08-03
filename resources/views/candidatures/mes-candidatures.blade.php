@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-paper-plane me-2"></i>
                    Mes Candidatures
                </h1>
                <a href="{{ route('stages.index') }}" class="btn btn-primary">
                    <i class="fas fa-search me-2"></i>
                    Rechercher des Stages
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
                <div class="row">
                    @foreach($candidatures as $candidature)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">
                                            <i class="fas fa-briefcase me-2"></i>
                                            {{ $candidature->stage->titre }}
                                        </h6>
                                        <span class="badge bg-light text-dark">
                                            @if($candidature->statut === 'en_attente')
                                                <i class="fas fa-clock me-1"></i> En attente
                                            @elseif($candidature->statut === 'acceptee')
                                                <i class="fas fa-check-circle me-1"></i> Acceptée
                                            @else
                                                <i class="fas fa-times-circle me-1"></i> Refusée
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Entreprise :</strong>
                                        <span class="text-muted">{{ $candidature->stage->entreprise->nom }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Date de candidature :</strong>
                                        <span class="text-muted">{{ $candidature->date_candidature->format('d/m/Y H:i') }}</span>
                                    </div>
                                    @if($candidature->date_reponse)
                                        <div class="mb-3">
                                            <strong>Date de réponse :</strong>
                                            <span class="text-muted">{{ $candidature->date_reponse->format('d/m/Y H:i') }}</span>
                                        </div>
                                    @endif
                                    @if($candidature->commentaire_entreprise)
                                        <div class="mb-3">
                                            <strong>Commentaire :</strong>
                                            <p class="text-muted small mb-0">{{ $candidature->commentaire_entreprise }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('stages.show', $candidature->stage) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i>
                                            Voir l'offre
                                        </a>
                                        <a href="{{ route('candidatures.show', $candidature) }}" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $candidatures->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-paper-plane fa-3x text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-3">Aucune candidature</h4>
                    <p class="text-muted mb-4">Vous n'avez pas encore postulé à des offres de stage.</p>
                    <a href="{{ route('stages.index') }}" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>
                        Rechercher des Stages
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 