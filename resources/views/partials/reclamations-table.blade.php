@forelse($Reclamations as $rec)
<tr class="hover:bg-slate-50/80 transition-colors group">
    <td class="px-6 py-4">
        <span class="text-sm font-bold text-slate-700">{{ $rec->titre }}</span>
    </td>
    <td class="px-6 py-4 text-xs font-bold capitalize text-slate-600">
        @if($rec->priorite == 'haute')
            <span class="bg-red-50 text-red-600 px-2.5 py-1 rounded-lg border border-red-100">Haute</span>
        @elseif($rec->priorite == 'moyenne')
            <span class="bg-amber-50 text-amber-600 px-2.5 py-1 rounded-lg border border-amber-100">Moyenne</span>
        @else
            <span class="bg-slate-50 text-slate-500 px-2.5 py-1 rounded-lg border border-slate-100">Basse</span>
        @endif
    </td>
    <td class="px-6 py-4">
        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $rec->status == 'resolue' ? 'bg-emerald-100 text-emerald-600' : ($rec->status == 'en_cours' ? 'bg-amber-100 text-amber-600' : 'bg-blue-100 text-blue-600') }}">
            {{ str_replace('_', ' ', $rec->status) }}
        </span>
    </td>
    <td class="px-6 py-4">
        <span class="text-[12px] text-slate-500 font-medium">
            {{ $rec->created_at ? $rec->created_at->format('d/m/Y') : 'Date inconnue' }}
        </span>
    </td>
    <td class="px-6 py-4 flex justify-end gap-3">
        <a href="/reclamation/{{ $rec->idReclamation }}" class="p-2 rounded-lg text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-all shadow-sm bg-white border border-slate-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
        </a>
        
        @if(auth()->user()->type !== 'employee')
        <button onclick="confirmDeleteReclamation('{{ $rec->idReclamation }}')" class="p-2 rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-600 transition-all shadow-sm bg-white border border-slate-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
        </button>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="px-6 py-12 text-center">
        <p class="text-slate-400 text-sm font-medium">Aucune réclamation trouvée.</p>
    </td>
</tr>
@endforelse
