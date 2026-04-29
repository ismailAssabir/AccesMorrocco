<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Espace Client - Access Morocco'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F8FAFC]">
    <div class="min-h-screen">
        <!-- Header Client -->
        <nav class="bg-white border-b border-slate-200 shadow-sm">
            <div class="px-8 py-4 flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold text-[#b11d40]">Access Morocco</h1>
                    <p class="text-xs text-slate-500">Espace Client</p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-slate-600">
                        <?php echo e(Auth::guard('client')->user()->firstName ?? ''); ?> <?php echo e(Auth::guard('client')->user()->lastName ?? ''); ?>

                    </span>
                    <form method="POST" action="<?php echo e(route('clients.logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-sm text-red-500 hover:text-red-700">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Contenu principal -->
        <main>
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</body>
</html><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/layouts/client.blade.php ENDPATH**/ ?>