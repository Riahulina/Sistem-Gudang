<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class StockReportController extends Controller
{
    public function index()
    {
        $barangs = Barang::withCount(['barangMasuks', 'barangKeluars'])
            ->orderBy('nama_barang')
            ->paginate(30);

        return view('stock.report', compact('barangs'));
    }

    public function export()
    {
        // TODO: implementasi export CSV/PDF
        return back()->with('info', 'Fitur export sedang dalam pengembangan.');
    }
}
