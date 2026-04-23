<x-app-layout>
    <div class="px-8 py-8 min-h-screen bg-[#F8FAFC]">
        
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ url('/reunions') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Retour aux réunions
            </a>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Planifier une Réunion</h1>
            <p class="text-sm font-medium text-slate-500 mt-1">Remplissez les informations pour organiser un nouveau rendez-vous.</p>
        </div>

        {{-- Form Card --}}
        <div class="max-w-3xl bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-indigo-500 to-purple-600"></div>
            
            <form action="{{ url('/reunions') }}" method="POST" class="p-8">
                @csrf
                
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-xs text-red-600 font-semibold space-y-1">
                        <p>Veuillez corriger les erreurs ci-dessous :</p>
                        <ul class="list-disc pl-4 opacity-80">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                    
                    {{-- Basic Info --}}
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Titre de la réunion *</label>
                        <input type="text" name="titre" value="{{ old('titre') }}" required class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all" placeholder="Ex: Revue de projet hebdomadaire">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Type de réunion *</label>
                        <select name="type" required class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all">
                            <option value="Interne" {{ old('type') == 'Interne' ? 'selected' : '' }}>Interne</option>
                            <option value="Externe" {{ old('type') == 'Externe' ? 'selected' : '' }}>Externe</option>
                            <option value="Autre" {{ old('type') == 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Département</label>
                        <select name="idDepartement" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all">
                            <option value="">-- Aucun --</option>
                            @foreach($departements as $dept)
                                <option value="{{ $dept->idDepartement }}" {{ old('idDepartement') == $dept->idDepartement ? 'selected' : '' }}>
                                    {{ $dept->title ?? $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Schedule --}}
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Date et Heure de début *</label>
                        <input type="datetime-local" name="dateHeure" value="{{ old('dateHeure') }}" required class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Heure de fin (Optionnel)</label>
                        <input type="time" name="heureFin" value="{{ old('heureFin') }}" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all">
                    </div>

                    {{-- Location / Link --}}
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Lieu / Salle</label>
                        <input type="text" name="lieu" value="{{ old('lieu') }}" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all" placeholder="Ex: Salle de conférence A">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Lien de la visioconférence</label>
                        <input type="url" name="lien" value="{{ old('lien') }}" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all" placeholder="Ex: https://meet.google.com/xxx">
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Objectif *</label>
                        <input type="text" name="objectif" value="{{ old('objectif') }}" required class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all" placeholder="Quel est le but principal de cette réunion ?">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Description détaillée</label>
                        <textarea name="description" rows="4" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all" placeholder="Points à aborder, participants, préparation nécessaire...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ url('/reunions') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-100 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-extrabold shadow-md shadow-indigo-600/20 transition-all focus:ring-4 focus:ring-indigo-600/20">
                        Planifier la réunion
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
