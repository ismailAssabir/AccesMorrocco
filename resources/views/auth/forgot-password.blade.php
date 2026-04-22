{{-- ============================================================
     PREMIUM SAAS FORGOT PASSWORD PAGE — ACCESS MOROCCO
     Split layout: Brand left · Auth right
     ============================================================ --}}
<x-guest-layout>

<div class="login-wrapper">

    {{-- ══════════════════════════════════════════════════
         LEFT PANEL — Brand / Marketing
         Hidden on mobile, shown on lg+
    ══════════════════════════════════════════════════ --}}
    <div class="login-left">

        {{-- Animated blur blobs --}}
        <div class="blob-1"></div>
        <div class="blob-2"></div>
        <div class="blob-3"></div>

        <div class="login-left-content">

            {{-- ── Top: Logo ── --}}
            <div>
                <div class="login-logo-badge">
                    <img src="{{ asset('images/logo.png') }}" alt="logo" class="logo-img">
                    <span class="login-logo-text">ACCESS MOROCCO</span>
                </div>
            </div>

            {{-- ── Center: Headline + features ── --}}
            <div>

                {{-- Feature pills --}}
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

                {{-- Main headline --}}
                <h1 class="login-headline mt-6">
                    Recover Your<br>
                    <span>Agency Access</span>
                </h1>

                <p class="login-subtext">
                    Don't worry, it happens. Enter your email address and we'll send you a secure link to reset your password and get back to managing your agency.
                </p>

                {{-- Stats row --}}
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

                {{-- Preview --}}
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

            {{-- ── Bottom: Footer note ── --}}
            <p class="login-left-footer">
                &copy; {{ date('Y') }} ACCESS MOROCCO. All rights reserved.
            </p>

        </div>
    </div>

    {{-- ══════════════════════════════════════════════════
         RIGHT PANEL — Auth Card
    ══════════════════════════════════════════════════ --}}
    <div class="login-right">

        <div class="w-full max-w-[420px]">

            {{-- Mobile-only logo (shown below lg) --}}
            <div class="login-mobile-logo">
                <div class="login-mobile-logo-badge">
                    <img src="{{ asset('images/logo.png') }}" alt="logo" class="logo-img">
                    <span class="login-mobile-logo-text">ACCESS MOROCCO</span>
                </div>
            </div>

            {{-- ── Glass Auth Card ── --}}
        <div class="card">
            <div class="auth-card">

                {{-- Card logo icon --}}
                <div class="auth-card-logo">
                    <div class="auth-card-logo-inner">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </div>

                <h2 class="auth-card-title">Reset password</h2>
                <p class="auth-card-subtitle mb-4">Enter your email address to receive a reset link</p>

                {{-- Session Status --}}
                <x-auth-session-status class="mb-4 text-sm text-brand-600 font-medium text-center" :status="session('status')" />

                {{-- ── Reset Password Form ── --}}
                <form method="POST" action="{{ route('password.email') }}" class="mt-7 space-y-5" id="reset-form">
                    @csrf

                    {{-- Email Address --}}
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
                                value="{{ old('email') }}"
                                placeholder="you@example.com"
                                required
                                autofocus />
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-brand-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit button --}}
                    <button type="submit" id="reset-btn" class="btn-brand mt-4">
                        <span>
                            Email Password Reset Link
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </span>
                    </button>
                    
                    {{-- Back to login link --}}
                    <div class="text-center mt-6">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-brand-600 transition-colors duration-150 inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to login
                        </a>
                    </div>
                </form>

            </div>

            {{-- Trust badges --}}
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

{{-- Button loading state on submit --}}
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

</x-guest-layout>
