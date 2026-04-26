

<div class="relative bg-white border border-slate-200 rounded-[24px] p-5 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
    
    <div class="absolute left-0 top-6 bottom-6 w-1.5 <?php echo e($tache->priority_config['border']); ?> rounded-r-full shadow-[0_0_10px_rgba(0,0,0,0.1)]"></div>

    
    <div class="flex justify-between items-start mb-2 pl-2">
        <h3 class="text-base font-extrabold text-slate-800 leading-tight group-hover:text-[#be2346] transition-colors line-clamp-1"><?php echo e($tache->titre); ?></h3>
        <div class="flex gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
            <?php if(auth()->user()->type !== 'employee'): ?>
            <button @click="openEditModal(<?php echo e(json_encode($tache)); ?>)" class="p-2 rounded-xl bg-slate-50 text-slate-400 hover:bg-[#be2346]/10 hover:text-[#be2346] transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            </button>
            <button type="button" @click="confirmDelete('<?php echo e($tache->idTache); ?>')" class="p-2 rounded-xl bg-slate-50 text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            </button>
            <?php endif; ?>
        </div>
    </div>

    
    <?php if($tache->description): ?>
        <p class="text-xs text-slate-500 font-medium mb-5 pl-2 line-clamp-2 leading-relaxed">
            <?php echo e($tache->description); ?>

        </p>
    <?php endif; ?>

    
    <div class="flex flex-wrap items-center gap-2 mb-5 pl-2">
        
        <span class="<?php echo e($tache->priority_config['bg']); ?> <?php echo e($tache->priority_config['text']); ?> text-[9px] font-black tracking-widest px-2.5 py-1 rounded-lg border <?php echo e(str_replace('bg-', 'border-', $tache->priority_config['bg'])); ?> shadow-sm uppercase">
            <?php echo e($tache->priority_config['label']); ?>

        </span>

        
        <?php if($tache->departement): ?>
            <div class="flex items-center gap-1.5 text-[9px] font-black text-blue-600 bg-blue-50/80 px-2.5 py-1 rounded-lg border border-blue-100 shadow-sm uppercase">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <?php echo e($tache->departement->title); ?>

            </div>
        <?php endif; ?>
    </div>

    
    <?php if($tache->dateDebut && $tache->duree): ?>
        <div class="bg-slate-50/80 rounded-2xl p-3 mb-5 pl-4 border border-slate-100/50 flex items-center justify-between group/time">
            <div class="flex flex-col gap-1">
                <div class="flex items-center gap-2 text-[10px] font-bold text-slate-600">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <div class="flex items-center gap-1.5">
                        <span><?php echo e($tache->dateDebut->format('d M, H:i')); ?></span>
                        <span class="text-slate-300">→</span>
                        <span><?php echo e($tache->duree->format('d M, H:i')); ?></span>
                    </div>
                </div>
            </div>
            
            <div class="w-fit flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-tight <?php echo e($tache->is_overdue ? 'bg-red-500 text-white shadow-lg shadow-red-500/20' : 'bg-white text-[#be2346] border border-slate-200'); ?>">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <?php echo e($tache->formatted_duration); ?>

            </div>
        </div>
    <?php endif; ?>

    
    <div class="flex items-center justify-between pt-4 border-t border-slate-100/60 pl-2">
        
        <div class="flex flex-wrap items-center gap-1.5 max-w-[70%]">
            <?php $__empty_1 = true; $__currentLoopData = $tache->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center gap-1.5 bg-slate-50 border border-slate-100 px-2 py-1 rounded-lg group/assignee shadow-sm">
                    
                    <div class="w-5 h-5 rounded-md bg-gradient-to-tr from-slate-100 to-slate-200 flex items-center justify-center text-[8px] font-black text-[#be2346] shadow-xs">
                        <?php echo e(substr($u->firstName, 0, 1)); ?><?php echo e(substr($u->lastName, 0, 1)); ?>

                    </div>
                    
                    
                    <span class="text-slate-600 font-bold text-[10px] truncate max-w-[70px]" title="<?php echo e($u->firstName); ?> <?php echo e($u->lastName); ?>">
                        <?php echo e(Str::limit($u->firstName . ' ' . $u->lastName, 12)); ?>

                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg bg-slate-50 border border-dashed border-slate-200 text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span class="text-[9px] font-bold uppercase tracking-widest">Non assigné</span>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="flex gap-1.5">
            <?php if($tache->status != 'todo'): ?>
                <button type="button" @click.prevent="changeStatus('<?php echo e($tache->idTache); ?>', '<?php echo e($tache->status == 'termine' ? 'en_cours' : 'todo'); ?>', $event)" class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-slate-200 hover:text-slate-600 transition-all shadow-sm" title="Précédent">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
            <?php endif; ?>

            <?php if($tache->status != 'termine'): ?>
                <button type="button" @click.prevent="changeStatus('<?php echo e($tache->idTache); ?>', '<?php echo e($tache->status == 'todo' ? 'en_cours' : 'termine'); ?>', $event)" class="w-8 h-8 flex items-center justify-center rounded-xl bg-[#be2346]/5 text-[#be2346] hover:bg-[#be2346] hover:text-white transition-all shadow-sm" title="Suivant">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="absolute bottom-1 right-1 opacity-[0.03] group-hover:opacity-10 transition-opacity pointer-events-none">
        <img src="<?php echo e(asset('images/logo.png')); ?>" class="w-12 h-12 grayscale" alt="Branding">
    </div>
</div>
<?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/taches/card.blade.php ENDPATH**/ ?>