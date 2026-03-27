@extends('layouts.app')

@section('title', $book->titre)
@section('page-title', 'Détail du livre')

@section('topbar-actions')
    <a href="{{ route('books.index') }}" class="btn btn-outline">← Catalogue</a>
    @auth
    @if(auth()->user()->isBibliothecaire())
        <a href="{{ route('books.edit', $book) }}" class="btn btn-primary">✏️ Modifier</a>
    @endif
    @endauth
@endsection

@section('content')
<div style="display:grid; grid-template-columns: 280px 1fr; gap:24px; align-items:start;">

    {{-- Couverture + actions --}}
    <div>
        <div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius:12px; overflow:hidden; aspect-ratio:2/3; display:flex; align-items:center; justify-content:center;">
            @if($book->couverture)
                <img src="{{ Storage::url($book->couverture) }}" alt="{{ $book->titre }}" style="width:100%; height:100%; object-fit:cover;">
            @else
                <span style="font-size:4rem;">📖</span>
            @endif
        </div>

        <div style="margin-top:16px; display:flex; flex-direction:column; gap:10px;">
            @auth
            @if(auth()->user()->isBibliothecaire() && $book->estDisponible())
                <a href="{{ route('borrows.create', ['book' => $book->id]) }}" class="btn btn-accent" style="justify-content:center;">📋 Enregistrer un emprunt</a>
            @endif
            @endauth

            @if($book->estDisponible())
                <div style="background:#d4edda; border-radius:8px; padding:12px; text-align:center;">
                    <div style="font-size:1.4rem; font-weight:700; color:#155724;">{{ $book->exemplaires_disponibles }}</div>
                    <div style="font-size:0.8rem; color:#155724;">exemplaire(s) disponible(s)</div>
                </div>
            @else
                <div style="background:#f8d7da; border-radius:8px; padding:12px; text-align:center; color:#721c24;">
                    <strong>Indisponible</strong>
                </div>
            @endif
        </div>
    </div>

    {{-- Infos --}}
    <div>
        <div class="card">
            <h2 style="font-family:'Playfair Display',serif; font-size:1.6rem; color:var(--primary); margin-bottom:6px;">{{ $book->titre }}</h2>
            <p style="font-size:1rem; color:var(--text-muted); margin-bottom:16px;">par <strong>{{ $book->auteur }}</strong></p>

            @if($book->categorie)
                <span class="badge badge-muted" style="margin-bottom:16px;">{{ $book->categorie }}</span>
            @endif

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:12px;">
                @if($book->isbn)
                <div>
                    <div style="font-size:0.75rem; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:2px;">ISBN</div>
                    <div style="font-size:0.9rem;">{{ $book->isbn }}</div>
                </div>
                @endif
                @if($book->editeur)
                <div>
                    <div style="font-size:0.75rem; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:2px;">Éditeur</div>
                    <div style="font-size:0.9rem;">{{ $book->editeur }}</div>
                </div>
                @endif
                @if($book->annee_publication)
                <div>
                    <div style="font-size:0.75rem; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:2px;">Année</div>
                    <div style="font-size:0.9rem;">{{ $book->annee_publication }}</div>
                </div>
                @endif
                @if($book->localisation)
                <div>
                    <div style="font-size:0.75rem; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:2px;">Localisation</div>
                    <div style="font-size:0.9rem;">{{ $book->localisation }}</div>
                </div>
                @endif
                <div>
                    <div style="font-size:0.75rem; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:2px;">Total exemplaires</div>
                    <div style="font-size:0.9rem;">{{ $book->nombre_exemplaires }}</div>
                </div>
            </div>

            @if($book->description)
            <div style="margin-top:20px; padding-top:16px; border-top:1px solid var(--border);">
                <div style="font-size:0.75rem; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:8px;">Description</div>
                <p style="font-size:0.9rem; line-height:1.7; color:var(--text);">{{ $book->description }}</p>
            </div>
            @endif
        </div>

        {{-- Historique des emprunts (bibliothécaire only) --}}
        @auth
        @if(auth()->user()->isBibliothecaire() && $book->borrows->count() > 0)
        <div class="card">
            <div class="card-title">🔄 Historique des emprunts</div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Emprunté le</th>
                            <th>Retour prévu</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($book->borrows->take(10) as $borrow)
                        <tr>
                            <td>{{ $borrow->user->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($borrow->date_emprunt)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($borrow->date_retour_prevue)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge badge-{{ $borrow->statut === 'retourne' ? 'success' : ($borrow->statut === 'en_retard' ? 'danger' : 'info') }}">
                                    {{ ucfirst(str_replace('_', ' ', $borrow->statut)) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        @endauth
    </div>
</div>
@endsection
