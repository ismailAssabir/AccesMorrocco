<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b border-slate-100 bg-slate-50/50">
                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Collaborateur</th>
                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Poste</th>
                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Contrat</th>
                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Département</th>
                <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-slate-50/80 transition-colors group">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#be2346]/10 flex items-center justify-center font-bold text-xs text-[#be2346]">
                            <?php echo e(strtoupper(substr($user->firstName, 0, 1))); ?><?php echo e(strtoupper(substr($user->lastName, 0, 1))); ?>

                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-slate-700"><?php echo e($user->firstName); ?> <?php echo e($user->lastName); ?></span>
                            <span class="text-[11px] text-slate-400"><?php echo e($user->email); ?></span>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-slate-600 font-medium"><?php echo e($user->post ?? 'Non défini'); ?></td>
                <td class="px-6 py-4">
                    <span class="text-[10px] font-black text-slate-400 uppercase">
                        <?php echo e($user->typeContrat == 'CD' ? 'CDI' : ($user->typeContrat == 'CI' ? 'CI' : ($user->typeContrat ?: 'Non défini'))); ?>

                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-medium text-slate-500"><?php echo e($user->departement->title ?? 'Aucun'); ?></span>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <button onclick='openViewModal(<?php echo json_encode($user, 15, 512) ?>)' class="p-2 rounded-lg text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-all" title="Voir les détails">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </button>
                        <button onclick='openEditModal(<?php echo json_encode($user, 15, 512) ?>)' class="p-2 rounded-lg text-slate-400 hover:bg-[#be2346]/10 hover:text-[#be2346] transition-all" title="Modifier">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z" /></svg>
                        </button>
                        <button onclick="confirmDeleteUser('<?php echo e(route('users.destroy', $user->idUser )); ?>')" class="p-2 rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-600 transition-all" title="Supprimer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5" class="px-6 py-20">
                    <div class="flex flex-col items-center justify-center text-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="text-slate-800 font-bold">Aucun résultat</h3>
                        <p class="text-slate-400 text-sm mt-1">Nous n'avons trouvé aucun collaborateur correspondant à vos critères.</p>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if($users->hasPages()): ?>
<div class="px-6 py-4 border-t border-slate-100 bg-white">
    <?php echo e($users->links('vendor.pagination.tailwind_saas')); ?>

</div>
<?php endif; ?>
<?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/partials/_user_table.blade.php ENDPATH**/ ?>