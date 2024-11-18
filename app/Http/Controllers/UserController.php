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
        $loggedUser = Auth::user();
        $users = $this->repository->getAllUsers();
        return view('admin.users.index', [
            'users' => $users,
            'loggedUser' => $loggedUser
        ]);
    }

    public function create()
    {
        $loggedUser = Auth::user();
        $permissionRepo = new PermissionRepository(new Permission());
        $permissions = $permissionRepo->getAllPermissions();

        return view('admin.users.create', [
            'permissions' => $permissions,
            'loggedUser' => $loggedUser
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->all();
        $loggedUser = Auth::user();

        $user['status'] = 1;
        if ($loggedUser->permissions->contains('id', 1)) {
            $user['password'] = Hash::make($user['password']);
        } else {
            $user['password'] = Hash::make('123456');
        }

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
        $loggedUser = Auth::user();
        $user = $this->repository->getUserById($id);
        $permissionRepo = new PermissionRepository(new Permission());
        $permissions = $permissionRepo->getAllPermissions();

        if (!$user)
            return redirect()->back();

        return view('admin.users.edit', [
            'user' => $user,
            'permissions' => $permissions,
            'loggedUser' => $loggedUser
        ]);
    }

    public function update(Request $request, $id)
    {
        $loggedUser = Auth::user();
        $user = $this->repository->getUserById($id);

        $user = $request->all();

        if (isset($user['password'])) {
            $user['password'] = Hash::make($user['password']);
        } else {
            unset($user['password']);
            unset($request['password']);
        }

        $userPermission = new UserPermissionRepository(new UserPermission());

        if (isset($user['permissions'])) {
            $permissions = $user['permissions'];
            unset($user['permissions']);


            $userPermission->deleteByUser($id);

            foreach ($permissions as $permission) {
                $userPermission->create($id, $permission);
            }
        } else if ($loggedUser->permissions->contains('id', 1)) {
            $userPermission->deleteByUser($id);
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
