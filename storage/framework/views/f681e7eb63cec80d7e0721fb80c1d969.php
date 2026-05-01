<?php $__env->startSection('title', 'Les Dossiers — Espace Client'); ?>
<?php $__env->startSection('page-title', 'Mes dossiers'); ?>
<?php $__env->startSection('page-subtitle', ''); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-8">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-5">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Dossiers</p>
                    <p class="text-2xl font-black text-slate-800"><?php echo e($dossiers->total()); ?></p>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-5">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Investissement</p>
                    <p class="text-2xl font-black text-slate-800"><?php echo e(number_format($dossiers->sum('montant'), 2, ',', ' ')); ?> MAD</p>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Liste des dossiers</h3>
                <span class="px-3 py-1 bg-white border border-slate-200 rounded-full text-[10px] font-bold text-slate-500">
                    <?php echo e($dossiers->count()); ?> dossier(s) sur cette page
                </span>
            </div>

            <div class="overflow-x-auto">
                <?php if($dossiers->count() > 0): ?>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Référence</th>
                                <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Destination & Voyage</th>
                                <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Pers.</th>
                                <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Statut</th>
                                <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php $__currentLoopData = $dossiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dossier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-slate-700">#<?php echo e($dossier->reference); ?></span>
                                            <span class="text-[10px] text-slate-400 italic">Créé le <?php echo e($dossier->created_at->format('d/m/Y')); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-bold text-slate-700 group-hover:text-[#be2346] transition-colors">
                                            <?php echo e($dossier->distination ?? 'Non spécifiée'); ?>

                                        </p>
                                        <p class="text-[10px] text-slate-500 font-medium">
                                            <?php if($dossier->dateVoyage): ?>
                                                Départ le <?php echo e(\Carbon\Carbon::parse($dossier->dateVoyage)->format('d/m/Y')); ?> 
                                                (<?php echo e($dossier->nombreJours); ?> jours)
                                            <?php else: ?>
                                                Date non fixée
                                            <?php endif; ?>
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-xs font-bold text-slate-600 bg-slate-100 px-2 py-1 rounded-lg">
                                            <?php echo e($dossier->nombrePersonnes); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <?php
                                            $statusClasses = match($dossier->status) {
                                                'ouvert' => 'bg-blue-50 text-blue-600 border-blue-100',
                                                'en_cours' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                'ferme' => 'bg-slate-100 text-slate-500 border-slate-200',
                                                default => 'bg-slate-50 text-slate-600 border-slate-100',
                                            };
                                            $statusLabel = match($dossier->status) {
                                                'ouvert' => 'Ouvert',
                                                'en_cours' => 'En Cours',
                                                'ferme' => 'Fermé',
                                                default => $dossier->status,
                                            };
                                        ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase border <?php echo e($statusClasses); ?>">
                                            <?php echo e($statusLabel); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="<?php echo e(route('clients.dossiers.show', $dossier->idDossier)); ?>" 
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 hover:bg-[#be2346] text-slate-600 hover:text-white rounded-xl text-xs font-bold transition-all active:scale-95 shadow-sm hover:shadow-[#be2346]/20">
                                            <span>Consulter</span>
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    
                    <div class="py-20 flex flex-col items-center justify-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mb-4 border border-slate-100 text-slate-300">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <p class="text-slate-400 text-sm font-medium">Vous n'avez pas encore de dossier de voyage.</p>
                        <a href="#" class="mt-4 text-[#be2346] text-xs font-bold uppercase tracking-widest hover:underline">Créer une demande</a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if($dossiers->hasPages()): ?>
                <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                    <?php echo e($dossiers->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/clients/dossiers/index.blade.php ENDPATH**/ ?>