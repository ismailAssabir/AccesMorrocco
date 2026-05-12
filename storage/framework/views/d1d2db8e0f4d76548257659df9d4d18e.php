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
<div class="p-8 bg-[#F8FAFC] min-h-screen" x-data="leadsKanban()">

    
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Gestion des Leads</h1>
            <p class="text-slate-500 text-sm">Suivez et gérez tous vos prospects commerciaux.</p>
        </div>
        <div class="flex gap-3">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead.view')): ?>
            <a href="<?php echo e(route('leads.export-pdf', request()->query())); ?>"
               class="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Exporter PDF
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead.create')): ?>
            <button onclick="document.getElementById('modal-create').classList.remove('hidden')"
                    class="flex items-center gap-2 px-4 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow-md shadow-[#b11d40]/20">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Nouveau Lead
            </button>
            <?php endif; ?>
        </div>
    </div>

    
    <?php if(session('msg')): ?>
    <div class="mb-6 flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-semibold">
        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <?php echo e(session('msg')); ?>

    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="mb-6 flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm font-semibold">
        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>

    
    <form method="GET" action="<?php echo e(route('leads.index')); ?>"
          class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4 mb-6 flex flex-wrap gap-3 items-end">

        <div class="flex-1 min-w-[200px]">
            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Recherche</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                       placeholder="Nom, email, téléphone..."
                       class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
            </div>
        </div>

        <div class="min-w-[140px]">
            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Type</label>
            <select name="type" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                <option value="">Tous les types</option>
                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($type); ?>" <?php echo e(request('type') === $type ? 'selected' : ''); ?>><?php echo e($type); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm">
                Filtrer
            </button>
            <?php if(request('search') || request('type')): ?>
            <a href="<?php echo e(route('leads.index')); ?>" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                Réinitialiser
            </a>
            <?php endif; ?>
        </div>
    </form>

    
    <?php
        $columns = [
            'nouveau'    => ['label' => 'Nouveau',    'dot' => 'bg-slate-400',   'badge' => 'bg-slate-100 text-slate-500',   'border' => 'border-slate-300',  'icon' => '🌱'],
            '1er_appel'  => ['label' => '1er Appel',  'dot' => 'bg-blue-400',    'badge' => 'bg-blue-50 text-blue-600',      'border' => 'border-blue-300',   'icon' => '📞'],
            '2eme_appel' => ['label' => '2ème Appel', 'dot' => 'bg-orange-400',  'badge' => 'bg-orange-50 text-orange-600',  'border' => 'border-orange-300', 'icon' => '📲'],
            'promis'     => ['label' => 'Promis',     'dot' => 'bg-yellow-400',  'badge' => 'bg-yellow-50 text-yellow-700',  'border' => 'border-yellow-300', 'icon' => '🤝'],
            'ok'         => ['label' => 'Converti',   'dot' => 'bg-emerald-400', 'badge' => 'bg-emerald-50 text-emerald-600','border' => 'border-emerald-300','icon' => '✅'],
            'lost'       => ['label' => 'Perdu',      'dot' => 'bg-red-400',     'badge' => 'bg-red-50 text-red-600',        'border' => 'border-red-300',    'icon' => '❌'],
        ];
        $grouped = $leads->groupBy('statut');
        $avatarColors = ['bg-[#b11d40]','bg-blue-500','bg-emerald-500','bg-amber-500','bg-violet-500','bg-cyan-500'];
    ?>

