<x-app-layout>
    <div class="p-6 md:p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

        {{-- ═══════════ TOP BAR ═══════════ --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Tableau de Pointage</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Suivi des présences, retards et absences de l'équipe.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('pointages.index') }}"
                    class="flex items-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 px-4 py-2.5 rounded-xl font-bold text-sm transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </a>
                <button onclick="openSettingsModal()"
                    class="flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    Paramètres
                </button>
            </div>
        </div>

        <x-status-messages />

        {{-- ═══════════ KPI STATS ═══════════ --}}
        @php
            $total = $stats['total'] ?? 0;
            $presents = $stats['presents'] ?? 0;
            $retards = $stats['retards'] ?? 0;
            $absents = $stats['absents'] ?? 0;
            $withJustif = $stats['withJustif'] ?? 0;
        @endphp
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-slate-100 text-slate-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Total</p>
                    <p class="text-2xl font-extrabold text-slate-800">{{ $total }}</p>
                </div>
            </div>
            <div
                class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4 border-l-4 border-l-emerald-400">
                <span class="p-2.5 rounded-xl bg-emerald-50 text-emerald-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Présents</p>
                    <p class="text-2xl font-extrabold text-emerald-500">{{ $presents }}</p>
                </div>
            </div>
            <div
                class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4 border-l-4 border-l-amber-400">
                <span class="p-2.5 rounded-xl bg-amber-50 text-amber-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Retards</p>
                    <p class="text-2xl font-extrabold text-amber-500">{{ $retards }}</p>
                </div>
            </div>
            <div
                class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4 border-l-4 border-l-[#b11d40]">
                <span class="p-2.5 rounded-xl bg-red-50 text-[#b11d40] shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Absents</p>
                    <p class="text-2xl font-extrabold text-[#b11d40]">{{ $absents }}</p>
                </div>
            </div>
            <div
                class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4 border-l-4 border-l-indigo-400">
                <span class="p-2.5 rounded-xl bg-indigo-50 text-indigo-500 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Justifiés</p>
                    <p class="text-2xl font-extrabold text-indigo-500">{{ $withJustif }}</p>
                </div>
            </div>
        </div>

        {{-- ═══════════ FILTER BAR ═══════════ --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4 mb-6">
            <form id="filterForm" action="{{ route('admin.pointages.index') ?? url()->current() }}" method="GET"
                class="flex flex-wrap items-center gap-4" onsubmit="event.preventDefault()">
                {{-- Global Search --}}
                <div class="flex-1 min-w-[280px] relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                        placeholder="Rechercher un employé..."
                        class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-2xl text-sm transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 outline-none">
                </div>

                {{-- Filters --}}
                <div class="flex flex-wrap items-center gap-3">
                    <div class="relative">
                        <select name="status"
                            class="filter-select appearance-none bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 text-xs font-bold text-slate-600 outline-none focus:border-[#be2346] transition-all cursor-pointer">
                            <option value="">Tous les statuts</option>
                            <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Présent
                            </option>
                            <option value="retard" {{ request('status') == 'retard' ? 'selected' : '' }}>Retard</option>
                            <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>

                    <div class="relative">
                        <select name="role"
                            class="filter-select appearance-none bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 text-xs font-bold text-slate-600 outline-none focus:border-[#be2346] transition-all cursor-pointer">
                            <option value="">Tous les rôles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="employee" {{ request('role') == 'employee' ? 'selected' : '' }}>Employé
                            </option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>

                    <div class="relative">
                        <select name="departement"
                            class="filter-select appearance-none bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 text-xs font-bold text-slate-600 outline-none focus:border-[#be2346] transition-all cursor-pointer">
                            <option value="">Tous les départements</option>
                            @foreach(\App\Models\Departement::orderBy('title')->get() as $dept)
                                <option value="{{ $dept->title }}" {{ request('departement') == $dept->title ? 'selected' : '' }}>{{ $dept->title }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>

                    <button type="button" id="resetFilters"
                        class="p-3 rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-all flex items-center justify-center"
                        title="Réinitialiser les filtres">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        {{-- ═══════════ MAIN TABLE ═══════════ --}}
        <div id="tableContainer"
            class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden transition-opacity duration-300 relative">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

            <div class="px-7 pt-6 pb-2 flex items-center justify-between border-b border-slate-50 bg-slate-50/30">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Historique de Pointage (Équipe)</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Suivi en temps réel
                        des Entrées/Sorties</p>
                </div>
                <div class="flex items-center gap-2">
                    <span
                        class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-white border border-slate-200 text-[10px] font-bold text-slate-500 shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Actifs
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600" id="pointage-table">
                    <thead
                        class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-extrabold text-slate-400 tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Employé</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Entrée</th>
                            <th class="px-6 py-4">Sortie</th>
                            <th class="px-6 py-4">Durée</th>
                            <th class="px-6 py-4">GPS</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4">Justification</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100" id="pointage-tbody">
                        @forelse($pointages as $pointage)
                            @php
                                $user = $pointage->user;
                                $empName = $user ? trim(($user->firstName ?? '') . ' ' . ($user->lastName ?? '')) : 'Employé inconnu';
                                $initial = $user ? strtoupper(substr($user->firstName ?? 'E', 0, 1)) : 'E';

                                // Calculate duration
                                $duree = '0h 0min';
                                if ($pointage->heureEntree && $pointage->heureSortie) {
                                    $entry = \Carbon\Carbon::parse($pointage->heureEntree);
                                    $exit = \Carbon\Carbon::parse($pointage->heureSortie);
                                    $mins = $entry->diffInMinutes($exit);
                                    $duree = intdiv($mins, 60) . 'h ' . ($mins % 60) . 'min';
                                }

                                // Calculate delay
                                $delayIn = null;
                                $delayOut = null;
                                if ($pointage->heureEntree && isset($settings->companyEntryTime)) {
                                    $entry = \Carbon\Carbon::parse($pointage->heureEntree);
                                    $officialIn = \Carbon\Carbon::parse($settings->companyEntryTime);
                                    if ($entry->gt($officialIn)) {
                                        $diff = $officialIn->diffInMinutes($entry);
                                        if ($diff > 0)
                                            $delayIn = "+ " . $diff . " min";
                                    }
                                }
                                if ($pointage->heureSortie && isset($settings->companyExitTime)) {
                                    $exit = \Carbon\Carbon::parse($pointage->heureSortie);
                                    $officialOut = \Carbon\Carbon::parse($settings->companyExitTime);
                                    if ($exit->lt($officialOut)) {
                                        $diff = $exit->diffInMinutes($officialOut);
                                        if ($diff > 0)
                                            $delayOut = "- " . $diff . " min";
                                    }
                                }
                            @endphp
                            <tr class="hover:bg-slate-50 transition-colors pointage-row"
                                data-name="{{ strtolower($empName) }}"
                                data-role="{{ strtolower($user->type ?? 'employee') }}" data-date="{{ $pointage->date }}"
                                data-status="{{ $pointage->status }}"
                                data-dept="{{ strtolower($user->departement->title ?? '') }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gradient-to-br from-[#7c1233] to-[#be2346] flex items-center justify-center text-white font-black text-xs shrink-0">
                                            {{ $initial }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 text-sm leading-tight">{{ $empName }}</p>
                                            @if($user)
                                                <div class="flex items-center gap-2 mt-0.5">
                                                    <p class="text-[10px] text-slate-400 font-medium">{{ $user->email ?? '' }}
                                                    </p>
                                                    <span
                                                        class="text-[8px] px-1.5 py-0.5 rounded font-black uppercase tracking-tighter border
                                                    {{ ($user->type ?? '') === 'admin' ? 'bg-red-50 text-[#be2346] border-red-100' : (($user->type ?? '') === 'manager' ? 'bg-indigo-50 text-indigo-500 border-indigo-100' : 'bg-slate-50 text-slate-500 border-slate-100') }}">
                                                        {{ $user->type ?? 'User' }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-700">
                                    {{ $pointage->date ? \Carbon\Carbon::parse($pointage->date)->translatedFormat('d M Y') : '--' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        @if($pointage->heureEntree)
                                            <span
                                                class="font-mono text-xs bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-lg font-bold w-fit">
                                                {{ \Carbon\Carbon::parse($pointage->heureEntree)->format('H:i') }}
                                            </span>
                                        @else
                                            <span
                                                class="text-[10px] bg-slate-50 text-slate-400 px-2 py-1 rounded font-bold w-fit border border-slate-100 uppercase">Non
                                                pointé</span>
                                        @endif
                                        @if($delayIn)
                                            <span
                                                class="text-[9px] font-black text-amber-500 mt-1 ml-1 uppercase tracking-tighter">{{ $delayIn }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        @if($pointage->heureSortie)
                                            <span
                                                class="font-mono text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg font-bold w-fit">
                                                {{ \Carbon\Carbon::parse($pointage->heureSortie)->format('H:i') }}
                                            </span>
                                        @else
                                            <span
                                                class="text-[10px] bg-slate-50 text-slate-400 px-2 py-1 rounded font-bold w-fit border border-slate-100 uppercase">Non
                                                pointé</span>
                                        @endif
                                        @if($delayOut)
                                            <span
                                                class="text-[9px] font-black text-[#be2346] mt-1 ml-1 uppercase tracking-tighter">Anticipé:
                                                {{ $delayOut }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-500 font-medium text-xs">{{ $duree }}</td>
                                <td class="px-6 py-4 text-xs text-slate-400 font-mono">
                                    @if($pointage->gps)
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $pointage->gps }}"
                                            target="_blank"
                                            class="flex items-center gap-1.5 hover:text-[#be2346] transition-colors group">
                                            <svg class="w-3 h-3 text-slate-300 group-hover:text-[#be2346]" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span>{{ substr($pointage->gps, 0, 12) }}...</span>
                                        </a>
                                    @else
                                        <span class="text-slate-300 text-[10px] uppercase font-bold italic">Non localisé</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($pointage->status === 'present')
                                        <span
                                            class="bg-emerald-50 text-emerald-600 font-bold px-3 py-1 rounded-full text-xs border border-emerald-200">Présent</span>
                                    @elseif($pointage->status === 'retard')
                                        <span
                                            class="bg-amber-50 text-amber-600 font-bold px-3 py-1 rounded-full text-xs border border-amber-200">Retard</span>
                                    @else
                                        <span
                                            class="bg-red-50 text-[#b11d40] font-bold px-3 py-1 rounded-full text-xs border border-red-200">Absent</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 max-w-xs">
                                    @if($pointage->justification)
                                        <button type="button" onclick="openAdminJustificationModal(this)"
                                            data-id="{{ $pointage->idPointage }}"
                                            data-justification="{{ $pointage->justification }}"
                                            data-type="{{ $pointage->typejustif }}"
                                            data-status="{{ $pointage->justification_status }}"
                                            data-file="{{ $pointage->fichier ? Storage::url($pointage->fichier) : '' }}"
                                            data-refus="{{ $pointage->motif_refus }}"
                                            class="relative inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-slate-600 hover:bg-[#be2346] hover:text-white hover:border-[#be2346] transition-all group shadow-sm">
                                            <svg class="w-4 h-4 text-slate-400 group-hover:text-white/80" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Voir Justification
                                            @if($pointage->justification_status === 'en_attente')
                                                <span class="absolute -top-1 -right-1 flex h-2.5 w-2.5">
                                                    <span
                                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
                                                </span>
                                            @endif
                                        </button>
                                    @else
                                        <span class="text-slate-300 text-xs italic">Aucune Justification</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-20 text-center text-slate-400 font-medium">
                                    Aucun enregistrement de pointage trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($pointages, 'links') && $pointages->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-white">
                    {{ $pointages->links('vendor.pagination.tailwind_saas') }}
                </div>
            @endif
        </div>
    </div>

    {{-- ═══════════ SETTINGS MODAL ═══════════ --}}
    <div id="settingsModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeSettingsModal()"></div>
        <div class="relative bg-white w-full max-w-lg rounded-[32px] shadow-2xl overflow-hidden flex flex-col z-10"
            style="animation: modalIn .2s ease-out">

            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Paramètres de l'Entreprise</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Configuration ·
                        Access Morocco</p>
                </div>
                <button type="button" onclick="closeSettingsModal()"
                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] hover:border-[#be2346]/30 transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" class="p-7 space-y-5">
                @csrf
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">GPS de
                        l'entreprise</label>
                    <input type="text" name="companyGps" placeholder="Ex: 32.9348,-6.0234"
                        value="{{ $settings->companyGps ?? '' }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 font-mono">
                    <p class="text-[10px] text-slate-400 ml-1">Format: latitude,longitude</p>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div class="space-y-1.5">
                        <label
                            class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Entrée</label>
                        <input type="time" name="companyEntryTime" value="{{ $settings->companyEntryTime ?? '' }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-3 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                    </div>
                    <div class="space-y-1.5">
                        <label
                            class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Sortie</label>
                        <input type="time" name="companyExitTime" value="{{ $settings->companyExitTime ?? '' }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-3 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                    </div>
                    <div class="space-y-1.5">
                        <label
                            class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Absence</label>
                        <input type="time" name="absenceTime" value="{{ $settings->absenceTime ?? '' }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-3 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Distance
                            maximale (m)</label>
                        <input type="number" name="distance" placeholder="Ex: 200" min="10" max="5000"
                            value="{{ $settings->distance ?? '' }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Délai de
                            grâce (min)</label>
                        <input type="number" name="maxDelay" placeholder="Ex: 15" min="0" max="120"
                            value="{{ $settings->maxDelay ?? '' }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                    </div>
                </div>
                <p class="text-[10px] text-slate-400 ml-1">Rayon autorisé (mètres) et marge de retard autorisée
                    (minutes).</p>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeSettingsModal()"
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

    {{-- ═══════════ REFUSAL MODAL ═══════════ --}}
    <div id="adminRefuseModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeAdminRefuseModal()"></div>
        <div class="relative bg-white w-full max-w-md rounded-[32px] shadow-2xl overflow-hidden flex flex-col z-10"
            style="animation: modalIn .2s ease-out">
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Refuser la justification</h2>
                </div>
                <button type="button" onclick="closeAdminRefuseModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="adminRefuseForm" method="POST" class="p-7 space-y-5">
                @csrf
                <input type="hidden" name="action" value="refuse">

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Motif du refus
                        <span class="text-[#be2346]">*</span></label>
                    <textarea name="motif_refus" rows="3" required
                        placeholder="Ex: Document illisible, motif non valable..."
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 max-length-500"></textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeAdminRefuseModal()"
                        class="flex-1 py-3 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50">
                        Annuler
                    </button>
                    <button type="submit"
                        class="flex-1 py-3 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] active:scale-95 font-extrabold text-white">
                        Confirmer le Refus
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ═══════════ JUSTIFICATION DETAIL MODAL ═══════════ --}}
    <div id="adminJustificationModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeAdminJustificationModal()"></div>
        <div class="relative bg-white w-full max-w-lg rounded-[32px] shadow-2xl overflow-hidden flex flex-col z-10"
            style="animation: modalIn .2s ease-out">
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Détails de la Justification</h2>
                    <div class="mt-1" id="modalJStatusBadge"></div>
                </div>
                <button type="button" onclick="closeAdminJustificationModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-7 space-y-6">
                {{-- Type --}}
                <div>
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1 block">Type
                        de Justification</label>
                    <div class="inline-block text-xs font-bold text-indigo-500 bg-indigo-50 border border-indigo-200 px-3 py-1.5 rounded-full uppercase tracking-wider"
                        id="modalJType"></div>
                </div>

                {{-- Text --}}
                <div>
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1 block">Motif
                        (Explication)</label>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 text-sm text-slate-700 font-medium"
                        id="modalJText"></div>
                </div>

                {{-- Fichier --}}
                <div id="modalJFileContainer" class="hidden">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1 block">Pièce
                        jointe</label>
                    <a id="modalJFile" href="#" target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-[#be2346] hover:bg-[#be2346]/5 hover:border-[#be2346]/20 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        Télécharger / Voir le fichier
                    </a>
                </div>

                {{-- Refus Reason --}}
                <div id="modalJRefusContainer" class="hidden">
                    <label class="text-[10px] font-black uppercase text-red-400 tracking-widest ml-1 mb-1 block">Motif
                        du refus</label>
                    <div class="bg-red-50 border border-red-100 rounded-2xl p-4 text-sm text-red-700 font-medium"
                        id="modalJRefus"></div>
                </div>

                {{-- Actions (if pending) --}}
                <div id="modalJActions" class="hidden pt-4 border-t border-slate-100 gap-3 flex">
                    <button type="button" id="modalJBtnRefuser"
                        class="flex-1 py-3 rounded-2xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition-all">Refuser</button>
                    <form id="modalJFormAccepter" method="POST" class="flex-1 m-0">
                        @csrf
                        <input type="hidden" name="action" value="accepte">
                        <button type="submit"
                            class="w-full py-3 rounded-2xl bg-emerald-500 hover:bg-emerald-600 active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-emerald-500/20">
                            Accepter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(8px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
    </style>

    <script>
        function openSettingsModal() {
            const modal = document.getElementById('settingsModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        function closeSettingsModal() {
            const modal = document.getElementById('settingsModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                closeSettingsModal();
                if (typeof closeAdminRefuseModal === 'function') closeAdminRefuseModal();
                if (typeof closeAdminJustificationModal === 'function') closeAdminJustificationModal();
            }
        });

        function openAdminJustificationModal(btn) {
            const id = btn.dataset.id;
            const justification = btn.dataset.justification;
            const type = btn.dataset.type;
            const status = btn.dataset.status;
            const file = btn.dataset.file;
            const refus = btn.dataset.refus;

            // Fill data
            document.getElementById('modalJType').innerText = type || 'Autre';
            document.getElementById('modalJText').innerText = justification || 'Aucun détail fourni.';

            // Status Badge
            const badgeContainer = document.getElementById('modalJStatusBadge');
            if (status === 'en_attente') {
                badgeContainer.innerHTML = '<span class="bg-amber-100 text-amber-700 text-[9px] font-black px-2 py-0.5 rounded uppercase">En attente</span>';
            } else if (status === 'accepte') {
                badgeContainer.innerHTML = '<span class="bg-emerald-100 text-emerald-700 text-[9px] font-black px-2 py-0.5 rounded uppercase">Acceptée</span>';
            } else if (status === 'refuse') {
                badgeContainer.innerHTML = '<span class="bg-red-100 text-red-700 text-[9px] font-black px-2 py-0.5 rounded uppercase">Refusée</span>';
            }

            // File
            const fileContainer = document.getElementById('modalJFileContainer');
            const fileLink = document.getElementById('modalJFile');
            if (file) {
                fileLink.href = file;
                fileContainer.classList.remove('hidden');
            } else {
                fileContainer.classList.add('hidden');
            }

            // Refus Reason
            const refusContainer = document.getElementById('modalJRefusContainer');
            if (status === 'refuse' && refus) {
                document.getElementById('modalJRefus').innerText = refus;
                refusContainer.classList.remove('hidden');
            } else {
                refusContainer.classList.add('hidden');
            }

            // Actions
            const actionsContainer = document.getElementById('modalJActions');
            if (status === 'en_attente') {
                actionsContainer.classList.remove('hidden');

                // Setup Accept Form Action
                const acceptForm = document.getElementById('modalJFormAccepter');
                acceptForm.action = `/admin/pointages/${id}/validate`;

                // Setup Refuse Button
                const refuseBtn = document.getElementById('modalJBtnRefuser');
                refuseBtn.onclick = function () {
                    closeAdminJustificationModal();
                    openAdminRefuseModal(id);
                };
            } else {
                actionsContainer.classList.add('hidden');
            }

            const modal = document.getElementById('adminJustificationModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeAdminJustificationModal() {
            const modal = document.getElementById('adminJustificationModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function openAdminRefuseModal(idPointage) {
            const form = document.getElementById('adminRefuseForm');
            form.action = `/admin/pointages/${idPointage}/validate`;
            const modal = document.getElementById('adminRefuseModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeAdminRefuseModal() {
            const modal = document.getElementById('adminRefuseModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // --- AJAX DOM Replacement Logic ---
        const filterForm = document.getElementById('filterForm');
        let searchTimeout = null;

        function fetchTableData() {
            const url = new URL(filterForm.action);
            const params = new URLSearchParams(new FormData(filterForm));
            url.search = params.toString();

            const tableContainer = document.getElementById('tableContainer');
            if (tableContainer) tableContainer.style.opacity = '0.5';

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newTable = doc.getElementById('tableContainer');
                    if (newTable && tableContainer) {
                        tableContainer.innerHTML = newTable.innerHTML;
                    }
                    window.history.pushState({}, '', url);
                })
                .catch(err => console.error(err))
                .finally(() => {
                    if (tableContainer) tableContainer.style.opacity = '1';
                });
        }

        if (filterForm) {
            // Debounce search input
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', () => {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(fetchTableData, 300);
                });
            }

            // Dropdowns
            document.querySelectorAll('.filter-select').forEach(select => {
                select.addEventListener('change', fetchTableData);
            });

            // Reset button
            const resetBtn = document.getElementById('resetFilters');
            if (resetBtn) {
                resetBtn.addEventListener('click', () => {
                    filterForm.reset();
                    fetchTableData();
                });
            }
        }

        // AJAX Pagination Clicks
        document.addEventListener('click', function (e) {
            const link = e.target.closest('.pagination a, [rel="next"], [rel="prev"]');
            if (link && document.getElementById('tableContainer').contains(link)) {
                e.preventDefault();
                const url = link.href;

                const tableContainer = document.getElementById('tableContainer');
                tableContainer.style.opacity = '0.5';

                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newTable = doc.getElementById('tableContainer');
                        if (newTable) {
                            tableContainer.innerHTML = newTable.innerHTML;
                            window.scrollTo({ top: tableContainer.offsetTop - 100, behavior: 'smooth' });
                        }
                        window.history.pushState({}, '', url);
                    })
                    .catch(err => console.error(err))
                    .finally(() => {
                        tableContainer.style.opacity = '1';
                    });
            }
        });

    </script>
</x-app-layout>