<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScaleResponsible extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'user_id',
        'scale_id',
        'function_id',
        'week',
        'day',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scale()
    {
        return $this->belongsTo(Scale::class);
    }

    public function function()
    {
        return $this->belongsTo(ScaleFunction::class);
    }
}
