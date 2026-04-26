
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

            
            <div>
                <div class="login-logo-badge">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="logo" class="logo-img">
                    <span class="login-logo-text">ACCESS MOROCCO</span>
                </div>
            </div>

            
            <div>

                
                <div class="login-pills">
                    <span class="login-pill">
                        <span class="login-pill-dot"></span>
                        Secure Account
                    </span>
                    <span class="login-pill">
                        <span class="login-pill-dot"></span>
                        Data Protection
                    </span>
                </div>

                
                <h1 class="login-headline mt-6">
                    Recover Your<br>
                    <span>Agency Access</span>
                </h1>

                <p class="login-subtext">
                    Don't worry, it happens. Enter your email address and we'll send you a secure link to reset your password and get back to managing your agency.
                </p>

                
                <div class="login-stats">
                    <div class="login-stat">
                        <span class="login-stat-value">256-bit</span>
                        <span class="login-stat-label">Encryption</span>
                    </div>
                    <div class="login-stat-divider"></div>
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
                        <span class="ml-3 text-white/30 text-xs font-mono">security.travel.local</span>
                    </div>

                    <div class="login-preview-body">
                        <div class="login-preview-row mt-3"></div>
                        <div class="login-preview-row-sm"></div>
                        <div class="login-preview-row-xs"></div>
                    </div>
                </div>

            </div>

            
            <p class="login-left-footer">
                &copy; <?php echo e(date('Y')); ?> ACCESS MOROCCO. All rights reserved.
            </p>

        </div>
    </div>

    
    <div class="login-right">

        <div class="w-full max-w-[420px]">

            
            <div class="login-mobile-logo">
                <div class="login-mobile-logo-badge">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="logo" class="logo-img">
                    <span class="login-mobile-logo-text">ACCESS MOROCCO</span>
                </div>
            </div>

            
        <div class="card">
            <div class="auth-card">

                
                <div class="auth-card-logo">
                    <div class="auth-card-logo-inner">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </div>

                <h2 class="auth-card-title">Reset password</h2>
                <p class="auth-card-subtitle mb-4">Enter your email address to receive a reset link</p>

                
                <?php if (isset($component)) { $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-session-status','data' => ['class' => 'mb-4 text-sm text-brand-600 font-medium text-center','status' => session('status')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-session-status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-4 text-sm text-brand-600 font-medium text-center','status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('status'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5)): ?>
<?php $attributes = $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5; ?>
<?php unset($__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5)): ?>
<?php $component = $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5; ?>
<?php unset($__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5); ?>
<?php endif; ?>

                
                <form method="POST" action="<?php echo e(route('password.email')); ?>" class="mt-7 space-y-5" id="reset-form">
                    <?php echo csrf_field(); ?>

                    
                    <div>
                        <label for="email" class="auth-label">Email address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input
                                id="email"
                                class="auth-field pl-10"
                                type="email"
                                name="email"
                                value="<?php echo e(old('email')); ?>"
                                placeholder="you@example.com"
                                required
                                autofocus />
                        </div>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1.5 text-xs text-brand-600 font-medium"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <button type="submit" id="reset-btn" class="btn-brand mt-4">
                        <span>
                            Email Password Reset Link
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </span>
                    </button>
                    
                    
                    <div class="text-center mt-6">
                        <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium text-gray-500 hover:text-brand-600 transition-colors duration-150 inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to login
                        </a>
                    </div>
                </form>

            </div>

            
            <div class="auth-trust">
                <div class="auth-trust-item">
                    <svg class="auth-trust-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span>256-bit SSL</span>
                </div>
                <div class="auth-trust-item">
                    <svg class="auth-trust-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>GDPR Compliant</span>
                </div>
            </div>

        </div>
    </div>

</div>


<script>
(function () {
    const form = document.getElementById('reset-form');
    const resetBtn = document.getElementById('reset-btn');
    if (form && resetBtn) {
        form.addEventListener('submit', function () {
            resetBtn.disabled = true;
            resetBtn.style.opacity = '0.75';
            resetBtn.querySelector('span').innerHTML =
                `<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg> Sending link…`;
        });
    }
})();
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
<?php endif; ?>
<?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>