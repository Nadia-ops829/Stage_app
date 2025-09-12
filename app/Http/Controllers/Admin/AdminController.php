<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Entreprise;
use App\Models\Stage;
use App\Models\Candidature;
use App\Models\Rapport;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Dashboard Admin
     */
    public function dashboard()
    {
        $nbEtudiants = User::where('role', 'etudiant')->count();
        $nouveauxEtudiantsMois = User::where('role', 'etudiant')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $nbEntreprises = Entreprise::count();
        $nbStages = Stage::count();
        $nbCandidatures = Candidature::count();
        $derniersEtudiants = User::where('role', 'etudiant')->latest()->take(5)->get();
        $dernieresEntreprises = Entreprise::latest()->take(5)->get();
        $stages = Stage::where('statut', 'active')->get();

        // Calcul du taux de placement via les candidatures acceptées
        $nbEtudiantsPlaces = Candidature::where('statut', 'acceptee')->distinct('etudiant_id')->count('etudiant_id');
        $tauxPlacement = $nbEtudiants > 0 ? round(($nbEtudiantsPlaces / $nbEtudiants) * 100, 2) : 0;

        // Qualité du placement
        if ($tauxPlacement >= 80) {
            $qualitePlacement = 'Excellent';
        } elseif ($tauxPlacement >= 60) {
            $qualitePlacement = 'Bon';
        } elseif ($tauxPlacement >= 40) {
            $qualitePlacement = 'Moyen';
        } else {
            $qualitePlacement = 'Faible';
        }

        return view('dashboard_admin', compact(
            'nbEtudiants',
            'nouveauxEtudiantsMois',
            'nbEntreprises',
            'nbStages',
            'nbCandidatures',
            'derniersEtudiants',
            'dernieresEntreprises',
            'stages',
            'tauxPlacement',
            'qualitePlacement'
        ));
    }

    /**
     * Liste des étudiants
     */
    public function etudiants()
    {
        $etudiants = User::where('role', 'etudiant')->paginate(10);
        return view('admin.etudiants.index', compact('etudiants'));
    }

    /**
     * Liste des candidatures
     */
    public function candidatures()
    {
        $candidatures = Candidature::with(['etudiant', 'stage', 'stage.entreprise'])
            ->latest()
            ->paginate(20);

        return view('admin.candidatures.index', compact('candidatures'));
    }

    /**
     * Liste des rapports
     */
    public function rapports()
    {
        $rapports = Rapport::with(['etudiant', 'stage'])->latest()->paginate(20);
        return view('admin.rapports', compact('rapports'));
    }

    /**
     * Statistiques avancées pour l'admin
     */
    public function statistiques()
    {
        $nbEtudiants = User::where('role', 'etudiant')->count();
        $nbEntreprises = Entreprise::count();
        $nbStages = Stage::count();
        $nbCandidatures = Candidature::count();
        $nbRapports = Rapport::count();
        $etudiantsPlaces = Candidature::where('statut', 'acceptee')->distinct('etudiant_id')->count('etudiant_id');
        $tauxPlacement = $nbEtudiants > 0 ? round(($etudiantsPlaces / $nbEtudiants) * 100, 2) : 0;

        return view('admin.statistiques', compact(
            'nbEtudiants',
            'nbEntreprises',
            'nbStages',
            'nbCandidatures',
            'nbRapports',
            'etudiantsPlaces',
            'tauxPlacement'
        ));
    }
}
