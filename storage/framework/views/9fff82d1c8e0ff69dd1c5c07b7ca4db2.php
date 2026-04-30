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

        
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <a href="<?php echo e(route('dossiers.index')); ?>"
                   class="inline-flex items-center gap-2 text-slate-400 hover:text-[#b11d40] text-sm font-bold mb-2 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Retour aux dossiers
                </a>
                <h1 class="text-2xl font-extrabold text-slate-800"><?php echo e($dossier->reference); ?></h1>
                <p class="text-slate-500 text-sm"><?php echo e($dossier->distination ?? 'Aucune destination'); ?></p>
            </div>
            <div class="flex gap-3">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.edit')): ?>
                <a href="<?php echo e(route('dossiers.edit', $dossier->idDossier)); ?>"
                   class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.delete')): ?>
                <form method="POST" action="<?php echo e(route('dossiers.destroy', $dossier->idDossier)); ?>"
                      onsubmit="return confirm('Supprimer ce dossier ?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit"
                            class="flex items-center gap-2 px-4 py-2 bg-white border border-red-200 text-red-500 font-bold rounded-xl hover:bg-red-500 hover:text-white transition-all text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Supprimer
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>

        
        <?php if(session('msg')): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm font-semibold">
            <?php echo e(session('msg')); ?>

        </div>
        <?php endif; ?>

        <?php
            $statusColors = ['ouvert' => 'bg-blue-100 text-blue-600', 'en_cours' => 'bg-yellow-100 text-yellow-700', 'ferme' => 'bg-slate-100 text-slate-500'];
            $statusLabels = ['ouvert' => 'Ouvert', 'en_cours' => 'En cours', 'ferme' => 'Fermé'];
        ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            
            <div class="lg:col-span-1 space-y-6">

                
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6">
                        <div class="flex flex-col items-center text-center mb-6">
                            <div class="w-16 h-16 rounded-2xl bg-[#b11d40]/10 flex items-center justify-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#b11d40]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h2 class="text-lg font-extrabold text-slate-800"><?php echo e($dossier->reference); ?></h2>
                            <span class="mt-2 px-3 py-1 rounded-xl text-xs font-black uppercase <?php echo e($statusColors[$dossier->status] ?? ''); ?>">
                                <?php echo e($statusLabels[$dossier->status] ?? $dossier->status); ?>

                            </span>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">Client</span>
                                <span class="text-sm font-bold text-slate-700"><?php echo e($dossier->client->firstName ?? '—'); ?> <?php echo e($dossier->client->lastName ?? ''); ?></span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">Département</span>
                                <span class="text-sm font-bold text-slate-700"><?php echo e($dossier->departement->title ?? '—'); ?></span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">Destination</span>
                                <span class="text-sm font-bold text-slate-700"><?php echo e($dossier->distination ?? '—'); ?></span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">Date voyage</span>
                                <span class="text-sm font-bold text-slate-700">
                                    <?php echo e($dossier->dateVoyage ? \Carbon\Carbon::parse($dossier->dateVoyage)->format('d/m/Y') : '—'); ?>

                                </span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">Personnes</span>
                                <span class="text-sm font-bold text-slate-700"><?php echo e($dossier->nombrePersonnes); ?></span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">Jours</span>
                                <span class="text-sm font-bold text-slate-700"><?php echo e($dossier->nombreJours); ?></span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-[#b11d40]/5 rounded-2xl border border-[#b11d40]/10">
                                <span class="text-xs font-black text-[#b11d40] uppercase">Montant</span>
                                <span class="text-sm font-black text-[#b11d40]"><?php echo e(number_format($dossier->montant, 2)); ?> MAD</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="lg:col-span-2 space-y-6">

                
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6 space-y-4">
                        <div>
                            <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-2">Commentaire</h3>
                            <?php if($dossier->commentaire): ?>
                                <p class="text-sm text-slate-700 bg-slate-50 rounded-2xl p-4 leading-relaxed"><?php echo e($dossier->commentaire); ?></p>
                            <?php else: ?>
                                <p class="text-sm text-slate-400 italic">Aucun commentaire.</p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-2">Réponse</h3>
                            <?php if($dossier->reponse): ?>
                                <p class="text-sm text-slate-700 bg-slate-50 rounded-2xl p-4 leading-relaxed"><?php echo e($dossier->reponse); ?></p>
                            <?php else: ?>
                                <p class="text-sm text-slate-400 italic">Aucune réponse.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6">
                        <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-4">
                            Paiements
                            <span class="ml-2 px-2 py-0.5 rounded-lg bg-slate-100 text-slate-500 text-xs"><?php echo e($dossier->paiements->count()); ?></span>
                        </h3>
                        <?php $__empty_1 = true; $__currentLoopData = $dossier->paiements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paiement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-2xl mb-2">
                            <div>
                                <p class="text-xs font-black text-slate-700"><?php echo e($paiement->reference ?? '—'); ?></p>
                                <p class="text-xs text-slate-400"><?php echo e($paiement->created_at?->format('d/m/Y')); ?></p>
                            </div>
                            <span class="text-sm font-black text-green-600"><?php echo e(number_format($paiement->montant ?? 0, 2)); ?> MAD</span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-slate-400 italic">Aucun paiement enregistré.</p>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6">
                        <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-4">
                            Présentations
                            <span class="ml-2 px-2 py-0.5 rounded-lg bg-slate-100 text-slate-500 text-xs"><?php echo e($dossier->presentations->count()); ?></span>
                        </h3>
                        <?php $__empty_1 = true; $__currentLoopData = $dossier->presentations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $presentation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-2xl mb-2">
                            <div>
                                <p class="text-xs font-black text-slate-700"><?php echo e($presentation->titre ?? '—'); ?></p>
                                <p class="text-xs text-slate-400"><?php echo e($presentation->created_at?->format('d/m/Y')); ?></p>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-slate-400 italic">Aucune présentation enregistrée.</p>
                        <?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/dossiers/show.blade.php ENDPATH**/ ?>