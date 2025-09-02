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
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:super_admin']);
    }

    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        
        // dd($admins);
        return view('superadmin.admins.index',  ['stages'=>$stages,'admins'=>$admins]);

    }

    public function create()
    {
        return view('superadmin.admins.create');
    }

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
        // dd($data);

        return redirect()->route('superadmin.admins.index')->with('success', 'Utilisateur créé avec succès.');
    }


    
public function dashboard()
{
    // Statistiques Entreprises
    $totalEntreprises = Entreprise::count();
    $nouvellesEntreprisesMois = Entreprise::where('created_at', '>=', now()->startOfMonth())->count();
    $entreprisesActives = Entreprise::where('created_at', '>=', now()->subDays(30))->count();

    // Statistiques Étudiants
    $totalEtudiants = Etudiant::count();
    $nouveauxEtudiantsMois = Etudiant::where('created_at', '>=', now()->startOfMonth())->count();
    $etudiantsActifs = Etudiant::where('created_at', '>=', now()->subDays(30))->count();

    // Statistiques Stages
    $totalStages = Stage::count();
    $nouveauxStagesMois = Stage::where('created_at', '>=', now()->startOfMonth())->count();

    // Statistiques Candidatures
    $totalCandidatures = Candidature::count();
    $nouvellesCandidaturesMois = Candidature::where('created_at', '>=', now()->startOfMonth())->count();

    // Listes pour affichage
    $derniersEtudiants = Etudiant::latest()->take(5)->get();
    $dernieresCandidatures = Candidature::latest()->take(5)->get();
    $dernieres_entreprises = Entreprise::latest()->take(5)->get();

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
        'dernieres_entreprises'
    ));
}

    // public function etudiants()
    // {
    //     $etudiants = \App\Models\User::where('role', 'etudiant')->get();
    //     return view('superadmin.admins.etudiants', compact('etudiants'));
    // }

    // public function entreprises()
    // {
    //     $entreprises = \App\Models\User::where('role', 'entreprise')->get();
    //     return view('superadmin.admins.entreprises', compact('entreprises'));
    // }

    // public function stages()
}
