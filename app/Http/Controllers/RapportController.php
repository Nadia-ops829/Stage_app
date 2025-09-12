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
        
        $query = Rapport::with(['stage.entreprise', 'etudiant']);
        
        if ($user->entreprise) {
            $query->whereHas('stage', function($q) use ($user) {
                $q->where('entreprise_id', $user->entreprise->id);
            });
        }
        elseif ($user->etudiant) {
            $query->where('etudiant_id', $user->etudiant->id);
        }
        
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
        $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'fichier' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'commentaire_etudiant' => 'nullable|string|max:1000',
        ]);

        $fichier = $request->file('fichier');
        $chemin = $fichier->store('rapports', 'public');

        $rapport = new Rapport([
            'stage_id' => $request->stage_id,
            'fichier' => $chemin,
            'commentaire_etudiant' => $request->commentaire_etudiant,
            'statut' => 'en_attente',
            'date_depot' => now(),
        ]);

        if (Auth::user()->etudiant) {
            $rapport->etudiant_id = Auth::user()->etudiant->id;
        }

        $rapport->save();

        // Notification après dépôt
        
Auth::user()->notify(new RapportetudiantNotifications(
    "Votre rapport a été déposé avec succès et est en attente de validation.", // $titre/message
    route('rapports.show', $rapport->id) // $lien vers le rapport
));

        return redirect()->route('rapports.index')
            ->with('success', 'Rapport déposé avec succès.');
    }

    public function show(string $id)
    {
        $rapport = Rapport::with(['stage', 'etudiant'])->findOrFail($id);
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
        $rapport = Rapport::findOrFail($id);

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

        //  Notification après validation ou refus
        if ($rapport->etudiant && $rapport->etudiant->user) {
            $rapport->etudiant->user->notify(new RapportetudiantNotifications(
                "Votre rapport a été " . $request->statut . " par l'entreprise."
            ));
        }

        return redirect()->back()
            ->with('success', 'Rapport ' . $request->statut . ' avec succès.');
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
