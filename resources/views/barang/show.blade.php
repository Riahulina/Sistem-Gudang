@extends('layouts.app')

@section('title', $barang->nama_barang . ' — Our Stock')

@push('styles')
<style>
    body { background: #f8fafc; }
    .page-header {
        background: linear-gradient(135deg, #064e3b 0%, #047857 60%, #059669 100%);
        border-radius: 1.5rem; padding: 1.75rem 2rem;
        position: relative; overflow: hidden;
    }
    .page-header::before {
        content: ''; position: absolute; top: -40px; right: -40px;
        width: 200px; height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,.08), transparent 70%);
        border-radius: 50%;
    }
    .section-label { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #059669; }
    .detail-row { display: flex; justify-content: space-between; padding: .75rem 0; border-bottom: 1px solid #f1f5f9; }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { font-size: .85rem; color: #64748b; font-weight: 500; }
    .detail-value { font-size: .85rem; color: #1e293b; font-weight: 600; text-align: right; }
    .badge-kat { display: inline-flex; align-items: center; gap: .35rem; font-size: .75rem; font-weight: 600; padding: .2rem .6rem; border-radius: 99px; background: #f5f3ff; color: #7c3aed; border: 1px solid #ddd6fe; }
    .badge-stok { font-size: .75rem; font-weight: 700; padding: .2rem .6rem; border-radius: 99px; }
    .badge-stok.ok { background: #ecfdf5; color: #059669; }
    .badge-stok.low { background: #fef2f2; color: #ef4444; }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto space-y-6">

        <div class="page-header animate-fade-up">
            <div class="relative z-10 flex items-center gap-4">
                <div style="width:48px;height:48px;background:rgba(255,255,255,.15);border-radius:14px;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);border:1px solid rgba(255,255,255,.2);">
                    <i data-lucide="package" style="width:24px;height:24px;color:white;"></i>
                </div>
                <div>
                    <p class="text-emerald-200 text-xs font-600 uppercase tracking-widest mb-0.5">Detail Barang</p>
                    <h1 class="text-2xl font-800 text-white" style="font-weight:800;">{{ $barang->nama_barang }}</h1>
                </div>
            </div>
        </div>

        {{-- Info Card --}}
        <div class="card p-6 animate-fade-up" style="animation-delay:.1s;opacity:0;animation-fill-mode:both;">
            <span class="section-label">Informasi Barang</span>
            <div class="mt-4">
                <div class="detail-row">
                    <span class="detail-label">Kode Barang</span>
                    <span class="detail-value font-mono">{{ $barang->kode_barang }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Nama Barang</span>
                    <span class="detail-value">{{ $barang->nama_barang }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Kategori</span>
                    <span class="detail-value">
                        @if($barang->kategori)
                        <span class="badge-kat"><i data-lucide="tag" style="width:11px;height:11px;"></i>{{ $barang->kategori->nama_kategori }}</span>
                        @else — @endif
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Stok</span>
                    <span class="detail-value">
                        <span class="badge-stok {{ $barang->stok <= $barang->minimum_stok ? 'low' : 'ok' }}">{{ $barang->stok }} {{ $barang->satuan }}</span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Minimum Stok</span>
                    <span class="detail-value">{{ $barang->minimum_stok }} {{ $barang->satuan }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Dibuat Oleh</span>
                    <span class="detail-value">{{ $barang->user->username ?? '-' }}</span>
                </div>
                @if($barang->keterangan)
                <div class="detail-row">
                    <span class="detail-label">Keterangan</span>
                    <span class="detail-value" style="max-width:60%;text-align:right;">{{ $barang->keterangan }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Riwayat Masuk --}}
        @if($riwayatMasuk->count())
        <div class="card p-6 animate-fade-up" style="animation-delay:.2s;opacity:0;animation-fill-mode:both;">
            <span class="section-label">Riwayat Masuk (10 Terakhir)</span>
            <div class="mt-3 space-y-2">
                @foreach($riwayatMasuk as $rm)
                <div class="flex items-center justify-between py-2 border-b border-slate-100 last:border-0">
                    <div class="flex items-center gap-2">
                        <div style="width:28px;height:28px;border-radius:.5rem;background:#ecfdf5;display:flex;align-items:center;justify-content:center;">
                            <i data-lucide="arrow-down" style="width:13px;height:13px;color:#059669;"></i>
                        </div>
                        <span class="text-sm text-slate-700">+{{ $rm->jumlah }} {{ $barang->satuan }}</span>
                    </div>
                    <span class="text-xs text-slate-400">{{ $rm->created_at->diffForHumans() }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Riwayat Keluar --}}
        @if($riwayatKeluar->count())
        <div class="card p-6 animate-fade-up" style="animation-delay:.3s;opacity:0;animation-fill-mode:both;">
            <span class="section-label">Riwayat Keluar (10 Terakhir)</span>
            <div class="mt-3 space-y-2">
                @foreach($riwayatKeluar as $rk)
                <div class="flex items-center justify-between py-2 border-b border-slate-100 last:border-0">
                    <div class="flex items-center gap-2">
                        <div style="width:28px;height:28px;border-radius:.5rem;background:#fef2f2;display:flex;align-items:center;justify-content:center;">
                            <i data-lucide="arrow-up" style="width:13px;height:13px;color:#ef4444;"></i>
                        </div>
                        <span class="text-sm text-slate-700">-{{ $rk->jumlah }} {{ $barang->satuan }}</span>
                    </div>
                    <span class="text-xs text-slate-400">{{ $rk->created_at->diffForHumans() }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="flex items-center gap-3 animate-fade-up" style="animation-delay:.35s;opacity:0;animation-fill-mode:both;">
            <a href="{{ route('barang.index') }}" class="btn-secondary flex-1 text-center" style="text-decoration:none;">
                <i data-lucide="arrow-left" style="width:15px;height:15px;"></i> Kembali
            </a>
            <a href="{{ route('barang.edit', $barang) }}" class="btn-primary flex-1 text-center" style="text-decoration:none;">
                <i data-lucide="pencil" style="width:15px;height:15px;"></i> Edit Barang
            </a>
        </div>
    </div>
</div>
@endsection
