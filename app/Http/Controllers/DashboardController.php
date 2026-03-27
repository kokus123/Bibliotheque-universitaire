<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_livres'       => Book::count(),
            'livres_disponibles' => Book::disponible()->count(),
            'emprunts_en_cours'  => Borrow::enCours()->count(),
            'emprunts_en_retard' => Borrow::enRetard()->count(),
            'total_utilisateurs' => User::count(),
            'etudiants'          => User::where('role', 'etudiant')->count(),
        ];

        $empruntsRecents = Borrow::with(['user', 'book'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $empruntsEnRetard = Borrow::with(['user', 'book'])
            ->enRetard()
            ->orderBy('date_retour_prevue')
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'empruntsRecents', 'empruntsEnRetard'));
    }
}
