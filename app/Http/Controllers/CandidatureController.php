<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidature;
use App\Models\Stage;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CandidatureNotification;

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
        if (Auth::user()->role !== 'entreprise' || $stage->entreprise_id !== Auth::user()->entreprise->id) {
            abort(403, 'Action non autorisée.');
        }

        $candidatures = $stage->candidatures()->with('etudiant')->paginate(10);

        // Compter par statut
        $totalCandidatures = $candidatures->total();
        $candidaturesAcceptees = $candidatures->where('statut', 'acceptee')->count();
        $candidaturesRefusees = $candidatures->where('statut', 'refusee')->count();
        $candidaturesEnAttente = $candidatures->where('statut', 'en_attente')->count();

        return view('candidatures.index', compact(
            'stage',
            'candidatures',
            'totalCandidatures',
            'candidaturesAcceptees',
            'candidaturesRefusees',
            'candidaturesEnAttente'
        ));
    }

    /**
     * Afficher les détails d'une candidature
     */
    public function show(Candidature $candidature)
    {
        if (
            Auth::user()->role === 'entreprise' && $candidature->stage->entreprise_id !== Auth::user()->entreprise->id ||
            Auth::user()->role === 'etudiant' && $candidature->etudiant_id !== Auth::id()
        ) {
            abort(403, 'Action non autorisée.');
        }

        $candidature->load(['etudiant', 'stage.entreprise']);

        return view('candidatures.show', compact('candidature'));
    }

    /**
     * Répondre à une candidature (pour les entreprises)
     */
    public function repondre(Request $request, Candidature $candidature)
    {
        if (Auth::user()->role !== 'entreprise' || $candidature->stage->entreprise_id !== Auth::user()->entreprise->id) {
            abort(403, 'Action non autorisée.');
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

        // Notification à l'étudiant
        $candidature->etudiant->notify(new CandidatureNotification($candidature, 'etudiant'));

        // ✅ Mettre le stage en "termine" si la candidature est acceptée
        if ($request->statut === 'acceptee') {
            $stage = $candidature->stage;
            $stage->statut = 'terminee';
            $stage->save();
        }

        $message = $request->statut === 'acceptee' ? 'Candidature acceptée ! Stage clôturé automatiquement.' : 'Candidature refusée.';

        return redirect()->route('candidatures.show', $candidature)
            ->with('success', $message);
    }

    /**
     * Afficher les candidatures de l'étudiant connecté
     */
    public function mesCandidatures()
    {
        // Récupère les candidatures paginées pour l'affichage
        $candidatures = Candidature::where('etudiant_id', Auth::id())
            ->with('stage.entreprise')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Compte exact des candidatures par statut
        $candidaturesAcceptees = Candidature::where('etudiant_id', Auth::id())
            ->where('statut', 'acceptee')
            ->count();

        $candidaturesRefusees = Candidature::where('etudiant_id', Auth::id())
            ->where('statut', 'refusee')
            ->count();

        $candidaturesEnAttente = Candidature::where('etudiant_id', Auth::id())
            ->where('statut', 'en_attente')
            ->count();

        return view('candidatures.mes-candidatures', compact(
            'candidatures',
            'candidaturesAcceptees',
            'candidaturesRefusees',
            'candidaturesEnAttente'
        ));
    }

    /**
     * Afficher les candidatures reçues par l'entreprise connectée
     */
    public function candidaturesRecues()
    {
        $stages = Stage::where('entreprise_id', Auth::user()->entreprise->id)
            ->with(['candidatures.etudiant'])
            ->get();

        $candidaturesAcceptees = 0;
        $candidaturesRefusees = 0;
        $candidaturesEnAttente = 0;

        foreach ($stages as $stage) {
            $candidaturesAcceptees += $stage->candidatures->where('statut', 'acceptee')->count();
            $candidaturesRefusees += $stage->candidatures->where('statut', 'refusee')->count();
            $candidaturesEnAttente += $stage->candidatures->where('statut', 'en_attente')->count();
        }

        return view('candidatures.candidatures-recues', compact(
            'stages',
            'candidaturesAcceptees',
            'candidaturesRefusees',
            'candidaturesEnAttente'
        ));
    }

    /**
     * Créer une nouvelle candidature (postuler à un stage) et notifier l'entreprise
     */
    public function postuler(Request $request)
    {
        $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'lettre_motivation' => 'nullable|string',
            'cv_path' => 'nullable|string'
        ]);

        $candidature = Candidature::create([
            'etudiant_id' => Auth::id(),
            'stage_id' => $request->stage_id,
            'lettre_motivation' => $request->lettre_motivation,
            'cv_path' => $request->cv_path
        ]);

        // Notification à l'entreprise
        $candidature->stage->entreprise->user->notify(new CandidatureNotification($candidature, 'entreprise'));

        return redirect()->back()->with('success', 'Candidature envoyée !');
    }
}
