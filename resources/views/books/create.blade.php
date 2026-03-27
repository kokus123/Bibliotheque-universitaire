@extends('layouts.app')

@section('title', 'Ajouter un livre')
@section('page-title', 'Nouveau livre')

@section('topbar-actions')
    <a href="{{ route('books.index') }}" class="btn btn-outline">← Retour</a>
@endsection

@section('content')
<div class="card" style="max-width:760px;">
    <div class="card-title">📖 Informations du livre</div>

    <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Titre <span style="color:var(--danger)">*</span></label>
                <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror" value="{{ old('titre') }}" required>
                @error('titre') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Auteur <span style="color:var(--danger)">*</span></label>
                <input type="text" name="auteur" class="form-control @error('auteur') is-invalid @enderror" value="{{ old('auteur') }}" required>
                @error('auteur') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">ISBN</label>
                <input type="text" name="isbn" class="form-control @error('isbn') is-invalid @enderror" value="{{ old('isbn') }}">
                @error('isbn') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Éditeur</label>
                <input type="text" name="editeur" class="form-control" value="{{ old('editeur') }}">
            </div>
        </div>

        <div class="form-grid-3">
            <div class="form-group">
                <label class="form-label">Année de publication</label>
                <input type="number" name="annee_publication" class="form-control" value="{{ old('annee_publication') }}" min="1000" max="{{ date('Y') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Catégorie</label>
                <input type="text" name="categorie" class="form-control" value="{{ old('categorie') }}" placeholder="ex: Informatique">
            </div>
            <div class="form-group">
                <label class="form-label">Nombre d'exemplaires <span style="color:var(--danger)">*</span></label>
                <input type="number" name="nombre_exemplaires" class="form-control @error('nombre_exemplaires') is-invalid @enderror" value="{{ old('nombre_exemplaires', 1) }}" min="1" required>
                @error('nombre_exemplaires') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Localisation (étagère, salle...)</label>
                <input type="text" name="localisation" class="form-control" value="{{ old('localisation') }}" placeholder="ex: Rayon A - Étagère 3">
            </div>
            <div class="form-group">
                <label class="form-label">Image de couverture</label>
                <input type="file" name="couverture" class="form-control @error('couverture') is-invalid @enderror" accept="image/*">
                @error('couverture') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Résumé ou description du livre...">{{ old('description') }}</textarea>
        </div>

        <div style="display:flex; gap:10px; margin-top:8px;">
            <button type="submit" class="btn btn-accent">✅ Enregistrer le livre</button>
            <a href="{{ route('books.index') }}" class="btn btn-outline">Annuler</a>
        </div>
    </form>
</div>
@endsection
