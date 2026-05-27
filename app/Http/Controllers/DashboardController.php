<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Kendaraan;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik ringkasan
        $totalBarang         = Barang::count();
        $barangMasukHariIni  = BarangMasuk::whereDate('created_at', today())->sum('jumlah');
        $barangKeluarHariIni = BarangKeluar::whereDate('created_at', today())->sum('jumlah');
        $kendaraanAktif      = Kendaraan::where('kondisi', 'baik')->count();

        return view('dashboard.index', compact(
            'totalBarang',
            'barangMasukHariIni',
            'barangKeluarHariIni',
            'kendaraanAktif',
        ));
    }
}
