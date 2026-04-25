<x-app-layout>
<div class="p-6 md:p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

    {{-- TOP BAR --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Mes Infractions</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Consultez et justifiez vos retards et absences.</p>
        </div>
        <a href="{{ route('pointages.index') }}"
            class="flex items-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 px-4 py-2.5 rounded-xl font-bold text-sm transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Retour au Pointage
        </a>
    </div>

    <x-status-messages />

    @if($infractions->count() > 0)
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-amber-400 to-orange-500"></div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-extrabold text-slate-400 tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Arrivée</th>
                        <th class="px-6 py-4">Départ</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="px-6 py-4">Justification</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($infractions as $infraction)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-800">
                            {{ \Carbon\Carbon::parse($infraction->date)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg">
                                {{ $infraction->heureEntree ?? '--:--' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg">
                                {{ $infraction->heureSortie ?? '--:--' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($infraction->status === 'retard')
                                <span class="bg-amber-50 text-amber-600 font-bold px-3 py-1 rounded-full text-xs border border-amber-200">Retard</span>
                            @else
                                <span class="bg-red-50 text-[#b11d40] font-bold px-3 py-1 rounded-full text-xs border border-red-200">Absent</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            @if($infraction->justification)
                                <p class="text-xs text-slate-600 truncate">{{ $infraction->justification }}</p>
                                @if($infraction->typejustif)
                                    <span class="text-[10px] font-bold text-indigo-500 uppercase">{{ $infraction->typejustif }}</span>
                                @endif
                            @else
                                <span class="text-slate-300 italic text-xs">Aucune</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if(!$infraction->justification)
                            <button type="button" onclick="openJustifModal({{ $infraction->idPointage }})"
                                class="text-xs font-bold bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white border border-indigo-200 px-3 py-1.5 rounded-xl transition-all">
                                Justifier
                            </button>
                            @else
                            <span class="text-xs font-bold text-emerald-500 flex items-center justify-end gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Soumis
                            </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-20 text-center">
        <div class="w-16 h-16 mx-auto rounded-2xl bg-emerald-50 flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="font-bold text-slate-700">Aucune infraction enregistrée</p>
        <p class="text-sm text-slate-400 mt-1">Continuez comme ça — beau travail !</p>
    </div>
    @endif
</div>

{{-- Justification Modal --}}
<div id="justifModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeJustifModal()"></div>
    <div class="relative bg-white w-full max-w-lg rounded-[32px] shadow-2xl overflow-hidden flex flex-col z-10" style="animation: modalIn .2s ease-out">
        <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between">
            <h2 class="text-lg font-black text-slate-800">Soumettre une Justification</h2>
            <button type="button" onclick="closeJustifModal()" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form action="{{ route('justification.submit') }}" method="POST" enctype="multipart/form-data" class="p-7 space-y-5">
            @csrf
            <input type="hidden" name="idPointage" id="justif-idPointage">
            <div class="space-y-1.5">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Type de Justification *</label>
                <select name="typejustif" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                    <option value="">-- Sélectionner --</option>
                    <option value="medical">Médical</option>
                    <option value="familial">Familial</option>
                    <option value="transport">Transport</option>
                    <option value="administratif">Administratif</option>
                    <option value="autre">Autre</option>
                </select>
            </div>
            <div class="space-y-1.5">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Motif *</label>
                <textarea name="justification" rows="4" required placeholder="Expliquez la raison..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5"></textarea>
            </div>
            <div class="space-y-1.5">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Fichier justificatif (PDF, JPG, PNG)</label>
                <input type="file" name="fichier" accept=".pdf,.jpg,.jpeg,.png"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:font-bold file:bg-[#be2346] file:text-white file:cursor-pointer">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeJustifModal()" class="flex-1 py-3.5 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 transition-all text-sm">Annuler</button>
                <button type="submit" class="flex-1 py-3.5 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-[#be2346]/20 text-sm">Envoyer</button>
            </div>
        </form>
    </div>
</div>
<style>@keyframes modalIn { from { opacity:0; transform:scale(.95) translateY(8px); } to { opacity:1; transform:scale(1) translateY(0); } }</style>
<script>
    function openJustifModal(id) {
        document.getElementById('justif-idPointage').value = id;
        const m = document.getElementById('justifModal');
        m.classList.remove('hidden'); m.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function closeJustifModal() {
        const m = document.getElementById('justifModal');
        m.classList.add('hidden'); m.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeJustifModal(); });
</script>
</x-app-layout>
