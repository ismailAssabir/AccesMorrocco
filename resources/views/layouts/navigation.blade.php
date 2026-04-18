<nav class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-gray-100 px-8 py-3">
    <div class="flex items-center justify-end">
        
        <div class="flex items-center gap-6">
            
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400 group-focus-within:text-[#be2346] transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" 
                    placeholder="Rechercher..." 
                    class="block w-64 group-focus-within:w-80 pl-11 pr-4 py-2 border-none bg-gray-100/60 rounded-xl text-sm placeholder-gray-400 focus:ring-2 focus:ring-[#be2346]/10 focus:bg-white transition-all duration-300">
            </div>

            <div class="h-6 w-[1px] bg-gray-200"></div>

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" 
                    class="relative p-2 rounded-xl hover:bg-[#be2346]/5 transition-all duration-300 group">
                    
                    <span class="absolute top-2 right-2 flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#be2346] opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-[#be2346]"></span>
                    </span>
                    
                    <svg class="w-6 h-6 text-gray-500 group-hover:text-[#be2346] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>

                <div x-show="open" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    @click.away="open = false" 
                    class="absolute right-0 mt-4 w-80 bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-gray-100 overflow-hidden z-50">
                    
                    <div class="px-5 py-4 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#be2346]">Notifications</p>
                    </div>

                    <div class="max-h-64 overflow-y-auto">
                        <div class="p-5 border-b border-gray-50 hover:bg-red-50/30 transition-colors cursor-pointer group">
                            <p class="text-sm font-bold text-gray-800 group-hover:text-[#be2346]">Mise à jour système</p>
                            <p class="text-xs text-gray-500 mt-1">Nouveaux objectifs ajoutés pour le projet Access Morocco.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</nav>