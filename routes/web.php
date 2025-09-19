
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
    
        Route::get('/stages/create', [StageController::class, 'create'])->name('stages.create');
        Route::post('/stages', [StageController::class, 'store'])->name('stages.store');
        Route::get('/stages/{stage}', [StageController::class, 'show'])->name('stages.show');
        Route::get('/stages/{stage}/edit', [StageController::class, 'edit'])->name('stages.edit');
        Route::put('/stages/{stage}', [StageController::class, 'update'])->name('stages.update');
        Route::get('/stages/{stage}/candidatures', [CandidatureController::class, 'index'])->name('candidatures.index');
        Route::get('/candidatures-recues', [CandidatureController::class, 'candidaturesRecues'])->name('candidatures.recues');
    

    // Routes pour superadmin
    Route::middleware(['role:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Superadmin\AdminController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/stages', [\App\Http\Controllers\Superadmin\AdminController::class, 'stages'])
        ->name('stages.index');
        
        // Admin management routes
        Route::get('/admins', [\App\Http\Controllers\Superadmin\AdminController::class, 'index'])->name('admins.index');
        Route::get('/admins/create', [\App\Http\Controllers\Superadmin\AdminController::class, 'create'])->name('admins.create');
        Route::post('/admins', [\App\Http\Controllers\Superadmin\AdminController::class, 'store'])->name('admins.store');
        Route::get('/admins/{admin}/edit', [\App\Http\Controllers\Superadmin\AdminController::class, 'edit'])->name('admins.edit');
        Route::put('/admins/{admin}', [\App\Http\Controllers\Superadmin\AdminController::class, 'update'])->name('admins.update');
        Route::delete('/admins/{admin}', [\App\Http\Controllers\Superadmin\AdminController::class, 'destroy'])->name('admins.destroy');
    });

    // Routes pour admin
Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Voir toutes les candidatures (admin)
    Route::get('candidatures', [AdminController::class, 'candidatures'])->name('candidatures.index');
    
    // Liste des stages
    Route::get('stages', [StageController::class, 'index'])->name('stages.index');
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
    // Liste des étudiants
    Route::get('etudiants', [AdminController::class, 'etudiants'])->name('etudiants.index');
    // Dashboard admin
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    // Page des rapports
    
    // Statistiques admin
    Route::get('statistiques', [AdminController::class, 'statistiques'])->name('statistiques');

   
});

        // Routes pour les rapports de stage
    Route::resource('rapports', \App\Http\Controllers\RapportController::class)->except(['show']);
    Route::get('rapports/{rapport}', [\App\Http\Controllers\RapportController::class, 'show'])->name('rapports.show');
    Route::post('rapports/{rapport}/valider', [\App\Http\Controllers\RapportController::class, 'valider'])->name('rapports.valider');
    Route::get('rapports/{rapport}/telecharger', [\App\Http\Controllers\RapportController::class, 'telecharger'])->name('rapports.telecharger');
    
    // Routes protégées pour les étudiants
    Route::middleware(['role:etudiant'])->group(function () {
        Route::get('/mes-rapports', [\App\Http\Controllers\RapportController::class, 'index'])->name('rapports.etudiant.index');
        Route::get('/rapports/create', [\App\Http\Controllers\RapportController::class, 'create'])->name('rapports.create');
        Route::post('/rapports', [\App\Http\Controllers\RapportController::class, 'store'])->name('rapports.store');
    });
    
    // Routes protégées pour les entreprises
    Route::middleware(['role:entreprise'])->group(function () {
        Route::get('/rapports-entreprise', [\App\Http\Controllers\RapportController::class, 'index'])->name('rapports.entreprise.index');
    });
    Route::post('rapports/{rapport}/valider', [\App\Http\Controllers\RapportController::class, 'valider'])->name('rapports.valider');
    Route::get('rapports/{rapport}/telecharger', [\App\Http\Controllers\RapportController::class, 'telecharger'])->name('rapports.telecharger');

    // Routes pour le profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ...existing code...
// Route pour modifier une entreprise (admin)
Route::get('admin/entreprises/{entreprise}/edit', [EntrepriseController::class, 'edit'])->name('admin.entreprises.edit');


 Route::delete('/stages/{stages}', [StageController::class, 'destroy'])->name('stages.destroy');

Route::get('/entreprises/{id}', [EntrepriseController::class, 'show'])->name('entreprises.show');

// Route pour toutes les candidatures (Admin)

    Route::get('/candidatures', [App\Http\Controllers\Admin\AdminController::class, 'candidatures'])->name('candidatures.index');

   Route::patch('/stages/{stage}/toggle', [StageController::class, 'toggleStatus'])
    ->name('stages.toggleStatus')
    ->middleware(['auth']);

    Route::middleware(['auth', 'role:super_admin'])
    ->prefix('superadmin')
    ->name('superadmin.admins.')
    ->group(function () {
        // Liste des étudiants
        Route::get('/etudiants', [\App\Http\Controllers\Superadmin\AdminController::class, 'etudiants'])
            ->name('etudiants');
});







