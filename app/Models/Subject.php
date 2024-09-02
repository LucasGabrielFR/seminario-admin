<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UuidTrait;

class Subject extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'name',
        'code',
        'credits',
        'course_id'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
