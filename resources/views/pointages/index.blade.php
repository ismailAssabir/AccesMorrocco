<x-app-layout>
<div class="p-6 md:p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

    {{-- ═══════════ TOP BAR ═══════════ --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Mon Pointage</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Enregistrez votre arrivée et votre départ via GPS.</p>
        </div>
        <div class="flex items-center gap-3">
            <span id="live-clock" class="text-slate-400 font-mono text-sm bg-white border border-slate-200 px-4 py-2 rounded-xl shadow-sm"></span>
            @if(auth()->user()->type !== 'employee')
            <a href="{{ route('admin.pointages.index') }}"
               class="flex items-center gap-2 bg-slate-800 hover:bg-slate-700 active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Vue Admin
            </a>
            @endif
        </div>
    </div>

    <x-status-messages />

    {{-- ═══════════ GPS CHECK-IN / CHECK-OUT CARDS ═══════════ --}}
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

    {{-- ═══════════ MES INFRACTIONS ═══════════ --}}
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden mb-8">
        <div class="h-1.5 w-full bg-gradient-to-r from-amber-400 to-orange-500"></div>
        <div class="px-7 pt-6 pb-3 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-black text-slate-800">Mes Infractions</h2>
                <p class="text-xs text-slate-400 font-medium mt-0.5">Retards et absences — Justifiez vos irrégularités.</p>
            </div>
            <span class="bg-amber-50 text-amber-600 font-black text-xs px-3 py-1 rounded-full border border-amber-200">
                {{ $infractions->count() }} infraction(s)
            </span>
        </div>

        @if($infractions->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-y border-slate-200 text-xs uppercase font-extrabold text-slate-400 tracking-wider">
                    <tr>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Arrivée</th>
                        <th class="px-6 py-3">Départ</th>
                        <th class="px-6 py-3">Statut</th>
                        <th class="px-6 py-3">Justification</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($infractions as $infraction)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-800">
                            {{ \Carbon\Carbon::parse($infraction->date)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-lg">
                                {{ $infraction->heureEntree ?? '--:--' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-lg">
                                {{ $infraction->heureSortie ?? '--:--' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($infraction->status === 'retard')
                                <span class="bg-amber-50 text-amber-600 font-bold px-3 py-1 rounded-full text-xs border border-amber-200">Retard</span>
                            @elseif($infraction->status === 'absent')
                                <span class="bg-red-50 text-[#b11d40] font-bold px-3 py-1 rounded-full text-xs border border-red-200">Absent</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            @if($infraction->justification)
                                <p class="text-xs text-slate-500 truncate">{{ $infraction->justification }}</p>
                                @if($infraction->typejustif)
                                    <span class="text-[10px] font-bold text-indigo-500 uppercase">{{ $infraction->typejustif }}</span>
                                @endif
                            @else
                                <span class="text-slate-300 text-xs italic">Aucune justification</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if(!$infraction->justification)
                            <button type="button"
                                onclick="openJustifModal({{ $infraction->idPointage }})"
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
        @else
        <div class="py-16 text-center">
            <div class="w-16 h-16 mx-auto rounded-2xl bg-emerald-50 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="font-bold text-slate-700">Aucune infraction enregistrée</p>
            <p class="text-sm text-slate-400 mt-1">Continuez comme ça !</p>
        </div>
        @endif
    </div>
</div>

{{-- ═══════════ JUSTIFICATION MODAL ═══════════ --}}
<div id="justifModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeJustifModal()"></div>
    <div class="relative bg-white w-full max-w-lg rounded-[32px] shadow-2xl overflow-hidden flex flex-col z-10" style="animation: modalIn .2s ease-out">

        {{-- Header --}}
        <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
            <div>
                <h2 class="text-lg font-black text-slate-800">Soumettre une Justification</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Infraction · Access Morocco</p>
            </div>
            <button type="button" onclick="closeJustifModal()"
                class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] hover:border-[#be2346]/30 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Form --}}
        <form action="{{ route('justification.submit') }}" method="POST" enctype="multipart/form-data" class="p-7 space-y-5">
            @csrf
            <input type="hidden" name="idPointage" id="justif-idPointage">

            <div class="space-y-1.5">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Type de Justification <span class="text-[#be2346]">*</span></label>
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
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Motif de justification <span class="text-[#be2346]">*</span></label>
                <textarea name="justification" rows="4" required
                    placeholder="Expliquez la raison de votre retard ou absence..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 max-length-500"></textarea>
            </div>

            <div class="space-y-1.5">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Pièce Justificative (PDF, JPG, PNG)</label>
                <input type="file" name="fichier" accept=".pdf,.jpg,.jpeg,.png"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:font-bold file:bg-[#be2346] file:text-white file:cursor-pointer">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeJustifModal()"
                    class="flex-1 py-3.5 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm">
                    Annuler
                </button>
                <button type="submit"
                    class="flex-1 py-3.5 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-[#be2346]/20 text-sm">
                    Envoyer
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.95) translateY(8px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }
</style>

<script>
    // ─── Live Clock ───────────────────────────────────────────────────────────
    function updateClock() {
        const now = new Date();
        const hh = String(now.getHours()).padStart(2, '0');
        const mm = String(now.getMinutes()).padStart(2, '0');
        const ss = String(now.getSeconds()).padStart(2, '0');
        const el = document.getElementById('live-clock');
        if (el) el.textContent = `${hh}:${mm}:${ss}`;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // ─── GPS + Submit ─────────────────────────────────────────────────────────
    function getLocationAndSubmit(action) {
        const statusEl = document.getElementById(action === 'checkin' ? 'gps-status-in' : 'gps-status-out');
        const gpsInput = document.getElementById(action === 'checkin' ? 'gps-checkin' : 'gps-checkout');
        const form     = document.getElementById(action === 'checkin' ? 'checkin-form' : 'checkout-form');

        statusEl.textContent = '📡 Localisation en cours...';

        if (!navigator.geolocation) {
            statusEl.textContent = '❌ Géolocalisation non supportée.';
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (position) => {
                const lat = position.coords.latitude.toFixed(7);
                const lon = position.coords.longitude.toFixed(7);
                gpsInput.value = `${lat},${lon}`;
                statusEl.textContent = `✅ Position: ${lat}, ${lon}`;
                form.submit();
            },
            (error) => {
                let msg = '❌ Erreur de localisation.';
                if (error.code === error.PERMISSION_DENIED)    msg = '❌ Permission refusée. Activez la localisation.';
                if (error.code === error.POSITION_UNAVAILABLE) msg = '❌ Position indisponible.';
                if (error.code === error.TIMEOUT)              msg = '❌ Délai expiré.';
                statusEl.textContent = msg;
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    }

    // ─── Justification Modal ─────────────────────────────────────────────────
    function openJustifModal(idPointage) {
        document.getElementById('justif-idPointage').value = idPointage;
        const modal = document.getElementById('justifModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeJustifModal() {
        const modal = document.getElementById('justifModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeJustifModal();
    });
</script>
</x-app-layout>
