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
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ts-control {
            border-radius: 0.75rem !important; /* rounded-xl */
            padding: 0.625rem 1rem !important; /* px-4 py-2.5 */
            background-color: #ffffff !important; /* bg-white */
            border: 1px solid #E2E8F0 !important; /* border-slate-200 */
            font-size: 0.875rem !important; /* text-sm */
            transition: all 0.2s ease !important;
        }
        .ts-wrapper.focus .ts-control {
            border-color: rgba(177, 29, 64, 0.4) !important; /* focus:border-[#b11d40]/40 */
            box-shadow: 0 0 0 4px rgba(177, 29, 64, 0.1) !important; /* focus:ring-4 focus:ring-[#b11d40]/10 */
        }
    </style>
    <div class="p-8 bg-[#F8FAFC] min-h-screen">

        
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Gestion des Primes</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Gérez et suivez les primes et bonus attribués aux employés.</p>
            </div>
            <div class="flex gap-3">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prime.create')): ?>
                <button onclick="document.getElementById('modal-create-prime').classList.remove('hidden')"
                        class="flex items-center gap-2 px-4 py-2 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Attribuer une Prime
                </button>
                <?php endif; ?>
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

        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-wider">Total Attribué</p>
                        <p class="text-xl font-black text-slate-800"><?php echo e(number_format($primes->sum('montant'), 2)); ?> MAD</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-wider">En Attente</p>
                        <p class="text-xl font-black text-slate-800"><?php echo e($primes->where('status', 'en_attente')->count()); ?></p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-wider">Payées</p>
                        <p class="text-xl font-black text-slate-800"><?php echo e($primes->where('status', 'payee')->count()); ?></p>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4 mb-6">
            <form id="primeFilterForm" action="<?php echo e(route('primes.index')); ?>" method="GET" class="flex flex-nowrap items-center gap-3 overflow-x-auto pb-2 custom-scrollbar">
                
                <div class="flex-1 min-w-[180px] shrink-0 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="searchInput" value="<?php echo e(request('search')); ?>"
                        placeholder="Rechercher..."
                        class="block w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-2xl text-sm transition-all focus:border-[#be2346]/40 focus:ring-4 focus:ring-[#be2346]/10 outline-none">
                </div>

                
                <div class="relative shrink-0">
                    <select name="status" onchange="fetchPrimes()"
                        class="filter-select appearance-none bg-white border border-slate-200 rounded-xl pl-4 pr-10 py-2 text-xs font-bold text-slate-600 outline-none transition-all focus:border-[#be2346]/40 focus:ring-4 focus:ring-[#be2346]/10 cursor-pointer">
                        <option value="">Status (Tous)</option>
                        <option value="en_attente" <?php echo e(request('status') == 'en_attente' ? 'selected' : ''); ?>>Attente</option>
                        <option value="validee" <?php echo e(request('status') == 'validee' ? 'selected' : ''); ?>>Validée</option>
                        <option value="payee" <?php echo e(request('status') == 'payee' ? 'selected' : ''); ?>>Payée</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>

                
                <div class="relative min-w-[110px] shrink-0">
                    <select name="role" onchange="fetchPrimes()"
                        class="filter-select appearance-none bg-white border border-slate-200 rounded-xl pl-4 pr-10 py-2 text-xs font-bold text-slate-600 outline-none transition-all focus:border-[#be2346]/40 focus:ring-4 focus:ring-[#be2346]/10 cursor-pointer w-full">
                        <option value="">Rôle (Tous)</option>
                        <option value="admin" <?php echo e(request('role') == 'admin' ? 'selected' : ''); ?>>Admin</option>
                        <option value="manager" <?php echo e(request('role') == 'manager' ? 'selected' : ''); ?>>Manager</option>
                        <option value="employee" <?php echo e(request('role') == 'employee' ? 'selected' : ''); ?>>Employé</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>

                
                <div class="relative min-w-[130px] shrink-0">
                    <select name="departement" onchange="fetchPrimes()"
                        class="filter-select appearance-none bg-white border border-slate-200 rounded-xl pl-4 pr-10 py-2 text-xs font-bold text-slate-600 outline-none transition-all focus:border-[#be2346]/40 focus:ring-4 focus:ring-[#be2346]/10 cursor-pointer w-full">
                        <option value="">Dép. (Tous)</option>
                        <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($dept->idDepartement); ?>" <?php echo e(request('departement') == $dept->idDepartement ? 'selected' : ''); ?>><?php echo e($dept->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>

                
                <div class="min-w-[130px] shrink-0">
                    <select name="post" id="filter-post">
                        <option value="">Poste (Tous)</option>
                        <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($post); ?>" <?php echo e(request('post') == $post ? 'selected' : ''); ?>><?php echo e($post); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div class="min-w-[160px] shrink-0">
                    <select name="user_id" id="filter-user_id">
                        <option value="">Employé (Tous)</option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->idUser); ?>" <?php echo e(request('user_id') == $user->idUser ? 'selected' : ''); ?>>
                                <?php echo e($user->firstName); ?> <?php echo e($user->lastName); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <a href="<?php echo e(route('primes.index')); ?>" id="resetFilters"
                    class="p-2 rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-all flex items-center justify-center shadow-sm shrink-0"
                    title="Réinitialiser">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </a>
            </form>
        </div>

        
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50">
                            <th class="text-left px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Employé</th>
                            <th class="text-left px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Montant</th>
                            <th class="text-left px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Motif & Référence</th>
                            <th class="text-left px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Statut</th>
                            <th class="text-left px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Date</th>
                            <th class="text-right px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50" id="prime-tbody">
                        <?php echo $__env->make('primes.partials.table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div id="modal-create-prime" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg flex flex-col overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
            <div class="p-6 flex justify-between items-center border-b border-slate-100">
                <h2 class="text-lg font-extrabold text-slate-800">Attribuer une Prime</h2>
                <button onclick="document.getElementById('modal-create-prime').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form action="<?php echo e(route('primes.store')); ?>" method="POST" class="p-6 space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Employé *</label>
                    <select name="idUser" id="create-idUser" required class="w-full">
                        <option value="">— Choisir un employé —</option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->idUser); ?>"><?php echo e($user->firstName); ?> <?php echo e($user->lastName); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Montant (MAD) *</label>
                        <input type="number" name="montant" step="0.01" required placeholder="0.00" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Statut *</label>
                        <select name="status" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                            <option value="en_attente">En Attente</option>
                            <option value="validee">Validée</option>
                            <option value="payee">Payée</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Motif</label>
                    <input type="text" name="motif" placeholder="Ex: Performance exceptionnelle" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#b11d40]">
                </div>
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="document.getElementById('modal-create-prime').classList.add('hidden')" class="flex-1 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">Annuler</button>
                    <button type="submit" class="flex-1 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">Attribuer</button>
                </div>
            </form>
        </div>
    </div>

    
    <div id="modal-edit-prime" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
        <div class="relative bg-white w-full max-w-lg rounded-[32px] shadow-2xl overflow-hidden flex flex-col max-h-[92vh]">
            
            <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Modifier la Prime</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Mise à jour · Access Morocco</p>
                </div>
                <button type="button" onclick="document.getElementById('modal-edit-prime').classList.add('hidden')"
                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] hover:border-[#be2346]/30 transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="overflow-y-auto">
                <form id="edit-prime-form" method="POST" class="p-7 space-y-5">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    
                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Employé <span class="text-[#be2346]">*</span></label>
                        <select name="idUser" id="edit-idUser" required class="w-full">
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->idUser); ?>"><?php echo e($user->firstName); ?> <?php echo e($user->lastName); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Montant (MAD) <span class="text-[#be2346]">*</span></label>
                            <input type="number" name="montant" id="edit-montant" step="0.01" required 
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>
                        
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Statut <span class="text-[#be2346]">*</span></label>
                            <select name="status" id="edit-status" required 
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 appearance-none">
                                <option value="en_attente">En Attente</option>
                                <option value="validee">Validée</option>
                                <option value="payee">Payée</option>
                            </select>
                        </div>
                    </div>

                    
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Motif</label>
                        <input type="text" name="motif" id="edit-motif" 
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                    </div>

                    
                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="document.getElementById('modal-edit-prime').classList.add('hidden')" 
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

    
    <div id="modal-show-prime" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-2xl flex flex-col overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
            <div class="p-6 flex justify-between items-center border-b border-slate-100">
                <h2 class="text-lg font-extrabold text-slate-800">Détails de la Prime</h2>
                <button onclick="document.getElementById('modal-show-prime').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-8 space-y-6">
                
                <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
                    <div id="show-user-avatar" class="w-16 h-16 rounded-xl bg-white flex items-center justify-center font-black text-xl text-[#b11d40] shadow-sm"></div>
                    <div>
                        <h3 id="show-user-name" class="text-lg font-black text-slate-800"></h3>
                        <p id="show-user-post" class="text-[10px] text-slate-400 uppercase font-black tracking-widest"></p>
                    </div>
                </div>

                
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Montant</p>
                        <p id="show-montant" class="text-2xl font-black text-slate-800"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Statut</p>
                        <span id="show-status" class="inline-flex px-3 py-1 rounded-xl text-[10px] font-black uppercase"></span>
                    </div>
                </div>

                
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Motif</p>
                    <p id="show-motif" class="text-sm text-slate-600 italic bg-slate-50 p-4 rounded-xl border-l-4 border-[#b11d40]"></p>
                </div>

                
                <div id="show-reference-container" class="hidden">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Référence Liée</p>
                    <div id="show-reference-content" class="p-4 rounded-xl border border-slate-100 flex items-center gap-3"></div>
                </div>

                
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Date d'attribution</p>
                    <p id="show-date" class="text-sm font-bold text-slate-700"></p>
                </div>
            </div>
            <div class="p-6 border-t border-slate-100 bg-slate-50 flex justify-end">
                <button onclick="document.getElementById('modal-show-prime').classList.add('hidden')" class="px-6 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-100 transition-all text-sm">Fermer</button>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        let searchTimeout = null;
        const filterForm = document.getElementById('primeFilterForm');

        function fetchPrimes() {
            const url = new URL(filterForm.action);
            const params = new URLSearchParams(new FormData(filterForm));
            url.search = params.toString();

            const tbody = document.getElementById('prime-tbody');
            if (tbody) tbody.style.opacity = '0.5';

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                if (tbody) {
                    tbody.innerHTML = html;
                    tbody.style.opacity = '1';
                }
            });
        }

        document.getElementById('searchInput').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                fetchPrimes();
            }, 400);
        });

        document.addEventListener('DOMContentLoaded', () => {
            tomSelectCreate = new TomSelect('#create-idUser', {
                create: false,
                placeholder: "— Rechercher un employé —",
                sortField: { field: "text", direction: "asc" }
            });
            tomSelectEdit = new TomSelect('#edit-idUser', {
                create: false,
                placeholder: "— Rechercher un employé —",
                sortField: { field: "text", direction: "asc" }
            });
            const tsUser = new TomSelect('#filter-user_id', {
                create: false,
                placeholder: "Employé (Tous)",
                sortField: { field: "text", direction: "asc" }
            });
            tsUser.on('change', () => fetchPrimes());

            const tsPost = new TomSelect('#filter-post', {
                create: false,
                placeholder: "Poste (Tous)",
                sortField: { field: "text", direction: "asc" }
            });
            tsPost.on('change', () => fetchPrimes());
        });

        function openShowModal(prime) {
            const modal = document.getElementById('modal-show-prime');
            
            // User info
            document.getElementById('show-user-name').textContent = `${prime.user.firstName} ${prime.user.lastName}`;
            document.getElementById('show-user-post').textContent = prime.user.post || 'N/A';
            document.getElementById('show-user-avatar').textContent = (prime.user.firstName[0] + prime.user.lastName[0]).toUpperCase();
            
            // Basic info
            document.getElementById('show-montant').textContent = new Intl.NumberFormat('fr-MA', { style: 'currency', currency: 'MAD' }).format(prime.montant);
            document.getElementById('show-motif').textContent = prime.motif || 'Aucun motif spécifié';
            document.getElementById('show-date').textContent = new Date(prime.dateAttribution).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' });

            // Status style
            const statusEl = document.getElementById('show-status');
            statusEl.textContent = prime.status.replace('_', ' ').toUpperCase();
            statusEl.className = 'inline-flex px-3 py-1 rounded-xl text-[10px] font-black uppercase ';
            if (prime.status === 'en_attente') statusEl.classList.add('bg-amber-100', 'text-amber-700');
            else if (prime.status === 'validee') statusEl.classList.add('bg-blue-100', 'text-blue-700');
            else if (prime.status === 'payee') statusEl.classList.add('bg-emerald-100', 'text-emerald-700');

            // Reference
            const refContainer = document.getElementById('show-reference-container');
            const refContent = document.getElementById('show-reference-content');
            refContainer.classList.add('hidden');
            refContent.innerHTML = '';

            if (prime.idTache && prime.tache) {
                refContainer.classList.remove('hidden');
                refContent.innerHTML = `<div class="p-2 rounded-lg bg-blue-50 text-blue-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg></div><div><p class="text-xs font-bold text-slate-800">${prime.tache.titre}</p><p class="text-[10px] text-slate-400">Tâche associée</p></div>`;
            } else if (prime.idPointage && prime.pointage) {
                refContainer.classList.remove('hidden');
                refContent.innerHTML = `<div class="p-2 rounded-lg bg-purple-50 text-purple-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div><div><p class="text-xs font-bold text-slate-800">Pointage du ${new Date(prime.pointage.date).toLocaleDateString()}</p><p class="text-[10px] text-slate-400">Pointage associé</p></div>`;
            } else if (prime.idObjectif && prime.objectif) {
                refContainer.classList.remove('hidden');
                refContent.innerHTML = `<div class="p-2 rounded-lg bg-emerald-50 text-emerald-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></div><div><p class="text-xs font-bold text-slate-800">${prime.objectif.titre}</p><p class="text-[10px] text-slate-400">Objectif associé</p></div>`;
            }

            modal.classList.remove('hidden');
        }

        function openEditModal(prime) {
            const modal = document.getElementById('modal-edit-prime');
            const form = document.getElementById('edit-prime-form');
            
            form.action = `/primes/${prime.idPrime}`;
            
            if (tomSelectEdit) {
                tomSelectEdit.setValue(prime.idUser);
            } else {
                document.getElementById('edit-idUser').value = prime.idUser;
            }

            document.getElementById('edit-montant').value = prime.montant;
            document.getElementById('edit-status').value = prime.status;
            document.getElementById('edit-motif').value = prime.motif || '';
            
            modal.classList.remove('hidden');
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
<?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/primes/index.blade.php ENDPATH**/ ?>