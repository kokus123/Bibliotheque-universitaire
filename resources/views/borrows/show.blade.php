@extends('layouts.app')

@section('title', 'Emprunt #' . $borrow->id)
@section('page-title', 'Détail de l\'emprunt')

@section('topbar-actions')
    <a href="{{ route('borrows.index') }}" class="btn btn-outline">← Retour</a>
    @if(auth()->user()->isBibliothecaire() && $borrow->statut !== 'retourne')
        <form method="POST" action="{{ route('borrows.retourner', $borrow) }}" onsubmit="return confirm('Confirmer le retour du livre ?')">
            @csrf @method('PATCH')
            <button type="submit" class="btn btn-accent">✅ Enregistrer le retour</button>
        </form>
    @endif
@endsection

@section('content')
<div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px;">

    <div class="card">
        <div class="card-title">📖 Livre emprunté</div>
        <h3 style="font-family:'Playfair Display',serif; font-size:1.2rem; margin-bottom:4px;">{{ $borrow->book->titre }}</h3>
        <p style="color:var(--text-muted); margin-bottom:16px;">{{ $borrow->book->auteur }}</p>
        <a href="{{ route('books.show', $borrow->book) }}" class="btn btn-outline btn-sm">Voir le livre →</a>
    </div>

    <div class="card">
        <div class="card-title">👤 Étudiant</div>
        <h3 style="font-size:1.1rem; margin-bottom:4px;">{{ $borrow->user->name }}</h3>
        <p style="color:var(--text-muted); font-size:0.875rem; margin-bottom:4px;">{{ $borrow->user->email }}</p>
        @if($borrow->user->matricule)
            <p style="color:var(--text-muted); font-size:0.875rem;">Matricule : {{ $borrow->user->matricule }}</p>
        @endif
        @if(auth()->user()->isBibliothecaire())
            <a href="{{ route('users.show', $borrow->user) }}" class="btn btn-outline btn-sm" style="margin-top:12px;">Profil →</a>
        @endif
    </div>

    <div class="card">
        <div class="card-title">📅 Dates</div>
        <div style="display:flex; flex-direction:column; gap:12px;">
            <div style="display:flex; justify-content:space-between;">
                <span style="color:var(--text-muted); font-size:0.875rem;">Date d'emprunt</span>
                <strong>{{ \Carbon\Carbon::parse($borrow->date_emprunt)->format('d/m/Y') }}</strong>
            </div>
            <div style="display:flex; justify-content:space-between;">
                <span style="color:var(--text-muted); font-size:0.875rem;">Retour prévu</span>
                <strong style="{{ $borrow->statut === 'en_retard' ? 'color:var(--danger)' : '' }}">
                    {{ \Carbon\Carbon::parse($borrow->date_retour_prevue)->format('d/m/Y') }}
                </strong>
            </div>
            @if($borrow->date_retour_reel)
            <div style="display:flex; justify-content:space-between;">
                <span style="color:var(--text-muted); font-size:0.875rem;">Retour effectif</span>
                <strong style="color:var(--success);">{{ \Carbon\Carbon::parse($borrow->date_retour_reel)->format('d/m/Y') }}</strong>
            </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-title">ℹ️ Informations</div>
        <div style="display:flex; flex-direction:column; gap:12px;">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <span style="color:var(--text-muted); font-size:0.875rem;">Statut</span>
                <span class="badge badge-{{ $borrow->statut === 'retourne' ? 'success' : ($borrow->statut === 'en_retard' ? 'danger' : 'info') }}">
                    {{ ucfirst(str_replace('_', ' ', $borrow->statut)) }}
                </span>
            </div>
            @if($borrow->bibliothecaire)
            <div style="display:flex; justify-content:space-between;">
                <span style="color:var(--text-muted); font-size:0.875rem;">Enregistré par</span>
                <strong>{{ $borrow->bibliothecaire->name }}</strong>
            </div>
            @endif
            @if($borrow->notes)
            <div>
                <div style="color:var(--text-muted); font-size:0.875rem; margin-bottom:4px;">Notes</div>
                <p style="font-size:0.875rem;">{{ $borrow->notes }}</p>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection
