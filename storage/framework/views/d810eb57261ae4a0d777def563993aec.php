

<?php $__env->startSection('title', 'Tableau de bord'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-8">
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-slate-800">Tableau de bord</h1>
        <p class="text-slate-500 text-sm">Bienvenue, <?php echo e($client->firstName); ?> <?php echo e($client->lastName); ?></p>
    </div>

    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
        <div class="p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Mes dossiers de voyage</h2>
            
            <?php if($dossiers->count() > 0): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $dossiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dossier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-slate-800">Réf: <?php echo e($dossier->reference); ?></p>
                                    <p class="text-sm text-slate-500">Destination: <?php echo e($dossier->distination); ?></p>
                                    <p class="text-sm text-slate-500">Date: <?php echo e($dossier->dateVoyage ?? 'Non définie'); ?></p>
                                    <p class="text-sm text-slate-500">Statut: 
                                        <span class="px-2 py-1 rounded-lg text-xs font-bold 
                                            <?php if($dossier->status == 'ouvert'): ?> bg-blue-100 text-blue-700
                                            <?php elseif($dossier->status == 'en_cours'): ?> bg-amber-100 text-amber-700
                                            <?php else: ?> bg-green-100 text-green-700
                                            <?php endif; ?>">
                                            <?php echo e($dossier->status); ?>

                                        </span>
                                    </p>
                                </div>
                                <a href="<?php echo e(route('dossiers.show', $dossier->idDossier)); ?>" 
                                   class="text-[#b11d40] hover:text-[#7c1233] font-semibold text-sm">
                                    Voir détails →
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="mt-4">
                    <?php echo e($dossiers->links()); ?>

                </div>
            <?php else: ?>
                <p class="text-slate-400 text-center py-8">Aucun dossier trouvé</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/clients/dashboard.blade.php ENDPATH**/ ?>