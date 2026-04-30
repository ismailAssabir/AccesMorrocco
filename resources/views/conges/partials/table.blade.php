@forelse($conges as $conge)
@php
    $empName = $conge->user ? trim(($conge->user->firstName ?? '') . ' ' . ($conge->user->lastName ?? '')) : 'Employé';
@endphp
<tr class="hover:bg-slate-50 transition-colors">
    <td class="px-6 py-4 font-bold text-slate-800">#{{ $conge->idConge }}</td>
    <td class="px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs shrink-0">
                {{ mb_substr($empName, 0, 1) }}
            </div>
            <span class="font-bold text-slate-800">{{ $empName }}</span>
        </div>
    </td>
    <td class="px-6 py-4 font-bold text-slate-600 capitalize">
        {{ str_replace('_', ' ', $conge->type) }}
    </td>
    <td class="px-6 py-4 text-slate-500">
        <div class="text-xs">
            <span class="block">Du: <span class="font-bold text-slate-700">{{ $conge->dateDebut }}</span></span>
            <span class="block mt-0.5">Au: <span class="font-bold text-slate-700">{{ $conge->dateFin }}</span></span>
        </div>
    </td>
    <td class="px-6 py-4 font-bold text-slate-600">
        {{ $conge->dateDemande }}
    </td>
    <td class="px-6 py-4">
        @if($conge->status == 'approuve')
            <span class="bg-emerald-50 text-emerald-600 font-bold px-3 py-1 rounded-full text-xs border border-emerald-200">Approuvé</span>
        @elseif($conge->status == 'refuse')
            <span class="bg-red-50 text-red-600 font-bold px-3 py-1 rounded-full text-xs border border-red-200">Refusé</span>
        @else
            <span class="bg-amber-50 text-amber-600 font-bold px-3 py-1 rounded-full text-xs border border-amber-200">En attente</span>
        @endif
    </td>
    <td class="px-6 py-4 text-right">
        <div class="flex items-center justify-end gap-2">
            {{-- Eye icon for everyone (show details) --}}
            <button onclick="openShowCongeModal('{{ $conge->idConge }}')" class="text-slate-400 hover:text-blue-500 bg-white hover:bg-blue-50 p-2 rounded-lg border border-slate-200 transition-colors shadow-sm" title="Voir les détails">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
            </button>

            {{-- Admin actions: Accept/Reject --}}
            @if(auth()->user()->type === 'admin' || auth()->user()->type === 'manager')
                @if($conge->status != 'approuve')
                    <form action="{{ route('conge.update', $conge->idConge) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="approuve">
                        <button type="submit" class="text-emerald-500 hover:text-emerald-600 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 p-2 rounded-lg transition-colors shadow-sm" title="Approuver">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </button>
                    </form>
                @endif
                
                @if($conge->status != 'refuse')
                    <form action="{{ route('conge.update', $conge->idConge) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="refuse">
                        <button type="submit" class="text-[#b11d40] hover:text-[#911633] bg-[#b11d40]/10 hover:bg-[#b11d40]/20 border border-[#b11d40]/30 p-2 rounded-lg transition-colors shadow-sm" title="Refuser">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </form>
                @endif
            @endif

            {{-- Edit restriction (Owner only when En attente) --}}
            @if(auth()->check() && (auth()->user()->idUser == $conge->idUser || auth()->id() == $conge->idUser) && $conge->status == 'en_attente')
                <button onclick="openEditCongeModal('{{ $conge->idConge }}')" class="text-amber-500 hover:text-amber-600 bg-amber-50 hover:bg-amber-100 border border-amber-200 p-2 rounded-lg transition-colors shadow-sm" title="Modifier">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                </button>
            @endif

            {{-- Delete restriction (Admin OR (Owner + En attente)) --}}
            @if(auth()->user()->type === 'admin' || ((auth()->user()->idUser == $conge->idUser || auth()->id() == $conge->idUser) && $conge->status == 'en_attente'))
                <button type="button" onclick="confirmDeleteConge('{{ $conge->idConge }}', '{{ route('conge.destroy', $conge->idConge) }}')" class="text-slate-500 hover:text-red-600 bg-slate-50 hover:bg-red-50 border border-slate-200 p-2 rounded-lg transition-colors shadow-sm" title="Supprimer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
            @endif
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="px-6 py-10 text-center text-slate-500 font-medium">
        Aucune demande de congé trouvée.
    </td>
</tr>
@endforelse
