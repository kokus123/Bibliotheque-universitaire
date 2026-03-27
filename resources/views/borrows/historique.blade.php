@extends('layouts.app')

@section('title', 'Historique — ' . $user->name)
@section('page-title', 'Historique des emprunts')

@section('topbar-actions')
    <a href="{{ route('users.show', $user) }}" class="btn btn-outline">← Profil</a>
@endsection

@section('content')
<div class="card" style="margin-bottom:20px; padding:16px 20px;">
    <div style="display:flex; align-items:center; gap:14px;">
        <div style="width:48px; height:48px; background:var(--primary); border-radius:50%; display:flex; align-items:center; justify-content:center; color:var(--accent); font-size:1.2rem; font-weight:700; flex-shrink:0;">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <div style="font-weight:600; font-size:1.05rem;">{{ $user->name }}</div>
            <div style="font-size:0.85rem; color:var(--text-muted);">{{ $user->email }} {{ $user->matricule ? '· ' . $user->matricule : '' }}</div>
        </div>
        <div style="margin-left:auto;">
            <span class="badge badge-muted">{{ $borrows->total() }} emprunt(s)</span>
        </div>
    </div>
</div>

<div class="card" style="padding:0; overflow:hidden;">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Livre</th>
                    <th>Emprunté le</th>
                    <th>Retour prévu</th>
                    <th>Retour effectif</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrows as $borrow)
                <tr>
                    <td>
                        <a href="{{ route('books.show', $borrow->book) }}" style="font-weight:500; text-decoration:none; color:var(--primary);">
                            {{ Str::limit($borrow->book->titre, 40) }}
                        </a>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($borrow->date_emprunt)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($borrow->date_retour_prevue)->format('d/m/Y') }}</td>
                    <td>{{ $borrow->date_retour_reel ? \Carbon\Carbon::parse($borrow->date_retour_reel)->format('d/m/Y') : '—' }}</td>
                    <td>
                        <span class="badge badge-{{ $borrow->statut === 'retourne' ? 'success' : ($borrow->statut === 'en_retard' ? 'danger' : 'info') }}">
                            {{ ucfirst(str_replace('_', ' ', $borrow->statut)) }}
                        </span>
                    </td>
                    <td><a href="{{ route('borrows.show', $borrow) }}" class="btn btn-outline btn-sm">Voir</a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:40px; color:var(--text-muted);">Aucun emprunt.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination">{{ $borrows->links() }}</div>
@endsection
