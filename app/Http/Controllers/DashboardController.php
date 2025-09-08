<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Entreprise;
use App\Models\Candidature;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
                
            case 'super_admin':
                return $this->dashboard_superadmin();
                
            case 'entreprise':
                // Récupérer l'entreprise de l'utilisateur connecté
                $entreprise = $user->entreprise;
                
                // Récupérer les offres actives de l'entreprise
                $offresActives = $entreprise->stages()
                    ->where('statut', 'active')
                    ->count();
                    
                // Récupérer les candidatures pour les offres de l'entreprise
                $candidatures = Candidature::whereHas('stage', function($query) use ($user) {
                    $query->where('entreprise_id', $user->id);
                })->get();
                
                // Compter les candidatures par statut
                $stats = [
                    'offres_actives' => $offresActives,
                    'candidatures_total' => $candidatures->count(),
                    'candidatures_en_attente' => $candidatures->where('statut', 'en_attente')->count(),
                    'candidatures_acceptees' => $candidatures->where('statut', 'acceptée')->count(),
                    'candidatures_refusees' => $candidatures->where('statut', 'refusée')->count(),
                ];
                
                return view('dashboard_entreprise', compact('candidatures', 'stats'));
                
            default:
                return $this->dashboardEtudiant();
        }
    }

    private function dashboardEtudiant()
    {
        $user = Auth::user();
        // Statistiques dynamiques depuis la base de données
        $stats = [
            'candidatures' => Candidature::where('etudiant_id', $user->id)->count(),
            'reponses' => Candidature::where('etudiant_id', $user->id)->whereNotNull('date_reponse')->count(),
            'en_attente' =>Candidature::where('etudiant_id', $user->id)->enAttente()->count(),
            // Score fictif basé sur le taux d'acceptation
            'score' => (function() use ($user) {
                $total = \App\Models\Candidature::where('etudiant_id', $user->id)->count();
                $acceptees = \App\Models\Candidature::where('etudiant_id', $user->id)->acceptees()->count();
                return $total > 0 ? number_format(($acceptees / $total) * 5, 1) . '/5' : '0/5';
            })()
        ];

        // Candidatures de l'étudiant 
        $candidatures = Candidature::with(['stage', 'stage.entreprise'])
            ->where('etudiant_id', $user->id)
            ->latest('date_candidature')
            ->take(10)
            ->get();

        // Entreprises recommandées 
        $entreprisesRecommandees = Entreprise::withCount('stages')
            ->orderByDesc('stages_count')
            ->take(4)
            ->get();

        return view('dashboard_etudiant', compact('stats', 'candidatures', 'entreprisesRecommandees'));
    }
    public function dashboard_superadmin()
    {
        return view('dashboard_superadmin');
    }
} 