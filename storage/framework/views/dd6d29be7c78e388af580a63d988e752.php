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

    
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Gestion des Dossiers</h1>
            <p class="text-slate-500 text-sm">Suivez et gérez tous vos dossiers.</p>
        </div>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.create')): ?>
        <button onclick="document.getElementById('modal-create').classList.remove('hidden')"
            class="flex items-center gap-2 px-4 py-2 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">
            ➕ Nouveau Dossier
        </button>
        <?php endif; ?>
    </div>

    
    <?php if(session('msg')): ?>
    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm font-semibold">
        <?php echo e(session('msg')); ?>

    </div>
    <?php endif; ?>

    
    <form method="GET" class="mb-6 flex flex-col md:flex-row gap-3">

        <input type="text" name="search" value="<?php echo e(request('search')); ?>"
            placeholder="Recherche..."
            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm">

        <?php if (! (auth()->user()->hasRole('manager'))): ?>
        <select name="idDepartement"
            class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm">
            <option value="">Tous les départements</option>
            <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($dept->idDepartement); ?>"
                    <?php echo e(request('idDepartement') == $dept->idDepartement ? 'selected' : ''); ?>>
                    <?php echo e($dept->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php endif; ?>

        <select name="status"
            class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm">
            <option value="">Tous les statuts</option>
            <option value="ouvert" <?php echo e(request('status')=='ouvert'?'selected':''); ?>>Ouvert</option>
            <option value="en_cours" <?php echo e(request('status')=='en_cours'?'selected':''); ?>>En cours</option>
            <option value="ferme" <?php echo e(request('status')=='ferme'?'selected':''); ?>>Fermé</option>
        </select>

        <button class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl text-sm">
            Filtrer
        </button>

        <?php if(request()->hasAny(['search','status','idDepartement'])): ?>
        <a href="<?php echo e(route('dossiers.index')); ?>"
            class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl text-sm">
            Reset
        </a>
        <?php endif; ?>
    </form>

    
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-slate-400 text-xs uppercase">
                    <th class="px-4 py-4 text-left">Ref</th>
                    <th class="px-4 py-4 text-left">Client</th>
                    <th class="px-4 py-4 text-left">Destination</th>
                    <th class="px-4 py-4 text-left">Département</th>
                    <th class="px-4 py-4 text-left">Assigné</th>
                    <th class="px-4 py-4 text-left">Statut</th>
                    <th class="px-4 py-4 text-left">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-50">
                <?php $__empty_1 = true; $__currentLoopData = $dossiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dossier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-50">

                    <td class="px-4 py-4 font-bold text-slate-700">
                        <?php echo e($dossier->reference); ?>

                    </td>

                    <td class="px-4 py-4">
                        <?php echo e($dossier->client->firstName ?? ''); ?>

                        <?php echo e($dossier->client->lastName ?? ''); ?>

                    </td>

                    <td class="px-4 py-4"><?php echo e($dossier->distination); ?></td>

                    <td class="px-4 py-4">
                        <?php echo e($dossier->departement->name ?? '-'); ?>

                    </td>

                    <td class="px-4 py-4 text-green-600 font-bold">
                        <?php echo e($dossier->user->name ?? 'Non assigné'); ?>

                    </td>

                    <td class="px-4 py-4">
                        <span class="px-2 py-1 rounded-lg text-xs font-bold bg-slate-100">
                            <?php echo e($dossier->status); ?>

                        </span>
                    </td>

                    <td class="px-4 py-4 flex gap-2">

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.view')): ?>
                        <a href="<?php echo e(route('dossiers.show',$dossier->idDossier)); ?>">👁</a>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.edit')): ?>
                        <a href="<?php echo e(route('dossiers.edit',$dossier->idDossier)); ?>">✏</a>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.delete')): ?>
                        <form method="POST" action="<?php echo e(route('dossiers.destroy',$dossier->idDossier)); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button>🗑</button>
                        </form>
                        <?php endif; ?>

                        
                        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'manager')): ?>
                        <?php if(auth()->user()->idDepartement == $dossier->idDepartement): ?>
                        <button onclick="openAssignModal(<?php echo e($dossier->idDossier); ?>, <?php echo e($dossier->idDepartement); ?>)">
                            👤
                        </button>
                        <?php endif; ?>
                        <?php endif; ?>

                    </td>

                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center py-16 text-slate-400">
                        Aucun dossier trouvé
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        
        <div class="p-4">
            <?php echo e($dossiers->links()); ?>

        </div>
    </div>

</div>


<div id="modal-assign" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center">
    <div class="bg-white p-6 rounded-2xl w-full max-w-md">

        <h2 class="font-bold mb-4">Assigner un employé</h2>

        <form method="POST" id="assignForm">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <select name="idUser" id="assign-user"
                class="w-full px-3 py-2 border rounded mb-4">
            </select>

            <button class="w-full bg-[#b11d40] text-white py-2 rounded">
                Assigner
            </button>
        </form>
    </div>
</div>


<script>
function openAssignModal(dossierId, departementId) {

    const modal = document.getElementById('modal-assign');
    const select = document.getElementById('assign-user');
    const form = document.getElementById('assignForm');

    modal.classList.remove('hidden');
    form.action = '/dossiers/' + dossierId + '/assign';

    fetch('/departements/' + departementId + '/users')
        .then(res => res.json())
        .then(data => {
            select.innerHTML = '';

            data.forEach(user => {
                select.innerHTML += `
                    <option value="${user.id}">
                        ${user.firstName + " "+user.lastName}
                    </option>`;
            });
        });
}
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
<?php endif; ?><?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/dossiers/index.blade.php ENDPATH**/ ?>