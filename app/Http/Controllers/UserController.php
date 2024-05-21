<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\UserPermission;
use App\Repositories\PermissionRepository;
use App\Repositories\UserPermissionRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
        $permissionRepo = new PermissionRepository(new Permission());
        $permissions = $permissionRepo->getAllPermissions();

        return view('admin.users.create', [
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->all();

        $user['status'] = 1;
        $user['password'] = Hash::make($user['password']);

        $permissions = $user['permissions'];
        unset($user['permissions']);

        $userCreated = $this->repository->createUser($user);
        $userPermission = new UserPermissionRepository(new UserPermission());

        foreach ($permissions as $permission) {
            $userPermission->create($userCreated->id, $permission);
        }

        return redirect()->route('users');
    }

    public function edit($id)
    {
        $user = $this->repository->getUserById($id);
        $permissionRepo = new PermissionRepository(new Permission());
        $permissions = $permissionRepo->getAllPermissions();

        if (!$user)
            return redirect()->back();

        return view('admin.users.edit', [
            'user' => $user,
            'permissions' => $permissions
        ]);
    }

    public function update(Request $request, $id)
    {

        $user = $this->repository->getUserById($id);

        $user = $request->all();

        $user['password'] = Hash::make($user['password']);

        $permissions = $user['permissions'];
        unset($user['permissions']);

        $userPermission = new UserPermissionRepository(new UserPermission());
        $userPermission->deleteByUser($id);

        foreach ($permissions as $permission) {
            $userPermission->create($id, $permission);
        }

        if (!$user)
            return redirect()->back();

        $this->repository->updateUser($request, $id);
        return redirect()->route('users');
    }

    public function delete($id)
    {
        $user = $this->repository->getUserById($id);
        if (!$user)
            return redirect()->back();

        $userPermission = new UserPermissionRepository(new UserPermission());
        $userPermission->deleteByUser($id);

        $this->repository->deleteUser($user);

        return redirect()->route('users');
    }

}
