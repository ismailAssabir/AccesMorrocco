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
                <a href="<?php echo e(route('clients.index')); ?>"
                   class="inline-flex items-center gap-2 text-slate-400 hover:text-[#b11d40] text-sm font-bold mb-2 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Retour aux clients
                </a>
                <h1 class="text-2xl font-extrabold text-slate-800"><?php echo e($client->firstName); ?> <?php echo e($client->lastName); ?></h1>
                <p class="text-slate-500 text-sm">Fiche client</p>
            </div>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client.edit')): ?>
            <a href="<?php echo e(route('clients.edit', $client->idClient)); ?>"
               class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Modifier
            </a>
            <?php endif; ?>
        </div>

        
        <?php if(session('msg')): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm font-semibold">
            <?php echo e(session('msg')); ?>

        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            
            <div class="lg:col-span-1">
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6 flex flex-col items-center text-center">
                        <div class="w-20 h-20 rounded-3xl bg-[#b11d40]/10 flex items-center justify-center mb-4">
                            <span class="text-[#b11d40] font-black text-2xl">
                                <?php echo e(strtoupper(substr($client->firstName, 0, 1))); ?><?php echo e(strtoupper(substr($client->lastName, 0, 1))); ?>

                            </span>
                        </div>
                        <h2 class="text-xl font-extrabold text-slate-800"><?php echo e($client->firstName); ?> <?php echo e($client->lastName); ?></h2>

                        <?php if($client->type): ?>
                        <span class="mt-2 px-3 py-1 rounded-xl text-xs font-black bg-[#b11d40]/10 text-[#b11d40] uppercase">
                            <?php echo e($client->type); ?>

                        </span>
                        <?php endif; ?>

                        <span class="mt-2 px-3 py-1 rounded-xl text-xs font-black uppercase
                            <?php echo e($client->status === 'actif' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-500'); ?>">
                            <?php echo e(ucfirst($client->status ?? 'inactif')); ?>

                        </span>

                        <div class="w-full mt-6 space-y-3 text-left">
                            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl">
                                <div class="w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-400 font-bold uppercase">Email</p>
                                    <p class="text-sm text-slate-700 font-semibold truncate"><?php echo e($client->email); ?></p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl">
                                <div class="w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-bold uppercase">Téléphone</p>
                                    <p class="text-sm text-slate-700 font-semibold"><?php echo e($client->phoneNumber); ?></p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl">
                                <div class="w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-bold uppercase">Adresse</p>
                                    <p class="text-sm text-slate-700 font-semibold"><?php echo e($client->address ?? '—'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6">
                        <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-4">Informations personnelles</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">CNE</p>
                                <p class="text-sm font-semibold text-slate-700"><?php echo e($client->CNE); ?></p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">Date de naissance</p>
                                <p class="text-sm font-semibold text-slate-700">
                                    <?php echo e($client->dateNaissance ? \Carbon\Carbon::parse($client->dateNaissance)->format('d/m/Y') : '—'); ?>

                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">Nationalité</p>
                                <p class="text-sm font-semibold text-slate-700"><?php echo e($client->nationalite ?? '—'); ?></p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">Type</p>
                                <p class="text-sm font-semibold text-slate-700"><?php echo e($client->type ?? '—'); ?></p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">Lead associé</p>
                                <p class="text-sm font-semibold text-slate-700">
                                    <?php if($client->idLead): ?>
                                        <a href="<?php echo e(route('leads.show', $client->idLead)); ?>"
                                           class="text-[#b11d40] hover:underline font-black">
                                            Voir le lead #<?php echo e($client->idLead); ?>

                                        </a>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6">
                        <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-3">Note</h3>
                        <?php if($client->note): ?>
                            <p class="text-sm text-slate-700 leading-relaxed bg-slate-50 rounded-2xl p-4"><?php echo e($client->note); ?></p>
                        <?php else: ?>
                            <p class="text-sm text-slate-400 italic">Aucune note renseignée.</p>
                        <?php endif; ?>
                    </div>
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
<?php endif; ?><?php /**PATH C:\Users\dell\Desktop\PROJECTS\AccesMorrocco\resources\views/showClient.blade.php ENDPATH**/ ?>