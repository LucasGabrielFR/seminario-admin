<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $repository;

    public function __construct()
    {

    }

    public function index()
    {
        if (Auth::check()) {
            return redirect()->intended('home');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('admin');
        }

        return back()->withErrors([
            'email' => trans('auth.general'),
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // public function authorizeData(Request $request)
    // {
    //     $userId = $request->user_id;
    //     $user = $this->repository->findUser($userId);
    //     $user->is_authorized = 1;
    //     $user->save();
    // }
}
