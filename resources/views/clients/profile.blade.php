@extends('layouts.client')

@section('title', 'Mon Profil — Access Morocco')
@section('page-title', 'Mon Profil')
@section('page-subtitle', 'Gérez vos informations et vos préférences')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    
    {{-- ═══════════════ PROFILE HEADER ═══════════════ --}}
    <div class="relative bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden group">
        {{-- Banner Background --}}
        <div class="h-48 w-full bg-gradient-to-br from-[#7c1233] via-[#be2346] to-[#d43f61] relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
                </svg>
            </div>
            {{-- Decorative circles --}}
            <div class="absolute top-[-10%] right-[-5%] w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-[-20%] left-[-10%] w-48 h-48 bg-black/10 rounded-full blur-2xl"></div>
        </div>

        <div class="px-8 pb-8 pt-0 relative flex flex-col md:flex-row items-end gap-6 -mt-16 md:-mt-12">
            {{-- Avatar --}}
            <div class="relative group/avatar">
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-3xl bg-white p-1.5 shadow-2xl relative z-10 transition-transform duration-500 group-hover/avatar:scale-[1.02]">
                    <div class="w-full h-full rounded-[1.25rem] bg-gradient-to-tr from-slate-50 to-slate-200 flex items-center justify-center text-4xl md:text-5xl font-black text-[#be2346] shadow-inner">
                        {{ strtoupper(mb_substr($client->firstName ?? 'C', 0, 1) . mb_substr($client->lastName ?? '', 0, 1)) }}
                    </div>
                </div>
                <div class="absolute -bottom-2 -right-2 bg-emerald-500 w-8 h-8 rounded-xl border-4 border-white shadow-lg z-20" title="Compte Actif"></div>
            </div>

            <div class="flex-1 text-center md:text-left mb-2">
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">{{ $client->firstName }} {{ $client->lastName }}</h1>
                <p class="text-slate-400 font-bold uppercase tracking-widest text-[10px] mt-1 flex items-center justify-center md:justify-start gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Client Premium · Access Morocco
                </p>
            </div>

            <div class="flex items-center gap-3 mb-2 shrink-0">
                <div class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-center">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Dossiers</p>
                    <p class="text-lg font-black text-[#be2346] leading-none mt-0.5">{{ $client->dossiers->count() }}</p>
                </div>
                <div class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-center">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Statut</p>
                    <p class="text-lg font-black text-emerald-600 leading-none mt-0.5">Actif</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- ═══════════════ SIDE INFO (Détails) ═══════════════ --}}
        <div class="space-y-8">
            <div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm p-8 flex flex-col gap-6">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest border-b border-slate-100 pb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Contact Rapide
                </h3>
                
                <div class="space-y-4">
                    <div class="group">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1.5 ml-1 transition-colors group-hover:text-[#be2346]">Email</label>
                        <div class="flex items-center gap-3 p-4 bg-slate-50 border border-slate-200 rounded-2xl transition-all group-hover:border-[#be2346]/20 group-hover:bg-[#be2346]/5">
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-width="2"/></svg>
                            <span class="text-sm font-bold text-slate-600 truncate">{{ $client->email }}</span>
                        </div>
                    </div>

                    <div class="group">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1.5 ml-1 transition-colors group-hover:text-[#be2346]">Téléphone</label>
                        <div class="flex items-center gap-3 p-4 bg-slate-50 border border-slate-200 rounded-2xl transition-all group-hover:border-[#be2346]/20 group-hover:bg-[#be2346]/5">
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-width="2"/></svg>
                            <span class="text-sm font-bold text-slate-600">{{ $client->phoneNumber ?? 'Non renseigné' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-[#0F1115] border border-white/5 rounded-[2.5rem] shadow-xl p-8 text-white">
                <p class="text-[10px] font-black uppercase text-[#be2346] tracking-[0.2em] mb-4">Support & Aide</p>
                <h4 class="text-base font-bold mb-2">Besoin d'assistance ?</h4>
                <p class="text-white/50 text-xs leading-relaxed mb-6">Notre équipe est disponible pour répondre à vos questions concernant vos dossiers.</p>
                <a href="mailto:support@accessmorocco.com" class="flex items-center justify-center gap-3 w-full py-3.5 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all text-xs font-black uppercase tracking-widest">
                    Contacter le support
                </a>
            </div>
        </div>

        {{-- ═══════════════ MAIN FORM (Informations) ═══════════════ --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Modifier mes informations</h3>
                    <span class="bg-slate-50 text-[10px] font-bold text-slate-400 px-3 py-1 rounded-full border border-slate-100">Informations de base</span>
                </div>

                <div class="p-8">
                    <form action="#" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Prénom</label>
                                <input type="text" value="{{ $client->firstName }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-700 outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Nom</label>
                                <input type="text" value="{{ $client->lastName }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-700 outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Email Principal</label>
                            <input type="email" value="{{ $client->email }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-700 outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full md:w-auto px-10 py-4 bg-[#be2346] hover:bg-[#a01d3a] text-white font-black text-sm rounded-2xl shadow-lg shadow-[#be2346]/20 transition-all active:scale-95 uppercase tracking-widest">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-red-50/10">
                    <h3 class="text-sm font-black text-red-800 uppercase tracking-widest flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m0 0v2m0-2h2m-2 0H10m4-11a4 4 0 11-8 0 4 4 0 018 0zM12 11h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Sécurité du compte
                    </h3>
                </div>

                <div class="p-8">
                    <form action="#" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Nouveau Mot de Passe</label>
                                <input type="password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm outline-none transition-all focus:border-red-500/50 focus:ring-4 focus:ring-red-500/5">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Confirmer le Mot de Passe</label>
                                <input type="password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm outline-none transition-all focus:border-red-500/50 focus:ring-4 focus:ring-red-500/5">
                            </div>
                        </div>

                        <div class="pt-4 flex items-center justify-between gap-4">
                            <button type="submit" class="w-full md:w-auto px-8 py-3.5 border-2 border-red-500 text-red-500 font-black text-xs rounded-xl hover:bg-red-500 hover:text-white transition-all active:scale-95 uppercase tracking-widest">
                                Mettre à jour le mot de passe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

