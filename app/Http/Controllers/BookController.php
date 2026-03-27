<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->filled('recherche')) {
            $query->recherche($request->recherche);
        }

        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        if ($request->filled('disponible')) {
            $query->disponible();
        }

        $books = $query->orderBy('titre')->paginate(12);
        $categories = Book::distinct()->pluck('categorie')->filter()->sort();

        return view('books.index', compact('books', 'categories'));
    }

    public function create()
    {
        if (!auth()->user()->isBibliothecaire()) {
            abort(403);
        }
        return view('books.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isBibliothecaire()) {
            abort(403);
        }

        $validated = $request->validate([
            'titre'                 => 'required|string|max:255',
            'auteur'                => 'required|string|max:255',
            'isbn'                  => 'nullable|string|unique:books,isbn',
            'editeur'               => 'nullable|string|max:255',
            'annee_publication'     => 'nullable|integer|min:1000|max:' . date('Y'),
            'categorie'             => 'nullable|string|max:100',
            'description'           => 'nullable|string',
            'nombre_exemplaires'    => 'required|integer|min:1',
            'localisation'          => 'nullable|string|max:100',
            'couverture'            => 'nullable|image|max:2048',
        ]);

        $validated['exemplaires_disponibles'] = $validated['nombre_exemplaires'];

        if ($request->hasFile('couverture')) {
            $validated['couverture'] = $request->file('couverture')->store('couvertures', 'public');
        }

        Book::create($validated);

        return redirect()->route('books.index')
            ->with('success', 'Livre ajouté avec succès !');
    }

    public function show(Book $book)
    {
        $book->load('borrows.user');
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        if (!auth()->user()->isBibliothecaire()) {
            abort(403);
        }
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        if (!auth()->user()->isBibliothecaire()) {
            abort(403);
        }

        $validated = $request->validate([
            'titre'              => 'required|string|max:255',
            'auteur'             => 'required|string|max:255',
            'isbn'               => 'nullable|string|unique:books,isbn,' . $book->id,
            'editeur'            => 'nullable|string|max:255',
            'annee_publication'  => 'nullable|integer|min:1000|max:' . date('Y'),
            'categorie'          => 'nullable|string|max:100',
            'description'        => 'nullable|string',
            'nombre_exemplaires' => 'required|integer|min:1',
            'localisation'       => 'nullable|string|max:100',
            'couverture'         => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('couverture')) {
            $validated['couverture'] = $request->file('couverture')->store('couvertures', 'public');
        }

        $diff = $validated['nombre_exemplaires'] - $book->nombre_exemplaires;
        $validated['exemplaires_disponibles'] = max(0, $book->exemplaires_disponibles + $diff);

        $book->update($validated);

        return redirect()->route('books.show', $book)
            ->with('success', 'Livre mis à jour avec succès !');
    }

    public function destroy(Book $book)
    {
        if (!auth()->user()->isBibliothecaire()) {
            abort(403);
        }

        if ($book->empruntsEnCours()->exists()) {
            return back()->with('error', 'Impossible de supprimer : ce livre est actuellement emprunté.');
        }

        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Livre supprimé avec succès.');
    }
}