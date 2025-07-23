<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin']);
    }

    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('superadmin.admins.index', compact('admins'));
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

        return redirect()->route('superadmin.admins.index')->with('success', 'Utilisateur créé avec succès.');
    }

    public function etudiants()
    {
        $etudiants = \App\Models\User::where('role', 'etudiant')->get();
        return view('superadmin.admins.etudiants', compact('etudiants'));
    }
}
