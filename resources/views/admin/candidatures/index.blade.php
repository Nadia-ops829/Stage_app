
@extends('layouts.admin')

@section('title', 'Candidatures')

@section('content')
<div class="container-fluid py-4">
    <h1 class="h3 mb-4">
        <i class="fas fa-file-alt me-2"></i>
        Liste des candidatures
    </h1>

    @if($candidatures->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Étudiant</th>
                        <th>Stage</th>
                        <th>Entreprise</th>
                        <th>Statut</th>
                        <th>Date de candidature</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($candidatures as $candidature)
                        <tr>
                            <td>{{ $candidature->etudiant->nom ?? '' }} {{ $candidature->etudiant->prenom ?? '' }}</td>
                            <td>{{ $candidature->stage->titre ?? '' }}</td>
                            <td>{{ $candidature->stage->entreprise->nom ?? '' }}</td>
                            <td>
                                @if($candidature->statut === 'acceptee')
                                    <span class="badge bg-success">Acceptée</span>
                                @elseif($candidature->statut === 'refusee')
                                    <span class="badge bg-danger">Refusée</span>
                                @else
                                    <span class="badge bg-secondary">En attente</span>
                                @endif
                            </td>
                            <td>{{ $candidature->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $candidatures->links() }}
        </div>
    @else
        <p class="text-muted">Aucune candidature pour le moment.</p>
    @endif
</div>
@endsection
