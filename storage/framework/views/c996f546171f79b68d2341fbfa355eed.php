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
            <h1 class="text-2xl font-extrabold text-slate-800">Gestion des Permissions Clients</h1>
            <p class="text-slate-500 text-sm">Gérez les rôles et permissions des clients</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
            
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-xs uppercase">
                        <th class="px-4 py-4 text-left">ID</th>
                        <th class="px-4 py-4 text-left">Client</th>
                        <th class="px-4 py-4 text-left">Email</th>
                        <th class="px-4 py-4 text-left">Rôles</th>
                        <th class="px-4 py-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-4"><?php echo e($client->idClient); ?></td>
                        <td class="px-4 py-4 font-bold"><?php echo e($client->firstName); ?> <?php echo e($client->lastName); ?></td>
                        <td class="px-4 py-4"><?php echo e($client->email); ?></td>
                        <td class="px-4 py-4">
                            <?php $__currentLoopData = $client->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs">
                                    <?php echo e($role->name); ?>

                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td class="px-4 py-4">
                            <a href="<?php echo e(route('admin.clients.permissions.edit', $client)); ?>" 
                               class="text-[#b11d40] hover:text-[#7c1233]">
                                ✏️ Gérer
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-16 text-slate-400">
                            Aucun client trouvé
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <div class="p-4">
                <?php echo e($clients->links()); ?>

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
<?php endif; ?><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/admin/clients/permissions/index.blade.php ENDPATH**/ ?>