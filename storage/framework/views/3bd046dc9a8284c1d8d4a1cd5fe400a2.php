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
    <div class="p-8 bg-[#F8FAFC] min-h-screen">
        
        <div class="mb-8 flex items-center justify-between">
            <div>
                <a href="<?php echo e(route('primes.index')); ?>" class="flex items-center gap-2 text-slate-500 hover:text-[#b11d40] transition-all mb-2 text-sm font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour à la liste
                </a>
                <h1 class="text-2xl font-extrabold text-slate-800">Détails de la Prime</h1>
                <p class="text-slate-500 text-sm">Consultez les informations détaillées sur cette prime.</p>
            </div>
            <div class="flex gap-3">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prime.edit')): ?>
                <button onclick="window.location.href='<?php echo e(route('primes.index')); ?>?edit=<?php echo e($prime->idPrime); ?>'"
                        class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all text-sm shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </button>
                <?php endif; ?>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-8">
                
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-8">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Montant de la Prime</p>
                                <h2 class="text-4xl font-black text-slate-800"><?php echo e(number_format($prime->montant, 2)); ?> <span class="text-xl text-slate-400">MAD</span></h2>
                            </div>
                            <div>
                                <?php
                                    $statusColors = [
                                        'en_attente' => 'bg-amber-100 text-amber-700',
                                        'validee'    => 'bg-blue-100 text-blue-700',
                                        'payee'      => 'bg-emerald-100 text-emerald-700',
                                    ];
                                    $statusLabels = [
                                        'en_attente' => 'En Attente',
                                        'validee'    => 'Validée',
                                        'payee'      => 'Payée',
                                    ];
                                ?>
                                <span class="inline-flex px-4 py-2 rounded-2xl text-sm font-black uppercase <?php echo e($statusColors[$prime->status] ?? 'bg-slate-100 text-slate-500'); ?>">
                                    <?php echo e($statusLabels[$prime->status] ?? $prime->status); ?>

                                </span>
                            </div>
                        </div>

                        <div class="mt-10 pt-8 border-t border-slate-100">
                            <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider mb-4">Motif d'attribution</h3>
                            <p class="text-slate-600 leading-relaxed bg-slate-50 p-6 rounded-2xl italic">
                                "<?php echo e($prime->motif ?? 'Aucun motif spécifié.'); ?>"
                            </p>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-8">
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider mb-6">Référence Liée</h3>
                    
                    <?php if($prime->idTache): ?>
                    <div class="flex items-start gap-4 p-6 rounded-2xl bg-blue-50 border border-blue-100">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-blue-400 uppercase tracking-widest mb-1">Tâche</p>
                            <h4 class="font-bold text-slate-800"><?php echo e($prime->tache->titre ?? 'Tâche supprimée'); ?></h4>
                            <p class="text-sm text-slate-500 mt-1"><?php echo e(Str::limit($prime->tache->description ?? '', 100)); ?></p>
                        </div>
                    </div>
                    <?php elseif($prime->idPointage): ?>
                    <div class="flex items-start gap-4 p-6 rounded-2xl bg-purple-50 border border-purple-100">
                        <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-purple-400 uppercase tracking-widest mb-1">Pointage</p>
                            <h4 class="font-bold text-slate-800">Session de pointage du <?php echo e(\Carbon\Carbon::parse($prime->pointage->date)->format('d/m/Y')); ?></h4>
                            <p class="text-sm text-slate-500 mt-1">Arrivée: <?php echo e($prime->pointage->check_in); ?> | Départ: <?php echo e($prime->pointage->check_out ?? 'N/A'); ?></p>
                        </div>
                    </div>
                    <?php elseif($prime->idObjectif): ?>
                    <div class="flex items-start gap-4 p-6 rounded-2xl bg-emerald-50 border border-emerald-100">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-emerald-400 uppercase tracking-widest mb-1">Objectif</p>
                            <h4 class="font-bold text-slate-800"><?php echo e($prime->objectif->titre ?? 'Objectif supprimé'); ?></h4>
                            <p class="text-sm text-slate-500 mt-1">Niveau d'importance: <?php echo e($prime->objectif->priorite ?? 'N/A'); ?></p>
                        </div>
                    <?php else: ?>
                    <div class="text-center py-10 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                        <p class="text-slate-400 font-bold">Aucune référence externe liée à cette prime.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="space-y-8">
                
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-8 text-center">
                    <div class="w-24 h-24 mx-auto mb-4 rounded-3xl bg-slate-100 flex items-center justify-center font-black text-2xl text-[#b11d40]">
                        <?php echo e(substr($prime->user->firstName ?? 'U', 0, 1)); ?><?php echo e(substr($prime->user->lastName ?? 'N', 0, 1)); ?>

                    </div>
                    <h3 class="text-xl font-black text-slate-800"><?php echo e($prime->user->firstName ?? 'N/A'); ?> <?php echo e($prime->user->lastName ?? ''); ?></h3>
                    <p class="text-[10px] text-slate-400 uppercase font-black tracking-widest mt-1"><?php echo e($prime->user->post ?? 'Poste non défini'); ?></p>
                    
                    <div class="mt-6 pt-6 border-t border-slate-50 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400 font-bold">Email</span>
                            <span class="text-slate-700 font-medium"><?php echo e($prime->user->email ?? 'N/A'); ?></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400 font-bold">Département</span>
                            <span class="text-slate-700 font-medium"><?php echo e($prime->user->departement->nom ?? 'N/A'); ?></span>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-8">
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider mb-6">Timeline</h3>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="w-px bg-slate-100 relative">
                                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-[#b11d40]"></div>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">Attribution</p>
                                <p class="text-sm font-bold text-slate-700"><?php echo e(\Carbon\Carbon::parse($prime->dateAttribution)->format('d F Y')); ?></p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-px bg-slate-100 relative">
                                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-slate-300"></div>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">Dernière modification</p>
                                <p class="text-sm font-bold text-slate-700"><?php echo e($prime->updated_at->format('d F Y à H:i')); ?></p>
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
<?php /**PATH C:\Users\dell\Desktop\PROJECTS\AccesMorrocco\resources\views/primes/show.blade.php ENDPATH**/ ?>