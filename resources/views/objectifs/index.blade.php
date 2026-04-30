<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

        {{-- ═══════════ TOP BAR ═══════════ --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Objectifs de l'Entreprise</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Pilotez et suivez les KPI majeurs pour atteindre nos ambitions.</p>
            </div>
            @if(auth()->user()->type !== 'employee')
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

        {{-- ═══════════ FILTER BAR ═══════════ --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4 mb-8">
            <div class="flex flex-nowrap items-center gap-3 overflow-x-auto pb-2 custom-scrollbar">
                {{-- Search --}}
                <div class="flex-1 min-w-[200px] shrink-0 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="searchInput" oninput="debounceFilter()" 
                        placeholder="Rechercher un objectif..." 
                        class="block w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-2xl text-sm transition-all focus:border-[#b11d40]/40 focus:ring-4 focus:ring-[#b11d40]/10 outline-none">
                </div>

                {{-- Status Filter --}}
                <div class="relative shrink-0">
                    <select id="statusFilter" onchange="fetchFilteredObjectifs()" 
                        class="appearance-none bg-white border border-slate-200 rounded-xl pl-4 pr-10 py-2 text-xs font-bold text-slate-600 outline-none transition-all focus:border-[#b11d40]/40 focus:ring-4 focus:ring-[#b11d40]/10 cursor-pointer">
                        <option value="">Statut (Tous)</option>
                        <option value="en_cours">En cours</option>
                        <option value="atteint">Atteint</option>
                        <option value="echoue">Échoué</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>

                {{-- Department Filter --}}
                <div class="relative min-w-[150px] shrink-0">
                    <select id="deptFilter" onchange="fetchFilteredObjectifs()" 
                        class="appearance-none bg-white border border-slate-200 rounded-xl pl-4 pr-10 py-2 text-xs font-bold text-slate-600 outline-none transition-all focus:border-[#b11d40]/40 focus:ring-4 focus:ring-[#b11d40]/10 cursor-pointer w-full">
                        <option value="">Département (Tous)</option>
                        <option value="global">Global</option>
                        @foreach($departements as $d)
                            <option value="{{ $d->idDepartement }}">{{ $d->title }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>

                {{-- Reset Button --}}
                <button type="button" onclick="resetFilters()" class="p-2 rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-all flex items-center justify-center shadow-sm shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- ═══════════ MAIN CONTENT ═══════════ --}}
        <div id="objectifs-container" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @include('objectifs.partials.cards')
        </div>

    </div>
    </div>

    {{-- ═══════════ MODALS ═══════════ --}}

    {{-- Add Objectif Modal --}}
    <div id="addObjectifModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 pointer-events-none">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm -z-10 transition-opacity pointer-events-auto" onclick="toggleModal('addObjectifModal', 'close')"></div>
        <div class="relative z-10 bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden flex flex-col max-h-[92vh] pointer-events-auto animate-in fade-in zoom-in duration-200">
            
            {{-- Header --}}
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Nouvel Objectif Stratégique</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Planification · Access Morocco</p>
                </div>
                <button type="button" onclick="toggleModal('addObjectifModal', 'close')"
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
                            <input type="text" name="titre" required maxlength="55" placeholder="Ex: Expansion Marché EMEA" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
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
                            <select name="status" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                <option value="en_cours">En cours</option>
                                <option value="atteint">Atteint</option>
                                <option value="echoue">Échoué</option>
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Avancement (%) <span class="text-[#be2346]">*</span></label>
                            <input type="number" name="avancement" required min="0" max="100" value="0" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Département responsable</label>
                            <select name="idDepartement" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                <option value="">-- Global --</option>
                                @foreach($departements as $dept)
                                    <option value="{{ $dept->idDepartement }}">{{ $dept->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Footer Buttons --}}
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="toggleModal('addObjectifModal', 'close')"
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
    <div id="editObjectifModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 pointer-events-none">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm -z-10 transition-opacity pointer-events-auto" onclick="toggleModal('editObjectifModal', 'close')"></div>
        <div class="relative z-10 bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden flex flex-col max-h-[92vh] pointer-events-auto animate-in fade-in zoom-in duration-200">
            
            {{-- Header --}}
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Modifier l'Objectif</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Édition · Access Morocco</p>
                </div>
                <button type="button" onclick="toggleModal('editObjectifModal', 'close')"
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
                            <input type="text" name="titre" id="edit_titre" required maxlength="55" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
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
                            <select name="status" id="edit_status" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                <option value="en_cours">En cours</option>
                                <option value="atteint">Atteint</option>
                                <option value="echoue">Échoué</option>
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Avancement (%) *</label>
                            <input type="number" name="avancement" id="edit_avancement" required min="0" max="100" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>

                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Département responsable</label>
                            <select name="idDepartement" id="edit_idDepartement" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                <option value="">-- Global --</option>
                                @foreach($departements as $dept)
                                    <option value="{{ $dept->idDepartement }}">{{ $dept->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Footer Buttons --}}
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="toggleModal('editObjectifModal', 'close')"
                            class="flex-1 py-3.5 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm">
                            Annuler
                        </button>
                        <button type="submit"
                            id="edit_submit_btn"
                            class="flex-1 py-3.5 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-[#be2346]/20 text-sm">
                            Sauvegarder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let debounceTimer;

        function debounceFilter() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetchFilteredObjectifs();
            }, 400);
        }

        function fetchFilteredObjectifs() {
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            const idDepartement = document.getElementById('deptFilter').value;
            
            const container = document.getElementById('objectifs-container');
            container.style.opacity = '0.5';

            let url = `{{ route('goals.index') }}?search=${encodeURIComponent(search)}&status=${status}&idDepartement=${idDepartement}`;

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
                container.style.opacity = '1';
            })
            .catch(error => {
                console.error('Error fetching filtered objectifs:', error);
                container.style.opacity = '1';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('deptFilter').value = '';
            fetchFilteredObjectifs();
        }

        function toggleModal(id, action = 'toggle') {
            const modal = document.getElementById(id);
            if (!modal) return;
            
            const isHidden = modal.classList.contains('hidden');
            const shouldOpen = action === 'open' || (action === 'toggle' && isHidden);
            
            if (shouldOpen) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }
        }

        function openEditModal(id) {
            const form = document.getElementById('editObjectifForm');
            form.action = `/objectifs/edit/${id}`;
            
            // Show modal immediately for better UX
            toggleModal('editObjectifModal', 'open');
            
            // Temporary loading state
            const titreInput = document.getElementById('edit_titre');
            const submitBtn = document.getElementById('edit_submit_btn');
            
            const originalTitle = titreInput.value;
            const originalBtnText = submitBtn.innerHTML;
            
            titreInput.value = 'Chargement...';
            submitBtn.innerHTML = 'Chargement...';
            submitBtn.disabled = true;
            
            // Fetch the data from the controller (AJAX)
            fetch(`/objectifs/edit/${id}?_t=${new Date().getTime()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if(!response.ok) throw new Error('Network error');
                return response.json();
            })
            .then(data => {
                document.getElementById('edit_titre').value = data.titre || '';
                document.getElementById('edit_description').value = data.description || '';
                document.getElementById('edit_dateDebut').value = data.dateDebut || '';
                document.getElementById('edit_dateFin').value = data.dateFin || '';
                document.getElementById('edit_status').value = data.status || 'en_cours';
                document.getElementById('edit_avancement').value = data.avancement || 0;
                document.getElementById('edit_idDepartement').value = data.idDepartement || '';
                
                submitBtn.innerHTML = 'Sauvegarder';
                submitBtn.disabled = false;
            })
            .catch(error => {
                console.error('Error fetching objective data:', error);
                titreInput.value = 'Erreur lors du chargement.';
                submitBtn.innerHTML = 'Erreur';
            });
        }

        function confirmDeleteObjectif(id) {
            window.confirmDelete('/objectifs/delete/' + id, 'objectif');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                toggleModal('addObjectifModal', 'close');
                toggleModal('editObjectifModal', 'close');
            }
        });
    </script>
</x-app-layout>