<div x-data="{ 
    todoPage: 1, 
    enCoursPage: 1, 
    terminePage: 1, 
    perPage: 4 
}" class="space-y-8">
    <div id="kanban-board" class="grid grid-cols-1 lg:grid-cols-3 gap-6 transition-all duration-300">
        
        
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between px-2">
                <h2 class="text-sm font-black uppercase tracking-widest text-slate-400 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                    À FAIRE
                </h2>
                <span class="bg-slate-100 text-slate-500 text-[10px] font-bold px-2 py-0.5 rounded-full"><?php echo e($todoTasks->count()); ?></span>
            </div>
            <div class="flex flex-col gap-4 min-h-[300px]">
                <?php $todoArray = $todoTasks->values()->toArray(); ?>
                <?php $__currentLoopData = $todoTasks->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tache): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div x-show="$index >= (todoPage-1)*perPage && $index < todoPage*perPage" 
                         x-data="{ $index: <?php echo e($index); ?> }"
                         class="transition-all duration-300">
                        <?php echo $__env->make('taches.card', ['tache' => $tache], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                <?php if($todoTasks->isEmpty()): ?>
                    <div class="p-8 border-2 border-dashed border-slate-200 rounded-[24px] flex flex-col items-center justify-center text-slate-400">
                        <p class="text-xs font-bold uppercase tracking-widest">Aucune tâche</p>
                    </div>
                <?php endif; ?>
            </div>

            
            <?php if($todoTasks->count() > 4): ?>
                <div class="flex items-center justify-center gap-4 mt-2">
                    <button @click="todoPage > 1 ? todoPage-- : null" :disabled="todoPage === 1" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-400 disabled:opacity-30 hover:text-[#be2346] transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Page <span x-text="todoPage"></span></span>
                    <button @click="todoPage * perPage < <?php echo e($todoTasks->count()); ?> ? todoPage++ : null" :disabled="todoPage * perPage >= <?php echo e($todoTasks->count()); ?>" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-400 disabled:opacity-30 hover:text-[#be2346] transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between px-2">
                <h2 class="text-sm font-black uppercase tracking-widest text-blue-400 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                    EN COURS
                </h2>
                <span class="bg-blue-50 text-blue-500 text-[10px] font-bold px-2 py-0.5 rounded-full"><?php echo e($enCoursTasks->count()); ?></span>
            </div>
            <div class="flex flex-col gap-4 min-h-[300px]">
                <?php $__currentLoopData = $enCoursTasks->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tache): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div x-show="$index >= (enCoursPage-1)*perPage && $index < enCoursPage*perPage" 
                         x-data="{ $index: <?php echo e($index); ?> }"
                         class="transition-all duration-300">
                        <?php echo $__env->make('taches.card', ['tache' => $tache], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if($enCoursTasks->isEmpty()): ?>
                    <div class="p-8 border-2 border-dashed border-slate-200 rounded-[24px] flex flex-col items-center justify-center text-slate-400">
                        <p class="text-xs font-bold uppercase tracking-widest">Aucune tâche</p>
                    </div>
                <?php endif; ?>
            </div>

            
            <?php if($enCoursTasks->count() > 4): ?>
                <div class="flex items-center justify-center gap-4 mt-2">
                    <button @click="enCoursPage > 1 ? enCoursPage-- : null" :disabled="enCoursPage === 1" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-400 disabled:opacity-30 hover:text-[#be2346] transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Page <span x-text="enCoursPage"></span></span>
                    <button @click="enCoursPage * perPage < <?php echo e($enCoursTasks->count()); ?> ? enCoursPage++ : null" :disabled="enCoursPage * perPage >= <?php echo e($enCoursTasks->count()); ?>" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-400 disabled:opacity-30 hover:text-[#be2346] transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between px-2">
                <h2 class="text-sm font-black uppercase tracking-widest text-emerald-400 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    TERMINÉ
                </h2>
                <span class="bg-emerald-50 text-emerald-500 text-[10px] font-bold px-2 py-0.5 rounded-full"><?php echo e($termineTasks->count()); ?></span>
            </div>
            <div class="flex flex-col gap-4 min-h-[300px]">
                <?php $__currentLoopData = $termineTasks->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tache): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div x-show="$index >= (terminePage-1)*perPage && $index < terminePage*perPage" 
                         x-data="{ $index: <?php echo e($index); ?> }"
                         class="transition-all duration-300">
                        <?php echo $__env->make('taches.card', ['tache' => $tache], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if($termineTasks->isEmpty()): ?>
                    <div class="p-8 border-2 border-dashed border-slate-200 rounded-[24px] flex flex-col items-center justify-center text-slate-400">
                        <p class="text-xs font-bold uppercase tracking-widest">Aucune tâche</p>
                    </div>
                <?php endif; ?>
            </div>

            
            <?php if($termineTasks->count() > 4): ?>
                <div class="flex items-center justify-center gap-4 mt-2">
                    <button @click="terminePage > 1 ? terminePage-- : null" :disabled="terminePage === 1" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-400 disabled:opacity-30 hover:text-[#be2346] transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Page <span x-text="terminePage"></span></span>
                    <button @click="terminePage * perPage < <?php echo e($termineTasks->count()); ?> ? terminePage++ : null" :disabled="terminePage * perPage >= <?php echo e($termineTasks->count()); ?>" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-400 disabled:opacity-30 hover:text-[#be2346] transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/taches/partials/board.blade.php ENDPATH**/ ?>