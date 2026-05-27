<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kendaraan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kendaraan',
        'plat_nomor',
        'jenis',
        'kondisi',
        'keterangan',
<<<<<<< HEAD
        'created_by',
=======
        'created_by'
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
    ];

    /*
    |--------------------------------------------------------------------------
<<<<<<< HEAD
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // kendaraan dibuat oleh user
=======
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // relasi ke user
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
<<<<<<< HEAD

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    // filter kendaraan berdasarkan kondisi
    public function scopeKondisi($query, string $kondisi)
    {
        return $query->where('kondisi', $kondisi);
    }

    // ambil kendaraan yang sedang servis atau rusak
    public function scopeBermasalah($query)
    {
        return $query->whereIn('kondisi', ['servis', 'rusak']);
    }
=======
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
}
