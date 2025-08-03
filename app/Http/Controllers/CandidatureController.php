<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidature;
use App\Models\Stage;
use Illuminate\Support\Facades\Auth;

class CandidatureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Afficher les candidatures d'un stage (pour les entreprises)
     */
    public function index(Stage $stage)
    {
        // Vérifier que l'utilisateur est l'entreprise propriétaire du stage
        if (Auth::id() !== $stage->entreprise_id) {
            abort(403, 'Accès refusé');
        }

        $candidatures = $stage->candidatures()->with('etudiant')->paginate(10);

        return view('candidatures.index', compact('stage', 'candidatures'));
    }

    /**
     * Afficher les détails d'une candidature
     */
    public function show(Candidature $candidature)
    {
        // Vérifier les permissions
        if (Auth::user()->role === 'entreprise' && Auth::id() !== $candidature->stage->entreprise_id) {
            abort(403, 'Accès refusé');
        }

        if (Auth::user()->role === 'etudiant' && Auth::id() !== $candidature->etudiant_id) {
            abort(403, 'Accès refusé');
        }

        $candidature->load(['etudiant', 'stage.entreprise']);

        return view('candidatures.show', compact('candidature'));
    }

    /**
     * Répondre à une candidature (pour les entreprises)
     */
    public function repondre(Request $request, Candidature $candidature)
    {
        // Vérifier que l'utilisateur est l'entreprise propriétaire du stage
        if (Auth::id() !== $candidature->stage->entreprise_id) {
            abort(403, 'Accès refusé');
        }

        $request->validate([
            'statut' => 'required|in:acceptee,refusee',
            'commentaire' => 'nullable|string|max:500'
        ]);

        $candidature->update([
            'statut' => $request->statut,
            'commentaire_entreprise' => $request->commentaire,
            'date_reponse' => now()
        ]);

        $message = $request->statut === 'acceptee' ? 'Candidature acceptée !' : 'Candidature refusée.';
        
        return redirect()->route('candidatures.show', $candidature)
            ->with('success', $message);
    }

    /**
     * Afficher les candidatures de l'étudiant connecté
     */
    public function mesCandidatures()
    {
        if (Auth::user()->role !== 'etudiant') {
            abort(403, 'Accès refusé');
        }

        $candidatures = Candidature::where('etudiant_id', Auth::id())
            ->with('stage.entreprise')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('candidatures.mes-candidatures', compact('candidatures'));
    }

    /**
     * Afficher les candidatures reçues par l'entreprise connectée
     */
    public function candidaturesRecues()
    {
        if (Auth::user()->role !== 'entreprise') {
            abort(403, 'Accès refusé');
        }

        $stages = Stage::where('entreprise_id', Auth::id())
            ->with(['candidatures.etudiant'])
            ->get();

        return view('candidatures.candidatures-recues', compact('stages'));
    }
}
