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

        $entreprise = Auth::user()->entreprise;

        $candidatures = Candidature::get();

        /* if ($entreprise) {
            $candidatures = $entreprise->candidatures()
                ->with(['etudiant', 'stage'])
                ->latest()
                ->get();
        } else {
            $candidatures = collect(); // collection vide
        } */

        //dd($candidatures);


        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'super_admin':
                // dd($user);
                return $this->dashboard_superadmin();
            case 'entreprise':
                return view('dashboard_entreprise', compact('candidatures'));
            default:
                // Dashboard étudiant avec données réalistes
                return $this->dashboardEtudiant();
        }
    }

    private function dashboardEtudiant()
    {
        $user = Auth::user();
        
        // Données simulées pour le dashboard étudiant
        $stats = [
            'candidatures' => rand(3, 8),
            'reponses' => rand(1, 4),
            'en_attente' => rand(1, 3),
            'score' => number_format(rand(35, 50) / 10, 1) . '/5'
        ];

        // Candidatures simulées
        $candidatures = [
            [
                'entreprise' => 'Microsoft France',
                'logo' => 'MS',
                'poste' => 'Développeur Full-Stack',
                'statut' => 'acceptée',
                'date' => now()->subDays(rand(1, 7))->format('d/m/Y'),
                'couleur' => 'primary'
            ],
            [
                'entreprise' => 'Google',
                'logo' => 'GO',
                'poste' => 'Data Scientist',
                'statut' => 'en_attente',
                'date' => now()->subDays(rand(1, 14))->format('d/m/Y'),
                'couleur' => 'info'
            ],
            [
                'entreprise' => 'Apple',
                'logo' => 'AP',
                'poste' => 'iOS Developer',
                'statut' => 'refusée',
                'date' => now()->subDays(rand(1, 21))->format('d/m/Y'),
                'couleur' => 'success'
            ],
            [
                'entreprise' => 'Amazon',
                'logo' => 'AM',
                'poste' => 'DevOps Engineer',
                'statut' => 'en_attente',
                'date' => now()->subDays(rand(1, 10))->format('d/m/Y'),
                'couleur' => 'warning'
            ]
        ];

        // Entreprises recommandées basées sur le profil de l'étudiant
        $entreprisesRecommandees = [
            [
                'nom' => 'Microsoft',
                'logo' => 'MS',
                'domaine' => 'Technologies',
                'couleur' => 'primary'
            ],
            [
                'nom' => 'Google',
                'logo' => 'GO',
                'domaine' => 'Technologies',
                'couleur' => 'info'
            ],
            [
                'nom' => 'Apple',
                'logo' => 'AP',
                'domaine' => 'Technologies',
                'couleur' => 'success'
            ],
            [
                'nom' => 'Amazon',
                'logo' => 'AM',
                'domaine' => 'E-commerce',
                'couleur' => 'warning'
            ]
        ];

        return view('dashboard_etudiant', compact('stats', 'candidatures', 'entreprisesRecommandees'));
    }
    public function dashboard_superadmin()
    {
        return view('dashboard_superadmin');
    }
} 