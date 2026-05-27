<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'jumlah',
        'tanggal_masuk',
        'supplier',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | BOOT — otomatis update stok barang saat transaksi
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        // Saat barang masuk dibuat → tambah stok
        static::created(function (BarangMasuk $masuk) {
            $masuk->barang()->increment('stok', $masuk->jumlah);
        });

        // Saat barang masuk dihapus → kurangi stok kembali
        static::deleted(function (BarangMasuk $masuk) {
            $masuk->barang()->decrement('stok', $masuk->jumlah);
        });

        // Saat jumlah diubah → sesuaikan stok (selisih)
        static::updated(function (BarangMasuk $masuk) {
            $selisih = $masuk->jumlah - $masuk->getOriginal('jumlah');
            if ($selisih > 0) {
                $masuk->barang()->increment('stok', $selisih);
            } elseif ($selisih < 0) {
                $masuk->barang()->decrement('stok', abs($selisih));
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
