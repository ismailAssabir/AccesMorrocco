<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Espace Client - Access Morocco'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
<style>
    /* Configuration de base de la sidebar */
    .sidebar-wrapper {
        position: fixed;
        left: 0;
        top: 0;
        z-index: 50;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .main-content {
        margin-left: 288px; /* Correspond à w-72 (72 * 4px) */
        min-height: 100vh;
        transition: margin-left 0.3s ease;
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        z-index: 40;
    }

    /* Scrollbar personnalisée pour le menu */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .sidebar-wrapper {
            transform: translateX(-100%);
        }
        .sidebar-wrapper.open {
            transform: translateX(0);
        }
        .sidebar-overlay.open {
            display: block;
        }
        .main-content {
            margin-left: 0;
        }
    }
</style>
</head>
<body class="bg-[#F8FAFC] font-sans">

<?php $client = Auth::guard('client')->user(); ?>


<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>


<aside class="sidebar-wrapper w-72 h-screen sticky top-0 bg-[#0F1115] text-white flex flex-col font-sans border-r border-white/5 shadow-2xl" id="sidebar">
    
    <div class="flex-shrink-0">
        <div class="flex items-center gap-4 px-6 py-10">
            <div class="bg-gradient-to-br from-[#7c1233] to-[#be2346] p-2 rounded-xl shadow-lg flex-shrink-0 border border-white/10">
                <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-bold tracking-tight text-white leading-tight">ACCESS</span>
                <span class="text-[#be2346] font-extrabold text-[10px] tracking-[0.4em] uppercase">Morocco</span>
            </div>
        </div>
    </div>

    
    <div id="sidebar-scroll-container" class="flex-1 overflow-y-auto custom-scrollbar min-h-0 px-4">
        
        
        <div class="px-4 mb-4">
            <p class="text-[10px] font-bold text-white/30 uppercase tracking-[0.25em] flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-[#be2346]"></span>
                Mon Espace
            </p>
        </div>

        <nav class="space-y-1 mb-8">
            
            <a href="<?php echo e(route('clients.dashboard')); ?>" 
               class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
               <?php echo e(request()->routeIs('clients.dashboard') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1'); ?>">
                <div class="transition-transform duration-300 <?php echo e(request()->routeIs('clients.dashboard') ? '' : 'group-hover:rotate-12'); ?>">
                    <svg class="w-5 h-5 <?php echo e(request()->routeIs('clients.dashboard') ? 'text-white' : 'group-hover:text-[#be2346]'); ?> transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="font-medium text-sm">Tableau de bord</span>
            </a>

            
            <a href="<?php echo e(route('clients.dossiers')); ?>" 
               class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
               <?php echo e(request()->routeIs('clients.dossiers*') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1'); ?>">
                <div class="transition-transform duration-300 <?php echo e(request()->routeIs('clients.dossiers*') ? '' : 'group-hover:rotate-12'); ?>">
                    <svg class="w-5 h-5 <?php echo e(request()->routeIs('clients.dossiers*') ? 'text-white' : 'group-hover:text-[#be2346]'); ?> transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="font-medium text-sm">Mes Dossiers</span>
            </a>

            
            <a href="<?php echo e(route('clients.presentations')); ?>" 
               class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
               <?php echo e(request()->routeIs('clients.presentations*') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1'); ?>">
                <div class="transition-transform duration-300 <?php echo e(request()->routeIs('clients.presentations*') ? '' : 'group-hover:rotate-12'); ?>">
                    <svg class="w-5 h-5 <?php echo e(request()->routeIs('clients.presentations*') ? 'text-white' : 'group-hover:text-[#be2346]'); ?> transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="font-medium text-sm">Présentations</span>
            </a>

            
            <a href="<?php echo e(route('clients.paiements')); ?>" 
               class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
               <?php echo e(request()->routeIs('clients.paiements*') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1'); ?>">
                <div class="transition-transform duration-300 <?php echo e(request()->routeIs('clients.paiements*') ? '' : 'group-hover:rotate-12'); ?>">
                    <svg class="w-5 h-5 <?php echo e(request()->routeIs('clients.paiements*') ? 'text-white' : 'group-hover:text-[#be2346]'); ?> transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="font-medium text-sm">Paiements</span>
            </a>
        </nav>

        
        <div class="px-4 mb-4">
            <p class="text-[10px] font-bold text-white/30 uppercase tracking-[0.25em] flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                Paramètres
            </p>
        </div>

        <nav class="space-y-1">
            <a href="<?php echo e(route('clients.profile')); ?>" 
               class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
               <?php echo e(request()->routeIs('clients.profile*') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1'); ?>">
                <div class="transition-transform duration-300 <?php echo e(request()->routeIs('clients.profile*') ? '' : 'group-hover:rotate-12'); ?>">
                    <svg class="w-5 h-5 <?php echo e(request()->routeIs('clients.profile*') ? 'text-white' : 'group-hover:text-blue-500'); ?> transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="font-medium text-sm">Mon Profil</span>
            </a>
        </nav>
    </div>

    
    <div class="flex-shrink-0 px-6 py-8 border-t border-white/5 bg-[#0F1115]">
        <div class="flex items-center justify-between mb-6">
            <div class="group/profile flex items-center gap-3 min-w-0 p-2 -ml-2 rounded-xl transition-all duration-300">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#7c1233] to-[#be2346] flex items-center justify-center font-black text-xs shadow-lg text-white shrink-0">
                    <?php echo e(strtoupper(mb_substr($client->firstName ?? 'C', 0, 1) . mb_substr($client->lastName ?? '', 0, 1))); ?>

                </div>
                <div class="flex flex-col min-w-0">
                    <p class="text-white font-bold text-sm truncate"><?php echo e($client->firstName ." ".$client->lastName); ?></p>
                    <p class="text-white/30 text-[10px] font-medium uppercase tracking-wider">Espace Client</p>
                </div>
            </div>
        </div>

        <form method="POST" action="<?php echo e(route('clients.logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" 
                    class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-xl bg-white/5 text-white/50 hover:bg-red-500/10 hover:text-red-500 transition-all duration-300 text-sm font-semibold border border-white/5">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Déconnexion
            </button>
        </form>
    </div>
</aside>


<div class="main-content">

    
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
        <div class="px-6 py-3 flex items-center justify-between">

            
            <button onclick="toggleSidebar()"
                    class="lg:hidden w-9 h-9 rounded-xl border border-slate-200 flex items-center justify-center hover:bg-slate-50 transition-colors">
                <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            
            <div class="hidden lg:block">
                <h2 class="text-sm font-black text-slate-800"><?php echo $__env->yieldContent('page-title', 'Tableau de bord'); ?></h2>
                <p class="text-[11px] text-slate-400"><?php echo $__env->yieldContent('page-subtitle', 'Bienvenue dans votre espace client'); ?></p>
            </div>

            
            <div class="flex items-center gap-3 ml-auto">

                
                <button class="relative w-9 h-9 rounded-xl border border-slate-200 flex items-center justify-center hover:bg-slate-50 transition-colors">
                    <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </button>

                
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#b11d40] to-[#7c1233] flex items-center justify-center text-[11px] font-black text-white">
                        <?php echo e(strtoupper(mb_substr($client->firstName ?? 'C', 0, 1))); ?>

                    </div>
                    <div class="hidden sm:block">
                        <p class="text-xs font-bold text-slate-700"><?php echo e($client->firstName); ?></p>
                        <p class="text-[10px] text-slate-400">Client</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    
    <main class="p-6 md:p-8">

        
        <?php if(session('success')): ?>
        <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl font-semibold text-sm">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
        <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl font-semibold text-sm">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <?php echo e(session('error')); ?>

        </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    sidebar.classList.toggle('open');
    overlay.classList.toggle('open');
}
</script>

</body>
</html><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/layouts/client.blade.php ENDPATH**/ ?>