<div class="flex gap-4 items-start overflow-x-auto pb-4">
        <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statut => $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $colLeads = $grouped->get($statut, collect()); ?>
        <div class="flex flex-col gap-3 min-w-0">

            
            <div class="flex items-center justify-between px-1">
                <h2 class="text-xs font-black uppercase tracking-widest text-slate-500 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full <?php echo e($col['dot']); ?> shrink-0"></span>
                    <span class="truncate"><?php echo e($col['label']); ?></span>
                </h2>
                <span class="<?php echo e($col['badge']); ?> text-[10px] font-black px-2 py-0.5 rounded-full shrink-0">
                    <?php echo e($colLeads->count()); ?>

                </span>
            </div>

            
            <div class="flex flex-col gap-3 min-h-[200px]"
                 x-data="{ page: 1, perPage: 5 }">

                <?php $__empty_1 = true; $__currentLoopData = $colLeads->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div x-show="<?php echo e($i); ?> >= (page-1)*perPage && <?php echo e($i); ?> < page*perPage"
                     class="relative bg-white border border-slate-200 rounded-2xl p-4 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 group cursor-default">

                    
                    <div class="absolute left-0 top-4 bottom-4 w-1 <?php echo e($col['border']); ?> border-l-2 rounded-r-full"></div>

                    
                    <div class="flex items-start justify-between gap-2 mb-3 pl-2">
                        <div class="flex items-center gap-2 min-w-0">
                            <div class="w-8 h-8 rounded-xl <?php echo e($avatarColors[$i % count($avatarColors)]); ?> flex items-center justify-center shrink-0 shadow-sm">
                                <span class="text-white font-black text-[10px]">
                                    <?php echo e(strtoupper(mb_substr($lead->firstName, 0, 1))); ?><?php echo e(strtoupper(mb_substr($lead->lastName, 0, 1))); ?>

                                </span>
                            </div>
                            <div class="min-w-0">
                                <p class="font-extrabold text-slate-800 text-xs leading-tight truncate group-hover:text-[#b11d40] transition-colors">
                                    <?php echo e($lead->firstName); ?> <?php echo e($lead->lastName); ?>

                                </p>
                                <?php if($lead->nationalite): ?>
                                <p class="text-[10px] text-slate-400 truncate"><?php echo e($lead->nationalite); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity shrink-0">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead.view')): ?>
                            <a href="<?php echo e(route('leads.show', $lead->idLead)); ?>"
                               class="w-6 h-6 rounded-lg flex items-center justify-center text-slate-400 hover:text-[#b11d40] hover:bg-[#b11d40]/10 transition-all"
                               title="Voir">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead.delete')): ?>
                            <button onclick="confirmDelete('<?php echo e(route('leads.destroy', $lead->idLead)); ?>', 'lead')"
                                    class="w-6 h-6 rounded-lg flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all"
                                    title="Supprimer">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="pl-2 space-y-1 mb-3">
                        <?php if($lead->phoneNumber): ?>
                        <div class="flex items-center gap-1.5 text-[10px] text-slate-500">
                            <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span class="truncate font-medium"><?php echo e($lead->phoneNumber); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if($lead->type): ?>
                        <div class="flex items-center gap-1.5">
                            <span class="text-[9px] font-black bg-[#b11d40]/10 text-[#b11d40] px-2 py-0.5 rounded-lg uppercase">
                                <?php echo e(\Illuminate\Support\Str::limit($lead->type, 10)); ?>

                            </span>
                            <?php if($lead->source): ?>
                            <span class="text-[9px] text-slate-400 font-medium truncate"><?php echo e($lead->source); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <?php if($lead->departements): ?>
                        <div class="flex items-center gap-1 text-[10px] text-blue-600 bg-blue-50 px-2 py-0.5 rounded-lg w-fit font-bold">
                            <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span class="truncate"><?php echo e($lead->departements->title); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="pl-2 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[9px] text-slate-400 font-medium">
                            <?php echo e($lead->dateCreation ? \Carbon\Carbon::parse($lead->dateCreation)->format('d/m/Y') : '—'); ?>

                        </span>

                        <div class="flex gap-1">
                            
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead.edit')): ?>
                            <?php if($statut !== 'nouveau' && $statut !== 'lost' && $statut !== 'ok'): ?>
                            <?php
                                $statutKeys = array_keys($columns);
                                $currentIndex = array_search($statut, $statutKeys);
                                $prevStatut = $currentIndex > 0 ? $statutKeys[$currentIndex - 1] : null;
                            ?>
                            <?php if($prevStatut): ?>
                            <button onclick="moveLeadStatut(<?php echo e($lead->idLead); ?>, '<?php echo e($prevStatut); ?>')"
                                    class="w-6 h-6 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-slate-200 hover:text-slate-600 transition-all"
                                    title="Reculer">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if($statut !== 'ok' && $statut !== 'lost'): ?>
                            <button onclick="openStatutModal(<?php echo e($lead->idLead); ?>, '<?php echo e($statut); ?>')"
                                    class="w-6 h-6 flex items-center justify-center rounded-lg bg-[#b11d40]/5 text-[#b11d40] hover:bg-[#b11d40] hover:text-white transition-all"
                                    title="Modifier le statut">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if($statut === 'ok' && $lead->client): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.create')): ?>
                            <button onclick="openDossierModal(<?php echo e($lead->client->idClient); ?>, <?php echo e($lead->idDepartement ?? 'null'); ?>)"
                                    class="w-6 h-6 flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white transition-all"
                                    title="Créer un dossier">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                </svg>
                            </button>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="p-6 border-2 border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center text-slate-400">
                    <span class="text-2xl mb-1"><?php echo e($col['icon']); ?></span>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-center">Aucun lead</p>
                </div>
                <?php endif; ?>

                
                <?php if($colLeads->count() > 5): ?>
                <div class="flex items-center justify-center gap-2 mt-1">
                    <button @click="page > 1 ? page-- : null" :disabled="page === 1"
                            class="p-1.5 rounded-lg bg-white border border-slate-200 text-slate-400 disabled:opacity-30 hover:text-[#b11d40] transition-all">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">
                        <span x-text="page"></span>/<span><?php echo e(ceil($colLeads->count() / 5)); ?></span>
                    </span>
                    <button @click="page * perPage < <?php echo e($colLeads->count()); ?> ? page++ : null"
                            :disabled="page * perPage >= <?php echo e($colLeads->count()); ?>"
                            class="p-1.5 rounded-lg bg-white border border-slate-200 text-slate-400 disabled:opacity-30 hover:text-[#b11d40] transition-all">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

