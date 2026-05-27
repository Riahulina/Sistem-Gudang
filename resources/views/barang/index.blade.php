@extends('layouts.app')

@section('title', 'Data Barang — Our Stock')

@push('styles')
<style>
    body { background: #f1f5f9; overflow-x: hidden; }

    #sidebar {
        width: 260px; min-height: 100vh;
        background: linear-gradient(180deg, #022c22 0%, #064e3b 40%, #065f46 100%);
        position: fixed; top: 0; left: 0; z-index: 40;
        display: flex; flex-direction: column;
        transition: transform .3s cubic-bezier(.4,0,.2,1);
        box-shadow: 4px 0 24px rgba(0,0,0,.15);
    }
    .sidebar-logo { padding: 1.5rem 1.25rem 1.25rem; border-bottom: 1px solid rgba(255,255,255,.07); }
    .logo-badge { width: 40px; height: 40px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(16,185,129,.4); }
    .sidebar-nav { padding: .875rem; flex: 1; overflow-y: auto; }
    .nav-section-title { font-size: .625rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: rgba(255,255,255,.3); padding: .75rem .5rem .5rem; margin-bottom: .25rem; }
    .nav-link { display: flex; align-items: center; gap: .75rem; padding: .65rem .875rem; border-radius: .75rem; color: rgba(255,255,255,.6); font-size: .875rem; font-weight: 500; text-decoration: none; transition: all .2s; margin-bottom: 2px; position: relative; }
    .nav-link:hover { background: rgba(255,255,255,.08); color: #fff; }
    .nav-link.active { background: rgba(255,255,255,.12); color: #fff; font-weight: 600; }
    .nav-link.active::before { content: ''; position: absolute; left: 0; top: 20%; height: 60%; width: 3px; background: #34d399; border-radius: 0 4px 4px 0; }
    .nav-link .nav-icon { width: 32px; height: 32px; border-radius: .5rem; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,.07); flex-shrink: 0; }
    .nav-link.active .nav-icon { background: rgba(52,211,153,.2); }
    .sidebar-footer { padding: 1rem .875rem; border-top: 1px solid rgba(255,255,255,.07); }
    .user-card { display: flex; align-items: center; gap: .75rem; padding: .625rem .75rem; border-radius: .875rem; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.08); }
    .user-avatar { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg, #34d399, #059669); display: flex; align-items: center; justify-content: center; font-size: .85rem; font-weight: 700; color: #fff; }

    #main-content { margin-left: 260px; min-height: 100vh; }
    .topbar { background: rgba(255,255,255,.9); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0,0,0,.06); padding: .875rem 1.75rem; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 30; }

    .data-table { width: 100%; border-collapse: separate; border-spacing: 0; }
    .data-table thead th { background: #f8fafc; padding: .75rem 1rem; font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #64748b; border-bottom: 1.5px solid #e2e8f0; text-align: left; }
    .data-table tbody td { padding: .875rem 1rem; font-size: .875rem; color: #334155; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .data-table tbody tr { transition: background .15s; }
    .data-table tbody tr:hover { background: #f0fdf6; }

    .badge-kat { display: inline-flex; align-items: center; gap: .35rem; font-size: .75rem; font-weight: 600; padding: .2rem .6rem; border-radius: 99px; background: #f5f3ff; color: #7c3aed; border: 1px solid #ddd6fe; }
    .badge-stok { font-size: .75rem; font-weight: 700; padding: .2rem .6rem; border-radius: 99px; }
    .badge-stok.ok { background: #ecfdf5; color: #059669; }
    .badge-stok.low { background: #fef2f2; color: #ef4444; }

    .btn-icon { width: 32px; height: 32px; border-radius: .5rem; border: 1.5px solid #e2e8f0; background: #fff; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all .2s; color: #64748b; }
    .btn-icon:hover { border-color: #a7f3d0; color: #059669; background: #f0fdf6; }
    .btn-icon.danger:hover { border-color: #fca5a5; color: #ef4444; background: #fef2f2; }

    #sidebarOverlay { display: none; position: fixed; inset: 0; z-index: 35; background: rgba(0,0,0,.4); }
    @media (max-width: 1024px) {
        #sidebar { transform: translateX(-100%); }
        #sidebar.open { transform: translateX(0); }
        #main-content { margin-left: 0; }
        #sidebarOverlay.open { display: block; }
    }
</style>
@endpush

@section('content')
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
            <span class="nav-icon"><i data-lucide="layout-dashboard" style="width:16px;height:16px;color:#34d399;"></i></span> Dashboard
        </a>
        @endif
        @if(auth()->user()->hasPermission('stock_report'))
        <a href="{{ route('stock.report') }}" class="nav-link {{ request()->routeIs('stock.*') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="bar-chart-3" style="width:16px;height:16px;color:#60a5fa;"></i></span> Stock Report
        </a>
        @endif
        @if(auth()->user()->hasPermission('create_barang') || auth()->user()->hasPermission('create_barang_masuk_keluar') || auth()->user()->hasPermission('create_vehicle'))
        <p class="nav-section-title" style="margin-top:.75rem;">Manajemen Data</p>
        @endif
        @if(auth()->user()->hasPermission('create_barang'))
        <a href="{{ route('barang.index') }}" class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="package" style="width:16px;height:16px;color:#fbbf24;"></i></span> Data Barang
        </a>
        <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="tags" style="width:16px;height:16px;color:#a78bfa;"></i></span> Kategori
        </a>
        @endif
        @if(auth()->user()->hasPermission('create_barang_masuk_keluar'))
        <a href="{{ route('transaksi.index') }}" class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="arrow-left-right" style="width:16px;height:16px;color:#22d3ee;"></i></span> Barang Masuk & Keluar
        </a>
        @endif
        @if(auth()->user()->hasPermission('create_vehicle'))
        <a href="{{ route('kendaraan.index') }}" class="nav-link {{ request()->routeIs('kendaraan.*') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="truck" style="width:16px;height:16px;color:#fb923c;"></i></span> Kendaraan
        </a>
        @endif
        @if(auth()->user()->hasPermission('create_user'))
        <p class="nav-section-title" style="margin-top:.75rem;">Administrasi</p>
        <a href="{{ route('users.create') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <span class="nav-icon"><i data-lucide="users" style="width:16px;height:16px;color:#a78bfa;"></i></span> Manajemen User
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
                <button type="submit" title="Logout" style="width:30px;height:30px;background:rgba(255,255,255,.08);border:none;border-radius:.5rem;cursor:pointer;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.5);"
                    onmouseover="this.style.background='rgba(239,68,68,.2)';this.style.color='#f87171';"
                    onmouseout="this.style.background='rgba(255,255,255,.08)';this.style.color='rgba(255,255,255,.5)';">
                    <i data-lucide="log-out" style="width:14px;height:14px;"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

<div id="main-content">
    <div class="topbar">
        <div class="flex items-center gap-3">
            <button onclick="toggleSidebar()" style="width:38px;height:38px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:.75rem;display:flex;align-items:center;justify-content:center;cursor:pointer;color:#64748b;" class="lg:hidden">
                <i data-lucide="menu" style="width:18px;height:18px;"></i>
            </button>
            <div>
                <h2 class="text-lg font-700 text-slate-900" style="font-weight:700;">Data Barang</h2>
                <p class="text-xs text-slate-400">Kelola seluruh data barang gudang</p>
            </div>
        </div>
        <a href="{{ route('barang.create') }}" class="btn-primary" style="text-decoration:none;">
            <i data-lucide="plus" style="width:16px;height:16px;"></i> Tambah Barang
        </a>
    </div>

    <div class="p-6 lg:p-8 space-y-5 max-w-screen-xl mx-auto">
        @if(session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl px-4 py-3.5 text-sm font-medium animate-fade-up">
            <i data-lucide="check-circle-2" style="width:18px;height:18px;flex-shrink:0;"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-4 py-3.5 text-sm font-medium animate-fade-up">
            <i data-lucide="circle-alert" style="width:18px;height:18px;flex-shrink:0;"></i> {{ session('error') }}
        </div>
        @endif

        <div class="card animate-fade-up" style="animation-delay:.1s;opacity:0;animation-fill-mode:both;">
            <div class="overflow-x-auto" style="border-radius:1.25rem;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th style="text-align:center;">Stok</th>
                            <th>Satuan</th>
                            <th style="text-align:center;width:130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $i => $brg)
                        <tr>
                            <td class="font-mono text-slate-400 text-xs">{{ $barangs->firstItem() + $i }}</td>
                            <td><span class="font-mono text-xs font-semibold text-slate-600">{{ $brg->kode_barang }}</span></td>
                            <td class="font-semibold text-slate-800">{{ $brg->nama_barang }}</td>
                            <td>
                                @if($brg->kategori)
                                <span class="badge-kat"><i data-lucide="tag" style="width:11px;height:11px;"></i>{{ $brg->kategori->nama_kategori }}</span>
                                @else
                                <span class="text-slate-400 text-xs">—</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                <span class="badge-stok {{ $brg->stok <= $brg->minimum_stok ? 'low' : 'ok' }}">{{ $brg->stok }}</span>
                            </td>
                            <td class="text-sm text-slate-500">{{ $brg->satuan }}</td>
                            <td style="text-align:center;">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('barang.show', $brg) }}" class="btn-icon" title="Detail"><i data-lucide="eye" style="width:14px;height:14px;"></i></a>
                                    <a href="{{ route('barang.edit', $brg) }}" class="btn-icon" title="Edit"><i data-lucide="pencil" style="width:14px;height:14px;"></i></a>
                                    <form method="POST" action="{{ route('barang.destroy', $brg) }}" onsubmit="return confirm('Hapus barang {{ $brg->nama_barang }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-icon danger" title="Hapus"><i data-lucide="trash-2" style="width:14px;height:14px;"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:3rem 1rem;">
                                <div class="flex flex-col items-center gap-2">
                                    <div style="width:48px;height:48px;border-radius:1rem;background:#fffbeb;display:flex;align-items:center;justify-content:center;">
                                        <i data-lucide="package" style="width:22px;height:22px;color:#f59e0b;"></i>
                                    </div>
                                    <p class="text-slate-400 text-sm font-medium">Belum ada data barang.</p>
                                    <a href="{{ route('barang.create') }}" class="text-emerald-600 text-sm font-semibold hover:underline">+ Tambah Barang Pertama</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($barangs->hasPages())
            <div style="padding:1rem 1.25rem;border-top:1px solid #f1f5f9;">{{ $barangs->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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
