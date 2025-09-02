<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stage;
use App\Models\Candidature;
use Illuminate\Support\Facades\Auth;

class StageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Afficher la liste des stages (pour les étudiants)
     */
    public function index()
    {
        $stages = Stage::with('entreprise')
            ->where('statut', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('stages.index', compact('stages'));
    }

    /**
     * Afficher les détails d'un stage
     */
    public function show(Stage $stage)
    {
        $stage->load('entreprise');
        
        // Vérifier si l'étudiant a déjà postulé
        $aDejaPostule = false;
        if (Auth::user()->role === 'etudiant') {
            $aDejaPostule = Candidature::where('etudiant_id', Auth::id())
                ->where('stage_id', $stage->id)
                ->exists();
        }

        return view('stages.show', compact('stage', 'aDejaPostule'));
    }

    /**
     * Afficher le formulaire de création (pour les entreprises)
     */
    public function create()
    {
        if (Auth::user()->role !== 'entreprise') {
            abort(403, 'Accès refusé');
        }

        return view('stages.create');
    }

    /**
     * Enregistrer un nouveau stage
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'entreprise') {
            abort(403, 'Accès refusé');
        }

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'domaine' => 'required|string|max:255',
            'niveau_requis' => 'required|string|max:255',
            'duree' => 'required|string|max:255',
            'lieu' => 'required|string|max:255',
            'remuneration' => 'nullable|numeric|min:0',
            'date_debut' => 'required|date|after:today',
            'date_fin' => 'required|date|after:date_debut',
            'nombre_places' => 'required|integer|min:1',
            'competences_requises' => 'nullable|array'
        ]);

        $stage = Stage::create([
            'entreprise_id' => Auth::id(),
            'titre' => $request->titre,
            'description' => $request->description,
            'domaine' => $request->domaine,
            'niveau_requis' => $request->niveau_requis,
            'duree' => $request->duree,
            'lieu' => $request->lieu,
            'remuneration' => $request->remuneration,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'nombre_places' => $request->nombre_places,
            'competences_requises' => $request->competences_requises
        ]);

        return redirect()->route('stages.show', $stage)
            ->with('success', 'Offre de stage créée avec succès !');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Stage $stage)
    {
        if (Auth::id() !== $stage->entreprise_id) {
            abort(403, 'Accès refusé');
        }

        return view('stages.edit', compact('stage'));
    }

    /**
     * Mettre à jour un stage
     */
    public function update(Request $request, Stage $stage)
    {
        if (Auth::id() !== $stage->entreprise_id) {
            abort(403, 'Accès refusé');
        }

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'domaine' => 'required|string|max:255',
            'niveau_requis' => 'required|string|max:255',
            'duree' => 'required|string|max:255',
            'lieu' => 'required|string|max:255',
            'remuneration' => 'nullable|numeric|min:0',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'nombre_places' => 'required|integer|min:1',
            'competences_requises' => 'nullable|array'
        ]);

        $stage->update($request->all());

        return redirect()->route('stages.show', $stage)
            ->with('success', 'Offre de stage mise à jour avec succès !');
    }

    /**
     * Supprimer un stage
     */
    public function destroy(Stage $stage)
    {
        if (Auth::id() !== $stage->entreprise_id) {
            abort(403, 'Accès refusé');
        }

        $stage->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Offre de stage supprimée avec succès !');
    }

    /**
     * Postuler à un stage (pour les étudiants)
     */
    public function postuler(Request $request, Stage $stage)
    {
        if (Auth::user()->role !== 'etudiant') {
            abort(403, 'Accès refusé');
        }

        // Vérifier si l'étudiant a déjà postulé
        $candidatureExistante = Candidature::where('etudiant_id', Auth::id())
            ->where('stage_id', $stage->id)
            ->first();

        if ($candidatureExistante) {
            return back()->with('error', 'Vous avez déjà postulé à ce stage.');
        }

        $request->validate([
            //'lettre_motivation' => 'required|string|min:100',
            'lettre_motivation' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
        }

        Candidature::create([
            'etudiant_id' => Auth::id(),
            'stage_id' => $stage->id,
            'lettre_motivation' => $request->lettre_motivation,
            'cv_path' => $cvPath
        ]);

        return redirect()->route('stages.show', $stage)
            ->with('success', 'Candidature envoyée avec succès !');
    }
}
