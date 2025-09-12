@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Détails du Rapport de Stage
                </div>
                

                <div class="card-body">
                    <div class="mb-4">
                        <h5>Informations sur le stage</h5>
                        <hr>
                        <p><strong>Titre du stage :</strong> {{ $rapport->stage->titre ?? 'N/A' }}</p>
                        <p><strong>Entreprise :</strong> {{ $rapport->stage->entreprise->nom ?? 'N/A' }}</p>
                        <p><strong>Période :</strong> 
                            {{ $rapport->stage->date_debut ? $rapport->stage->date_debut->format('d/m/Y') : 'N/A' }} - 
                            {{ $rapport->stage->date_fin ? $rapport->stage->date_fin->format('d/m/Y') : 'N/A' }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <h5>Informations sur le rapport</h5>
                        <hr>
                        <p><strong>Date de dépôt :</strong> {{ $rapport->date_depot->format('d/m/Y H:i') }}</p>
                        <p><strong>Statut :</strong> 
                            @php
                                $badgeClass = [
                                    'en_attente' => 'bg-warning',
                                    'valide' => 'bg-success',
                                    'refuse' => 'bg-danger'
                                ][$rapport->statut] ?? 'bg-secondary';
                            @endphp
                            <span class="badge {{ $badgeClass }}">
                                {{ ucfirst($rapport->statut) }}
                            </span>
                        </p>
                        @if($rapport->date_validation)
                            <p><strong>Date de validation :</strong> {{ $rapport->date_validation->format('d/m/Y H:i') }}</p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h5>Commentaire étudiant</h5>
                        <hr>
                        <div class="p-3 bg-light rounded">
                            {{ $rapport->commentaire_etudiant ?? 'Aucun commentaire.' }}
                        </div>
                    </div>

                    @if($rapport->commentaire_entreprise)
                        <div class="mb-4">
                            <h5>Commentaire de l'entreprise</h5>
                            <hr>
                            <div class="p-3 bg-light rounded">
                                {{ $rapport->commentaire_entreprise }}
                            </div>
                        </div>
                    @endif

                    @if(auth()->user()->role == 'entreprise' && $rapport->statut == 'en_attente')
                        <div class="mb-4">
                            <h5>Validation du rapport</h5>
                            <hr>
                            <form action="{{ route('rapports.valider', $rapport->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="statut" class="form-label">Statut</label>
                                    <select name="statut" id="statut" class="form-select" required>
                                        <option value="valide">Valider</option>
                                        <option value="refuse">Refuser</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="commentaire_entreprise" class="form-label">Commentaire (optionnel)</label>
                                    <textarea name="commentaire_entreprise" id="commentaire_entreprise" 
                                              class="form-control" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </form>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('rapports.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour à la liste
                        </a>
                        <div></div>
                        
                        <div>
                            <a href="{{ route('rapports.telecharger', $rapport->id) }}" 
                               class="btn btn-primary">
                                <i class="fas fa-download"></i> Télécharger le rapport
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
