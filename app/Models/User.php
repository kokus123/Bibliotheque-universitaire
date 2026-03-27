<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'matricule',
        'telephone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
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

    public function empruntsEnRetard()
    {
        return $this->hasMany(Borrow::class)->where('statut', 'en_retard');
    }

    // Helpers de rôle
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isBibliothecaire(): bool
    {
        return in_array($this->role, ['admin', 'bibliothecaire']);
    }

    public function isEtudiant(): bool
    {
        return $this->role === 'etudiant';
    }
}
