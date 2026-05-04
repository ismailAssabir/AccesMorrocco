@extends('layouts.client')

@section('title', 'Journal de Voyage — Access Morocco')
@section('page-title', 'Journal de Voyage')
@section('page-subtitle', 'Gardez une trace de vos plus beaux moments au Maroc')

@section('content')
<div class="space-y-8 animate-fadeIn" x-data="{ 
    openAddModal: false, 
    openViewModal: false,
    openEditModal: false,
    selectedSouvenir: null,
    selectedEditSouvenir: null,
    openSouvenir(souvenir) {
        this.selectedSouvenir = souvenir;
        this.openViewModal = true;
    },
    openEditSouvenir(souvenir) {
        this.selectedEditSouvenir = souvenir;
        this.openEditModal = true;
        this.openViewModal = false;
    }
}">
    {{-- Header with Action --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Vos Souvenirs</h2>
            <p class="text-sm text-slate-500 font-medium">Capturez et partagez vos expériences uniques.</p>
        </div>
        <button @click="openAddModal = true" class="flex items-center justify-center gap-2 px-6 py-3.5 bg-[#be2346] text-white rounded-2xl font-black text-sm shadow-xl shadow-[#be2346]/20 hover:scale-[1.02] active:scale-95 transition-all group">
            <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Ajouter un moment
        </button>
    </div>

    {{-- Stats / Mood Summary --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Moments</p>
            <p class="text-2xl font-black text-slate-800">{{ $souvenirs->total() }}</p>
        </div>
        <div class="bg-[#be2346]/5 p-6 rounded-[2rem] border border-[#be2346]/10 shadow-sm">
            <p class="text-[10px] font-black text-[#be2346] uppercase tracking-widest mb-1">Dernier Moment</p>
            <p class="text-xs font-bold text-slate-700 truncate">{{ $souvenirs->first()->titre ?? 'Aucun' }}</p>
        </div>
    </div>

    {{-- Memory Wall (Gallery) --}}
    @if($souvenirs->isEmpty())
    <div class="bg-white rounded-[3rem] border border-dashed border-slate-200 p-16 text-center">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <h3 class="text-xl font-black text-slate-800 mb-2">Votre mur est vide</h3>
        <p class="text-slate-400 text-sm max-w-xs mx-auto mb-8 font-medium">Commencez à ajouter des photos et des histoires de votre voyage pour créer votre journal personnalisé.</p>
        <button @click="openAddModal = true" class="text-[#be2346] font-black text-sm uppercase tracking-widest hover:underline">Créer mon premier souvenir</button>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($souvenirs as $souvenir)
        <div class="group bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-slate-200 transition-all duration-500 overflow-hidden flex flex-col h-full cursor-pointer"
             @click="openSouvenir({{ json_encode($souvenir->toArray() + ['dossier_destination' => $souvenir->dossier->distination ?? null]) }})">
            {{-- Image Header --}}
            <div class="relative aspect-[4/5] overflow-hidden bg-slate-100">
                @if($souvenir->image)
                    <img src="{{ asset('storage/' . $souvenir->image) }}" alt="{{ $souvenir->titre }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="1.5"/></svg>
                    </div>
                @endif
                
                {{-- Mood Tag --}}
                @if($souvenir->mood)
                <div class="absolute top-4 left-4 px-3 py-1.5 bg-white/90 backdrop-blur-md rounded-full text-[9px] shadow-sm font-black uppercase tracking-widest text-[#be2346] border border-[#be2346]/10">
                    {{ $souvenir->mood }}
                </div>
                @endif

                {{-- Action Menu --}}
                <div class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-all translate-y-2 group-hover:translate-y-0" @click.stop>
                    <button type="button" 
                            @click="openEditSouvenir({{ json_encode($souvenir->toArray() + ['dossier_destination' => $souvenir->dossier->distination ?? null]) }})"
                            class="w-8 h-8 bg-white/90 backdrop-blur-md text-slate-600 rounded-xl flex items-center justify-center hover:bg-[#be2346] hover:text-white transition-all shadow-lg">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" /></svg>
                    </button>
                    <button type="button" 
                            onclick="openGlobalDeleteModal('{{ route('clients.souvenirs.destroy', $souvenir->idSouvenir) }}', 'Supprimer ce souvenir ?', 'Êtes-vous sûr de vouloir retirer ce moment de votre journal ? Cette action est irréversible.')"
                            class="w-8 h-8 bg-red-500 text-white rounded-xl flex items-center justify-center hover:bg-red-600 transition-colors shadow-lg">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" /></svg>
                    </button>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-6 flex flex-col flex-1">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        {{ $souvenir->date ? \Carbon\Carbon::parse($souvenir->date)->format('d M Y') : $souvenir->created_at->format('d M Y') }}
                    </span>
                    @if($souvenir->location)
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <span class="text-[10px] font-black text-[#be2346] uppercase tracking-widest truncate max-w-[100px]">
                        {{ $souvenir->location }}
                    </span>
                    @endif
                </div>
                <h4 class="text-lg font-black text-slate-800 leading-tight mb-2 group-hover:text-[#be2346] transition-colors">{{ $souvenir->titre }}</h4>
                <p class="text-xs text-slate-500 leading-relaxed font-medium line-clamp-2 mb-6">{{ $souvenir->description }}</p>
                
                @if($souvenir->dossier)
                <div class="mt-auto pt-4 border-t border-slate-50">
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded bg-slate-100 flex items-center justify-center">
                            <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" stroke-width="2" /></svg>
                        </div>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Voyage à {{ $souvenir->dossier->distination }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-8">
        {{ $souvenirs->links() }}
    </div>
    @endif

    {{-- VIEW MODAL --}}
    <div x-show="openViewModal" 
         x-cloak
         class="fixed inset-0 z-[110] flex items-center justify-center p-4 sm:p-8"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        
        <div class="absolute inset-0 bg-slate-900/90 backdrop-blur-xl" @click="openViewModal = false"></div>

        <div class="relative w-full max-w-5xl bg-white rounded-[3rem] shadow-2xl overflow-hidden flex flex-col md:flex-row h-full max-h-[85vh]"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            
            {{-- Image View --}}
            <div class="flex-1 bg-black relative flex items-center justify-center group overflow-hidden">
                <template x-if="selectedSouvenir && selectedSouvenir.image">
                    <img :src="'/storage/' + selectedSouvenir.image" class="max-w-full max-h-full object-contain">
                </template>
                <template x-if="selectedSouvenir && !selectedSouvenir.image">
                    <div class="text-slate-600 flex flex-col items-center gap-4">
                        <svg class="w-20 h-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="1.5"/></svg>
                        <p class="font-black uppercase tracking-widest text-xs">Aucune photo</p>
                    </div>
                </template>

                {{-- Download Button Over Image --}}
                <template x-if="selectedSouvenir && selectedSouvenir.image">
                    <a :href="'/storage/' + selectedSouvenir.image" download 
                       class="absolute bottom-8 right-8 flex items-center gap-3 px-6 py-3 bg-white/20 backdrop-blur-md text-white rounded-2xl font-black text-xs hover:bg-white hover:text-[#be2346] transition-all shadow-xl">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-width="2.5"/></svg>
                        Télécharger la photo
                    </a>
                </template>
            </div>

            {{-- Info Panel --}}
            <div class="w-full md:w-[400px] bg-white flex flex-col p-10 overflow-y-auto custom-scrollbar">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex gap-2">
                        <div class="px-4 py-1.5 bg-[#be2346]/5 rounded-full border border-[#be2346]/10">
                            <span class="text-[10px] font-black text-[#be2346] uppercase tracking-widest" x-text="selectedSouvenir?.mood || 'Souvenir'"></span>
                        </div>
                        <button @click="openEditSouvenir(selectedSouvenir)" class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-[#be2346] transition-all border border-slate-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2"/></svg>
                        </button>
                    </div>
                    <button @click="openViewModal = false" class="w-10 h-10 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-red-500 transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M6 18L18 6M6 6l12 12" stroke-width="2.5"/></svg>
                    </button>
                </div>

                <div class="space-y-6">
                    <div>
                        <h3 class="text-3xl font-black text-slate-800 leading-tight mb-2" x-text="selectedSouvenir?.titre"></h3>
                        <div class="flex items-center gap-4 text-slate-400">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                                <span class="text-[10px] font-bold uppercase" x-text="selectedSouvenir?.date || selectedSouvenir?.created_at?.split('T')[0]"></span>
                            </div>
                            <template x-if="selectedSouvenir?.location">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2"/></svg>
                                    <span class="text-[10px] font-bold uppercase text-[#be2346]" x-text="selectedSouvenir?.location"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="w-12 h-1 bg-[#be2346]/20 rounded-full"></div>

                    <div class="space-y-4">
                        <p class="text-sm font-black text-slate-400 uppercase tracking-widest">L'histoire</p>
                        <p class="text-sm text-slate-600 leading-relaxed font-medium" x-text="selectedSouvenir?.description || 'Aucune description fournie.'"></p>
                    </div>

                    <template x-if="selectedSouvenir?.dossier_destination">
                        <div class="pt-8 mt-8 border-t border-slate-50">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Voyage associé</p>
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" stroke-width="2"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-slate-800" x-text="'Voyage à ' + selectedSouvenir.dossier_destination"></p>
                                    <p class="text-[10px] text-slate-400 font-bold">Access Morocco Experience</p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div x-show="openEditModal" 
         x-cloak
         class="fixed inset-0 z-[110] flex items-center justify-center p-4 sm:p-6"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md" @click="openEditModal = false"></div>

        <div class="relative w-full max-w-2xl bg-white rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100">
            
            <div class="relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#be2346] via-blue-600 to-[#be2346]"></div>
                <div class="px-8 pt-10 pb-6 flex items-center justify-between border-b border-slate-50 bg-white">
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 leading-tight">Modifier le Souvenir</h3>
                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1">Mettez à jour votre moment spécial</p>
                    </div>
                    <button @click="openEditModal = false" class="w-10 h-10 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-red-500 transition-all border border-slate-100 shadow-sm">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M6 18L18 6M6 6l12 12" stroke-width="2.5"/></svg>
                    </button>
                </div>
            </div>

            <div class="flex-1 max-h-[75vh] overflow-y-auto custom-scrollbar bg-white">
                <form :action="'/clients/journal/' + selectedEditSouvenir?.idSouvenir" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2"/></svg>
                            </div>
                            <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest">L'essentiel</h4>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Titre</label>
                                <input type="text" name="titre" required x-model="selectedEditSouvenir.titre"
                                       class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-800 focus:border-[#be2346] transition-all outline-none">
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Voyage</label>
                                <select name="idDossier" x-model="selectedEditSouvenir.idDossier" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-800 outline-none appearance-none">
                                    <option value="">Voyage libre</option>
                                    @foreach($dossiers as $dossier)
                                        <option value="{{ $dossier->idDossier }}">Voyage à {{ $dossier->distination }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Date</label>
                                <input type="date" name="date" x-model="selectedEditSouvenir.date"
                                       class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-800 outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                            </div>
                            <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest">Ambiance</h4>
                        </div>
                        <input type="hidden" name="mood" x-model="selectedEditSouvenir.mood">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <template x-for="m in [
                                {id: 'Aventure', label: 'Aventure', icon: `<svg class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M13 21V11.5a3.5 3.5 0 00-7 0V21m12 0V11a5 5 0 00-10 0v10' /></svg>`},
                                {id: 'Détente', label: 'Détente', icon: `<svg class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z' /></svg>`},
                                {id: 'Culture', label: 'Culture', icon: `<svg class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4' /></svg>`},
                                {id: 'Gastronomie', label: 'Food', icon: `<svg class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253' /></svg>`},
                                {id: 'Nature', label: 'Nature', icon: `<svg class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z' /></svg>`},
                                {id: 'Shopping', label: 'Shopping', icon: `<svg class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M16 11V7a4 4 0 11-8 0v4M5 9h14l1 12H4L5 9z' /></svg>`},
                                {id: 'Rencontre', label: 'Rencontre', icon: `<svg class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z' /></svg>`},
                                {id: 'Magique', label: 'Magique', icon: `<svg class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z' /></svg>`}
                            ]">
                                <button type="button" @click="selectedEditSouvenir.mood = m.id" 
                                        :class="selectedEditSouvenir.mood === m.id ? 'border-[#be2346] bg-[#be2346]/5 text-[#be2346]' : 'border-slate-100 bg-slate-50/50 text-slate-400'"
                                        class="flex flex-col items-center gap-2 p-4 rounded-2xl border transition-all">
                                    <div x-html="m.icon"></div>
                                    <span class="text-[9px] font-black uppercase" x-text="m.label"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2"/></svg>
                            </div>
                            <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest">Détails</h4>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Lieu</label>
                            <input type="text" name="location" x-model="selectedEditSouvenir.location" 
                                   class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-800 focus:border-[#be2346] outline-none">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Histoire</label>
                            <textarea name="description" rows="4" x-model="selectedEditSouvenir.description"
                                      class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-700 focus:border-[#be2346] outline-none resize-none"></textarea>
                        </div>
                        <div x-data="{ hasFile: false, fileName: '' }">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Changer la photo (optionnel)</label>
                            <div class="relative">
                                <input type="file" name="image" id="souvenir_image_edit" class="hidden" accept="image/*"
                                       @change="hasFile = true; fileName = $event.target.files[0].name">
                                <label for="souvenir_image_edit" 
                                       :class="hasFile ? 'border-[#be2346] bg-[#be2346]/5' : 'border-slate-200 bg-slate-50 hover:border-[#be2346]/30'"
                                       class="flex flex-col items-center justify-center w-full py-10 border-2 border-dashed rounded-[2rem] cursor-pointer transition-all group">
                                    <div class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6 text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" /></svg>
                                    </div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest group-hover:text-[#be2346]" x-text="hasFile ? fileName : 'Cliquez pour remplacer la photo'"></p>
                                    <p class="text-[9px] text-slate-300 mt-1" x-show="!hasFile">Laissez vide pour conserver l'ancienne</p>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex gap-4">
                        <button type="submit" class="flex-1 py-5 bg-slate-900 text-white rounded-3xl font-black text-sm shadow-xl hover:scale-[1.02] transition-all">
                            Mettre à jour
                        </button>
                        <button type="button" @click="openEditModal = false" class="px-8 py-5 bg-slate-100 text-slate-500 rounded-3xl font-black text-sm">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ADD MODAL --}}
    <div x-show="openAddModal" 
         x-cloak
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md" @click="openAddModal = false"></div>

        {{-- Modal Content --}}
        <div class="relative w-full max-w-2xl bg-white rounded-[2.5rem] shadow-2xl shadow-slate-900/50 overflow-hidden flex flex-col"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100">
            
            {{-- Header with Brand Accent --}}
            <div class="relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#be2346] via-[#7c1233] to-[#be2346]"></div>
                <div class="px-8 pt-10 pb-6 flex items-center justify-between border-b border-slate-50 bg-white">
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 leading-tight">Nouveau Souvenir</h3>
                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1">Créez un moment inoubliable au Maroc</p>
                    </div>
                    <button @click="openAddModal = false" class="w-10 h-10 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-red-500 transition-all border border-slate-100 shadow-sm">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M6 18L18 6M6 6l12 12" stroke-width="2.5"/></svg>
                    </button>
                </div>
            </div>

            <div class="flex-1 max-h-[75vh] overflow-y-auto custom-scrollbar bg-white">
                <form action="{{ route('clients.souvenirs.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                    @csrf
                    
                    {{-- Section 1: L'essentiel --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2"/></svg>
                            </div>
                            <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest">L'essentiel</h4>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Titre de l'expérience</label>
                                <input type="text" name="titre" required placeholder="Ex: Une nuit magique sous les étoiles" 
                                       class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-800 focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 transition-all outline-none">
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Lié au Voyage</label>
                                <select name="idDossier" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-800 focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 transition-all outline-none appearance-none">
                                    <option value="">Voyage libre</option>
                                    @foreach($dossiers as $dossier)
                                        <option value="{{ $dossier->idDossier }}">
                                            Voyage à {{ $dossier->distination }} {{ $dossier->dateVoyage ? '(' . \Carbon\Carbon::parse($dossier->dateVoyage)->format('F Y') . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Date du moment</label>
                                <input type="date" name="date" value="{{ date('Y-m-d') }}"
                                       class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-800 focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 transition-all outline-none">
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: L'Ambiance (Mood) --}}
                    <div class="space-y-6" x-data="{ currentMood: 'Aventure' }">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                            </div>
                            <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest">L'Ambiance</h4>
                        </div>
                        
                        <input type="hidden" name="mood" x-model="currentMood">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <template x-for="m in [
                                {id: 'Aventure', label: 'Aventure', icon: `<svg class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M13 21V11.5a3.5 3.5 0 00-7 0V21m12 0V11a5 5 0 00-10 0v10' /></svg>`},
                                {id: 'Détente', label: 'Détente', icon: `<svg class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z' /></svg>`},
                                {id: 'Culture', label: 'Culture', icon: `<svg class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4' /></svg>`},
                                {id: 'Gastronomie', label: 'Food', icon: `<svg class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253' /></svg>`},
                                {id: 'Nature', label: 'Nature', icon: `<svg class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z' /></svg>`},
                                {id: 'Shopping', label: 'Shopping', icon: `<svg class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M16 11V7a4 4 0 11-8 0v4M5 9h14l1 12H4L5 9z' /></svg>`},
                                {id: 'Rencontre', label: 'Rencontre', icon: `<svg class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z' /></svg>`},
                                {id: 'Magique', label: 'Magique', icon: `<svg class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z' /></svg>`}
                            ]">
                                <button type="button" @click="currentMood = m.id" 
                                        :class="currentMood === m.id ? 'border-[#be2346] ring-4 ring-[#be2346]/5 bg-[#be2346]/5 text-[#be2346]' : 'border-slate-100 bg-slate-50/50 hover:border-[#be2346]/30 text-slate-400'"
                                        class="flex flex-col items-center gap-2 p-4 rounded-2xl border transition-all duration-300 group">
                                    <div class="group-hover:scale-110 transition-transform" x-html="m.icon"></div>
                                    <span class="text-[9px] font-black uppercase tracking-tighter" x-text="m.label"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    {{-- Section 3: Détails & Photo --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2"/></svg>
                            </div>
                            <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest">Détails & Photo</h4>
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Lieu précis</label>
                                <div class="relative">
                                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/></svg>
                                    <input type="text" name="location" placeholder="Ex: Jardin Majorelle, Marrakech" 
                                           class="w-full pl-12 pr-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-800 focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 transition-all outline-none">
                                </div>
                            </div>
                            
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Votre histoire</label>
                                <textarea name="description" rows="4" placeholder="Décrivez ce moment spécial..." 
                                          class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-700 focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 transition-all outline-none resize-none"></textarea>
                            </div>

                            <div x-data="{ hasFile: false, fileName: '' }">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Photo souvenir</label>
                                <div class="relative">
                                    <input type="file" name="image" id="souvenir_image_new" class="hidden" accept="image/*"
                                           @change="hasFile = true; fileName = $event.target.files[0].name">
                                    <label for="souvenir_image_new" 
                                           :class="hasFile ? 'border-[#be2346] bg-[#be2346]/5' : 'border-slate-200 bg-slate-50 hover:border-[#be2346]/30'"
                                           class="flex flex-col items-center justify-center w-full py-8 border-2 border-dashed rounded-3xl cursor-pointer transition-all group">
                                        <div class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6 text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" /></svg>
                                        </div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest group-hover:text-[#be2346]" x-text="hasFile ? fileName : 'Sélectionner une photo'"></p>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex flex-col sm:flex-row items-center gap-4">
                        <button type="submit" class="w-full sm:flex-1 py-5 bg-slate-900 text-white rounded-3xl font-black text-sm shadow-xl shadow-slate-900/20 hover:scale-[1.02] active:scale-95 transition-all">
                            Enregistrer le souvenir
                        </button>
                        <button type="button" @click="openAddModal = false" class="w-full sm:w-auto px-10 py-5 bg-slate-100 text-slate-500 rounded-3xl font-black text-sm hover:bg-slate-200 transition-all">
                            Fermer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if(session('msg'))
<div x-data="{ show: true }" 
     x-show="show" 
     x-init="setTimeout(() => show = false, 5000)"
     class="fixed bottom-8 right-8 z-[120] bg-slate-900 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 animate-slideInRight">
    <div class="w-8 h-8 bg-[#be2346] rounded-xl flex items-center justify-center">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M5 13l4 4L19 7" stroke-width="3"/></svg>
    </div>
    <p class="text-sm font-bold">{{ session('msg') }}</p>
    <button @click="show = false" class="ml-4 text-white/40 hover:text-white transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M6 18L18 6M6 6l12 12" stroke-width="2.5"/></svg>
    </button>
</div>
@endif

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
.animate-fadeIn { animation: fadeIn 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
.animate-slideInRight { animation: slideInRight 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
</style>
@endsection
