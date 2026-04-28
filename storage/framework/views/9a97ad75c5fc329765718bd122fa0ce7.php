<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        .elite-font { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
        .elite-heading { letter-spacing: -0.025em; }

        /* Ultra-soft multi-layered floating shadow */
        .elite-shadow {
            box-shadow:
                0 1px 2px rgba(0, 0, 0, 0.02),
                0 4px 8px rgba(0, 0, 0, 0.02),
                0 8px 16px rgba(0, 0, 0, 0.02),
                0 16px 32px rgba(0, 0, 0, 0.02);
        }
        .elite-shadow-hover:hover {
            box-shadow:
                0 2px 4px rgba(0, 0, 0, 0.03),
                0 8px 16px rgba(0, 0, 0, 0.03),
                0 16px 32px rgba(0, 0, 0, 0.03),
                0 24px 48px rgba(0, 0, 0, 0.04);
        }

        /* Glass Hero */
        .glass-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 40%, #334155 100%);
        }
        .glass-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 70% 10%, rgba(177,29,64,0.12) 0%, transparent 55%),
                radial-gradient(ellipse at 15% 90%, rgba(177,29,64,0.06) 0%, transparent 45%);
            pointer-events: none;
        }
        .glass-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0.03;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h60v60H0z' fill='none' stroke='white' stroke-width='.3'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* Focus ring for inputs */
        .elite-input:focus {
            border-color: #b11d40;
            box-shadow: 0 0 0 3px rgba(177, 29, 64, 0.08);
        }

        /* Active tab indicator */
        .elite-tab-active {
            color: #b11d40;
            position: relative;
        }
        .elite-tab-active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background: #b11d40;
            border-radius: 2px 2px 0 0;
        }

        /* Stat card hover lift */
        .stat-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .stat-lift:hover { transform: translateY(-3px); }

        /* Online pulse */
        .pulse-online { box-shadow: 0 0 0 0 rgba(52,211,153,0.4); animation: pulse-green 2s infinite; }
        @keyframes pulse-green {
            0% { box-shadow: 0 0 0 0 rgba(52,211,153,0.4); }
            70% { box-shadow: 0 0 0 8px rgba(52,211,153,0); }
            100% { box-shadow: 0 0 0 0 rgba(52,211,153,0); }
        }
    </style>

    <div class="elite-font bg-[#f8fafc] min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-10 py-8 space-y-8">

            
            <div class="glass-hero relative rounded-2xl overflow-hidden border border-white/[0.06]">
                <div class="relative z-10 px-8 sm:px-10 lg:px-12 py-10">
                    <div class="flex flex-col lg:flex-row items-center gap-8">

                        
                        <div class="relative flex-shrink-0">
                            <div class="w-[7.5rem] h-[7.5rem] rounded-2xl bg-gradient-to-br from-[#b11d40] to-[#d63b5e] flex items-center justify-center text-white text-[2.5rem] font-extrabold elite-heading shadow-2xl shadow-[#b11d40]/25 ring-4 ring-white/[0.08] hover:scale-[1.03] transition-transform duration-300 cursor-default select-none">
                                <?php echo e(strtoupper(substr(auth()->user()->firstName ?? 'A', 0, 1))); ?><?php echo e(strtoupper(substr(auth()->user()->lastName ?? 'M', 0, 1))); ?>

                            </div>
                            
                            <div class="absolute -bottom-1.5 -right-1.5 w-7 h-7 bg-emerald-400 rounded-lg border-[3px] border-[#1e293b] flex items-center justify-center pulse-online">
                                <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </div>
                        </div>

                        
                        <div class="flex-1 text-center lg:text-left space-y-3 min-w-0">
                            <div>
                                <h1 class="text-3xl sm:text-4xl font-extrabold text-white elite-heading">
                                    <?php echo e(auth()->user()->firstName); ?> <?php echo e(auth()->user()->lastName); ?>

                                </h1>
                                <p class="text-white/40 font-semibold text-sm mt-1.5 flex flex-wrap items-center justify-center lg:justify-start gap-x-3 gap-y-1">
                                    <span><?php echo e(auth()->user()->post ?? 'Collaborateur'); ?></span>
                                    <?php if(auth()->user()->departement): ?>
                                        <span class="w-1 h-1 rounded-full bg-white/20"></span>
                                        <span class="text-white/30"><?php echo e(auth()->user()->departement->nomDepartement ?? ''); ?></span>
                                    <?php endif; ?>
                                </p>
                            </div>

                            
                            <div class="flex flex-wrap justify-center lg:justify-start gap-2 pt-1">
                                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white/[0.06] backdrop-blur-sm rounded-xl text-xs font-semibold text-white/60 border border-white/[0.04]">
                                    <svg class="w-3.5 h-3.5 text-[#b11d40]" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                                    <?php echo e(auth()->user()->email); ?>

                                </span>
                                <?php if(auth()->user()->phoneNumber): ?>
                                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white/[0.06] backdrop-blur-sm rounded-xl text-xs font-semibold text-white/60 border border-white/[0.04]">
                                    <svg class="w-3.5 h-3.5 text-[#b11d40]" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                                    <?php echo e(auth()->user()->phoneNumber); ?>

                                </span>
                                <?php endif; ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500/[0.08] rounded-xl text-xs font-bold text-emerald-400 border border-emerald-500/10">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    En ligne
                                </span>
                            </div>
                        </div>

                        
                        <div class="hidden xl:flex items-center gap-8 pl-8 border-l border-white/[0.06]">
                            <div class="text-center">
                                <p class="text-3xl font-extrabold text-white elite-heading"><?php echo e(auth()->user()->taches()->count()); ?></p>
                                <p class="text-[10px] font-bold text-white/30 uppercase tracking-[0.15em] mt-1">Tâches</p>
                            </div>
                            <div class="text-center">
                                <p class="text-3xl font-extrabold text-white elite-heading"><?php echo e(auth()->user()->conges()->count()); ?></p>
                                <p class="text-[10px] font-bold text-white/30 uppercase tracking-[0.15em] mt-1">Congés</p>
                            </div>
                            <div class="text-center">
                                <p class="text-3xl font-extrabold text-[#b11d40] elite-heading"><?php echo e(auth()->user()->documents()->count()); ?></p>
                                <p class="text-[10px] font-bold text-white/30 uppercase tracking-[0.15em] mt-1">Documents</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                
                <div class="bg-white rounded-2xl border border-[#f1f5f9] elite-shadow elite-shadow-hover stat-lift p-6 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-50 flex items-center justify-center">
                            <svg class="w-4.5 h-4.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800 elite-heading">Profil Professionnel</h3>
                    </div>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Gestion des itinéraires touristiques et coordination des opérations au sein d'Access Morocco.
                    </p>
                    <div class="pt-2 flex items-center gap-3 text-xs font-bold text-slate-400">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-50 rounded-lg">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                            <?php echo e(auth()->user()->typeContrat ?? 'CDI'); ?>

                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-50 rounded-lg">
                            <span class="w-1.5 h-1.5 rounded-full bg-violet-400"></span>
                            <?php echo e(auth()->user()->post ?? 'Collaborateur'); ?>

                        </span>
                    </div>
                </div>

                
                <div class="bg-white rounded-2xl border border-[#f1f5f9] elite-shadow elite-shadow-hover stat-lift p-6 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-50 flex items-center justify-center">
                            <svg class="w-4.5 h-4.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800 elite-heading">Coordonnées</h3>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest w-16 shrink-0">Email</span>
                            <span class="text-sm font-semibold text-slate-700 truncate"><?php echo e(auth()->user()->email); ?></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest w-16 shrink-0">Tél</span>
                            <span class="text-sm font-semibold text-slate-700"><?php echo e(auth()->user()->phoneNumber ?? '—'); ?></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest w-16 shrink-0">Adresse</span>
                            <span class="text-sm font-semibold text-slate-700 truncate"><?php echo e(auth()->user()->address ?? '—'); ?></span>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-2xl border border-[#f1f5f9] elite-shadow elite-shadow-hover stat-lift p-6 space-y-4 sm:col-span-2 lg:col-span-1">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-50 flex items-center justify-center">
                            <svg class="w-4.5 h-4.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800 elite-heading">Aperçu Rapide</h3>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="text-center p-3 bg-slate-50/70 rounded-xl">
                            <p class="text-2xl font-extrabold text-slate-800 elite-heading"><?php echo e(auth()->user()->taches()->count()); ?></p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Tâches</p>
                        </div>
                        <div class="text-center p-3 bg-slate-50/70 rounded-xl">
                            <p class="text-2xl font-extrabold text-slate-800 elite-heading"><?php echo e(auth()->user()->conges()->count()); ?></p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Congés</p>
                        </div>
                        <div class="text-center p-3 bg-[#b11d40]/[0.04] rounded-xl border border-[#b11d40]/[0.06]">
                            <p class="text-2xl font-extrabold text-[#b11d40] elite-heading"><?php echo e(auth()->user()->reclamations()->count()); ?></p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Tickets</p>
                        </div>
                    </div>
                </div>
            </div>

            
            <div x-data="{ tab: 'profile' }" class="bg-white rounded-2xl border border-[#f1f5f9] elite-shadow overflow-hidden">

                
                <div class="flex items-center border-b border-[#f1f5f9] px-6 sm:px-8 overflow-x-auto">
                    <button @click="tab = 'profile'"
                        :class="tab === 'profile' ? 'elite-tab-active font-bold text-[#b11d40]' : 'text-slate-400 hover:text-slate-600'"
                        class="relative px-5 py-4 text-sm font-semibold transition-colors duration-200 flex items-center gap-2 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Informations
                    </button>
                    <button @click="tab = 'security'"
                        :class="tab === 'security' ? 'elite-tab-active font-bold text-[#b11d40]' : 'text-slate-400 hover:text-slate-600'"
                        class="relative px-5 py-4 text-sm font-semibold transition-colors duration-200 flex items-center gap-2 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Sécurité
                    </button>
                </div>

                
                <div class="p-6 sm:p-8 lg:p-10">
                    
                    <div x-show="tab === 'profile'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <?php echo $__env->make('profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>

                    
                    <div x-show="tab === 'security'" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <?php echo $__env->make('profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\dell\Desktop\PROJECTS\AccesMorrocco\resources\views/profile/edit.blade.php ENDPATH**/ ?>