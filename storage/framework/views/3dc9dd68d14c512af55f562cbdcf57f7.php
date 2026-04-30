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
                <h1 class="text-2xl font-extrabold text-slate-800">Gestion des Leads</h1>
                <p class="text-slate-500 text-sm">Suivez et gérez tous vos prospects commerciaux.</p>
            </div>
            <div class="flex gap-3">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead.view')): ?>
                <a href="<?php echo e(route('leads.export-pdf', request()->query())); ?>"
                   class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Exporter PDF
                </a>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead.create')): ?>
                <button onclick="document.getElementById('modal-create').classList.remove('hidden')"
                        class="flex items-center gap-2 px-4 py-2 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nouveau Lead
                </button>
                <?php endif; ?>
            </div>
        </div>

        
        <?php if(session('msg')): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm font-semibold">
            <?php echo e(session('msg')); ?>

        </div>
        <?php endif; ?>

        
        <form method="GET" action="<?php echo e(route('leads.index')); ?>" class="mb-6 flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                       placeholder="Rechercher par nom, email, téléphone..."
                       class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
            </div>

            <select name="type"
                    class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40]">
                <option value="">Tous les types</option>
                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($type); ?>" <?php echo e(request('type') === $type ? 'selected' : ''); ?>><?php echo e($type); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <select name="statut"
                    class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40]">
                <option value="">Tous les statuts</option>
                <option value="nouveau"    <?php echo e(request('statut') === 'nouveau'    ? 'selected' : ''); ?>>Nouveau</option>
                <option value="1er_appel"  <?php echo e(request('statut') === '1er_appel'  ? 'selected' : ''); ?>>1er Appel</option>
                <option value="2eme_appel" <?php echo e(request('statut') === '2eme_appel' ? 'selected' : ''); ?>>2ème Appel</option>
                <option value="promis"     <?php echo e(request('statut') === 'promis'     ? 'selected' : ''); ?>>Promis</option>
                <option value="ok"         <?php echo e(request('statut') === 'ok'         ? 'selected' : ''); ?>>Converti</option>
                <option value="lost"       <?php echo e(request('statut') === 'lost'       ? 'selected' : ''); ?>>Perdu</option>
            </select>

            <button type="submit"
                    class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm">
                Filtrer
            </button>

            <?php if(request('search') || request('type') || request('statut')): ?>
            <a href="<?php echo e(route('leads.index')); ?>"
               class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                Réinitialiser
            </a>
            <?php endif; ?>
        </form>

        
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[900px]">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50">
                            <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Lead</th>
                            <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Contact</th>
                            <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Type</th>
                            <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Statut</th>
                            <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Source</th>
                            <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Département</th>
                            <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Date</th>
                            <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php
                            $statutColors = [
                                'nouveau'    => 'bg-slate-100 text-slate-500',
                                '1er_appel'  => 'bg-blue-100 text-blue-600',
                                '2eme_appel' => 'bg-orange-100 text-orange-600',
                                'lost'       => 'bg-red-100 text-red-600',
                                'promis'     => 'bg-yellow-100 text-yellow-700',
                                'ok'         => 'bg-green-100 text-green-600',
                            ];
                            $statutLabels = [
                                'nouveau'    => 'Nouveau',
                                '1er_appel'  => '1er Appel',
                                '2eme_appel' => '2ème Appel',
                                'lost'       => 'Perdu',
                                'promis'     => 'Promis',
                                'ok'         => 'Converti ✓',
                            ];
                        ?>

                        <?php $__empty_1 = true; $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50 transition-colors">

                            
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-xl bg-[#b11d40]/10 flex items-center justify-center flex-shrink-0">
                                        <span class="text-[#b11d40] font-black text-xs">
                                            <?php echo e(strtoupper(substr($lead->firstName, 0, 1))); ?><?php echo e(strtoupper(substr($lead->lastName, 0, 1))); ?>

                                        </span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-bold text-slate-800 truncate text-xs"><?php echo e($lead->firstName); ?> <?php echo e($lead->lastName); ?></p>
                                        <p class="text-slate-400 text-xs truncate"><?php echo e($lead->nationalite ?? '—'); ?></p>
                                    </div>
                                </div>
                            </td>

                            
                            <td class="px-4 py-4">
                                <p class="text-slate-700 text-xs truncate"><?php echo e($lead->email ?? '—'); ?></p>
                                <p class="text-slate-400 text-xs"><?php echo e($lead->phoneNumber ?? '—'); ?></p>
                            </td>

                            
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 rounded-lg text-xs font-black bg-[#b11d40]/10 text-[#b11d40] uppercase">
                                    <?php echo e(Str::limit($lead->type, 10)); ?>

                                </span>
                            </td>

                            
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 rounded-lg text-xs font-black uppercase <?php echo e($statutColors[$lead->statut] ?? 'bg-slate-100 text-slate-500'); ?>">
                                    <?php echo e($statutLabels[$lead->statut] ?? $lead->statut); ?>

                                </span>
                            </td>

                            
                            <td class="px-4 py-4 text-slate-600 text-xs truncate"><?php echo e($lead->source ?? '—'); ?></td>

                            
                            <td class="px-4 py-4 text-slate-600 text-xs truncate"><?php echo e($lead->departements->title ?? '—'); ?></td>

                            
                            <td class="px-4 py-4 text-slate-500 text-xs">
                                <?php echo e($lead->dateCreation ? \Carbon\Carbon::parse($lead->dateCreation)->format('d/m/Y') : '—'); ?>

                            </td>

                            
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1">

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead.view')): ?>
                                <a href="<?php echo e(route('leads.show', $lead->idLead)); ?>"
                                class="p-1.5 rounded-lg text-slate-400 hover:text-[#b11d40] hover:bg-[#b11d40]/10 transition-all"
                                title="Voir">
                                    👁️
                                </a>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead.edit')): ?>
                                <a href="<?php echo e(route('leads.edit', $lead->idLead)); ?>"
                                class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all"
                                title="Modifier">
                                    ✏️
                                </a>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead.delete')): ?>
                                <button type="button"
                                        onclick="confirmDelete('<?php echo e(route('leads.destroy', $lead->idLead)); ?>', 'lead')"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all"
                                        title="Supprimer">
                                    🗑️
                                </button>
                                <?php endif; ?>

                                
                                <?php if($lead->statut === 'ok' && $lead->client): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.create')): ?>
                                <button type="button"
                                    onclick="openDossierModal(
                                        <?php echo e($lead->client->idClient); ?>,
                                        <?php echo e($lead->idDepartement ?? 'null'); ?>

                                    )"
                                    class="p-1.5 rounded-lg text-slate-400 hover:text-green-600 hover:bg-green-50 transition-all"
                                    title="Créer un dossier">

                                    📁
                                </button>
                                <?php endif; ?>
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
                                <p class="font-bold text-slate-500">Aucun lead trouvé</p>
                                <p class="text-sm mt-1">Modifiez vos critères de recherche ou ajoutez un nouveau lead.</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <?php if($leads->hasPages()): ?>
            <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
                <p class="text-xs text-slate-400 font-semibold">
                    <?php echo e($leads->firstItem()); ?>–<?php echo e($leads->lastItem()); ?> sur <?php echo e($leads->total()); ?> leads
                </p>
                <div class="flex gap-1">
                    <?php if($leads->onFirstPage()): ?>
                        <span class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-300 bg-slate-50 cursor-not-allowed">‹</span>
                    <?php else: ?>
                        <a href="<?php echo e($leads->previousPageUrl()); ?>" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 bg-white border border-slate-200 hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all">‹</a>
                    <?php endif; ?>

                    <?php $__currentLoopData = $leads->getUrlRange(1, $leads->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $leads->currentPage()): ?>
                            <span class="px-3 py-1.5 rounded-lg text-xs font-black text-white bg-[#b11d40]"><?php echo e($page); ?></span>
                        <?php else: ?>
                            <a href="<?php echo e($url); ?>" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 bg-white border border-slate-200 hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all"><?php echo e($page); ?></a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if($leads->hasMorePages()): ?>
                        <a href="<?php echo e($leads->nextPageUrl()); ?>" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 bg-white border border-slate-200 hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all">›</a>
                    <?php else: ?>
                        <span class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-300 bg-slate-50 cursor-not-allowed">›</span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead.create')): ?>
    <div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden">

            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233] shrink-0"></div>

            <div class="p-6 pb-0 flex justify-between items-center shrink-0">
                <h2 class="text-lg font-extrabold text-slate-800">Nouveau Lead</h2>
                <button onclick="document.getElementById('modal-create').classList.add('hidden')"
                        class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form method="POST" action="<?php echo e(route('leads.store')); ?>" class="flex flex-col overflow-hidden">
                <?php echo csrf_field(); ?>

                <div class="p-6 overflow-y-auto">
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
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Email</label>
                            <input name="email" type="email" placeholder="email@exemple.com"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Téléphone</label>
                            <input name="phoneNumber" placeholder="+212..."
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">CNE</label>
                            <input name="CNE" placeholder="CNE"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nationalité</label>
                            <input name="nationalite" placeholder="Nationalité"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Adresse</label>
                            <input name="address" placeholder="Adresse"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Source</label>
                            <input name="source" placeholder="Ex: LinkedIn, Référence..."
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
                        
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Note</label>
                            <textarea name="note" rows="2" placeholder="Notes complémentaires..."
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] resize-none"></textarea>
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-slate-100 flex gap-3 justify-end bg-slate-50 shrink-0">
                    <button type="button" onclick="document.getElementById('modal-create').classList.add('hidden')"
                            class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                        Annuler
                    </button>
                    <button type="submit"
                            class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">
                        Créer le Lead
                    </button>
                </div>
            </form>
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

                <div class="px-6 pb-4 space-y-4">

                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Département *</label>
                        <select name="idDepartement" id="dossier-idDepartement" required
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
                    <button type="button"
                            onclick="document.getElementById('modal-dossier').classList.add('hidden')"
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

    <script>
    function openDossierModal(clientId, deptId) {
        document.getElementById('dossier-idClient').value = clientId;

        const select = document.getElementById('dossier-idDepartement');
        select.value = deptId ?? '';

        document.getElementById('modal-dossier').classList.remove('hidden');
    }

    window.addEventListener('click', function(e) {
        const modal = document.getElementById('modal-dossier');
        if (e.target === modal) modal.classList.add('hidden');
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
<?php endif; ?><?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/leads/index.blade.php ENDPATH**/ ?>