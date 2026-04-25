<aside class="sidebar-wrapper w-72 h-screen sticky top-0 bg-[#0F1115] text-white flex flex-col font-sans border-r border-white/5 shadow-2xl">
    {{-- ═══════════════ TOP SECTION (fixed) ═══════════════ --}}
    <div class="flex-shrink-0">
        <div class="flex items-center gap-4 px-6 py-10">
            <div class="bg-gradient-to-br from-[#7c1233] to-[#be2346] p-2 rounded-xl shadow-lg flex-shrink-0 border border-white/10">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain filter brightness-0 invert"
                    onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0id2hpdGUiPjxwYXRoIGQ9Ik0xMiAyTDggMjJoNGwyLTNoMTJsNC00aC00TDQgMnptNiAxNUg5bDMtNiAzIDZ6Ii8+PC9zdmc+'">
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-bold tracking-tight text-white leading-tight">ACCESS</span>
                <span class="text-[#be2346] font-extrabold text-[10px] tracking-[0.4em] uppercase">Morocco</span>
            </div>
        </div>

        <div class="px-4 mb-2">
            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}" 
                class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
                {{ request()->routeIs('dashboard') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">
                    
                    <div class="transition-transform duration-300 {{ request()->routeIs('dashboard') ? '' : 'group-hover:rotate-12' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'group-hover:text-[#be2346]' }} transition-colors" 
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" 
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="font-medium text-sm">Accueil</span>
                </a>
            </nav>
        </div>
    </div>
    {{-- ═══════════════ MIDDLE SECTION (scrollable) ═══════════════ --}}
    <div class="flex-1 overflow-y-auto custom-scrollbar min-h-0 px-4">
        <div class="px-4 mb-6">
            <p class="text-[10px] font-bold text-white/30 uppercase tracking-[0.25em] flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-[#be2346]"></span>
                Gestion Interne
            </p>
        </div>

        <nav class="space-y-1">
            
@if(auth()->user()->type !== 'employee')
    @can('user.view')
      <a href="{{ url('/users') }}" 
   class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
   {{ request()->is('users*') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">
    
    <div class="transition-transform duration-300 {{ request()->is('users*') ? '' : 'group-hover:rotate-12' }}">
        <svg class="w-5 h-5 {{ request()->is('users*') ? 'text-white' : 'group-hover:text-[#be2346]' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </div>
    <span class="font-medium text-sm">Ressources Humaines</span>
</a>
@endcan
@endif


@if(auth()->user()->type !== 'employee')
            @can('departement.view')
            <a href="/departements" 

               class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
               {{ request()->is('departements*') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">
                <div class="transition-transform duration-300 {{ request()->is('departements*') ? '' : 'group-hover:rotate-12' }}">
                    <svg class="w-5 h-5 {{ request()->is('departements*') ? 'text-white' : 'group-hover:text-[#be2346]' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="font-medium text-sm">Département</span>
            </a>
            @endcan
@endif
<<<<<<< HEAD

            <a href="{{ route('pointages.index') }}" 
=======
            @can('pointage.view')
            <a href="{{ Route::has('pointages.index') ? route('pointages.index') : '#' }}" 
>>>>>>> 7f66f8f966f514da8a3288712e728d31919943c9
               class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
               {{ request()->routeIs('pointages.index') || request()->routeIs('admin.pointages.index') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">
                <div class="transition-transform duration-300 {{ request()->routeIs('pointages.index') || request()->routeIs('admin.pointages.index') ? '' : 'group-hover:rotate-12' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('pointages.index') || request()->routeIs('admin.pointages.index') ? 'text-white' : 'group-hover:text-[#be2346]' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="font-medium text-sm">Pointage</span>
            </a>
            @endcan
            @can('tache.view')
            <a href="{{ Route::has('tasks.index') ? route('tasks.index') : '#' }}" 
               class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
               {{ request()->routeIs('tasks.index') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">
                <div class="transition-transform duration-300 {{ request()->routeIs('tasks.index') ? '' : 'group-hover:rotate-12' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('tasks.index') ? 'text-white' : 'group-hover:text-[#be2346]' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="font-medium text-sm">Gestion des tâches</span>
            </a>
            @endcan
            @can('reunion.view')
            <a href="{{ Route::has('meetings.index') ? route('meetings.index') : '#' }}" 
               class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
               {{ request()->routeIs('meetings.index') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">
                <div class="transition-transform duration-300 {{ request()->routeIs('meetings.index') ? '' : 'group-hover:rotate-12' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('meetings.index') ? 'text-white' : 'group-hover:text-[#be2346]' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="font-medium text-sm">Réunions</span>
            </a>
            @endcan
            @can('objectif.view')
            <a href="{{ Route::has('goals.index') ? route('goals.index') : '#' }}" 
               class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
               {{ request()->routeIs('goals.index') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">
                <div class="transition-transform duration-300 {{ request()->routeIs('goals.index') ? '' : 'group-hover:rotate-12' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('goals.index') ? 'text-white' : 'group-hover:text-[#be2346]' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="font-medium text-sm">Objectifs</span>
            </a>
            @endcan
            @can('conge.view')
            <a href="{{ Route::has('conge.index') ? route('conge.index') : '#' }}" 
               class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
               {{ request()->routeIs('conge.index') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">
                <div class="transition-transform duration-300 {{ request()->routeIs('conge.index') ? '' : 'group-hover:rotate-12' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('conge.index') ? 'text-white' : 'group-hover:text-[#be2346]' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="font-medium text-sm">Congés</span>
            </a>
            @endcan
            @can('reclamation.view')
       <a href="/reclamations" 
   class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
   {{ request()->is('reclamations') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">
    
    <div class="transition-transform duration-300 {{ request()->is('reclamations') ? '' : 'group-hover:rotate-12' }}">
        <svg class="w-5 h-5 {{ request()->is('reclamations') ? 'text-white' : 'group-hover:text-[#be2346]' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </div>
    
    <span class="font-medium text-sm">Réclamations</span>
</a>
@endcan
        </nav>
    </div>

    {{-- ═══════════════ BOTTOM SECTION (fixed) ═══════════════ --}}
    <div class="flex-shrink-0 px-6 py-8 border-t border-white/5">
        <div class="flex items-center justify-between">
            <a href="{{ route('profile.edit') }}" class="group/profile flex items-center gap-3 min-w-0 p-2 -ml-2 rounded-xl hover:bg-white/5 transition-all duration-300 cursor-pointer">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#7c1233] to-[#be2346] flex items-center justify-center font-black text-xs shadow-lg text-white shrink-0 group-hover/profile:scale-110 group-hover/profile:rotate-3 transition-transform">
                    {{ substr(optional(Auth::user())->firstName ?? 'A', 0, 1) }}{{ substr(optional(Auth::user())->lastName ?? 'D', 0, 1) }}
                </div>
                
                <div class="flex flex-col min-w-0">
                    <p class="text-sm font-bold tracking-tight text-white leading-tight truncate group-hover/profile:text-[#be2346] transition-colors">
                        {{ optional(Auth::user())->firstName ?? 'Admin' }} {{ optional(Auth::user())->lastName ?? 'User' }}
                    </p>
                    <p class="text-[10px] text-[#be2346] uppercase font-black tracking-widest mt-0.5 opacity-80 group-hover/profile:opacity-100 transition-opacity">
                        {{ optional(Auth::user())->role ?? 'Admin' }}
                    </p>
                </div>
            </a>

            <button type="button" onclick="confirmLogout()"
                class="group p-2.5 rounded-lg bg-white/5 hover:bg-red-600/20 border border-white/5 hover:border-red-600/40 transition-all duration-300 active:scale-90"
                title="Quitter">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    class="w-5 h-5 text-white/40 group-hover:text-[#be2346] transition-all duration-300" 
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
        </div>
    </div>
</aside>
