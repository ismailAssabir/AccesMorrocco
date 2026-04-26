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
    <?php
        $departements = \App\Models\Departement::with('manager')->get();
    ?>
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
                <h3 class="text-3xl font-bold mt-2 text-slate-800"><?php echo e($users->count()); ?></h3>
            </div>

            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm border-l-4 border-l-[#be2346]">
                <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest">En Congé</p>
                <h3 class="text-3xl font-bold mt-2 text-[#be2346]"><?php echo e($users->where('status', 'conge')->count()); ?></h3>
            </div>

            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
                <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest">Consultants</p>
                <h3 class="text-3xl font-bold mt-2 text-blue-600">
                    <?php echo e($users->where('typeContrat', 'freelance')->count()); ?></h3>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-open modal if userId is in URL
        const urlParams = new URLSearchParams(window.location.search);
        const userId = urlParams.get('userId');
        if (userId) {
            const users = <?php echo json_encode($users, 15, 512) ?>;
            const user = users.find(u => (u.idUser || u.id) == userId);
            if (user) {
                openViewModal(user);
            }
        }
    });
</script>

        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden mb-8">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/50">
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                Collaborateur</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Poste
                            </th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                Contrat</th>
                            <th
                                class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-[#be2346]/10 flex items-center justify-center font-bold text-xs text-[#be2346]">
                                        <?php echo e(strtoupper(substr($user->firstName, 0, 1))); ?><?php echo e(strtoupper(substr($user->lastName, 0, 1))); ?>

                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-700"><?php echo e($user->firstName); ?> <?php echo e($user->lastName); ?></span>
                                        <span class="text-[11px] text-slate-400"><?php echo e($user->email); ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 font-medium"><?php echo e($user->post ?? 'Non défini'); ?></td>
                            <td class="px-6 py-4">
                                <span class="text-[10px] font-black text-slate-400 uppercase"><?php echo e($user->typeContrat == 'CD' ? 'CDI' : $user->typeContrat); ?></span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button onclick='openViewModal(<?php echo json_encode($user, 15, 512) ?>)' class="p-2 rounded-lg text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-all" title="Voir les détails">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </button>
                                    <button onclick='openEditModal(<?php echo json_encode($user, 15, 512) ?>)' class="p-2 rounded-lg text-slate-400 hover:bg-[#be2346]/10 hover:text-[#be2346] transition-all" title="Modifier">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z" /></svg>
                                    </button>
                                    <button onclick="confirmDeleteUser('<?php echo e(route('users.destroy', $user->idUser )); ?>')" class="p-2 rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-600 transition-all" title="Supprimer">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-400 text-sm">Aucun collaborateur trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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

        function confirmDeleteUser(url) {
            window.confirmDelete(url, 'employé');
        }

        // --- Auto-open and UI initialization ---
        document.addEventListener('DOMContentLoaded', function() {
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
                document.getElementById('viewUserModal').classList.add('hidden');
                document.getElementById('editUserModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            };
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
                        
                        window.confirmDelete = window.confirmDelete || function(){}; // Safety
                        
                        // Use openGlobalDeleteModal for custom text and theme
                        openGlobalDeleteModal(
                            null, 
                            'Remplacer le Manager ?', 
                            `Ce département a déjà un manager (${currentManager}). En confirmant, il sera rétrogradé en employé pour laisser la place au nouveau manager.`,
                            'Confirmer le remplacement',
                            'info',
                            'switch'
                        );
                        
                        // Override the form submission logic for this specific case
                        const confirmBtn = document.querySelector('#globalDeleteForm button[type="submit"]');
                        const originalOnclick = confirmBtn.onclick;
                        
                        confirmBtn.onclick = function(event) {
                            event.preventDefault();
                            form.submit();
                        };
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            bindManagerValidation('#addUserModal form', 'select[name="type"]', 'select[name="idDepartement"]');
            bindManagerValidation('#editForm', '#edit_role', '#edit_idDepartement');
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
<?php endif; ?><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/AllUser.blade.php ENDPATH**/ ?>