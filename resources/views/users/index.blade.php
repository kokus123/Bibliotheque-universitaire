@extends('layouts.app')

@section('title', 'Utilisateurs')
@section('page-title', 'Gestion des utilisateurs')

@section('topbar-actions')
    <a href="{{ route('users.create') }}" class="btn btn-accent">+ Nouvel utilisateur</a>
@endsection

@section('content')

{{-- Filtres --}}
<div class="card" style="margin-bottom:20px; padding:16px 20px;">
    <form method="GET" style="display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end;">
        <div style="flex:1; min-width:200px;">
            <label class="form-label">Recherche</label>
            <input type="text" name="recherche" class="form-control" placeholder="Nom, email, matricule..." value="{{ request('recherche') }}">
        </div>
        <div style="min-width:160px;">
            <label class="form-label">Rôle</label>
            <select name="role" class="form-control">
                <option value="">Tous</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="bibliothecaire" {{ request('role') == 'bibliothecaire' ? 'selected' : '' }}>Bibliothécaire</option>
                <option value="etudiant" {{ request('role') == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">🔍 Filtrer</button>
        @if(request()->hasAny(['recherche','role']))
            <a href="{{ route('users.index') }}" class="btn btn-outline">✕</a>
        @endif
    </form>
</div>

<div class="card" style="padding:0; overflow:hidden;">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Matricule</th>
                    <th>Rôle</th>
                    <th>Emprunts actifs</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:34px; height:34px; background:var(--primary); border-radius:50%; display:flex; align-items:center; justify-content:center; color:var(--accent); font-size:0.8rem; font-weight:700; flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <a href="{{ route('users.show', $user) }}" style="font-weight:500; text-decoration:none; color:var(--primary);">
                                {{ $user->name }}
                            </a>
                        </div>
                    </td>
                    <td style="color:var(--text-muted); font-size:0.875rem;">{{ $user->email }}</td>
                    <td style="font-size:0.875rem;">{{ $user->matricule ?? '—' }}</td>
                    <td>
                        <span class="badge badge-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'bibliothecaire' ? 'warning' : 'info') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>{{ $user->empruntsEnCours()->count() }}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('users.show', $user) }}" class="btn btn-outline btn-sm">Voir</a>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-outline btn-sm">✏️</a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:40px; color:var(--text-muted);">Aucun utilisateur trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination">{{ $users->withQueryString()->links() }}</div>

@endsection
