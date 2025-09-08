@extends('layouts.admin')

@section('title', 'Statistiques')

@section('content')
<div class="container py-4">
    <h1 class="mb-4"><i class="fas fa-chart-bar me-2"></i> Statistiques générales</h1>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">Étudiants inscrits</h6>
                    <h2 class="fw-bold">{{ $nbEtudiants }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">Entreprises</h6>
                    <h2 class="fw-bold">{{ $nbEntreprises }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">Stages proposés</h6>
                    <h2 class="fw-bold">{{ $nbStages }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">Candidatures</h6>
                    <h2 class="fw-bold">{{ $nbCandidatures }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">Rapports déposés</h6>
                    <h2 class="fw-bold">{{ $nbRapports }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">Étudiants placés</h6>
                    <h2 class="fw-bold">{{ $etudiantsPlaces }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Taux de placement</h5>
                    <div class="progress mb-2" style="height: 30px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $tauxPlacement }}%;" aria-valuenow="{{ $tauxPlacement }}" aria-valuemin="0" aria-valuemax="100">
                            {{ $tauxPlacement }} %
                        </div>
                    </div>
                    <p class="mb-0">Qualité : <span class="fw-bold">{{ $tauxPlacement >= 80 ? 'Excellent' : ($tauxPlacement >= 60 ? 'Bon' : ($tauxPlacement >= 40 ? 'Moyen' : 'Faible')) }}</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

