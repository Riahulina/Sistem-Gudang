<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
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