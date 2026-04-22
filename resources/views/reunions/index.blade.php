<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

        {{-- ═══════════ TOP BAR ═══════════ --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Planification des Réunions</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Gérez vos rendez-vous internes et externes.</p>
            </div>
            @if(auth()->user()->role !== 'employee')
            <button onclick="toggleModal('addReunionModal')" class="flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter
            </button>
            @endif
        </div>

        {{-- Alert Messages --}}
        <div class="mb-6">
            @if(session('msg'))
                <div id="success-alert" class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-2xl font-bold text-sm flex items-center gap-3 transition-all duration-500 ease-in-out shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    {{ session('msg') }}
                </div>
            @endif

            @if($errors->any())
                <div id="error-alert" class="p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl font-bold text-sm transition-all duration-500 ease-in-out shadow-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        {{-- ═══════════ MAIN CONTENT ═══════════ --}}
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden p-6">
            <h2 class="text-lg font-extrabold text-slate-800 mb-6">Prochaines Réunions</h2>
            <div class="space-y-4">
                @forelse($reunions as $reunion)
                <div class="flex flex-col md:flex-row md:items-center gap-4 bg-slate-50 border border-slate-100 p-5 rounded-2xl hover:shadow-md transition-shadow relative group">
                    
                    {{-- Avatar / Icon --}}
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex flex-col items-center justify-center text-indigo-600 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-bold text-slate-800 truncate">{{ $reunion->titre }}</h3>
                        <p class="text-sm text-slate-500 mt-1 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ \Carbon\Carbon::parse($reunion->dateHeure)->translatedFormat('d M Y, H:i') }}
                            @if($reunion->lieu)
                                <span class="text-slate-300 mx-1">|</span>
                                <span class="text-xs font-medium">{{ $reunion->lieu }}</span>
                            @endif
                        </p>
                    </div>

                    {{-- Meta & Actions --}}
                    <div class="flex items-center gap-4 sm:ml-auto">
                        @php
                            $typeColor = match($reunion->type) {
                                'Interne' => 'bg-slate-200 text-slate-700',
                                'Externe' => 'bg-blue-100 text-blue-700',
                                default => 'bg-[#b11d40]/10 text-[#b11d40]'
                            };
                        @endphp
                        <span class="{{ $typeColor }} font-bold px-3 py-1 rounded-lg text-xs uppercase tracking-wider">{{ $reunion->type }}</span>

                        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            @if(auth()->user()->role !== 'employee')
                            <button type="button" onclick='openEditModal(@json($reunion))' class="p-2 bg-white text-slate-400 hover:text-blue-600 rounded-lg border border-slate-200 shadow-sm transition-colors" title="Modifier">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button type="button" onclick="confirmDelete({{ $reunion->idReunion }})" class="p-2 bg-white text-slate-400 hover:text-red-600 rounded-lg border border-slate-200 shadow-sm transition-colors" title="Supprimer">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                            @endif
                            @if($reunion->lien)
                            <a href="{{ $reunion->lien }}" target="_blank" class="p-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-sm" title="Rejoindre">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="py-20 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-300">
                    <p class="text-slate-400 font-medium">Aucune réunion prévue.</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ═══════════ MODALS ═══════════ --}}

    {{-- Add Reunion Modal --}}
    <div id="addReunionModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('addReunionModal')"></div>
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-black text-slate-800">Planifier une Réunion</h2>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Nouvel événement · Access Morocco</p>
                    </div>
                    <button type="button" onclick="toggleModal('addReunionModal')" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#b11d40] transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form action="{{ url('/reunions') }}" method="POST" class="p-8 space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-black uppercase text-slate-400 ml-1 mb-1">Titre de la réunion *</label>
                            <input type="text" name="titre" required placeholder="Ex: Revue de projet hebdomadaire" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-indigo-500/50 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 ml-1 mb-1">Type *</label>
                            <select name="type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-indigo-500/50 outline-none transition-all">
                                <option value="Interne">Interne</option>
                                <option value="Externe">Externe</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 ml-1 mb-1">Département</label>
                            <select name="idDepartement" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-indigo-500/50 outline-none transition-all">
                                <option value="">-- Aucun --</option>
                                @foreach($departements as $dept)
                                    <option value="{{ $dept->idDepartement }}">{{ $dept->title ?? $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 ml-1 mb-1">Date et Heure *</label>
                            <input type="datetime-local" name="dateHeure" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-indigo-500/50 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 ml-1 mb-1">Heure de fin</label>
                            <input type="time" name="heureFin" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-indigo-500/50 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 ml-1 mb-1">Lieu / Salle</label>
                            <input type="text" name="lieu" placeholder="Ex: Salle A" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-indigo-500/50 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 ml-1 mb-1">Lien Visioconférence</label>
                            <input type="url" name="lien" placeholder="Ex: https://meet..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-indigo-500/50 outline-none transition-all">
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-black uppercase text-slate-400 ml-1 mb-1">Objectif *</label>
                            <input type="text" name="objectif" required placeholder="But principal..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-indigo-500/50 outline-none transition-all">
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-black uppercase text-slate-400 ml-1 mb-1">Description</label>
                            <textarea name="description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-indigo-500/50 outline-none transition-all"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="w-full py-4 mt-4 rounded-xl bg-[#b11d40] hover:bg-[#911633] text-white font-black shadow-lg shadow-[#b11d40]/20 transition-all active:scale-[0.98]">
                        Confirmer la planification
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Reunion Modal --}}
    <div id="editReunionModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('editReunionModal')"></div>
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-black text-slate-800">Modifier la Réunion</h2>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Édition · Access Morocco</p>
                    </div>
                    <button type="button" onclick="toggleModal('editReunionModal')" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#b11d40] transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form id="editReunionForm" method="POST" class="p-8 space-y-5">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-black uppercase text-slate-400 ml-1 mb-1">Titre de la réunion *</label>
                            <input type="text" name="titre" id="edit_titre" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-indigo-500/50 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 ml-1 mb-1">Type *</label>
                            <select name="type" id="edit_type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-indigo-500/50 outline-none transition-all">
                                <option value="Interne">Interne</option>
                                <option value="Externe">Externe</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 ml-1 mb-1">Département</label>
                            <select name="idDepartement" id="edit_idDepartement" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-indigo-500/50 outline-none transition-all">
                                <option value="">-- Aucun --</option>
                                @foreach($departements as $dept)
                                    <option value="{{ $dept->idDepartement }}">{{ $dept->title ?? $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 ml-1 mb-1">Date et Heure *</label>
                            <input type="datetime-local" name="dateHeure" id="edit_dateHeure" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-indigo-500/50 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 ml-1 mb-1">Heure de fin</label>
                            <input type="time" name="heureFin" id="edit_heureFin" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-indigo-500/50 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 ml-1 mb-1">Lieu / Salle</label>
                            <input type="text" name="lieu" id="edit_lieu" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-indigo-500/50 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 ml-1 mb-1">Lien Visioconférence</label>
                            <input type="url" name="lien" id="edit_lien" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-indigo-500/50 outline-none transition-all">
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-black uppercase text-slate-400 ml-1 mb-1">Objectif *</label>
                            <input type="text" name="objectif" id="edit_objectif" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-indigo-500/50 outline-none transition-all">
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-black uppercase text-slate-400 ml-1 mb-1">Description</label>
                            <textarea name="description" id="edit_description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-indigo-500/50 outline-none transition-all"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="w-full py-4 mt-4 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-black shadow-lg transition-all active:scale-[0.98]">
                        Enregistrer les modifications
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="deleteConfirmationModal" class="fixed inset-0 z-[110] hidden overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('deleteConfirmationModal')"></div>
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white w-full max-w-md rounded-[32px] shadow-2xl overflow-hidden p-8 text-center">
                <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6 text-red-600">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <h2 class="text-xl font-black text-slate-800 mb-2">Supprimer la réunion ?</h2>
                <p class="text-slate-500 text-sm mb-8 font-medium px-4">Cette action est irréversible. Voulez-vous vraiment supprimer cet événement ?</p>
                
                <div class="flex gap-3">
                    <button type="button" onclick="toggleModal('deleteConfirmationModal')" class="flex-1 py-3 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition-all">
                        Annuler
                    </button>
                    <form id="deleteForm" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-3 rounded-xl bg-red-600 text-white font-bold hover:bg-red-700 shadow-lg shadow-red-600/20 transition-all">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.toggle('hidden');
                document.body.style.overflow = modal.classList.contains('hidden') ? 'auto' : 'hidden';
            }
        }

        function openEditModal(reunion) {
            const form = document.getElementById('editReunionForm');
            form.action = `/reunions/edit/${reunion.idReunion}`;
            
            document.getElementById('edit_titre').value = reunion.titre || '';
            document.getElementById('edit_type').value = reunion.type || 'Interne';
            document.getElementById('edit_idDepartement').value = reunion.idDepartement || '';
            
            // Format date for datetime-local
            if (reunion.dateHeure) {
                const d = new Date(reunion.dateHeure);
                const offset = d.getTimezoneOffset() * 60000;
                const localISOTime = (new Date(d.getTime() - offset)).toISOString().slice(0, 16);
                document.getElementById('edit_dateHeure').value = localISOTime;
            }
            
            document.getElementById('edit_heureFin').value = reunion.heureFin || '';
            document.getElementById('edit_lieu').value = reunion.lieu || '';
            document.getElementById('edit_lien').value = reunion.lien || '';
            document.getElementById('edit_objectif').value = reunion.objectif || '';
            document.getElementById('edit_description').value = reunion.description || '';
            
            toggleModal('editReunionModal');
        }

        function confirmDelete(id) {
            const form = document.getElementById('deleteForm');
            form.action = `/reunions/delete/${id}`;
            toggleModal('deleteConfirmationModal');
        }

        document.addEventListener('DOMContentLoaded', function() {
            function fadeAndRemove(elementId) {
                const el = document.getElementById(elementId);
                if (el) {
                    setTimeout(() => {
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(-10px)';
                        setTimeout(() => el.remove(), 500);
                    }, 3000);
                }
            }
            fadeAndRemove('success-alert');
            fadeAndRemove('error-alert');
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('addReunionModal')?.classList.add('hidden');
                document.getElementById('editReunionModal')?.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
    </script>
</x-app-layout>

