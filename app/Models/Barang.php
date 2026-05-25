<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'stok',
        'satuan',
        'minimum_stok',
        'created_by'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // barang dibuat oleh user
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // relasi barang masuk
    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    // relasi barang keluar
    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class);
    }
}
