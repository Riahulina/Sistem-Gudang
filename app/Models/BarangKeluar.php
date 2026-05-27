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
<<<<<<< HEAD
        'created_by',
    ];

    protected $casts = [
        'tanggal_keluar' => 'date',
=======
        'created_by'
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
    ];

    /*
    |--------------------------------------------------------------------------
<<<<<<< HEAD
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
=======
    | RELATIONSHIP
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
    |--------------------------------------------------------------------------
    */

    // relasi ke barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

<<<<<<< HEAD
    // relasi ke user yang input
=======
    // relasi ke user
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
