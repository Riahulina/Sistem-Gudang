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
        'kategori_id',
        'stok',
        'satuan',
        'minimum_stok',
        'keterangan',
        'created_by',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // barang milik kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // barang dibuat oleh user
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // riwayat barang masuk
    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    // riwayat barang keluar
    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS / HELPERS
    |--------------------------------------------------------------------------
    */

    // cek apakah stok hampir habis (stok <= minimum_stok)
    public function getStokHampisHabisAttribute(): bool
    {
        return $this->stok <= $this->minimum_stok;
    }

    // total barang masuk
    public function getTotalMasukAttribute(): int
    {
        return $this->barangMasuks()->sum('jumlah');
    }

    // total barang keluar
    public function getTotalKeluarAttribute(): int
    {
        return $this->barangKeluars()->sum('jumlah');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    // ambil barang yang stoknya hampir habis
    public function scopeStokMenipis($query)
    {
        return $query->whereColumn('stok', '<=', 'minimum_stok');
    }

    // filter berdasarkan kategori
    public function scopeByKategori($query, $kategoriId)
    {
        return $query->where('kategori_id', $kategoriId);
    }
}
