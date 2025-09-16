<?php

namespace App\Http\Controllers;

use App\Models\Rapport;
use App\Models\Stage;
use App\Notifications\RapportetudiantNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RapportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $query = Rapport::with(['stage.entreprise.user', 'etudiant.user']);
        
        if ($user->isEntreprise()) {
            // Pour les entreprises, afficher les rapports des stages qu'elles proposent
            $query->whereHas('stage', function($q) use ($user) {
                $q->where('entreprise_id', $user->entreprise->id);
            });
            
            // Récupérer les rapports avec les informations nécessaires
            $rapports = $query->latest()->get();
            
            // Log pour le débogage
            \Log::info('Rapports pour l\'entreprise', [
                'entreprise_id' => $user->id,
                'rapports_count' => $rapports->count(),
                'rapports' => $rapports->toArray()
            ]);
            
            return view('rapports.index', [
                'rapports' => $rapports,
                'stageAccepte' => null
            ]);
        }
        elseif ($user->isEtudiant()) {
            // Pour les étudiants, afficher uniquement leurs rapports
            $query->where('etudiant_id', $user->id);
            
            // Vérifier si l'étudiant a un stage accepté sans rapport
            $stageAccepte = \App\Models\Stage::whereHas('candidatures', function($q) use ($user) {
                    $q->where('etudiant_id', $user->id)
                      ->where('statut', 'acceptee');
                })
                ->whereDoesntHave('rapport')
                ->first();
                
            // Pour le débogage
            \Log::info('Stage accepté trouvé:', ['stage' => $stageAccepte]);
                
            return view('rapports.index', [
                'rapports' => $query->latest()->get(),
                'stageAccepte' => $stageAccepte
            ]);
        }
        
        // Pour les admins ou autres rôles
        $rapports = $query->latest()->get();
        return view('rapports.index', compact('rapports'));
    }

    public function create()
    {
        $stages = Stage::where('statut', 'active')->get();
        return view('rapports.create', compact('stages'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur est un étudiant
        if (!$user->isEtudiant()) {
            abort(403, 'Seuls les étudiants peuvent déposer des rapports.');
        }
        
        // Log des informations de débogage
        \Log::info('Tentative de dépôt de rapport', [
            'user_id' => $user->id,
            'stage_id' => $request->stage_id,
            'is_etudiant' => $user->isEtudiant()
        ]);
        
        // Vérifier que le stage existe et que l'étudiant a une candidature acceptée pour ce stage
        $stage = \App\Models\Stage::where('id', $request->stage_id)
            ->whereHas('candidatures', function($q) use ($user) {
                $q->where('etudiant_id', $user->id)
                  ->where('statut', 'acceptee');
            })
            ->first();
            
        // Log du résultat de la requête
        \Log::info('Résultat de la requête stage', [
            'stage' => $stage ? $stage->toArray() : null,
            'candidatures' => $stage ? $stage->candidatures : []
        ]);
        
        if (!$stage) {
            \Log::error('Stage non trouvé ou non autorisé', [
                'user_id' => $user->id,
                'stage_id' => $request->stage_id
            ]);
            abort(404, 'Stage non trouvé ou vous n\'êtes pas autorisé à déposer un rapport pour ce stage.');
        }
            
        // Vérifier qu'il n'y a pas déjà un rapport pour ce stage
        if (Rapport::where('stage_id', $stage->id)->exists()) {
            return redirect()->back()
                ->with('error', 'Un rapport existe déjà pour ce stage.');
        }

        $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'fichier' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'commentaire_etudiant' => 'nullable|string|max:1000',
        ]);

        $fichier = $request->file('fichier');
        $chemin = $fichier->store('rapports', 'public');

        $rapport = new Rapport([
            'etudiant_id' => $user->id,
            'stage_id' => $stage->id,
            'fichier' => $chemin,
            'commentaire_etudiant' => $request->commentaire_etudiant,
            'statut' => 'en_attente',
            'date_depot' => now(),
        ]);

        $rapport->save();

        // Notification à l'entreprise
        if ($stage->entreprise && $stage->entreprise->user) {
            $stage->entreprise->user->notify(new \App\Notifications\RapportetudiantNotifications(
                "Nouveau rapport déposé par l'étudiant " . $user->prenom . ' ' . $user->nom,
                route('rapports.show', $rapport->id),
                'nouveau'
            ));
        }

        // Notification à l'étudiant
        $user->notify(new \App\Notifications\RapportetudiantNotifications(
            "Votre rapport a été déposé avec succès et est en attente de validation.",
            route('rapports.show', $rapport->id),
            'info'
        ));

        return redirect()->route('rapports.index')
            ->with('success', 'Rapport déposé avec succès. Il est en attente de validation par l\'entreprise.');
    }

    public function show(string $id)
    {
        $user = Auth::user();
        $rapport = Rapport::with(['stage.entreprise.user', 'etudiant'])->findOrFail($id);
        
        // Vérifier les autorisations
        // if ($user->isEtudiant() && $rapport->etudiant_id !== $user->id) {
        //     abort(403, 'Vous n\'êtes pas autorisé à voir ce rapport.');
        // }
        
        // if ($user->isEntreprise() && $rapport->stage->entreprise_id !== $user->id) {
        //     abort(403, 'Vous n\'êtes pas autorisé à voir ce rapport.');
        // }
        
        return view('rapports.show', compact('rapport'));
    }

    public function edit(string $id)
    {
        $rapport = Rapport::findOrFail($id);
        $stages = Stage::where('statut', 'active')->get();
        return view('rapports.edit', compact('rapport', 'stages'));
    }

    public function update(Request $request, string $id)
    {
        $rapport = Rapport::findOrFail($id);

        $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'fichier' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'commentaire_etudiant' => 'nullable|string|max:1000',
        ]);

        $data = [
            'stage_id' => $request->stage_id,
            'commentaire_etudiant' => $request->commentaire_etudiant,
        ];

        if ($request->hasFile('fichier')) {
            Storage::disk('public')->delete($rapport->fichier);
            $fichier = $request->file('fichier');
            $data['fichier'] = $fichier->store('rapports', 'public');
        }

        $rapport->update($data);

        return redirect()->route('rapports.index')
            ->with('success', 'Rapport mis à jour avec succès.');
    }

    public function valider(Request $request, $id)
    {
        $user = Auth::user();
        $rapport = Rapport::with(['stage', 'etudiant.user'])->findOrFail($id);
        
        // Vérifier que l'utilisateur est l'entreprise concernée
        

        $request->validate([
            'statut' => 'required|in:valide,refuse',
            'commentaire_entreprise' => 'required_if:statut,refuse|string|max:1000',
        ], [
            'commentaire_entreprise.required_if' => 'Un motif de refus est obligatoire.',
        ]);

        $rapport->update([
            'statut' => $request->statut,
            'commentaire_entreprise' => $request->commentaire_entreprise,
            'date_validation' => now(),
        ]);

        // Notification à l'étudiant
        if ($rapport->etudiant && $rapport->etudiant->user) {
            $message = $request->statut === 'valide' 
                ? "Votre rapport a été validé par l'entreprise."
                : "Votre rapport a été refusé. Motif : " . $request->commentaire_entreprise;
            
            $type = $request->statut === 'valide' ? 'validation' : 'refus';
                
            $rapport->etudiant->user->notify(new \App\Notifications\RapportetudiantNotifications(
                $message,
                route('rapports.show', $rapport->id),
                $type
            ));
        }

        return redirect()->back()
            ->with('success', 'Le rapport a été ' . $request->statut . ' avec succès.');
    }

    public function telecharger($id)
    {
        $rapport = Rapport::findOrFail($id);
        $user = Auth::user();

        if ($user->role!='etudiant' && $user->role!='entreprise') {
             abort(403);
        }

        return Storage::disk('public')->download(
            $rapport->fichier,
            'rapport_' . $rapport->id . '.' . pathinfo($rapport->fichier, PATHINFO_EXTENSION)
        );
    }

    public function destroy(string $id)
    {
        $rapport = Rapport::findOrFail($id);

        $user = Auth::user();

        if ($user->role!='etudiant') {
             abort(403);
        }
        Storage::disk('public')->delete($rapport->fichier);
        $rapport->delete();

        return redirect()->route('rapports.index')
            ->with('success', 'Rapport supprimé avec succès.');
    }
}
