<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'name',
        'author',
        'image',
        'status',
        'publisher',
        'description',
        'isbn',
        'page_num',
        'qtd',
        'edition',
        'section',
        'bookshelf',
        'publish',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_categories', 'book_id', 'category_id');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'loans', 'book_id', 'user_id')
            ->using(Loan::class)
            ->withPivot(['date_loan', 'date_return', 'date_limit', 'status']);
    }
}
