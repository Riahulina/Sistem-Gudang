@extends('layouts.app')

@section('title', 'Login — Our Stock')

@push('styles')
<style>
    body { background: linear-gradient(145deg, #f0fdf6 0%, #f8fafc 50%, #ecfdf5 100%); min-height: 100vh; }

    .login-bg-blob {
        position: fixed;
        border-radius: 50%;
        filter: blur(80px);
        pointer-events: none;
        z-index: 0;
    }

    .logo-mark {
        width: 52px; height: 52px;
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 8px 25px rgba(5,150,105,.3);
        position: relative;
        overflow: hidden;
    }
    .logo-mark::after {
        content: '';
        position: absolute;
        top: -10px; right: -10px;
        width: 30px; height: 30px;
        background: rgba(255,255,255,.15);
        border-radius: 50%;
    }

    .login-card {
        background: rgba(255,255,255,.92);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(167,243,208,.4);
        border-radius: 1.75rem;
        box-shadow: 0 4px 6px rgba(0,0,0,.04), 0 25px 50px rgba(0,0,0,.08), 0 0 0 1px rgba(255,255,255,.6);
        padding: 2.5rem;
        width: 100%;
        max-width: 420px;
        animation: fadeUp .6s ease both;
    }

    .divider-line {
        height: 1px;
        background: linear-gradient(90deg, transparent, #d1fae5, transparent);
        margin: 1.5rem 0;
    }

    .input-wrap { position: relative; }
    .input-wrap .input-icon {
        position: absolute;
        left: .875rem; top: 50%; transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
        transition: color .2s;
    }
    .input-wrap:focus-within .input-icon { color: #059669; }
    .input-wrap .input-field { padding-left: 2.75rem; }

    .eye-toggle {
        position: absolute;
        right: .875rem; top: 50%; transform: translateY(-50%);
        color: #94a3b8; cursor: pointer;
        transition: color .2s;
        background: none; border: none; padding: 0;
    }
    .eye-toggle:hover { color: #059669; }

    .badge-secure {
        display: inline-flex; align-items: center; gap: .35rem;
        font-size: .7rem; font-weight: 600;
        color: #059669;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        border-radius: 99px;
        padding: .2rem .65rem;
        letter-spacing: .03em;
        text-transform: uppercase;
    }

    .btn-login {
        width: 100%;
        padding: .875rem;
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: #fff;
        font-weight: 700;
        font-size: .95rem;
        border-radius: .875rem;
        border: none;
        cursor: pointer;
        transition: transform .2s, box-shadow .2s, filter .2s;
        box-shadow: 0 6px 20px rgba(5,150,105,.35);
        letter-spacing: .01em;
        position: relative;
        overflow: hidden;
    }
    .btn-login::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.15), transparent);
        transition: left .5s;
    }
    .btn-login:hover::before { left: 100%; }
    .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(5,150,105,.45); }
    .btn-login:active { transform: translateY(0); }

    .btn-register-outline {
        width: 100%;
        padding: .875rem;
        background: transparent;
        color: #059669;
        font-weight: 700;
        font-size: .95rem;
        border-radius: .875rem;
        border: 2px solid #a7f3d0;
        cursor: pointer;
        transition: all .2s;
        letter-spacing: .01em;
        text-decoration: none;
    }
    .btn-register-outline:hover {
        background: #ecfdf5;
        border-color: #059669;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5,150,105,.15);
    }

    .floating-dots {
        position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden;
    }
    .dot {
        position: absolute;
        border-radius: 50%;
        background: radial-gradient(circle, #10b981 0%, transparent 70%);
        opacity: .06;
        animation: floatDot linear infinite;
    }
    @keyframes floatDot {
        from { transform: translateY(100vh) rotate(0deg); opacity: 0; }
        10%  { opacity: .06; }
        90%  { opacity: .06; }
        to   { transform: translateY(-100px) rotate(360deg); opacity: 0; }
    }
</style>
@endpush

@section('content')
{{-- Ambient blobs --}}
<div class="login-bg-blob" style="width:600px;height:600px;background:radial-gradient(circle,rgba(16,185,129,.12),transparent 70%);top:-200px;right:-200px;"></div>
<div class="login-bg-blob" style="width:400px;height:400px;background:radial-gradient(circle,rgba(5,150,105,.08),transparent 70%);bottom:-100px;left:-100px;"></div>

{{-- Floating particles --}}
<div class="floating-dots" aria-hidden="true">
    @for($i=0;$i<8;$i++)
    <div class="dot" style="
        width:{{ rand(60,180) }}px; height:{{ rand(60,180) }}px;
        left:{{ rand(0,100) }}%;
        animation-duration:{{ rand(15,30) }}s;
        animation-delay:-{{ rand(0,20) }}s;
    "></div>
    @endfor
</div>

<div class="relative z-10 min-h-screen flex flex-col items-center justify-center px-4 py-12">

    {{-- Tagline above card --}}
    <div class="mb-6 text-center animate-fade-in" style="animation-delay:.1s;opacity:0">
        <span class="badge-secure">
            <i data-lucide="shield-check" style="width:11px;height:11px;"></i>
            Sistem Manajemen Gudang Terpadu
        </span>
    </div>

    {{-- Card --}}
    <div class="login-card">

        {{-- Header --}}
        <div class="flex items-center gap-3.5 mb-6">
            <div class="logo-mark">
                <i data-lucide="package-2" style="width:26px;height:26px;color:white;"></i>
            </div>
            <div>
                <h1 class="text-xl font-800 text-slate-900 leading-tight" style="font-weight:800;">Our Stock</h1>
                <p class="text-xs text-slate-400 font-medium mt-0.5">Masuk ke akun Anda</p>
            </div>
        </div>

        <div class="divider-line"></div>

        {{-- Alert Error --}}
        @if($errors->has('login'))
        <div class="mb-4 flex items-center gap-2.5 bg-red-50 border border-red-200 text-red-600 text-sm font-medium rounded-xl px-4 py-3">
            <i data-lucide="circle-alert" style="width:16px;height:16px;flex-shrink:0;"></i>
            {{ $errors->first('login') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-4 flex items-center gap-2.5 bg-red-50 border border-red-200 text-red-600 text-sm font-medium rounded-xl px-4 py-3">
            <i data-lucide="circle-alert" style="width:16px;height:16px;flex-shrink:0;"></i>
            {{ session('error') }}
        </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            {{-- Username --}}
            <div>
                <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Username</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <i data-lucide="user" style="width:16px;height:16px;"></i>
                    </span>
                    <input
                        type="text"
                        name="username"
                        class="input-field @error('username') border-red-400 @enderror"
                        placeholder="Masukkan username Anda"
                        value="{{ old('username') }}"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </div>
                @error('username')
                <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                    <i data-lucide="circle-alert" style="width:12px;height:12px;"></i>
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Password</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <i data-lucide="lock" style="width:16px;height:16px;"></i>
                    </span>
                    <input
                        type="password"
                        name="password"
                        id="passwordInput"
                        class="input-field @error('password') border-red-400 @enderror"
                        placeholder="Masukkan password Anda"
                        autocomplete="current-password"
                        required
                    >
                    <button type="button" class="eye-toggle" id="togglePassword" tabindex="-1">
                        <i data-lucide="eye" id="eyeIcon" style="width:16px;height:16px;"></i>
                    </button>
                </div>
                @error('password')
                <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                    <i data-lucide="circle-alert" style="width:12px;height:12px;"></i>
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- Remember me --}}
            <div class="flex items-center gap-2 pt-1">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <div class="toggle-wrap flex items-center">
                        <input type="checkbox" name="remember" id="rememberMe">
                        <div class="toggle-track" onclick="document.getElementById('rememberMe').click()">
                            <div class="toggle-thumb"></div>
                        </div>
                    </div>
                    <span class="text-sm text-slate-500 font-medium">Ingat saya</span>
                </label>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-login mt-2">
                <span id="btnText" class="flex items-center justify-center gap-2">
                    <i data-lucide="log-in" style="width:17px;height:17px;"></i>
                    Masuk Sekarang
                </span>
                <span id="btnLoading" class="hidden flex items-center justify-center gap-2">
                    <svg class="animate-spin" style="width:17px;height:17px;" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                        <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Memproses...
                </span>
            </button>

            {{-- Divider --}}
            <div class="divider-line"></div>

            {{-- Tombol ke Register --}}
            <p class="text-sm text-slate-500 text-center">
                Belum punya akun?
            </p>
            <a href="{{ route('register') }}" class="btn-register-outline flex items-center justify-center gap-2">
                <i data-lucide="user-plus" style="width:17px;height:17px;"></i>
                Daftar Akun Baru
            </a>
        </form>
    </div>

    {{-- Footer --}}
    <p class="mt-6 text-xs text-slate-400 text-center animate-fade-in" style="animation-delay:.5s;opacity:0;">
        &copy; {{ date('Y') }} Our Stock · Sistem Manajemen Gudang
    </p>
</div>
@endsection

@push('scripts')
<script>
    // Toggle password visibility
    const toggleBtn = document.getElementById('togglePassword');
    const pwInput   = document.getElementById('passwordInput');
    const eyeIcon   = document.getElementById('eyeIcon');

    toggleBtn.addEventListener('click', () => {
        const isPassword = pwInput.type === 'password';
        pwInput.type = isPassword ? 'text' : 'password';
        eyeIcon.setAttribute('data-lucide', isPassword ? 'eye-off' : 'eye');
        lucide.createIcons();
    });

    // Loading state on submit
    document.querySelector('form').addEventListener('submit', function() {
        document.getElementById('btnText').classList.add('hidden');
        document.getElementById('btnLoading').classList.remove('hidden');
    });
</script>
@endpush
