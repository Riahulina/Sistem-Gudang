<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::with('user')->latest()->paginate(15);
        return view('kendaraan.index', compact('kendaraans'));
    }

    public function create()
    {
        return view('kendaraan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kendaraan' => ['required', 'string', 'max:100'],
            'plat_nomor'     => ['required', 'string', 'max:20', 'unique:kendaraans,plat_nomor'],
            'jenis'          => ['nullable', 'string', 'max:50'],
            'kondisi'        => ['required', 'in:baik,servis,rusak'],
            'keterangan'     => ['nullable', 'string'],
        ], [
            'plat_nomor.unique' => 'Plat nomor sudah terdaftar.',
        ]);

        Kendaraan::create([
            ...$request->only('nama_kendaraan', 'plat_nomor', 'jenis', 'kondisi', 'keterangan'),
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('kendaraan.index')
            ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function show(Kendaraan $kendaraan)
    {
        $kendaraan->load('user');
        return view('kendaraan.show', compact('kendaraan'));
    }

    public function edit(Kendaraan $kendaraan)
    {
        return view('kendaraan.edit', compact('kendaraan'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $request->validate([
            'nama_kendaraan' => ['required', 'string', 'max:100'],
            'plat_nomor'     => ['required', 'string', 'max:20', 'unique:kendaraans,plat_nomor,' . $kendaraan->id],
            'jenis'          => ['nullable', 'string', 'max:50'],
            'kondisi'        => ['required', 'in:baik,servis,rusak'],
            'keterangan'     => ['nullable', 'string'],
        ]);

        $kendaraan->update(
            $request->only('nama_kendaraan', 'plat_nomor', 'jenis', 'kondisi', 'keterangan')
        );

        return redirect()->route('kendaraan.index')
            ->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return redirect()->route('kendaraan.index')
            ->with('success', 'Kendaraan berhasil dihapus.');
    }
}