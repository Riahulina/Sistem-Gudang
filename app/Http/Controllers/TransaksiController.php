<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        // Gabungkan masuk & keluar, urutkan terbaru
        $masuk = BarangMasuk::with('barang', 'user')
            ->latest()
            ->paginate(10, ['*'], 'masuk');

        $keluar = BarangKeluar::with('barang', 'user')
            ->latest()
            ->paginate(10, ['*'], 'keluar');

        return view('transaksi.index', compact('masuk', 'keluar'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        return view('transaksi.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe'       => ['required', 'in:masuk,keluar'],
            'barang_id'  => ['required', 'exists:barangs,id'],
            'jumlah'     => ['required', 'integer', 'min:1'],
            'tanggal'    => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($request->tipe === 'masuk') {

            BarangMasuk::create([
                'barang_id'    => $barang->id,
                'jumlah'       => $request->jumlah,
                'tanggal_masuk'=> $request->tanggal,
                'supplier'     => $request->supplier,
                'keterangan'   => $request->keterangan,
                'created_by'   => auth()->id(),
            ]);
            // Stok otomatis bertambah via model booted()

        } else {

            // Cek stok mencukupi
            if ($barang->stok < $request->jumlah) {
                return back()
                    ->withInput()
                    ->withErrors(['jumlah' => "Stok tidak mencukupi. Stok saat ini: {$barang->stok} {$barang->satuan}"]);
            }

            BarangKeluar::create([
                'barang_id'      => $barang->id,
                'jumlah'         => $request->jumlah,
                'tanggal_keluar' => $request->tanggal,
                'tujuan'         => $request->tujuan,
                'keterangan'     => $request->keterangan,
                'created_by'     => auth()->id(),
            ]);
            // Stok otomatis berkurang via model booted()
        }

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi barang ' . $request->tipe . ' berhasil dicatat.');
    }

    public function show($id)
    {
        // Cari di masuk dulu, lalu keluar
        $transaksi = BarangMasuk::with('barang', 'user')->find($id)
            ?? BarangKeluar::with('barang', 'user')->findOrFail($id);

        $tipe = $transaksi instanceof BarangMasuk ? 'masuk' : 'keluar';

        return view('transaksi.show', compact('transaksi', 'tipe'));
    }

    public function editMasuk(BarangMasuk $masuk)
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        return view('transaksi.edit', [
            'transaksi' => $masuk,
            'tipe'      => 'masuk',
            'barangs'   => $barangs,
        ]);
    }

    public function updateMasuk(Request $request, BarangMasuk $masuk)
    {
        $request->validate([
            'jumlah'        => ['required', 'integer', 'min:1'],
            'tanggal_masuk' => ['required', 'date'],
            'supplier'      => ['nullable', 'string', 'max:100'],
            'keterangan'    => ['nullable', 'string', 'max:255'],
        ]);

        // Model booted() otomatis sesuaikan stok saat update
        $masuk->update($request->only('jumlah', 'tanggal_masuk', 'supplier', 'keterangan'));

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi masuk berhasil diperbarui.');
    }

    public function destroyMasuk(BarangMasuk $masuk)
    {
        // Model booted() otomatis kurangi stok kembali saat delete
        $masuk->delete();

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi masuk berhasil dihapus.');
    }

    public function editKeluar(BarangKeluar $keluar)
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        return view('transaksi.edit', [
            'transaksi' => $keluar,
            'tipe'      => 'keluar',
            'barangs'   => $barangs,
        ]);
    }

    public function updateKeluar(Request $request, BarangKeluar $keluar)
    {
        $request->validate([
            'jumlah'         => ['required', 'integer', 'min:1'],
            'tanggal_keluar' => ['required', 'date'],
            'tujuan'         => ['nullable', 'string', 'max:100'],
            'keterangan'     => ['nullable', 'string', 'max:255'],
        ]);

        // Cek stok mencukupi untuk selisih tambahan
        $selisih = $request->jumlah - $keluar->jumlah;
        if ($selisih > 0 && $keluar->barang->stok < $selisih) {
            return back()->withInput()->withErrors([
                'jumlah' => "Stok tidak mencukupi. Stok saat ini: {$keluar->barang->stok} {$keluar->barang->satuan}"
            ]);
        }

        // Model booted() otomatis sesuaikan stok saat update
        $keluar->update($request->only('jumlah', 'tanggal_keluar', 'tujuan', 'keterangan'));

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi keluar berhasil diperbarui.');
    }

    public function destroyKeluar(BarangKeluar $keluar)
    {
        // Model booted() otomatis kembalikan stok saat delete
        $keluar->delete();

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi keluar berhasil dihapus.');
    }
}