<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Repositories\BookRepository;
use App\Repositories\LoanRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    protected $repository;

    public function __construct(LoanRepository $loanRepository)
    {
        $this->repository = $loanRepository;
    }

    public function index(){

        $loans = $this->repository->getAllLoans();

        return view('admin.loans.index', [
            'loans' => $loans
        ]);
    }

    public function create(){
        $userRepo = new UserRepository(new User());
        $users = $userRepo->getAllUsers();

        $booksRepo = new BookRepository(new Book());
        $books = $booksRepo->getAllBooks();

        return view('admin.loans.create', [
            'users' => $users,
            'books' => $books
        ]);
    }

    public function store(Request $request){
        $loan = $request->all();
        $loan['status'] = 1;
        $loan['date_loan'] = date('Y-m-d H:i:s');

        $loanCreated = $this->repository->createLoan($loan);
        return redirect()->route('loans');
    }

    public function return($id){
        $loan = $this->repository->returnLoan($id);
        return redirect()->route('loans');
    }

    public function extendMin($id){
        $loan = $this->repository->extendMin($id);
        return redirect()->route('loans');
    }

    public function extendMax($id){
        $loan = $this->repository->extendMax($id);
        return redirect()->route('loans');
    }
}
