<x-app-layout>
<div class="p-8 bg-[#F8FAFC] min-h-screen">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Gestion des Dossiers</h1>
            <p class="text-slate-500 text-sm">Suivez et gérez tous vos dossiers.</p>
        </div>

        <div class="flex gap-3">
    @can('dossier.view')
    <a href="{{ route('dossiers.export-pdf', request()->query()) }}"
        class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
        </svg>
        Exporter PDF
    </a>
    @endcan

    @can('dossier.create')
    <button onclick="document.getElementById('modal-create').classList.remove('hidden')"
        class="flex items-center gap-2 px-4 py-2 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nouveau Dossier
    </button>
    @endcan
</div>
    </div>

    {{-- FLASH --}}
    @if(session('msg'))
    <div id="flash-message" class="js-flash-message mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm font-semibold transition-all duration-500">
        {{ session('msg') }}
    </div>
    @endif

    {{-- FILTERS --}}
    <form method="GET" action="{{ route('dossiers.index') }}" x-data
          class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4 mb-6">
        <div class="flex flex-nowrap items-center gap-3 overflow-x-auto pb-2 custom-scrollbar">
            
            {{-- Search --}}
            <div class="flex-1 min-w-[200px] shrink-0 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                       @input.debounce.500ms="$el.closest('form').submit()"
                       placeholder="Rechercher référence, destination..."
                       class="block w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-2xl text-sm transition-all focus:border-[#b11d40]/40 focus:ring-4 focus:ring-[#b11d40]/10 outline-none">
            </div>

            {{-- Departement Filter --}}
            @unless(auth()->user()->hasRole('manager'))
            <div class="relative shrink-0">
                <select name="idDepartement" onchange="this.form.submit()"
                        class="appearance-none bg-white border border-slate-200 rounded-xl pl-4 pr-10 py-2 text-xs font-bold text-slate-600 outline-none transition-all focus:border-[#b11d40]/40 focus:ring-4 focus:ring-[#b11d40]/10 cursor-pointer">
                    <option value="">Département (Tous)</option>
                    @foreach($departements as $dept)
                        <option value="{{ $dept->idDepartement }}" {{ request('idDepartement') == $dept->idDepartement ? 'selected' : '' }}>{{ $dept->title }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
            @endunless

            {{-- Status Filter --}}
            <div class="relative shrink-0">
                <select name="status" onchange="this.form.submit()"
                        class="appearance-none bg-white border border-slate-200 rounded-xl pl-4 pr-10 py-2 text-xs font-bold text-slate-600 outline-none transition-all focus:border-[#b11d40]/40 focus:ring-4 focus:ring-[#b11d40]/10 cursor-pointer">
                    <option value="">Statut (Tous)</option>
                    <option value="ouvert" {{ request('status') == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                    <option value="en_cours" {{ request('status') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                    <option value="ferme" {{ request('status') == 'ferme' ? 'selected' : '' }}>Fermé</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

            {{-- Reset --}}
            @if((request()->has('search') && request('search') != '') || (request()->has('status') && request('status') != '') || (request()->has('idDepartement') && request('idDepartement') != ''))
            <div class="flex shrink-0">
                <a href="{{ route('dossiers.index') }}" title="Réinitialiser" class="p-2 rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-all flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </a>
            </div>
            @endif
        </div>
    </form>

    {{-- TABLE --}}
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-slate-400 text-xs uppercase">
                    <th class="px-4 py-4 text-left">Ref</th>
                    <th class="px-4 py-4 text-left">Client</th>
                    <th class="px-4 py-4 text-left">Destination</th>
                    <th class="px-4 py-4 text-left">Département</th>
                    <th class="px-4 py-4 text-left">Assigné</th>
                    <th class="px-4 py-4 text-left">Statut</th>
                    <th class="px-4 py-4 text-left">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-50">
                @forelse($dossiers as $dossier)
                <tr class="hover:bg-slate-50">

                    <td class="px-4 py-4 font-bold text-slate-700">
                        {{ $dossier->reference }}
                    </td>

                    <td class="px-4 py-4">
                        {{ $dossier->client->firstName ?? '' }}
                        {{ $dossier->client->lastName ?? '' }}
                    </td>

                    <td class="px-4 py-4">{{ $dossier->distination }}</td>

                    <td class="px-4 py-4">
                        @if(!$dossier->idDepartement && auth()->user()->hasRole('admin'))
                            <button onclick="openDeptModal({{ $dossier->idDossier }})"
                                class="inline-flex items-center gap-1.5 px-2 py-1 rounded-lg text-[11px] font-bold bg-amber-100 text-amber-700 hover:bg-amber-200 transition">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                Non assigné
                            </button>
                        @else
                            {{ $dossier->departement->title ?? '-' }}
                        @endif
                    </td>

                    <td class="px-4 py-4 text-green-600 font-bold">
                        {{$dossier->idUser? $dossier->user->firstName." ".$dossier->user->lastName : 'Non assigné' }}
                    </td>

                    <td class="px-4 py-4">
                    @php
                        $statusColors = [
                            'ouvert' => 'bg-blue-100 text-blue-700',
                            'en_cours' => 'bg-amber-100 text-amber-700',
                            'ferme' => 'bg-green-100 text-green-700'
                        ];
                        $statusIcons = [
                            'ouvert' => '<svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>',
                            'en_cours' => '<svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>',
                            'ferme' => '<svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>'
                        ];
                        $statusLabels = [
                            'ouvert' => 'Ouvert',
                            'en_cours' => 'En cours',
                            'ferme' => 'Fermé'
                        ];
                        $canEditStatus = (
                            (auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager') || $dossier->idUser == auth()->user()->idUser)
                            && $dossier->status !== 'ferme' // 🔥 IMPORTANT
                        );                    
                        @endphp
                    
                    @if($canEditStatus)
                        <select onchange="updateStatus({{ $dossier->idDossier }}, this.value)"
                                class="px-2 py-1 rounded-lg text-xs font-bold border-0 focus:ring-2 focus:ring-[#b11d40] cursor-pointer {{ $statusColors[$dossier->status] ?? 'bg-slate-100' }}">
                            <option value="ouvert" {{ $dossier->status == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                            <option value="en_cours" {{ $dossier->status == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="ferme" {{ $dossier->status == 'ferme' ? 'selected' : '' }}>Fermé</option>
                        </select>
                    @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold uppercase tracking-wider {{ $statusColors[$dossier->status] ?? 'bg-slate-100' }}">
                            {!! $statusIcons[$dossier->status] ?? '' !!}
                            {{ $statusLabels[$dossier->status] ?? $dossier->status }}
                        </span>
                    @endif
                    </td>
                <td class="px-4 py-4">
                    <div class="flex items-center gap-1">

                        @can('dossier.view')
                        <a href="{{ route('dossiers.show',$dossier->idDossier) }}"
                           class="p-1.5 rounded-lg text-slate-400 hover:text-green-600 hover:bg-green-50 transition-all"
                           title="Voir les détails">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                        @endcan

                        @can('dossier.edit')
                        <a href="{{ route('dossiers.edit',$dossier->idDossier) }}"
                           class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all"
                           title="Modifier">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        @endcan

                        @can('dossier.delete')
                        <button onclick="window.confirmDelete('{{ route('dossiers.destroy', $dossier->idDossier) }}', 'dossier')"
                                class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all"
                                title="Supprimer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                        @endcan

                        {{-- ASSIGN --}}
                        @role('manager')
                        @if(auth()->user()->idDepartement == $dossier->idDepartement)
                        <button onclick="openAssignModal({{ $dossier->idDossier }}, {{ $dossier->idDepartement }})"
                                class="p-1.5 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-all"
                                title="Assigner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m13-3a4 4 0 10-8 0 4 4 0 008 0z" />
                            </svg>
                        </button>
                        @endif
                        @endrole

                    </div>
                </td>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-16 text-slate-400">
                        Aucun dossier trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- PAGINATION --}}
        <div class="p-4">
            {{ $dossiers->links() }}
        </div>
    </div>

</div>

{{-- ================= MODAL ASSIGN ================= --}}

<div id="modal-assign" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md max-h-[90vh] flex flex-col overflow-hidden">

        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

        <div class="p-6 border-b border-slate-100 flex justify-between items-center shrink-0">
            <h2 class="font-extrabold text-slate-800">Assigner un employé</h2>
            <button onclick="document.getElementById('modal-assign').classList.add('hidden')"
                class="text-slate-400 hover:text-slate-600">✕</button>
        </div>

        <div class="px-6 py-4 overflow-y-auto flex-1 space-y-3">

            {{-- Loading --}}
            <div id="assign-loading" class="hidden text-center text-slate-400 text-sm py-4">
                Chargement...
            </div>

            {{-- Cards employés --}}
            <div id="assign-list" class="space-y-2"></div>

        </div>

        <form method="POST" id="assignForm" class="px-6 pb-6 pt-4 border-t border-slate-100 bg-slate-50 shrink-0">
            @csrf
            @method('PUT')

            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Sélectionner</label>
            <select name="idUser" id="assign-user"
                class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm mb-4">
            </select>

            <button class="w-full bg-[#b11d40] text-white py-2.5 rounded-xl font-bold text-sm hover:bg-[#7c1233] transition">
                Assigner
            </button>
        </form>
    </div>
</div>
{{-- ================= MODAL ASSIGN DEPARTEMENT ================= --}}
<div id="modal-dept" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-2xl w-full max-w-md shadow-xl">
        <h2 class="font-bold mb-1 text-slate-800">Assigner un Département</h2>
        <p class="text-xs text-slate-400 mb-4">Ce dossier n'est assigné à aucun département.</p>

        <form method="POST" id="deptForm">
            @csrf
            @method('PUT')

            <select name="idDepartement" id="dept-select"
                class="w-full px-3 py-2 border border-slate-200 rounded-xl mb-4 text-sm">
                <option value="">Choisir un département...</option>
                @foreach($departements as $dept)
                    <option value="{{ $dept->idDepartement }}">{{ $dept->title }}</option>
                @endforeach
            </select>

            <div class="flex gap-2">
                <button type="submit"
                    class="flex-1 bg-[#b11d40] text-white py-2 rounded-xl font-bold text-sm hover:bg-[#7c1233] transition">
                    Assigner
                </button>
                <button type="button" onclick="document.getElementById('modal-dept').classList.add('hidden')"
                    class="flex-1 bg-slate-100 text-slate-600 py-2 rounded-xl font-bold text-sm hover:bg-slate-200 transition">
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>
{{-- ===== MODAL CREATE DOSSIER ===== --}}
@can('dossier.create')
<div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg max-h-[90vh] flex flex-col">

        {{-- HEADER FIXE --}}
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233] rounded-t-3xl shrink-0"></div>
        <div class="p-6 flex justify-between items-center border-b border-slate-100 shrink-0">
            <h2 class="text-lg font-extrabold text-slate-800">Nouveau Dossier</h2>
            <button onclick="document.getElementById('modal-create').classList.add('hidden')"
                    class="text-slate-400 hover:text-slate-600">✕</button>
        </div>

        <form method="POST" action="{{ route('dossiers.store') }}" class="flex flex-col flex-1 overflow-hidden">
            @csrf

            {{-- SCROLL AREA --}}
            <div class="px-6 py-4 space-y-4 overflow-y-auto flex-1">

                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Client *</label>
                    <select name="idClient" required
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        <option value="">— Choisir un client —</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->idClient }}">{{ $client->firstName }} {{ $client->lastName }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Département </label>
                    <select name="idDepartement" 
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        <option value="">— Choisir un département —</option>
                        @foreach($departements as $dept)
                            <option value="{{ $dept->idDepartement }}">{{ $dept->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Destination</label>
                    <input name="distination" placeholder="Ex: Paris, Dubai..."
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nombre de personnes *</label>
                        <input name="nombrePersonnes" type="number" min="1" value="1" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nombre de jours *</label>
                        <input name="nombreJours" type="number" min="0" value="0" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Montant *</label>
                    <input name="montant" type="number" min="0" step="0.01" value="0" required
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Date de voyage</label>
                    <input name="dateVoyage" type="date"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Commentaire</label>
                    <textarea name="commentaire" rows="3"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] resize-none"></textarea>
                </div>

            </div>

            {{-- FOOTER FIXE --}}
            <div class="px-6 py-4 flex gap-3 justify-end border-t border-slate-100 bg-slate-50 shrink-0">
                <button type="button"
                    onclick="document.getElementById('modal-create').classList.add('hidden')"
                    class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm">
                    Annuler
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl text-sm shadow">
                    Créer le Dossier
                </button>
            </div>

        </form>
    </div>
</div>
@endcan
{{-- ===== MODAL CONFIRMATION STATUS ===== --}}
<div id="modal-confirm-status" class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
        <div class="p-6">
            <div class="flex items-center gap-4 mb-4">
                <div id="confirm-icon" class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl flex-shrink-0"></div>
                <div>
                    <h3 class="font-extrabold text-slate-800 text-base">Confirmer le changement</h3>
                    <p id="confirm-message" class="text-slate-500 text-sm mt-0.5"></p>
                </div>
            </div>
            <div id="confirm-status-preview" class="mb-5 p-3 rounded-xl border text-center text-sm font-bold"></div>
            <div class="flex gap-3">
                <button onclick="cancelStatusChange()"
                    class="flex-1 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm hover:bg-slate-50 transition">
                    Annuler
                </button>
                <button onclick="confirmStatusChange()"
                    class="flex-1 px-4 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl text-sm hover:bg-[#7c1233] transition shadow">
                    Confirmer
                </button>
            </div>
        </div>
    </div>
</div>
{{-- JS --}}
<script>
    let pendingStatusChange = null;

    function openDeptModal(dossierId) {
        const modal = document.getElementById('modal-dept');
        const form = document.getElementById('deptForm');
        form.action = '/dossiers/' + dossierId + '/assign-departement';
        modal.classList.remove('hidden');
    }

    window.addEventListener('click', function(event) {
        const deptModal = document.getElementById('modal-dept');
        if (event.target == deptModal) {
            deptModal.classList.add('hidden');
        }
    });

    function openAssignModal(dossierId, departementId) {
        const modal = document.getElementById('modal-assign');
        const select = document.getElementById('assign-user');
        const form = document.getElementById('assignForm');
        const loadingEl = document.getElementById('assign-loading');
        const listEl = document.getElementById('assign-list');

        modal.classList.remove('hidden');
        form.action = '/dossiers/' + dossierId + '/assign';

        loadingEl.classList.remove('hidden');
        listEl.innerHTML = '';
        select.innerHTML = '';

        fetch('/departements/' + departementId + '/users')
            .then(res => res.json())
            .then(data => {
                loadingEl.classList.add('hidden');
                select.innerHTML = '<option value="">Choisir un employé...</option>';
                data.sort((a, b) => a.dossiers_actifs - b.dossiers_actifs);

                data.forEach(user => {
                    const actifs = user.dossiers_actifs ?? 0;
                    const fermes = user.dossiers_fermes ?? 0;
                    const maxDossiers = 5;
                    const isFull = actifs >= maxDossiers;
                    const chargePercent = Math.min((actifs / maxDossiers) * 100, 100);

                    let chargeColor = '#16a34a';
                    if (actifs >= 5) chargeColor = '#dc2626';
                    else if (actifs >= 3) chargeColor = '#f59e0b';
                    else if (actifs >= 2) chargeColor = '#3b82f6';

                    const opt = document.createElement('option');
                    opt.value = user.idUser;
                    opt.textContent = `${user.firstName} ${user.lastName} - ${actifs}/5 actifs, ${fermes} fermés`;
                    if (isFull) {
                        opt.disabled = true;
                        opt.textContent += ' (complet)';
                    }
                    select.appendChild(opt);

                    listEl.innerHTML += `
                        <div class="p-3 rounded-xl border ${isFull ? 'bg-red-50 border-red-200 opacity-60' : 'bg-slate-50 border-slate-200'}">
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">${user.firstName} ${user.lastName}</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5 flex items-center gap-1.5"><svg class="w-3 h-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg> ${actifs} actif(s) <span class="mx-1 text-slate-300">|</span> <svg class="w-3 h-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> ${fermes} fermé(s)</p>
                                </div>
                                ${isFull
                                    ? '<span class="inline-flex items-center gap-1 text-[10px] font-black uppercase text-red-500 bg-red-100 px-2 py-1 rounded-md tracking-wider"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>COMPLET</span>'
                                    : '<span class="inline-flex items-center gap-1 text-[10px] font-black uppercase text-green-600 bg-green-100 px-2 py-1 rounded-md tracking-wider"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>DISPONIBLE</span>'
                                }
                            </div>
                            <div class="mb-1">
                                <div class="flex justify-between text-[11px] font-bold mb-1">
                                    <span class="text-slate-500">Charge de travail</span>
                                    <span style="color: ${chargeColor};">${actifs}/${maxDossiers}</span>
                                </div>
                                <div class="bg-slate-200 rounded-full h-1.5 overflow-hidden">
                                    <div class="h-1.5 rounded-full transition-all duration-300"
                                        style="width: ${chargePercent}%; background: ${chargeColor};"></div>
                                </div>
                            </div>
                            ${actifs === 4 ? `<div class="mt-2 text-[10px] font-bold text-orange-600 bg-orange-50/80 px-2 py-1.5 rounded-lg border border-orange-100 flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg> Capacité proche du maximum</div>` : ''}
                            ${isFull ? `<div class="mt-2 text-[10px] font-bold text-red-600 bg-red-50/80 px-2 py-1.5 rounded-lg border border-red-100 flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg> Impossible d'assigner</div>` : ''}
                        </div>
                    `;
                });

                const availableUsers = data.filter(u => (u.dossiers_actifs ?? 0) < 5);
                if (availableUsers.length === 0) {
                    listEl.innerHTML += `
                        <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl text-center">
                            <div class="mx-auto w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-500 mb-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <p class="text-amber-700 font-bold text-sm">Aucun employé disponible</p>
                            <p class="text-amber-600 text-xs mt-1">Tous les employés ont atteint leur capacité maximale.</p>
                        </div>
                    `;
                }
            })
            .catch(err => {
                loadingEl.classList.add('hidden');
                listEl.innerHTML = '<div class="text-center text-red-500 text-sm py-4 flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Erreur de chargement</div>';
                console.error(err);
            });
    }

    // ===== STATUS =====

    function updateStatus(dossierId, newStatus) {
        const select = event.target;
        const oldValue = select.getAttribute('data-old') || select.value;
        select.setAttribute('data-old', oldValue);

        const labels = {
            'ouvert':   { label: 'Ouvert',   bg: '#eff6ff', color: '#1d4ed8', icon: '<svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>', iconBg: '#dbeafe' },
            'en_cours': { label: 'En cours', bg: '#fffbeb', color: '#b45309', icon: '<svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>', iconBg: '#fef3c7' },
            'ferme':    { label: 'Fermé',    bg: '#f0fdf4', color: '#15803d', icon: '<svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>', iconBg: '#dcfce7' },
        };

        const info = labels[newStatus] || { label: newStatus, bg: '#f8fafc', color: '#475569', icon: '<svg class="w-6 h-6 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>', iconBg: '#f1f5f9' };

        document.getElementById('confirm-icon').innerHTML = info.icon;
        document.getElementById('confirm-icon').style.background = info.iconBg;
        document.getElementById('confirm-message').textContent = `Voulez-vous changer le statut vers :`;

        const preview = document.getElementById('confirm-status-preview');
        preview.textContent = info.label;
        preview.style.background = info.bg;
        preview.style.color = info.color;
        preview.style.borderColor = info.color + '33';

        pendingStatusChange = { dossierId, newStatus, oldValue, select };
        document.getElementById('modal-confirm-status').classList.remove('hidden');
    }

    function cancelStatusChange() {
        if (pendingStatusChange) {
            pendingStatusChange.select.value = pendingStatusChange.oldValue;
        }
        pendingStatusChange = null;
        document.getElementById('modal-confirm-status').classList.add('hidden');
    }

    function confirmStatusChange() {
        if (!pendingStatusChange) return;

        const { dossierId, newStatus, oldValue, select } = pendingStatusChange;
        document.getElementById('modal-confirm-status').classList.add('hidden');
        pendingStatusChange = null;

        select.disabled = true;

        fetch(`/dossiers/${dossierId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showFlashMessage(data.message || 'Statut mis à jour avec succès !', 'success');
                updateSelectColor(select, newStatus);
                select.setAttribute('data-old', newStatus);
            } else {
                showFlashMessage(data.message || 'Erreur lors de la mise à jour', 'error');
                select.value = oldValue;
            }
            select.disabled = false;
        })
        .catch(error => {
            console.error('Error:', error);
            showFlashMessage('Erreur lors de la mise à jour du statut', 'error');
            select.value = oldValue;
            select.disabled = false;
        });
    }

    function updateSelectColor(select, status) {
        select.classList.remove('bg-blue-100', 'text-blue-700', 'bg-amber-100', 'text-amber-700', 'bg-green-100', 'text-green-700');
        if (status === 'ouvert') select.classList.add('bg-blue-100', 'text-blue-700');
        else if (status === 'en_cours') select.classList.add('bg-amber-100', 'text-amber-700');
        else if (status === 'ferme') select.classList.add('bg-green-100', 'text-green-700');
    }

    function showFlashMessage(message, type = 'success') {
        const existingFlash = document.querySelector('.custom-flash-message');
        if (existingFlash) existingFlash.remove();

        const isSuccess = type === 'success';

        const flashDiv = document.createElement('div');
        flashDiv.className = 'custom-flash-message fixed top-6 right-6 z-[9999] flex items-center gap-3 px-5 py-4 rounded-2xl shadow-xl border';
        flashDiv.style.cssText = `
            background: ${isSuccess ? '#f0fdf4' : '#fef2f2'};
            border-color: ${isSuccess ? '#bbf7d0' : '#fecaca'};
            min-width: 300px; max-width: 420px;
            transform: translateX(120%); opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
        `;

        flashDiv.innerHTML = `
            <div style="width:36px;height:36px;border-radius:10px;flex-shrink:0;display:flex;align-items:center;justify-content:center;background:${isSuccess ? '#dcfce7' : '#fee2e2'};color:${isSuccess ? '#15803d' : '#dc2626'};">
                ${isSuccess ? '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>' : '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>'}
            </div>
            <div style="flex:1;">
                <p style="font-weight:800;font-size:13px;color:${isSuccess ? '#15803d' : '#dc2626'};margin:0;">
                    ${isSuccess ? 'Succès' : 'Erreur'}
                </p>
                <p style="font-size:12px;color:${isSuccess ? '#16a34a' : '#ef4444'};margin:0;margin-top:2px;">
                    ${message}
                </p>
            </div>
            <button onclick="this.parentElement.remove()" style="color:${isSuccess ? '#86efac' : '#fca5a5'};background:none;border:none;cursor:pointer;font-size:16px;padding:0;">✕</button>
        `;

        document.body.appendChild(flashDiv);
        requestAnimationFrame(() => {
            flashDiv.style.transform = 'translateX(0)';
            flashDiv.style.opacity = '1';
        });

        setTimeout(() => {
            flashDiv.style.transform = 'translateX(120%)';
            flashDiv.style.opacity = '0';
            setTimeout(() => flashDiv.remove(), 300);
        }, 3000);
    }

    // Fermer modal assign en cliquant dehors
    window.onclick = function(event) {
        const modal = document.getElementById('modal-assign');
        if (event.target == modal) modal.classList.add('hidden');

        const confirmModal = document.getElementById('modal-confirm-status');
        if (event.target == confirmModal) cancelStatusChange();
    }
</script>

</x-app-layout>