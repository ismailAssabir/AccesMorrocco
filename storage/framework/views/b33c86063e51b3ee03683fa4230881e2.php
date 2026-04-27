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
<div class="p-6 md:p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Tableau de Pointage</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Suivi des présences, retards et absences de l'équipe.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('pointages.index')); ?>"
               class="flex items-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 px-4 py-2.5 rounded-xl font-bold text-sm transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Mon Pointage
            </a>
            <button onclick="openSettingsModal()"
                class="flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
                Paramètres
            </button>
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

    
    <?php
        $total    = $pointages->count();
        $presents = $pointages->where('status', 'present')->count();
        $retards  = $pointages->where('status', 'retard')->count();
        $absents  = $pointages->where('status', 'absent')->count();
        $withJustif = $pointages->whereNotNull('justification')->count();
    ?>
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
            <span class="p-2.5 rounded-xl bg-slate-100 text-slate-500 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </span>
            <div>
                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Total</p>
                <p class="text-2xl font-extrabold text-slate-800"><?php echo e($total); ?></p>
            </div>
        </div>
        <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4 border-l-4 border-l-emerald-400">
            <span class="p-2.5 rounded-xl bg-emerald-50 text-emerald-500 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
            <div>
                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Présents</p>
                <p class="text-2xl font-extrabold text-emerald-500"><?php echo e($presents); ?></p>
            </div>
        </div>
        <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4 border-l-4 border-l-amber-400">
            <span class="p-2.5 rounded-xl bg-amber-50 text-amber-500 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
            <div>
                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Retards</p>
                <p class="text-2xl font-extrabold text-amber-500"><?php echo e($retards); ?></p>
            </div>
        </div>
        <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4 border-l-4 border-l-[#b11d40]">
            <span class="p-2.5 rounded-xl bg-red-50 text-[#b11d40] shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </span>
            <div>
                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Absents</p>
                <p class="text-2xl font-extrabold text-[#b11d40]"><?php echo e($absents); ?></p>
            </div>
        </div>
        <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4 border-l-4 border-l-indigo-400">
            <span class="p-2.5 rounded-xl bg-indigo-50 text-indigo-500 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </span>
            <div>
                <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Justifiés</p>
                <p class="text-2xl font-extrabold text-indigo-500"><?php echo e($withJustif); ?></p>
            </div>
        </div>
    </div>

    
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4 mb-6">
        <form id="filterForm" class="flex flex-wrap items-center gap-4" onsubmit="event.preventDefault()">
            
            <div class="flex-1 min-w-[280px] relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" id="search-input" oninput="filterTable()" placeholder="Rechercher un employé, une date..." 
                    class="block w-full pl-10 pr-4 py-3 border border-slate-200 rounded-2xl text-sm transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 outline-none">
            </div>

            
            <div class="flex flex-wrap items-center gap-3">
                <div class="relative">
                    <select id="status-filter" onchange="filterTable()" class="appearance-none bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 text-xs font-bold text-slate-600 outline-none focus:border-[#be2346] transition-all cursor-pointer">
                        <option value="">Tous les statuts</option>
                        <option value="present">Présent</option>
                        <option value="retard">Retard</option>
                        <option value="absent">Absent</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>

                <div class="relative">
                    <select id="role-filter" onchange="filterTable()" class="appearance-none bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 text-xs font-bold text-slate-600 outline-none focus:border-[#be2346] transition-all cursor-pointer">
                        <option value="">Tous les rôles</option>
                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                        <option value="employee">Employé</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>

                <div class="relative">
                    <select id="dept-filter" onchange="filterTable()" class="appearance-none bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-10 py-2.5 text-xs font-bold text-slate-600 outline-none focus:border-[#be2346] transition-all cursor-pointer">
                        <option value="">Tous les départements</option>
                        <?php $__currentLoopData = \App\Models\Departement::orderBy('title')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e(strtolower($dept->title)); ?>"><?php echo e($dept->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>

                <button type="button" onclick="document.getElementById('search-input').value='';document.getElementById('status-filter').value='';document.getElementById('role-filter').value='';document.getElementById('dept-filter').value='';filterTable()" class="p-3 rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-all flex items-center justify-center" title="Réinitialiser les filtres">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                </button>
            </div>
        </form>
    </div>

    
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
        
        <div class="px-7 pt-6 pb-2 flex items-center justify-between border-b border-slate-50 bg-slate-50/30">
            <div>
                <h2 class="text-lg font-black text-slate-800">Historique de Pointage (Équipe)</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Suivi en temps réel des Entrées/Sorties</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-white border border-slate-200 text-[10px] font-bold text-slate-500 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Actifs
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600" id="pointage-table">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-extrabold text-slate-400 tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Employé</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Entrée</th>
                        <th class="px-6 py-4">Sortie</th>
                        <th class="px-6 py-4">Durée</th>
                        <th class="px-6 py-4">GPS</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="px-6 py-4">Justification</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" id="pointage-tbody">
                    <?php $__empty_1 = true; $__currentLoopData = $pointages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pointage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $user = $pointage->user;
                        $empName = $user ? trim(($user->firstName ?? '') . ' ' . ($user->lastName ?? '')) : 'Employé inconnu';
                        $initial = $user ? strtoupper(substr($user->firstName ?? 'E', 0, 1)) : 'E';

                        // Calculate duration
                        $duree = '--';
                        if ($pointage->heureEntree && $pointage->heureSortie) {
                            $entry = \Carbon\Carbon::parse($pointage->heureEntree);
                            $exit  = \Carbon\Carbon::parse($pointage->heureSortie);
                            $mins  = $entry->diffInMinutes($exit);
                            $duree = intdiv($mins, 60) . 'h ' . ($mins % 60) . 'min';
                        }

                        // Calculate delay
                        $delayIn = null;
                        $delayOut = null;
                        if ($pointage->heureEntree && isset($settings->companyEntryTime)) {
                            $entry = \Carbon\Carbon::parse($pointage->heureEntree);
                            $officialIn = \Carbon\Carbon::parse($settings->companyEntryTime);
                            if ($entry->gt($officialIn)) {
                                $diff = $officialIn->diffInMinutes($entry);
                                if ($diff > 0) $delayIn = "+ " . $diff . " min";
                            }
                        }
                        if ($pointage->heureSortie && isset($settings->companyExitTime)) {
                            $exit = \Carbon\Carbon::parse($pointage->heureSortie);
                            $officialOut = \Carbon\Carbon::parse($settings->companyExitTime);
                            if ($exit->lt($officialOut)) {
                                $diff = $exit->diffInMinutes($officialOut);
                                if ($diff > 0) $delayOut = "- " . $diff . " min";
                            }
                        }
                    ?>
                    <tr class="hover:bg-slate-50 transition-colors pointage-row"
                        data-name="<?php echo e(strtolower($empName)); ?>"
                        data-role="<?php echo e(strtolower($user->type ?? 'employee')); ?>"
                        data-date="<?php echo e($pointage->date); ?>"
                        data-status="<?php echo e($pointage->status); ?>"
                        data-dept="<?php echo e(strtolower($user->departement->title ?? '')); ?>">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#7c1233] to-[#be2346] flex items-center justify-center text-white font-black text-xs shrink-0">
                                    <?php echo e($initial); ?>

                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-sm leading-tight"><?php echo e($empName); ?></p>
                                    <?php if($user): ?>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <p class="text-[10px] text-slate-400 font-medium"><?php echo e($user->email ?? ''); ?></p>
                                        <span class="text-[8px] px-1.5 py-0.5 rounded font-black uppercase tracking-tighter border
                                            <?php echo e(($user->type ?? '') === 'admin' ? 'bg-red-50 text-[#be2346] border-red-100' : (($user->type ?? '') === 'manager' ? 'bg-indigo-50 text-indigo-500 border-indigo-100' : 'bg-slate-50 text-slate-500 border-slate-100')); ?>">
                                            <?php echo e($user->type ?? 'User'); ?>

                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-700">
                            <?php echo e($pointage->date ? \Carbon\Carbon::parse($pointage->date)->translatedFormat('d M Y') : '--'); ?>

                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-mono text-xs bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-lg font-bold w-fit">
                                    <?php echo e($pointage->heureEntree ? \Carbon\Carbon::parse($pointage->heureEntree)->format('H:i') : '--:--'); ?>

                                </span>
                                <?php if($delayIn): ?>
                                    <span class="text-[9px] font-black text-amber-500 mt-1 ml-1 uppercase tracking-tighter"><?php echo e($delayIn); ?></span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-mono text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg font-bold w-fit">
                                    <?php echo e($pointage->heureSortie ? \Carbon\Carbon::parse($pointage->heureSortie)->format('H:i') : '--:--'); ?>

                                </span>
                                <?php if($delayOut): ?>
                                    <span class="text-[9px] font-black text-[#be2346] mt-1 ml-1 uppercase tracking-tighter">Anticipé: <?php echo e($delayOut); ?></span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500 font-medium text-xs"><?php echo e($duree); ?></td>
                        <td class="px-6 py-4 text-xs text-slate-400 font-mono">
                            <?php if($pointage->gps): ?>
                            <a href="https://www.google.com/maps/search/?api=1&query=<?php echo e($pointage->gps); ?>" target="_blank" 
                               class="flex items-center gap-1.5 hover:text-[#be2346] transition-colors group">
                                <svg class="w-3 h-3 text-slate-300 group-hover:text-[#be2346]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span><?php echo e(substr($pointage->gps, 0, 12)); ?>...</span>
                            </a>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php if($pointage->status === 'present'): ?>
                                <span class="bg-emerald-50 text-emerald-600 font-bold px-3 py-1 rounded-full text-xs border border-emerald-200">Présent</span>
                            <?php elseif($pointage->status === 'retard'): ?>
                                <span class="bg-amber-50 text-amber-600 font-bold px-3 py-1 rounded-full text-xs border border-amber-200">Retard</span>
                            <?php else: ?>
                                <span class="bg-red-50 text-[#b11d40] font-bold px-3 py-1 rounded-full text-xs border border-red-200">Absent</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            <?php if($pointage->justification): ?>
                                <div class="space-y-2">
                                    <div class="flex items-start justify-between gap-2">
                                        <p class="text-xs text-slate-600 truncate max-w-[150px]" title="<?php echo e($pointage->justification); ?>">
                                            <?php echo e($pointage->justification); ?>

                                        </p>
                                        <?php if($pointage->justification_status === 'en_attente'): ?>
                                            <span class="bg-amber-100 text-amber-700 text-[9px] font-black px-1.5 py-0.5 rounded uppercase shrink-0">En attente</span>
                                        <?php elseif($pointage->justification_status === 'accepte'): ?>
                                            <span class="bg-emerald-100 text-emerald-700 text-[9px] font-black px-1.5 py-0.5 rounded uppercase shrink-0">Acceptée</span>
                                        <?php elseif($pointage->justification_status === 'refuse'): ?>
                                            <span class="bg-red-100 text-red-700 text-[9px] font-black px-1.5 py-0.5 rounded uppercase shrink-0">Refusée</span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-2">
                                        <?php if($pointage->typejustif): ?>
                                            <span class="inline-block text-[10px] font-bold text-indigo-500 bg-indigo-50 border border-indigo-200 px-2 py-0.5 rounded-full uppercase"><?php echo e($pointage->typejustif); ?></span>
                                        <?php endif; ?>
                                        <?php if($pointage->fichier): ?>
                                            <a href="<?php echo e(Storage::url($pointage->fichier)); ?>" target="_blank"
                                                class="inline-flex items-center gap-1 text-[10px] font-bold text-[#be2346] hover:underline">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                                Fichier
                                            </a>
                                        <?php endif; ?>
                                    </div>

                                    <?php if($pointage->justification_status === 'en_attente'): ?>
                                        <div class="flex items-center gap-2 pt-1">
                                            <form action="<?php echo e(route('admin.pointages.validate', $pointage->idPointage)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="action" value="accepte">
                                                <button type="submit" class="text-[10px] bg-emerald-500 hover:bg-emerald-600 text-white font-bold px-2 py-1 rounded transition-colors">Accepter</button>
                                            </form>
                                            <button type="button" onclick="openAdminRefuseModal(<?php echo e($pointage->idPointage); ?>)" class="text-[10px] bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold px-2 py-1 rounded transition-colors">Refuser</button>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($pointage->justification_status === 'refuse' && $pointage->motif_refus): ?>
                                        <div class="mt-1 p-1.5 bg-red-50 border border-red-100 rounded text-[9px] text-red-700">
                                            <strong class="font-bold">Motif refus:</strong> <?php echo e($pointage->motif_refus); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <span class="text-slate-300 text-xs italic">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="px-6 py-20 text-center text-slate-400 font-medium">
                            Aucun enregistrement de pointage trouvé.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div id="settingsModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeSettingsModal()"></div>
    <div class="relative bg-white w-full max-w-lg rounded-[32px] shadow-2xl overflow-hidden flex flex-col z-10" style="animation: modalIn .2s ease-out">

        <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
            <div>
                <h2 class="text-lg font-black text-slate-800">Paramètres de l'Entreprise</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Configuration · Access Morocco</p>
            </div>
            <button type="button" onclick="closeSettingsModal()"
                class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] hover:border-[#be2346]/30 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" class="p-7 space-y-5">
            <?php echo csrf_field(); ?>
            <div class="space-y-1.5">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">GPS de l'entreprise</label>
                <input type="text" name="companyGps" placeholder="Ex: 32.9348,-6.0234" value="<?php echo e($settings->companyGps ?? ''); ?>"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 font-mono">
                <p class="text-[10px] text-slate-400 ml-1">Format: latitude,longitude</p>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Entrée</label>
                    <input type="time" name="companyEntryTime" value="<?php echo e($settings->companyEntryTime ?? ''); ?>"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-3 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                </div>
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Sortie</label>
                    <input type="time" name="companyExitTime" value="<?php echo e($settings->companyExitTime ?? ''); ?>"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-3 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                </div>
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Absence</label>
                    <input type="time" name="absenceTime" value="<?php echo e($settings->absenceTime ?? ''); ?>"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-3 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Distance maximale (m)</label>
                    <input type="number" name="distance" placeholder="Ex: 200" min="10" max="5000" value="<?php echo e($settings->distance ?? ''); ?>"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                </div>
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Délai de grâce (min)</label>
                    <input type="number" name="maxDelay" placeholder="Ex: 15" min="0" max="120" value="<?php echo e($settings->maxDelay ?? ''); ?>"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                </div>
            </div>
            <p class="text-[10px] text-slate-400 ml-1">Rayon autorisé (mètres) et marge de retard autorisée (minutes).</p>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeSettingsModal()"
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


<div id="adminRefuseModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeAdminRefuseModal()"></div>
    <div class="relative bg-white w-full max-w-md rounded-[32px] shadow-2xl overflow-hidden flex flex-col z-10" style="animation: modalIn .2s ease-out">
        <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
            <div>
                <h2 class="text-lg font-black text-slate-800">Refuser la justification</h2>
            </div>
            <button type="button" onclick="closeAdminRefuseModal()"
                class="w-8 h-8 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346]">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="adminRefuseForm" method="POST" class="p-7 space-y-5">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="action" value="refuse">

            <div class="space-y-1.5">
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Motif du refus <span class="text-[#be2346]">*</span></label>
                <textarea name="motif_refus" rows="3" required
                    placeholder="Ex: Document illisible, motif non valable..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 max-length-500"></textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeAdminRefuseModal()"
                    class="flex-1 py-3 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50">
                    Annuler
                </button>
                <button type="submit"
                    class="flex-1 py-3 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] active:scale-95 font-extrabold text-white">
                    Confirmer le Refus
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.95) translateY(8px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }
</style>

