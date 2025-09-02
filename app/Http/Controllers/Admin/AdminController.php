<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Etudiant;
use App\Models\Entreprise;
use App\Models\Stage;
use App\Models\Candidature;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

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

    // Calcul du taux de placement via la table candidatures (statut valide)
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

        $nouveauxEtudiantsMois = User::where('role', 'etudiant')
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->count();

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
            'qualitePlacement',
        ));
    }

    public function etudiants()
    {
        $etudiants = User::where('role', 'etudiant')->paginate(10);
        return view('admin.etudiants.index', compact('etudiants'));
    }

     public function rapports()
    {
        return view('admin.rapports');
    }
    
} 