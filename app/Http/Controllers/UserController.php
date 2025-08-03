<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function listEtudiants()
    {
        $etudiants = User::where('role', 'etudiant')->paginate(10);
        return view('admin.users.etudiants', compact('etudiants'));
    }

    public function listEntreprises()
    {
        $entreprises = User::where('role', 'entreprise')->paginate(10);
        return view('admin.users.entreprises', compact('entreprises'));
    }

    public function deleteEntreprise($id)
    {
        $entreprise = User::where('role', 'entreprise')->findOrFail($id);
        $entreprise->delete();
        return redirect()->route('admin.entreprises.index')->with('success', 'Entreprise supprimée avec succès.');
    }

    public function editEntreprise($id)
    {
        $entreprise = User::where('role', 'entreprise')->findOrFail($id);
        return view('admin.users.edit_entreprise', compact('entreprise'));
    }

    public function updateEntreprise(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'domaine' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
        ]);

        $entreprise = User::where('role', 'entreprise')->findOrFail($id);
        $entreprise->update($request->only('nom', 'prenom', 'email', 'domaine', 'adresse'));

        return redirect()->route('admin.entreprises.index')->with('success', 'Entreprise mise à jour avec succès.');
    }
}
