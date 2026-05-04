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
                <a href="<?php echo e(route('dossiers.index')); ?>"
                   class="inline-flex items-center gap-2 text-slate-400 hover:text-[#b11d40] text-sm font-bold mb-2 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Retour aux dossiers
                </a>
                <h1 class="text-2xl font-extrabold text-slate-800"><?php echo e($dossier->reference); ?></h1>
                <p class="text-slate-500 text-sm"><?php echo e($dossier->distination ?? 'Aucune destination'); ?></p>
            </div>
            <div class="flex gap-3">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.edit')): ?>
                <a href="<?php echo e(route('dossiers.edit', $dossier->idDossier)); ?>"
                   class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dossier.delete')): ?>
                <form method="POST" action="<?php echo e(route('dossiers.destroy', $dossier->idDossier)); ?>"
                      onsubmit="return confirm('Supprimer ce dossier ?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit"
                            class="flex items-center gap-2 px-4 py-2 bg-white border border-red-200 text-red-500 font-bold rounded-xl hover:bg-red-500 hover:text-white transition-all text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Supprimer
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>

        
        <?php if(session('msg')): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm font-semibold">
            <?php echo e(session('msg')); ?>

        </div>
        <?php endif; ?>

        <?php
            $statusColors = ['ouvert' => 'bg-blue-100 text-blue-600', 'en_cours' => 'bg-yellow-100 text-yellow-700', 'ferme' => 'bg-slate-100 text-slate-500'];
            $statusLabels = ['ouvert' => 'Ouvert', 'en_cours' => 'En cours', 'ferme' => 'Fermé'];
        ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            
            <div class="lg:col-span-1 space-y-6">

                
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6">
                        <div class="flex flex-col items-center text-center mb-6">
                            <div class="w-16 h-16 rounded-2xl bg-[#b11d40]/10 flex items-center justify-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#b11d40]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h2 class="text-lg font-extrabold text-slate-800"><?php echo e($dossier->reference); ?></h2>
                            <span class="mt-2 px-3 py-1 rounded-xl text-xs font-black uppercase <?php echo e($statusColors[$dossier->status] ?? ''); ?>">
                                <?php echo e($statusLabels[$dossier->status] ?? $dossier->status); ?>

                            </span>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">Client</span>
                                <span class="text-sm font-bold text-slate-700"><?php echo e($dossier->client->firstName ?? '—'); ?> <?php echo e($dossier->client->lastName ?? ''); ?></span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">Département</span>
                                <span class="text-sm font-bold text-slate-700"><?php echo e($dossier->departement->title ?? '—'); ?></span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">Destination</span>
                                <span class="text-sm font-bold text-slate-700"><?php echo e($dossier->distination ?? '—'); ?></span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">Date voyage</span>
                                <span class="text-sm font-bold text-slate-700">
                                    <?php echo e($dossier->dateVoyage ? \Carbon\Carbon::parse($dossier->dateVoyage)->format('d/m/Y') : '—'); ?>

                                </span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">Personnes</span>
                                <span class="text-sm font-bold text-slate-700"><?php echo e($dossier->nombrePersonnes); ?></span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl">
                                <span class="text-xs font-black text-slate-400 uppercase">Jours</span>
                                <span class="text-sm font-bold text-slate-700"><?php echo e($dossier->nombreJours); ?></span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-[#b11d40]/5 rounded-2xl border border-[#b11d40]/10">
                                <span class="text-xs font-black text-[#b11d40] uppercase">Montant</span>
                                <span class="text-sm font-black text-[#b11d40]"><?php echo e(number_format($dossier->montant, 2)); ?> MAD</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="lg:col-span-2 space-y-6">

                
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6 space-y-4">
                        <div>
                            <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-2">Commentaire</h3>
                            <?php if($dossier->commentaire): ?>
                                <p class="text-sm text-slate-700 bg-slate-50 rounded-2xl p-4 leading-relaxed"><?php echo e($dossier->commentaire); ?></p>
                            <?php else: ?>
                                <p class="text-sm text-slate-400 italic">Aucun commentaire.</p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-2">Réponse</h3>
                            <?php if($dossier->reponse): ?>
                                <p class="text-sm text-slate-700 bg-slate-50 rounded-2xl p-4 leading-relaxed"><?php echo e($dossier->reponse); ?></p>
                            <?php else: ?>
                                <p class="text-sm text-slate-400 italic">Aucune réponse.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6">
                        <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-4">
                            Paiements
                            <span class="ml-2 px-2 py-0.5 rounded-lg bg-slate-100 text-slate-500 text-xs"><?php echo e($dossier->paiements->count()); ?></span>
                        </h3>
                        <?php $__empty_1 = true; $__currentLoopData = $dossier->paiements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paiement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-2xl mb-2">
                            <div>
                                <p class="text-xs font-black text-slate-700"><?php echo e($paiement->reference ?? '—'); ?></p>
                                <p class="text-xs text-slate-400"><?php echo e($paiement->created_at?->format('d/m/Y')); ?></p>
                            </div>
                            <span class="text-sm font-black text-green-600"><?php echo e(number_format($paiement->montant ?? 0, 2)); ?> MAD</span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-slate-400 italic">Aucun paiement enregistré.</p>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden" x-data="presentationManager()">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider">
                                Présentations
                                <span class="ml-2 px-2 py-0.5 rounded-lg bg-slate-100 text-slate-500 text-xs"><?php echo e($dossier->presentations->count()); ?></span>
                            </h3>
                            <button @click="openModal()" class="flex items-center gap-1.5 px-3 py-1.5 bg-[#b11d40]/10 text-[#b11d40] rounded-xl text-[10px] font-black uppercase hover:bg-[#b11d40] hover:text-white transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
                                </svg>
                                Ajouter
                            </button>
                        </div>

                        <?php $__empty_1 = true; $__currentLoopData = $dossier->presentations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $presentation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="p-4 bg-slate-50 rounded-2xl mb-3 border border-slate-100 group hover:border-[#b11d40]/20 transition-all">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-black text-slate-700"><?php echo e($presentation->titre ?? '—'); ?></p>
                                        <div class="flex items-center" x-data="{ 
                                            status: '<?php echo e($presentation->status); ?>',
                                            async updateStatus(newStatus) {
                                                try {
                                                    const res = await fetch(`/admin/presentations/<?php echo e($presentation->idPresentation); ?>`, {
                                                        method: 'PUT',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]').getAttribute('content'),
                                                            'Accept': 'application/json'
                                                        },
                                                        body: JSON.stringify({ status: newStatus })
                                                    });
                                                    if(res.ok) {
                                                        this.status = newStatus;
                                                    }
                                                } catch(e) { alert('Erreur'); }
                                            }
                                        }">
                                            <select x-model="status" @change="updateStatus($event.target.value)" 
                                                class="appearance-none px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border-2 outline-none cursor-pointer transition-all shadow-sm"
                                                :class="{
                                                    'bg-amber-50 text-amber-600 border-amber-200 hover:border-amber-400': status === 'en_attente',
                                                    'bg-emerald-50 text-emerald-600 border-emerald-200 hover:border-emerald-400': status === 'validee',
                                                    'bg-rose-50 text-rose-600 border-rose-200 hover:border-rose-400': status === 'refusee'
                                                }">
                                                <option value="en_attente">En attente</option>
                                                <option value="validee">Validée</option>
                                                <option value="refusee">Refusée</option>
                                            </select>
                                        </div>
                                        <button @click="openModal(<?php echo e(json_encode($presentation)); ?>)" class="p-1 text-slate-400 hover:text-[#b11d40] transition-colors opacity-0 group-hover:opacity-100" title="Modifier">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button @click="duplicatePresentation(<?php echo e($presentation->idPresentation); ?>)" class="p-1 text-slate-400 hover:text-green-600 transition-colors opacity-0 group-hover:opacity-100" title="Nouvelle Version">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                                            </svg>
                                        </button>
                                        <button @click="deletePresentation(<?php echo e($presentation->idPresentation); ?>)" class="p-1 text-slate-400 hover:text-red-600 transition-colors opacity-0 group-hover:opacity-100" title="Supprimer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-[10px] text-slate-400 uppercase font-bold"><?php echo e($presentation->created_at?->format('d/m/Y')); ?></p>
                                </div>
                                <span class="text-sm font-black text-[#b11d40]"><?php echo e(number_format($presentation->total, 2)); ?> MAD</span>
                            </div>
                            
                            <?php if($presentation->presentationItems->count() > 0): ?>
                            <div class="mt-3 space-y-1 pl-2 border-l-2 border-slate-200 group-hover:border-[#b11d40]/30 transition-all">
                                <?php $__currentLoopData = $presentation->presentationItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex justify-between text-[11px] text-slate-500 p-1.5 rounded-lg transition-all <?php echo e($item->status === 'validee' ? 'bg-green-50/50' : ''); ?>">
                                    <span class="flex items-center gap-2">
                                        <?php if($item->status === 'validee'): ?>
                                        <span class="flex h-4 w-4 rounded-full bg-green-100 items-center justify-center ring-1 ring-green-500/20">
                                            <svg class="w-2.5 h-2.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M5 13l4 4L19 7"/></svg>
                                        </span>
                                        <?php endif; ?>
                                        <span class="flex flex-col">
                                            <span class="font-black text-slate-800 text-xs"><?php echo e($item->nom); ?></span>
                                            <span class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter"><?php echo e($item->category->nom ?? 'Article'); ?></span>
                                        </span>
                                    </span>
                                    <div class="flex items-center gap-3">
                                        <span class="text-[9px] font-bold text-slate-500">x<?php echo e($item->quantity); ?></span>
                                        <span class="font-bold text-slate-700"><?php echo e(number_format($item->totale, 2)); ?> MAD</span>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php endif; ?>

                            <?php if($presentation->reponse): ?>
                            <div class="mt-4 p-3 bg-[#b11d40]/5 rounded-xl border border-[#b11d40]/10">
                                <p class="text-[9px] font-black text-[#b11d40] uppercase tracking-widest mb-1">Suggestion du client:</p>
                                <p class="text-[10px] text-slate-600 italic leading-relaxed">"<?php echo e(Str::limit($presentation->reponse, 100)); ?>"</p>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="flex flex-col items-center justify-center py-10 text-center opacity-40">
                            <svg class="w-10 h-10 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-xs font-bold uppercase">Aucune présentation</p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Modal Création/Édition Présentation -->
                    <div x-show="showModal" 
                         class="fixed inset-0 z-[1000] flex items-center justify-center p-4"
                         x-cloak>
                        <div x-show="showModal" 
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeModal()"></div>
                        
                        <div x-show="showModal"
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                             class="bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl overflow-hidden z-[1001] flex flex-col max-h-[90vh]">
                            
                            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between shrink-0">
                                <div>
                                    <h2 class="text-xl font-black text-slate-800" x-text="isEdit ? 'Modifier Présentation' : 'Nouvelle Présentation'"></h2>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Dossier: <?php echo e($dossier->reference); ?></p>
                                </div>
                                <button @click="closeModal()" class="w-10 h-10 flex items-center justify-center rounded-2xl hover:bg-slate-200 transition-colors">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>

                            <div class="flex-1 overflow-y-auto p-8">
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Titre de la présentation *</label>
                                        <input type="text" x-model="form.titre" placeholder="Ex: Devis V1 - Circuit Sud" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-sm text-slate-700 outline-none focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5 transition-all font-bold">
                                    </div>

                                    <div class="pt-4">
                                        <div class="flex items-center justify-between mb-4">
                                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Éléments de la présentation</label>
                                            <button @click="addItem()" class="text-[10px] font-black uppercase text-[#b11d40] hover:underline">+ Ajouter un article</button>
                                        </div>

                                        <div class="space-y-3">
                                            <template x-for="(item, index) in form.items" :key="index">
                                                <div class="grid grid-cols-12 gap-3 p-4 bg-slate-50 rounded-3xl border border-slate-100 relative">
                                                    <div class="col-span-12">
                                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-tighter mb-1 block">Nom de l'article *</label>
                                                        <input type="text" x-model="item.nom" placeholder="Ex: Transport Touristique" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-700 outline-none focus:border-[#b11d40] transition-all font-bold">
                                                    </div>
                                                    <div class="col-span-5">
                                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-tighter mb-1 block">Catégorie</label>
                                                        <select x-model="item.idCategory" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-700 outline-none focus:border-[#b11d40] transition-all font-bold">
                                                            <option value="">Sélectionner</option>
                                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($cat->idCategory); ?>"><?php echo e($cat->nom); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-span-3">
                                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-tighter mb-1 block">Prix (MAD)</label>
                                                        <input type="number" x-model="item.prixUnitaire" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-700 outline-none focus:border-[#b11d40] transition-all font-bold">
                                                    </div>
                                                    <div class="col-span-2">
                                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-tighter mb-1 block">Qté</label>
                                                        <input type="number" x-model="item.quantity" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-700 outline-none focus:border-[#b11d40] transition-all font-bold">
                                                    </div>
                                                    <div class="col-span-2 flex items-end justify-end">
                                                        <button @click="removeItem(index)" class="p-2 text-slate-300 hover:text-red-500 transition-colors">
                                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-8 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between shrink-0">
                                <div class="text-left">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Estimé</p>
                                    <p class="text-xl font-black text-[#b11d40]" x-text="formatMoney(calculateTotal()) + ' MAD'"></p>
                                </div>
                                <div class="flex gap-3">
                                    <button @click="closeModal()" class="px-6 py-3.5 rounded-2xl font-bold text-slate-400 hover:text-slate-600 transition-all text-sm">Annuler</button>
                                    <button @click="submitForm()" 
                                            class="px-8 py-3.5 bg-[#b11d40] text-white rounded-2xl font-black text-sm shadow-lg shadow-[#b11d40]/20 hover:scale-[1.02] active:scale-95 transition-all disabled:opacity-50"
                                            :disabled="loading">
                                        <span x-show="!loading">Enregistrer</span>
                                        <span x-show="loading" class="flex items-center gap-2">
                                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                            Traitement...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function presentationManager() {
            return {
                showModal: false,
                loading: false,
                isEdit: false,
                form: {
                    idPresentation: null,
                    idDossier: <?php echo e($dossier->idDossier); ?>,
                    titre: '',
                    items: [
                        { idItems: null, nom: '', idCategory: '', prixUnitaire: 0, quantity: 1 }
                    ]
                },
                openModal(presentation = null) {
                    if (presentation) {
                        this.isEdit = true;
                        this.form.idPresentation = presentation.idPresentation;
                        this.form.titre = presentation.titre;
                        this.form.items = presentation.presentation_items.map(i => ({
                            idItems: i.idItems,
                            nom: i.nom,
                            idCategory: i.idCategory,
                            prixUnitaire: i.prixUnitaire,
                            quantity: i.quantity
                        }));
                    } else {
                        this.isEdit = false;
                        this.form.idPresentation = null;
                        this.form.titre = '';
                        this.form.items = [{ idItems: null, nom: '', idCategory: '', prixUnitaire: 0, quantity: 1 }];
                    }
                    this.showModal = true;
                    document.body.style.overflow = 'hidden';
                },
                closeModal() {
                    this.showModal = false;
                    document.body.style.overflow = 'auto';
                },
                addItem() {
                    this.form.items.push({ idItems: null, nom: '', idCategory: '', prixUnitaire: 0, quantity: 1 });
                },
                removeItem(index) {
                    if (this.form.items.length > 1) {
                        this.form.items.splice(index, 1);
                    }
                },
                calculateTotal() {
                    return this.form.items.reduce((sum, item) => {
                        return sum + (parseFloat(item.prixUnitaire || 0) * parseInt(item.quantity || 0));
                    }, 0);
                },
                formatMoney(amount) {
                    return new Intl.NumberFormat('fr-MA', { minimumFractionDigits: 2 }).format(amount);
                },
                duplicatePresentation(id) {
                    currentDuplicateId = id;
                    const modal = document.getElementById('duplicateConfirmModal');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    document.body.style.overflow = 'hidden';
                },
                updatePresentationStatus(id, nextStatus) {
                    fetch(`/admin/presentations/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ status: nextStatus })
                    })
                    .then(res => res.json())
                    .then(data => {
                        window.location.reload();
                    })
                    .catch(err => alert('Erreur lors du changement de statut'));
                },
                deletePresentation(id) {
                    currentDeleteId = id;
                    const modal = document.getElementById('deleteConfirmModal');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    document.body.style.overflow = 'hidden';
                },
                async submitForm() {
                    if (!this.form.titre) {
                        alert('Veuillez saisir un titre.');
                        return;
                    }

                    // Validate items have names
                    for(let item of this.form.items) {
                        if(!item.nom) {
                            alert('Veuillez saisir un nom pour tous les articles.');
                            return;
                        }
                    }
                    
                    this.loading = true;
                    const url = this.isEdit ? `/admin/presentations/${this.form.idPresentation}` : '/admin/presentations';
                    const method = this.isEdit ? 'PUT' : 'POST';

                    try {
                        const response = await fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(this.form)
                        });

                        if (response.ok) {
                            window.location.reload();
                        } else {
                            const err = await response.json();
                            alert(err.message || 'Erreur lors de l\'enregistrement');
                        }
                    } catch (e) {
                        console.error(e);
                        alert('Une erreur est survenue.');
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
    
    <div id="duplicateConfirmModal" class="fixed inset-0 z-[160] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeDuplicateModal()"></div>
        <div class="relative bg-white w-full max-w-sm rounded-[32px] shadow-2xl p-8 z-10 animate-modal-in text-center">
            <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 mx-auto mb-6">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" /></svg>
            </div>
            <h3 class="text-xl font-black text-slate-800 mb-2">Nouvelle Version</h3>
            <p class="text-xs text-slate-500 font-bold mb-8">Voulez-vous créer une nouvelle version de cette présentation ?</p>
            
            <div class="flex gap-3">
                <button onclick="closeDuplicateModal()" class="flex-1 py-3 bg-slate-100 text-slate-400 rounded-2xl font-bold text-xs hover:bg-slate-200 transition-all">Annuler</button>
                <button id="confirmDuplicateBtn" class="flex-1 py-3 bg-green-600 text-white rounded-2xl font-bold text-xs shadow-lg shadow-green-600/20 hover:bg-green-700 transition-all">Confirmer</button>
            </div>
        </div>
    </div>

    
    <div id="deleteConfirmModal" class="fixed inset-0 z-[160] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeDeleteModal()"></div>
        <div class="relative bg-white w-full max-w-sm rounded-[32px] shadow-2xl p-8 z-10 animate-modal-in text-center">
            <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center text-red-600 mx-auto mb-6">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            </div>
            <h3 class="text-xl font-black text-slate-800 mb-2">Supprimer</h3>
            <p class="text-xs text-slate-500 font-bold mb-8">Voulez-vous vraiment supprimer cette présentation ? Cette action est irréversible.</p>
            
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 py-3 bg-slate-100 text-slate-400 rounded-2xl font-bold text-xs hover:bg-slate-200 transition-all">Annuler</button>
                <button id="confirmDeleteBtn" class="flex-1 py-3 bg-red-600 text-white rounded-2xl font-bold text-xs shadow-lg shadow-red-600/20 hover:bg-red-700 transition-all">Supprimer</button>
            </div>
        </div>
    </div>

    <script>
        let currentDuplicateId = null;
        let currentDeleteId = null;

        function closeDuplicateModal() {
            document.getElementById('duplicateConfirmModal').classList.add('hidden');
            document.getElementById('duplicateConfirmModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function closeDeleteModal() {
            document.getElementById('deleteConfirmModal').classList.add('hidden');
            document.getElementById('deleteConfirmModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        document.getElementById('confirmDuplicateBtn').onclick = function() {
            if(!currentDuplicateId) return;
            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin h-4 w-4 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            
            fetch(`/admin/presentations/${currentDuplicateId}/duplicate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                window.location.reload();
            })
            .catch(err => {
                alert('Erreur lors de la duplication');
                btn.disabled = false;
                btn.textContent = 'Confirmer';
            });
        }

        document.getElementById('confirmDeleteBtn').onclick = function() {
            if(!currentDeleteId) return;
            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin h-4 w-4 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            
            fetch(`/admin/presentations/${currentDeleteId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                window.location.reload();
            })
            .catch(err => {
                alert('Erreur lors de la suppression');
                btn.disabled = false;
                btn.textContent = 'Supprimer';
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
<?php endif; ?><?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/dossiers/show.blade.php ENDPATH**/ ?>