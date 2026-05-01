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
    <style>
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(-20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
    </style>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Ressources Humaines</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Gestion des effectifs et des talents Access Morocco.
                </p>
            </div>

            <button onclick="toggleModal('addUserModal')"
                class="flex items-center gap-2 bg-[#be2346] hover:bg-[#a01d3a] text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#be2346]/10 active:scale-95 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter un Employé
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest">Effectif Total</p>
                    <span class="p-2 bg-slate-50 rounded-lg text-slate-400">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </span>
                </div>
                <h3 class="text-3xl font-bold mt-2 text-slate-800"><?php echo e($stats['total']); ?></h3>
            </div>

            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm border-l-4 border-l-[#be2346]">
                <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest">En Congé</p>
                <h3 class="text-3xl font-bold mt-2 text-[#be2346]"><?php echo e($stats['conge']); ?></h3>
            </div>

            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
                <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest">Consultants</p>
                <h3 class="text-3xl font-bold mt-2 text-blue-600">
                    <?php echo e($stats['freelance']); ?></h3>
            </div>
        </div>

        <div class="px-7 pt-6">
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
        </div>

        
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4 mb-6">
            <form id="filterForm" class="flex flex-wrap items-center gap-4">
                
                <div class="flex-1 min-w-[280px] relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="searchInput" placeholder="Rechercher par nom, email, poste..." 
                        class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-2xl text-sm transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 outline-none">
                </div>

                
                <div class="flex flex-wrap items-center gap-3">
                    <div class="relative">
                        <select name="poste" class="appearance-none bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 text-xs font-bold text-slate-600 outline-none focus:border-[#be2346] transition-all cursor-pointer">
                            <option value="">Poste (Tous)</option>
                            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($post); ?>"><?php echo e($post); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>

                    <div class="relative">
                        <select name="type" class="appearance-none bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 text-xs font-bold text-slate-600 outline-none focus:border-[#be2346] transition-all cursor-pointer">
                            <option value="">Rôle (Tous)</option>
                            <option value="employee">Employé</option>
                            <option value="manager">Manager</option>
                            <option value="admin">Admin</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>

                    <div class="relative">
                        <select name="typeContrat" class="appearance-none bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 text-xs font-bold text-slate-600 outline-none focus:border-[#be2346] transition-all cursor-pointer">
                            <option value="">Contrat (Tous)</option>
                            <option value="CD">CDI</option>
                            <option value="CI">CI</option>
                            <option value="freelance">Freelance</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>

                    <div class="relative">
                        <select name="departement" class="appearance-none bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 text-xs font-bold text-slate-600 outline-none focus:border-[#be2346] transition-all cursor-pointer">
                            <option value="">Département (Tous)</option>
                            <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($dept->idDepartement); ?>"><?php echo e($dept->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>

                    <button type="button" id="resetFilters" class="p-3 rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-all flex items-center justify-center" title="Réinitialiser les filtres">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    </button>
                </div>
            </form>
        </div>

        
        <div id="tableContainer" class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden mb-8 relative">
            
            <div id="loadingOverlay" class="absolute inset-0 bg-white/60 backdrop-blur-[1px] z-10 hidden items-center justify-center transition-all duration-300">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-8 h-8 border-4 border-[#be2346]/20 border-t-[#be2346] rounded-full animate-spin"></div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Mise à jour...</span>
                </div>
            </div>

            <div id="usersTable">
                <?php echo $__env->make('partials._user_table', ['users' => $users], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>

        <script>
            function openDeptModal() {
                const modal = document.getElementById('addUserModal');
                if (modal) {
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeDeptModal() {
                const modal = document.getElementById('addUserModal');
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeDeptModal();
                }
            });
        </script>

        <div id="addUserModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('addUserModal')"></div>
            <div class="relative flex items-center justify-center min-h-screen p-4">
                <div class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden flex flex-col max-h-[92vh] z-10" style="animation: modalIn .2s ease-out">
                    
                    
                    <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                        <div>
                            <h2 class="text-lg font-black text-slate-800">Nouveau Collaborateur</h2>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Fiche de création · Access Morocco</p>
                        </div>
                        <button type="button" onclick="toggleModal('addUserModal')"
                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] hover:border-[#be2346]/30 transition-all">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    
                    <div class="overflow-y-auto">
                        <form action="<?php echo e(route('users.store')); ?>" method="POST" class="p-7 space-y-5">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="fichier" value="placeholder">
                            <input type="hidden" name="rip" value="placeholder">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Prénom *</label>
                                    <input type="text" name="firstName" required placeholder="Ex: Jean" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Nom *</label>
                                    <input type="text" name="lastName" required placeholder="Ex: Dupont" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Adresse Email *</label>
                                    <input type="email" name="email" required placeholder="email@exemple.com" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Mot de passe *</label>
                                    <input type="password" name="password" required value="12345678" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">CIN *</label>
                                    <input type="text" name="cin" required placeholder="Ex: AB12345" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Poste occupé</label>
                                    <input type="text" name="post" placeholder="Ex: Développeur Full Stack" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Téléphone *</label>
                                    <input type="text" name="phoneNumber" required placeholder="06..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date de naissance *</label>
                                    <input type="date" name="birthday" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Salaire (MAD) *</label>
                                    <input type="number" name="salaire" required placeholder="Ex: 8000" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Rôle Système *</label>
                                    <select name="type" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                        <option value="" disabled selected>— Sélectionner un rôle —</option>
                                        <option value="employee">Employé</option>
                                        <option value="manager">Manager</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Type de Contrat *</label>
                                    <select name="typeContrat" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                        <option value="CD">CDI</option>
                                        <option value="CI">CI</option>
                                        <option value="freelance">Freelance</option>
                                    </select>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Statut *</label>
                                    <select name="status" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                        <option value="active" selected>Actif</option>
                                        <option value="desactive">Désactivé</option>
                                        <option value="conge">En Congé</option>
                                    </select>
                                </div>

                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Département Affecté *</label>
                                    <select name="idDepartement" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                        <option value="" disabled selected>— Choisir un département —</option>
                                        <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $deptManager = $dept->manager ? trim($dept->manager->firstName . ' ' . $dept->manager->lastName) : ''; ?>
                                            <option value="<?php echo e($dept->idDepartement); ?>" data-current-manager="<?php echo e(htmlspecialchars($deptManager, ENT_QUOTES)); ?>"><?php echo e($dept->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            
                            <div class="flex gap-3 pt-4">
                                <button type="button" onclick="toggleModal('addUserModal')"
                                    class="flex-1 py-3.5 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm">
                                    Annuler
                                </button>
                                <button type="submit"
                                    class="flex-1 py-3.5 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-[#be2346]/20 text-sm">
                                    Confirmer l'ajout
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="viewUserModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-md" onclick="toggleModal('viewUserModal')"></div>
            <div class="relative flex items-center justify-center min-h-screen p-6">
                <div class="bg-white w-full max-w-3xl rounded-[24px] shadow-2xl overflow-hidden border border-slate-200">
                    
                    <!-- Professional Header -->
                    <div class="bg-slate-50 border-b border-slate-100 px-8 py-6 flex items-center justify-between">
                        <div class="flex items-center gap-5">
                            <div id="view_avatar" class="w-16 h-16 rounded-full bg-white shadow-sm border border-slate-200 flex items-center justify-center text-xl font-bold text-[#be2346]"></div>
                            <div>
                                <h2 id="view_fullName" class="text-xl font-bold text-slate-800 tracking-tight leading-tight"></h2>
                                <div class="flex items-center gap-2 mt-1">
                                    <span id="view_status" class="px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-wider"></span>
                                    <span class="text-slate-300">|</span>
                                    <span id="view_type_label" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"></span>
                                </div>
                            </div>
                        </div>
                        <button onclick="toggleModal('viewUserModal')" class="p-2 rounded-xl hover:bg-slate-200/50 text-slate-400 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            
                            <!-- Column 1: Identification -->
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] mb-4 flex items-center gap-2">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                        Identification
                                    </h3>
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-[10px] text-slate-400 font-medium mb-0.5">Email Professionnel</p>
                                            <p id="view_email" class="text-sm font-semibold text-slate-700 break-all"></p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-slate-400 font-medium mb-0.5">CIN / ID</p>
                                            <p id="view_cin" class="text-sm font-semibold text-slate-700"></p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-slate-400 font-medium mb-0.5">Date de Naissance</p>
                                            <p id="view_birthday" class="text-sm font-semibold text-slate-700"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Column 2: Carrière -->
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] mb-4 flex items-center gap-2">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                        Parcours
                                    </h3>
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-[10px] text-slate-400 font-medium mb-0.5">Poste Actuel</p>
                                            <p id="view_post" class="text-sm font-semibold text-slate-700"></p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-slate-400 font-medium mb-0.5">Département</p>
                                            <p id="view_dept" class="text-sm font-semibold text-[#be2346]"></p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-slate-400 font-medium mb-0.5">Date d'Embauche</p>
                                            <p id="view_dateEmb" class="text-sm font-semibold text-slate-700"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Column 3: Contrat & Contact -->
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] mb-4 flex items-center gap-2">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        Conditions
                                    </h3>
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-[10px] text-slate-400 font-medium mb-0.5">Contrat</p>
                                            <span id="view_contract" class="text-sm font-semibold text-slate-700"></span>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-slate-400 font-medium mb-0.5">Rémunération (MAD)</p>
                                            <p id="view_salaire" class="text-sm font-semibold text-slate-700"></p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-slate-400 font-medium mb-0.5">Contact Direct</p>
                                            <p id="view_phone" class="text-sm font-semibold text-slate-700"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Action Footer -->
                    <div class="bg-slate-50 px-8 py-4 border-t border-slate-100 flex justify-end">
                        <button onclick="toggleModal('viewUserModal')" class="px-6 py-2 bg-slate-800 text-white text-xs font-bold rounded-xl hover:bg-slate-900 transition-all">
                            Fermer
                        </button>
                    </div>

                </div>
              </div>
            </div>
        </div>

        
        <div id="editUserModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('editUserModal')"></div>
            <div class="relative flex items-center justify-center min-h-screen p-4">
                <div class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden flex flex-col max-h-[92vh] z-10" style="animation: modalIn .2s ease-out">
                    
                    
                    <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                        <div>
                            <h2 class="text-lg font-black text-slate-800">Modifier collaborateur</h2>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Mise à jour · Access Morocco</p>
                        </div>
                        <button type="button" onclick="toggleModal('editUserModal')"
                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] hover:border-[#be2346]/30 transition-all">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    
                    <div class="overflow-y-auto">
                        <form id="editForm" method="POST" class="p-7 space-y-5">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Prénom</label>
                                    <input type="text" name="firstName" id="edit_firstName" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Nom</label>
                                    <input type="text" name="lastName" id="edit_lastName" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Adresse Email</label>
                                    <input type="email" name="email" id="edit_email" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Poste</label>
                                    <input type="text" name="post" id="edit_post" placeholder="Poste" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Adresse</label>
                                    <input type="text" name="address" id="edit_address" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Rôle Système</label>
                                    <select name="type" id="edit_role" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                        <option value="" disabled>Sélectionner le rôle</option>
                                        <option value="employee">Employé</option>
                                        <option value="manager">Manager</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">CIN</label>
                                    <input type="text" name="cin" id="edit_cin" placeholder="CIN" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Salaire (MAD)</label>
                                    <input type="number" name="salaire" id="edit_salaire" placeholder="Salaire" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Téléphone</label>
                                    <input type="text" name="phoneNumber" id="edit_phoneNumber" placeholder="Téléphone" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date de Naissance</label>
                                    <input type="date" name="birthday" id="edit_birthday" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date d'embauche</label>
                                    <input type="date" name="dateEmb" id="edit_dateEmb" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Type de Contrat</label>
                                    <select name="typeContrat" id="edit_typeContrat" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                        <option value="CD">CDI</option>
                                        <option value="CI">CI</option>
                                        <option value="freelance">Freelance</option>
                                    </select>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Statut</label>
                                    <select name="status" id="edit_status" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                        <option value="active">Actif</option>
                                        <option value="desactive">Désactivé</option>
                                        <option value="conge">En Congé</option>
                                    </select>
                                </div>

                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Département Affecté</label>
                                    <select name="idDepartement" id="edit_idDepartement" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                        <option value="" disabled>Sélectionner le département</option>
                                        <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $deptManager = $dept->manager ? trim($dept->manager->firstName . ' ' . $dept->manager->lastName) : ''; ?>
                                            <option value="<?php echo e($dept->idDepartement); ?>" data-current-manager="<?php echo e(htmlspecialchars($deptManager, ENT_QUOTES)); ?>"><?php echo e($dept->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            
                            <div class="flex gap-3 pt-4">
                                <button type="button" onclick="toggleModal('editUserModal')"
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
        </div>

        
        <div id="editUserModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('editUserModal')"></div>
            <div class="relative flex items-center justify-center min-h-screen p-4">
                <div class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden flex flex-col max-h-[92vh] z-10" style="animation: modalIn .2s ease-out">
                    
                    
                    <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                        <div>
                            <h2 class="text-lg font-black text-slate-800">Modifier collaborateur</h2>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Mise à jour · Access Morocco</p>
                        </div>
                        <button type="button" onclick="toggleModal('editUserModal')"
                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] hover:border-[#be2346]/30 transition-all">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    
                    <div class="overflow-y-auto">
                        <form id="editForm" method="POST" class="p-7 space-y-5">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Prénom</label>
                                    <input type="text" name="firstName" id="edit_firstName" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Nom</label>
                                    <input type="text" name="lastName" id="edit_lastName" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Adresse Email</label>
                                    <input type="email" name="email" id="edit_email" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Poste</label>
                                    <input type="text" name="post" id="edit_post" placeholder="Poste" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Adresse</label>
                                    <input type="text" name="address" id="edit_address" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Rôle Système</label>
                                    <select name="type" id="edit_role" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                        <option value="" disabled>Sélectionner le rôle</option>
                                        <option value="employee">Employé</option>
                                        <option value="manager">Manager</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">CIN</label>
                                    <input type="text" name="cin" id="edit_cin" placeholder="CIN" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Salaire (MAD)</label>
                                    <input type="number" name="salaire" id="edit_salaire" placeholder="Salaire" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Téléphone</label>
                                    <input type="text" name="phoneNumber" id="edit_phoneNumber" placeholder="Téléphone" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date de Naissance</label>
                                    <input type="date" name="birthday" id="edit_birthday" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date d'embauche</label>
                                    <input type="date" name="dateEmb" id="edit_dateEmb" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Type de Contrat</label>
                                    <select name="typeContrat" id="edit_typeContrat" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                        <option value="CD">CDI</option>
                                        <option value="CI">CI</option>
                                        <option value="freelance">Freelance</option>
                                    </select>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Statut</label>
                                    <select name="status" id="edit_status" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                        <option value="active">Actif</option>
                                        <option value="desactive">Désactivé</option>
                                        <option value="conge">En Congé</option>
                                    </select>
                                </div>

                                <div class="space-y-1.5 md:col-span-2">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Département Affecté</label>
                                    <select name="idDepartement" id="edit_idDepartement" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                        <option value="" disabled>Sélectionner le département</option>
                                        <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $deptManager = $dept->manager ? trim($dept->manager->firstName . ' ' . $dept->manager->lastName) : ''; ?>
                                            <option value="<?php echo e($dept->idDepartement); ?>" data-current-manager="<?php echo e(htmlspecialchars($deptManager, ENT_QUOTES)); ?>"><?php echo e($dept->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            
                            <div class="flex gap-3 pt-4">
                                <button type="button" onclick="toggleModal('editUserModal')"
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
        </div>

            </div>
        </div>
    </div>
    </div>

    <script>
        function updateUrl(params) {
            let baseUrl = "<?php echo e(route('users.index')); ?>";
            let newUrl = baseUrl;
            
            if (params.userId) {
                if (params.action === 'edit') {
                    newUrl = baseUrl + '/edit/' + params.userId;
                } else {
                    newUrl = baseUrl + '/' + params.userId;
                }
            }
            
            window.history.pushState(null, '', newUrl);
        }

        function resetUrl() {
            updateUrl({});
        }

        function toggleModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                const isOpening = modal.classList.contains('hidden');
                modal.classList.toggle('hidden');
                document.body.style.overflow = modal.classList.contains('hidden') ? 'auto' : 'hidden';
                
                // Reset URL when closing user modals
                if (!isOpening && (id === 'viewUserModal' || id === 'editUserModal')) {
                    resetUrl();
                }
            }
        }

        function openViewModal(user, skipPush = false) {
            console.log("Viewing user:", user);
            
            if (!skipPush) {
                updateUrl({ userId: (user.idUser || user.id) });
            }
            
            // Full Name and Avatar
            document.getElementById('view_fullName').innerText = user.firstName + ' ' + user.lastName;
            const initials = (user.firstName?.charAt(0) || '') + (user.lastName?.charAt(0) || '');
            document.getElementById('view_avatar').innerText = initials.toUpperCase();
            
            // Professional Details
            document.getElementById('view_post').innerText = user.post || 'Collaborateur';
            document.getElementById('view_dept').innerText = user.departement ? user.departement.title : 'Non assigné';
            document.getElementById('view_contract').innerText = user.typeContrat === 'CD' ? 'CDI' : (user.typeContrat || 'CDI');
            document.getElementById('view_salaire').innerText = user.salaire ? new Intl.NumberFormat('fr-MA', { style: 'currency', currency: 'MAD' }).format(user.salaire) : '0,00 MAD';
            document.getElementById('view_dateEmb').innerText = user.dateEmb ? new Date(user.dateEmb).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' }) : 'Non renseignée';
            
            // Personal Details
            document.getElementById('view_email').innerText = user.email || 'Non renseigné';
            document.getElementById('view_phone').innerText = user.phoneNumber || 'Non renseigné';
            document.getElementById('view_cin').innerText = user.cin || 'Non renseigné';
            document.getElementById('view_birthday').innerText = user.birthday ? new Date(user.birthday).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' }) : 'Non renseignée';
            
            // System Role
            const roleLabel = document.getElementById('view_type_label');
            const role = user.type || 'employee';
            
            if (role === 'admin') {
                roleLabel.innerText = 'Administrateur Système';
                roleLabel.className = 'text-[10px] font-bold text-red-500 uppercase tracking-widest';
            } else if (role === 'manager') {
                roleLabel.innerText = 'Manager';
                roleLabel.className = 'text-[10px] font-bold text-blue-500 uppercase tracking-widest';
            } else {
                roleLabel.innerText = 'Collaborateur';
                roleLabel.className = 'text-[10px] font-bold text-slate-400 uppercase tracking-widest';
            }

            // Status Badge
            const statusEl = document.getElementById('view_status');
            const status = user.status || 'active';
            
            if (status === 'active') {
                statusEl.innerText = 'Actif';
                statusEl.className = 'px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600 border border-emerald-100';
            } else if (status === 'conge') {
                statusEl.innerText = 'En Congé';
                statusEl.className = 'px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-wider bg-amber-50 text-amber-600 border border-amber-100';
            } else if (status === 'desactive') {
                statusEl.innerText = 'Désactivé';
                statusEl.className = 'px-2 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-wider bg-slate-50 text-slate-400 border border-slate-200';
            }
            toggleModal('viewUserModal');
        }

        function openEditModal(user) {
            const form = document.getElementById('editForm');
            form.action = `/users/edit/${user.idUser}`;
            
            document.getElementById('edit_firstName').value = user.firstName || '';
            document.getElementById('edit_lastName').value = user.lastName || '';
            document.getElementById('edit_email').value = user.email || '';
            document.getElementById('edit_cin').value = user.cin || '';
            document.getElementById('edit_birthday').value = user.birthday ? user.birthday.split(' ')[0] : '';
            document.getElementById('edit_address').value = user.address || '';
            document.getElementById('edit_phoneNumber').value = user.phoneNumber || '';
            document.getElementById('edit_typeContrat').value = user.typeContrat || 'CD';
            document.getElementById('edit_salaire').value = user.salaire || 0;
            document.getElementById('edit_post').value = user.post || '';
            document.getElementById('edit_dateEmb').value = user.dateEmb ? user.dateEmb.split(' ')[0] : '';
            document.getElementById('edit_idDepartement').value = user.idDepartement || '';
            document.getElementById('edit_status').value = user.status || 'active';
            document.getElementById('edit_role').value = user.type || 'employee';
            
            toggleModal('editUserModal');
        }

        // --- High-End SaaS Filter & AJAX Logic ---
        const filterForm = document.getElementById('filterForm');
        const usersTable = document.getElementById('usersTable');
        const loadingOverlay = document.getElementById('loadingOverlay');
        let searchTimeout;

        function fetchUsers() {
            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);
            const url = `<?php echo e(route('users.index')); ?>?${params.toString()}`;

            if (loadingOverlay) { loadingOverlay.classList.remove('hidden'); loadingOverlay.classList.add('flex'); }
            if (usersTable) usersTable.style.opacity = '0.4';

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.text())
            .then(html => {
                if (usersTable) usersTable.innerHTML = html;
                window.history.pushState({ path: url }, '', url);
            })
            .catch(error => console.error('Error:', error))
            .finally(() => {
                if (loadingOverlay) { loadingOverlay.classList.add('hidden'); loadingOverlay.classList.remove('flex'); }
                if (usersTable) usersTable.style.opacity = '1';
            });
        }

        if (filterForm) {
            filterForm.querySelectorAll('select').forEach(select => select.addEventListener('change', fetchUsers));
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', () => {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(fetchUsers, 300);
                });
            }
            const resetBtn = document.getElementById('resetFilters');
            if (resetBtn) { resetBtn.addEventListener('click', () => { filterForm.reset(); fetchUsers(); }); }

            // Handle Pagination AJAX
            if (usersTable) {
                usersTable.addEventListener('click', function(e) {
                    const link = e.target.closest('.pagination a, [rel="next"], [rel="prev"]');
                    if (link) {
                        e.preventDefault();
                        const url = link.href;
                        
                        if (loadingOverlay) { loadingOverlay.classList.remove('hidden'); loadingOverlay.classList.add('flex'); }
                        usersTable.style.opacity = '0.4';

                        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(response => response.text())
                        .then(html => {
                            usersTable.innerHTML = html;
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                            window.history.pushState({ path: url }, '', url);
                        })
                        .catch(error => console.error('Error:', error))
                        .finally(() => {
                            if (loadingOverlay) { loadingOverlay.classList.add('hidden'); loadingOverlay.classList.remove('flex'); }
                            usersTable.style.opacity = '1';
                        });
                    }
                });
            }
        }

        function initFiltersFromUrl() {
            const params = new URLSearchParams(window.location.search);
            params.forEach((value, key) => {
                const input = filterForm?.querySelector(`[name="${key}"]`);
                if (input) input.value = value;
            });
        }

        window.addEventListener('popstate', () => {
            initFiltersFromUrl();
            fetchUsers();
        });

        // Add Global-Modal based Validation
        function bindManagerValidation(formSelector, roleSelector, deptSelector) {
            const form = document.querySelector(formSelector);
            if (!form) return;
            
            form.addEventListener('submit', function(e) {
                const typeSelect = form.querySelector(roleSelector);
                const deptSelect = form.querySelector(deptSelector);
                
                if (typeSelect && deptSelect && typeSelect.value === 'manager' && deptSelect.value) {
                    const selectedOption = deptSelect.options[deptSelect.selectedIndex];
                    const currentManager = selectedOption.getAttribute('data-current-manager');
                    
                    if (currentManager && currentManager !== '') {
                        e.preventDefault();
                        window.confirmDelete = window.confirmDelete || function(){}; 
                        openGlobalDeleteModal(
                            null, 
                            'Remplacer le Manager ?', 
                            `Ce département a déjà un manager (${currentManager}). En confirmant, il sera rétrogradé en employé pour laisser la place au nouveau manager.`,
                            'Confirmer le remplacement',
                            'info',
                            'switch'
                        );
                        const confirmBtn = document.querySelector('#globalDeleteForm button[type="submit"]');
                        confirmBtn.onclick = function(event) {
                            event.preventDefault();
                            form.submit();
                        };
                    }
                }
            });
        }

        // --- Initialization ---
        document.addEventListener('DOMContentLoaded', function() {
            initFiltersFromUrl();
            
            // Auto-open modal if userId is in URL
            const urlParams = new URLSearchParams(window.location.search);
            const userId = urlParams.get('userId');
            if (userId) {
                const users = <?php echo json_encode($users, 15, 512) ?>;
                const user = users.find(u => (u.idUser || u.id) == userId);
                if (user) openViewModal(user);
            }

            // Server-side auto-open (When data is received from routes)
            <?php if(isset($openModal) && isset($selectedUser)): ?>
                const selectedUser = <?php echo json_encode($selectedUser, 15, 512) ?>;
                const openModal = "<?php echo e($openModal); ?>";
                if (openModal === 'view') {
                    openViewModal(selectedUser, true);
                } else if (openModal === 'edit') {
                    openEditModal(selectedUser, true);
                }
            <?php endif; ?>

            // Handle back button
            window.onpopstate = function() {
                const vModal = document.getElementById('viewUserModal');
                const eModal = document.getElementById('editUserModal');
                if (vModal) vModal.classList.add('hidden');
                if (eModal) eModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            };

            bindManagerValidation('#addUserModal form', 'select[name="type"]', 'select[name="idDepartement"]');
            bindManagerValidation('#editForm', '#edit_role', '#edit_idDepartement');
        });

        function confirmDeleteUser(url) {
            window.confirmDelete(url, 'collaborateur');
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
<?php endif; ?><?php /**PATH C:\Users\Legion UCGS.ma\Desktop\project\AccesMorrocco\resources\views/AllUser.blade.php ENDPATH**/ ?>