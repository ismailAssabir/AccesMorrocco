@if($departements->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($departements as $dept)
            @php
                $isManager = $dept->manager && $dept->manager->type === 'manager';
                $managerName = $isManager ? trim($dept->manager->firstName . ' ' . $dept->manager->lastName) : null;
                $managerInitials = $managerName ? strtoupper(mb_substr($dept->manager->firstName, 0, 1) . mb_substr($dept->manager->lastName, 0, 1)) : '?';

                $presence = round($dept->avg_presence ?? 0);
                $tasks = $dept->tasks_count > 0 ? round(($dept->completed_tasks_count / $dept->tasks_count) * 100) : 0;
                $empCount = $dept->users_count ?? 0;

                $avatarColors = ['bg-[#b11d40]','bg-blue-500','bg-emerald-500','bg-amber-500','bg-violet-500'];
            @endphp

            <div class="dept-card bg-white border border-slate-200 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden group" data-dept-id="{{ $dept->idDepartement ?? $dept->id }}">

                {{-- Red top accent --}}
                <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

                <div class="p-6 flex-1 flex flex-col gap-5">

                    {{-- Title Row --}}
                    <div class="flex items-start gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-[#b11d40]/10 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-[#b11d40]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1v1H9V7zm5 0h1v1h-1V7zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1z"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base font-extrabold text-slate-800 truncate">{{ $dept->title }}</h3>
                            <p class="text-[11px] text-slate-400 truncate mt-0.5">{{ $dept->description ?? 'Aucune description' }}</p>
                        </div>
                        
                        {{-- Edit Button --}}
                        <button type="button" onclick="openEditDeptModal('{{ $dept->idDepartement ?? $dept->id }}', '{{ addslashes($dept->title) }}', '{{ addslashes($dept->description) }}', '{{ $dept->idUser }}')" class="shrink-0 text-slate-300 hover:text-[#b11d40] transition-colors p-1 mr-1" title="Modifier">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        
                        {{-- Delete Button --}}
                        <button type="button" onclick="confirmDeleteDept('{{ route('departements.destroy', $dept->idDepartement ?? $dept->id ) }}')" class="shrink-0 text-slate-300 hover:text-red-500 transition-colors p-1" title="Supprimer">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>

                    {{-- Manager --}}
                    <div class="flex items-center gap-3 bg-slate-50 rounded-2xl px-4 py-3">
                        @if($managerName)
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#7c1233] to-[#b11d40] flex items-center justify-center font-black text-xs text-white shadow-sm shrink-0">
                                {{ $managerInitials }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Manager</p>
                                <p class="text-sm font-bold text-slate-700 truncate">{{ $managerName }}</p>
                            </div>
                        @else
                            <div class="w-9 h-9 rounded-xl bg-slate-200 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Manager</p>
                                <p class="text-sm text-slate-400 italic">Aucun manager assigné</p>
                            </div>
                        @endif
                    </div>

                    {{-- Progress Bars --}}
                    <div class="space-y-3">
                        {{-- Présence --}}
                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest flex items-center gap-1.5">
                                    <span class="presence-dot w-1.5 h-1.5 rounded-full {{ $presence >= 80 ? 'bg-emerald-400' : ($presence >= 40 ? 'bg-amber-400' : 'bg-red-400') }} inline-block"></span>
                                    Présence
                                </span>
                                <span class="presence-text text-xs font-extrabold {{ $presence >= 80 ? 'text-emerald-500' : ($presence >= 40 ? 'text-amber-500' : 'text-red-500') }}">{{ $presence }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                <div class="presence-bar h-2 rounded-full transition-all duration-700 {{ $presence >= 80 ? 'bg-emerald-400' : ($presence >= 40 ? 'bg-amber-400' : 'bg-red-400') }}" style="width: {{ $presence }}%"></div>
                            </div>
                        </div>
                        {{-- Tâches --}}
                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest flex items-center gap-1.5">
                                    <span class="tasks-dot w-1.5 h-1.5 rounded-full {{ $tasks >= 80 ? 'bg-emerald-400' : ($tasks >= 50 ? 'bg-blue-400' : 'bg-amber-400') }} inline-block"></span>
                                    Tâches
                                </span>
                                <span class="tasks-text text-xs font-extrabold {{ $tasks >= 80 ? 'text-emerald-500' : ($tasks >= 50 ? 'text-blue-500' : 'text-amber-500') }}">{{ $tasks }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                <div class="tasks-bar h-2 rounded-full transition-all duration-700 {{ $tasks >= 80 ? 'bg-emerald-400' : ($tasks >= 50 ? 'bg-blue-400' : 'bg-amber-400') }}" style="width: {{ $tasks }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Footer --}}
                <div class="border-t border-slate-100 bg-slate-50/60 px-6 py-4 flex items-center justify-between">
                    {{-- Avatar Stack --}}
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-2">
                            @for($i = 0; $i < min($empCount, 4); $i++)
                                <div class="w-8 h-8 rounded-xl {{ $avatarColors[$i % count($avatarColors)] }} border-2 border-white flex items-center justify-center text-[10px] font-black text-white shadow-sm">
                                    {{ chr(65 + $i) }}
                                </div>
                            @endfor
                            @if($empCount > 4)
                                <div class="w-8 h-8 rounded-xl bg-slate-200 border-2 border-white flex items-center justify-center text-[9px] font-black text-slate-500 shadow-sm">
                                    +{{ $empCount - 4 }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-extrabold text-slate-700">{{ $empCount }}</p>
                            <p class="text-[10px] text-slate-400 font-medium">employé{{ $empCount > 1 ? 's' : '' }}</p>
                        </div>
                    </div>

                    {{-- Gérer Button --}}
                    <a href="{{ route('departements.show', $dept->idDepartement ) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#b11d40] border border-[#b11d40]/30 hover:bg-[#b11d40] hover:text-white px-4 py-2 rounded-xl transition-all duration-200 active:scale-95">
                        Gérer
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@else
    {{-- Empty State --}}
    <div class="flex flex-col items-center justify-center bg-white border border-slate-200 rounded-3xl shadow-sm py-20 px-8 text-center">
        <div class="w-20 h-20 rounded-3xl bg-[#b11d40]/10 flex items-center justify-center mb-5">
            <svg class="w-10 h-10 text-[#b11d40]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1v1H9V7zm5 0h1v1h-1V7zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1z"/></svg>
        </div>
        <h3 class="text-xl font-extrabold text-slate-800">Aucun département trouvé</h3>
        <p class="text-slate-500 mt-2 max-w-sm text-sm">Essayez d'ajuster vos filtres ou créez un nouveau département.</p>
        <button onclick="openDeptModal()" class="mt-6 flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] text-white px-6 py-3 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm active:scale-95">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Nouveau département
        </button>
    </div>
@endif
