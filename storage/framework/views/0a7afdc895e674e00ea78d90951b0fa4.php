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
        <div class="max-w-4xl mx-auto">
            
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-800">Détails de la Réclamation</h1>
                    <p class="text-slate-500 text-sm mt-1 font-medium">Référence: #REC-<?php echo e(str_pad($Reclamation->idReclamation, 5, '0', STR_PAD_LEFT)); ?></p>
                </div>
                <a href="<?php echo e(url('/reclamations')); ?>" class="flex items-center gap-2 text-slate-500 hover:text-slate-800 transition-colors font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour à la liste
                </a>
            </div>

            
            <div class="mb-6">
                <?php if(session('msg')): ?>
                    <div id="success-alert" class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-2xl font-bold text-sm flex items-center gap-3 transition-all duration-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <?php echo e(session('msg')); ?>

                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div id="error-alert" class="p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl font-bold text-sm transition-all duration-500">
                        <ul class="list-disc list-inside">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white border border-slate-200 rounded-[32px] shadow-sm p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-black text-slate-800"><?php echo e($Reclamation->titre); ?></h2>
                            <span class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-wider <?php echo e($Reclamation->status == 'resolue' ? 'bg-emerald-100 text-emerald-600' : ($Reclamation->status == 'en_cours' ? 'bg-amber-100 text-amber-600' : 'bg-blue-100 text-blue-600')); ?>">
                                <?php echo e(str_replace('_', ' ', $Reclamation->status)); ?>

                            </span>
                        </div>
                        
                        <div class="prose prose-slate max-w-none">
                            <h3 class="text-[10px] font-black uppercase text-slate-400 mb-2">Description</h3>
                            <p class="text-slate-600 leading-relaxed bg-slate-50 p-6 rounded-2xl border border-slate-100 italic">
                                "<?php echo e($Reclamation->description); ?>"
                            </p>
                        </div>

                        <?php if($Reclamation->reponse): ?>
                        <div class="mt-8 pt-8 border-t border-slate-100">
                            <h3 class="text-[10px] font-black uppercase text-[#be2346] mb-2 text-right">Réponse de l'administration</h3>
                            <div class="bg-red-50/50 p-6 rounded-2xl border border-red-100 text-slate-700 font-medium">
                                <?php echo e($Reclamation->reponse); ?>

                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if($Reclamation->fichier): ?>
                    <div class="bg-white border border-slate-200 rounded-[32px] shadow-sm p-8">
                        <h3 class="text-[10px] font-black uppercase text-slate-400 mb-4">Pièce jointe</h3>
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-[#be2346]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-700">Document joint</p>
                                    <p class="text-[10px] text-slate-400">Cliquer pour télécharger</p>
                                </div>
                            </div>
                            <a href="<?php echo e(asset('storage/' . $Reclamation->fichier)); ?>" target="_blank" class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-xs font-black text-slate-600 hover:bg-slate-50 transition-colors">
                                Ouvrir
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                
                <div class="space-y-6">
                    <div class="bg-white border border-slate-200 rounded-[32px] shadow-sm p-8">
                        <h3 class="text-[10px] font-black uppercase text-slate-400 mb-6">Informations</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <p class="text-[10px] font-black uppercase text-slate-400 mb-1">Priorité</p>
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full <?php echo e($Reclamation->priorite == 'haute' ? 'bg-red-500' : ($Reclamation->priorite == 'moyenne' ? 'bg-amber-500' : 'bg-blue-500')); ?>"></div>
                                    <span class="text-sm font-bold text-slate-700 capitalize"><?php echo e($Reclamation->priorite); ?></span>
                                </div>
                            </div>

                            <div>
                                <p class="text-[10px] font-black uppercase text-slate-400 mb-1">Date d'envoi</p>
                                <p class="text-sm font-bold text-slate-700"><?php echo e($Reclamation->created_at->format('d M Y, H:i')); ?></p>
                            </div>

                            <?php if($Reclamation->user): ?>
                            <div class="pt-6 border-t border-slate-100">
                                <p class="text-[10px] font-black uppercase text-slate-400 mb-3">Soumis par</p>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-[#be2346]/10 rounded-full flex items-center justify-center text-[#be2346] font-black text-xs">
                                        <?php echo e(substr($Reclamation->user->firstName, 0, 1)); ?><?php echo e(substr($Reclamation->user->lastName, 0, 1)); ?>

                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-700"><?php echo e($Reclamation->user->firstName); ?> <?php echo e($Reclamation->user->lastName); ?></p>
                                        <p class="text-[10px] text-slate-400"><?php echo e($Reclamation->user->post ?? 'Employé'); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="bg-slate-900 rounded-[32px] p-8 shadow-xl shadow-slate-200">
                        <h3 class="text-[10px] font-black uppercase text-slate-400 mb-4">Actions rapides</h3>
                        <div class="space-y-3">
                            <?php if(auth()->user()->type === 'admin' || auth()->user()->type === 'manager'): ?>
                                <button onclick="toggleModal('replyReclamationModal')" class="w-full py-3 bg-[#be2346] text-white rounded-xl text-xs font-black hover:bg-[#a01d3a] transition-all">
                                    <?php echo e($Reclamation->reponse ? 'Modifier la réponse' : 'Répondre'); ?>

                                </button>
                            <?php endif; ?>
                            <button onclick="toggleModal('deleteReclamationModal')" class="w-full py-3 bg-white/10 text-white rounded-xl text-xs font-black hover:bg-white/20 transition-all border border-white/10">
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div id="deleteReclamationModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('deleteReclamationModal')"></div>
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white w-full max-w-md rounded-[32px] shadow-2xl p-8 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-red-500"></div>
                
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center text-red-500 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    
                    <h2 class="text-xl font-black text-slate-800 mb-2">Confirmer la suppression</h2>
                    <p class="text-slate-500 text-sm font-medium mb-8">Êtes-vous sûr de vouloir supprimer cette réclamation ? Cette action est irréversible.</p>
                    
                    <div class="flex w-full gap-3">
                        <button onclick="toggleModal('deleteReclamationModal')" class="flex-1 py-3.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-black transition-all">
                            Annuler
                        </button>
                        <form action="/reclamation/delete/<?php echo e($Reclamation->idReclamation); ?>" method="POST" class="flex-1">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="w-full py-3.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-black transition-all shadow-lg shadow-red-200">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    
    <div id="replyReclamationModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('replyReclamationModal')"></div>
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white w-full max-w-lg rounded-[32px] shadow-2xl p-8 relative">
                <button onclick="toggleModal('replyReclamationModal')" class="absolute top-6 right-6 p-2 rounded-full hover:bg-slate-100 text-slate-400 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <h2 class="text-xl font-black text-slate-800 mb-2">Répondre à la réclamation</h2>
                <p class="text-slate-500 text-sm font-medium mb-6">La réclamation sera automatiquement marquée comme <span class="text-emerald-600">résolue</span>.</p>
                
                <form action="/reclamation/reponse/<?php echo e($Reclamation->idReclamation); ?>" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Votre réponse</label>
                        <textarea name="reponse" rows="6" required placeholder="Tapez votre réponse ici..." class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#be2346]/20 outline-none transition-all"><?php echo e($Reclamation->reponse); ?></textarea>
                    </div>

                    <button type="submit" class="w-full py-4 rounded-xl bg-[#be2346] hover:bg-[#a01d3a] text-white font-black transition-all shadow-lg shadow-[#be2346]/20">Envoyer la réponse</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.toggle('hidden');
                document.body.style.overflow = modal.classList.contains('hidden') ? 'auto' : 'hidden';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            function fadeAndRemove(elementId) {
                const el = document.getElementById(elementId);
                if (el) {
                    setTimeout(() => {
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(-10px)';
                        setTimeout(() => el.remove(), 500);
                    }, 4000);
                }
            }
            fadeAndRemove('success-alert');
            fadeAndRemove('error-alert');
        });
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
<?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/showReclamation.blade.php ENDPATH**/ ?>