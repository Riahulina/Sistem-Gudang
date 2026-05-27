@extends('layouts.app')
@section('title', 'Detail Transaksi — Our Stock')

@push('styles')
<style>
    body { background: #f8fafc; }
    .page-header { background: linear-gradient(135deg, #064e3b 0%, #047857 60%, #059669 100%); border-radius: 1.5rem; padding: 1.75rem 2rem; position: relative; overflow: hidden; }
    .page-header::before { content: ''; position: absolute; top: -40px; right: -40px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(255,255,255,.08), transparent 70%); border-radius: 50%; }
    .section-label { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #059669; }
    .detail-row { display: flex; justify-content: space-between; padding: .75rem 0; border-bottom: 1px solid #f1f5f9; }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { font-size: .85rem; color: #64748b; font-weight: 500; }
    .detail-value { font-size: .85rem; color: #1e293b; font-weight: 600; text-align: right; }
    .badge-masuk { font-size: .75rem; font-weight: 700; padding: .2rem .6rem; border-radius: 99px; background: #ecfdf5; color: #059669; }
    .badge-keluar { font-size: .75rem; font-weight: 700; padding: .2rem .6rem; border-radius: 99px; background: #fef2f2; color: #ef4444; }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-xl mx-auto space-y-6">

        <div class="page-header animate-fade-up">
            <div class="relative z-10 flex items-center gap-4">
                <div style="width:48px;height:48px;background:rgba(255,255,255,.15);border-radius:14px;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);border:1px solid rgba(255,255,255,.2);">
                    <i data-lucide="{{ $tipe==='masuk'?'arrow-down':'arrow-up' }}" style="width:24px;height:24px;color:white;"></i>
                </div>
                <div>
                    <p class="text-emerald-200 text-xs font-600 uppercase tracking-widest mb-0.5">Detail Transaksi</p>
                    <h1 class="text-2xl font-800 text-white" style="font-weight:800;">Barang {{ ucfirst($tipe) }}</h1>
                </div>
            </div>
        </div>

        <div class="card p-6 animate-fade-up" style="animation-delay:.1s;opacity:0;animation-fill-mode:both;">
            <span class="section-label">Informasi Transaksi</span>
            <div class="mt-4">
                <div class="detail-row">
                    <span class="detail-label">Tipe</span>
                    <span class="detail-value"><span class="{{ $tipe==='masuk'?'badge-masuk':'badge-keluar' }}">{{ ucfirst($tipe) }}</span></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Barang</span>
                    <span class="detail-value">{{ $transaksi->barang->nama_barang ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Jumlah</span>
                    <span class="detail-value">{{ $tipe==='masuk'?'+':'-' }}{{ $transaksi->jumlah }} {{ $transaksi->barang->satuan ?? '' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal</span>
                    <span class="detail-value">{{ $tipe==='masuk' ? $transaksi->tanggal_masuk->format('d/m/Y') : $transaksi->tanggal_keluar->format('d/m/Y') }}</span>
                </div>
                @if($tipe==='masuk' && $transaksi->supplier)
                <div class="detail-row">
                    <span class="detail-label">Supplier</span>
                    <span class="detail-value">{{ $transaksi->supplier }}</span>
                </div>
                @endif
                @if($tipe==='keluar' && $transaksi->tujuan)
                <div class="detail-row">
                    <span class="detail-label">Tujuan</span>
                    <span class="detail-value">{{ $transaksi->tujuan }}</span>
                </div>
                @endif
                @if($transaksi->keterangan)
                <div class="detail-row">
                    <span class="detail-label">Keterangan</span>
                    <span class="detail-value" style="max-width:60%;text-align:right;">{{ $transaksi->keterangan }}</span>
                </div>
                @endif
                <div class="detail-row">
                    <span class="detail-label">Dicatat Oleh</span>
                    <span class="detail-value">{{ $transaksi->user->username ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 animate-fade-up" style="animation-delay:.2s;opacity:0;animation-fill-mode:both;">
            <a href="{{ route('transaksi.index') }}" class="btn-secondary flex-1 text-center" style="text-decoration:none;">
                <i data-lucide="arrow-left" style="width:15px;height:15px;"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
