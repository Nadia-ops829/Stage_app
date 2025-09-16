@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Déposer mon rapport de stage
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('rapports.store') }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="stage_id" value="{{ request('stage_id') }}">
                        
                        <div class="alert alert-info">
                            <h5>Dépôt de rapport pour le stage :</h5>
                            @php
                                $stage = \App\Models\Stage::with('entreprise')->findOrFail(request('stage_id'));
                            @endphp
                            <p><strong>Titre :</strong> {{ $stage->titre }}</p>
                            <p><strong>Entreprise :</strong> {{ $stage->entreprise->nom }}</p>
                            <p><strong>Période :</strong> du {{ \Carbon\Carbon::parse($stage->date_debut)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($stage->date_fin)->format('d/m/Y') }}</p>
                        </div>

                        <div class="mb-3">
                            <label for="fichier" class="form-label">Fichier du rapport <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('fichier') is-invalid @enderror" 
                                   id="fichier" name="fichier" required 
                                   accept=".pdf,.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                            <div class="form-text">
                                Formats acceptés : PDF, DOC, DOCX. Taille maximale : 10 Mo.
                                Le nom du fichier doit être clair et explicite (ex: Rapport_Stage_NomPrenom_Annee.pdf).
                            </div>
                            @error('fichier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        <div class="mb-3">
                            <label for="commentaire_etudiant" class="form-label">Commentaire (optionnel)</label>
                            <textarea class="form-control @error('commentaire_etudiant') is-invalid @enderror" 
                                      id="commentaire_etudiant" name="commentaire_etudiant" 
                                      rows="3" 
                                      placeholder="Vous pouvez ajouter ici des informations complémentaires sur votre rapport...">{{ old('commentaire_etudiant') }}</textarea>
                            <div class="form-text">
                                Ce commentaire sera visible par l'entreprise et l'administration.
                            </div>
                            @error('commentaire_etudiant')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>Important</h6>
                            <ul class="mb-0">
                                <li>Vérifiez que votre document est complet avant de le déposer.</li>
                                <li>Une fois déposé, vous ne pourrez plus modifier le fichier, seulement le supprimer et en déposer un nouveau.</li>
                                <li>Votre rapport sera soumis à validation par l'entreprise.</li>
                            </ul>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('rapports.index') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i> Déposer mon rapport
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
