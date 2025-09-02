
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Superadmin\AdminController as SuperadminAdminController;
use App\Http\Controllers\Admin\EntrepriseController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\CandidatureController;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes d'authentification
require __DIR__.'/auth.php';

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {
    // Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes pour les stages
    Route::get('/stages', [StageController::class, 'index'])->name('stages.index');
    Route::post('/stages/{stage}/postuler', [StageController::class, 'postuler'])->name('stages.postuler');

    // Routes pour les candidatures
    Route::get('/candidatures/mes-candidatures', [CandidatureController::class, 'mesCandidatures'])->name('candidatures.mes-candidatures');
    Route::get('/candidatures/{candidature}', [CandidatureController::class, 'show'])->name('candidatures.show');
    Route::post('/candidatures/{candidature}/repondre', [CandidatureController::class, 'repondre'])->name('candidatures.repondre');

    // Routes pour les entreprises (création/modification de stages)
    Route::middleware(['role:entreprise'])->group(function () {
        Route::get('/stages/create', [StageController::class, 'create'])->name('stages.create');
        Route::post('/stages', [StageController::class, 'store'])->name('stages.store');
        Route::get('/stages/{stage}/edit', [StageController::class, 'edit'])->name('stages.edit');
        Route::put('/stages/{stage}', [StageController::class, 'update'])->name('stages.update');
        Route::delete('/stages/{stage}', [StageController::class, 'destroy'])->name('stages.destroy');
        Route::get('/stages/{stage}/candidatures', [CandidatureController::class, 'index'])->name('candidatures.index');
        Route::get('/candidatures-recues', [CandidatureController::class, 'candidaturesRecues'])->name('candidatures.recues');
    });

    // Route pour voir les détails d'un stage (doit être après les routes spécifiques)
    Route::get('/stages/{stage}', [StageController::class, 'show'])->name('stages.show');

    // Routes pour superadmin
    Route::middleware(['role:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
        // dd(auth()->user()->role('super_admin'));
        Route::resource('admins', SuperadminAdminController::class);
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard_superadmin');
        Route::get('/admins.index', [SuperadminAdminController::class, 'index'])->name('superadmin.admins.index');
        
    });

    // Routes pour admin
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Liste des entreprises
        Route::get('entreprises', [EntrepriseController::class, 'index'])->name('entreprises.index');

        // Formulaire de création
        Route::get('entreprises/create', [EntrepriseController::class, 'create'])->name('entreprises.create');

        // Enregistrement d'une nouvelle entreprise
        Route::post('entreprises', [EntrepriseController::class, 'store'])->name('entreprises.store');

        // Formulaire d'édition
        Route::get('entreprises/{entreprise}/edit', [EntrepriseController::class, 'edit'])->name('entreprises.edit');

        // Mise à jour d'une entreprise
        Route::put('entreprises/{entreprise}', [EntrepriseController::class, 'update'])->name('entreprises.update');

        // Suppression d'une entreprise
        Route::delete('entreprises/{entreprise}', [EntrepriseController::class, 'destroy'])->name('entreprises.destroy');

        Route::get('/etudiants', [AdminController::class, 'etudiants'])->name('etudiants.index');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    });

    // Routes pour le profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route statistiques pour admin
Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('statistiques', [AdminController::class, 'statistiques'])->name('statistiques');
});
// Route pour modifier une entreprise (admin)
Route::get('admin/entreprises/{entreprise}/edit', [EntrepriseController::class, 'edit'])->name('admin.entreprises.edit');

