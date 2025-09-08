@extends('layouts.admin')

@section('title', 'Toutes les candidatures')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4"><i class="fas fa-file-alt me-2"></i> Toutes les candidatures</h1>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Étudiant</th>
                    <th>Stage</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($candidatures as $candidature)
                    <tr>
                        <td>{{ $candidature->id }}</td>
                        <td>{{ $candidature->etudiant->nom ?? '-' }} {{ $candidature->etudiant->prenom ?? '' }}</td>
                        <td>{{ $candidature->stage->titre ?? '-' }}</td>
                        <td>{{ $candidature->statut }}</td>
                        <td>{{ $candidature->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Aucune candidature trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $candidatures->links() }}
        </div>
    </div>
</div>
@endsection
