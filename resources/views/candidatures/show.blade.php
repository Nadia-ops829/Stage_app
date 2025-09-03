@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-file-alt me-2"></i>
                    Détails de la Candidature
                </h1>
                <div>
                    @if(Auth::user()->role === 'etudiant')
                        <a href="{{ route('candidatures.mes-candidatures') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Retour à mes candidatures
                        </a>
                    @elseif(Auth::user()->role === 'entreprise')
                        <a href="{{ route('candidatures.recues') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Retour aux candidatures
                        </a>
                    @endif
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Informations sur le stage -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-briefcase me-2"></i>
                                Offre de Stage
                            </h5>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">{{ $candidature->stage->titre }}</h6>
                            <p class="text-muted">{{ $candidature->stage->description }}</p>
                            
                            <div class="row">
                                <div class="col-6">
                                    <strong>Entreprise :</strong>
                                    
                                </div>
                                <div class="col-6">
                                    <strong>Domaine :</strong>
                                    <p class="text-muted">{{ $candidature->stage->domaine }}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-6">
                                    <strong>Lieu :</strong>
                                    <p class="text-muted">{{ $candidature->stage->lieu }}</p>
                                </div>
                                <div class="col-6">
                                    <strong>Durée :</strong>
                                    <p class="text-muted">{{ $candidature->stage->duree }}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-6">
                                    <strong>Niveau requis :</strong>
                                    <p class="text-muted">{{ $candidature->stage->niveau_requis }}</p>
                                </div>
                                <div class="col-6">
                                    <strong>Rémunération :</strong>
                                    <p class="text-muted">{{ $candidature->stage->remuneration ? number_format($candidature->stage->remuneration, 2) . ' €' : 'Non spécifiée' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations sur l'étudiant -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user-graduate me-2"></i>
                                Informations Étudiant
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar me-3">
                                    <span class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                        {{ strtoupper(substr($candidature->etudiant->nom, 0, 1) . substr($candidature->etudiant->prenom, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <h6 class="mb-1">{{ $candidature->etudiant->nom }} {{ $candidature->etudiant->prenom }}</h6>
                                    <p class="text-muted mb-0">{{ $candidature->etudiant->email }}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-6">
                                    <strong>Téléphone :</strong>
                                    <p class="text-muted">{{ $candidature->etudiant->telephone ?? 'Non renseigné' }}</p>
                                </div>
                                <div class="col-6">
                                    <strong>Niveau :</strong>
                                    <p class="text-muted">{{ $candidature->etudiant->niveau ?? 'Non renseigné' }}</p>
                                </div>
                            </div>
                            
                            @if($candidature->etudiant->spécialité)
                                <div class="row">
                                    <div class="col-12">
                                        <strong>Spécialité :</strong>
                                        <p class="text-muted">{{ $candidature->etudiant->spécialité }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            @if($candidature->etudiant->adresse)
                                <div class="row">
                                    <div class="col-12">
                                        <strong>Adresse :</strong>
                                        <p class="text-muted">{{ $candidature->etudiant->adresse }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Détails de la candidature -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-file-alt me-2"></i>
                                Détails de la Candidature
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Date de candidature :</strong>
                                    <p class="text-muted">{{ $candidature->date_candidature->format('d/m/Y à H:i') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>Statut :</strong>
                                    <p>
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
                                    </p>
                                </div>
                            </div>
                            
                            @if($candidature->date_reponse)
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Date de réponse :</strong>
                                        <p class="text-muted">{{ $candidature->date_reponse->format('d/m/Y à H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            
                             @if($candidature->lettre_motivation_path)
                                <div class="row">
                                    <div class="col-12">
                                        <strong>Lettre_motivation :</strong>
                                        <div class="mt-2">
                                            <a href="{{ Storage::url($candidature->lettre_motivation_path) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                                <i class="fas fa-download me-2"></i>
                                                Télécharger la lettre de motivation
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            @if($candidature->cv_path)
                                <div class="row">
                                    <div class="col-12">
                                        <strong>CV :</strong>
                                        <div class="mt-2">
                                            <a href="{{ Storage::url($candidature->cv_path) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                                <i class="fas fa-download me-2"></i>
                                                Télécharger le CV
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @if($candidature->commentaire_entreprise)
                                <div class="row">
                                    <div class="col-12">
                                        <strong>Commentaire de l'entreprise :</strong>
                                        <div class="mt-2 p-3 bg-light rounded">
                                            <p class="mb-0">{{ $candidature->commentaire_entreprise }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions pour l'entreprise -->
            @if(Auth::user()->role === 'entreprise' && Auth::id() === $candidature->stage->entreprise_id && $candidature->statut === 'en_attente')
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-warning text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-reply me-2"></i>
                                    Répondre à la Candidature
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('candidatures.repondre', $candidature) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="statut" class="form-label">Décision</label>
                                                <select class="form-select" id="statut" name="statut" required>
                                                    <option value="">Choisir une décision</option>
                                                    <option value="acceptee">Accepter la candidature</option>
                                                    <option value="refusee">Refuser la candidature</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="commentaire" class="form-label">Commentaire (optionnel)</label>
                                                <textarea class="form-control" id="commentaire" name="commentaire" rows="3" placeholder="Ajoutez un commentaire..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-2"></i>
                                            Envoyer la réponse
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 