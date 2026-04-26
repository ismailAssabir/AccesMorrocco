<?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="<?php echo e(__('Pagination Navigation')); ?>" class="flex flex-col items-center justify-center gap-4 py-4">
        
        <div class="flex items-center gap-2">
            
            <?php if($paginator->onFirstPage()): ?>
                <span class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-300 cursor-default border border-slate-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </span>
            <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-slate-100 text-slate-500 hover:border-[#b11d40] hover:text-[#b11d40] hover:shadow-lg hover:shadow-[#b11d40]/10 transition-all duration-300" aria-label="<?php echo e(__('pagination.previous')); ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </a>
            <?php endif; ?>

            
            <div class="flex items-center gap-2 px-1">
                <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(is_string($element)): ?>
                        <span class="text-slate-400 px-1 font-bold"><?php echo e($element); ?></span>
                    <?php endif; ?>

                    <?php if(is_array($element)): ?>
                        <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($page == $paginator->currentPage()): ?>
                                <span class="w-10 h-10 flex items-center justify-center rounded-full bg-[#b11d40] text-white text-sm font-black shadow-xl shadow-[#b11d40]/30 ring-4 ring-[#b11d40]/15 z-10 scale-110">
                                    <?php echo e($page); ?>

                                </span>
                            <?php else: ?>
                                <a href="<?php echo e($url); ?>" class="w-9 h-9 flex items-center justify-center rounded-full text-slate-500 text-sm font-bold hover:bg-slate-100 hover:text-slate-800 transition-all duration-300">
                                    <?php echo e($page); ?>

                                </a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-slate-100 text-slate-500 hover:border-[#b11d40] hover:text-[#b11d40] hover:shadow-lg hover:shadow-[#b11d40]/10 transition-all duration-300" aria-label="<?php echo e(__('pagination.next')); ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            <?php else: ?>
                <span class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-300 cursor-default border border-slate-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </span>
            <?php endif; ?>
        </div>

        
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] opacity-60">
            Page <span class="text-slate-900"><?php echo e($paginator->currentPage()); ?></span> sur <?php echo e($paginator->lastPage()); ?>

        </p>
    </nav>
<?php endif; ?>
<?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/vendor/pagination/tailwind_saas.blade.php ENDPATH**/ ?>