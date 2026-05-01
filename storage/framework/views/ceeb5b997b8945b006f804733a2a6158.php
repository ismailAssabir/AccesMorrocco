<?php $__empty_1 = true; $__currentLoopData = $conges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php
    $empName = $conge->user ? trim(($conge->user->firstName ?? '') . ' ' . ($conge->user->lastName ?? '')) : 'Employé';
?>
<tr class="hover:bg-slate-50 transition-colors">
    <td class="px-6 py-4 font-bold text-slate-800">#<?php echo e($conge->idConge); ?></td>
    <td class="px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs shrink-0">
                <?php echo e(mb_substr($empName, 0, 1)); ?>

            </div>
            <span class="font-bold text-slate-800"><?php echo e($empName); ?></span>
        </div>
    </td>
    <td class="px-6 py-4 font-bold text-slate-600 capitalize">
        <?php echo e(str_replace('_', ' ', $conge->type)); ?>

    </td>
    <td class="px-6 py-4 text-slate-500">
        <div class="text-xs">
            <span class="block">Du: <span class="font-bold text-slate-700"><?php echo e($conge->dateDebut); ?></span></span>
            <span class="block mt-0.5">Au: <span class="font-bold text-slate-700"><?php echo e($conge->dateFin); ?></span></span>
        </div>
    </td>
    <td class="px-6 py-4 font-bold text-slate-600">
        <?php echo e($conge->dateDemande); ?>

    </td>
    <td class="px-6 py-4">
        <?php if($conge->status == 'approuve'): ?>
            <span class="bg-emerald-50 text-emerald-600 font-bold px-3 py-1 rounded-full text-xs border border-emerald-200">Approuvé</span>
        <?php elseif($conge->status == 'refuse'): ?>
            <span class="bg-red-50 text-red-600 font-bold px-3 py-1 rounded-full text-xs border border-red-200">Refusé</span>
        <?php else: ?>
            <span class="bg-amber-50 text-amber-600 font-bold px-3 py-1 rounded-full text-xs border border-amber-200">En attente</span>
        <?php endif; ?>
    </td>
    <td class="px-6 py-4 text-right">
        <div class="flex items-center justify-end gap-2">
            
            <button onclick="openShowCongeModal('<?php echo e($conge->idConge); ?>')" class="text-slate-400 hover:text-blue-500 bg-white hover:bg-blue-50 p-2 rounded-lg border border-slate-200 transition-colors shadow-sm" title="Voir les détails">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
            </button>

            
            <?php if(auth()->user()->type === 'admin' || auth()->user()->type === 'manager'): ?>
                <?php if($conge->status != 'approuve'): ?>
                    <form action="<?php echo e(route('conge.update', $conge->idConge)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="hidden" name="status" value="approuve">
                        <button type="submit" class="text-emerald-500 hover:text-emerald-600 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 p-2 rounded-lg transition-colors shadow-sm" title="Approuver">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </button>
                    </form>
                <?php endif; ?>
                
                <?php if($conge->status != 'refuse'): ?>
                    <form action="<?php echo e(route('conge.update', $conge->idConge)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="hidden" name="status" value="refuse">
                        <button type="submit" class="text-[#b11d40] hover:text-[#911633] bg-[#b11d40]/10 hover:bg-[#b11d40]/20 border border-[#b11d40]/30 p-2 rounded-lg transition-colors shadow-sm" title="Refuser">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>

            
            <?php if(auth()->check() && (auth()->user()->idUser == $conge->idUser || auth()->id() == $conge->idUser) && $conge->status == 'en_attente'): ?>
                <button onclick="openEditCongeModal('<?php echo e($conge->idConge); ?>')" class="text-amber-500 hover:text-amber-600 bg-amber-50 hover:bg-amber-100 border border-amber-200 p-2 rounded-lg transition-colors shadow-sm" title="Modifier">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                </button>
            <?php endif; ?>

            
            <?php if(auth()->user()->type === 'admin' || ((auth()->user()->idUser == $conge->idUser || auth()->id() == $conge->idUser) && $conge->status == 'en_attente')): ?>
                <button type="button" onclick="confirmDeleteConge('<?php echo e($conge->idConge); ?>', '<?php echo e(route('conge.destroy', $conge->idConge)); ?>')" class="text-slate-500 hover:text-red-600 bg-slate-50 hover:bg-red-50 border border-slate-200 p-2 rounded-lg transition-colors shadow-sm" title="Supprimer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
            <?php endif; ?>
        </div>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr>
    <td colspan="7" class="px-6 py-10 text-center text-slate-500 font-medium">
        Aucune demande de congé trouvée.
    </td>
</tr>
<?php endif; ?>
<?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/conges/partials/table.blade.php ENDPATH**/ ?>