@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Mes Rapports de Stage</span>
                    @if(isset($stageAccepte) && $stageAccepte)
                        <a href="{{ route('rapports.create', ['stage_id' => $stageAccepte->id]) }}" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Déposer mon rapport de stage
                        </a>
                    @endif
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    @if(auth()->user()->role == 'entreprise')
                                        <th>Étudiant</th>
                                    @endif
                                    <th>Titre du Stage</th>
                                    @if(auth()->user()->role == 'admin')
                                        <th>Entreprise</th>
                                    @endif
                                    <th>Date de dépôt</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rapports as $rapport)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        @if(auth()->user()->role == 'entreprise')
                                            <td>{{ $rapport->etudiant->nom_complet ?? 'N/A' }}</td>
                                        @endif
                                        <td>{{ $rapport->stage->titre ?? 'N/A' }}</td>
                                        @if(auth()->user()->role == 'admin')
                                            <td>{{ $rapport->stage->entreprise->nom ?? 'N/A' }}</td>
                                        @endif
                                        <td>{{ $rapport->date_depot->format('d/m/Y') }}</td>
                                        <td>
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
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('rapports.show', $rapport->id) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   title="Voir les détails">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                
                                                    <!-- @if($rapport->statut != 'valide')
                                                        <a href="{{ route('rapports.edit', $rapport->id) }}" 
                                                           class="btn btn-sm btn-warning"
                                                           title="Modifier">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        
                                                        <form action="{{ route('rapports.destroy', $rapport->id) }}" 
                                                              method="POST" 
                                                              class="d-inline"
                                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rapport ?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif -->
                                                
                                                
                                                <a href="{{ route('rapports.telecharger', $rapport->id) }}" 
                                                   class="btn btn-sm btn-primary"
                                                   title="Télécharger">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            @if(auth()->user()->isEtudiant() && !isset($stageAccepte))
                                                <p>Vous n'avez pas de stage accepté pour le moment.</p>
                                            @else
                                                <p>Aucun rapport trouvé.</p>
                                                @if(auth()->user()->isEtudiant() && $stageAccepte)
                                                    <a href="{{ route('rapports.create', ['stage_id' => $stageAccepte->id]) }}" class="btn btn-primary mt-2">
                                                        <i class="fas fa-upload"></i> Déposer mon premier rapport
                                                    </a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>


                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
