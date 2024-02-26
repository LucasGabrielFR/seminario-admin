<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'book_id',
        'category_id'
    ];

    public function book() {
        return $this->belongsTo(Book::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

}
