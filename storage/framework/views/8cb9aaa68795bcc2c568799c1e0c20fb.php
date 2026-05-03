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
<div class="p-8 min-h-screen">

    
    <div class="fixed top-5 right-5 z-50 flex flex-col gap-3 pointer-events-none">
        <?php if(session('msg')): ?>
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-4"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-4"
             class="bg-white border-l-4 border-emerald-500 text-slate-700 shadow-lg rounded-xl p-4 flex items-center gap-3 w-80 pointer-events-auto">
            <div class="bg-emerald-100 p-2 rounded-full">
                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="font-medium text-sm flex-1"><?php echo e(session('msg')); ?></p>
            <button @click="show = false" class="text-slate-400 hover:text-slate-600">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-4"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-4"
             class="bg-white border-l-4 border-red-500 text-slate-700 shadow-lg rounded-xl p-4 flex items-center gap-3 w-80 pointer-events-auto">
            <div class="bg-red-100 p-2 rounded-full">
                <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <p class="font-medium text-sm flex-1"><?php echo e(session('error')); ?></p>
            <button @click="show = false" class="text-slate-400 hover:text-slate-600">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <a href="<?php echo e(route('leads.index')); ?>"
               class="inline-flex items-center gap-2 text-slate-400 hover:text-[#b11d40] text-sm font-bold mb-3 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Retour aux leads
            </a>
            <h1 class="text-2xl font-extrabold text-slate-800"><?php echo e($lead->firstName); ?> <?php echo e($lead->lastName); ?></h1>
            <p class="text-slate-500 text-sm mt-1">Fiche prospect — détails et dossiers associés</p>
        </div>
        <div class="flex gap-3">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead.edit')): ?>
            <a href="<?php echo e(route('leads.edit', $lead->idLead)); ?>"
               class="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Modifier
            </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead.delete')): ?>
            <button onclick="confirmDelete('<?php echo e(route('leads.destroy', $lead->idLead)); ?>', 'lead')"
                    class="flex items-center gap-2 px-4 py-2.5 bg-white border border-red-200 text-red-500 font-bold rounded-xl hover:bg-red-500 hover:text-white transition-all text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Supprimer
            </button>
            <?php endif; ?>
        </div>
    </div>


    <?php
        $statutColors = [
            'nouveau'    => 'bg-slate-100 text-slate-500',
            '1er_appel'  => 'bg-blue-50 text-blue-600',
            '2eme_appel' => 'bg-orange-50 text-orange-600',
            'lost'       => 'bg-red-50 text-red-600',
            'promis'     => 'bg-yellow-50 text-yellow-700',
            'ok'         => 'bg-emerald-50 text-emerald-600',
        ];
        $statutLabels = [
            'nouveau'    => 'Nouveau',
            '1er_appel'  => '1er Appel',
            '2eme_appel' => '2ème Appel',
            'lost'       => 'Perdu',
            'promis'     => 'Promis',
            'ok'         => 'Converti',
        ];
        $dossierStatus = [
            'ouvert'   => ['label' => 'Ouvert',   'class' => 'bg-blue-50 text-blue-600'],
            'en_cours' => ['label' => 'En cours', 'class' => 'bg-amber-50 text-amber-600'],
            'ferme'    => ['label' => 'Terminé',  'class' => 'bg-emerald-50 text-emerald-600'],
        ];
    ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        
        <div class="lg:col-span-1 space-y-6">

            
            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                <div class="p-6 flex flex-col items-center text-center">

                    
                    <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-[#b11d40] to-[#7c1233] flex items-center justify-center mb-4 shadow-lg shadow-[#b11d40]/20">
                        <span class="text-white font-black text-2xl">
                            <?php echo e(strtoupper(mb_substr($lead->firstName,0,1))); ?><?php echo e(strtoupper(mb_substr($lead->lastName,0,1))); ?>

                        </span>
                    </div>

                    <h2 class="text-xl font-extrabold text-slate-800"><?php echo e($lead->firstName); ?> <?php echo e($lead->lastName); ?></h2>

                    <div class="flex flex-wrap gap-2 justify-center mt-3">
                        <span class="px-3 py-1 rounded-xl text-xs font-black bg-[#b11d40]/10 text-[#b11d40] uppercase">
                            <?php echo e($lead->type); ?>

                        </span>
                        <span class="px-3 py-1 rounded-xl text-xs font-black uppercase <?php echo e($statutColors[$lead->statut] ?? 'bg-slate-100 text-slate-500'); ?>">
                            <?php echo e($statutLabels[$lead->statut] ?? $lead->statut); ?>

                        </span>
                    </div>

                    
                    <div class="w-full mt-6 space-y-2.5">
                        <?php $__currentLoopData = [
                            ['icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'label' => 'Email', 'value' => $lead->email],
                            ['icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'label' => 'Téléphone', 'value' => $lead->phoneNumber],
                            ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z', 'label' => 'Adresse', 'value' => $lead->address],
                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-2xl text-left">
                            <div class="w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($item['icon']); ?>"/>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest"><?php echo e($item['label']); ?></p>
                                <p class="text-sm font-semibold text-slate-700 break-all leading-relaxed mt-0.5">
                                    <?php echo e($item['value'] ?? '—'); ?>

                                </p>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            
            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                <div class="p-6">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-4">Informations</p>
                    <div class="space-y-3">
                        <?php $__currentLoopData = [
                            ['label' => 'CNE',         'value' => $lead->CNE],
                            ['label' => 'Nationalité',  'value' => $lead->nationalite],
                            ['label' => 'Source',       'value' => $lead->source],
                            ['label' => 'Département',  'value' => $lead->departements->title ?? null],
                            ['label' => 'Responsable',  'value' => $lead->user ? $lead->user->firstName.' '.$lead->user->lastName : null],
                            ['label' => 'Date création','value' => $lead->dateCreation ? \Carbon\Carbon::parse($lead->dateCreation)->format('d/m/Y') : null],
                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-start justify-between gap-3 py-2.5 border-b border-slate-100 last:border-0">
                            <span class="text-xs font-black text-slate-400 uppercase tracking-wide shrink-0"><?php echo e($item['label']); ?></span>
                            <span class="text-xs font-semibold text-slate-700 text-right break-words max-w-[60%]">
                                <?php echo e($item['value'] ?? '—'); ?>

                            </span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            
           
        </div>

        
        <div class="lg:col-span-2 space-y-6">

            
            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                <div class="p-6">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-6">Pipeline de progression</p>
                    <?php
                        $steps = [
                            ['key' => 'nouveau',    'label' => 'Nouveau',    'icon' => 'M12 4v16m8-8H4'],
                            ['key' => '1er_appel',  'label' => '1er Appel',  'icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
                            ['key' => '2eme_appel', 'label' => '2ème Appel', 'icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
                            ['key' => 'promis',     'label' => 'Promis',     'icon' => 'M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11'],
                            ['key' => 'ok',         'label' => 'Converti',   'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ];
                        $order = ['nouveau' => 0, '1er_appel' => 1, '2eme_appel' => 2, 'promis' => 3, 'ok' => 4, 'lost' => 99];
                        $currentOrder = $order[$lead->statut] ?? 0;
                    ?>

                    <?php if($lead->statut === 'lost'): ?>
                    <div class="flex items-center gap-4 p-4 bg-red-50 border border-red-200 rounded-2xl">
                        <div class="w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-black text-red-700">Lead perdu</p>
                            <p class="text-xs text-red-400 mt-0.5">Ce lead n'a pas abouti à une conversion.</p>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="flex items-start gap-1">
                        <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $stepOrder = $order[$step['key']] ?? 0;
                            $isDone    = $stepOrder < $currentOrder;
                            $isCurrent = $step['key'] === $lead->statut;
                        ?>
                        <div class="flex items-center <?php echo e($i < count($steps)-1 ? 'flex-1' : ''); ?>">
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-2xl flex items-center justify-center shadow-sm
                                    <?php echo e($isCurrent ? 'bg-[#b11d40] ring-4 ring-[#b11d40]/20' : ($isDone ? 'bg-emerald-500' : 'bg-slate-100')); ?>">
                                    <svg class="w-4 h-4 <?php echo e($isCurrent || $isDone ? 'text-white' : 'text-slate-400'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($step['icon']); ?>"/>
                                    </svg>
                                </div>
                                <p class="text-[10px] font-black mt-2 text-center whitespace-nowrap
                                    <?php echo e($isCurrent ? 'text-[#b11d40]' : ($isDone ? 'text-emerald-600' : 'text-slate-400')); ?>">
                                    <?php echo e($step['label']); ?>

                                </p>
                            </div>
                            <?php if($i < count($steps)-1): ?>
                            <div class="flex-1 h-0.5 mx-2 mb-5 rounded-full <?php echo e($isDone ? 'bg-emerald-400' : 'bg-slate-200'); ?>"></div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <?php if($lead->client): ?>
            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="h-1.5 w-full bg-gradient-to-r from-emerald-400 to-emerald-600"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-5">
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Client associé</p>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-black bg-emerald-50 text-emerald-600">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            Converti
                        </span>
                    </div>
                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shrink-0 shadow-md">
                            <span class="text-white font-black text-lg">
                                <?php echo e(strtoupper(mb_substr($lead->client->firstName,0,1))); ?><?php echo e(strtoupper(mb_substr($lead->client->lastName,0,1))); ?>

                            </span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-extrabold text-slate-800 text-base"><?php echo e($lead->client->firstName); ?> <?php echo e($lead->client->lastName); ?></p>
                            <p class="text-sm text-slate-400 mt-0.5 truncate"><?php echo e($lead->client->email); ?></p>
                            <p class="text-sm text-slate-400"><?php echo e($lead->client->phoneNumber ?? '—'); ?></p>
                        </div>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client.view')): ?>
                        <a href="<?php echo e(route('clients.show', $lead->client->idClient)); ?>"
                           class="shrink-0 inline-flex items-center gap-1.5 text-xs font-bold text-[#b11d40] border border-[#b11d40]/30 hover:bg-[#b11d40] hover:text-white px-3 py-2 rounded-xl transition-all">
                            Voir
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if($lead->client && $lead->client->dossiers->count() > 0): ?>
            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Dossiers de voyage</p>
                    <span class="px-2.5 py-1 rounded-xl text-xs font-black bg-[#b11d40]/10 text-[#b11d40]">
                        <?php echo e($lead->client->dossiers->count()); ?> dossier<?php echo e($lead->client->dossiers->count() > 1 ? 's' : ''); ?>

                    </span>
                </div>
                <div class="divide-y divide-slate-100">
                    <?php $__currentLoopData = $lead->client->dossiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dossier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $ds = $dossierStatus[$dossier->status] ?? ['label' => $dossier->status, 'class' => 'bg-slate-100 text-slate-500']; ?>
                    <div class="p-5 hover:bg-slate-50/60 transition-colors">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-3 min-w-0 flex-1">
                                <div class="w-10 h-10 rounded-2xl bg-[#b11d40]/10 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-5 h-5 text-[#b11d40]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-black text-slate-800 text-sm"><?php echo e($dossier->reference); ?></span>
                                        <span class="px-2 py-0.5 rounded-lg text-[10px] font-black <?php echo e($ds['class']); ?>"><?php echo e($ds['label']); ?></span>
                                    </div>
                                    <?php if($dossier->distination): ?>
                                    <p class="text-sm text-slate-500 mt-1 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <?php echo e($dossier->distination); ?>

                                    </p>
                                    <?php endif; ?>
                                    <div class="flex flex-wrap gap-3 mt-2">
                                        <?php if($dossier->date_voyage): ?>
                                        <span class="inline-flex items-center gap-1 text-xs text-slate-400 font-medium">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <?php echo e(\Carbon\Carbon::parse($dossier->date_voyage)->format('d/m/Y')); ?>

                                        </span>
                                        <?php endif; ?>
                                        <span class="inline-flex items-center gap-1 text-xs text-slate-400 font-medium">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <?php echo e($dossier->nombre_personne); ?> pers.
                                        </span>
                                        <span class="inline-flex items-center gap-1 text-xs font-black text-slate-700">
                                            <?php echo e(number_format($dossier->montant ?? 0, 0, ',', ' ')); ?> MAD
                                        </span>
                                    </div>

                                    
                                    <?php if($dossier->commentaire): ?>
                                    <div class="mt-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Commentaire</p>
                                        <p class="text-xs text-slate-600 leading-relaxed"><?php echo e($dossier->commentaire); ?></p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.view')): ?>
                            <a href="<?php echo e(route('dossiers.show', $dossier->idDossier)); ?>"
                               class="shrink-0 inline-flex items-center gap-1.5 text-xs font-bold text-[#b11d40] border border-[#b11d40]/30 hover:bg-[#b11d40] hover:text-white px-3 py-2 rounded-xl transition-all">
                                Détails
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if($lead->note): ?>
            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                <div class="p-6">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-4">Note</p>
                    <div class="relative">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-[#b11d40] to-[#7c1233] rounded-full"></div>
                        <p class="pl-5 text-sm text-slate-700 leading-relaxed whitespace-pre-line"><?php echo e($lead->note); ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if($lead->duree || $lead->contentAppel): ?>
            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="h-1.5 w-full bg-gradient-to-r from-blue-400 to-blue-600"></div>
                <div class="p-6">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-4">Détails de l'appel</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php if($lead->duree): ?>
                        <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100">
                            <p class="text-[10px] font-black uppercase text-blue-400 tracking-widest mb-1">Durée</p>
                            <p class="text-lg font-extrabold text-blue-700"><?php echo e($lead->duree); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if($lead->contentAppel): ?>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 sm:col-span-<?php echo e($lead->duree ? '1' : '2'); ?>">
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Contenu</p>
                            <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line"><?php echo e($lead->contentAppel); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script>
function toggleDept(radio) {
    document.getElementById('dept-section').classList.toggle('hidden', radio.value !== 'ok');
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
<?php endif; ?><?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/leads/show.blade.php ENDPATH**/ ?>