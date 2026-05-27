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
<<<<<<< HEAD
        'created_by',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
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
