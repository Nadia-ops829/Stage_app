<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entreprise;

class EntrepriseSeeder extends Seeder
{
    public function run(): void
    {
        Entreprise::create([
            'nom' => 'EntrepriseTest',
            'email' => 'contact@entreprise.com',
            'adresse' => '1 rue de l\'Entreprise',
            'domaine' => 'Informatique',
            'telephone' => '0123456789',
            'mot de passe' => bcrypt('password'),
        ]);
    }
} 