<?php

namespace App\Http\Controllers;

use App\Models\Rapport;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RapportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        $query = Rapport::with(['stage.entreprise', 'etudiant']);
        
        // Si l'utilisateur a un profil entreprise, on filtre pour ne montrer que les rapports de ses stages
        if ($user->entreprise) {
            $query->whereHas('stage', function($q) use ($user) {
                $q->where('entreprise_id', $user->entreprise->id);
            });
        }
        // Si l'utilisateur a un profil étudiant, on ne montre que ses rapports
        elseif ($user->etudiant) {
            $query->where('etudiant_id', $user->etudiant->id);
        }
        
        $rapports = $query->latest()->get();
            
        return view('rapports.index', compact('rapports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stages = Stage::where('statut', 'active')
            ->get();
            
        return view('rapports.create', compact('stages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'fichier' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'commentaire_etudiant' => 'nullable|string|max:1000',
        ]);

        $fichier = $request->file('fichier');
        $chemin = $fichier->store('rapports', 'public');

        // Créer un rapport sans forcer le champ etudiant_id
        $rapport = new Rapport([
            'stage_id' => $request->stage_id,
            'fichier' => $chemin,
            'commentaire_etudiant' => $request->commentaire_etudiant,
            'statut' => 'en_attente',
            'date_depot' => now(),
        ]);

        // Si l'utilisateur a un profil étudiant, on l'associe
        if (Auth::user()->etudiant) {
            $rapport->etudiant_id = Auth::user()->etudiant->id;
        }

        $rapport->save();

        return redirect()->route('rapports.index')
            ->with('success', 'Rapport déposé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rapport = Rapport::with(['stage', 'etudiant'])->findOrFail($id);
        
        // Vérifier les autorisations
        $user = Auth::user();
        
        
        return view('rapports.show', compact('rapport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rapport = Rapport::findOrFail($id);
        
        // Seul l'étudiant propriétaire peut modifier son rapport
        
        
        // $stages = Auth::user()->etudiant->stages;
        
        return view('rapports.edit', compact('rapport'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rapport = Rapport::findOrFail($id);
        
        // Vérifier que l'utilisateur est bien le propriétaire du rapport
        if (Auth::user()->etudiant->id !== $rapport->etudiant_id) {
            abort(403);
        }
        
        $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'fichier' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'commentaire_etudiant' => 'nullable|string|max:1000',
        ]);
        
        $data = [
            'stage_id' => $request->stage_id,
            'commentaire_etudiant' => $request->commentaire_etudiant,
        ];
        
        // Mettre à jour le fichier si un nouveau est fourni
        if ($request->hasFile('fichier')) {
            // Supprimer l'ancien fichier
            Storage::disk('public')->delete($rapport->fichier);
            
            // Enregistrer le nouveau fichier
            $fichier = $request->file('fichier');
            $data['fichier'] = $fichier->store('rapports', 'public');
        }
        
        $rapport->update($data);
        
        return redirect()->route('rapports.index')
            ->with('success', 'Rapport mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function valider(Request $request, $id)
    {
        $rapport = Rapport::findOrFail($id);
        
        // Vérifier que l'utilisateur est l'entreprise concernée
        if (Auth::user()->entreprise->id !== $rapport->stage->entreprise_id) {
            abort(403);
        }
        
        $request->validate([
            'statut' => 'required|in:valide,refuse',
            'commentaire_entreprise' => 'nullable|string|max:1000',
        ]);
        
        $rapport->update([
            'statut' => $request->statut,
            'commentaire_entreprise' => $request->commentaire_entreprise,
            'date_validation' => now(),
        ]);
        
        return redirect()->back()
            ->with('success', 'Rapport ' . $request->statut . ' avec succès.');
    }
    
    public function telecharger($id)
    {
        $rapport = Rapport::findOrFail($id);
        
        // Vérifier les autorisations
        $user = Auth::user();
        if ($user->hasRole('etudiant') && $rapport->etudiant_id !== $user->etudiant->id) {
            abort(403);
        }
        
        if ($user->hasRole('entreprise') && $rapport->stage->entreprise_id !== $user->entreprise->id) {
            abort(403);
        }
        
        return Storage::disk('public')->download($rapport->fichier, 'rapport_' . $rapport->id . '.' . pathinfo($rapport->fichier, PATHINFO_EXTENSION));
    }
    
    public function destroy(string $id)
    {
        $rapport = Rapport::findOrFail($id);
        
        // Seul l'étudiant propriétaire peut supprimer son rapport
        if (Auth::user()->etudiant->id !== $rapport->etudiant_id) {
            abort(403);
        }
        
        // Supprimer le fichier physique
        Storage::disk('public')->delete($rapport->fichier);
        
        // Supprimer l'entrée en base de données
        $rapport->delete();
        
        return redirect()->route('rapports.index')
            ->with('success', 'Rapport supprimé avec succès.');
    }
}
