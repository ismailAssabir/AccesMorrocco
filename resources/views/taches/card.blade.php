<div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all group">
    <div class="flex justify-between items-start gap-2 mb-3">
        <div class="flex items-start justify-between gap-3">
            <h3 class="text-sm font-bold text-slate-800 leading-tight group-hover:text-[#b11d40] transition-colors">{{ $tache->titre }}</h3>
            <button @click="openEditModal({{ json_encode($tache) }})" class="p-1.5 rounded-lg bg-slate-50 text-slate-400 hover:bg-[#b11d40]/10 hover:text-[#b11d40] transition-all opacity-0 group-hover:opacity-100">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            </button>
        </div>
        <div class="flex gap-1">
            <button type="button" @click="confirmDelete('{{ $tache->idTache }}')" class="p-1.5 rounded-lg bg-slate-50 text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all opacity-0 group-hover:opacity-100" title="Supprimer">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            </button>
        </div>
    </div>

    @if($tache->description)
        <p class="text-xs text-slate-500 mb-4 line-clamp-2">{{ $tache->description }}</p>
    @endif

    <div class="flex items-center gap-3 mb-4">
        @if($tache->priorite == 'haute')
            <span class="bg-red-50 text-red-600 text-[10px] font-black uppercase px-2 py-0.5 rounded-md border border-red-100">Haute</span>
        @elseif($tache->priorite == 'moyenne')
            <span class="bg-amber-50 text-amber-600 text-[10px] font-black uppercase px-2 py-0.5 rounded-md border border-amber-100">Moyenne</span>
        @else
            <span class="bg-blue-50 text-blue-600 text-[10px] font-black uppercase px-2 py-0.5 rounded-md border border-blue-100">Basse</span>
        @endif

        @if($tache->dateDebut && $tache->duree)
            @php
                $start = \Carbon\Carbon::parse($tache->dateDebut);
                $end = \Carbon\Carbon::parse($tache->duree);
                $duration = $start->diffInDays($end);
            @endphp
            <div class="flex items-center gap-1 text-[10px] font-bold text-[#b11d40] bg-[#b11d40]/5 px-2 py-0.5 rounded-md">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $duration }} Jours
            </div>
        @endif

        @if($tache->departement)
            <div class="flex items-center gap-1 text-[10px] font-bold text-blue-500 bg-blue-50 px-2 py-0.5 rounded-md">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                {{ $tache->departement->title }}
            </div>
        @endif
    </div>

    <div class="flex items-center justify-between pt-3 border-t border-slate-50">
        <div class="flex flex-col gap-1.5">
            @forelse($tache->users as $assignedUser)
                <div class="flex items-center gap-2 group/user">
                    <form action="{{ route('tasks.unassign') }}" method="POST" class="flex items-center">
                        @csrf
                        <input type="hidden" name="idTache" value="{{ $tache->idTache }}">
                        <input type="hidden" name="idUser" value="{{ $assignedUser->idUser }}">
                        <button type="submit" class="w-5 h-5 rounded-md bg-red-50 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Retirer">
                            <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </form>
                    <span class="text-[10px] font-bold text-slate-600">{{ $assignedUser->firstName }} {{ $assignedUser->lastName }}</span>
                </div>
            @empty
                <div class="text-[10px] font-bold text-slate-300 italic">Non assigné</div>
            @endforelse
        </div>

        <div class="flex gap-1">
            @if($tache->status != 'todo')
                <form action="{{ route('tasks.updateStatus', $tache->idTache) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="{{ $tache->status == 'termine' ? 'en_cours' : 'todo' }}">
                    <button type="submit" class="p-1.5 rounded-lg bg-slate-50 text-slate-400 hover:bg-slate-100 transition-all" title="Reculer">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                </form>
            @endif

            @if($tache->status != 'termine')
                <form action="{{ route('tasks.updateStatus', $tache->idTache) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="{{ $tache->status == 'todo' ? 'en_cours' : 'termine' }}">
                    <button type="submit" class="p-1.5 rounded-lg bg-[#b11d40]/5 text-[#b11d40] hover:bg-[#b11d40]/10 transition-all" title="Avancer">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
