<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('kategori')
            ->latest()
            ->paginate(15);

        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('barang.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang'   => ['required', 'string', 'max:50', 'unique:barangs,kode_barang'],
            'nama_barang'   => ['required', 'string', 'max:255'],
            'kategori_id'   => ['nullable', 'exists:kategoris,id'],
            'stok'          => ['required', 'integer', 'min:0'],
            'satuan'        => ['required', 'string', 'max:50'],
            'minimum_stok'  => ['required', 'integer', 'min:0'],
            'keterangan'    => ['nullable', 'string'],
        ], [
            'kode_barang.unique' => 'Kode barang sudah digunakan.',
        ]);

        Barang::create([
            ...$request->only(
                'kode_barang', 'nama_barang', 'kategori_id',
                'stok', 'satuan', 'minimum_stok', 'keterangan'
            ),
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        $barang->load('kategori', 'user');

        // Riwayat transaksi barang ini
        $riwayatMasuk  = $barang->barangMasuks()->with('user')->latest()->limit(10)->get();
        $riwayatKeluar = $barang->barangKeluars()->with('user')->latest()->limit(10)->get();

        return view('barang.show', compact('barang', 'riwayatMasuk', 'riwayatKeluar'));
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'kode_barang'   => ['required', 'string', 'max:50', 'unique:barangs,kode_barang,' . $barang->id],
            'nama_barang'   => ['required', 'string', 'max:255'],
            'kategori_id'   => ['nullable', 'exists:kategoris,id'],
            'stok'          => ['required', 'integer', 'min:0'],
            'satuan'        => ['required', 'string', 'max:50'],
            'minimum_stok'  => ['required', 'integer', 'min:0'],
            'keterangan'    => ['nullable', 'string'],
        ]);

        $barang->update($request->only(
            'kode_barang', 'nama_barang', 'kategori_id',
            'stok', 'satuan', 'minimum_stok', 'keterangan'
        ));

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        // Cek apakah ada riwayat transaksi
        if ($barang->barangMasuks()->exists() || $barang->barangKeluars()->exists()) {
            return back()->with('error', 'Barang tidak bisa dihapus karena sudah memiliki riwayat transaksi.');
        }

        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}