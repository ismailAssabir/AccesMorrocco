<x-app-layout>
<div class="p-8 bg-[#F8FAFC] min-h-screen">

    {{-- TOP BAR --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Gestion des Leads</h1>
            <p class="text-slate-500 text-sm">Suivez et gérez tous vos prospects commerciaux.</p>
        </div>
        <div class="flex gap-3">
            @can('lead.view')
            <a href="{{ route('leads.export-pdf', request()->query()) }}"
               class="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Exporter PDF
            </a>
            @endcan

            @can('lead.create')
            <button onclick="document.getElementById('modal-create').classList.remove('hidden')"
                    class="flex items-center gap-2 px-4 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow-md shadow-[#b11d40]/20">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Nouveau Lead
            </button>
            @endcan
        </div>
    </div>

    {{-- FLASH --}}
    @if(session('msg'))
    <div class="mb-6 flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-semibold">
        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('msg') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm font-semibold">
        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- FILTERS --}}
    <form method="GET" action="{{ route('leads.index') }}"
          class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4 mb-6 flex flex-wrap gap-3 items-end">

        <div class="flex-1 min-w-[200px]">
            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Recherche</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Nom, email, téléphone..."
                       class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
            </div>
        </div>

        <div class="min-w-[140px]">
            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Type</label>
            <select name="type"
                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                <option value="">Tous les types</option>
                @foreach($types as $type)
                    <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <div class="min-w-[150px]">
            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Statut</label>
            <select name="statut"
                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                <option value="">Tous les statuts</option>
                <option value="nouveau"    {{ request('statut') === 'nouveau'    ? 'selected' : '' }}>Nouveau</option>
                <option value="1er_appel"  {{ request('statut') === '1er_appel'  ? 'selected' : '' }}>1er Appel</option>
                <option value="2eme_appel" {{ request('statut') === '2eme_appel' ? 'selected' : '' }}>2ème Appel</option>
                <option value="promis"     {{ request('statut') === 'promis'     ? 'selected' : '' }}>Promis</option>
                <option value="ok"         {{ request('statut') === 'ok'         ? 'selected' : '' }}>Converti</option>
                <option value="lost"       {{ request('statut') === 'lost'       ? 'selected' : '' }}>Perdu</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit"
                    class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm">
                Filtrer
            </button>
            @if(request('search') || request('type') || request('statut'))
            <a href="{{ route('leads.index') }}"
               class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                Réinitialiser
            </a>
            @endif
        </div>
    </form>

    {{-- TABLE --}}
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[1000px]">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-5 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Lead</th>
                        <th class="text-left px-5 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Contact</th>
                        <th class="text-left px-5 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Type</th>
                        <th class="text-left px-5 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Statut</th>
                        <th class="text-left px-5 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Source</th>
                        <th class="text-left px-5 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Département</th>
                        <th class="text-left px-5 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Date</th>
                        <th class="text-right px-5 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @php
                    $statutColors = [
                        'nouveau'    => 'bg-slate-100 text-slate-500',
                        '1er_appel'  => 'bg-blue-50 text-blue-600',
                        '2eme_appel' => 'bg-orange-50 text-orange-600',
                        'lost'       => 'bg-red-50 text-red-600',
                        'promis'     => 'bg-yellow-50 text-yellow-700',
                        'ok'         => 'bg-emerald-50 text-emerald-600',
                    ];
                    $statutLabels = [
                        'nouveau'    => 'Nouveau',
                        '1er_appel'  => '1er Appel',
                        '2eme_appel' => '2ème Appel',
                        'lost'       => 'Perdu',
                        'promis'     => 'Promis',
                        'ok'         => 'Converti',
                    ];
                    $avatarColors = ['bg-[#b11d40]','bg-blue-500','bg-emerald-500','bg-amber-500','bg-violet-500'];
                @endphp

                @forelse($leads as $lead)
                <tr class="hover:bg-slate-50/60 transition-colors">

                    {{-- Lead --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl {{ $avatarColors[$loop->index % count($avatarColors)] }} flex items-center justify-center shrink-0">
                                <span class="text-white font-black text-xs">
                                    {{ strtoupper(mb_substr($lead->firstName, 0, 1)) }}{{ strtoupper(mb_substr($lead->lastName, 0, 1)) }}
                                </span>
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-slate-800 text-sm truncate">{{ $lead->firstName }} {{ $lead->lastName }}</p>
                                <p class="text-slate-400 text-xs truncate">{{ $lead->nationalite ?? '—' }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Contact --}}
                    <td class="px-5 py-4">
                        <p class="text-slate-700 text-xs font-medium truncate">{{ $lead->email ?? '—' }}</p>
                        <p class="text-slate-400 text-xs mt-0.5">{{ $lead->phoneNumber ?? '—' }}</p>
                    </td>

                    {{-- Type --}}
                    <td class="px-5 py-4">
                        <span class="px-2.5 py-1 rounded-xl text-xs font-black bg-[#b11d40]/10 text-[#b11d40] uppercase">
                            {{ \Illuminate\Support\Str::limit($lead->type, 12) }}
                        </span>
                    </td>

                    {{-- Statut --}}
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl text-xs font-black {{ $statutColors[$lead->statut] ?? 'bg-slate-100 text-slate-500' }}">
                            @if($lead->statut === 'ok')
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            @elseif($lead->statut === 'lost')
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            @else
                                <span class="w-1.5 h-1.5 rounded-full bg-current inline-block"></span>
                            @endif
                            {{ $statutLabels[$lead->statut] ?? $lead->statut }}
                        </span>
                    </td>

                    {{-- Source --}}
                    <td class="px-5 py-4 text-slate-500 text-xs font-medium">{{ $lead->source ?? '—' }}</td>

                    {{-- Département --}}
                    <td class="px-5 py-4 text-slate-500 text-xs font-medium">{{ $lead->departements->title ?? '—' }}</td>

                    {{-- Date --}}
                    <td class="px-5 py-4 text-slate-400 text-xs">
                        {{ $lead->dateCreation ? \Carbon\Carbon::parse($lead->dateCreation)->format('d/m/Y') : '—' }}
                    </td>

                    {{-- Actions --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-end gap-1">

                            {{-- Voir --}}
                            @can('lead.view')
                            <a href="{{ route('leads.show', $lead->idLead) }}"
                               class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-[#b11d40] hover:bg-[#b11d40]/10 transition-all"
                               title="Voir le détail">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            @endcan

                            {{-- Modifier --}}
                            @can('lead.edit')
                            <a href="{{ route('leads.edit', $lead->idLead) }}"
                               class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all"
                               title="Modifier">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            @endcan

                            {{-- Modifier Statut --}}
                            @can('lead.edit')
                            @if($lead->statut !== 'ok' && $lead->statut !== 'lost')
                            <button onclick="openStatutModal({{ $lead->idLead }}, '{{ $lead->statut }}')"
                                    class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-all"
                                    title="Modifier le statut">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </button>
                            @endif
                            @endcan

                            {{-- Créer dossier --}}
                            @if($lead->statut === 'ok' && $lead->client)
                            @can('dossier.create')
                            <button onclick="openDossierModal({{ $lead->client->idClient }}, {{ $lead->idDepartement ?? 'null' }})"
                                    class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all"
                                    title="Créer un dossier">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                </svg>
                            </button>
                            @endcan
                            @endif

                            {{-- Supprimer --}}
                            @can('lead.delete')
                            <button onclick="confirmDelete('{{ route('leads.destroy', $lead->idLead) }}', 'lead')"
                                    class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all"
                                    title="Supprimer">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                            @endcan

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 rounded-2xl bg-[#b11d40]/10 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-[#b11d40]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <p class="font-extrabold text-slate-700 text-lg">Aucun lead trouvé</p>
                            <p class="text-slate-400 text-sm mt-1">Modifiez vos critères ou ajoutez un nouveau lead.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($leads->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
            <p class="text-xs text-slate-400 font-semibold">
                {{ $leads->firstItem() }}–{{ $leads->lastItem() }} sur {{ $leads->total() }} leads
            </p>
            <div class="flex gap-1">
                @if($leads->onFirstPage())
                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-300 bg-slate-50 cursor-not-allowed">‹</span>
                @else
                    <a href="{{ $leads->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 bg-white border border-slate-200 hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all">‹</a>
                @endif

                @foreach($leads->getUrlRange(1, $leads->lastPage()) as $page => $url)
                    @if($page == $leads->currentPage())
                        <span class="px-3 py-1.5 rounded-lg text-xs font-black text-white bg-[#b11d40]">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 bg-white border border-slate-200 hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all">{{ $page }}</a>
                    @endif
                @endforeach

                @if($leads->hasMorePages())
                    <a href="{{ $leads->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 bg-white border border-slate-200 hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all">›</a>
                @else
                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-300 bg-slate-50 cursor-not-allowed">›</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

{{-- ===== MODAL STATUT ===== --}}
<div id="statutModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeStatutModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
        <div class="p-6">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-extrabold text-slate-800">Modifier le statut</h3>
                    <p class="text-sm text-slate-400 mt-0.5">Mettez à jour l'avancement du lead</p>
                </div>
                <button onclick="closeStatutModal()"
                        class="w-8 h-8 rounded-xl border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-50">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="statutForm" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                {{-- Statut --}}
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Statut *</label>
                    <select name="statut" id="statutSelect" onchange="handleStatutChange(this.value)"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-[#b11d40]/30 focus:border-[#b11d40]">
                        <option value="1er_appel">📞 1er Appel</option>
                        <option value="2eme_appel">📞 2ème Appel</option>
                        <option value="promis">🤝 Promis</option>
                        <option value="lost">❌ Perdu</option>
                        <option value="ok">✅ Converti en client</option>
                    </select>
                </div>

                {{-- Champs appel --}}
                <div id="appelFields" class="space-y-4 hidden">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Durée de l'appel</label>
                        <input type="time" name="duree" step="1"
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-[#b11d40]/30 focus:border-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Contenu de l'appel</label>
                        <textarea name="contentAppel" rows="3"
                                  class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-[#b11d40]/30 focus:border-[#b11d40] resize-none"
                                  placeholder="Résumé de l'appel..."></textarea>
                    </div>
                </div>

                {{-- Département (ok) --}}
                <div id="deptField" class="hidden">
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Département</label>
                    <select name="idDepartement"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-[#b11d40]/30 focus:border-[#b11d40]">
                        <option value="">— Sélectionner —</option>
                        @foreach($departements as $dept)
                            <option value="{{ $dept->idDepartement }}">{{ $dept->title }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Note --}}
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Note</label>
                    <textarea name="note" rows="2"
                              class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-[#b11d40]/30 focus:border-[#b11d40] resize-none"
                              placeholder="Ajouter une note..."></textarea>
                </div>

                {{-- Boutons --}}
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeStatutModal()"
                            class="flex-1 px-4 py-3 rounded-2xl border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 transition-all">
                        Annuler
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-3 rounded-2xl bg-[#b11d40] hover:bg-[#911633] text-white font-bold text-sm transition-all shadow-md shadow-[#b11d40]/20 active:scale-95">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== MODAL CREATE LEAD ===== --}}
@can('lead.create')
<div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233] shrink-0"></div>
        <div class="p-6 pb-0 flex justify-between items-center shrink-0">
            <h2 class="text-lg font-extrabold text-slate-800">Nouveau Lead</h2>
            <button onclick="document.getElementById('modal-create').classList.add('hidden')"
                    class="w-8 h-8 rounded-xl border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-600">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('leads.store') }}" class="flex flex-col overflow-hidden">
            @csrf
            <div class="p-6 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Prénom *</label>
                        <input name="firstName" required placeholder="Prénom"
                               class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Nom *</label>
                        <input name="lastName" required placeholder="Nom"
                               class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Email</label>
                        <input name="email" type="email" placeholder="email@exemple.com"
                               class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Téléphone</label>
                        <input name="phoneNumber" placeholder="+212..."
                               class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">CNE</label>
                        <input name="CNE" placeholder="CNE"
                               class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Nationalité</label>
                        <input name="nationalite" placeholder="Nationalité"
                               class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Adresse</label>
                        <input name="address" placeholder="Adresse"
                               class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Source</label>
                        <input name="source" placeholder="Ex: LinkedIn, Référence..."
                               class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Type *</label>
                        <select name="type_select" required
                                onchange="document.getElementById('other-type-wrapper').classList.toggle('hidden', this.value !== 'autre')"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                            <option value="" disabled selected>Sélectionner un type</option>
                            <option value="particulier">Particulier</option>
                            <option value="famille">Famille</option>
                            <option value="entreprise">Entreprise</option>
                            <option value="groupe">Groupe</option>
                            <option value="autre">Autre</option>
                        </select>
                        <div id="other-type-wrapper" class="hidden mt-2">
                            <input name="type" placeholder="Précisez le type..."
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Note</label>
                        <textarea name="note" rows="2" placeholder="Notes complémentaires..."
                                  class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] resize-none"></textarea>
                    </div>
                </div>
            </div>
            <div class="p-6 border-t border-slate-100 flex gap-3 justify-end bg-slate-50 shrink-0">
                <button type="button" onclick="document.getElementById('modal-create').classList.add('hidden')"
                        class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                    Annuler
                </button>
                <button type="submit"
                        class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow-md shadow-[#b11d40]/20">
                    Créer le Lead
                </button>
            </div>
        </form>
    </div>
</div>
@endcan

{{-- ===== MODAL DOSSIER ===== --}}
@can('dossier.create')
<div id="modal-dossier" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
        <div class="p-6 flex justify-between items-center">
            <h2 class="text-lg font-extrabold text-slate-800">Créer un Dossier</h2>
            <button onclick="document.getElementById('modal-dossier').classList.add('hidden')"
                    class="w-8 h-8 rounded-xl border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-600">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('dossiers.store') }}">
            @csrf
            <input type="hidden" name="idClient" id="dossier-idClient">
            <div class="px-6 pb-4 space-y-4">
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Département *</label>
                    <select name="idDepartement" id="dossier-idDepartement" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                        <option value="">— Choisir un département —</option>
                        @foreach($departements as $dept)
                            <option value="{{ $dept->idDepartement }}">{{ $dept->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Destination</label>
                    <input name="distination" placeholder="Ex: Paris, Dubai..."
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Nb. personnes *</label>
                        <input name="nombrePersonnes" type="number" min="1" value="1" required
                               class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Nb. jours *</label>
                        <input name="nombreJours" type="number" min="0" value="0" required
                               class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Montant (MAD) *</label>
                    <input name="montant" type="number" min="0" step="0.01" value="0" required
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Date de voyage</label>
                    <input name="dateVoyage" type="date"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Commentaire</label>
                    <textarea name="commentaire" rows="2"
                              class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] resize-none"></textarea>
                </div>
            </div>
            <div class="px-6 pb-6 flex gap-3 justify-end border-t border-slate-100 pt-4 bg-slate-50">
                <button type="button" onclick="document.getElementById('modal-dossier').classList.add('hidden')"
                        class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm">
                    Annuler
                </button>
                <button type="submit"
                        class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl text-sm shadow-md shadow-[#b11d40]/20">
                    Créer le Dossier
                </button>
            </div>
        </form>
    </div>
</div>
@endcan

<script>
// ===== STATUT MODAL =====
function openStatutModal(leadId, currentStatut) {
    const modal  = document.getElementById('statutModal');
    const form   = document.getElementById('statutForm');
    const select = document.getElementById('statutSelect');

    form.action  = `/leads/${leadId}/statut`;
    select.value = currentStatut;
    handleStatutChange(currentStatut);

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeStatutModal() {
    document.getElementById('statutModal').classList.add('hidden');
    document.getElementById('statutModal').classList.remove('flex');
}

function handleStatutChange(value) {
    const appelFields = document.getElementById('appelFields');
    const deptField   = document.getElementById('deptField');

    appelFields.classList.toggle('hidden', !['1er_appel', '2eme_appel'].includes(value));
    deptField.classList.toggle('hidden', value !== 'ok');
}

// ===== DOSSIER MODAL =====
function openDossierModal(clientId, deptId) {
    document.getElementById('dossier-idClient').value   = clientId;
    document.getElementById('dossier-idDepartement').value = deptId ?? '';
    document.getElementById('modal-dossier').classList.remove('hidden');
}

// close on ESC
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeStatutModal();
        document.getElementById('modal-create').classList.add('hidden');
        document.getElementById('modal-dossier').classList.add('hidden');
    }
});
</script>

</x-app-layout>