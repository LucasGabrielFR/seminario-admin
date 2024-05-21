<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryRepository
{
    protected $entity;

    function __construct(Category $model)
    {
        $this->entity = $model;
    }

    public function getAllCategories()
    {
        return $this->entity->orderBy('name')->get();
    }

    public function createCategory(Request $request)
    {
        $this->entity->create($request->all());
    }

    public function updateCategory(Request $request, $id)
    {
        $category = $this->entity->find($id);
        $category->update($request->all());
    }

    public function deleteCategory($category)
    {
        $category->delete();
    }

    public function getCategory($id)
    {
        return $this->entity->find($id);
    }
}
