<?php $__env->startSection('title', 'Tableau de bord — Espace Client'); ?>
<?php $__env->startSection('page-title', 'Tableau de bord'); ?>
<?php $__env->startSection('page-subtitle', 'Suivez vos dossiers et paiements'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $totalDossiers   = $dossiers->total();
    $enCours         = $dossiers->getCollection()->where('status', 'en_cours')->count();
    $termines        = $dossiers->getCollection()->where('status', 'ferme')->count();
    $totalPaiements  = $dossiers->getCollection()->sum(fn($d) => $d->montant ?? 0);
?>




<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

    <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
        <span class="p-2.5 rounded-xl bg-[#b11d40]/10 text-[#b11d40] shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
        </span>
        <div>
            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Dossiers</p>
            <p class="text-2xl font-extrabold text-slate-800"><?php echo e($totalDossiers); ?></p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
        <span class="p-2.5 rounded-xl bg-amber-50 text-amber-500 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </span>
        <div>
            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">En cours</p>
            <p class="text-2xl font-extrabold text-slate-800"><?php echo e($enCours); ?></p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
        <span class="p-2.5 rounded-xl bg-emerald-50 text-emerald-500 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </span>
        <div>
            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Terminés</p>
            <p class="text-2xl font-extrabold text-slate-800"><?php echo e($termines); ?></p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
        <span class="p-2.5 rounded-xl bg-blue-50 text-blue-500 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
        </span>
        <div>
            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Total</p>
            <p class="text-2xl font-extrabold text-slate-800"><?php echo e(number_format($totalPaiements, 0, ',', ' ')); ?> <span class="text-sm text-slate-400">MAD</span></p>
        </div>
    </div>
</div>


<div class="mb-8 relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-8 md:p-10 text-white shadow-2xl">
    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
        <div class="max-w-lg">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#be2346]/20 border border-[#be2346]/30 text-[#be2346] text-[10px] font-black uppercase tracking-widest mb-4">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#be2346] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#be2346]"></span>
                </span>
                Nouveau : Journal de Voyage
            </div>
            <h2 class="text-3xl md:text-4xl font-black mb-4 leading-tight">Capturez vos plus beaux <span class="text-[#be2346]">souvenirs</span> au Maroc.</h2>
            <p class="text-slate-400 text-sm font-medium leading-relaxed">Racontez vos histoires, téléchargez vos photos et gardez une trace indélébile de chaque moment spécial de votre voyage avec nous.</p>
            
            <div class="mt-8 flex flex-wrap gap-8">
                <div class="flex items-center gap-4 group">
                    <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-[#be2346] group-hover:scale-110 transition-transform duration-500 shadow-xl">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-0.5">Moments sauvés</p>
                        <p class="text-xl font-black text-white"><?php echo e($souvenirsCount ?? 0); ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-4 group">
                    <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-[#be2346] group-hover:scale-110 transition-transform duration-500 shadow-xl">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-0.5">Photos partagées</p>
                        <p class="text-xl font-black text-white"><?php echo e($souvenirsCount ?? 0); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <a href="<?php echo e(route('clients.souvenirs.index')); ?>" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-[#be2346] text-white rounded-2xl font-black text-sm shadow-xl shadow-[#be2346]/40 hover:scale-[1.05] active:scale-95 transition-all">
                Ouvrir mon journal
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M14 5l7 7-7 7" stroke-width="3" /></svg>
            </a>
            <p class="text-center text-[10px] text-slate-500 font-bold uppercase tracking-tighter italic">"Le voyage est la seule chose qu'on achète qui nous rend plus riche."</p>
        </div>
    </div>

    
    <div class="absolute -right-20 -top-20 w-80 h-80 bg-[#be2346]/10 rounded-full blur-[100px]"></div>
    <div class="absolute -left-20 -bottom-20 w-60 h-60 bg-blue-500/5 rounded-full blur-[80px]"></div>
</div>


<div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

    
    <div class="p-6 flex items-center justify-between border-b border-slate-100">
        <div>
            <h2 class="text-base font-extrabold text-slate-800">Mes dossiers de voyage</h2>
            <p class="text-xs text-slate-400 mt-0.5"><?php echo e($totalDossiers); ?> dossier<?php echo e($totalDossiers > 1 ? 's' : ''); ?> au total</p>
        </div>
        <a href="<?php echo e(route('clients.dossiers')); ?>"
           class="inline-flex items-center gap-1.5 text-xs font-bold text-[#b11d40] border border-[#b11d40]/30 hover:bg-[#b11d40] hover:text-white px-4 py-2 rounded-xl transition-all duration-200">
            Voir tout
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    <?php if($dossiers->count() > 0): ?>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/60">
                    <th class="text-left px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Référence</th>
                    <th class="text-left px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Destination</th>
                    <th class="text-left px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Date voyage</th>
                    <th class="text-left px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Personnes</th>
                    <th class="text-left px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Montant</th>
                    <th class="text-left px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Statut</th>
                    <th class="text-right px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__currentLoopData = $dossiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dossier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $statusConfig = match($dossier->status) {
                        'ouvert'   => ['label' => 'Ouvert',    'class' => 'bg-blue-50 text-blue-600'],
                        'en_cours' => ['label' => 'En cours',  'class' => 'bg-amber-50 text-amber-600'],
                        'ferme'    => ['label' => 'Terminé',   'class' => 'bg-emerald-50 text-emerald-600'],
                        default    => ['label' => $dossier->status, 'class' => 'bg-slate-100 text-slate-500'],
                    };
                ?>
                <tr class="hover:bg-slate-50/60 transition-colors">

                    
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-[#b11d40]/10 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-[#b11d40]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                            </div>
                            <span class="font-black text-slate-800 text-xs"><?php echo e($dossier->reference); ?></span>
                        </div>
                    </td>

                    
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-700"><?php echo e($dossier->distination ?? '—'); ?></p>
                    </td>

                    
                    <td class="px-6 py-4">
                        <p class="text-slate-600">
                            <?php echo e($dossier->date_voyage ? \Carbon\Carbon::parse($dossier->date_voyage)->format('d/m/Y') : '—'); ?>

                        </p>
                    </td>

                    
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-slate-600 font-medium"><?php echo e($dossier->nombre_personne); ?></span>
                        </div>
                    </td>

                    
                    <td class="px-6 py-4">
                        <span class="font-black text-slate-800"><?php echo e(number_format($dossier->montant ?? 0, 0, ',', ' ')); ?></span>
                        <span class="text-xs text-slate-400 ml-1">MAD</span>
                    </td>

                    
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-black <?php echo e($statusConfig['class']); ?>">
                            <?php echo e($statusConfig['label']); ?>

                        </span>
                    </td>

                    
                    <td class="px-6 py-4 text-right">
                        <a href="<?php echo e(route('clients.dossiers.show', $dossier->idDossier)); ?>"
                           class="inline-flex items-center gap-1.5 text-xs font-bold text-[#b11d40] border border-[#b11d40]/30 hover:bg-[#b11d40] hover:text-white px-4 py-2 rounded-xl transition-all duration-200 active:scale-95">
                            Détails
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    
    <?php if($dossiers->hasPages()): ?>
    <div class="px-6 py-4 border-t border-slate-100">
        <?php echo e($dossiers->links()); ?>

    </div>
    <?php endif; ?>

    <?php else: ?>
    
    <div class="flex flex-col items-center justify-center py-20 px-8 text-center">
        <div class="w-20 h-20 rounded-3xl bg-[#b11d40]/10 flex items-center justify-center mb-5">
            <svg class="w-10 h-10 text-[#b11d40]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
        </div>
        <h3 class="text-xl font-extrabold text-slate-800">Aucun dossier</h3>
        <p class="text-slate-500 mt-2 max-w-sm text-sm">Vous n'avez pas encore de dossier de voyage.</p>
    </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dell\Desktop\AccesMorrocco\resources\views/clients/dashboard.blade.php ENDPATH**/ ?>