</div>


<div id="statutModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeStatutModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-extrabold text-slate-800">Modifier le statut</h3>
                    <p class="text-sm text-slate-400 mt-0.5">Mettez à jour l'avancement du lead</p>
                </div>
                <button onclick="closeStatutModal()"
                        class="w-8 h-8 rounded-xl border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-50">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="statutForm" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>

                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Statut *</label>
                    <select name="statut" id="statutSelect" onchange="handleStatutChange(this.value)"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-[#b11d40]/30 focus:border-[#b11d40]">
                        <option value="1er_appel">📞 1er Appel</option>
                        <option value="2eme_appel">📞 2ème Appel</option>
                        <option value="promis">🤝 Promis</option>
                        <option value="lost">❌ Perdu</option>
                        <option value="ok">✅ Converti en client</option>
                    </select>
                </div>

                <div id="appelFields" class="space-y-4 hidden">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Durée de l'appel</label>
                        <input type="time" name="duree" step="1"
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-[#b11d40]/30 focus:border-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Contenu de l'appel</label>
                        <textarea name="contentAppel" rows="3"
                                  class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-[#b11d40]/30 focus:border-[#b11d40] resize-none"
                                  placeholder="Résumé de l'appel..."></textarea>
                    </div>
                </div>

                <div id="deptField" class="hidden">
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Département</label>
                    <select name="idDepartement"
                            class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-[#b11d40]/30 focus:border-[#b11d40]">
                        <option value="">— Sélectionner —</option>
                        <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($dept->idDepartement); ?>"><?php echo e($dept->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Note</label>
                    <textarea name="note" rows="2"
                              class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-[#b11d40]/30 focus:border-[#b11d40] resize-none"
                              placeholder="Ajouter une note..."></textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeStatutModal()"
                            class="flex-1 px-4 py-3 rounded-2xl border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 transition-all">
                        Annuler
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-3 rounded-2xl bg-[#b11d40] hover:bg-[#911633] text-white font-bold text-sm transition-all shadow-md shadow-[#b11d40]/20 active:scale-95">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead.create')): ?>
<div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233] shrink-0"></div>
        <div class="p-6 pb-0 flex justify-between items-center shrink-0">
            <h2 class="text-lg font-extrabold text-slate-800">Nouveau Lead</h2>
            <button onclick="document.getElementById('modal-create').classList.add('hidden')"
                    class="w-8 h-8 rounded-xl border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-600">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="<?php echo e(route('leads.store')); ?>" class="flex flex-col overflow-hidden">
            <?php echo csrf_field(); ?>
            <div class="p-6 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Prénom *</label>
                        <input name="firstName" required placeholder="Prénom" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Nom *</label>
                        <input name="lastName" required placeholder="Nom" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Email</label>
                        <input name="email" type="email" placeholder="email@exemple.com" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Téléphone</label>
                        <input name="phoneNumber" placeholder="+212..." class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">CNE</label>
                        <input name="CNE" placeholder="CNE" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Nationalité</label>
                        <input name="nationalite" placeholder="Nationalité" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Adresse</label>
                        <input name="address" placeholder="Adresse" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Source</label>
                        <input name="source" placeholder="Ex: LinkedIn, Référence..." class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Type *</label>
                        <select name="type_select" required
                                onchange="document.getElementById('other-type-wrapper').classList.toggle('hidden', this.value !== 'autre')"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                            <option value="" disabled selected>Sélectionner un type</option>
                            <option value="particulier">Particulier</option>
                            <option value="famille">Famille</option>
                            <option value="entreprise">Entreprise</option>
                            <option value="groupe">Groupe</option>
                            <option value="autre">Autre</option>
                        </select>
                        <div id="other-type-wrapper" class="hidden mt-2">
                            <input name="type" placeholder="Précisez le type..." class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Note</label>
                        <textarea name="note" rows="2" placeholder="Notes complémentaires..." class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] resize-none"></textarea>
                    </div>
                </div>
            </div>
            <div class="p-6 border-t border-slate-100 flex gap-3 justify-end bg-slate-50 shrink-0">
                <button type="button" onclick="document.getElementById('modal-create').classList.add('hidden')"
                        class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                    Annuler
                </button>
                <button type="submit"
                        class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow-md shadow-[#b11d40]/20">
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
                    class="w-8 h-8 rounded-xl border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-600">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="<?php echo e(route('dossiers.store')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="idClient" id="dossier-idClient">
            <div class="px-6 pb-4 space-y-4">
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Département *</label>
                    <select name="idDepartement" id="dossier-idDepartement" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                        <option value="">— Choisir un département —</option>
                        <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($dept->idDepartement); ?>"><?php echo e($dept->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Destination</label>
                    <input name="distination" placeholder="Ex: Paris, Dubai..." class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Nb. personnes *</label>
                        <input name="nombrePersonnes" type="number" min="1" value="1" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Nb. jours *</label>
                        <input name="nombreJours" type="number" min="0" value="0" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Montant (MAD) *</label>
                    <input name="montant" type="number" min="0" step="0.01" value="0" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Date de voyage</label>
                    <input name="dateVoyage" type="date" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1.5">Commentaire</label>
                    <textarea name="commentaire" rows="2" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40] resize-none"></textarea>
                </div>
            </div>
            <div class="px-6 pb-6 flex gap-3 justify-end border-t border-slate-100 pt-4 bg-slate-50">
                <button type="button" onclick="document.getElementById('modal-dossier').classList.add('hidden')"
                        class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm">Annuler</button>
                <button type="submit"
                        class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl text-sm shadow-md shadow-[#b11d40]/20">Créer le Dossier</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<script>
// ===== STATUT MODAL =====
function openStatutModal(leadId, currentStatut) {
    const modal  = document.getElementById('statutModal');
    const form   = document.getElementById('statutForm');
    const select = document.getElementById('statutSelect');
    form.action  = `/leads/${leadId}/statut`;
    select.value = currentStatut;
    handleStatutChange(currentStatut);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeStatutModal() {
    document.getElementById('statutModal').classList.add('hidden');
    document.getElementById('statutModal').classList.remove('flex');
}

function handleStatutChange(value) {
    document.getElementById('appelFields').classList.toggle('hidden', !['1er_appel', '2eme_appel'].includes(value));
    document.getElementById('deptField').classList.toggle('hidden', value !== 'ok');
}

// ===== MOVE LEAD (quick status change without modal) =====
function moveLeadStatut(leadId, newStatut) {
    if (!confirm(`Déplacer ce lead vers "${newStatut}" ?`)) return;

    fetch(`/leads/${leadId}/statut`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-HTTP-Method-Override': 'PATCH',
        },
        body: JSON.stringify({ statut: newStatut })
    }).then(r => {
        if (r.ok || r.redirected) window.location.reload();
    });
}

// ===== DOSSIER MODAL =====
function openDossierModal(clientId, deptId) {
    document.getElementById('dossier-idClient').value = clientId;
    document.getElementById('dossier-idDepartement').value = deptId ?? '';
    document.getElementById('modal-dossier').classList.remove('hidden');
}

// ===== DELETE =====
function confirmDelete(url, type) {
    if (!confirm(`Supprimer ce ${type} ?`)) return;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = url;
    form.innerHTML = `<?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>`;
    // inject real tokens
    const csrf = document.createElement('input');
    csrf.type = 'hidden'; csrf.name = '_token';
    csrf.value = document.querySelector('meta[name="csrf-token"]').content;
    const method = document.createElement('input');
    method.type = 'hidden'; method.name = '_method'; method.value = 'DELETE';
    form.appendChild(csrf); form.appendChild(method);
    document.body.appendChild(form);
    form.submit();
}

// ESC
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeStatutModal();
        document.getElementById('modal-create').classList.add('hidden');
        document.getElementById('modal-dossier').classList.add('hidden');
    }
});

function leadsKanban() { return {}; }
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
<?php endif; ?><?php /**PATH C:\Users\dell\Desktop\PROJECTS\AccesMorrocco\resources\views/leads/index.blade.php ENDPATH**/ ?>