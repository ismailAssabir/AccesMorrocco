@forelse($reunions as $reunion)
<tr class="hover:bg-slate-50 transition-colors group">
    <td class="px-6 py-4">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-black text-slate-800 truncate">{{ $reunion->titre }}</p>
                <p class="text-[11px] text-slate-500 font-medium truncate">{{ $reunion->objectif }}</p>
            </div>
        </div>
    </td>
    <td class="px-6 py-4">
        <div class="flex flex-col">
            <span class="text-xs font-bold text-slate-700">{{ $reunion->dateHeure->translatedFormat('d M Y') }}</span>
            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">{{ $reunion->dateHeure->format('H:i') }}</span>
        </div>
    </td>
    <td class="px-6 py-4">
        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $reunion->type === 'Présentiel' ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600' }}">
            {{ $reunion->type }}
        </span>
    </td>
    <td class="px-6 py-4">
        <div class="flex items-center gap-2">
            @if($reunion->idDepartement)
                <span class="text-[10px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-md">{{ $reunion->departement->title }}</span>
            @elseif($reunion->participants->count() > 0)
                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">Individuel</span>
            @else
                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">Public</span>
            @endif
        </div>
    </td>
    <td class="px-6 py-4">
        <div class="flex -space-x-2">
            @foreach($reunion->participants->take(3) as $p)
                <div class="w-7 h-7 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-[9px] font-black text-slate-600" title="{{ $p->firstName }}">
                    {{ substr($p->firstName, 0, 1) }}
                </div>
            @endforeach
            @if($reunion->participants->count() > 3)
                <div class="w-7 h-7 rounded-full border-2 border-white bg-slate-800 flex items-center justify-center text-[9px] font-black text-white">
                    +{{ $reunion->participants->count() - 3 }}
                </div>
            @endif
        </div>
    </td>
    <td class="px-6 py-4 text-right">
        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
            <a href="{{ route('reunions.show', $reunion->idReunion) }}" class="p-2 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 transition-colors" title="Détails">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </a>
            @if(auth()->user()->type !== 'employee')
            <button onclick='openEditModal({!! e(json_encode($reunion)) !!})' class="p-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </button>
            <button onclick="confirmDeleteReunion({{ $reunion->idReunion }})" class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
            @endif
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="px-6 py-20 text-center">
        <div class="flex flex-col items-center justify-center space-y-4">
            <div class="w-16 h-16 rounded-3xl bg-slate-50 flex items-center justify-center text-slate-300">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <p class="text-slate-400 font-bold tracking-tight">Aucune réunion trouvée.</p>
        </div>
    </td>
</tr>
@endforelse

@if($reunions->hasPages())
<tr class="meetings-pagination">
    <td colspan="6" class="px-6 py-4 bg-slate-50/50">
        {{ $reunions->links('vendor.pagination.tailwind_saas') }}
    </td>
</tr>
@endif
