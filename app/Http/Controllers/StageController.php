<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stage;
use App\Models\Candidature;
use App\Models\Entreprise;
use App\Models\User;
use App\Notifications\JobofferNotifications;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class StageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Afficher la liste des stages (pour les étudiants et les entreprises)
     */
    public function index()
    {
        $query = Stage::with('entreprise')
            ->when(Auth::user()->role === 'entreprise', function($q) {
                // Pour les entreprises, afficher uniquement leurs propres offres
                $entrepriseId = Auth::user()->entreprise->id;
                return $q->where('entreprise_id', $entrepriseId);
            }, function($q) {
                // Pour les autres rôles (étudiants), afficher uniquement les offres actives
                return $q->where('statut', 'active');
            })
            ->orderBy('created_at', 'desc');

        // Appliquer les filtres de recherche si présents
        if (request()->has('domaine')) {
            $query->where('domaine', request('domaine'));
        }
        
        if (request()->has('lieu')) {
            $query->where('lieu', 'like', '%' . request('lieu') . '%');
        }
        
        if (request()->has('niveau')) {
            $query->where('niveau_requis', request('niveau'));
        }

        $stages = $query->paginate(10);

        return view('stages.index', compact('stages'));
    }

    /**
     * Afficher les détails d'un stage
     */
    public function show(Stage $stage)
{
    // Charger l'entreprise avec son utilisateur associé
    $stage->load(['entreprise' => function($query) {
        $query->with('user');
    }]);
    
    // Vérifier si l'utilisateur est une entreprise
    if (Auth::user()->role === 'entreprise') {
        // Charger l'entreprise de l'utilisateur avec la relation user
        $userEntreprise = Auth::user()->load('entreprise')->entreprise;
        
        if (!$userEntreprise) {
            abort(403, 'Aucune entreprise associée à votre compte.');
        }
        
        // Vérifier si l'entreprise de l'utilisateur correspond à celle du stage
        if ($userEntreprise->id != $stage->entreprise_id) {
            abort(403, 'Accès non autorisé à cette offre de stage');
        }
    }

    // Vérifier si l'étudiant a déjà postulé
    $aDejaPostule = false;
    if (Auth::user()->role === 'etudiant') {
        // Bloquer l'accès si le stage n'est pas actif
        if ($stage->statut !== 'active') {
            return redirect()->route('stages.index')
                ->with('error', 'Cette offre est clôturée.');
        }

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
        // if (Auth::user()->role !== 'entreprise') {
        //     abort(403, 'Accès refusé');
        // }

      

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

    // Récupérer l'utilisateur connecté
    $user = Auth::user();
    
    // Vérifier si l'utilisateur a une entreprise associée
    $entreprise = $user->entreprise;
    
    // Si l'entreprise n'existe pas, la créer
    if (!$entreprise) {
        $entreprise = Entreprise::create([
            'user_id' => $user->id,
            'nom' => $user->nom,
            'email' => $user->email,
            'adresse' => $user->adresse ?? null,
            'domaine' => $request->domaine ?? null,
            'telephone' => $user->telephone ?? null,
        ]);
    }

    // Création de l’offre de stage
    $stage = Stage::create([
        'entreprise_id' => $entreprise->id,
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

    //  Envoi de la notification avec le titre de l’offre
    $users = User::where('role', 'etudiant')->get(); // uniquement les étudiants
    Notification::send($users, new JobofferNotifications($stage->titre));

    // Redirection finale
    return redirect()->route('stages.show', $stage)
        ->with('success', 'Offre de stage créée avec succès et notification envoyée !');
}

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

        // Création de la candidature liée au stage (et donc à l'entreprise)
        $candidature = new Candidature([
            'etudiant_id' => Auth::id(),
            'stage_id' => $stage->id,
            'lettre_motivation' => $request->lettre_motivation,
            'cv_path' => $cvPath,
            'statut' => 'en_attente',
            'date_candidature' => now()
        ]);
        
        // Sauvegarde de la candidature via la relation avec le stage
        // Cela garantit que la candidature est bien liée au stage et donc à l'entreprise
        $stage->candidatures()->save($candidature);

        return redirect()->route('stages.show', $stage)
            ->with('success', 'Candidature envoyée avec succès !');
    }


  public function toggleStatus(Stage $stage)
{
    // Vérifie que l'utilisateur est bien une entreprise et que c'est son stage
    if (Auth::user()->role !== 'entreprise' || Auth::user()->entreprise->id !== $stage->entreprise_id) {
        abort(403, "Accès interdit");
    }

    // Basculer le statut
    $stage->statut = $stage->statut === 'active' ? 'inactive' : 'active';
    $stage->save();

    return redirect()->back()->with('success', 'Statut du stage mis à jour.');
}

    
}
