<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Entreprise;

class EntrepriseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    // Liste toutes les entreprises
    public function index()
    {
        $entreprises = Entreprise::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.entreprises.index', compact('entreprises'));
    }

    // Formulaire création entreprise
    public function create()
    {
        return view('admin.entreprises.create');
    }

    // Enregistre une nouvelle entreprise
    public function store(Request $request)
        {
            // Validation des champs
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'email' => 'required|email|unique:entreprises,email',
                'domaine' => 'required|string|max:255',
                'adresse' => 'required|string|max:255',
                'mot_de_passe' => 'required|string|min:8',
            ]);

            try {
                // Hash du mot de passe avant sauvegarde
                $validated['mot_de_passe'] = bcrypt($validated['mot_de_passe']);

                // Création de l'entreprise
                Entreprise::create($validated);

                // Redirection avec message de succès pour SweetAlert
                return redirect()->back()->with('success', 'Entreprise créée avec succès !');

            } catch (\Exception $e) {
                // Redirection avec message d'erreur pour SweetAlert
                return redirect()->back()->with('error', 'Erreur lors de la création de l’entreprise : ' . $e->getMessage());
            }
        }


    // Affiche une entreprise (optionnel)
    public function show($id)
    {
        $entreprise = User::where('role', 'entreprise')->findOrFail($id);
        return view('admin.entreprises.show', compact('entreprise'));
    }

    // Formulaire édition entreprise
    public function edit($id)
    {
        $entreprise = User::where('role', 'entreprise')->findOrFail($id);
        return view('admin.entreprises.edit', compact('entreprise'));
    }

    // Mise à jour entreprise
    public function update(Request $request, $id)
    {
        $entreprise = User::where('role', 'entreprise')->findOrFail($id);

        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'domaine' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $entreprise->nom = $request->nom;
        $entreprise->email = $request->email;
        $entreprise->domaine = $request->domaine;
        $entreprise->adresse = $request->adresse;

        if ($request->filled('password')) {
            $entreprise->password = Hash::make($request->password);
        }

        $entreprise->save();

        return redirect()->route('admin.entreprises.index')->with('success', 'Entreprise mise à jour avec succès.');
    }

    // Supprime une entreprise
    public function destroy($id)
    {
        $entreprise = User::where('role', 'entreprise')->findOrFail($id);
        $entreprise->delete();

        return redirect()->route('admin.entreprises.index')->with('success', 'Entreprise supprimée avec succès.');
    }
}
