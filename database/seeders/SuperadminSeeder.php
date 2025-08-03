<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'nom' => 'Super',
                'prenom' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'telephone' => '0605040302',
                'niveau' => null,
                'spécialité' => null,
                'adresse' => 'Adresse superadmin',
                'domaine' => null,
            ]
        );
    }
} 