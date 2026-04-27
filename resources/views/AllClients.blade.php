<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen">

        {{-- Header --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Gestion des Clients</h1>
                <p class="text-slate-500 text-sm">Liste de tous vos clients actifs.</p>
            </div>
            @can('client.create')
            <button onclick="document.getElementById('modal-create').classList.remove('hidden')"
                    class="flex items-center gap-2 px-4 py-2 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouveau Client
            </button>
            @endcan
        </div>

        {{-- Flash --}}
        @if(session('msg'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm font-semibold">
            {{ session('msg') }}
        </div>
        @endif

        {{-- Table --}}
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

            <table class="w-full text-sm table-fixed">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50">
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[20%]">Client</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[18%]">Contact</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[10%]">Type</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[10%]">Statut</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[12%]">Nationalité</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[12%]">Naissance</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[18%]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($clients as $client)
                    <tr class="hover:bg-slate-50 transition-colors">

                        {{-- Client --}}
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-xl bg-[#b11d40]/10 flex items-center justify-center flex-shrink-0">
                                    <span class="text-[#b11d40] font-black text-xs">
                                        {{ strtoupper(substr($client->firstName, 0, 1)) }}{{ strtoupper(substr($client->lastName, 0, 1)) }}
                                    </span>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-800 text-xs truncate">{{ $client->firstName }} {{ $client->lastName }}</p>
                                    <p class="text-slate-400 text-xs truncate">{{ $client->CNE ?? '—' }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Contact --}}
                        <td class="px-4 py-4">
                            <p class="text-slate-700 text-xs truncate">{{ $client->email }}</p>
                            <p class="text-slate-400 text-xs">{{ $client->phoneNumber }}</p>
                        </td>

                        {{-- Type --}}
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 rounded-lg text-xs font-black bg-[#b11d40]/10 text-[#b11d40] uppercase">
                                {{ $client->type ?? '—' }}
                            </span>
                        </td>

                        {{-- Statut --}}
                        <td class="px-4 py-4">
                            @if($client->status === 'actif')
                                <span class="px-2 py-1 rounded-lg text-xs font-black bg-green-100 text-green-600">Actif</span>
                            @else
                                <span class="px-2 py-1 rounded-lg text-xs font-black bg-red-100 text-red-500">Inactif</span>
                            @endif
                        </td>

                        {{-- Nationalité --}}
                        <td class="px-4 py-4 text-slate-600 text-xs truncate">{{ $client->nationalite ?? '—' }}</td>

                        {{-- Naissance --}}
                        <td class="px-4 py-4 text-slate-500 text-xs">
                            {{ $client->dateNaissance ? \Carbon\Carbon::parse($client->dateNaissance)->format('d/m/Y') : '—' }}
                        </td>

                       
                        {{-- Actions --}}
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-1">
                            @can('client.view')
                            <a href="{{ route('clients.show', $client->idClient) }}"
                            class="p-1.5 rounded-lg text-slate-400 hover:text-[#b11d40] hover:bg-[#b11d40]/10 transition-all"
                            title="Voir">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            @endcan

                            @can('client.edit')
                            <a href="{{ route('clients.edit', $client->idClient) }}"
                            class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all"
                            title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            @endcan

                            {{-- 🔥 BOUTON CRÉER DOSSIER --}}
                            @can('dossier.create')
                            <button type="button"
                                    onclick="openDossierModal({{ $client->idClient }}, {{ $client->idDepartement ?? 'null' }})"
                                    class="p-1.5 rounded-lg text-slate-400 hover:text-green-600 hover:bg-green-50 transition-all"
                                    title="Créer un dossier">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2z"/>
                                </svg>
                            </button>
                            @endcan
                            
                        </div>
                    </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="font-bold text-slate-500">Aucun client trouvé</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== MODAL CREATE ===== --}}
    @can('client.create')
    <div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-extrabold text-slate-800">Nouveau Client</h2>
                    <button onclick="document.getElementById('modal-create').classList.add('hidden')"
                            class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('clients.store') }}">
                    @csrf

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl text-xs font-bold">
                            <ul class="list-disc pl-4 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

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
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Email *</label>
                            <input name="email" type="email" required placeholder="email@exemple.com"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Mot de passe *</label>
                            <input name="password" type="password" required placeholder="Min. 8 caractères"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">CNE *</label>
                            <input name="CNE" required placeholder="CNE"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Date de naissance *</label>
                            <input name="dateNaissance" type="date" required
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Téléphone *</label>
                            <input name="phoneNumber" required placeholder="+212..."
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nationalité</label>
                            <input name="nationalite" placeholder="Nationalité"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Type</label>
                            <input name="type" placeholder="Type de client"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Statut</label>
                            <select name="status"
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                                <option value="actif">Actif</option>
                                <option value="inactif">Inactif</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Adresse</label>
                            <input name="address" placeholder="Adresse complète"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Note</label>
                            <textarea name="note" rows="2" placeholder="Notes complémentaires..."
                                      class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] resize-none"></textarea>
                        </div>

                    </div>
                    <div class="flex gap-3 justify-end mt-6">
                        <button type="button" onclick="document.getElementById('modal-create').classList.add('hidden')"
                                class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                            Annuler
                        </button>
                        <button type="submit"
                                class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">
                            Créer le Client
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
    {{-- ===== MODAL CRÉER DOSSIER ===== --}}
@can('dossier.create')
<div id="modal-dossier" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
        <div class="p-6 flex justify-between items-center">
            <h2 class="text-lg font-extrabold text-slate-800">Créer un Dossier</h2>
            <button onclick="document.getElementById('modal-dossier').classList.add('hidden')"
                    class="text-slate-400 hover:text-slate-600">✕</button>
        </div>
        <form method="POST" action="{{ route('dossiers.store') }}">
            @csrf
            <input type="hidden" name="idClient" id="dossier-idClient">
            

            <div class="px-6 pb-6 space-y-4">
                <div>
                <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Département *</label>
                <select name="idDepartement" id="dossier-idDepartement"
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
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nombre de personnes *</label>
                        <input name="nombrePersonnes" type="number" min="1" value="1" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nombre de jours *</label>
                        <input name="nombreJours" type="number" min="0" value="0" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Montant *</label>
                    <input name="montant" type="number" min="0" step="0.01" value="0" required
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Date de voyage</label>
                    <input name="dateVoyage" type="date"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Commentaire</label>
                    <textarea name="commentaire" rows="2"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm resize-none"></textarea>
                </div>
            </div>

            <div class="px-6 pb-6 flex gap-3 justify-end border-t border-slate-100 pt-4 bg-slate-50">
                <button type="button" onclick="document.getElementById('modal-dossier').classList.add('hidden')"
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

<script>
function openDossierModal(clientId, deptId) {
    document.getElementById('dossier-idClient').value = clientId;
    document.getElementById('dossier-idDepartement').value = deptId ?? '';
    document.getElementById('modal-dossier').classList.remove('hidden');
}

window.onclick = function(event) {
    const modal = document.getElementById('modal-dossier');
    if (event.target == modal) modal.classList.add('hidden');
}
</script>
@endcan

</x-app-layout>