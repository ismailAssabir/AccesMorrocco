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
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            
            <nav class="flex mb-8 text-sm font-medium" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="<?php echo e(route('reunions.index')); ?>" class="text-gray-500 hover:text-[#be2346] transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Réunions
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-gray-400 md:ml-2">Détails de la réunion</span>
                        </div>
                    </li>
                </ol>
            </nav>

            
            <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-2xl shadow-gray-200/50 overflow-hidden">
                
                <div class="bg-gradient-to-br from-[#be2346] to-rose-700 p-8 md:p-12 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-10">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-widest border border-white/30">
                                <?php echo e($reunion->type); ?>

                            </span>
                            <?php if($reunion->dateHeure->isPast()): ?>
                                <span class="px-3 py-1 bg-gray-900/40 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-widest border border-white/10">
                                    Terminée
                                </span>
                            <?php endif; ?>
                        </div>
                        <h1 class="text-3xl md:text-5xl font-black mb-4 leading-tight"><?php echo e($reunion->titre); ?></h1>
                        <p class="text-rose-100 text-lg font-medium opacity-90"><?php echo e($reunion->objectif); ?></p>
                    </div>
                </div>

                <div class="p-8 md:p-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        
                        <div class="space-y-8">
                            <div>
                                <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-6">Informations Clés</h3>
                                <div class="space-y-6">
                                    <div class="flex items-start gap-4">
                                        <div class="p-3 bg-gray-50 rounded-2xl text-[#be2346]">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-400 uppercase mb-1">Date & Heure</p>
                                            <p class="text-lg font-black text-gray-900"><?php echo e($reunion->dateHeure->translatedFormat('l d F Y')); ?></p>
                                            <p class="text-sm font-bold text-gray-500">À partir de <?php echo e($reunion->dateHeure->format('H:i')); ?></p>
                                        </div>
                                    </div>

                                    <?php if($reunion->heureFin): ?>
                                    <div class="flex items-start gap-4">
                                        <div class="p-3 bg-gray-50 rounded-2xl text-[#be2346]">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-400 uppercase mb-1">Fin prévue</p>
                                            <p class="text-lg font-black text-gray-900"><?php echo e(\Carbon\Carbon::parse($reunion->heureFin)->format('H:i')); ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <div class="flex items-start gap-4">
                                        <div class="p-3 bg-gray-50 rounded-2xl text-[#be2346]">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-400 uppercase mb-1">Localisation</p>
                                            <p class="text-lg font-black text-gray-900"><?php echo e($reunion->lieu ?? 'Visioconférence'); ?></p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-4">
                                        <div class="p-3 bg-gray-50 rounded-2xl text-[#be2346]">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-400 uppercase mb-1">Cible</p>
                                            <p class="text-lg font-black text-gray-900">
                                                <?php if($reunion->idDepartement): ?>
                                                    Département: <?php echo e($reunion->departement->title ?? 'N/A'); ?>

                                                <?php elseif($reunion->participants->count() > 0): ?>
                                                    <?php echo e($reunion->participants->count()); ?> Participant(s) spécifique(s)
                                                <?php else: ?>
                                                    Tous les employés
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if($reunion->participants->count() > 0): ?>
                            <div>
                                <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-6">Participants invités</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <?php $__currentLoopData = $reunion->participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $participant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center gap-3 p-3 bg-white border border-gray-100 rounded-2xl shadow-sm">
                                        <div class="w-8 h-8 rounded-full bg-[#be2346]/10 flex items-center justify-center text-[#be2346] font-black text-[10px]">
                                            <?php echo e(substr($participant->firstName, 0, 1)); ?><?php echo e(substr($participant->lastName, 0, 1)); ?>

                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs font-bold text-gray-900 truncate"><?php echo e($participant->firstName); ?> <?php echo e($participant->lastName); ?></p>
                                            <p class="text-[9px] text-gray-400 font-medium truncate"><?php echo e($participant->post); ?></p>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        
                        <div class="space-y-8">
                            <div>
                                <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-6">Description détaillée</h3>
                                <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100">
                                    <p class="text-gray-600 leading-relaxed italic">
                                        <?php echo e($reunion->description ?? 'Aucune description supplémentaire fournie pour cette réunion.'); ?>

                                    </p>
                                </div>
                            </div>

                            <?php if($reunion->lien): ?>
                            <div>
                                <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-6">Accès Distant</h3>
                                <a href="<?php echo e($reunion->lien); ?>" target="_blank" class="group flex items-center justify-between p-6 bg-gray-900 rounded-[2rem] text-white hover:bg-[#be2346] transition-all duration-300 shadow-xl shadow-gray-900/10">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 bg-white/10 rounded-2xl group-hover:bg-white/20 transition-colors">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black uppercase tracking-widest">Rejoindre la visio</p>
                                            <p class="text-[10px] text-white/50 font-bold uppercase tracking-tighter">Lien sécurisé Access Morocco</p>
                                        </div>
                                    </div>
                                    <svg class="w-6 h-6 transform translate-x-0 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                </a>
                            </div>
                            <?php endif; ?>

                            <div class="flex gap-4 pt-8">
                                <a href="<?php echo e(route('reunions.index')); ?>" class="flex-1 inline-flex items-center justify-center px-6 py-4 bg-white border border-gray-200 rounded-2xl text-sm font-black text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
                                    Retour à la liste
                                </a>
                            </div>
                        </div>
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
<?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/reunions/show.blade.php ENDPATH**/ ?>