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
            <div class="flex items-center gap-4">
                <a href="<?php echo e(route('departements.index')); ?>" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-[#b11d40] hover:border-[#b11d40]/30 hover:bg-[#b11d40]/5 transition-all shadow-sm active:scale-95">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tight"><?php echo e($departement->title); ?></h1>
                    <div class="flex items-center gap-2 mt-1 mb-1">
                        <span class="text-[10px] font-black uppercase text-[#b11d40] tracking-widest bg-[#b11d40]/10 px-2 py-0.5 rounded-md">Département</span>
                    </div>
                    <p class="text-slate-500 font-medium text-sm">Gestion et suivi des membres du département</p>
                </div>
            </div>

            <button type="button" onclick="openEditDeptModal('<?php echo e($departement->idDepartement ?? $departement->id); ?>', '<?php echo e(addslashes($departement->title)); ?>', '<?php echo e(addslashes($departement->description)); ?>', '<?php echo e($departement->idUser); ?>')"
                class="flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Modifier le département
            </button>
        </div>

        <?php if(session('msg')): ?>
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 3000)"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-90"
                 class="mb-6 p-4 bg-emerald-100 border border-emerald-200 text-emerald-700 rounded-xl font-bold flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <?php echo e(session('msg')); ?>

            </div>
        <?php endif; ?>

        
        <?php
            $managerName    = $departement->manager ? trim($departement->manager->firstName . ' ' . $departement->manager->lastName) : null;
            $managerInitials = $managerName ? strtoupper(mb_substr($managerName, 0, 1)) : '?';
            $presence       = $departement->presence ?? 0;
            $totalTaches    = $departement->taches->count();
            $finishedTaches = $departement->taches->where('status', 'termine')->count();
            $tasksPercentage = $totalTaches > 0 ? round(($finishedTaches / $totalTaches) * 100) : 0;
            
            // Allow user relationship as requested, fallback to employes relationship or an empty array
            $employeesList  = $departement->users ?? $departement->employes ?? collect([]); 
            
            // Only count active employees for the KPI card
            $empCount       = $employeesList->whereIn('status', ['Actif', 'actif', 'Active', 'active'])->count();
        ?>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            
            <div class="bg-white border md:col-span-1 border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-[#b11d40] flex items-center justify-between gap-4">
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Manager</p>
                    <p class="text-lg font-extrabold text-slate-800"><?php echo e($managerName ?? 'Non assigné'); ?></p>
                </div>
                <?php if($managerName): ?>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#7c1233] to-[#b11d40] flex items-center justify-center font-black text-lg text-white shadow-sm shrink-0">
                        <?php echo e($managerInitials); ?>

                    </div>
                <?php else: ?>
                    <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                <?php endif; ?>
            </div>

            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-emerald-500 flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-emerald-50 text-emerald-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Employés Actifs</p>
                    <p class="text-2xl font-extrabold text-slate-800"><?php echo e($empCount); ?></p>
                </div>
            </div>

            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-blue-500 flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-blue-50 text-blue-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Présence Moy.</p>
                    <p class="text-2xl font-extrabold text-slate-800"><?php echo e($departement->avg_presence ?? 0); ?>%</p>
                </div>
            </div>

            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-amber-500 flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-amber-50 text-amber-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Tâches Faites</p>
                    <p class="text-2xl font-extrabold text-slate-800"><?php echo e($tasksPercentage); ?>%</p>
                </div>
            </div>
        </div>

        
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/50">
                <h3 class="text-lg font-extrabold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#b11d40]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Membres du Département
                </h3>

                <div class="flex flex-wrap items-center gap-3">
                    
                    <div class="bg-white p-1 rounded-xl border border-slate-200 shadow-sm flex items-center">
                        <a href="<?php echo e(route('departements.show', ['id' => $departement->idDepartement, 'period' => 'today'])); ?>" 
                           class="px-4 py-1.5 rounded-lg text-[10px] font-black uppercase transition-all <?php echo e($period == 'today' ? 'bg-slate-800 text-white shadow-md' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-600'); ?>">
                            Aujourd'hui
                        </a>
                        <a href="<?php echo e(route('departements.show', ['id' => $departement->idDepartement, 'period' => 'weekly'])); ?>" 
                           class="px-4 py-1.5 rounded-lg text-[10px] font-black uppercase transition-all <?php echo e($period == 'weekly' ? 'bg-slate-800 text-white shadow-md' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-600'); ?>">
                            7 Jours
                        </a>
                        <a href="<?php echo e(route('departements.show', ['id' => $departement->idDepartement, 'period' => 'monthly'])); ?>" 
                           class="px-4 py-1.5 rounded-lg text-[10px] font-black uppercase transition-all <?php echo e($period == 'monthly' ? 'bg-slate-800 text-white shadow-md' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-600'); ?>">
                            Ce Mois
                        </a>
                    </div>

                    
                    <a href="<?php echo e(route('departements.export-pdf', ['id' => $departement->idDepartement, 'period' => $period])); ?>" 
                       class="flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase shadow-lg shadow-slate-200 transition-all active:scale-95">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        PDF Rapport
                    </a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 uppercase tracking-wider text-[11px] font-black w-2/5">Employé</th>
                            <th class="px-6 py-4 uppercase tracking-wider text-[11px] font-black w-1/5">Rôle / Poste</th>
                            <th class="px-6 py-4 uppercase tracking-wider text-[11px] font-black w-1/5 text-center">Présence</th>
                            <th class="px-6 py-4 uppercase tracking-wider text-[11px] font-black w-1/5 text-center">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php $__empty_1 = true; $__currentLoopData = $employeesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-slate-100 text-[#b11d40] flex items-center justify-center font-black shadow-sm shrink-0">
                                            <?php echo e(strtoupper(substr($employee->firstName, 0, 1) . substr($employee->lastName, 0, 1))); ?>

                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800"><?php echo e($employee->firstName); ?> <?php echo e($employee->lastName); ?></p>
                                            <p class="text-[11px] text-slate-400 mt-0.5"><?php echo e($employee->email); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-100">
                                        <?php echo e($employee->post ?? 'Employé'); ?>

                                    </span>
                                </td>
                                 <td class="px-6 py-4 text-center">
                                     <div class="flex flex-col items-center gap-1.5">
                                         <div class="flex items-center gap-3">
                                             <div class="flex items-center gap-2">
                                                 <span class="text-xs font-extrabold <?php echo e(($employee->presence_percentage ?? 0) >= 80 ? 'text-emerald-500' : (($employee->presence_percentage ?? 0) >= 40 ? 'text-amber-500' : 'text-red-500')); ?>">
                                                     <?php echo e($employee->presence_percentage ?? 0); ?>%
                                                 </span>
                                                 <div class="w-16 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                                     <div class="h-1.5 rounded-full transition-all duration-500 <?php echo e(($employee->presence_percentage ?? 0) >= 80 ? 'bg-emerald-400' : (($employee->presence_percentage ?? 0) >= 40 ? 'bg-amber-400' : 'bg-red-400')); ?>" 
                                                          style="width: <?php echo e($employee->presence_percentage ?? 0); ?>%"></div>
                                                 </div>
                                             </div>
                                             
                                             
                                             <?php if($employee->is_here_today): ?>
                                                 <?php
                                                     $pStatus = strtolower($employee->today_pointage->status ?? 'present');
                                                     $arrivalTime = $employee->today_pointage->heureEntree ? \Carbon\Carbon::parse($employee->today_pointage->heureEntree)->format('H:i') : '--:--';
                                                 ?>
                                                 
                                                 <?php if($pStatus === 'retard'): ?>
                                                     <div class="group relative inline-block">
                                                         <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 text-[9px] font-black uppercase tracking-tighter cursor-help">
                                                             <span class="w-1 h-1 rounded-full bg-amber-500"></span>
                                                             En retard
                                                         </span>
                                                         
                                                         <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover:block w-max">
                                                             <div class="bg-slate-800 text-white text-[10px] py-1 px-2.5 rounded-lg shadow-xl font-bold">
                                                                 Arrivé à <?php echo e($arrivalTime); ?>

                                                                 <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-slate-800"></div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 <?php else: ?>
                                                     <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[9px] font-black uppercase tracking-tighter">
                                                         <span class="w-1 h-1 rounded-full bg-emerald-500"></span>
                                                         Présent
                                                     </span>
                                                 <?php endif; ?>
                                             <?php else: ?>
                                                 <?php if($employee->today_pointage && strtolower($employee->today_pointage->status) === 'absent'): ?>
                                                     <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-50 text-[#be2346] text-[9px] font-black uppercase tracking-tighter border border-red-100/50">
                                                         <span class="w-1 h-1 rounded-full bg-[#be2346]"></span>
                                                         Absent
                                                     </span>
                                                 <?php else: ?>
                                                     <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-slate-100 text-slate-400 text-[9px] font-black uppercase tracking-tighter">
                                                         <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                                         Absent
                                                     </span>
                                                 <?php endif; ?>
                                             <?php endif; ?>
                                         </div>
                                     </div>
                                 </td>
                                <td class="px-6 py-4 text-center">
                                    <?php
                                        $statusStr = strtolower($employee->status ?? 'actif');
                                    ?>
                                    <?php if($statusStr === 'actif' || $statusStr === 'active'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100/50">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Actif
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-slate-50 text-slate-500 border border-slate-200">
                                            Inactif
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-500">
                                        <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        </div>
                                        <p class="font-bold text-slate-700">Aucun employé assigné</p>
                                        <p class="text-sm text-slate-400 mt-1 max-w-sm">Ce département ne possède actuellement aucun membre. Naviguez vers la liste des employés pour en assigner.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="mt-8 bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden flex flex-col mb-12">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="text-lg font-extrabold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Tâches du Département
                </h3>
                <a href="<?php echo e(route('tasks.index')); ?>" class="text-[11px] font-black uppercase text-[#b11d40] hover:underline">Voir tout le board</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 uppercase tracking-wider text-[11px] font-black w-2/5">Tâche</th>
                            <th class="px-6 py-4 uppercase tracking-wider text-[11px] font-black min-w-[200px]">Assignation</th>
                            <th class="px-6 py-4 uppercase tracking-wider text-[11px] font-black w-1/5 text-center">Durée</th>
                            <th class="px-6 py-4 uppercase tracking-wider text-[11px] font-black w-1/5 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php $__empty_1 = true; $__currentLoopData = $departement->taches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tache): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-bold text-slate-800"><?php echo e($tache->titre); ?></p>
                                        <p class="text-[11px] text-slate-400 mt-0.5"><?php echo e(Str::limit($tache->description, 50)); ?></p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <?php $__empty_2 = true; $__currentLoopData = $tache->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                            <div class="flex items-center gap-1.5 bg-slate-50 border border-slate-200 px-2 py-1 rounded-lg group/badge transition-all hover:border-[#b11d40]/30 hover:bg-[#b11d40]/5">
                                                <div class="w-5 h-5 rounded-md bg-white border border-slate-200 flex items-center justify-center text-[8px] font-black text-[#b11d40] shadow-sm">
                                                    <?php echo e(strtoupper(substr($u->firstName, 0, 1) . substr($u->lastName, 0, 1))); ?>

                                                </div>
                                                <span class="text-[10px] font-bold text-slate-600 truncate max-w-[80px]" title="<?php echo e($u->firstName); ?> <?php echo e($u->lastName); ?>">
                                                    <?php echo e(Str::limit($u->firstName . ' ' . $u->lastName, 12)); ?>

                                                </span>
                                                <form action="<?php echo e(route('tasks.unassign')); ?>" method="POST" class="inline-flex">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="idTache" value="<?php echo e($tache->idTache); ?>">
                                                    <input type="hidden" name="idUser" value="<?php echo e($u->idUser); ?>">
                                                    <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors" title="Retirer">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                            <span class="text-[10px] font-black uppercase text-slate-300 italic tracking-widest">Non assigné</span>
                                        <?php endif; ?>
                                        
                                        <form action="<?php echo e(route('tasks.assign')); ?>" method="POST" class="ml-1">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="idTache" value="<?php echo e($tache->idTache); ?>">
                                            <select name="idUser" onchange="this.form.submit()" class="text-[9px] font-black uppercase bg-slate-50 border-slate-200 rounded-lg px-2 py-1.5 focus:ring-1 focus:ring-[#b11d40] transition-all cursor-pointer hover:bg-slate-100">
                                                <option value="">+ Assigner</option>
                                                <?php $__currentLoopData = $employeesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($emp->idUser); ?>"><?php echo e($emp->firstName); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if($tache->dateDebut && $tache->duree): ?>
                                        <span class="text-[10px] font-black text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg uppercase tracking-tight">
                                            <?php echo e($tache->formatted_duration); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-xs text-slate-400 font-medium">--</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if($tache->status == 'todo'): ?>
                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase bg-slate-100 text-slate-500">À Faire</span>
                                    <?php elseif($tache->status == 'en_cours'): ?>
                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase bg-blue-50 text-blue-500">En Cours</span>
                                    <?php else: ?>
                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase bg-emerald-50 text-emerald-500">Terminé</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center text-slate-400 font-medium">
                                    Aucune tâche assignée à ce département.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <?php echo $__env->make('departements.edit_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
<?php /**PATH C:\Users\dell\Desktop\PROJECTS\AccesMorrocco\resources\views/showDepartement.blade.php ENDPATH**/ ?>