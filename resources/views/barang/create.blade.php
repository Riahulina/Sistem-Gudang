@extends('layouts.app')

@section('title', 'Tambah Barang — Our Stock')

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
    .section-label {
        font-size: .7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .08em; color: #059669;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto space-y-6">

        <div class="page-header animate-fade-up">
            <div class="relative z-10 flex items-center gap-4">
                <div style="width:48px;height:48px;background:rgba(255,255,255,.15);border-radius:14px;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);border:1px solid rgba(255,255,255,.2);">
                    <i data-lucide="package-plus" style="width:24px;height:24px;color:white;"></i>
                </div>
                <div>
                    <p class="text-emerald-200 text-xs font-600 uppercase tracking-widest mb-0.5">Manajemen Data</p>
                    <h1 class="text-2xl font-800 text-white" style="font-weight:800;">Tambah Barang</h1>
                </div>
            </div>
        </div>

        @if($errors->any())
        <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-4 py-3.5 text-sm font-medium animate-fade-up">
            <i data-lucide="circle-alert" style="width:18px;height:18px;flex-shrink:0;margin-top:1px;"></i>
            <ul class="space-y-1">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
        @endif

        <form method="POST" action="{{ route('barang.store') }}">
            @csrf
            <div class="card p-6 space-y-5 animate-fade-up" style="animation-delay:.1s;opacity:0;animation-fill-mode:both;">
                <span class="section-label">Informasi Barang</span>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Kode Barang --}}
                    <div>
                        <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Kode Barang <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span style="position:absolute;left:.875rem;top:50%;transform:translateY(-50%);color:#94a3b8;"><i data-lucide="hash" style="width:15px;height:15px;"></i></span>
                            <input type="text" name="kode_barang" class="input-field" style="padding-left:2.5rem;" placeholder="cth: BRG-001" value="{{ old('kode_barang') }}" required>
                        </div>
                        @error('kode_barang')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
                    </div>

                    {{-- Nama Barang --}}
                    <div>
                        <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Nama Barang <span class="text-red-400">*</span></label>
                        <input type="text" name="nama_barang" class="input-field" placeholder="cth: Semen 50kg" value="{{ old('nama_barang') }}" required>
                        @error('nama_barang')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Kategori</label>
                    <div class="relative">
                        <span style="position:absolute;left:.875rem;top:50%;transform:translateY(-50%);color:#94a3b8;"><i data-lucide="tag" style="width:15px;height:15px;"></i></span>
                        <select name="kategori_id" class="input-field" style="padding-left:2.5rem;appearance:auto;">
                            <option value="">— Tanpa Kategori —</option>
                            @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('kategori_id')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    {{-- Stok --}}
                    <div>
                        <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Stok Awal <span class="text-red-400">*</span></label>
                        <input type="number" name="stok" class="input-field" min="0" value="{{ old('stok', 0) }}" required>
                        @error('stok')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
                    </div>
                    {{-- Satuan --}}
                    <div>
                        <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Satuan <span class="text-red-400">*</span></label>
                        <input type="text" name="satuan" class="input-field" placeholder="cth: pcs, kg, liter" value="{{ old('satuan') }}" required>
                        @error('satuan')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
                    </div>
                    {{-- Minimum Stok --}}
                    <div>
                        <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Minimum Stok <span class="text-red-400">*</span></label>
                        <input type="number" name="minimum_stok" class="input-field" min="0" value="{{ old('minimum_stok', 0) }}" required>
                        @error('minimum_stok')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Keterangan</label>
                    <textarea name="keterangan" rows="2" class="input-field" placeholder="Catatan tambahan (opsional)" style="resize:vertical;">{{ old('keterangan') }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-3 animate-fade-up" style="animation-delay:.25s;opacity:0;animation-fill-mode:both;margin-top:1.25rem;">
                <a href="{{ route('barang.index') }}" class="btn-secondary flex-1 text-center" style="text-decoration:none;">
                    <i data-lucide="arrow-left" style="width:15px;height:15px;"></i> Batal
                </a>
                <button type="submit" class="btn-primary flex-1">
                    <i data-lucide="plus" style="width:16px;height:16px;"></i> Simpan Barang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
