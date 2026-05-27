<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'jumlah',
        'tanggal_keluar',
        'tujuan',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_keluar' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | BOOT — otomatis update stok barang saat transaksi
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        // Saat barang keluar dibuat → kurangi stok
        static::created(function (BarangKeluar $keluar) {
            $keluar->barang()->decrement('stok', $keluar->jumlah);
        });

        // Saat barang keluar dihapus → kembalikan stok
        static::deleted(function (BarangKeluar $keluar) {
            $keluar->barang()->increment('stok', $keluar->jumlah);
        });

        // Saat jumlah diubah → sesuaikan stok (selisih)
        static::updated(function (BarangKeluar $keluar) {
            $selisih = $keluar->jumlah - $keluar->getOriginal('jumlah');
            if ($selisih > 0) {
                $keluar->barang()->decrement('stok', $selisih);
            } elseif ($selisih < 0) {
                $keluar->barang()->increment('stok', abs($selisih));
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // relasi ke barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    // relasi ke user yang input
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
