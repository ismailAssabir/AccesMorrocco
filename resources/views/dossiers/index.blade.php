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
        ➕ Nouveau Dossier
    </button>
    @endcan
</div>
    </div>

    {{-- FLASH --}}
    @if(session('msg'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm font-semibold">
        {{ session('msg') }}
    </div>
    @endif

    {{-- FILTER --}}
    <form method="GET" class="mb-6 flex flex-col md:flex-row gap-3">

        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Recherche..."
            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm">

        @unless(auth()->user()->hasRole('manager'))
        <select name="idDepartement"
            class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm">
            <option value="">Tous les départements</option>
            @foreach($departements as $dept)
                <option value="{{ $dept->idDepartement }}"
                    {{ request('idDepartement') == $dept->idDepartement ? 'selected' : '' }}>
                    {{ $dept->title }}
                </option>
            @endforeach
        </select>
        @endunless

        <select name="status"
            class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm">
            <option value="">Tous les statuts</option>
            <option value="ouvert" {{ request('status')=='ouvert'?'selected':'' }}>Ouvert</option>
            <option value="en_cours" {{ request('status')=='en_cours'?'selected':'' }}>En cours</option>
            <option value="ferme" {{ request('status')=='ferme'?'selected':'' }}>Fermé</option>
        </select>

        <button class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl text-sm">
            Filtrer
        </button>

        @if(request()->hasAny(['search','status','idDepartement']))
        <a href="{{ route('dossiers.index') }}"
            class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl text-sm">
            Reset
        </a>
        @endif
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
                                class="px-2 py-1 rounded-lg text-xs font-bold bg-amber-100 text-amber-700 hover:bg-amber-200 transition">
                                ⚠ Non assigné
                            </button>
                        @else
                            {{ $dossier->departement->title ?? '-' }}
                        @endif
                    </td>

                    <td class="px-4 py-4 text-green-600 font-bold">
                        {{$dossier->idUser? $dossier->user->firstName." ".$dossier->user->lastName : 'Non assigné' }}
                    </td>

                    <td class="px-4 py-4">
                        <span class="px-2 py-1 rounded-lg text-xs font-bold bg-slate-100">
                            {{ $dossier->status }}
                        </span>
                    </td>

                    <td class="px-4 py-4 flex gap-2">

                        @can('dossier.view')
                        <a href="{{ route('dossiers.show',$dossier->idDossier) }}">👁</a>
                        @endcan

                        @can('dossier.edit')
                        <a href="{{ route('dossiers.edit',$dossier->idDossier) }}">✏</a>
                        @endcan

                        @can('dossier.delete')
                        <form method="POST" action="{{ route('dossiers.destroy',$dossier->idDossier) }}">
                            @csrf @method('DELETE')
                            <button>🗑</button>
                        </form>
                        @endcan

                        {{-- ASSIGN --}}
                        @role('manager')
                        @if(auth()->user()->idDepartement == $dossier->idDepartement)
                        <button onclick="openAssignModal({{ $dossier->idDossier }}, {{ $dossier->idDepartement }})">
                            👤
                        </button>
                        @endif
                        @endrole

                    </td>

                </tr>
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
<div id="modal-assign" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center">
    <div class="bg-white p-6 rounded-2xl w-full max-w-md">

        <h2 class="font-bold mb-4">Assigner un employé</h2>

        <form method="POST" id="assignForm">
            @csrf
            @method('PUT')

            <select name="idUser" id="assign-user"
                class="w-full px-3 py-2 border rounded mb-4">
            </select>

            <button class="w-full bg-[#b11d40] text-white py-2 rounded">
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
{{-- JS --}}
<script>
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

    modal.classList.remove('hidden');
    // On s'assure que l'URL générée est correcte
    form.action = '/dossiers/' + dossierId + '/assign';

    fetch('/departements/' + departementId + '/users')
        .then(res => res.json())
        .then(data => {
            select.innerHTML = '<option value="">Choisir un employé...</option>';

            data.forEach(user => {
                // ATTENTION : on utilise user.idUser car c'est ce que votre route JSON renvoie
                select.innerHTML += `
                    <option value="${user.idUser}">
                        ${user.firstName} ${user.lastName}
                    </option>`;
            });
        })
        .catch(err => console.error('Erreur lors de la récupération des utilisateurs:', err));
}

// Optionnel : Fermer le modal en cliquant à côté
window.onclick = function(event) {
    const modal = document.getElementById('modal-assign');
    if (event.target == modal) {
        modal.classList.add('hidden');
    }
}
</script>

</x-app-layout>