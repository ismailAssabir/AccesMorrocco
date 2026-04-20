<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

        {{-- ═══════════ TOP BAR ═══════════ --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Gestion des Tâches</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Suivez l'avancement des projets et des assignations.</p>
            </div>
            <button class="flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter
            </button>
        </div>

        {{-- ═══════════ KPI STRIP ═══════════ --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-blue-400 flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-blue-50 text-blue-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Total Tâches</p>
                    <p class="text-2xl font-extrabold text-slate-800">{{ $tasks->count() }}</p>
                </div>
            </div>
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-[#b11d40] flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-red-50 text-[#b11d40]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Critiques / Hautes</p>
                    <p class="text-2xl font-extrabold text-[#b11d40]">{{ $tasks->whereIn('priority', ['Critique', 'Haute'])->count() }}</p>
                </div>
            </div>
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-emerald-400 flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-emerald-50 text-emerald-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Complétées</p>
                    <p class="text-2xl font-extrabold text-emerald-500">{{ $tasks->where('progress', '>=', 100)->count() }}</p>
                </div>
            </div>
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-amber-400 flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-amber-50 text-amber-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Prog. Moyenne</p>
                    <p class="text-2xl font-extrabold text-amber-500">{{ round($tasks->avg('progress')) }}%</p>
                </div>
            </div>
        </div>

        {{-- ═══════════ MAIN CONTENT ═══════════ --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tasks as $task)
            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden">
                <div class="p-6 flex-1 flex flex-col gap-5">
                    <div class="flex justify-between items-start gap-4 mb-2">
                        <h3 class="text-base font-extrabold text-slate-800 leading-tight">{{ $task['title'] }}</h3>
                        @if($task['priority'] == 'Critique')
                            <span class="bg-red-100 text-red-600 border border-red-200 font-bold px-2.5 py-1 rounded-lg text-[10px] uppercase tracking-wider shrink-0">Critique</span>
                        @elseif($task['priority'] == 'Haute')
                            <span class="bg-orange-100 text-orange-600 border border-orange-200 font-bold px-2.5 py-1 rounded-lg text-[10px] uppercase tracking-wider shrink-0">Haute</span>
                        @else
                            <span class="bg-blue-100 text-blue-600 border border-blue-200 font-bold px-2.5 py-1 rounded-lg text-[10px] uppercase tracking-wider shrink-0">{{ $task['priority'] }}</span>
                        @endif
                    </div>
                    
                    <div class="flex items-center gap-2 text-slate-500 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Échéance: <span class="font-bold text-slate-700">{{ $task['deadline'] }}</span></span>
                    </div>

                    <div class="space-y-2 mt-auto">
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-black text-slate-500 uppercase text-[10px] tracking-widest">Progression</span>
                            <span class="font-extrabold text-slate-800">{{ $task['progress'] }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="h-2 rounded-full transition-all duration-700 bg-gradient-to-r from-[#b11d40] to-[#7c1233]" style="width: {{ $task['progress'] }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="border-t border-slate-100 bg-slate-50/60 px-6 py-4 flex justify-between items-center">
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full bg-blue-500 border-2 border-white flex items-center justify-center text-[10px] font-black text-white shadow-sm">K</div>
                        <div class="w-8 h-8 rounded-full bg-emerald-500 border-2 border-white flex items-center justify-center text-[10px] font-black text-white shadow-sm">S</div>
                    </div>
                    <button class="inline-flex items-center gap-1.5 text-xs font-bold text-[#b11d40] hover:text-[#7c1233]">
                        Gérer <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
