@extends('layouts.app')
@section('title', 'Catat Transaksi — Our Stock')

@push('styles')
<style>
    body { background: #f8fafc; }
    .page-header { background: linear-gradient(135deg, #064e3b 0%, #047857 60%, #059669 100%); border-radius: 1.5rem; padding: 1.75rem 2rem; position: relative; overflow: hidden; }
    .page-header::before { content: ''; position: absolute; top: -40px; right: -40px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(255,255,255,.08), transparent 70%); border-radius: 50%; }
    .section-label { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #059669; }
    .tipe-btn { flex: 1; padding: .75rem; border-radius: .75rem; border: 1.5px solid #e2e8f0; background: #fff; font-size: .9rem; font-weight: 600; cursor: pointer; transition: all .2s; text-align: center; }
    .tipe-btn.active-masuk { border-color: #059669; background: #ecfdf5; color: #059669; box-shadow: 0 0 0 3px rgba(5,150,105,.1); }
    .tipe-btn.active-keluar { border-color: #ef4444; background: #fef2f2; color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,.1); }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto space-y-6">

        <div class="page-header animate-fade-up">
            <div class="relative z-10 flex items-center gap-4">
                <div style="width:48px;height:48px;background:rgba(255,255,255,.15);border-radius:14px;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);border:1px solid rgba(255,255,255,.2);">
                    <i data-lucide="arrow-left-right" style="width:24px;height:24px;color:white;"></i>
                </div>
                <div>
                    <p class="text-emerald-200 text-xs font-600 uppercase tracking-widest mb-0.5">Transaksi Stok</p>
                    <h1 class="text-2xl font-800 text-white" style="font-weight:800;">Catat Transaksi</h1>
                </div>
            </div>
        </div>

        @if($errors->any())
        <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-4 py-3.5 text-sm font-medium animate-fade-up">
            <i data-lucide="circle-alert" style="width:18px;height:18px;flex-shrink:0;margin-top:1px;"></i>
            <ul class="space-y-1">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
        @endif

        <form method="POST" action="{{ route('transaksi.store') }}">
            @csrf
            <div class="card p-6 space-y-5 animate-fade-up" style="animation-delay:.1s;opacity:0;animation-fill-mode:both;">
                <span class="section-label">Tipe Transaksi</span>
                <input type="hidden" name="tipe" id="tipeInput" value="{{ old('tipe', 'masuk') }}">
                <div class="flex gap-3">
                    <div class="tipe-btn {{ old('tipe','masuk')==='masuk'?'active-masuk':'' }}" onclick="setTipe('masuk',this)">
                        <i data-lucide="arrow-down" style="width:16px;height:16px;display:inline;vertical-align:middle;"></i> Barang Masuk
                    </div>
                    <div class="tipe-btn {{ old('tipe')==='keluar'?'active-keluar':'' }}" onclick="setTipe('keluar',this)">
                        <i data-lucide="arrow-up" style="width:16px;height:16px;display:inline;vertical-align:middle;"></i> Barang Keluar
                    </div>
                </div>

                <span class="section-label" style="margin-top:1rem;">Detail</span>

                <div>
                    <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Barang <span class="text-red-400">*</span></label>
                    <select name="barang_id" class="input-field" required>
                        <option value="">— Pilih Barang —</option>
                        @foreach($barangs as $b)
                        <option value="{{ $b->id }}" {{ old('barang_id')==$b->id?'selected':'' }}>{{ $b->kode_barang }} — {{ $b->nama_barang }} (Stok: {{ $b->stok }})</option>
                        @endforeach
                    </select>
                    @error('barang_id')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Jumlah <span class="text-red-400">*</span></label>
                        <input type="number" name="jumlah" class="input-field" min="1" value="{{ old('jumlah') }}" required>
                        @error('jumlah')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Tanggal <span class="text-red-400">*</span></label>
                        <input type="date" name="tanggal" class="input-field" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    </div>
                </div>

                {{-- Dynamic: supplier (masuk) or tujuan (keluar) --}}
                <div id="field-supplier" style="{{ old('tipe')==='keluar'?'display:none':'' }}">
                    <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Supplier</label>
                    <input type="text" name="supplier" class="input-field" placeholder="Nama supplier (opsional)" value="{{ old('supplier') }}">
                </div>
                <div id="field-tujuan" style="{{ old('tipe','masuk')==='masuk'?'display:none':'' }}">
                    <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Tujuan</label>
                    <input type="text" name="tujuan" class="input-field" placeholder="Tujuan pengiriman (opsional)" value="{{ old('tujuan') }}">
                </div>

                <div>
                    <label class="block text-sm font-600 text-slate-700 mb-1.5" style="font-weight:600;">Keterangan</label>
                    <textarea name="keterangan" rows="2" class="input-field" placeholder="Catatan tambahan (opsional)" style="resize:vertical;">{{ old('keterangan') }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-3 animate-fade-up" style="animation-delay:.2s;opacity:0;animation-fill-mode:both;margin-top:1.25rem;">
                <a href="{{ route('transaksi.index') }}" class="btn-secondary flex-1 text-center" style="text-decoration:none;">
                    <i data-lucide="arrow-left" style="width:15px;height:15px;"></i> Batal
                </a>
                <button type="submit" class="btn-primary flex-1">
                    <i data-lucide="save" style="width:16px;height:16px;"></i> Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function setTipe(tipe, el) {
        document.getElementById('tipeInput').value = tipe;
        document.querySelectorAll('.tipe-btn').forEach(b => { b.classList.remove('active-masuk','active-keluar'); });
        el.classList.add(tipe==='masuk'?'active-masuk':'active-keluar');
        document.getElementById('field-supplier').style.display = tipe==='masuk'?'':'none';
        document.getElementById('field-tujuan').style.display = tipe==='keluar'?'':'none';
    }
</script>
@endpush
