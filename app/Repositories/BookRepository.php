<?php

namespace App\Repositories;

use App\Models\Book;
use Illuminate\Http\Request;

class BookRepository
{
    protected $entity;

    function __construct(Book $model)
    {
        $this->entity = $model;
    }

    public function getAllBooks()
    {
        return $this->entity->orderBy('name')->get();
    }

    public function getBookById($id)
    {
        return $this->entity->find($id)->first();
    }

    public function deleteBook($book)
    {
        $book->delete();
    }

    public function createBook($book)
    {
        return $this->entity->create($book);
    }

    public function updateBook(Request $request, $id)
    {

        $book = $this->entity->find($id);
        $book->update($request->all());
    }
}
