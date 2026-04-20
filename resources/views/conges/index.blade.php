<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

        {{-- ═══════════ TOP BAR ═══════════ --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Demandes de Congés</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Gérez et validez les demandes d'absence.</p>
            </div>
            <button class="flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Nouvelle Demande
            </button>
        </div>

        {{-- ═══════════ MAIN CONTENT ═══════════ --}}
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-extrabold text-slate-500 tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Employé</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Période</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($leaves as $leave)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs shrink-0">
                                        {{ substr($leave['employe'], 0, 1) }}
                                    </div>
                                    <span class="font-bold text-slate-800">{{ $leave['employe'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-600">{{ $leave['type'] }}</td>
                            <td class="px-6 py-4 text-slate-500">
                                <div class="text-xs">
                                    <span class="block">Du: <span class="font-bold text-slate-700">{{ $leave['start'] }}</span></span>
                                    <span class="block mt-0.5">Au: <span class="font-bold text-slate-700">{{ $leave['end'] }}</span></span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($leave['status'] == 'Approuvé')
                                    <span class="bg-emerald-50 text-emerald-600 font-bold px-3 py-1 rounded-full text-xs border border-emerald-200">Approuvé</span>
                                @elseif($leave['status'] == 'Refusé')
                                    <span class="bg-red-50 text-red-600 font-bold px-3 py-1 rounded-full text-xs border border-red-200">Refusé</span>
                                @else
                                    <span class="bg-amber-50 text-amber-600 font-bold px-3 py-1 rounded-full text-xs border border-amber-200">En attente</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button class="text-emerald-500 bg-emerald-50 hover:bg-emerald-100 p-2 rounded-lg transition-colors" title="Approuver">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                                <button class="text-red-500 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors" title="Refuser">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
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
