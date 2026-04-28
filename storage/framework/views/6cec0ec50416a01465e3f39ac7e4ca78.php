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
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Gestion des Départements</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Organisez et pilotez la structure interne d'Access Morocco.</p>
            </div>
            <button onclick="openDeptModal()"
                class="flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter
            </button>
        </div>

        
        <?php

            $totalDepts = $state['totalDepartements'] ?? 0;
            $totalEmp   = $state['totalEmployes'] ?? 0;
            $avgPres    = $state['presenceMoyenne'] ?? 0;
            $totalDepts = $departements->count();

            $avgTasks   = $state['tachesMoyenne'] ?? 0;

        ?>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-extrabold text-slate-800">Aperçu Global</h2>
            
            <div class="bg-white p-1 rounded-xl border border-slate-200 shadow-sm flex items-center inline-flex">
                <button type="button" data-period="monthly" class="period-toggle px-4 py-1.5 rounded-lg text-[10px] font-black uppercase transition-all <?php echo e($period == 'monthly' ? 'bg-slate-800 text-white shadow-md' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-600'); ?>">Mensuel</button>
                <button type="button" data-period="today" class="period-toggle px-4 py-1.5 rounded-lg text-[10px] font-black uppercase transition-all <?php echo e($period == 'today' ? 'bg-slate-800 text-white shadow-md' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-600'); ?>">Aujourd'hui</button>
            </div>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-[] flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-[#b11d40]/10 text-[#b11d40]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1v1H9V7zm5 0h1v1h-1V7zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Départements</p>
                    <p class="text-2xl font-extrabold text-slate-800"><?php echo e($totalDepts); ?></p>
                </div>
            </div>
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-[] flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-emerald-50 text-emerald-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Total Employés</p>
                    <p class="text-2xl font-extrabold text-slate-800"><?php echo e($totalEmp); ?></p>
                </div>
            </div>
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-[] flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-blue-50 text-blue-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Présence Moy.</p>
                    <p class="text-2xl font-extrabold text-slate-800"><span id="global-presence"><?php echo e($avgPres); ?></span>%</p>
                </div>
            </div>
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-[#b11d40] flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-amber-50 text-amber-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Tâches Moy.</p>
                    <p class="text-2xl font-extrabold text-[#b11d40]"><span id="global-tasks"><?php echo e($avgTasks); ?></span>%</p>
                </div>
            </div>
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

        
        <?php if($departements->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $isManager = $dept->manager && $dept->manager->type === 'manager';
                        $managerName = $isManager ? trim($dept->manager->firstName . ' ' . $dept->manager->lastName) : null;
                        $managerInitials = $managerName ? strtoupper(mb_substr($dept->manager->firstName, 0, 1) . mb_substr($dept->manager->lastName, 0, 1)) : '?';

                        $presence = round($dept->avg_presence ?? 0);
                        $tasks = $dept->tasks_count > 0 ? round(($dept->completed_tasks_count / $dept->tasks_count) * 100) : 0;
                        $empCount = $dept->users_count ?? 0;

                        $avatarColors = ['bg-[#b11d40]','bg-blue-500','bg-emerald-500','bg-amber-500','bg-violet-500'];
                    ?>

                    <div class="dept-card bg-white border border-slate-200 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden group" data-dept-id="<?php echo e($dept->idDepartement ?? $dept->id); ?>">

                        
                        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

                        <div class="p-6 flex-1 flex flex-col gap-5">

                            
                            <div class="flex items-start gap-3">
                                <div class="w-11 h-11 rounded-2xl bg-[#b11d40]/10 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-[#b11d40]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1v1H9V7zm5 0h1v1h-1V7zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1z"/></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-base font-extrabold text-slate-800 truncate"><?php echo e($dept->title); ?></h3>
                                    <p class="text-[11px] text-slate-400 truncate mt-0.5"><?php echo e($dept->description ?? 'Aucune description'); ?></p>
                                </div>
                                
                                
                                <button type="button" onclick="openEditDeptModal('<?php echo e($dept->idDepartement ?? $dept->id); ?>', '<?php echo e(addslashes($dept->title)); ?>', '<?php echo e(addslashes($dept->description)); ?>', '<?php echo e($dept->idUser); ?>')" class="shrink-0 text-slate-300 hover:text-[#b11d40] transition-colors p-1 mr-1" title="Modifier">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                
                                
                                <button type="button" onclick="confirmDeleteDept('<?php echo e(route('departements.destroy', $dept->idDepartement ?? $dept->id )); ?>')" class="shrink-0 text-slate-300 hover:text-red-500 transition-colors p-1" title="Supprimer">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>

                            
                            <div class="flex items-center gap-3 bg-slate-50 rounded-2xl px-4 py-3">
                                <?php if($managerName): ?>
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#7c1233] to-[#b11d40] flex items-center justify-center font-black text-xs text-white shadow-sm shrink-0">
                                        <?php echo e($managerInitials); ?>

                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Manager</p>
                                        <p class="text-sm font-bold text-slate-700 truncate"><?php echo e($managerName); ?></p>
                                    </div>
                                <?php else: ?>
                                    <div class="w-9 h-9 rounded-xl bg-slate-200 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Manager</p>
                                        <p class="text-sm text-slate-400 italic">Aucun manager assigné</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            
                            <div class="space-y-3">
                                
                                <div>
                                    <div class="flex justify-between items-center mb-1.5">
                                        <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest flex items-center gap-1.5">
                                            <span class="presence-dot w-1.5 h-1.5 rounded-full <?php echo e($presence >= 80 ? 'bg-emerald-400' : ($presence >= 40 ? 'bg-amber-400' : 'bg-red-400')); ?> inline-block"></span>
                                            Présence
                                        </span>
                                        <span class="presence-text text-xs font-extrabold <?php echo e($presence >= 80 ? 'text-emerald-500' : ($presence >= 40 ? 'text-amber-500' : 'text-red-500')); ?>"><?php echo e($presence); ?>%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="presence-bar h-2 rounded-full transition-all duration-700 <?php echo e($presence >= 80 ? 'bg-emerald-400' : ($presence >= 40 ? 'bg-amber-400' : 'bg-red-400')); ?>" style="width: <?php echo e($presence); ?>%"></div>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="flex justify-between items-center mb-1.5">
                                        <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest flex items-center gap-1.5">
                                            <span class="tasks-dot w-1.5 h-1.5 rounded-full <?php echo e($tasks >= 80 ? 'bg-emerald-400' : ($tasks >= 50 ? 'bg-blue-400' : 'bg-amber-400')); ?> inline-block"></span>
                                            Tâches
                                        </span>
                                        <span class="tasks-text text-xs font-extrabold <?php echo e($tasks >= 80 ? 'text-emerald-500' : ($tasks >= 50 ? 'text-blue-500' : 'text-amber-500')); ?>"><?php echo e($tasks); ?>%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="tasks-bar h-2 rounded-full transition-all duration-700 <?php echo e($tasks >= 80 ? 'bg-emerald-400' : ($tasks >= 50 ? 'bg-blue-400' : 'bg-amber-400')); ?>" style="width: <?php echo e($tasks); ?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="border-t border-slate-100 bg-slate-50/60 px-6 py-4 flex items-center justify-between">
                            
                            <div class="flex items-center gap-3">
                                <div class="flex -space-x-2">
                                    <?php for($i = 0; $i < min($empCount, 4); $i++): ?>
                                        <div class="w-8 h-8 rounded-xl <?php echo e($avatarColors[$i % count($avatarColors)]); ?> border-2 border-white flex items-center justify-center text-[10px] font-black text-white shadow-sm">
                                            <?php echo e(chr(65 + $i)); ?>

                                        </div>
                                    <?php endfor; ?>
                                    <?php if($empCount > 4): ?>
                                        <div class="w-8 h-8 rounded-xl bg-slate-200 border-2 border-white flex items-center justify-center text-[9px] font-black text-slate-500 shadow-sm">
                                            +<?php echo e($empCount - 4); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="text-xs font-extrabold text-slate-700"><?php echo e($empCount); ?></p>
                                    <p class="text-[10px] text-slate-400 font-medium">employé<?php echo e($empCount > 1 ? 's' : ''); ?></p>
                                </div>
                            </div>

                            
                            <a href="<?php echo e(route('departements.show', $dept->idDepartement )); ?>" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#b11d40] border border-[#b11d40]/30 hover:bg-[#b11d40] hover:text-white px-4 py-2 rounded-xl transition-all duration-200 active:scale-95">
                                Gérer
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            
            <div class="flex flex-col items-center justify-center bg-white border border-slate-200 rounded-3xl shadow-sm py-20 px-8 text-center">
                <div class="w-20 h-20 rounded-3xl bg-[#b11d40]/10 flex items-center justify-center mb-5">
                    <svg class="w-10 h-10 text-[#b11d40]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1v1H9V7zm5 0h1v1h-1V7zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1z"/></svg>
                </div>
                <h3 class="text-xl font-extrabold text-slate-800">Aucun département</h3>
                <p class="text-slate-500 mt-2 max-w-sm text-sm">Créez votre premier département pour structurer votre organisation.</p>
                <button onclick="openDeptModal()" class="mt-6 flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] text-white px-6 py-3 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm active:scale-95">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Créer le premier département
                </button>
            </div>
        <?php endif; ?>
    </div>

    
    <?php echo $__env->make('departements.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    
    <?php echo $__env->make('departements.edit_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script>
        function openDeptModal() {
            document.getElementById('addDepartmentModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeDeptModal() {
            document.getElementById('addDepartmentModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        document.addEventListener('keydown', e => { 
            if (e.key === 'Escape') {
                closeDeptModal(); 
            }
        });

        function confirmDeleteDept(url) {
            window.confirmDelete(url, 'département');
        }

        // --- Period Toggle AJAX Logic ---
        document.querySelectorAll('.period-toggle').forEach(btn => {
            btn.addEventListener('click', function() {
                const period = this.getAttribute('data-period');
                
                // Update UI toggle buttons
                document.querySelectorAll('.period-toggle').forEach(b => {
                    b.className = 'period-toggle px-4 py-1.5 rounded-lg text-[10px] font-black uppercase transition-all text-slate-400 hover:bg-slate-50 hover:text-slate-600';
                });
                this.className = 'period-toggle px-4 py-1.5 rounded-lg text-[10px] font-black uppercase transition-all bg-slate-800 text-white shadow-md';

                // Fetch new data
                fetch(`<?php echo e(route('departements.index')); ?>?period=${period}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(data => {
                    // Update global KPIs
                    if (data.state) {
                        animateValue('global-presence', data.state.presenceMoyenne);
                        animateValue('global-tasks', data.state.tachesMoyenne);
                    }

                    // Update each department card
                    if (data.departements) {
                        data.departements.forEach(dept => {
                            const card = document.querySelector(`.dept-card[data-dept-id="${dept.id}"]`);
                            if (card) {
                                // Update Presence
                                const pText = card.querySelector('.presence-text');
                                const pBar = card.querySelector('.presence-bar');
                                const pDot = card.querySelector('.presence-dot');
                                
                                pText.textContent = `${dept.presence}%`;
                                pBar.style.width = `${dept.presence}%`;
                                
                                // Reset colors for presence
                                pText.className = `presence-text text-xs font-extrabold ${getPresenceTextColor(dept.presence)}`;
                                pBar.className = `presence-bar h-2 rounded-full transition-all duration-700 ${getPresenceBgColor(dept.presence)}`;
                                pDot.className = `presence-dot w-1.5 h-1.5 rounded-full ${getPresenceBgColor(dept.presence)} inline-block`;

                                // Update Tasks
                                const tText = card.querySelector('.tasks-text');
                                const tBar = card.querySelector('.tasks-bar');
                                const tDot = card.querySelector('.tasks-dot');

                                tText.textContent = `${dept.tasks}%`;
                                tBar.style.width = `${dept.tasks}%`;

                                // Reset colors for tasks
                                tText.className = `tasks-text text-xs font-extrabold ${getTasksTextColor(dept.tasks)}`;
                                tBar.className = `tasks-bar h-2 rounded-full transition-all duration-700 ${getTasksBgColor(dept.tasks)}`;
                                tDot.className = `tasks-dot w-1.5 h-1.5 rounded-full ${getTasksBgColor(dept.tasks)} inline-block`;
                            }
                        });
                    }
                })
                .catch(err => console.error('Error fetching period stats:', err));
            });
        });

        // Helpers for dynamic colors
        function getPresenceTextColor(val) { return val >= 80 ? 'text-emerald-500' : (val >= 40 ? 'text-amber-500' : 'text-red-500'); }
        function getPresenceBgColor(val) { return val >= 80 ? 'bg-emerald-400' : (val >= 40 ? 'bg-amber-400' : 'bg-red-400'); }
        
        function getTasksTextColor(val) { return val >= 80 ? 'text-emerald-500' : (val >= 50 ? 'text-blue-500' : 'text-amber-500'); }
        function getTasksBgColor(val) { return val >= 80 ? 'bg-emerald-400' : (val >= 50 ? 'bg-blue-400' : 'bg-amber-400'); }

        // Number animation for global KPIs
        function animateValue(id, end) {
            const el = document.getElementById(id);
            if (!el) return;
            let start = parseInt(el.textContent) || 0;
            if (start === end) return;
            let duration = 500; // ms
            let startTime = null;

            function step(timestamp) {
                if (!startTime) startTime = timestamp;
                let progress = Math.min((timestamp - startTime) / duration, 1);
                el.textContent = Math.floor(progress * (end - start) + start);
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                } else {
                    el.textContent = end;
                }
            }
            window.requestAnimationFrame(step);
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
<?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/departements/index.blade.php ENDPATH**/ ?>