<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    protected $repository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->repository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->repository->getAllCategories();
        return view('admin.categories.index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $this->repository->createCategory($request);
        return redirect()->route('categories');
    }

    public function edit($id){
        $category = $this->repository->getCategory($id);

        if(!$category)
            return redirect()->back();

        return view('admin.categories.edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, $id){
        $category = $this->repository->getCategory($id);
        if(!$category)
            return redirect()->back();

        $this->repository->updateCategory($request, $id);
        return redirect()->route('categories');
    }

    public function delete($id)
    {
        $category = $this->repository->getCategory($id);
        if(!$category)
            return redirect()->back();

        $this->repository->deleteCategory($category);

        return redirect()->route('categories');
    }
}
