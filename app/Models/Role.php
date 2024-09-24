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
        return $this->belongsToMany(User::class, 'role_classrooms', 'role_id', 'user_id')
            ->using(UserPermission::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'role_classrooms', 'role_id', 'subject_id')
            ->using(UserPermission::class);
    }
}
