<?php

namespace App\Http\Controllers;

use App\Repositories\BookRepository;
use App\Repositories\BookCategoryRepository;
use App\Models\BookCategory;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $repository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->repository = $bookRepository;
    }

    public function index()
    {
        $books = $this->repository->getAllBooks();
        return view('admin.books.index', [
            'books' => $books
        ]);
    }

    public function create()
    {
        $categoryRepo = new CategoryRepository(new Category());
        $categories = $categoryRepo->getAllCategories();

        return view('admin.books.create', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $book = $request->all();

        $book['status'] = 1;
        $categories = $book['categories'];
        unset($book['categories']);


        $bookCreated = $this->repository->createBook($book);
        $bookCategoryRepo = new BookCategoryRepository(new BookCategory());

        foreach ($categories as $category) {
            $bookCategoryRepo->create($bookCreated->id, $category);
        }

        return redirect()->route('library');
    }

    public function edit($id)
    {
        $book = $this->repository->getBookById($id);

        $categoryRepo = new CategoryRepository(new Category());
        $categories = $categoryRepo->getAllCategories();

        if(!$book)
            return redirect()->back();

        return view('admin.books.edit', [
            'book' => $book,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, $id)
    {

        $book = $this->repository->getBookById($id);
        if(!$book)
            return redirect()->back();

        $this->repository->updateBook($request, $id);
        return redirect()->route('library');
    }

    public function delete($id)
    {
        $book = $this->repository->getBookById($id);
        if(!$book)
            return redirect()->back();

        $this->repository->deleteBook($book);

        return redirect()->route('library');
    }

    public function loan($id){
        $book = $this->repository->getBookById($id);
        if(!$book)
            return redirect()->back();
        return view('admin.books.loan', [
            'book' => $book
        ]);
    }
}
