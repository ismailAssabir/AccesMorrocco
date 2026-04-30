{{-- resources/views/clients/dossiers/show.blade.php --}}

@extends('layouts.client')
    @section('title', 'Dossier #' . $dossier->reference . ' - Access Morocco')
    @section('page-title', 'Détails du Dossier')
    @section('page-subtitle', 'Référence : ' . $dossier->reference)
@section('content')
    <div class="space-y-6 pb-12">
        {{-- Barre d'actions --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('clients.dossiers') }}" class="flex items-center gap-2 text-slate-500 hover:text-[#be2346] transition-colors text-sm font-bold">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Retour à la liste
            </a>
            
            @php
                $statusClasses = match($dossier->status) {
                    'ouvert' => 'bg-blue-50 text-blue-600 border-blue-100',
                    'en_cours' => 'bg-amber-50 text-amber-600 border-amber-100',
                    'ferme' => 'bg-slate-100 text-slate-500 border-slate-200',
                    default => 'bg-slate-50 text-slate-600 border-slate-100',
                };
            @endphp
            <span class="px-4 py-1.5 rounded-full text-xs font-black uppercase border {{ $statusClasses }}">
                Statut : {{ $dossier->status }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Colonne Principale : Détails du Voyage --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Informations Générales</h3>
                    </div>
                    <div class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Destination</label>
                                <p class="text-lg font-bold text-slate-800 mt-1 uppercase">{{ $dossier->distination ?? 'Non définie' }}</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Date de création</label>
                                <p class="text-slate-700 font-bold mt-1">{{ \Carbon\Carbon::parse($dossier->dateCreation)->format('d F Y') }}</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Date de voyage prévue</label>
                                <p class="text-slate-700 font-bold mt-1">
                                    {{ $dossier->dateVoyage ? \Carbon\Carbon::parse($dossier->dateVoyage)->format('d/m/Y') : 'À confirmer' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Durée du séjour</label>
                                <p class="text-slate-700 font-bold mt-1">{{ $dossier->nombreJours }} Jours</p>
                            </div>
                        </div>

                        <div class="mt-8 pt-8 border-t border-slate-100">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Votre commentaire / Demande</label>
                            <div class="mt-2 p-4 bg-slate-50 rounded-2xl text-sm text-slate-600 leading-relaxed italic">
                                "{{ $dossier->commentaire ?? 'Aucun commentaire fourni.' }}"
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Réponse de l'administration --}}
                @if($dossier->reponse)
                <div class="bg-[#be2346]/5 rounded-3xl border border-[#be2346]/10 overflow-hidden">
                    <div class="px-8 py-6 border-b border-[#be2346]/10 bg-white/50">
                        <h3 class="text-sm font-black text-[#be2346] uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                            Réponse Access Morocco
                        </h3>
                    </div>
                    <div class="p-8 text-sm text-slate-700 leading-relaxed font-medium">
                        {!! nl2br(e($dossier->reponse)) !!}
                    </div>
                </div>
                @endif
            </div>

            {{-- Colonne Latérale : Résumé & Documents --}}
            <div class="space-y-6">
                {{-- Card Montant --}}
                <div class="bg-slate-900 rounded-3xl p-8 text-white shadow-xl shadow-slate-200 relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 mb-2">Montant du dossier</p>
                        <h4 class="text-3xl font-black">{{ number_format($dossier->montant, 2, ',', ' ') }} <span class="text-sm font-light text-slate-400">MAD</span></h4>
                        <div class="mt-6 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <p class="text-xs font-bold">{{ $dossier->nombrePersonnes }} Personne(s)</p>
                        </div>
                    </div>
                    {{-- Décoration --}}
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/5 rounded-full blur-2xl"></div>
                </div>

                {{-- Card Document --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-4">Document joint</h3>
                    @if($dossier->document)
                        <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-2xl border border-slate-100 group">
                            <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-[#be2346]">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-slate-700 truncate">{{ $dossier->titreDocument ?? 'Fiche dossier' }}</p>
                                <a href="{{ asset('storage/' . $dossier->document) }}" target="_blank" class="text-[10px] font-black text-[#be2346] hover:underline uppercase tracking-tighter">Télécharger</a>
                            </div>
                        </div>
                    @else
                        <p class="text-xs text-slate-400 italic">Aucun document attaché.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection