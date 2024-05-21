<?php

namespace App\Http\Controllers;

use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $repository;

    public function __construct(PermissionRepository $permissionRepository)
    {

        $this->repository = $permissionRepository;
    }

    function index()
    {
        $permissions = $this->repository->getAllPermissions();

        return view('admin.permissions.index', [
            'permissions' => $permissions
        ]);
    }

    function create()
    {
        return view('admin.permissions.create');
    }

    function store(Request $request)
    {
        $this->repository->createPermission($request);
        return redirect()->route('permissions');
    }

    function edit($id)
    {
        $permission = $this->repository->getPermission($id);

        if(!$permission)
            return redirect()->back();

        return view('admin.permissions.edit', [
            'permission' => $permission
        ]);
    }

    function update(Request $request, $id)
    {
        $permission = $this->repository->getPermission($id);
        if(!$permission)
            return redirect()->back();

        $this->repository->updatePermission($request, $id);
        return redirect()->route('permissions');
    }

    function delete($id)
    {
    }
}
