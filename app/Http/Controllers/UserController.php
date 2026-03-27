<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        //
    }

    private function checkBibliothecaire()
    {
        if (!auth()->user()?->isBibliothecaire()) {
            abort(403, 'Accès réservé aux bibliothécaires.');
        }
    }

    public function index(Request $request)
    {
        $this->checkBibliothecaire();

        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('recherche')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->recherche}%")
                  ->orWhere('email', 'like', "%{$request->recherche}%")
                  ->orWhere('matricule', 'like', "%{$request->recherche}%");
            });
        }

        $users = $query->orderBy('name')->paginate(15);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->checkBibliothecaire();
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->checkBibliothecaire();

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8|confirmed',
            'role'       => 'required|in:admin,bibliothecaire,etudiant',
            'matricule'  => 'nullable|string|unique:users,matricule',
            'telephone'  => 'nullable|string|max:20',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur créé avec succès !');
    }

    public function show(User $user)
    {
        $this->checkBibliothecaire();

        $user->load(['borrows.book']);
        $stats = [
            'total'     => $user->borrows()->count(),
            'en_cours'  => $user->empruntsEnCours()->count(),
            'en_retard' => $user->empruntsEnRetard()->count(),
            'retournes' => $user->borrows()->retournes()->count(),
        ];
        return view('users.show', compact('user', 'stats'));
    }

    public function edit(User $user)
    {
        $this->checkBibliothecaire();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->checkBibliothecaire();

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'role'      => 'required|in:admin,bibliothecaire,etudiant',
            'matricule' => 'nullable|string|unique:users,matricule,' . $user->id,
            'telephone' => 'nullable|string|max:20',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('users.show', $user)
            ->with('success', 'Utilisateur mis à jour avec succès !');
    }

    public function destroy(User $user)
    {
        $this->checkBibliothecaire();

        if ($user->empruntsEnCours()->exists()) {
            return back()->with('error', 'Impossible de supprimer : cet utilisateur a des emprunts en cours.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur supprimé.');
    }
}