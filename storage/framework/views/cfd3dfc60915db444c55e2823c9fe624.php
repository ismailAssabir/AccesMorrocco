<?php $__empty_1 = true; $__currentLoopData = $primes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prime): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr class="hover:bg-slate-50 transition-colors">
    
    <td class="px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center font-black text-xs text-[#b11d40]">
                <?php echo e(substr($prime->user->firstName ?? 'U', 0, 1)); ?><?php echo e(substr($prime->user->lastName ?? 'N', 0, 1)); ?>

            </div>
            <div>
                <p class="font-bold text-slate-800"><?php echo e($prime->user->firstName ?? 'N/A'); ?> <?php echo e($prime->user->lastName ?? ''); ?></p>
                <p class="text-[10px] text-slate-400 uppercase font-black tracking-widest"><?php echo e($prime->user->post ?? 'Poste non défini'); ?></p>
            </div>
        </div>
    </td>

    
    <td class="px-6 py-4">
        <span class="font-black text-slate-700"><?php echo e(number_format($prime->montant, 2)); ?> MAD</span>
    </td>

    
    <td class="px-6 py-4">
        <div class="flex flex-col gap-1">
            <p class="text-slate-600 font-medium"><?php echo e($prime->motif ?? 'Aucun motif'); ?></p>
            <div class="flex gap-2">
                <?php if($prime->idTache): ?>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-blue-50 text-blue-600 text-[10px] font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Tâche
                    </span>
                <?php endif; ?>
                <?php if($prime->idPointage): ?>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-purple-50 text-purple-600 text-[10px] font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Pointage
                    </span>
                <?php endif; ?>
                <?php if($prime->idObjectif): ?>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-emerald-50 text-emerald-600 text-[10px] font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Objectif
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </td>

    
    <td class="px-6 py-4">
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
        <span class="px-3 py-1 rounded-xl text-[10px] font-black uppercase <?php echo e($statusColors[$prime->status] ?? 'bg-slate-100 text-slate-500'); ?>">
            <?php echo e($statusLabels[$prime->status] ?? $prime->status); ?>

        </span>
    </td>

    
    <td class="px-6 py-4">
        <p class="text-xs font-bold text-slate-500"><?php echo e(\Carbon\Carbon::parse($prime->dateAttribution)->format('d/m/Y')); ?></p>
    </td>

    
    <td class="px-6 py-4 text-right">
        <div class="flex items-center justify-end gap-2">
            <button onclick="openShowModal(<?php echo e(json_encode($prime)); ?>)" title="Voir les détails"
               class="p-2 rounded-xl text-slate-400 hover:text-[#b11d40] hover:bg-[#b11d40]/5 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prime.edit')): ?>
            <?php if($prime->status !== 'payee'): ?>
            <button onclick="openEditModal(<?php echo e(json_encode($prime)); ?>)"
                    class="p-2 rounded-xl text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </button>
            <?php endif; ?>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prime.delete')): ?>
            <button type="button" onclick="window.confirmDelete('<?php echo e(route('primes.destroy', $prime->idPrime)); ?>', 'prime')" 
                class="p-2 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
            <?php endif; ?>
        </div>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr>
    <td colspan="6" class="px-6 py-12 text-center">
        <div class="flex flex-col items-center justify-center text-slate-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-3 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="font-bold">Aucune prime enregistrée</p>
            <p class="text-xs">Commencez par attribuer une prime à un employé.</p>
        </div>
    </td>
</tr>
<?php endif; ?>
<?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/primes/partials/table.blade.php ENDPATH**/ ?>