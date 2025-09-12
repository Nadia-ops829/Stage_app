@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <form method="POST" action="{{ route('rapports.store') }}" enctype="multipart/form-data">
                    Déposer un nouveau rapport de stage
                </div>


                

                <div class="card-body">
                    <form method="POST" action="{{ route('rapports.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="stage_id" class="form-label">Stage concerné</label>
                            <select name="stage_id" id="stage_id" class="form-select @error('stage_id') is-invalid @enderror" required>
                                <option value="">Sélectionnez un stage</option>
                                @foreach($stages as $stage)
                                    <option value="{{ $stage->id }}" {{ old('stage_id') == $stage->id ? 'selected' : '' }}>
                                        {{ $stage->titre }} - {{ $stage->entreprise->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('stage_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fichier" class="form-label">Fichier du rapport</label>
                            <input type="file" class="form-control @error('fichier') is-invalid @enderror" 
                                   id="fichier" name="fichier" required>
                            <div class="form-text">Formats acceptés : PDF, DOC, DOCX. Taille maximale : 10 Mo</div>
                            @error('fichier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        <div class="mb-3">
                            <label for="commentaire_etudiant" class="form-label">Commentaire (optionnel)</label>
                            <textarea class="form-control @error('commentaire_etudiant') is-invalid @enderror" 
                                      id="commentaire_etudiant" name="commentaire_etudiant" 
                                      rows="3">{{ old('commentaire_etudiant') }}</textarea>
                            @error('commentaire_etudiant')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('rapports.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
