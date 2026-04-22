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
            <button @click="showModal = true" class="flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter une Tâche
            </button>
        </div>

        @if(session('msg'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 3000)"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-90"
                 class="mb-6 p-4 bg-emerald-100 border border-emerald-200 text-emerald-700 rounded-xl font-bold flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('msg') }}
            </div>
        @endif

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
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
            <div @click.away="showModal = false" class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h2 class="text-xl font-extrabold text-slate-800">Nouvelle Tâche</h2>
                    <button @click="showModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form action="{{ route('tasks.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    
                    @if ($errors->any())
                        <div class="p-4 bg-red-50 border border-red-100 text-red-600 rounded-xl text-xs font-bold">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Titre de la tâche</label>
                        <input type="text" name="titre" required value="{{ old('titre') }}" class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-[#b11d40] focus:border-[#b11d40] transition-all" placeholder="Ex: Rapport mensuel">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Priorité</label>
                            <select name="priorite" class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-[#b11d40] transition-all">
                                <option value="basse" {{ old('priorite') == 'basse' ? 'selected' : '' }}>Basse</option>
                                <option value="moyenne" {{ old('priorite') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                                <option value="haute" {{ old('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Status Initial</label>
                            <select name="status" class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-[#b11d40] transition-all">
                                <option value="todo" {{ old('status') == 'todo' ? 'selected' : '' }}>À Faire</option>
                                <option value="en_cours" {{ old('status') == 'en_cours' ? 'selected' : '' }}>En Cours</option>
                                <option value="termine" {{ old('status') == 'termine' ? 'selected' : '' }}>Terminé</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Département Responsable</label>
                            <select name="idDepartement" required class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-[#b11d40] transition-all">
                                <option value="">Choisir un département</option>
                                @foreach($departements as $dept)
                                    <option value="{{ $dept->idDepartement }}" {{ old('idDepartement') == $dept->idDepartement ? 'selected' : '' }}>{{ $dept->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Assigner à (Optionnel)</label>
                            <select name="idUser" class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-[#b11d40] transition-all">
                                <option value="">Non assigné</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->idUser }}" {{ old('idUser') == $user->idUser ? 'selected' : '' }}>{{ $user->firstName }} {{ $user->lastName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Date début</label>
                            <input type="date" name="dateDebut" value="{{ old('dateDebut') }}" class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-[#b11d40] transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Échéance (Duree)</label>
                            <input type="date" name="duree" value="{{ old('duree') }}" class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-[#b11d40] transition-all">
                            <input type="hidden" name="typeDuree" value="jours">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Objectif lié</label>
                        <select name="idObjectif" class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-[#b11d40] transition-all">
                            <option value="">Aucun objectif</option>
                            @foreach($objectifs as $objectif)
                                <option value="{{ $objectif->idObjectif }}" {{ old('idObjectif') == $objectif->idObjectif ? 'selected' : '' }}>{{ $objectif->titre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Description</label>
                        <textarea name="description" rows="3" class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-[#b11d40] transition-all" placeholder="Détails de la tâche...">{{ old('description') }}</textarea>
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" @click="showModal = false" class="flex-1 px-6 py-3 rounded-xl font-bold text-slate-500 hover:bg-slate-100 transition-all">Annuler</button>
                        <button type="submit" class="flex-1 px-6 py-3 rounded-xl font-bold bg-[#b11d40] text-white hover:bg-[#911633] shadow-lg shadow-[#b11d40]/20 transition-all">Créer la Tâche</button>
                    </div>
                </form>

            </div>
        </div>

        {{-- ═══════════ EDIT TASK MODAL ═══════════ --}}
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all" x-show="showEditModal" x-cloak x-transition>
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden border border-slate-100" @click.away="showEditModal = false">
                
                <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <h2 class="text-xl font-black text-slate-800 tracking-tight">Modifier la Tâche</h2>
                    <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <form :action="'/tasks/' + currentTask.idTache" method="POST" class="p-8 space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Titre de la tâche</label>
                        <input type="text" name="titre" required x-model="currentTask.titre" class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-[#b11d40] transition-all">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Priorité</label>
                            <select name="priorite" x-model="currentTask.priorite" class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-[#b11d40] transition-all">
                                <option value="basse">Basse</option>
                                <option value="moyenne">Moyenne</option>
                                <option value="haute">Haute</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Status</label>
                            <select name="status" x-model="currentTask.status" class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-[#b11d40] transition-all">
                                <option value="todo">À Faire</option>
                                <option value="en_cours">En Cours</option>
                                <option value="termine">Terminé</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Département</label>
                            <select name="idDepartement" x-model="currentTask.idDepartement" class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-[#b11d40] transition-all">
                                <option value="">Choisir un département</option>
                                @foreach($departements as $dept)
                                    <option value="{{ $dept->idDepartement }}">{{ $dept->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Objectif lié</label>
                            <select name="idObjectif" x-model="currentTask.idObjectif" class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-[#b11d40] transition-all">
                                <option value="">Aucun objectif</option>
                                @foreach($objectifs as $objectif)
                                    <option value="{{ $objectif->idObjectif }}">{{ $objectif->titre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Date début</label>
                            <input type="date" name="dateDebut" x-model="currentTask.dateDebut" class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-[#b11d40] transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Échéance (Duree)</label>
                            <input type="date" name="duree" x-model="currentTask.duree" class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-[#b11d40] transition-all">
                            <input type="hidden" name="typeDuree" value="jours">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Description</label>
                        <textarea name="description" rows="3" x-model="currentTask.description" class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-[#b11d40] transition-all"></textarea>
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" @click="showEditModal = false" class="flex-1 px-6 py-3 rounded-xl font-bold text-slate-500 hover:bg-slate-100 transition-all">Annuler</button>
                        <button type="submit" class="flex-1 px-6 py-3 rounded-xl font-bold bg-[#b11d40] text-white hover:bg-[#911633] shadow-lg shadow-[#b11d40]/20 transition-all">Mettre à jour</button>
                    </div>
                </form>

            </div>
        </div>


    </div>
</x-app-layout>
