<aside class="sidebar-wrapper w-72 h-screen sticky top-0 bg-[#0F1115] text-white flex flex-col font-sans border-r border-white/5 shadow-2xl">
    
    <div class="flex-shrink-0">
        <div class="flex items-center gap-4 px-6 py-10">
            <div class="bg-gradient-to-br from-[#7c1233] to-[#be2346] p-2 rounded-xl shadow-lg flex-shrink-0 border border-white/10">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" class="w-8 h-8 object-contain filter brightness-0 invert"
                    onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0id2hpdGUiPjxwYXRoIGQ9Ik0xMiAyTDggMjJoNGwyLTNoMTJsNC00aC00TDQgMnptNiAxNUg5bDMtNiAzIDZ6Ii8+PC9zdmc+'">
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-bold tracking-tight text-white leading-tight">ACCESS</span>
                <span class="text-[#be2346] font-extrabold text-[10px] tracking-[0.4em] uppercase">Morocco</span>
            </div>
        </div>

        <div class="px-4 mb-2">
            <nav class="space-y-1">
                <a href="<?php echo e(route('dashboard')); ?>" 
                   class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
                   <?php echo e(request()->routeIs('dashboard') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1'); ?>">
                    <div class="transition-transform duration-300 <?php echo e(request()->routeIs('dashboard') ? '' : 'group-hover:rotate-12'); ?>">
                        <svg class="w-5 h-5 <?php echo e(request()->routeIs('dashboard') ? 'text-white' : 'group-hover:text-[#be2346]'); ?> transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="font-medium text-sm">Accueil</span>
                </a>
            </nav>
        </div>
    </div>

    

    <div id="sidebar-scroll-container" class="flex-1 overflow-y-auto custom-scrollbar min-h-0 px-4">
        <div class="px-4 mb-6">
            <p class="text-[10px] font-bold text-white/30 uppercase tracking-[0.25em] flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-[#be2346]"></span>
                Gestion Interne
            </p>
        </div>

        <nav class="space-y-1">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user.view')): ?>

                <a href="<?php echo e(url('/users')); ?>" 
                   class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
                   <?php echo e(request()->is('users*') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1'); ?>">

                    <div class="transition-transform duration-300 <?php echo e(request()->is('users*') ? '' : 'group-hover:rotate-12'); ?>">
                        <svg class="w-5 h-5 <?php echo e(request()->is('users*') ? 'text-white' : 'group-hover:text-[#be2346]'); ?> transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="font-medium text-sm">Ressources Humaines</span>
                </a>
            <?php endif; ?>

      
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('departement.view')): ?>
                <a href="/departements" 
                   class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
                   <?php echo e(request()->is('departements*') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1'); ?>">

                    <div class="transition-transform duration-300 <?php echo e(request()->is('departements*') ? '' : 'group-hover:rotate-12'); ?>">
                        <svg class="w-5 h-5 <?php echo e(request()->is('departements*') ? 'text-white' : 'group-hover:text-[#be2346]'); ?> transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="font-medium text-sm">Département</span>
                </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pointage.view')): ?>

                <a href="<?php echo e(Route::has('pointages.index') ? route('pointages.index') : '#'); ?>" 
                   class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
                   <?php echo e(request()->routeIs('pointages.index') || request()->routeIs('admin.pointages.index') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1'); ?>">
                    <div class="transition-transform duration-300 <?php echo e(request()->routeIs('pointages.index') || request()->routeIs('admin.pointages.index') ? '' : 'group-hover:rotate-12'); ?>">
                        <svg class="w-5 h-5 <?php echo e(request()->routeIs('pointages.index') || request()->routeIs('admin.pointages.index') ? 'text-white' : 'group-hover:text-[#be2346]'); ?> transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="font-medium text-sm">Pointage</span>
                </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prime.view')): ?>
                <a href="<?php echo e(route('primes.index')); ?>" 
                   class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
                   <?php echo e(request()->routeIs('primes.*') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1'); ?>">
                    <div class="transition-transform duration-300 <?php echo e(request()->routeIs('primes.*') ? '' : 'group-hover:rotate-12'); ?>">
                        <svg class="w-5 h-5 <?php echo e(request()->routeIs('primes.*') ? 'text-white' : 'group-hover:text-[#be2346]'); ?> transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="font-medium text-sm">Primes</span>
                </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tache.view')): ?>
                <a href="<?php echo e(Route::has('tasks.index') ? route('tasks.index') : '#'); ?>" class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95 <?php echo e(request()->routeIs('tasks.*') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1'); ?>">
                    <div class="transition-transform duration-300 <?php echo e(request()->routeIs('tasks.*') ? '' : 'group-hover:rotate-12'); ?>">
                        <svg class="w-5 h-5 <?php echo e(request()->routeIs('tasks.*') ? 'text-white' : 'group-hover:text-[#be2346]'); ?> transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="font-medium text-sm">Gestion des tâches</span>
                </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('reclamation.view')): ?>

                <a href="/reclamations" 
                   class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
                   <?php echo e(request()->is('reclamations*') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1'); ?>">

                    <div class="transition-transform duration-300 <?php echo e(request()->is('reclamations*') ? '' : 'group-hover:rotate-12'); ?>">
                        <svg class="w-5 h-5 <?php echo e(request()->is('reclamations*') ? 'text-white' : 'group-hover:text-[#be2346]'); ?> transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="font-medium text-sm">Réclamations</span>
                </a>
            <?php endif; ?>


            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['client.view', 'lead.view', 'dossier.view'])): ?>
            <div class="px-4 mt-8 mb-6">
                <p class="text-[10px] font-bold text-white/30 uppercase tracking-[0.25em] flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                    Gestion Commerciale
                </p>
            </div>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client.view')): ?>
                <a href="<?php echo e(Route::has('clients.index') ? route('clients.index') : '/clients'); ?>" 
                   class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
                   <?php echo e(request()->is('clients*') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1'); ?>">
                    <div class="transition-transform duration-300 <?php echo e(request()->is('clients*') ? '' : 'group-hover:rotate-12'); ?>">
                        <svg class="w-5 h-5 <?php echo e(request()->is('clients*') ? 'text-white' : 'group-hover:text-blue-500'); ?> transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="font-medium text-sm">Clients</span>
                </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead.view')): ?>
                <a href="<?php echo e(route('leads.index')); ?>" 
                   class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
                   <?php echo e(request()->routeIs('leads.*') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1'); ?>">
                    <div class="transition-transform duration-300 <?php echo e(request()->routeIs('leads.*') ? '' : 'group-hover:rotate-12'); ?>">
                        <svg class="w-5 h-5 <?php echo e(request()->routeIs('leads.*') ? 'text-white' : 'group-hover:text-blue-500'); ?> transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="font-medium text-sm">Leads</span>
                </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.view')): ?>
                <a href="<?php echo e(Route::has('dossiers.index') ? route('dossiers.index') : '/dossiers'); ?>" 
                   class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
                   <?php echo e(request()->is('dossiers*') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1'); ?>">
                    <div class="transition-transform duration-300 <?php echo e(request()->is('dossiers*') ? '' : 'group-hover:rotate-12'); ?>">
                        <svg class="w-5 h-5 <?php echo e(request()->is('dossiers*') ? 'text-white' : 'group-hover:text-blue-500'); ?> transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="font-medium text-sm">Dossiers</span>
                </a>
            <?php endif; ?>
            <?php endif; ?>

            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission.view')): ?>
            <div class="px-4 mt-8 mb-6">
                <p class="text-[10px] font-bold text-white/30 uppercase tracking-[0.25em] flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    Système
                </p>
            </div>
            <a href="<?php echo e(route('permissions.index')); ?>" 
               class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
               <?php echo e(request()->routeIs('permissions.*') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1'); ?>">
                <div class="transition-transform duration-300 <?php echo e(request()->routeIs('permissions.*') ? '' : 'group-hover:rotate-12'); ?>">
                    <svg class="w-5 h-5 <?php echo e(request()->routeIs('permissions.*') ? 'text-white' : 'group-hover:text-amber-500'); ?> transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="font-medium text-sm">Permissions</span>
            </a>
            <?php endif; ?>
        </nav>

    </div>

    
    <div class="flex-shrink-0 px-6 py-8 border-t border-white/5">
        <div class="flex items-center justify-between">
            <a href="<?php echo e(route('profile.edit')); ?>" class="group/profile flex items-center gap-3 min-w-0 p-2 -ml-2 rounded-xl hover:bg-white/5 transition-all duration-300 cursor-pointer">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#7c1233] to-[#be2346] flex items-center justify-center font-black text-xs shadow-lg text-white shrink-0 group-hover/profile:scale-110 group-hover/profile:rotate-3 transition-transform">
                    <?php echo e(substr(optional(Auth::user())->firstName ?? 'A', 0, 1)); ?><?php echo e(substr(optional(Auth::user())->lastName ?? 'D', 0, 1)); ?>

                </div>
                <div class="flex flex-col min-w-0">
                    <p class="text-sm font-bold tracking-tight text-white leading-tight truncate group-hover/profile:text-[#be2346] transition-colors">
                        <?php echo e(optional(Auth::user())->firstName ?? 'Admin'); ?> <?php echo e(optional(Auth::user())->lastName ?? 'User'); ?>

                    </p>
                    <p class="text-[10px] text-[#be2346] uppercase font-black tracking-widest mt-0.5 opacity-80 group-hover/profile:opacity-100 transition-opacity">
                        <?php echo e(optional(Auth::user())->type ?? 'Admin'); ?>

                    </p>
                </div>
            </a>

            <button type="button" onclick="confirmLogout()" class="group p-2.5 rounded-lg bg-white/5 hover:bg-red-600/20 border border-white/5 hover:border-red-600/40 transition-all duration-300 active:scale-90" title="Quitter">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/40 group-hover:text-[#be2346] transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
        </div>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarScroll = document.getElementById('sidebar-scroll-container');
        if (sidebarScroll) {
            // Restore scroll position
            const scrollPos = sessionStorage.getItem('sidebar-scroll-pos');
            if (scrollPos) {
                sidebarScroll.scrollTop = scrollPos;
            }

            // Save scroll position on click of any link inside sidebar
            sidebarScroll.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function() {
                    sessionStorage.setItem('sidebar-scroll-pos', sidebarScroll.scrollTop);
                });
            });
        }
    });
</script><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/components/sidebar.blade.php ENDPATH**/ ?>