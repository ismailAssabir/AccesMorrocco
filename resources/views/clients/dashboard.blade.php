@extends('layouts.client')

@section('title', 'Tableau de bord — Espace Client')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Suivez vos dossiers et paiements')

@section('content')
@php
    $totalDossiers   = $dossiers->total();
    $enCours         = $dossiers->getCollection()->where('status', 'en_cours')->count();
    $termines        = $dossiers->getCollection()->where('status', 'ferme')->count();
    $totalPaiements  = $dossiers->getCollection()->sum(fn($d) => $d->montant ?? 0);
@endphp



{{-- ═══ KPI CARDS ═══ --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

    <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
        <span class="p-2.5 rounded-xl bg-[#b11d40]/10 text-[#b11d40] shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
        </span>
        <div>
            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Dossiers</p>
            <p class="text-2xl font-extrabold text-slate-800">{{ $totalDossiers }}</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
        <span class="p-2.5 rounded-xl bg-amber-50 text-amber-500 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </span>
        <div>
            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">En cours</p>
            <p class="text-2xl font-extrabold text-slate-800">{{ $enCours }}</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
        <span class="p-2.5 rounded-xl bg-emerald-50 text-emerald-500 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </span>
        <div>
            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Terminés</p>
            <p class="text-2xl font-extrabold text-slate-800">{{ $termines }}</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
        <span class="p-2.5 rounded-xl bg-blue-50 text-blue-500 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
        </span>
        <div>
            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Total</p>
            <p class="text-2xl font-extrabold text-slate-800">{{ number_format($totalPaiements, 0, ',', ' ') }} <span class="text-sm text-slate-400">MAD</span></p>
        </div>
    </div>
</div>

{{-- ═══ DOSSIERS TABLE ═══ --}}
<div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

    {{-- Header --}}
    <div class="p-6 flex items-center justify-between border-b border-slate-100">
        <div>
            <h2 class="text-base font-extrabold text-slate-800">Mes dossiers de voyage</h2>
            <p class="text-xs text-slate-400 mt-0.5">{{ $totalDossiers }} dossier{{ $totalDossiers > 1 ? 's' : '' }} au total</p>
        </div>
        <a href="{{ route('clients.dossiers') }}"
           class="inline-flex items-center gap-1.5 text-xs font-bold text-[#b11d40] border border-[#b11d40]/30 hover:bg-[#b11d40] hover:text-white px-4 py-2 rounded-xl transition-all duration-200">
            Voir tout
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    @if($dossiers->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/60">
                    <th class="text-left px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Référence</th>
                    <th class="text-left px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Destination</th>
                    <th class="text-left px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Date voyage</th>
                    <th class="text-left px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Personnes</th>
                    <th class="text-left px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Montant</th>
                    <th class="text-left px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Statut</th>
                    <th class="text-right px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($dossiers as $dossier)
                @php
                    $statusConfig = match($dossier->status) {
                        'ouvert'   => ['label' => 'Ouvert',    'class' => 'bg-blue-50 text-blue-600'],
                        'en_cours' => ['label' => 'En cours',  'class' => 'bg-amber-50 text-amber-600'],
                        'ferme'    => ['label' => 'Terminé',   'class' => 'bg-emerald-50 text-emerald-600'],
                        default    => ['label' => $dossier->status, 'class' => 'bg-slate-100 text-slate-500'],
                    };
                @endphp
                <tr class="hover:bg-slate-50/60 transition-colors">

                    {{-- Référence --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-[#b11d40]/10 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-[#b11d40]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                            </div>
                            <span class="font-black text-slate-800 text-xs">{{ $dossier->reference }}</span>
                        </div>
                    </td>

                    {{-- Destination --}}
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-700">{{ $dossier->distination ?? '—' }}</p>
                    </td>

                    {{-- Date --}}
                    <td class="px-6 py-4">
                        <p class="text-slate-600">
                            {{ $dossier->date_voyage ? \Carbon\Carbon::parse($dossier->date_voyage)->format('d/m/Y') : '—' }}
                        </p>
                    </td>

                    {{-- Personnes --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-slate-600 font-medium">{{ $dossier->nombre_personne }}</span>
                        </div>
                    </td>

                    {{-- Montant --}}
                    <td class="px-6 py-4">
                        <span class="font-black text-slate-800">{{ number_format($dossier->montant ?? 0, 0, ',', ' ') }}</span>
                        <span class="text-xs text-slate-400 ml-1">MAD</span>
                    </td>

                    {{-- Statut --}}
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-black {{ $statusConfig['class'] }}">
                            {{ $statusConfig['label'] }}
                        </span>
                    </td>

                    {{-- Action --}}
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('clients.dossiers.show', $dossier->idDossier) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-bold text-[#b11d40] border border-[#b11d40]/30 hover:bg-[#b11d40] hover:text-white px-4 py-2 rounded-xl transition-all duration-200 active:scale-95">
                            Détails
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($dossiers->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $dossiers->links() }}
    </div>
    @endif

    @else
    {{-- Empty state --}}
    <div class="flex flex-col items-center justify-center py-20 px-8 text-center">
        <div class="w-20 h-20 rounded-3xl bg-[#b11d40]/10 flex items-center justify-center mb-5">
            <svg class="w-10 h-10 text-[#b11d40]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
        </div>
        <h3 class="text-xl font-extrabold text-slate-800">Aucun dossier</h3>
        <p class="text-slate-500 mt-2 max-w-sm text-sm">Vous n'avez pas encore de dossier de voyage.</p>
    </div>
    @endif
</div>

@endsection