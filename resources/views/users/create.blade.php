@extends('layouts.app')

@section('title', 'Nouvel utilisateur')
@section('page-title', 'Créer un utilisateur')

@section('topbar-actions')
    <a href="{{ route('users.index') }}" class="btn btn-outline">← Retour</a>
@endsection

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-title">👤 Informations de l'utilisateur</div>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Nom complet <span style="color:var(--danger)">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Email <span style="color:var(--danger)">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Mot de passe <span style="color:var(--danger)">*</span></label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Confirmer le mot de passe <span style="color:var(--danger)">*</span></label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>

        <div class="form-grid-3">
            <div class="form-group">
                <label class="form-label">Rôle <span style="color:var(--danger)">*</span></label>
                <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                    <option value="etudiant" {{ old('role') === 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                    <option value="bibliothecaire" {{ old('role') === 'bibliothecaire' ? 'selected' : '' }}>Bibliothécaire</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Matricule</label>
                <input type="text" name="matricule" class="form-control @error('matricule') is-invalid @enderror" value="{{ old('matricule') }}">
                @error('matricule') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Téléphone</label>
                <input type="text" name="telephone" class="form-control" value="{{ old('telephone') }}">
            </div>
        </div>

        <div style="display:flex; gap:10px; margin-top:8px;">
            <button type="submit" class="btn btn-accent">✅ Créer l'utilisateur</button>
            <a href="{{ route('users.index') }}" class="btn btn-outline">Annuler</a>
        </div>
    </form>
</div>
@endsection
