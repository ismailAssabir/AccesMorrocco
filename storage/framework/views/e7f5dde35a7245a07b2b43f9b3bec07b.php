<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Espace Client — Access Morocco</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <style>
        /* Styles additionnels pour la page client */
        .login-wrapper {
            display: flex;
            min-height: 100vh;
            background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%);
        }
        
        /* Left Panel */
        .login-left {
            flex: 1;
            position: relative;
            background: linear-gradient(145deg, #0F172A 0%, #1E293B 100%);
            display: none;
            overflow: hidden;
            isolation: isolate;
        }
        
        @media (min-width: 1024px) {
            .login-left {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }
        
        /* Animated blobs */
        .blob-1, .blob-2, .blob-3 {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            z-index: 0;
            animation: float 20s infinite ease-in-out;
        }
        
        .blob-1 {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, #b11d40, #7c1233);
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }
        
        .blob-2 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #3B82F6, #1E40AF);
            bottom: -150px;
            left: -150px;
            animation-delay: 5s;
        }
        
        .blob-3 {
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, #F59E0B, #D97706);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 10s;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        
        .login-left-content {
            position: relative;
            z-index: 10;
            width: 80%;
            max-width: 500px;
            padding: 3rem;
        }
        
        .login-logo-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 3rem;
        }
        
        .logo-img {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #b11d40, #7c1233);
            padding: 8px;
        }
        
        .login-logo-text {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 1px;
            background: linear-gradient(135deg, #fff 0%, #94A3B8 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .login-pills {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }
        
        .login-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(10px);
            border-radius: 40px;
            font-size: 12px;
            font-weight: 500;
            color: #CBD5E1;
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .login-pill-dot {
            width: 6px;
            height: 6px;
            background: #b11d40;
            border-radius: 50%;
        }
        
        .login-headline {
            font-size: 42px;
            font-weight: 800;
            line-height: 1.2;
            color: white;
            margin-bottom: 1rem;
        }
        
        .login-headline span {
            background: linear-gradient(135deg, #b11d40, #F43F5E);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .login-subtext {
            color: #94A3B8;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        
        .login-stats {
            display: flex;
            gap: 24px;
            padding: 20px 0;
            border-top: 1px solid rgba(255,255,255,0.08);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 2rem;
        }
        
        .login-stat {
            flex: 1;
        }
        
        .login-stat-value {
            display: block;
            font-size: 28px;
            font-weight: 800;
            color: white;
            margin-bottom: 4px;
        }
        
        .login-stat-label {
            font-size: 11px;
            font-weight: 600;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .login-preview {
            background: rgba(255,255,255,0.03);
            border-radius: 20px;
            padding: 16px;
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(10px);
        }
        
        .login-preview-bar {
            display: flex;
            align-items: center;
            gap: 6px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 12px;
        }
        
        .login-preview-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }
        
        .login-left-footer {
            margin-top: 4rem;
            font-size: 11px;
            color: #475569;
            text-align: center;
        }
        
        /* Right Panel */
        .login-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .login-mobile-logo {
            text-align: center;
            margin-bottom: 2rem;
            display: block;
        }
        
        @media (min-width: 1024px) {
            .login-mobile-logo {
                display: none;
            }
        }
        
        .auth-card {
            background: white;
            border-radius: 32px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            border: 1px solid #E2E8F0;
        }
        
        .auth-card-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 24px;
        }
        
        .auth-card-logo-inner {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #b11d40, #7c1233);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 20px -5px rgba(177,29,64,0.3);
        }
        
        .auth-card-title {
            font-size: 28px;
            font-weight: 800;
            text-align: center;
            color: #0F172A;
            margin-bottom: 8px;
        }
        
        .auth-card-subtitle {
            text-align: center;
            color: #64748B;
            font-size: 14px;
            margin-bottom: 32px;
        }
        
        .auth-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #475569;
            margin-bottom: 8px;
        }
        
        .auth-field {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #E2E8F0;
            border-radius: 16px;
            font-size: 14px;
            transition: all 0.2s;
            background: #F8FAFC;
        }
        
        .auth-field:focus {
            outline: none;
            border-color: #b11d40;
            box-shadow: 0 0 0 3px rgba(177,29,64,0.1);
        }
        
        .btn-brand {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #b11d40, #7c1233);
            color: white;
            font-weight: 700;
            border: none;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-brand:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(177,29,64,0.4);
        }
        
        .auth-trust {
            display: flex;
            justify-content: center;
            gap: 24px;
            margin-top: 24px;
            padding: 20px;
            background: #F1F5F9;
            border-radius: 20px;
        }
        
        .auth-trust-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 600;
            color: #475569;
        }
        
        .auth-trust-icon {
            width: 14px;
            height: 14px;
            color: #b11d40;
        }
        
        .auth-checkbox {
            width: 18px;
            height: 18px;
            border-radius: 6px;
            border: 2px solid #CBD5E1;
            accent-color: #b11d40;
        }
        
        @media (max-width: 640px) {
            .auth-card {
                padding: 24px;
            }
            .auth-card-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

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
                    <span class="login-pill"><span class="login-pill-dot"></span>Follow Your Trips</span>
                    <span class="login-pill"><span class="login-pill-dot"></span>Track Documents</span>
                    <span class="login-pill"><span class="login-pill-dot"></span>Payments History</span>
                </div>

                <h1 class="login-headline">
                    Your Travel Journey,<br>
                    <span>In Your Hands</span>
                </h1>

                <p class="login-subtext">
                    Access your travel files, download documents, track payments, and stay updated on your upcoming trips — all in one secure place.
                </p>

                <div class="login-stats">
                    <div class="login-stat">
                        <span class="login-stat-value">15K+</span>
                        <span class="login-stat-label">Happy Travelers</span>
                    </div>
                    <div class="login-stat-divider"></div>
                    <div class="login-stat">
                        <span class="login-stat-value">50+</span>
                        <span class="login-stat-label">Destinations</span>
                    </div>
                    <div class="login-stat-divider"></div>
                    <div class="login-stat">
                        <span class="login-stat-value">24/7</span>
                        <span class="login-stat-label">Client Support</span>
                    </div>
                </div>

                <div class="login-preview mt-8">
                    <div class="login-preview-bar">
                        <span class="login-preview-dot bg-rose-400/60"></span>
                        <span class="login-preview-dot bg-amber-400/60"></span>
                        <span class="login-preview-dot bg-emerald-400/60"></span>
                        <span class="ml-3 text-white/30 text-xs font-mono">your-trip.access.ma</span>
                    </div>
                    <div class="space-y-2">
                        <div class="h-2 bg-white/10 rounded w-3/4"></div>
                        <div class="h-2 bg-white/10 rounded w-1/2"></div>
                        <div class="h-2 bg-white/10 rounded w-5/6"></div>
                    </div>
                </div>
            </div>

            <p class="login-left-footer">
                &copy; <?php echo e(date('Y')); ?> ACCESS MOROCCO. All rights reserved.
            </p>
        </div>
    </div>

    
    <div class="login-right">
        <div class="w-full max-w-[480px]">

            <div class="login-mobile-logo">
                <div class="login-logo-badge justify-center">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="logo" class="logo-img">
                    <span class="login-logo-text">ACCESS MOROCCO</span>
                </div>
            </div>

            <div class="auth-card">
                <div class="auth-card-logo">
                    <div class="auth-card-logo-inner">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                </div>

                <h2 class="auth-card-title">Client Access</h2>
                <p class="auth-card-subtitle">Sign in to view your travel dossiers</p>

                <?php if($errors->any()): ?>
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl">
                        <div class="flex items-center gap-2 text-red-600 text-sm font-semibold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <?php echo e($errors->first()); ?>

                        </div>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('clients.login.post')); ?>" class="space-y-5">
                    <?php echo csrf_field(); ?>

                    <div>
                        <label class="auth-label">Email address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                                   class="auth-field pl-10"
                                   placeholder="client@example.com">
                        </div>
                    </div>

                    <div>
                        <label class="auth-label">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input type="password" name="password" required id="password"
                                   class="auth-field pl-10 pr-11"
                                   placeholder="••••••••">
                            <button type="button" id="toggle-password"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600">
                                <svg id="eye-icon" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="auth-checkbox">
                            <span class="text-sm text-gray-600">Remember me</span>
                        </label>
                        <a href="#" class="text-xs font-semibold text-[#b11d40] hover:text-[#7c1233] transition">
                            Forgot password?
                        </a>
                    </div>

                    <button type="submit" class="btn-brand group mt-4" id="sign-in-btn">
                        <span class="flex items-center gap-2">
                            Sign in
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </span>
                    </button>
                </form>
            </div>

            <div class="auth-trust">
                <div class="auth-trust-item">
                    <svg class="auth-trust-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span>Secure Connection</span>
                </div>
                <div class="auth-trust-item">
                    <svg class="auth-trust-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>Data Protected</span>
                </div>
                <div class="auth-trust-item">
                    <svg class="auth-trust-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span>Real-time Updates</span>
                </div>
            </div>

            <p class="text-center text-xs text-slate-400 mt-6">
                Employee access? 
                <a href="<?php echo e(route('login')); ?>" class="text-[#b11d40] font-bold hover:underline">
                    Go to staff login →
                </a>
            </p>
        </div>
    </div>
</div>

<script>
(function() {
    const btn = document.getElementById('toggle-password');
    const input = document.getElementById('password');
    const icon = document.getElementById('eye-icon');
    
    if (btn && input && icon) {
        btn.addEventListener('click', function() {
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            icon.innerHTML = isPassword ? 
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>' :
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
        });
    }
    
    const form = document.querySelector('form');
    const signInBtn = document.getElementById('sign-in-btn');
    if (form && signInBtn) {
        form.addEventListener('submit', function() {
            signInBtn.disabled = true;
            signInBtn.style.opacity = '0.75';
            signInBtn.querySelector('span').innerHTML = `
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                Signing in...
            `;
        });
    }
})();
</script>

</body>
</html><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/clients/auth/login.blade.php ENDPATH**/ ?>