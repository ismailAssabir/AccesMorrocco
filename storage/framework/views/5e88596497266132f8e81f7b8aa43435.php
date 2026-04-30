<?php $__env->startSection('title', 'Mon Profil — Espace Client'); ?>
<?php $__env->startSection('page-title', 'Mon Profil'); ?>
<?php $__env->startSection('page-subtitle', 'Gérez vos informations personnelles'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl">
    <div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

        <div class="p-8 border-b border-slate-100">
            <h2 class="text-lg font-black text-slate-800 text-center">Informations Personnelles</h2>
        </div>

        <div class="p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-2">Prénom</label>
                    <div class="px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-slate-700"><?php echo e($client->firstName); ?></div>
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-2">Nom</label>
                    <div class="px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-slate-700"><?php echo e($client->lastName); ?></div>
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-2">Email</label>
                    <div class="px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-slate-700"><?php echo e($client->email); ?></div>
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-2">Téléphone</label>
                    <div class="px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-slate-700"><?php echo e($client->phoneNumber ?? '—'); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dell\Desktop\PROJECTS\AccesMorrocco\resources\views/clients/profile.blade.php ENDPATH**/ ?>