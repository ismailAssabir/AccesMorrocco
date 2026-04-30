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
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Gestion des Réclamations</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Liste complète des requêtes envoyées.</p>
            </div>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('reclamation.create')): ?>
            <button onclick="toggleModal('addReclamationModal')" class="flex items-center gap-2 bg-[#be2346] hover:bg-[#a01d3a] text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md active:scale-95 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Nouvelle Réclamation
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

        
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4 mb-8">
            <div class="flex flex-nowrap items-center gap-3 overflow-x-auto pb-2 custom-scrollbar">
                
                <div class="flex-1 min-w-[200px] shrink-0 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="searchInput" oninput="debounceFilter()" 
                        placeholder="Rechercher par sujet..." 
                        class="block w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-2xl text-sm transition-all focus:border-[#be2346]/40 focus:ring-4 focus:ring-[#be2346]/10 outline-none">
                </div>

                
                <div class="relative shrink-0">
                    <select id="statusFilter" onchange="fetchFilteredReclamations()" 
                        class="appearance-none bg-white border border-slate-200 rounded-xl pl-4 pr-10 py-2 text-xs font-bold text-slate-600 outline-none transition-all focus:border-[#be2346]/40 focus:ring-4 focus:ring-[#be2346]/10 cursor-pointer">
                        <option value="">Statut (Tous)</option>
                        <option value="ouverte">Ouverte</option>
                        <option value="en_cours">En Cours</option>
                        <option value="resolue">Résolue</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>

                
                <div class="relative shrink-0">
                    <select id="priorityFilter" onchange="fetchFilteredReclamations()" 
                        class="appearance-none bg-white border border-slate-200 rounded-xl pl-4 pr-10 py-2 text-xs font-bold text-slate-600 outline-none transition-all focus:border-[#be2346]/40 focus:ring-4 focus:ring-[#be2346]/10 cursor-pointer">
                        <option value="">Priorité (Tous)</option>
                        <option value="basse">Basse</option>
                        <option value="moyenne">Moyenne</option>
                        <option value="haute">Haute</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>

                
                <button type="button" onclick="resetFilters()" class="p-2 rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-all flex items-center justify-center shadow-sm shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden mb-8">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50">
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Sujet</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Priorité</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Statut</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Date</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="reclamations-table-body" class="divide-y divide-slate-100">
                    <?php echo $__env->make('partials.reclamations-table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </tbody>
            </table>
        </div>

        <div id="addReclamationModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('addReclamationModal')"></div>
            <div class="relative flex items-center justify-center min-h-screen p-4">
                <div class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden flex flex-col max-h-[92vh] z-10" style="animation: modalIn .2s ease-out">
                    
                    
                    <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                        <div>
                            <h2 class="text-lg font-black text-slate-800">Soumettre une réclamation</h2>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Nouveau · Access Morocco</p>
                        </div>
                        <button type="button" onclick="toggleModal('addReclamationModal')"
                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] transition-all">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    
                    <div class="overflow-y-auto">
                        <form action="/reclamations" method="POST" enctype="multipart/form-data" class="p-7 space-y-5">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="idUser" value="<?php echo e(Auth::user()->idUser); ?>">
                            
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Sujet de la demande (Max 20 car.)</label>
                                <input type="text" name="titre" required maxlength="20" placeholder="Ex: Problème badge" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                            
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Priorité</label>
                                <select name="priorite" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                    <option value="basse">Basse</option>
                                    <option value="moyenne" selected>Moyenne</option>
                                    <option value="haute">Haute</option>
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Description détaillée</label>
                                <textarea name="description" rows="4" required placeholder="Expliquez votre problème ici..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5"></textarea>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Pièce jointe (Optionnel)</label>
                                <div class="relative group">
                                    <input type="file" name="fichier" id="reclamationFileInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="updateReclamationFileName(this)">
                                    <div class="w-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl px-4 py-5 flex items-center justify-center gap-3 transition-all group-hover:border-[#be2346]/30 group-hover:bg-[#be2346]/5">
                                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-[#be2346] group-hover:border-[#be2346]/20 transition-all shadow-sm">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-sm font-bold text-slate-600 group-hover:text-[#be2346] transition-all" id="recFileNameDisplay">Choisir un fichier</p>
                                            <p class="text-[10px] text-slate-400 font-medium">PDF, JPG, PNG (Max. 5MB)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-3 pt-4">
                                <button type="button" onclick="toggleModal('addReclamationModal')"
                                    class="flex-1 py-4 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm">
                                    Annuler
                                </button>
                                <button type="submit" class="flex-1 py-4 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] text-white font-black transition-all shadow-lg shadow-[#be2346]/20 text-sm">
                                    Sauvegarder
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <script>
        let debounceTimer;

        function debounceFilter() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetchFilteredReclamations();
            }, 400);
        }

        function fetchFilteredReclamations() {
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            const priorite = document.getElementById('priorityFilter').value;
            
            const container = document.getElementById('reclamations-table-body');
            container.style.opacity = '0.5';

            let url = `/reclamations?search=${encodeURIComponent(search)}&status=${status}&priorite=${priorite}`;

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
                container.style.opacity = '1';
            })
            .catch(error => {
                console.error('Error fetching filtered reclamations:', error);
                container.style.opacity = '1';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('priorityFilter').value = '';
            fetchFilteredReclamations();
        }

        function toggleModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.toggle('hidden');
                document.body.style.overflow = modal.classList.contains('hidden') ? 'auto' : 'hidden';
            }
        }

        function confirmDeleteReclamation(id) {
            window.confirmDelete(`/reclamation/delete/${id}`, 'réclamation');
        }

        function updateReclamationFileName(input) {
            const display = document.getElementById('recFileNameDisplay');
            if (input.files && input.files.length > 0) {
                display.innerText = input.files[0].name;
                display.classList.remove('text-slate-600');
                display.classList.add('text-[#be2346]');
            } else {
                display.innerText = 'Choisir un fichier';
                display.classList.remove('text-[#be2346]');
                display.classList.add('text-slate-600');
            }
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
<?php endif; ?><?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/AllReclamations.blade.php ENDPATH**/ ?>