<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Etudiant;
use App\Models\Entreprise;
use App\Models\Stage;
use App\Models\Candidature;
use App\Models\Rapport;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:super_admin']);
    }

    /**
     * Affiche la liste des administrateurs
     */
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('superadmin.admins.index', compact('admins'));
    }

    /**
     * Formulaire de création d'un nouvel utilisateur
     */
    public function create()
    {
        return view('superadmin.admins.create');
    }

    /**
     * Stocke un nouvel utilisateur (admin ou entreprise)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:admin,entreprise',
            'domaine' => 'required_if:role,entreprise',
            'adresse' => 'required_if:role,entreprise',
        ]);

        $data = [
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ];

        if ($request->role === 'entreprise') {
            $data['domaine'] = $request->domaine;
            $data['adresse'] = $request->adresse;
        }

        User::create($data);

        return redirect()->route('superadmin.admins.index')
                         ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Dashboard superadmin
     */
    public function dashboard()
    {
        // Statistiques Entreprises
        $totalEntreprises = Entreprise::count();
        $nouvellesEntreprisesMois = Entreprise::where('created_at', '>=', now()->startOfMonth())->count();
        $entreprisesActives = Entreprise::where('created_at', '>=', now()->subDays(30))->count();

        // Statistiques Étudiants
        $totalEtudiants = Etudiant::count();
        $nouveauxEtudiantsMois = User::where('created_at', '>=', now()->startOfMonth())->count();
        $etudiantsActifs = User::where('created_at', '>=', now()->subDays(30))->count();

        // Statistiques Stages
        $totalStages = Stage::count();
        $nouveauxStagesMois = Stage::where('created_at', '>=', now()->startOfMonth())->count();

        // Statistiques Candidatures
        $totalCandidatures = Candidature::count();
        $nouvellesCandidaturesMois = Candidature::where('created_at', '>=', now()->startOfMonth())->count();

        // Listes récentes pour affichage
        $derniersEtudiants = User::latest()->take(5)->get();
        $dernieresCandidatures = Candidature::latest()->take(5)->get();
        $dernieresEntreprises = Entreprise::latest()->take(5)->get();

        // Activité récente du système (exemple basé sur les actions sur les admins/entreprises)
        $recentActivities = User::latest()->take(5)->get()->map(function ($user) {
            return (object) [
                'action' => $user->role === 'admin' ? 'Nouvel administrateur créé' : 'Nouvelle entreprise ajoutée',
                'user' => $user,
                'details' => $user->email,
                'status' => 'success',
                'created_at' => $user->created_at,
            ];
        });

        return view('dashboard_superadmin', compact(
            'totalEntreprises',
            'nouvellesEntreprisesMois',
            'entreprisesActives',
            'totalEtudiants',
            'nouveauxEtudiantsMois',
            'etudiantsActifs',
            'totalStages',
            'nouveauxStagesMois',
            'totalCandidatures',
            'nouvellesCandidaturesMois',
            'derniersEtudiants',
            'dernieresCandidatures',
            'dernieresEntreprises',
            
        ));
    }

    public function etudiants()
{
    $etudiants = \App\Models\User::where('role', 'etudiant')->get();
    return view('superadmin..admins.etudiants', compact('etudiants'));
}

public function stages()
{
    $stagesActifs = \App\Models\Stage::where('statut', 'active')->get();
    $stagesTermines = \App\Models\Stage::where('statut', 'terminee')->get();

    return view('superadmin.stages.index', compact('stagesActifs', 'stagesTermines'));
}


}
