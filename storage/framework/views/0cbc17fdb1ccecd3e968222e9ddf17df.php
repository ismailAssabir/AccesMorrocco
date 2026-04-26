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
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <?php if(auth()->user()->type === 'employee'): ?>
                
                
                
                <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Mon Espace Personnel</h1>
                        <p class="text-sm text-gray-500 mt-1">Bonjour <?php echo e(auth()->user()->firstName); ?>, voici vos tâches et événements à venir. <span class="ml-2 px-2 py-0.5 bg-blue-50 text-blue-600 rounded text-[10px] font-bold uppercase tracking-widest border border-blue-100"><?php echo e(optional(auth()->user()->departement)->title ?? 'Global'); ?></span></p>
                    </div>
                    <div class="flex gap-2">
                        <a href="<?php echo e(url('/reclamations')); ?>" class="inline-flex items-center px-4 py-2 bg-[#be2346] text-white text-sm font-semibold rounded-lg hover:bg-[#a01d3a] transition-colors shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 4v16m8-8H4" stroke-width="2"/></svg>
                            Nouvelle Réclamation
                        </a>
                    </div>
                </div>

                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-2xl hover:shadow-[#be2346]/10 hover:-translate-y-1 hover:border-[#be2346]/20 transition-all duration-300 cursor-pointer">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Mes Tâches</p>
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-bold text-gray-900"><?php echo e($stats['myTasks']); ?></h3>
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-width="2"/></svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-2xl hover:shadow-[#be2346]/10 hover:-translate-y-1 hover:border-[#be2346]/20 transition-all duration-300 cursor-pointer">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Réunions Dept.</p>
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-bold text-gray-900"><?php echo e($stats['myDepartmentMeetings']); ?></h3>
                            <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" stroke-width="2"/></svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-2xl hover:shadow-[#be2346]/10 hover:-translate-y-1 hover:border-[#be2346]/20 transition-all duration-300 cursor-pointer">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Réclamations</p>
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-bold text-gray-900"><?php echo e($stats['myPendingReclamations']); ?></h3>
                            <div class="p-2 bg-rose-50 text-rose-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-8">
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                                <h2 class="text-lg font-bold text-gray-900">Mes Tâches Récentes</h2>
                                <a href="<?php echo e(route('tasks.index')); ?>" class="text-sm font-semibold text-[#be2346] hover:underline">Voir tout</a>
                            </div>
                            <div class="p-6">
                                <?php $__empty_1 = true; $__currentLoopData = $myRecentTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="flex items-center justify-between p-4 mb-4 bg-gray-50 rounded-lg last:mb-0 border border-transparent hover:border-gray-200 transition-all">
                                        <div class="flex items-center gap-4">
                                            <div class="w-2 h-2 rounded-full <?php echo e($task->status === 'termine' ? 'bg-green-500' : 'bg-amber-500'); ?>"></div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-900"><?php echo e($task->titre); ?></p>
                                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-tight"><?php echo e($task->priorite); ?> • <?php echo e($task->dateDebut ? $task->dateDebut->format('d/m/Y') : 'Pas de date'); ?></p>
                                            </div>
                                        </div>
                                        <span class="text-xs font-bold text-gray-500"><?php echo e($task->status); ?></span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <p class="text-center text-gray-400 italic py-8">Aucune tâche assignée pour le moment.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100">
                                <h2 class="text-lg font-bold text-gray-900">Mes Réclamations</h2>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead class="bg-gray-50 border-b border-gray-100">
                                        <tr>
                                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Sujet</th>
                                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <?php $__empty_1 = true; $__currentLoopData = $myRecentReclamations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo e($rec->titre ?? 'Réclamation'); ?></td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2 py-1 text-[10px] font-bold rounded-full <?php echo e($rec->status === 'resolue' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'); ?>">
                                                        <?php echo e($rec->status); ?>

                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="2" class="px-6 py-8 text-center text-gray-400 italic">Aucune réclamation envoyée.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    
                    <div class="space-y-6">
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-widest mb-6">Prochaines Réunions</h2>
                            <div class="space-y-4">
                                <?php $__empty_1 = true; $__currentLoopData = $upcomingReunions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reunion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors cursor-pointer group"
                                     onclick='viewReunionDetails(<?php echo e(json_encode($reunion)); ?>)'>
                                        <div class="bg-gray-100 rounded-lg p-2 h-12 w-12 flex flex-col items-center justify-center text-[#be2346]">
                                            <span class="text-xs font-bold uppercase"><?php echo e($reunion->dateHeure->translatedFormat('M')); ?></span>
                                            <span class="text-sm font-black"><?php echo e($reunion->dateHeure->format('d')); ?></span>
                                        </div>
                                        <div class="flex-1 px-4">
                                            <p class="text-sm font-bold text-gray-900 truncate"><?php echo e($reunion->titre); ?></p>
                                            <p class="text-[10px] text-gray-400 font-medium uppercase mt-0.5"><?php echo e($reunion->dateHeure->format('H:i')); ?> • <?php echo e($reunion->lieu ?? 'Visioconférence'); ?></p>
                                        </div>
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <p class="text-xs text-gray-400 italic">Pas de réunion prévue.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="bg-gray-900 rounded-xl p-6 text-white shadow-lg">
                            <h2 class="text-xs font-bold uppercase tracking-widest mb-6 text-gray-400">Liens Utiles</h2>
                            <div class="grid grid-cols-1 gap-2">
                                <a href="<?php echo e(route('conge.index')); ?>" class="flex items-center p-3 bg-white/5 hover:bg-white/10 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-3 text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2"/></svg>
                                    <span class="text-sm font-medium">Demander un congé</span>
                                </a>
                                <a href="<?php echo e(url('/demandeDocuments')); ?>" class="flex items-center p-3 bg-white/5 hover:bg-white/10 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-3 text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2"/></svg>
                                    <span class="text-sm font-medium">Documents RH</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                
                
                
                <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

                
                <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="animate-fade-in">
                        <h1 class="text-3xl font-black text-gray-900 tracking-tight">Intelligence <span class="text-[#be2346]">Opérationnelle</span></h1>
                        <div class="flex items-center gap-4 mt-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-[#be2346]/10 text-[#be2346] uppercase tracking-widest border border-[#be2346]/20">Administration</span>
                            <span class="text-xs text-gray-400 font-medium tracking-wide italic">Dernière analyse : <?php echo e(now()->format('H:i')); ?></span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                         <a href="<?php echo e(route('reunions.index')); ?>" class="group relative inline-flex items-center px-6 py-3 bg-gray-900 text-white text-xs font-bold rounded-xl overflow-hidden transition-all hover:scale-105 active:scale-95 shadow-xl shadow-gray-900/20">
                            <div class="absolute inset-0 bg-gradient-to-r from-[#be2346] to-rose-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <span class="relative flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                Planifier une Réunion
                            </span>
                        </a>
                    </div>
                </div>

                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    
                    <div class="lg:col-span-2 bg-white p-8 rounded-[2rem] border border-gray-100 shadow-2xl shadow-gray-200/50 relative overflow-hidden hover:shadow-[#be2346]/10 hover:-translate-y-1 hover:border-[#be2346]/20 transition-all duration-300 cursor-pointer">
                        <div class="absolute top-0 right-0 p-8">
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Évolution Directe</span>
                            </div>
                        </div>
                        <h2 class="text-xl font-black text-gray-900 mb-2">Croissance de l'Effectif</h2>
                        <p class="text-xs text-gray-400 mb-8 font-medium">Évolution des inscriptions sur les 6 derniers mois</p>
                        <div id="trendChart" class="min-h-[250px]"></div>
                    </div>

                    
                    <div class="flex flex-col gap-6">
                        <div class="bg-gradient-to-br from-[#be2346] to-rose-700 p-8 rounded-[2rem] text-white shadow-xl shadow-rose-900/20 relative overflow-hidden group">
                            <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                            <p class="text-[10px] font-bold text-rose-100 uppercase tracking-widest mb-1 opacity-80">Effectif Global</p>
                            <h3 class="text-5xl font-black"><?php echo e($stats['totalEmployees']); ?></h3>
                            <div class="mt-6 flex items-center text-xs font-bold text-rose-100/70">
                                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                                +4% ce mois
                            </div>
                        </div>
                        
                        <?php
                            $perc = $stats['completionPercentage'];
                            $colorTheme = $perc >= 80 ? 'green' : ($perc >= 40 ? 'amber' : 'red');
                            $themes = [
                                'green' => [
                                    'bg' => 'bg-emerald-50', 
                                    'text' => 'text-emerald-600', 
                                    'bar' => 'bg-emerald-500', 
                                    'hoverBg' => 'group-hover/item:bg-emerald-500',
                                    'glow' => 'group-hover/item:shadow-emerald-500/20'
                                ],
                                'amber' => [
                                    'bg' => 'bg-amber-50', 
                                    'text' => 'text-amber-600', 
                                    'bar' => 'bg-amber-500', 
                                    'hoverBg' => 'group-hover/item:bg-amber-500',
                                    'glow' => 'group-hover/item:shadow-amber-500/20'
                                ],
                                'red' => [
                                    'bg' => 'bg-rose-50', 
                                    'text' => 'text-rose-600', 
                                    'bar' => 'bg-rose-500', 
                                    'hoverBg' => 'group-hover/item:bg-rose-500',
                                    'glow' => 'group-hover/item:shadow-rose-500/20'
                                ],
                            ];
                            $theme = $themes[$colorTheme];
                        ?>
                        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-xl shadow-gray-200/40 cursor-pointer group/item hover:shadow-2xl hover:shadow-[#be2346]/20 hover:-translate-y-1 hover:border-[#be2346]/20 transition-all duration-300"
                            onclick="window.location='<?php echo e(route('tasks.index')); ?>'">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 <?php echo e($theme['bg']); ?> <?php echo e($theme['text']); ?> rounded-2xl <?php echo e($theme['hoverBg']); ?> group-hover/item:text-white transition-all duration-300 group-hover/item:scale-110 shadow-sm <?php echo e($theme['glow']); ?>">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Missions</p>
                                    <h3 class="text-2xl font-black text-gray-900 group-hover/item:<?php echo e($theme['text']); ?> transition-colors duration-300"><?php echo e($stats['completedTasks']); ?> / <?php echo e($stats['totalTasks']); ?></h3>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                                <div class="<?php echo e($theme['bar']); ?> h-full rounded-full transition-all duration-1000" style="width: <?php echo e($stats['completionPercentage']); ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                    
                    <div class="bg-white p-6 rounded-[1.5rem] border border-gray-100 shadow-lg shadow-gray-100/50 hover:shadow-2xl hover:shadow-[#be2346]/15 hover:-translate-y-1 hover:border-[#be2346]/20 transition-all duration-300 cursor-pointer">
                        <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Requêtes</h2>
                        <div id="reclamationsChart" class="py-2"></div>
                    </div>

                    
                    <div class="bg-white p-6 rounded-[1.5rem] border border-gray-100 shadow-lg shadow-gray-100/50 cursor-pointer group/task hover:shadow-2xl hover:shadow-[#be2346]/15 hover:-translate-y-1 hover:border-[#be2346]/20 transition-all duration-300"
                        onclick="window.location='<?php echo e(route('tasks.index')); ?>'">
                        <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4 group-hover/task:text-[#be2346] transition-colors">Statut Tâches</h2>
                        <div id="tasksChart" class="py-2"></div>
                    </div>

                    
                    <div class="lg:col-span-2 bg-white p-6 rounded-[1.5rem] border border-gray-100 shadow-lg shadow-gray-100/50 relative overflow-hidden hover:shadow-[#be2346]/10 hover:-translate-y-1 hover:border-[#be2346]/20 transition-all duration-300 cursor-pointer">
                        <div class="absolute top-0 right-0 p-4">
                            <a href="<?php echo e(route('reunions.index')); ?>" class="text-[10px] font-bold text-[#be2346] uppercase hover:underline">Voir tout</a>
                        </div>
                        <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Calendrier des Réunions</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 pb-2">
                            <?php $__empty_1 = true; $__currentLoopData = $upcomingReunions->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reunion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="p-4 bg-gray-50 rounded-2xl border border-transparent hover:border-[#be2346]/20 hover:shadow-xl hover:shadow-[#be2346]/10 hover:-translate-y-1 transition-all duration-300 cursor-pointer group/item relative h-full flex flex-col justify-between"
                                     onclick="window.location='<?php echo e(route('reunions.show', $reunion->idReunion)); ?>'">
                                     <div>
                                         <?php if(\Carbon\Carbon::parse($reunion->dateHeure)->isPast()): ?>
                                             <div class="absolute top-2 right-2 px-1.5 py-0.5 bg-gray-200 text-[7px] font-black text-gray-500 rounded uppercase tracking-tighter">Passé</div>
                                         <?php endif; ?>
                                         <div class="flex items-center gap-3 mb-3">
                                             <div class="w-10 h-10 bg-white rounded-xl flex flex-col items-center justify-center text-[10px] font-bold text-[#be2346] shadow-sm group-hover/item:bg-[#be2346] group-hover/item:text-white transition-colors border border-gray-50">
                                                 <span class="leading-none"><?php echo e(\Carbon\Carbon::parse($reunion->dateHeure)->format('d')); ?></span>
                                                 <span class="uppercase text-[8px] opacity-60 leading-none mt-1"><?php echo e(\Carbon\Carbon::parse($reunion->dateHeure)->translatedFormat('M')); ?></span>
                                             </div>
                                             <div>
                                                 <div class="text-[11px] font-black text-gray-900 group-hover/item:text-[#be2346] transition-colors line-clamp-1"><?php echo e($reunion->titre); ?></div>
                                                 <span class="inline-block px-1.5 py-0.5 bg-white text-[7px] font-bold text-gray-400 rounded border border-gray-100 uppercase tracking-tighter mt-1"><?php echo e($reunion->type); ?></span>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter flex items-center justify-between border-t border-gray-100 pt-2">
                                         <span><?php echo e(\Carbon\Carbon::parse($reunion->dateHeure)->format('H:i')); ?></span>
                                         <span class="truncate ml-2 max-w-[80px]"><?php echo e($reunion->lieu ?? 'Bureau'); ?></span>
                                     </div>
                                 </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-[10px] text-gray-400 italic">Rien à signaler.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 bg-white rounded-[2rem] border border-gray-100 shadow-xl shadow-gray-200/50 overflow-hidden hover:shadow-[#be2346]/10 hover:-translate-y-1 hover:border-[#be2346]/20 transition-all duration-300 cursor-pointer">
                        <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center">
                            <h2 class="text-lg font-black text-gray-900">Requêtes Récentes</h2>
                            <span class="px-3 py-1 bg-gray-100 text-[10px] font-bold text-gray-500 rounded-full uppercase tracking-tighter">Flux en direct</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <tbody class="divide-y divide-gray-50">
                                    <?php $__empty_1 = true; $__currentLoopData = $recentReclamations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reclamation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="group hover:bg-[#be2346]/[0.02] transition-colors cursor-pointer" 
                                            onclick="window.location='<?php echo e(url('/reclamation/' . $reclamation->idReclamation)); ?>'">
                                            <td class="px-8 py-5">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex-shrink-0 flex items-center justify-center text-xs font-black text-gray-400 group-hover:bg-[#be2346]/10 group-hover:text-[#be2346] transition-colors">
                                                        <?php echo e(substr($reclamation->user->firstName, 0, 1)); ?><?php echo e(substr($reclamation->user->lastName, 0, 1)); ?>

                                                    </div>
                                                    <div>
                                                        <div class="font-bold text-gray-900 group-hover:text-[#be2346] transition-colors"><?php echo e($reclamation->titre ?? 'Requête'); ?></div>
                                                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-tight"><?php echo e($reclamation->user->firstName); ?> • <?php echo e($reclamation->created_at->diffForHumans()); ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-5 text-right">
                                                <span class="px-3 py-1.5 text-[9px] font-black uppercase rounded-lg 
                                                    <?php echo e($reclamation->status === 'resolue' ? 'bg-green-50 text-green-700' : ($reclamation->status === 'en_cours' ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-700')); ?>">
                                                    <?php echo e(str_replace('_', ' ', $reclamation->status)); ?>

                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr><td class="px-8 py-10 text-center text-gray-400 italic text-sm">Silence radio...</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    
                    <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-xl shadow-gray-200/50 hover:shadow-[#be2346]/10 hover:-translate-y-1 hover:border-[#be2346]/20 transition-all duration-300 cursor-pointer">
                        <h2 class="text-lg font-black text-gray-900 mb-6">Répartition Dept.</h2>
                        <div id="deptChart"></div>
                    </div>
                </div>

                
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const colors = { primary: '#be2346', secondary: '#fbbf24', success: '#10b981', gray: '#94a3b8' };

                        // 1. GROWTH TREND CHART (Stylish Area Chart)
                        new ApexCharts(document.querySelector("#trendChart"), {
                            series: [{
                                name: 'Nouveaux Inscrits',
                                data: [<?php $__currentLoopData = $trendData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($data['count']); ?>, <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>]
                            }],
                            chart: {
                                type: 'area',
                                height: 250,
                                toolbar: { show: false },
                                sparkline: { enabled: false },
                                dropShadow: { enabled: true, top: 10, left: 0, blur: 4, color: colors.primary, opacity: 0.1 }
                            },
                            stroke: { curve: 'smooth', width: 4, colors: [colors.primary] },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.4,
                                    opacityTo: 0,
                                    stops: [0, 90, 100],
                                    colorStops: [
                                        { offset: 0, color: colors.primary, opacity: 0.4 },
                                        { offset: 100, color: colors.primary, opacity: 0 }
                                    ]
                                }
                            },
                            dataLabels: { enabled: false },
                            xaxis: {
                                categories: [<?php $__currentLoopData = $trendData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> '<?php echo e($data['month']); ?>', <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
                                axisBorder: { show: false },
                                axisTicks: { show: false }
                            },
                            yaxis: { show: false },
                            grid: { show: false }
                        }).render();

                        // 2. RECLAMATIONS DONUT
                        new ApexCharts(document.querySelector("#reclamationsChart"), {
                            series: [<?php echo e($reclamationsByStatus['ouverte']); ?>, <?php echo e($reclamationsByStatus['en_cours']); ?>, <?php echo e($reclamationsByStatus['resolue']); ?>],
                            chart: { type: 'donut', height: 180 },
                            labels: ['Ouverte', 'En cours', 'Résolue'],
                            colors: ['#ef4444', '#f59e0b', '#10b981'],
                            legend: { show: false },
                            dataLabels: { enabled: false },
                            plotOptions: { pie: { donut: { size: '80%' } } }
                        }).render();

                        // 3. TASKS BAR
                        new ApexCharts(document.querySelector("#tasksChart"), {
                            series: [{ data: [<?php echo e($tasksByStatus['en_attente']); ?>, <?php echo e($tasksByStatus['en_cours']); ?>, <?php echo e($tasksByStatus['termine']); ?>] }],
                            chart: { type: 'bar', height: 150, toolbar: { show: false } },
                            plotOptions: { bar: { borderRadius: 4, columnWidth: '50%', distributed: true } },
                            colors: [colors.gray, colors.secondary, colors.primary],
                            legend: { show: false },
                            xaxis: { categories: ['Attente', 'En cours', 'Terminé'], labels: { style: { fontSize: '9px', fontWeight: 900 } } },
                            yaxis: { show: false },
                            grid: { show: false }
                        }).render();

                        // 4. DEPT CHART
                        new ApexCharts(document.querySelector("#deptChart"), {
                            series: [{ data: [<?php $__currentLoopData = $deptStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($dept['count']); ?>, <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>] }],
                            chart: { type: 'bar', height: 280, toolbar: { show: false } },
                            plotOptions: { bar: { borderRadius: 6, horizontal: true, barHeight: '25%' } },
                            colors: [colors.primary],
                            xaxis: { categories: [<?php $__currentLoopData = $deptStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> '<?php echo e($dept['name']); ?>', <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>] },
                            dataLabels: { enabled: true, style: { fontSize: '9px' } }
                        }).render();
                    });
                </script>

                <style>
                    .animate-fade-in { animation: fadeIn 0.8s ease-out; }
                    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
                    .scrollbar-hide::-webkit-scrollbar { display: none; }
                    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
                </style>
            <?php endif; ?>

    
    <div id="viewReunionModal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeReunionModal()"></div>
        <div class="relative bg-white w-full max-w-lg rounded-[40px] shadow-2xl overflow-hidden flex flex-col z-10 animate-modal-in border border-white/20">
            <div class="p-8 md:p-10">
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
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <span class="text-sm font-black uppercase tracking-[0.1em]">Rejoindre la réunion</span>
                            </div>
                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>

                <div class="flex gap-4">
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
    </script>

    
    <style>
        @keyframes modal-in {
            from { opacity: 0; transform: scale(0.95) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-modal-in { animation: modal-in 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
    </style>
    
        </div>
    </div>
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
<?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/dashboard.blade.php ENDPATH**/ ?>