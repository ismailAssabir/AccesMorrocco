@extends('layouts.client')

@section('title', 'Tableau de bord')

@section('content')
<div class="p-8">
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-slate-800">Tableau de bord</h1>
        <p class="text-slate-500 text-sm">Bienvenue, {{ $client->firstName }} {{ $client->lastName }}</p>
    </div>

    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
        <div class="p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Mes dossiers de voyage</h2>
            
            @if($dossiers->count() > 0)
                <div class="space-y-3">
                    @foreach($dossiers as $dossier)
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-slate-800">Réf: {{ $dossier->reference }}</p>
                                    <p class="text-sm text-slate-500">Destination: {{ $dossier->distination }}</p>
                                    <p class="text-sm text-slate-500">Date: {{ $dossier->dateVoyage ?? 'Non définie' }}</p>
                                    <p class="text-sm text-slate-500">Statut: 
                                        <span class="px-2 py-1 rounded-lg text-xs font-bold 
                                            @if($dossier->status == 'ouvert') bg-blue-100 text-blue-700
                                            @elseif($dossier->status == 'en_cours') bg-amber-100 text-amber-700
                                            @else bg-green-100 text-green-700
                                            @endif">
                                            {{ $dossier->status }}
                                        </span>
                                    </p>
                                </div>
                                <a href="{{ route('dossiers.show', $dossier->idDossier) }}" 
                                   class="text-[#b11d40] hover:text-[#7c1233] font-semibold text-sm">
                                    Voir détails →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $dossiers->links() }}
                </div>
            @else
                <p class="text-slate-400 text-center py-8">Aucun dossier trouvé</p>
            @endif
        </div>
    </div>
</div>
@endsection