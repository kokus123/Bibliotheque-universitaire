@extends('layouts.app')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

@section('topbar-actions')
    @if(auth()->user()->isBibliothecaire())
        <a href="{{ route('books.create') }}" class="btn btn-accent">
            <i class="bi bi-plus-lg"></i> Nouveau livre
        </a>
        <a href="{{ route('books.index') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left-right"></i> Emprunts
        </a>
    @endif
@endsection

@section('content')

{{-- Stats --}}
<div class="stats-grid">

    <div class="stat-card">
        <div style="flex:1;">
            <div style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:10px;">Total livres</div>
            <div style="font-family:'Cormorant',serif; font-size:2.4rem; font-weight:700; color:var(--navy); line-height:1;">{{ $stats['total_livres'] }}</div>
            <div style="margin-top:10px; font-size:0.78rem; color:var(--text-muted); display:flex; align-items:center; gap:5px;">
                <i class="bi bi-journals" style="color:var(--gold);"></i>
                Catalogue complet
            </div>
        </div>
        <div style="width:48px; height:48px; background:var(--navy); border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <i class="bi bi-journals" style="color:var(--gold); font-size:1.3rem;"></i>
        </div>
    </div>

    <div class="stat-card">
        <div style="flex:1;">
            <div style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:10px;">Disponibles</div>
            <div style="font-family:'Cormorant',serif; font-size:2.4rem; font-weight:700; color:#16a34a; line-height:1;">{{ $stats['livres_disponibles'] }}</div>
            <div style="margin-top:10px; font-size:0.78rem; color:var(--text-muted); display:flex; align-items:center; gap:5px;">
                <i class="bi bi-check-circle-fill" style="color:#16a34a;"></i>
                Prêts à l'emprunt
            </div>
        </div>
        <div style="width:48px; height:48px; background:#dcfce7; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <i class="bi bi-check-circle" style="color:#16a34a; font-size:1.3rem;"></i>
        </div>
    </div>

    <div class="stat-card">
        <div style="flex:1;">
            <div style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:10px;">Emprunts en cours</div>
            <div style="font-family:'Cormorant',serif; font-size:2.4rem; font-weight:700; color:#2563eb; line-height:1;">{{ $stats['emprunts_en_cours'] }}</div>
            <div style="margin-top:10px; font-size:0.78rem; color:var(--text-muted); display:flex; align-items:center; gap:5px;">
                <i class="bi bi-arrow-left-right" style="color:#2563eb;"></i>
                En circulation
            </div>
        </div>
        <div style="width:48px; height:48px; background:#dbeafe; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <i class="bi bi-arrow-left-right" style="color:#2563eb; font-size:1.3rem;"></i>
        </div>
    </div>

    <div class="stat-card" style="{{ $stats['emprunts_en_retard'] > 0 ? 'border-color:#fca5a5;' : '' }}">
        <div style="flex:1;">
            <div style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:10px;">En retard</div>
            <div style="font-family:'Cormorant',serif; font-size:2.4rem; font-weight:700; color:{{ $stats['emprunts_en_retard'] > 0 ? '#dc2626' : 'var(--navy)' }}; line-height:1;">{{ $stats['emprunts_en_retard'] }}</div>
            <div style="margin-top:10px; font-size:0.78rem; color:var(--text-muted); display:flex; align-items:center; gap:5px;">
                <i class="bi bi-exclamation-triangle{{ $stats['emprunts_en_retard'] > 0 ? '-fill' : '' }}" style="color:{{ $stats['emprunts_en_retard'] > 0 ? '#dc2626' : 'var(--text-muted)' }};"></i>
                {{ $stats['emprunts_en_retard'] > 0 ? 'Action requise' : 'Aucun retard' }}
            </div>
        </div>
        <div style="width:48px; height:48px; background:{{ $stats['emprunts_en_retard'] > 0 ? '#fee2e2' : '#f1f5f9' }}; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <i class="bi bi-clock-history" style="color:{{ $stats['emprunts_en_retard'] > 0 ? '#dc2626' : '#64748b' }}; font-size:1.3rem;"></i>
        </div>
    </div>

    @if(auth()->user()->isBibliothecaire())
    <div class="stat-card">
        <div style="flex:1;">
            <div style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:10px;">Utilisateurs</div>
            <div style="font-family:'Cormorant',serif; font-size:2.4rem; font-weight:700; color:var(--navy); line-height:1;">{{ $stats['total_utilisateurs'] }}</div>
            <div style="margin-top:10px; font-size:0.78rem; color:var(--text-muted); display:flex; align-items:center; gap:5px;">
                <i class="bi bi-people" style="color:var(--gold);"></i>
                Comptes actifs
            </div>
        </div>
        <div style="width:48px; height:48px; background:var(--gold-pale); border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <i class="bi bi-people" style="color:var(--gold); font-size:1.3rem;"></i>
        </div>
    </div>

    <div class="stat-card">
        <div style="flex:1;">
            <div style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:10px;">Étudiants</div>
            <div style="font-family:'Cormorant',serif; font-size:2.4rem; font-weight:700; color:var(--navy); line-height:1;">{{ $stats['etudiants'] }}</div>
            <div style="margin-top:10px; font-size:0.78rem; color:var(--text-muted); display:flex; align-items:center; gap:5px;">
                <i class="bi bi-mortarboard" style="color:var(--gold);"></i>
                Inscrits
            </div>
        </div>
        <div style="width:48px; height:48px; background:var(--gold-pale); border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <i class="bi bi-mortarboard" style="color:var(--gold); font-size:1.3rem;"></i>
        </div>
    </div>
    @endif

