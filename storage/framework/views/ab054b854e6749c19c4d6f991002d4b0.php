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

        <div class="flex gap-3">
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.view')): ?>
    <a href="<?php echo e(route('dossiers.export-pdf', request()->query())); ?>"
        class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
        </svg>
        Exporter PDF
    </a>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.create')): ?>
    <button onclick="document.getElementById('modal-create').classList.remove('hidden')"
        class="flex items-center gap-2 px-4 py-2 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">
        ➕ Nouveau Dossier
    </button>
    <?php endif; ?>
</div>
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
                    <?php echo e($dept->title); ?>

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
                        <?php if(!$dossier->idDepartement && auth()->user()->hasRole('admin')): ?>
                            <button onclick="openDeptModal(<?php echo e($dossier->idDossier); ?>)"
                                class="px-2 py-1 rounded-lg text-xs font-bold bg-amber-100 text-amber-700 hover:bg-amber-200 transition">
                                ⚠ Non assigné
                            </button>
                        <?php else: ?>
                            <?php echo e($dossier->departement->title ?? '-'); ?>

                        <?php endif; ?>
                    </td>

                    <td class="px-4 py-4 text-green-600 font-bold">
                        <?php echo e($dossier->idUser? $dossier->user->firstName." ".$dossier->user->lastName : 'Non assigné'); ?>

                    </td>

                    <td class="px-4 py-4">
                    <?php
                        $statusColors = [
                            'ouvert' => 'bg-blue-100 text-blue-700',
                            'en_cours' => 'bg-amber-100 text-amber-700',
                            'ferme' => 'bg-green-100 text-green-700'
                        ];
                        $statusLabels = [
                            'ouvert' => '📋 Ouvert',
                            'en_cours' => '⚙️ En cours',
                            'ferme' => '✅ Fermé'
                        ];
                        $canEditStatus = (
                            $dossier->idUser == auth()->user()->idUser 
                            && auth()->user()->hasRole('employee')
                            && $dossier->status !== 'ferme' // 🔥 IMPORTANT
                        );                    
                        ?>
                    
                    <?php if($canEditStatus): ?>
                        <select onchange="updateStatus(<?php echo e($dossier->idDossier); ?>, this.value)"
                                class="px-2 py-1 rounded-lg text-xs font-bold border-0 focus:ring-2 focus:ring-[#b11d40] cursor-pointer <?php echo e($statusColors[$dossier->status] ?? 'bg-slate-100'); ?>">
                            <option value="ouvert" <?php echo e($dossier->status == 'ouvert' ? 'selected' : ''); ?>>📋 Ouvert</option>
                            <option value="en_cours" <?php echo e($dossier->status == 'en_cours' ? 'selected' : ''); ?>>⚙️ En cours</option>
                            <option value="ferme" <?php echo e($dossier->status == 'ferme' ? 'selected' : ''); ?>>✅ Fermé</option>
                        </select>
                    <?php else: ?>
                        <span class="px-2 py-1 rounded-lg text-xs font-bold <?php echo e($statusColors[$dossier->status] ?? 'bg-slate-100'); ?>">
                            <?php echo e($statusLabels[$dossier->status] ?? $dossier->status); ?>

                        </span>
                    <?php endif; ?>
                <td class="px-4 py-4">
                    <div class="flex items-center gap-2">

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.view')): ?>
                        <a href="<?php echo e(route('dossiers.show',$dossier->idDossier)); ?>"
                        class="p-2 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-200 shadow-sm hover:shadow-md"
                        title="Voir">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5
                                    c4.478 0 8.268 2.943 9.542 7
                                    -1.274 4.057-5.064 7-9.542 7
                                    -4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.edit')): ?>
                        <a href="<?php echo e(route('dossiers.edit',$dossier->idDossier)); ?>"
                        class="p-2 rounded-xl bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-all duration-200 shadow-sm hover:shadow-md"
                        title="Modifier">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5h2m-1-1v2m4.293 1.293l1.414 1.414
                                    a1 1 0 010 1.414l-9.9 9.9
                                    a2 2 0 01-.878.514l-3.182.795
                                    .795-3.182a2 2 0 01.514-.878l9.9-9.9
                                    a1 1 0 011.414 0z" />
                            </svg>
                        </a>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.delete')): ?>
                        <form method="POST" action="<?php echo e(route('dossiers.destroy',$dossier->idDossier)); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>

                            <button type="submit"
                                onclick="return confirm('Voulez-vous supprimer ce dossier ?')"
                                class="p-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all duration-200 shadow-sm hover:shadow-md"
                                title="Supprimer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                        a2 2 0 01-1.995-1.858L5 7m5-4h4
                                        m-4 0a2 2 0 00-2 2v1h8V5a2 2 0 00-2-2
                                        m-4 0h4" />
                                </svg>
                            </button>
                        </form>
                        <?php endif; ?>

                        
                        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'manager')): ?>
                        <?php if(auth()->user()->idDepartement == $dossier->idDepartement): ?>
                        <button onclick="openAssignModal(<?php echo e($dossier->idDossier); ?>, <?php echo e($dossier->idDepartement); ?>)"
                            class="p-2 rounded-xl bg-green-50 text-green-600 hover:bg-green-600 hover:text-white transition-all duration-200 shadow-sm hover:shadow-md"
                            title="Assigner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a4 4 0 00-3-3.87
                                    M9 20H4v-2a4 4 0 013-3.87
                                    m13-3a4 4 0 10-8 0
                                    4 4 0 008 0z" />
                            </svg>
                        </button>
                        <?php endif; ?>
                        <?php endif; ?>

                    </div>
                </td>
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



