<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'created_by',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // kategori punya banyak barang
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }

    // kategori dibuat oleh user
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    // hitung total barang dalam kategori ini
    public function getTotalBarangAttribute(): int
    {
        return $this->barangs()->count();
    }
}
