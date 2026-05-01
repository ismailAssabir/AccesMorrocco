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
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Gestion des Clients</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Liste de tous vos clients enregistrés.</p>
            </div>
            <div class="flex items-center gap-3">
                
                <div class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-2xl shadow-sm">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-xs font-black text-slate-500 uppercase tracking-widest"><?php echo e($clients->count()); ?> Clients</span>
                </div>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client.view')): ?>
                <a href="<?php echo e(route('clients.export-pdf')); ?>"
                    class="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-[#be2346] hover:text-white hover:border-transparent transition-all text-sm shadow-sm active:scale-95">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    PDF
                </a>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client.create')): ?>
                <button onclick="document.getElementById('modal-create').classList.remove('hidden')"
                        class="flex items-center gap-2 px-5 py-2.5 bg-[#be2346] text-white font-bold rounded-xl hover:bg-[#a01d3a] transition-all text-sm shadow-md shadow-[#be2346]/20 active:scale-95">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Nouveau Client
                </button>
                <?php endif; ?>
            </div>
        </div>

        
        <?php if(session('msg')): ?>
            <div class="mb-6 flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-semibold">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <?php echo e(session('msg')); ?>

            </div>
        <?php endif; ?>

        
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4 mb-8">
            <div class="flex flex-nowrap items-center gap-3 overflow-x-auto pb-2 custom-scrollbar">
                
                <div class="flex-1 min-w-[200px] shrink-0 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="client-search" oninput="filterClients()"
                        placeholder="Rechercher par nom, email, CNE..."
                        class="block w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-2xl text-sm transition-all focus:border-[#be2346]/40 focus:ring-4 focus:ring-[#be2346]/10 outline-none">
                </div>

                
                <div class="relative shrink-0">
                    <select id="client-type" onchange="filterClients()"
                        class="appearance-none bg-white border border-slate-200 rounded-xl pl-4 pr-10 py-2 text-xs font-bold text-slate-600 outline-none transition-all focus:border-[#be2346]/40 focus:ring-4 focus:ring-[#be2346]/10 cursor-pointer">
                        <option value="">Type (Tous)</option>
                        <option value="particulier">Particulier</option>
                        <option value="famille">Famille</option>
                        <option value="entreprise">Entreprise</option>
                        <option value="groupe">Groupe</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>

                
                <div class="relative shrink-0">
                    <select id="client-status" onchange="filterClients()"
                        class="appearance-none bg-white border border-slate-200 rounded-xl pl-4 pr-10 py-2 text-xs font-bold text-slate-600 outline-none transition-all focus:border-[#be2346]/40 focus:ring-4 focus:ring-[#be2346]/10 cursor-pointer">
                        <option value="">Statut (Tous)</option>
                        <option value="actif">Actif</option>
                        <option value="inactif">Inactif</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>

                
                <div class="relative shrink-0">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <input type="text" id="client-nationalite" oninput="filterClients()"
                        placeholder="Nationalité..."
                        class="pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 outline-none transition-all focus:border-[#be2346]/40 focus:ring-4 focus:ring-[#be2346]/10 w-36">
                </div>

                
                <button type="button" onclick="resetClientFilters()" class="p-2 rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-all flex items-center justify-center shadow-sm shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
            </div>
        </div>
        <div id="client-results-info" class="hidden mb-4 px-4 py-2 bg-[#be2346]/5 border border-[#be2346]/15 rounded-2xl">
            <p class="text-xs font-bold text-[#be2346]"><span id="client-count">0</span> client(s) trouvé(s)</p>
        </div>

        
        <div class="bg-white border border-slate-200 rounded-[2rem] shadow-sm overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#be2346] to-[#7c1233]"></div>

            <table class="w-full text-sm table-fixed">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50">
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[20%]">Client</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[18%]">Contact</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[10%]">Type</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[10%]">Statut</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[12%]">Nationalité</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[12%]">Naissance</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[18%]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php $__empty_1 = true; $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="client-row hover:bg-slate-50 transition-colors"
                        data-name="<?php echo e(strtolower($client->firstName . ' ' . $client->lastName)); ?>"
                        data-email="<?php echo e(strtolower($client->email)); ?>"
                        data-cne="<?php echo e(strtolower($client->CNE ?? '')); ?>"
                        data-type="<?php echo e(strtolower($client->type ?? '')); ?>"
                        data-status="<?php echo e(strtolower($client->status ?? '')); ?>"
                        data-nationalite="<?php echo e(strtolower($client->nationalite ?? '')); ?>">

                        
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

                        
                        <td class="px-4 py-4 text-slate-600 text-xs truncate"><?php echo e($client->nationalite ?? '—'); ?></td>

                        
                        <td class="px-4 py-4 text-slate-500 text-xs">
                            <?php echo e($client->dateNaissance ? \Carbon\Carbon::parse($client->dateNaissance)->format('d/m/Y') : '—'); ?>

                        </td>

                       
                        
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-1">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client.view')): ?>
                            <a href="<?php echo e(route('clients.show', $client->idClient)); ?>"
                            class="p-1.5 rounded-lg text-slate-400 hover:text-[#b11d40] hover:bg-[#b11d40]/10 transition-all"
                            title="Voir">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client.edit')): ?>
                            <a href="<?php echo e(route('clients.edit', $client->idClient)); ?>"
                            class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all"
                            title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <?php endif; ?>

                            
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.create')): ?>
                            <button type="button"
                                    onclick="openDossierModal(<?php echo e($client->idClient); ?>, <?php echo e($client->idDepartement ?? 'null'); ?>)"
                                    class="p-1.5 rounded-lg text-slate-400 hover:text-green-600 hover:bg-green-50 transition-all"
                                    title="Créer un dossier">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2z"/>
                                </svg>
                            </button>
                            <?php endif; ?>
                            
                        </div>
                    </td>

                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center text-slate-400">
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
                            <input name="firstName" required placeholder="Prénom"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nom *</label>
                            <input name="lastName" required placeholder="Nom"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Email *</label>
                            <input name="email" type="email" required placeholder="email@exemple.com"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>


                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">CNE *</label>
                            <input name="CNE" required placeholder="CNE"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Date de naissance *</label>
                            <input name="dateNaissance" type="date" required
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Téléphone *</label>
                            <input name="phoneNumber" required placeholder="+212..."
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nationalité</label>
                            <input name="nationalite" placeholder="Nationalité"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                       <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Type *</label>
                            <select name="type_select" required
                                onchange="document.getElementById('other-type-wrapper').classList.toggle('hidden', this.value !== 'autre')"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                                <option value="" disabled selected>Sélectionner un type</option>
                                <option value="particulier">Particulier</option>
                                <option value="famille">Famille</option>
                                <option value="entreprise">Entreprise</option>
                                <option value="groupe">Groupe</option>
                                <option value="autre">Autre</option>
                            </select>

                            <div id="other-type-wrapper" class="hidden mt-2">
                                <input name="type" placeholder="Précisez le type..."
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
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
    
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.create')): ?>
<div id="modal-dossier" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
        <div class="p-6 flex justify-between items-center">
            <h2 class="text-lg font-extrabold text-slate-800">Créer un Dossier</h2>
            <button onclick="document.getElementById('modal-dossier').classList.add('hidden')"
                    class="text-slate-400 hover:text-slate-600">✕</button>
        </div>
        <form method="POST" action="<?php echo e(route('dossiers.store')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="idClient" id="dossier-idClient">
            

            <div class="px-6 pb-6 space-y-4">
                <div>
                <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Département *</label>
                <select name="idDepartement" id="dossier-idDepartement"
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
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nombre de personnes *</label>
                        <input name="nombrePersonnes" type="number" min="1" value="1" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nombre de jours *</label>
                        <input name="nombreJours" type="number" min="0" value="0" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Montant *</label>
                    <input name="montant" type="number" min="0" step="0.01" value="0" required
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Date de voyage</label>
                    <input name="dateVoyage" type="date"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Commentaire</label>
                    <textarea name="commentaire" rows="2"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm resize-none"></textarea>
                </div>
            </div>

            <div class="px-6 pb-6 flex gap-3 justify-end border-t border-slate-100 pt-4 bg-slate-50">
                <button type="button" onclick="document.getElementById('modal-dossier').classList.add('hidden')"
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

