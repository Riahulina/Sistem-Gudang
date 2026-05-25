<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Mass Assignment
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'role',
        'password',
    ];

    /**
     * Hidden attribute
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute Casting
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // relasi permission
    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'user_permissions'
        );
    }

    // relasi barang
    public function barangs()
    {
        return $this->hasMany(
            Barang::class,
            'created_by'
        );
    }

    // relasi barang masuk
    public function barangMasuks()
    {
        return $this->hasMany(
            BarangMasuk::class,
            'created_by'
        );
    }

    // relasi barang keluar
    public function barangKeluars()
    {
        return $this->hasMany(
            BarangKeluar::class,
            'created_by'
        );
    }

    // relasi kendaraan
    public function kendaraans()
    {
        return $this->hasMany(
            Kendaraan::class,
            'created_by'
        );
    }
}
