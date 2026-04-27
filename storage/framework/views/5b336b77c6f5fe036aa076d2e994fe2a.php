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
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Objectifs de l'Entreprise</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Pilotez et suivez les KPI majeurs pour atteindre nos ambitions.</p>
            </div>
            <?php if(auth()->user()->type !== 'employee'): ?>
            <button onclick="toggleModal('addObjectifModal')" class="flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter
            </button>
            <?php endif; ?>
        </div>

        
        <?php if (isset($component)) { $__componentOriginal22c14bbdfcc4454c743aeeffbde19ea3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal22c14bbdfcc4454c743aeeffbde19ea3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-messages','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-messages'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal22c14bbdfcc4454c743aeeffbde19ea3)): ?>
<?php $attributes = $__attributesOriginal22c14bbdfcc4454c743aeeffbde19ea3; ?>
<?php unset($__attributesOriginal22c14bbdfcc4454c743aeeffbde19ea3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal22c14bbdfcc4454c743aeeffbde19ea3)): ?>
<?php $component = $__componentOriginal22c14bbdfcc4454c743aeeffbde19ea3; ?>
<?php unset($__componentOriginal22c14bbdfcc4454c743aeeffbde19ea3); ?>
<?php endif; ?>

        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $objs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white border border-slate-100 rounded-[2rem] shadow-xl shadow-slate-200/40 p-7 flex flex-col hover:shadow-2xl hover:shadow-[#b11d40]/5 transition-all duration-300 relative group hover:-translate-y-1">
                
                
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shrink-0 shadow-sm border border-indigo-100/50">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="<?php echo e($obj->status_config['class']); ?> font-bold px-3.5 py-1.5 rounded-xl text-[10px] uppercase tracking-wider shadow-sm border border-current/10">
                            <?php echo e($obj->status_config['label']); ?>

                        </span>
                    </div>
                </div>
                
                
                <div class="mb-6">
                    <h3 class="text-xl font-extrabold text-slate-900 mb-2 leading-tight group-hover:text-[#b11d40] transition-colors"><?php echo e($obj->titre); ?></h3>
                    <p class="text-slate-500 text-sm leading-relaxed line-clamp-2 font-medium"><?php echo e($obj->description); ?></p>
                </div>

                
                <div class="flex flex-wrap items-center gap-4 mb-8 pt-4 border-t border-slate-50">
                    <div class="flex items-center gap-2 text-slate-400">
                        <div class="w-7 h-7 rounded-lg bg-slate-50 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-500"><?php echo e(optional($obj->departement)->title ?? 'Global'); ?></span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-400">
                        <div class="w-7 h-7 rounded-lg bg-slate-50 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">
                            <?php echo e(($obj->departement && $obj->departement->manager) ? $obj->departement->manager->firstName . ' ' . $obj->departement->manager->lastName : 'Non assigné'); ?>

                        </span>
                    </div>
                </div>

                
                <div class="mt-auto">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Complétion Globale</span>
                        <span class="text-lg font-black text-slate-900"><?php echo e($obj->avancement); ?>%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden shadow-inner">
                        <?php
                            $progressColor = 'bg-rose-500';
                            if($obj->avancement > 70) $progressColor = 'bg-emerald-500';
                            elseif($obj->avancement > 30) $progressColor = 'bg-amber-500';
                        ?>
                        <div class="h-full rounded-full transition-all duration-1000 ease-out <?php echo e($progressColor); ?> shadow-sm" 
                             style="width: <?php echo e($obj->avancement); ?>%">
                        </div>
                    </div>
                </div>

                
                <?php if(auth()->user()->type !== 'employee'): ?>
                <div class="absolute inset-x-7 bottom-7 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0">
                    <div class="bg-white/90 backdrop-blur-md border border-slate-100 rounded-2xl shadow-xl p-1.5 flex gap-1.5">
                        <button type="button" onclick="openEditModal('<?php echo e($obj->idObjectif); ?>')" class="flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all font-bold text-xs">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Modifier
                        </button>
                        <button type="button" onclick="confirmDeleteObjectif('<?php echo e($obj->idObjectif); ?>')" class="flex items-center justify-center w-9 h-9 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-dashed border-slate-300">
                <p class="text-slate-400 font-medium">Aucun objectif trouvé.</p>
            </div>
            <?php endif; ?>
        </div>

    </div>
    </div>

    

    
    <div id="addObjectifModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 pointer-events-none">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm -z-10 transition-opacity pointer-events-auto" onclick="toggleModal('addObjectifModal', 'close')"></div>
        <div class="relative z-10 bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden flex flex-col max-h-[92vh] pointer-events-auto animate-in fade-in zoom-in duration-200">
            
            
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Nouvel Objectif Stratégique</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Planification · Access Morocco</p>
                </div>
                <button type="button" onclick="toggleModal('addObjectifModal', 'close')"
                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] hover:border-[#be2346]/30 transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            
            <div class="overflow-y-auto">
                <form action="<?php echo e(url('/objectifs')); ?>" method="POST" class="p-7 space-y-5">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Titre de l'objectif <span class="text-[#be2346]">*</span></label>
                            <input type="text" name="titre" required maxlength="55" placeholder="Ex: Expansion Marché EMEA" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Description</label>
                            <textarea name="description" rows="3" placeholder="Détails de l'objectif..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5"></textarea>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date de début</label>
                            <input type="date" name="dateDebut" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date d'échéance</label>
                            <input type="date" name="dateFin" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Statut <span class="text-[#be2346]">*</span></label>
                            <select name="status" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                <option value="en_cours">En cours</option>
                                <option value="atteint">Atteint</option>
                                <option value="echoue">Échoué</option>
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Avancement (%) <span class="text-[#be2346]">*</span></label>
                            <input type="number" name="avancement" required min="0" max="100" value="0" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Département responsable</label>
                            <select name="idDepartement" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                <option value="">-- Global --</option>
                                <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($dept->idDepartement); ?>"><?php echo e($dept->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="toggleModal('addObjectifModal', 'close')"
                            class="flex-1 py-4 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm">
                            Annuler
                        </button>
                        <button type="submit"
                            class="flex-1 py-4 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-[#be2346]/20 text-sm">
                            Sauvegarder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div id="editObjectifModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 pointer-events-none">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm -z-10 transition-opacity pointer-events-auto" onclick="toggleModal('editObjectifModal', 'close')"></div>
        <div class="relative z-10 bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden flex flex-col max-h-[92vh] pointer-events-auto animate-in fade-in zoom-in duration-200">
            
            
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Modifier l'Objectif</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Édition · Access Morocco</p>
                </div>
                <button type="button" onclick="toggleModal('editObjectifModal', 'close')"
                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            
            <div class="overflow-y-auto">
                <form id="editObjectifForm" method="POST" class="p-7 space-y-5">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Titre de l'objectif *</label>
                            <input type="text" name="titre" id="edit_titre" required maxlength="55" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>

                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Description</label>
                            <textarea name="description" id="edit_description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5"></textarea>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date de début</label>
                            <input type="date" name="dateDebut" id="edit_dateDebut" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date d'échéance</label>
                            <input type="date" name="dateFin" id="edit_dateFin" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Statut *</label>
                            <select name="status" id="edit_status" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                <option value="en_cours">En cours</option>
                                <option value="atteint">Atteint</option>
                                <option value="echoue">Échoué</option>
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Avancement (%) *</label>
                            <input type="number" name="avancement" id="edit_avancement" required min="0" max="100" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>

                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Département responsable</label>
                            <select name="idDepartement" id="edit_idDepartement" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                <option value="">-- Global --</option>
                                <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($dept->idDepartement); ?>"><?php echo e($dept->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="toggleModal('editObjectifModal', 'close')"
                            class="flex-1 py-3.5 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm">
                            Annuler
                        </button>
                        <button type="submit"
                            id="edit_submit_btn"
                            class="flex-1 py-3.5 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-[#be2346]/20 text-sm">
                            Sauvegarder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleModal(id, action = 'toggle') {
            const modal = document.getElementById(id);
            if (!modal) return;
            
            const isHidden = modal.classList.contains('hidden');
            const shouldOpen = action === 'open' || (action === 'toggle' && isHidden);
            
            if (shouldOpen) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }
        }

        function openEditModal(id) {
            const form = document.getElementById('editObjectifForm');
            form.action = `/objectifs/edit/${id}`;
            
            // Show modal immediately for better UX
            toggleModal('editObjectifModal', 'open');
            
            // Temporary loading state
            const titreInput = document.getElementById('edit_titre');
            const submitBtn = document.getElementById('edit_submit_btn');
            
            const originalTitle = titreInput.value;
            const originalBtnText = submitBtn.innerHTML;
            
            titreInput.value = 'Chargement...';
            submitBtn.innerHTML = 'Chargement...';
            submitBtn.disabled = true;
            
            // Fetch the data from the controller (AJAX)
            fetch(`/objectifs/edit/${id}?_t=${new Date().getTime()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if(!response.ok) throw new Error('Network error');
                return response.json();
            })
            .then(data => {
                document.getElementById('edit_titre').value = data.titre || '';
                document.getElementById('edit_description').value = data.description || '';
                document.getElementById('edit_dateDebut').value = data.dateDebut || '';
                document.getElementById('edit_dateFin').value = data.dateFin || '';
                document.getElementById('edit_status').value = data.status || 'en_cours';
                document.getElementById('edit_avancement').value = data.avancement || 0;
                document.getElementById('edit_idDepartement').value = data.idDepartement || '';
                
                submitBtn.innerHTML = 'Sauvegarder';
                submitBtn.disabled = false;
            })
            .catch(error => {
                console.error('Error fetching objective data:', error);
                titreInput.value = 'Erreur lors du chargement.';
                submitBtn.innerHTML = 'Erreur';
            });
        }

        function confirmDeleteObjectif(id) {
            window.confirmDelete('/objectifs/delete/' + id, 'objectif');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                toggleModal('addObjectifModal', 'close');
                toggleModal('editObjectifModal', 'close');
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
<?php endif; ?><?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/objectifs/index.blade.php ENDPATH**/ ?>