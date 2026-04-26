
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
                        Secure Access
                    </span>
                    <span class="login-pill">
                        <span class="login-pill-dot"></span>
                        Identity Protection
                    </span>
                    <span class="login-pill">
                        <span class="login-pill-dot"></span>
                        24/7 Monitoring
                    </span>
                </div>

                
                <h1 class="login-headline mt-6">
                    Restore Your<br>
                    <span>Secure Access</span>
                </h1>

                <p class="login-subtext">
                    Follow the simple steps to reset your password and regain access to your travel agency control center.
                </p>

                
                <div class="login-stats">
                    <div class="login-stat">
                        <span class="login-stat-value">256-bit</span>
                        <span class="login-stat-label">Encryption</span>
                    </div>
                    <div class="login-stat-divider"></div>
                    <div class="login-stat">
                        <span class="login-stat-value">Fast</span>
                        <span class="login-stat-label">Recovery</span>
                    </div>
                </div>

                
                <div class="login-preview mt-8">
                    <div class="login-preview-bar">
                        <span class="login-preview-dot bg-rose-400/60"></span>
                        <span class="login-preview-dot bg-amber-400/60"></span>
                        <span class="login-preview-dot bg-emerald-400/60"></span>
                        <span class="ml-3 text-white/30 text-xs font-mono">security.access.auth</span>
                    </div>

                    <div class="login-preview-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <div class="space-y-1">
                                <div class="h-2 w-24 rounded-full bg-white/20"></div>
                                <div class="h-1.5 w-16 rounded-full bg-white/10"></div>
                            </div>
                        </div>
                        <div class="login-preview-row"></div>
                        <div class="login-preview-row-sm"></div>
                        <div class="login-preview-row-xs"></div>
                    </div>
                </div>
            </div>

            
            <p class="login-left-footer">
                &copy; <?php echo e(date('Y')); ?> ACCESS MOROCCO. Secure Infrastructure.
            </p>
        </div>
    </div>

    
    <div class="login-right">

        <div class="w-full max-w-[440px]">

            
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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                    </div>

                    <h2 class="auth-card-title">Reset your password</h2>
                    <p class="auth-card-subtitle">Choose a strong password to protect your account</p>

                    
                    <form method="POST" action="<?php echo e(route('password.store')); ?>" class="mt-7 space-y-5" id="reset-form">
                        <?php echo csrf_field(); ?>

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="<?php echo e($request->route('token')); ?>">

                        
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
                                    class="auth-field pl-10 bg-gray-50/50 cursor-not-allowed"
                                    type="email"
                                    name="email"
                                    value="<?php echo e(old('email', $request->email)); ?>"
                                    readonly
                                    required
                                    autocomplete="username"/>
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

                        
                        <div>
                            <label for="password" class="auth-label">New Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </span>
                                <input
                                    id="password"
                                    class="auth-field pl-10 pr-11"
                                    type="password"
                                    name="password"
                                    placeholder="••••••••"
                                    required
                                    autofocus
                                    autocomplete="new-password"/>
                                <button type="button"
                                        class="toggle-password absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-150"
                                        data-target="password">
                                    <svg class="eye-icon w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            <?php $__errorArgs = ['password'];
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

                        
                        <div>
                            <label for="password_confirmation" class="auth-label">Confirm New Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </span>
                                <input
                                    id="password_confirmation"
                                    class="auth-field pl-10 pr-11"
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="••••••••"
                                    required
                                    autocomplete="new-password"/>
                                <button type="button"
                                        class="toggle-password absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-150"
                                        data-target="password_confirmation">
                                    <svg class="eye-icon w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            <?php $__errorArgs = ['password_confirmation'];
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
                                Update Password
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                </svg>
                            </span>
                        </button>

                    </form>

                    
                    <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                        <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium text-gray-500 hover:text-brand-600 transition-colors duration-200 flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to sign in
                        </a>
                    </div>

                </div>

                
                <div class="auth-trust">
                    <div class="auth-trust-item">
                        <svg class="auth-trust-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span>Protected</span>
                    </div>
                    <div class="auth-trust-item">
                        <svg class="auth-trust-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Compliant</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<script>
(function () {
    // Password toggles
    const toggles = document.querySelectorAll('.toggle-password');
    const eyeOpen = `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    const eyeClosed = `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;

    toggles.forEach(btn => {
        btn.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('.eye-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = eyeClosed;
            } else {
                input.type = 'password';
                icon.innerHTML = eyeOpen;
            }
        });
    });

    // Loading state
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
                </svg> Updating…`;
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
<?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/auth/reset-password.blade.php ENDPATH**/ ?>