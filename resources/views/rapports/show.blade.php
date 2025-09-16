@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        Détails du Rapport de Stage
                    </h5>
                    <div>
                        <span class="badge bg-{{ $rapport->statut === 'valide' ? 'success' : ($rapport->statut === 'refuse' ? 'danger' : 'warning') }} fs-6">
                            {{ ucfirst($rapport->statut) }}
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Informations sur le stage</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong><i class="fas fa-heading me-2"></i>Titre :</strong> {{ $rapport->stage->titre ?? 'N/A' }}</p>
                                    <p><strong><i class="fas fa-building me-2"></i>Entreprise :</strong> {{ $rapport->stage->entreprise->nom ?? 'N/A' }}</p>
                                    <p><strong><i class="far fa-calendar-alt me-2"></i>Période :</strong> 
                                        {{ $rapport->stage->date_debut ? $rapport->stage->date_debut->format('d/m/Y') : 'N/A' }} - 
                                        {{ $rapport->stage->date_fin ? $rapport->stage->date_fin->format('d/m/Y') : 'N/A' }}
                                    </p>
                                    <p><strong><i class="fas fa-user-graduate me-2"></i>Étudiant :</strong> 
                                        {{ $rapport->etudiant->user->prenom ?? 'N/A' }} {{ $rapport->etudiant->user->nom ?? '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Détails du dépôt</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong><i class="far fa-calendar-check me-2"></i>Date de dépôt :</strong> 
                                        {{ $rapport->date_depot->format('d/m/Y à H:i') }}
                                    </p>
                                    @if($rapport->date_validation)
                                        <p><strong><i class="fas fa-check-circle me-2"></i>Date de validation :</strong> 
                                            {{ $rapport->date_validation->format('d/m/Y à H:i') }}
                                        </p>
                                    @endif
                                    <p class="mb-0"><strong><i class="fas fa-file me-2"></i>Fichier :</strong></p>
                                    <a href="{{ route('rapports.telecharger', $rapport->id) }}" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="fas fa-download me-1"></i> Télécharger le rapport
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mb-4">
                        @if($rapport->commentaire_etudiant)
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-comment-alt me-2"></i>Commentaire de l'étudiant</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="p-3 bg-light rounded">
                                            {{ $rapport->commentaire_etudiant }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($rapport->commentaire_entreprise)
                            <div class="col-md-6">
                                <div class="card h-100 border-{{ $rapport->statut === 'refuse' ? 'danger' : 'success' }}">
                                    <div class="card-header bg-{{ $rapport->statut === 'refuse' ? 'danger text-white' : 'light' }}">
                                        <h6 class="mb-0">
                                            <i class="fas fa-building me-2"></i>
                                            Retour de l'entreprise
                                            @if($rapport->statut === 'refuse')
                                                <span class="badge bg-white text-danger ms-2">Refusé</span>
                                            @elseif($rapport->statut === 'valide')
                                                <span class="badge bg-white text-success ms-2">Validé</span>
                                            @endif
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        @if($rapport->statut === 'refuse')
                                            <div class="alert alert-danger">
                                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Motif du refus :</h6>
                                                <div class="p-3 bg-white rounded mt-2">
                                                    {{ $rapport->commentaire_entreprise }}
                                                </div>
                                            </div>
                                            
                                            @if(auth()->user()->isEtudiant())
                                                <div class="alert alert-info mt-3">
                                                    <i class="fas fa-info-circle me-2"></i>
                                                    Vous pouvez modifier votre rapport en cliquant sur le bouton "Modifier le rapport".
                                                </div>
                                            @endif
                                        @else
                                            <div class="p-3 bg-light rounded">
                                                {{ $rapport->commentaire_entreprise ?? 'Aucun commentaire supplémentaire.' }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if(auth()->user()->isEntreprise() && $rapport->statut == 'en_attente')
                        <div class="card border-primary mb-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>Validation du rapport</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('rapports.valider', $rapport->id) }}" method="POST" id="validationForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="statut" class="form-label">Décision <span class="text-danger">*</span></label>
                                            <select name="statut" id="statut" class="form-select" required>
                                                <option value="valide">Valider le rapport</option>
                                                <option value="refuse">Refuser le rapport</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3" id="commentaireContainer">
                                        <label for="commentaire_entreprise" class="form-label">
                                            Commentaire <span id="commentRequired" class="text-danger d-none">*</span>
                                            <small class="text-muted">(Obligatoire en cas de refus)</small>
                                        </label>
                                        <textarea name="commentaire_entreprise" id="commentaire_entreprise" 
                                                class="form-control" rows="4"
                                                placeholder="Saisissez votre commentaire ici..."></textarea>
                                        <div class="form-text">
                                            En cas de refus, veuillez préciser les modifications nécessaires.
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('rapports.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i> Annuler
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-check-circle me-1"></i> Enregistrer la décision
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        @push('scripts')
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const statutSelect = document.getElementById('statut');
                                const commentaireField = document.getElementById('commentaire_entreprise');
                                const commentRequired = document.getElementById('commentRequired');
                                const form = document.getElementById('validationForm');
                                
                                function toggleCommentRequired() {
                                    if (statutSelect.value === 'refuse') {
                                        commentRequired.classList.remove('d-none');
                                        commentaireField.setAttribute('required', 'required');
                                    } else {
                                        commentRequired.classList.add('d-none');
                                        commentaireField.removeAttribute('required');
                                    }
                                }
                                
                                // Au chargement
                                toggleCommentRequired();
                                
                                // Quand la sélection change
                                statutSelect.addEventListener('change', toggleCommentRequired);
                                
                                // Validation du formulaire
                                form.addEventListener('submit', function(e) {
                                    if (statutSelect.value === 'refuse' && !commentaireField.value.trim()) {
                                        e.preventDefault();
                                        alert('Veuillez saisir un motif de refus.');
                                        commentaireField.focus();
                                    }
                                });
                            });
                        </script>
                        @endpush
                    @endif

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('rapports.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                        </a>
                        
                        <div class="btn-group">
                            @if(auth()->user()->isEtudiant() && $rapport->statut !== 'valide')
                                <a href="{{ route('rapports.edit', $rapport->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-1"></i> Modifier le rapport
                                </a>
                                
                                <form action="{{ route('rapports.destroy', $rapport->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rapport ? Cette action est irréversible.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger ms-2">
                                        <i class="fas fa-trash-alt me-1"></i> Supprimer
                                    </button>
                                </form>
                            @endif
                            
                            @if(auth()->user()->isAdmin())
                                <a href="#" class="btn btn-outline-danger ms-2"
                                   onclick="event.preventDefault(); document.getElementById('deleteForm').submit();">
                                    <i class="fas fa-trash-alt me-1"></i> Supprimer (Admin)
                                </a>
                                <form id="deleteForm" action="{{ route('rapports.destroy', $rapport->id) }}" 
                                      method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
