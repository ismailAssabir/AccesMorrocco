<?php $__empty_1 = true; $__currentLoopData = $objs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<div class="bg-white border border-slate-100 rounded-[2rem] shadow-xl shadow-slate-200/40 p-7 flex flex-col hover:shadow-2xl hover:shadow-[#b11d40]/5 transition-all duration-300 relative group hover:-translate-y-1">
    
    
    <div class="flex justify-between items-start mb-6">
        <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shrink-0 shadow-sm border border-indigo-100/50">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
        </div>
        <div class="flex items-center gap-2">
            <span class="<?php echo e($obj->status_config['class']); ?> font-bold px-3.5 py-1.5 rounded-xl text-[10px] uppercase tracking-wider shadow-sm border border-current/10">
                <?php echo e($obj->status_config['label']); ?>

            </span>
        </div>
    </div>
    
    
    <div class="mb-6">
        <h3 class="text-xl font-extrabold text-slate-900 mb-2 leading-tight group-hover:text-[#b11d40] transition-colors"><?php echo e($obj->titre); ?></h3>
        <p class="text-slate-500 text-sm leading-relaxed line-clamp-2 font-medium"><?php echo e($obj->description); ?></p>
    </div>

    
    <div class="flex flex-wrap items-center gap-4 mb-8 pt-4 border-t border-slate-50">
        <div class="flex items-center gap-2 text-slate-400">
            <div class="w-7 h-7 rounded-lg bg-slate-50 flex items-center justify-center">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500"><?php echo e(optional($obj->departement)->title ?? 'Global'); ?></span>
        </div>
        <div class="flex items-center gap-2 text-slate-400">
            <div class="w-7 h-7 rounded-lg bg-slate-50 flex items-center justify-center">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">
                <?php echo e(($obj->departement && $obj->departement->manager) ? $obj->departement->manager->firstName . ' ' . $obj->departement->manager->lastName : ($obj->idDepartement ? 'Non assigné' : 'admin')); ?>

            </span>
        </div>
    </div>

    
    <div class="mt-auto">
        <div class="flex justify-between items-center mb-3">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Complétion Globale</span>
            <span class="text-lg font-black text-slate-900"><?php echo e($obj->avancement); ?>%</span>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden shadow-inner">
            <?php
                $progressColor = 'bg-rose-500';
                if($obj->avancement > 70) $progressColor = 'bg-emerald-500';
                elseif($obj->avancement > 30) $progressColor = 'bg-amber-500';
            ?>
            <div class="h-full rounded-full transition-all duration-1000 ease-out <?php echo e($progressColor); ?> shadow-sm" 
                 style="width: <?php echo e($obj->avancement); ?>%">
            </div>
        </div>
    </div>

    
    <?php if(auth()->user()->type !== 'employee'): ?>
    <div class="absolute inset-x-7 bottom-7 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0">
        <div class="bg-white/90 backdrop-blur-md border border-slate-100 rounded-2xl shadow-xl p-1.5 flex gap-1.5">
            <button type="button" onclick="openEditModal('<?php echo e($obj->idObjectif); ?>')" class="flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all font-bold text-xs">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Modifier
            </button>
            <button type="button" onclick="confirmDeleteObjectif('<?php echo e($obj->idObjectif); ?>')" class="flex items-center justify-center w-9 h-9 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<div class="col-span-full py-20 text-center bg-white rounded-3xl border border-dashed border-slate-300">
    <p class="text-slate-400 font-medium">Aucun objectif trouvé.</p>
</div>
<?php endif; ?>
<?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/objectifs/partials/cards.blade.php ENDPATH**/ ?>