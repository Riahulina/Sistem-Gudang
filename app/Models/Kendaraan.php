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
        'created_by',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // kendaraan dibuat oleh user
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

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
}
