
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
                        Trip Planning
                    </span>
                    <span class="login-pill">
                        <span class="login-pill-dot"></span>
                        Client Booking
                    </span>
                    <span class="login-pill">
                        <span class="login-pill-dot"></span>
                        Agency Management
                    </span>
                </div>

                
                <h1 class="login-headline mt-6">
                    Welcome to Your<br>
                    <span>Travel Agency Hub</span>
                </h1>

                <p class="login-subtext">
                    Manage clients, organize trips, and handle reservations efficiently — everything your travel agency needs in one place.
                </p>

                
                <div class="login-stats">
                    <div class="login-stat">
                        <span class="login-stat-value">150+</span>
                        <span class="login-stat-label">Destinations</span>
                    </div>
                    <div class="login-stat-divider"></div>
                    <div class="login-stat">
                        <span class="login-stat-value">500+</span>
                        <span class="login-stat-label">Trips Created</span>
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
                        <span class="ml-3 text-white/30 text-xs font-mono">agency.travel.local</span>
                    </div>

                    <div class="login-preview-body">

                        
                        <div class="grid grid-cols-3 gap-2 mb-3">
                            <?php $__currentLoopData = ['bg-rose-500/20', 'bg-amber-500/15', 'bg-emerald-500/15']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="rounded-lg p-3 <?php echo e($color); ?> border border-white/5">
                                <div class="h-1.5 w-8 rounded-full bg-white/20 mb-2"></div>
                                <div class="h-4 w-12 rounded bg-white/30"></div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        
                        <div class="flex items-end gap-1 h-12 mt-1">
                            <?php $__currentLoopData = [40, 60, 35, 80, 55, 90, 45, 70, 60, 85, 50, 75]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex-1 rounded-t"
                                style="height: <?php echo e($h); ?>%; background: rgba(225,29,72,<?php echo e($h > 70 ? '0.45' : '0.20'); ?>);"></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

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
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                </div>

                <h2 class="auth-card-title">Sign in to your account</h2>
                <p class="auth-card-subtitle">Enter your credentials to access the dashboard</p>

                
                <?php if (isset($component)) { $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-session-status','data' => ['class' => 'mt-4 mb-2 text-sm text-brand-600 font-medium text-center','status' => session('status')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-session-status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-4 mb-2 text-sm text-brand-600 font-medium text-center','status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('status'))]); ?>
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

                
                <form method="POST" action="<?php echo e(route('login')); ?>" class="mt-7 space-y-5" id="login-form">
                    <?php echo csrf_field(); ?>

                    
                    <div>
                        <label for="email" class="auth-label">Email address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
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
                                autofocus
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
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="auth-label mb-0">Password</label>
                            <?php if(Route::has('password.request')): ?>
                                <a href="<?php echo e(route('password.request')); ?>"
                                   class="text-xs font-medium text-brand-600 hover:text-brand-700 transition-colors duration-150">
                                    Forgot password?
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input
                                id="password"
                                class="auth-field pl-10 pr-11"
                                type="password"
                                name="password"
                                placeholder="••••••••"
                                required
                                autocomplete="current-password"/>
                            
                            <button type="button"
                                    id="toggle-password"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-150"
                                    aria-label="Toggle password visibility">
                                <svg id="eye-icon" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
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

                    
                    <div class="flex items-center gap-2.5">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="auth-checkbox">
                        <label for="remember_me" class="text-sm text-gray-600 cursor-pointer select-none">
                            Keep me signed in for 30 days
                        </label>
                    </div>

                    
                    <button type="submit" id="sign-in-btn" class="btn-brand mt-2">
                        <span>
                            
                            Sign in
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </span>
                    </button>

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
                <div class="auth-trust-item">
                    <svg class="auth-trust-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span>99.9% Uptime</span>
                </div>
            </div>

        </div>
    </div>

</div>


<script>
(function () {
    const btn   = document.getElementById('toggle-password');
    const input = document.getElementById('password');
    const icon  = document.getElementById('eye-icon');

    if (!btn || !input) return;

    const eyeOpen = `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    const eyeClosed = `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;

    btn.addEventListener('click', function () {
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        icon.innerHTML = isPassword ? eyeClosed : eyeOpen;
    });

    
    const form = document.getElementById('login-form');
    const signInBtn = document.getElementById('sign-in-btn');
    if (form && signInBtn) {
        form.addEventListener('submit', function () {
            signInBtn.disabled = true;
            signInBtn.style.opacity = '0.75';
            signInBtn.querySelector('span').innerHTML =
                `<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg> Signing in…`;
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
<?php endif; ?><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/auth/login.blade.php ENDPATH**/ ?>