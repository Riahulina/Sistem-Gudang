@extends('layouts.app')
@section('title', 'Transaksi Barang — Our Stock')

@push('styles')
@include('components.sidebar-styles')
<style>
    .tab-btn { padding: .625rem 1.25rem; font-size: .85rem; font-weight: 600; border-radius: .75rem; border: 1.5px solid #e2e8f0; background: #fff; color: #64748b; cursor: pointer; transition: all .2s; }
    .tab-btn.active { background: linear-gradient(135deg, #059669, #047857); color: #fff; border-color: #059669; box-shadow: 0 4px 15px rgba(5,150,105,.3); }
    .tab-btn:hover:not(.active) { border-color: #a7f3d0; background: #f0fdf6; color: #059669; }
    .badge-masuk { font-size: .7rem; font-weight: 700; padding: .15rem .5rem; border-radius: 99px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .badge-keluar { font-size: .7rem; font-weight: 700; padding: .15rem .5rem; border-radius: 99px; background: #fef2f2; color: #ef4444; border: 1px solid #fca5a5; }
</style>
@endpush

@section('content')
@include('components.sidebar')

<div id="main-content">
    <div class="topbar">
        <div class="flex items-center gap-3">
            <button onclick="toggleSidebar()" style="width:38px;height:38px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:.75rem;display:flex;align-items:center;justify-content:center;cursor:pointer;color:#64748b;" class="lg:hidden">
                <i data-lucide="menu" style="width:18px;height:18px;"></i>
            </button>
            <div>
                <h2 class="text-lg font-700 text-slate-900" style="font-weight:700;">Transaksi Barang</h2>
                <p class="text-xs text-slate-400">Riwayat barang masuk & keluar</p>
            </div>
        </div>
        <a href="{{ route('transaksi.create') }}" class="btn-primary" style="text-decoration:none;">
            <i data-lucide="plus" style="width:16px;height:16px;"></i> Catat Transaksi
        </a>
    </div>

    <div class="p-6 lg:p-8 space-y-5 max-w-screen-xl mx-auto">
        @if(session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl px-4 py-3.5 text-sm font-medium animate-fade-up">
            <i data-lucide="check-circle-2" style="width:18px;height:18px;flex-shrink:0;"></i> {{ session('success') }}
        </div>
        @endif

        {{-- Tab Buttons --}}
        <div class="flex gap-2 animate-fade-up">
            <button class="tab-btn active" onclick="showTab('masuk',this)">
                <i data-lucide="arrow-down" style="width:14px;height:14px;display:inline;vertical-align:middle;"></i> Barang Masuk
            </button>
            <button class="tab-btn" onclick="showTab('keluar',this)">
                <i data-lucide="arrow-up" style="width:14px;height:14px;display:inline;vertical-align:middle;"></i> Barang Keluar
            </button>
        </div>

        {{-- Tabel Masuk --}}
        <div id="tab-masuk" class="card animate-fade-up" style="animation-delay:.1s;opacity:0;animation-fill-mode:both;">
            <div class="overflow-x-auto" style="border-radius:1.25rem;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th>Barang</th>
                            <th style="text-align:center;">Jumlah</th>
                            <th>Supplier</th>
                            <th>Tanggal</th>
                            <th>Oleh</th>
                            <th style="text-align:center;width:100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($masuk as $i => $m)
                        <tr>
                            <td class="font-mono text-slate-400 text-xs">{{ $masuk->firstItem() + $i }}</td>
                            <td class="font-semibold text-slate-800">{{ $m->barang->nama_barang ?? '-' }}</td>
                            <td style="text-align:center;"><span class="badge-masuk">+{{ $m->jumlah }}</span></td>
                            <td class="text-sm text-slate-500">{{ $m->supplier ?? '—' }}</td>
                            <td class="text-sm text-slate-500">{{ $m->tanggal_masuk->format('d/m/Y') }}</td>
                            <td class="text-sm text-slate-500">{{ $m->user->username ?? '-' }}</td>
                            <td style="text-align:center;">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('transaksi.editMasuk', $m) }}" class="btn-icon" title="Edit"><i data-lucide="pencil" style="width:14px;height:14px;"></i></a>
                                    <form method="POST" action="{{ route('transaksi.destroyMasuk', $m) }}" onsubmit="return confirm('Hapus transaksi ini?')">@csrf @method('DELETE')
                                        <button type="submit" class="btn-icon danger" title="Hapus"><i data-lucide="trash-2" style="width:14px;height:14px;"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" style="text-align:center;padding:2rem;color:#94a3b8;">Belum ada transaksi masuk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($masuk->hasPages())
            <div style="padding:1rem 1.25rem;border-top:1px solid #f1f5f9;">{{ $masuk->links() }}</div>
            @endif
        </div>

        {{-- Tabel Keluar --}}
        <div id="tab-keluar" class="card animate-fade-up" style="display:none;animation-delay:.1s;opacity:0;animation-fill-mode:both;">
            <div class="overflow-x-auto" style="border-radius:1.25rem;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th>Barang</th>
                            <th style="text-align:center;">Jumlah</th>
                            <th>Tujuan</th>
                            <th>Tanggal</th>
                            <th>Oleh</th>
                            <th style="text-align:center;width:100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($keluar as $i => $k)
                        <tr>
                            <td class="font-mono text-slate-400 text-xs">{{ $keluar->firstItem() + $i }}</td>
                            <td class="font-semibold text-slate-800">{{ $k->barang->nama_barang ?? '-' }}</td>
                            <td style="text-align:center;"><span class="badge-keluar">-{{ $k->jumlah }}</span></td>
                            <td class="text-sm text-slate-500">{{ $k->tujuan ?? '—' }}</td>
                            <td class="text-sm text-slate-500">{{ $k->tanggal_keluar->format('d/m/Y') }}</td>
                            <td class="text-sm text-slate-500">{{ $k->user->username ?? '-' }}</td>
                            <td style="text-align:center;">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('transaksi.editKeluar', $k) }}" class="btn-icon" title="Edit"><i data-lucide="pencil" style="width:14px;height:14px;"></i></a>
                                    <form method="POST" action="{{ route('transaksi.destroyKeluar', $k) }}" onsubmit="return confirm('Hapus transaksi ini?')">@csrf @method('DELETE')
                                        <button type="submit" class="btn-icon danger" title="Hapus"><i data-lucide="trash-2" style="width:14px;height:14px;"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" style="text-align:center;padding:2rem;color:#94a3b8;">Belum ada transaksi keluar.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($keluar->hasPages())
            <div style="padding:1rem 1.25rem;border-top:1px solid #f1f5f9;">{{ $keluar->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleSidebar(){document.getElementById('sidebar').classList.toggle('open');document.getElementById('sidebarOverlay').classList.toggle('open');}
    function closeSidebar(){document.getElementById('sidebar').classList.remove('open');document.getElementById('sidebarOverlay').classList.remove('open');}
    function showTab(tab, btn){
        document.getElementById('tab-masuk').style.display = tab==='masuk'?'block':'none';
        document.getElementById('tab-keluar').style.display = tab==='keluar'?'block':'none';
        document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));
        btn.classList.add('active');
        lucide.createIcons();
    }
</script>
@endpush
