@extends('layouts.app')

@section('title', 'Modifier — ' . $user->name)
@section('page-title', 'Modifier l\'utilisateur')

@section('topbar-actions')
    <a href="{{ route('users.show', $user) }}" class="btn btn-outline">← Profil</a>
@endsection

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-title">✏️ Modifier : {{ $user->name }}</div>

    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf @method('PUT')

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Nom complet <span style="color:var(--danger)">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Email <span style="color:var(--danger)">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-grid-3">
            <div class="form-group">
                <label class="form-label">Rôle <span style="color:var(--danger)">*</span></label>
                <select name="role" class="form-control" required>
                    <option value="etudiant" {{ old('role', $user->role) === 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                    <option value="bibliothecaire" {{ old('role', $user->role) === 'bibliothecaire' ? 'selected' : '' }}>Bibliothécaire</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Matricule</label>
                <input type="text" name="matricule" class="form-control @error('matricule') is-invalid @enderror" value="{{ old('matricule', $user->matricule) }}">
                @error('matricule') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Téléphone</label>
                <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $user->telephone) }}">
            </div>
        </div>

        <div style="padding:14px; background:var(--bg); border-radius:8px; margin-bottom:16px;">
            <p style="font-size:0.85rem; font-weight:500; margin-bottom:12px;">🔐 Changer le mot de passe (laisser vide pour ne pas modifier)</p>
            <div class="form-grid-2">
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Nouveau mot de passe</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Confirmer</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>
        </div>

        <div style="display:flex; gap:10px; margin-top:8px;">
            <button type="submit" class="btn btn-accent">✅ Mettre à jour</button>
            <a href="{{ route('users.show', $user) }}" class="btn btn-outline">Annuler</a>
        </div>
    </form>
</div>
@endsection
