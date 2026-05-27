@extends('layouts.app')

@section('title', 'Edit Kategori — Our Stock')

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
    <div class="max-w-xl mx-auto space-y-6">

        <div class="page-header animate-fade-up">
            <div class="relative z-10 flex items-center gap-4">
                <div style="width:48px;height:48px;background:rgba(255,255,255,.15);border-radius:14px;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);border:1px solid rgba(255,255,255,.2);">
                    <i data-lucide="pencil" style="width:24px;height:24px;color:white;"></i>
                </div>
                <div>
                    <p class="text-emerald-200 text-xs font-600 uppercase tracking-widest mb-0.5">Manajemen Data</p>
                    <h1 class="text-2xl font-800 text-white" style="font-weight:800;">Edit Kategori</h1>
                </div>
            </div>
        </div>

        @if($errors->any())
        <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-4 py-3.5 text-sm font-medium animate-fade-up">
            <i data-lucide="circle-alert" style="width:18px;height:18px;flex-shrink:0;margin-top:1px;"></i>
            <ul class="space-y-1">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
        @endif

        <form method="POST" action="{{ route('kategori.update', $kategori) }}">
            @csrf @method('PATCH')
            <div class="card p-6 space-y-5 animate-fade-up" style="animation-delay:.15s;opacity:0;animation-fill-mode:both;">
                <span class="section-label">Informasi Kategori</span>

                <div>
                    <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Nama Kategori <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <span style="position:absolute;left:.875rem;top:50%;transform:translateY(-50%);color:#94a3b8;"><i data-lucide="tag" style="width:15px;height:15px;"></i></span>
                        <input type="text" name="nama_kategori" class="input-field @error('nama_kategori') border-red-400 @enderror" style="padding-left:2.5rem;" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required autofocus>
                    </div>
                    @error('nama_kategori')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="input-field @error('deskripsi') border-red-400 @enderror" placeholder="Deskripsi singkat (opsional)" style="resize:vertical;min-height:80px;">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                    @error('deskripsi')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex items-center gap-3 animate-fade-up" style="animation-delay:.25s;opacity:0;animation-fill-mode:both;margin-top:1.25rem;">
                <a href="{{ route('kategori.index') }}" class="btn-secondary flex-1 text-center" style="text-decoration:none;">
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
