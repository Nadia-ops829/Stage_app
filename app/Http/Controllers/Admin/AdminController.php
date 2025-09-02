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
        $nbEntreprises = Entreprise::count();
        $nbStages = Stage::count();
        $nbCandidatures = Candidature::count();
        $derniersEtudiants = User::where('role', 'etudiant')->latest()->take(5)->get();
        $dernieresEntreprises = Entreprise::latest()->take(5)->get();

        return view('dashboard_admin', compact(
            'nbEtudiants',
            'nbEntreprises',
            'nbStages',
            'nbCandidatures',
            'derniersEtudiants',
            'dernieresEntreprises'
        ));
    }

    public function etudiants()
    {
        $etudiants = User::where('role', 'etudiant')->paginate(10);
        return view('admin.etudiants.index', compact('etudiants'));
    }

    
} 