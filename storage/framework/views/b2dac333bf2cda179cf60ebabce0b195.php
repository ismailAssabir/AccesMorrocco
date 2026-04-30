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
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900" 
         x-data="{ 
            showModal: <?php echo e($errors->any() ? 'true' : 'false'); ?>, 
            showEditModal: false,
            view: 'board',
            search: '',
            priority: '',
            status: '',
            dept: '',
            user: '',
            loading: false,

            
            deptSearch: '',
            userSearch: '',
            showDeptOptions: false,
            showUserOptions: false,

            departements: <?php echo e(json_encode($departements)); ?>,
            users: <?php echo e(json_encode($users)); ?>,

            get filteredDepts() {
                if (!this.deptSearch) return this.departements;
                return this.departements.filter(d => d.title.toLowerCase().includes(this.deptSearch.toLowerCase()));
            },

            get filteredUsers() {
                if (!this.userSearch) return this.users;
                return this.users.filter(u => 
                    (u.firstName + ' ' + u.lastName).toLowerCase().includes(this.userSearch.toLowerCase())
                );
            },

            get selectedDeptName() {
                const d = this.departements.find(x => x.idDepartement == this.dept);
                return d ? d.title : 'Département';
            },

            get selectedUserName() {
                const u = this.users.find(x => x.idUser == this.user);
                return u ? u.firstName + ' ' + u.lastName : 'Assigné à';
            },

            currentTask: { titre: '', idTache: '', description: '', priorite: 'moyenne', status: 'todo', start_date: '', end_date: '', typeDuree: 'jours', idDepartement: '', idObjectif: '' },
            
            init() {
                this.$watch('search', () => this.debounceFetch());
                this.$watch('priority', () => this.fetchTasks());
                this.$watch('status', () => this.fetchTasks());
                this.$watch('dept', () => this.fetchTasks());
                this.$watch('user', () => this.fetchTasks());
                this.$watch('view', () => this.fetchTasks());
            },

            debounceTimer: null,
            debounceFetch() {
                clearTimeout(this.debounceTimer);
                this.debounceTimer = setTimeout(() => this.fetchTasks(), 400);
            },

            async fetchTasks(page = 1) {
                this.loading = true;
                const url = `<?php echo e(route('tasks.index')); ?>?view=${this.view}&search=${encodeURIComponent(this.search)}&priority=${this.priority}&status=${this.status}&idDepartement=${this.dept}&idUser=${this.user}&page=${page}`;
                
                try {
                    const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    const html = await res.text();
                    document.getElementById('tasks-container').innerHTML = html;
                    this.bindPagination();
                } catch (err) {
                    console.error('Error:', err);
                } finally {
                    this.loading = false;
                }
            },

            bindPagination() {
                document.querySelectorAll('.tasks-pagination a').forEach(link => {
                    link.onclick = (e) => {
                        e.preventDefault();
                        const url = new URL(link.href);
                        this.fetchTasks(url.searchParams.get('page'));
                    };
                });
            },
            
            openEditModal(task) {
                this.currentTask = {
                    ...task,
                    start_date: task.dateDebut ? task.dateDebut.replace(' ', 'T').substring(0, 16) : '',
                    end_date: task.duree ? task.duree.replace(' ', 'T').substring(0, 16) : ''
                };
                this.showEditModal = true;
            },

            confirmDelete(id) {
                window.confirmDelete('/tasks/' + id, 'tâche');
            },

            async changeStatus(id, newStatus, event) {
                const btn = event.currentTarget;
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<svg class=\'animate-spin w-4 h-4\' xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\'><circle class=\'opacity-25\' cx=\'12\' cy=\'12\' r=\'10\' stroke=\'currentColor\' stroke-width=\'4\'></circle><path class=\'opacity-75\' fill=\'currentColor\' d=\'M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z\'></path></svg>';
                btn.disabled = true;

                try {
                    await fetch(`/tasks/${id}/status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ status: newStatus })
                    });
                    this.fetchTasks();
                } catch (err) {
                    btn.innerHTML = originalHtml;
                    btn.disabled = false;
                }
            }
         }">

        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Gestion des Tâches</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Suivez l'avancement des projets et des assignations.</p>
            </div>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tache.create')): ?>
            <button @click="showModal = true" class="flex items-center gap-2 bg-[#be2346] hover:bg-[#a01d3a] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#be2346]/20 text-sm whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter une Tâche
            </button>
            <?php endif; ?>
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

        
        <div class="bg-white border border-slate-200 rounded-[24px] shadow-sm p-4 mb-8 flex flex-wrap items-center gap-4">
            
            <div class="flex-1 min-w-[200px] relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" x-model="search" placeholder="Rechercher une tâche..." 
                    class="block w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm transition-all focus:border-[#be2346]/40 focus:ring-4 focus:ring-[#be2346]/10 outline-none">
            </div>

            
            <div class="flex flex-wrap items-center gap-3">
                <select x-model="priority" class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-[11px] font-bold uppercase tracking-widest text-slate-500 outline-none focus:border-[#be2346]/40 focus:ring-4 focus:ring-[#be2346]/10 transition-all appearance-none cursor-pointer">
                    <option value="">Priorité</option>
                    <option value="basse">Basse</option>
                    <option value="moyenne">Moyenne</option>
                    <option value="haute">Haute</option>
                </select>

                <select x-model="status" class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-[11px] font-bold uppercase tracking-widest text-slate-500 outline-none focus:border-[#be2346]/40 focus:ring-4 focus:ring-[#be2346]/10 transition-all appearance-none cursor-pointer">
                    <option value="">Statut</option>
                    <option value="todo">À Faire</option>
                    <option value="en_cours">En Cours</option>
                    <option value="termine">Terminé</option>
                </select>

                <?php if(auth()->user()->type !== 'employee'): ?>
                
                <div class="relative min-w-[150px]" @click.away="showDeptOptions = false">
                    <button @click="showDeptOptions = !showDeptOptions" type="button" 
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-[11px] font-bold uppercase tracking-widest text-slate-500 flex items-center justify-between outline-none transition-all focus:border-[#be2346]/40 focus:ring-4 focus:ring-[#be2346]/10"
                        :class="showDeptOptions ? 'border-[#be2346]/40 ring-4 ring-[#be2346]/10' : ''">
                        <span x-text="selectedDeptName"></span>
                        <svg class="w-3 h-3 ml-2 transition-transform" :class="showDeptOptions ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="showDeptOptions" x-cloak class="absolute z-[110] mt-2 w-full bg-white border border-slate-200 rounded-xl shadow-xl p-2 animate-in fade-in zoom-in duration-200">
                        <input type="text" x-model="deptSearch" placeholder="Chercher..." class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg mb-2 outline-none transition-all focus:border-[#be2346]/40">
                        <div class="max-h-48 overflow-y-auto custom-scrollbar">
                            <template x-for="d in filteredDepts" :key="d.idDepartement">
                                <button @click="dept = d.idDepartement; showDeptOptions = false; deptSearch = ''" type="button" class="w-full text-left px-3 py-2 text-[10px] font-bold uppercase hover:bg-slate-50 rounded-lg transition-colors" :class="dept == d.idDepartement ? 'text-[#be2346] bg-[#be2346]/5' : 'text-slate-600'">
                                    <span x-text="d.title"></span>
                                </button>
                            </template>
                            <button @click="dept = ''; showDeptOptions = false; deptSearch = ''" type="button" class="w-full text-left px-3 py-2 text-[10px] font-bold uppercase hover:bg-slate-50 rounded-lg text-slate-400">
                                <span>Tous les départements</span>
                            </button>
                        </div>
                    </div>
                </div>

                
                <div class="relative min-w-[150px]" @click.away="showUserOptions = false">
                    <button @click="showUserOptions = !showUserOptions" type="button" 
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-[11px] font-bold uppercase tracking-widest text-slate-500 flex items-center justify-between outline-none transition-all focus:border-[#b11d40]/40 focus:ring-4 focus:ring-[#b11d40]/10"
                        :class="showUserOptions ? 'border-[#b11d40]/40 ring-4 ring-[#b11d40]/10' : ''">
                        <span x-text="selectedUserName"></span>
                        <svg class="w-3 h-3 ml-2 transition-transform" :class="showUserOptions ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="showUserOptions" x-cloak class="absolute z-[110] mt-2 w-full bg-white border border-slate-200 rounded-xl shadow-xl p-2 animate-in fade-in zoom-in duration-200">
                        <input type="text" x-model="userSearch" placeholder="Chercher..." class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg mb-2 outline-none transition-all focus:border-[#b11d40]/40">
                        <div class="max-h-48 overflow-y-auto custom-scrollbar">
                            <template x-for="u in filteredUsers" :key="u.idUser">
                                <button @click="user = u.idUser; showUserOptions = false; userSearch = ''" type="button" class="w-full text-left px-3 py-2 text-[10px] font-bold uppercase hover:bg-slate-50 rounded-lg transition-colors" :class="user == u.idUser ? 'text-[#be2346] bg-[#be2346]/5' : 'text-slate-600'">
                                    <span x-text="u.firstName + ' ' + u.lastName"></span>
                                </button>
                            </template>
                            <button @click="user = ''; showUserOptions = false; userSearch = ''" type="button" class="w-full text-left px-3 py-2 text-[10px] font-bold uppercase hover:bg-slate-50 rounded-lg text-slate-400">
                                <span>Tous les employés</span>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            
            <div class="ml-auto flex items-center bg-slate-50 p-1 rounded-xl border border-slate-100 shrink-0">
                <button type="button" @click="view = 'board'" :class="view === 'board' ? 'bg-white text-[#be2346] shadow-sm' : 'text-slate-400 hover:text-slate-600'" class="p-2 rounded-lg transition-all" title="Vue Tableau">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7" /></svg>
                </button>
                <button type="button" @click="view = 'table'" :class="view === 'table' ? 'bg-white text-[#be2346] shadow-sm' : 'text-slate-400 hover:text-slate-600'" class="p-2 rounded-lg transition-all" title="Vue Liste">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                </button>
            </div>
        </div>

        
        <div id="tasks-container" class="transition-opacity duration-300" :style="loading ? 'opacity: 0.5' : 'opacity: 1'">
            <?php echo $__env->make('taches.partials.board', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        
        <div x-show="showModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all" x-cloak x-transition>
            <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-2xl overflow-hidden border border-slate-100 flex flex-col max-h-[92vh] z-10" @click.away="showModal = false" style="animation: modalIn .2s ease-out">
                
                
                <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                    <div>
                        <h2 class="text-lg font-black text-slate-800">Nouvelle Tâche</h2>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Planification · Access Morocco</p>
                    </div>
                    <button @click="showModal = false"
                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] hover:border-[#be2346]/30 transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                
                <div class="overflow-y-auto">
                    <form action="<?php echo e(route('tasks.store')); ?>" method="POST" class="p-7 space-y-5">
                        <?php echo csrf_field(); ?>
                        
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Titre de la tâche <span class="text-[#be2346]">*</span></label>
                            <input type="text" name="titre" required value="<?php echo e(old('titre')); ?>" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5" placeholder="Ex: Rapport mensuel">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Priorité</label>
                                <select name="priorite" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="basse" <?php echo e(old('priorite') == 'basse' ? 'selected' : ''); ?>>Basse</option>
                                    <option value="moyenne" <?php echo e(old('priorite') == 'moyenne' || !old('priorite') ? 'selected' : ''); ?>>Moyenne</option>
                                    <option value="haute" <?php echo e(old('priorite') == 'haute' ? 'selected' : ''); ?>>Haute</option>
                                </select>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Status Initial</label>
                                <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="todo" <?php echo e(old('status') == 'todo' ? 'selected' : ''); ?>>À Faire</option>
                                    <option value="en_cours" <?php echo e(old('status') == 'en_cours' ? 'selected' : ''); ?>>En Cours</option>
                                    <option value="termine" <?php echo e(old('status') == 'termine' ? 'selected' : ''); ?>>Terminé</option>
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Département Responsable <span class="text-[#be2346]">*</span></label>
                                <select name="idDepartement" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="">Choisir un département</option>
                                    <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($dept->idDepartement); ?>" <?php echo e(old('idDepartement') == $dept->idDepartement ? 'selected' : ''); ?>><?php echo e($dept->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Assigner à (Optionnel)</label>
                                <select name="idUser" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="">Non assigné</option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->idUser); ?>" <?php echo e(old('idUser') == $user->idUser ? 'selected' : ''); ?>><?php echo e($user->firstName); ?> <?php echo e($user->lastName); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Date début</label>
                                <input type="datetime-local" name="start_date" value="<?php echo e(old('start_date')); ?>" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Échéance</label>
                                <input type="datetime-local" name="end_date" value="<?php echo e(old('end_date')); ?>" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Type de Durée</label>
                                <select name="typeDuree" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="jours" <?php echo e(old('typeDuree') == 'jours' ? 'selected' : ''); ?>>Jours</option>
                                    <option value="h" <?php echo e(old('typeDuree') == 'h' ? 'selected' : ''); ?>>Heures</option>
                                    <option value="mois" <?php echo e(old('typeDuree') == 'mois' ? 'selected' : ''); ?>>Mois</option>
                                </select>
                            </div>
                            
                            <div class="md:col-span-2 space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Objectif lié</label>
                                <select name="idObjectif" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="">Aucun objectif</option>
                                    <?php $__currentLoopData = $objectifs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objectif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($objectif->idObjectif); ?>" <?php echo e(old('idObjectif') == $objectif->idObjectif ? 'selected' : ''); ?>><?php echo e($objectif->titre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Description</label>
                            <textarea name="description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5" placeholder="Détails de la tâche..."><?php echo e(old('description')); ?></textarea>
                        </div>

                        
                        <div class="flex gap-3 pt-4">
                            <button type="button" @click="showModal = false"
                                class="flex-1 py-4 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm">
                                Annuler
                            </button>
                            <button type="submit"
                                class="flex-1 py-4 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-[#be2346]/20 text-sm">
                                Sauvegarder
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all" x-show="showEditModal" x-cloak x-transition>
            <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-2xl overflow-hidden border border-slate-100 flex flex-col max-h-[92vh]" @click.away="showEditModal = false" style="animation: modalIn .2s ease-out">
                
                
                <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                    <div>
                        <h2 class="text-lg font-black text-slate-800">Modifier la Tâche</h2>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Édition · Access Morocco</p>
                    </div>
                    <button @click="showEditModal = false"
                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                
                <div class="overflow-y-auto">
                    <form :action="'/tasks/' + currentTask.idTache" method="POST" class="p-7 space-y-5">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Titre de la tâche</label>
                            <input type="text" name="titre" required x-model="currentTask.titre" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Priorité</label>
                                <select name="priorite" x-model="currentTask.priorite" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="basse">Basse</option>
                                    <option value="moyenne">Moyenne</option>
                                    <option value="haute">Haute</option>
                                </select>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Status</label>
                                <select name="status" x-model="currentTask.status" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="todo">À Faire</option>
                                    <option value="en_cours">En Cours</option>
                                    <option value="termine">Terminé</option>
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Département</label>
                                <select name="idDepartement" x-model="currentTask.idDepartement" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="">Choisir un département</option>
                                    <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($dept->idDepartement); ?>"><?php echo e($dept->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Objectif lié</label>
                                <select name="idObjectif" x-model="currentTask.idObjectif" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="">Aucun objectif</option>
                                    <?php $__currentLoopData = $objectifs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objectif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($objectif->idObjectif); ?>"><?php echo e($objectif->titre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date début</label>
                                <input type="datetime-local" name="start_date" x-model="currentTask.start_date" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Échéance</label>
                                <input type="datetime-local" name="end_date" x-model="currentTask.end_date" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Type de Durée</label>
                                <select name="typeDuree" x-model="currentTask.typeDuree" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="jours">Jours</option>
                                    <option value="h">Heures</option>
                                    <option value="mois">Mois</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Description</label>
                            <textarea name="description" rows="3" x-model="currentTask.description" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5"></textarea>
                        </div>

                        
                        <div class="flex gap-3 pt-4">
                            <button type="button" @click="showEditModal = false"
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
<?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/taches/index.blade.php ENDPATH**/ ?>