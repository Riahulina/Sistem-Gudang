@extends('layouts.app')

@section('title', 'Buat User Baru — Our Stock')

@push('styles')
<style>
    body { background: #f8fafc; }

    .page-header {
        background: linear-gradient(135deg, #064e3b 0%, #047857 60%, #059669 100%);
        border-radius: 1.5rem;
        padding: 1.75rem 2rem;
        position: relative;
        overflow: hidden;
    }
    .page-header::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 200px; height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,.08), transparent 70%);
        border-radius: 50%;
    }
    .page-header::after {
        content: '';
        position: absolute;
        bottom: -60px; left: 30%;
        width: 250px; height: 250px;
        background: radial-gradient(circle, rgba(255,255,255,.05), transparent 70%);
        border-radius: 50%;
    }

    .section-label {
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #059669;
    }

    /* Permission toggle items */
    .perm-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .875rem 1.125rem;
        border-radius: .875rem;
        border: 1.5px solid #f1f5f9;
        background: #fff;
        transition: border-color .2s, box-shadow .2s, background .2s;
        cursor: pointer;
    }
    .perm-item:hover { border-color: #a7f3d0; background: #f0fdf6; }
    .perm-item.active {
        border-color: #6ee7b7;
        background: linear-gradient(135deg, #f0fdf6 0%, #ecfdf5 100%);
        box-shadow: 0 0 0 3px rgba(5,150,105,.08);
    }

    .perm-icon-wrap {
        width: 36px; height: 36px;
        border-radius: .625rem;
        display: flex; align-items: center; justify-content: center;
        background: #f1f5f9;
        transition: background .2s;
        flex-shrink: 0;
    }
    .perm-item.active .perm-icon-wrap { background: #d1fae5; }
    .perm-item.active .perm-icon-wrap i { color: #059669 !important; }

    .status-badge {
        font-size: .7rem; font-weight: 700;
        padding: .2rem .6rem;
        border-radius: 99px;
        transition: all .2s;
        letter-spacing: .03em;
    }
    .status-badge.off { background: #f1f5f9; color: #94a3b8; }
    .status-badge.on  { background: #d1fae5; color: #065f46; }

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
        transition: width .4s, background .4s;
        width: 0%;
    }

    .select-all-btn {
        font-size: .8rem; font-weight: 600;
        color: #059669;
        background: none;
        border: none;
        cursor: pointer;
        text-decoration: underline;
        text-underline-offset: 3px;
        padding: 0;
    }
    .select-all-btn:hover { color: #047857; }

    .progress-step {
        display: flex; align-items: center; gap: .5rem;
        font-size: .8rem; font-weight: 600; color: #94a3b8;
    }
    .progress-step.done { color: #059669; }
    .step-circle {
        width: 22px; height: 22px;
        border-radius: 50%;
        background: #e2e8f0;
        display: flex; align-items: center; justify-content: center;
        font-size: .65rem; font-weight: 700;
        transition: all .2s;
    }
    .progress-step.done .step-circle { background: #059669; color: #fff; }
    .step-sep { flex: 1; height: 1px; background: #e2e8f0; min-width: 20px; }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="page-header animate-fade-up">
            <div class="relative z-10 flex items-center gap-4">
                <div style="width:48px;height:48px;background:rgba(255,255,255,.15);border-radius:14px;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);border:1px solid rgba(255,255,255,.2);">
                    <i data-lucide="user-plus" style="width:24px;height:24px;color:white;"></i>
                </div>
                <div>
                    <p class="text-emerald-200 text-xs font-600 uppercase tracking-widest mb-0.5">KTU · Manajemen Akses</p>
                    <h1 class="text-2xl font-800 text-white" style="font-weight:800;">Buat User Baru</h1>
                </div>
            </div>
        </div>

        {{-- Progress Indicator --}}
        <div class="flex items-center gap-2 px-1 animate-fade-up" style="animation-delay:.1s;opacity:0;animation-fill-mode:both;">
            <div class="progress-step done" id="step1">
                <div class="step-circle">1</div>
                <span>Informasi Akun</span>
            </div>
            <div class="step-sep"></div>
            <div class="progress-step" id="step2">
                <div class="step-circle">2</div>
                <span>Otorisasi Akses</span>
            </div>
            <div class="step-sep"></div>
            <div class="progress-step" id="step3">
                <div class="step-circle">3</div>
                <span>Konfirmasi</span>
            </div>
        </div>

        {{-- Alert --}}
        @if(session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl px-4 py-3.5 text-sm font-medium animate-fade-up">
            <i data-lucide="check-circle-2" style="width:18px;height:18px;flex-shrink:0;"></i>
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-4 py-3.5 text-sm font-medium animate-fade-up">
            <i data-lucide="circle-alert" style="width:18px;height:18px;flex-shrink:0;margin-top:1px;"></i>
            <ul class="space-y-1">
                @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('users.store') }}" id="createUserForm">
            @csrf

            {{-- Section 1: Account Info --}}
            <div class="card p-6 space-y-5 animate-fade-up" style="animation-delay:.15s;opacity:0;animation-fill-mode:both;">
                <div class="flex items-center gap-2 mb-1">
                    <span class="section-label">Informasi Akun</span>
                </div>

                {{-- Username --}}
                <div>
                    <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">
                        Username <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span style="position:absolute;left:.875rem;top:50%;transform:translateY(-50%);color:#94a3b8;">
                            <i data-lucide="at-sign" style="width:15px;height:15px;"></i>
                        </span>
                        <input type="text" name="username" id="usernameInput"
                            class="input-field @error('username') border-red-400 @enderror"
                            style="padding-left:2.5rem;"
                            placeholder="cth: john_doe"
                            value="{{ old('username') }}"
                            oninput="checkUsername(this.value)"
                            required>
                    </div>
                    <div id="usernameHint" class="mt-1.5 text-xs text-slate-400 hidden flex items-center gap-1">
                        <i data-lucide="info" style="width:11px;height:11px;"></i>
                        Gunakan huruf kecil, angka, atau underscore
                    </div>
                    @error('username')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">
                        Password <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span style="position:absolute;left:.875rem;top:50%;transform:translateY(-50%);color:#94a3b8;">
                            <i data-lucide="key-round" style="width:15px;height:15px;"></i>
                        </span>
                        <input type="password" name="password" id="passwordInput"
                            class="input-field @error('password') border-red-400 @enderror"
                            style="padding-left:2.5rem;padding-right:3rem;"
                            placeholder="Min. 8 karakter"
                            oninput="checkStrength(this.value)"
                            required>
                        <button type="button" onclick="togglePw('passwordInput','eyeP1')"
                            style="position:absolute;right:.875rem;top:50%;transform:translateY(-50%);color:#94a3b8;background:none;border:none;cursor:pointer;">
                            <i data-lucide="eye" id="eyeP1" style="width:15px;height:15px;"></i>
                        </button>
                    </div>
                    <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                    <p class="text-xs mt-1 font-medium" id="strengthLabel" style="color:#94a3b8;">Masukkan password</p>
                    @error('password')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">
                        Konfirmasi Password <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span style="position:absolute;left:.875rem;top:50%;transform:translateY(-50%);color:#94a3b8;">
                            <i data-lucide="shield-check" style="width:15px;height:15px;"></i>
                        </span>
                        <input type="password" name="password_confirmation" id="confirmPwInput"
                            class="input-field"
                            style="padding-left:2.5rem;padding-right:3rem;"
                            placeholder="Ulangi password"
                            oninput="checkMatch()"
                            required>
                        <button type="button" onclick="togglePw('confirmPwInput','eyeP2')"
                            style="position:absolute;right:.875rem;top:50%;transform:translateY(-50%);color:#94a3b8;background:none;border:none;cursor:pointer;">
                            <i data-lucide="eye" id="eyeP2" style="width:15px;height:15px;"></i>
                        </button>
                    </div>
                    <p class="text-xs mt-1.5 font-medium hidden" id="matchStatus"></p>
                </div>
            </div>

            {{-- Section 2: Permissions --}}
            <div class="card p-6 animate-fade-up" style="animation-delay:.25s;opacity:0;animation-fill-mode:both;margin-top:1.25rem;">
                <div class="flex items-center justify-between mb-4">
                    <span class="section-label">Otorisasi Akses</span>
                    <div class="flex gap-3">
                        <button type="button" class="select-all-btn" onclick="toggleAll(true)">Pilih Semua</button>
                        <span class="text-slate-300">·</span>
                        <button type="button" class="select-all-btn" style="color:#ef4444;text-decoration-color:#ef4444;" onclick="toggleAll(false)">Hapus Semua</button>
                    </div>
                </div>

                <div class="space-y-2.5" id="permissionList">

                    @php
                    $perms = [
                        ['key'=>'create_user',       'label'=>'Create User',                'desc'=>'Membuat & mengelola pengguna',      'icon'=>'users',        'color'=>'#8b5cf6'],
                        ['key'=>'create_barang',     'label'=>'Create Barang',              'desc'=>'Menambahkan data barang baru',      'icon'=>'package',      'color'=>'#f59e0b'],
                        ['key'=>'create_barang_masuk_keluar','label'=>'Create Barang Masuk & Keluar','desc'=>'Mencatat transaksi stok masuk/keluar','icon'=>'arrow-left-right','color'=>'#06b6d4'],
                        ['key'=>'create_vehicle',    'label'=>'Create Vehicle / Kendaraan', 'desc'=>'Mengelola data armada kendaraan',   'icon'=>'truck',        'color'=>'#f97316'],
                        ['key'=>'dashboard',         'label'=>'Dashboard',                  'desc'=>'Akses halaman ringkasan utama',     'icon'=>'layout-dashboard','color'=>'#059669'],
                        ['key'=>'stock_report',      'label'=>'Stock Report',               'desc'=>'Melihat & mencetak laporan stok',   'icon'=>'bar-chart-3',  'color'=>'#ec4899'],
                    ];
                    @endphp

                    @foreach($perms as $perm)
                    <div class="perm-item {{ old('permissions.'.$perm['key']) ? 'active' : '' }}"
                         id="perm-{{ $perm['key'] }}"
                         onclick="togglePerm('{{ $perm['key'] }}')">

                        <div class="flex items-center gap-3">
                            <div class="perm-icon-wrap">
                                <i data-lucide="{{ $perm['icon'] }}"
                                   style="width:17px;height:17px;color:{{ $perm['color'] }};"></i>
                            </div>
                            <div>
                                <p class="text-sm font-600 text-slate-800" style="font-weight:600;">{{ $perm['label'] }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $perm['desc'] }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2.5 flex-shrink-0">
                            <span class="status-badge {{ old('permissions.'.$perm['key']) ? 'on' : 'off' }}"
                                  id="badge-{{ $perm['key'] }}">
                                {{ old('permissions.'.$perm['key']) ? 'AKtif' : 'Nonaktif' }}
                            </span>
                            <div class="toggle-wrap flex items-center">
                                <input type="checkbox"
                                       name="permissions[{{ $perm['key'] }}]"
                                       id="chk-{{ $perm['key'] }}"
                                       value="1"
                                       {{ old('permissions.'.$perm['key']) ? 'checked' : '' }}>
                                <div class="toggle-track" style="pointer-events:none;">
                                    <div class="toggle-thumb"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>

                {{-- Permission summary --}}
                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <p class="text-sm text-slate-400">
                        <span id="permCount" class="font-700 text-slate-700" style="font-weight:700;">0</span>
                        dari 6 akses dipilih
                    </p>
                    <div class="flex gap-1" id="permDots">
                        @for($i=0;$i<6;$i++)
                        <div class="perm-dot" style="width:8px;height:8px;border-radius:50%;background:#e2e8f0;transition:background .2s;"></div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-3 animate-fade-up" style="animation-delay:.35s;opacity:0;animation-fill-mode:both;margin-top:1.25rem;">
                <a href="{{ route('dashboard') }}"
                   class="btn-secondary flex-1 text-center" style="text-decoration:none;">
                    <i data-lucide="arrow-left" style="width:15px;height:15px;"></i>
                    Batal
                </a>
                <button type="submit" class="btn-primary flex-1" id="submitBtn">
                    <i data-lucide="user-plus" style="width:16px;height:16px;"></i>
                    Buat User
                </button>
            </div>

        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle permission item
    function togglePerm(key) {
        const item  = document.getElementById('perm-' + key);
        const chk   = document.getElementById('chk-' + key);
        const badge = document.getElementById('badge-' + key);

        chk.checked = !chk.checked;

        if (chk.checked) {
            item.classList.add('active');
            badge.classList.remove('off'); badge.classList.add('on');
            badge.textContent = 'Aktif';
        } else {
            item.classList.remove('active');
            badge.classList.remove('on'); badge.classList.add('off');
            badge.textContent = 'Nonaktif';
        }
        updatePermCount();
        lucide.createIcons();
    }

    function toggleAll(val) {
        const keys = ['create_user','create_barang','create_barang_masuk_keluar','create_vehicle','dashboard','stock_report'];
        keys.forEach(k => {
            const chk = document.getElementById('chk-' + k);
            if (chk.checked !== val) togglePerm(k);
        });
    }

    function updatePermCount() {
        const checks = document.querySelectorAll('#permissionList input[type=checkbox]');
        let count = 0;
        checks.forEach((c, i) => {
            if (c.checked) count++;
            const dot = document.querySelectorAll('.perm-dot')[i];
            if (dot) dot.style.background = c.checked ? '#059669' : '#e2e8f0';
        });
        document.getElementById('permCount').textContent = count;
    }

    // Password visibility toggle
    function togglePw(inputId, iconId) {
        const inp  = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        const show = inp.type === 'password';
        inp.type = show ? 'text' : 'password';
        icon.setAttribute('data-lucide', show ? 'eye-off' : 'eye');
        lucide.createIcons();
    }

    // Password strength
    function checkStrength(val) {
        const fill  = document.getElementById('strengthFill');
        const label = document.getElementById('strengthLabel');
        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const levels = [
            { w:'0%',   c:'#e2e8f0', t:'Masukkan password',     tc:'#94a3b8' },
            { w:'25%',  c:'#f87171', t:'Lemah',                  tc:'#ef4444' },
            { w:'50%',  c:'#fb923c', t:'Sedang',                 tc:'#f97316' },
            { w:'75%',  c:'#facc15', t:'Kuat',                   tc:'#d97706' },
            { w:'100%', c:'#34d399', t:'Sangat Kuat ✓',          tc:'#059669' },
        ];
        const l = levels[score] || levels[0];
        fill.style.width = l.w;
        fill.style.background = l.c;
        label.textContent = l.t;
        label.style.color = l.tc;

        checkMatch();
    }

    function checkMatch() {
        const pw  = document.getElementById('passwordInput').value;
        const cpw = document.getElementById('confirmPwInput').value;
        const el  = document.getElementById('matchStatus');
        if (!cpw) { el.classList.add('hidden'); return; }
        el.classList.remove('hidden');
        if (pw === cpw) {
            el.style.color = '#059669'; el.textContent = '✓ Password cocok';
        } else {
            el.style.color = '#ef4444'; el.textContent = '✗ Password tidak cocok';
        }
    }

    function checkUsername(val) {
        document.getElementById('usernameHint').classList.toggle('hidden', val.length === 0);
    }

    // Init count
    updatePermCount();
</script>
@endpush
