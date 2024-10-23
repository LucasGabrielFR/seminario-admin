<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scale extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'name',
        'week',
        'current_week',
        'status',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'scale_responsibles', 'scale_id', 'user_id')
            ->using(ScaleResponsible::class);
    }

    public function functions()
    {
        return $this->belongsToMany(ScaleFunction::class, 'scale_responsibles', 'scale_id', 'function_id')
            ->using(ScaleResponsible::class);
    }

}
