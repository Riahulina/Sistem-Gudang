@extends('layouts.app')

@section('title', 'Daftar Akun — Our Stock')

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
        max-width: 460px;
        animation: fadeUp .6s ease both;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
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

    .input-field {
        width: 100%;
        padding: .75rem 1rem;
        border: 1.5px solid #e2e8f0;
        border-radius: .875rem;
        font-size: .9rem;
        color: #1e293b;
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .input-field:focus {
        border-color: #059669;
        box-shadow: 0 0 0 3px rgba(5,150,105,.1);
    }
    .input-field.border-red-400 {
        border-color: #f87171;
    }
    .input-field::placeholder { color: #cbd5e1; }

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

    .btn-register {
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
    .btn-register::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.15), transparent);
        transition: left .5s;
    }
    .btn-register:hover::before { left: 100%; }
    .btn-register:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(5,150,105,.45); }
    .btn-register:active { transform: translateY(0); }

    .role-option {
        flex: 1;
        border: 1.5px solid #e2e8f0;
        border-radius: .875rem;
        padding: .75rem 1rem;
        cursor: pointer;
        transition: all .2s;
        text-align: center;
        position: relative;
    }
    .role-option:has(input:checked) {
        border-color: #059669;
        background: #ecfdf5;
        box-shadow: 0 0 0 3px rgba(5,150,105,.1);
    }
    .role-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0; height: 0;
    }
    .role-option .role-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: #f1f5f9;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto .5rem;
        transition: background .2s;
    }
    .role-option:has(input:checked) .role-icon {
        background: #d1fae5;
        color: #059669;
    }

    .optional-badge {
        font-size: .68rem;
        font-weight: 600;
        color: #94a3b8;
        background: #f1f5f9;
        border-radius: 99px;
        padding: .15rem .5rem;
        margin-left: .4rem;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .btn-login-outline {
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
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
    }
    .btn-login-outline:hover {
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

    .animate-fade-in {
        animation: fadeUp .6s ease both;
    }

    .strength-bar {
        height: 4px;
        border-radius: 99px;
        background: #e2e8f0;
        overflow: hidden;
        margin-top: .5rem;
    }
    .strength-fill {
        height: 100%;
        border-radius: 99px;
        transition: width .3s, background .3s;
        width: 0%;
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

    {{-- Tagline --}}
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
                <h1 class="text-xl text-slate-900 leading-tight" style="font-weight:800;">Our Stock</h1>
                <p class="text-xs text-slate-400 font-medium mt-0.5">Daftarkan akun baru</p>
            </div>
        </div>

        <div class="divider-line"></div>

        {{-- Form --}}
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            {{-- Nama Lengkap --}}
            <div>
                <label class="block text-sm text-slate-700 mb-1.5" style="font-weight:600;">
                    Nama Lengkap
                </label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <i data-lucide="circle-user" style="width:16px;height:16px;"></i>
                    </span>
                    <input
                        type="text"
                        name="name"
                        class="input-field @error('name') border-red-400 @enderror"
                        placeholder="Masukkan nama lengkap"
                        value="{{ old('name') }}"
                        required
                        autofocus
                    >
                </div>
                @error('name')
                <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                    <i data-lucide="circle-alert" style="width:12px;height:12px;"></i>
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- Username --}}
            <div>
                <label class="block text-sm text-slate-700 mb-1.5" style="font-weight:600;">
                    Username
                </label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <i data-lucide="at-sign" style="width:16px;height:16px;"></i>
                    </span>
                    <input
                        type="text"
                        name="username"
                        class="input-field @error('username') border-red-400 @enderror"
                        placeholder="Buat username unik"
                        value="{{ old('username') }}"
                        required
                        autocomplete="username"
                    >
                </div>
                @error('username')
                <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                    <i data-lucide="circle-alert" style="width:12px;height:12px;"></i>
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- Email (opsional) --}}
            <div>
                <label class="block text-sm text-slate-700 mb-1.5" style="font-weight:600;">
                    Email
                    <span class="optional-badge">Opsional</span>
                </label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <i data-lucide="mail" style="width:16px;height:16px;"></i>
                    </span>
                    <input
                        type="email"
                        name="email"
                        class="input-field @error('email') border-red-400 @enderror"
                        placeholder="contoh@email.com"
                        value="{{ old('email') }}"
                        autocomplete="email"
                    >
                </div>
                @error('email')
                <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                    <i data-lucide="circle-alert" style="width:12px;height:12px;"></i>
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- Role --}}
            <div>
                <label class="block text-sm text-slate-700 mb-1.5" style="font-weight:600;">
                    Role Akun
                </label>
                <div class="flex gap-3">
                    {{-- Admin --}}
                    <label class="role-option">
                        <input type="radio" name="role" value="admin"
                            {{ old('role', 'admin') === 'admin' ? 'checked' : '' }}
                            onchange="updateRoleIcons()">
                        <div class="role-icon" id="icon-admin">
                            <i data-lucide="shield" style="width:18px;height:18px;color:#64748b;"></i>
                        </div>
                        <p class="text-sm font-semibold text-slate-700">Admin</p>
                        <p class="text-xs text-slate-400 mt-0.5">Kelola data gudang</p>
                    </label>

                    {{-- KTU --}}
                    <label class="role-option">
                        <input type="radio" name="role" value="ktu"
                            {{ old('role') === 'ktu' ? 'checked' : '' }}
                            onchange="updateRoleIcons()">
                        <div class="role-icon" id="icon-ktu">
                            <i data-lucide="crown" style="width:18px;height:18px;color:#64748b;"></i>
                        </div>
                        <p class="text-sm font-semibold text-slate-700">KTU</p>
                        <p class="text-xs text-slate-400 mt-0.5">Akses penuh sistem</p>
                    </label>
                </div>
                @error('role')
                <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                    <i data-lucide="circle-alert" style="width:12px;height:12px;"></i>
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm text-slate-700 mb-1.5" style="font-weight:600;">Password</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <i data-lucide="lock" style="width:16px;height:16px;"></i>
                    </span>
                    <input
                        type="password"
                        name="password"
                        id="passwordInput"
                        class="input-field @error('password') border-red-400 @enderror"
                        placeholder="Minimal 8 karakter"
                        autocomplete="new-password"
                        required
                        oninput="checkStrength(this.value)"
                    >
                    <button type="button" class="eye-toggle" id="togglePassword" tabindex="-1">
                        <i data-lucide="eye" id="eyeIcon" style="width:16px;height:16px;"></i>
                    </button>
                </div>
                {{-- Password strength --}}
                <div class="strength-bar mt-2">
                    <div class="strength-fill" id="strengthFill"></div>
                </div>
                <p class="text-xs text-slate-400 mt-1" id="strengthText"></p>
                @error('password')
                <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                    <i data-lucide="circle-alert" style="width:12px;height:12px;"></i>
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label class="block text-sm text-slate-700 mb-1.5" style="font-weight:600;">Konfirmasi Password</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <i data-lucide="lock-keyhole" style="width:16px;height:16px;"></i>
                    </span>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="confirmInput"
                        class="input-field"
                        placeholder="Ulangi password"
                        autocomplete="new-password"
                        required
                        oninput="checkMatch()"
                    >
                    <button type="button" class="eye-toggle" id="toggleConfirm" tabindex="-1">
                        <i data-lucide="eye" id="eyeIconConfirm" style="width:16px;height:16px;"></i>
                    </button>
                </div>
                <p class="text-xs mt-1 hidden" id="matchText"></p>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-register mt-2">
                <span id="btnText" class="flex items-center justify-center gap-2">
                    <i data-lucide="user-plus" style="width:17px;height:17px;"></i>
                    Daftar Sekarang
                </span>
                <span id="btnLoading" class="hidden flex items-center justify-center gap-2">
                    <svg class="animate-spin" style="width:17px;height:17px;" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                        <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Memproses...
                </span>
            </button>

            {{-- Link ke login --}}
            <div class="divider-line"></div>
            <p class="text-sm text-slate-500 text-center">
                Sudah punya akun?
            </p>
            <a href="{{ route('login') }}" class="btn-login-outline">
                <i data-lucide="log-in" style="width:17px;height:17px;"></i>
                Masuk ke Akun
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
    document.getElementById('togglePassword').addEventListener('click', function() {
        const input = document.getElementById('passwordInput');
        const icon  = document.getElementById('eyeIcon');
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        icon.setAttribute('data-lucide', isPassword ? 'eye-off' : 'eye');
        lucide.createIcons();
    });

    document.getElementById('toggleConfirm').addEventListener('click', function() {
        const input = document.getElementById('confirmInput');
        const icon  = document.getElementById('eyeIconConfirm');
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        icon.setAttribute('data-lucide', isPassword ? 'eye-off' : 'eye');
        lucide.createIcons();
    });

    // Password strength checker
    function checkStrength(val) {
        const fill = document.getElementById('strengthFill');
        const text = document.getElementById('strengthText');
        let score = 0;
        if (val.length >= 8)  score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const levels = [
            { width: '0%',   color: '#e2e8f0', label: '' },
            { width: '25%',  color: '#f87171', label: 'Lemah' },
            { width: '50%',  color: '#fbbf24', label: 'Cukup' },
            { width: '75%',  color: '#34d399', label: 'Kuat' },
            { width: '100%', color: '#059669', label: 'Sangat Kuat' },
        ];

        fill.style.width     = levels[score].width;
        fill.style.background = levels[score].color;
        text.textContent     = val.length > 0 ? `Kekuatan: ${levels[score].label}` : '';
        text.style.color     = levels[score].color;
    }

    // Password match checker
    function checkMatch() {
        const pw   = document.getElementById('passwordInput').value;
        const conf = document.getElementById('confirmInput').value;
        const msg  = document.getElementById('matchText');
        if (conf.length === 0) { msg.classList.add('hidden'); return; }
        msg.classList.remove('hidden');
        if (pw === conf) {
            msg.textContent  = '✓ Password cocok';
            msg.style.color  = '#059669';
        } else {
            msg.textContent  = '✗ Password tidak cocok';
            msg.style.color  = '#f87171';
        }
    }

    // Update role icon colors
    function updateRoleIcons() {
        const radios = document.querySelectorAll('input[name="role"]');
        radios.forEach(r => {
            const icon = r.closest('label').querySelector('.role-icon i');
            if (r.checked) {
                icon.style.color = '#059669';
            } else {
                icon.style.color = '#64748b';
            }
        });
    }

    // Loading on submit
    document.querySelector('form').addEventListener('submit', function() {
        document.getElementById('btnText').classList.add('hidden');
        document.getElementById('btnLoading').classList.remove('hidden');
    });

    // Init role colors on page load
    updateRoleIcons();
</script>
@endpush
