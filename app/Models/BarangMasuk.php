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
        'created_by'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // relasi ke barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
