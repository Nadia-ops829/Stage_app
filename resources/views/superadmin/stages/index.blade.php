@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Statistiques des Stages</h2>

    <div class="mb-5">
        <h4>Stages Actifs</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Entreprise</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stagesActifs as $stage)
                    <tr>
                        <td>{{ $stage->titre }}</td>
                        <td>{{ $stage->entreprise->nom ?? 'N/A' }}</td>
                        <td>{{ $stage->date_debut }}</td>
                        <td>{{ $stage->date_fin }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted">Aucun stage actif</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        <h4>Stages Terminés</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Entreprise</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stagesTermines as $stage)
                    <tr>
                        <td>{{ $stage->titre }}</td>
                        <td>{{ $stage->entreprise->nom ?? 'N/A' }}</td>
                        <td>{{ $stage->date_debut }}</td>
                        <td>{{ $stage->date_fin }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted">Aucun stage terminé</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
