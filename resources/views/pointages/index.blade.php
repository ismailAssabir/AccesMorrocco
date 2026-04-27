<x-app-layout>
<div class="p-6 md:p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

    {{-- ═══════════ TOP BAR ═══════════ --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">
                {{ $isAdmin ? 'Centre de Contrôle des Présences' : 'Mon Pointage' }}
            </h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">
                {{ $isAdmin ? 'Suivi global des présences et gestion des pointages de l\'équipe.' : 'Enregistrez votre arrivée et votre départ via GPS.' }}
            </p>
        </div>
        <div class="flex items-center gap-3">
            <span id="live-clock" class="text-slate-400 font-mono text-sm bg-white border border-slate-200 px-4 py-2 rounded-xl shadow-sm"></span>
            @if(auth()->user()->type === 'admin')
                <a href="{{ route('admin.pointages.index') }}"
                   class="flex items-center gap-2 bg-slate-800 hover:bg-slate-700 active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md text-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Vue Admin
                </a>
            @endif
        </div>
    </div>

    <x-status-messages />

    {{-- ═══════════ SECTION A: PERSONAL CLOCK-IN/OUT (can_point only) ═══════════ --}}
    @can('can_point')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            {{-- CHECK-IN CARD --}}
            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="h-1.5 w-full bg-gradient-to-r from-emerald-400 to-emerald-600"></div>
                <div class="p-7">
                    <div class="flex items-start justify-between mb-5">
                        <div>
                            <h2 class="text-lg font-black text-slate-800">Enregistrer l'Entrée</h2>
                            <p class="text-xs text-slate-400 font-medium mt-1">Pointage de présence du matin</p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                        </div>
                    </div>
                    <form action="{{ route('pointage.checkin') }}" method="POST" id="checkin-form" class="space-y-4">
                        @csrf
                        <input type="hidden" name="gps" id="gps-checkin">
                        <div class="flex items-center gap-3 bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span id="gps-status-in" class="text-xs text-slate-500 font-medium">Localisation non détectée</span>
                        </div>
                        <button type="button" onclick="getLocationAndSubmit('checkin')"
                            class="w-full py-3.5 rounded-2xl bg-emerald-500 hover:bg-emerald-600 active:scale-95 text-white font-extrabold transition-all shadow-lg shadow-emerald-500/25 text-sm flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            Pointer l'Entrée
                        </button>
                    </form>
                </div>
            </div>

            {{-- CHECK-OUT CARD --}}
            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                <div class="p-7">
                    <div class="flex items-start justify-between mb-5">
                        <div>
                            <h2 class="text-lg font-black text-slate-800">Enregistrer la Sortie</h2>
                            <p class="text-xs text-slate-400 font-medium mt-1">Clôturez votre journée de travail</p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#b11d40]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </div>
                    </div>
                    <form action="{{ route('pointage.checkout') }}" method="POST" id="checkout-form" class="space-y-4">
                        @csrf
                        <input type="hidden" name="gps" id="gps-checkout">
                        <div class="flex items-center gap-3 bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span id="gps-status-out" class="text-xs text-slate-500 font-medium">Localisation non détectée</span>
                        </div>
                        <button type="button" onclick="getLocationAndSubmit('checkout')"
                            class="w-full py-3.5 rounded-2xl bg-[#b11d40] hover:bg-[#911633] active:scale-95 text-white font-extrabold transition-all shadow-lg shadow-[#b11d40]/25 text-sm flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Pointer la Sortie
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endcan

    {{-- ═══════════ SECTION B: KPI STATS (Admin only) ═══════════ --}}
    @if($isAdmin)
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-slate-100 text-slate-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Total (Aujourd'hui)</p>
                    <p class="text-2xl font-extrabold text-slate-800">{{ $totalToday }}</p>
                </div>
            </div>
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4 border-l-4 border-l-emerald-400">
                <span class="p-2.5 rounded-xl bg-emerald-50 text-emerald-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Présents</p>
                    <p class="text-2xl font-extrabold text-emerald-500">{{ $presentsToday }}</p>
                </div>
            </div>
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4 border-l-4 border-l-amber-400">
                <span class="p-2.5 rounded-xl bg-amber-50 text-amber-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Retards</p>
                    <p class="text-2xl font-extrabold text-amber-500">{{ $retardsToday }}</p>
                </div>
            </div>
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4 border-l-4 border-l-[#b11d40]">
                <span class="p-2.5 rounded-xl bg-red-50 text-[#b11d40] shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Absents</p>
                    <p class="text-2xl font-extrabold text-[#b11d40]">{{ $absentsToday }}</p>
                </div>
            </div>
        </div>

        {{-- ═══════════ FILTER BAR (Matching HR Style) ═══════════ --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4 mb-6">
            <form id="filterForm" action="{{ route('pointages.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
                {{-- Global Search --}}
                <div class="flex-1 min-w-[280px] relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" onchange="this.form.submit()" placeholder="Rechercher par nom..." 
                        class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-2xl text-sm transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 outline-none">
                </div>

                {{-- Filters Group --}}
                <div class="flex flex-wrap items-center gap-3">
                    {{-- Status Filter --}}
                    <div class="relative">
                        <select name="status" onchange="this.form.submit()" class="appearance-none bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 text-xs font-bold text-slate-600 outline-none focus:border-[#be2346] transition-all cursor-pointer">
                            <option value="">Statut (Tous)</option>
                            <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Présent</option>
                            <option value="retard" {{ request('status') == 'retard' ? 'selected' : '' }}>Retard</option>
                            <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>

                    {{-- Role Filter --}}
                    <div class="relative">
                        <select name="role" onchange="this.form.submit()" class="appearance-none bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 text-xs font-bold text-slate-600 outline-none focus:border-[#be2346] transition-all cursor-pointer">
                            <option value="">Rôle (Tous)</option>
                            <option value="employee" {{ request('role') == 'employee' ? 'selected' : '' }}>Employé</option>
                            <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>

                    {{-- Department Filter --}}
                    <div class="relative">
                        <select name="departement" onchange="this.form.submit()" class="appearance-none bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 text-xs font-bold text-slate-600 outline-none focus:border-[#be2346] transition-all cursor-pointer">
                            <option value="">Département (Tous)</option>
                            @foreach($departements as $dept)
                                <option value="{{ $dept->idDepartement }}" {{ request('departement') == $dept->idDepartement ? 'selected' : '' }}>{{ $dept->title }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>

                    {{-- Post Filter --}}
                    <div class="relative">
                        <select name="post" onchange="this.form.submit()" class="appearance-none bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 text-xs font-bold text-slate-600 outline-none focus:border-[#be2346] transition-all cursor-pointer">
                            <option value="">Poste (Tous)</option>
                            @foreach($uniquePosts as $p)
                                <option value="{{ $p }}" {{ request('post') == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>

                    {{-- Reset Button --}}
                    <a href="{{ route('pointages.index') }}" class="p-3 rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-all flex items-center justify-center" title="Réinitialiser les filtres">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    </a>
                </div>
            </form>
        </div>
    @endif

    {{-- ═══════════ SECTION C: HISTORY TABLE ═══════════ --}}
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden mb-8">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
        
        <div class="px-7 pt-6 pb-2 flex items-center justify-between border-b border-slate-50 bg-slate-50/30">
            <div>
                <h2 class="text-lg font-black text-slate-800">
                    {{ $isAdmin ? 'Suivi Global (Aujourd\'hui)' : 'Historique de Pointage' }}
                </h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">
                    {{ $isAdmin ? 'Tous les enregistrements de la journée' : 'Vos 15 derniers enregistrements' }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-white border border-slate-200 text-[10px] font-bold text-slate-500 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    {{ $recentPointages->count() }} Records
                </span>
            </div>
        </div>

        @if($recentPointages->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-extrabold text-slate-400 tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Date & {{ $isAdmin ? 'Employé' : 'Rôle' }}</th>
                            <th class="px-6 py-4">Arrivée</th>
                            <th class="px-6 py-4">Départ</th>
                            <th class="px-6 py-4 text-center">Statut</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentPointages as $p)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-4 font-bold text-slate-800 flex flex-col">
                                    <span class="text-[10px] text-slate-400 mb-1">{{ \Carbon\Carbon::parse($p->date)->translatedFormat('d M Y') }}</span>
                                    @if($isAdmin)
                                        <span class="text-[12px] font-black text-slate-800 group-hover:text-[#be2346] transition-colors leading-tight">
                                            {{ $p->user->firstName ?? '' }} {{ $p->user->lastName ?? '' }}
                                        </span>
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">{{ $p->user->post ?? ($p->user->departement->title ?? 'Poste non défini') }}</span>
                                    @else
                                        <span class="text-[11px] font-black uppercase text-slate-600 tracking-widest">{{ auth()->user()->type }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-mono text-xs bg-emerald-50 text-emerald-700 px-2.5 py-1.5 rounded-xl font-black">
                                        {{ $p->heureEntree ? \Carbon\Carbon::parse($p->heureEntree)->format('H:i') : '--:--' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-mono text-xs bg-slate-50 text-slate-500 px-2.5 py-1.5 rounded-xl font-black">
                                        {{ $p->heureSortie ? \Carbon\Carbon::parse($p->heureSortie)->format('H:i') : '--:--' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($p->status === 'present')
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-wider border border-emerald-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Présent
                                        </span>
                                    @elseif($p->status === 'retard')
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 text-[10px] font-black uppercase tracking-wider border border-amber-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Retard
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-red-50 text-[#be2346] text-[10px] font-black uppercase tracking-wider border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#be2346]"></span>Absence
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($isAdmin)
                                        @if($p->justification)
                                            <div class="flex items-center justify-center gap-1.5">
                                                @if($p->justification_status === 'en_attente')
                                                    <button type="button" 
                                                        onclick="openAdminJustifModal({
                                                            id: {{ $p->idPointage }},
                                                            user: '{{ $p->user->firstName }} {{ $p->user->lastName }}',
                                                            type: '{{ $p->typejustif }}',
                                                            motif: '{{ addslashes($p->justification) }}',
                                                            date: '{{ \Carbon\Carbon::parse($p->date)->translatedFormat('d M Y') }}',
                                                            fichier: '{{ $p->fichier }}'
                                                        })"
                                                        class="bg-[#be2346] hover:bg-[#a01d3a] text-white text-[9px] font-black uppercase px-3 py-1.5 rounded-lg transition-all shadow-sm">
                                                        Justification 📥
                                                    </button>
                                                @else
                                                    <span class="text-[9px] font-black uppercase {{ $p->justification_status === 'accepte' ? 'text-emerald-500' : 'text-[#be2346]' }} bg-slate-50 px-2 py-1 rounded-lg border border-slate-100">
                                                        {{ $p->justification_status === 'accepte' ? 'Validé ✓' : 'Refusé ✗' }}
                                                    </span>
                                                @endif
                                            </div>
                                        @elseif($p->status !== 'present')
                                            <span class="text-[10px] font-bold text-amber-500 uppercase italic opacity-70">Attente justification...</span>
                                        @else
                                            <span class="text-slate-300 font-black text-[10px]">--</span>
                                        @endif
                                    @else
                                        @if($p->justification)
                                            <div class="flex items-center justify-center gap-1.5">
                                                <span class="text-[9px] font-black uppercase {{ $p->justification_status === 'accepte' ? 'text-emerald-500' : ($p->justification_status === 'refuse' ? 'text-[#be2346]' : 'text-amber-500') }} bg-slate-50 px-2 py-1 rounded-lg border border-slate-100">
                                                    {{ $p->justification_status === 'en_attente' ? 'En attente' : ($p->justification_status === 'accepte' ? 'Validé' : 'Refusé') }}
                                                </span>
                                                @if($p->justification_status === 'refuse')
                                                    <button type="button" onclick="openRefusalReasonModal('{{ addslashes($p->motif_refus) }}')" class="p-1.5 rounded-lg bg-red-50 text-[#be2346] hover:bg-red-100 transition-all" title="Voir le motif du refus">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    </button>
                                                @endif
                                            </div>
                                        @elseif($p->status !== 'present')
                                            <button onclick="openJustifModal({{ $p->idPointage }})" class="text-[10px] font-black text-[#be2346] hover:bg-[#be2346] hover:text-white border border-[#be2346] px-3 py-1 rounded-lg transition-all uppercase tracking-widest">Justifier</button>
                                        @else
                                            <span class="text-slate-300 font-black text-[10px]">--</span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(method_exists($recentPointages, 'links') && $recentPointages->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-white">
                    {{ $recentPointages->links('vendor.pagination.tailwind_saas') }}
                </div>
            @endif
        @else
            <div class="py-20 text-center flex flex-col items-center gap-3">
                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center border border-slate-100">
                    <svg class="w-8 h-8 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                </div>
                <p class="text-slate-400 font-bold text-sm">Aucun historique trouvé pour aujourd'hui.</p>
            </div>
        @endif
    </div>
</div>

{{-- MODALS --}}
<div id="justifModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeJustifModal()"></div>
    <div class="relative bg-white w-full max-w-lg rounded-[32px] shadow-2xl overflow-hidden flex flex-col z-10" style="animation: modalIn .2s ease-out">
        <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
            <div>
                <h2 class="text-lg font-black text-slate-800">Soumettre une Justification</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Infraction · Access Morocco</p>
            </div>
            <button type="button" onclick="closeJustifModal()" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form action="{{ route('justification.submit') }}" method="POST" enctype="multipart/form-data" class="p-7 space-y-5">
            @csrf <input type="hidden" name="idPointage" id="justif-idPointage">
            <div class="space-y-1.5">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Type de Justification <span class="text-[#be2346]">*</span></label>
                <select name="typejustif" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none appearance-none focus:border-[#be2346]">
                    <option value="">-- Sélectionner --</option>
                    <option value="medical">Médical</option><option value="familial">Familial</option><option value="transport">Transport</option><option value="administratif">Administratif</option><option value="autre">Autre</option>
                </select>
            </div>
            <div class="space-y-1.5">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Motif <span class="text-[#be2346]">*</span></label>
                <textarea name="justification" rows="4" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#be2346]"></textarea>
            </div>
            <input type="file" name="fichier" class="text-xs">
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeJustifModal()" class="flex-1 py-3.5 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 transition-all text-sm">Annuler</button>
                <button type="submit" class="flex-1 py-3.5 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] font-extrabold text-white transition-all shadow-lg shadow-[#be2346]/20 text-sm">Envoyer</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal pour voir le motif du refus (Manager/Employee) --}}
<div id="refusalReasonModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeRefusalReasonModal()"></div>
    <div class="relative bg-white w-full max-w-md rounded-[32px] shadow-2xl overflow-hidden flex flex-col z-10" style="animation: modalIn .2s ease-out">
        <div class="px-7 py-5 border-b border-slate-100 bg-red-50/50 flex items-center justify-between shrink-0">
            <div>
                <h2 class="text-lg font-black text-slate-800">Justification Refusée</h2>
                <p class="text-[10px] text-red-400 font-bold uppercase tracking-widest mt-0.5">Motif du refus · Administration</p>
            </div>
            <button type="button" onclick="closeRefusalReasonModal()" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-7">
            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 border-l-4 border-l-[#be2346]">
                <p id="refusal-reason-text" class="text-sm text-slate-600 leading-relaxed italic"></p>
            </div>
            <button type="button" onclick="closeRefusalReasonModal()" class="w-full mt-6 py-3 rounded-2xl bg-slate-800 text-white font-extrabold text-sm transition-all active:scale-95">Compris</button>
        </div>
    </div>
</div>

@if($isAdmin)
    {{-- Admin View Justification Modal --}}
    <div id="adminJustifModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeAdminJustifModal()"></div>
        <div class="relative bg-white w-full max-w-lg rounded-[32px] shadow-2xl overflow-hidden flex flex-col z-10" style="animation: modalIn .2s ease-out">
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Détails de la Justification</h2>
                    <p id="aj-user-date" class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5"></p>
                </div>
                <button type="button" onclick="closeAdminJustifModal()" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-7 space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Type</span>
                        <p id="aj-type" class="text-sm font-bold text-slate-800 bg-slate-50 px-3 py-2 rounded-xl border border-slate-100"></p>
                    </div>
                    <div id="aj-file-container" class="space-y-1 hidden">
                        <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Pièce jointe</span>
                        <a id="aj-file-link" href="#" target="_blank" class="flex items-center gap-2 text-xs font-bold text-[#be2346] bg-red-50 px-3 py-2 rounded-xl border border-red-100 hover:bg-red-100 transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2"/></svg>
                            Voir le fichier
                        </a>
                    </div>
                </div>
                <div class="space-y-1">
                    <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Motif de l'employé</span>
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <p id="aj-motif" class="text-sm text-slate-600 leading-relaxed"></p>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <form id="aj-accept-form" method="POST" class="flex-1">
                        @csrf <input type="hidden" name="action" value="accepte">
                        <button type="submit" class="w-full py-3.5 rounded-2xl bg-emerald-500 hover:bg-emerald-600 font-extrabold text-white transition-all shadow-lg shadow-emerald-500/20 text-sm">Accepter ✓</button>
                    </form>
                    <button type="button" onclick="triggerAdminRefuse()" class="flex-1 py-3.5 rounded-2xl bg-slate-800 hover:bg-black font-extrabold text-white transition-all text-sm">Refuser ✗</button>
                </div>
            </div>
        </div>
    </div>

    <div id="adminRefuseModal" class="fixed inset-0 z-[120] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeAdminRefuseModal()"></div>
        <div class="relative bg-white w-full max-w-md rounded-[32px] shadow-2xl overflow-hidden flex flex-col z-10" style="animation: modalIn .2s ease-out">
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                <h2 class="text-lg font-black text-slate-800">Refuser la justification</h2>
                <button type="button" onclick="closeAdminRefuseModal()" class="w-8 h-8 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346]"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <form id="adminRefuseForm" method="POST" class="p-7 space-y-5">
                @csrf <input type="hidden" name="action" value="refuse">
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Motif du refus <span class="text-[#be2346]">*</span></label>
                    <textarea name="motif_refus" rows="3" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#be2346]"></textarea>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeAdminRefuseModal()" class="flex-1 py-3 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50">Annuler</button>
                    <button type="submit" class="flex-1 py-3 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] font-extrabold text-white transition-all shadow-lg shadow-[#be2346]/20">Confirmer</button>
                </div>
            </form>
        </div>
    </div>
@endif

<style>
    @keyframes modalIn { from { opacity: 0; transform: scale(0.95) translateY(8px); } to { opacity: 1; transform: scale(1) translateY(0); } }
</style>

<script>
    let currentAdminJustifId = null;

    function updateClock() {
        const now = new Date();
        const el = document.getElementById('live-clock');
        if (el) el.textContent = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    setInterval(updateClock, 1000); updateClock();

    async function getLocationAndSubmit(action) {
        const statusEl = document.getElementById(action === 'checkin' ? 'gps-status-in' : 'gps-status-out');
        const btn = event.currentTarget;
        statusEl.innerHTML = '<span class="animate-pulse text-blue-500 font-bold">📡 Localisation...</span>';
        btn.disabled = true;
        
        if (!navigator.geolocation) { alert('GPS non supporté'); btn.disabled = false; return; }

        navigator.geolocation.getCurrentPosition(async (pos) => {
            const gps = `${pos.coords.latitude},${pos.coords.longitude}`;
            statusEl.textContent = '✅ Position détectée';
            try {
                const res = await fetch(action === 'checkin' ? '{{ route("pointage.checkin") }}' : '{{ route("pointage.checkout") }}', {
                    method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: JSON.stringify({ gps: gps })
                });
                const data = await res.json();
                if (data.success) { window.location.reload(); }
                else { alert(data.message); btn.disabled = false; }
            } catch (e) { alert('Erreur serveur'); btn.disabled = false; }
        }, () => { alert('Activez le GPS'); btn.disabled = false; }, { enableHighAccuracy: true });
    }

    function openJustifModal(id) { document.getElementById('justif-idPointage').value = id; const m = document.getElementById('justifModal'); m.classList.remove('hidden'); m.classList.add('flex'); }
    function closeJustifModal() { const m = document.getElementById('justifModal'); m.classList.add('hidden'); m.classList.remove('flex'); }
    
    function openRefusalReasonModal(reason) {
        document.getElementById('refusal-reason-text').textContent = reason || "Aucun motif spécifié.";
        const m = document.getElementById('refusalReasonModal');
        m.classList.remove('hidden'); m.classList.add('flex');
    }
    function closeRefusalReasonModal() { const m = document.getElementById('refusalReasonModal'); m.classList.add('hidden'); m.classList.remove('flex'); }

    @if($isAdmin)
        function openAdminJustifModal(data) {
            currentAdminJustifId = data.id;
            document.getElementById('aj-user-date').textContent = `${data.user} · ${data.date}`;
            document.getElementById('aj-type').textContent = data.type.toUpperCase();
            document.getElementById('aj-motif').textContent = data.motif;
            document.getElementById('aj-accept-form').action = `/admin/pointages/${data.id}/validate`;
            
            const fileCont = document.getElementById('aj-file-container');
            if (data.fichier && data.fichier !== 'null') {
                fileCont.classList.remove('hidden');
                document.getElementById('aj-file-link').href = `/storage/${data.fichier}`;
            } else {
                fileCont.classList.add('hidden');
            }

            const m = document.getElementById('adminJustifModal');
            m.classList.remove('hidden'); m.classList.add('flex');
        }

        function closeAdminJustifModal() { const m = document.getElementById('adminJustifModal'); m.classList.add('hidden'); m.classList.remove('flex'); }

        function triggerAdminRefuse() {
            closeAdminJustifModal();
            openAdminRefuseModal(currentAdminJustifId);
        }

        function openAdminRefuseModal(id) { 
            const f = document.getElementById('adminRefuseForm'); 
            f.action = `/admin/pointages/${id}/validate`; 
            const m = document.getElementById('adminRefuseModal'); 
            m.classList.remove('hidden'); m.classList.add('flex'); 
        }
        function closeAdminRefuseModal() { const m = document.getElementById('adminRefuseModal'); m.classList.add('hidden'); m.classList.remove('flex'); }
    @endif
</script>
</x-app-layout>
