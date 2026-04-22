<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900" 
         x-data="{ 
            showModal: {{ $errors->any() ? 'true' : 'false' }}, 
            showEditModal: false,
            currentTask: { titre: '', idTache: '', description: '', priorite: 'moyenne', status: 'todo', dateDebut: '', duree: '', idDepartement: '', idObjectif: '' },
            openEditModal(task) {
                this.currentTask = task;
                this.showEditModal = true;
            },
            confirmDelete(id) {
                window.confirmDelete('/tasks/' + id, 'tâche');
            }
         }">

        {{-- ═══════════ TOP BAR ═══════════ --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Gestion des Tâches</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Suivez l'avancement des projets et des assignations.</p>
            </div>
            <button @click="showModal = true" class="flex items-center gap-2 bg-[#be2346] hover:bg-[#a01d3a] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#be2346]/20 text-sm whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter une Tâche
            </button>
        </div>

        <x-status-messages />

        {{-- ═══════════ KANBAN BOARD ═══════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- À FAIRE --}}
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between px-2">
                    <h2 class="text-sm font-black uppercase tracking-widest text-slate-400 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                        À FAIRE
                    </h2>
                    <span class="bg-slate-100 text-slate-500 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $Taches->where('status', 'todo')->count() }}</span>
                </div>
                <div class="flex flex-col gap-4 min-h-[500px]">
                    @foreach($Taches->where('status', 'todo') as $tache)
                        @include('taches.card', ['tache' => $tache])
                    @endforeach
                </div>
            </div>

            {{-- EN COURS --}}
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between px-2">
                    <h2 class="text-sm font-black uppercase tracking-widest text-blue-400 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                        EN COURS
                    </h2>
                    <span class="bg-blue-50 text-blue-500 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $Taches->where('status', 'en_cours')->count() }}</span>
                </div>
                <div class="flex flex-col gap-4 min-h-[500px]">
                    @foreach($Taches->where('status', 'en_cours') as $tache)
                        @include('taches.card', ['tache' => $tache])
                    @endforeach
                </div>
            </div>

            {{-- TERMINÉ --}}
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between px-2">
                    <h2 class="text-sm font-black uppercase tracking-widest text-emerald-400 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        TERMINÉ
                    </h2>
                    <span class="bg-emerald-50 text-emerald-500 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $Taches->where('status', 'termine')->count() }}</span>
                </div>
                <div class="flex flex-col gap-4 min-h-[500px]">
                    @foreach($Taches->where('status', 'termine') as $tache)
                        @include('taches.card', ['tache' => $tache])
                    @endforeach
                </div>
            </div>

        </div>

        {{-- ═══════════ MODAL AJOUTER ═══════════ --}}
        <div x-show="showModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all" x-cloak x-transition>
            <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-2xl overflow-hidden border border-slate-100 flex flex-col max-h-[92vh] z-10" @click.away="showModal = false" style="animation: modalIn .2s ease-out">
                
                {{-- Header --}}
                <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                    <div>
                        <h2 class="text-lg font-black text-slate-800">Nouvelle Tâche</h2>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Planification · Access Morocco</p>
                    </div>
                    <button @click="showModal = false"
                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] hover:border-[#be2346]/30 transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Form Content --}}
                <div class="overflow-y-auto">
                    <form action="{{ route('tasks.store') }}" method="POST" class="p-7 space-y-5">
                        @csrf
                        
                        @if ($errors->any())
                            <div class="p-4 bg-red-50 border border-red-100 text-red-600 rounded-2xl text-[11px] font-bold">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Titre de la tâche <span class="text-[#be2346]">*</span></label>
                            <input type="text" name="titre" required value="{{ old('titre') }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5" placeholder="Ex: Rapport mensuel">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Priorité</label>
                                <select name="priorite" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="basse" {{ old('priorite') == 'basse' ? 'selected' : '' }}>Basse</option>
                                    <option value="moyenne" {{ old('priorite') == 'moyenne' || !old('priorite') ? 'selected' : '' }}>Moyenne</option>
                                    <option value="haute" {{ old('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
                                </select>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Status Initial</label>
                                <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="todo" {{ old('status') == 'todo' ? 'selected' : '' }}>À Faire</option>
                                    <option value="en_cours" {{ old('status') == 'en_cours' ? 'selected' : '' }}>En Cours</option>
                                    <option value="termine" {{ old('status') == 'termine' ? 'selected' : '' }}>Terminé</option>
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Département Responsable <span class="text-[#be2346]">*</span></label>
                                <select name="idDepartement" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="">Choisir un département</option>
                                    @foreach($departements as $dept)
                                        <option value="{{ $dept->idDepartement }}" {{ old('idDepartement') == $dept->idDepartement ? 'selected' : '' }}>{{ $dept->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Assigner à (Optionnel)</label>
                                <select name="idUser" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="">Non assigné</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->idUser }}" {{ old('idUser') == $user->idUser ? 'selected' : '' }}>{{ $user->firstName }} {{ $user->lastName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Date début</label>
                                <input type="date" name="dateDebut" value="{{ old('dateDebut') }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Échéance</label>
                                <input type="date" name="duree" value="{{ old('duree') }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                <input type="hidden" name="typeDuree" value="jours">
                            </div>
                            
                            <div class="md:col-span-2 space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Objectif lié</label>
                                <select name="idObjectif" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="">Aucun objectif</option>
                                    @foreach($objectifs as $objectif)
                                        <option value="{{ $objectif->idObjectif }}" {{ old('idObjectif') == $objectif->idObjectif ? 'selected' : '' }}>{{ $objectif->titre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Description</label>
                            <textarea name="description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5" placeholder="Détails de la tâche...">{{ old('description') }}</textarea>
                        </div>

                        {{-- Footer Buttons --}}
                        <div class="flex gap-3 pt-4">
                            <button type="button" @click="showModal = false"
                                class="flex-1 py-4 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm">
                                Annuler
                            </button>
                            <button type="submit"
                                class="flex-1 py-4 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-[#be2346]/20 text-sm">
                                Sauvegarder
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ═══════════ EDIT TASK MODAL ═══════════ --}}
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all" x-show="showEditModal" x-cloak x-transition>
            <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-2xl overflow-hidden border border-slate-100 flex flex-col max-h-[92vh]" @click.away="showEditModal = false" style="animation: modalIn .2s ease-out">
                
                {{-- Header --}}
                <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                    <div>
                        <h2 class="text-lg font-black text-slate-800">Modifier la Tâche</h2>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Édition · Access Morocco</p>
                    </div>
                    <button @click="showEditModal = false"
                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Form Content --}}
                <div class="overflow-y-auto">
                    <form :action="'/tasks/' + currentTask.idTache" method="POST" class="p-7 space-y-5">
                        @csrf
                        @method('PUT')

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Titre de la tâche</label>
                            <input type="text" name="titre" required x-model="currentTask.titre" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Priorité</label>
                                <select name="priorite" x-model="currentTask.priorite" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="basse">Basse</option>
                                    <option value="moyenne">Moyenne</option>
                                    <option value="haute">Haute</option>
                                </select>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Status</label>
                                <select name="status" x-model="currentTask.status" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="todo">À Faire</option>
                                    <option value="en_cours">En Cours</option>
                                    <option value="termine">Terminé</option>
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Département</label>
                                <select name="idDepartement" x-model="currentTask.idDepartement" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="">Choisir un département</option>
                                    @foreach($departements as $dept)
                                        <option value="{{ $dept->idDepartement }}">{{ $dept->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Objectif lié</label>
                                <select name="idObjectif" x-model="currentTask.idObjectif" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="">Aucun objectif</option>
                                    @foreach($objectifs as $objectif)
                                        <option value="{{ $objectif->idObjectif }}">{{ $objectif->titre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date début</label>
                                <input type="date" name="dateDebut" x-model="currentTask.dateDebut" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Échéance</label>
                                <input type="date" name="duree" x-model="currentTask.duree" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Description</label>
                            <textarea name="description" rows="3" x-model="currentTask.description" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5"></textarea>
                        </div>

                        {{-- Footer Buttons --}}
                        <div class="flex gap-3 pt-4">
                            <button type="button" @click="showEditModal = false"
                                class="flex-1 py-3.5 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm">
                                Annuler
                            </button>
                            <button type="submit"
                                class="flex-1 py-3.5 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-[#be2346]/20 text-sm">
                                Sauvegarder
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