<script>
function openDossierModal(clientId, deptId) {
    document.getElementById('dossier-idClient').value = clientId;
    document.getElementById('dossier-idDepartement').value = deptId ?? '';
    document.getElementById('modal-dossier').classList.remove('hidden');
}

window.onclick = function(event) {
    const modal = document.getElementById('modal-dossier');
    if (event.target == modal) modal.classList.add('hidden');
}
</script>
<?php endif; ?>

<script>
    function filterClients() {
        const search      = document.getElementById('client-search').value.trim().toLowerCase();
        const type        = document.getElementById('client-type').value.toLowerCase();
        const status      = document.getElementById('client-status').value.toLowerCase();
        const nationalite = document.getElementById('client-nationalite').value.trim().toLowerCase();
        const hasFilter   = search || type || status || nationalite;
        let visible = 0;

        document.querySelectorAll('.client-row').forEach(row => {
            const nameMatch   = !search      || row.dataset.name.includes(search) || row.dataset.email.includes(search) || row.dataset.cne.includes(search);
            const typeMatch   = !type        || row.dataset.type === type;
            const statusMatch = !status      || row.dataset.status === status;
            const natMatch    = !nationalite || row.dataset.nationalite.includes(nationalite);
            const show = nameMatch && typeMatch && statusMatch && natMatch;
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        const info = document.getElementById('client-results-info');
        info.classList.toggle('hidden', !hasFilter);
        if (hasFilter) document.getElementById('client-count').textContent = visible;
    }

    function resetClientFilters() {
        document.getElementById('client-search').value = '';
        document.getElementById('client-type').value = '';
        document.getElementById('client-status').value = '';
        document.getElementById('client-nationalite').value = '';
        document.querySelectorAll('.client-row').forEach(r => r.style.display = '');
        document.getElementById('client-results-info').classList.add('hidden');
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
<?php endif; ?><?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/AllClients.blade.php ENDPATH**/ ?>