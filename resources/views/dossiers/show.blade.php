<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen">

        {{-- Header --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <a href="{{ route('dossiers.index') }}"
                   class="inline-flex items-center gap-2 text-slate-400 hover:text-[#b11d40] text-sm font-bold mb-2 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Retour aux dossiers
                </a>
                <h1 class="text-2xl font-extrabold text-slate-800">{{ $dossier->reference }}</h1>
                <p class="text-slate-500 text-sm">{{ $dossier->distination ?? 'Aucune destination' }}</p>
            </div>
            <div class="flex gap-3">
                @can('dossier.edit')
                <a href="{{ route('dossiers.edit', $dossier->idDossier) }}"
                   class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </a>
                @endcan
                @can('dossier.delete')
                <form method="POST" action="{{ route('dossiers.destroy', $dossier->idDossier) }}"
                      onsubmit="return confirm('Supprimer ce dossier ?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="flex items-center gap-2 px-4 py-2 bg-white border border-red-200 text-red-500 font-bold rounded-xl hover:bg-red-500 hover:text-white transition-all text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Supprimer
                    </button>
                </form>
                @endcan
            </div>
        </div>

        {{-- Flash --}}
        @if(session('msg'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm font-semibold">
            {{ session('msg') }}
        </div>
        @endif

        @php
            $statusColors = ['ouvert' => 'bg-blue-100 text-blue-600', 'en_cours' => 'bg-yellow-100 text-yellow-700', 'ferme' => 'bg-slate-100 text-slate-500'];
            $statusLabels = ['ouvert' => 'Ouvert', 'en_cours' => 'En cours', 'ferme' => 'Fermé'];
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Colonne gauche --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Carte dossier --}}
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6">
                        <div class="flex flex-col items-center text-center mb-6">
                            <div class="w-16 h-16 rounded-2xl bg-[#b11d40]/10 flex items-center justify-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#b11d40]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h2 class="text-lg font-extrabold text-slate-800">{{ $dossier->reference }}</h2>
                            <span class="mt-2 px-3 py-1 rounded-xl text-xs font-black uppercase {{ $statusColors[$dossier->status] ?? '' }}">
                                {{ $statusLabels[$dossier->status] ?? $dossier->status }}
                            </span>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">Client</span>
                                <span class="text-sm font-bold text-slate-700">{{ $dossier->client->firstName ?? '—' }} {{ $dossier->client->lastName ?? '' }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">Département</span>
                                <span class="text-sm font-bold text-slate-700">{{ $dossier->departement->title ?? '—' }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">Destination</span>
                                <span class="text-sm font-bold text-slate-700">{{ $dossier->distination ?? '—' }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">Date voyage</span>
                                <span class="text-sm font-bold text-slate-700">
                                    {{ $dossier->dateVoyage ? \Carbon\Carbon::parse($dossier->dateVoyage)->format('d/m/Y') : '—' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">Personnes</span>
                                <span class="text-sm font-bold text-slate-700">{{ $dossier->nombrePersonnes }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">Jours</span>
                                <span class="text-sm font-bold text-slate-700">{{ $dossier->nombreJours }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-[#b11d40]/5 rounded-2xl border border-[#b11d40]/10">
                                <span class="text-xs font-black text-[#b11d40] uppercase">Montant</span>
                                <span class="text-sm font-black text-[#b11d40]">{{ number_format($dossier->montant, 2) }} MAD</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Colonne droite --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Commentaire & Réponse --}}
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6 space-y-4">
                        <div>
                            <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-2">Commentaire</h3>
                            @if($dossier->commentaire)
                                <p class="text-sm text-slate-700 bg-slate-50 rounded-2xl p-4 leading-relaxed">{{ $dossier->commentaire }}</p>
                            @else
                                <p class="text-sm text-slate-400 italic">Aucun commentaire.</p>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-2">Réponse</h3>
                            @if($dossier->reponse)
                                <p class="text-sm text-slate-700 bg-slate-50 rounded-2xl p-4 leading-relaxed">{{ $dossier->reponse }}</p>
                            @else
                                <p class="text-sm text-slate-400 italic">Aucune réponse.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Paiements --}}
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6">
                        <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-4">
                            Paiements
                            <span class="ml-2 px-2 py-0.5 rounded-lg bg-slate-100 text-slate-500 text-xs">{{ $dossier->paiements->count() }}</span>
                        </h3>
                        @forelse($dossier->paiements as $paiement)
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-2xl mb-2">
                            <div>
                                <p class="text-xs font-black text-slate-700">{{ $paiement->reference ?? '—' }}</p>
                                <p class="text-xs text-slate-400">{{ $paiement->created_at?->format('d/m/Y') }}</p>
                            </div>
                            <span class="text-sm font-black text-green-600">{{ number_format($paiement->montant ?? 0, 2) }} MAD</span>
                        </div>
                        @empty
                        <p class="text-sm text-slate-400 italic">Aucun paiement enregistré.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Présentations --}}
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6">
                        <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-4">
                            Présentations
                            <span class="ml-2 px-2 py-0.5 rounded-lg bg-slate-100 text-slate-500 text-xs">{{ $dossier->presentations->count() }}</span>
                        </h3>
                        @forelse($dossier->presentations as $presentation)
                        <div class="p-4 bg-slate-50 rounded-2xl mb-3 border border-slate-100">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <p class="text-sm font-black text-slate-700">{{ $presentation->titre ?? '—' }}</p>
                                    <p class="text-[10px] text-slate-400 uppercase font-bold">{{ $presentation->created_at?->format('d/m/Y') }}</p>
                                </div>
                                <span class="text-sm font-black text-[#b11d40]">{{ number_format($presentation->total, 2) }} MAD</span>
                            </div>
                            
                            @if($presentation->presentationItems->count() > 0)
                            <div class="mt-3 space-y-1 pl-2 border-l-2 border-slate-200">
                                @foreach($presentation->presentationItems as $item)
                                <div class="flex justify-between text-[11px] text-slate-500">
                                    <span>{{ $item->quantity }}x {{ $item->category->title ?? 'Article' }}</span>
                                    <span class="font-bold">{{ number_format($item->totale, 2) }} MAD</span>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @empty
                        <p class="text-sm text-slate-400 italic">Aucune présentation enregistrée.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>