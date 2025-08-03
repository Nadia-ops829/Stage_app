<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Superadmin\AdminController;
use App\Http\Controllers\Admin\EntrepriseController;
use App\Http\Controllers\DashboardController;

// // Route d'inscription personnalisée (Breeze gère /login automatiquement)
// Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
// Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');


// // Route pour le tableau de bord du superadmin
// //Route::get('/dashboard/superadmin', [AdminController::class, 'index'])->middleware(['auth', 'role:superadmin'])->name('dashboard.superadmin');

// // Route pour le tableau de bord de l'admin
// Route::get('/dashboard/admin', [AdminController::class, 'index'])->middleware(['auth', 'role:admin'])->name('dashboard.admin');

// Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
//     Route::get('/dashboard', [AdminController::class, 'dashboard'])->name(' dashboard.admin');
// });


// //Route pour la gestion des utilisateurs par l'administrateur :



// Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

// Route::get('/etudiants', [AdminController::class, 'etudiants'])->name('admins.etudiants');

//     // Liste des étudiants
//     Route::get('etudiants', [UserController::class, 'listEtudiants'])->name('etudiants.index');

//     // Liste des entreprises
//     Route::get('entreprises', [UserController::class, 'listEntreprises'])->name('entreprises.index');
    
//     // Suppression entreprise
//     Route::delete('entreprises/{id}', [UserController::class, 'deleteEntreprise'])->name('entreprises.delete');

//     // Edition entreprise (form)
//     Route::get('entreprises/{id}/edit', [UserController::class, 'editEntreprise'])->name('entreprises.edit');

//     // Mise à jour entreprise
//     Route::put('entreprises/{id}', [UserController::class, 'updateEntreprise'])->name('entreprises.update');
// });



// //Route creation d'un administrateur

// Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
//     Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
//     Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
//     Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
    
// });

// //Route creation d'une entreprise



// Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::resource('entreprises', EntrepriseController::class);
// });

// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Route::middleware(['auth'])->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';




// Route d'inscription personnalisée (Breeze gère /login automatiquement)
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

//Route creation d'un administrateur

Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
    Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
    Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
    Route::get('/etudiants', [AdminController::class, 'etudiants'])->name('admins.etudiants');
});

//Route creation d'une entreprise



Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('entreprises', EntrepriseController::class);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

