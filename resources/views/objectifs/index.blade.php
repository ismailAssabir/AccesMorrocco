<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

        {{-- ═══════════ TOP BAR ═══════════ --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Objectifs de l'Entreprise</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Pilotez et suivez les KPI majeurs pour atteindre nos ambitions.</p>
            </div>
            @if(auth()->user()->role !== 'employee')
            <button onclick="toggleModal('addObjectifModal')" class="flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter
            </button>
            @endif
        </div>

        {{-- Alert Messages --}}
        <x-status-messages />

        {{-- ═══════════ MAIN CONTENT ═══════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse($objs as $obj)
            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-6 flex flex-col justify-between hover:shadow-xl transition-all duration-300 relative group">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-[#b11d40]/10 rounded-2xl flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-[#b11d40]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                    <div class="flex items-center gap-2">
                        @php
                            $statusColor = match($obj->status) {
                                'termine' => 'bg-emerald-100 text-emerald-700',
                                'en_cours' => 'bg-blue-100 text-blue-700',
                                'retard' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-700'
                            };
                            $statusLabel = match($obj->status) {
                                'termine' => 'Terminé',
                                'en_cours' => 'En cours',
                                'retard' => 'En retard',
                                default => $obj->status
                            };
                        @endphp
                        <span class="{{ $statusColor }} font-bold px-3 py-1 rounded-lg text-xs">{{ $statusLabel }}</span>
                    </div>
                </div>
                
                <h3 class="text-xl font-black text-slate-800 mb-2">{{ $obj->titre }}</h3>
                <p class="text-slate-500 text-sm mb-6 line-clamp-2">{{ $obj->description }}</p>

                <div>
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Complétion</span>
                        <span class="text-2xl font-extrabold text-slate-800">{{ $obj->avancement }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-700 bg-gradient-to-r from-[#b11d40] to-rose-400" style="width: {{ $obj->avancement }}%"></div>
                    </div>
                </div>

                {{-- Admin/Manager Actions --}}
                @if(auth()->user()->role !== 'employee')
                <div class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button type="button" onclick='openEditModal(@json($obj))' class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button type="button" onclick="confirmDeleteObjectif('{{ $obj->idObjectif }}')" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
                @endif
            </div>
            @empty
            <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-dashed border-slate-300">
                <p class="text-slate-400 font-medium">Aucun objectif trouvé.</p>
            </div>
            @endforelse
        </div>

    </div>
    </div>

    {{-- ═══════════ MODALS ═══════════ --}}

    {{-- Add Objectif Modal --}}
    <div id="addObjectifModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="toggleModal('addObjectifModal')"></div>
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden flex flex-col max-h-[92vh] z-10" style="animation: modalIn .2s ease-out">
                
                {{-- Header --}}
                <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                    <div>
                        <h2 class="text-lg font-black text-slate-800">Nouvel Objectif Stratégique</h2>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Planification · Access Morocco</p>
                    </div>
                    <button type="button" onclick="toggleModal('addObjectifModal')"
                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] hover:border-[#be2346]/30 transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Form Content --}}
                <div class="overflow-y-auto">
                    <form action="{{ url('/objectifs') }}" method="POST" class="p-7 space-y-5">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-2 space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Titre de l'objectif <span class="text-[#be2346]">*</span></label>
                                <input type="text" name="titre" required placeholder="Ex: Expansion Marché EMEA" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                            <div class="md:col-span-2 space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Description</label>
                                <textarea name="description" rows="3" placeholder="Détails de l'objectif..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5"></textarea>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date de début</label>
                                <input type="date" name="dateDebut" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date d'échéance</label>
                                <input type="date" name="dateFin" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Statut <span class="text-[#be2346]">*</span></label>
                                <select name="status" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="en_cours">En cours</option>
                                    <option value="termine">Terminé</option>
                                    <option value="retard">En retard</option>
                                </select>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Avancement (%) <span class="text-[#be2346]">*</span></label>
                                <input type="number" name="avancement" required min="0" max="100" value="0" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                            <div class="md:col-span-2 space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Département responsable</label>
                                <select name="idDepartement" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="">-- Global --</option>
                                    @foreach($departements as $dept)
                                        <option value="{{ $dept->idDepartement }}">{{ $dept->title ?? $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Footer Buttons --}}
                        <div class="flex gap-3 pt-4">
                            <button type="button" onclick="toggleModal('addObjectifModal')"
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

    {{-- Edit Objectif Modal --}}
    <div id="editObjectifModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('editObjectifModal')"></div>
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden flex flex-col max-h-[92vh] z-10" style="animation: modalIn .2s ease-out">
                
                {{-- Header --}}
                <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                    <div>
                        <h2 class="text-lg font-black text-slate-800">Modifier l'Objectif</h2>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Édition · Access Morocco</p>
                    </div>
                    <button type="button" onclick="toggleModal('editObjectifModal')"
                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Form Content --}}
                <div class="overflow-y-auto">
                    <form id="editObjectifForm" method="POST" class="p-7 space-y-5">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            
                            <div class="md:col-span-2 space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Titre de l'objectif *</label>
                                <input type="text" name="titre" id="edit_titre" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>

                            <div class="md:col-span-2 space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Description</label>
                                <textarea name="description" id="edit_description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5"></textarea>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date de début</label>
                                <input type="date" name="dateDebut" id="edit_dateDebut" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date d'échéance</label>
                                <input type="date" name="dateFin" id="edit_dateFin" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Statut *</label>
                                <select name="status" id="edit_status" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="en_cours">En cours</option>
                                    <option value="termine">Terminé</option>
                                    <option value="retard">En retard</option>
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Avancement (%) *</label>
                                <input type="number" name="avancement" id="edit_avancement" required min="0" max="100" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>

                            <div class="md:col-span-2 space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Département responsable</label>
                                <select name="idDepartement" id="edit_idDepartement" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="">-- Global --</option>
                                    @foreach($departements as $dept)
                                        <option value="{{ $dept->idDepartement }}">{{ $dept->title ?? $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Footer Buttons --}}
                        <div class="flex gap-3 pt-4">
                            <button type="button" onclick="toggleModal('editObjectifModal')"
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

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.toggle('hidden');
                document.body.style.overflow = modal.classList.contains('hidden') ? 'auto' : 'hidden';
            }
        }
        function openEditModal(obj) {
            const form = document.getElementById('editObjectifForm');
            form.action = '/objectifs/edit/' + obj.idObjectif;
            
            document.getElementById('edit_titre').value = obj.titre || '';
            document.getElementById('edit_description').value = obj.description || '';
            document.getElementById('edit_dateDebut').value = obj.dateDebut || '';
            document.getElementById('edit_dateFin').value = obj.dateFin || '';
            document.getElementById('edit_status').value = obj.status || 'en_cours';
            document.getElementById('edit_avancement').value = obj.avancement || 0;
            document.getElementById('edit_idDepartement').value = obj.idDepartement || '';
            
            toggleModal('editObjectifModal');
        }

        function confirmDeleteObjectif(id) {
            window.confirmDelete('/objectifs/delete/' + id, 'objectif');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('addObjectifModal')?.classList.add('hidden');
                document.getElementById('editObjectifModal')?.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
    </script>
</x-app-layout>

