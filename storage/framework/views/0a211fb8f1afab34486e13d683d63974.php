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
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Planification des Réunions</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Gérez vos rendez-vous internes et externes.</p>
            </div>
            <?php if(auth()->user()->type !== 'employee'): ?>
            <button onclick="toggleModal('addReunionModal', 'open')" class="flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter
            </button>
            <?php endif; ?>
        </div>
        <script>
            function fetchMeetings() {
                const search = document.getElementById('searchInput').value;
                const type = document.getElementById('typeFilter').value;
                const dept = document.getElementById('deptFilter').value;
                const cardsContainer = document.getElementById('cards-container');
                
                const url = `<?php echo e(route('reunions.index')); ?>?search=${encodeURIComponent(search)}&idDepartement=${dept}&type=${type}`;
                
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => res.text())
                    .then(html => {
                        cardsContainer.innerHTML = html;
                    })
                    .catch(err => console.error('Error:', err));
            }

            let searchTimeout = null;
            function debounceSearch() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(fetchMeetings, 400);
            }

            function resetFilters() {
                document.getElementById('searchInput').value = '';
                document.getElementById('typeFilter').value = '';
                document.getElementById('deptFilter').value = '';
                fetchMeetings();
            }
        </script>

        
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4 mb-6">
            <form onsubmit="return false;" class="flex flex-wrap items-center gap-4">
                
                <div class="flex-1 min-w-[280px] relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="searchInput" oninput="debounceSearch()" 
                        placeholder="Rechercher par titre, lieu..." 
                        class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-2xl text-sm transition-all focus:border-[#b11d40]/40 focus:ring-4 focus:ring-[#b11d40]/10 outline-none">
                </div>

                
                <div class="flex flex-wrap items-center gap-3">
                    
                    <div class="relative">
                        <select id="typeFilter" onchange="fetchMeetings()" 
                            class="appearance-none bg-white border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 text-xs font-bold text-slate-600 outline-none focus:border-[#b11d40]/40 focus:ring-4 focus:ring-[#b11d40]/10 transition-all cursor-pointer">
                            <option value="">Format (Tous)</option>
                            <option value="Interne">Interne</option>
                            <option value="Externe">Externe</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>

                    
                    <div class="relative">
                        <select id="deptFilter" onchange="fetchMeetings()" 
                            class="appearance-none bg-white border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 text-xs font-bold text-slate-600 outline-none focus:border-[#b11d40]/40 focus:ring-4 focus:ring-[#b11d40]/10 transition-all cursor-pointer">
                            <option value="">Département (Tous)</option>
                            <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($d->idDepartement); ?>"><?php echo e($d->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>

                    
                    <button type="button" onclick="resetFilters()" 
                        class="p-3 rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-all flex items-center justify-center" 
                        title="Réinitialiser les filtres">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden p-6">
            <h2 class="text-lg font-extrabold text-slate-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Liste des Réunions
            </h2>
            <div class="space-y-4" id="cards-container">
                <?php echo $__env->make('reunions.partials.cards', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </div>

    

    
    <div id="addReunionModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="toggleModal('addReunionModal', 'close')"></div>
        <div class="relative bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden flex flex-col max-h-[92vh] z-10 animate-modal-in">
            
            
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Planifier une Réunion</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Nouvel événement · Access Morocco</p>
                </div>
                <button type="button" onclick="toggleModal('addReunionModal', 'close')"
                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] hover:border-[#be2346]/30 transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            
            <div class="overflow-y-auto">
                <form action="<?php echo e(url('/reunions')); ?>" method="POST" class="p-7 space-y-5">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Titre de la réunion <span class="text-[#be2346]">*</span></label>
                            <input type="text" name="titre" required placeholder="Ex: Revue de projet hebdomadaire" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Type <span class="text-[#be2346]">*</span></label>
                            <select name="type" id="add_type" required onchange="toggleLienField('add')" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                <option value="Interne">Interne</option>
                                <option value="Externe">Externe</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>
                        <div class="md:col-span-2 space-y-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Type d'Invitation <span class="text-[#be2346]">*</span></label>
                            <div class="flex flex-wrap gap-4">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="invitation_type" value="all" checked onchange="toggleInvitationFields('add')" class="w-4 h-4 text-[#be2346] focus:ring-[#be2346]">
                                    <span class="text-sm font-bold text-slate-600 group-hover:text-slate-900">Tout les employés</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="invitation_type" value="department" onchange="toggleInvitationFields('add')" class="w-4 h-4 text-[#be2346] focus:ring-[#be2346]">
                                    <span class="text-sm font-bold text-slate-600 group-hover:text-slate-900">Par département</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="invitation_type" value="individual" onchange="toggleInvitationFields('add')" class="w-4 h-4 text-[#be2346] focus:ring-[#be2346]">
                                    <span class="text-sm font-bold text-slate-600 group-hover:text-slate-900">Individuel</span>
                                </label>
                            </div>
                        </div>

                        <div id="add_dept_field" class="hidden space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Département <span class="text-[#be2346]">*</span></label>
                            <select name="idDepartement" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                <option value="">-- Sélectionner --</option>
                                <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($dept->idDepartement); ?>"><?php echo e($dept->title ?? $dept->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div id="add_individual_field" class="hidden md:col-span-2 space-y-3">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 text-left block">Sélectionner les employés <span class="text-[#be2346]">*</span></label>
                            <div class="relative">
                                <input type="text" placeholder="Rechercher un employé..." onkeyup="filterUsers(this, 'add_user_list')" class="w-full bg-slate-50 border border-slate-200 rounded-t-2xl px-4 py-3 text-sm outline-none focus:border-[#be2346] transition-all">
                                <div id="add_user_list" class="max-h-48 overflow-y-auto border-x border-b border-slate-200 rounded-b-2xl bg-white p-2 grid grid-cols-1 md:grid-cols-2 gap-2 scrollbar-hide">
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="user-item flex items-center gap-3 p-2 hover:bg-slate-50 rounded-xl cursor-pointer transition-colors border border-transparent hover:border-slate-100">
                                            <input type="checkbox" name="participant_ids[]" value="<?php echo e($user->idUser); ?>" class="w-4 h-4 text-[#be2346] rounded focus:ring-[#be2346]">
                                            <div class="flex flex-col">
                                                <span class="text-xs font-black text-slate-700"><?php echo e($user->firstName); ?> <?php echo e($user->lastName); ?></span>
                                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tight"><?php echo e($user->post); ?></span>
                                            </div>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date et Heure <span class="text-[#be2346]">*</span></label>
                            <input type="datetime-local" name="dateHeure" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Heure de fin</label>
                            <input type="time" name="heureFin" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Lieu / Salle</label>
                            <input type="text" name="lieu" placeholder="Ex: Salle A" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>
                        <div class="space-y-1.5" id="add_lien_container">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Lien Visioconférence</label>
                            <input type="url" name="lien" placeholder="Ex: https://meet..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Objectif <span class="text-[#be2346]">*</span></label>
                            <input type="text" name="objectif" required placeholder="But principal..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Description</label>
                            <textarea name="description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5"></textarea>
                        </div>
                    </div>

                    
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="toggleModal('addReunionModal', 'close')"
                            class="flex-1 py-4 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm">
                            Annuler
                        </button>
                        <button type="submit"
                            class="flex-1 py-4 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-[#be2346]/20 text-sm">
                            Planifier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div id="editReunionModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('editReunionModal', 'close')"></div>
        <div class="relative bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden flex flex-col max-h-[92vh] z-10 animate-modal-in">
            
            
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Modifier la Réunion</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Édition · Access Morocco</p>
                </div>
                <button type="button" onclick="toggleModal('editReunionModal', 'close')"
                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            
            <div class="overflow-y-auto">
                <form id="editReunionForm" method="POST" class="p-7 space-y-5">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Titre de la réunion *</label>
                            <input type="text" name="titre" id="edit_titre" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Type *</label>
                            <select name="type" id="edit_type" required onchange="toggleLienField('edit')" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                <option value="Interne">Interne</option>
                                <option value="Externe">Externe</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>

                        <div class="md:col-span-2 space-y-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Type d'Invitation <span class="text-[#be2346]">*</span></label>
                            <div class="flex flex-wrap gap-4">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="invitation_type" id="edit_invitation_all" value="all" onchange="toggleInvitationFields('edit')" class="w-4 h-4 text-[#be2346] focus:ring-[#be2346]">
                                    <span class="text-sm font-bold text-slate-600 group-hover:text-slate-900">Tout les employés</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="invitation_type" id="edit_invitation_department" value="department" onchange="toggleInvitationFields('edit')" class="w-4 h-4 text-[#be2346] focus:ring-[#be2346]">
                                    <span class="text-sm font-bold text-slate-600 group-hover:text-slate-900">Par département</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="invitation_type" id="edit_invitation_individual" value="individual" onchange="toggleInvitationFields('edit')" class="w-4 h-4 text-[#be2346] focus:ring-[#be2346]">
                                    <span class="text-sm font-bold text-slate-600 group-hover:text-slate-900">Individuel</span>
                                </label>
                            </div>
                        </div>

                        <div id="edit_dept_field" class="hidden space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Département <span class="text-[#be2346]">*</span></label>
                            <select name="idDepartement" id="edit_idDepartement" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                <option value="">-- Sélectionner --</option>
                                <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($dept->idDepartement); ?>"><?php echo e($dept->title ?? $dept->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div id="edit_individual_field" class="hidden md:col-span-2 space-y-3">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 text-left block">Sélectionner les employés <span class="text-[#be2346]">*</span></label>
                            <div class="relative">
                                <input type="text" placeholder="Rechercher un employé..." onkeyup="filterUsers(this, 'edit_user_list')" class="w-full bg-slate-50 border border-slate-200 rounded-t-2xl px-4 py-3 text-sm outline-none focus:border-[#be2346] transition-all">
                                <div id="edit_user_list" class="max-h-48 overflow-y-auto border-x border-b border-slate-200 rounded-b-2xl bg-white p-2 grid grid-cols-1 md:grid-cols-2 gap-2 scrollbar-hide">
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="user-item flex items-center gap-3 p-2 hover:bg-slate-50 rounded-xl cursor-pointer transition-colors border border-transparent hover:border-slate-100">
                                            <input type="checkbox" name="participant_ids[]" value="<?php echo e($user->idUser); ?>" class="edit-user-checkbox w-4 h-4 text-[#be2346] rounded focus:ring-[#be2346]">
                                            <div class="flex flex-col">
                                                <span class="text-xs font-black text-slate-700"><?php echo e($user->firstName); ?> <?php echo e($user->lastName); ?></span>
                                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tight"><?php echo e($user->post); ?></span>
                                            </div>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date et Heure *</label>
                            <input type="datetime-local" name="dateHeure" id="edit_dateHeure" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Heure de fin</label>
                            <input type="time" name="heureFin" id="edit_heureFin" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Lieu / Salle</label>
                            <input type="text" name="lieu" id="edit_lieu" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>

                        <div class="space-y-1.5" id="edit_lien_container">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Lien Visioconférence</label>
                            <input type="url" name="lien" id="edit_lien" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>

                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Objectif *</label>
                            <input type="text" name="objectif" id="edit_objectif" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>

                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Description</label>
                            <textarea name="description" id="edit_description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5"></textarea>
                        </div>
                    </div>

                    
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="toggleModal('editReunionModal', 'close')"
                            class="flex-1 py-3.5 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm">
                            Annuler
                        </button>
                        <button type="submit"
                            class="flex-1 py-3.5 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-[#be2346]/20 text-sm">
                            Sauvegarder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <script>
        function toggleLienField(mode) {
            const typeSelect = document.getElementById(mode + '_type');
            const container = document.getElementById(mode + '_lien_container');
            if (!typeSelect || !container) return;

            if (typeSelect.value === 'Interne') {
                container.style.display = 'none';
            } else {
                container.style.display = 'block';
            }
        }

        function toggleModal(id, action = 'toggle') {
            const modal = document.getElementById(id);
            if (!modal) return;

            const isHidden = modal.classList.contains('hidden');
            const shouldOpen = action === 'open' || (action === 'toggle' && isHidden);

            if (shouldOpen) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
                if (id === 'addReunionModal') toggleLienField('add');
                if (id === 'editReunionModal') toggleLienField('edit');
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }
        }
    </script>

    
    <div id="viewReunionModal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeReunionModal()"></div>
        <div class="relative bg-white w-11/12 md:max-w-lg rounded-[40px] shadow-2xl overflow-hidden flex flex-col z-10 animate-modal-in border border-white/20 max-h-[90vh]">
            
            
            <div class="overflow-y-auto p-8 md:p-10 scrollbar-hide">
                <div class="flex justify-between items-start mb-8">
                    <div id="modal_reunion_type_badge" class="px-4 py-1.5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-sm"></div>
                    <button onclick="closeReunionModal()" class="w-10 h-10 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 hover:text-gray-900 hover:bg-gray-100 transition-all active:scale-90">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <h3 id="modal_reunion_title" class="text-3xl font-black text-gray-900 mb-2 leading-tight"></h3>
                <p id="modal_reunion_objectif" class="text-sm font-bold text-[#be2346] mb-8 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#be2346] animate-pulse"></span>
                    <span id="objectif_text"></span>
                </p>

                <div class="space-y-6 mb-10">
                    <div class="flex items-center gap-5 p-4 bg-gray-50 rounded-3xl border border-transparent hover:border-gray-100 transition-all">
                        <div class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center text-[#be2346]">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Date & Heure de début</p>
                            <p id="modal_reunion_date" class="text-sm font-black text-gray-900"></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-5 p-4 bg-gray-50 rounded-3xl border border-transparent hover:border-gray-100 transition-all">
                        <div class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center text-[#be2346]">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Lieu de la réunion</p>
                            <p id="modal_reunion_lieu" class="text-sm font-black text-gray-900"></p>
                        </div>
                    </div>

                    
                    <div id="modal_reunion_desc_container" class="p-4 bg-slate-50 rounded-3xl">
                         <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Description</p>
                         <p id="modal_reunion_description" class="text-xs text-gray-600 leading-relaxed font-medium"></p>
                    </div>

                    <div id="modal_reunion_link_container" class="hidden">
                        <a id="modal_reunion_link" href="#" target="_blank" class="flex items-center justify-between p-5 bg-gray-900 rounded-[24px] text-white hover:bg-[#be2346] transition-all group shadow-xl shadow-gray-900/10">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition-colors">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                </div>
                                <span class="text-sm font-black uppercase tracking-[0.1em]">Rejoindre la réunion</span>
                            </div>
                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>

                <div class="flex gap-4 pb-4">
                    <button onclick="closeReunionModal()" class="flex-1 py-5 bg-gray-100 hover:bg-gray-200 rounded-[24px] text-xs font-black text-gray-500 transition-all active:scale-95 uppercase tracking-widest">Fermer</button>
                    <a id="modal_view_full" href="#" class="flex-1 py-5 bg-[#be2346] hover:bg-[#a01d3a] rounded-[24px] text-xs font-black text-white text-center transition-all shadow-xl shadow-[#be2346]/20 active:scale-95 uppercase tracking-widest">Voir plus</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewReunionDetails(reunionData) {
            let reunion = typeof reunionData === 'string' ? JSON.parse(reunionData) : reunionData;
            const modal = document.getElementById('viewReunionModal');
            if (!modal) return;

            document.getElementById('modal_reunion_title').textContent = reunion.titre || 'Sans titre';
            document.getElementById('objectif_text').textContent = reunion.objectif || 'Aucun objectif spécifié';
            let defaultLieu = 'Visioconférence';
            if (reunion.type === 'Interne') defaultLieu = 'Enterprise';
            else if (reunion.type === 'Externe') defaultLieu = 'Meeting online';
            
            document.getElementById('modal_reunion_lieu').textContent = reunion.lieu || defaultLieu;
            
            // Description
            const descContainer = document.getElementById('modal_reunion_desc_container');
            const descText = document.getElementById('modal_reunion_description');
            if (reunion.description) {
                descContainer.classList.remove('hidden');
                descText.textContent = reunion.description;
            } else {
                descContainer.classList.add('hidden');
            }

            // Format Date
            if (reunion.dateHeure) {
                const date = new Date(reunion.dateHeure);
                const formattedDate = date.toLocaleDateString('fr-FR', { 
                    weekday: 'long', 
                    day: 'numeric', 
                    month: 'long', 
                    year: 'numeric',
                    hour: '2-digit', 
                    minute: '2-digit' 
                });
                document.getElementById('modal_reunion_date').textContent = formattedDate;
            }

            // Badge
            const badge = document.getElementById('modal_reunion_type_badge');
            if (badge) {
                badge.textContent = reunion.type || 'Interne';
                if (reunion.type === 'Interne') {
                    badge.className = 'px-4 py-1.5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] bg-slate-100 text-slate-600 border border-slate-200';
                } else {
                    badge.className = 'px-4 py-1.5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] bg-indigo-50 text-indigo-600 border border-indigo-100';
                }
            }

            // Link
            const linkContainer = document.getElementById('modal_reunion_link_container');
            const link = document.getElementById('modal_reunion_link');
            if (reunion.lien) {
                linkContainer.classList.remove('hidden');
                let url = reunion.lien;
                if (!url.startsWith('http')) {
                    url = 'https://' + url;
                }
                link.href = url;
            } else {
                linkContainer.classList.add('hidden');
            }

            // Full View Link
            const fullView = document.getElementById('modal_view_full');
            if (fullView) {
                fullView.href = `/reunions/${reunion.idReunion}`;
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeReunionModal() {
            const modal = document.getElementById('viewReunionModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function toggleInvitationFields(prefix) {
            const form = prefix === 'add' ? document.querySelector('#addReunionModal form') : document.getElementById('editReunionForm');
            const checkedRadio = form.querySelector('input[name="invitation_type"]:checked');
            const currentType = checkedRadio ? checkedRadio.value : 'all';

            const deptField = document.getElementById(`${prefix}_dept_field`);
            const individualField = document.getElementById(`${prefix}_individual_field`);

            if (deptField) deptField.classList.add('hidden');
            if (individualField) individualField.classList.add('hidden');

            if (currentType === 'department' && deptField) {
                deptField.classList.remove('hidden');
            } else if (currentType === 'individual' && individualField) {
                individualField.classList.remove('hidden');
            }
        }

        function filterUsers(input, listId) {
            const filter = input.value.toLowerCase();
            const list = document.getElementById(listId);
            const items = list.getElementsByClassName('user-item');

            for (let i = 0; i < items.length; i++) {
                const text = items[i].textContent.toLowerCase();
                if (text.includes(filter)) {
                    items[i].style.display = "";
                } else {
                    items[i].style.display = "none";
                }
            }
        }

        function openEditModal(reunion) {
            const form = document.getElementById('editReunionForm');
            form.action = `/reunions/${reunion.idReunion}`;
            
            document.getElementById('edit_titre').value = reunion.titre || '';
            document.getElementById('edit_type').value = reunion.type || 'Interne';
            
            // Invitation Type Logic
            if (reunion.idDepartement) {
                document.getElementById('edit_invitation_department').checked = true;
                document.getElementById('edit_idDepartement').value = reunion.idDepartement;
            } else if (reunion.participants && reunion.participants.length > 0) {
                document.getElementById('edit_invitation_individual').checked = true;
                // Check the checkboxes
                const participantIds = reunion.participants.map(p => p.idUser);
                document.querySelectorAll('.edit-user-checkbox').forEach(cb => {
                    cb.checked = participantIds.includes(parseInt(cb.value));
                });
            } else {
                document.getElementById('edit_invitation_all').checked = true;
            }
            toggleInvitationFields('edit');
            
            // Precise date/time conversion for datetime-local
            if (reunion.dateHeure) {
                const d = new Date(reunion.dateHeure);
                const offset = d.getTimezoneOffset() * 60000;
                const localISOTime = (new Date(d.getTime() - offset)).toISOString().slice(0, 16);
                document.getElementById('edit_dateHeure').value = localISOTime;
            }
            
            document.getElementById('edit_heureFin').value = reunion.heureFin || '';
            document.getElementById('edit_lieu').value = reunion.lieu || '';
            document.getElementById('edit_lien').value = reunion.lien || '';
            document.getElementById('edit_objectif').value = reunion.objectif || '';
            document.getElementById('edit_description').value = reunion.description || '';
            
            toggleLienField('edit');
            toggleModal('editReunionModal', 'open');
        }

        function confirmDeleteReunion(id) {
            window.confirmDelete(`/reunions/${id}`, 'réunion');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                toggleModal('addReunionModal', 'close');
                toggleModal('editReunionModal', 'close');
            }
        });
    </script>

    
    <style>
        @keyframes modal-in {
            from { opacity: 0; transform: scale(0.95) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-modal-in { animation: modal-in 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
    </style>
    

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

<?php /**PATH C:\Users\dell\Desktop\PROJECTS\AccesMorrocco\resources\views/reunions/index.blade.php ENDPATH**/ ?>