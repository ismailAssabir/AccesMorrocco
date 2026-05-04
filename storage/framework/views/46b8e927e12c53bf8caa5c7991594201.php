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
    [x-cloak] { display: none !important; }
</style>
</head>
<body class="bg-[#F8FAFC] font-sans">

<?php 
    $client = Auth::guard('client')->user(); 
    $recentNotifications = collect();
    if ($client) {
        $dossierIds = $client->dossiers()->pluck('idDossier');
        
        // New Presentations
        $presentations = \App\Models\Presentation::whereIn('idDossier', $dossierIds)
            ->latest()
            ->limit(3)
            ->get()
            ->map(function($item) {
                return [
                    'title' => 'Nouvelle Présentation',
                    'desc' => $item->titre,
                    'time' => $item->created_at->toDateTimeString(),
                    'url' => route('clients.presentations')
                ];
            });
        $recentNotifications = $recentNotifications->concat($presentations);

        // Payment Updates
        $paiements = \App\Models\Paiement::whereIn('idDossier', $dossierIds)
            ->latest()
            ->limit(3)
            ->get()
            ->map(function($item) {
                return [
                    'title' => 'Mise à jour Paiement',
                    'desc' => 'Le paiement de ' . number_format($item->montantPaye, 2) . ' MAD est ' . $item->status,
                    'time' => $item->updated_at->toDateTimeString(),
                    'url' => route('clients.paiements')
                ];
            });
        $recentNotifications = $recentNotifications->concat($paiements);
        
        $recentNotifications = $recentNotifications->sortByDesc('time')->take(5)->values();
    }
?>


<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>