<div id="modal-assign" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md max-h-[90vh] flex flex-col overflow-hidden">

        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

        <div class="p-6 border-b border-slate-100 flex justify-between items-center shrink-0">
            <h2 class="font-extrabold text-slate-800">Assigner un employé</h2>
            <button onclick="document.getElementById('modal-assign').classList.add('hidden')"
                class="text-slate-400 hover:text-slate-600">✕</button>
        </div>

        <div class="px-6 py-4 overflow-y-auto flex-1 space-y-3">

            
            <div id="assign-loading" class="hidden text-center text-slate-400 text-sm py-4">
                Chargement...
            </div>

            
            <div id="assign-list" class="space-y-2"></div>

        </div>

        <form method="POST" id="assignForm" class="px-6 pb-6 pt-4 border-t border-slate-100 bg-slate-50 shrink-0">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Sélectionner</label>
            <select name="idUser" id="assign-user"
                class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm mb-4">
            </select>

            <button class="w-full bg-[#b11d40] text-white py-2.5 rounded-xl font-bold text-sm hover:bg-[#7c1233] transition">
                Assigner
            </button>
        </form>
    </div>
</div>

<div id="modal-dept" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-2xl w-full max-w-md shadow-xl">
        <h2 class="font-bold mb-1 text-slate-800">Assigner un Département</h2>
        <p class="text-xs text-slate-400 mb-4">Ce dossier n'est assigné à aucun département.</p>

        <form method="POST" id="deptForm">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <select name="idDepartement" id="dept-select"
                class="w-full px-3 py-2 border border-slate-200 rounded-xl mb-4 text-sm">
                <option value="">Choisir un département...</option>
                <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($dept->idDepartement); ?>"><?php echo e($dept->title); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <div class="flex gap-2">
                <button type="submit"
                    class="flex-1 bg-[#b11d40] text-white py-2 rounded-xl font-bold text-sm hover:bg-[#7c1233] transition">
                    Assigner
                </button>
                <button type="button" onclick="document.getElementById('modal-dept').classList.add('hidden')"
                    class="flex-1 bg-slate-100 text-slate-600 py-2 rounded-xl font-bold text-sm hover:bg-slate-200 transition">
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.create')): ?>
<div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg max-h-[90vh] flex flex-col">

        
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233] rounded-t-3xl shrink-0"></div>
        <div class="p-6 flex justify-between items-center border-b border-slate-100 shrink-0">
            <h2 class="text-lg font-extrabold text-slate-800">Nouveau Dossier</h2>
            <button onclick="document.getElementById('modal-create').classList.add('hidden')"
                    class="text-slate-400 hover:text-slate-600">✕</button>
        </div>

        <form method="POST" action="<?php echo e(route('dossiers.store')); ?>" class="flex flex-col flex-1 overflow-hidden">
            <?php echo csrf_field(); ?>

            
            <div class="px-6 py-4 space-y-4 overflow-y-auto flex-1">

                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Client *</label>
                    <select name="idClient" required
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        <option value="">— Choisir un client —</option>
                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($client->idClient); ?>"><?php echo e($client->firstName); ?> <?php echo e($client->lastName); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Département </label>
                    <select name="idDepartement" 
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        <option value="">— Choisir un département —</option>
                        <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($dept->idDepartement); ?>"><?php echo e($dept->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Destination</label>
                    <input name="distination" placeholder="Ex: Paris, Dubai..."
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nombre de personnes *</label>
                        <input name="nombrePersonnes" type="number" min="1" value="1" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nombre de jours *</label>
                        <input name="nombreJours" type="number" min="0" value="0" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Montant *</label>
                    <input name="montant" type="number" min="0" step="0.01" value="0" required
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Date de voyage</label>
                    <input name="dateVoyage" type="date"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Commentaire</label>
                    <textarea name="commentaire" rows="3"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] resize-none"></textarea>
                </div>

            </div>

            
            <div class="px-6 py-4 flex gap-3 justify-end border-t border-slate-100 bg-slate-50 shrink-0">
                <button type="button"
                    onclick="document.getElementById('modal-create').classList.add('hidden')"
                    class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm">
                    Annuler
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl text-sm shadow">
                    Créer le Dossier
                </button>
            </div>

        </form>
    </div>
