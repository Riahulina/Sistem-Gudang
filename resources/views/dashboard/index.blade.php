@extends('layouts.app')

@section('title', 'Dashboard — Our Stock')

@push('styles')
<style>
    body { background: #f1f5f9; overflow-x: hidden; }

    /* ───── Sidebar ───── */
    #sidebar {
        width: 260px;
        min-height: 100vh;
        background: linear-gradient(180deg, #022c22 0%, #064e3b 40%, #065f46 100%);
        position: fixed; top: 0; left: 0; z-index: 40;
        display: flex; flex-direction: column;
        transition: transform .3s cubic-bezier(.4,0,.2,1);
        box-shadow: 4px 0 24px rgba(0,0,0,.15);
    }

    .sidebar-logo {
        padding: 1.5rem 1.25rem 1.25rem;
        border-bottom: 1px solid rgba(255,255,255,.07);
    }
    .logo-badge {
        width: 40px; height: 40px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 12px rgba(16,185,129,.4);
    }

    .sidebar-nav { padding: .875rem .875rem; flex: 1; overflow-y: auto; }
    .nav-section-title {
        font-size: .625rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: rgba(255,255,255,.3);
        padding: .75rem .5rem .5rem;
        margin-bottom: .25rem;
    }

    .nav-link {
        display: flex; align-items: center; gap: .75rem;
        padding: .65rem .875rem;
        border-radius: .75rem;
        color: rgba(255,255,255,.6);
        font-size: .875rem; font-weight: 500;
        text-decoration: none;
        transition: all .2s;
        margin-bottom: 2px;
        position: relative;
    }
    .nav-link:hover { background: rgba(255,255,255,.08); color: #fff; }
    .nav-link.active {
        background: rgba(255,255,255,.12);
        color: #fff;
        font-weight: 600;
    }
    .nav-link.active::before {
        content: '';
        position: absolute;
        left: 0; top: 20%; height: 60%;
        width: 3px;
        background: #34d399;
        border-radius: 0 4px 4px 0;
    }
    .nav-link .nav-icon {
        width: 32px; height: 32px;
        border-radius: .5rem;
        display: flex; align-items: center; justify-content: center;
        background: rgba(255,255,255,.07);
        flex-shrink: 0;
        transition: background .2s;
    }
    .nav-link.active .nav-icon { background: rgba(52,211,153,.2); }
    .nav-link:hover .nav-icon  { background: rgba(255,255,255,.12); }

    .sidebar-footer {
        padding: 1rem .875rem;
        border-top: 1px solid rgba(255,255,255,.07);
    }
    .user-card {
        display: flex; align-items: center; gap: .75rem;
        padding: .625rem .75rem;
        border-radius: .875rem;
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,255,255,.08);
    }
    .user-avatar {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #34d399, #059669);
        display: flex; align-items: center; justify-content: center;
        font-size: .85rem; font-weight: 700; color: #fff;
        flex-shrink: 0;
    }

    /* ───── Main Content ───── */
    #main-content {
        margin-left: 260px;
        min-height: 100vh;
        transition: margin-left .3s;
    }

    /* Topbar */
    .topbar {
        background: rgba(255,255,255,.9);
        backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(0,0,0,.06);
        padding: .875rem 1.75rem;
        display: flex; align-items: center; justify-content: space-between;
        position: sticky; top: 0; z-index: 30;
    }

    .notification-btn {
        width: 38px; height: 38px;
        border-radius: .75rem;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: all .2s;
        position: relative;
        color: #64748b;
    }
    .notification-btn:hover { border-color: #a7f3d0; background: #ecfdf5; color: #059669; }
    .notif-dot {
        position: absolute; top: 7px; right: 7px;
        width: 8px; height: 8px;
        background: #ef4444;
        border-radius: 50%;
        border: 2px solid white;
    }

    /* ───── Stat Cards ───── */
    .stat-card {
        background: #fff;
        border-radius: 1.25rem;
        padding: 1.375rem 1.5rem;
        position: relative;
        overflow: hidden;
        transition: transform .2s, box-shadow .2s;
        border: 1px solid rgba(0,0,0,.05);
        box-shadow: 0 1px 3px rgba(0,0,0,.05), 0 8px 24px rgba(0,0,0,.06);
    }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 6px rgba(0,0,0,.05), 0 16px 32px rgba(0,0,0,.09); }
    .stat-card .card-bg {
        position: absolute;
        top: -20px; right: -20px;
        width: 110px; height: 110px;
        border-radius: 50%;
        opacity: .07;
    }
    .stat-icon {
        width: 44px; height: 44px;
        border-radius: .875rem;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: .875rem;
    }
    .stat-value {
        font-size: 1.875rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
        letter-spacing: -.02em;
    }
    .stat-label {
        font-size: .8rem; font-weight: 600;
        color: #64748b;
        margin-top: .25rem;
    }
    .stat-change {
        display: inline-flex; align-items: center; gap: .25rem;
        font-size: .7rem; font-weight: 700;
        padding: .2rem .55rem;
        border-radius: 99px;
        margin-top: .625rem;
    }
    .stat-change.up   { background: #ecfdf5; color: #059669; }
    .stat-change.down { background: #fef2f2; color: #ef4444; }
    .stat-change.flat { background: #f8fafc; color: #64748b; }

    /* Activity Feed */
    .activity-item {
        display: flex; align-items: flex-start; gap: .875rem;
        padding: .875rem 0;
        border-bottom: 1px solid #f1f5f9;
        animation: fadeIn .4s ease both;
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-dot {
        width: 8px; height: 8px; border-radius: 50%;
        flex-shrink: 0; margin-top: .375rem;
    }

    /* Quick Actions */
    .quick-action {
        display: flex; flex-direction: column; align-items: center; gap: .625rem;
        padding: 1.125rem .875rem;
        background: #fff;
        border: 1.5px solid #f1f5f9;
        border-radius: 1rem;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
    }
    .quick-action:hover { border-color: #a7f3d0; background: #f0fdf6; transform: translateY(-1px); box-shadow: 0 4px 15px rgba(5,150,105,.1); }
    .quick-action-icon {
        width: 44px; height: 44px;
        border-radius: .75rem;
        display: flex; align-items: center; justify-content: center;
    }

    /* Chart bar */
    .chart-bar { transition: height .8s cubic-bezier(.34,1.56,.64,1); }

    /* Mobile overlay */
    #sidebarOverlay {
        display: none;
        position: fixed; inset: 0; z-index: 35;
        background: rgba(0,0,0,.4);
    }

    @media (max-width: 1024px) {
        #sidebar { transform: translateX(-100%); }
        #sidebar.open { transform: translateX(0); }
        #main-content { margin-left: 0; }
        #sidebarOverlay.open { display: block; }
    }
</style>
@endpush

@section('content')

{{-- Sidebar Overlay (mobile) --}}
<div id="sidebarOverlay" onclick="closeSidebar()"></div>

{{-- ═══════════ SIDEBAR ═══════════ --}}
<aside id="sidebar">

    {{-- Logo --}}
    <div class="sidebar-logo">
        <div class="flex items-center gap-3">
            <div class="logo-badge">
                <i data-lucide="package-2" style="width:20px;height:20px;color:white;"></i>
            </div>
            <div>
                <p class="text-white font-800 text-base leading-tight" style="font-weight:800;">Our Stock</p>
                <p class="text-emerald-400 text-xs font-medium">Manajemen Gudang</p>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">

        {{-- Main --}}
        <p class="nav-section-title">Menu Utama</p>

        {{-- Dashboard: selalu tampil --}}
        @if(auth()->user()->hasPermission('dashboard'))
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="nav-icon">
                <i data-lucide="layout-dashboard" style="width:16px;height:16px;color:#34d399;"></i>
            </span>
            Dashboard
        </a>
        @endif

        @if(auth()->user()->hasPermission('stock_report'))
        <a href="{{ route('stock.report') }}" class="nav-link {{ request()->routeIs('stock.*') ? 'active' : '' }}">
            <span class="nav-icon">
                <i data-lucide="bar-chart-3" style="width:16px;height:16px;color:#60a5fa;"></i>
            </span>
            Stock Report
        </a>
        @endif

        {{-- Manajemen Data --}}
        @if(auth()->user()->hasPermission('create_barang') || auth()->user()->hasPermission('create_barang_masuk_keluar') || auth()->user()->hasPermission('create_vehicle'))
        <p class="nav-section-title" style="margin-top:.75rem;">Manajemen Data</p>
        @endif

        @if(auth()->user()->hasPermission('create_barang'))
        <a href="{{ route('barang.index') }}" class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}">
            <span class="nav-icon">
                <i data-lucide="package" style="width:16px;height:16px;color:#fbbf24;"></i>
            </span>
            Data Barang
        </a>
        <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
            <span class="nav-icon">
                <i data-lucide="tags" style="width:16px;height:16px;color:#a78bfa;"></i>
            </span>
            Kategori
        </a>
        @endif

        @if(auth()->user()->hasPermission('create_barang_masuk_keluar'))
        <a href="{{ route('transaksi.index') }}" class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
            <span class="nav-icon">
                <i data-lucide="arrow-left-right" style="width:16px;height:16px;color:#22d3ee;"></i>
            </span>
            Barang Masuk & Keluar
        </a>
        @endif

        @if(auth()->user()->hasPermission('create_vehicle'))
        <a href="{{ route('kendaraan.index') }}" class="nav-link {{ request()->routeIs('kendaraan.*') ? 'active' : '' }}">
            <span class="nav-icon">
                <i data-lucide="truck" style="width:16px;height:16px;color:#fb923c;"></i>
            </span>
            Kendaraan
        </a>
        @endif

        {{-- Admin --}}
        @if(auth()->user()->hasPermission('create_user'))
        <p class="nav-section-title" style="margin-top:.75rem;">Administrasi</p>
        <a href="{{ route('users.create') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <span class="nav-icon">
                <i data-lucide="users" style="width:16px;height:16px;color:#a78bfa;"></i>
            </span>
            Manajemen User
        </a>
        @endif

    </nav>

    {{-- User Profile --}}
    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->username ?? 'U', 0, 1)) }}
            </div>
            <div style="flex:1;min-width:0;">
                <p class="text-white text-sm font-600 truncate" style="font-weight:600;">
                    {{ auth()->user()->username ?? 'User' }}
                </p>
                <p class="text-emerald-400 text-xs truncate">
                    {{ auth()->user()->role ?? 'Staff Gudang' }}
                </p>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" title="Logout"
                    style="width:30px;height:30px;background:rgba(255,255,255,.08);border:none;border-radius:.5rem;cursor:pointer;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.5);transition:all .2s;"
                    onmouseover="this.style.background='rgba(239,68,68,.2)';this.style.color='#f87171';"
                    onmouseout="this.style.background='rgba(255,255,255,.08)';this.style.color='rgba(255,255,255,.5)';">
                    <i data-lucide="log-out" style="width:14px;height:14px;"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- ═══════════ MAIN CONTENT ═══════════ --}}
