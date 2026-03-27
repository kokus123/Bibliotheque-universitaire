@extends('layouts.app')

@section('title', $user->name)
@section('page-title', 'Profil utilisateur')

@section('topbar-actions')
    <a href="{{ route('users.index') }}" class="btn btn-outline">← Utilisateurs</a>
    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">✏️ Modifier</a>
@endsection

@section('content')
<div style="display:grid; grid-template-columns: 300px 1fr; gap:24px; align-items:start;">

    {{-- Profil --}}
    <div class="card" style="text-align:center;">
        <div style="width:72px; height:72px; background:var(--primary); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; font-size:1.8rem; font-weight:700; color:var(--accent);">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <h2 style="font-family:'Playfair Display',serif; font-size:1.2rem; margin-bottom:4px;">{{ $user->name }}</h2>
        <p style="color:var(--text-muted); font-size:0.875rem; margin-bottom:12px;">{{ $user->email }}</p>
        <span class="badge badge-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'bibliothecaire' ? 'warning' : 'info') }}">
            {{ ucfirst($user->role) }}
        </span>

        @if($user->matricule || $user->telephone)
        <div style="margin-top:16px; padding-top:16px; border-top:1px solid var(--border); text-align:left;">
            @if($user->matricule)
            <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                <span style="font-size:0.8rem; color:var(--text-muted);">Matricule</span>
                <span style="font-size:0.875rem; font-weight:500;">{{ $user->matricule }}</span>
            </div>
            @endif
            @if($user->telephone)
            <div style="display:flex; justify-content:space-between;">
                <span style="font-size:0.8rem; color:var(--text-muted);">Téléphone</span>
                <span style="font-size:0.875rem; font-weight:500;">{{ $user->telephone }}</span>
            </div>
            @endif
        </div>
        @endif

        <div style="margin-top:16px; padding-top:16px; border-top:1px solid var(--border);">
            <a href="{{ route('borrows.historique', $user) }}" class="btn btn-outline btn-sm" style="width:100%; justify-content:center;">
                📋 Voir l'historique complet
            </a>
        </div>
    </div>

    {{-- Stats + emprunts récents --}}
    <div>
        <div class="stats-grid" style="grid-template-columns: repeat(4, 1fr); margin-bottom:20px;">
            <div class="stat-card">
                <div class="stat-icon stat-icon-blue">📚</div>
                <div>
                    <div class="stat-value">{{ $stats['total'] }}</div>
                    <div class="stat-label">Total</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stat-icon-gold">🔄</div>
                <div>
                    <div class="stat-value">{{ $stats['en_cours'] }}</div>
                    <div class="stat-label">En cours</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stat-icon-red">⏰</div>
                <div>
                    <div class="stat-value">{{ $stats['en_retard'] }}</div>
                    <div class="stat-label">En retard</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stat-icon-green">✅</div>
                <div>
                    <div class="stat-value">{{ $stats['retournes'] }}</div>
                    <div class="stat-label">Retournés</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-title">🔄 Emprunts récents</div>
            @forelse($user->borrows->take(8) as $borrow)
            <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid var(--border);">
                <div>
                    <a href="{{ route('borrows.show', $borrow) }}" style="font-weight:500; font-size:0.9rem; text-decoration:none; color:var(--text);">
                        {{ Str::limit($borrow->book->titre, 45) }}
                    </a>
                    <div style="font-size:0.8rem; color:var(--text-muted);">
                        {{ \Carbon\Carbon::parse($borrow->date_emprunt)->format('d/m/Y') }}
                        → {{ \Carbon\Carbon::parse($borrow->date_retour_prevue)->format('d/m/Y') }}
                    </div>
                </div>
                <span class="badge badge-{{ $borrow->statut === 'retourne' ? 'success' : ($borrow->statut === 'en_retard' ? 'danger' : 'info') }}">
                    {{ ucfirst(str_replace('_', ' ', $borrow->statut)) }}
                </span>
            </div>
            @empty
            <p style="color:var(--text-muted); font-size:0.9rem;">Aucun emprunt enregistré.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
