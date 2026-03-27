@extends('layouts.app')

@section('title', 'Nouvel emprunt')
@section('page-title', 'Enregistrer un emprunt')

@section('topbar-actions')
    <a href="{{ route('borrows.index') }}" class="btn btn-outline">← Retour</a>
@endsection

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-title">📋 Nouvel emprunt</div>

    {{-- Infos livre --}}
    <div style="background:var(--bg); border-radius:8px; padding:14px; margin-bottom:20px; display:flex; gap:14px; align-items:center;">
        <span style="font-size:2rem;">📖</span>
        <div>
            <div style="font-weight:600; font-size:1rem;">{{ $book->titre }}</div>
            <div style="font-size:0.85rem; color:var(--text-muted);">{{ $book->auteur }}</div>
            <div style="font-size:0.8rem; margin-top:4px;">
                <span class="badge badge-success">{{ $book->exemplaires_disponibles }} disponible(s)</span>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('borrows.store') }}">
        @csrf
        <input type="hidden" name="book_id" value="{{ $book->id }}">

        <div class="form-group">
            <label class="form-label">Étudiant <span style="color:var(--danger)">*</span></label>
            <select name="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                <option value="">-- Sélectionner un étudiant --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} — {{ $user->matricule ?? $user->email }}
                    </option>
                @endforeach
            </select>
            @error('user_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Date d'emprunt <span style="color:var(--danger)">*</span></label>
                <input type="date" name="date_emprunt" class="form-control @error('date_emprunt') is-invalid @enderror"
                    value="{{ old('date_emprunt', date('Y-m-d')) }}" required>
                @error('date_emprunt') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Date de retour prévue <span style="color:var(--danger)">*</span></label>
                <input type="date" name="date_retour_prevue" class="form-control @error('date_retour_prevue') is-invalid @enderror"
                    value="{{ old('date_retour_prevue', date('Y-m-d', strtotime('+14 days'))) }}" required>
                @error('date_retour_prevue') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Notes (optionnel)</label>
            <textarea name="notes" class="form-control" rows="3" placeholder="Remarques éventuelles...">{{ old('notes') }}</textarea>
        </div>

        <div style="display:flex; gap:10px; margin-top:8px;">
            <button type="submit" class="btn btn-accent">✅ Enregistrer l'emprunt</button>
            <a href="{{ route('books.show', $book) }}" class="btn btn-outline">Annuler</a>
        </div>
    </form>
</div>
@endsection
