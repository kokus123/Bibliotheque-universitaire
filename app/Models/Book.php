<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'auteur',
        'isbn',
        'editeur',
        'annee_publication',
        'categorie',
        'description',
        'nombre_exemplaires',
        'exemplaires_disponibles',
        'localisation',
        'couverture',
    ];

    // Relations
    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    public function empruntsEnCours()
    {
        return $this->hasMany(Borrow::class)->where('statut', 'en_cours');
    }

    // Scopes
    public function scopeDisponible($query)
    {
        return $query->where('exemplaires_disponibles', '>', 0);
    }

    public function scopeRecherche($query, $terme)
    {
        return $query->where('titre', 'like', "%{$terme}%")
                     ->orWhere('auteur', 'like', "%{$terme}%")
                     ->orWhere('isbn', 'like', "%{$terme}%")
                     ->orWhere('categorie', 'like', "%{$terme}%");
    }

    // Helpers
    public function estDisponible(): bool
    {
        return $this->exemplaires_disponibles > 0;
    }

    public function decrementerDisponibilite(): void
    {
        if ($this->exemplaires_disponibles > 0) {
            $this->decrement('exemplaires_disponibles');
        }
    }

    public function incrementerDisponibilite(): void
    {
        if ($this->exemplaires_disponibles < $this->nombre_exemplaires) {
            $this->increment('exemplaires_disponibles');
        }
    }
}
