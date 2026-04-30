
<div id="editDepartmentModal"
     class="fixed inset-0 z-[100] <?php echo e(($errors->any() && old('_method') === 'PUT') ? '' : 'hidden'); ?> flex items-center justify-center p-4"
     role="dialog" aria-modal="true" aria-labelledby="editDeptModalTitle">

    
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeEditDeptModal()"></div>

    
    <div class="relative bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden flex flex-col max-h-[92vh] z-10"
         style="animation: modalIn .2s ease-out">

        
        <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
            <div>
                <h2 class="text-lg font-black text-slate-800" id="editDeptModalTitle">Modifier Département</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Mise à jour · Access Morocco</p>
            </div>
            <button type="button" onclick="closeEditDeptModal()"
                class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] hover:border-[#be2346]/30 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <?php
            $users = \App\Models\User::with('departementManager')->orderBy('firstName')->get();
        ?>
        
        <div class="overflow-y-auto">
            <form id="editDepartmentForm" action="<?php echo e(old('edit_url', '#')); ?>" method="POST" class="p-7 space-y-5">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                
                <input type="hidden" name="edit_url" id="edit_url_input" value="<?php echo e(old('edit_url')); ?>">

                
                <div class="space-y-1.5">
                    <label for="edit_dept_title" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">
                        Nom du département <span class="text-[#be2346]">*</span>
                    </label>
                    <input type="text" name="title" id="edit_dept_title" required value="<?php echo e(old('title')); ?>"
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 <?php if($errors->has('title') && old('_method') === 'PUT'): ?> border-red-400 <?php endif; ?>">
                    <?php if($errors->has('title') && old('_method') === 'PUT'): ?>
                        <p class="text-xs text-red-500 font-semibold ml-1 mt-1"><?php echo e($errors->first('title')); ?></p>
                    <?php endif; ?>
                </div>

                
                <div class="space-y-1.5">
                    <label for="edit_dept_description" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Description</label>
                    <textarea name="description" id="edit_dept_description" rows="3"
                              class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 <?php if($errors->has('description') && old('_method') === 'PUT'): ?> border-red-400 <?php endif; ?>"><?php echo e(old('description')); ?></textarea>
                    <?php if($errors->has('description') && old('_method') === 'PUT'): ?>
                        <p class="text-xs text-red-500 font-semibold ml-1 mt-1"><?php echo e($errors->first('description')); ?></p>
                    <?php endif; ?>
                </div>

                
                <div class="space-y-1.5">
                    <label for="edit_dept_manager" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Manager / Responsable</label>
                    <div class="relative">
                        <select name="idUser" id="edit_dept_manager"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 <?php if($errors->has('idUser') && old('_method') === 'PUT'): ?> border-red-400 <?php endif; ?>">
                            <option value="">— Sans manager pour le moment —</option>
                            <?php if(isset($users)): ?>
                                
                                <?php $__currentLoopData = $users->filter(fn($u) => strtolower($u->type ?? '') === 'manager'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $uid   = $user->idUser ?? $user->id;
                                        $uName = trim(($user->firstName ?? '') . ' ' . ($user->lastName ?? '')) ?: 'Utilisateur';
                                        $managedDept = $user->departementManager ? $user->departementManager->title : '';
                                    ?>
                                    <option value="<?php echo e($uid); ?>" <?php echo e(old('idUser') == $uid ? 'selected' : ''); ?> data-current-department="<?php echo e(htmlspecialchars($managedDept, ENT_QUOTES)); ?>">
                                        <?php echo e($uName); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                        <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                    <?php if($errors->has('idUser') && old('_method') === 'PUT'): ?>
                        <p class="text-xs text-red-500 font-semibold ml-1 mt-1"><?php echo e($errors->first('idUser')); ?></p>
                    <?php endif; ?>
                </div>

                
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeEditDeptModal()"
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

<script>
    function openEditDeptModal(id) {
        // Build the URLs
        const url = '<?php echo e(url("/departements/edit")); ?>/' + id;

        // Fetch data via AJAX
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Fetch failed');
            return response.json();
        })
        .then(data => {
            // Populate inputs
            document.getElementById('edit_dept_title').value = data.title || '';
            document.getElementById('edit_dept_description').value = data.description || '';
            document.getElementById('edit_dept_manager').value = data.idUser || '';
            
            // Set form action and hidden URL input
            document.getElementById('editDepartmentForm').action = url;
            document.getElementById('edit_url_input').value = url;

            // Open modal
            document.getElementById('editDepartmentModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Impossible de charger les données du département.');
        });
    }

    function closeEditDeptModal() {
        document.getElementById('editDepartmentModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const editForm = document.getElementById('editDepartmentForm');
        
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                const select = document.getElementById('edit_dept_manager');
                if (!select.value) return; 
                
                const selectedOption = select.options[select.selectedIndex];
                const managedDept = selectedOption.getAttribute('data-current-department');
                const managerName = selectedOption.text.trim();
                
                const currentEditDeptName = document.getElementById('edit_dept_title').value.trim();
                
                if (managedDept && managedDept !== '' && managedDept !== currentEditDeptName) {
                    e.preventDefault();
                    
                    // Use openGlobalDeleteModal for custom text and theme
                    openGlobalDeleteModal(
                        null, 
                        'Remplacer le Manager ?', 
                        `${managerName} est déjà manager du département "${managedDept}". En confirmant, il sera transféré à ce département.`,
                        'Confirmer le transfert',
                        'info',
                        'switch'
                    );
                    
                    // Override the form submission logic
                    const confirmBtn = document.getElementById('deleteModalConfirmBtn');
                    confirmBtn.onclick = function(event) {
                        event.preventDefault();
                        editForm.submit();
                    };
                }
            });
        }
    });
</script>
<?php /**PATH C:\Users\dell\Desktop\PROJECTS\AccesMorrocco\resources\views/departements/edit_modal.blade.php ENDPATH**/ ?>