<?php

namespace App\Models;

<<<<<<< HEAD
=======
// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Database\Factories\UserFactory;
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
<<<<<<< HEAD
    use HasFactory, Notifiable;

=======
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Mass Assignment
     */
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
    protected $fillable = [
        'name',
        'username',
        'email',
        'role',
        'password',
    ];

<<<<<<< HEAD
=======
    /**
     * Hidden attribute
     */
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
    protected $hidden = [
        'password',
        'remember_token',
    ];

<<<<<<< HEAD
=======
    /**
     * Attribute Casting
     */
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
<<<<<<< HEAD
            'password'          => 'hashed',
=======
            'password' => 'hashed',
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
        ];
    }

    /*
    |--------------------------------------------------------------------------
<<<<<<< HEAD
    | ROLE HELPERS
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKtu(): bool
    {
        return $this->role === 'ktu';
    }

    /**
     * No-op — dulu dipakai sebelum sistem role disederhanakan.
     * Tetap ada agar kode lama (DashboardController, dsb.) tidak error.
     */
    public function loadPermissions(): static
    {
        return $this;
    }

    /**
     * Cek hak akses berdasarkan role.
     * Dipanggil dari middleware 'permission:xxx' dan blade @if(...).
     */
    public function hasPermission(string $permission): bool
    {
        $adminPermissions = [
            'dashboard',
            'view_barang',
            'create_barang',      // CRUD barang & kategori
            'create_user',        // kelola user
            'laporan',
            'stock_report',
        ];

        $ktuPermissions = [
            'dashboard',
            'view_barang',               // lihat daftar barang (read-only)
            'create_barang_masuk_keluar', // transaksi masuk / keluar
            'stock_report',
            'create_vehicle',
            'laporan',
            'create_user',               // KTU bisa buat / kelola user
        ];

        if ($this->isAdmin()) {
            return in_array($permission, $adminPermissions);
        }

        if ($this->isKtu()) {
            return in_array($permission, $ktuPermissions);
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'created_by');
    }

    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class, 'created_by');
    }

    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class, 'created_by');
    }

    public function kendaraans()
    {
        return $this->hasMany(Kendaraan::class, 'created_by');
    }

    public function kategoris()
    {
        return $this->hasMany(Kategori::class, 'created_by');
    }
}
=======
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
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
