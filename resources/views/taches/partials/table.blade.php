<div id="tasks-table" class="bg-white border border-slate-200 rounded-[24px] overflow-hidden shadow-sm transition-all duration-300">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50/80">
                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Tâche</th>
                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Priorité</th>
                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Statut</th>
                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Assignés</th>
                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Échéance</th>
                @if(auth()->user()->can('tache.edit') || auth()->user()->can('tache.delete'))
                    <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($taches as $tache)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-slate-800">{{ $tache->titre }}</span>
                            @if($tache->departement)
                                <span class="text-[10px] text-slate-400 font-medium">{{ $tache->departement->title }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="{{ $tache->priority_config['bg'] }} {{ $tache->priority_config['text'] }} text-[9px] font-black tracking-widest px-2 py-0.5 rounded-lg border {{ str_replace('bg-', 'border-', $tache->priority_config['bg']) }} uppercase">
                            {{ $tache->priority_config['label'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusMap = [
                                'todo' => ['label' => 'À Faire', 'class' => 'bg-slate-100 text-slate-500 border-slate-200'],
                                'en_cours' => ['label' => 'En Cours', 'class' => 'bg-blue-50 text-blue-500 border-blue-200'],
                                'termine' => ['label' => 'Terminé', 'class' => 'bg-emerald-50 text-emerald-500 border-emerald-200'],
                            ];
                            $currStatus = $statusMap[$tache->status] ?? $statusMap['todo'];
                        @endphp
                        <span class="{{ $currStatus['class'] }} text-[9px] font-black tracking-widest px-2 py-0.5 rounded-lg border uppercase">
                            {{ $currStatus['label'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex -space-x-2">
                            @foreach($tache->users as $u)
                                <div class="w-6 h-6 rounded-lg bg-slate-100 border border-white flex items-center justify-center text-[8px] font-black text-[#be2346] shadow-sm" title="{{ $u->firstName }} {{ $u->lastName }}">
                                    {{ substr($u->firstName, 0, 1) }}
                                </div>
                            @endforeach
                            @if($tache->users->isEmpty())
                                <span class="text-[10px] text-slate-400 italic">Non assigné</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($tache->duree)
                            <div class="flex flex-col">
                                <span class="text-[11px] font-bold {{ $tache->is_overdue ? 'text-red-500' : 'text-slate-600' }}">
                                    {{ $tache->duree->format('d/m/Y') }}
                                </span>
                                <span class="text-[9px] text-slate-400">{{ $tache->formatted_duration }}</span>
                            </div>
                        @else
                            <span class="text-[10px] text-slate-400">-</span>
                        @endif
                    </td>
                    @if(auth()->user()->can('tache.edit') || auth()->user()->can('tache.delete'))
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <button @click="openEditModal({{ json_encode($tache) }})" class="p-2 rounded-xl text-slate-400 hover:bg-[#be2346]/10 hover:text-[#be2346] transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button @click="confirmDelete('{{ $tache->idTache }}')" class="p-2 rounded-xl text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                    </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ (auth()->user()->can('tache.edit') || auth()->user()->can('tache.delete')) ? 6 : 5 }}" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-10 h-10 text-slate-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <span class="text-sm font-bold text-slate-400 uppercase tracking-widest">Aucune tâche trouvée</span>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($taches instanceof \Illuminate\Pagination\LengthAwarePaginator && $taches->hasPages())
        <div class="px-6 py-4 bg-white border-t border-slate-100 tasks-pagination">
            {{ $taches->links('vendor.pagination.tailwind_saas') }}
        </div>
    @endif
</div>
