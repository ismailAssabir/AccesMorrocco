<x-app-layout>
<div class="p-8 min-h-screen" x-data="leadsKanban()">

    {{-- TOAST NOTIFICATIONS --}}
    <div class="fixed top-5 right-5 z-50 flex flex-col gap-3 pointer-events-none">
        @if(session('msg'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-4"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-4"
             class="bg-white border-l-4 border-emerald-500 text-slate-700 shadow-lg rounded-xl p-4 flex items-center gap-3 w-80 pointer-events-auto">
            <div class="bg-emerald-100 p-2 rounded-full">
                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="font-medium text-sm flex-1">{{ session('msg') }}</p>
            <button @click="show = false" class="text-slate-400 hover:text-slate-600">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-4"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-4"
             class="bg-white border-l-4 border-red-500 text-slate-700 shadow-lg rounded-xl p-4 flex items-center gap-3 w-80 pointer-events-auto">
            <div class="bg-red-100 p-2 rounded-full">
                <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <p class="font-medium text-sm flex-1">{{ session('error') }}</p>
            <button @click="show = false" class="text-slate-400 hover:text-slate-600">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        @endif
    </div>

    {{-- TOP BAR --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Gestion des Leads</h1>
            <p class="text-slate-500 text-sm">Suivez et gérez tous vos prospects commerciaux.</p>
        </div>
        <div class="flex gap-3">
            @can('lead.view')
            <a href="{{ route('leads.export-pdf', request()->query()) }}"
               class="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-all text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Exporter PDF
            </a>
            @endcan

            @can('lead.create')
            <button onclick="document.getElementById('modal-create').classList.remove('hidden'); document.getElementById('modal-create').classList.add('flex');"
                    class="flex items-center gap-2 px-4 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow-sm shadow-[#b11d40]/20">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Nouveau Lead
            </button>
            @endcan
        </div>
    </div>

    {{-- FILTERS --}}
    <form method="GET" action="{{ route('leads.index') }}" x-data
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
                       placeholder="Rechercher nom, email, téléphone..."
                       class="block w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-2xl text-sm transition-all focus:border-[#b11d40]/40 focus:ring-4 focus:ring-[#b11d40]/10 outline-none">
            </div>

            {{-- Type Filter --}}
            <div class="relative shrink-0">
                <select name="type" onchange="this.form.submit()"
                        class="appearance-none bg-white border border-slate-200 rounded-xl pl-4 pr-10 py-2 text-xs font-bold text-slate-600 outline-none transition-all focus:border-[#b11d40]/40 focus:ring-4 focus:ring-[#b11d40]/10 cursor-pointer">
                    <option value="">Type (Tous)</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

            {{-- Source Filter --}}
            <div class="relative shrink-0">
                <select name="source" onchange="this.form.submit()"
                        class="appearance-none bg-white border border-slate-200 rounded-xl pl-4 pr-10 py-2 text-xs font-bold text-slate-600 outline-none transition-all focus:border-[#b11d40]/40 focus:ring-4 focus:ring-[#b11d40]/10 cursor-pointer">
                    <option value="">Source (Toutes)</option>
                    @foreach($sources as $source)
                        <option value="{{ $source }}" {{ request('source') === $source ? 'selected' : '' }}>{{ $source }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

            {{-- Nationalité Filter --}}
            <div class="relative shrink-0">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <input type="text" name="nationalite" value="{{ request('nationalite') }}"
                       @input.debounce.500ms="$el.closest('form').submit()"
                       placeholder="Nationalité..."
                       class="pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 outline-none transition-all focus:border-[#b11d40]/40 focus:ring-4 focus:ring-[#b11d40]/10 w-36">
            </div>

            {{-- Reset --}}
            @if(request('search') || request('type') || request('source') || request('nationalite'))
            <div class="flex shrink-0">
                <a href="{{ route('leads.index') }}" title="Réinitialiser" class="p-2 rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-all flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </a>
            </div>
            @endif
        </div>
    </form>

    {{-- KANBAN BOARD --}}
    @php
        $columns = [
            'nouveau'    => ['label' => 'Nouveau',    'dot' => 'bg-slate-400',   'badge' => 'bg-slate-100 text-slate-500',   'border' => 'border-slate-300',  'svgPath' => 'M12 4v16m8-8H4'],
            '1er_appel'  => ['label' => '1er Appel',  'dot' => 'bg-blue-400',    'badge' => 'bg-blue-50 text-blue-600',      'border' => 'border-blue-300',   'svgPath' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
            '2eme_appel' => ['label' => '2ème Appel', 'dot' => 'bg-orange-400',  'badge' => 'bg-orange-50 text-orange-600',  'border' => 'border-orange-300', 'svgPath' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
            'promis'     => ['label' => 'Promis',     'dot' => 'bg-yellow-400',  'badge' => 'bg-yellow-50 text-yellow-700',  'border' => 'border-yellow-300', 'svgPath' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
            'ok'         => ['label' => 'Converti',   'dot' => 'bg-emerald-400', 'badge' => 'bg-emerald-50 text-emerald-600','border' => 'border-emerald-300','svgPath' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            'lost'       => ['label' => 'Perdu',      'dot' => 'bg-red-400',     'badge' => 'bg-red-50 text-red-600',        'border' => 'border-red-300',    'svgPath' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ];
        $grouped = $leads->groupBy('statut');
        $avatarColors = ['bg-[#b11d40]','bg-blue-500','bg-emerald-500','bg-amber-500','bg-violet-500','bg-cyan-500'];
    @endphp

<div class="flex gap-4 items-start overflow-x-auto pb-4">
        @foreach($columns as $statut => $col)
        @php $colLeads = $grouped->get($statut, collect()); @endphp
        <div class="flex flex-col gap-3 min-w-0">

            {{-- Column Header --}}
            <div class="flex items-center justify-between px-2">
                <h2 class="text-xs font-black uppercase tracking-wider text-slate-400 flex items-center gap-2 whitespace-nowrap truncate">
                    <span class="w-2 h-2 rounded-full shrink-0 {{ $col['dot'] }}"></span>
                    <span class="truncate">{{ $col['label'] }}</span>
                </h2>
                <span class="{{ $col['badge'] }} text-[10px] font-bold px-2 py-0.5 rounded-full shrink-0 ml-2">
                    {{ $colLeads->count() }}
                </span>
            </div>

            {{-- Cards --}}
            <div class="flex flex-col gap-4 min-h-[300px]"
                 x-data="{ page: 1, perPage: 4 }">

                @forelse($colLeads->values() as $i => $lead)
                <div x-show="{{ $i }} >= (page-1)*perPage && {{ $i }} < page*perPage"
                     class="relative bg-white border border-slate-200 rounded-[24px] p-5 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group cursor-default overflow-hidden flex flex-col h-full">

                    {{-- Vertical Accent --}}
                    <div class="absolute left-0 top-6 bottom-6 w-1.5 {{ str_replace('bg-', '', $col['dot']) }} bg-opacity-70 bg-gradient-to-b from-{{ str_replace('bg-', '', $col['dot']) }} to-slate-200 rounded-r-full shadow-[0_0_10px_rgba(0,0,0,0.1)]" style="background-color: var(--fallback, currentColor); border-left: 4px solid inherit;"></div>
                    <div class="absolute left-0 top-6 bottom-6 w-1.5 {{ $col['dot'] }} rounded-r-full shadow-[0_0_10px_rgba(0,0,0,0.1)]"></div>

                    {{-- Avatar + Name --}}
                    <div class="flex items-start justify-between gap-2 mb-3 pl-2">
                        <div class="flex items-center gap-2 min-w-0">
                            <div class="w-8 h-8 rounded-xl {{ $avatarColors[$i % count($avatarColors)] }} flex items-center justify-center shrink-0 shadow-sm">
                                <span class="text-white font-black text-[10px]">
                                    {{ strtoupper(mb_substr($lead->firstName, 0, 1)) }}{{ strtoupper(mb_substr($lead->lastName, 0, 1)) }}
                                </span>
                            </div>
                            <div class="min-w-0">
                                <p class="font-extrabold text-slate-800 text-base leading-tight truncate group-hover:text-[#b11d40] transition-colors">
                                    {{ $lead->firstName }} {{ $lead->lastName }}
                                </p>
                                @if($lead->nationalite)
                                <p class="text-[10px] text-slate-400 font-medium truncate">{{ $lead->nationalite }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Actions dropdown --}}
                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity shrink-0">
                            @can('lead.view')
                            <a href="{{ route('leads.show', $lead->idLead) }}"
                               class="w-6 h-6 rounded-lg flex items-center justify-center text-slate-400 hover:text-[#b11d40] hover:bg-[#b11d40]/10 transition-all"
                               title="Voir">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            @endcan
                            @can('lead.delete')
                            <button onclick="confirmDelete('{{ route('leads.destroy', $lead->idLead) }}', 'lead')"
                                    class="w-6 h-6 rounded-lg flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all"
                                    title="Supprimer">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                            @endcan
                        </div>
                    </div>

                    {{-- Contact Info --}}
                    <div class="pl-2 space-y-1 mb-3">
                        @if($lead->phoneNumber)
                        <div class="flex items-center gap-1.5 text-[10px] text-slate-500">
                            <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span class="truncate font-medium">{{ $lead->phoneNumber }}</span>
                        </div>
                        @endif
                        @if($lead->type)
                        <div class="flex items-center gap-1.5">
                            <span class="text-[9px] font-black bg-[#b11d40]/10 text-[#b11d40] px-2 py-0.5 rounded-lg uppercase">
                                {{ \Illuminate\Support\Str::limit($lead->type, 10) }}
                            </span>
                            @if($lead->source)
                            <span class="text-[9px] text-slate-400 font-medium truncate">{{ $lead->source }}</span>
                            @endif
                        </div>
                        @endif
                        @if($lead->departements)
                        <div class="flex items-center gap-1 text-[10px] text-blue-600 bg-blue-50 px-2 py-0.5 rounded-lg w-fit font-bold">
                            <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span class="truncate">{{ $lead->departements->title }}</span>
                        </div>
                        @endif
                    </div>

                    {{-- Footer: Date + Actions --}}
                    <div class="pl-2 pt-4 border-t border-slate-100/60 flex items-center justify-between">
                        <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">
                            {{ $lead->dateCreation ? \Carbon\Carbon::parse($lead->dateCreation)->format('d M, Y') : '—' }}
                        </span>

                        <div class="flex gap-1">
                            {{-- Move backward --}}
                            @can('lead.edit')
                            @if($statut !== 'nouveau' && $statut !== 'lost' && $statut !== 'ok')
                            @php
                                $statutKeys = array_keys($columns);
                                $currentIndex = array_search($statut, $statutKeys);
                                $prevStatut = $currentIndex > 0 ? $statutKeys[$currentIndex - 1] : null;
                            @endphp
                            @if($prevStatut)
                            <button onclick="moveLeadStatut({{ $lead->idLead }}, '{{ $prevStatut }}')"
                                    class="w-6 h-6 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-slate-200 hover:text-slate-600 transition-all"
                                    title="Reculer">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            @endif
                            @endif

                            {{-- Change status (modal) --}}
                            @if($statut !== 'ok' && $statut !== 'lost')
                            <button onclick="openStatutModal({{ $lead->idLead }}, '{{ $statut }}')"
                                    class="w-6 h-6 flex items-center justify-center rounded-lg bg-[#b11d40]/5 text-[#b11d40] hover:bg-[#b11d40] hover:text-white transition-all"
                                    title="Modifier le statut">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            @endif
                            @endcan

                            {{-- Create dossier --}}
                            @if($statut === 'ok' && $lead->client)
                            @can('dossier.create')
                            <button onclick="openDossierModal({{ $lead->client->idClient }}, {{ $lead->idDepartement ?? 'null' }})"
                                    class="w-6 h-6 flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white transition-all"
                                    title="Créer un dossier">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                </svg>
                            </button>
                            @endcan
                            @endif
                        </div>
                    </div>

                    {{-- Subtle Branding --}}
                    <div class="absolute bottom-1 right-1 opacity-[0.03] group-hover:opacity-10 transition-opacity pointer-events-none">
                        <img src="{{ asset('images/logo.png') }}" class="w-12 h-12 grayscale" alt="Branding">
                    </div>
                </div>
                @empty
                <div class="p-8 border-2 border-dashed border-slate-200 rounded-[24px] flex flex-col items-center justify-center text-slate-400 min-h-[150px]">
                    <svg class="w-8 h-8 mb-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $col['svgPath'] }}"/>
                    </svg>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-center">Aucun lead</p>
                </div>
                @endforelse

                {{-- Column Pagination --}}
                @if($colLeads->count() > 4)
                <div class="flex items-center justify-center gap-4 mt-2">
                    <button @click="page > 1 ? page-- : null" :disabled="page === 1"
                            class="p-2 rounded-xl bg-white border border-slate-200 text-slate-400 disabled:opacity-30 hover:text-[#b11d40] transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        Page <span x-text="page"></span>
                    </span>
                    <button @click="page * perPage < {{ $colLeads->count() }} ? page++ : null"
                            :disabled="page * perPage >= {{ $colLeads->count() }}"
                            class="p-2 rounded-xl bg-white border border-slate-200 text-slate-400 disabled:opacity-30 hover:text-[#b11d40] transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

</div>

{{-- ===== MODAL STATUT ===== --}}
<div id="statutModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeStatutModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md mx-4 flex flex-col overflow-hidden" style="max-height: 90vh;">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233] shrink-0"></div>
        <div class="flex flex-col overflow-hidden flex-1">
            {{-- Header fixe --}}
            <div class="flex items-center justify-between px-6 pt-6 pb-4 shrink-0 border-b border-slate-100">
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

            <form id="statutForm" method="POST" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                @method('PATCH')

                {{-- Zone scrollable --}}
                <div class="overflow-y-auto flex-1 px-6 py-5 space-y-4">

                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Statut *</label>
                        <select name="statut" id="statutSelect" onchange="handleStatutChange(this.value)"
                                class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-[#b11d40]/30 focus:border-[#b11d40]">
                            <option value="1er_appel">1er Appel</option>
                            <option value="2eme_appel">2ème Appel</option>
                            <option value="promis">Promis</option>
                            <option value="lost">Perdu</option>
                            <option value="ok">Converti en client</option>
                        </select>
                    </div>

                    <div id="appelFields" class="space-y-4 hidden">

                        {{-- Toggle Pas de réponse --}}
                        <div class="flex items-center justify-between p-3 bg-amber-50 border border-amber-200 rounded-2xl cursor-pointer"
                             onclick="togglePasDeReponse()">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-xl bg-amber-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-amber-700">Le client n'a pas répondu</p>
                                    <p class="text-[10px] text-amber-500">Cocher si l'appel est resté sans réponse</p>
                                </div>
                            </div>
                            <div id="nrToggleUI" class="w-10 h-6 rounded-full bg-slate-200 relative transition-all duration-200 shrink-0">
                                <div id="nrToggleDot" class="absolute left-1 top-1 w-4 h-4 rounded-full bg-white shadow transition-all duration-200"></div>
                            </div>
                            <input type="hidden" name="pas_de_reponse" id="pasDeReponseInput" value="0">
                        </div>

                        {{-- Champs appel (masqués si NR) --}}
                        <div id="appelDetailFields" class="space-y-4">
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
                    </div>

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

                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Note</label>
                        <textarea name="note" rows="2"
                                  class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-[#b11d40]/30 focus:border-[#b11d40] resize-none"
                                  placeholder="Ajouter une note..."></textarea>
                    </div>

                </div>

                {{-- Boutons fixes en bas --}}
                <div class="px-6 py-4 border-t border-slate-100 flex gap-3 shrink-0 bg-slate-50 rounded-b-3xl">
                    <button type="button" onclick="closeStatutModal()"
                            class="flex-1 px-4 py-3 rounded-2xl border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-100 transition-all">
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

{{-- ===== MODAL CONFIRM MOVE ===== --}}
<div id="modal-confirm-move" class="hidden fixed inset-0 z-50 items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-sm flex flex-col overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-slate-400 to-slate-600 shrink-0"></div>
        <div class="p-6">
            <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mb-4 text-slate-500">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                </svg>
            </div>
            <h3 class="text-lg font-extrabold text-slate-800 mb-1">Déplacer le lead</h3>
            <p class="text-sm text-slate-500 mb-6">Êtes-vous sûr de vouloir déplacer ce lead vers l'étape <span id="confirm-move-statut-label" class="font-bold text-slate-800"></span> ?</p>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeConfirmMoveModal()"
                        class="flex-1 px-4 py-3 rounded-2xl border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 transition-all">
                    Annuler
                </button>
                <button type="button" id="confirm-move-btn"
                        class="flex-1 px-4 py-3 rounded-2xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-sm transition-all shadow-md shadow-slate-900/20 active:scale-95">
                    Confirmer
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ===== MODAL CREATE LEAD ===== --}}
@can('lead.create')
<div id="modal-create" class="hidden fixed inset-0 z-50 items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233] shrink-0"></div>
        <div class="p-6 pb-0 flex justify-between items-center shrink-0">
            <h2 class="text-lg font-extrabold text-slate-800">Nouveau Lead</h2>
            <button onclick="document.getElementById('modal-create').classList.add('hidden'); document.getElementById('modal-create').classList.remove('flex');"
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
                        <input name="firstName" required placeholder="Prénom" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Nom *</label>
                        <input name="lastName" required placeholder="Nom" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Email</label>
                        <input name="email" type="email" placeholder="email@exemple.com" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Téléphone</label>
                        <input name="phoneNumber" placeholder="+212..." class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">CNE</label>
                        <input name="CNE" placeholder="CNE" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Nationalité</label>
                        <input name="nationalite" placeholder="Nationalité" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Adresse</label>
                        <input name="address" placeholder="Adresse" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Source</label>
                        <input name="source" placeholder="Ex: LinkedIn, Référence..." class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
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
                            <input name="type" placeholder="Précisez le type..." class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Note</label>
                        <textarea name="note" rows="2" placeholder="Notes complémentaires..." class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] resize-none"></textarea>
                    </div>
                </div>
            </div>
            <div class="p-6 border-t border-slate-100 flex gap-3 justify-end bg-slate-50 shrink-0">
                <button type="button" onclick="document.getElementById('modal-create').classList.add('hidden'); document.getElementById('modal-create').classList.remove('flex');"
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
<div id="modal-dossier" class="hidden fixed inset-0 z-50 items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
        <div class="p-6 flex justify-between items-center">
            <h2 class="text-lg font-extrabold text-slate-800">Créer un Dossier</h2>
            <button onclick="document.getElementById('modal-dossier').classList.add('hidden'); document.getElementById('modal-dossier').classList.remove('flex');"
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
                    <select name="idDepartement" id="dossier-idDepartement" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                        <option value="">— Choisir un département —</option>
                        @foreach($departements as $dept)
                            <option value="{{ $dept->idDepartement }}">{{ $dept->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Destination</label>
                    <input name="distination" placeholder="Ex: Paris, Dubai..." class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Nb. personnes *</label>
                        <input name="nombrePersonnes" type="number" min="1" value="1" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Nb. jours *</label>
                        <input name="nombreJours" type="number" min="0" value="0" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Montant (MAD) *</label>
                    <input name="montant" type="number" min="0" step="0.01" value="0" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Date de voyage</label>
                    <input name="dateVoyage" type="date" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Commentaire</label>
                    <textarea name="commentaire" rows="2" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] resize-none"></textarea>
                </div>
            </div>
            <div class="px-6 pb-6 flex gap-3 justify-end border-t border-slate-100 pt-4 bg-slate-50">
                <button type="button" onclick="document.getElementById('modal-dossier').classList.add('hidden'); document.getElementById('modal-dossier').classList.remove('flex');"
                        class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm">Annuler</button>
                <button type="submit"
                        class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl text-sm shadow-md shadow-[#b11d40]/20">Créer le Dossier</button>
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
    // Réinitialiser le toggle NR
    resetPasDeReponse();
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeStatutModal() {
    document.getElementById('statutModal').classList.add('hidden');
    document.getElementById('statutModal').classList.remove('flex');
}

function handleStatutChange(value) {
    document.getElementById('appelFields').classList.toggle('hidden', !['1er_appel', '2eme_appel'].includes(value));
    document.getElementById('deptField').classList.toggle('hidden', value !== 'ok');
    // Réinitialiser NR à chaque changement de statut
    if (!['1er_appel', '2eme_appel'].includes(value)) resetPasDeReponse();
}

function resetPasDeReponse() {
    document.getElementById('pasDeReponseInput').value = '0';
    document.getElementById('nrToggleUI').classList.remove('bg-amber-400');
    document.getElementById('nrToggleUI').classList.add('bg-slate-200');
    document.getElementById('nrToggleDot').style.transform = 'translateX(0)';
    document.getElementById('appelDetailFields').classList.remove('hidden', 'opacity-50', 'pointer-events-none');
}

function togglePasDeReponse() {
    const input   = document.getElementById('pasDeReponseInput');
    const toggle  = document.getElementById('nrToggleUI');
    const dot     = document.getElementById('nrToggleDot');
    const fields  = document.getElementById('appelDetailFields');

    const isNR = input.value === '1';

    if (isNR) {
        // Désactiver NR
        input.value = '0';
        toggle.classList.remove('bg-amber-400');
        toggle.classList.add('bg-slate-200');
        dot.style.transform = 'translateX(0)';
        fields.classList.remove('opacity-50', 'pointer-events-none');
    } else {
        // Activer NR
        input.value = '1';
        toggle.classList.remove('bg-slate-200');
        toggle.classList.add('bg-amber-400');
        dot.style.transform = 'translateX(16px)';
        fields.classList.add('opacity-50', 'pointer-events-none');
    }
}

// ===== MOVE LEAD (quick status change without modal) =====
let currentMoveLeadId = null;
let currentMoveStatut = null;

const statutsLabelsMap = {
    'nouveau': 'Nouveau',
    '1er_appel': '1er Appel',
    '2eme_appel': '2ème Appel',
    'promis': 'Promis',
    'ok': 'Converti',
    'lost': 'Perdu'
};

function moveLeadStatut(leadId, newStatut) {
    currentMoveLeadId = leadId;
    currentMoveStatut = newStatut;
    
    document.getElementById('confirm-move-statut-label').textContent = statutsLabelsMap[newStatut] || newStatut;
    
    const modal = document.getElementById('modal-confirm-move');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeConfirmMoveModal() {
    const modal = document.getElementById('modal-confirm-move');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    currentMoveLeadId = null;
    currentMoveStatut = null;
}

document.getElementById('confirm-move-btn').addEventListener('click', function() {
    if (!currentMoveLeadId || !currentMoveStatut) return;
    
    // Disable button and show loading state
    this.disabled = true;
    this.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Patientez...';

    fetch(`/leads/${currentMoveLeadId}/statut`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-HTTP-Method-Override': 'PATCH',
        },
        body: JSON.stringify({ statut: currentMoveStatut })
    }).then(async r => {
        if (!r.ok && !r.redirected) {
            const data = await r.json().catch(() => ({}));
            throw new Error(data.message || `Erreur HTTP ${r.status}`);
        }
        window.location.reload();
    }).catch(err => {
        console.error("Move Lead Error:", err);
        document.getElementById('confirm-move-btn').disabled = false;
        document.getElementById('confirm-move-btn').textContent = 'Confirmer';
        closeConfirmMoveModal();
        alert('Erreur: ' + err.message);
    });
});

// ===== DOSSIER MODAL =====
function openDossierModal(clientId, deptId) {
    document.getElementById('dossier-idClient').value = clientId;
    document.getElementById('dossier-idDepartement').value = deptId ?? '';
    document.getElementById('modal-dossier').classList.remove('hidden');
    document.getElementById('modal-dossier').classList.add('flex');
}

// ===== DELETE =====
function confirmDelete(url, type) {
    if (!confirm(`Supprimer ce ${type} ?`)) return;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = url;
    form.innerHTML = `@csrf @method('DELETE')`;
    // inject real tokens
    const csrf = document.createElement('input');
    csrf.type = 'hidden'; csrf.name = '_token';
    csrf.value = document.querySelector('meta[name="csrf-token"]').content;
    const method = document.createElement('input');
    method.type = 'hidden'; method.name = '_method'; method.value = 'DELETE';
    form.appendChild(csrf); form.appendChild(method);
    document.body.appendChild(form);
    form.submit();
}

// ESC
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeStatutModal();
        closeConfirmMoveModal();
        const mc = document.getElementById('modal-create');
        if (mc) { mc.classList.add('hidden'); mc.classList.remove('flex'); }
        const md = document.getElementById('modal-dossier');
        if (md) { md.classList.add('hidden'); md.classList.remove('flex'); }
    }
});

function leadsKanban() { return {}; }
</script>

</x-app-layout>