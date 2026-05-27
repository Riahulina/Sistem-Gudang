{{-- Sidebar Overlay (mobile) --}}
<div id="sidebarOverlay" onclick="closeSidebar()"></div>

<aside id="sidebar">
    <div class="sidebar-logo">
        <div class="flex items-center gap-3">
            <div class="logo-badge"><i data-lucide="package-2" style="width:20px;height:20px;color:white;"></i></div>
            <div>
                <p class="text-white font-800 text-base leading-tight" style="font-weight:800;">Our Stock</p>
                <p class="text-emerald-400 text-xs font-medium">Manajemen Gudang</p>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <p class="nav-section-title">Menu Utama</p>

        @if(auth()->user()->hasPermission('dashboard'))
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="layout-dashboard" style="width:16px;height:16px;color:#34d399;"></i></span>
            Dashboard
        </a>
        @endif

        @if(auth()->user()->hasPermission('stock_report'))
        <a href="{{ route('stock.report') }}" class="nav-link {{ request()->routeIs('stock.*') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="bar-chart-3" style="width:16px;height:16px;color:#60a5fa;"></i></span>
            Stock Report
        </a>
        @endif

        @if(auth()->user()->hasPermission('create_barang') || auth()->user()->hasPermission('create_barang_masuk_keluar') || auth()->user()->hasPermission('create_vehicle'))
        <p class="nav-section-title" style="margin-top:.75rem;">Manajemen Data</p>
        @endif

        @if(auth()->user()->hasPermission('create_barang'))
        <a href="{{ route('barang.index') }}" class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="package" style="width:16px;height:16px;color:#fbbf24;"></i></span>
            Data Barang
        </a>
        <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="tags" style="width:16px;height:16px;color:#a78bfa;"></i></span>
            Kategori
        </a>
        @endif

        @if(auth()->user()->hasPermission('create_barang_masuk_keluar'))
        <a href="{{ route('transaksi.index') }}" class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="arrow-left-right" style="width:16px;height:16px;color:#22d3ee;"></i></span>
            Barang Masuk & Keluar
        </a>
        @endif

        @if(auth()->user()->hasPermission('create_vehicle'))
        <a href="{{ route('kendaraan.index') }}" class="nav-link {{ request()->routeIs('kendaraan.*') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="truck" style="width:16px;height:16px;color:#fb923c;"></i></span>
            Kendaraan
        </a>
        @endif

        @if(auth()->user()->hasPermission('laporan'))
        <p class="nav-section-title" style="margin-top:.75rem;">Laporan</p>
        <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="file-text" style="width:16px;height:16px;color:#f472b6;"></i></span>
            Laporan Bulanan
        </a>
        @endif

        @if(auth()->user()->hasPermission('create_user'))
        <p class="nav-section-title" style="margin-top:.75rem;">Administrasi</p>
        <a href="{{ route('users.create') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="users" style="width:16px;height:16px;color:#a78bfa;"></i></span>
            Manajemen User
        </a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->username ?? 'U', 0, 1)) }}</div>
            <div style="flex:1;min-width:0;">
                <p class="text-white text-sm font-600 truncate" style="font-weight:600;">{{ auth()->user()->username ?? 'User' }}</p>
                <p class="text-emerald-400 text-xs truncate">{{ auth()->user()->role ?? 'Staff' }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">@csrf
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
