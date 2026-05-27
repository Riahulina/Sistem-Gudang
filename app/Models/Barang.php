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
<<<<<<< HEAD
        'kategori_id',
        'stok',
        'satuan',
        'minimum_stok',
        'keterangan',
        'created_by',
=======
        'kategori',
        'stok',
        'satuan',
        'minimum_stok',
        'created_by'
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
    ];

    /*
    |--------------------------------------------------------------------------
<<<<<<< HEAD
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // barang milik kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

=======
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
    // barang dibuat oleh user
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

<<<<<<< HEAD
    // riwayat barang masuk
=======
    // relasi barang masuk
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class);
    }

<<<<<<< HEAD
    // riwayat barang keluar
=======
    // relasi barang keluar
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class);
    }
<<<<<<< HEAD

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
=======
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
}
