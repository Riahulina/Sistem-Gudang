@extends('layouts.app')
@section('title', 'Edit Transaksi — Our Stock')

@push('styles')
<style>
    body { background: #f8fafc; }
    .page-header { background: linear-gradient(135deg, #064e3b 0%, #047857 60%, #059669 100%); border-radius: 1.5rem; padding: 1.75rem 2rem; position: relative; overflow: hidden; }
    .page-header::before { content: ''; position: absolute; top: -40px; right: -40px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(255,255,255,.08), transparent 70%); border-radius: 50%; }
    .section-label { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #059669; }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto space-y-6">

        <div class="page-header animate-fade-up">
            <div class="relative z-10 flex items-center gap-4">
                <div style="width:48px;height:48px;background:rgba(255,255,255,.15);border-radius:14px;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);border:1px solid rgba(255,255,255,.2);">
                    <i data-lucide="pencil" style="width:24px;height:24px;color:white;"></i>
                </div>
                <div>
                    <p class="text-emerald-200 text-xs font-600 uppercase tracking-widest mb-0.5">Edit Transaksi</p>
                    <h1 class="text-2xl font-800 text-white" style="font-weight:800;">Barang {{ ucfirst($tipe) }}</h1>
                </div>
            </div>
        </div>

        @if($errors->any())
        <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-4 py-3.5 text-sm font-medium animate-fade-up">
            <i data-lucide="circle-alert" style="width:18px;height:18px;flex-shrink:0;margin-top:1px;"></i>
            <ul class="space-y-1">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
        @endif

        @php
            $actionRoute = $tipe === 'masuk'
                ? route('transaksi.updateMasuk', $transaksi)
                : route('transaksi.updateKeluar', $transaksi);
        @endphp

        <form method="POST" action="{{ $actionRoute }}">
            @csrf @method('PATCH')
            <div class="card p-6 space-y-5 animate-fade-up" style="animation-delay:.1s;opacity:0;animation-fill-mode:both;">
                <span class="section-label">Detail Transaksi</span>

                <div>
                    <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Barang</label>
                    <input type="text" class="input-field" value="{{ $transaksi->barang->nama_barang ?? '-' }}" disabled style="background:#f8fafc;">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Jumlah <span class="text-red-400">*</span></label>
                        <input type="number" name="jumlah" class="input-field" min="1" value="{{ old('jumlah', $transaksi->jumlah) }}" required>
                        @error('jumlah')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Tanggal <span class="text-red-400">*</span></label>
                        @if($tipe === 'masuk')
                        <input type="date" name="tanggal_masuk" class="input-field" value="{{ old('tanggal_masuk', $transaksi->tanggal_masuk->format('Y-m-d')) }}" required>
                        @else
                        <input type="date" name="tanggal_keluar" class="input-field" value="{{ old('tanggal_keluar', $transaksi->tanggal_keluar->format('Y-m-d')) }}" required>
                        @endif
                    </div>
                </div>

                @if($tipe === 'masuk')
                <div>
                    <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Supplier</label>
                    <input type="text" name="supplier" class="input-field" value="{{ old('supplier', $transaksi->supplier) }}" placeholder="Nama supplier (opsional)">
                </div>
                @else
                <div>
                    <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Tujuan</label>
                    <input type="text" name="tujuan" class="input-field" value="{{ old('tujuan', $transaksi->tujuan) }}" placeholder="Tujuan pengiriman (opsional)">
                </div>
                @endif

                <div>
                    <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Keterangan</label>
                    <textarea name="keterangan" rows="2" class="input-field" style="resize:vertical;">{{ old('keterangan', $transaksi->keterangan) }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-3 animate-fade-up" style="animation-delay:.2s;opacity:0;animation-fill-mode:both;margin-top:1.25rem;">
                <a href="{{ route('transaksi.index') }}" class="btn-secondary flex-1 text-center" style="text-decoration:none;">
                    <i data-lucide="arrow-left" style="width:15px;height:15px;"></i> Batal
                </a>
                <button type="submit" class="btn-primary flex-1">
                    <i data-lucide="save" style="width:16px;height:16px;"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
