@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Mes Rapports de Stage</span>
                    @if(auth()->user()->etudiant)
                        <a href="{{ route('rapports.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nouveau Rapport
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
                                                
                                                
                                                    @if($rapport->statut != 'valide')
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
                                                    @endif
                                                
                                                
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
                                            Aucun rapport trouvé.
                                           <tr> <a href="{{ route('rapports.create') }}" class="btn btn-outline-primary">
                                                <i class="fas fa-plus me-2"></i>
                                                    Créer votre  premier Rapport
                                                </a>
                                            </tr>
                                            
                                            
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
