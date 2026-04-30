@extends('layouts.client')

@section('title', 'Mes Présentations — Espace Client')
@section('page-title', 'Mes Présentations')
@section('page-subtitle', 'Consultez vos dossiers de présentation')

@section('content')
<div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden">
    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

    <div class="p-8 flex items-center justify-between border-b border-slate-100">
        <div>
            <h2 class="text-lg font-black text-slate-800">Mes Présentations</h2>
            <p class="text-xs text-slate-400 mt-1">Vos documents de présentation par dossier</p>
        </div>
    </div>

    @if($presentations->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/50">
                    <th class="text-left px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest">Titre</th>
                    <th class="text-left px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest">Dossier</th>
                    <th class="text-left px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest">Date</th>
                    <th class="text-right px-8 py-5 text-[10px] font-black uppercase text-slate-400 tracking-widest">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($presentations as $pres)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-6">
                        <span class="font-bold text-slate-700">{{ $pres->titre }}</span>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-xs font-black text-[#b11d40]">{{ $pres->dossier->reference ?? '—' }}</span>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-slate-500">{{ $pres->created_at->format('d/m/Y') }}</span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        @if($pres->fichier)
                        <a href="{{ asset('storage/'.$pres->fichier) }}" target="_blank" class="text-[#b11d40] font-bold hover:underline">Télécharger</a>
                        @else
                        <span class="text-slate-300">Indisponible</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($presentations->hasPages())
    <div class="px-8 py-6 border-t border-slate-100">
        {{ $presentations->links() }}
    </div>
    @endif
    @else
    <div class="flex flex-col items-center justify-center py-24 px-8 text-center">
        <div class="w-24 h-24 rounded-[2rem] bg-slate-50 flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <h3 class="text-2xl font-black text-slate-800">Aucune présentation</h3>
        <p class="text-slate-400 mt-2 max-w-xs text-sm">Vos documents de présentation apparaîtront ici.</p>
    </div>
    @endif
</div>
@endsection
