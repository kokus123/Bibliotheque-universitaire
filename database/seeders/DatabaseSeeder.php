<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Borrow;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name'      => 'Administrateur',
            'email'     => 'admin@bibliotheque.cm',
            'password'  => Hash::make('password'),
            'role'      => 'admin',
        ]);

        // Bibliothécaire
        $biblio = User::create([
            'name'      => 'Jean Dupont',
            'email'     => 'jean@bibliotheque.cm',
            'password'  => Hash::make('password'),
            'role'      => 'bibliothecaire',
        ]);

        // Étudiants
        $etudiant1 = User::create([
            'name'       => 'Alice Mballa',
            'email'      => 'alice@univ.cm',
            'password'   => Hash::make('password'),
            'role'       => 'etudiant',
            'matricule'  => 'ETU001',
        ]);

        $etudiant2 = User::create([
            'name'       => 'Paul Nkomo',
            'email'      => 'paul@univ.cm',
            'password'   => Hash::make('password'),
            'role'       => 'etudiant',
            'matricule'  => 'ETU002',
        ]);

        // Livres
        $livres = [
            ['titre' => 'Introduction aux algorithmes', 'auteur' => 'Thomas Cormen', 'isbn' => '978-2-10-070313-8', 'categorie' => 'Informatique', 'nombre_exemplaires' => 3],
            ['titre' => 'Le Petit Prince',              'auteur' => 'Antoine de Saint-Exupéry', 'isbn' => '978-2-07-040850-4', 'categorie' => 'Littérature', 'nombre_exemplaires' => 2],
            ['titre' => 'Mathématiques pour l\'ingénieur', 'auteur' => 'Jean-Pierre Ramis', 'isbn' => '978-2-10-071234-5', 'categorie' => 'Mathématiques', 'nombre_exemplaires' => 4],
            ['titre' => 'Base de données relationnelles', 'auteur' => 'Chris Date', 'isbn' => '978-2-10-072345-6', 'categorie' => 'Informatique', 'nombre_exemplaires' => 2],
            ['titre' => 'Physique générale', 'auteur' => 'Serway & Jewett', 'isbn' => '978-2-10-073456-7', 'categorie' => 'Physique', 'nombre_exemplaires' => 5],
            ['titre' => 'Droit civil', 'auteur' => 'Jean Carbonnier', 'isbn' => '978-2-13-074567-8', 'categorie' => 'Droit', 'nombre_exemplaires' => 3],
        ];

        foreach ($livres as $livre) {
            $livre['exemplaires_disponibles'] = $livre['nombre_exemplaires'];
            Book::create($livre);
        }

        // Emprunts exemple
        $book1 = Book::first();
        Borrow::create([
            'user_id'            => $etudiant1->id,
            'book_id'            => $book1->id,
            'date_emprunt'       => Carbon::today()->subDays(20),
            'date_retour_prevue' => Carbon::today()->subDays(6), // En retard !
            'statut'             => 'en_retard',
            'bibliothecaire_id'  => $biblio->id,
        ]);
        $book1->decrement('exemplaires_disponibles');

        $book2 = Book::skip(1)->first();
        Borrow::create([
            'user_id'            => $etudiant2->id,
            'book_id'            => $book2->id,
            'date_emprunt'       => Carbon::today()->subDays(3),
            'date_retour_prevue' => Carbon::today()->addDays(11),
            'statut'             => 'en_cours',
            'bibliothecaire_id'  => $biblio->id,
        ]);
        $book2->decrement('exemplaires_disponibles');
    }
}
