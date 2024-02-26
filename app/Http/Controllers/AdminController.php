<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $countBooks = Book::get()->count();
        $countSeminaristas = User::get()->count();
        $countLoans = Loan::get()->count();

        return view('admin.dashboard',[
            'countBooks' => $countBooks,
            'countSeminaristas' => $countSeminaristas,
            'countLoans' => $countLoans
        ]);
    }
}
