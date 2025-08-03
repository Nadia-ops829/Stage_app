<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'nom' => 'Admin',
                'prenom' => 'Principal',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'telephone' => '0102030405',
                'niveau' => null,
                'spécialité' => null,
                'adresse' => 'Adresse admin',
                'domaine' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'nom' => 'Super',
                'prenom' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'telephone' => '0102030406',
                'niveau' => null,
                'spécialité' => null,
                'adresse' => 'Adresse super admin',
                'domaine' => null,
            ]
        );
    }
} 