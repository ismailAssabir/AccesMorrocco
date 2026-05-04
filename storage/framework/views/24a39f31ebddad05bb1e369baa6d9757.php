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
    <div class="p-8 bg-[#F8FAFC] min-h-screen">

        
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Gestion des Catégories</h1>
                <p class="text-slate-500 text-sm">Liste de toutes vos catégories</p>
            </div>
            <div class="flex gap-3">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category.view')): ?>
                <a href="<?php echo e(route('categories.export-pdf')); ?>"
                    class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Exporter PDF
                </a>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category.create')): ?>
                <button onclick="document.getElementById('modal-create').classList.remove('hidden')"
                        class="flex items-center gap-2 px-4 py-2 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nouvelle Catégorie
                </button>
                <?php endif; ?>
            </div>
        </div>

        
        <?php if(session('msg')): ?>
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm font-semibold">
                <?php echo e(session('msg')); ?>

            </div>
        <?php endif; ?>

        
        <div class="mb-6 bg-white border border-slate-200 rounded-2xl shadow-sm p-4">
            <div class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Rechercher</label>
                    <div class="relative">
                        <input type="text" 
                               id="search-input"
                               placeholder="Rechercher par titre ou description..." 
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] pl-10">
                        <svg class="absolute left-3 top-3 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="w-full md:w-48">
                    <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Trier par</label>
                    <select id="sort-select" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        <option value="nom_asc">Titre (A → Z)</option>
                        <option value="nom_desc">Titre (Z → A)</option>
                        <option value="created_desc">Plus récent</option>
                        <option value="created_asc">Plus ancien</option>
                    </select>
                </div>
                <button id="reset-filters" class="px-4 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all text-sm">
                    Réinitialiser
                </button>
            </div>
        </div>

        
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm" id="categories-table">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50">
                            <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[10%]">N°</th>
                            <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[30%]">Titre</th>
                            <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[40%]">Description</th>
                            <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider w-[20%]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50" id="categories-tbody">
                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50 transition-colors category-row" 
                        data-id="<?php echo e($category->id); ?>" 
                        data-nom="<?php echo e(\Illuminate\Support\Str::lower($category->nom)); ?>" 
                        data-desc="<?php echo e(\Illuminate\Support\Str::lower($category->desc ?? '')); ?>" 
                        data-created="<?php echo e($category->created_at ? $category->created_at->timestamp : 0); ?>">                            
                            <td class="px-4 py-4 font-mono text-xs text-slate-600">
                                <?php echo e($loop->iteration); ?>

                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-[#b11d40]/10 flex items-center justify-center flex-shrink-0">
                                        <span class="text-[#b11d40] font-black text-xs">
                                            <?php echo e(strtoupper(substr($category->nom, 0, 2))); ?>

                                        </span>
                                    </div>
                                    <p class="font-bold text-slate-800"><?php echo e($category->nom); ?></p>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-slate-600">
                                <?php
                                    $maxLength = 50;
                                    $description = $category->desc ?: '—';
                                ?>
                                
                                <?php if(strlen($description) > $maxLength): ?>
                                    <div class="flex items-center gap-2">
                                        <span class="inline-block">
                                            <?php echo e(substr($description, 0, $maxLength)); ?>...
                                        </span>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category.view')): ?>
                                        <a href="<?php echo e(route('categories.show', $category)); ?>" 
                                           class="text-[#b11d40] hover:text-[#7c1233] text-xs font-semibold inline-flex items-center gap-1 transition-colors">
                                            Voir plus
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <?php echo e($description); ?>

                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-1">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category.view')): ?>
                                    <a href="<?php echo e(route('categories.show', $category)); ?>"
                                       class="p-1.5 rounded-lg text-slate-400 hover:text-green-600 hover:bg-green-50 transition-all"
                                       title="Voir les détails">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category.edit')): ?>
                                    <a href="<?php echo e(route('categories.edit', $category)); ?>"
                                       class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all"
                                       title="Modifier">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category.delete')): ?>
                                    <form action="<?php echo e(route('categories.destroy', $category)); ?>" method="POST" class="inline-block" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all" title="Supprimer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr id="no-results-row">
                            <td colspan="4" class="px-6 py-16 text-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                                <p class="font-bold text-slate-500">Aucune catégorie trouvée</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category.create')): ?>
    <div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-extrabold text-slate-800">Nouvelle Catégorie</h2>
                    <button onclick="document.getElementById('modal-create').classList.add('hidden')"
                            class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="<?php echo e(route('categories.store')); ?>">
                    <?php echo csrf_field(); ?>

                    <?php if($errors->any()): ?>
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl text-xs font-bold">
                            <ul class="list-disc pl-4 space-y-1">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Titre *</label>
                            <input type="text" name="nom" required placeholder="Ex: Hôtels, Vols, Séjours..."
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]"
                                   value="<?php echo e(old('nom')); ?>">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Description</label>
                            <textarea name="desc" rows="4" placeholder="Description de la catégorie..."
                                      class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] resize-none"><?php echo e(old('desc')); ?></textarea>
                        </div>
                    </div>

                    <div class="flex gap-3 justify-end mt-6">
                        <button type="button" onclick="document.getElementById('modal-create').classList.add('hidden')"
                                class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                            Annuler
                        </button>
                        <button type="submit"
                                class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">
                            Créer la Catégorie
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

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

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const searchInput = document.getElementById('search-input');
        const sortSelect = document.getElementById('sort-select');
        const resetButton = document.getElementById('reset-filters');
        const tbody = document.getElementById('categories-tbody');

        let rows = Array.from(document.querySelectorAll('.category-row'));
        let currentRows = [...rows];

        // 🔎 FILTRER
        function filterRows() {
            const searchTerm = searchInput.value.toLowerCase().trim();

            currentRows = rows.filter(row => {
                if (searchTerm === '') return true;

                const nom = row.getAttribute('data-nom') || '';
                const desc = row.getAttribute('data-desc') || '';

                return nom.includes(searchTerm) || desc.includes(searchTerm);
            });

            sortRows();
        }

        // 🔃 TRIER
        function sortRows() {
            const sortValue = sortSelect.value;

            currentRows.sort((a, b) => {

                const nomA = a.getAttribute('data-nom') || '';
                const nomB = b.getAttribute('data-nom') || '';

                const dateA = parseInt(a.getAttribute('data-created')) || 0;
                const dateB = parseInt(b.getAttribute('data-created')) || 0;

                switch (sortValue) {
                    case 'nom_asc':
                        return nomA.localeCompare(nomB);

                    case 'nom_desc':
                        return nomB.localeCompare(nomA);

                    case 'created_desc':
                        return dateB - dateA;

                    case 'created_asc':
                        return dateA - dateB;

                    default:
                        return 0;
                }
            });

            displayRows();
        }

        // 🖥️ AFFICHER
        function displayRows() {
            tbody.innerHTML = '';

            if (currentRows.length === 0) {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td colspan="4" class="px-6 py-16 text-center text-slate-400">
                        <p class="font-bold text-slate-500">Aucune catégorie trouvée</p>
                    </td>
                `;
                tbody.appendChild(tr);
                return;
            }

            currentRows.forEach((row, index) => {
                row.style.display = '';

                const numberCell = row.querySelector('td:first-child');
                if (numberCell) {
                    numberCell.textContent = index + 1;
                }

                tbody.appendChild(row);
            });
        }

        // 🔄 RESET
        function resetFilters() {
            searchInput.value = '';
            sortSelect.value = 'nom_asc';
            currentRows = [...rows];

            // 👉 IMPORTANT: revenir à l'affichage simple
            tbody.innerHTML = '';
            rows.forEach((row, index) => {
                const numberCell = row.querySelector('td:first-child');
                if (numberCell) {
                    numberCell.textContent = index + 1;
                }
                tbody.appendChild(row);
            });
        }

        // ⚡ debounce
        let timeout;
        searchInput.addEventListener('input', () => {
            clearTimeout(timeout);
            timeout = setTimeout(filterRows, 250);
        });

        sortSelect.addEventListener('change', sortRows);
        resetButton.addEventListener('click', resetFilters);

        // 🚀 IMPORTANT : affichage initial SIMPLE (sans tri)
        tbody.innerHTML = '';
        rows.forEach((row, index) => {
            const numberCell = row.querySelector('td:first-child');
            if (numberCell) {
                numberCell.textContent = index + 1;
            }
            tbody.appendChild(row);
        });

    });
</script>

<style>
.category-row {
    transition: all 0.2s ease;
}

#search-input, #sort-select {
    transition: all 0.2s ease;
}

#search-input:focus, #sort-select:focus {
    box-shadow: 0 0 0 3px rgba(177, 29, 64, 0.1);
}
</style><?php /**PATH C:\Users\dell\Desktop\AccesMorrocco\resources\views/AllCategories.blade.php ENDPATH**/ ?>