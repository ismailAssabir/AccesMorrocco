<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="p-8 bg-[#F8FAFC] min-h-screen">

        
        <div class="mb-8">
            <div class="flex items-center gap-4">
                <a href="<?php echo e(route('categories.index')); ?>" 
                   class="p-2 rounded-lg text-slate-400 hover:text-[#b11d40] hover:bg-[#b11d40]/10 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-800">Détails de la Catégorie</h1>
                    <p class="text-slate-500 text-sm">Informations complètes de la catégorie</p>
                </div>
            </div>
        </div>

        
        <?php if(session('msg')): ?>
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm font-semibold">
                <?php echo e(session('msg')); ?>

            </div>
        <?php endif; ?>

        
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden max-w-4xl mx-auto">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
            
            <div class="p-8">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-16 h-16 rounded-2xl bg-[#b11d40]/10 flex items-center justify-center">
                        <span class="text-[#b11d40] font-black text-2xl">
                            <?php echo e(strtoupper(substr($category->nom, 0, 2))); ?>

                        </span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-800"><?php echo e($category->nom); ?></h2>
                        <p class="text-slate-500 text-sm">ID: #<?php echo e($category->id); ?></p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="border-b border-slate-100 pb-4">
                        <label class="block text-xs font-black text-slate-500 uppercase mb-2">Titre</label>
                        <p class="text-slate-800 text-lg font-semibold"><?php echo e($category->nom); ?></p>
                    </div>

                    <div class="border-b border-slate-100 pb-4">
                        <label class="block text-xs font-black text-slate-500 uppercase mb-2">Description</label>
                        <div class="text-slate-700 leading-relaxed">
                            <?php echo e($category->desc ?: 'Aucune description disponible'); ?>

                        </div>
                    </div>

                    <div class="border-b border-slate-100 pb-4">
                        <label class="block text-xs font-black text-slate-500 uppercase mb-2">Informations système</label>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-slate-500">Créé le :</span>
                                <span class="text-slate-800 font-semibold ml-2"><?php echo e($category->created_at ? $category->created_at->format('d/m/Y à H:i') : '—'); ?></span>
                            </div>
                            <div>
                                <span class="text-slate-500">Dernière modification :</span>
                                <span class="text-slate-800 font-semibold ml-2"><?php echo e($category->updated_at ? $category->updated_at->format('d/m/Y à H:i') : '—'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 justify-end mt-8 pt-4 border-t border-slate-100">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category.edit')): ?>
                    <a href="<?php echo e(route('categories.edit', $category)); ?>"
                       class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition-all text-sm">
                        Modifier
                    </a>
                    <?php endif; ?>
                    
                    <a href="<?php echo e(route('categories.index')); ?>"
                       class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">
                        Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/showCategory.blade.php ENDPATH**/ ?>