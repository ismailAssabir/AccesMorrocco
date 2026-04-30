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
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Demandes de Congés</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Gérez et validez les demandes d'absence.</p>
            </div>
            <button onclick="openCongeModal()" class="flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Nouvelle Demande
            </button>
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

        
        <?php
            $totalConges = $conges->count();
            $pendingConges = $conges->where('status', 'en_attente')->count();
            $approvedConges = $conges->where('status', 'approuve')->count();
            $rejectedConges = $conges->where('status', 'refuse')->count();
        ?>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-5 transition-transform hover:-translate-y-1">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-blue-50 text-blue-500">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total</p>
                    <p class="text-2xl font-black text-slate-800"><?php echo e($totalConges); ?></p>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-5 transition-transform hover:-translate-y-1">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-amber-50 text-amber-500">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">En Attente</p>
                    <p class="text-2xl font-black text-slate-800"><?php echo e($pendingConges); ?></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-5 transition-transform hover:-translate-y-1">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-emerald-50 text-emerald-500">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Approuvés</p>
                    <p class="text-2xl font-black text-slate-800"><?php echo e($approvedConges); ?></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-5 transition-transform hover:-translate-y-1">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center bg-red-50 text-red-500">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Refusés</p>
                    <p class="text-2xl font-black text-slate-800"><?php echo e($rejectedConges); ?></p>
                </div>
            </div>
        </div>

        
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4 mb-8">
            <div class="flex flex-nowrap items-center gap-3 overflow-x-auto pb-2 custom-scrollbar">
                
                <div class="flex-1 min-w-[200px] shrink-0 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="searchInput" oninput="debounceFilter()" 
                        placeholder="Rechercher un employé..." 
                        class="block w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-2xl text-sm transition-all focus:border-[#b11d40]/40 focus:ring-4 focus:ring-[#b11d40]/10 outline-none">
                </div>

                
                <div class="relative shrink-0">
                    <select id="statusFilter" onchange="fetchFilteredConges()" 
                        class="appearance-none bg-white border border-slate-200 rounded-xl pl-4 pr-10 py-2 text-xs font-bold text-slate-600 outline-none transition-all focus:border-[#b11d40]/40 focus:ring-4 focus:ring-[#b11d40]/10 cursor-pointer">
                        <option value="">Statut (Tous)</option>
                        <option value="en_attente">En attente</option>
                        <option value="approuve">Approuvé</option>
                        <option value="refuse">Refusé</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>

                
                <div class="relative shrink-0">
                    <select id="typeFilter" onchange="fetchFilteredConges()" 
                        class="appearance-none bg-white border border-slate-200 rounded-xl pl-4 pr-10 py-2 text-xs font-bold text-slate-600 outline-none transition-all focus:border-[#b11d40]/40 focus:ring-4 focus:ring-[#b11d40]/10 cursor-pointer">
                        <option value="">Type (Tous)</option>
                        <option value="annuel">Annuel</option>
                        <option value="maladie">Maladie</option>
                        <option value="sans_solde">Sans Solde</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>

                
                <button type="button" onclick="resetFilters()" class="p-2 rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-all flex items-center justify-center shadow-sm shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
            </div>
        </div>

        
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-extrabold text-slate-500 tracking-wider">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Employé</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Période</th>
                            <th class="px-6 py-4">Date Demande</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="conges-table-body" class="divide-y divide-slate-100">
                        <?php echo $__env->make('conges.partials.table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    
    <div id="addCongeModal" class="fixed inset-0 z-[100] <?php echo e($errors->any() ? '' : 'hidden'); ?> flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeCongeModal()"></div>
        <div class="relative bg-white w-full max-w-2xl rounded-[32px] shadow-2xl border border-slate-100 overflow-hidden flex flex-col max-h-[92vh] z-10" style="animation: modalIn .2s ease-out">
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Nouvelle Demande</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Congé · Access Morocco</p>
                </div>
                <button type="button" onclick="closeCongeModal()" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] hover:border-[#be2346]/30 transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="overflow-y-auto">
                <form action="<?php echo e(route('conge.store')); ?>" method="POST" enctype="multipart/form-data" class="p-7 space-y-5">
                    <?php echo csrf_field(); ?>
                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Type de Congé <span class="text-[#be2346]">*</span></label>
                        <select name="type" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            <option value="annuel" <?php echo e(old('type') == 'annuel' ? 'selected' : ''); ?>>Annuel</option>
                            <option value="maladie" <?php echo e(old('type') == 'maladie' ? 'selected' : ''); ?>>Maladie</option>
                            <option value="sans_solde" <?php echo e(old('type') == 'sans_solde' ? 'selected' : ''); ?>>Sans Solde</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date Début <span class="text-[#be2346]">*</span></label>
                            <input type="date" name="dateDebut" required value="<?php echo e(old('dateDebut')); ?>" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date Fin <span class="text-[#be2346]">*</span></label>
                            <input type="date" name="dateFin" required value="<?php echo e(old('dateFin')); ?>" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Raison (Motif)</label>
                        <textarea name="motif" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5"><?php echo e(old('motif')); ?></textarea>
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Justification (Fichier)</label>
                        <div class="relative group">
                            <input type="file" name="justification" id="justificationInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="updateFileName(this)">
                            <div class="w-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl px-4 py-5 flex items-center justify-center gap-3 transition-all group-hover:border-[#be2346]/30 group-hover:bg-[#be2346]/5">
                                <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-[#be2346] group-hover:border-[#be2346]/20 transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-bold text-slate-600 group-hover:text-[#be2346] transition-all" id="fileNameDisplay">Choisir un fichier</p>
                                    <p class="text-[10px] text-slate-400 font-medium">PDF, JPG, PNG (Max. 5MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="closeCongeModal()" class="flex-1 py-4 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm">Annuler</button>
                        <button type="submit" class="flex-1 py-4 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-[#be2346]/20 text-sm">Soumettre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div id="editCongeModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeEditCongeModal()"></div>
        <div class="relative bg-white w-full max-w-2xl rounded-[32px] shadow-2xl border border-slate-100 overflow-hidden flex flex-col max-h-[92vh] z-10" style="animation: modalIn .2s ease-out">
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Modifier la Demande</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Demande #<span id="edit-id-text"></span></p>
                </div>
                <button type="button" onclick="closeEditCongeModal()" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] hover:border-[#be2346]/30 transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="overflow-y-auto">
                <form id="editCongeForm" method="POST" enctype="multipart/form-data" class="p-7 space-y-5">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Type de Congé <span class="text-[#be2346]">*</span></label>
                        <select name="type" id="edit-type" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            <option value="annuel">Annuel</option>
                            <option value="maladie">Maladie</option>
                            <option value="sans_solde">Sans Solde</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date Début <span class="text-[#be2346]">*</span></label>
                            <input type="date" name="dateDebut" id="edit-dateDebut" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date Fin <span class="text-[#be2346]">*</span></label>
                            <input type="date" name="dateFin" id="edit-dateFin" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Raison (Motif)</label>
                        <textarea name="motif" id="edit-motif" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5"></textarea>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Justification (Fichier)</label>
                        <div class="relative group">
                            <input type="file" name="justification" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="updateFileNameEdit(this)">
                            <div class="w-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl px-4 py-5 flex items-center justify-center gap-3 transition-all group-hover:border-[#be2346]/30 group-hover:bg-[#be2346]/5">
                                <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-[#be2346] group-hover:border-[#be2346]/20 transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-bold text-slate-600 group-hover:text-[#be2346] transition-all" id="fileNameDisplayEdit">Modifier le fichier</p>
                                    <p class="text-[10px] text-slate-400 font-medium">Laissez vide pour conserver l'ancien</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="closeEditCongeModal()" class="flex-1 py-4 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm">Annuler</button>
                        <button type="submit" class="flex-1 py-4 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-[#be2346]/20 text-sm">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div id="showCongeDetailsModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeCongeDetailsModal()"></div>
        <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl border border-slate-200 overflow-hidden flex flex-col max-h-[92vh] z-10" style="animation: modalIn .2s ease-out">
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Détails de la Demande</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Demande #<span id="detail-id"></span></p>
                </div>
                <button type="button" onclick="closeCongeDetailsModal()" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#b11d40] hover:border-[#b11d40]/30 transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="p-7 space-y-4 text-sm text-slate-700 flex-1 overflow-y-scroll min-h-0 custom-scrollbar" id="detail-body">
                <div class="flex items-center gap-3 mb-6 bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg shrink-0" id="detail-avatar">
                        E
                    </div>
                    <div>
                        <p class="font-black text-slate-800" id="detail-employe">Employé Name</p>
                        <p class="text-xs text-slate-500 font-medium">Créée le <span id="detail-dateDemande">...</span></p>
                    </div>
                    <div class="ml-auto" id="detail-status">
                        <!-- Statut injecté ici -->
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-3">
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Date Début</p>
                        <p class="font-bold text-slate-800 mt-1" id="detail-dateDebut">...</p>
                    </div>
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-3">
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Date Fin</p>
                        <p class="font-bold text-slate-800 mt-1" id="detail-dateFin">...</p>
                    </div>
                </div>

                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Type</p>
                    <p class="font-bold text-slate-800 mt-1 capitalize" id="detail-type">...</p>
                </div>

                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Motif</p>
                    <p class="text-slate-600 mt-1" id="detail-motif">...</p>
                </div>

                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Justification</p>
                    <p class="text-slate-600 mt-1 break-words" id="detail-justification">
                        <!-- Lien ou nom du fichier -->
                    </p>
                </div>
                
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Solde</p>
                    <p class="text-slate-600 mt-1" id="detail-sold">...</p>
                </div>
            </div>
            <div class="px-7 py-5 border-t border-slate-100 bg-slate-50/60 flex items-center justify-end shrink-0">
                <button type="button" onclick="closeCongeDetailsModal()" class="px-5 py-2.5 rounded-xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-white hover:text-slate-600 transition-all text-sm shadow-sm">
                    Fermer
                </button>
            </div>
        </div>
    </div>




    <script>
        let debounceTimer;

        function debounceFilter() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetchFilteredConges();
            }, 400);
        }

        function fetchFilteredConges() {
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            const type = document.getElementById('typeFilter').value;
            
            const container = document.getElementById('conges-table-body');
            container.style.opacity = '0.5';

            let url = `<?php echo e(route('conge.index')); ?>?search=${encodeURIComponent(search)}&status=${status}&type=${type}`;

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
                container.style.opacity = '1';
            })
            .catch(error => {
                console.error('Error fetching filtered conges:', error);
                container.style.opacity = '1';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('typeFilter').value = '';
            fetchFilteredConges();
        }

        // Modals Toggle Functions
        function openCongeModal() {
            document.getElementById('addCongeModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeCongeModal() {
            document.getElementById('addCongeModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        function closeCongeDetailsModal() {
            document.getElementById('showCongeDetailsModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        function closeEditCongeModal() {
            document.getElementById('editCongeModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        function confirmDeleteConge(id, url) {
            window.confirmDelete(url, 'demande de congé');
        }

        // JS Logic for Editing
        function openEditCongeModal(id) {
            document.getElementById('editCongeModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            document.getElementById('edit-id-text').innerText = id;
            document.getElementById('edit-motif').value = "Chargement...";
            
            let updateUrl = `<?php echo e(url('conge/update')); ?>/${id}`;
            document.getElementById('editCongeForm').action = updateUrl;

            fetch(`/conge/${id}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if(!response.ok) throw new Error("Erreur réseau");
                return response.json();
            })
            .then(data => {
                document.getElementById('edit-type').value = data.type;
                document.getElementById('edit-dateDebut').value = data.dateDebut;
                document.getElementById('edit-dateFin').value = data.dateFin;
                document.getElementById('edit-motif').value = data.motif || '';
            })
            .catch(error => {
                console.error("Erreur de récupération :", error);
                document.getElementById('edit-motif').value = "";
            });
        }

        // Vanilla JS AJAX Fetch for Details Pop-up
        function openShowCongeModal(id) {
            // Afficher le modal avec un état de chargement léger
            document.getElementById('showCongeDetailsModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            document.getElementById('detail-id').innerText = id;
            document.getElementById('detail-employe').innerText = "Chargement...";
            document.getElementById('detail-avatar').innerText = "...";
            document.getElementById('detail-dateDemande').innerText = "...";
            document.getElementById('detail-dateDebut').innerText = "...";
            document.getElementById('detail-dateFin').innerText = "...";
            document.getElementById('detail-type').innerText = "...";
            document.getElementById('detail-motif').innerText = "Chargement...";
            document.getElementById('detail-sold').innerText = "Chargement...";
            document.getElementById('detail-justification').innerHTML = "Chargement...";
            document.getElementById('detail-status').innerHTML = "";

            fetch(`/conge/${id}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if(!response.ok) throw new Error("Erreur réseau");
                return response.json();
            })
            .then(data => {
                const conge = data;
                let empName = 'Employé Inconnu';
                let initials = 'E';
                
                if (conge.user) {
                    const first = conge.user.firstName || '';
                    const last = conge.user.lastName || '';
                    empName = (first + ' ' + last).trim() || 'Employé Inconnu';
                    
                    if (first && last) {
                        initials = first.charAt(0).toUpperCase() + last.charAt(0).toUpperCase();
                    } else if (empName !== 'Employé Inconnu') {
                        initials = empName.charAt(0).toUpperCase();
                    }
                }
                
                document.getElementById('detail-employe').innerText = empName;
                document.getElementById('detail-avatar').innerText = initials;
                
                document.getElementById('detail-dateDemande').innerText = conge.dateDemande || '-';
                document.getElementById('detail-dateDebut').innerText = conge.dateDebut || '-';
                document.getElementById('detail-dateFin').innerText = conge.dateFin || '-';
                
                let typeStr = conge.type ? conge.type.replace('_', ' ') : '-';
                document.getElementById('detail-type').innerText = typeStr;
                
                document.getElementById('detail-motif').innerText = conge.motif || 'Aucun motif fourni.';
                document.getElementById('detail-sold').innerText = conge.sold !== null ? conge.sold : 'Non renseigné';
                
                if (conge.justification) {
                    document.getElementById('detail-justification').innerHTML = `<a href="/storage/${conge.justification}" target="_blank" class="text-blue-500 hover:underline">Voir le fichier joint</a>`;
                } else {
                    document.getElementById('detail-justification').innerText = "Aucun fichier joint.";
                }

                let badge = '';
                if(conge.status === 'approuve') {
                    badge = `<span class="bg-emerald-50 text-emerald-600 font-bold px-3 py-1 rounded-full text-xs border border-emerald-200">Approuvé</span>`;
                } else if(conge.status === 'refuse') {
                    badge = `<span class="bg-red-50 text-red-600 font-bold px-3 py-1 rounded-full text-xs border border-red-200">Refusé</span>`;
                } else {
                    badge = `<span class="bg-amber-50 text-amber-600 font-bold px-3 py-1 rounded-full text-xs border border-amber-200">En attente</span>`;
                }
                document.getElementById('detail-status').innerHTML = badge;
            })
            .catch(error => {
                console.error("Erreur lors de la récupération des détails :", error);
                document.getElementById('detail-motif').innerText = "Erreur lors du chargement des détails.";
            });
        }
        
        // Update file name display
        function updateFileName(input) {
            const display = document.getElementById('fileNameDisplay');
            if (input.files && input.files.length > 0) {
                display.innerText = input.files[0].name;
                display.classList.remove('text-slate-600');
                display.classList.add('text-[#be2346]');
            } else {
                display.innerText = 'Choisir un fichier';
                display.classList.remove('text-[#be2346]');
                display.classList.add('text-slate-600');
            }
        }

        function updateFileNameEdit(input) {
            const display = document.getElementById('fileNameDisplayEdit');
            if (input.files && input.files.length > 0) {
                display.innerText = input.files[0].name;
                display.classList.remove('text-slate-600');
                display.classList.add('text-[#be2346]');
            } else {
                display.innerText = 'Modifier le fichier';
                display.classList.remove('text-[#be2346]');
                display.classList.add('text-slate-600');
            }
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
<?php endif; ?>
<?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/conges/index.blade.php ENDPATH**/ ?>