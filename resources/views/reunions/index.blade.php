<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

        {{-- ═══════════ TOP BAR ═══════════ --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Planification des Réunions</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Gérez vos rendez-vous internes et externes.</p>
            </div>
            <button class="flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter
            </button>
        </div>

        {{-- ═══════════ MAIN CONTENT ═══════════ --}}
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden p-6">
            <h2 class="text-lg font-extrabold text-slate-800 mb-6">Prochaines Réunions</h2>
            <div class="space-y-4">
                @foreach($meetings as $meeting)
                <div class="flex flex-col md:flex-row md:items-center gap-4 bg-slate-50 border border-slate-100 p-5 rounded-2xl hover:shadow-md transition-shadow">
                    
                    {{-- Avatar / Icon --}}
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex flex-col items-center justify-center text-indigo-600 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-bold text-slate-800 truncate">{{ $meeting['title'] }}</h3>
                        <p class="text-sm text-slate-500 mt-1 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ \Carbon\Carbon::parse($meeting['date'])->translatedFormat('d M Y, H:i') }}
                        </p>
                    </div>

                    {{-- Meta & Actions --}}
                    <div class="flex items-center gap-4 sm:ml-auto">
                        @if($meeting['type'] == 'Interne')
                            <span class="bg-slate-200 text-slate-700 font-bold px-3 py-1 rounded-lg text-xs">{{ $meeting['type'] }}</span>
                        @elseif($meeting['type'] == 'Externe')
                            <span class="bg-blue-100 text-blue-700 font-bold px-3 py-1 rounded-lg text-xs">{{ $meeting['type'] }}</span>
                        @else
                            <span class="bg-[#b11d40]/10 text-[#b11d40] font-bold px-3 py-1 rounded-lg text-xs">{{ $meeting['type'] }}</span>
                        @endif

                        <button class="text-slate-400 hover:text-[#b11d40] transition-colors p-2 bg-white rounded-lg border border-slate-200 shadow-sm" title="Rejoindre ou Gérer">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
