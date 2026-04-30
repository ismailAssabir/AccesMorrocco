@forelse($reunions as $reunion)
<div class="flex flex-col md:flex-row md:items-center gap-4 bg-slate-50 border border-slate-100 p-5 rounded-2xl hover:shadow-md transition-shadow relative group animate-fadeIn">
    
    {{-- Avatar / Icon --}}
    <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex flex-col items-center justify-center text-indigo-600 shrink-0 group-hover:scale-105 transition-transform">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
    </div>

    {{-- Info --}}
    <div class="flex-1 min-w-0">
        <h3 class="text-base font-bold text-slate-800 truncate">{{ $reunion->titre }}</h3>
        <p class="text-sm text-slate-500 mt-1 flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            {{ $reunion->dateHeure->translatedFormat('d M Y, H:i') }}
            @if($reunion->lieu)
                <span class="text-slate-300 mx-1">|</span>
                <span class="text-xs font-medium text-slate-400">{{ $reunion->lieu }}</span>
            @endif
        </p>
    </div>

    {{-- Meta & Actions --}}
    <div class="flex items-center gap-4 sm:ml-auto">
        <span class="{{ $reunion->type_color }} font-bold px-3 py-1 rounded-lg text-[10px] uppercase tracking-wider">{{ $reunion->type }}</span>

        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
            <button type="button" onclick='viewReunionDetails({!! e(json_encode($reunion)) !!})' class="flex items-center gap-2 px-4 py-2 bg-slate-200/50 text-slate-600 rounded-xl hover:bg-slate-200 hover:text-slate-800 transition-all font-bold text-xs shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Voir
            </button>

            @if(auth()->user()->type !== 'employee')
            <button type="button" onclick='openEditModal({!! e(json_encode($reunion)) !!})' class="flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all font-bold text-xs shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Modifier
            </button>
            <button type="button" onclick="confirmDeleteReunion({{ $reunion->idReunion }})" class="flex items-center justify-center w-9 h-9 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
            @endif
            @if($reunion->lien)
            <a href="{{ $reunion->lien }}" target="_blank" class="p-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-600/20" title="Rejoindre">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
            @endif
        </div>
    </div>
</div>
@empty
<div class="py-20 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-300 animate-fadeIn">
    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </div>
    <p class="text-slate-400 font-bold tracking-tight">Aucune réunion trouvée.</p>
</div>
@endforelse
