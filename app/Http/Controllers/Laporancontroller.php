<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        // Ambil semua barang + data masuk keluar bulan ini
        $barangs = Barang::with('kategori')->orderBy('nama_barang')->get();

        // Data masuk per barang bulan ini
        $dataMasuk = BarangMasuk::select('barang_id', DB::raw('SUM(jumlah) as total'))
            ->whereMonth('tanggal_masuk', $bulan)
            ->whereYear('tanggal_masuk', $tahun)
            ->groupBy('barang_id')
            ->pluck('total', 'barang_id');

        // Data keluar per barang bulan ini
        $dataKeluar = BarangKeluar::select('barang_id', DB::raw('SUM(jumlah) as total'))
            ->whereMonth('tanggal_keluar', $bulan)
            ->whereYear('tanggal_keluar', $tahun)
            ->groupBy('barang_id')
            ->pluck('total', 'barang_id');

        // Format data untuk Chart.js
        $labels      = $barangs->pluck('nama_barang');
        $seriesMasuk = $barangs->map(fn($b) => $dataMasuk[$b->id] ?? 0);
        $seriesKeluar= $barangs->map(fn($b) => $dataKeluar[$b->id] ?? 0);

        // Data tren masuk/keluar per hari dalam bulan ini (untuk line chart)
        $trenMasuk = BarangMasuk::select(
                DB::raw('DAY(tanggal_masuk) as hari'),
                DB::raw('SUM(jumlah) as total')
            )
            ->whereMonth('tanggal_masuk', $bulan)
            ->whereYear('tanggal_masuk', $tahun)
            ->groupBy('hari')
            ->orderBy('hari')
            ->pluck('total', 'hari');

        $trenKeluar = BarangKeluar::select(
                DB::raw('DAY(tanggal_keluar) as hari'),
                DB::raw('SUM(jumlah) as total')
            )
            ->whereMonth('tanggal_keluar', $bulan)
            ->whereYear('tanggal_keluar', $tahun)
            ->groupBy('hari')
            ->orderBy('hari')
            ->pluck('total', 'hari');

        // Isi semua hari dalam bulan
        $hariDalamBulan = now()->setMonth($bulan)->setYear($tahun)->daysInMonth;
        $hariLabels     = range(1, $hariDalamBulan);
        $trenMasukArr   = array_map(fn($h) => $trenMasuk[$h] ?? 0, $hariLabels);
        $trenKeluarArr  = array_map(fn($h) => $trenKeluar[$h] ?? 0, $hariLabels);

        // Ringkasan total
        $totalMasukBulanIni  = $dataMasuk->sum();
        $totalKeluarBulanIni = $dataKeluar->sum();

        // Daftar tahun tersedia untuk filter
        $tahunTersedia = range(now()->year, now()->year - 3);

        return view('laporan.index', compact(
            'barangs',
            'bulan', 'tahun',
            'labels', 'seriesMasuk', 'seriesKeluar',
            'hariLabels', 'trenMasukArr', 'trenKeluarArr',
            'totalMasukBulanIni', 'totalKeluarBulanIni',
            'tahunTersedia',
        ));
    }

    // Export ke PDF
    public function exportPdf(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $barangs = Barang::with('kategori')->orderBy('nama_barang')->get();

        $dataMasuk = BarangMasuk::select('barang_id', DB::raw('SUM(jumlah) as total'))
            ->whereMonth('tanggal_masuk', $bulan)
            ->whereYear('tanggal_masuk', $tahun)
            ->groupBy('barang_id')
            ->pluck('total', 'barang_id');

        $dataKeluar = BarangKeluar::select('barang_id', DB::raw('SUM(jumlah) as total'))
            ->whereMonth('tanggal_keluar', $bulan)
            ->whereYear('tanggal_keluar', $tahun)
            ->groupBy('barang_id')
            ->pluck('total', 'barang_id');

        $namaBulan = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember',
        ];

        $pdf = Pdf::loadView('laporan.pdf', compact(
            'barangs', 'dataMasuk', 'dataKeluar', 'bulan', 'tahun', 'namaBulan'
        ))->setPaper('a4', 'landscape');

        return $pdf->download("laporan-{$namaBulan[$bulan]}-{$tahun}.pdf");
    }

    // Export ke Excel
    public function exportExcel(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $namaBulan = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember',
        ];

        return Excel::download(
            new LaporanExport($bulan, $tahun),
            "laporan-{$namaBulan[$bulan]}-{$tahun}.xlsx"
        );
    }
}