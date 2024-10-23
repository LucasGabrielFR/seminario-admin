<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScaleFunction extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = ['name'];

    public function scales()
    {
        return $this->belongsToMany(Scale::class, 'scale_responsibles', 'function_id', 'scale_id')
            ->using(ScaleResponsible::class);
    }
}
