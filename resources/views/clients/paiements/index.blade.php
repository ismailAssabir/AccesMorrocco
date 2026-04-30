@extends('layouts.client')

@section('title', 'Mes Paiements — Espace Client')
@section('page-title', 'Mes Paiements')
@section('page-subtitle', 'Consultez l\'historique de vos règlements')

@section('content')
@php
    $totalPaye = $paiements->getCollection()->sum('montantPaye');
    $totalReste = $paiements->getCollection()->sum('montantReste');
    $countComplet = $paiements->getCollection()->where('status', 'complet')->count();
@endphp

{{-- ═══ KPI CARDS ═══ --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    {{-- Total Payé --}}
    <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-10 -mt-10 transition-transform group-hover:scale-110"></div>
        <div class="flex items-center gap-5 relative z-10">
            <span class="p-3.5 rounded-2xl bg-emerald-50 text-emerald-600 shrink-0 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </span>
            <div>
                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Total Payé</p>
                <p class="text-2xl font-black text-slate-800">{{ number_format($totalPaye, 2, ',', ' ') }} <span class="text-xs font-bold text-slate-400">MAD</span></p>
            </div>
        </div>
    </div>

    {{-- Montant Restant --}}
    <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-rose-50 rounded-bl-full -mr-10 -mt-10 transition-transform group-hover:scale-110"></div>
        <div class="flex items-center gap-5 relative z-10">
            <span class="p-3.5 rounded-2xl bg-rose-50 text-rose-600 shrink-0 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </span>
            <div>
                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Reste à Payer</p>
                <p class="text-2xl font-black text-slate-800">{{ number_format($totalReste, 2, ',', ' ') }} <span class="text-xs font-bold text-slate-400">MAD</span></p>
            </div>
        </div>
    </div>

    {{-- Paiements Complets --}}
    <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-10 -mt-10 transition-transform group-hover:scale-110"></div>
        <div class="flex items-center gap-5 relative z-10">
            <span class="p-3.5 rounded-2xl bg-blue-50 text-blue-600 shrink-0 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </span>
            <div>
                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Règlements Complets</p>
                <p class="text-2xl font-black text-slate-800">{{ $countComplet }} <span class="text-xs font-bold text-slate-400">Paiement{{ $countComplet > 1 ? 's' : '' }}</span></p>
            </div>
        </div>
    </div>

</div>

{{-- ═══ PAIEMENTS TABLE ═══ --}}
<div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden">
    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

    {{-- Header --}}
    <div class="p-8 flex items-center justify-between border-b border-slate-100">
        <div>
            <h2 class="text-lg font-black text-slate-800">Historique des transactions</h2>
            <p class="text-xs text-slate-400 mt-1">Retrouvez le détail de tous vos versements</p>
        </div>
    </div>

    @if($paiements->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/50">
                    <th class="text-left px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest">Date</th>
                    <th class="text-left px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest">Réf / Dossier</th>
                    <th class="text-left px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest">Mode</th>
                    <th class="text-left px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest">Montant Payé</th>
                    <th class="text-left px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest">Reste</th>
                    <th class="text-left px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($paiements as $p)
                @php
                    $statusConfig = match($p->status) {
                        'complet' => ['label' => 'Complet', 'class' => 'bg-emerald-50 text-emerald-600', 'icon' => 'check-circle'],
                        'partiel' => ['label' => 'Partiel', 'class' => 'bg-amber-50 text-amber-600', 'icon' => 'clock'],
                        'annule'  => ['label' => 'Annulé',  'class' => 'bg-rose-50 text-rose-600', 'icon' => 'x-circle'],
                        default   => ['label' => $p->status, 'class' => 'bg-slate-100 text-slate-500', 'icon' => 'info'],
                    };
                @endphp
                <tr class="hover:bg-slate-50/50 transition-colors">
                    
                    {{-- Date --}}
                    <td class="px-8 py-6">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($p->date)->format('d M Y') }}</span>
                            <span class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($p->date)->format('H:i') }}</span>
                        </div>
                    </td>

                    {{-- Réf / Dossier --}}
                    <td class="px-8 py-6">
                        <div class="flex flex-col gap-0.5">
                            <span class="font-black text-[#b11d40] text-xs">{{ $p->ref ?? 'TRX-'.strtoupper(substr(md5($p->idPaiement), 0, 8)) }}</span>
                            <span class="text-[10px] font-medium text-slate-400">Dossier: {{ $p->dossier->reference ?? '—' }}</span>
                        </div>
                    </td>

                    {{-- Mode --}}
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-2">
                            <span class="p-1.5 rounded-lg bg-slate-100 text-slate-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </span>
                            <span class="font-semibold text-slate-600 capitalize">{{ $p->modePaiement ?? 'Virement' }}</span>
                        </div>
                    </td>

                    {{-- Montant Payé --}}
                    <td class="px-8 py-6">
                        <span class="font-black text-slate-800">{{ number_format($p->montantPaye, 2, ',', ' ') }}</span>
                        <span class="text-[10px] font-bold text-slate-400 ml-0.5">MAD</span>
                    </td>

                    {{-- Reste --}}
                    <td class="px-8 py-6">
                        <span class="font-bold {{ $p->montantReste > 0 ? 'text-rose-500' : 'text-slate-400' }}">
                            {{ number_format($p->montantReste, 2, ',', ' ') }}
                        </span>
                        <span class="text-[10px] font-bold text-slate-300 ml-0.5">MAD</span>
                    </td>

                    {{-- Statut --}}
                    <td class="px-8 py-6">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-black tracking-tight {{ $statusConfig['class'] }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                            {{ $statusConfig['label'] }}
                        </span>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($paiements->hasPages())
    <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/30">
        {{ $paiements->links() }}
    </div>
    @endif

    @else
    {{-- Empty state --}}
    <div class="flex flex-col items-center justify-center py-24 px-8 text-center">
        <div class="w-24 h-24 rounded-[2rem] bg-slate-50 flex items-center justify-center mb-6 shadow-inner">
            <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
        </div>
        <h3 class="text-2xl font-black text-slate-800">Aucun paiement trouvé</h3>
        <p class="text-slate-400 mt-2 max-w-xs text-sm">Dès que vous effectuerez un règlement, il apparaîtra ici avec tous les détails.</p>
    </div>
    @endif
</div>

@endsection
