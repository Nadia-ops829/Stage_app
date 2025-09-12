<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Entreprise;
use App\Models\Candidature;
use App\Models\Rapport;

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
                
                // Récupérer les offres actives de l'entreprise avec le nombre de candidatures
                $offres = $entreprise->stages()
                    ->where('statut', 'active')
                    ->withCount('candidatures')
                    ->get();
                    
                // 5 dernières candidatures reçues par l’entreprise
                $candidatures = Candidature::whereHas('stage', function($query) use ($entreprise) {
                    $query->where('entreprise_id', $entreprise->id);
                })
                ->with(['etudiant', 'stage'])
                ->latest()
                ->take(5)
                ->get();
                
                // Compter les candidatures par statut
                $stats = [
                    'offres_actives' => $offres->count(),
                    'candidatures_total' => $candidatures->count(),
                    'candidatures_en_attente' => $candidatures->where('statut', 'en_attente')->count(),
                    'candidatures_acceptees' => $candidatures->where('statut', 'acceptee')->count(),
                    'candidatures_refusees' => $candidatures->where('statut', 'refusee')->count(),
                    'rapports' => Rapport::whereHas('stage', function($q) use ($entreprise) {
                        $q->where('entreprise_id', $entreprise->id);
                    })->count(),
                ];
                
                return view('dashboard_entreprise', compact('entreprise', 'offres', 'candidatures', 'stats'));
                
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
            'en_attente' => Candidature::where('etudiant_id', $user->id)->enAttente()->count(),
            // Score basé sur le taux d'acceptation
            'score' => (function() use ($user) {
                $total = Candidature::where('etudiant_id', $user->id)->count();
                $acceptees = Candidature::where('etudiant_id', $user->id)->acceptees()->count();
                return $total > 0 ? number_format(($acceptees / $total) * 5, 1) . '/5' : '0/5';
            })()
        ];

        // Candidatures de l'étudiant avec pagination
        $candidatures = Candidature::with(['stage', 'stage.entreprise'])
            ->where('etudiant_id', $user->id)
            ->latest('date_candidature')
            ->paginate(10);

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
