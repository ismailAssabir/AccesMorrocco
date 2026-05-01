<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié — Access Morocco</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-[#F8FAFC] min-h-screen flex items-center justify-center font-sans p-4">
    <div class="w-full max-w-md">

        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
            <div class="p-8">

                <div class="text-center mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#b11d40] to-[#7c1233] flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-extrabold text-slate-800">Mot de passe oublié</h1>
                    <p class="text-slate-500 text-sm mt-1">Entrez votre email pour recevoir un lien de réinitialisation</p>
                </div>

                
                <?php if(session('status')): ?>
                <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl text-sm font-semibold">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <?php echo e(session('status')); ?>

                </div>
                <?php endif; ?>

                
                <?php if($errors->any()): ?>
                <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-2xl text-sm font-semibold">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <?php echo e($errors->first()); ?>

                </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('client.password.forgot.send')); ?>" class="space-y-5">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">
                            Adresse email
                        </label>
                        <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-[#b11d40]/30 focus:border-[#b11d40] transition-all"
                               placeholder="votre@email.com">
                    </div>

                    <button type="submit"
                            class="w-full bg-[#b11d40] hover:bg-[#911633] text-white font-black py-3 rounded-2xl transition-all shadow-md shadow-[#b11d40]/20 active:scale-95 text-sm">
                        Envoyer le lien →
                    </button>
                </form>
            </div>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">
            <a href="<?php echo e(route('clients.login')); ?>" class="text-[#b11d40] font-bold hover:underline">
                ← Retour à la connexion
            </a>
        </p>
    </div>
</body>
</html><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/clients/auth/forgot-password.blade.php ENDPATH**/ ?>