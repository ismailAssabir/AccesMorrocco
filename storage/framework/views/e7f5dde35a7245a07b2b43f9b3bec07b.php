<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

<div class="login-wrapper">

    
    <div class="login-left">
        <div class="blob-1"></div>
        <div class="blob-2"></div>
        <div class="blob-3"></div>

        <div class="login-left-content">

            
            <div class="login-logo-badge">
                <img src="<?php echo e(asset('images/logo.png')); ?>" class="logo-img">
                <span class="login-logo-text">ACCESS MOROCCO</span>
            </div>

            
            <div class="login-pills">
                <span class="login-pill"><span class="login-pill-dot"></span>Track Trips</span>
                <span class="login-pill"><span class="login-pill-dot"></span>Documents</span>
                <span class="login-pill"><span class="login-pill-dot"></span>Payments</span>
            </div>

            
            <h1 class="login-headline mt-6">
                Manage Your<br>
                <span>Travel Experience</span>
            </h1>

            <p class="login-subtext">
                Access your dossiers, download documents, and track your travel journey securely.
            </p>

            
            <div class="login-stats">
                <div class="login-stat">
                    <span class="login-stat-value">15K+</span>
                    <span class="login-stat-label">Clients</span>
                </div>
                <div class="login-stat">
                    <span class="login-stat-value">50+</span>
                    <span class="login-stat-label">Destinations</span>
                </div>
                <div class="login-stat">
                    <span class="login-stat-value">24/7</span>
                    <span class="login-stat-label">Support</span>
                </div>
            </div>

            
            <div class="login-preview mt-8">
                <div class="login-preview-bar">
                    <span class="login-preview-dot bg-rose-400/60"></span>
                    <span class="login-preview-dot bg-amber-400/60"></span>
                    <span class="login-preview-dot bg-emerald-400/60"></span>
                    <span class="ml-3 text-white/30 text-xs font-mono">client.access.ma</span>
                </div>

                <div class="space-y-2">
                    <div class="h-2 bg-white/10 rounded w-3/4"></div>
                    <div class="h-2 bg-white/10 rounded w-1/2"></div>
                    <div class="h-2 bg-white/10 rounded w-5/6"></div>
                </div>
            </div>

        </div>
    </div>

    
    <div class="login-right">

        <div class="w-full max-w-[420px]">

            
            <div class="login-mobile-logo">
                <div class="login-logo-badge justify-center">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" class="logo-img">
                    <span class="login-logo-text">ACCESS MOROCCO</span>
                </div>
            </div>

            
            <div class="auth-card">

                
                <div class="auth-card-logo">
                    <div class="auth-card-logo-inner">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5.121 17.804A4 4 0 017 17h10a4 4 0 011.879.804M15 11a3 3 0 11-6 0"/>
                        </svg>
                    </div>
                </div>

                <h2 class="auth-card-title">Client Access</h2>
                <p class="auth-card-subtitle">Sign in to your space</p>

                
                <?php if($errors->any()): ?>
                    <div class="mb-4 text-red-600 text-sm">
                        <?php echo e($errors->first()); ?>

                    </div>
                <?php endif; ?>

                
                <form method="POST" action="<?php echo e(route('clients.login.post')); ?>" class="space-y-5" id="login-form">
                    <?php echo csrf_field(); ?>

                    
                    <div>
                        <label class="auth-label">Email</label>
                        <input type="email" name="email"
                               value="<?php echo e(old('email')); ?>"
                               class="auth-field"
                               required>
                    </div>

                    
                    <div>
                        <div class="flex justify-between mb-1">
                            <label class="auth-label">Password</label>
                            <a href="#" class="text-xs text-[#b11d40]">Forgot?</a>
                        </div>

                        <div class="relative">
                            <input type="password" name="password"
                                   id="password"
                                   class="auth-field pr-10"
                                   required>

                            <button type="button" id="toggle-password"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                👁
                            </button>
                        </div>
                    </div>

                    
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="remember" class="auth-checkbox">
                        <span class="text-sm">Remember me</span>
                    </div>

                    
                    <button type="submit" id="sign-in-btn" class="btn-brand">
                        <span>Sign in →</span>
                    </button>

                </form>
            </div>

            
            <div class="auth-trust">
                <span>🔒 Secure</span>
                <span>🛡 Data Protected</span>
                <span>⚡ Fast Access</span>
            </div>

            <p class="text-center text-xs mt-6">
                Staff access ?
                <a href="<?php echo e(route('login')); ?>" class="text-[#b11d40] font-bold">
                    Login here →
                </a>
            </p>

        </div>
    </div>
</div>


<script>
document.getElementById('toggle-password').onclick = () => {
    let input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
};

document.getElementById('login-form').addEventListener('submit', function() {
    let btn = document.getElementById('sign-in-btn');
    btn.disabled = true;
    btn.innerHTML = "Signing in...";
});
</script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/clients/auth/login.blade.php ENDPATH**/ ?>