<div id="main-content">

    {{-- Topbar --}}
    <div class="topbar">
        <div class="flex items-center gap-3">
            <button onclick="toggleSidebar()"
                style="width:38px;height:38px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:.75rem;display:flex;align-items:center;justify-content:center;cursor:pointer;color:#64748b;transition:all .2s;"
                class="lg:hidden">
                <i data-lucide="menu" style="width:18px;height:18px;"></i>
            </button>
            <div>
                <h2 class="text-lg font-700 text-slate-900" style="font-weight:700;">Dashboard</h2>
                <p class="text-xs text-slate-400">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2.5">

            {{-- Search --}}
            <div class="relative hidden sm:block">
                <span style="position:absolute;left:.75rem;top:50%;transform:translateY(-50%);color:#94a3b8;">
                    <i data-lucide="search" style="width:14px;height:14px;"></i>
                </span>
                <input type="text" placeholder="Cari barang, kendaraan..."
                    style="padding:.5rem .875rem .5rem 2.25rem;border:1.5px solid #e2e8f0;border-radius:.75rem;font-size:.8rem;color:#1e293b;background:#f8fafc;outline:none;width:220px;font-family:'Plus Jakarta Sans',sans-serif;transition:all .2s;"
                    onfocus="this.style.borderColor='#059669';this.style.boxShadow='0 0 0 3px rgba(5,150,105,.1)';this.style.background='#fff';"
                    onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none';this.style.background='#f8fafc';">
            </div>

            {{-- Notif --}}
            <button class="notification-btn">
                <i data-lucide="bell" style="width:16px;height:16px;"></i>
                <span class="notif-dot"></span>
            </button>

            {{-- Avatar --}}
            <div style="width:38px;height:38px;background:linear-gradient(135deg,#34d399,#059669);border-radius:.75rem;display:flex;align-items:center;justify-content:center;font-size:.85rem;font-weight:700;color:#fff;cursor:pointer;box-shadow:0 4px 12px rgba(5,150,105,.25);">
                {{ strtoupper(substr(auth()->user()->username ?? 'U', 0, 1)) }}
            </div>
        </div>
    </div>

    {{-- Page Body --}}
    <div class="p-6 lg:p-8 space-y-6 max-w-screen-xl mx-auto">

        {{-- Welcome Banner --}}
        <div style="background:linear-gradient(135deg,#064e3b 0%,#047857 50%,#059669 100%);border-radius:1.5rem;padding:1.75rem 2rem;position:relative;overflow:hidden;" class="animate-fade-up">
            <div style="position:absolute;top:-30px;right:-30px;width:180px;height:180px;background:radial-gradient(circle,rgba(255,255,255,.08),transparent 70%);border-radius:50%;"></div>
            <div style="position:absolute;bottom:-50px;right:30%;width:200px;height:200px;background:radial-gradient(circle,rgba(16,185,129,.15),transparent 70%);border-radius:50%;"></div>
            <div class="relative z-10 flex items-center justify-between flex-wrap gap-4">
                <div>
                    <p class="text-emerald-200 text-sm font-600 mb-1">
                        Selamat datang kembali,
                    </p>
                    <h3 class="text-white text-2xl font-800" style="font-weight:800;">
                        {{ auth()->user()->username ?? 'User' }} 👋
                    </h3>
                    <p class="text-emerald-300 text-sm mt-1.5">
                        Berikut ringkasan aktivitas gudang hari ini.
                    </p>
                </div>
                <div style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);border-radius:1rem;padding:.875rem 1.25rem;backdrop-filter:blur(8px);">
                    <p class="text-emerald-200 text-xs font-600 uppercase tracking-wider mb-1">Status Gudang</p>
                    <div class="flex items-center gap-2">
                        <div style="width:8px;height:8px;background:#34d399;border-radius:50%;animation:pulse 2s infinite;"></div>
                        <p class="text-white text-sm font-700" style="font-weight:700;">Operasional Normal</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Total Barang --}}
            <div class="stat-card animate-fade-up" style="animation-delay:.1s;opacity:0;animation-fill-mode:both;">
                <div class="card-bg" style="background:#fbbf24;"></div>
                <div class="stat-icon" style="background:#fffbeb;">
                    <i data-lucide="package" style="width:20px;height:20px;color:#f59e0b;"></i>
                </div>
                <div class="stat-value">{{ $totalBarang ?? '1,248' }}</div>
                <div class="stat-label">Total Barang</div>
                <div class="stat-change up">
                    <i data-lucide="trending-up" style="width:10px;height:10px;"></i>
                    +12% bulan ini
                </div>
            </div>

            {{-- Barang Masuk --}}
            <div class="stat-card animate-fade-up" style="animation-delay:.15s;opacity:0;animation-fill-mode:both;">
                <div class="card-bg" style="background:#10b981;"></div>
                <div class="stat-icon" style="background:#ecfdf5;">
                    <i data-lucide="package-plus" style="width:20px;height:20px;color:#059669;"></i>
                </div>
                <div class="stat-value">{{ $barangMasukHariIni ?? '84' }}</div>
                <div class="stat-label">Masuk Hari Ini</div>
                <div class="stat-change up">
                    <i data-lucide="trending-up" style="width:10px;height:10px;"></i>
                    +8 dari kemarin
                </div>
            </div>

            {{-- Barang Keluar --}}
            <div class="stat-card animate-fade-up" style="animation-delay:.2s;opacity:0;animation-fill-mode:both;">
                <div class="card-bg" style="background:#ef4444;"></div>
                <div class="stat-icon" style="background:#fef2f2;">
                    <i data-lucide="package-minus" style="width:20px;height:20px;color:#ef4444;"></i>
                </div>
                <div class="stat-value">{{ $barangKeluarHariIni ?? '37' }}</div>
                <div class="stat-label">Keluar Hari Ini</div>
                <div class="stat-change down">
                    <i data-lucide="trending-down" style="width:10px;height:10px;"></i>
                    -3 dari kemarin
                </div>
            </div>

            {{-- Kendaraan Aktif --}}
            <div class="stat-card animate-fade-up" style="animation-delay:.25s;opacity:0;animation-fill-mode:both;">
                <div class="card-bg" style="background:#fb923c;"></div>
                <div class="stat-icon" style="background:#fff7ed;">
                    <i data-lucide="truck" style="width:20px;height:20px;color:#f97316;"></i>
                </div>
                <div class="stat-value">{{ $kendaraanAktif ?? '12' }}</div>
                <div class="stat-label">Kendaraan Aktif</div>
                <div class="stat-change flat">
                    <i data-lucide="minus" style="width:10px;height:10px;"></i>
                    Sama dari kemarin
                </div>
            </div>
        </div>

        {{-- Row: Chart + Activity --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Bar Chart --}}
            <div class="lg:col-span-2 card p-6 animate-fade-up" style="animation-delay:.3s;opacity:0;animation-fill-mode:both;">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="font-700 text-slate-900 text-sm" style="font-weight:700;">Arus Stok 7 Hari Terakhir</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Perbandingan barang masuk & keluar</p>
                    </div>
                    <div class="flex items-center gap-3 text-xs font-600">
                        <span class="flex items-center gap-1.5">
                            <span style="width:8px;height:8px;border-radius:50%;background:#059669;display:inline-block;"></span>
                            Masuk
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span style="width:8px;height:8px;border-radius:50%;background:#fbbf24;display:inline-block;"></span>
                            Keluar
                        </span>
                    </div>
                </div>

                {{-- Chart --}}
                <div class="flex items-end gap-2.5" style="height:140px;" id="barChart">
                    @php
                    $days   = ['Sen','Sel','Rab','Kam','Jum','Sab','Min'];
                    $masuk  = [65, 80, 55, 90, 70, 45, 84];
                    $keluar = [30, 45, 28, 50, 38, 20, 37];
                    $maxVal = max(array_merge($masuk, $keluar));
                    @endphp
                    @foreach($days as $i => $day)
                    <div class="flex flex-col items-center gap-1 flex-1">
                        <div class="flex items-end gap-0.5 w-full justify-center" style="height:120px;">
                            <div class="chart-bar rounded-t-md"
                                 style="width:45%;background:linear-gradient(to top,#059669,#34d399);height:0%;border-radius:4px 4px 0 0;"
                                 data-val="{{ round($masuk[$i] / $maxVal * 100) }}">
                            </div>
                            <div class="chart-bar rounded-t-md"
                                 style="width:45%;background:linear-gradient(to top,#d97706,#fbbf24);height:0%;border-radius:4px 4px 0 0;"
                                 data-val="{{ round($keluar[$i] / $maxVal * 100) }}">
                            </div>
                        </div>
                        <span class="text-slate-400 text-xs font-500">{{ $day }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Activity Feed --}}
            <div class="card p-6 animate-fade-up" style="animation-delay:.35s;opacity:0;animation-fill-mode:both;">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-700 text-slate-900 text-sm" style="font-weight:700;">Aktivitas Terbaru</h3>
                    <span style="background:#ecfdf5;color:#059669;font-size:.65rem;font-weight:700;padding:.2rem .6rem;border-radius:99px;border:1px solid #a7f3d0;">Live</span>
                </div>

                <div class="space-y-0">
                    @php
                    $activities = [
                        ['color'=>'#059669','text'=>'Semen 50kg masuk 20 sak','time'=>'5 menit lalu','icon'=>'package-plus'],
                        ['color'=>'#f59e0b','text'=>'Besi hollow 4x4 keluar 15 batang','time'=>'23 menit lalu','icon'=>'package-minus'],
                        ['color'=>'#3b82f6','text'=>'Kendaraan B-1234-XY berangkat','time'=>'1 jam lalu','icon'=>'truck'],
                        ['color'=>'#8b5cf6','text'=>'User "operator02" dibuat','time'=>'2 jam lalu','icon'=>'user-plus'],
                        ['color'=>'#ef4444','text'=>'Stok Pasir hampir habis!','time'=>'3 jam lalu','icon'=>'alert-triangle'],
                    ];
                    @endphp
                    @foreach($activities as $act)
                    <div class="activity-item">
                        <div style="width:28px;height:28px;border-radius:.5rem;background:{{ $act['color'] }}18;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i data-lucide="{{ $act['icon'] }}" style="width:13px;height:13px;color:{{ $act['color'] }};"></i>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <p class="text-sm text-slate-700 font-500 leading-snug" style="font-weight:500;">{{ $act['text'] }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $act['time'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        @if(auth()->user()->hasPermission('create_barang') || auth()->user()->hasPermission('create_barang_masuk_keluar') || auth()->user()->hasPermission('create_vehicle') || auth()->user()->hasPermission('create_user'))
        <div class="card p-6 animate-fade-up" style="animation-delay:.4s;opacity:0;animation-fill-mode:both;">
            <h3 class="font-700 text-slate-900 text-sm mb-4" style="font-weight:700;">Aksi Cepat</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @if(auth()->user()->hasPermission('create_barang'))
                <a href="{{ route('barang.create') }}" class="quick-action">
                    <div class="quick-action-icon" style="background:#fffbeb;">
                        <i data-lucide="package-plus" style="width:20px;height:20px;color:#f59e0b;"></i>
                    </div>
                    <span class="text-xs font-600 text-slate-700 text-center" style="font-weight:600;">Tambah Barang</span>
                </a>
                @endif
                @if(auth()->user()->hasPermission('create_barang_masuk_keluar'))
                <a href="{{ route('transaksi.create') }}" class="quick-action">
                    <div class="quick-action-icon" style="background:#ecfeff;">
                        <i data-lucide="arrow-up-down" style="width:20px;height:20px;color:#06b6d4;"></i>
                    </div>
                    <span class="text-xs font-600 text-slate-700 text-center" style="font-weight:600;">Catat Transaksi</span>
                </a>
                @endif
                @if(auth()->user()->hasPermission('create_vehicle'))
                <a href="{{ route('kendaraan.create') }}" class="quick-action">
                    <div class="quick-action-icon" style="background:#fff7ed;">
                        <i data-lucide="truck" style="width:20px;height:20px;color:#f97316;"></i>
                    </div>
                    <span class="text-xs font-600 text-slate-700 text-center" style="font-weight:600;">Tambah Kendaraan</span>
                </a>
                @endif
                @if(auth()->user()->hasPermission('create_user'))
                <a href="{{ route('users.create') }}" class="quick-action">
                    <div class="quick-action-icon" style="background:#f5f3ff;">
                        <i data-lucide="user-plus" style="width:20px;height:20px;color:#8b5cf6;"></i>
                    </div>
                    <span class="text-xs font-600 text-slate-700 text-center" style="font-weight:600;">Buat User Baru</span>
                </a>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>

@endsection

@push('scripts')
<script>
    // Animate bars on load
    window.addEventListener('load', () => {
        setTimeout(() => {
            document.querySelectorAll('.chart-bar').forEach(bar => {
                bar.style.height = bar.dataset.val + '%';
            });
        }, 500);
    });

    // Sidebar toggle
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebarOverlay').classList.toggle('open');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('open');
    }
</script>
@endpush
