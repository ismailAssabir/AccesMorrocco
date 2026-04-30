<?php $__empty_1 = true; $__currentLoopData = $reunions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reunion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr class="hover:bg-slate-50/50 transition-colors group">
        <td class="px-6 py-4">
            <div class="flex flex-col">
                <span class="text-sm font-bold text-slate-800"><?php echo e($reunion->titre); ?></span>
                <span class="text-[10px] text-slate-400 font-medium line-clamp-1"><?php echo e($reunion->objectif); ?></span>
            </div>
        </td>
        <td class="px-6 py-4">
            <div class="flex flex-col">
                <span class="text-[11px] font-bold text-slate-600">
                    <?php echo e(\Carbon\Carbon::parse($reunion->dateHeure)->format('d/m/Y')); ?>

                </span>
                <span class="text-[10px] text-slate-400">
                    <?php echo e(\Carbon\Carbon::parse($reunion->dateHeure)->format('H:i')); ?> - <?php echo e($reunion->heureFin ? \Carbon\Carbon::parse($reunion->heureFin)->format('H:i') : '...'); ?>

                </span>
            </div>
        </td>
        <td class="px-6 py-4">
            <span class="px-2 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-widest border <?php echo e($reunion->type === 'Présentiel' ? 'bg-blue-50 text-blue-500 border-blue-200' : 'bg-purple-50 text-purple-500 border-purple-200'); ?>">
                <?php echo e($reunion->type); ?>

            </span>
        </td>
        <td class="px-6 py-4">
            <?php if($reunion->idDepartement): ?>
                <span class="text-[10px] font-bold text-[#be2346] bg-[#be2346]/5 px-2 py-1 rounded-lg border border-[#be2346]/10">
                    <?php echo e($reunion->departement->title); ?>

                </span>
            <?php else: ?>
                <span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-lg border border-slate-200">
                    Toute l'agence
                </span>
            <?php endif; ?>
        </td>
        <td class="px-6 py-4">
            <div class="flex -space-x-2">
                <?php $__currentLoopData = $reunion->participants->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="w-6 h-6 rounded-lg bg-slate-100 border border-white flex items-center justify-center text-[8px] font-black text-[#be2346] shadow-sm" title="<?php echo e($u->firstName); ?> <?php echo e($u->lastName); ?>">
                        <?php echo e(substr($u->firstName, 0, 1)); ?>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($reunion->participants->count() > 3): ?>
                    <div class="w-6 h-6 rounded-lg bg-slate-200 border border-white flex items-center justify-center text-[8px] font-black text-slate-500 shadow-sm">
                        +<?php echo e($reunion->participants->count() - 3); ?>

                    </div>
                <?php endif; ?>
                <?php if($reunion->participants->isEmpty() && !$reunion->idDepartement): ?>
                    <span class="text-[10px] text-slate-400 italic">Tous les employés</span>
                <?php elseif($reunion->participants->isEmpty()): ?>
                    <span class="text-[10px] text-slate-400 italic">Départemental</span>
                <?php endif; ?>
            </div>
        </td>
        <td class="px-6 py-4 text-right">
            <div class="flex justify-end gap-2">
                <a href="<?php echo e(route('reunions.show', $reunion->idReunion)); ?>" class="p-2 rounded-xl text-slate-400 hover:bg-blue-50 hover:text-blue-500 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                </a>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('reunion.edit')): ?>
                <a href="<?php echo e(route('reunions.edit', $reunion->idReunion)); ?>" class="p-2 rounded-xl text-slate-400 hover:bg-[#be2346]/10 hover:text-[#be2346] transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('reunion.delete')): ?>
                <button onclick="confirmDeleteMeeting('<?php echo e($reunion->idReunion); ?>')" class="p-2 rounded-xl text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
                <?php endif; ?>
            </div>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr>
        <td colspan="6" class="px-6 py-12 text-center">
            <div class="flex flex-col items-center">
                <svg class="w-10 h-10 text-slate-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="text-sm font-bold text-slate-400 uppercase tracking-widest">Aucune réunion prévue</span>
            </div>
        </td>
    </tr>
<?php endif; ?>

<?php if($reunions instanceof \Illuminate\Pagination\LengthAwarePaginator && $reunions->hasPages()): ?>
    <tr>
        <td colspan="6" class="px-6 py-4 bg-slate-50/50 meetings-pagination">
            <?php echo e($reunions->links('vendor.pagination.tailwind_saas')); ?>

        </td>
    </tr>
<?php endif; ?>
<?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/reunions/partials/table.blade.php ENDPATH**/ ?>