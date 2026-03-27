<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Book;
use App\Models\User;
use App\Notifications\RetardNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrow::with(['user', 'book']);

        if (!Auth::user()->isBibliothecaire()) {
            $query->where('user_id', Auth::id());
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('user_id') && Auth::user()->isBibliothecaire()) {
            $query->where('user_id', $request->user_id);
        }

        $borrows = $query->orderByDesc('created_at')->paginate(15);

        return view('borrows.index', compact('borrows'));
    }

    public function create(Book $book)
    {
        abort_if(!$book->estDisponible(), 403, 'Ce livre n\'est pas disponible.');
        $users = User::where('role', 'etudiant')->orderBy('name')->get();
        return view('borrows.create', compact('book', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'            => 'required|exists:users,id',
            'book_id'            => 'required|exists:books,id',
            'date_emprunt'       => 'required|date',
            'date_retour_prevue' => 'required|date|after:date_emprunt',
            'notes'              => 'nullable|string|max:500',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        if (!$book->estDisponible()) {
            return back()->with('error', 'Ce livre n\'est plus disponible.');
        }

        $validated['statut'] = 'en_cours';
        $validated['bibliothecaire_id'] = Auth::id();

        Borrow::create($validated);
        $book->decrementerDisponibilite();

        return redirect()->route('borrows.index')
            ->with('success', 'Emprunt enregistré avec succès !');
    }

    public function show(Borrow $borrow)
    {
        $this->authorizeAccess($borrow);
        $borrow->load(['user', 'book', 'bibliothecaire']);
        return view('borrows.show', compact('borrow'));
    }

    public function retourner(Borrow $borrow)
    {
        if (!Auth::user()->isBibliothecaire()) {
            abort(403);
        }

        if ($borrow->statut === 'retourne') {
            return back()->with('error', 'Cet emprunt a déjà été retourné.');
        }

        $borrow->retourner();

        return redirect()->route('borrows.index')
            ->with('success', 'Retour enregistré avec succès !');
    }

    public function envoyerNotificationsRetard()
    {
        if (!Auth::user()->isBibliothecaire()) {
            abort(403);
        }

        $empruntsEnRetard = Borrow::enCours()
            ->where('date_retour_prevue', '<', Carbon::today())
            ->get();

        $count = 0;
        foreach ($empruntsEnRetard as $borrow) {
            $borrow->update(['statut' => 'en_retard']);

            if (!$borrow->notification_retard_envoyee) {
                $borrow->user->notify(new RetardNotification($borrow));
                $borrow->update(['notification_retard_envoyee' => true]);
                $count++;
            }
        }

        return back()->with('success', "{$count} notification(s) de retard envoyée(s).");
    }

    public function historiqueUser(User $user)
    {
        if (!Auth::user()->isBibliothecaire()) {
            abort(403);
        }

        $borrows = $user->borrows()->with('book')->orderByDesc('created_at')->paginate(15);
        return view('borrows.historique', compact('user', 'borrows'));
    }

    private function authorizeAccess(Borrow $borrow): void
    {
        if (!Auth::user()->isBibliothecaire() && $borrow->user_id !== Auth::id()) {
            abort(403);
        }
    }
}