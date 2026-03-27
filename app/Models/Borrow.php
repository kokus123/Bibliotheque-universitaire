<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'date_emprunt',
        'date_retour_prevue',
        'date_retour_effective',
        'statut',
        'notes',
        'notification_retard_envoyee',
        'bibliothecaire_id',
    ];

    protected $casts = [
        'date_emprunt' => 'date',
        'date_retour_prevue' => 'date',
        'date_retour_effective' => 'date',
        'notification_retard_envoyee' => 'boolean',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function bibliothecaire()
    {
        return $this->belongsTo(User::class, 'bibliothecaire_id');
    }

    // Scopes
    public function scopeEnCours($query)
    {
        return $query->where('statut', 'en_cours');
    }

    public function scopeEnRetard($query)
    {
        return $query->where('statut', 'en_retard');
    }

    public function scopeRetournes($query)
    {
        return $query->where('statut', 'retourne');
    }

    // Helpers
    public function estEnRetard(): bool
    {
        return $this->statut !== 'retourne'
            && Carbon::now()->greaterThan($this->date_retour_prevue);
    }

    public function joursDeRetard(): int
    {
        if (!$this->estEnRetard()) return 0;
        return Carbon::now()->diffInDays($this->date_retour_prevue);
    }

    public function retourner(): void
    {
        $this->update([
            'statut' => 'retourne',
            'date_retour_effective' => Carbon::today(),
        ]);
        $this->book->incrementerDisponibilite();
    }
}

