<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

        {{-- ═══════════ TOP BAR ═══════════ --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Objectifs de l'Entreprise</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Pilotez et suivez les KPI majeurs pour atteindre nos ambitions.</p>
            </div>
            <button class="flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter
            </button>
        </div>

        {{-- ═══════════ MAIN CONTENT ═══════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($goals as $goal)
            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-6 flex flex-col justify-between hover:shadow-xl transition-all duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-[#b11d40]/10 rounded-2xl flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-[#b11d40]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                    @if($goal['status'] == 'Presque terminé')
                        <span class="bg-emerald-100 text-emerald-700 font-bold px-3 py-1 rounded-lg text-xs">{{ $goal['status'] }}</span>
                    @elseif($goal['status'] == 'En retard')
                        <span class="bg-red-100 text-red-700 font-bold px-3 py-1 rounded-lg text-xs">{{ $goal['status'] }}</span>
                    @else
                        <span class="bg-blue-100 text-blue-700 font-bold px-3 py-1 rounded-lg text-xs">{{ $goal['status'] }}</span>
                    @endif
                </div>
                
                <h3 class="text-xl font-black text-slate-800 mb-6">{{ $goal['title'] }}</h3>

                <div>
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Complétion</span>
                        <span class="text-2xl font-extrabold text-slate-800">{{ $goal['progress'] }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-700 bg-gradient-to-r from-[#b11d40] to-rose-400" style="width: {{ $goal['progress'] }}%"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