</div>

{{-- Tables --}}
<div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px;">

    {{-- Emprunts récents --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-title">
            <i class="bi bi-clock-history" style="color:var(--gold);"></i>
            Emprunts récents
        </div>
        @forelse($empruntsRecents as $borrow)
        <div style="display:flex; justify-content:space-between; align-items:center; padding:11px 0; border-bottom:1px solid var(--border);">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:36px; height:36px; background:var(--navy); border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="bi bi-book" style="color:var(--gold); font-size:0.85rem;"></i>
                </div>
                <div>
                    <div style="font-weight:500; font-size:0.875rem; color:var(--navy);">{{ Str::limit($borrow->book->titre, 28) }}</div>
                    <div style="font-size:0.75rem; color:var(--text-muted); margin-top:1px;">{{ $borrow->user->name }}</div>
                </div>
            </div>
            <span class="badge badge-{{ $borrow->statut === 'en_cours' ? 'info' : ($borrow->statut === 'en_retard' ? 'danger' : 'success') }}">
                {{ ucfirst(str_replace('_', ' ', $borrow->statut)) }}
            </span>
        </div>
        @empty
        <div style="text-align:center; padding:32px; color:var(--text-muted);">
            <i class="bi bi-inbox" style="font-size:2rem; display:block; margin-bottom:8px;"></i>
            Aucun emprunt récent
        </div>
        @endforelse
        <div style="margin-top:16px;">
            <a href="{{ route('borrows.index') }}" class="btn btn-outline btn-sm">
                Voir tous les emprunts <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    {{-- Retards --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-title" style="{{ $empruntsEnRetard->count() > 0 ? 'color:#dc2626;' : '' }}">
            <i class="bi bi-exclamation-triangle{{ $empruntsEnRetard->count() > 0 ? '-fill' : '' }}" style="color:{{ $empruntsEnRetard->count() > 0 ? '#dc2626' : 'var(--gold)' }};"></i>
            Retards
            @if($empruntsEnRetard->count() > 0)
                <span class="badge badge-danger" style="margin-left:auto;">{{ $empruntsEnRetard->count() }}</span>
            @endif
        </div>
        @forelse($empruntsEnRetard as $borrow)
        <div style="display:flex; justify-content:space-between; align-items:center; padding:11px 0; border-bottom:1px solid var(--border);">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:36px; height:36px; background:#fee2e2; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="bi bi-clock" style="color:#dc2626; font-size:0.85rem;"></i>
                </div>
                <div>
                    <div style="font-weight:500; font-size:0.875rem; color:var(--navy);">{{ Str::limit($borrow->book->titre, 28) }}</div>
                    <div style="font-size:0.75rem; color:#dc2626; margin-top:1px;">
                        {{ $borrow->user->name }} · dû le {{ \Carbon\Carbon::parse($borrow->date_retour_prevue)->format('d/m/Y') }}
                    </div>
                </div>
            </div>
            <a href="{{ route('borrows.show', $borrow) }}" class="btn btn-outline btn-sm">Voir</a>
        </div>
        @empty
        <div style="text-align:center; padding:32px; color:var(--text-muted);">
            <i class="bi bi-check-circle" style="font-size:2rem; color:#16a34a; display:block; margin-bottom:8px;"></i>
            Aucun retard
        </div>
        @endforelse

        @if(auth()->user()->isBibliothecaire() && $empruntsEnRetard->count() > 0)
        <div style="margin-top:16px;">
            <form method="POST" action="{{ route('borrows.notifications-retard') }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bi bi-bell"></i> Envoyer notifications
                </button>
            </form>
        </div>
        @endif
    </div>

</div>

@endsection