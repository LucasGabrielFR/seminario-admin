<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_classroom', 'role_id', 'user_id')
            ->using(UserPermission::class);
    }
}
