<?php

namespace App\Repositories;

use App\Models\BookCategory;

class BookCategoryRepository
{
    protected $entity;

    function __construct(BookCategory $model)
    {
        $this->entity = $model;
    }

    public function create($book_id, $category_id)
    {
        $this->entity->create([
            'book_id' => $book_id,
            'category_id' => $category_id
        ]);
    }

    public function deleteByBook($book_id)
    {
        $this->entity->where('book_id', $book_id)->delete();
    }
}