<aside class="sidebar-wrapper w-72 h-screen sticky top-0 bg-[#0F1115] text-white flex flex-col font-sans border-r border-white/5 shadow-2xl" id="sidebar">
    
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

            
            <a href="<?php echo e(route('clients.souvenirs.index')); ?>" 
               class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 active:scale-95
               <?php echo e(request()->routeIs('clients.souvenirs.index') ? 'bg-[#be2346] text-white shadow-lg shadow-[#be2346]/20' : 'text-white/50 hover:bg-white/5 hover:text-white hover:translate-x-1'); ?>">
                <div class="transition-transform duration-300 <?php echo e(request()->routeIs('clients.souvenirs.index') ? '' : 'group-hover:rotate-12'); ?>">
                    <svg class="w-5 h-5 <?php echo e(request()->routeIs('clients.souvenirs.index') ? 'text-white' : 'group-hover:text-[#be2346]'); ?> transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="font-medium text-sm">Journal de Voyage</span>
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
        <div class="flex items-center justify-between">
            <a href="<?php echo e(route('clients.profile')); ?>" class="group/profile flex items-center gap-3 min-w-0 p-2 -ml-2 rounded-xl hover:bg-white/5 transition-all duration-300 cursor-pointer">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#7c1233] to-[#be2346] flex items-center justify-center font-black text-xs shadow-lg text-white shrink-0 group-hover/profile:scale-110 group-hover/profile:rotate-3 transition-transform">
                    <?php echo e(strtoupper(mb_substr($client->firstName ?? 'C', 0, 1) . mb_substr($client->lastName ?? '', 0, 1))); ?>

                </div>
                <div class="flex flex-col min-w-0">
                    <p class="text-sm font-bold tracking-tight text-white leading-tight truncate group-hover/profile:text-[#be2346] transition-colors">
                        <?php echo e($client->firstName ." ".$client->lastName); ?>

                    </p>
                    <p class="text-[10px] text-[#be2346] uppercase font-black tracking-widest mt-0.5 opacity-80 group-hover/profile:opacity-100 transition-opacity">
                        Espace Client
                    </p>
                </div>
            </a>

            <button type="button" onclick="confirmClientLogout()" class="group p-2.5 rounded-lg bg-white/5 hover:bg-red-600/20 border border-white/5 hover:border-red-600/40 transition-all duration-300 active:scale-90" title="Déconnexion">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/40 group-hover:text-[#be2346] transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
        </div>
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

                
                <div x-data="{ 
                    open: false,
                    lastChecked: parseInt(localStorage.getItem('client_notifications_last_checked_<?php echo e($client->idClient ?? 0); ?>') || '0'),
                    readIds: JSON.parse(localStorage.getItem('client_read_notifications_<?php echo e($client->idClient ?? 0); ?>') || '[]'),
                    notifications: <?php echo e(json_encode($recentNotifications->map(function($n) {
                        $n['timestamp'] = \Carbon\Carbon::parse($n['time'])->timestamp * 1000;
                        $n['time_human'] = \Carbon\Carbon::parse($n['time'])->diffForHumans();
                        return $n;
                    }))); ?>,
                    get visibleNotifications() {
                        return this.notifications.filter(n => !this.readIds.includes(n.timestamp));
                    },
                    get hasNew() {
                        return this.visibleNotifications.some(n => n.timestamp > this.lastChecked);
                    },
                    toggle() {
                        if (!this.open) {
                            this.open = true;
                            // Optionally clear the global 'new' indicator when opening
                            this.lastChecked = Date.now();
                            localStorage.setItem('client_notifications_last_checked_<?php echo e($client->idClient ?? 0); ?>', this.lastChecked);
                        } else {
                            this.open = false;
                        }
                    },
                    markAsRead(n) {
                        if (!this.readIds.includes(n.timestamp)) {
                            this.readIds.push(n.timestamp);
                            localStorage.setItem('client_read_notifications_<?php echo e($client->idClient ?? 0); ?>', JSON.stringify(this.readIds));
                        }
                    }
                }" @click.away="open = false" class="relative">
                    <button @click="toggle()" 
                        class="relative w-9 h-9 rounded-xl border border-slate-200 flex items-center justify-center hover:bg-slate-50 transition-colors group">
                        
                        <template x-if="hasNew">
                            <span class="absolute top-1.5 right-1.5 flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#be2346] opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-[#be2346]"></span>
                            </span>
                        </template>
                        
                        <svg class="w-4 h-4 text-slate-500 group-hover:text-[#be2346] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </button>

                    
                    <div x-show="open" 
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        class="absolute right-0 mt-4 w-80 bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-slate-100 overflow-hidden z-50">
                        
                        <div class="px-5 py-4 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#be2346]">Notifications</p>
                        </div>

                        <div class="max-h-80 overflow-y-auto">
                            <template x-for="notif in visibleNotifications" :key="notif.time + notif.title">
                                <a :href="notif.url" @click="markAsRead(notif)" class="block p-4 border-b border-slate-50 hover:bg-slate-50 transition-colors cursor-pointer group">
                                    <div class="flex justify-between items-start mb-1">
                                        <p class="text-xs font-bold text-slate-800 group-hover:text-[#be2346]" x-text="notif.title"></p>
                                        <span class="text-[9px] text-slate-400 font-medium whitespace-nowrap ml-2" x-text="notif.time_human"></span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 line-clamp-2 mt-1" x-text="notif.desc"></p>
                                </a>
                            </template>

                            <div x-show="visibleNotifications.length === 0" class="p-8 text-center">
                                <svg class="w-8 h-8 text-slate-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <p class="text-xs font-bold text-slate-400">Aucune notification</p>
                            </div>
                        </div>
                    </div>
                </div>

                
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

<?php if (isset($component)) { $__componentOriginal8b7b112f0fae85419ee5abf8337434ab = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8b7b112f0fae85419ee5abf8337434ab = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.delete-confirmation-modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('delete-confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8b7b112f0fae85419ee5abf8337434ab)): ?>
<?php $attributes = $__attributesOriginal8b7b112f0fae85419ee5abf8337434ab; ?>
<?php unset($__attributesOriginal8b7b112f0fae85419ee5abf8337434ab); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8b7b112f0fae85419ee5abf8337434ab)): ?>
<?php $component = $__componentOriginal8b7b112f0fae85419ee5abf8337434ab; ?>
<?php unset($__componentOriginal8b7b112f0fae85419ee5abf8337434ab); ?>
<?php endif; ?>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    sidebar.classList.toggle('open');
    overlay.classList.toggle('open');
}

function confirmClientLogout() {
    if (typeof openGlobalDeleteModal === 'function') {
        openGlobalDeleteModal(
            "<?php echo e(route('clients.logout')); ?>", 
            "Quitter la session ?", 
            "Êtes-vous sûr de vouloir vous déconnecter de votre compte Access Morocco ?", 
            "Se déconnecter", 
            "danger", 
            "logout", 
            "POST"
        );
    } else {
        if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "<?php echo e(route('clients.logout')); ?>";
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
    }
}
</script>

</body>
</html><?php /**PATH C:\Users\dell\Desktop\AccesMorrocco\resources\views/layouts/client.blade.php ENDPATH**/ ?>