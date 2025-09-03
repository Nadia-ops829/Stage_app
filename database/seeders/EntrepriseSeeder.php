<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Entreprise;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class EntrepriseSeeder extends Seeder
{
    public function run(): void
    {
        // Créer d'abord l'utilisateur entreprise
        $user = User::create([
            'nom' => 'EntrepriseTest',
            'prenom' => 'Société',
            'email' => 'contact@entreprise.com',
            'password' => Hash::make('password'),
            'role' => 'entreprise',
            'telephone' => '0123456789',
            'adresse' => '1 rue de l\'Entreprise',
            'domaine' => 'Informatique',
        ]);

        // Créer l'entreprise liée à l'utilisateur
        Entreprise::create([
            'nom' => 'EntrepriseTest',
            'user_id' => $user->id,
            'description' => 'Une entreprise spécialisée dans le développement informatique',
            'site_web' => 'https://www.entreprisetest.com',
            'logo' => null,
        ]);
    }
}