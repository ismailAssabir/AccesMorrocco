@extends('layouts.client')

@section('title', 'Détails Présentation — Espace Client')
@section('page-title', 'Détails Présentation')
@section('page-subtitle', $presentation->titre)

@section('content')
<div class="space-y-8 animate-fadeIn">
    {{-- Header / Breadcrumb --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('clients.presentations') }}" class="flex items-center gap-2 text-slate-400 hover:text-[#b11d40] font-bold text-sm transition-all group">
            <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            Retour aux présentations
        </a>
        <div class="flex items-center gap-3">
            @if($presentation->fichier)
            <a href="{{ asset('storage/'.$presentation->fichier) }}" target="_blank" class="flex items-center gap-2 px-6 py-2.5 bg-slate-100 text-slate-600 rounded-2xl font-bold text-sm hover:bg-slate-200 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                PDF Officiel
            </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- Presentation Items --}}
            <div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden">
                <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-xl font-black text-slate-800">Détails de la proposition</h2>
                            <p class="text-xs text-slate-400 mt-1 uppercase font-bold tracking-widest">Dossier: {{ $presentation->dossier->reference }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Total Estimé</p>
                            <p class="text-2xl font-black text-[#b11d40]">{{ number_format($presentation->total, 2) }} MAD</p>
                        </div>
                    </div>

                    <div class="space-y-4" x-data="{
                        loading: null,
                        async toggleItem(id, currentStatus) {
                            const newStatus = currentStatus === 'validee' ? 'en_attente' : 'validee';
                            this.loading = id;
                            console.log('Toggling item:', id, 'to', newStatus);
                            
                            try {
                                const url = '{{ route("clients.presentations.item.status", ["id" => ":id"]) }}'.replace(':id', id);
                                const res = await fetch(url, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest'
                                    },
                                    body: JSON.stringify({ 
                                        status: newStatus,
                                        _method: 'PATCH'
                                    })
                                });
                                
                                if(res.ok) {
                                    console.log('Update successful, reloading...');
                                    window.location.reload();
                                } else {
                                    const data = await res.json();
                                    console.error('Update failed:', data);
                                    alert('Erreur: ' + (data.message || 'Inconnue'));
                                    this.loading = null;
                                }
                            } catch(e) { 
                                console.error('Connection error:', e);
                                alert('Erreur de connexion au serveur');
                                this.loading = null;
                            }
                        }
                    }">
                        @forelse($presentation->presentationItems as $item)
                        <div class="flex items-center justify-between p-6 rounded-3xl border transition-all {{ $item->status === 'validee' ? 'bg-green-50 border-green-200' : 'bg-slate-50 border-slate-100' }} group"
                             :class="{ 'opacity-50 pointer-events-none': loading === {{ $item->idItems }} }">
                            <div class="flex items-center gap-5">
                                <button @click="toggleItem({{ $item->idItems }}, '{{ $item->status }}')" 
                                    class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all shadow-sm {{ $item->status === 'validee' ? 'bg-green-500 text-white shadow-green-500/20' : 'bg-white text-slate-300 hover:text-[#b11d40]' }}">
                                    <template x-if="loading === {{ $item->idItems }}">
                                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </template>
                                    <template x-if="loading !== {{ $item->idItems }}">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </template>
                                </button>
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest mb-0.5 {{ $item->status === 'validee' ? 'text-green-600' : 'text-[#b11d40]' }}">Article</p>
                                    <p class="text-lg font-black text-slate-800 leading-tight">{{ $item->nom }}</p>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wide {{ $item->status === 'validee' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }}">{{ $item->category->nom ?? 'Divers' }}</span>
                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                        <span class="text-xs text-slate-400 font-bold uppercase tracking-tighter">Quantité: {{ $item->quantity }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-slate-700">{{ number_format($item->totale, 2) }} MAD</p>
                                <p class="text-[10px] text-slate-400 font-bold">{{ number_format($item->prixUnitaire, 2) }} / unité</p>
                            </div>
                        </div>
                        @empty
                        <div class="py-12 text-center">
                            <p class="text-slate-400 italic">Aucun élément dans cette présentation.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar / Interaction --}}
        <div class="space-y-8">
            {{-- Suggest Modifications --}}
            <div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden p-8">
                <h3 class="text-lg font-black text-slate-800 mb-2">Suggestions</h3>
                <p class="text-xs text-slate-500 mb-6 leading-relaxed">Souhaitez-vous apporter des modifications à cette proposition ? Envoyez vos suggestions à notre équipe.</p>

                @if(session('msg'))
                <div class="mb-6 p-4 bg-green-50 border border-green-100 rounded-2xl">
                    <p class="text-xs font-bold text-green-600 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('msg') }}
                    </p>
                </div>
                @endif

                <form action="{{ route('clients.presentations.suggest', $presentation->idPresentation) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <textarea name="reponse" rows="6" 
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm text-slate-700 outline-none focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5 transition-all font-medium placeholder:text-slate-300"
                            placeholder="Ex: J'aimerais modifier l'hôtel pour le deuxième jour, ou ajuster le nombre de participants...">{{ old('reponse', $presentation->reponse) }}</textarea>
                        @error('reponse')
                            <p class="text-[10px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full py-4 bg-[#b11d40] text-white rounded-2xl font-black text-sm shadow-lg shadow-[#b11d40]/20 hover:scale-[1.02] active:scale-95 transition-all">
                        Envoyer mes suggestions
                    </button>
                </form>

                <div class="mt-6 pt-6 border-t border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full {{ $presentation->status === 'validee' ? 'bg-green-500' : ($presentation->status === 'refusee' ? 'bg-red-500' : 'bg-amber-500') }}"></div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Statut: {{ ucfirst($presentation->status) }}</p>
                    </div>
                </div>
            </div>

            {{-- Admin Comment (if any) --}}
            @if($presentation->comment)
            <div class="bg-[#b11d40]/5 border border-[#b11d40]/10 rounded-[2.5rem] p-8">
                <h3 class="text-sm font-black text-[#b11d40] uppercase tracking-widest mb-3">Note de l'administrateur</h3>
                <p class="text-xs text-slate-600 font-medium leading-relaxed italic">
                    "{{ $presentation->comment }}"
                </p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
