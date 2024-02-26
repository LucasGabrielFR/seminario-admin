<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $categoryRepository)
    {
        $this->repository = $categoryRepository;
    }

    public function index()
    {
        $users = $this->repository->getAllUsers();
        return view('admin.users.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $user = $request->all();

        $user['status'] = 1;
        $user['password'] = Hash::make('123456');

        $userCreated = $this->repository->createUser($user);

        return redirect()->route('users');
    }

    public function edit($id)
    {
        $user = $this->repository->getUserById($id);

        if(!$user)
            return redirect()->back();

        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {

        $user = $this->repository->getUserById($id);
        if(!$user)
            return redirect()->back();

        $this->repository->updateUser($request, $id);
        return redirect()->route('users');
    }

    public function delete($id)
    {
        $user = $this->repository->getUserById($id);
        if(!$user)
            return redirect()->back();

        $this->repository->deleteUser($user);

        return redirect()->route('users');
    }
}
