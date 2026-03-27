@extends('layouts.app')

@section('title', 'Catalogue des livres')
@section('page-title', 'Catalogue')

@section('topbar-actions')
    @auth
    @if(auth()->user()->isBibliothecaire())
        <a href="{{ route('books.create') }}" class="btn btn-accent">+ Ajouter un livre</a>
    @endif
    @endauth
@endsection

@section('content')

{{-- Filtres --}}
<div class="card" style="margin-bottom:20px; padding:16px 20px;">
    <form method="GET" action="{{ route('books.index') }}" style="display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end;">
        <div style="flex:1; min-width:200px;">
            <label class="form-label">Recherche</label>
            <input type="text" name="recherche" class="form-control" placeholder="Titre, auteur, ISBN..." value="{{ request('recherche') }}">
        </div>
        <div style="min-width:160px;">
            <label class="form-label">Catégorie</label>
            <select name="categorie" class="form-control">
                <option value="">Toutes</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('categorie') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div style="display:flex; align-items:center; gap:8px; padding-bottom:2px;">
            <input type="checkbox" name="disponible" id="disponible" value="1" {{ request('disponible') ? 'checked' : '' }}>
            <label for="disponible" style="font-size:0.875rem; cursor:pointer;">Disponibles seulement</label>
        </div>
        <button type="submit" class="btn btn-primary">🔍 Filtrer</button>
        @if(request()->hasAny(['recherche','categorie','disponible']))
            <a href="{{ route('books.index') }}" class="btn btn-outline">✕ Réinitialiser</a>
        @endif
    </form>
</div>

{{-- Résultats --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
    <p style="color:var(--text-muted); font-size:0.875rem;">{{ $books->total() }} livre(s) trouvé(s)</p>
</div>

@if($books->count() > 0)
<div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap:20px;">
    @foreach($books as $book)
    <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; overflow:hidden; transition: box-shadow 0.2s;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='none'">
        
        {{-- Couverture CORRIGÉE --}}
        <div style="height:220px; background: #f0f0f0; display:flex; align-items:center; justify-content:center; position:relative; overflow:hidden;">
            @if($book->couverture)
                @php
                    // On vérifie si c'est une URL externe ou un fichier local
                    $urlCouverture = Str::startsWith($book->couverture, ['http://', 'https://']) 
                                    ? $book->couverture 
                                    : asset($book->couverture);
                @endphp
                <img src="{{ $urlCouverture }}" alt="{{ $book->titre }}" style="width:100%; height:100%; object-fit:cover;">
            @else
                {{-- Fond dégradé si pas d'image --}}
                <div style="width:100%; height:100%; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); display:flex; align-items:center; justify-content:center;">
                    <span style="font-size:3.5rem;">📖</span>
                </div>
            @endif

            {{-- Badge de disponibilité --}}
            @if(!$book->estDisponible())
                <div style="position:absolute; top:10px; right:10px; background:var(--danger); color:#fff; font-size:0.7rem; font-weight:600; padding:3px 8px; border-radius:20px; z-index:10;">Indisponible</div>
            @else
                <div style="position:absolute; top:10px; right:10px; background:var(--success); color:#fff; font-size:0.7rem; font-weight:600; padding:3px 8px; border-radius:20px; z-index:10;">{{ $book->exemplaires_disponibles }} dispo.</div>
            @endif
        </div>

        <div style="padding:14px;">
            <h3 style="font-family:'Playfair Display',serif; font-size:0.95rem; font-weight:600; margin-bottom:4px; line-height:1.3;">
                <a href="{{ route('books.show', $book) }}" style="text-decoration:none; color:var(--text);">{{ Str::limit($book->titre, 50) }}</a>
            </h3>
            <p style="font-size:0.8rem; color:var(--text-muted); margin-bottom:8px;">{{ $book->auteur }}</p>
            
            @if($book->categorie)
                <span class="badge badge-muted">{{ $book->categorie }}</span>
            @endif

            <div style="margin-top:12px; display:flex; gap:6px; flex-wrap:wrap;">
                <a href="{{ route('books.show', $book) }}" class="btn btn-outline btn-sm">Voir</a>
                @auth
                    @if(auth()->user()->isBibliothecaire() && $book->estDisponible())
                        <a href="{{ route('borrows.create', ['book' => $book->id]) }}" class="btn btn-primary btn-sm">Emprunter</a>
                    @endif
                    @if(auth()->user()->isBibliothecaire())
                        <a href="{{ route('books.edit', $book) }}" class="btn btn-outline btn-sm">✏️</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Pagination --}}
<div class="pagination" style="margin-top: 30px;">
    {{ $books->withQueryString()->links() }}
</div>

@else
{{-- Vue vide si aucun livre --}}
<div class="card" style="text-align:center; padding:48px;">
    <div style="font-size:3rem;">📚</div>
    <p style="color:var(--text-muted); margin-top:12px;">Aucun livre trouvé.</p>
    @auth
    @if(auth()->user()->isBibliothecaire())
        <a href="{{ route('books.create') }}" class="btn btn-accent" style="margin-top:16px;">Ajouter le premier livre</a>
    @endif
    @endauth
</div>
@endif

@endsection