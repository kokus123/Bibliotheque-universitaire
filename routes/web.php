<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\UserController;

// Page d'accueil → catalogue public
Route::get('/', [BookController::class, 'index'])->name('home');

// Auth (Laravel Breeze)
require __DIR__.'/auth.php';

// Routes protégées (utilisateur connecté)
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Livres
    Route::resource('books', BookController::class);

    // Emprunts
    Route::resource('borrows', BorrowController::class)->only(['index',  'store', 'show']);
    Route::get('/borrows/create/{book}', [BorrowController::class, 'create'])->name('borrows.create');
    Route::patch('/borrows/{borrow}/retourner', [BorrowController::class, 'retourner'])->name('borrows.retourner');
    Route::post('/borrows/notifications-retard', [BorrowController::class, 'envoyerNotificationsRetard'])->name('borrows.notifications-retard');
    Route::get('/borrows/historique/{user}', [BorrowController::class, 'historiqueUser'])->name('borrows.historique');

    // Utilisateurs
    Route::resource('users', UserController::class);

});