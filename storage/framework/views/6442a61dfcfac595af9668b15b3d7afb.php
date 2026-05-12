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
        
        <?php
            $totalDepts = $departements->count();
            $totalEmp   = $state['totalEmployes'] ?? 0;
            $avgPres    = $state['presenceMoyenne'] ?? 0;
            $avgTasks   = $state['tachesMoyenne'] ?? 0;
        ?>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-[#b11d40] flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-[#b11d40]/10 text-[#b11d40]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1v1H9V7zm5 0h1v1h-1V7zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Départements</p>
                    <p class="text-2xl font-extrabold text-slate-800"><?php echo e($totalDepts); ?></p>
                </div>
            </div>
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-emerald-50 text-emerald-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Employés</p>
                    <p class="text-2xl font-extrabold text-slate-800"><?php echo e($totalEmp); ?></p>
                </div>
            </div>
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-blue-50 text-blue-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Présence Moy.</p>
                    <p class="text-2xl font-extrabold text-slate-800"><span id="global-presence"><?php echo e($avgPres); ?></span>%</p>
                </div>
            </div>
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
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

        
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4 mb-6 flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[300px] relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" id="deptSearch" placeholder="Rechercher par nom, manager ou description..."
                    class="block w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm transition-all focus:border-[#b11d40]/40 focus:ring-4 focus:ring-[#b11d40]/10 outline-none">
            </div>
            
            <div class="bg-slate-50 p-1 rounded-xl border border-slate-200 shadow-sm flex items-center shrink-0">
                <button type="button" data-period="monthly" class="period-toggle px-5 py-2 rounded-lg text-[10px] font-black uppercase transition-all <?php echo e($period == 'monthly' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-400 hover:bg-slate-100 hover:text-slate-600'); ?>">Mensuel</button>
                <button type="button" data-period="today" class="period-toggle px-5 py-2 rounded-lg text-[10px] font-black uppercase transition-all <?php echo e($period == 'today' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-400 hover:bg-slate-100 hover:text-slate-600'); ?>">Aujourd'hui</button>
            </div>
        </div>

        
        <div id="dept-grid-container">
            <?php echo $__env->make('departements.partials.cards', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    
    <?php echo $__env->make('departements.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    
    <?php echo $__env->make('departements.edit_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script>
        let searchTimeout = null;
        let currentPeriod = '<?php echo e($period); ?>';

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

        // --- Optimized AJAX Logic ---
        function fetchDepartements() {
            const search = document.getElementById('deptSearch').value;
            const container = document.getElementById('dept-grid-container');
            
            // Show loading state
            container.style.opacity = '0.5';

            // 1. Fetch HTML Cards
            fetch(`<?php echo e(route('departements.index')); ?>?period=${currentPeriod}&search=${encodeURIComponent(search)}&get_cards=1`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                container.innerHTML = html;
                container.style.opacity = '1';
            });

            // 2. Fetch JSON KPIs
            fetch(`<?php echo e(route('departements.index')); ?>?period=${currentPeriod}&search=${encodeURIComponent(search)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.state) {
                    animateValue('global-presence', data.state.presenceMoyenne);
                    animateValue('global-tasks', data.state.tachesMoyenne);
                }
            })
            .catch(err => console.error('Error fetching stats:', err));
        }

        // Search listener (with debounce)
        document.getElementById('deptSearch').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                fetchDepartements();
            }, 400);
        });

        // Period toggle listener
        document.querySelectorAll('.period-toggle').forEach(btn => {
            btn.addEventListener('click', function() {
                currentPeriod = this.getAttribute('data-period');
                
                // Update UI toggle buttons
                document.querySelectorAll('.period-toggle').forEach(b => {
                    b.className = 'period-toggle px-5 py-2 rounded-lg text-[10px] font-black uppercase transition-all text-slate-400 hover:bg-slate-100 hover:text-slate-600';
                });
                this.className = 'period-toggle px-5 py-2 rounded-lg text-[10px] font-black uppercase transition-all bg-white text-slate-800 shadow-sm';

                fetchDepartements();
            });
        });

        // Number animation for global KPIs
        function animateValue(id, end) {
            const el = document.getElementById(id);
            if (!el) return;
            let start = parseInt(el.textContent) || 0;
            if (start === end) return;
            let duration = 500;
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
<?php /**PATH C:\Users\dell\Desktop\PROJECTS\AccesMorrocco\resources\views/departements/index.blade.php ENDPATH**/ ?>