</div>
<?php endif; ?>

<div id="modal-confirm-status" class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
        <div class="p-6">
            <div class="flex items-center gap-4 mb-4">
                <div id="confirm-icon" class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl flex-shrink-0"></div>
                <div>
                    <h3 class="font-extrabold text-slate-800 text-base">Confirmer le changement</h3>
                    <p id="confirm-message" class="text-slate-500 text-sm mt-0.5"></p>
                </div>
            </div>
            <div id="confirm-status-preview" class="mb-5 p-3 rounded-xl border text-center text-sm font-bold"></div>
            <div class="flex gap-3">
                <button onclick="cancelStatusChange()"
                    class="flex-1 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm hover:bg-slate-50 transition">
                    Annuler
                </button>
                <button onclick="confirmStatusChange()"
                    class="flex-1 px-4 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl text-sm hover:bg-[#7c1233] transition shadow">
                    Confirmer
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let pendingStatusChange = null;

    function openDeptModal(dossierId) {
        const modal = document.getElementById('modal-dept');
        const form = document.getElementById('deptForm');
        form.action = '/dossiers/' + dossierId + '/assign-departement';
        modal.classList.remove('hidden');
    }

    window.addEventListener('click', function(event) {
        const deptModal = document.getElementById('modal-dept');
        if (event.target == deptModal) {
            deptModal.classList.add('hidden');
        }
    });

    function openAssignModal(dossierId, departementId) {
        const modal = document.getElementById('modal-assign');
        const select = document.getElementById('assign-user');
        const form = document.getElementById('assignForm');
        const loadingEl = document.getElementById('assign-loading');
        const listEl = document.getElementById('assign-list');

        modal.classList.remove('hidden');
        form.action = '/dossiers/' + dossierId + '/assign';

        loadingEl.classList.remove('hidden');
        listEl.innerHTML = '';
        select.innerHTML = '';

        fetch('/departements/' + departementId + '/users')
            .then(res => res.json())
            .then(data => {
                loadingEl.classList.add('hidden');
                select.innerHTML = '<option value="">Choisir un employé...</option>';
                data.sort((a, b) => a.dossiers_actifs - b.dossiers_actifs);

                data.forEach(user => {
                    const actifs = user.dossiers_actifs ?? 0;
                    const fermes = user.dossiers_fermes ?? 0;
                    const maxDossiers = 5;
                    const isFull = actifs >= maxDossiers;
                    const chargePercent = Math.min((actifs / maxDossiers) * 100, 100);

                    let chargeColor = '#16a34a';
                    if (actifs >= 5) chargeColor = '#dc2626';
                    else if (actifs >= 3) chargeColor = '#f59e0b';
                    else if (actifs >= 2) chargeColor = '#3b82f6';

                    const opt = document.createElement('option');
                    opt.value = user.idUser;
                    opt.textContent = `${user.firstName} ${user.lastName} - ${actifs}/5 actifs, ${fermes} fermés`;
                    if (isFull) {
                        opt.disabled = true;
                        opt.textContent += ' (complet)';
                    }
                    select.appendChild(opt);

                    listEl.innerHTML += `
                        <div class="p-3 rounded-xl border ${isFull ? 'bg-red-50 border-red-200 opacity-60' : 'bg-slate-50 border-slate-200'}">
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">${user.firstName} ${user.lastName}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">📋 ${actifs} actif(s) | ✅ ${fermes} fermé(s)</p>
                                </div>
                                ${isFull
                                    ? '<span class="text-xs font-bold text-red-500 bg-red-100 px-2 py-1 rounded-lg">🔴 COMPLET (5/5)</span>'
                                    : '<span class="text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded-lg">🟢 Disponible</span>'
                                }
                            </div>
                            <div class="mb-1">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-slate-600">Charge de travail</span>
                                    <span class="font-bold" style="color: ${chargeColor};">${actifs}/${maxDossiers}</span>
                                </div>
                                <div class="bg-slate-200 rounded-full h-2.5 overflow-hidden">
                                    <div class="h-2.5 rounded-full transition-all duration-300"
                                        style="width: ${chargePercent}%; background: ${chargeColor};"></div>
                                </div>
                            </div>
                            ${actifs === 4 ? `<div class="mt-2 text-xs text-orange-600 bg-orange-50 p-1.5 rounded-lg">⚠️ Capacité proche du maximum (4/5 dossiers)</div>` : ''}
                            ${isFull ? `<div class="mt-2 text-xs text-red-600 bg-red-50 p-1.5 rounded-lg">🚫 Impossible d'assigner un nouveau dossier</div>` : ''}
                        </div>
                    `;
                });

                const availableUsers = data.filter(u => (u.dossiers_actifs ?? 0) < 5);
                if (availableUsers.length === 0) {
                    listEl.innerHTML += `
                        <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl text-center">
                            <p class="text-amber-700 font-medium">⚠️ Aucun employé disponible</p>
                            <p class="text-amber-600 text-sm mt-1">Tous les employés ont atteint leur capacité maximale (5 dossiers actifs)</p>
                        </div>
                    `;
                }
            })
            .catch(err => {
                loadingEl.classList.add('hidden');
                listEl.innerHTML = '<div class="text-center text-red-500 text-sm py-4">❌ Erreur de chargement</div>';
                console.error(err);
            });
    }

    // ===== STATUS =====

    function updateStatus(dossierId, newStatus) {
        const select = event.target;
        const oldValue = select.getAttribute('data-old') || select.value;
        select.setAttribute('data-old', oldValue);

        const labels = {
            'ouvert':   { label: '📋 Ouvert',   bg: '#eff6ff', color: '#1d4ed8', icon: '📋', iconBg: '#dbeafe' },
            'en_cours': { label: '⚙️ En cours', bg: '#fffbeb', color: '#b45309', icon: '⚙️', iconBg: '#fef3c7' },
            'ferme':    { label: '✅ Fermé',    bg: '#f0fdf4', color: '#15803d', icon: '✅', iconBg: '#dcfce7' },
        };

        const info = labels[newStatus] || { label: newStatus, bg: '#f8fafc', color: '#475569', icon: '🔄', iconBg: '#f1f5f9' };

        document.getElementById('confirm-icon').textContent = info.icon;
        document.getElementById('confirm-icon').style.background = info.iconBg;
        document.getElementById('confirm-message').textContent = `Voulez-vous changer le statut vers :`;

        const preview = document.getElementById('confirm-status-preview');
        preview.textContent = info.label;
        preview.style.background = info.bg;
        preview.style.color = info.color;
        preview.style.borderColor = info.color + '33';

        pendingStatusChange = { dossierId, newStatus, oldValue, select };
        document.getElementById('modal-confirm-status').classList.remove('hidden');
    }

    function cancelStatusChange() {
        if (pendingStatusChange) {
            pendingStatusChange.select.value = pendingStatusChange.oldValue;
        }
        pendingStatusChange = null;
        document.getElementById('modal-confirm-status').classList.add('hidden');
    }

    function confirmStatusChange() {
        if (!pendingStatusChange) return;

        const { dossierId, newStatus, oldValue, select } = pendingStatusChange;
        document.getElementById('modal-confirm-status').classList.add('hidden');
        pendingStatusChange = null;

        select.disabled = true;

        fetch(`/dossiers/${dossierId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '<?php echo e(csrf_token()); ?>',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showFlashMessage(data.message || 'Statut mis à jour avec succès !', 'success');
                updateSelectColor(select, newStatus);
                select.setAttribute('data-old', newStatus);
            } else {
                showFlashMessage(data.message || 'Erreur lors de la mise à jour', 'error');
                select.value = oldValue;
            }
            select.disabled = false;
        })
        .catch(error => {
            console.error('Error:', error);
            showFlashMessage('Erreur lors de la mise à jour du statut', 'error');
            select.value = oldValue;
            select.disabled = false;
        });
    }

    function updateSelectColor(select, status) {
        select.classList.remove('bg-blue-100', 'text-blue-700', 'bg-amber-100', 'text-amber-700', 'bg-green-100', 'text-green-700');
        if (status === 'ouvert') select.classList.add('bg-blue-100', 'text-blue-700');
        else if (status === 'en_cours') select.classList.add('bg-amber-100', 'text-amber-700');
        else if (status === 'ferme') select.classList.add('bg-green-100', 'text-green-700');
    }

    function showFlashMessage(message, type = 'success') {
        const existingFlash = document.querySelector('.custom-flash-message');
        if (existingFlash) existingFlash.remove();

        const isSuccess = type === 'success';

        const flashDiv = document.createElement('div');
        flashDiv.className = 'custom-flash-message fixed top-6 right-6 z-[9999] flex items-center gap-3 px-5 py-4 rounded-2xl shadow-xl border';
        flashDiv.style.cssText = `
            background: ${isSuccess ? '#f0fdf4' : '#fef2f2'};
            border-color: ${isSuccess ? '#bbf7d0' : '#fecaca'};
            min-width: 300px; max-width: 420px;
            transform: translateX(120%); opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
        `;

        flashDiv.innerHTML = `
            <div style="width:36px;height:36px;border-radius:10px;flex-shrink:0;display:flex;align-items:center;justify-content:center;background:${isSuccess ? '#dcfce7' : '#fee2e2'};font-size:16px;">
                ${isSuccess ? '✅' : '❌'}
            </div>
            <div style="flex:1;">
                <p style="font-weight:800;font-size:13px;color:${isSuccess ? '#15803d' : '#dc2626'};margin:0;">
                    ${isSuccess ? 'Succès' : 'Erreur'}
                </p>
                <p style="font-size:12px;color:${isSuccess ? '#16a34a' : '#ef4444'};margin:0;margin-top:2px;">
                    ${message}
                </p>
            </div>
            <button onclick="this.parentElement.remove()" style="color:${isSuccess ? '#86efac' : '#fca5a5'};background:none;border:none;cursor:pointer;font-size:16px;padding:0;">✕</button>
        `;

        document.body.appendChild(flashDiv);
        requestAnimationFrame(() => {
            flashDiv.style.transform = 'translateX(0)';
            flashDiv.style.opacity = '1';
        });

        setTimeout(() => {
            flashDiv.style.transform = 'translateX(120%)';
            flashDiv.style.opacity = '0';
            setTimeout(() => flashDiv.remove(), 300);
        }, 3000);
    }

    // Fermer modal assign en cliquant dehors
    window.onclick = function(event) {
        const modal = document.getElementById('modal-assign');
        if (event.target == modal) modal.classList.add('hidden');

        const confirmModal = document.getElementById('modal-confirm-status');
        if (event.target == confirmModal) cancelStatusChange();
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
<?php endif; ?><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/dossiers/index.blade.php ENDPATH**/ ?>