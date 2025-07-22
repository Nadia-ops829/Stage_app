<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Models\User;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register'); // Vue du formulaire d’inscription
    }

    public function store(Request $request)
    {
        //  Validation des champs
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'spécialité' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
        ]);

        //  Création de l’utilisateur
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'etudiant',
            'spécialité' => $request->spécialité,
            'niveau' => $request->niveau,
            'email_verified_at' => Carbon::now(), // email marqué comme vérifié
        ]);

        //  Envoi d’un email de bienvenue (simple)
        Mail::raw("Bienvenue {$user->prenom} sur la plateforme de stages !", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject("Bienvenue sur notre plateforme 🎓");
        });

        //   Connexion automatique
        Auth::login($user);

        //  Redirection
        return redirect()->route('dashboard')->with('success', 'Inscription réussie ! Bienvenue !');
    }
}
