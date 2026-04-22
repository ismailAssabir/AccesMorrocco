<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

        {{-- ═══════════ TOP BAR ═══════════ --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Demandes de Congés</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Gérez et validez les demandes d'absence.</p>
            </div>
            <button onclick="openCongeModal()" class="flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Nouvelle Demande
            </button>
        </div>

        {{-- Flash Messages --}}
        <div id="status-messages">
            @if(session('msg'))
                <div class="msg-item mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-2xl font-bold text-sm flex items-center gap-3 transition-all duration-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    {{ session('msg') }}
                </div>
            @endif
            @if($errors->any())
                <div class="msg-item mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl font-bold text-sm transition-all duration-500">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        {{-- ═══════════ STATISTICS HEADER ═══════════ --}}
        @php
            $totalConges = $conges->count();
            $pendingConges = $conges->where('status', 'en_attente')->count();
            $approvedConges = $conges->where('status', 'approuve')->count();
            $rejectedConges = $conges->where('status', 'refuse')->count();
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-5 transition-transform hover:-translate-y-1">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-blue-50 text-blue-500">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total</p>
                    <p class="text-2xl font-black text-slate-800">{{ $totalConges }}</p>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-5 transition-transform hover:-translate-y-1">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-amber-50 text-amber-500">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">En Attente</p>
                    <p class="text-2xl font-black text-slate-800">{{ $pendingConges }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-5 transition-transform hover:-translate-y-1">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-emerald-50 text-emerald-500">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Approuvés</p>
                    <p class="text-2xl font-black text-slate-800">{{ $approvedConges }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-5 transition-transform hover:-translate-y-1">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-red-50 text-red-500">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Refusés</p>
                    <p class="text-2xl font-black text-slate-800">{{ $rejectedConges }}</p>
                </div>
            </div>
        </div>

        {{-- ═══════════ MAIN CONTENT ═══════════ --}}
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-extrabold text-slate-500 tracking-wider">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Employé</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Période</th>
                            <th class="px-6 py-4">Date Demande</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php
                            $filteredConges = auth()->user()->role === 'employee' 
                                ? $conges->where('idUser', auth()->user()->idUser) 
                                : $conges;
                        @endphp

                        @forelse($filteredConges as $conge)
                        @php
                            $empName = $conge->user ? trim(($conge->user->firstName ?? '') . ' ' . ($conge->user->lastName ?? '')) : 'Employé';
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-800">#{{ $conge->idConge }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs shrink-0">
                                        {{ mb_substr($empName, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-slate-800">{{ $empName }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-600 capitalize">
                                {{ str_replace('_', ' ', $conge->type) }}
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                <div class="text-xs">
                                    <span class="block">Du: <span class="font-bold text-slate-700">{{ $conge->dateDebut }}</span></span>
                                    <span class="block mt-0.5">Au: <span class="font-bold text-slate-700">{{ $conge->dateFin }}</span></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-600">
                                {{ $conge->dateDemande }}
                            </td>
                            <td class="px-6 py-4">
                                @if($conge->status == 'approuve')
                                    <span class="bg-emerald-50 text-emerald-600 font-bold px-3 py-1 rounded-full text-xs border border-emerald-200">Approuvé</span>
                                @elseif($conge->status == 'refuse')
                                    <span class="bg-red-50 text-red-600 font-bold px-3 py-1 rounded-full text-xs border border-red-200">Refusé</span>
                                @else
                                    <span class="bg-amber-50 text-amber-600 font-bold px-3 py-1 rounded-full text-xs border border-amber-200">En attente</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Eye icon for everyone (show details) --}}
                                    <button onclick="openShowCongeModal('{{ $conge->idConge }}')" class="text-slate-400 hover:text-blue-500 bg-white hover:bg-blue-50 p-2 rounded-lg border border-slate-200 transition-colors shadow-sm" title="Voir les détails">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </button>

                                    {{-- Admin actions: Accept/Reject --}}
                                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
                                        @if($conge->status != 'approuve')
                                            <form action="{{ route('conge.update', $conge->idConge) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="approuve">
                                                <button type="submit" class="text-emerald-500 hover:text-emerald-600 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 p-2 rounded-lg transition-colors shadow-sm" title="Approuver">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($conge->status != 'refuse')
                                            <form action="{{ route('conge.update', $conge->idConge) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="refuse">
                                                <button type="submit" class="text-[#b11d40] hover:text-[#911633] bg-[#b11d40]/10 hover:bg-[#b11d40]/20 border border-[#b11d40]/30 p-2 rounded-lg transition-colors shadow-sm" title="Refuser">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                    @endif

                                    {{-- Edit restriction (Owner only when En attente) --}}
                                    @if(auth()->check() && (auth()->user()->idUser == $conge->idUser || auth()->id() == $conge->idUser) && $conge->status == 'en_attente')
                                        <button onclick="openEditCongeModal('{{ $conge->idConge }}')" class="text-amber-500 hover:text-amber-600 bg-amber-50 hover:bg-amber-100 border border-amber-200 p-2 rounded-lg transition-colors shadow-sm" title="Modifier">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </button>
                                    @endif

                                    {{-- Delete restriction (Admin OR (Owner + En attente)) --}}
                                    @if(auth()->user()->role === 'admin' || ((auth()->user()->idUser == $conge->idUser || auth()->id() == $conge->idUser) && $conge->status == 'en_attente'))
                                        <button type="button" onclick="openDeleteModal('{{ $conge->idConge }}', '{{ route('conge.destroy', $conge->idConge) }}')" class="text-slate-500 hover:text-red-600 bg-slate-50 hover:bg-red-50 border border-slate-200 p-2 rounded-lg transition-colors shadow-sm" title="Supprimer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-slate-500">
                                Aucune demande de congé trouvée.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Modal Nouvelle Demande --}}
    <div id="addCongeModal" class="fixed inset-0 z-[100] {{ $errors->any() ? '' : 'hidden' }} flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeCongeModal()"></div>
        <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl border border-slate-200 overflow-hidden flex flex-col max-h-[92vh] z-10" style="animation: modalIn .2s ease-out">
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Nouvelle Demande</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Congé · Access Morocco</p>
                </div>
                <button type="button" onclick="closeCongeModal()" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#b11d40] hover:border-[#b11d40]/30 transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="overflow-y-auto">
                <form action="{{ route('conge.store') }}" method="POST" enctype="multipart/form-data" class="p-7 space-y-5">
                    @csrf
                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Type de Congé <span class="text-[#b11d40]">*</span></label>
                        <select name="type" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5">
                            <option value="annuel" {{ old('type') == 'annuel' ? 'selected' : '' }}>Annuel</option>
                            <option value="maladie" {{ old('type') == 'maladie' ? 'selected' : '' }}>Maladie</option>
                            <option value="sans_solde" {{ old('type') == 'sans_solde' ? 'selected' : '' }}>Sans Solde</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date Début <span class="text-[#b11d40]">*</span></label>
                            <input type="date" name="dateDebut" required value="{{ old('dateDebut') }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date Fin <span class="text-[#b11d40]">*</span></label>
                            <input type="date" name="dateFin" required value="{{ old('dateFin') }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Raison (Motif)</label>
                        <textarea name="motif" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5">{{ old('motif') }}</textarea>
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Justification (Fichier)</label>
                        <input type="file" name="justification" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5">
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="closeCongeModal()" class="flex-1 py-3.5 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm">Annuler</button>
                        <button type="submit" class="flex-1 py-3.5 rounded-2xl bg-[#b11d40] hover:bg-[#911633] active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-[#b11d40]/20 text-sm">Soumettre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit Demande --}}
    <div id="editCongeModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeEditCongeModal()"></div>
        <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl border border-slate-200 overflow-hidden flex flex-col max-h-[92vh] z-10" style="animation: modalIn .2s ease-out">
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Modifier la Demande</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Demande #<span id="edit-id-text"></span></p>
                </div>
                <button type="button" onclick="closeEditCongeModal()" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#b11d40] hover:border-[#b11d40]/30 transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="overflow-y-auto">
                <form id="editCongeForm" method="POST" enctype="multipart/form-data" class="p-7 space-y-5">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Type de Congé <span class="text-[#b11d40]">*</span></label>
                        <select name="type" id="edit-type" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5">
                            <option value="annuel">Annuel</option>
                            <option value="maladie">Maladie</option>
                            <option value="sans_solde">Sans Solde</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date Début <span class="text-[#b11d40]">*</span></label>
                            <input type="date" name="dateDebut" id="edit-dateDebut" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date Fin <span class="text-[#b11d40]">*</span></label>
                            <input type="date" name="dateFin" id="edit-dateFin" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Raison (Motif)</label>
                        <textarea name="motif" id="edit-motif" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5"></textarea>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="closeEditCongeModal()" class="flex-1 py-3.5 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm">Annuler</button>
                        <button type="submit" class="flex-1 py-3.5 rounded-2xl bg-[#b11d40] hover:bg-[#911633] active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-[#b11d40]/20 text-sm">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Show Details Modal (AJAX) --}}
    <div id="showCongeDetailsModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeCongeDetailsModal()"></div>
        <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl border border-slate-200 overflow-hidden flex flex-col z-10" style="animation: modalIn .2s ease-out">
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Détails de la Demande</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Demande #<span id="detail-id"></span></p>
                </div>
                <button type="button" onclick="closeCongeDetailsModal()" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#b11d40] hover:border-[#b11d40]/30 transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="p-7 space-y-4 text-sm text-slate-700" id="detail-body">
                <div class="flex items-center gap-3 mb-6 bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg shrink-0" id="detail-avatar">
                        E
                    </div>
                    <div>
                        <p class="font-black text-slate-800" id="detail-employe">Employé Name</p>
                        <p class="text-xs text-slate-500 font-medium">Créée le <span id="detail-dateDemande">...</span></p>
                    </div>
                    <div class="ml-auto" id="detail-status">
                        <!-- Statut injecté ici -->
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-3">
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Date Début</p>
                        <p class="font-bold text-slate-800 mt-1" id="detail-dateDebut">...</p>
                    </div>
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-3">
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Date Fin</p>
                        <p class="font-bold text-slate-800 mt-1" id="detail-dateFin">...</p>
                    </div>
                </div>

                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Type</p>
                    <p class="font-bold text-slate-800 mt-1 capitalize" id="detail-type">...</p>
                </div>

                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Motif</p>
                    <p class="text-slate-600 mt-1" id="detail-motif">...</p>
                </div>

                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Justification</p>
                    <p class="text-slate-600 mt-1 break-words" id="detail-justification">
                        <!-- Lien ou nom du fichier -->
                    </p>
                </div>
                
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Solde</p>
                    <p class="text-slate-600 mt-1" id="detail-sold">...</p>
                </div>
            </div>
            <div class="px-7 py-5 border-t border-slate-100 bg-slate-50/60 flex items-center justify-end">
                <button type="button" onclick="closeCongeDetailsModal()" class="px-5 py-2.5 rounded-xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-white hover:text-slate-600 transition-all text-sm shadow-sm">
                    Fermer
                </button>
            </div>
        </div>
    </div>




    <script>
        // Modals Toggle Functions
        function openCongeModal() {
            document.getElementById('addCongeModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeCongeModal() {
            document.getElementById('addCongeModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        function closeCongeDetailsModal() {
            document.getElementById('showCongeDetailsModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        function closeEditCongeModal() {
            document.getElementById('editCongeModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        function openDeleteModal(id, url) {
            window.confirmDelete(url, 'demande de congé');
        }

        // JS Logic for Editing
        function openEditCongeModal(id) {
            document.getElementById('editCongeModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            document.getElementById('edit-id-text').innerText = id;
            document.getElementById('edit-motif').value = "Chargement...";
            
            let updateUrl = `{{ url('conge/update') }}/${id}`;
            document.getElementById('editCongeForm').action = updateUrl;

            fetch(`/conge/${id}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if(!response.ok) throw new Error("Erreur réseau");
                return response.json();
            })
            .then(data => {
                document.getElementById('edit-type').value = data.type;
                document.getElementById('edit-dateDebut').value = data.dateDebut;
                document.getElementById('edit-dateFin').value = data.dateFin;
                document.getElementById('edit-motif').value = data.motif || '';
            })
            .catch(error => {
                console.error("Erreur de récupération :", error);
                document.getElementById('edit-motif').value = "";
            });
        }

        // Vanilla JS AJAX Fetch for Details Pop-up
        function openShowCongeModal(id) {
            // Afficher le modal avec un état de chargement léger
            document.getElementById('showCongeDetailsModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            document.getElementById('detail-id').innerText = id;
            document.getElementById('detail-employe').innerText = "Chargement...";
            document.getElementById('detail-avatar').innerText = "...";
            document.getElementById('detail-dateDemande').innerText = "...";
            document.getElementById('detail-dateDebut').innerText = "...";
            document.getElementById('detail-dateFin').innerText = "...";
            document.getElementById('detail-type').innerText = "...";
            document.getElementById('detail-motif').innerText = "Chargement...";
            document.getElementById('detail-sold').innerText = "Chargement...";
            document.getElementById('detail-justification').innerHTML = "Chargement...";
            document.getElementById('detail-status').innerHTML = "";

            fetch(`/conge/${id}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if(!response.ok) throw new Error("Erreur réseau");
                return response.json();
            })
            .then(data => {
                const conge = data;
                let empName = conge.user ? (conge.user.firstName + ' ' + conge.user.lastName) : 'Employé Inconnu';
                
                document.getElementById('detail-employe').innerText = empName;
                document.getElementById('detail-avatar').innerText = empName.charAt(0).toUpperCase();
                
                document.getElementById('detail-dateDemande').innerText = conge.dateDemande || '-';
                document.getElementById('detail-dateDebut').innerText = conge.dateDebut || '-';
                document.getElementById('detail-dateFin').innerText = conge.dateFin || '-';
                
                let typeStr = conge.type ? conge.type.replace('_', ' ') : '-';
                document.getElementById('detail-type').innerText = typeStr;
                
                document.getElementById('detail-motif').innerText = conge.motif || 'Aucun motif fourni.';
                document.getElementById('detail-sold').innerText = conge.sold !== null ? conge.sold : 'Non renseigné';
                
                if (conge.justification) {
                    document.getElementById('detail-justification').innerHTML = `<a href="/storage/${conge.justification}" target="_blank" class="text-blue-500 hover:underline">Voir le fichier joint</a>`;
                } else {
                    document.getElementById('detail-justification').innerText = "Aucun fichier joint.";
                }

                let badge = '';
                if(conge.status === 'approuve') {
                    badge = `<span class="bg-emerald-50 text-emerald-600 font-bold px-3 py-1 rounded-full text-xs border border-emerald-200">Approuvé</span>`;
                } else if(conge.status === 'refuse') {
                    badge = `<span class="bg-red-50 text-red-600 font-bold px-3 py-1 rounded-full text-xs border border-red-200">Refusé</span>`;
                } else {
                    badge = `<span class="bg-amber-50 text-amber-600 font-bold px-3 py-1 rounded-full text-xs border border-amber-200">En attente</span>`;
                }
                document.getElementById('detail-status').innerHTML = badge;
            })
            .catch(error => {
                console.error("Erreur lors de la récupération des détails :", error);
                document.getElementById('detail-motif').innerText = "Erreur lors du chargement des détails.";
            });
        }
        
        // Auto-dismiss Flash Messages
        document.addEventListener('DOMContentLoaded', function() {
            const messages = document.querySelectorAll('.msg-item');
            messages.forEach(msg => {
                setTimeout(() => {
                    msg.style.opacity = '0';
                    msg.style.transform = 'translateY(-10px)';
                    setTimeout(() => msg.remove(), 500);
                }, 3000);
            });
        });
    </script>
</x-app-layout>
