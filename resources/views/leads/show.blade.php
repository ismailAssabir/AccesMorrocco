<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen">

        {{-- Header --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <a href="{{ route('leads.index') }}"
                   class="inline-flex items-center gap-2 text-slate-400 hover:text-[#b11d40] text-sm font-bold mb-2 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Retour aux leads
                </a>
                <h1 class="text-2xl font-extrabold text-slate-800">{{ $lead->firstName }} {{ $lead->lastName }}</h1>
                <p class="text-slate-500 text-sm">Détails du prospect</p>
            </div>
            <div class="flex gap-3">
                @can('lead.edit')
                <a href="{{ route('leads.edit', $lead->idLead) }}"
                   class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </a>
                @endcan
                @can('lead.delete')
                <button type="button" 
                        onclick="confirmDelete('{{ route('leads.destroy', $lead->idLead) }}', 'lead')"
                        class="flex items-center gap-2 px-4 py-2 bg-white border border-red-200 text-red-500 font-bold rounded-xl hover:bg-red-500 hover:text-white transition-all text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Supprimer
                </button>
                @endcan
            </div>
        </div>

        {{-- Flash --}}
        @if(session('msg'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm font-semibold">
            {{ session('msg') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm font-semibold">
            {{ session('error') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Colonne gauche --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Carte identité --}}
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6 flex flex-col items-center text-center">
                        <div class="w-20 h-20 rounded-3xl bg-[#b11d40]/10 flex items-center justify-center mb-4">
                            <span class="text-[#b11d40] font-black text-2xl">
                                {{ strtoupper(substr($lead->firstName,0,1)) }}{{ strtoupper(substr($lead->lastName,0,1)) }}
                            </span>
                        </div>
                        <h2 class="text-xl font-extrabold text-slate-800">{{ $lead->firstName }} {{ $lead->lastName }}</h2>
                        <span class="mt-2 px-3 py-1 rounded-xl text-xs font-black bg-[#b11d40]/10 text-[#b11d40] uppercase">
                            {{ $lead->type }}
                        </span>

                        {{-- Statut badge --}}
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
                        <span class="mt-2 px-3 py-1 rounded-xl text-xs font-black uppercase {{ $statutColors[$lead->statut] ?? 'bg-slate-100 text-slate-500' }}">
                            {{ $statutLabels[$lead->statut] ?? $lead->statut }}
                        </span>

                        <div class="w-full mt-6 space-y-3 text-left">
                            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl">
                                <div class="w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-bold uppercase">Email</p>
                                    <p class="text-sm text-slate-700 font-semibold">{{ $lead->email ?? '—' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl">
                                <div class="w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-bold uppercase">Téléphone</p>
                                    <p class="text-sm text-slate-700 font-semibold">{{ $lead->phoneNumber ?? '—' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl">
                                <div class="w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-bold uppercase">Adresse</p>
                                    <p class="text-sm text-slate-700 font-semibold">{{ $lead->address ?? '—' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pipeline statut --}}
                @can('lead.edit')
                @if(!in_array($lead->statut, ['lost', 'ok']))
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6">
                        <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-4">Mettre à jour le statut</h3>
                        <form method="POST" action="{{ route('leads.statut', $lead->idLead) }}" id="form-statut">
                            @csrf
                            <div class="space-y-2 mb-4">

                                {{-- 1er appel --}}
                                @if($lead->statut === 'nouveau')
                                <label class="flex items-center gap-3 p-3 rounded-2xl border-2 border-blue-200 bg-blue-50 cursor-pointer hover:border-blue-400 transition-all">
                                    <input type="radio" name="statut" value="1er_appel" class="accent-[#b11d40]" onchange="toggleDept(this)">
                                    <div>
                                        <p class="text-sm font-black text-blue-700">📞 1er Appel</p>
                                        <p class="text-xs text-blue-500">Premier contact effectué</p>
                                    </div>
                                </label>
                                @endif

                                {{-- 2eme appel --}}
                                @if(in_array($lead->statut, ['nouveau', '1er_appel']))
                                <label class="flex items-center gap-3 p-3 rounded-2xl border-2 border-orange-200 bg-orange-50 cursor-pointer hover:border-orange-400 transition-all">
                                    <input type="radio" name="statut" value="2eme_appel" class="accent-[#b11d40]" onchange="toggleDept(this)">
                                    <div>
                                        <p class="text-sm font-black text-orange-700">📞 2ème Appel</p>
                                        <p class="text-xs text-orange-500">Deuxième tentative de contact</p>
                                    </div>
                                </label>
                                @endif

                                {{-- Promis --}}
                                <label class="flex items-center gap-3 p-3 rounded-2xl border-2 border-yellow-200 bg-yellow-50 cursor-pointer hover:border-yellow-400 transition-all">
                                    <input type="radio" name="statut" value="promis" class="accent-[#b11d40]" onchange="toggleDept(this)">
                                    <div>
                                        <p class="text-sm font-black text-yellow-700">🤝 Promis</p>
                                        <p class="text-xs text-yellow-600">Le lead a donné une promesse</p>
                                    </div>
                                </label>

                                {{-- OK - Converti --}}
                                <label class="flex items-center gap-3 p-3 rounded-2xl border-2 border-green-200 bg-green-50 cursor-pointer hover:border-green-400 transition-all">
                                    <input type="radio" name="statut" value="ok" class="accent-[#b11d40]" onchange="toggleDept(this)">
                                    <div>
                                        <p class="text-sm font-black text-green-700">✅ OK — Converti</p>
                                        <p class="text-xs text-green-600">Accepté, assigner à un département</p>
                                    </div>
                                </label>

                                {{-- Lost --}}
                                <label class="flex items-center gap-3 p-3 rounded-2xl border-2 border-red-200 bg-red-50 cursor-pointer hover:border-red-400 transition-all">
                                    <input type="radio" name="statut" value="lost" class="accent-[#b11d40]" onchange="toggleDept(this)">
                                    <div>
                                        <p class="text-sm font-black text-red-700">❌ Perdu</p>
                                        <p class="text-xs text-red-500">Pas de réponse ou refus</p>
                                    </div>
                                </label>

                            </div>

                            {{-- Département + Employé (visible seulement si OK) --}}
                            <div id="dept-section" class="hidden space-y-3 mb-4 p-4 bg-slate-50 rounded-2xl border border-slate-200">

    {{-- Département --}}
    <div>
        <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Département</label>
        <select name="idDepartement" id="select-dept"
            class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm"
            onchange="loadEmployees(this.value)">
            <option value="">— Choisir un département —</option>
            @foreach($departements as $dept)
                <option value="{{ $dept->idDepartement }}">{{ $dept->title }}</option>
            @endforeach
        </select>
    </div>

    {{-- User --}}
    <div>
        <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Employé</label>
        <select name="idUser" id="select-user"
            class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm">
            <option value="">— Choisir un employé —</option>
        </select>
    </div>

    {{-- 🔥 Password --}}
    <div>
        <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Mot de passe client</label>
        <input type="password" name="password" id="password"
            class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm"
            placeholder="Entrer un mot de passe">
    </div>

</div>

                            <button type="submit"
                                    class="w-full py-2.5 bg-[#b11d40] text-white font-black rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">
                                Confirmer le statut
                            </button>
                        </form>
                    </div>
                </div>
                @endif
                @endcan

            </div>

            {{-- Colonne droite --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Infos --}}
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6">
                        <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-4">Informations personnelles</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">CNE</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $lead->CNE ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">Nationalité</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $lead->nationalite ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">Source</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $lead->source ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">Département</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $lead->departements->title ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">Responsable</p>
                                <p class="text-sm font-semibold text-slate-700">
                                    {{ $lead->user ? $lead->user->firstName.' '.$lead->user->lastName : '—' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">Date création</p>
                                <p class="text-sm font-semibold text-slate-700">
                                    {{ $lead->dateCreation ? \Carbon\Carbon::parse($lead->dateCreation)->format('d/m/Y') : '—' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Timeline statut --}}
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6">
                        <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-5">Pipeline</h3>
                        @php
                            $steps = [
                                ['key' => 'nouveau',    'label' => 'Nouveau',    'icon' => '🆕'],
                                ['key' => '1er_appel',  'label' => '1er Appel',  'icon' => '📞'],
                                ['key' => '2eme_appel', 'label' => '2ème Appel', 'icon' => '📞'],
                                ['key' => 'promis',     'label' => 'Promis',     'icon' => '🤝'],
                                ['key' => 'ok',         'label' => 'Converti',   'icon' => '✅'],
                            ];
                            $order = ['nouveau' => 0, '1er_appel' => 1, '2eme_appel' => 2, 'promis' => 3, 'ok' => 4, 'lost' => 99];
                            $currentOrder = $order[$lead->statut] ?? 0;
                        @endphp

                        @if($lead->statut === 'lost')
                            <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-2xl">
                                <span class="text-2xl">❌</span>
                                <div>
                                    <p class="font-black text-red-700">Lead perdu</p>
                                    <p class="text-xs text-red-500">Ce lead n'a pas abouti.</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-2">
                                @foreach($steps as $i => $step)
                                    @php
                                        $stepOrder = $order[$step['key']] ?? 0;
                                        $isDone    = $stepOrder < $currentOrder;
                                        $isCurrent = $step['key'] === $lead->statut;
                                    @endphp
                                    <div class="flex items-center {{ $i < count($steps)-1 ? 'flex-1' : '' }}">
                                        <div class="flex flex-col items-center">
                                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm
                                                {{ $isCurrent ? 'bg-[#b11d40] text-white ring-4 ring-[#b11d40]/20' : ($isDone ? 'bg-green-500 text-white' : 'bg-slate-100 text-slate-400') }}">
                                                {{ $step['icon'] }}
                                            </div>
                                            <p class="text-xs font-bold mt-1 whitespace-nowrap
                                                {{ $isCurrent ? 'text-[#b11d40]' : ($isDone ? 'text-green-600' : 'text-slate-400') }}">
                                                {{ $step['label'] }}
                                            </p>
                                        </div>
                                        @if($i < count($steps)-1)
                                        <div class="flex-1 h-0.5 mx-2 mb-4 {{ $isDone ? 'bg-green-400' : 'bg-slate-200' }}"></div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Note --}}
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6">
                        <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-3">Note</h3>
                        @if($lead->note)
                            <p class="text-sm text-slate-700 leading-relaxed bg-slate-50 rounded-2xl p-4">{{ $lead->note }}</p>
                        @else
                            <p class="text-sm text-slate-400 italic">Aucune note renseignée.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Afficher/masquer la section département selon le statut choisi
        function toggleDept(radio) {
            const section = document.getElementById('dept-section');
            section.classList.toggle('hidden', radio.value !== 'ok');
        }

        // Charger les employés du département via fetch
        function loadEmployees(deptId) {
            const select = document.getElementById('select-user');
            select.innerHTML = '<option value="">Chargement...</option>';

            if (!deptId) {
                select.innerHTML = '<option value="">— Choisir un employé —</option>';
                return;
            }

            fetch(`/departements/${deptId}/users`)
                .then(r => r.json())
                .then(users => {
                    select.innerHTML = '<option value="">— Choisir un employé —</option>';
                    users.forEach(u => {
                        select.innerHTML += `<option value="${u.idUser}">${u.firstName} ${u.lastName}</option>`;
                    });
                })
                .catch(() => {
                    select.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        }
    </script>
</x-app-layout>