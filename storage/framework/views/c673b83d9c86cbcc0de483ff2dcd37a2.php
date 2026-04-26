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
                <h1 class="text-2xl font-extrabold text-slate-800">Gestion des Clients</h1>
                <p class="text-slate-500 text-sm">Liste de tous vos clients actifs.</p>
            </div>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client.create')): ?>
            <button onclick="document.getElementById('modal-create').classList.remove('hidden')"
                    class="flex items-center gap-2 px-4 py-2 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouveau Client
            </button>
            <?php endif; ?>
        </div>

        
        <?php if(session('msg')): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm font-semibold">
            <?php echo e(session('msg')); ?>

        </div>
        <?php endif; ?>

        
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

            <table class="w-full text-sm table-fixed">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50">
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[18%]">Client</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[16%]">Contact</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[9%]">Type</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[9%]">Statut</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[13%]">Département</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[20%]">Assigné à</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[10%]">Naissance</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[5%]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php $__empty_1 = true; $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50 transition-colors">

                        
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-xl bg-[#b11d40]/10 flex items-center justify-center flex-shrink-0">
                                    <span class="text-[#b11d40] font-black text-xs">
                                        <?php echo e(strtoupper(substr($client->firstName, 0, 1))); ?><?php echo e(strtoupper(substr($client->lastName, 0, 1))); ?>

                                    </span>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-800 text-xs truncate"><?php echo e($client->firstName); ?> <?php echo e($client->lastName); ?></p>
                                    <p class="text-slate-400 text-xs truncate"><?php echo e($client->CNE ?? '—'); ?></p>
                                </div>
                            </div>
                        </td>

                        
                        <td class="px-4 py-4">
                            <p class="text-slate-700 text-xs truncate"><?php echo e($client->email); ?></p>
                            <p class="text-slate-400 text-xs"><?php echo e($client->phoneNumber); ?></p>
                        </td>

                        
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 rounded-lg text-xs font-black bg-[#b11d40]/10 text-[#b11d40] uppercase">
                                <?php echo e($client->type ?? '—'); ?>

                            </span>
                        </td>

                        
                        <td class="px-4 py-4">
                            <?php if($client->status === 'actif'): ?>
                                <span class="px-2 py-1 rounded-lg text-xs font-black bg-green-100 text-green-600">Actif</span>
                            <?php else: ?>
                                <span class="px-2 py-1 rounded-lg text-xs font-black bg-red-100 text-red-500">Inactif</span>
                            <?php endif; ?>
                        </td>

                        
                        <td class="px-4 py-4 text-xs text-slate-600 truncate">
                            <?php echo e($client->departement->title ?? '—'); ?>

                        </td>

                        
                        <td class="px-4 py-4">
                            <?php if($client->assignedUser): ?>
                                <div class="flex items-center gap-1.5">
                                    <div class="w-5 h-5 rounded-md bg-blue-100 flex items-center justify-center flex-shrink-0">
                                        <span class="text-blue-600 font-black text-[9px]">
                                            <?php echo e(strtoupper(substr($client->assignedUser->firstName, 0, 1))); ?>

                                        </span>
                                    </div>
                                    <span class="text-xs text-slate-700 font-semibold truncate">
                                        <?php echo e($client->assignedUser->firstName); ?> <?php echo e($client->assignedUser->lastName); ?>

                                    </span>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client.edit')): ?>
                                    <button onclick="toggleAssignPanel(<?php echo e($client->idClient); ?>)"
                                            class="ml-1 text-slate-300 hover:text-[#b11d40] transition-colors"
                                            title="Changer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client.edit')): ?>
                                <button onclick="toggleAssignPanel(<?php echo e($client->idClient); ?>)"
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs font-bold text-[#b11d40] bg-[#b11d40]/10 hover:bg-[#b11d40]/20 transition-all border border-[#b11d40]/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Assigner
                                </button>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('client.edit')): ?>
                                <span class="text-xs text-slate-400">—</span>
                                <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client.edit')): ?>
                            <div id="assign-panel-<?php echo e($client->idClient); ?>"
                                class="hidden mt-2 p-3 bg-slate-50 border border-slate-200 rounded-xl shadow-sm space-y-2">

                                <form method="POST" action="<?php echo e(route('clients.assign', $client->idClient)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>

                                    <?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                                    
                                    <select name="idDepartement"
                                            class="w-full px-2 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-slate-700 focus:outline-none focus:border-[#b11d40]">
                                        <option value="">— Département —</option>
                                        <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($dep->idDepartement); ?>"
                                                <?php echo e($client->idDepartement == $dep->idDepartement ? 'selected' : ''); ?>>
                                                <?php echo e($dep->title); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php endif; ?>

                                    <?php if (\Illuminate\Support\Facades\Blade::check('role', 'manager')): ?>
                                    
                                    <select name="idUser"
                                            class="w-full px-2 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-slate-700 focus:outline-none focus:border-[#b11d40]">
                                        <option value="">— Employé —</option>
                                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($emp->idUser); ?>"
                                                <?php echo e($client->idUser == $emp->idUser ? 'selected' : ''); ?>>
                                                <?php echo e($emp->firstName); ?> <?php echo e($emp->lastName); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php endif; ?>

                                    <div class="flex gap-2 pt-1">
                                        <button type="submit"
                                                class="flex-1 py-1.5 bg-[#b11d40] text-white text-xs font-bold rounded-lg hover:bg-[#7c1233] transition-all">
                                            Confirmer
                                        </button>
                                        <button type="button"
                                                onclick="toggleAssignPanel(<?php echo e($client->idClient); ?>)"
                                                class="flex-1 py-1.5 bg-white border border-slate-200 text-slate-600 text-xs font-bold rounded-lg hover:bg-slate-50 transition-all">
                                            Annuler
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <?php endif; ?>
                        </td>

                        
                        <td class="px-4 py-4 text-slate-500 text-xs">
                            <?php echo e($client->dateNaissance ? \Carbon\Carbon::parse($client->dateNaissance)->format('d/m/Y') : '—'); ?>

                        </td>

                        
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client.view')): ?>
                                <a href="<?php echo e(route('clients.show', $client->idClient)); ?>"
                                   class="p-1.5 rounded-lg text-slate-400 hover:text-[#b11d40] hover:bg-[#b11d40]/10 transition-all" title="Voir">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client.edit')): ?>
                                <a href="<?php echo e(route('clients.edit', $client->idClient)); ?>"
                                   class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all" title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client.delete')): ?>
                                <form method="POST" action="<?php echo e(route('clients.destroy', $client->idClient)); ?>"
                                      onsubmit="return confirm('Supprimer ce client?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                            class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all" title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>

                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="font-bold text-slate-500">Aucun client trouvé</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client.create')): ?>
    <div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-extrabold text-slate-800">Nouveau Client</h2>
                    <button onclick="document.getElementById('modal-create').classList.add('hidden')"
                            class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="<?php echo e(route('clients.store')); ?>">
                    <?php echo csrf_field(); ?>

                    <?php if($errors->any()): ?>
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl text-xs font-bold">
                        <ul class="list-disc pl-4 space-y-1">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Prénom *</label>
                            <input name="firstName" required value="<?php echo e(old('firstName')); ?>" placeholder="Prénom"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nom *</label>
                            <input name="lastName" required value="<?php echo e(old('lastName')); ?>" placeholder="Nom"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Email *</label>
                            <input name="email" type="email" required value="<?php echo e(old('email')); ?>" placeholder="email@exemple.com"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Mot de passe *</label>
                            <input name="password" type="password" required placeholder="Min. 8 caractères"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">CNE *</label>
                            <input name="CNE" required value="<?php echo e(old('CNE')); ?>" placeholder="CNE"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Date de naissance *</label>
                            <input name="dateNaissance" type="date" required value="<?php echo e(old('dateNaissance')); ?>"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Téléphone *</label>
                            <input name="phoneNumber" required value="<?php echo e(old('phoneNumber')); ?>" placeholder="+212..."
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nationalité</label>
                            <input name="nationalite" value="<?php echo e(old('nationalite')); ?>" placeholder="Nationalité"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Type</label>
                            <input name="type" value="<?php echo e(old('type')); ?>" placeholder="Type de client"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Statut</label>
                            <select name="status"
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                                <option value="actif" <?php echo e(old('status') == 'actif' ? 'selected' : ''); ?>>Actif</option>
                                <option value="inactif" <?php echo e(old('status') == 'inactif' ? 'selected' : ''); ?>>Inactif</option>
                            </select>
                        </div>

                        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Département</label>
                            <select name="idDepartement" id="modal-select-dep"
                                    onchange="loadModalEmployees(this.value)"
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                                <option value="">-- Sélectionner --</option>
                                <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($dep->idDepartement); ?>" <?php echo e(old('idDepartement') == $dep->idDepartement ? 'selected' : ''); ?>>
                                        <?php echo e($dep->title); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Assigner à</label>
                            <select name="idUser" id="modal-select-emp"
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                                <option value="">-- Choisir un département d'abord --</option>
                            </select>
                        </div>
                        <?php endif; ?>

                        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'manager')): ?>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Assigner à</label>
                            <select name="idUser"
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                                <option value="">-- Aucun --</option>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($emp->idUser); ?>"><?php echo e($emp->firstName); ?> <?php echo e($emp->lastName); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <?php endif; ?>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Lead associé</label>
                            <select name="idLead"
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                                <option value="">-- Sélectionner un Lead --</option>
                                <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($lead->id); ?>"><?php echo e($lead->firstName); ?> <?php echo e($lead->lastName); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Adresse</label>
                            <input name="address" value="<?php echo e(old('address')); ?>" placeholder="Adresse complète"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Note</label>
                            <textarea name="note" rows="2" placeholder="Notes complémentaires..."
                                      class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] resize-none"><?php echo e(old('note')); ?></textarea>
                        </div>

                    </div>

                    <div class="flex gap-3 justify-end mt-6">
                        <button type="button" onclick="document.getElementById('modal-create').classList.add('hidden')"
                                class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                            Annuler
                        </button>
                        <button type="submit"
                                class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">
                            Créer le Client
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script>
        function toggleAssignPanel(clientId) {
            document.querySelectorAll('[id^="assign-panel-"]').forEach(p => {
                if (p.id !== `assign-panel-${clientId}`) p.classList.add('hidden');
            });
            document.getElementById(`assign-panel-${clientId}`).classList.toggle('hidden');
        }

        async function loadModalEmployees(depId) {
            const select = document.getElementById('modal-select-emp');
            if (!depId) {
                select.innerHTML = '<option value="">-- Choisir un département d\'abord --</option>';
                return;
            }
            select.innerHTML = '<option value="">Chargement...</option>';
            try {
                const res = await fetch(`/departements/${depId}/users`);
                const users = await res.json();
                select.innerHTML = users.length === 0
                    ? '<option value="">Aucun employé</option>'
                    : '<option value="">— Aucun —</option>' + users.map(u => `<option value="${u.idUser}">${u.firstName} ${u.lastName}</option>`).join('');
            } catch {
                select.innerHTML = '<option value="">Erreur</option>';
            }
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('[id^="assign-panel-"]') && !e.target.closest('button[onclick^="toggleAssignPanel"]')) {
                document.querySelectorAll('[id^="assign-panel-"]').forEach(p => p.classList.add('hidden'));
            }
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
<?php endif; ?><?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/AllClients.blade.php ENDPATH**/ ?>