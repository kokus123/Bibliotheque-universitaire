@extends('layouts.app')

@section('title', 'Emprunts')
@section('page-title', 'Gestion des emprunts')

@section('topbar-actions')
    @if(auth()->user()->isBibliothecaire())
        <form method="POST" action="{{ route('borrows.notifications-retard') }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-outline">🔔 Notifier retards</button>
        </form>
    @endif
@endsection

@section('content')

{{-- Filtres --}}
<div class="card" style="margin-bottom:20px; padding:16px 20px;">
    <form method="GET" style="display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end;">
        <div style="min-width:160px;">
            <label class="form-label">Statut</label>
            <select name="statut" class="form-control">
                <option value="">Tous</option>
                <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                <option value="en_retard" {{ request('statut') == 'en_retard' ? 'selected' : '' }}>En retard</option>
                <option value="retourne" {{ request('statut') == 'retourne' ? 'selected' : '' }}>Retourné</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">🔍 Filtrer</button>
        @if(request('statut'))
            <a href="{{ route('borrows.index') }}" class="btn btn-outline">✕ Réinitialiser</a>
        @endif
    </form>
</div>

<div class="card" style="padding:0; overflow:hidden;">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Livre</th>
                    @if(auth()->user()->isBibliothecaire())<th>Étudiant</th>@endif
                    <th>Emprunté le</th>
                    <th>Retour prévu</th>
                    <th>Retour réel</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrows as $borrow)
                <tr>
                    <td>
                        <a href="{{ route('books.show', $borrow->book) }}" style="font-weight:500; text-decoration:none; color:var(--primary);">
                            {{ Str::limit($borrow->book->titre, 35) }}
                        </a>
                    </td>
                    @if(auth()->user()->isBibliothecaire())
                    <td>
                        <a href="{{ route('users.show', $borrow->user) }}" style="text-decoration:none; color:var(--text);">
                            {{ $borrow->user->name }}
                        </a>
                    </td>
                    @endif
                    <td>{{ \Carbon\Carbon::parse($borrow->date_emprunt)->format('d/m/Y') }}</td>
                    <td>
                        <span style="{{ $borrow->statut === 'en_retard' ? 'color:var(--danger); font-weight:600;' : '' }}">
                            {{ \Carbon\Carbon::parse($borrow->date_retour_prevue)->format('d/m/Y') }}
                        </span>
                    </td>
                    <td>{{ $borrow->date_retour_reel ? \Carbon\Carbon::parse($borrow->date_retour_reel)->format('d/m/Y') : '—' }}</td>
                    <td>
                        <span class="badge badge-{{ $borrow->statut === 'retourne' ? 'success' : ($borrow->statut === 'en_retard' ? 'danger' : 'info') }}">
                            {{ ucfirst(str_replace('_', ' ', $borrow->statut)) }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('borrows.show', $borrow) }}" class="btn btn-outline btn-sm">Voir</a>
                            @if(auth()->user()->isBibliothecaire() && $borrow->statut !== 'retourne')
                            <form method="POST" action="{{ route('borrows.retourner', $borrow) }}" onsubmit="return confirm('Confirmer le retour ?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-primary btn-sm">✅ Retour</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:40px; color:var(--text-muted);">
                        Aucun emprunt trouvé.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination">{{ $borrows->withQueryString()->links() }}</div>

@endsection
