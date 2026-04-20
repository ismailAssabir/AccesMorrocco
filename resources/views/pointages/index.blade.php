<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

        {{-- ═══════════ TOP BAR ═══════════ --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Pointage des Employés</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Consultez les heures d'arrivée et de départ de votre équipe.</p>
            </div>
            <button class="flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter
            </button>
        </div>

        {{-- ═══════════ KPI STRIP ═══════════ --}}
        @php
            $totalPointages = $pointages->count();
            $presents = $pointages->where('status', 'Présent')->count();
            $retards = $pointages->where('status', 'En retard')->count();
            $absents = $pointages->where('status', 'Absent')->count();
        @endphp
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-slate-400 flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-slate-100 text-slate-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Total</p>
                    <p class="text-2xl font-extrabold text-slate-800">{{ $totalPointages }}</p>
                </div>
            </div>
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-emerald-400 flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-emerald-50 text-emerald-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Présents</p>
                    <p class="text-2xl font-extrabold text-emerald-500">{{ $presents }}</p>
                </div>
            </div>
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-amber-400 flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-amber-50 text-amber-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">En Retard</p>
                    <p class="text-2xl font-extrabold text-amber-500">{{ $retards }}</p>
                </div>
            </div>
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-[#b11d40] flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-red-50 text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Absents</p>
                    <p class="text-2xl font-extrabold text-[#b11d40]">{{ $absents }}</p>
                </div>
            </div>
        </div>

        {{-- ═══════════ MAIN CONTENT ═══════════ --}}
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-extrabold text-slate-500 tracking-wider">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Employé</th>
                            <th class="px-6 py-4">Check-in</th>
                            <th class="px-6 py-4">Check-out</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($pointages as $pointage)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-800">#{{ $pointage['id'] }}</td>
                            <td class="px-6 py-4 font-bold text-slate-700">{{ $pointage['employe'] }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-slate-100 text-slate-600 font-mono text-xs px-2 py-1 rounded">
                                    {{ $pointage['checkin'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-slate-100 text-slate-600 font-mono text-xs px-2 py-1 rounded">
                                    {{ $pointage['checkout'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($pointage['status'] == 'Présent')
                                    <span class="bg-emerald-50 text-emerald-600 font-bold px-3 py-1 rounded-full text-xs">Présent</span>
                                @elseif($pointage['status'] == 'En retard')
                                    <span class="bg-amber-50 text-amber-600 font-bold px-3 py-1 rounded-full text-xs">En retard</span>
                                @else
                                    <span class="bg-red-50 text-red-600 font-bold px-3 py-1 rounded-full text-xs">Absent</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-slate-400 hover:text-[#b11d40] transition-colors p-1">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
