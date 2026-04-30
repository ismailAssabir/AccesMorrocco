<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

        {{-- ═══════════ TOP BAR ═══════════ --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Gestion Financière</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Suivi des paiements et recouvrement des dossiers clients.</p>
            </div>
            
            <button onclick="toggleModal('addPaiementModal')"
                class="flex items-center gap-2 bg-[#be2346] hover:bg-[#a01d3a] text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#be2346]/10 active:scale-95 text-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Enregistrer un Paiement
            </button>
        </div>

        {{-- ═══════════ KPI CARDS ═══════════ --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest">Total Encaissé</p>
                    <span class="p-2 bg-emerald-50 rounded-lg text-emerald-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </span>
                </div>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($stats['totalPaye'], 2) }} <span class="text-xs font-medium text-slate-400">MAD</span></h3>
            </div>

            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm border-l-4 border-l-amber-500">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest">Reste à Recouvrer</p>
                    <span class="p-2 bg-amber-50 rounded-lg text-amber-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                    </span>
                </div>
                <h3 class="text-2xl font-bold text-amber-600">{{ number_format($stats['totalReste'], 2) }} <span class="text-xs font-medium text-slate-400">MAD</span></h3>
            </div>

            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest">Dossiers Soldés</p>
                    <span class="p-2 bg-blue-50 rounded-lg text-blue-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </span>
                </div>
                <h3 class="text-2xl font-bold text-slate-800">{{ $stats['completCount'] }}</h3>
            </div>

            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest">Transactions</p>
                    <span class="p-2 bg-slate-50 rounded-lg text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    </span>
                </div>
                <h3 class="text-2xl font-bold text-slate-800">{{ $stats['totalTransactions'] }}</h3>
            </div>
        </div>

        <x-status-messages />

        {{-- ═══════════ DATA TABLE ═══════════ --}}
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden mb-8">
            <div class="px-7 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h3 class="text-lg font-black text-slate-800">Historique des Transactions</h3>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" id="paiementSearch" placeholder="Rechercher..." class="pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-[11px] font-bold focus:ring-4 focus:ring-[#be2346]/5 focus:border-[#be2346] outline-none transition-all w-64">
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-slate-50 text-slate-400 font-bold border-b border-slate-200">
                        <tr>
                            <th class="px-8 py-5 uppercase tracking-widest text-[10px] font-black">Client / Dossier</th>
                            <th class="px-8 py-5 uppercase tracking-widest text-[10px] font-black">Date</th>
                            <th class="px-8 py-5 uppercase tracking-widest text-[10px] font-black">Mode / Ref</th>
                            <th class="px-8 py-5 uppercase tracking-widest text-[10px] font-black text-right">Montant Payé</th>
                            <th class="px-8 py-5 uppercase tracking-widest text-[10px] font-black text-right">Reste</th>
                            <th class="px-8 py-5 uppercase tracking-widest text-[10px] font-black text-center">Status</th>
                            <th class="px-8 py-5 uppercase tracking-widest text-[10px] font-black text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($paiements as $p)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-800">{{ $p->dossier->client->firstName ?? '—' }} {{ $p->dossier->client->lastName ?? '' }}</span>
                                    <span class="text-[10px] font-black text-[#be2346] uppercase tracking-wider mt-0.5">{{ $p->dossier->reference ?? 'DOS-N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="font-semibold text-slate-600">{{ \Carbon\Carbon::parse($p->date)->format('d/m/Y') }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-700 text-xs">{{ strtoupper($p->modePaiement ?? 'VIREMENT') }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium mt-0.5">Ref: {{ $p->ref ?? '—' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="font-black text-emerald-600">+ {{ number_format($p->montantPaye, 2) }}</span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="font-bold text-slate-400">{{ number_format($p->montantReste, 2) }}</span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                @if($p->status == 'complet')
                                    <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase bg-emerald-50 text-emerald-600 border border-emerald-100">Complet</span>
                                @elseif($p->status == 'partiel')
                                    <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase bg-amber-50 text-amber-600 border border-amber-100">Partiel</span>
                                @else
                                    <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase bg-rose-50 text-rose-600 border border-rose-100">Annulé</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick='openEditModal(@json($p))' class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 hover:bg-[#be2346]/10 hover:text-[#be2346] transition-all flex items-center justify-center border border-slate-100">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button onclick="confirmDelete('{{ route('paiements.destroy', $p->idPaiement) }}')" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center border border-slate-100">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-300">
                                    <svg class="w-16 h-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    <p class="font-black uppercase tracking-widest text-xs">Aucun paiement enregistré</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.98) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-modalIn { animation: modalIn 0.2s ease-out; }
        
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0, 0, 0, 0.05); border-radius: 10px; }
    </style>

    {{-- ═══════════ MODAL: AJOUTER ═══════════ --}}
    <div id="addPaiementModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('addPaiementModal')"></div>
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden z-10 animate-modalIn">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-black text-slate-800">Enregistrer un Paiement</h2>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Nouveau règlement · Access Morocco</p>
                    </div>
                    <button onclick="toggleModal('addPaiementModal')" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>

                <form action="{{ route('paiements.store') }}" method="POST" class="p-8 space-y-5">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 block mb-2">Dossier Concerné *</label>
                            
                            {{-- Searchable Select via Alpine --}}
                            <div x-data="{
                                open: false,
                                search: '',
                                selectedId: '',
                                selectedRef: '— Sélectionner le dossier —',
                                dossiers: {{ json_encode($dossiers) }},
                                get filteredDossiers() {
                                    if (this.search === '') return this.dossiers;
                                    return this.dossiers.filter(d => d.reference.toLowerCase().includes(this.search.toLowerCase()));
                                },
                                select(id, ref) {
                                    this.selectedId = id;
                                    this.selectedRef = ref;
                                    this.open = false;
                                    this.search = '';
                                }
                            }" class="relative">
                                <button type="button" @click="open = !open" 
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm text-left flex items-center justify-between outline-none focus:border-[#be2346] transition-all">
                                    <span x-text="selectedRef" :class="selectedId ? 'text-slate-800 font-bold' : 'text-slate-400 font-medium'"></span>
                                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                                
                                <input type="hidden" name="idDossier" :value="selectedId" required>

                                <div x-show="open" @click.away="open = false" x-cloak
                                    class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-2xl overflow-hidden animate-modalIn">
                                    <div class="p-3 border-b border-slate-50 bg-slate-50/50">
                                        <input type="text" x-model="search" placeholder="Filtrer les dossiers..." 
                                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold focus:ring-4 focus:ring-[#be2346]/5 focus:border-[#be2346] outline-none transition-all">
                                    </div>
                                    <div class="max-h-60 overflow-y-auto custom-scrollbar py-2">
                                        <template x-for="d in filteredDossiers" :key="d.idDossier">
                                            <div @click="select(d.idDossier, d.reference)" 
                                                class="px-5 py-3 text-sm hover:bg-[#be2346]/5 cursor-pointer transition-colors flex items-center justify-between group">
                                                <div class="flex flex-col">
                                                    <span x-text="d.reference" class="font-black text-slate-700 group-hover:text-[#be2346]"></span>
                                                </div>
                                                <svg x-show="selectedId == d.idDossier" class="w-4 h-4 text-[#be2346]" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                            </div>
                                        </template>
                                        <div x-show="filteredDossiers.length === 0" class="px-5 py-10 text-center text-slate-400 text-xs font-bold italic">
                                            Aucun dossier trouvé
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 block mb-2">Montant Payé *</label>
                                <input type="number" step="0.01" name="montantPaye" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 block mb-2">Montant Restant</label>
                                <input type="number" step="0.01" name="montantReste" value="0" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 block mb-2">Date *</label>
                                <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 block mb-2">Status *</label>
                                <select name="status" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="partiel">Partiel</option>
                                    <option value="complet">Complet</option>
                                    <option value="annule">Annulé</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 block mb-2">Mode de Paiement</label>
                                <input type="text" name="modePaiement" placeholder="Virement, Chèque, Cash..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 block mb-2">Référence</label>
                                <input type="text" name="ref" placeholder="N° de transaction..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="button" onclick="toggleModal('addPaiementModal')" class="flex-1 py-4 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 transition-all">Annuler</button>
                        <button type="submit" class="flex-1 py-4 rounded-2xl bg-[#be2346] text-white font-black shadow-lg shadow-[#be2346]/20 active:scale-95 transition-all">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ═══════════ MODAL: MODIFIER ═══════════ --}}
    <div id="editPaiementModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" 
        x-data="{
            open: false,
            search: '',
            selectedId: '',
            selectedRef: '— Sélectionner le dossier —',
            dossiers: {{ json_encode($dossiers) }},
            get filteredDossiers() {
                if (this.search === '') return this.dossiers;
                return this.dossiers.filter(d => d.reference.toLowerCase().includes(this.search.toLowerCase()));
            },
            select(id, ref) {
                this.selectedId = id;
                this.selectedRef = ref;
                this.open = false;
                this.search = '';
            },
            initValues(id, ref) {
                this.selectedId = id;
                this.selectedRef = ref;
            }
        }"
        @set-edit-dossier.window="initValues($event.detail.id, $event.detail.ref)"
    >
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('editPaiementModal')"></div>
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden z-10 animate-modalIn">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-black text-slate-800">Modifier le Règlement</h2>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Édition transaction · Access Morocco</p>
                    </div>
                    <button onclick="toggleModal('editPaiementModal')" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>

                <form id="editPaiementForm" method="POST" class="p-8 space-y-5">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 block mb-2">Dossier Concerné *</label>
                            
                            <div class="relative">
                                <button type="button" @click="open = !open" 
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm text-left flex items-center justify-between outline-none focus:border-[#be2346] transition-all">
                                    <span x-text="selectedRef" class="font-bold text-slate-800"></span>
                                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                                
                                <input type="hidden" name="idDossier" :value="selectedId" required>

                                <div x-show="open" @click.away="open = false" x-cloak
                                    class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-2xl overflow-hidden animate-modalIn">
                                    <div class="p-3 border-b border-slate-50 bg-slate-50/50">
                                        <input type="text" x-model="search" placeholder="Filtrer les dossiers..." 
                                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold focus:ring-4 focus:ring-[#be2346]/5 focus:border-[#be2346] outline-none transition-all">
                                    </div>
                                    <div class="max-h-60 overflow-y-auto custom-scrollbar py-2">
                                        <template x-for="d in filteredDossiers" :key="d.idDossier">
                                            <div @click="select(d.idDossier, d.reference)" 
                                                class="px-5 py-3 text-sm hover:bg-[#be2346]/5 cursor-pointer transition-colors flex items-center justify-between group">
                                                <span x-text="d.reference" class="font-black text-slate-700 group-hover:text-[#be2346]"></span>
                                                <svg x-show="selectedId == d.idDossier" class="w-4 h-4 text-[#be2346]" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 block mb-2">Montant Payé *</label>
                                <input type="number" step="0.01" name="montantPaye" id="edit_montantPaye" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm outline-none transition-all focus:border-[#be2346]">
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 block mb-2">Montant Restant</label>
                                <input type="number" step="0.01" name="montantReste" id="edit_montantReste" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm outline-none transition-all focus:border-[#be2346]">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 block mb-2">Date *</label>
                                <input type="date" name="date" id="edit_date" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm outline-none transition-all focus:border-[#be2346]">
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 block mb-2">Status *</label>
                                <select name="status" id="edit_status" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm outline-none transition-all focus:border-[#be2346]">
                                    <option value="partiel">Partiel</option>
                                    <option value="complet">Complet</option>
                                    <option value="annule">Annulé</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 block mb-2">Mode de Paiement</label>
                                <input type="text" name="modePaiement" id="edit_modePaiement" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm outline-none transition-all focus:border-[#be2346]">
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 block mb-2">Référence</label>
                                <input type="text" name="ref" id="edit_ref" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm outline-none transition-all focus:border-[#be2346]">
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="button" onclick="toggleModal('editPaiementModal')" class="flex-1 py-4 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 transition-all">Annuler</button>
                        <button type="submit" class="flex-1 py-4 rounded-2xl bg-slate-800 text-white font-black shadow-lg shadow-slate-200 active:scale-95 transition-all">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
            document.body.style.overflow = modal.classList.contains('hidden') ? 'auto' : 'hidden';
        }

        function openEditModal(p) {
            const form = document.getElementById('editPaiementForm');
            form.action = `/paiements/${p.idPaiement}`;
            
            // Dispatch event to Alpine for searchable select
            const dossierRef = p.dossier ? p.dossier.reference : '—';
            window.dispatchEvent(new CustomEvent('set-edit-dossier', { 
                detail: { id: p.idDossier, ref: dossierRef } 
            }));

            document.getElementById('edit_montantPaye').value = p.montantPaye;
            document.getElementById('edit_montantReste').value = p.montantReste;
            document.getElementById('edit_date').value = p.date.split(' ')[0];
            document.getElementById('edit_status').value = p.status;
            document.getElementById('edit_modePaiement').value = p.modePaiement || '';
            document.getElementById('edit_ref').value = p.ref || '';
            
            toggleModal('editPaiementModal');
        }

        function confirmDelete(url) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce paiement ? Cette action est irréversible.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.innerHTML = `@csrf @method('DELETE')`;
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Search functionality for the main table
        document.getElementById('paiementSearch').addEventListener('keyup', function() {
            const val = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(val) ? '' : 'none';
            });
        });
    </script>
</x-app-layout>
