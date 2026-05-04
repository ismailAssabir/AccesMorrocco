
<div id="addDepartmentModal"
     class="fixed inset-0 z-[100] <?php echo e($errors->any() ? '' : 'hidden'); ?> flex items-center justify-center p-4"
     role="dialog" aria-modal="true" aria-labelledby="deptModalTitle">

    
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeDeptModal()"></div>

    
    <div class="relative bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden flex flex-col max-h-[92vh] z-10"
         style="animation: modalIn .2s ease-out">

        
        <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
            <div>
                <h2 class="text-lg font-black text-slate-800" id="deptModalTitle">Nouveau Département</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Fiche de création · Access Morocco</p>
            </div>
            <button type="button" onclick="closeDeptModal()"
                class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] hover:border-[#be2346]/30 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <?php
            $users = \App\Models\User::with('departementManager')->orderBy('firstName')->get();
        ?>
        
        <div class="overflow-y-auto">
            <form action="<?php echo e(route('departements.store')); ?>" method="POST" class="p-7 space-y-5">
                <?php echo csrf_field(); ?>

                
                <div class="space-y-1.5">
                    <label for="dept_title" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">
                        Nom du département <span class="text-[#be2346]">*</span>
                    </label>
                    <input type="text" name="title" id="dept_title" required value="<?php echo e(old('title')); ?>"
                           placeholder="Ex: Ressources Humaines"
                           class="w-full bg-slate-50 border <?php echo e($errors->has('title') ? 'border-red-400' : 'border-slate-200'); ?> rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-xs text-red-500 font-semibold ml-1 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="space-y-1.5">
                    <label for="dept_description" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Description</label>
                    <textarea name="description" id="dept_description" rows="3"
                              placeholder="Missions et objectifs de ce département..."
                              class="w-full bg-slate-50 border <?php echo e($errors->has('description') ? 'border-red-400' : 'border-slate-200'); ?> rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5"><?php echo e(old('description')); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-xs text-red-500 font-semibold ml-1 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="space-y-1.5">
                    <label for="dept_manager" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Manager / Responsable</label>
                    <div class="relative">
                        <select name="idUser" id="dept_manager"
                                class="w-full bg-slate-50 border <?php echo e($errors->has('idUser') ? 'border-red-400' : 'border-slate-200'); ?> rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
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
                    <?php $__errorArgs = ['idUser'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-xs text-red-500 font-semibold ml-1 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeDeptModal()"
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

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const createForm = document.querySelector('#addDepartmentModal form');
        
        if (createForm) {
            createForm.addEventListener('submit', function(e) {
                const select = document.getElementById('dept_manager');
                if (!select.value) return; 
                
                const selectedOption = select.options[select.selectedIndex];
                const managedDept = selectedOption.getAttribute('data-current-department');
                const managerName = selectedOption.text.trim();
                
                if (managedDept && managedDept !== '') {
                    e.preventDefault();
                    
                    // Use openGlobalDeleteModal for custom text and theme
                    openGlobalDeleteModal(
                        null, 
                        'Remplacer le Manager ?', 
                        `${managerName} est déjà manager du département "${managedDept}". En confirmant, il sera transféré à ce nouveau département.`,
                        'Confirmer le transfert',
                        'info',
                        'switch'
                    );
                    
                    // Override the form submission logic
                    const confirmBtn = document.getElementById('deleteModalConfirmBtn');
                    confirmBtn.onclick = function(event) {
                        event.preventDefault();
                        createForm.submit();
                    };
                }
            });
        }
    });
</script>
<?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/departements/create.blade.php ENDPATH**/ ?>