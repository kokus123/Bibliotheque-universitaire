@extends('layouts.app')

@section('title', 'Modifier — ' . $book->titre)
@section('page-title', 'Modifier le livre')

@section('topbar-actions')
    <a href="{{ route('books.show', $book) }}" class="btn btn-outline">← Retour</a>
@endsection

@section('content')
<div class="card" style="max-width:760px;">
    <div class="card-title">✏️ Modifier : {{ $book->titre }}</div>

    <form method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Titre <span style="color:var(--danger)">*</span></label>
                <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror" value="{{ old('titre', $book->titre) }}" required>
                @error('titre') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Auteur <span style="color:var(--danger)">*</span></label>
                <input type="text" name="auteur" class="form-control @error('auteur') is-invalid @enderror" value="{{ old('auteur', $book->auteur) }}" required>
                @error('auteur') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">ISBN</label>
                <input type="text" name="isbn" class="form-control @error('isbn') is-invalid @enderror" value="{{ old('isbn', $book->isbn) }}">
                @error('isbn') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Éditeur</label>
                <input type="text" name="editeur" class="form-control" value="{{ old('editeur', $book->editeur) }}">
            </div>
        </div>

        <div class="form-grid-3">
            <div class="form-group">
                <label class="form-label">Année de publication</label>
                <input type="number" name="annee_publication" class="form-control" value="{{ old('annee_publication', $book->annee_publication) }}" min="1000" max="{{ date('Y') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Catégorie</label>
                <input type="text" name="categorie" class="form-control" value="{{ old('categorie', $book->categorie) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Nombre d'exemplaires <span style="color:var(--danger)">*</span></label>
                <input type="number" name="nombre_exemplaires" class="form-control @error('nombre_exemplaires') is-invalid @enderror" value="{{ old('nombre_exemplaires', $book->nombre_exemplaires) }}" min="1" required>
                @error('nombre_exemplaires') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Localisation</label>
                <input type="text" name="localisation" class="form-control" value="{{ old('localisation', $book->localisation) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Nouvelle couverture</label>
                @if($book->couverture)
                    <div style="margin-bottom:8px;">
                        <img src="{{ Storage::url($book->couverture) }}" alt="couverture" style="height:60px; border-radius:4px;">
                        <small style="color:var(--text-muted); display:block; margin-top:4px;">Laisser vide pour garder l'image actuelle</small>
                    </div>
                @endif
                <input type="file" name="couverture" class="form-control @error('couverture') is-invalid @enderror" accept="image/*">
                @error('couverture') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $book->description) }}</textarea>
        </div>

        <div style="display:flex; gap:10px; margin-top:8px;">
            <button type="submit" class="btn btn-accent">✅ Mettre à jour</button>
            <a href="{{ route('books.show', $book) }}" class="btn btn-outline">Annuler</a>

            {{-- Supprimer --}}
            @if(!$book->empruntsEnCours()->exists())
            <form method="POST" action="{{ route('books.destroy', $book) }}" style="margin-left:auto;" onsubmit="return confirm('Supprimer ce livre ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">🗑 Supprimer</button>
            </form>
            @endif
        </div>
    </form>
</div>
@endsection
