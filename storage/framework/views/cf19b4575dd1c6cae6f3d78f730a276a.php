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
        <div class="flex items-center gap-4 mb-8">
            <a href="<?php echo e(route('permissions.index')); ?>" class="w-9 h-9 rounded-xl border border-slate-200 bg-white flex items-center justify-center shadow-sm">
                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Permissions du Rôle : <span class="text-[#b11d40]"><?php echo e(ucfirst($role->name)); ?></span></h1>
            </div>
        </div>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission.edit')): ?>
        <form action="<?php echo e(route('permissions.update', $role->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $perms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-50">
                            <p class="font-black text-slate-800 uppercase tracking-widest text-xs"><?php echo e($module); ?></p>
                            <label class="text-[10px] font-bold text-[#b11d40] cursor-pointer">
                                <input type="checkbox" class="select-all mr-1" data-module="<?php echo e($module); ?>"> Tout cocher
                            </label>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <?php $__currentLoopData = $perms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-slate-50/30 cursor-pointer hover:border-[#b11d40]/30 transition-all">
                                <input type="checkbox" name="permissions[]" value="<?php echo e($perm->name); ?>" 
                                       class="perm-<?php echo e($module); ?> accent-[#b11d40]"
                                       <?php echo e($role->hasPermissionTo($perm->name) ? 'checked' : ''); ?>>
                                <span class="text-xs font-bold text-slate-700"><?php echo e(explode('.', $perm->name)[1]); ?></span>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="sticky bottom-8 mt-10 flex justify-end">
                <button type="submit" class="bg-[#b11d40] text-white px-10 py-4 rounded-2xl font-black shadow-xl shadow-[#b11d40]/20 hover:scale-105 transition-transform">
                    Enregistrer les modifications pour <?php echo e($role->name); ?>

                </button>
            </div>
        </form>
    </div>
<?php endif; ?>
    <script>
        document.querySelectorAll('.select-all').forEach(check => {
            check.addEventListener('change', function() {
                document.querySelectorAll('.perm-' + this.dataset.module).forEach(p => p.checked = this.checked);
            });
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\Legion UCGS.ma\Desktop\project\AccesMorrocco\resources\views/permissions/edit.blade.php ENDPATH**/ ?>