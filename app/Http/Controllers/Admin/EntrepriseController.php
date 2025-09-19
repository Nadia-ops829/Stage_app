<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Entreprise;

class EntrepriseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,super_admin']);
    }

    // Liste toutes les entreprises avec leurs utilisateurs associés
    public function index()
    {
        $entreprises = Entreprise::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
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
            'email' => 'required|email|unique:users,email',
            'domaine' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'mot_de_passe' => 'required|string|min:8',
            'telephone' => 'nullable|string|max:20',
        ]);

        // Démarrer une transaction pour assurer l'intégrité des données
        DB::beginTransaction();

        try {
            // 1. Créer le compte utilisateur
            $user = User::create([
                'nom' => $validated['nom'],
                'prenom' => '', // Champ requis
                'email' => $validated['email'],
                'password' => bcrypt($validated['mot_de_passe']),
                'role' => 'entreprise',
                'adresse' => $validated['adresse'],
                'domaine' => $validated['domaine'],
                'telephone' => $validated['telephone'] ?? null,
            ]);

            // 2. Créer l'entreprise liée à l'utilisateur
            $entreprise = Entreprise::create([
                'nom' => $validated['nom'],
                'user_id' => $user->id,
                'description' => null,
                'logo' => null,
                'site_web' => null
            ]);
            
            // Valider la transaction
            DB::commit();

            // Redirection avec message de succès
            return redirect()->route('admin.entreprises.index')
                ->with('success', 'Entreprise créée avec succès ! L\'entreprise peut maintenant se connecter avec son email et mot de passe.');

        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            DB::rollBack();
            
            // Journaliser l'erreur pour le débogage
            \Log::error('Erreur création entreprise : ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la création de l\'entreprise. Veuillez réessayer.');
        }
    }


    // Affiche les détails d'une entreprise
    public function show($id)
    {
        $entreprise = Entreprise::with('user')->findOrFail($id);
        
        if (!$entreprise->user) {
            return redirect()->route('admin.entreprises.index')
                ->with('error', 'Aucun utilisateur associé à cette entreprise.');
        }
        
        return view('admin.entreprises.show', compact('entreprise'));
    }

    // Formulaire édition entreprise
    public function edit($id)
    {
        $entreprise = Entreprise::with('user')->findOrFail($id);
        
        if (!$entreprise->user) {
            return redirect()->route('admin.entreprises.index')
                ->with('error', 'Aucun utilisateur associé à cette entreprise.');
        }
        
        return view('admin.entreprises.edit', compact('entreprise'));
    }

    // Mise à jour entreprise
    public function update(Request $request, $id)
    {
        $entreprise = Entreprise::with('user')->findOrFail($id);
        
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $entreprise->user_id,
            'domaine' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'mot_de_passe' => 'nullable|string|min:8',
        ]);

        // Démarrer une transaction
        DB::beginTransaction();

        try {
            // Mettre à jour l'utilisateur associé
            $userData = [
                'nom' => $validated['nom'],
                'email' => $validated['email'],
                'adresse' => $validated['adresse'],
                'domaine' => $validated['domaine'],
                'telephone' => $validated['telephone'] ?? null,
            ];

            if ($request->filled('mot_de_passe')) {
                $userData['password'] = bcrypt($validated['mot_de_passe']);
            }

            $entreprise->user->update($userData);

            // Mettre à jour l'entreprise
            $entreprise->update([
                'nom' => $validated['nom'],
                'description' => $request->input('description'),
                'site_web' => $request->input('site_web'),
            ]);

            DB::commit();

            return redirect()->route('admin.entreprises.index')
                ->with('success', 'Entreprise mise à jour avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur lors de la mise à jour de l\'entreprise : ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour de l\'entreprise. Veuillez réessayer.');
        }
    }

    // Supprime une entreprise et son utilisateur associé
    public function destroy($id)
    {
        $entreprise = Entreprise::with('user')->findOrFail($id);
        
        DB::beginTransaction();
        
        try {
            // Supprimer l'utilisateur associé s'il existe
            if ($entreprise->user) {
                $entreprise->user->delete();
            }
            
            // Supprimer l'entreprise
            $entreprise->delete();
            
            DB::commit();
            
            return redirect()->route('admin.entreprises.index')
                ->with('success', 'Entreprise supprimée avec succès !');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur lors de la suppression de l\'entreprise : ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression de l\'entreprise. Veuillez réessayer.');
        }
    }
}
