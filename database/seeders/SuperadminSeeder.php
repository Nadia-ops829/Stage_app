<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nom' => 'Super',
            'prenom' => 'Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'telephone' => '0605040302',
            'niveau' => null,
            'spécialité' => null,
            'adresse' => 'Adresse superadmin',
            'domaine' => null,
        ]);
    }
} 