<script>
    function openSettingsModal() {
        const modal = document.getElementById('settingsModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function closeSettingsModal() {
        const modal = document.getElementById('settingsModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }
    document.addEventListener('keydown', e => { 
        if (e.key === 'Escape') {
            closeSettingsModal();
            if(typeof closeAdminRefuseModal === 'function') closeAdminRefuseModal();
        }
    });

    function openAdminRefuseModal(idPointage) {
        const form = document.getElementById('adminRefuseForm');
        form.action = `/admin/pointages/${idPointage}/validate`;
        const modal = document.getElementById('adminRefuseModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeAdminRefuseModal() {
        const modal = document.getElementById('adminRefuseModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    function filterTable() {
        const search = document.getElementById('search-input').value.toLowerCase();
        const status = document.getElementById('status-filter').value.toLowerCase();
        const role   = document.getElementById('role-filter').value.toLowerCase();
        const dept   = document.getElementById('dept-filter').value.toLowerCase();
        const rows   = document.querySelectorAll('.pointage-row');

        rows.forEach(row => {
            const nameMatch   = row.getAttribute('data-name').includes(search);
            const statusMatch = status === '' || row.getAttribute('data-status') === status;
            const roleMatch   = role === '' || row.getAttribute('data-role') === role;
            const deptMatch   = dept === '' || row.getAttribute('data-dept') === dept;
            
            if (nameMatch && statusMatch && roleMatch && deptMatch) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
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
<?php endif; ?>
<?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/Adminpointage.blade.php ENDPATH**/ ?>