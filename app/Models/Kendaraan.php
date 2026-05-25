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
        'created_by'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
