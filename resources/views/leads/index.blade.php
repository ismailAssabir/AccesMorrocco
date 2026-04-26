<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen">

        {{-- Header --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Gestion des Leads</h1>
                <p class="text-slate-500 text-sm">Suivez et gérez tous vos prospects commerciaux.</p>
            </div>
            <div class="flex gap-3">
                @can('lead.view')
                <a href="{{ route('leads.export-pdf', request()->query()) }}"
                   class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Exporter PDF
                </a>
                @endcan

                @can('lead.create')
                <button onclick="document.getElementById('modal-create').classList.remove('hidden')"
                        class="flex items-center gap-2 px-4 py-2 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nouveau Lead
                </button>
                @endcan
            </div>
        </div>

        {{-- Flash Message --}}
        @if(session('msg'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm font-semibold">
            {{ session('msg') }}
        </div>
        @endif

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('leads.index') }}" class="mb-6 flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Rechercher par nom, email, téléphone..."
                       class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
            </div>

            <select name="type"
                    class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40]">
                <option value="">Tous les types</option>
                @foreach($types as $type)
                    <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>

            <select name="statut"
                    class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40]">
                <option value="">Tous les statuts</option>
                <option value="nouveau"    {{ request('statut') === 'nouveau'    ? 'selected' : '' }}>Nouveau</option>
                <option value="1er_appel"  {{ request('statut') === '1er_appel'  ? 'selected' : '' }}>1er Appel</option>
                <option value="2eme_appel" {{ request('statut') === '2eme_appel' ? 'selected' : '' }}>2ème Appel</option>
                <option value="promis"     {{ request('statut') === 'promis'     ? 'selected' : '' }}>Promis</option>
                <option value="ok"         {{ request('statut') === 'ok'         ? 'selected' : '' }}>Converti</option>
                <option value="lost"       {{ request('statut') === 'lost'       ? 'selected' : '' }}>Perdu</option>
            </select>

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
        </form>

        {{-- Table --}}
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

            <table class="w-full text-sm table-fixed">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50">
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[18%]">Lead</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[18%]">Contact</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[10%]">Type</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[11%]">Statut</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[10%]">Source</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[13%]">Département</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[10%]">Date</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[10%]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @php
                        $statutColors = [
                            'nouveau'    => 'bg-slate-100 text-slate-500',
                            '1er_appel'  => 'bg-blue-100 text-blue-600',
                            '2eme_appel' => 'bg-orange-100 text-orange-600',
                            'lost'       => 'bg-red-100 text-red-600',
                            'promis'     => 'bg-yellow-100 text-yellow-700',
                            'ok'         => 'bg-green-100 text-green-600',
                        ];
                        $statutLabels = [
                            'nouveau'    => 'Nouveau',
                            '1er_appel'  => '1er Appel',
                            '2eme_appel' => '2ème Appel',
                            'lost'       => 'Perdu',
                            'promis'     => 'Promis',
                            'ok'         => 'Converti ✓',
                        ];
                    @endphp

                    @forelse($leads as $lead)
                    <tr class="hover:bg-slate-50 transition-colors">

                        {{-- Lead --}}
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-xl bg-[#b11d40]/10 flex items-center justify-center flex-shrink-0">
                                    <span class="text-[#b11d40] font-black text-xs">
                                        {{ strtoupper(substr($lead->firstName, 0, 1)) }}{{ strtoupper(substr($lead->lastName, 0, 1)) }}
                                    </span>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-800 truncate text-xs">{{ $lead->firstName }} {{ $lead->lastName }}</p>
                                    <p class="text-slate-400 text-xs truncate">{{ $lead->nationalite ?? '—' }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Contact --}}
                        <td class="px-4 py-4">
                            <p class="text-slate-700 text-xs truncate">{{ $lead->email ?? '—' }}</p>
                            <p class="text-slate-400 text-xs">{{ $lead->phoneNumber ?? '—' }}</p>
                        </td>

                        {{-- Type --}}
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 rounded-lg text-xs font-black bg-[#b11d40]/10 text-[#b11d40] uppercase">
                                {{ Str::limit($lead->type, 10) }}
                            </span>
                        </td>

                        {{-- Statut --}}
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 rounded-lg text-xs font-black uppercase {{ $statutColors[$lead->statut] ?? 'bg-slate-100 text-slate-500' }}">
                                {{ $statutLabels[$lead->statut] ?? $lead->statut }}
                            </span>
                        </td>

                        {{-- Source --}}
                        <td class="px-4 py-4 text-slate-600 text-xs truncate">{{ $lead->source ?? '—' }}</td>

                        {{-- Département --}}
                        <td class="px-4 py-4 text-slate-600 text-xs truncate">{{ $lead->departements->name ?? '—' }}</td>

                        {{-- Date --}}
                        <td class="px-4 py-4 text-slate-500 text-xs">
                            {{ $lead->dateCreation ? \Carbon\Carbon::parse($lead->dateCreation)->format('d/m/Y') : '—' }}
                        </td>

                        {{-- Actions --}}
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1">
                                @can('lead.view')
                                <a href="{{ route('leads.show', $lead->idLead) }}"
                                   class="p-1.5 rounded-lg text-slate-400 hover:text-[#b11d40] hover:bg-[#b11d40]/10 transition-all"
                                   title="Voir">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                @endcan

                                @can('lead.edit')
                                <a href="{{ route('leads.edit', $lead->idLead) }}"
                                   class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all"
                                   title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                @endcan

                                @can('lead.delete')
                                <button type="button" 
                                        onclick="confirmDelete('{{ route('leads.destroy', $lead->idLead) }}', 'lead')"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all"
                                        title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                                @endcan
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="font-bold text-slate-500">Aucun lead trouvé</p>
                            <p class="text-sm mt-1">Modifiez vos critères de recherche ou ajoutez un nouveau lead.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
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

    {{-- ===== MODAL CREATE ===== --}}
    {{-- ===== MODAL CREATE ===== --}}
    @can('lead.create')
    <div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden">
            
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233] shrink-0"></div>
            
            <div class="p-6 pb-0 flex justify-between items-center shrink-0">
                <h2 class="text-lg font-extrabold text-slate-800">Nouveau Lead</h2>
                <button onclick="document.getElementById('modal-create').classList.add('hidden')"
                        class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('leads.store') }}" class="flex flex-col overflow-hidden">
                @csrf
                
                <div class="p-6 overflow-y-auto custom-scrollbar">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Prénom *</label>
                            <input name="firstName" required placeholder="Prénom"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nom *</label>
                            <input name="lastName" required placeholder="Nom"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Email</label>
                            <input name="email" type="email" placeholder="email@exemple.com"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Téléphone</label>
                            <input name="phoneNumber" placeholder="+212..."
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">CNE</label>
                            <input name="CNE" placeholder="CNE"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nationalité</label>
                            <input name="nationalite" placeholder="Nationalité"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Adresse</label>
                            <input name="adresse" placeholder="Adresse"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Source</label>
                            <input name="source" placeholder="Ex: LinkedIn, Référence..."
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Type *</label>
                            <input name="type" required placeholder="Type de lead"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Note</label>
                            <textarea name="note" rows="2" placeholder="Notes complémentaires..."
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] resize-none"></textarea>
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-slate-100 flex gap-3 justify-end bg-slate-50 shrink-0">
                    <button type="button" onclick="document.getElementById('modal-create').classList.add('hidden')"
                            class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                        Annuler
                    </button>
                    <button type="submit"
                            class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">
                        Créer le Lead
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endcan

</x-app-layout>