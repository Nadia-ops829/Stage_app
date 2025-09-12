@extends('layouts.admin')

@section('title', 'Dashboard Étudiant')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2">
    <i class="fas fa-user-graduate me-2"></i>
     {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
</h1>

                    <p class="text-muted mb-0">Bienvenue {{ Auth::user()->nom }} {{ Auth::user()->prenom }} !</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('stages.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-search me-1"></i>
                        Rechercher des stages
                    </a>
                    <a href="{{ route('rapports.index') }}" class="btn btn-outline-success">
                        <i class="fas fa-file-alt me-1"></i>
                        Mes Rapports
                    </a>
                    <a href="{{ route('rapports.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus me-2"></i>
                        Nouveau Rapport
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        @php
            $cards = [
                ['title'=>'Candidatures','value'=>$stats['candidatures'] ?? 0,'icon'=>'paper-plane','bg'=>'primary'],
                ['title'=>'Réponses','value'=>$stats['reponses'] ?? 0,'icon'=>'check-circle','bg'=>'success'],
                ['title'=>'En attente','value'=>$stats['en_attente'] ?? 0,'icon'=>'clock','bg'=>'warning'],
                ['title'=>'Score','value'=>$stats['score'] ?? '4.2/5','icon'=>'star','bg'=>'info'],
            ];
        @endphp
        @foreach($cards as $card)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 bg-{{ $card['bg'] }} rounded-circle p-3 text-white">
                        <i class="fas fa-{{ $card['icon'] }}"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">{{ $card['title'] }}</h6>
                        <h3 class="mb-0">{{ $card['value'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Mes dernières candidatures -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Mes dernières candidatures</h5>
                    <a href="{{ route('candidatures.mes-candidatures') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body p-0">
                    @if($candidatures->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-paper-plane fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Aucune candidature pour le moment</p>
                        </div>
                    @else
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Stage</th>
                                    <th>Statut</th>
                                    <th>Date de candidature</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($candidatures as $candidature)
                                    <tr>
                                        <td>{{ $candidature->stage->titre }}</td>
                                        <td>
                                            @if($candidature->statut === 'acceptee')
                                                <span class="badge bg-success">Acceptée</span>
                                            @elseif($candidature->statut === 'refusee')
                                                <span class="badge bg-danger">Refusée</span>
                                            @else
                                                <span class="badge bg-warning text-dark">En attente</span>
                                            @endif
                                        </td>
                                        <td>{{ $candidature->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('candidatures.show', $candidature->id) }}" class="btn btn-sm btn-primary">Voir</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="p-3">
                            {{ $candidatures->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Profil et actions rapides -->
        <div class="col-lg-4">
            <!-- Profil -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Mon Profil</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="bg-gradient-info rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                            <span class="text-white fw-bold fs-4">{{ strtoupper(substr(Auth::user()->nom,0,1) . substr(Auth::user()->prenom,0,1)) }}</span>
                        </div>
                    </div>
                    <h6 class="mb-1">{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</h6>
                    <p class="text-muted mb-2">{{ Auth::user()->email }}</p>
                    @if(Auth::user()->niveau)
                        <span class="badge bg-primary">{{ Auth::user()->niveau }}</span>
                    @endif
                    @if(Auth::user()->specialite)
                        <span class="badge bg-info ms-1">{{ Auth::user()->specialite }}</span>
                    @endif
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Actions rapides</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('stages.index') }}" class="btn btn-outline-primary"><i class="fas fa-search me-2"></i>Rechercher des stages</a>
                        <a href="{{ route('rapports.create') }}" class="btn btn-outline-success"><i class="fas fa-file-alt me-2"></i>Mettre à jour mes rapports</a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-info"><i class="fas fa-user-edit me-2"></i>Modifier mon profil</a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Entreprises recommandées -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-star me-2"></i>Entreprises recommandées pour vous</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(isset($entreprisesRecommandees) && count($entreprisesRecommandees))
                            @foreach($entreprisesRecommandees as $entreprise)
                                <div class="col-md-3 mb-3">
                                    <div class="card border h-100">
                                        <div class="card-body text-center">
                                            <div class="bg-gradient-{{ $entreprise['couleur'] }} rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                                                <span class="text-white fw-bold">{{ $entreprise['logo'] }}</span>
                                            </div>
                                            <h6 class="card-title">{{ $entreprise['nom'] }}</h6>
                                            <p class="card-text small text-muted">{{ $entreprise['domaine'] }}</p>
                                            <a href="{{ route('stages.index') }}" class="btn btn-sm btn-outline-primary">
                                                Voir les offres
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center py-4">
                                <i class="fas fa-building fa-2x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Aucune recommandation pour le moment</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary { background: linear-gradient(45deg, #007bff, #6610f2); }
.bg-gradient-info { background: linear-gradient(45deg, #17a2b8, #20c997); }
.bg-gradient-success { background: linear-gradient(45deg, #28a745, #20c997); }
.bg-gradient-warning { background: linear-gradient(45deg, #ffc107, #fd7e14); }
</style>

@endsection
