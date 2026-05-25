<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'permission_name',
        'description'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // relasi ke users melalui user_permissions
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'user_permissions'
        );
    }
}
